<?php

include("inc/login_status.inc");
include("inc/database_connection.inc");

$username = $_SESSION['username'] ?? null;
if ($username === 'admin') {
    $_SESSION['admin_logged_in'] = true;
}

$content = '';
$title = 'Buy Product';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = intval($_POST['product_id'] ?? 0);
    $step = $_POST['step'] ?? 'select_addon';
    $addon_selected = isset($_POST['addon']) && $_POST['addon'] === 'yes';

    // Fetch product info
    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $product = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if (!$product) {
        $content = '<div class="buyproduct-container"><p class="buyproduct-error">Product not found.</p></div>';
        $title = 'Error';
    } else {
        $is_member = !empty($username);
        $is_admin = false;
        if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
            $is_admin = true;
        }
        $user = null;
        if ($is_member && !$is_admin) {
            $stmt = $conn->prepare("SELECT * FROM topup WHERE login_id = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $user = $stmt->get_result()->fetch_assoc();
            $stmt->close();
        }

        $mp = $product['mp'];
        $np = $product['np'];
        $price = $is_member ? $mp : $np;
        $addon_price = 2.00;
        if ($addon_selected) {
            $price += $addon_price;
        }

    // STEP 1: Show add-on selection and final price for confirmation
    if ($step === 'select_addon') {
?>
        <!DOCTYPE html>
        <html>

        <head>
            <title>Confirm Purchase</title>
            <link rel="stylesheet" href="styles/buy.css">

            <meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="description" content="Confirm Purchase">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <link rel="icon" href="images/Brew&Go_logo.png" type="image/png">
            <link rel="stylesheet" href="styles/style.css">
        </head>


        <body>
            <?php include("inc/top_navigation_bar.inc"); ?>
            <main>
                <div class="purchase-container">
                    <h2>Confirm Purchase</h2>
                    <p class="purchase-info">Product: <?php echo htmlspecialchars($product['name']); ?></p>
                    <?php if ($is_member): ?>
                        <p>Member Price (MP): RM<?php echo number_format($mp, 2); ?></p>
                        <?php if ($is_admin): ?>
                            <p><strong>Admin: Infinite credit</strong></p>
                        <?php elseif ($user): ?>
                            <p>Your balance: RM<?php echo number_format($user['balance'], 2); ?></p>
                        <?php endif; ?>
                    <?php else: ?>
                        <p>Normal Price (NP): RM<?php echo number_format($np, 2); ?></p>
                        <p><em>Login to enjoy member price and balance deduction.</em></p>
                    <?php endif; ?>
                    <form method="post" action="buy_product.php">
                        <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                        <input type="hidden" name="step" value="show_final">
                        <label>
                            <input type="checkbox" name="addon" value="yes" <?php if ($addon_selected) echo 'checked'; ?>>
                            Add Oat Milk (+RM2.00)
                        </label>
                        <br><br>
                        <strong>Final Price: RM<?php echo number_format($price, 2); ?></strong>
                        <br><br>
                        <button type="submit">Confirm</button>
                        <a href="product.php"><button type="button">Back to products</button></a>
                    </form>
                    <p><em>Check add-on and click Confirm to see the final price. Click Confirm again to purchase.</em></p>
                </div>
            </main>
            <?php include("inc/scroll_to_top_button.inc"); ?>

            <?php include("inc/footer.inc"); ?>
        </body>

        </html>
    <?php
        exit;
    }

    // STEP 2: Show final price and ask for second confirmation
    if ($step === 'show_final') {
    ?>
        <!DOCTYPE html>
        <html>

        <head>
            <title>Final Confirmation</title>
            <link rel="stylesheet" href="styles/buy.css">
            <meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="description" content="Final Confirmation">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <link rel="icon" href="images/Brew&Go_logo.png" type="image/png">
            <link rel="stylesheet" href="styles/style.css">
        </head>

        <body class="theme-final">
            <?php include("inc/top_navigation_bar.inc"); ?>
            <main>
                <div class="purchase-container">
                    <h2>Final Confirmation</h2>
                    <p class="purchase-info">Product: <?php echo htmlspecialchars($product['name']); ?></p>
                    <?php if ($is_member): ?>
                        <p>Member Price (MP): RM<?php echo number_format($mp, 2); ?></p>
                        <?php if ($is_admin): ?>
                            <p><strong>Admin: Infinite credit</strong></p>
                        <?php elseif ($user): ?>
                            <p>Your balance: RM<?php echo number_format($user['balance'], 2); ?></p>
                        <?php endif; ?>
                    <?php else: ?>
                        <p>Normal Price (NP): RM<?php echo number_format($np, 2); ?></p>
                    <?php endif; ?>
                    <?php if ($addon_selected): ?>
                        <p><strong>Oat Milk added (+RM2.00)</strong></p>
                    <?php endif; ?>
                    <strong>Final Price: RM<?php echo number_format($price, 2); ?></strong>
                    <form method="post" action="buy_product.php">
                        <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                        <input type="hidden" name="step" value="confirm_purchase">
                        <input type="hidden" name="addon" value="<?php echo $addon_selected ? 'yes' : ''; ?>">
                        <br><br>
                        <button type="submit">Confirm Purchase</button>
                        <a href="product.php"><button type="button">Back to products</button></a>
                    </form>
                    <p><em>Click Confirm Purchase to complete your order.</em></p>
                </div>
            </main>
            <?php include("inc/scroll_to_top_button.inc"); ?>

            <?php include("inc/footer.inc"); ?>
        </body>

        </html>
        <?php
        exit;
    }

    // STEP 3: Actually process the purchase after second confirm
    if ($step === 'confirm_purchase') {
        if ($is_member) {
            if ($is_admin) {
                // Admin: always successful, no balance check or top up needed
        ?>
                <!DOCTYPE html>
                <html>

                <head>
                    <title>Purchase Successful</title>
                    <link rel="stylesheet" href="styles/buy.css">
                    <meta charset="utf-8">
                    <meta http-equiv="X-UA-Compatible" content="IE=edge">
                    <meta name="description" content="Purchase Successful">
                    <meta name="viewport" content="width=device-width, initial-scale=1">
                    <link rel="icon" href="images/Brew&Go_logo.png" type="image/png">
                    <link rel="stylesheet" href="styles/style.css">
                </head>

                <body>
                    <main>
                        <?php include("inc/top_navigation_bar.inc"); ?>
                        <div class="purchase-container">
                            <h2>Purchase Successful</h2>
                            <p class="purchase-success">Purchase successful! (Admin: infinite credit, no deduction)</p>
                            <a href="product.php"><button type="button">Back to products</button></a>
                        </div>
                    </main>
                    <?php include("inc/scroll_to_top_button.inc"); ?>

                    <?php include("inc/footer.inc"); ?>
                </body>

                </html>
            <?php
            } else if ($user && $user['balance'] >= $price) {
                // Normal member: check balance and deduct
                $new_balance = $user['balance'] - $price;
                $stmt = $conn->prepare("UPDATE topup SET balance = ? WHERE login_id = ?");
                $stmt->bind_param("ds", $new_balance, $username);
                $stmt->execute();
                $stmt->close();
            ?>
                <!DOCTYPE html>
                <html>

                <head>
                    <title>Purchase Successful</title>
                    <link rel="stylesheet" href="styles/buy.css">
                    <meta charset="utf-8">
                    <meta http-equiv="X-UA-Compatible" content="IE=edge">
                    <meta name="description" content="Purchase Successful">
                    <meta name="viewport" content="width=device-width, initial-scale=1">
                    <link rel="icon" href="images/Brew&Go_logo.png" type="image/png">
                    <link rel="stylesheet" href="styles/style.css">
                </head>

                <body>
                    <?php include("inc/top_navigation_bar.inc"); ?>
                    <main>
                        <div class="purchase-container">
                            <h2>Purchase Successful</h2>
                            <p class="purchase-success">Purchase successful! Your new balance is RM<?php echo number_format($new_balance, 2); ?>.</p>
                            <a href="product.php"><button type="button">Back to products</button></a>
                        </div>
                    </main>
                    <?php include("inc/scroll_to_top_button.inc"); ?>

                    <?php include("inc/footer.inc"); ?>
                </body>

                </html>
            <?php
            } else if (!$user) {
                // Normal member: no top-up record
            ?>
                <!DOCTYPE html>
                <html>

                <head>
                    <title>No Top-up</title>
                    <link rel="stylesheet" href="styles/buy.css">
                    <meta charset="utf-8">
                    <meta http-equiv="X-UA-Compatible" content="IE=edge">
                    <meta name="description" content="No Top-up">
                    <meta name="viewport" content="width=device-width, initial-scale=1">
                    <link rel="icon" href="images/Brew&Go_logo.png" type="image/png">
                    <link rel="stylesheet" href="styles/style.css">
                </head>

                <body>
                    <?php include("inc/top_navigation_bar.inc"); ?><main>
                        <div class="purchase-container">
                            <p class="purchase-error">No top-up record found. Please top up first.</p>
                            <a href="product.php"><button type="button">Back to products</button></a>
                        </div>
                    </main>
                    <?php include("inc/scroll_to_top_button.inc"); ?>

                    <?php include("inc/footer.inc"); ?>
                </body>

                </html>
            <?php
            } else {
                // Normal member: insufficient balance
                ?>
                <!DOCTYPE html>
                <html>
                <head>
                    <title>Insufficient Balance</title>
                    <link rel="stylesheet" href="styles/buy.css" />
                </head>
                <body>
                    <div class="purchase-container">
                        <p class="purchase-error">Insufficient balance. Please top up.</p>
                        <a href="product.php"><button type="button">Back to products</button></a>
                    </div>
                </body>
                </html>
                <?php
            }
            exit;
        } else {
            // Not a member
            ?>
            <!DOCTYPE html>
            <html>
            <head>
                <title>Thank You</title>
                <link rel="stylesheet" href="styles/buy.css" />
            </head>
            <body>
                <div class="purchase-container">
                    <h2>Thank You</h2>
                    <p class="purchase-success">Thank you for your purchase.</p>
                    <a href="product.php"><button type="button">Back to products</button></a>
                </div>
            </body>
            </html>
            <?php
            exit;
        }
    }
} else {
    header("Location: product.php");
    exit;
}

?>
<!DOCTYPE html>
<html>
<head>
    <title><?php echo htmlspecialchars($title); ?></title>
    <link rel="stylesheet" href="styles/style.css" />
</head>
<body class="buyproduct-body">
<?php
echo $content;

// For debugging only, remove after testing!
echo '<pre>';
print_r($_SESSION);
echo '</pre>';
?>

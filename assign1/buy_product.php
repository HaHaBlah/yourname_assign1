<?php

include("inc/login_status.inc");
include("inc/database_connection.inc");

$username = $_SESSION['username'] ?? null;
// Detect admin by login flag or role
$is_admin = (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true)
    || (isset($_SESSION['role']) && $_SESSION['role'] === 'admin');
// Only non-admin logged-in users are "members"
$is_member = !empty($username) && !$is_admin;

$content = '';
$title = 'Buy Product';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id     = intval($_POST['product_id'] ?? 0);
    $step           = $_POST['step'] ?? 'select_addon';
    $addon_selected = isset($_POST['addon']) && $_POST['addon'] === 'yes';

    // Fetch product details
    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $product = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if (!$product) {
        $title = 'Product Not Found';
        $content = '<div class="buyproduct-container"><p class="buyproduct-error">Product not found.</p></div>';
    } else {
        // Fetch top-up info only for non-admin members
        $user = null;
        if ($is_member) {
            $stmt = $conn->prepare("SELECT * FROM topup WHERE login_id = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $user = $stmt->get_result()->fetch_assoc();
            $stmt->close();
        }

        // Calculate price
        $mp    = $product['mp'];
        $np    = $product['np'];
        $price = $is_member ? $mp : $np;
        $addon_price = 2.00;
        if ($addon_selected) {
            $price += $addon_price;
        }
        if ($is_admin) {
            $price = 0.00;
        }

        // === STEP 1: Add-on selection ===
        if ($step === 'select_addon') {
            $title = 'Confirm Purchase';
            ob_start(); ?>
            <div class="buyproduct-container">
                <h2 class="buyproduct-title">Confirm Purchase</h2>
                <p class="buyproduct-info">Product: <?= htmlspecialchars($product['name']) ?></p>
                <?php if ($is_admin): ?>
                    <p class="buyproduct-p"><strong class="buyproduct-strong">Admin: Free of charge</strong></p>
                <?php elseif ($is_member): ?>
                    <p class="buyproduct-p">Member Price (MP): RM<?= number_format($mp, 2) ?></p>
                    <p class="buyproduct-p">Your balance: RM<?= number_format($user['balance'] ?? 0, 2) ?></p>
                <?php else: ?>
                    <p class="buyproduct-p">Normal Price (NP): RM<?= number_format($np, 2) ?></p>
                    <p class="buyproduct-p"><em>Login to get member price and balance deduction.</em></p>
                <?php endif; ?>
                <form method="post" action="buy_product.php">
                    <input type="hidden" name="product_id" value="<?= $product_id ?>">
                    <input type="hidden" name="step" value="show_final">
                    <label class="buyproduct-label">
                        <input type="checkbox" class="buyproduct-checkbox" name="addon" value="yes" <?= $addon_selected ? 'checked' : '' ?>> Add Oat Milk (+RM2.00)
                    </label>
                    <br><br>
                    <?php if ($is_admin): ?>
                        <strong class="buyproduct-strong">Final Price: Free of charge</strong>
                    <?php else: ?>
                        <strong class="buyproduct-strong">Final Price: RM<?= number_format($price, 2) ?></strong>
                    <?php endif; ?>
                    <br><br>
                    <button type="submit" class="buyproduct-btn">Confirm</button>
                    <a href="product.php" class="buyproduct-link"><button type="button" class="buyproduct-btn-alt">Back to products</button></a>
                </form>
                <p>Check add-on and click Confirm to see the final price. Click Confirm again to purchase.</p>
            </div>
        <?php
            $content = ob_get_clean();
        }
        // === STEP 2: Final confirmation ===
        else if ($step === 'show_final') {
            $title = 'Final Confirmation';
            ob_start(); ?>
            <div class="buyproduct-container">
                <h2 class="buyproduct-title">Final Confirmation</h2>
                <p class="buyproduct-info">Product: <?= htmlspecialchars($product['name']) ?></p>
                <?php if ($is_admin): ?>
                    <p class="buyproduct-p"><strong class="buyproduct-strong">Admin: Free of charge</strong></p>
                <?php elseif ($is_member): ?>
                    <p class="buyproduct-p">Member Price (MP): RM<?= number_format($mp, 2) ?></p>
                    <p class="buyproduct-p">Your balance: RM<?= number_format($user['balance'] ?? 0, 2) ?></p>
                <?php else: ?>
                    <p class="buyproduct-p">Normal Price (NP): RM<?= number_format($np, 2) ?></p>
                <?php endif; ?>
                <?php if ($addon_selected): ?><p class="buyproduct-p"><strong class="buyproduct-strong">Oat Milk added (+RM2.00)</strong></p><?php endif; ?>
                <?php if ($is_admin): ?>
                    <strong class="buyproduct-strong">Final Price: Free of charge</strong>
                <?php else: ?>
                    <strong class="buyproduct-strong">Final Price: RM<?= number_format($price, 2) ?></strong>
                <?php endif; ?>
                <form method="post" action="buy_product.php">
                    <input type="hidden" name="product_id" value="<?= $product_id ?>">
                    <input type="hidden" name="step" value="confirm_purchase">
                    <input type="hidden" name="addon" value="<?= $addon_selected ? 'yes' : '' ?>">
                    <br><br>
                    <button type="submit" class="buyproduct-btn">Confirm Purchase</button>
                    <a href="product.php" class="buyproduct-link"><button type="button" class="buyproduct-btn-alt">Back to products</button></a>
                </form>
                <p>Click Confirm Purchase to complete your order</p>
            </div>
<?php
            $content = ob_get_clean();
        }
        // === STEP 3: Process purchase ===
        else if ($step === 'confirm_purchase') {
            if ($is_admin) {
                $title = 'Purchase Successful';
                $content = '
                <div class="buyproduct-container">
                    <h2 class="buyproduct-title">Purchase Successful</h2>
                    <p class="buyproduct-success">Purchase successful! (Admin: free of charge)</p>
                    <a href="product.php"><button type="button" class="buyproduct-btn-alt">Back to products</button></a>
                </div>';
            } else if ($is_member) {
                if ($user && $user['balance'] >= $price) {
                    $new_balance = $user['balance'] - $price;
                    $stmt = $conn->prepare("UPDATE topup SET balance = ? WHERE login_id = ?");
                    $stmt->bind_param("ds", $new_balance, $username);
                    $stmt->execute();
                    $stmt->close();
                    $title = 'Purchase Successful';
                    $content = '
                    <div class="buyproduct-container">
                        <h2 class="buyproduct-title">Purchase Successful</h2>
                        <p class="buyproduct-success">Purchase successful! New balance: RM' . number_format($new_balance, 2) . '</p>
                        <a href="product.php"><button type="button" class="buyproduct-btn-alt">Back to products</button></a>
                    </div>';
                } else if (!$user) {
                    $title = 'No Top-up';
                    $content = '
                    <div class="buyproduct-container">
                        <p class="buyproduct-error">No top-up record found. Please top up first.</p>
                        <a href="product.php"><button type="button" class="buyproduct-btn-alt">Back to products</button></a>
                    </div>';
                } else {
                    $title = 'Insufficient Balance';
                    $content = '
                    <div class="buyproduct-container">
                        <p class="buyproduct-error">Insufficient balance. Please top up.</p>
                        <a href="product.php"><button type="button" class="buyproduct-btn-alt">Back to products</button></a>
                    </div>';
                }
            } else {
                $title = 'Thank You';
                $content = '
                <div class="buyproduct-container">
                    <h2 class="buyproduct-title">Thank You</h2>
                    <p class="buyproduct-success">Thank you for your purchase.</p>
                    <a href="product.php"><button type="button" class="buyproduct-btn-alt">Back to products</button></a>
                </div>';
            }
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
    <title><?= htmlspecialchars($title) ?></title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Buy Product">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="images/Brew&Go_logo.png" type="image/png">
    <link rel="stylesheet" href="styles/style.css">
</head>

<body class="buyproduct-body">
    <?php include("inc/top_navigation_bar.inc"); ?>
    <main>
    <?= $content ?>
    </main>
    <?php include("inc/scroll_to_top_button.inc"); ?>

    <?php include("inc/footer.inc"); ?>
</body>

</html>
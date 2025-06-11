<?php

include("inc/login_status.inc");
include("inc/database_connection.inc");

$username = $_SESSION['username'] ?? null;

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
        die("Product not found.");
    }

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
            <link rel="stylesheet" href="styles/style.css" />
        </head>
        <body>
            <h2>Confirm Purchase</h2>
            <p>Product: <?php echo htmlspecialchars($product['name']); ?></p>
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
                    <input type="checkbox" name="addon" value="yes" <?php if($addon_selected) echo 'checked'; ?>>
                    Add Oat Milk (+RM2.00)
                </label>
                <br><br>
                <strong>Final Price: RM<?php echo number_format($price, 2); ?></strong>
                <br><br>
                <button type="submit">Confirm</button>
                <a href="product.php"><button type="button">Cancel</button></a>
            </form>
            <p><em>Check add-on and click Confirm to see the final price. Click Confirm again to purchase.</em></p>
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
            <link rel="stylesheet" href="styles/style.css" />
        </head>
        <body>
            <h2>Final Confirmation</h2>
            <p>Product: <?php echo htmlspecialchars($product['name']); ?></p>
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
                <a href="product.php"><button type="button">Cancel</button></a>
            </form>
            <p><em>Click Confirm Purchase to complete your order.</em></p>
        </body>
        </html>
        <?php
        exit;
    }

    // STEP 3: Actually process the purchase after second confirm
    if ($step === 'confirm_purchase') {
        if ($is_member) {
            if ($is_admin) {
                echo "<p>Purchase successful! (Admin: infinite credit, no deduction)</p>";
            } else if ($user && $user['balance'] >= $price) {
                $new_balance = $user['balance'] - $price;
                $stmt = $conn->prepare("UPDATE topup SET balance = ? WHERE login_id = ?");
                $stmt->bind_param("ds", $new_balance, $username);
                $stmt->execute();
                $stmt->close();
                echo "<p>Purchase successful! Your new balance is RM" . number_format($new_balance, 2) . ".</p>";
            } else if (!$user) {
                echo "<p>No top-up record found. Please top up first.</p>";
            } else {
                echo "<p>Insufficient balance. Please top up.</p>";
            }
            echo '<a href="product.php">Back to products</a>';
            exit;
        } else {
            echo "<p>Thank you for your purchase.</p>";
            echo '<a href="product.php">Back to products</a>';
            exit;
        }
    }
} else {
    header("Location: product.php");
    exit;
}
?>

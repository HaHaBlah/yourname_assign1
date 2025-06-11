<?php

include("inc/login_status.inc");
include("inc/database_connection.inc");

$username = $_SESSION['username'] ?? null;
// Detect admin by login flag or role
$is_admin = (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true)
         || (isset($_SESSION['role']) && $_SESSION['role'] === 'admin');
// Only non-admin logged-in users are "members"
$is_member = !empty($username) && !$is_admin;

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
        die("Product not found.");
    }

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

    // Admin override: free service
    if ($is_admin) {
        $price = 0.00;
    }

    // === STEP 1: Add-on selection ===
    if ($step === 'select_addon') {
        ?>
        <!DOCTYPE html>
        <html>
        <head><title>Confirm Purchase</title><link rel="stylesheet" href="styles/buy.css" /></head>
        <body>
        <div class="purchase-container">
          <h2>Confirm Purchase</h2>
          <p class="purchase-info">Product: <?=htmlspecialchars($product['name'])?></p>
          <?php if ($is_admin): ?>
            <p><strong>Admin: Free of charge</strong></p>
          <?php elseif ($is_member): ?>
            <p>Member Price (MP): RM<?=number_format($mp,2)?></p>
            <p>Your balance: RM<?=number_format($user['balance'] ?? 0,2)?></p>
          <?php else: ?>
            <p>Normal Price (NP): RM<?=number_format($np,2)?></p>
            <p><em>Login to get member price and balance deduction.</em></p>
          <?php endif; ?>

          <form method="post" action="buy_product.php">
            <input type="hidden" name="product_id" value="<?=$product_id?>">
            <input type="hidden" name="step" value="show_final">
            <label><input type="checkbox" name="addon" value="yes" <?= $addon_selected?'checked':'' ?>> Add Oat Milk (+RM2.00)</label>
            <br><br>
            <?php if ($is_admin): ?>
              <strong>Final Price: Free of charge</strong>
            <?php else: ?>
              <strong>Final Price: RM<?=number_format($price,2)?></strong>
            <?php endif; ?>
            <br><br>
            <button type="submit">Confirm</button>
            <a href="product.php"><button type="button">Back to products</button></a>
          </form>
        </div>
        </body>
        </html>
        <?php
        exit;
    }

    // === STEP 2: Final confirmation ===
    if ($step === 'show_final') {
        ?>
        <!DOCTYPE html>
        <html>
        <head><title>Final Confirmation</title><link rel="stylesheet" href="styles/buy.css" /></head>
        <body class="theme-final">
        <div class="purchase-container">
          <h2>Final Confirmation</h2>
          <p class="purchase-info">Product: <?=htmlspecialchars($product['name'])?></p>
          <?php if ($is_admin): ?>
            <p><strong>Admin: Free of charge</strong></p>
          <?php elseif ($is_member): ?>
            <p>Member Price (MP): RM<?=number_format($mp,2)?></p>
            <p>Your balance: RM<?=number_format($user['balance'] ?? 0,2)?></p>
          <?php else: ?>
            <p>Normal Price (NP): RM<?=number_format($np,2)?></p>
          <?php endif; ?>
          <?php if ($addon_selected): ?><p><strong>Oat Milk added (+RM2.00)</strong></p><?php endif; ?>
          <?php if ($is_admin): ?>
            <strong>Final Price: Free of charge</strong>
          <?php else: ?>
            <strong>Final Price: RM<?=number_format($price,2)?></strong>
          <?php endif; ?>
          <form method="post" action="buy_product.php">
            <input type="hidden" name="product_id" value="<?=$product_id?>">
            <input type="hidden" name="step" value="confirm_purchase">
            <input type="hidden" name="addon" value="<?=$addon_selected?'yes':''?>">
            <br><br>
            <button type="submit">Confirm Purchase</button>
            <a href="product.php"><button type="button">Back to products</button></a>
          </form>
        </div>
        </body>
        </html>
        <?php
        exit;
    }

    // === STEP 3: Process purchase ===
    if ($step === 'confirm_purchase') {
        if ($is_admin) {
            // Admin always succeeds
            ?>
            <!DOCTYPE html>
            <html>
            <head><title>Purchase Successful</title><link rel="stylesheet" href="styles/buy.css" /></head>
            <body>
            <div class="purchase-container">
              <h2>Purchase Successful</h2>
              <p class="purchase-success">Purchase successful! (Admin: free of charge)</p>
              <a href="product.php"><button type="button">Back to products</button></a>
            </div>
            </body>
            </html>
            <?php exit;
        }

        if ($is_member) {
            if ($user && $user['balance'] >= $price) {
                $new_balance = $user['balance'] - $price;
                $stmt = $conn->prepare("UPDATE topup SET balance = ? WHERE login_id = ?");
                $stmt->bind_param("ds", $new_balance, $username);
                $stmt->execute();
                $stmt->close();
                ?>
                <!DOCTYPE html>
                <html>
                <head><title>Purchase Successful</title><link rel="stylesheet" href="styles/buy.css" /></head>
                <body>
                <div class="purchase-container">
                  <h2>Purchase Successful</h2>
                  <p class="purchase-success">Purchase successful! New balance: RM<?=number_format($new_balance,2)?></p>
                  <a href="product.php"><button type="button">Back to products</button></a>
                </div>
                </body>
                </html>
                <?php
            } elseif (!$user) {
                // No record
                ?>
                <!DOCTYPE html>
                <html>
                <head><title>No Top-up</title><link rel="stylesheet" href="styles/buy.css" /></head>
                <body>
                <div class="purchase-container">
                  <p class="purchase-error">No top-up record found. Please top up first.</p>
                  <a href="product.php"><button type="button">Back to products</button></a>
                </div>
                </body>
                </html>
                <?php
            } else {
                // Insufficient
                ?>
                <!DOCTYPE html>
                <html>
                <head><title>Insufficient Balance</title><link rel="stylesheet" href="styles/buy.css" /></head>
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
        }

        // Guest
        ?>
        <!DOCTYPE html>
        <html>
        <head><title>Thank You</title><link rel="stylesheet" href="styles/buy.css" /></head>
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
} else {
    header("Location: product.php");
    exit;
}
?>
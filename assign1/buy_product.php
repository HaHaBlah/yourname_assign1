<?php
session_start();
include("inc/login_status.inc");
include("inc/database_connection.inc");

// Get logged-in username (adjust if you use a different session variable)
$username = $_SESSION['username'] ?? null;

// if (!$username) { //Disable this to check 
//     die("You must be logged in to buy a product.");
// }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = intval($_POST['product_id'] ?? 0);
    $confirm = $_POST['confirm'] ?? '';

    // Fetch product info
    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $product = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if (!$product) {
        die("Product not found.");
    }

    // Determine if user is logged in
    $is_member = !empty($username);

    // Fetch user info only if logged in
    $is_admin = false;
    if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
        $is_admin = true;
    }
    $user_email = null;
    $user = null;

    if ($is_member && !$is_admin) {
        // Only fetch topup data if NOT admin
        $stmt = $conn->prepare("SELECT * FROM topup WHERE login_id = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();
        $stmt->close();
    }

    // Check if admin is logged in
    if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
        $is_admin = true;
    }

    // Use member price if logged in, otherwise normal price
    $mp = $product['mp'];
    $np = $product['np'];
    $price = $is_member ? $mp : $np;

    // Handle add-on
    $addon_price = 2.00;
    $addon_selected = isset($_POST['addon']) && $_POST['addon'] === 'yes';
    if ($addon_selected) {
        $price += $addon_price;
    }

    if ($confirm === 'yes') {
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
            // Non-member: show thank you message only
            echo "<p>Thank you for your purchase.</p>";
            echo '<a href="product.php">Back to products</a>';
            exit;
        }
    }

    // Show confirmation form (only if not confirmed yet)
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
            <input type="hidden" name="confirm" value="yes">
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
    </body>
    </html>
    <?php
    exit;
} else {
    header("Location: product.php");
    exit;
}
?>
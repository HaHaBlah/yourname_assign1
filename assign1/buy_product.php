<?php
session_start();
include("inc/login_status.inc");
include("inc/database_connection.inc");

// Get logged-in username (adjust if you use a different session variable)
$username = $_SESSION['username'] ?? null;

if (!$username) {
    die("You must be logged in to buy a product.");
}

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

    // Fetch user info (assuming login_id = username)
    $stmt = $conn->prepare("SELECT * FROM topup WHERE login_id = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if (!$user) {
        die("User not found in topup table.");
    }

    // Use member price
    $price = $product['mp'];

    if ($confirm === 'yes') {
        // Deduct balance if enough
        if ($user['balance'] >= $price) {
            $new_balance = $user['balance'] - $price;
            $stmt = $conn->prepare("UPDATE topup SET balance = ? WHERE login_id = ?");
            $stmt->bind_param("ds", $new_balance, $username);
            $stmt->execute();
            $stmt->close();
            echo "<p>Purchase successful! Your new balance is RM" . number_format($new_balance, 2) . ".</p>";
            echo '<a href="product.php">Back to products</a>';
        } else {
            echo "<p>Insufficient balance. Please top up.</p>";
            echo '<a href="product.php">Back to products</a>';
        }
        exit;
    }
    // Show confirmation form
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
        <p>Price: RM<?php echo number_format($price, 2); ?></p>
        <p>Your balance: RM<?php echo number_format($user['balance'], 2); ?></p>
        <form method="post" action="buy_product.php">
            <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
            <input type="hidden" name="confirm" value="yes">
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
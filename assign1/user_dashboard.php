<?php
ob_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include("inc/database_connection.inc");
include("inc/login_status.inc");

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];

// Fetch user information
$stmt = $conn->prepare("SELECT id, firstname, lastname, email, username, role, phonenumber FROM members WHERE username = ? AND email_verified = 1");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 1) {
    $userInfo = $result->fetch_assoc();
    $_SESSION['user_id'] = $userInfo['id'];
} else {
    header("Location: login.php");
    exit();
}
$stmt->close();

$user_id = $_SESSION['user_id'];
$addressInfo = [];
$creditBalance = 0;
$successMsg = '';
$errorMsg = '';

// Fetch address info from new addresses table
$stmt = $conn->prepare("SELECT * FROM members WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $addressInfo = $result->fetch_assoc();
}
$stmt->close();

// Fetch credit balance
$stmt = $conn->prepare("SELECT balance FROM topup WHERE login_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $creditData = $result->fetch_assoc();
    $creditBalance = $creditData['balance'];
}
$stmt->close();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update_personal'])) {
        $firstname = htmlspecialchars(trim($_POST['firstname']));
        $lastname = htmlspecialchars(trim($_POST['lastname']));
        $email = htmlspecialchars(trim($_POST['email']));
        $phonenumber = htmlspecialchars(trim($_POST['phonenumber']));

        $stmt = $conn->prepare("UPDATE members SET firstname = ?, lastname = ?, email = ?, phonenumber = ? WHERE id = ?");
        $stmt->bind_param("ssssi", $firstname, $lastname, $email, $phonenumber, $user_id);
        if ($stmt->execute()) {
            $successMsg = "Personal information updated successfully!";
        } else {
            $errorMsg = "Error updating personal information: " . $stmt->error;
        }
        $stmt->close();
    }

    if (isset($_POST['update_address'])) {
        $streetaddress = htmlspecialchars(trim($_POST['streetaddress']));
        $citytown = htmlspecialchars(trim($_POST['citytown']));
        $state = htmlspecialchars(trim($_POST['state']));
        $postcode = htmlspecialchars(trim($_POST['postcode']));

        if (!empty($addressInfo)) {
            $stmt = $conn->prepare("UPDATE members SET streetaddress = ?, citytown = ?, state = ?, postcode = ? WHERE id = ?");
            $stmt->bind_param("ssssi", $streetaddress, $citytown, $state, $postcode, $user_id);
        } else {
            $stmt = $conn->prepare("INSERT INTO members (id, streetaddress, citytown, state, postcode) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("issss", $user_id, $streetaddress, $citytown, $state, $postcode);
        }

        if ($stmt->execute()) {
            $successMsg = empty($addressInfo) ? "Address added successfully!" : "Address updated successfully!";
        } else {
            $errorMsg = "Error saving address: " . $stmt->error;
        }
        $stmt->close();
    }
}

$conn->close();
?>

// Close database connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard - Brew & Go</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" href="images/Brew&Go_logo.png" type="image/png">
    <link rel="stylesheet" href="styles/style.css">
</head>
<body>
    <?php include("inc/top_navigation_bar.inc"); ?>
    
    <div class="container">
        <div class="dashboard-header">
            <div class="welcome-section">
                <div class="user-greeting">
                    <h1>Welcome, <?php echo htmlspecialchars($userInfo['username'] ?? 'User'); ?>!</h1>
                    <p>Manage your account details and preferences</p>
                </div>
                <div class="credit-section">
                    <div class="credit-display">
                        <span class="credit-label">Your Credit Balance:</span>
                        <span class="credit-amount">RM <?php echo number_format($creditBalance, 2); ?></span>
                    </div>
                    <a href="member_topup.php" class="topup-btn">
                        <i class="fas fa-coins"></i> Top Up Credit
                    </a>
                </div>
            </div>
        </div>

        <?php if ($successMsg): ?>
            <div class="alert alert-success">
                <?php echo $successMsg; ?>
            </div>
        <?php endif; ?>
        
        <?php if ($errorMsg): ?>
            <div class="alert alert-error">
                <?php echo $errorMsg; ?>
            </div>
        <?php endif; ?>

        <div class="dashboard-grid">
            <!-- Personal Information Card -->
            <div class="dashboard-card">
                <div class="card-header">
                    <div class="card-icon">
                        <i class="fas fa-user"></i>
                    </div>
                    <h2 class="card-title">Personal Information</h2>
                </div>
                
                <form method="POST" action="user_dashboard.php">
                    <div class="form-group">
                        <label for="firstname">First Name</label>
                        <input type="text" class="form-control" id="firstname" name="firstname" 
                               value="<?php echo htmlspecialchars($userInfo['firstname'] ?? ''); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="lastname">Last Name</label>
                        <input type="text" class="form-control" id="lastname" name="lastname" 
                               value="<?php echo htmlspecialchars($userInfo['lastname'] ?? ''); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" class="form-control" id="email" name="email" 
                               value="<?php echo htmlspecialchars($userInfo['email'] ?? ''); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="phonenumber">Phone Number</label>
                        <input type="tel" class="form-control" id="phonenumber" name="phonenumber" 
                               value="<?php echo htmlspecialchars($userInfo['phonenumber'] ?? ''); ?>" required>
                    </div>
                    
                    <button type="submit" name="update_personal" class="btn-submit">
                        <i class="fas fa-save"></i> Update Personal Info
                    </button>
                </form>
            </div>
            
            <!-- Address Information Card -->
            <div class="dashboard-card">
                <div class="card-header">
                    <div class="card-icon">
                        <i class="fas fa-home"></i>
                    </div>
                    <h2 class="card-title">Address Information</h2>
                </div>
                
                <form method="POST" action="user_dashboard.php">
                    <div class="form-group">
                        <label for="streetaddress">Street Address</label>
                        <input type="text" class="form-control" id="streetaddress" name="streetaddress" 
                               value="<?php echo htmlspecialchars($addressInfo['streetaddress'] ?? ''); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="citytown">City/Town</label>
                        <input type="text" class="form-control" id="citytown" name="citytown" 
                               value="<?php echo htmlspecialchars($addressInfo['citytown'] ?? ''); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="state">State</label>
                        <select class="form-control" id="state" name="state" required>
                            <option value="">Select a state</option>
                            <option value="Perlis" <?php echo (isset($addressInfo['state']) && $addressInfo['state'] === 'Perlis') ? 'selected' : ''; ?>>Perlis</option>
                            <option value="Kedah" <?php echo (isset($addressInfo['state']) && $addressInfo['state'] === 'Kedah') ? 'selected' : ''; ?>>Kedah</option>
                            <option value="Penang" <?php echo (isset($addressInfo['state']) && $addressInfo['state'] === 'Penang') ? 'selected' : ''; ?>>Penang</option>
                            <option value="Perak" <?php echo (isset($addressInfo['state']) && $addressInfo['state'] === 'Perak') ? 'selected' : ''; ?>>Perak</option>
                            <option value="Selangor" <?php echo (isset($addressInfo['state']) && $addressInfo['state'] === 'Selangor') ? 'selected' : ''; ?>>Selangor</option>
                            <option value="Negeri Sembilan" <?php echo (isset($addressInfo['state']) && $addressInfo['state'] === 'Negeri Sembilan') ? 'selected' : ''; ?>>Negeri Sembilan</option>
                            <option value="Melaka" <?php echo (isset($addressInfo['state']) && $addressInfo['state'] === 'Melaka') ? 'selected' : ''; ?>>Melaka</option>
                            <option value="Johor" <?php echo (isset($addressInfo['state']) && $addressInfo['state'] === 'Johor') ? 'selected' : ''; ?>>Johor</option>
                            <option value="Kelantan" <?php echo (isset($addressInfo['state']) && $addressInfo['state'] === 'Kelantan') ? 'selected' : ''; ?>>Kelantan</option>
                            <option value="Terengganu" <?php echo (isset($addressInfo['state']) && $addressInfo['state'] === 'Terengganu') ? 'selected' : ''; ?>>Terengganu</option>
                            <option value="Pahang" <?php echo (isset($addressInfo['state']) && $addressInfo['state'] === 'Pahang') ? 'selected' : ''; ?>>Pahang</option>
                            <option value="Sabah" <?php echo (isset($addressInfo['state']) && $addressInfo['state'] === 'Sabah') ? 'selected' : ''; ?>>Sabah</option>
                            <option value="Sarawak" <?php echo (isset($addressInfo['state']) && $addressInfo['state'] === 'Sarawak') ? 'selected' : ''; ?>>Sarawak</option>
                            <option value="Kuala Lumpur" <?php echo (isset($addressInfo['state']) && $addressInfo['state'] === 'Kuala Lumpur') ? 'selected' : ''; ?>>Kuala Lumpur</option>
                            <option value="Putrajaya" <?php echo (isset($addressInfo['state']) && $addressInfo['state'] === 'Putrajaya') ? 'selected' : ''; ?>>Putrajaya</option>
                            <option value="Labuan" <?php echo (isset($addressInfo['state']) && $addressInfo['state'] === 'Labuan') ? 'selected' : ''; ?>>Labuan</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="postcode">Postcode</label>
                        <input type="text" class="form-control" id="postcode" name="postcode" 
                               value="<?php echo htmlspecialchars($addressInfo['postcode'] ?? ''); ?>" required>
                    </div>
                    
                    <button type="submit" name="update_address" class="btn-submit">
                        <i class="fas fa-map-marker-alt"></i> Update Address
                    </button>
                </form>
            </div>
        </div>
        
        <div class="dashboard-footer">
            <p>Brew & Go &copy; <?php echo date("Y"); ?> | Your Coffee Companion</p>
        </div>
    </div>
    
    <?php include("inc/scroll_to_top_button.inc"); ?>
    <?php include("inc/footer.inc"); ?>
</body>
</html>
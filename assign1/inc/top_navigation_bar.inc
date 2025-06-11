<?php
// Ensure session is started, database is initialised on every page cuz it's in the navbars and footer
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include("database_connection.inc");
?>

<nav>
    <div class="nav-selector">
        <a href="index.php">
            <img src="images/Brew&Go_logo.png" alt="Brew & Go logo">
        </a>
        <div class="nav-text">
            <a href="index.php">Brew & Go. Coffee</a>
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                <div class="admin-label">Admin</div>
            <?php endif; ?>
        </div>
    </div>

    <ul>
        <li>
            <div class="Dropdown_Start"><a href="product.php">Products</a>
                <div class="Dropdown_Content">
                    <ul>
                        <li><a href="product1.php">Basic Brew</a></li>
                        <li><a href="product2.php">Artisan Brew</a></li>
                        <li><a href="product3.php">Non-Coffee</a></li>
                        <li><a href="product4.php">Hot Beverages</a></li>
                    </ul>
                </div>
            </div>
        </li>
        <li>
            <div class="Dropdown_Start"><a href="activities.php">Activities</a>
                <div class="Dropdown_Content">
                    <ul>
                        <li><a href="Current.php">Current</a></li>
                        <li><a href="Coming_Soon.php">Coming Soon</a></li>
                        <li><a href="Past.php">Past</a></li>
                    </ul>
                </div>
            </div>
        </li>
        <li><a href="joinus.php">Join Us</a></li>
        <li><a href="enquiry.php">Enquiry</a></li>
        <li><a href="registration.php">Membership</a></li>
        
        <li id="nav-login" class="nav-selector">
            <div class="Dropdown_Start">
                <?php if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true): ?>
                    <div class="login-wrapper">
                        <a href="login.php">Login</a>
                        <a class="center" href="login.php">
                            <img alt="Login icon" src="images/Icons/user-circle-svgrepo-com(black).svg">
                        </a>
                    </div>
                <?php else: ?>
                    <div class="login-wrapper">
                        <a class="center" href="#">
                            <img alt="User icon" src="images/Icons/user-circle-svgrepo-com(black).svg">
                        </a>
                    </div>
                    <div class="Dropdown_Content">
                        <ul>
                            <?php if ($_SESSION['role'] === 'member'): ?>
                                <li><a href="user_dashboard.php">Dashboard</a></li>
                            <?php elseif ($_SESSION['role'] === 'admin'): ?>
                                <li><a href="admin_dashboard.php">Dashboard</a></li>
                            <?php endif; ?>
                            <li><a href="logout.php">Log Out</a></li>
                        </ul>
                    </div>
                <?php endif; ?>
            </div>
        </li>
    </ul>
</nav>

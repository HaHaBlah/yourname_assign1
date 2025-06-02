<?php
echo
'<nav>
        <div class="nav-selector">
            <a href="index.php"><img src="images/Brew&Go_logo.png" alt="Brew & Go logo"></a>
            <a href="index.php">Brew & Go. Coffee</a>
        </div>
        <ul>
            <li>
                <div class="Dropdown_Start"><a href="products.php">Products</a>
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
                <div class="Dropdown_Start"> <a href="activities.php">Activities</a>
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
                <a href="login.php">Login</a>
                <a class="center" href="login.php"><img alt="Login icon" src="images/Icons/user-circle-svgrepo-com(black).svg"></a>
            </li>
        </ul>
    </nav>'
?>
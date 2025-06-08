<!--Done-->
<!-- Check if user/ admin has logged in -->
<!-- If admin, then show admin logo -->
<?php include("inc/login_status.inc"); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="author" content="Hii Wei Bao">
    <title>Membership Registration Page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Brew & Go Coffee Membership Registration Page">
    <meta name="keywords" content="Brew & Go, Coffee, Membership, Registration">
    <link rel="stylesheet" href="styles/style.css">
    <link rel="icon" href="images/Brew&Go_logo.png" type="image/png">
</head>

<body>

    <?php include("inc/top_navigation_bar.inc"); ?>

    <header class="location-header" id="image-Coffee_Beans_Bg">
        <img src="images/Coffee_Beans_Bg.png" alt="Coffee Beans Background">
    </header>
    <main class="no-margin-top">

        <section class="login-pretext">
            <h1>Membership Registration Form</h1>

            <p>Fill in the form below to register as a member of Brew & Go Coffee.</p>
            <p>As a member, you will be entitled to exclusive discounts and promotions.</p>
            <p>We will send you a confirmation email once your registration is successful.</p>
        </section>

        <section class="registration-perks">
            <h1>Membership</h1>
            <ul>
                <li>To become a member, you can choose to top-up RM30, RM50, RM100 or RM200.</li>
                <li>The money that you top-up will be stored as credits.</li>
                <li>Remaining credit in your account cannot be withdrawn.</li>
                <li>Our membership is for lifetime.</li>
                <li>In an event of insufficient credit balance, a minimum top-up of RM30 is required to continue
                    enjoying member price.</li>
                <li>Members can choose to top-up RM50, RM100. or RM200.</li>
            </ul>

            <h1>Membership PERKS</h1>
            <ul>
                <li>Members can enjoy excusive member prices.</li>
                <li>A more attractive lucky draw prices awaits.</li>
                <li>Psstt: you may even get free drinks from us for FIVE DAYS STRAIGHT!!</li>
            </ul>

            <img src="images/Join_member/duitnow.svg" alt="Join Member" class="registration-qr">
            <br>
            <label for="myFile">Upload your payment receipt here:</label>
            <br>
            <div class="file-upload-wrapper">
                <input type="file" name="myFile" id="myFile" hidden required>
                <label for="myFile" class="btn-upload responsive-hover-button">Choose File</label>
            </div>
            <br>
            <input class="btn-upload responsive-hover-button" type="submit" value="Send">
        </section>

        <br>
        <br>

        <section class="login-container" id="registration-container">
            <div class="login-left">
                <img src="images/Brew&Go_logo.png" alt="Brew & Go logo">

                <h2>Membership Registration</h2>
                <p>Become a member of Brew & Go. Coffee</p>
            </div>
            <div class="login-right">
                <form action="membership_process.php" method="post" enctype="multipart/form-data">
                    <fieldset>
                        <fieldset>
                            <legend>Personal Details</legend>
                            <input class="responsive-hover" type="text" placeholder="First name" name="firstname"
                                maxlength="25" required="required" pattern="[A-Za-z\s]+"
                                title="Alphabetical characters only; Maximum 25 characters." id="firstname" value="<?php echo htmlspecialchars($data['firstname'] ?? ''); ?>">
                            <input class="responsive-hover" type="text" placeholder="Last name" name="lastname"
                                maxlength="25" required="required" pattern="[A-Za-z\s]+"
                                title="Alphabetical characters only; Maximum 25 characters." id="lastname" value="<?php echo htmlspecialchars($data['lastname'] ?? ''); ?>">
                            <input class="responsive-hover" type="email" placeholder="E-mail address" name="email"
                                required="required" pattern="/^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$/" id="email" value="<?php echo htmlspecialchars($data['email'] ?? ''); ?>">
                        </fieldset>
                        <fieldset>
                            <legend>Account Details</legend>
                            <input class="responsive-hover" type="text" name="username" placeholder="Username" required
                                maxlength="10" pattern="[A-Za-z]+" id="username" value="<?php echo htmlspecialchars($data['username'] ?? ''); ?>"
                                title="Alphabetical characters only; Maximum 10 characters.">
                            <input class="responsive-hover" type="text" name="password" placeholder="Password" required
                                maxlength="25" pattern="[A-Za-z0-9]+"
                                title="Alphabetical characters only; Maximum 25 characters." id="password">
                        </fieldset>
                        <button class="responsive-hover-button" type="submit">Become a Member</button>
                        <button class="responsive-hover-button" type="reset">Clear Form</button>
                    </fieldset>
                </form>

                <div class="login-bottom">
                    <a href="login.html">Already a Member?</a>
                </div>
            </div>
        </section>

        
    </main>
    <?php include("inc/scroll_to_top_button.inc"); ?>

    <?php include("inc/footer.inc"); ?>
    <!--<footer>
        <div class="footer-container">
            <div class="row">
                <div class="footer-col">
                    <h4>Overview</h4>
                    <ul>
                        <li><a href="index.html">Home</a></li>
                        <li><a href="products.html">Products</a></li>
                        <li><a href="Activities.html">Activities</a></li>
                        <li><a href="joinus.html">Work for us</a></li>
                        <li><a href="locations.html">Visit Us</a></li>
                        <li><a href="enquiry.html">FAQ</a></li>
                        <li><a href="registration.html">Register</a></li>
                        <li><a href="login.html">Login</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4><a href="about.html">The Team</a></h4>
                    <ul>
                        <li><a href="aboutme1.html">Kelvin</a></li>
                        <li><a href="aboutme2.html">Patrick</a></li>
                        <li><a href="aboutme3.html">Ricardo</a></li>
                        <li><a href="aboutme4.html">Wei Bao</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>Extra</h4>
                    <ul>
                        <li><a href="acknowledgement.html">Acknowledgements</a></li>
                        <li><a href="enhancements.html">Enhancements</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>Follow Us</h4>
                    <div class="social-links">
                        <a class="responsive-hover-img" href="https://www.instagram.com/p/DGdDmXOPD-J/">
                            <img class="responsive-hover" src="images/Icons/bxl-instagram.svg" alt="Instagram">
                        </a>
                        <a class="responsive-hover-img" href="https://www.facebook.com/profile.php?id=61554234958482">
                            <img class="responsive-hover" src="images/Icons/bxl-facebook-circle.svg" alt="Facebook">
                        </a>
                    </div>
                    <h4>Contact Us</h4>
                    <p>Phone: +60 11-1653 1886</p>
                    <p>Email: <a href="mailto:brewngo.coffee@gmail.com">brewngo.coffee@gmail.com</a></p>
                </div>
                <div class="footer-col">
                    <h4>Latest from us</h4>
                    <iframe class="responsive-hover-img no-scroll"
                        src="https://www.facebook.com/plugins/post.php?href=https%3A%2F%2Fwww.facebook.com%2Fpermalink.php%3Fstory_fbid%3Dpfbid0Ro5XUkWsugqwP6cFKBsd7MWcqumoxyF4wDd8xdPcGCLZK7udVGAtrpvjBrnVUgJSl%26id%3D61554234958482&show_text=true&width=500"
                        allowfullscreen
                        allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share"></iframe>
                </div>
                <div class="footer-col">
                    <small>&copy; 2025 Brew & Go Coffee</small>
                </div>
            </div>
        </div>
    </footer>-->
    <?php unset($_SESSION['form_data']); ?>
</body>

</html>
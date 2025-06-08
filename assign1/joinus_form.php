<!--Done-->
<!-- Check if user/ admin has logged in -->
<!-- If admin, then show admin logo -->
<?php include("inc/login_status.inc"); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Join Us</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="images/Brew&Go_logo.png" type="image/png">
    <link rel="stylesheet" href="styles/style.css">

</head>

<body>
    <?php include("inc/top_navigation_bar.inc"); ?>
    <header class="location-header" id="image-Coffee_Beans_Bg">
        <img src="images/Coffee_Beans_Bg.png" alt="Coffee Beans Background">
    </header>
    <main>
        <section>
            <div class="login-container" id="joinus-container">
                <div class="login-left">
                    <img src="images/Brew&Go_logo.png" alt="Brew & Go logo">

                    <h2>Join Us ☕</h2>
                    <p>We would love to have you!</p>
                </div>
                <div class="login-right">
                    <form action="joinus_process.php" method="post" enctype="multipart/form-data">
                        <fieldset>
                            <fieldset>
                                <legend>
                                    <strong>Personal Details</strong>
                                </legend>
                                <input class="responsive-hover" type="text" placeholder="First name" name="firstname"
                                    maxlength="25" required="required" pattern="[A-Za-z\s]+"
                                    title="Alphabetical characters only; Maximum 25 characters." id="firstname"><br>

                                <input class="responsive-hover" type="text" placeholder="Last name" name="lastname"
                                    maxlength="25" required="required" pattern="[A-Za-z\s]+"
                                    title="Alphabetical characters only; Maximum 25 characters." id="lastname"><br>

                                <input class="responsive-hover" type="email" placeholder="Enter your e-mail address"
                                    name="email" required="required"
                                    pattern="/^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$/" id="email"><br>
                                <input class="responsive-hover" type="text" placeholder="Phone Number" id="phonenumber"
                                    name="phonenumber" maxlength="11" required="required" pattern="\d{10}"
                                    title="Format:0123456789.">
                            </fieldset>
                            <fieldset>
                                <legend>
                                    <strong>Address</strong>
                                </legend>
                                <label for="streetaddress">Street Address:</label>
                                <input class="responsive-hover" type="text" id="streetaddress" name="streetaddress" placeholder="Street Address"
                                    maxlength="40" required="required"
                                    pattern="[A-Za-z0-9\s]+"
                                    title="Alphanumeric characters only; Maximum 40 characters.">
                                <br>
                                <label for="citytown">City/Town:</label>
                                <input class="responsive-hover" type="text" placeholder="City/Town" id="citytown" name="citytown"
                                    maxlength="20" required="required" pattern="[A-Za-z\s]+"
                                    title="Alphabetical characters only; Maximum 20 characters.">
                                <br>
                                <label for="state">State:</label>

                                <select id="state" name="state" required="required">

                                    <option value="">Select a state</option>
                                    <option value="Perlis">Perlis</option>
                                    <option value="Kedah">Kedah</option>
                                    <option value="Penang">Penang</option>
                                    <option value="Perak">Perak</option>
                                    <option value="Selangor">Selangor</option>
                                    <option value="Negeri Sembilan">Negeri Sembilan</option>
                                    <option value="Melaka">Melaka</option>
                                    <option value="Johor">Johor</option>
                                    <option value="Kelantan">Kelantan</option>
                                    <option value="Terengganu">Terengganu</option>
                                    <option value="Pahang">Pahang</option>
                                    <option value="Sabah">Sabah</option>
                                    <option value="Sarawak">Sarawak</option>
                                    <option value="Kuala Lumpur">Kuala Lumpur</option>
                                    <option value="Putrajaya">Putrajaya</option>
                                    <option value="Labuan">Labuan</option>
                                </select>
                                <br>

                                <label for="postcode">Postcode:</label>
                                <input class="responsive-hover" type="text" placeholder="Postcode" id="postcode"
                                    name="postcode" maxlength="5" required="required" pattern="\d{5}"
                                    title="5-digit postcode only.">
                            </fieldset>

                            <br>
                            <fieldset>
                                <legend>
                                    <strong>Verification</strong>
                                </legend>
                                <label for="FileCV">CV Upload:</label>
                                <input type="file" id="FileCV" name="CVFile" required="required" accept=".pdf, .doc, .docx">

                                <label for="FilePhoto">Photo Upload (less than 200kb):</label>
                                <input type="file" id="FilePhoto" name="FilePhoto" required="required" accept="image/*">



                                <button class="responsive-hover-button" type="submit">Join Now!</button>
                                <button class="responsive-hover-button" type="reset">Clear Form</button>
                            </fieldset>
                        </fieldset>
                    </form>
                </div>
            </div>
        </section>
    </main>
    <?php include("inc/scroll_to_top_button.inc"); ?>

    <?php include("inc/footer.inc"); ?>
</body>

</html>
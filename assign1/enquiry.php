<?php
// 1) Initialise DB & check login
require_once "inc/database_connection.inc";
require_once "inc/login_status.inc";

// 2) If the user is logged in, fetch any saved profile/address data
$isLoggedIn = !empty($_SESSION['logged_in']);
$userProfile = [];

if ($isLoggedIn) {
    $username = $_SESSION['username'];
    $stmt = $conn->prepare("
        SELECT firstname, lastname, email, phonenumber,
               streetaddress, citytown, state, postcode
          FROM members
         WHERE username = ?
         LIMIT 1
    ");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $userProfile = $stmt->get_result()->fetch_assoc() ?: [];
    $stmt->close();
}

// 3) Decide which sections need to be shown
$hasPersonal = !empty($userProfile['firstname'])
            && !empty($userProfile['lastname'])
            && !empty($userProfile['email'])
            && !empty($userProfile['phonenumber']);

$hasAddress  = !empty($userProfile['streetaddress'])
            && !empty($userProfile['citytown'])
            && !empty($userProfile['state'])
            && !empty($userProfile['postcode']);

$showPersonal = ! $hasPersonal;
$showAddress  = ! $hasAddress;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Contact Us – Brew &amp; Go Coffee</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="styles/style.css">
</head>
<body>
  <?php include "inc/top_navigation_bar.inc"; ?>

  <main class="no-margin-top">
    <section id="enquiry-container" class="login-container">
      <div class="login-left">
        <img src="images/Brew&Go_logo.png" alt="Brew & Go logo">
        <h2>Contact Us ☕</h2>
        <p>We are here to help!</p>
      </div>

      <div class="login-right">
        <form action="enquiry_process.php" method="post">
          <fieldset>
            <!-- Personal Information -->
            <?php if ($showPersonal): ?>
            <fieldset>
              <legend><strong>Personal Information</strong></legend>
              <input
                class="responsive-hover"
                type="text"
                name="firstname"
                placeholder="First name"
                maxlength="25"
                required
                pattern="[A-Za-z\s]+"
                value="<?= htmlspecialchars($userProfile['firstname'] ?? '') ?>"
              ><br>

              <input
                class="responsive-hover"
                type="text"
                name="lastname"
                placeholder="Last name"
                maxlength="25"
                required
                pattern="[A-Za-z\s]+"
                value="<?= htmlspecialchars($userProfile['lastname'] ?? '') ?>"
              ><br>

              <input
                class="responsive-hover"
                type="email"
                name="email"
                placeholder="E-mail address"
                required
                value="<?= htmlspecialchars($userProfile['email'] ?? '') ?>"
              ><br>

              <input
                class="responsive-hover"
                type="text"
                name="phonenumber"
                placeholder="Phone Number"
                maxlength="11"
                required
                pattern="\d{10,11}"
                title="Format: 0123456789"
                value="<?= htmlspecialchars($userProfile['phonenumber'] ?? '') ?>"
              >
            </fieldset>
            <?php endif; ?>

            <!-- Address -->
            <?php if ($showAddress): ?>
            <fieldset>
              <legend><strong>Address</strong></legend>
              <label for="streetaddress">Street Address:</label><br>
              <input
                class="responsive-hover"
                type="text"
                id="streetaddress"
                name="streetaddress"
                placeholder="Street Address"
                maxlength="40"
                required
                value="<?= htmlspecialchars($userProfile['streetaddress'] ?? '') ?>"
              ><br>

              <label for="citytown">City/Town:</label><br>
              <input
                class="responsive-hover"
                type="text"
                id="citytown"
                name="citytown"
                placeholder="City/Town"
                maxlength="20"
                required
                pattern="[A-Za-z\s]+"
                value="<?= htmlspecialchars($userProfile['citytown'] ?? '') ?>"
              ><br>

              <label for="state">State:</label><br>
              <select id="state" name="state" required>
                <option value="">Select a state</option>
                <?php
                  $states = [
                    'Perlis','Kedah','Penang','Perak','Selangor',
                    'Negeri Sembilan','Melaka','Johor','Kelantan',
                    'Terengganu','Pahang','Sabah','Sarawak',
                    'Kuala Lumpur','Putrajaya','Labuan'
                  ];
                  foreach ($states as $st) {
                      $sel = ($userProfile['state'] ?? '') === $st ? ' selected' : '';
                      echo "<option value=\"$st\"$sel>$st</option>";
                  }
                ?>
              </select><br>

              <label for="postcode">Postcode:</label><br>
              <input
                class="responsive-hover"
                type="text"
                id="postcode"
                name="postcode"
                placeholder="Postcode"
                maxlength="5"
                required
                pattern="\d{5}"
                value="<?= htmlspecialchars($userProfile['postcode'] ?? '') ?>"
              >
            </fieldset>
            <?php endif; ?>

            <!-- Enquiry Details (always shown) -->
            <fieldset>
              <legend><strong>Enquiry</strong></legend>
              <select id="enquirytype" name="enquirytype" required>
                <option value="">Select an enquiry type</option>
                <option value="Product">Products</option>
                <option value="Membership">Membership</option>
                <option value="Pop-up">Pop-up Market Activities</option>
              </select><br>

              <label for="message">Your Message:</label><br>
              <textarea
                id="message"
                name="message"
                placeholder="Your Message"
                required
                rows="3"
                cols="40"
              ><?= htmlspecialchars($data['message'] ?? '') ?></textarea>
            </fieldset>

            <button class="responsive-hover-button" type="submit">
              Send Enquiry
            </button>
            <button class="responsive-hover-button" type="reset">
              Clear Form
            </button>
          </fieldset>
        </form>
      </div>
    </section>
  </main>

  <?php include "inc/scroll_to_top_button.inc"; ?>
  <?php include "inc/footer.inc"; ?>
</body>
</html>
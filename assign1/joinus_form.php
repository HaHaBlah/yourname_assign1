<?php
// 1) Database & login check
require_once "inc/database_connection.inc";
require_once "inc/login_status.inc";

// 2) Fetch existing “join‐us” data, if any
$isLoggedIn = !empty($_SESSION['logged_in']);
$userData   = [];

if ($isLoggedIn) {
    $username = $_SESSION['username'];
    $stmt = $conn->prepare("
        SELECT firstname, lastname, email, phonenumber,
               streetaddress, citytown, state, postcode,
               CVFile, PhotoFile
          FROM members
         WHERE username = ?
         LIMIT 1
    ");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $userData = $stmt->get_result()->fetch_assoc() ?: [];
    $stmt->close();
}

// 3) Decide which sections still need input
$hasAddress      = !empty($userData['streetaddress'])
                 && !empty($userData['citytown'])
                 && !empty($userData['state'])
                 && !empty($userData['postcode']);

$hasVerification = !empty($userData['CVFile'])
                 && !empty($userData['PhotoFile']);

$showAddress      = ! $hasAddress;
$showVerification = ! $hasVerification;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Join Us – Brew &amp; Go Coffee</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="styles/style.css">
</head>
<body>
  <?php include "inc/top_navigation_bar.inc"; ?>

  <main>
    <section id="joinus-container" class="login-container">
      <div class="login-left">
        <img src="images/Brew&Go_logo.png" alt="Brew & Go logo">
        <h2>Join Us ☕</h2>
        <p>We would love to have you!</p>
      </div>

      <div class="login-right">
        <form action="joinus_process.php" method="post" enctype="multipart/form-data">
          <fieldset>

            <!-- always show Personal Details -->
            <fieldset>
              <legend><strong>Personal Details</strong></legend>
              <input
                class="responsive-hover"
                type="text"
                name="firstname"
                placeholder="First name"
                maxlength="25"
                required
                pattern="[A-Za-z\s]+"
                value="<?= htmlspecialchars($userData['firstname'] ?? '') ?>"
              ><br>

              <input
                class="responsive-hover"
                type="text"
                name="lastname"
                placeholder="Last name"
                maxlength="25"
                required
                pattern="[A-Za-z\s]+"
                value="<?= htmlspecialchars($userData['lastname'] ?? '') ?>"
              ><br>

              <input
                class="responsive-hover"
                type="email"
                name="email"
                placeholder="Enter your e-mail address"
                required
                value="<?= htmlspecialchars($userData['email'] ?? '') ?>"
              ><br>

              <input
                class="responsive-hover"
                type="text"
                name="phonenumber"
                placeholder="Phone Number"
                maxlength="11"
                required
                pattern="\d{10,11}"
                title="Format:0123456789."
                value="<?= htmlspecialchars($userData['phonenumber'] ?? '') ?>"
              >
            </fieldset>

            <!-- Address: show only if missing, else hidden -->
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
                pattern="[A-Za-z0-9\s]+"
                value="<?= htmlspecialchars($userData['streetaddress'] ?? '') ?>"
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
                value="<?= htmlspecialchars($userData['citytown'] ?? '') ?>"
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
                    $sel = ($userData['state'] ?? '') === $st ? ' selected' : '';
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
                value="<?= htmlspecialchars($userData['postcode'] ?? '') ?>"
              >
            </fieldset>
            <?php else: ?>
              <input type="hidden" name="streetaddress"
                     value="<?= htmlspecialchars($userData['streetaddress']) ?>">
              <input type="hidden" name="citytown"
                     value="<?= htmlspecialchars($userData['citytown']) ?>">
              <input type="hidden" name="state"
                     value="<?= htmlspecialchars($userData['state']) ?>">
              <input type="hidden" name="postcode"
                     value="<?= htmlspecialchars($userData['postcode']) ?>">
            <?php endif; ?>

            <!-- Verification: show only if missing, else hidden -->
            <?php if ($showVerification): ?>
            <fieldset>
              <legend><strong>Verification</strong></legend>
              <label for="FileCV">CV Upload:</label><br>
              <input
                type="file"
                id="FileCV"
                name="CVFile"
                required
                accept=".pdf,.doc,.docx"
              ><br>

              <label for="FilePhoto">Photo Upload (≤200 KB):</label><br>
              <input
                type="file"
                id="FilePhoto"
                name="PhotoFile"
                required
                accept="image/*"
              >
            </fieldset>
            <?php else: ?>
              <input type="hidden" name="CVFile"
                     value="<?= htmlspecialchars($userData['CVFile']) ?>">
              <input type="hidden" name="PhotoFile"
                     value="<?= htmlspecialchars($userData['PhotoFile']) ?>">
            <?php endif; ?>

            <br>
            <button class="responsive-hover-button" type="submit">
              <?= ($showAddress || $showVerification) ? 'Save Details' : 'All Done!' ?>
            </button>
            <?php if ($showAddress || $showVerification): ?>
              <button class="responsive-hover-button" type="reset">
                Clear Form
              </button>
            <?php endif; ?>

          </fieldset>
        </form>
      </div>
    </section>
  </main>

  <?php include "inc/scroll_to_top_button.inc"; ?>
  <?php include "inc/footer.inc"; ?>
</body>
</html>

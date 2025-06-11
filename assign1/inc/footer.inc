<?php
// inc/footerbare.inc

// 1. Safely include the DB connection only once
if (!isset($conn)) {
  require_once __DIR__ . '/database_connection.inc';
}

// 2. Get the 5 latest updates
$sql = "SELECT update_message, photofile FROM updates ORDER BY id DESC LIMIT 1";
$res = $conn->query($sql);
?>
<footer>
  <div class="footer-container">
    <div class="row">

      <!-- Column 1: Navigation -->
      <div class="footer-col">
        <h4>Overview</h4>
        <ul>
          <li><a href="index.php">Home</a></li>
          <li><a href="products.php">Products</a></li>
          <li><a href="Activities.php">Activities</a></li>
          <li><a href="joinus.php">Work for us</a></li>
          <li><a href="locations.php">Visit Us</a></li>
          <li><a href="enquiry.php">FAQ</a></li>
          <li><a href="registration.php">Register</a></li>
          <li><a href="login.php">Login</a></li>
        </ul>
      </div>

      <!-- Column 2: Team -->
      <div class="footer-col">
        <h4><a href="about.php">The Team</a></h4>
        <ul>
          <li><a href="aboutme1.php">Kelvin</a></li>
          <li><a href="aboutme2.php">Patrick</a></li>
          <li><a href="aboutme3.php">Ricardo</a></li>
          <li><a href="aboutme4.php">Wei Bao</a></li>
        </ul>
      </div>

      <!-- Column 3: Extras -->
      <div class="footer-col">
        <h4>Extra</h4>
        <ul>
          <li><a href="acknowledgement.php">Acknowledgements</a></li>
          <li><a href="enhancements.php">Enhancements</a></li>
          <li><a href="enhancements2.php">Enhancements2</a></li>
        </ul>
      </div>

      <!-- Column 4: Social & Contact -->
      <div class="footer-col">
        <h4>Follow Us</h4>
        <div class="social-links">
          <a href="https://www.instagram.com/p/DGdDmXOPD-J/">
            <img src="images/Icons/bxl-instagram.svg" alt="Instagram">
          </a>
          <a href="https://www.facebook.com/profile.php?id=61554234958482">
            <img src="images/Icons/bxl-facebook-circle.svg" alt="Facebook">
          </a>
        </div>

        <h4>Contact Us</h4>
        <p>Phone: +60 11-1653 1886</p>
        <p>Email: <a href="mailto:brewngo.coffee@gmail.com">brewngo.coffee@gmail.com</a></p>
      </div>

      <!-- Column 5: Facebook Embed -->
      <div class="footer-col">
        <h4>Latest From Us</h4>
        <iframe
          class="responsive-hover-img no-scroll"
          src="https://www.facebook.com/plugins/post.php?href=https%3A%2F%2Fwww.facebook.com%2Fpermalink.php%3Fstory_fbid%3Dpfbid0Ro5XUkWsugqwP6cFKBsd7MWcqumoxyF4wDd8xdPcGCLZK7udVGAtrpvjBrnVUgJSl%26id%3D61554234958482&amp;show_text=true&amp;width=500"
          allowfullscreen
          allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share">
        </iframe>
      </div>

      <!-- Column 6: Latest Updates -->
      <div class="footer-col">
        <h4>Latest Update</h4>
        <?php if ($res && $res->num_rows): ?>
          <?php $u = $res->fetch_assoc(); ?>
          <div>
            <?php if (!empty($u['update_message'])): ?>
              <p><?= htmlspecialchars($u['update_message'], ENT_QUOTES) ?></p>
            <?php endif; ?>
            <?php if (!empty($u['photofile'])): ?>
              <img src="<?= htmlspecialchars($u['photofile'], ENT_QUOTES) ?>" alt="Update Image">
            <?php endif; ?>
          </div>
        <?php else: ?>
          <p>No updates at the moment.</p>
        <?php endif; ?>
        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
          <div class="update-form">
            <form action="edit_update.php" method="post" enctype="multipart/form-data">
              <fieldset>
                <h3>Update Latest News</h3>
                <textarea placeholder="New Update" id="update_message" name="update_message" required="required"
                  rows="3" cols="40"><?php echo htmlspecialchars($data['update_message'] ?? ''); ?></textarea><br>
                <label for="FilePhoto">Image:</label>
                <input type="file" id="FilePhoto" name="FilePhoto" accept="image/*">
                <button class="responsive-hover-button" type="submit">Update Message</button>
                <button class="responsive-hover-button" type="reset">Clear Form</button>
              </fieldset>
            </form>
          </div>
        <?php endif; ?>
      </div>

      <!-- Footer Copyright -->
      <div class="footer-col">
        <small>&copy; <?php echo date("Y"); ?> Brew & Go Coffee</small>
      </div>

    </div>

  </div>
</footer>
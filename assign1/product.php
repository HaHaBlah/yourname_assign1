<?php
$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "product";

$conn = new mysqli($servername, $username, $password);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "CREATE DATABASE IF NOT EXISTS `$dbname`
         DEFAULT CHARACTER SET utf8mb4
         COLLATE utf8mb4_general_ci";
if (! $conn->query($sql)) {
    die("Database creation failed: " . $conn->error);
}

$conn->select_db($dbname);

$sql = "
  CREATE TABLE IF NOT EXISTS `products` (
    `id`        INT(6) UNSIGNED NOT NULL AUTO_INCREMENT,
    `name`      VARCHAR(100)        NOT NULL,
    `np`        DECIMAL(8,2)        NOT NULL COMMENT 'normal price',
    `mp`        DECIMAL(8,2)        NOT NULL COMMENT 'member price',
    `image_url` VARCHAR(255) DEFAULT NULL,
    PRIMARY KEY (`id`)
  ) ENGINE=InnoDB
    DEFAULT CHARSET=utf8mb4
    COLLATE=utf8mb4_general_ci
";
if (! $conn->query($sql)) {
    die("Table creation failed: " . $conn->error);
}

$keyword = '';
$results = [];

if (isset($_GET['q'])) {
    $keyword = trim($_GET['q']);
    if ($keyword !== '') {
        $sql = "
          SELECT `id`, `name`, `np`, `mp`, `image_url`
          FROM `products`
          WHERE `name` LIKE ?
          ORDER BY `name` ASC
        ";
        $stmt = $conn->prepare($sql);
        $likeParam = '%' . $keyword . '%';
        $stmt->bind_param("s", $likeParam);
        $stmt->execute();
        $resultSet = $stmt->get_result();
        while ($row = $resultSet->fetch_assoc()) {
            $results[] = $row;
        }
        $stmt->close();
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <title>Locations</title>
  <meta name="description" content="" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="icon" href="images/Brew&Go_logo.png" type="image/png" />
  <link rel="stylesheet" href="styles/style.css" />
</head>

<body>
  <?php include("inc/top_navigation_bar.inc"); ?>

  <div class="video-banner">
    <video autoplay loop muted>
      <source src="video/Strawberry_latte.mp4" type="video/mp4" />
      Your browser does not support the video tag.
    </video>
    <div class="title">
      <span class="cursive-text">
        Once a Strawberry Latte addict, forever a Strawberry Latte addict🍓☕
      </span>
    </div>
  </div>

  <form action="product.php" method="get" class="search-form">
    <input
      type="text"
      name="q"
      placeholder="Search products..."
      value="<?php echo htmlspecialchars($keyword); ?>"
    >
    <button type="submit">Search</button>
  </form>

  <main>
    <?php if ($keyword !== ''): ?>
      <h2>Search Results for “<?php echo htmlspecialchars($keyword); ?>”</h2>

      <?php if (empty($results)): ?>
        <p>No products found containing “<?php echo htmlspecialchars($keyword); ?>”.</p>
      <?php else: ?>
        <div class="product-gallery">
          <?php foreach ($results as $product): ?>
            <section class="product-content">
              <?php if (!empty($product['image_url'])): ?>
                <img
                  src="<?php echo htmlspecialchars($product['image_url']); ?>"
                  alt="<?php echo htmlspecialchars($product['name']); ?>"
                >
              <?php else: ?>
                <div class="no-image">No image available</div>
              <?php endif; ?>
              <h3><?php echo htmlspecialchars($product['name']); ?></h3>
              <p class="product-price">
                <span class="product-mp-price">MP: RM<?php echo number_format($product['mp'], 2); ?></span>
                <span class="product-divider">|</span>
                <span class="product-np-price">NP: RM<?php echo number_format($product['np'], 2); ?></span>
              </p>
              <a href="https://food.grab.com/my/en/restaurant/brew-go-coffee-plaza-merdeka-delivery/1-C7AKV63CAU6TV6?"
                 target="_blank">
                <button class="product-buy-4">Buy Now</button>
              </a>
            </section>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>

    <?php else: ?>

      <div class="review-cards">
        <div class="review-card">
          <div class="stars">★ ★ ★ ★ ★</div>
          <div class="comment">
            "The best Strawberry Latte I've ever had! The taste is perfect every time!"
          </div>
          <div class="name">John Doe</div>
        </div>

        <div class="review-card">
          <div class="stars">★ ★ ★ ★ ★</div>
          <div class="comment">
            "Absolutely love it! The creamy texture and the strawberry flavor are just perfect."
          </div>
          <div class="name">Jane Smith</div>
        </div>

        <div class="review-card">
          <div class="stars">★ ★ ★ ★ ★</div>
          <div class="comment">
            "Can't get enough of this drink! It's my go-to whenever I need a pick-me-up."
          </div>
          <div class="name">Alex Johnson</div>
        </div>
      </div>

    <?php endif; ?>
  </main>

  <?php include("inc/scroll_to_top_button.inc"); ?>
  <?php include("inc/footer.inc"); ?>

</body>

</html>
<?php

$conn->close();
?>

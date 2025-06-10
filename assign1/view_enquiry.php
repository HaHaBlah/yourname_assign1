<!DOCTYPE html>
<html lang="en">

<!-- Check if user/ admin has logged in -->
<?php include("inc/login_status.inc"); ?>

<?php // Enable this later
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php?error=not_authorized');
    exit;
}
?>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Enquiries</title>
    <meta name="description" content="View customer enquiries at Brew & Go Coffee">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="images/Brew&Go_logo.png" type="image/png">
    <link rel="stylesheet" href="styles/style.css">
</head>

<body>
    <?php include("inc/top_navigation_bar.inc"); ?>
    <main class="view_enquiry_main">
        <h1 class="view_enquiry_title">Enquiry List</h1>

        <table class="jobapp-table enquiry-table">
            <tr>
                <th>No</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Address</th>
                <th>City/Town</th>
                <th>State</th>
                <th>Postcode</th>
                <th>Enquiry Type</th>
                <th>Message</th>
                <th>Submitted At</th>
                <th>Actions</th>
            </tr>

            <?php
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "brew&go_db";

            // Create connection
            $conn = mysqli_connect($servername, $username, $password, $dbname);

            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }

            $sql = "SELECT * FROM enquiries ORDER BY submitted_at DESC";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                $no = 1;
                while ($row = mysqli_fetch_assoc($result)) {
            ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td><?php echo htmlspecialchars($row["firstname"]); ?></td>
                        <td><?php echo htmlspecialchars($row["lastname"]); ?></td>
                        <td><?php echo htmlspecialchars($row["email"]); ?></td>
                        <td><?php echo htmlspecialchars($row["phonenumber"]); ?></td>
                        <td><?php echo htmlspecialchars($row["streetaddress"]); ?></td>
                        <td><?php echo htmlspecialchars($row["citytown"]); ?></td>
                        <td><?php echo htmlspecialchars($row["state"]); ?></td>
                        <td><?php echo htmlspecialchars($row["postcode"]); ?></td>
                        <td><?php echo htmlspecialchars($row["enquirytype"]); ?></td>
                        <td><?php echo nl2br(htmlspecialchars($row["message"])); ?></td>
                        <td><?php echo htmlspecialchars($row["submitted_at"]); ?></td>
                        <td>
                            <a href="reply_enquiry.php?id=<?php echo $row['id']; ?>" class="reply-btn">Reply</a>
                        </td>
                    </tr>
            <?php
                }
            } else {
                echo "<tr><td colspan='13'>No enquiries found.</td></tr>";
            }

            
            ?>
        </table>

        <?php include("inc/scroll_to_top_button.inc"); ?>
    </main>
    <?php include("inc/footer.inc"); ?>
    mysqli_close($conn);
</body>

</html>
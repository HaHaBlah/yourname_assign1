<!DOCTYPE html>
<html lang="en">

<!-- Check if user/ admin has logged in -->
<!-- If admin, then show admin logo -->
<?php include("inc/login_status.inc"); ?>

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
    <main>
        <h1>Enquiry List</h1>

        <table border="1">
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
            </tr>

            <?php
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "enquiry";
            // Create connection
            $conn = mysqli_connect($servername, $username, $password, $dbname);
            // Check connection
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
                    </tr>
            <?php
                }
            } else {
                echo "<tr><td colspan='12'>No enquiries found.</td></tr>";
            }

            mysqli_close($conn);
            ?>
        </table>
        <?php include("inc/scroll_to_top_button.inc"); ?>
    </main>
    <?php include("inc/footer.inc"); ?>
</body>

</html>
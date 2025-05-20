<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Members</title>
    <meta name="description" content="Career opportunities at Brew & Go Coffee">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="images/Brew&Go_logo.png" type="image/png">
    <link rel="stylesheet" href="styles/style.css">
</head>

<body>
    <?php include("inc/top_navigation_bar.inc"); ?>
    <main>
        <h1>Job Apps</h1>

        <table border="1">
            <tr>
                <th>No</th>
                <th width="120px">First Name</th>
                <th width="120px">Last Name</th>
                <th width="200px">Email</th>
                <th width="120px">Phone</th>
                <th width="180px">Address</th>
                <th width="120px">City/Town</th>
                <th width="120px">State</th>
                <th width="80px">Postcode</th>
                <th width="120px">CV</th>
                <th width="120px">Photo</th>
                <th width="180px">Registration Date</th>
            </tr>

            <?php
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "JoinUs";
            // Create connection
            $conn = mysqli_connect($servername, $username, $password, $dbname);
            // Check connection
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }
            $sql = "SELECT * FROM members";
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
                        <td>
                            <?php if (!empty($row["cvfile"])): ?>
                                <a href="<?php echo htmlspecialchars($row["cvfile"]); ?>" target="_blank">Download</a>
                            <?php else: ?>
                                N/A
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if (!empty($row["photofile"])): ?>
                                <a href="<?php echo htmlspecialchars($row["photofile"]); ?>" target="_blank">View</a>
                            <?php else: ?>
                                N/A
                            <?php endif; ?>
                        </td>
                        <td><?php echo htmlspecialchars($row["reg_date"]); ?></td>
                    </tr>
            <?php
                }
            } else {
                echo "<tr><td colspan='12'>0 results</td></tr>";
            }

            mysqli_close($conn);
            ?>
        </table>
        <?php include("inc/scroll_to_top_button.inc"); ?>
    </main>


    <?php include("inc/footer.inc"); ?>
</body>

</html>
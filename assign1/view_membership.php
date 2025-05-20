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
        <h1>Booking page</h1>

        <table border="1">
            <tr>
                <th>No</th>
                <th width="150px">Name</th>
                <th width="80px">Age</th>
                <th width="80px">Food</th>
                <th width="80px">Size</th>
            </tr>

            <?php
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "membership";
            // Create connection
            $conn = mysqli_connect($servername, $username, $password, $dbname);
            // Check connection
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }
            $sql = "SELECT * FROM R_Book";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                // output data of each row
                while ($row = mysqli_fetch_assoc($result)) {
            ?>
                    <tr>
                        <td> <?php echo $row["id"]; ?></td>
                        <td> <?php echo $row["firstname"] . " " . $row["lastname"]; ?></td>
                        <td> <?php echo $row["age"]; ?></td>
                        <td> <?php echo $row["food"]; ?></td>
                        <td> <?php echo $row["size"]; ?></td>
                    </tr>

            <?php
                }
            } else {
                echo "0 results";
            }

            mysqli_close($conn);
            ?>
        </table>
    </main>
    <?php include("inc/scroll_to_top_button.inc"); ?>

    <?php include("inc/footer.inc"); ?>
</body>

</html>
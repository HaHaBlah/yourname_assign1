<!DOCTYPE html>
<html lang="en">

<!-- Check if user/ admin has logged in -->
<!-- If admin, then show admin logo -->
<?php include("inc/login_status.inc"); ?>

<?php
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php?error=not_authorized');
    exit;
}
?>

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
    <main class="view_enquiry_main">
        <h1 class="view_enquiry_title">Membership List</h1>

        <table class="jobapp-table enquiry-table">
            <tr>
                <th>No</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Username</th>
                <th>Password</th>
                <th>Registration Date</th>
                <th>Option</th>
            </tr>

            <?php
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "brew&go_db";

            $conn = mysqli_connect($servername, $username, $password, $dbname);

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
                        <td><?php echo htmlspecialchars($row["username"]); ?></td>
                        <td><?php echo htmlspecialchars($row["password"]); ?></td>
                        <td><?php echo htmlspecialchars($row["reg_date"]); ?></td>
                        <td>
                            <a href="member_form.php?id=<?php echo $row['id']; ?>">Edit</a> |
                            <a href="member_delete.php?id=<?php echo $row['id']; ?>"
                                onclick="return confirm('Are you sure to delete this member?');">Delete</a>
                        </td>
                    </tr>   
            <?php
                }
            } else {
                echo "<tr><td colspan='6'>0 results</td></tr>";
            }

            
            ?>
        </table>
        <p><a href="member_form.php" class="add-member-button responsive-hover-button">+ Add New Member</a></p>
        <?php include("inc/scroll_to_top_button.inc"); ?>
    </main>
    
    <?php include("inc/footer.inc"); 
    mysqli_close($conn);
    ?>
    
</body>

</html>
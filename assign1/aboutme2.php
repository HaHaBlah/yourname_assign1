<!--Patrick Profile-->
<!DOCTYPE html>
<html lang="en">

<!-- Automatically initialise database -->
<?php include("inc/database_connection.inc"); ?>

<!-- Check if user/ admin has logged in -->
<!-- If admin, then show admin logo -->
<?php include("inc/login_status.inc"); ?>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>About Me - Patrick</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="images/Brew&Go_logo.png" type="image/png">
    <link rel="stylesheet" href="styles/style.css">
</head>

<body>
    <?php include("inc/top_navigation_bar.inc"); ?>

    <main class="profile">
        <img class="profilepicture profile-pic" src="images/Patrick_Lip_Siang_SIM.jpg" alt="Patrick's Profile Picture">
        <h1>Patrick Lip Siang SIM</h1>
        <h2 id="student_id">104393720</h2>
        <h2>Bachelor of Computer Science</h2>

        <table class="profiletable">
            <thead>
                <tr>
                    <th>Category</th>
                    <th>Details</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Age</td>
                    <td>19</td>
                </tr>
                <tr>
                    <td>Demographic Information</td>
                    <td>As of 2025, I am 19 years old.</td>
                </tr>
                <tr>
                    <td>My Hometown</td>
                    <td>I am from Kuching, a city in Sarawak. It rains every day here. Especially during the rainy
                        season from September to February.</td>
                </tr>
                <tr>
                    <td>My Achievements</td>
                    <td>
                        I am an Administrator for the <a href="https://ronroblox.fandom.com/wiki/User:HaHaBlah">Rise of
                            Nations
                            wiki</a>.
                    </td>
                </tr>
                <tr>
                    <td>Favourite Music</td>
                    <td>
                        <p>NEFFEX - Careless</p>
                        <audio controls>
                            <source src="audio/NEFFEX.mp3" type="audio/mpeg">
                        </audio>
                        <p>Vicetone - Nevada</p>
                        <audio controls>
                            <source src="audio/Vicetone.mp3" type="audio/mpeg">
                        </audio>
                        <p>Vanic - Somedays</p>
                        <audio controls>
                            <source src="audio/Vanic.mp3" type="audio/mpeg">
                        </audio>
                        <p>Panda Eyes - Colorblind</p>
                        <audio controls>
                            <source src="audio/Panda_Eyes.mp3" type="audio/mpeg">
                        </audio>
                        <p>Stratus - I Wonder How It'll End</p>
                        <audio controls>
                            <source src="audio/Stratus.mp3" type="audio/mpeg">
                        </audio>
                    </td>
                </tr>
            </tbody>
        </table>
    </main>
    
    <?php include("inc/scroll_to_top_button.inc"); ?>

    <footer>
        <div class="footer-container">
            <form action="mailto:104393720@students.swinburne.edu.my" method="post" enctype="text/plain">
                <button type="submit">Email Me</button>
            </form>
            <?php include("inc/footer.inc"); ?>
        </div>
    </footer>
</body>

</html>
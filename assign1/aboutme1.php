<!--Kelvin Profile-->
<!DOCTYPE html>
<html lang="en">

<!-- Automatically initialise database -->
<?php include("inc/database_connection.inc"); ?>

<!-- Check if user/ admin has logged in -->
<!-- If admin, then show admin logo -->
<?php include("inc/login_status.inc"); ?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Page</title>
    <link rel="icon" href="images/Brew&Go_logo.png" type="image/png">
    <link rel="stylesheet" href="styles/style.css">
</head>

<body>
    <?php include("inc/top_navigation_bar.inc"); ?>
    <main class="profile">
        <img class="profilepicture profile-pic" src="images/Kelvin_Lau_Sze_Hoon.jpg" alt="Kelvin's Profile Picture">
        <h1>Kelvin Lau Sze Hoon</h1>
        <h2 id="student_id">104391559</h2>
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
                    <td>My name is Kelvin Lau Sze Hoon. I am from Kuching, Sarawak, Malaysia. I am 19 years old and
                        currently
                        pursuing studies in computer science. I grew up in Kuching, a city known for its rich cultural
                        heritage
                        and strong sense of community.I speak English, Mandarin & Malay and enjoy learning about
                        technology,
                        microelectronics, and innovation. My academic interests align with my passion for semiconductor
                        development and computing, which I hope to pursue in the future.</td>
                </tr>
                <tr>
                    <td>My Hometown</td>
                    <td>Kuching is the capital city of Sarawak, located on the island of Borneo, Malaysia. Known as the
                        "City of
                        Cats," it is famous for its rich cultural heritage, diverse communities, and delicious local
                        cuisine
                        like Sarawak Laksa and Kolo Mee. The city is home to scenic spots such as the Kuching Waterfront
                        and
                        Bako National Park, offering a mix of modern development and natural beauty.</td>
                </tr>
                <tr>
                    <td>My Achievements</td>
                    <td>My greatest achievement so far is completing my foundation in computer science, where I
                        developed strong
                        problem-solving skills and a passion for microelectronics.Additionally, I have worked on
                        projects that
                        challenged me to apply my knowledge in real-world scenarios, further strengthening my confidence
                        in the
                        field.
                    </td>
                </tr>
                <tr>
                    <td>Favourite Games</td>
                    <td>
                        <div class="games">
                            <div>
                                <img src="images/mllogo.png" alt="mllogo.png">
                                <span>Mobile Legends: Bang Bang</span>
                            </div>
                            <div>
                                <img src="images/gtavlogo.png" alt="gtavlogo.png">
                                <span>Grand Theft Auto V</span>
                            </div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </main>
    <?php include("inc/scroll_to_top_button.inc"); ?>
    
    <footer>
        <div class="footer-container">
            <form action="mailto:104391559@students.swinburne.edu.my" method="post" enctype="text/plain">
                <button type="submit">Email Me</button>
            </form>
            <?php include("inc/footer.inc"); ?>
        </div>
    </footer>
</body>

</html>
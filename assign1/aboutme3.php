<!--Ricardo's Webpage-->
<!--https://www.youtube.com/watch?v=6egO0WgqYaU-->
<!DOCTYPE html>
<html lang="en">

<!-- Check if user/ admin has logged in -->
<!-- If admin, then show admin logo -->
<?php include("inc/login_status.inc"); ?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/style.css">
    <link rel="icon" href="images/Brew&Go_logo.png" type="image/png">
    <title>About Me - Ricardo</title>
</head>

<body>
    <?php include("inc/top_navigation_bar.inc"); ?>

    <main class="profile">
        <img class="profilepicture profile-pic" src="images/Ricardo.jpg" alt="Ricardo's Profile Picture">
        <h1>Ricardo Zhen Wei CHEW</h1>
        <h2 id="student_id">104392756</h2>
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
                    <td>Home Town</td>
                    <td>Kuching, Sarawak, Malaysia</td>
                </tr>
                <tr>
                    <td>Demographic Information</td>
                    <td>I am from Kuching, Sarawak, Malaysia. I am 19 years old and currently pursuing studies in
                        computer science at Swinburne Sarawak University. I grew up in Kuching, a city known for its
                        rich cultural heritage and strong sense of community. My main language is English while the
                        other language I speak are Chinese and Malay. My academic interests align with my passion for
                        software designing, data analysis and AI.
                    </td>
                </tr>
                <tr>
                    <td>My Hometown</td>
                    <td>Kuching, the capital of Sarawak, Malaysia, is a charming and culturally rich hometown where
                        modernity meets tradition. Known as the "Cat City," it boasts a diverse community, a vibrant
                        food scene with delights like kolo mee and Sarawak laksa, and a laid-back atmosphere. The
                        picturesque Sarawak River, lively waterfront, and surrounding natural wonders such as Bako
                        National Park and Semenggoh Wildlife Centre make it a haven for both city dwellers and nature
                        lovers. With its friendly people, affordable living, and blend of heritage and greenery, Kuching
                        is a warm and welcoming place to call home.</td>
                </tr>
                <tr>
                    <td>My Achievements</td>
                    <td>One of my greatest achievements so far has been performing as a violinist at the prestigious ACG
                        2024 event, an experience that not only showcased my dedication to music but also allowed me to
                        share my passion with a wider audience. The opportunity to be part of such a significant event
                        was both an honor and a testament to my years of practice and commitment to my craft.
                        Additionally, I successfully completed my Foundation studies at Swinburne Sarawak University, a
                        milestone that reflects my academic perseverance and determination. Throughout my time in the
                        program, I developed essential skills, gained valuable knowledge, and prepared myself for the
                        next stage of my academic journey. This accomplishment marks an important step toward my future
                        aspirations and personal growth.</td>
                </tr>
                <tr>
                    <td>Favorite Games</td>
                    <td>I have venture myself in the game community and industry. I’ve explored many different types of
                        games such Call of Duties (COD), Players Unknown Battle Ground, Minecraft and many more. But
                        here’s my favourite games out of all:
                        <div class="games">
                            <div>
                                <img src="images/Genshin_logo.webp" alt="mllogo.png">
                                <span>Genshin Impact</span>
                            </div>
                            <div>
                                <img src="images/Lichess.png" alt="gtavlogo.png">
                                <span>Chess</span>
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
            <form action="mailto:104392756@students.swinburne.edu.my" method="post" enctype="text/plain">
                <button type="submit">Email Me</button>
            </form>
            <?php include("inc/footerbare.inc"); ?>
        </div>
    </footer>
</body>

</html>
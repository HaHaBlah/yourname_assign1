<!--Wei Bao Profile-->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="about us">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="images/Brew&Go_logo.png" type="image/png">
    <link rel="stylesheet" href="styles/style.css">
    <title>About me - Wei Bao</title>
</head>

<body>
    <?php include("inc/top_navigation_bar.inc"); ?>

    <main class="profile">
        <img class="profilepicture profile-pic" src="images/weibao.jpg" alt="Patrick's Profile Picture">
        <h1>Hii Wei Bao</h1>
        <h2 id="student_id">104390572</h2>
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
                    <td>I am from Kuching, Sarawak and I'm 19 years old this year. Of course I am a handsome boy. I am
                        currently pursuing studies in computer science at Swinburne University of Technology Sarawak
                        Campus. I am a native of Kuching as I grew up here. My main language is Chinese while I usually
                        talk with my parents using Fuzhou dialect. My father have own a business whih is welding.</td>
                </tr>
                <tr>
                    <td>My Hometown</td>
                    <td>My hometown used to be Sibu, which is a samll city in Sarawak. It only have two "seasons", which
                        is rainy and sunny. During rainy seasons, it will rain everyday especially from September to
                        February. It has just cause a heavy flood few days ago. It is also a city rich in Chinese
                        cultural atrraction, especially those of the Foochow clan. Besides that, it is also a city full
                        of traditional delicious food such as "kampua" and "kongpia" which almost is the childhood of
                        every Sibu people.</td>
                </tr>
                <tr>
                    <td>My Achievements</td>
                    <td>One of the greatest achievement so far I thing is I have get Black Belt which is the highest
                        level in Taekwando at few years ago. I am really proud of that as it is my dream that I thought
                        I had no chance to reach it since child. Additionally, I have successfully get the highest marks
                        for Maths and Accounting of the whole shcool during my secondary shcool. Not only that, I have
                        also get the first place in class during my SPM trial exam.

                    </td>
                </tr>
                <tr>
                    <td>Favourite Games</td>
                    <td>
                        <div class="games">
                            <div>
                                <img src="images/sekiro.png" alt="sekiro.jpg">
                                <span>Sekiro: Shadows Die Twice</span>
                            </div>
                            <div>
                                <img src="images/product1/Wukong.png" alt="Wukong.png">
                                <span>Black Myth: Wukong</span>
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
            <form action="mailto:104390572@students.swinburne.edu.my" method="post" enctype="text/plain">
                <button type="submit">Email Me</button>
            </form>
            <?php include("inc/footerbare.inc"); ?>
        </div>
    </footer>
</body>

</html>
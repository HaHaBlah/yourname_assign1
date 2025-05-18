<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Enhancements</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="images/Brew&Go_logo.png" type="image/png">
    <link rel="stylesheet" href="styles/style.css">
</head>

<body>
    <?php include("inc/top_navigation_bar.inc"); ?>

    <main class="enhancements">
        <!--Scroll to top-->
        <section>
            <h2>Scroll to Top Button</h2>
            <p>A button that when clicked, scrolls all the way back to the top of the page</p>
            <p>Found on All Pages</p>
            <video src="images/enhancements/Scroll_to_Top_Button.mp4" autoplay loop muted></video>
            <h2>HTML</h2>
            <div class="code">
                <span>
                    &lt;div class="scroll-top"><br>
                    &nbsp;&nbsp;&nbsp;&lt;a class="scroll-top__link" href="#">& #11165;&lt;/a><br>
                    &lt;/div>
                </span>
            </div>
            <h2>CSS</h2>
            <div class="code">
                <span>
                    .scroll-top__link {<br>
                    &nbsp;&nbsp;&nbsp;position: fixed;<br>
                    &nbsp;&nbsp;&nbsp;bottom: 2rem;<br>
                    &nbsp;&nbsp;&nbsp;right: 2rem;<br>
                    &nbsp;&nbsp;&nbsp;text-decoration: none;<br>
                    &nbsp;&nbsp;&nbsp;border-radius: .5rem;<br>
                    &nbsp;&nbsp;&nbsp;background-color: var(--accent-color-1);<br>
                    &nbsp;&nbsp;&nbsp;padding: 0 .5rem;<br>
                    &nbsp;&nbsp;&nbsp;color: white;<br>
                    &nbsp;&nbsp;&nbsp;font-size: 2em;<br>
                    &nbsp;&nbsp;&nbsp;opacity: .5;<br>
                    &nbsp;&nbsp;&nbsp;z-index: 10;<br>
                    &nbsp;&nbsp;&nbsp;transition: opacity 0.1s ease-in-out;<br>
                    }<br>
                    <br>

                    .scroll-top__link:hover {<br>
                    &nbsp;&nbsp;&nbsp;opacity: 1;<br>}
                </span>
            </div>
        </section>
    </main>
    <?php include("inc/scroll_to_top_button.inc"); ?>

    <?php include("inc/footer.inc"); ?>
</body>

</html>
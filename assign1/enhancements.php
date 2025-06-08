<!DOCTYPE html>
<html lang="en">

<!-- Check if user/ admin has logged in -->
<!-- If admin, then show admin logo -->
<?php include("inc/login_status.inc"); ?>

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

        <section>
            <!--Flip card-->
            <h2>Flip card effects</h2>
            <p>When an object was hovered, it will flip</p>
            <video src="images/enhancements/Flipping_cards.mp4" autoplay loop muted></video>
            <h2>HTML</h2>
            <div class="code">
                <span>
                    &lt;div class="location-card-inner"&gt;<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;&lt;div class="location-card-front"&gt;<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;img src="#" alt="Front Image"&gt;<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;&lt;/div&gt;<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;&lt;div class="location-card-back"&gt;<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;a href="https://maps.app.goo.gl/8ap6MykG7yn7rF7A6"&gt;<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;img src="images/location/Location_1.png"
                    alt="Location 1 Back Image"&gt;<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;/a&gt;<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;&lt;/div&gt;<br>
                    &lt;/div&gt;
                </span>
            </div>
            <h2>CSS</h2>
            <div class="code">
                <span>
                    .location-card-inner &#123;<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;position: relative;<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;width: 100%;<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;height: 100%;<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;transition: transform 0.6s;<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;transform-style: preserve-3d;<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;transform: rotateY(180deg);<br>
                    &#125;<br><br>

                    .location-card-front, .location-card-back &#123;<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;position: absolute;<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;width: 100%;<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;height: 100%;<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;-webkit-backface-visibility: hidden;<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;backface-visibility: hidden;<br>
                    &#125;<br><br>

                    .location-card-front &#123;<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;background-color: var(--accent-color-1);<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;color: white;<br>
                    &#125;<br><br>

                    .location-card-back &#123;<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;transform: rotateY(180deg);<br>
                    &#125;<br><br>

                    .location-card img &#123;<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;width: 100%;<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;height: 100%;<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;object-fit: cover;<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;display: block;<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;border-radius: 50%;<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;overflow: hidden;<br>
                    &#125;
                </span>
            </div>
        </section>

        <!--Dropdown Menu-->
        <section>
            <h2>Dropdown Menu</h2>
            <p>A Menu that reveals more options when hovered over</p>
            <p>Found in All Pages at the top navigation bar</p>
            <img src="images/enhancements/Dropdown_Menu.png" alt="Dropdown Menu">
            <h2>HTML</h2>
            <div class="code">
                &lt;div class="Dropdown_Start"> &lt;a href="activities.html">Activities&lt;/a><br>
                &nbsp;&nbsp;&nbsp;&lt;div class="Dropdown_Content"><br>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;ul><br>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;li>&lt;a
                href="Current.html">Current&lt;/a>&lt;/li><br>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;li>&lt;a href="Coming_Soon.html">Coming
                Soon&lt;/a>&lt;/li><br>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;li>&lt;a
                href="Past.html">Past&lt;/a>&lt;/li><br>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;/ul><br>
                &nbsp;&nbsp;&nbsp;&lt;/div><br>
                &lt;/div><br>
            </div>
            <h2>CSS</h2>
            <div class="code">
                .Dropdown_Content {<br>
                &nbsp;&nbsp;&nbsp;display: none;<br>
                }<br><br>
                .Dropdown_Start:hover .Dropdown_Content {<br>
                &nbsp;&nbsp;&nbsp;display: inline-block;<br>
                }
            </div>
        </section>

        <section>
            <!--Color Change when Hover-->
            <h2>Color Change when Hover effect</h2>
            <p>When an object was hovered, it will change color</p>
            <video src="images/enhancements/Color_Change_when_Hover.mp4" autoplay loop muted></video>
            <h2>HTML</h2>
            <div class="code">
                <span>
                    &lt;div class="sci"&gt;<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;&lt;a href="#" target="_blank"&gt;<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;img src="#" alt="Icon"&gt;<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;&lt;/a&gt;<br>
                    &lt;/div&gt;
                </span>
            </div>
            <h2>CSS</h2>
            <div class="code">
                <span>
                    .sci &#123;<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;margin-left: 20px;<br>
                    &#125;<br><br>

                    .sci a &#123;<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;display: inline-flex;<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;padding: 8px;<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;border: 2px solid var(--accent-color-1);<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;border-radius: 50%;<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;font-size: 20px;<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;height: 40px;<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;width: 40px;<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;color: var(--accent-color-1);<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;margin: 0 8px;<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;transition: .25s;<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;box-sizing: border-box;<br>
                    &#125;<br><br>

                    .sci a img &#123;<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;filter: invert(22%) sepia(18%) saturate(1418%) hue-rotate(343deg) brightness(94%)
                    contrast(86%);<br>
                    &#125;<br><br>

                    .sci a:hover &#123;<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;background: var(--accent-color-1);<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;color: #A99175;<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;box-shadow: 0 0 10px var(--accent-color-1);<br>
                    &#125;<br><br>

                    .sci a:hover img &#123;<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;filter: invert(64%) sepia(29%) saturate(331%) hue-rotate(352deg) brightness(87%)
                    contrast(90%);<br>
                    &#125;
                </span>
            </div>
        </section>

        <section>
            <!--Animated conic gradient border--><!--Not yet done-->
            <h2>Animated conic gradient border</h2>
            <p>Moving Border effect around the profile photos</p>
            <video src="images/enhancements/Animated_conic_gradient_border.mp4" autoplay loop muted></video>
            <h2>HTML</h2>
            <div class="code">
                <span>
                    &lt;div class="home-img"&gt;<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;&lt;div class="img-box"&gt;<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;div class="img-item"&gt;<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;img src="#" alt="#"&gt;<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;/div&gt;<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;&lt;/div&gt;<br>
                    &lt;/div&gt;
                </span>
            </div>
            <h2>CSS</h2>
            <div class="code">
                <span>
                    .home-img &#123;<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;flex: 0 0 auto;<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;display: flex;<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;justify-content: flex-end;<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;align-items: center;<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;width: auto;<br>
                    &#125;<br><br>

                    .home-img .img-box &#123;<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;position: relative;<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;width: 32vw;<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;height: 32vw;<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;border-radius: 50%;<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;padding: 5px;<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;display: flex;<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;justify-content: center;<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;align-items: center;<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;overflow: hidden;<br>
                    &#125;<br><br>

                    .home-img .img-box::before,<br>
                    .home-img .img-box::after &#123;<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;content: '';<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;position: absolute;<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;width: 500px;<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;height: 500px;<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;background: conic-gradient(transparent, transparent, transparent, var(--accent-color-1));<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;transform: rotate(0deg);<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;animation: rotate-border 16s linear infinite;<br>
                    &#125;<br><br>

                    .home-img .img-box::after &#123;<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;animation-delay: 8s;<br>
                    &#125;<br><br>

                    @keyframes rotate-border &#123;<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;100% &#123;<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;transform: rotate(360deg);<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;&#125;<br>
                    &#125;<br><br>

                    .home-img .img-box .img-item &#123;<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;position: relative;<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;width: 100%;<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;height: 100%;<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;background: var(--accent-color-1);<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;border-radius: 50%;<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;border: .1px solid var(--accent-color-1);<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;display: flex;<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;justify-content: center;<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;z-index: 1;<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;overflow: hidden;<br>
                    &#125;<br><br>

                    .home-img .img-box .img-item img &#123;<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;position: absolute;<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;top: 1px;<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;display: block;<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;width: 99.7%;<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;object-fit: cover;<br>
                    &#125;
                </span>
            </div>
        </section>

        <!--Embedded Social Media-->
        <section>
            <h2>Embedded Social Media</h2>
            <p>An embedded Facebook document</p>
            <p>Found in all pages at the footer</p>
            <img src="images/enhancements/Embedded_Social_Media.png" alt="Embedded Social Media">
            <h2>HTML</h2>
            <div class="code">
                &lt;iframe class="responsive-hover-img"
                src="https://www.facebook.com/plugins/post.php?href=https%3A%2F%2Fwww.facebook.com%2Fpermalink.php%3Fstory_fbid%3Dpfbid0Ro5XUkWsugqwP6cFKBsd7MWcqumoxyF4wDd8xdPcGCLZK7udVGAtrpvjBrnVUgJSl%26id%3D61554234958482&show_text=true&width=500"
                scrolling="no" allowfullscreen="true"
                allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share">&lt;/iframe>
            </div>
        </section>

        <!--Interactive Hover-->
        <section>
            <h2>Hover Effects 2</h2>
            <p>When hovered over, some elements change appearance</p>
            <p>Found on all pages</p>
            <video src="images/enhancements/Responsive_Hover.mp4" autoplay loop muted></video>
            <h2>CSS</h2>
            <div class="code">
                .responsive-hover:hover {<br>
                &nbsp;&nbsp;&nbsp;transition: var(--transition);<br>
                &nbsp;&nbsp;&nbsp;box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);<br>
                &nbsp;&nbsp;&nbsp;transform: scale(1.01);<br>
                }
            </div>
        </section>

        <!--Responsive webpage resizing-->
        <section>
            <h2>Responsive Webpage Resizing</h2>
            <p>Pages account for different viewport sizes.</p>
            <p>Found on all pages</p>
            <video src="images/enhancements/Responsive_Resizing.mp4" autoplay loop muted></video>
            <h2>CSS</h2>
            <div class="code">
                @media (max-width: 1000px) {<br>
                &nbsp;&nbsp;&nbsp;.product-content {<br>
                &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;width: 45%;<br>
                &nbsp;&nbsp;&nbsp; }<br>
                <br>
                &nbsp;&nbsp;&nbsp;.product-sidebar {<br>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;width: 100%;<br>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;margin-left: 0;<br>
                &nbsp;&nbsp;&nbsp;}<br>
                }
            </div>
        </section>

        <!--Live Input Validation-->
        <section>
            <h2>Live Input Validation</h2>
            <p>When an input is in the wrong format, it will show up red</p>
            <p>Found on <a href="login.html">login.html</a>, <a href="registration.html">registration.html</a>, <a
                    href="enquiry.html">enquiry.html</a> and <a href="joinus_form.html">joinus_form.html</a></p>
            <img src="images/enhancements/Live_Input_Validation.png" alt="Live Input Validation">
            <h2>CSS</h2>
            <div class="code">
                input:user-invalid {<br>
                &nbsp;&nbsp;&nbsp;outline: 2px solid red;<br>
                &nbsp;&nbsp;&nbsp;color: red;<br>
                }
            </div>
        </section>

        <!--Interactive Map-->
        <section>
            <h2>Interactive Map</h2>
            <p>An embedded Google Map document</p>
            <p>Found in <a href="location1.html">location1.html</a> and <a href="location2.html">location2.html</a></p>
            <img src="images/enhancements/Interactive_Map.png" alt="Interactive Map">
            <h2>HTML</h2>
            <div class="code">
                &lt;iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15953.675113405434!2d110.3657563!3d1.5176329!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31fba7003da964cb%3A0xf8d14c19ed1634a4!2sBrew%20and%20Go!5e0!3m2!1sen!2smy!4v1744122746072!5m2!1sen!2smy"
                allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">&lt;/iframe>
            </div>
        </section>

    </main>
    <?php include("inc/scroll_to_top_button.inc"); ?>

    <?php include("inc/footer.inc"); ?>
</body>

</html>
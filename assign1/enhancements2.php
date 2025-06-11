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
    <title>Enhancements2</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="images/Brew&Go_logo.png" type="image/png">
    <link rel="stylesheet" href="styles/style.css">
</head>

<body>
    <?php include("inc/top_navigation_bar.inc"); ?>

    <main class="enhancements">

        <!-- User Management Module -->
        <section>
            <h2>User Management Module</h2>
            <p>Allows admins to view and manage public enquiry. As well as Create, View, Edit and Delete user from the website.</p>
            <p>Uses: <a href="admin_dashboard.php">admin_dashboard.php</a>, <a href="view_enquiry.php">, view_enquiry.php</a>, <a href="reply_enquiry.php">reply_enquiry.php</a>, <a href="view_membership.php">view_membership.php</a>, <a href="member_form.php">member_form.php</a>, <a href="member_save.php">member_save.php</a>, <a href="member_delete.php">member_delete.php</a> and <a href="email_templates.php">email_templates.php</a></p>
            <img src="images/enhancements/User_Management2.png" alt="User Management2">
            <img src="images/enhancements/User_Management.png" alt="User Management">
            <img src="images/enhancements/User_Management5.png" alt="User Management5">  
            <img src="images/enhancements/User_Management6.png" alt="User Management6">          
            <img src="images/enhancements/User_Management3.png" alt="User Management3">
            <img src="images/enhancements/User_Management4.png" alt="User Management4">
            <h2>reply_enquiry.php</h2>
            <div class="code">
                <span>
                    $subject = "Re: Your enquiry at Brew & Go Coffee";<br>
                    $body = get_enquiry_reply_email($to_name, $reply_msg);<br>
                    $headers = "From: Brew & Go <taphahablah@gmail.com>\r\n";<br>
                        $headers .= "Reply-To: taphahablah@gmail.com\r\n";<br>
                        $headers .= "MIME-Version: 1.0\r\n";<br>
                        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";<br>
                        <br>
                        mail($to_email, $subject, $body, $headers)<br>
                </span>
            </div>
            <h2>member_save.php</h2>
            <div class="code">
                <span>
                    $id   = (int)$_POST['id'];<br>
                    $sql  = "UPDATE members<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SET firstname=?, lastname=?, email=?, username=?, password=?<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;WHERE id=?";<br>
                    $stmt = $conn->prepare($sql);<br>
                    $stmt->bind_param("sssssi",<br>
                        &nbsp;&nbsp;&nbsp;$firstname,<br>
                        &nbsp;&nbsp;&nbsp;$lastname,<br>
                        &nbsp;&nbsp;&nbsp;$email,<br>
                        &nbsp;&nbsp;&nbsp;$username,<br>
                        &nbsp;&nbsp;&nbsp;$hashed,<br>
                        &nbsp;&nbsp;&nbsp;$id<br>
                    );
                </span>
            </div>
        </section>

        <!-- Promotion and News Update Module -->
        <section>
            <h2>Promotion and News Update Module</h2>
            <p>This feature allows admins to create, edit/update, and delete the promotion and news from the database.</p>
            <p>Uses: <a href="inc/footer.inc">footer.inc</a> and <a href="edit_update.php">edit_update.php</a></p>
            <img src="images/enhancements/Updates_News.png" alt="Updates and News">
            <img src="images/enhancements/Updates_News2.png" alt="Updates and News">
            <h2>footer.inc</h2>
            <div class="code">
                <span>
                    &lt;h4&gt;Latest Update&lt;/h4&gt;<br>
                    &lt;?php if ($res && $res->num_rows): ?&gt;<br>
                    &nbsp;&nbsp;&nbsp;&lt;?php $u = $res->fetch_assoc(); ?&gt;<br>
                    &nbsp;&nbsp;&nbsp;&lt;div&gt;<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;?php if (!empty($u['update_message'])): ?&gt;<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;p&gt;&lt;?= htmlspecialchars($u['update_message'], ENT_QUOTES) ?&gt;&lt;/p&gt;<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;?php endif; ?&gt;<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;?php if (!empty($u['photofile'])): ?&gt;<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;img src="&lt;?= htmlspecialchars($u['photofile'], ENT_QUOTES) ?&gt;" alt="Update Image"&gt;<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;?php endif; ?&gt;<br>
                    &nbsp;&nbsp;&nbsp;&lt;/div&gt;<br>
                    &lt;?php else: ?&gt;<br>
                    &nbsp;&nbsp;&nbsp;&lt;p&gt;No updates at the moment.&lt;/p&gt;<br>
                    &lt;?php endif; ?&gt;<br>
                    &lt;?php if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true): ?&gt;<br>
                    &nbsp;&nbsp;&nbsp;&lt;div class="update-form"&gt;<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;form action="edit_update.php" method="post" enctype="multipart/form-data"&gt;<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;fieldset&gt;<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;h3&gt;Update Latest News&lt;/h3&gt;<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;textarea placeholder="New Update" id="update_message" name="update_message" required="required"<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;rows="3" cols="40"&gt;&lt;?php echo htmlspecialchars($data['update_message'] ?? ''); ?&gt;&lt;/textarea&gt;&lt;br&gt;<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;label for="FilePhoto"&gt;Image:&lt;/label&gt;<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;input type="file" id="FilePhoto" name="FilePhoto" accept="image/*"&gt;<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;button class="responsive-hover-button" type="submit"&gt;Update Message&lt;/button&gt;<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;button class="responsive-hover-button" type="reset"&gt;Clear Form&lt;/button&gt;<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;/fieldset&gt;<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;/form&gt;<br>
                    &nbsp;&nbsp;&nbsp;&lt;/div&gt;<br>
                    &lt;?php endif; ?&gt;<br>
                </span>
            </div>
        </section>

        <!-- Job Application Module -->
        <section>
            <h2>Job Application Module</h2>
            <p>This feature allows users to submit their resume and photo by uploading the photo into the website.</p>
            <p>Uses: joinus_process.php and view_job.php</p>
            <video src="images/enhancements/Job_Application.mp4" autoplay loop muted></video>
            <h2>joinus_process.php</h2>
            <div class="code">
                <span>
                    $uploadDir = "uploads/";<br>
                    <br>
                    if (!file_exists($uploadDir)) {<br>
                    &nbsp;&nbsp;&nbsp;mkdir($uploadDir, 0777, true);<br>
                    }<br>
                    <br>
                    if (isset($_FILES['CVFile']) && $_FILES['CVFile']['error'] == 0) {<br>
                    &nbsp;&nbsp;&nbsp;$cvTarget = $uploadDir . basename($_FILES['CVFile']['name']);<br>
                    &nbsp;&nbsp;&nbsp;if (move_uploaded_file($_FILES['CVFile']['tmp_name'], $cvTarget)) {<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$cvfile = $cvTarget;<br>
                    &nbsp;&nbsp;&nbsp;} else {<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$uploadOk = false;<br>
                    &nbsp;&nbsp;&nbsp;}<br>
                    }<br>
                    <br>
                    $stmt = $conn->prepare("INSERT INTO jobapp (firstname, lastname, email, phonenumber, streetaddress, citytown, state, postcode, cvfile, photofile) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");<br>
                    $stmt->bind_param("ssssssssss", $firstname, $lastname, $email, $phonenumber, $streetaddress, $citytown, $state, $postcode, $cvfile, $photofile);
                </span>
            </div>
            <h2>view_job.php</h2>
            <div class="code">
                <span>
                    &lt;a href="<?php echo htmlspecialchars($row["cvfile"]); ?>" target="_blank">View&lt;/a>
                </span>
            </div>
        </section>

        <!-- Member Top-up Module -->
        <section>
            <h2>Member Top-up Module</h2>
            <p>This feature allows members to do top up into their accounts.</p>
            <p>Uses: <a href="member_topup.php">member_topup.php</a> and <a href="user_dashboard.php">user_dashboard.php</a></p>
            <img src="images/enhancements/Topup.png" alt="Top Up">
            <img src="images/enhancements/Topup2.png" alt="Top Up2">
            <h2>member_topup.php</h2>
            <div class="code">
                <span>
                    $syncSql = &lt;&lt;&lt;SQL<br>
                    INSERT INTO topup (login_id, email, balance)<br>
                    SELECT username, email, 0<br>
                        &nbsp;&nbsp;&nbsp;FROM members<br>
                    ON DUPLICATE KEY UPDATE<br>
                        &nbsp;&nbsp;&nbsp;email   = VALUES(email)<br>
                    SQL;<br>
                    if (! $conn->query($syncSql)) {<br>
                        &nbsp;&nbsp;&nbsp;die("Error syncing members: " . $conn->error);<br>
                    }<br>
<br>
                    $newBalance = $currentBalance + $amount;<br>
<br>
                    $update = $conn->prepare(<br>
                    "UPDATE topup<br>
                        &nbsp;&nbsp;&nbsp;SET balance           = ?,<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;last_topup_method = ?,<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;last_topup_amount = ?,<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;last_topup_time   = NOW()<br>
                        &nbsp;&nbsp;&nbsp;WHERE login_id = ? AND email = ?"<br>
                    );<br>
                    $update->bind_param("dsdss",<br>
                        &nbsp;&nbsp;&nbsp;$newBalance,<br>
                        &nbsp;&nbsp;&nbsp;$method,<br>
                        &nbsp;&nbsp;&nbsp;$amount,<br>
                        &nbsp;&nbsp;&nbsp;$login_id,<br>
                        &nbsp;&nbsp;&nbsp;$email<br>
                    );
                </span>
            </div>
        </section>

        <!-- Product Search Feature -->
        <section>
            <h2>Product Search Feature</h2>
            <p>This feature allows Website users to search products or services offered based on their preference(s), filters or keyword(s) given by user.</p>
            <p>Uses: <a href="product.php">product.php</a></p>
            <img src="images/enhancements/Product_Search.png" alt="Product Search">
            <h2>product.php</h2>
            <div class="code">
                <span>
                    &lt;?php foreach ($results as $product): ?><br>
                    &nbsp;&nbsp;&nbsp;&lt;?php if (!empty($product['image_url'])): ?><br>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;img src="&lt;?php echo htmlspecialchars($product['image_url']); ?>" alt="&lt;?php echo htmlspecialchars($product['name']); ?>"><br>
                    &nbsp;&nbsp;&nbsp;&lt;?php else: ?><br>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;p>No image available&lt;/p><br>
                    &nbsp;&nbsp;&nbsp;&lt;?php endif; ?><br>
                    &lt;?php endforeach; ?><br>
                </span>
            </div>
        </section>

        <!-- Anti-Spam Feature -->
        <section>
            <h2>Anti-Spam Feature</h2>
            <p>If someone tries to submit a form too many times in a short period, they will be temporarily blocked.</p>
            <p>Uses: <a href="anti_spam_check.php">anti_spam_check.php</a></p>
            <img src="images/enhancements/Anti_Spam.png" alt="Anti-Spam">
            <h2>anti_spam_check.php</h2>
            <div class="code">
                <span>
                    if ($now - $firstAttempt > $WINDOW_SECONDS) {<br>
                    &nbsp;&nbsp;&nbsp;&nbsp$attemptCount = 1;<br>
                    &nbsp;&nbsp;&nbsp;&nbsp$firstAttempt = $now;<br>
                    } else {<br>
                    &nbsp;&nbsp;&nbsp;&nbsp$attemptCount++;<br>
                    }<br>
                    <br>
                    if ($attemptCount > $MAX_IN_WINDOW) {<br>
                    &nbsp;&nbsp;&nbsp;&nbsp$blockedUntil = $now + $BLOCK_DURATION;<br>
                    }
                    <br>
                    if ($now < $blockedUntil) {<br>
                        &nbsp;&nbsp;&nbsp;&nbsp$secsLeft = $blockedUntil - $now;<br>
                        &nbsp;&nbsp;&nbsp;&nbspshow_antispam_page();<br>
                        }
                </span>
            </div>
        </section>

        <!-- Email Verification Module -->
        <section>
            <h2>Email Verification Module</h2>
            <p>User emails are verified by sending them an email with a link to click. Only verified users are able to login.</p>
            <p>Uses: <a href="membership_process.php">membership_process.php</a>, <a href="verification_email.php">verification_email.php</a>, <a href="verify_email.php">verify_email.php</a>. This also requires editing xampp's sendmail.ini and php.ini files locally.</p>
            <img src="images/enhancements/Email_Verification.png" alt="Email Verification">
            <img src="images/enhancements/Email_Verification2.png" alt="Email Verification2">
            <h2>membership_process.php</h2>
            <div class="code">
                <span>
                    $sql = "CREATE TABLE IF NOT EXISTS members (<br>
                    &nbsp;&nbsp;&nbsp;firstname VARCHAR(25) NOT NULL,<br>
                    &nbsp;&nbsp;&nbsp;email VARCHAR(50) NOT NULL,<br>
                    &nbsp;&nbsp;&nbsp;reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,<br>
                    &nbsp;&nbsp;&nbsp;email_verified TINYINT(1) DEFAULT 0,<br>
                    &nbsp;&nbsp;&nbsp;verification_token VARCHAR(64),<br>
                    &nbsp;&nbsp;&nbsp;verification_expires DATETIME,<br>
                    )";<br>
                    <br>
                    if ($stmt->execute()) {<br>
                    &nbsp;&nbsp;&nbsp;$verify_link = "http://{$_SERVER['HTTP_HOST']}/yourname_assign1/assign1/verify_email.php?token=$token";<br>
                    &nbsp;&nbsp;&nbsp;$subject = "Verify your Brew & Go Coffee Membership";<br>
                    &nbsp;&nbsp;&nbsp;$message = get_verification_email($firstname, $verify_link);<br>
                    &nbsp;&nbsp;&nbsp;$headers = "MIME-Version: 1.0" . "\r\n";<br>
                    &nbsp;&nbsp;&nbsp;$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";<br>
                    &nbsp;&nbsp;&nbsp;$headers .= "From: brewngo.coffee@gmail.com" . "\r\n";<br>
                    <br>
                    &nbsp;&nbsp;&nbsp;mail($email, $subject, $message, $headers);<br>
                </span>
            </div>
            <h2>verification_email.php</h2>
            <div class="code">
                <span>
                    &lt;a href="$verify_link">Verify Email&lt;/a>
                </span>
            </div>
        </section>

        <!-- User Dashboard -->
        <section>
            <h2>User Dashboard</h2>
            <p>This is the user dashboard where users can view their profile information and edit it.</p>
            <p>Uses: <a href="user_dashboard.php">user_dashboard.php</a></p>
            <img src="images/enhancements/User_Dashboard.png" alt="User Dashboard">
            <h2>user_dashboard.php</h2>
            <div class="code">
                <span>
                    $stmt = $conn->prepare("SELECT id, firstname, lastname, email, username, role, phonenumber FROM members WHERE username = ? AND email_verified = 1");<br>
                    $stmt->bind_param("s", $username);<br>
                    $stmt->execute();<br>
                    $result = $stmt->get_result();<br>
                    if ($result->num_rows === 1) {<br>
                        &nbsp;&nbsp;&nbsp;$userInfo = $result->fetch_assoc();<br>
                        &nbsp;&nbsp;&nbsp;$_SESSION['user_id'] = $userInfo['id'];<br>
                    } else {<br>
                        &nbsp;&nbsp;&nbsp;header("Location: login.php");<br>
                        &nbsp;&nbsp;&nbsp;exit();<br>
                    }<br>
                    $stmt->close();<br>
<br>
                    $user_id = $_SESSION['user_id'];<br>
                    $addressInfo = [];<br>
                    $creditBalance = 0;<br>
                    $successMsg = '';<br>
                    $errorMsg = '';<br>
<br>
                    // Fetch address info from new addresses table<br>
                    $stmt = $conn->prepare("SELECT * FROM members WHERE id = ?");<br>
                    $stmt->bind_param("i", $user_id);<br>
                    $stmt->execute();<br>
                    $result = $stmt->get_result();<br>
                    if ($result->num_rows > 0) {<br>
                        &nbsp;&nbsp;&nbsp;$addressInfo = $result->fetch_assoc();<br>
                    }<br>
                    $stmt->close();<br>
<br>
                    // Fetch credit balance<br>
                    $stmt = $conn->prepare("SELECT balance FROM topup WHERE login_id = ?");<br>
                    $stmt->bind_param("s", $username);<br>
                    $stmt->execute();<br>
                    $result = $stmt->get_result();<br>
                    if ($result->num_rows > 0) {<br>
                        &nbsp;&nbsp;&nbsp;$creditData = $result->fetch_assoc();<br>
                        &nbsp;&nbsp;&nbsp;$creditBalance = $creditData['balance'];<br>
                    }<br>
                    $stmt->close();<br>
<br>
                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {<br>
                        &nbsp;&nbsp;&nbsp;if (isset($_POST['update_personal'])) {<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$firstname = htmlspecialchars(trim($_POST['firstname']));<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$lastname = htmlspecialchars(trim($_POST['lastname']));<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$email = htmlspecialchars(trim($_POST['email']));<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$phonenumber = htmlspecialchars(trim($_POST['phonenumber']));<br>
<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$stmt = $conn->prepare("UPDATE members SET firstname = ?, lastname = ?, email = ?, phonenumber = ? WHERE id = ?");<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$stmt->bind_param("ssssi", $firstname, $lastname, $email, $phonenumber, $user_id);<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;if ($stmt->execute()) {<br>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$successMsg = "Personal information updated successfully!";<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;} else {<br>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$errorMsg = "Error updating personal information: " . $stmt->error;<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;}<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$stmt->close();<br>
                        &nbsp;&nbsp;&nbsp;}<br>
<br>
                        &nbsp;&nbsp;&nbsp;if (isset($_POST['update_address'])) {<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$streetaddress = htmlspecialchars(trim($_POST['streetaddress']));<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$citytown = htmlspecialchars(trim($_POST['citytown']));<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$state = htmlspecialchars(trim($_POST['state']));<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$postcode = htmlspecialchars(trim($_POST['postcode']));<br>
<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;if (!empty($addressInfo)) {<br>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$stmt = $conn->prepare("UPDATE members SET streetaddress = ?, citytown = ?, state = ?, postcode = ? WHERE id = ?");<br>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$stmt->bind_param("ssssi", $streetaddress, $citytown, $state, $postcode, $user_id);<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;} else {<br>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$stmt = $conn->prepare("INSERT INTO members (id, streetaddress, citytown, state, postcode) VALUES (?, ?, ?, ?, ?)");<br>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$stmt->bind_param("issss", $user_id, $streetaddress, $citytown, $state, $postcode);<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;}<br>
<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;if ($stmt->execute()) {<br>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$successMsg = empty($addressInfo) ? "Address added successfully!" : "Address updated successfully!";<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;} else {<br>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$errorMsg = "Error saving address: " . $stmt->error;<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;}<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$stmt->close();<br>
                        &nbsp;&nbsp;&nbsp;}<br>
<br>
                    }<br>
<br>
                    $conn->close();
                </span>
            </div>
            <h2>verification_email.php</h2>
            <div class="code">
                <span>
                    &lt;a href="$verify_link">Verify Email&lt;/a>
                </span>
            </div>
        </section>
    </main>
    <?php include("inc/scroll_to_top_button.inc"); ?>

    <?php include("inc/footer.inc"); ?>
</body>

</html>
<?php
function get_password_reset_email($firstname, $reset_link) {
    $logo_url = "http://{$_SERVER['HTTP_HOST']}/yourname_assign1/assign1/images/Brew&Go_logo.png";
    return <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Reset your Brew & Go Coffee password">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="https://i.imgur.com/n70wcbN.png" type="image/png">
    <title>Reset Your Brew & Go Coffee Password</title>
</head>
<body style="margin:0;padding:0;background:#f4f4f4;">
    <table width="100%" bgcolor="#f4f4f4" cellpadding="0" cellspacing="0" style="min-width:348px;">
        <tr>
            <td align="center">
                <table width="100%" style="max-width:600px;margin:40px auto;background:#fff;border-radius:8px;box-shadow:0 2px 8px rgba(0,0,0,0.08);">
                    <tr>
                        <td align="center" style="padding:40px 20px 20px 20px;">
                            <a href="http://{$_SERVER['HTTP_HOST']}/yourname_assign1/assign1/index.php"><img src="https://i.imgur.com/n70wcbN.png" height="74" alt="Brew & Go Coffee" style="margin-bottom:16px;"></a>
                            <h1 style="font-family:'Poppins',Arial,sans-serif;font-size:24px;color:#593C26;margin:0 0 16px 0;">Reset Your Password</h1>
                            <p style="font-family:'Arial',sans-serif;font-size:16px;color:#333;margin:0 0 24px 0;">
                                Hi <strong>$firstname</strong>,<br><br>
                                We received a request to reset your Brew & Go Coffee password.<br>
                                Click the button below to reset your password.
                            </p>
                            <a href="$reset_link" style="display:inline-block;padding:16px 32px;background-color:#593C26;color:#fff;text-decoration:none;border-radius:8px;font-weight:bold;font-size:18px;margin:24px 0 16px 0;transition:background 0.3s;">Reset Password</a>
                            <p style="font-family:'Arial',sans-serif;font-size:14px;color:#888;margin:24px 0 0 0;">
                                If you did not request a password reset, please ignore this email.<br>
                                <span style="color:#b0b0b0;">&copy; 2025 Brew & Go Coffee</span>
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
HTML;
}

function get_enquiry_reply_email($firstname, $reply_msg) {
    $logo_url = "http://{$_SERVER['HTTP_HOST']}/yourname_assign1/assign1/images/Brew&Go_logo.png";
    $safe_msg = nl2br(htmlspecialchars($reply_msg));
    return <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Reply from Brew & Go Coffee">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="https://i.imgur.com/n70wcbN.png" type="image/png">
    <title>Your Brew & Go Coffee Enquiry</title>
</head>
<body style="margin:0;padding:0;background:#f4f4f4;">
    <table width="100%" bgcolor="#f4f4f4" cellpadding="0" cellspacing="0" style="min-width:348px;">
        <tr>
            <td align="center">
                <table width="100%" style="max-width:600px;margin:40px auto;background:#fff;border-radius:8px;box-shadow:0 2px 8px rgba(0,0,0,0.08);">
                    <tr>
                        <td align="center" style="padding:40px 20px 20px 20px;">
                            <a href="http://{$_SERVER['HTTP_HOST']}/yourname_assign1/assign1/index.php"><img src="https://i.imgur.com/n70wcbN.png" height="74" alt="Brew & Go Coffee" style="margin-bottom:16px;"></a>
                            <h1 style="font-family:'Poppins',Arial,sans-serif;font-size:24px;color:#593C26;margin:0 0 16px 0;">Reply to Your Enquiry</h1>
                            <p style="font-family:'Arial',sans-serif;font-size:16px;color:#333;margin:0 0 24px 0;">
                                Hi <strong>$firstname</strong>,<br><br>
                                Thank you for contacting Brew & Go Coffee.<br>
                                Here is our reply to your enquiry:
                            </p>
                            <div style="background:#f9f6f2;border-radius:8px;padding:20px 16px;margin:16px 0 24px 0;font-family:'Arial',sans-serif;font-size:16px;color:#333;text-align:left;">
                                $safe_msg
                            </div>
                            <p style="font-family:'Arial',sans-serif;font-size:14px;color:#888;margin:24px 0 0 0;">
                                If you have further questions, just reply to this email.<br>
                                <span style="color:#b0b0b0;">&copy; 2025 Brew & Go Coffee</span>
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
HTML;
}
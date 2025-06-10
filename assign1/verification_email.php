<?php
function get_verification_email($firstname, $verify_link) {
    $logo_url = "http://{$_SERVER['HTTP_HOST']}/yourname_assign1/assign1/images/Brew&Go_logo.png";
    return <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Verify your Brew & Go Coffee membership">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="https://i.imgur.com/n70wcbN.png" type="image/png">
    <title>Verify Your Brew & Go Coffee Membership</title>
</head>
<body style="margin:0;padding:0;background:#f4f4f4;">
    <table width="100%" bgcolor="#f4f4f4" cellpadding="0" cellspacing="0" style="min-width:348px;">
        <tr>
            <td align="center">
                <table width="100%" style="max-width:600px;margin:40px auto;background:#fff;border-radius:8px;box-shadow:0 2px 8px rgba(0,0,0,0.08);">
                    <tr>
                        <td align="center" style="padding:40px 20px 20px 20px;">
                            <a href="http://{$_SERVER['HTTP_HOST']}/yourname_assign1/assign1/index.php"><img src="https://i.imgur.com/n70wcbN.png" height="74" alt="Brew & Go Coffee" style="margin-bottom:16px;"></a>
                            <h1 style="font-family:'Poppins',Arial,sans-serif;font-size:24px;color:#593C26;margin:0 0 16px 0;">Verify Your Email</h1>
                            <p style="font-family:'Arial',sans-serif;font-size:16px;color:#333;margin:0 0 24px 0;">
                                Hi <strong>$firstname</strong>,<br><br>
                                Thank you for registering with Brew & Go Coffee!<br>
                                Please verify your email by clicking the button below.
                            </p>
                            <a href="$verify_link" style="display:inline-block;padding:16px 32px;background-color:#593C26;color:#fff;text-decoration:none;border-radius:8px;font-weight:bold;font-size:18px;margin:24px 0 16px 0;transition:background 0.3s;">Verify Email</a>
                            <p style="font-family:'Arial',sans-serif;font-size:14px;color:#888;margin:24px 0 0 0;">
                                If you did not register, please ignore this email.<br>
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
?>
<?php
// Landing page for the "Confirm my email address" link.
session_start();
require_once "config.php";

$mmsgOk = confirm_email($link, (string) ($_GET['selector'] ?? ''), (string) ($_GET['validator'] ?? ''));
http_response_code($mmsgOk ? 200 : 400);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Confirm your email - MM's Gaming Community</title>
    <meta name="robots" content="noindex">
    <link rel="stylesheet" type="text/css" href="/footer.css">
</head>
<body style="font-family: Arial; background-color: #38b6ff; margin: 0;">
<div style="max-width: 560px; margin: 60px auto; background: white; border-radius: 16px; padding: 32px 24px; text-align: center;">
<?php if ($mmsgOk) { ?>
    <h1>Email confirmed!</h1>
    <p>Thanks! You can now earn points, comment and use the Store.</p>
    <p><a href="/index.php">Start playing</a></p>
<?php } else { ?>
    <h1>This link didn't work</h1>
    <p>It may have expired (links work for <?php echo VERIFY_LINK_HOURS; ?> hours) or already been used.</p>
    <p>Log in and use <b>Resend the email</b> at the top of the page to get a new link.</p>
    <p><a href="/login.php">Log in</a></p>
<?php } ?>
</div>
</body>
</html>

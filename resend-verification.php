<?php
// "Resend the email" button for players who haven't confirmed their email yet.
session_start();
require_once "config.php";
require_login_post();

$mmsgSent = false;
if (needs_email_verification($link)) {
    $res = db_query($link, 'SELECT Email FROM users WHERE id = ?', [(int) $_SESSION['id']]);
    $row = $res ? mysqli_fetch_assoc($res) : null;
    if ($row) {
        $mmsgSent = send_verification_email($link, (int) $_SESSION['id'], (string) $row['Email']);
    }
}
$mmsgMessage = $mmsgSent
    ? 'We sent you a new confirmation link. Check your email!'
    : 'We could not send another email right now. Please try again in an hour, or check your spam folder for the last one.';
echo '<script type="text/javascript">alert(' . js($mmsgMessage) . ');</script>';
echo '<meta http-equiv="refresh" content="0;url=index.php">';

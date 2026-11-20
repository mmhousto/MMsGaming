<?php
session_start();
require_once "config.php";
require_login_post();

if (needs_email_verification($link)) {
	echo '<script type="text/javascript">alert("Please confirm your email address before using the Store. Check your inbox, or use Resend the email at the top of the page.");</script>';
	echo '<meta http-equiv="refresh" content="1;url=index.php">';
	exit();
}

$result = buy_item($link, (int) $_SESSION['id'], 'ownCursor', 1000);
if ($result === 'ok') {
	$_SESSION['ownCursor'] = 1;
	header("location: index.php");
} else if ($result === 'owned') {
	echo '<script type="text/javascript">alert("Already Own!");</script>';
	echo '<meta http-equiv="refresh" content="1;url=index.php">';
} else {
	echo '<script type="text/javascript">alert("Not enough points!");</script>';
	echo '<meta http-equiv="refresh" content="1;url=index.php">';
}
exit();

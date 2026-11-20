<?php
session_start();
require_once "config.php";
require_login_post();

$result = buy_item($link, (int) $_SESSION['id'], 'ownBg', 2500);
if ($result === 'ok') {
	$_SESSION['ownBg'] = 1;
	header("location: index.php");
} else if ($result === 'owned') {
	echo '<script type="text/javascript">alert("Already Own!");</script>';
	echo '<meta http-equiv="refresh" content="1;url=index.php">';
} else {
	echo '<script type="text/javascript">alert("Not enough points!");</script>';
	echo '<meta http-equiv="refresh" content="1;url=index.php">';
}
exit();

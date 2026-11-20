<?php
session_start();
require_once "config.php";
require_login_post();

$id = (int) $_SESSION['id'];
$owned = 0;
$res = db_query($link, "SELECT ownFont FROM custom WHERE UID = ?", [$id]);
if ($res && ($row = mysqli_fetch_assoc($res))) {
	$owned = (int) $row['ownFont'];
}

if ($owned !== 1) {
	echo '<script type="text/javascript">alert("You Do Not Own Fonts, keep earning points!");</script>';
	echo '<meta http-equiv="refresh" content="1;url=index.php">';
	exit();
}

$value = safe_font_name($_POST['myFont'] ?? '');
if ($value === null) {
	echo '<script type="text/javascript">alert("Please enter a font name like Arial or Comic Sans MS.");</script>';
	echo '<meta http-equiv="refresh" content="1;url=index.php">';
	exit();
}

db_query($link, "UPDATE custom SET Font = ? WHERE UID = ?", [$value, $id]) or die('Error querying database.');
header("location: index.php");
exit();

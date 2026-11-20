<?php
session_start();
require_once "config.php";
require_login_post();

$id = (int) $_SESSION['id'];
$owned = 0;
$res = db_query($link, "SELECT ownBg FROM custom WHERE UID = ?", [$id]);
if ($res && ($row = mysqli_fetch_assoc($res))) {
	$owned = (int) $row['ownBg'];
}

if ($owned !== 1) {
	echo '<script type="text/javascript">alert("You Do Not Own Background Color!");</script>';
	echo '<meta http-equiv="refresh" content="1;url=index.php">';
	exit();
}

$value = safe_css_color($_POST['box2'] ?? '');
if ($value === null) {
	echo '<script type="text/javascript">alert("Please enter a color like red or #ff0000.");</script>';
	echo '<meta http-equiv="refresh" content="1;url=index.php">';
	exit();
}

db_query($link, "UPDATE custom SET BgColor = ?, lastSet = 'Background' WHERE UID = ?", [$value, $id]) or die('Error querying database.');
header("location: index.php");
exit();

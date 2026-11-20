<?php
session_start();
require_once "config.php";
require_login_post();

$id = (int) $_SESSION['id'];
$owned = 0;
$res = db_query($link, "SELECT ownImg FROM custom WHERE UID = ?", [$id]);
if ($res && ($row = mysqli_fetch_assoc($res))) {
	$owned = (int) $row['ownImg'];
}

if ($owned !== 1) {
	echo '<script type="text/javascript">alert("You Do Not Own Background Image, get GOOD!");</script>';
	echo '<meta http-equiv="refresh" content="1;url=index.php">';
	exit();
}

$value = safe_image_url($_POST['image'] ?? '');
if ($value === null) {
	echo '<script type="text/javascript">alert("Please enter an https:// image link.");</script>';
	echo '<meta http-equiv="refresh" content="1;url=index.php">';
	exit();
}

db_query($link, "UPDATE custom SET BgImg = ?, lastSet = 'Image' WHERE UID = ?", [$value, $id]) or die('Error querying database.');
header("location: index.php");
exit();

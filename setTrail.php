<?php
session_start();
require_once "config.php";
require_login_post();

$id = (int) $_SESSION['id'];
$owned = 0;
$res = db_query($link, "SELECT ownTrail FROM custom WHERE UID = ?", [$id]);
if ($res && ($row = mysqli_fetch_assoc($res))) {
	$owned = (int) $row['ownTrail'];
}

if ($owned !== 1) {
	echo '<script type="text/javascript">alert("You Do Not Own the Circle Trail!");</script>';
	echo '<meta http-equiv="refresh" content="1;url=index.php">';
	exit();
}

$value = safe_css_color($_POST['color'] ?? '');
if ($value === null) {
	echo '<script type="text/javascript">alert("Please enter a color like red or #ff0000.");</script>';
	echo '<meta http-equiv="refresh" content="1;url=index.php">';
	exit();
}

db_query($link, "UPDATE custom SET Trail = ? WHERE UID = ?", [$value, $id]) or die('Error querying database.');
header("location: index.php");
exit();

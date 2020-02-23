<?php
    session_start(); 
    require_once "config.php";

    $username = $_SESSION['username'];
    $cursor = $_SESSION['CursorC'];   
    $id = $_SESSION['id'];
	$ownCursor = $_SESSION['ownCursor'];

$oc = "SELECT ownCursor FROM custom WHERE UID = '$id'";
$result2 = mysqli_query($link, $oc);
while($row = mysqli_fetch_assoc($result2)) {
	$ownCursor = $row["ownCursor"];
}
if ($ownCursor == 1) {
$sql = "UPDATE custom SET CursorC = '$_POST[cursorC]' WHERE UID = '$id'";
mysqli_query($link, $sql) or die('Error querying database.');
header("location: index.php");
} else {
	echo '<script type="text/javascript"> alert("You Do Not Own Custom Cursors, get GOOD!"); </script>';
	echo '<meta http-equiv="refresh" content="1;url=index.php">';
}

?>
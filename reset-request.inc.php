<?php 

if(isset($_POST["forgot-password"])){
	
	$selector = bin2hex(random_bytes(8));
	$token = random_bytes(32);
	
	$url = "https://mms-gaming.com/create-new-password.php?selector=$selector&validator=".bin2hex($token);
	
	$expires = date("U") + 1800;
	
	require_once 'config.php';
		
	$userEmail = $_POST["user-email"];
	
	$sql1 = "SELECT * from users WHERE Email ='$userEmail'";
	$result = mysqli_query($link, $sql1);
	if(mysqli_num_rows($result)>0){
	
	$sql = "DELETE FROM pwdReset WHERE pwdResetEmail=?;";
	$stmt = mysqli_stmt_init($link);
	if (!mysqli_stmt_prepare($stmt, $sql)) {
	    echo "There was an error!";
	    exit();
	} else {
	    mysqli_stmt_bind_param($stmt, "s", $userEmail);
	    mysqli_stmt_execute($stmt);
	}

	$sql = "INSERT INTO pwdReset (pwdResetEmail, pwdResetSelector, pwdResetToken, pwdResetExpires) VALUES (?, ?, ?, ?);";
	$stmt = mysqli_stmt_init($link);
	if (!mysqli_stmt_prepare($stmt, $sql)) {
	    echo "There was an error!";
	    exit();
	} else {
	    $hashedToken = password_hash($token, PASSWORD_DEFAULT);
	    mysqli_stmt_bind_param($stmt, "ssss", $userEmail, $selector, $hashedToken, $expires);
	    mysqli_stmt_execute($stmt);
	}
	
	mysqli_stmt_close($stmt);
	mysqli_close($link);
	
	$to = $userEmail;
	
	$subject = "Reset your password for MM's Gamming Co.";
	
	$message = '<p>We received a password reset request. The link to reset your password is below. If you did not make this request, you can ignore this email.</p>';
	$message .= '<p><a href="'.$url.'">Here is your link to reset your password</a></p>';
	
	$headers = "From: MM's Gaming Co <morgan.houston@mms-gaming.com>\r\n";
	$headers .= "Reply-To: morgan.houston@mms-gaming.com\r\n";
	$headers .= "Content-type: text/html\r\n";
	
	mail($to, $subject, $message, $headers);
	header("Location: forgot-password.php?reset=success");
	
	} else {
    header("Location: forgot-password.php?reset=fail");
    }
} else {
	header("Location: index.php");
}
	
	
	
?>
<?php 
require_once "config.php";

if (isset($_POST["reset-password-submit"])) {
    
    $selector = (string) ($_POST["selector"] ?? '');
    $validator = (string) ($_POST["validator"] ?? '');
    // Trimmed like the login form does, so the new password always works there.
    $password = trim((string) ($_POST["pwd"] ?? ''));
    $passwordRepeat = trim((string) ($_POST["pwd-repeat"] ?? ''));

    // On a problem, go back to the form WITH the reset link's codes so the
    // person can simply try again.
    $back = "Location: create-new-password.php?selector=" . urlencode($selector) . "&validator=" . urlencode($validator) . "&newpwd=";
    if (empty($password) || empty($passwordRepeat)) {
        header($back . "empty");
        exit();
    } else if ($password != $passwordRepeat) {
        header($back . "pwdnotsame");
        exit();
    } else if (password_problem($password) !== null) {
        header($back . "weak");
        exit();
    }
    
    $currentDate = date("U");
    
    $sql = "SELECT * FROM pwdReset WHERE pwdResetSelector = ? AND pwdResetExpires >= ?";
    $stmt = mysqli_stmt_init($link);
	if (!mysqli_stmt_prepare($stmt, $sql)) {
	    echo "There was an error!";
	    exit();
	} elseif (mysqli_stmt_prepare($stmt, $sql)) {
	    
	    mysqli_stmt_bind_param($stmt, "ss", $selector, $currentDate);
	    mysqli_stmt_execute($stmt);

            $result = mysqli_stmt_get_result($stmt);
            $row = mysqli_fetch_assoc($result);
	        if($row == null) {
	            echo "You need to re-submit your reset request.";
	            exit();
	        } else {
	        
	        $tokenBin = hex2bin($validator);
	        $tokenCheck = password_verify($tokenBin, $row["pwdResetToken"]);
	        
	        if ($tokenCheck === false) {
	            echo "Token Check fail!";
	            exit();
	        } elseif ($tokenCheck === true) {
	            $tokenEmail = $row['pwdResetEmail'];
	            
	            $sql = "SELECT * FROM users WHERE Email=?;";
	            $stmt = mysqli_stmt_init($link);
            	if (!mysqli_stmt_prepare($stmt, $sql)) {
            	    echo "There was an error!";
            	    exit();
            	} else {
            	    mysqli_stmt_bind_param($stmt, "s", $tokenEmail);
            	    mysqli_stmt_execute($stmt);
            	    $result = mysqli_stmt_get_result($stmt);
            	    if (!$row = mysqli_fetch_assoc($result)) {
            	        echo "There was an error!";
            	        exit();
            	    } else {
            	        
            	        $sql = "UPDATE users SET password=? WHERE Email=?";
            	        $stmt = mysqli_stmt_init($link);
                    	if (!mysqli_stmt_prepare($stmt, $sql)) {
                    	    echo "There was an error!";
                    	    exit();
                    	} else {
                    	    $newPwdHash = password_hash($password, PASSWORD_DEFAULT);
                    	    mysqli_stmt_bind_param($stmt, "ss", $newPwdHash, $tokenEmail);
                    	    mysqli_stmt_execute($stmt);
                    	    
                    	    $sql = "DELETE FROM pwdReset WHERE pwdResetEmail=?;";
                        	$stmt = mysqli_stmt_init($link);
                        	if (!mysqli_stmt_prepare($stmt, $sql)) {
                        	    echo "There was an error!";
                        	    exit();
                        	} else {
                        	    mysqli_stmt_bind_param($stmt, "s", $tokenEmail);
                        	    mysqli_stmt_execute($stmt);
                        	    header("Location: login.php?newpwd=passwordupdated");
                        	}
                    	    
                    	}
            	    }
            	}
	       }
	   }
	}
    
} else {
    header("Location: index.php");
}

?>
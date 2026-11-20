<?php
// Initialize the session
session_start();
 
// Include config file
require_once "config.php";
 

?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" /> <!-- Optimal Internet Explorer compatibility -->
    <title>Can't Remember Passcode for MM's Gaming Co.? [Forgot Password]</title>
    <meta name="description" content="Forgot your password for MM's Gaming Co? Reset it using your email. Change passcode here to something you can remember!">

    <link rel="apple-touch-icon" sizes="180x180" href="apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.png">
    <link rel="manifest" href="site.webmanifest">
    <link rel="stylesheet" href="footer.css">
    <link rel="canonical" href="https://mms-gaming.com/forgot-password.php">

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha256-pasqAKBDmFT4eHoN2ndd6lN370kFiGUFyTiUHWhU7k8=" crossorigin="anonymous"></script>
    
    <script data-ad-client="ca-pub-8251399081266327" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    <script type="text/javascript" src="mouseFollow.js"></script>

    <style type="text/css">

        body {
  background-color: #38b6ff;
  height: 100%;
  font-family: Arial;
  background-image: none;
  overflow: hidden;
}

        .wrapper{ 
    width: 70%;
    padding: 20px;
    font: 14px sans-serif;
    border: solid 2px black;
    border-radius: 25px;
    background-color: white;
    }
    
    .form-control {
        width:50%;
    }
        
        .footer {
            display: block;
            position: fixed;
            left: 0;
            bottom: 0;
            width: 100%;
            background-color: gray;
            color: black;
            padding: 5px;
        }
        .alignLeft {
            float: left;
        }
        .alignRight {
            float: right;
        }
        #gradient {
            background-image: linear-gradient(
                to top right, 
                #a7fbfc, #ff80bd
                );
        }
        
        @media screen and (max-width: 800px) {
            
            .wrapper {width: 80%;}

    .footer {
        display:inline-block;
        height: auto;
    }

    .alignLeft {
        width: 100%;
        display: inline-block;
        justify-contents: center;
        align-items: center;
        text-align: center;
    }
    .alignRight {
        width: 100%;
        display: inline-block;
        justify-contents: center;
        align-items: center;
        text-align: center;
    }
}

input[type=text], input[type=password] {
    outline: none;
    background-color: #333;
    color: white;
}

input[type=text]:focus, input[type=password]:focus {
  border: 3px solid white;
  background-color: #333;
    color: white;
}

/* Change Autocomplete styles in Chrome*/
input:-webkit-autofill,
input:-webkit-autofill:hover, 
input:-webkit-autofill:focus,
textarea:-webkit-autofill,
textarea:-webkit-autofill:hover,
textarea:-webkit-autofill:focus,
select:-webkit-autofill,
select:-webkit-autofill:hover,
select:-webkit-autofill:focus {
  border: 1px solid white;
  -webkit-text-fill-color: white;
  -webkit-box-shadow: 0 0 0px 1000px #000 inset;
  transition: background-color 5000s ease-in-out 0s;
}

input::-webkit-credentials-auto-fill-button {
  background-color: white;
}

input::-webkit-credentials-auto-fill-button:hover {
  background-color: #38b6ff;
}

.help-block {
    color: red;
}

.signupsuccess {
    color: lime;
}
    </style>
</head>
<body>

<div id="page-container">
   <div id="content-wrap">
       <br><br><br>
<center>
    <div class="wrapper">
        <h1>Forgot Password for Your Account?</h1>
        <p>Please fill out this form to update your account. You will receive an email with instructions on how to reset the password you forgot.</p>
        <form name="frmForgot" id="frmForgot" action="reset-request.inc.php" method="post">
	<div class="field-group">
		<div><label for="email">Email</label></div>
		<div><input type="text" name="user-email" id="user-email" placeholder="Enter your email..." class="form-control"></div>
	</div>
	<br>
	<div class="field-group">
		<div><button type="submit" name="forgot-password" id="forgot-password" class="form-submit-button">Receive New Password</button></div>
	</div>	
</form>
<?php 
    if(isset($_GET["reset"])) {
        if ($_GET["reset"] == "success") {
            echo '<br><p class="signupsuccess">If an account uses that e-mail, we have sent it a reset link. Check your e-mail!</p>';
        } 
    }
?>
</div>
    </div>  
    </center>
</div>
<?php include __DIR__ . '/templates/footer.php'; ?>
</div>
</body>
</html>
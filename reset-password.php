<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
 
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$new_password = $confirm_password = "";
$current_password_err = $new_password_err = $confirm_password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // The current password is required, so a borrowed or stolen session
    // can't be used to lock the owner out. Wrong guesses count toward the
    // same 15-minute pause as wrong logins.
    $mmsgUser = (string) ($_SESSION["username"] ?? '');
    if (login_blocked($link, $mmsgUser)) {
        $current_password_err = "Too many failed attempts. Please wait 15 minutes and try again.";
    } else {
        $mmsgRow = mysqli_fetch_assoc(db_query($link, "SELECT password FROM users WHERE id = ?", [(int) $_SESSION["id"]]));
        if (!$mmsgRow || !password_verify(trim((string) ($_POST["current_password"] ?? '')), $mmsgRow["password"])) {
            rate_record($link, 'login', $mmsgUser);
            $current_password_err = "Your current password is not correct.";
        }
    }

    // Validate new password
    if(empty(trim($_POST["new_password"]))){
        $new_password_err = "Please enter the new password.";     
    } elseif(($mmsgProblem = password_problem(trim($_POST["new_password"]), (string) ($_SESSION["username"] ?? ''))) !== null){
        $new_password_err = $mmsgProblem;
    } else{
        $new_password = trim($_POST["new_password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm the password.";
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($new_password_err) && ($new_password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
        
    // Check input errors before updating the database
    if(empty($current_password_err) && empty($new_password_err) && empty($confirm_password_err)){
        // Prepare an update statement
        $sql = "UPDATE users SET password = ? WHERE id = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "si", $param_password, $param_id);
            
            // Set parameters
            $param_password = password_hash($new_password, PASSWORD_DEFAULT);
            $param_id = $_SESSION["id"];
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Password updated successfully. Destroy the session, and redirect to login page
                session_destroy();
                header("location: login.php");
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    // (the connection closes by itself at the end; closing it here broke the rest of the page)
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" /> <!-- Optimal Internet Explorer compatibility -->
    <title>Change Passcode for MM's Gaming Co. [Reset Password]</title>
    <meta name="description" content="Reset your password, for MM's Gaming Co, to help protect against hackers. Change Passcode Here!">

    <link rel="apple-touch-icon" sizes="180x180" href="apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.png">
    <link rel="manifest" href="site.webmanifest">
    <link rel="stylesheet" href="footer.css">
    <link rel="canonical" href="https://mms-gaming.com/reset-password.php">

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha256-pasqAKBDmFT4eHoN2ndd6lN370kFiGUFyTiUHWhU7k8=" crossorigin="anonymous"></script>
    
    <script data-ad-client="ca-pub-8251399081266327" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    <script type="text/javascript" src="mouseFollow.js"></script>

    <style type="text/css">

        body {
  background-color: <?php include "loadBg.php";?>;
  height: 100%;
  font-family: Arial;
  background-image: none;
  overflow: hidden;
}
.pointer {
  position: fixed;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  width: 40px;
  height: 40px;
  background: <?php include "loadTrail.php";?>;
  border: 1px solid <?php include "loadTrail.php";?>;
  opacity: 0.4;
  border-radius: 50%;
  pointer-events: none;
  box-sizing: border-box;
}

.pointer1{
  transition: 0.05s;
}

.pointer2{
  transition: 0.10s;
  width: 35px;
  height: 35px;
}

.pointer3{
  transition: 0.15s;
  width: 30px;
  height: 30px;
}

.pointer4{
  transition: 0.20s;
  width: 25px;
  height: 25px;
}

.pointer5{
  transition: 0.25s;
  width: 20px;
  height: 20px;
}
        .wrapper{ 
    width: 600px;
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
    </style>
</head>
<body style="background-color: <?php include "loadBg.php"; ?>;">

<div id="page-container">
   <div id="content-wrap">
       <br><br><br>
<center>
    <div class="wrapper">
        <h1>Reset Password for your account</h1>
        <p>Please fill out this form to reset your password.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"> 
            <div class="form-group <?php echo (!empty($current_password_err)) ? 'has-error' : ''; ?>">
                <label>Current Password</label>
                <input type="password" name="current_password" class="form-control" autocomplete="current-password">
                <span class="help-block"><?php echo e($current_password_err); ?></span>
            </div>
            <div class="form-group <?php echo (!empty($new_password_err)) ? 'has-error' : ''; ?>">
                <label>New Password</label>
                <input type="password" name="new_password" class="form-control" autocomplete="new-password">
                <span class="help-block"><?php echo $new_password_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control">
                <span class="help-block"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <a class="btn btn-link" href="index.php">Cancel</a>
            </div>
        </form>
    </div>  
    </center>
</div>
<?php include __DIR__ . '/templates/footer.php'; ?>
</div>
</body>
</html>
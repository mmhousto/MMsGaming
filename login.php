<?php
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: index.php");
    exit;
}
 
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$points = $totalPoints = $ownTrail = $ownBg = $ownImg = $ownCursor = $ownFont = $isDonor = 0;
$email = $username = $password = $rank = $lastSet = "";
$bgColor = $TrailC = $bgImg = $CursorC = $font = "";
$username_err = $password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Pause logins after too many wrong passwords (per account and per IP)
    if(empty($username_err) && empty($password_err) && login_blocked($link, $username)){
        $password_err = "Too many failed attempts. Please wait 15 minutes and try again, or reset your password.";
    }

    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT id, username, password FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = $username;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            session_regenerate_id(true); // fresh session ID on login (prevents session fixation)
                            rate_clear($link, 'login', $username);
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["Email"] = $email;
                            $_SESSION["username"] = $username; 
                            $_SESSION["totalPoints"] = $totalPoints;
                            $_SESSION["points"] = $points;
                            $_SESSION["rank"] = $rank;
                            $_SESSION["UID"] = $id;
                            $_SESSION["ownTrail"] = $ownTrail;
                            $_SESSION["ownBg"] = $ownBg;
                            $_SESSION["ownImg"] = $ownImg;
                            $_SESSION["ownCursor"] = $ownCursor;
                            $_SESSION["ownFont"] = $ownFont;
                            $_SESSION["lastSet"] = $lastSet;
                            $_SESSION["BgColor"] = $bgColor;
                            $_SESSION["Trail"] = $TrailC;
                            $_SESSION["BgImg"] = $bgImg;
                            $_SESSION["CursorC"] = $CursorC;
                            $_SESSION["Font"] = $font;
                            $_SESSION["Donor"] = $isDonor;  
                            

                                                    
                            
                            // Redirect user to welcome page
                            header("location: index.php");
                        } else{
                            // Same message as an unknown username, so it doesn't reveal which accounts exist
                            rate_record($link, 'login', $username);
                            $password_err = "The username or password you entered was not valid.";
                        }
                    }
                } else{
                    // Same message as a wrong password, so it doesn't reveal which accounts exist
                    rate_record($link, 'login', $username);
                    $password_err = "The username or password you entered was not valid.";
                }
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
    <!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-162871090-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-162871090-1');
</script>


    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" /> <!-- Optimal Internet Explorer compatibility -->
    <title>Login | Free Online Games</title>
    <meta name="description" content="Login or sign up to start earning points playing the best multiplayer games. Then buy items in my custom store to customize the site your way! Free Online Games!">
    <link rel="apple-touch-icon" sizes="180x180" href="apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.png">
    <link rel="manifest" href="site.webmanifest">
    <link rel="canonical" href="https://mms-gaming.com/login.php">
    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    
    <style type="text/css">
        html{
            min-height: 100%;
            margin: 0;
            font-family: Arial;
            overflow: auto;
            }
        body {
            background-color: #38b6ff;
            min-height: 100%;
            position: relative;
            margin: 0;
            font-family: Arial;
            overflow: hidden;
            }
            #page-container {
  position: relative;
  min-height: 100vh;
}

.form-control {
    width: 50%;
}

#content-wrap {
  padding-bottom: 2.5rem;    /* Footer height */
}
.wrapper{ 
    width: 600px;
    padding: 20px;
    font: 14px sans-serif;
    border: solid 2px black;
    border-radius: 25px;
    background-color: white;
    }
    
        .btn-primary {
          color: #fff;
          background-color: #35CD34;
          border-color: #2e6da4;
        }
        .btn-primary:hover {
          color: #fff;
          background-color: #01A800;
          border-color: #204d74;
        }
        
.blue {
  color: #38b6ff;
}

.blue:visited {
  color: #38b6ff;
}

.blue:hover, .blue:active, .blue:focus {
  color: #000000;
}

.footer {
            display: block;
            position: absolute;
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
        
@media screen and (max-width: 1220px) {
    .form-control {
    width: 50%;
    }
}

.bgB {
    width: 65%;
    height: auto;
    background-color: white;
    border: solid black 1px;
    border-radius: 25px;
    padding: 20px;
    margin: 15px;
}
        
@media screen and (max-width: 800px) {

.form-control {
    width: 50%;
}

    .wrapper, .bgB {
        max-width: 80%;
    }

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

    </style>
    
</head>
<body>
    <div id="page-container">
   <div id="content-wrap">
    <center>
     <picture>
            <source srcset="MMsGCoo.webp" type="image/webp">
            <source srcset="MMsGCoo.jp2" type="image/jp2">
	  	    <a href="index.php" ><img src="MMsGCoo.png" alt="The logo of MMs Gaming company, meant to look like a controller and the letters 'MM'" title="MMs Gaming Logo" style="max-width:100%;max-height:300px;" vspace="0"></a>
	     </picture>
    <div class="bgB">
     <h2>Welcome Gamers!</h2>
     <p><font size="+1">Login or register to earn points while you play online games with multiplayer for free!</font></p>
    </div>
    <br>
     <div class="wrapper">
        <h1>Login to Earn Points</h1>
        <p>Please fill in your credentials to login.</p>
                <?php 
    if(($_GET["verify"] ?? '') === "sent") {
        echo '<p class="signupsuccess">Account created! We sent you an email: click the link in it to confirm your address and start earning points.</p>';
    }
    if(isset($_GET["newpwd"])) {
        if ($_GET["newpwd"] == "passwordupdated") {
            echo '<p class="signupsuccess">Your password has been reset!</p>';
        }
    }
?>
        <form class="frm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <input type="hidden" name="points" value="<?php echo $points; ?>">
            <input type="hidden" name="totalPoints" value="<?php echo $totalPoints; ?>">
            <input type="hidden" name="rank" value="<?php echo $rank; ?>">
            <input type="hidden" name="ownTrail" value="<?php echo $ownTrail; ?>">
            <input type="hidden" name="ownBg" value="<?php echo $ownBg; ?>">
            <input type="hidden" name="ownImg" value="<?php echo $ownImg; ?>">
            <input type="hidden" name="ownCursor" value="<?php echo $ownCursor; ?>">
            <input type="hidden" name="lastSet" value="<?php echo $lastSet; ?>">
            <input type="hidden" name="Trail" value="<?php echo $TrailC; ?>">
            <input type="hidden" name="BgColor" value="<?php echo $bgColor; ?>">
            <input type="hidden" name="BgImg" value="<?php echo $bgImg; ?>">
            <input type="hidden" name="CursorC" value="<?php echo $CursorC; ?>">
            <input type="hidden" name="Font" value="<?php echo $font; ?>">
            <input type="hidden" name="Donor" value="<?php echo $isDonor; ?>">
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Username</label>
                <input type="text" name="username" class="form-control" value="<?php echo e($username); ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Password</label>
                <input type="password" name="password" class="form-control">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Login">
            </div>
            <p>Don't have an account? <a class="blue" href="register.php">Sign up now!</a></p><br>
            <p><a class="blue" href="forgot-password.php">Forgot Password?</a></p>
        </form>
     </div>
     <br>
     <div class="bgB">
         <h2> <a class="blue" href="index.php"><strong>Continue to Free Online Games!</strong></a></h2>
     <p>For those of you, whom just want to play games and not earn points while ranking up. Click the header above, but beware you will not be able to customize the site!</p>
     </div>
     <br>
     
    </center> 
    
    </div>
<?php include __DIR__ . '/templates/footer.php'; ?>
</div>

</body>

</html>
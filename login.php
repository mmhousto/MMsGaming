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
$points = $totalPoints = $ownTrail = $ownBg = $ownImg = $ownCursor = $isDonor = 0;
$username = $password = $rank = $lastSet = "";
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
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username; 
                            $_SESSION["totalPoints"] = $totalPoints;
                            $_SESSION["points"] = $points;
                            $_SESSION["rank"] = $rank;
                            $_SESSION["UID"] = $id;
                            $_SESSION["ownTrail"] = $ownTrail;
                            $_SESSION["ownBg"] = $ownBg;
                            $_SESSION["ownImg"] = $ownImg;
                            $_SESSION["ownCursor"] = $ownCursor;
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
                            // Display an error message if password is not valid
                            $password_err = "The password you entered was not valid.";
                        }
                    }
                } else{
                    // Display an error message if username doesn't exist
                    $username_err = "No account found with that username.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" /> <!-- Optimal Internet Explorer compatibility -->
    <title>Login</title>
    <link rel="apple-touch-icon" sizes="180x180" href="apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.png">
    <link rel="manifest" href="site.webmanifest">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    
    <style type="text/css">
        html{
            min-height: 100%;
            margin: 0;
            font-family: Arial;
            }
        body {
            background-color: #38b6ff;
            min-height: 100%;
            position: relative;
            margin: 0;
            font-family: Arial;
            overflow: hidden;
            }
        .wrapper{ 
            width: 350px;
            padding: 20px;
            font: 14px sans-serif;
            border: dashed black 2px; }
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
    </style>
    
</head>
<body>
    <center>
     <img src="MMsGCoo.png" alt="MM Gaming"  height="150" width="400" vspace="10">
     
     <h1>Welcome Gamers!</h1>
     <h3>Login or register to earn points while you play below!</h3>
     <p>For those of you who just want to play games and not earn points while ranking up, Click <a href="index.php">Here</a> to continue to the site!</p>
     <div class="wrapper" border="">
        <h2>Login</h2>
        <p>Please fill in your credentials to login.</p>
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
                <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
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
            <p>Don't have an account? <a href="register.php">Sign up now</a>.</p>
        </form>
     </div>
     <br>
    </center> 
<footer id="gradient" class="footer">
  <span class="alignLeft">MM's Gaming Co © 2019-2020. All Rights Reserved.</span><span class="alignRight"><a href="sitemap.xml">Sitemap</a> | <a href="terms.html">Terms & Conditions</a> | <a href="privacyPolicy.html">Privacy Policy</a> | <a href="contactform.htm">Contact Me!</a></span>
</footer>
</body>
</html>
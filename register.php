<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$rank = "Noob";
$ID = "";
$points = $totalPoints = 0;
$email = $username = $password = $confirm_password = "";
$ownTrail = $ownBg = $ownImg = $ownCursor = $ownFont = "";
$lastSet = $cursor = $font = "";
$username_err = $password_err = $confirm_password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } elseif(!preg_match('/^[A-Za-z0-9_]{3,20}$/', trim($_POST["username"]))){
        $username_err = "Username must be 3-20 letters, numbers or underscores.";
        } else {
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);

                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    $email = trim($_POST["email"]);
    // Validate email
    if (empty($email)) {
        $email_err = "Email is required!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $email_err = "Invalid email format"; // check if e-mail address is well-formed
    } else {
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE Email = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_email);
            
            // Set parameters
            $param_email = trim($_POST["email"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);

                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $email_err = "This E-mail is already in use.";
                } else{
                    $email = trim($_POST["email"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
    
    // Check input errors before inserting in database
    if(empty($username_err) && empty($email_err) && empty($password_err) && empty($confirm_password_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO users (Email, username, password) VALUES (?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sss", $param_email, $param_username, $param_password);
            
            // Set parameters
            $param_email = $email;
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: login.php");
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }

        $sql1 = "UPDATE users SET rank = ? WHERE username = ?";
        db_query($link, $sql1, [$rank, $username]);
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
        $sql2 = "INSERT INTO custom (UID) VALUES (LAST_INSERT_ID())";
        mysqli_query($link, $sql2);

    // Close connection
    mysqli_close($link);
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" /> <!-- Optimal Internet Explorer compatibility -->
    <title>Register | Earn points playing games</title>
    <meta name="description" content="Register to earn points playing online games with multiplayer for free at MM's Gaming Co.">
    <link rel="apple-touch-icon" sizes="180x180" href="apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.png">
    <link rel="manifest" href="site.webmanifest">
    <link rel="canonical" href="https://mms-gaming.com/register.php">
    
 <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    
    <script data-ad-client="ca-pub-8251399081266327" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    
</head>

<style type="text/css">
/* Set height of body and the document to 100% to enable "full page tabs" */
html{
  height: 100%;
  margin: 0;
  font-family: Arial;
  overflow: auto;
}
body {
  background-color: #38b6ff;
  height: 100%;
  margin: 0;
  font-family: Arial;
  overflow: auto;
}

.form-control {
    width: 50%;
    }


.wrapper{ 
    width: 600px;
    padding: 20px;
    font: 14px sans-serif;
    border: solid 2px black;
    border-radius: 25px;
    background-color: white;
    }

input {
    margin: 10px;
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
            #page-container {
  position: relative;
  min-height: 100vh;
}

#content-wrap {
  padding-bottom: 2.5rem;    /* Footer height */
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

.help-block {
    color: red;
}

</style>
<body>
 <div id="page-container">
   <div id="content-wrap">
    <center>
    <picture>
            <source srcset="MMsGCoo.webp" type="image/webp">
            <source srcset="MMsGCoo.jp2" type="image/jp2">
	  	    <a href="index.php" ><img src="MMsGCoo.png" alt="The logo of MMs Gaming company, meant to look like a controller and the letters 'MM'" title="MMs Gaming Logo" style="max-width:100%;max-height:300px;" vspace="0"></a>
	     </picture>
    <br><br>
    <div class="wrapper">
        <h1>Register to Earn Points</h1>
        <p>Please fill out this form to create an account.</p>
        
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" onsubmit="if(document.getElementById('agree').checked) { return true; } else { alert('Please indicate that you have read and agree to the Terms and Conditions'); return false; }" method="post">
            <input type="hidden" name="points" value="<?php echo $points; ?>">
            <input type="hidden" name="totalPoints" value="<?php echo $totalPoints; ?>">
            <input type="hidden" name="rank" value="<?php echo $rank; ?>">
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Username</label>
                <input type="text" name="username" class="form-control" value="<?php echo e($username); ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>  
            <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                <label>Email</label>
                <input type="text" name="email" class="form-control" value="<?php echo e($email); ?>">
                <span class="help-block"><?php echo $email_err; ?></span>
            </div>  
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Password</label>
                <input type="password" name="password" class="form-control" value="<?php echo e($password); ?>">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control" value="<?php echo e($confirm_password); ?>">
                <span class="help-block"><?php echo $confirm_password_err; ?></span>
            </div>
            <input type="checkbox" name="checkbox" value="check" id="agree" /> I have read and agree to the <a class="blue" href="terms.html">Terms and Conditions</a>
            <div class="form-group">
                <input name='register' type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-default" value="Reset">
            </div>
            <p>Already have an account? <a class="blue" href="login.php">Login here</a>.</p>
        </form>
    </div>   
    <br>
    
    <div class="bgB">
        <a class="blue" href="index.php"><h2><strong>Continue to Free Online Gaming!</strong></h2></a>
        <p><font size="+1">Do you just want to play games and not earn points while ranking up? Skip the register and click the header above, but remember you will not be able to customize the site or receive points for playing!</font></p>
    </div>
    <br>
</center>

</div>
<footer id="gradient" class="footer">
  <span class="alignLeft">© 2019-2024 MM's Gaming Community LLC. All Rights Reserved.</span><span class="alignRight"><a href="sitemap.xml">Sitemap</a> | <a href="terms.html">Terms & Conditions</a> | <a href="privacyPolicy.html">Privacy Policy</a> | <a href="contactform.html">Contact Me!</a></span>
</footer>
</div>
</body>
</html>
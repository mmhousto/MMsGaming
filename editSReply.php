<?php 
// Initialize the session
session_start();   
require_once "config.php";
include 'comments.inc.php';

date_default_timezone_set('America/Chicago');


?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1"> <!-- Ensures optimal rendering on mobile devices. -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" /> <!-- Optimal Internet Explorer compatibility -->

    <title>Edit Second Reply to a Post | MM's Gaming Co. [Blog]</title>
    <meta name="description" content="Edit a second reply on a blog post for MM's Gaming Co. Very simple popup window to edit your replies.">
    <link rel="apple-touch-icon" sizes="180x180" href="apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.png">
    <link rel="manifest" href="site.webmanifest">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <link rel="stylesheet" href="basic.css">
    <link rel="canonical" href="https://mms-gaming.com/editSReply.php">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha256-pasqAKBDmFT4eHoN2ndd6lN370kFiGUFyTiUHWhU7k8=" crossorigin="anonymous"></script>
    

</head>

<style type="text/css">

.heading1 {
    width: 100%;
    height: auto;
    display: flex;
    justify-content: center;
    text-align:center;
    top:0;
    left:0;
    padding-bottom: 10px;
}


p, h1, h2, h3, h4, h5, h6 {
  width: 100%;
  line-height: 200%;
}

.bgW {
    width:90%;
    height: auto;
    background-color: #FFC675;
    border: solid black 1px;
    border-radius: 25px;
    padding: 10px;
    margin: 15px;
}


/* Add a card effect for articles */
.card {
  margin: 20px;
  background-color: white;
  padding: 20px;
  border-radius: 5px;
}

.row{
    padding-bottom: 20px;
    width:75%;
}

/* Clear floats after the columns */
.row:after {
  content: "";
  display: table;
  clear: both;
}


h2, h3, h4, h5, h6 {
    margin-top: -10px;
}


@media screen and (max-width: 1222px) {
    
    #heading1 {
        display:flex;
        flex-direction: column-reverse;
    }
    
    #rightHd{
        width: 100%;
    }
    
    #logo{width: 66.6%;float: left;
        display: inline;
        align-items:right;
        justify-content:right;
        text-align:right;}
    #info { width: 50%;}
    
    .info {
        display: block;
        float: none;
        width: 100%;
    }
    .ctrlBtns {
        display: inline;
        float: left;
        width:33.3%;
    }
    
  .col-lg-10{
    column-count:3;
  }

  .col-lg-12{
    column-count:3;
  }
  
  .leftcolumn, .rightcolumn { 
    width: 100%;
    padding: 0;
  }
  
}

@media screen and (max-width: 916px) {
    .ctrlBtns {
        width:45%;
    }
    
    #logo{
        width: 55%;
    }
    
    #info { width: 50%;}
}

@media screen and (max-width: 800px) {
    
    .ctrlBtns {
        width:50%;
    }
    
    #logo{
        width: 50%;
    }
    
    #info { width: 50%;}

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
    
  .col-lg-10{
    column-count:2;
  }

  .col-lg-12{
    column-count:2;
  }
  
}

@media screen and (max-width: 620px) {
    
    #info { width: 50%;}

    .col-lg-10{
    column-count:1;
  }
    
    .col-lg-12{
        column-count:1;
    }
    
    .info {
        width: 100%;
        display: block;
        align-items: baseline;
        text-align: left;
    }
    
    .logo {
        width: 100%;
        left: 50%;
        display: block;
        align-items: center;
        text-align: center;
        vertical-align: left;
    }
    
    .footer {
        display:inline-block;
        height: auto;
    }
    
    .alignLeft {
        width: 100%;
        display: inline-block;
        justify-content: center;
        align-items: center;
        text-align: center;
    }
    .alignRight {
        width: 100%;
        display: inline-block;
        justify-content: center;
        align-items: center;
        text-align: center;
    }
    
}

</style>

<body>

<main id="page-container">
        
   <div id="content-wrap">

<center>
 <div class="row">
    <div class="card">
<?php
    $srid = $_POST['srid'];
    $uid = $_POST['uid'];
    $date = $_POST['date'];
    $message = $_POST['message']; 
        
    echo "<form method='POST' action='".editSReplies($link)."'>
            <input type='hidden' name='srid' value='".e($srid)."'>
            <input type='hidden' name='uid' value='".e($uid)."'>
            <input type='hidden' name='date' value='".e($date)."'>
            <textarea class='myTextArea' name='message'>".e($message)."</textarea><br>
            <button style='width: 100px; height: 30px; font-size: 16px; font-weight: 400; background-color: #333; color: white; border: none; border-radius: 25px; margin-top: 10px;' name='editSRSubmit' type='submit'>Edit</button>
        </form>";
        ?>
    </div>
</div>
</center>

</div>

</div>
<footer id="gradient" class="footer">
  <span class="alignLeft">© 2019-2024 MM's Gaming Community LLC. All Rights Reserved.</span><span class="alignRight"><a href="sitemap.xml">Sitemap</a> | <a href="terms.html">Terms & Conditions</a> | <a href="privacyPolicy.html">Privacy Policy</a> | <a href="contactform.htm">Contact Me!</a></span>
</footer>
</main>

</body>


</html>

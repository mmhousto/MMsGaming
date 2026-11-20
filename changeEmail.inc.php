<?php

require_once "config.php";

if (isset($_POST['emailSubmit'])) {
    
    $id = $_POST['uid'];
    $email = trim($_POST["newEmail"]);
    // Validate email
    if (empty($email)) {
        echo "Email is required!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format"; // check if e-mail address is well-formed
    } else {
    
    $sql = "UPDATE users SET Email = '$email' WHERE id = '$id'";
    $result = mysqli_query($link, $sql);
    
    header ("Location: profile.php?update=success");
    }
}



?>





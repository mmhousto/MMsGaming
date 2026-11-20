<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "config.php";

if (isset($_POST['emailSubmit'])) {
    
    if (!is_logged_in()) {
        header("Location: login.php");
        exit();
    }
    $id = (int) $_SESSION['id']; // never trust a user id sent by the form
    $email = trim($_POST["newEmail"]);
    // Validate email
    if (empty($email)) {
        echo "Email is required!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format"; // check if e-mail address is well-formed
    } else {
    
    $sql = "UPDATE users SET Email = ? WHERE id = ?";
    $result = db_query($link, $sql, [$email, $id]);
    
    header ("Location: profile.php?update=success");
    exit();
    exit();
    }
}



?>





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
    
    $mmsgOld = mysqli_fetch_assoc(db_query($link, "SELECT Email FROM users WHERE id = ?", [$id]));
    $sql = "UPDATE users SET Email = ? WHERE id = ?";
    $result = db_query($link, $sql, [$email, $id]);
    // A new address has to be confirmed again.
    if (verification_ready($link) && strcasecmp((string) ($mmsgOld['Email'] ?? ''), $email) !== 0) {
        db_query($link, "UPDATE users SET email_verified_at = NULL WHERE id = ?", [$id]);
        send_verification_email($link, $id, $email);
    }
    
    header ("Location: profile.php?update=success");
    exit();
    exit();
    }
}



?>





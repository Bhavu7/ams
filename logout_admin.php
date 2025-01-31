<?php
session_start();

if (isset($_POST['logout']) && $_POST['logout'] === 'true') {
    // Destroy the session to log the user out
    session_unset();  // Unset all session variables
    session_destroy();  // Destroy the session

    // Respond with a success message
    echo 'success';
} else {
    // If the request is not valid, show an error
    echo 'error';
}
?>

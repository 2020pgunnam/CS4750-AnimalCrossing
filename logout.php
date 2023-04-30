<?php
// Initialize the session.
// If you are using session_name("something"), don't forget it now!
session_start();
// Unset all of the session variables.
$_SESSION = array();
// If it's desired to kill the session, also delete the session cookie.
// Note: This will destroy the session, and not just the session data!
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}
// Finally, destroy the session.
session_destroy();
header("Location: index.php");
exit;
?>
<!-- // Run the project by following URL:

// http://localhost/google-login-php/login.php
// Also Read : Laravel 9 Sorting Columns with Pagination

// Conclusion
// Today we had learned How to Login with Google in PHP with Google Apis. Hope this tutorial helps you. If you have any trouble with the tutorial you can comment down below.

// Also Read : How to Create a Login Form in PHP Example

// Medium Articles:
// Install ReactJS in Laravel 9 Tutorial
// Codeigniter 3 and AngularJS CRUD with Search and Pagination Tutorial
// PHP Chunk File Upload using JavaScript
// June 15, 2022, Originally published at laraveltuts.com ・8 min read

// PHP
// Google
// Login
// Login With Google
// Php Tutorial
// 4


// 2 -->




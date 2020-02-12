<?php
// Start the session if it has not started
if (!isset($_SESSION)) {
    session_start();
}
$view = new stdClass();
$view->pageTitle = "Forum Natura";
// Set error message empty by default
$view->errorMessage = " ";
require_once("models/Login.php");
$login = new Login();
// Sends you back to the main page if the session for the user has been set
if (isset($_SESSION['username'])) {
    echo '<meta http-equiv="refresh" content="0; URL=index.php">';
}
// Login button and reCaptcha
if (isset($_POST["loginButton"])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
//    If the login details are correct and the Captcha code matches
    if (($login->loginUser($username, $password)) && ($_POST['captchaCode'] === $_SESSION['captcha'])) {
        $_SESSION['username'] = $username;
//    Sends you back to the main page if you have logged in
        echo '<meta http-equiv="refresh" content="0; URL=index.php">';
//    Returns an invalid details error if the password or username are not valid
    } elseif ((preg_match('(SELECT|FROM|DROP|WHERE|TABLE|ADD|ALTER|CHECK|DELETE|DEFAULT|IN|CREATE|COLUMN|CHECK)', strtoupper($username)) >= 2) && (preg_match('(SELECT|FROM|DROP|WHERE|TABLE|ADD|ALTER|CHECK|DELETE|DEFAULT|IN|CREATE|COLUMN|CHECK)', strtoupper($password)) >= 2) && (!preg_match("/^[a-zA-Z0-9]*$/", $username))) {
        $view->errorMessage = "invalidDetails";
//    If the captcha code does not match
    } elseif ($_POST['captchaCode'] != $_SESSION['captcha']) {
        $view->errorMessage = "invalidCode";
    }
}
require_once("views/login.phtml");
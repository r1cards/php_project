<?php
// Start the session if it has not started
if (!isset($_SESSION)) {
    session_start();
}
$view = new stdClass();
$view->pageTitle = "Forum Natura";
require_once("models/Register.php");
$register = new Register();
// Sends you back to the main page if the session for the user has been set
if(isset($_SESSION['username'])){
    echo '<meta http-equiv="refresh" content="0; URL=index.php">';
}
// Set error message to nothing by default
$view->errorMessage = " ";
if (isset($_POST["createUser"])) {
    $date = date('Y/m/d');
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
//    Checks if the username is already in the database
    if ($register->usernameExists($username)) {
        $view->errorMessage = "takenUser";
//    Checks if the passwords match when entered
    } elseif ($password != $_POST['repeatPassword']) {
        $view->errorMessage = "passwordNotMatch";
    } //    Checks if the email is valid
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $view->errorMessage = "notValidEmail";
//    Checks if the username is valid
    } elseif (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
        $view->errorMessage = "invalidUsername";
//        Checks for sql words in the password
    } elseif (preg_match('(SELECT|FROM|DROP|WHERE|TABLE|ADD|ALTER|CHECK|DELETE|DEFAULT|IN|CREATE|COLUMN|CHECK)', strtoupper($password)) >= 2) {
        $view->errorMessage = "invalidPassword";
    } //    Checks if the email is already in use
    elseif ($register->emailExists($email)) {
        $view->errorMessage = "emailTaken";
//    If no errors are present
    } else {
        $view->errorMessage = "none";
        $register->addUser($username, $email, $password, $date);
        echo '<meta http-equiv="refresh" content="0; URL=login.php">';
    }
}
require_once("views/register.phtml");
<?php
// Start the session if it has not started
if (!isset($_SESSION)) {
    session_start();
}
require_once("models/ProfileAction.php");
$view = new stdClass();
$view->pageTitle = "Forum Natura";
// Set error message empty by default
$view->errorMessage = " ";
$profile = new ProfileAction();
if(isset($_GET['user'])){
    $fetchedProfile = $profile->getProfile($_GET['user']);
    if($fetchedProfile!==null){
        $view->profile = $profile->getProfile($_GET['user']);
    }else{
        $view->errorMessage="noUser";
    }
}
require_once("views/profile.phtml");
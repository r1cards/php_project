<?php
require_once "models/PostAction.php";
$view = new stdClass();
$postAction = new PostAction();
// Start the session if it has not started yet
if (!isset($_SESSION)) {
    session_start();
}
$view->pageTitle = "Forum Natura";
// Set error message to nothing by default
$view->errorMessage = '';
// If the delete post from watch list button is pressed
if (isset($_POST['deletePost'])) {
    $postToDelete = $_POST['postToDelete'];
//    Delete the post from the watch list of that user
    $postAction->deleteFromWatchList($_SESSION['username'], $postToDelete);
}
// Logout button
if (isset($_POST['logoutButton'])) {
    unset($_SESSION['username']);
    unset($_SESSION['amount']);
    unset($_SESSION['filter']);
    session_destroy();
    echo '<meta http-equiv="refresh" content="0; URL=index.php">';
}
// Sends you back to the main page if the session for the user has been set
if (!isset($_SESSION['username'])) {
    echo '<meta http-equiv="refresh" content="0; URL=index.php">';
}
// Get the whole watch list
$posts = $postAction->getWatchList($_SESSION['username']);
// Save the posts returned in view
$view->posts = $posts;
require_once "views/watchList.phtml";
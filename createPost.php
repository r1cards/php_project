<?php
// Start a session if it has not been started
if (!isset($_SESSION)) {
    session_start();
}
$view = new stdClass();
$view->pageTitle = "Forum Natura";
require_once("models/PostAction.php");
$postAction = new PostAction();
// Set th error message as empty by default
$view->postError = ' ';
// Sends you back to the main page if the session for the user has not been set
if (!isset($_SESSION['username'])) {
    echo '<meta http-equiv="refresh" content="0; URL=index.php">';
}
// Logout button
if (isset($_POST['logoutButton'])) {
    unset($_SESSION['username']);
    unset($_SESSION['amount']);
    unset($_SESSION['filter']);
    session_destroy();
//    Jump back to the home page
    echo '<meta http-equiv="refresh" content="0; URL=index.php">';
}
// If the create post button is pressed
if (isset($_POST['createPostButton'])) {
//    Get all the values from the fields
    $postAuthor = $_SESSION['username'];
    $title = $_POST['postTitle'];
    $postImage = $postAction->addImageToPost();
    $postContent = $_POST['postContent'];
    $postCategory = $_POST['postCategoryName'];
    $creationDate = date('Y/m/d');
//    Check if the title of the post is correct
    if ((!preg_match("/^[a-zA-Z0-9 ,!?]*$/", $title)) || (preg_match('(SELECT|FROM|DROP|WHERE|TABLE|ADD|ALTER|CHECK|DELETE|DEFAULT|IN|CREATE|COLUMN|CHECK)', strtoupper($title)) >= 2)) {
        $view->postError = 'wrongTitle';
//    Check if the category name is correct
    } elseif ((!preg_match("/^[a-zA-Z0-9 ,!?]*$/", $postCategory)) || (preg_match('(SELECT|FROM|DROP|WHERE|TABLE|ADD|ALTER|CHECK|DELETE|DEFAULT|IN|CREATE|COLUMN|CHECK)', strtoupper($postCategory)) >= 2)) {
        $view->postError = "wrongCategory";
//     Check if the content is valid
    } elseif ((!preg_match("/^[a-zA-Z0-9 ,!?]*$/", $postContent)) || (preg_match('(SELECT|FROM|DROP|WHERE|TABLE|ADD|ALTER|CHECK|DELETE|DEFAULT|IN|CREATE|COLUMN|CHECK)', strtoupper($postContent)) >= 2)) {
        $view->postError = "wrongContent";
    } else {
//      Here we check if there are any errors relating to the file, and depending on what is returned a different message will be displayed in the view
        switch ($postImage) {
            case "fileExists":
                $view->postError = "fileExists";
                break;
            case "fileTooBig" :
                $view->postError = "fileTooBig";
                break;
            case "wrongFileType":
                $view->postError = "wrongFileType";
                break;
            default:
//               A post is created
                $postAction->createPost($postAuthor, $title, $postContent, $postCategory, $creationDate, $postImage);
                $view->postError = 'none';
        }
    }
}
require_once "views/createPost.phtml";
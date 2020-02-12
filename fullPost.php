<?php
// Start the session if it has not started yet
if (!isset($_SESSION)) {
    session_start();
}
require_once("models/PostAction.php");
require_once("models/CommentAction.php");
$view = new stdClass();
$view->pageTitle = "Forum Natura";
$view->errorMessage = '';
$postAction = new PostAction();
$commentAction = new CommentAction();
// Get the post id from the top of the page and save i in a session
if (isset($_GET['postID'])) {
    $_SESSION['currentPostId'] = $_GET['postID'];
}
// Return and save a single post in the view based on the id given
$view->post = $postAction->getPost($_SESSION['currentPostId']);
// Retrieve all comments for a post
$view->comments = $commentAction->getAllComments($_SESSION['currentPostId']);
// If remove post button is pressed
if (isset($_GET['removePost'])) {
//    Here we check the top of the page for a removePost value if it is 1 then that post is deleted we also check if you are the same person who made that post in order to delete it
    if (($_GET['removePost'] == 1) && ($_SESSION['username'] == $view->post->getPostAuthor())) {
        $postAction->removePost($view->post->getPostId());
//    Deletes the image from the images directory
        unlink("images/" . $view->post->getPostImage());
//        Sends you back to the home page
        echo '<meta http-equiv="refresh" content="0; URL=index.php">';
    }
}
// Logout button
if (isset($_POST['logoutButton'])) {
    unset($_SESSION['username']);
    unset($_SESSION['amount']);
    unset($_SESSION['filter']);
    session_destroy();
    // Sends you back to the home page
    echo '<meta http-equiv="refresh" content="0; URL=index.php">';
}
// If remove comment button is pressed
if (isset($_GET['removeComment'])) {
//    Here we save the comment that is needed to be deleted in the view
    $view->comment = $commentAction->getComment($_GET['commentId']);
//    If removeComment is equal to 1 and you are the person who posted the comment it may be deleted
    if (($_GET['removeComment'] == 1) && ($_SESSION['username'] == $view->comment->getCommentUsername())) {
//        Here we removed a comment based on the id given
        $commentAction->removeComment($_GET['commentId']);
//        Sends you back to the fullPost page of that post
        echo '<meta http-equiv="refresh" content="0; URL=fullPost.php">';
    }
}
// If the write comment button is pressed
if (isset($_POST['writeCommentButton'])) {
//    Here we check if the comment text is valid
    if (preg_match("/^[a-zA-Z0-9 !?,.]*$/", $_POST['comment_text'])) {
        $commentText = $_POST['comment_text'];
        $commentDate = date('Y-m-d H:i:s');
        $commentAction->createComment($_SESSION['username'], $_SESSION['currentPostId'], $commentText, $commentDate);
//        Sends ypu back to the full post page
        echo '<meta http-equiv="refresh" content="0; URL=fullPost.php">';
    }
}
// If the add to watch list button is pressed
If (isset($_POST['addWatchListButton'])) {
//    Here we check if the post is not already in the watch list
    if (!$postAction->addedToWatch($_SESSION['username'], $_GET['postID'])) {
        $postAction->addToWatchList($_SESSION['username'], $_GET['postID']);
        $view->errorMessage = "added";
    } else {
        $view->errorMessage = "alreadyAdded";
    }
}
require_once('views/fullPost.phtml');
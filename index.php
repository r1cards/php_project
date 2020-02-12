<?php
// Start the session if it has not started
if (!isset($_SESSION)) {
    session_start();
}
$view = new stdClass();
$view->pageTitle = "Forum Natura";
$view->errorMessage = '';
require_once("models/PostAction.php");
$postAction = new PostAction();
// Here we specify how many posts will be loaded in when website is loaded
if (!isset($_SESSION['amount'])) {
//    Default load value for the amount of posts to load initially
    $_SESSION['amount'] = 20;
}
// If the load more button is pressed
if (isset($_POST['loadMoreButton'])) {
//    How many posts will be added after the button is clicked
    $_SESSION['amount'] += 20;
}
// If a filter option is selected
if (isset($_POST['filterOption'])) {
//    If the session for the filter has not been started, we will create it
    if (!isset($_SESSION['filter'])) {
        $_SESSION['filter'] = $_POST['filterOption'];
    }
}
// This is used for the search feature at the top of the page
if (isset($_POST['searchButton'])) {
//    We save the selected filter option the session
    $_SESSION['filter'] = $_POST['filterOption'];
    if (isset($_POST['searchField'])) {
        $keyword = $_POST['searchField'];
        if (empty($keyword)) {
//          If the search field is empty we set the default search keyword
            $keyword = "";
        }
//        Display the all the posts that match a particular filter option
        if (($_SESSION['filter'] == "n") && (!empty($view->posts = $postAction->getAllPostsByDateNew($_SESSION['amount'], $keyword)))) {
            $view->posts = $postAction->getAllPostsByDateNew($_SESSION['amount'], $keyword);
        } elseif (($_SESSION['filter'] == "o") && (!empty($view->posts = $postAction->getAllPostsByDateOld($_SESSION['amount'], $keyword)))) {
            $view->posts = $postAction->getAllPostsByDateOld($_SESSION['amount'], $keyword);
        } elseif ($_SESSION['filter'] == "a" && (!empty($view->posts = $postAction->getAllPostsAlphabetically($_SESSION['amount'], $keyword)))) {
            $view->posts = $postAction->getAllPostsAlphabetically($_SESSION['amount'], $keyword);
        } else {
//            If no posts have been found
            $view->errorMessage = 'nothingFound';
        }
    }
} else {
//    The search values that are set by default
    $keyword = "";
    $view->posts = $postAction->getAllPostsByDateNew($_SESSION['amount'], $keyword);
}

// Logout button
if (isset($_POST['logoutButton'])) {
    unset($_SESSION['username']);
    unset($_SESSION['amount']);
    unset($_SESSION['filter']);
    session_destroy();
    echo '<meta http-equiv="refresh" content="0; URL=index.php">';
}
require_once("views/index.phtml");
<?php
require_once("models/Database.php");
require_once("models/Post.php");
// This class deals with posts, adding them to the database retrieving them, sorting them and adding, removing from the watch list
class PostAction
{
    protected $_dbHandler;

// This is the constructor for the postAction Class
    public function __construct()
    {
        $this->_dbHandler = Database::GetInstance()->getdbConnection();
    }

// Retrieves a single post from the database based by the id of that post
    public function getPost($postId)
    {

        $query = "SELECT * FROM posts WHERE post_id = '$postId'";
        $result = $this->_dbHandler->prepare($query);
        $result->execute();
        $posts = [];
        while ($row = $result->fetch()) {
            $posts [] = new Post($row);
        }
        return $posts[0];
    }

// This method returns the posts from the database, alphabetically
    public function getAllPostsAlphabetically($amount, $keyword)
    {
        $query = 'SELECT * FROM posts WHERE post_title LIKE "%' . $keyword . '%" ORDER BY post_title ASC limit ' . $amount;
        $result = $this->_dbHandler->prepare($query);
        $result->execute();
        $posts = [];
        while ($row = $result->fetch()) {
            $posts [] = new Post($row);
        }
        return $posts;
    }

// This method returns the posts from the database, newest first
    public function getAllPostsByDateNew($amount, $keyword)
    {
        $query = 'SELECT * FROM posts WHERE post_title LIKE "%' . $keyword . '%" ORDER BY post_date DESC limit ' . $amount;
        $result = $this->_dbHandler->prepare($query);
        $result->execute();
        $posts = [];
        while ($row = $result->fetch()) {
            $posts [] = new Post($row);
        }
        return $posts;
    }

// This method returns the posts from the database, oldest first
    public function getAllPostsByDateOld($amount, $keyword)
    {
        $query = 'SELECT * FROM posts WHERE post_title LIKE "%' . $keyword . '%" ORDER BY post_date ASC limit ' . $amount;
        $result = $this->_dbHandler->prepare($query);
        $result->execute();
        $posts = [];
        while ($row = $result->fetch()) {
            $posts [] = new Post($row);
        }
        return $posts;
    }

// This is the method for the load more button
    public function loadMorePosts($amount)
    {
        $query = "SELECT * FROM posts ORDER BY post_id ASC LIMIT '$amount'";
        $result = $this->_dbHandler->prepare($query);
        $result->execute();
        $posts = [];
        while ($row = $result->fetch()) {
            $posts [] = new Post($row);
        }
        return $posts;
    }

// This is the method for removing a post from the database
    public function removePost($postId)
    {
        $query = "DELETE FROM posts WHERE post_id = '$postId'";
        $result = $this->_dbHandler->prepare($query);
        $result->execute();
    }

//  This method is used to create and add a post to the database
    public function createPost($postAuthor, $title, $postContent, $postCategory, $creationDate, $postImage)
    {
        $query = "INSERT INTO posts VALUES (NULL,:postAuthor,:title,:postContent,:postCategory,:creationDate,:postImage)";
        $result = $this->_dbHandler->prepare($query);
        $result->bindValue('postAuthor', $postAuthor);
        $result->bindValue('title', $title);
        $result->bindValue('postContent', $postContent);
        $result->bindValue('postCategory', $postCategory);
        $result->bindValue('creationDate', $creationDate);
        $result->bindValue('postImage', $postImage);
        $result->execute();
    }

// This method returns the name of the selected file, in order to store the name of he image in the database, and that file is also moved to the images directory
    public function addImageToPost()
    {
//        Target directory where image will be moved
        $target_dir = "images/";
//        Setting a path with the name of the file
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
//        Name of the image
        $filename = basename($_FILES["fileToUpload"]["name"]);
        if (isset($_POST["createPostButton"])) {
//            Check if the file exists
            if (file_exists($target_file)) {
                return "fileExists";
//            Check the size of the file
            } elseif ($_FILES["fileToUpload"]["size"] > 500000) {
                return "fileTooBig";
//            Check the format of the file
            } elseif ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
                return "wrongFileType";
            } else {
//             Move the file to the directory
                move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
//              Returning the name of the file in order to store it in the database
                return $filename;
            }
        }
    }
// Returning the watchlist
    public function getWatchList($username)
    {
        $query = "SELECT * FROM posts WHERE post_id IN (SELECT post_id FROM watchlist WHERE username = '$username') ORDER BY post_date DESC";
        $result = $this->_dbHandler->prepare($query);
        $result->execute();
        $posts = [];
        while ($row = $result->fetch()) {
            $posts[] = new Post($row);
        }
        return $posts;
    }
// Add a post to the watch list
    public function addToWatchList($username, $post_id)
    {
        $query = "INSERT INTO watchlist VALUES (:username,:post_id)";
        $result = $this->_dbHandler->prepare($query);
        $result->bindValue('username', $username);
        $result->bindValue('post_id', $post_id);
        $result->execute();
    }
// Check if post has already been added to the watchlist
    public function addedToWatch($username, $post_id)
    {
        $query = "SELECT username FROM watchlist WHERE username = '$username' AND post_id = '$post_id'";
        $result = $this->_dbHandler->prepare($query);
        $result->execute();
        $row = $result->fetch();
        return $row != null;
    }
// Delete post from watchlist
    public function deleteFromWatchList($username, $postToDelete)
    {
        $query = "DELETE FROM watchlist WHERE username = '$username' AND post_id = '$postToDelete'";
        $result = $this->_dbHandler->prepare($query);
        $result->execute();
    }
}
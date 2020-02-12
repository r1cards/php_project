<?php
require_once("models/Database.php");
require_once("models/Comment.php");
// This class deals with inserting and retrieving comment information from the database
class CommentAction
{
    protected $_dbHandler;

// This is the constructor for the CommentAction class
    public function __construct()
    {
        $this->_dbHandler = Database::GetInstance()->getdbConnection();
    }

//  This method is used to create a comment and store it in a database
    public function createComment($comment_username, $comment_post_id, $comment_text, $comment_date)
    {
        $query = "INSERT INTO comments VALUES (NULL,:commentUsername,:commentPostId,:commentText,:commentDate)";
        $result = $this->_dbHandler->prepare($query);
        $result->bindValue('commentUsername', $comment_username);
        $result->bindValue('commentPostId', $comment_post_id);
        $result->bindValue('commentText', $comment_text);
        $result->bindValue('commentDate', $comment_date);
        $result->execute();
    }

    // This method returns all the comments for a post
    public function getAllComments($postID)
    {
        $query = "SELECT * FROM comments WHERE comment_post_id = :postId ORDER BY comment_date DESC";
        $result = $this->_dbHandler->prepare($query);
        $result->bindValue('postId', $postID);
        $result->execute();
        $comments = [];
        while ($row = $result->fetch()) {
            $comments [] = new Comment($row);
        }
        return $comments;
    }

// This is the method for removing a comment from the database
    public function removeComment($commentId)
    {
        $query = "DELETE FROM comments WHERE comment_id = :commentId";
        $result = $this->_dbHandler->prepare($query);
        $result->bindValue('commentId', $commentId);
        $result->execute();
    }

    // Returns a single comment based on the id provided
    public function getComment($commentId)
    {
        $query = "SELECT * FROM comments WHERE comment_id = :commentId";
        $result = $this->_dbHandler->prepare($query);
        $result->bindValue('commentId', $commentId);
        $result->execute();
        $comments = [];
        while ($row = $result->fetch()) {
            $comments [] = new Comment($row);
        }
        return $comments[0];
    }
}
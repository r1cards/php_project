<?php
// This class handles returns the data of a comment
class Comment
{
    private $comment_id, $comment_username, $comment_post_id, $comment_text, $comment_date;
// This is the constructor for the Comment class
    public function __construct($row)
    {
        $this->comment_id = $row['comment_id'];
        $this->comment_username = $row['comment_username'];
        $this->comment_post_id = $row['comment_post_id'];
        $this->comment_text = $row['comment_text'];
        $this->comment_date = $row['comment_date'];
    }

// Returns the id of the comment
    public function getCommentId()
    {
        return $this->comment_id;
    }

// Returns the author of the comment
    public function getCommentUsername()
    {
        return $this->comment_username;
    }

// Returns the the id of the post that the comment is in
    public function getCommentPostId()
    {
        return $this->comment_post_id;
    }

// Returns the text of the comment
    public function getCommentText()
    {
        return $this->comment_text;
    }

// Returns the date of when the comment was posted
    public function getCommentDate()
    {
        return $this->comment_date;
    }
}
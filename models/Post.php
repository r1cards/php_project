<?php

// This class deals with returning data from a post
class Post
{
    private $post_id, $post_author, $post_title, $post_content, $post_category_name, $post_date, $post_image;

// This is the constructor for the Post class
    public function __construct($row)
    {
        $this->post_id = $row['post_id'];
        $this->post_author = $row['post_author'];
        $this->post_title = $row['post_title'];
        $this->post_content = $row['post_content'];
        $this->post_category_name = $row['post_category_name'];
        $this->post_date = $row['post_date'];
        $this->post_image = $row['post_image'];
    }

//    Returns the Id of the post
    public function getPostId()
    {
        return $this->post_id;
    }

//     Returns the author of the post
    public function getPostAuthor()
    {
        return $this->post_author;
    }

//      Returns the title of th post
    public function getPostTitle()
    {
        return $this->post_title;
    }

//      Returns the content of the post
    public function getPostContent()
    {
        return $this->post_content;
    }

//      Returns the category of the post
    public function getPostCategoryName()
    {
        return $this->post_category_name;
    }

//      Returns the date of the post
    public function getPostDate()
    {
        return $this->post_date;
    }

//      Returns the image name of the post
    public function getPostImage()
    {
        return $this->post_image;
    }
}
<?php

// This class deals with returning data from a post
class Profile
{
    private $user_id, $username, $email, $creation_date;

// This is the constructor for the Post class
    public function __construct($row)
    {
        $this->user_id= $row['user_id'];
        $this->username = $row['username'];
        $this->email = $row['email'];
        $this->creation_date = $row['creation_date'];
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return mixed
     */
    public function getCreationDate()
    {
        return $this->creation_date;
    }

}
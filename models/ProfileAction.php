<?php
require_once("models/Database.php");
require_once("models/Profile.php");
// This class deals with posts, adding them to the database retrieving them, sorting them and adding, removing from the watch list
class ProfileAction
{
    protected $_dbHandler;

// This is the constructor for the postAction Class
    public function __construct()
    {
        $this->_dbHandler = Database::GetInstance()->getdbConnection();
    }

// Retrieves a single post from the database based by the id of that post
    public function getProfile($username)
    {
        $query = "SELECT * FROM users WHERE username = '$username'";
        $result = $this->_dbHandler->prepare($query);
        $result->execute();
//        $user = new Profile($result->fetch());
//        return $user;
        $user = [];
        while ($row = $result->fetch()) {
            $user [] = new Profile($row);
        }
        if($user == null){
            return null;
        }else{
            return $user[0];
        }
    }
}
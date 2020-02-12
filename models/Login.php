<?php
require_once("models/Database.php");

// This class deals with logging in a user
class Login
{
    protected $_dbHandler;

//  This is the constructor for the Login class
    public function __construct()
    {
        $this->_dbHandler = Database::GetInstance()->getdbConnection();
    }

// This is used to login the user
    public function loginUser($username, $password)
    {
        $query = "SELECT * FROM users WHERE username = :username";
        $result = $this->_dbHandler->prepare($query);
        $result->bindValue('username', $username);
        $result->execute();
        $this->_dbHandler = Database::GetInstance()->__destruct();
        $row = $result->fetch();
//      Here we check if the password match
        if (password_verify($password, $row['password'])) {
            return true;
        } else {
            return false;
        }
    }
}
<?php
require_once("models/Database.php");
// This class adds users to the database
class Register
{
    protected $_dbHandler;
// This is the constructor for the Register class
    public function __construct()
    {
        $this->_dbHandler = Database::GetInstance()->getdbConnection();
    }
//  This is used to create an account for the user and load their account data to the database
    public function addUser($username, $email, $password, $creationDate)
    {
        $hashedString = password_hash($password, PASSWORD_ARGON2I);
        $query = "INSERT INTO users VALUES (NULL,:username,:email,:hashedString,:creationDate)";
        $result = $this->_dbHandler->prepare($query);
        $result->bindValue('username',$username);
        $result->bindValue('email',$email);
        $result->bindValue('hashedString',$hashedString);
        $result->bindValue('creationDate',$creationDate);
        $result->execute();
        $this->_dbHandler = Database::GetInstance()->__destruct();
    }
//  Here we check if the username is already taken
    public function usernameExists($username){
        $query = "SELECT * FROM users WHERE username = :username";
        $result = $this->_dbHandler->prepare($query);
        $result->bindValue('username',$username);
        $result->execute();
        if($result->rowCount() > 0){
            return true;
        }else{
            return false;
        }
    }
//  Here we check if the email is already in use
    public function emailExists($email){
        $query = "SELECT * FROM users WHERE email = :email";
        $result = $this->_dbHandler->prepare($query);
        $result->bindValue('email',$email);
        $result->execute();
        if($result->rowCount() > 0){
            return true;
        }else{
            return false;
        }
    }
}
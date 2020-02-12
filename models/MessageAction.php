<?php
require_once("Database.php");
require_once("Message.php");
// This class deals with posts, adding them to the database retrieving them, sorting them and adding, removing from the watch list
class MessageAction
{
    protected $_dbHandler;

// This is the constructor for the postAction Class
    public function __construct()
    {
        $this->_dbHandler = Database::GetInstance()->getdbConnection();
    }

    public function insertNewMessage($message,$receiver,$sender,$date){
        $query = "INSERT INTO messages VALUES (NULL,'$message','$date','$sender','$receiver')";
        $result = $this->_dbHandler->prepare($query);
        $result->execute();
    }

    public function getChatMessages($sender, $receiver){
        $query = "SELECT * FROM messages WHERE (sender_id = '$sender' AND reciever_id = '$receiver')
OR (sender_id = '$receiver' AND reciever_id = '$sender')";

        $result = $this->_dbHandler->prepare($query);

        $result->execute();

        $messages = [];
        while ($row = $result->fetch()) {
            $messages[] = new Message($row);
        }
        return $messages;
    }
}
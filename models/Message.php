<?php

// This class deals with returning data from a post
class Message
{
    public $message_id, $message_content, $message_date, $sender_id, $receiver_id;

// This is the constructor for the Post class
    public function __construct($row)
    {
        $this->message_id = $row['message_id'];
        $this->message_content = $row['message_content'];
        $this->message_date = $row['message_date'];
        $this->sender_id = $row['sender_id'];
        $this->receiver_id = $row['reciever_id'];

    }


//    public function getMessageId()
//    {
//        return $this->message_id;
//    }
//
//
//    public function getMessageContent()
//    {
//        return $this->message_content;
//    }
//
//
//    public function getMessageDate()
//    {
//        return $this->message_date;
//    }
//
//
//    public function getSenderId()
//    {
//        return $this->sender_id;
//    }
//
//    public function getReceiverId()
//    {
//        return $this->receiver_id;
//    }

}
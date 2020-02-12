<?php

require_once "MessageAction.php";

if(isset($_REQUEST['message'])){
    $message = $_REQUEST['message'];
    $receiver = $_REQUEST['receiver'];
    $sender = $_REQUEST['sender'];
    $date = date("Y-m-d H:i:s");

    $messageAction = new MessageAction();
    $messageAction->insertNewMessage($message,$receiver,$sender,$date);
}
// cHECK caht managaer to make sence
if(isset($_REQUEST['requestName']) && $_REQUEST['requestName'] === 'getNewMessages'){

    $receiver = $_REQUEST['receiverId'];
    $sender = $_REQUEST['senderId'];


    $messageAction = new MessageAction();
    echo json_encode($messageAction->getChatMessages($sender,$receiver));


}










 ?>

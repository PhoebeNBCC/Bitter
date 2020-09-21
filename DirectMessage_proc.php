<?php
//date_default_timezone_set('America/Halifax');
//insert a tweet into the database
include("connect.php");
session_start();
include_once "User.php";
$user = new User();
//$msg=$_POST["#myTweet"];
//echo $msg;

if (($_POST["to"] !="")) {
    
    $screen_name=$_POST["to"];
    $message_text = htmlspecialchars(trim($_POST["message"]));
    if ($message_text == "") {
       $msg = "Something went wrong. Your message cannot be empty.";
        header("location:DirectMessage.php?message=$msg");
    } else {
        $from_id = $_SESSION['SESS_MEMBER_ID'];
        if ($user->AddMessage($from_id, $screen_name, $message_text)) {
            $msg = "Your message is sent successfully!";
            header("location:DirectMessage.php?message=$msg");
        } else {  
            $msg = "Something went wrong. (Ex: your message is too long) Please try again!";
            header("location:DirectMessage.php?message=$msg");
        }
    }
    //$tweet->displayTweet($_SESSION['SESS_MEMBER_ID']);
}
else{
    $msg = "Please enter 'Send message to'";
            header("location:DirectMessage.php?message=$msg");
}
?>
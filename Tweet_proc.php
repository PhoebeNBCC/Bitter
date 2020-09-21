<?php
//date_default_timezone_set('America/Halifax');
//insert a tweet into the database
include("connect.php");
session_start();
include_once "Tweet.php";

//$msg=$_POST["#myTweet"];
//echo $msg;

if (isset($_POST["myTweet"])) {
    $tweet = new Tweet();
    $tweet->tweetText = htmlspecialchars(trim($_POST["myTweet"]));
    if ($tweet->tweetText == "") {
        //$json_out='{"msg": "Something went wrong. Your tweet cannot be empty."}';
        $msg = "Something went wrong. Your tweet cannot be empty.";
        //header("location:index.php?message=$msg");
    } else {
        $tweet->userId = $_SESSION['SESS_MEMBER_ID'];
        $tweet->originalTweetId = 0;
        $tweet->replyToTweetId = $_POST['replyToId'];

        if ($tweet->insertTweet()) {
            //$json_out='{"msg": "Your tweet is sent successfully!"}';
            $msg = "Your tweet is sent successfully!";
            //header("location:index.php?message=$msg");
        } else {
            //$json_out='{"msg": "Something went wrong."}';
            $msg = "Something went wrong. (Ex: your tweet is too long) Please try again!";
            //header("location:index.php?message=$msg");
        }
    }
    //$tweet->displayTweet($_SESSION['SESS_MEMBER_ID']);
}

echo $msg;

//echo $json_out;
?>
<?php
session_start();
include("connect.php");
include "navigateLogin.php";
include "Tweet.php";
if (isset($_GET['originalTweetId'])) {
    $tweet1 = new Tweet();
    //$tweet->originalTweetId=$_GET['originalTweetId'];
    $id = $_GET['originalTweetId'];
    $tweet = $tweet1->cloneTweet($id);
    
    //$tweet->originalTweetId=$id;
    $tweet->userId = $_SESSION['SESS_MEMBER_ID'];
    $tweet->replyToTweetId=0;
    //echo $tweet->tweetText;
    
    
    
    if ($tweet->insertTweet()) {
        //$json_out='{"msg": "Your tweet is sent successfully!"}';
        $msg = "Your retweet is sent successfully!";
        header("Refresh: 0; url=index.php");
        echo '<script>alert("'.$msg.'");</script>';
        
    } else {
        //$json_out='{"msg": "Something went wrong."}';
        $msg = "Something went wrong. Please try again!";
        header("Refresh: 0; url=index.php");
        echo '<script>alert("'.$msg.'");</script>';
        
    }
}


<?php
session_start();
include("connect.php");
include "navigateLogin.php";
include "Tweet.php";
if (isset($_GET['tweetId'])) {
    $tweet = new Tweet();
    $tweetId = $_GET['tweetId'];
    $userId = $_SESSION['SESS_MEMBER_ID'];

    $tweet->like($tweetId, $userId);
    header("Refresh: 0; url=index.php");

}


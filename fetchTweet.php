<?php
date_default_timezone_set('America/Halifax');
//insert a tweet into the database
include("connect.php");
session_start();
include "Tweet.php";
$output = '';
$id = $_SESSION['SESS_MEMBER_ID'];
$json_out = fetchTweet($id);
echo $json_out;

function fetchTweet($id) { //$id is SESSION ID
    $t = new Tweet();
    global $con;
    $sql = "select tweets.user_id, first_name, last_name, screen_name, tweet_text, original_tweet_id, tweets.date_created, tweets.tweet_id from users "
            . "inner join tweets ON users.user_id = tweets.user_id "
            . "WHERE (users.user_id in (Select follows.to_id FROM follows where follows.from_id = '$id') "
            . "or  users.user_id = '$id' )"
            . "and (reply_to_tweet_id=0) order by tweets.tweet_id desc limit 10";
    $result = mysqli_query($con, $sql);
    $output = "";
    while ($tweets = mysqli_fetch_array($result)) {
        $tweetUserName = substr($tweets['first_name'] . ' ' . $tweets['last_name'] . ' @' . $tweets['screen_name'], 0, 22);
//            $this->tweetId = $tweets['tweet_id'];
//            $this->dateAdded = $tweets['date_created'];
//            $this->tweetText = $tweets['tweet_text'];
//            $this->originalTweetId = $tweets['original_tweet_id'];
        $output .= '<a href="userpage.php?memId=' . $tweets['user_id'] . '" >' . $tweetUserName . '</a>' . ' ';
        $output .= displayTime($tweets['date_created']);
        if ($tweets['original_tweet_id'] != 0) {
            $originalTweet = cloneTweet($tweets['original_tweet_id']);
            //echo $originalTweet->fullName. ' ';
            //$this->displayTime($originalTweet->originalDateAdded);
            $output .= ' <strong>retweeted from ' . $originalTweet->fullName . '</strong>';
        }
        $output .= '<br>';
        $output .= $tweets['tweet_text'] . '<br>';
        if (Tweet::isLike($tweets['tweet_id'], $id)) {
            $output .= '<img class="icon" src="images/like.png">';
        } else {
            $output .= '<a href="LikeTweet.php?tweetId=' . $tweets['tweet_id'] . '"><img class="icon" src="images/like.ico"></a>';
        }


        
        $output .= '<a href="Retweet.php?originalTweetId=' . $tweets['tweet_id'] . '"><img class="icon" src="images/retweet.png"></a>';
        $output .= ' <img id="' . $tweets['tweet_id'] . '" class="icon reply" src="images/reply.png">';
        //$this->displayAddReply($this->tweetId);
        $output .= '<hr></hr>';
        $output .= getReply($id, $tweets['tweet_id']);
    }
    return $output;
}

function getReply($id, $replyToId = 0, $marginleft = 0) {
    global $con;
    $sql = "select users.user_id, first_name, last_name, screen_name, tweet_text, original_tweet_id, tweets.date_created, tweets.tweet_id from users "
            . "inner join tweets ON users.user_id = tweets.user_id  where reply_to_tweet_id='$replyToId'";
    $result = mysqli_query($con, $sql);
    if ($replyToId == 0) {
        $marginleft = 0;
    } else {
        $marginleft += 40;
    }
    $output = "";
    while ($tweets = mysqli_fetch_array($result)) {
        $tweetUserName = substr($tweets['first_name'] . ' ' . $tweets['last_name'] . ' @' . $tweets['screen_name'], 0, 22);
//            $this->tweetId = $tweets['tweet_id'];
//            $this->dateAdded = $tweets['date_created'];
//            $this->tweetText = $tweets['tweet_text'];
//            $this->originalTweetId = $tweets['original_tweet_id'];
        $date = $tweets['date_created'];
        $output .= '<div class="img-rounded" style="margin-left:' . $marginleft . 'px">';
        $output .= '<a href="userpage.php?memId=' . $tweets['user_id'] . '" >' . $tweetUserName . '</a>' . ' ';

        $output .= displayTime($date);
        $output .= '<br>';
        $output .= $tweets['tweet_text'] . '<br>';
        if (Tweet::isLike($tweets['tweet_id'], $id)) {
            $output .= '<img class="icon" src="images/like.png">';
        } else {
            $output .= '<a href="LikeTweet.php?tweetId=' . $tweets['tweet_id'] . '"><img class="icon" src="images/like.ico"></a>';
        }
        //echo '<a href="Tweet_proc.php?originalTweetId=' . $tweets['tweet_id'] . '"><img class="icon" src="images/retweet.png"></a>';
        $output .= ' <img id="' . $tweets['tweet_id'] . '" class="icon reply" src="images/reply.png">';

        $output .= '<hr></hr>';
        $output .= '</div>';
        $output .= getReply($id, $tweets['tweet_id'], $marginleft);
    }
    return $output;
}

function displayTime($date) {
    global $con;
    $now = new DateTime();
    $tweetTime = new DateTime($date);
    $interval = $tweetTime->diff($now);
    $output = "";
    if ($interval->y > 1)
        $output .= $interval->format('%y years') . " ago";
    elseif ($interval->y > 0)
        $output .= $interval->format('%y year') . " ago";
    elseif ($interval->m > 1)
        $output .= $interval->format('%m months') . " ago";
    elseif ($interval->m > 0)
        $output .= $interval->format('%m month') . " ago";
    elseif ($interval->d > 1)
        $output .= $interval->format('%d days') . " ago";
    elseif ($interval->d > 0)
        $output .= $interval->format('%d day') . " ago";
    elseif ($interval->h > 1)
        $output .= $interval->format('%h hours') . " ago";
    elseif ($interval->h > 0)
        $output .= $interval->format('%h hour') . " ago";
    elseif ($interval->i > 1)
        $output .= $interval->format('%i minutes') . " ago";
    elseif ($interval->i > 0)
        $output .= $interval->format('%i minute') . " ago";
    elseif ($interval->s > 1)
        $output .= $interval->format('%s seconds') . " ago";
    elseif ($interval->s > 0)
        $output .= $interval->format('%s second') . " ago";
    return $output;
}

function cloneTweet($id) {
    global $con;
    $t = new Tweet();
    $sql = "select first_name, last_name, screen_name, tweet_text, tweets.date_created from tweets inner join users "
            . "on users.user_id = tweets.user_id where tweet_id=$id";
    $result = mysqli_query($con, $sql);
    while ($tweets = mysqli_fetch_array($result)) {
        $t->originalTweetId = $id;
        $t->tweetText = $tweets['tweet_text'];
        //don't need below
        $t->originalDateAdded = $tweets['date_created'];
        $t->fullName = $tweets['first_name'] . ' ' . $tweets['last_name'];
    }
    return $t;
}

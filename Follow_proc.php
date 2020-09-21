<?php include("connect.php"); ?>
<?php

//this page will be used when the user clicks on the "follow" button for a particular user
//process the transaction and insert a record into the database, then redirect the user back
// to index.php
include_once "Follower.php";
session_start();
$follower = new Follower();
$follower->userId = $_SESSION['SESS_MEMBER_ID']; //from_id
$follower->to_id = $_GET['to_id'];

if($follower->insertFollowers()){
//if everything is successful, redirect them to the index page.
$msg = "Followed successfully!";
header("location:index.php?message=$msg");

}
else {
    //if there is an error, redirect back to the index page with a friendly message
    $msg = "Something went wrong!";
    header("location:index.php?message=$msg");
}//end if
?>
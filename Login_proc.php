<?php

//verify the user's login credentials. if they are valid redirect them to index.php/
//if they are invalid send them back to login.php
session_start();
include("connect.php");
include "User.php";
if (isset($_POST["username"])) {
    $user = new User();
    $username = strtolower($_POST["username"]);
    $password = $_POST["password"];

    if ($user->matchUserPass($username, $password)) {
        // echo $user->password;           
        $_SESSION['SESS_FIRST_NAME'] = $user->fName;
        $_SESSION['SESS_LAST_NAME'] = $user->lName;
        $_SESSION['SESS_MEMBER_ID'] = $user->userId;
        $_SESSION['SESS_IMAGE_ID'] = $user->profileImage;
        $msg = "Welcome to " . $username . "!";
        header("location:index.php?message=$msg");
    } else {
        $msg = "User name and password are not matched. Please try again!";
        header("location:Login.php?message=$msg");
    }
}
?>
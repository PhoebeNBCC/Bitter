<?php
include("connect.php");
session_start();
include "User.php";
$user = new User();
$id = $_SESSION['SESS_MEMBER_ID'];
$keyword = $_GET["to"];
    $keywordL = strtolower($keyword);
$json_out = $user->GetUser($keywordL,$id);
echo $json_out;
?>

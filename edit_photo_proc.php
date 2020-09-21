<?php
//ob_start();
session_start();
include("connect.php");
include "navigateLogin.php";
include_once("getMessage.php");
include_once "User.php";
?>
//<?php
//
////chapter 20
//$userName = $_GET['txtUsername'];
//
//
//$strSql = "select * from users where screen_name='$userName'";
////echo $strSQl;
//if ($result = mysqli_query($db, $strSql)) {
//    if (mysqli_num_rows($result) > 0) {
//        //there's no point echoing out debugging code on this page, 
//        //since the user will never this page.
//        //echo "sorry username is already taken, please try again<BR>";
//        $json_out = '{"msg":"sorry username is already taken, please try again"}';
//    } else {
//        //echo "good to go<BR>";
//        $json_out = '{"msg":"Good to go"}';
//    }
//}
//echo $json_out;
//
////perform any server-side validation that may be needed
////if it's all good, go ahead and insert into the database or whatever
//
?>
<?php
if (isset($_POST['submit'])) {
    $user = new User();
    $user->userId = $_SESSION['SESS_MEMBER_ID'];
    //Attempt to upload file
//    if (empty($_FILES['pic']['name'])) {//name of file
//        $msg = "ERROR: You must select a file";
//        header("location:edit_photo.php?message=$msg");
//    }
    if ($user->validateFile()) {
        $_SESSION['SESS_IMAGE_ID'] = $new_name;
        $msg = "Your profile image is updated successfully";
        header("location:index.php?message=$msg");
    } else {
        
        $msg = "Your profile image is not updated successfully";
        header("location:edit_photo.php?message=$msg");
    }
}
?>
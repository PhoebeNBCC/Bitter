<?php
session_start();
if (isset($_SESSION['SESS_MEMBER_ID'])) {
    header("location:index.php");
}
?>

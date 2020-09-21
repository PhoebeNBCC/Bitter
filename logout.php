<?php
//log the user out and redirect them back to the login page.
session_start();
session_destroy();
header("location:Login.php")
?>

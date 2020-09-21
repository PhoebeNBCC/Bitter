<?php
if (isset($_GET["message"])) {
    $message = $_GET["message"];
    //echo "<script>alert('$message')</script>";
    echo '<br><span class="label label-info" id="spanInfo">'.$message.'</span>';    
}
?>


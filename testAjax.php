<?php
$userName = $_POST['myTweet'];

// Connect to database - CHANGE THIS TO YOUR DB SCHEMA NAME
$db = mysqli_connect("localhost", "root", "","bitter_phoebe")
		or die(mysql_error());
$strSql = "select * from tweets where tweet_text='$userName'";
//echo $strSQl;
$output="";
if($result = mysqli_query($db, $strSql)) {
    if (mysqli_num_rows($result) > 0) {
        //there's no point echoing out debugging code on this page, 
        //since the user will never this page.
        $output.="sorry username is already taken, please try again<BR>";
        //$json_out = '{"msg":"sorry username is already taken, please try again"}';
        
    }
    else{
        $output.= "good to go<BR>";
        //$json_out = '{"msg":"Good to go"}';
    }                
}
$data =array('msg' => $output);
echo json_encode($data);

//perform any server-side validation that may be needed
//if it's all good, go ahead and insert into the database or whatever
?>
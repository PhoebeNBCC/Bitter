<?php include("connect.php"); ?>
<?php
session_start();
include "navigateLogin.php";
include("getMessage.php");
?>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="Let's start trolling and have fun with your friends, family, poloticians and celebrities">
        <meta name="author" content="Phoebe Nguyen - phoebe.nlc@hotmail.com">
        <link rel="icon" href="favicon.ico">

        <title>Edit photo - Bitter</title>

        <!-- Bootstrap core CSS -->
        <link href="includes/bootstrap.min.css" rel="stylesheet">

        <!-- Custom styles for this template -->
        <link href="includes/starter-template.css" rel="stylesheet">
        <!-- Bootstrap core JavaScript-->
        <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>

        <script src="includes/bootstrap.min.js"></script>

        <script type="text/javascript">
            //just a little jquery, nothing to see here
//            function frm_submit(){
//                $.get(//get method/function in Jquery
//                    "edit_photo_proc.php",
//                    $("#myForm").serializeArray(),//make it serial, a line
//                    function(data) {//anonymous function 
//                        //alert(data); //use this for debugging - user doesn't see behind html get post methods
//        //console.log(data);                
//        //write the resulting message back to the mySpan tag - callback functions - Java Script Object Notation
//                      $("#mySpan").text(data.msg);  
//                    },
//                    "json" //change this to HTML for debugging
//                );//end of the get function call
//                return true;
            }
        </script>        
    </head>
    <body>
        <?php include "includes/Header.php"; ?>
        <BR><BR>
        <!-- the world's simplest form -->        
        <form method="post" enctype="multipart/form-data" id="myForm" action="edit_photo_proc.php" >
            Select your image (Must be under 1MB in size): 
	<input type="file" name="pic" accept="image/*" required><br><br>
	<input id="button" type="submit" name="submit" value="Submit">
        <span id="mySpan"></span><BR>
        <!--<p id="image_submitted">Thank you for your image.</p>-->
        </form>
        
    </body>
        
</html>
<?php
//ob_start();//turn on output buffering for just this page
session_start();
include("connect.php");
include "navigateLogin.php";
include("getMessage.php");
//include_once "User.php";
include_once "Tweet.php";
include_once "Follower.php";
$user = new Follower();

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="DESC MISSING">
        <meta name="author" content="Nick Taggart, nick.taggart@nbcc.ca">
        <link rel="icon" href="favicon.ico">

        <title>Bitter - Social Media for Trolls, Narcissists, Bullies and Presidents</title>

        <!-- Bootstrap core CSS -->
        <link href="includes/bootstrap.min.css" rel="stylesheet">

        <!-- Custom styles for this template -->
        <link href="includes/starter-template.css" rel="stylesheet">
        <!-- Bootstrap core JavaScript-->
        <script src="https://code.jquery.com/jquery-1.10.2.js" ></script>
        <script type="text/javascript" src="Includes/jquery-3.3.1.min.js"></script>

        <script>

            //just a little jquery to make the textbox appear/disappear like the real Twitter website does
            $(document).ready(function () {
                //hide the submit button on page load
                $("#button").hide();
                $("#buttonReply").hide();
                $("#myReply").hide();
                $("#btnCancel").hide();
                $("#tweet_form").submit(function () {
                $("#button").hide();
                });



                $("#myTweet").click(function () {
                    this.attributes["rows"].nodeValue = 5;
                    $("#button").show();
                    $("#mySpan").text("");

                });//end of click event
                $("#myTweet").blur(function () {
                    //this.attributes["rows"].nodeValue = 1;
                    $("#mySpan").text("");
                    $("#spanInfo").text("");
                    //$("#button").hide();
                    //$("#myTweet").attr("placeholder", "What are you bitter about today?");
                    //$('#replyToId').val('0');

                });//end of click event
                $(document).on('click', '.reply', function () {
                    var replyToId = $(this).attr("id");
                    $('#replyToId').val(replyToId);
                    $("#myTweet").attr("placeholder", "Reply to tweet");
                    $('#myTweet').focus();
                    $("#myTweet").attr("rows", 5);
                    $("#button").show();
                    $("#btnCancel").show();

                });
                $("#btnCancel").click(function () {
                    $("#myTweet").attr("placeholder", "What are you bitter about today?");
                    $('#replyToId').val('0');
                    $("#myTweet").val("");
                    $('#myTweet').focus();
                    $("#btnCancel").hide();
                });

                //my reference: https://www.youtube.com/watch?v=7Gj_zWCHTIk
                $("#tweet_form").on('submit', function (event) {
                    event.preventDefault();
                    var form_data = $(this).serialize();
                    //alert(form_data);
                    $.ajax({//get method/function in Jquery
                        url: "Tweet_proc.php",
                        method: "POST",
                        data: form_data,
                        //dataType:"JSON",
                        success: function (data) {
                            //alert(data);
                            $("#mySpan").text(data);
                            $("#myTweet").val("");
                            $('#myTweet').focus();
                            $("#myTweet").attr("rows", "1");
                            $("#button").hide();
                            $("#myTweet").attr("placeholder", "What are you bitter about today?");
                            $('#replyToId').val('0');
                            $("#btnCancel").hide();
                            loadTweet();
                        }
                    });//end of the get function call
                });//end ajax

                loadTweet();
                function loadTweet() {
                    $.ajax({//get method/function in Jquery
                        url: "fetchTweet.php",
                        method: "POST",
                        success: function (data) {
                            $("#diplayTweet").html(data);
                        }
                    })
                }
            });//end of ready event handler




        </script>
    </head>

    <body>
    <?php include 'includes/HeaderSearch.php';?>
        
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <div class="mainprofile img-rounded">
                        <div class="bold">
                            <?php
                            $user->getMember($_SESSION['SESS_MEMBER_ID']);
                            $user->displayUser();
                            ?>
                            <BR><BR><BR><BR><BR>
                        </div><BR><BR>
                        <div class="trending img-rounded">
                            <div class="bold">Trending</div>
                        </div>

                    </div>
                    <div class="col-md-6">
                        <div class="img-rounded">
                            <form method="POST" id="tweet_form" name="tweet_form" >
                                <div class="form-group">
                                    <input type="hidden" name="replyToId" id="replyToId" value="0"/>
                                    <textarea class="form-control" name="myTweet" id="myTweet" rows="1" placeholder="What are you bitter about today?"></textarea>
                                    <input type="submit" name="button" id="button" value="Send" class="btn btn-primary btn-lg btn-block login-button"/>
                                    <input name="button" id="btnCancel" value="Cancel" class="btn btn-primary btn-lg btn-block login-button"/>

                                </div>
                            </form>
                        </div>
                        <span id="mySpan" name="mySpan"></span><br><br>
                        <div class="img-rounded" id="diplayTweet">
                            <!--display list of tweets here-->
                            <?php
//                            date_default_timezone_set('America/Halifax');
//                            if (isset($_SESSION['SESS_MEMBER_ID'])) {
//                                $tweet = new Tweet();
//                                $id = $_SESSION['SESS_MEMBER_ID'];
//                                //$tweet->displayTweet($id);
//                            }
                            ?>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="whoToTroll img-rounded">
                            <div class="bold">Who to Troll?<BR></div>
                            <!-- display people you may know here-->
                            <?php
//                            if (isset($_SESSION['SESS_MEMBER_ID'])) {
                                
                                $user->displayNonFollowers($_SESSION['SESS_MEMBER_ID']);
//                            }
                            ?>


                        </div><BR>
                        <!--don't need this div for now 
                        <div class="trending img-rounded">
                        © 2018 Bitter
                        </div>-->
                    </div>
                </div> <!-- end row -->
            </div><!-- /.container -->



            <!-- Bootstrap core JavaScript
            ================================================== -->
            <!-- Placed at the end of the document so the pages load faster -->
            <!--<script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>-->
            <script src="https://code.jquery.com/jquery-3.1.1.min.js" ></script>
            <script src="includes/bootstrap.min.js"></script>

    </body>
</html>

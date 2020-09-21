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
        <meta name="author" content="Phoebe Nguyen, phoebe.nlc@hotmail.com">
        <link rel="icon" href="favicon.ico">

        <title>Bitter - Social Media for Trolls, Narcissists, Bullies and Presidents</title>

        <!-- Bootstrap core CSS -->
        <link href="includes/bootstrap.min.css" rel="stylesheet">

        <!-- Custom styles for this template -->
        <link href="includes/starter-template.css" rel="stylesheet">
        <!-- Bootstrap core JavaScript-->
        <script src="https://code.jquery.com/jquery-3.3.1.js" ></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script>
            $(document).ready(function () {
                
                //hide the submit button on page load
                $("#button").hide();
                $("#message_form").submit(function () {
                    //alert("submit form");
                    $("#button").hide();
                });
                $("#message").focus(function () {
                    this.attributes["rows"].nodeValue = 5;
                    $("#button").show();
                }); //end of click event

                $("#to").keyup(//key up event for the user name textbox

                        function (e) {
                            if (e.keyCode === 13) {
                                //don't do anything if the user types the enter key, it might try to submit the form
                                return false;
                            }
                            jQuery.get(
                                    "UserSearch_AJAX.php",
                                    $("#message_form").serializeArray(),
                                    function (data) {//anonymous function
                                        //uncomment this alert for debugging the directMessage_proc.php page
                                        //alert(data);
                                        //clear the users datalist
                                        $("#dlUsers").empty();
                                        if (typeof (data) === "undefined") {
                                            $("#dlUsers").append("<option value='NO USERS FOUND' label='NO USERS FOUND'></option>");
                                        }
                                        $.each(data, function (index, element) {
                                            //this will loop through the JSON array of users and add them to the select box
                                            $("#dlUsers").append("<option value='" + element + "' label='" + element +
                                                    "'></option>");
                                            //alert(element.id + " " + element.name);
                                        });
                                    },
                                    //change this to "html" for debugging the UserSearch_AJAX.php page"json"
                                    "json"
                                    );
                            //make sure the focus stays on the textbox so the user can keep typing
                            $("#to").focus();
                            return false;

                        }
                );
            }); //end of ready event handler
        </script>
    </head>

    <body>
        <?php include 'includes/HeaderSearch.php'; ?>

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


                            <form method="post" id="message_form" action="DirectMessage_proc.php">
                                <div class="form-group">
                                    Send message to: <input type="search" id="to" name="to" list="dlUsers" autocomplete="off"><br>
                                    <datalist id="dlUsers">
                                        <!-- this datalist is empty initially but will hold the list of users to select as the user is typing -->
                                        <!-- <option value="phoebe" label='phoebe'></option> -->
                                    </datalist>
                                    <input type="hidden" name="userId" value="">
                                    <textarea class="form-control" name="message" id="message" rows="1" placeholder="Enter your message here"></textarea>

                                    <input type="submit" name="button" id="button" value="Send" class="btn btn-primary btn-lg btn-block login-button"/>
                                </div>
                            </form>
                        </div>
                        <span id="mySpan" name="mySpan"></span><br><br>
                        <h2>Your messages</h2>
                        <div class="img-rounded" id="diplayMessage">
                            <!--display list of message here-->

                            <?php
                            $user->GetAllMessages($_SESSION['SESS_MEMBER_ID']);
                            
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

<!DOCTYPE html>
<?php
include("connect.php");
include("navigateIndex.php");
include("getMessage.php");

?>

<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="Let's start trolling and have fun with your friends, family, poloticians and celebrities">
        <meta name="author" content="Phoebe Nguyen - phoebe.nlc@hotmail.com">
        <link rel="icon" href="favicon.ico">

        <title>Signup - Bitter</title>

        <!-- Bootstrap core CSS -->
        <link href="includes/bootstrap.min.css" rel="stylesheet">

        <!-- Custom styles for this template -->
        <link href="includes/starter-template.css" rel="stylesheet">
        <!-- Bootstrap core JavaScript-->
        <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>

        <script src="includes/bootstrap.min.js"></script>

        <script type="text/javascript">
            //any JS validation you write can go here
            var $ = function (id) {
                return document.getElementById(id);
            }

            window.onload = function () {
                //wire the event to the button

                $("registration_form").onsubmit = ValidateForm;
            }

            function ValidateForm() {
                var myValidator=new validator();
                var myPhone=$("phone").value;
                var myPostalCode=$("postalCode").value;
                var myPassword=$("password").value;
                var myConfirmP=$("confirm").value;
                var myEmail=$("email").value;
                if(!myValidator.isPhoneNum(myPhone)){
                    alert("Please enter a valid phone number format ie: (555) 555-5555");
                    $("phone").value="";
                    return false;
                    
                }
                if(!myValidator.isPostalCode(myPostalCode)){
                    alert("Please enter a valid postal code format ie: E3B 3Y3 or E3B3Y3");
                    $("postalCode").value="";
                    return false;
                    
                }
                if(myConfirmP!==myPassword){
                    alert("The confirm password is not matched to the password");
                    $("confirm").value="";
                    return false;
                    //$("registration_form").action="Signup.php";
                }
                if(!myValidator.isEmail(myEmail)){
                    alert("Please enter a valid email");
                    $("email").value="";
                    return false;
                    
                }
                


            }
            var validator = function () {
                    this.isBlank = function (text) {
                        return (text == "");
                    };
                    this.isPhoneNum = function (text) {
                        //| means "or" in a regex
                        var pattern = /^\(\d{3}\) ?\d{3}(-)|( )\d{4}$/;//[space]? space is optional
                        return pattern.test(text);
                    };
                    this.isPostalCode=function(text){
                        var pattern=/^[A-Za-z][0-9][A-Za-z] ?[0-9][A-Za-z][0-9]$/;
                        return pattern.test(text);
                    }
                    this.isEmail = function (text) {
                        //+ means 1 or more of the previous pattern
                        var pattern = /^[A-Z0-9]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i;
                        return pattern.test(text);
                    };
                };

        </script>
        <?php
        
        ?>
    </head>

    <body>

        <?php include "includes/header.php"; ?>

        <BR><BR>
        <div class="container">
            <div class="row">

                <div class="main-login main-center">
                    <h5>Sign up once and troll as many people as you like!</h5>
                    <form method="post" id="registration_form" action="signup_proc.php">

                        <div class="form-group">
                            <label for="name" class="cols-sm-2 control-label">First Name</label>
                            <div class="cols-sm-10">
                                <div class="input-group">

                                    <input type="text" class="form-control" required name="firstname" id="firstname"  placeholder="Enter your First Name"/>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name" class="cols-sm-2 control-label">Last Name</label>
                            <div class="cols-sm-10">
                                <div class="input-group">

                                    <input type="text" class="form-control" required name="lastname" id="lastname"  placeholder="Enter your Last Name"/>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="email" class="cols-sm-2 control-label">Your Email</label>
                            <div class="cols-sm-10">
                                <div class="input-group">

                                    <input type="text" class="form-control" required name="email" id="email"  placeholder="Enter your Email"/>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="username" class="cols-sm-2 control-label">Screen Name</label>
                            <div class="cols-sm-10">
                                <div class="input-group">

                                    <input type="text" class="form-control" required name="username" id="username"  placeholder="Enter your Screen Name"/>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password" class="cols-sm-2 control-label">Password</label>
                            <div class="cols-sm-10">
                                <div class="input-group">

                                    <input type="password" class="form-control" required name="password" id="password"  placeholder="Enter your Password"/>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="confirm" class="cols-sm-2 control-label">Confirm Password</label>
                            <div class="cols-sm-10">
                                <div class="input-group">

                                    <input type="password" class="form-control" required name="confirm" id="confirm"  placeholder="Confirm your Password"/>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="name" class="cols-sm-2 control-label">Phone Number</label>
                            <div class="cols-sm-10">
                                <div class="input-group">

                                    <input type="text" class="form-control" required name="phone" id="phone"  placeholder="Enter your Phone Number"/>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="name" class="cols-sm-2 control-label">Address</label>
                            <div class="cols-sm-10">
                                <div class="input-group">

                                    <input type="text" class="form-control" required name="address" id="address"  placeholder="Enter your Address"/>
                                </div>
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="name" class="cols-sm-2 control-label">Province</label>
                            <div class="cols-sm-10">
                                <div class="input-group">

                                    <select name="province" id="province" class="textfield1" required><?php echo $vprovince; ?> 
                                        <option> </option>
                                        <option value="British Columbia">British Columbia</option>
                                        <option value="Alberta">Alberta</option>
                                        <option value="Saskatchewan">Saskatchewan</option>
                                        <option value="Manitoba">Manitoba</option>
                                        <option value="Ontario">Ontario</option>
                                        <option value="Quebec">Quebec</option>
                                        <option value="New Brunswick">New Brunswick</option>
                                        <option value="Prince Edward Island">Prince Edward Island</option>
                                        <option value="Nova Scotia">Nova Scotia</option>
                                        <option value="Newfoundland and Labrador">Newfoundland and Labrador</option>
                                        <option value="Northwest Territories">Northwest Territories</option>
                                        <option value="Nunavut">Nunavut</option>
                                        <option value="Yukon">Yukon</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="name" class="cols-sm-2 control-label">Postal Code</label>
                            <div class="cols-sm-10">
                                <div class="input-group">

                                    <input type="text" class="form-control" required name="postalCode" id="postalCode"  placeholder="Enter your Postal Code"/>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="name" class="cols-sm-2 control-label">Url</label>
                            <div class="cols-sm-10">
                                <div class="input-group">

                                    <input type="text" class="form-control" name="url" id="url"  placeholder="Enter your URL"/>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="name" class="cols-sm-2 control-label">Description</label>
                            <div class="cols-sm-10">
                                <div class="input-group">

                                    <input type="text" class="form-control" required name="desc" id="desc"  placeholder="Description of your profile"/>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="name" class="cols-sm-2 control-label">Location</label>
                            <div class="cols-sm-10">
                                <div class="input-group">

                                    <input type="text" class="form-control" name="location" id="location"  placeholder="Enter your Location"/>
                                </div>
                            </div>
                        </div>


                        <div class="form-group ">
                            <input type="submit"  name="button" id="button" value="Register" class="btn btn-primary btn-lg btn-block login-button"/>

                        </div>

                    </form>
                </div>

            </div> <!-- end row -->
        </div><!-- /.container -->
        <footer>
            <?php include("includes/ContactUs.php"); ?>

        </footer>
    </body>
</html>
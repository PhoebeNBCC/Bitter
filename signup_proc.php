<?php

include("connect.php");
include "User.php";
?>
<?php

//insert the user's data into the users table of the DB

if (isset($_POST["firstname"])) {
    $fname = $_POST["firstname"];
    $lname = $_POST["lastname"];
    $email = $_POST["email"];
    $username = strtolower($_POST["username"]);
    $password = $_POST["password"];
    $confirm = $_POST["confirm"];
    $phone = $_POST["phone"];
    $address = $_POST["address"];
    $province = $_POST["province"];
    $postalCode = $_POST["postalCode"];
    $url = $_POST["url"];
    $desc = $_POST["desc"];
    $location = $_POST["location"];

    //encrypt password
    $myHashedPassword = password_hash($password, PASSWORD_DEFAULT);
    //password_verify($password, $myHashedPassword);

    $user = new User();

    $user->fName = $fname;
    $user->lName = $lname;
    $user->email = $email;
    $user->userName = $username;
    $user->password = $myHashedPassword;
    $user->phone = $phone;
    $user->address = $address;
    $user->province = $province;
    $user->postalCode = $postalCode;
    $user->url = $url;
    $user->description = $desc;
    $user->location = $location;
    //validate username
    //echo $sqlSelect;
    //echo mysqli_fetch_array($result);
    
    if ($user->validateUser($username)) {

        if (User::FedexValidate($postalCode, $province)) {
            
            if ($user->insertUser()) {
                $msg = "Your account is created successfully!";
                header("location:Login.php?message=$msg");
            } else {
                $msg = "Something went wrong. Please try again!";
                header("location:Signup.php?message=$msg");
            }
        } else {
            $msg = "PostalCode is not correct. Please try again!";
            header("location:Signup.php?message=$msg");
        }
    }//end if
    else {
        $msg = "The user name is existed. Please try the different one!";
        header("location:Signup.php?message=$msg");
    }
}
?>
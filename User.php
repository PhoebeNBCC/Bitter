<?php

class User {//same name with the file

    private $userId;
    private $userName;
    private $password;
    private $fName;
    private $lName;
    private $address;
    private $province;
    private $postalCode;
    private $phone;
    private $email;
    private $dateAdded;
    private $profileImage;
    private $location;
    private $description;
    private $url;
    private $noTweets;
    private $noFollowing;
    private $noFollowers;

    public function __set($propName, $propValue) {
        $this->$propName = $propValue;
    }

    public function __get($property) {//any attribute name, it takes some variables
        return $this->$property;
    }

    public function __construct() {
        
    }

    public function validateUser($userName) {
        global $con;
        $sqlSelect = "select screen_name from users where screen_name='$userName'";
        $result = mysqli_query($con, $sqlSelect);
        if (mysqli_num_rows($result) == 0) {
            return true;
        } else {
            return false;
        }
    }

    public function insertUser() {
        global $con;
        $sql = "insert into users (first_name, last_name, screen_name, password, 
        address, province, postal_code, contact_number, email, url, description, location)  
              values ('$this->fName','$this->lName', '$this->userName', '$this->password', '$this->address','$this->province',
        '$this->postalCode','$this->phone','$this->email', '$this->url', '$this->description', '$this->location')";
        mysqli_query($con, $sql);
        if (mysqli_affected_rows($con) == 1) {
//if everything is successful, redirect them to the login page.
//echo "if true";
            $this->userId = mysqli_insert_id($result); //check this one
            return true;
        } else {
//if there is an error, redirect back to the signup page with a friendly message
//data entered violate the DB fields
//echo "if false";
            return false;
        }
    }

    public function matchUserPass($username, $password) {
        global $con;
        $sql = "select user_id, first_name, last_name, screen_name, password, date_created, profile_pic 
        from users where screen_name = '$username' ";
        $result = mysqli_query($con, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($rs = mysqli_fetch_array($result)) {
                $this->fName = $rs['first_name'];
                $this->lName = $rs['last_name'];
                $this->userId = $rs['user_id'];
                $this->userName = $rs['screen_name'];
                $this->password = $rs['password'];
                if (is_null($rs['profile_pic'])) {
                    $this->profileImage = "default.jfif";
                } else {
                    $this->profileImage = $rs['profile_pic'];
                }

                if (password_verify($password, $this->password)) {
                    return true;
                } else {
                    return false;
                }
            }
            return false;
        } else {
            return false;
        }
    }

//end matchUserPass

    public function validateFile() {
        global $con;
        if ($_FILES['pic']['size'] > (1024 * 1024)) {
            unlink($_FILES['pic']['tmp_name']); //delete the file
            return false;
        } else {
            $path = pathinfo($_FILES['pic']['name']);
            $extension = $path['extension'];
            $new_name = $this->userId . '_' . strtotime(date("Y-m-d G:i:s")) . '.' . $extension;
            if (move_uploaded_file($_FILES['pic']['tmp_name'], "Images/profilepics/" . $new_name)) {
                $sql = "update users set profile_pic='$new_name' where user_id='$this->userId'";
                mysqli_query($con, $sql);
//echo mysqli_affected_rows($con);
                if (mysqli_affected_rows($con) == 1) {
                    return true;
                } else {
                    unlink($_FILES['pic']['tmp_name']); //delete the file
                    return false;
                }
            } else {
                unlink($_FILES['pic']['tmp_name']); //delete the file
                return false;
            }
        }
    }

    public function displayImage() {
        global $con;
        $profile_pic = "default.jfif";
        $sql = "select profile_pic, first_name, last_name from users where user_id='$this->userId'";
        $result = mysqli_query($con, $sql);
        while ($image = mysqli_fetch_array($result)) {
            $this->fName = $image['first_name'];
            $this->lName = $image['last_name'];
            if (!is_null($image['profile_pic'])) {
                $this->profileImage = $image['profile_pic'];
                return true;
            } else {
                return false;
            }
        }
        return false;
    }

    Static function FedexValidate($postalCode, $province) {

        function getProvinceCode($details, $spacer) {
            foreach ($details as $key => $value) {
                if (is_array($value) || is_object($value)) {
                    $newSpacer = $spacer . '&nbsp;&nbsp;&nbsp;&nbsp;';
                    //echo '<tr><td>' . $spacer . $key . '</td><td>&nbsp;</td></tr>';
                    getProvinceCode($value, $newSpacer);
                } elseif (empty($value)) {
                    //printString($spacer, $key, $value);
                    return "";
                } else {
                    //printString($spacer, $key, $value);
                    if (strcasecmp($key, 'StateOrProvinceCode') == 0) {
                        return $value;
                    }
                }
            }
        }

        function getProvince($code) {
            switch ($code) {
                case "NB":
                    return "New Brunswick";
                case "NF":
                    return "Newfoundland and Labrador";
                case "PE":
                    return "Prince Edward Island";
                case "NS":
                    return "Nova Scotia";
                case "PQ":
                    return "Quebec";
                case "ON":
                    return "Ontario";
                case "MB":
                    return "Manitoba";
                case "SK":
                    return "Saskatchewan";
                case "AB":
                    return "Alberta";
                case "BC":
                    return "British Columbia";
                case "YT":
                    return "Yukon";
                case "NT":
                    return "Northwest Territories";
                case "NT"://NU
                    return "Nunavut";
            }
        }

        require_once('includes/Fedex/fedex-common.php');

        $newline = "<br />";
//Please include and reference in $path_to_wsdl variable.
        $path_to_wsdl = "includes/Fedex/wsdl/CountryService/CountryService_v5.wsdl";


        ini_set("soap.wsdl_cache_enabled", "0");

        $client = new SoapClient($path_to_wsdl, array('trace' => 1)); // Refer to http://us3.php.net/manual/en/ref.soap.php for more information

        $request['WebAuthenticationDetail'] = array(
            'ParentCredential' => array(
                'Key' => getProperty('parentkey'),
                'Password' => getProperty('parentpassword')
            ),
            'UserCredential' => array(
                'Key' => getProperty('key'),
                'Password' => getProperty('password')
            )
        );

        $request['ClientDetail'] = array(
            'AccountNumber' => getProperty('shipaccount'),
            'MeterNumber' => getProperty('meter')
        );
        $request['TransactionDetail'] = array('CustomerTransactionId' => ' *** Validate Postal Code Request using PHP ***');
        $request['Version'] = array(
            'ServiceId' => 'cnty',
            'Major' => '5',
            'Intermediate' => '0',
            'Minor' => '1'
        );
//change
        $request['Address'] = array(
            'PostalCode' => $postalCode, //from user input
            //'StateOrProvinceCode' => getCode($province),
            'CountryCode' => 'CA'
        );

        $request['CarrierCode'] = 'FDXE';

        try {
            if (setEndpoint('changeEndpoint')) {
                $newLocation = $client->__setLocation(setEndpoint('endpoint'));
            }

            $response = $client->validatePostal($request);



            if ($response->HighestSeverity != 'FAILURE' && $response->HighestSeverity != 'ERROR') {
                //printSuccess($client, $response);
//loop through array that is returned in the reply
//                echo "<table>\n";
//                printPostalDetails($response->PostalDetail, "");
//                echo "</table>\n";
                $details = $response->PostalDetail;
                $provinceCode = getProvinceCode($details, "");
                //echo '<script>alert(' . $provinceCode . ');</script>';
                $provinceResponse = getProvince($provinceCode);
                //echo '<script>alert(' . $provinceResponse . ');</script>';
                if (strcasecmp($provinceResponse, $province) == 0) {
                    return true;
                } else {
                    //echo '<script>alert("compare");</script>';
                    return false;
                }
            } else {
                //printError($client, $response);
                //echo '<script>alert("incorrect postalcode");</script>';
                return false;
            }

            //writeToLog($client);    // Write to log file   
        } catch (SoapFault $exception) {
            //printFault($exception, $client);
            //echo '<script>alert("exception");</script>';
            return false;
        }

//        function printString($spacer, $key, $value) {
//            if (is_bool($value)) {
//                if ($value)
//                    $value = 'true';
//                else
//                    $value = 'false';
//            }
//            echo '<tr><td>' . $spacer . $key . '</td><td>' . $value . '</td></tr>';
//        }
    }

    public function GetAllMessages($userId) {//to current user, session ID
        global $con;
        $sql = "select user_id, first_name, last_name, screen_name, message_text from users "
                . "inner join messages ON users.user_id = messages.from_id "
                . "WHERE messages.to_id = $userId "
                . " order by messages.id desc";
        $result = mysqli_query($con, $sql);

        while ($message = mysqli_fetch_array($result)) {
            $messageUserName = substr($message['first_name'] . ' ' . $message['last_name'] . ' @' . $message['screen_name'], 0, 22);
            echo '<a href="userpage.php?memId=' . $message['user_id'] . '" >' . $messageUserName . '</a>' . ' <br>';
            echo $message['message_text'];
            echo '<hr></hr>';
        }
    }

    public function AddMessage($from_id, $screen_name, $message_text) { //$from-id is SessionID
        global $con;
        $to_id = $this->GetUserByScreenName($screen_name);
        
        $Sqlmessage_text = mysqli_escape_string($con, $message_text);
        $sql = "insert into messages (from_id, to_id, message_text) VALUES ($from_id, $to_id, '$Sqlmessage_text')";
       
        mysqli_query($con, $sql);
        if (mysqli_affected_rows($con) == 1) {
            return true;
        } else {
            return false;
        }
    }

    public function GetUserByScreenName($screen_name) {
        global $con;
        $sql = "select user_id from users where screen_name = '$screen_name'";
        $result = mysqli_query($con, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_array($result)) {
                return $row['user_id'];
            }
        }
        
    }

    public function GetUser($keywordL, $id) {
        global $con;
        $usersArray = array();
        $sql = "select screen_name from users where user_id in (select to_id from follows where from_id=$id) "
                . "and screen_name LIKE '%" . $keywordL . "%'";
        $result = mysqli_query($con, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_array($result)) {
                array_push($usersArray, $row["screen_name"]);
            }
            return json_encode($usersArray);
        }
    }

}
?>



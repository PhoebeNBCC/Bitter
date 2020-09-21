<?php

include "User.php";

class Follower extends User {

    private $to_id;
    private $noSameFollowers;

    public function _contruct() {
        
    }

    public function __set($propName, $propValue) {
        $this->$propName = $propValue;
    }

    public function __get($property) {//any attribute name, it takes some variables
        return $this->$property;
    }

    public function insertFollowers() {
        global $con;
        $sql = "insert into follows (from_id, to_id) value ('$this->userId','$this->to_id')";
        echo $sql;
        mysqli_query($con, $sql);
        if (mysqli_affected_rows($con) == 1) {
            return true;
        } else {
            echo $sql;
            return false;
        }
    }

    public function displayNonFollowers($id) {
        global $con;
        $sql = "select user_id, first_name, last_name, screen_name, profile_pic from users where user_id != $id "
                . "and user_id NOT IN (SELECT to_id from follows where from_id=$id) order by rand() limit 3";
        $result = mysqli_query($con, $sql);
        while ($row = mysqli_fetch_array($result)) {
            if (isset($row['profile_pic'])) {
                echo '<img class="bannericons" src="images/profilepics/' . $row['profile_pic'] . '">';
            } else {
                echo '<img class="bannericons" src="images/profilepics/default.jfif">';
            }

            $truncateString = substr($row['first_name'] . ' ' . $row['last_name'] . ' @' . $row['screen_name'], 0, 22);
            echo '<a href="userpage.php?memId=' . $row['user_id'] . '" >' . $truncateString . '</a>' . '<br>';
            echo '<a href="follow_proc.php?to_id=' . $row['user_id'] . '"><button class="followbutton" type=button>Follow</button> </a>' . '<br>';
            echo '<hr></hr>';
        }
    }

    public function getMember($id) {
        global $con;
        $sql = "select profile_pic, first_name, last_name, province, screen_name, date_created from users where user_id='$id'";
        $result = mysqli_query($con, $sql);
        while ($image = mysqli_fetch_array($result)) {
            $this->userId = $id;
            $this->fName = $image['first_name'];
            $this->lName = $image['last_name'];
            $this->province = $image['province'];
            $this->dateAdded = $image['date_created'];
            if (!is_null($image['profile_pic'])) {
                $this->profileImage = $image['profile_pic'];
            } else {
                $this->profileImage = "default.jfif";
            }
        }
        $sqlTweet = "select * from tweets where user_id='$id' and reply_to_tweet_id=0 ";
        $resultTweet = mysqli_query($con, $sqlTweet);
        $this->noTweets = mysqli_num_rows($resultTweet);
        $sqlFollowing = "select * from follows where from_id='$id'";
        $resultFollowing = mysqli_query($con, $sqlFollowing);
        $this->noFollowing = mysqli_num_rows($resultFollowing);
        $sqlFollowers = "select * from follows where to_id='$id'";
        $resultFollowers = mysqli_query($con, $sqlFollowers);
        $this->noFollowers = mysqli_num_rows($resultFollowers);
        
        return $this;
    }
    public function displayUser(){
        echo '<img class="bannericons" src="images/profilepics/' . $this->profileImage . '">';
                            echo '<a href="userpage.php?memId=' . $this->userId . '" >'  .$this->fName . ' ' . $this->lName . '</a><BR></div>';
                            echo'<table>';
                            echo '<tr><td>tweets</td><td>following</td><td>followers</td></tr>';
                            echo '<tr><td>' . $this->noTweets . '</td><td>' . $this->noFollowing . '</td><td>' . $this->noFollowers . '</td></tr>';
                            echo '</table>';
                            echo'<img class="icon" src="images/location_icon.jpg">' . $this->province
                            . '<div class="bold">Member Since:</div>
				<div>' . date('M jS, Y', strtotime($this->dateAdded)) . '</div>';
    }

    Public function getNoSameFollowers($id, $loggedId) {
        global $con;
        $sql = "select user_id, first_name, last_name, screen_name, profile_pic from users where user_id != $id and user_id != $loggedId "
                . "and user_id IN (SELECT to_id from follows where from_id=$id) "
                . "and user_id IN (SELECT to_id from follows where from_id=$loggedId) order by rand()";
        
        $result = mysqli_query($con, $sql);
        $this->noSameFollowers = mysqli_num_rows($result);
        echo $this->noSameFollowers; 
        echo '&nbsp;Followers you know<BR>';
        $i=1;                       
        while ($row = mysqli_fetch_array($result)) {
            if($i>3) break;
            if (isset($row['profile_pic'])) {
                echo '<img class="bannericons" src="images/profilepics/' . $row['profile_pic'] . '">';
            } else {
                echo '<img class="bannericons" src="images/profilepics/default.jfif">';
            }
            $truncateString = substr($row['first_name'] . ' ' . $row['last_name'] . ' @' . $row['screen_name'], 0, 22);
            echo '<a href="userpage.php?memId=' . $row['user_id'] . '" >' . $truncateString . '</a>' . '<br>';

            echo '<hr></hr>';
            $i++;
        }
    }

    public function getSameFollowers($result) {
        global $con;
        while ($row = mysqli_fetch_array($result)) {

            if (isset($row['profile_pic'])) {
                echo '<img class="bannericons" src="images/profilepics/' . $row['profile_pic'] . '">';
            } else {
                echo '<img class="bannericons" src="images/profilepics/default.jfif">';
            }
            $truncateString = substr($row['first_name'] . ' ' . $row['last_name'] . ' @' . $row['screen_name'], 0, 22);
            echo '<a href="userpage.php?memId=' . $row['user_id'] . '" >' . $truncateString . '</a>' . '<br>';

            echo '<hr></hr>';
        }
    }

    public function searchName($keyword, $id) {
        global $con;
        $keywordL = strtolower($keyword);
        $sql = "select user_id, first_name, last_name, screen_name, profile_pic from users where user_id != $id and "
                . "(LOWER(first_name) LIKE '%" . $keywordL . "%' or LOWER(last_name) LIKE '%" . $keywordL . "%' or screen_name LIKE '%" . $keywordL . "%')";
        $result = mysqli_query($con, $sql);
        if (mysqli_num_rows($result) == 0) {
            echo 'Could not find any user with "' . $keyword . '"<br><br><hr></hr>"';
        } else {
            echo '<strong>Users found:</strong>';
            echo '<hr></hr>';
            while ($row = mysqli_fetch_array($result)) {

                $truncateString = substr($row['first_name'] . ' ' . $row['last_name'] . ' @' . $row['screen_name'], 0, 22);
                echo '<a href="userpage.php?memId=' . $row['user_id'] . '" >' . $truncateString . '</a>';
                if ($this->checkFollowing($id, $row['user_id'])) {
                    echo "|Following";
                } else {
                    echo '<a href="follow_proc.php?to_id=' . $row['user_id'] . '"><button class="followbutton" type=button>Follow</button> </a>';
                }
                if ($this->checkFollowing($row['user_id'],$id)) {//swapped parameters to check follow me
                    echo "|Follows You";
                }

                echo '<br><br>';
            }
            echo '<hr></hr>';
        }
    }



    public function checkFollowing($yourId, $followsYouId) {
        global $con;
        $sql = "select * from follows where from_id=$yourId and to_id=$followsYouId";
        $result = mysqli_query($con, $sql);
        if (mysqli_num_rows($result) == 1) {
            return true;
        }
        return false;
    }

}

?>

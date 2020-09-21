<?php

class Tweet {//same name with the file

    private $tweetId;
    private $tweetText;
    private $userId;
    private $originalTweetId;
    private $replyToTweetId;
    private $dateAdded;
    private $fullName;

    //private $originalDateAdded;

    public function __set($propName, $propValue) {
        $this->$propName = $propValue;
    }

    public function __get($property) {//any attribute name, it takes some variables
        return $this->$property;
    }

    public function __construct() {
        
    }

    public function insertTweet() {
        global $con;
        $sqlTweetText = mysqli_escape_string($con, $this->tweetText);
        $sql = "insert into tweets (tweet_text, user_id, original_tweet_id, reply_to_tweet_id) VALUES ( "
                . " '$sqlTweetText', '$this->userId', '$this->originalTweetId', '$this->replyToTweetId')";
        $result = mysqli_query($con, $sql);

        if (mysqli_affected_rows($con) == 1) {
            return true;
        } else {
            return false;
        }
    }

    public function displayMemTweet($id) {
        global $con;
        $sql = "select tweets.user_id, first_name, last_name, screen_name, tweet_text, original_tweet_id, tweets.date_created, tweets.tweet_id from users "
                . "inner join tweets ON users.user_id = tweets.user_id "
                . "where tweets.user_id = '$id' "
                . "and (reply_to_tweet_id=0) order by tweets.tweet_id desc limit 10";
        $result = mysqli_query($con, $sql);
        while ($tweets = mysqli_fetch_array($result)) {
            $tweetUserName = substr($tweets['first_name'] . ' ' . $tweets['last_name'] . ' @' . $tweets['screen_name'], 0, 22);
            //$this->tweetId = $tweets['tweet_id'];
            //$this->dateAdded = $tweets['date_created'];
            //$this->tweetText = $tweets['tweet_text'];
            //$this->originalTweetId = $tweets['original_tweet_id'];
            echo '<a href="userpage.php?memId=' . $tweets['user_id'] . '" >' . $tweetUserName . '</a>' . ' ';
            $this->displayTime($tweets['date_created']);
            if ($tweets['original_tweet_id'] != 0) {
                $originalTweet = $this->cloneTweet($tweets['original_tweet_id']);
                //echo $originalTweet->fullName. ' ';
                //$this->displayTime($originalTweet->originalDateAdded);
                echo ' <strong>retweeted from ' . $originalTweet->fullName . '</strong>';
            }
            echo '<br>';
            echo $tweets['tweet_text'] . '<br>';
            if (Tweet::isLike($tweets['tweet_id'], $_SESSION['SESS_MEMBER_ID'])) {
                echo '<img class="icon" src="images/like.png">';
            } else {
                echo '<a href="LikeTweet.php?tweetId=' . $tweets['tweet_id'] . '"><img class="icon" src="images/like.ico"></a>';
            }
            echo '<a href="Retweet.php?originalTweetId=' . $tweets['tweet_id'] . '"><img class="icon" src="images/retweet.png"></a>';
            echo ' <img id="' . $tweets['tweet_id'] . '" class="icon reply" src="images/reply.png">';
            //$this->displayAddReply($this->tweetId);
            echo '<hr></hr>';
        }
    }

    public function displayTweet($id) {
        global $con;
        $sql = "select tweets.user_id, first_name, last_name, screen_name, tweet_text, original_tweet_id, tweets.date_created, tweets.tweet_id from users "
                . "inner join tweets ON users.user_id = tweets.user_id "
                . "WHERE (users.user_id in (Select follows.to_id FROM follows where follows.from_id = '$id') "
                . "or  users.user_id = '$id' )"
                . "and (reply_to_tweet_id=0) order by tweets.tweet_id desc limit 10";
        $result = mysqli_query($con, $sql);
        while ($tweets = mysqli_fetch_array($result)) {
            $tweetUserName = substr($tweets['first_name'] . ' ' . $tweets['last_name'] . ' @' . $tweets['screen_name'], 0, 22);
            //$this->tweetId = $tweets['tweet_id'];
            //$this->dateAdded = $tweets['date_created'];
            //$this->tweetText = $tweets['tweet_text'];
            //$this->originalTweetId = $tweets['original_tweet_id'];
            echo '<a href="userpage.php?memId=' . $tweets['user_id'] . '" >' . $tweetUserName . '</a>' . ' ';
            $this->displayTime($tweets['date_created']);
            if ($tweets['original_tweet_id'] != 0) {
                $originalTweet = $this->cloneTweet($tweets['original_tweet_id']);
                //echo $originalTweet->fullName. ' ';
                //$this->displayTime($originalTweet->originalDateAdded);
                echo ' <strong>retweeted from ' . $originalTweet->fullName . '</strong>';
            }
            echo '<br>';
            echo $tweets['tweet_text'] . '<br>';
            if (Tweet::isLike($tweets['tweet_id'], $id)) {
                echo '<img class="icon" src="images/like.png">';
            } else {
                echo '<a href="LikeTweet.php?tweetId=' . $tweets['tweet_id'] . '"><img class="icon" src="images/like.ico"></a>';
            }
            echo '<a href="Retweet.php?originalTweetId=' . $tweets['tweet_id'] . '"><img class="icon" src="images/retweet.png"></a>';
            echo ' <img id="' . $tweets['tweet_id'] . '" class="icon reply" src="images/reply.png">';
            //$this->displayAddReply($this->tweetId);
            echo '<hr></hr>';
            $this->getReply($tweets['tweet_id']);
        }
    }

    public function getReply($replyToId = 0, $marginleft = 0) {
        global $con;
        $sql = "select tweets.user_id, first_name, last_name, screen_name, tweet_text, original_tweet_id, tweets.date_created, tweets.tweet_id from users "
                . "inner join tweets ON users.user_id = tweets.user_id  where reply_to_tweet_id='$replyToId'";
        $result = mysqli_query($con, $sql);
        if ($replyToId == 0) {
            $marginleft += 0;
        } else {
            $marginleft += 40;
        }
        while ($tweets = mysqli_fetch_array($result)) {
            $tweetUserName = substr($tweets['first_name'] . ' ' . $tweets['last_name'] . ' @' . $tweets['screen_name'], 0, 22);
//            $this->tweetId = $tweets['tweet_id'];
//            $this->dateAdded = $tweets['date_created'];
//            $this->tweetText = $tweets['tweet_text'];
//            $this->originalTweetId = $tweets['original_tweet_id'];

            echo '<div class="img-rounded" style="margin-left:' . $marginleft . 'px">';
            echo '<a href="userpage.php?memId=' . $tweets['user_id'] . '" >' . $tweetUserName . '</a>' . ' ';
            $this->displayTime($tweets['date_created']);

            echo '<br>';
            echo $tweets['tweet_text'] . '<br>';
            echo '<img class="icon" src="images/like.ico">';
            //echo '<a href="Tweet_proc.php?originalTweetId=' . $this->tweetId . '"><img class="icon" src="images/retweet.png"></a>';
            echo ' <img id="' . $tweets['tweet_id'] . '" class="icon reply" src="images/reply.png">';
            //$this->displayAddReply($this->tweetId);
            echo '<hr></hr>';
            echo '</div>';
            $this->getReply($tweets['tweet_id'], $marginleft);
        }
    }

    public function displayTime($date) {
        global $con;
        date_default_timezone_set('America/Halifax');
        $now = new DateTime();
        $tweetTime = new DateTime($date);
        $interval = $tweetTime->diff($now);

        if ($interval->y > 1)
            echo $interval->format('%y years') . " ago";
        elseif ($interval->y > 0)
            echo $interval->format('%y year') . " ago";
        elseif ($interval->m > 1)
            echo $interval->format('%m months') . " ago";
        elseif ($interval->m > 0)
            echo $interval->format('%m month') . " ago";
        elseif ($interval->d > 1)
            echo $interval->format('%d days') . " ago";
        elseif ($interval->d > 0)
            echo $interval->format('%d day') . " ago";
        elseif ($interval->h > 1)
            echo $interval->format('%h hours') . " ago";
        elseif ($interval->h > 0)
            echo $interval->format('%h hour') . " ago";
        elseif ($interval->i > 1)
            echo $interval->format('%i minutes') . " ago";
        elseif ($interval->i > 0)
            echo $interval->format('%i minute') . " ago";
        elseif ($interval->s > 1)
            echo $interval->format('%s seconds') . " ago";
        elseif ($interval->s > 0)
            echo $interval->format('%s second') . " ago";
    }

    public function cloneTweet($id) {
        global $con;
        $sql = "select first_name, last_name, screen_name, tweet_text, tweets.date_created from tweets inner join users "
                . "on users.user_id = tweets.user_id where tweet_id=$id";
        $result = mysqli_query($con, $sql);
        while ($tweets = mysqli_fetch_array($result)) {
            $this->originalTweetId = $id;
            $this->tweetText = $tweets['tweet_text'];
            //create fullName property for the tweet owner to display on screen
            $this->fullName = $tweets['first_name'] . ' ' . $tweets['last_name'];
        }
        return $this;
    }

    public function searchTweets($keyword) {
        global $con;
        $keywordL = strtolower($keyword);
        $sql = "select tweets.user_id, first_name, last_name, screen_name, tweet_text, original_tweet_id, tweets.date_created, tweets.tweet_id from users "
                . "inner join tweets ON users.user_id = tweets.user_id "
                . "WHERE LOWER(tweet_text) LIKE '%" . $keywordL . "%'"
                . "and (reply_to_tweet_id=0) order by tweets.tweet_id desc";
        $result = mysqli_query($con, $sql);
        if (mysqli_num_rows($result) == 0) {
            echo 'Could not find any tweet with "' . $keyword . '"<br><br><hr></hr>';
        } else {
            echo '<strong>Tweets found:</strong><br><br>';
            while ($tweets = mysqli_fetch_array($result)) {
                $tweetUserName = substr($tweets['first_name'] . ' ' . $tweets['last_name'] . ' @' . $tweets['screen_name'], 0, 22);
                //$this->tweetId = $tweets['tweet_id'];
                //$this->dateAdded = $tweets['date_created'];
                //$this->tweetText = $tweets['tweet_text'];
                //$this->originalTweetId = $tweets['original_tweet_id'];
                echo '<a href="userpage.php?memId=' . $tweets['user_id'] . '" >' . $tweetUserName . '</a>' . ' ';
                $this->displayTime($tweets['date_created']);
                if ($tweets['original_tweet_id'] != 0) {
                    $originalTweet = $this->cloneTweet($tweets['original_tweet_id']);
                    //echo $originalTweet->fullName. ' ';
                    //$this->displayTime($originalTweet->originalDateAdded);
                    echo ' <strong>retweeted from ' . $originalTweet->fullName . '</strong>';
                }
                echo '<br>';
                echo $tweets['tweet_text'] . '<br>';
                if (Tweet::isLike($tweets['tweet_id'], $_SESSION['SESS_MEMBER_ID'])) {
                    echo '<img class="icon" src="images/like.png">';
                } else {
                    echo '<a href="LikeTweet.php?tweetId=' . $tweets['tweet_id'] . '"><img class="icon" src="images/like.ico"></a>';
                }
                echo '<a href="Retweet.php?originalTweetId=' . $tweets['tweet_id'] . '"><img class="icon" src="images/retweet.png"></a>';
                echo ' <img id="' . $tweets['tweet_id'] . '" class="icon reply" src="images/reply.png">';
                //$this->displayAddReply($this->tweetId);
                echo '<hr></hr>';
            }
        }
    }

    public static function isLike($tweetId, $userId) {
        global $con;
        $sql = "select * from likes where tweet_id = $tweetId and user_id = $userId";
        $result = mysqli_query($con, $sql);
        $row = mysqli_num_rows($result);
        if ($row > 0)
            return true;
        else
            return false;
    }

    public function like($tweetId, $userId) {
        global $con;
        $sql = "insert into likes (tweet_id, user_id) VALUES ($tweetId, $userId)";
        $result = mysqli_query($con, $sql);
        if (mysqli_affected_rows($con) == 1) {
            return true;
        } else {
            return false;
        }
    }

    public function displayLike($id) {
        global $con;
        $sql = "select users.user_id, first_name, last_name, screen_name, tweet_text, original_tweet_id, likes.date_created, tweets.tweet_id from users "
                . "inner join likes ON users.user_id = likes.user_id "
                . "inner join tweets ON tweets.tweet_id = likes.tweet_id "
                . "where "
                . "likes.tweet_id in (select tweets.tweet_id from tweets where tweets.user_id = $id) "
                . "order by likes.date_created desc";
        $result = mysqli_query($con, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($tweets = mysqli_fetch_array($result)) {
                $tweetUserName = substr($tweets['first_name'] . ' ' . $tweets['last_name'] . ' @' . $tweets['screen_name'], 0, 22);

                echo '<a href="userpage.php?memId=' . $tweets['user_id'] . '" >' . $tweetUserName . '</a>' . ' liked your tweet ';
                $this->displayTime($tweets['date_created']);
                
                if ($tweets['original_tweet_id'] != 0) {
                    $originalTweet = $this->cloneTweet($tweets['original_tweet_id']);
                    //echo $originalTweet->fullName. ' ';
                    //$this->displayTime($originalTweet->originalDateAdded);
                    echo ' <br><strong>retweeted from ' . $originalTweet->fullName . '</strong>';
                }
                echo '<br>';
                echo $tweets['tweet_text'] . '<br>';
                echo '<hr></hr>';
            }
        }
    }
    public function displayRetweets($id) {
        global $con;
        $sql = "select users.user_id, first_name, last_name, screen_name, tweet_text, original_tweet_id, tweets.date_created, tweets.tweet_id from users "
                . "inner join tweets ON users.user_id = tweets.user_id "
                . "where original_tweet_id in (select tweets.tweet_id from tweets where tweets.user_id = $id)"
                . "order by tweets.date_created desc";
        $result = mysqli_query($con, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($tweets = mysqli_fetch_array($result)) {
                $tweetUserName = substr($tweets['first_name'] . ' ' . $tweets['last_name'] . ' @' . $tweets['screen_name'], 0, 22);

                echo '<a href="userpage.php?memId=' . $tweets['user_id'] . '" >' . $tweetUserName . '</a>' . ' retweeted your tweet ';
                $this->displayTime($tweets['date_created']);
                
                if ($tweets['original_tweet_id'] != 0) {
                    $originalTweet = $this->cloneTweet($tweets['original_tweet_id']);
                    //echo $originalTweet->fullName. ' ';
                    //$this->displayTime($originalTweet->originalDateAdded);
                    echo ' <br><strong>retweeted from ' . $originalTweet->fullName . '</strong>';
                }
                echo '<br>';
                echo $tweets['tweet_text'] . '<br>';
                echo '<hr></hr>';
            }
        }
    }
    public function displayReply($id) {
        global $con;
        $sql = "select users.user_id, first_name, last_name, screen_name, tweet_text, original_tweet_id, reply_to_tweet_id, tweets.date_created, tweets.tweet_id from users "
                . "inner join tweets ON users.user_id = tweets.user_id "
                . "where reply_to_tweet_id in (select tweets.tweet_id from tweets where tweets.user_id = $id) "
                . "order by tweets.date_created desc";
        $result = mysqli_query($con, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($tweets = mysqli_fetch_array($result)) {
                $tweetUserName = substr($tweets['first_name'] . ' ' . $tweets['last_name'] . ' @' . $tweets['screen_name'], 0, 22);

                echo '<a href="userpage.php?memId=' . $tweets['user_id'] . '" >' . $tweetUserName . '</a>' . ' replied your tweet ';
                $this->displayTime($tweets['date_created']);
                
                if ($tweets['original_tweet_id'] != 0) {
                    $originalTweet = $this->cloneTweet($tweets['original_tweet_id']);
                    //echo $originalTweet->fullName. ' ';
                    //$this->displayTime($originalTweet->originalDateAdded);
                    echo ' <br><strong>retweeted from ' . $originalTweet->fullName . '</strong>';
                }
                echo '<br>';
                echo $tweets['tweet_text'] . '<br>';
                echo '<hr></hr>';
            }
        }
    }

}
?>


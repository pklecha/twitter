<?php

/**
 * Created by PhpStorm.
 * User: Pawel
 * Date: 21.03.2017
 * Time: 15:46
 */
class Tweet
{
    private $id;
    private $userId;
    private $text;
    private $creationDate;

    public function __construct()
    {
        $this->id = -1;
        $this->userId = '';
        $this->text = '';
        $this->creationDate = '';
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @return string
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @param string $userId
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    /**
     * @param string $text
     */
    public function setText($text)
    {
        $this->text = $text;
    }

    /**
     * @param string $creationDate
     */
    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;
    }

    public function saveToDB(mysqli $conn, $userId)
    {
        if ($this->id == -1 && $userId != -1) {
            $sql = sprintf("INSERT INTO twitter.tweet (`text`, `user_id`, `creation_date`) VALUES ('%s', '%d', '%d')", $this->getText(), $userId, time());
            $result = $conn->query($sql);
            if ($result == true) {
                $this->id = $conn->insert_id;
            }
            return $result;
        } else {
            $sql = sprintf("UPDATE twitter.tweet SET (`text`, `user_id`, `creation_date`) VALUES ('%s', '%d', '%d')", $this->getText(), $this->getUserId(), time());
            $result = $conn->query($sql);
            if ($result) {
                return true;
            }
            return false;
        }
    }

    static public function loadTweetById(mysqli $conn, $id)
    {
        $id = $conn->real_escape_string($id);
        $sql = "SELECT * FROM twitter.tweet WHERE id=$id";
        $result = $conn->query($sql);


        if ($result->num_rows == 1) {
            $tweetArray = $result->fetch_assoc();
            $tweet = new Tweet();
            $tweet->setId($tweetArray['id']);
            $tweet->setText($tweetArray['text']);
            $tweet->setUserId($tweetArray['user_id']);
            $tweet->setCreationDate($tweetArray['creation_date']);

            return $tweet;
        }
    }

    static public function loadAllTweetsByUserId(mysqli $conn, $userId)
    {
        $allTweets = [];

        $userId = $conn->real_escape_string($userId);
        $sql = "SELECT * FROM twitter.tweet WHERE twitter.user_id = $userId";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            $tweetsArray = $result->fetch_assoc();

            foreach ($tweetsArray as $row) {
                $tweet = new Tweet();
                $tweet->setId($row['id']);
                $tweet->setText($row['text']);
                $tweet->setUserId($row['user_id']);
                $tweet->setCreationDate($row['creation_date']);

                $allTweets[] = $tweet;
            }
        }

        return $allTweets;
    }

    static public function loadAllTweets(mysqli $conn)
    {
        $allTweets = [];
        $sql = "SELECT * FROM twitter.tweet ORDER BY id DESC";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $tweet = new Tweet();
                $tweet->setId($row['id']);
                $tweet->setText($row['text']);
                $tweet->setUserId($row['user_id']);
                $tweet->setCreationDate($row['creation_date']);

                $allTweets[] = $tweet;
            }
            return $allTweets;
        }
        return null;
    }

}
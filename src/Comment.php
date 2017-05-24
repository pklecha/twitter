<?php

/**
 * Created by PhpStorm.
 * User: pawelklecha
 * Date: 23/05/2017
 * Time: 17:25
 */
class Comment
{
    private $id;
    private $creation_date;
    private $tweetId;
    private $userId;
    private $comment;

    public function __construct()
    {
        $this->id = -1;
        $this->tweetId = -1;
        $this->userId = -1;
        $this->comment = "";
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getTweetId()
    {
        return $this->tweetId;
    }

    /**
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @param int $tweetId
     */
    public function setTweetId($tweetId)
    {
        $this->tweetId = $tweetId;
    }

    /**
     * @param int $userId
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    /**
     * @param string $comment
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
    }

    /**
     * @return mixed
     */
    public function getCreationDate()
    {
        return $this->creation_date;
    }

    /**
     * @param mixed $creation_date
     */
    public function setCreationDate($creation_date)
    {
        $this->creation_date = $creation_date;
    }



    public function saveToDB(mysqli $conn)
    {
        if (-1 === $this->id) {
            $sql = sprintf("INSERT INTO twitter.comment (`creation_date`, `comment`, `tweet_id`, `user_id`) VALUES('%d','%s','%d','%d')", $this->creation_date, $this->comment, $this->tweetId, $this->userId);

            $result = $conn->query($sql);

            if($result) {
                $this->id = $conn->insert_id;
                return true;
            }
            return false;
        } else {
            $sql = sprintf("UPDATE twitter.comment SET comment='%s', tweet_id='%d', user_id='%d', creation_date='%d' WHERE id='%d'",
                $this->comment, $this->tweetId, $this->userId, $this->creation_date, $this->id);
            $result = $conn->query($sql);

            if ($result) {
                return true;
            }
            return false;
        }
    }

    static public function loadCommentById(mysqli $conn, $id)
    {

    }
    
    static public function loadCommentsbyTweet(mysqli $conn, $tweetId)
    {
        $comments = [];
        $sql = "SELECT * FROM comment WHERE tweet_id=" . $tweetId . " ORDER BY id DESC";

        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $comment = new Comment();
                $comment->id = $row['id'];
                $comment->comment = $row['comment'];
                $comment->tweetId = $row['tweet_id'];
                $comment->userId = $row['user_id'];
                $comment->creation_date = $row['creation_date'];

                $comments[] = $comment;
            }
            return $comments;
        }
        return null;
    }

    static public function loadCommentsByUser(mysqli $conn, $userId)
    {

    }
}
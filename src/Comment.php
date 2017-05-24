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

    public function saveToDB(mysqli $conn)
    {
        if (-1 === $this->id) {
            $sql = sprintf("INSERT INTO twitter.comment (`comment`, `tweet_id`, `user_id`) VALUES('%s','%d','%d')", $this->comment, $this->tweetId, $this->userId);

            $result = $conn->query($sql);

            if($result) {
                $this->id = $conn->insert_id;
                return true;
            }
            return false;
        } else {
            $sql = sprintf("UPDATE twitter.comment SET comment='%s', tweet_id='%d', user_id='%d' WHERE id='%d'",
                $this->comment, $this->tweetId, $this->userId, $this->id);
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
        
    }

    static public function loadCommentsByUser(mysqli $conn, $userId)
    {

    }
}
<?php

/**
 * Created by PhpStorm.
 * User: pawelklecha
 * Date: 23/05/2017
 * Time: 17:25
 */
class Message
{
    private $id;
    private $senderId;
    private $recipientId;
    private $message;
    private $isRead;

    public function __construct()
    {
        $this->id = -1;
        $this->senderId = -1;
        $this->recipientId = -1;
        $this->message = "";
        $this->isRead = false;
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
    public function getSenderId()
    {
        return $this->senderId;
    }

    /**
     * @return int
     */
    public function getRecipientId()
    {
        return $this->recipientId;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @return bool
     */
    public function isRead()
    {
        return $this->isRead;
    }

    /**
     * @param int $senderId
     */
    public function setSenderId($senderId)
    {
        $this->senderId = $senderId;
    }

    /**
     * @param int $recipientId
     */
    public function setRecipientId($recipientId)
    {
        $this->recipientId = $recipientId;
    }

    /**
     * @param string $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * @param bool $isRead
     */
    public function setIsRead($isRead)
    {
        $this->isRead = $isRead;
    }

    public function saveToDB(mysqli $conn)
    {
        if ($this->isRead) {
            $isRead = 1;
        } else {
            $isRead = 0;
        }

        if (-1 === $this->id) {

            $sql = sprintf("INSERT INTO twitter.message (`message`, `sender_id`, `recipient_id`, `is_read`) VALUES('%s','%d','%d', '%d')", $this->message, $this->senderId, $this->recipientId, $isRead);

            $result = $conn->query($sql);

            if($result) {
                $this->id = $conn->insert_id;
                return true;
            }
            return false;
        } else {
            $sql = sprintf("UPDATE twitter.message SET message='%s', sender_id='%d', recipient_id='%d', is_read='%d' WHERE id='%d'", $this->message, $this->senderId, $this->recipientId, $this->id, $isRead);
            $result = $conn->query($sql);

            if ($result) {
                return true;
            }
            return false;
        }
    }

    static public function loadMessageById(mysqli $conn, $id)
    {

    }

    static public function loadAllMessagesByUser(mysqli $conn, $userId)
    {

    }

    static public function loadReceivedMessagesByUser(mysqli $conn, $recipientId)
    {

    }
}
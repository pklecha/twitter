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
    private $creation_date;

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
        if ($this->isRead) {
            $isRead = 1;
        } else {
            $isRead = 0;
        }

        if (-1 === $this->id) {

            $sql = sprintf("INSERT INTO twitter.message (`message`, `sender_id`, `recipient_id`, `is_read`, `creation_date`) VALUES('%s','%d','%d', '%d', '%d')", $this->message, $this->senderId, $this->recipientId, $isRead, $this->creation_date);

            $result = $conn->query($sql);

            if($result) {
                $this->id = $conn->insert_id;
                return true;
            }
            return false;
        } else {
            $sql = sprintf("UPDATE twitter.message SET message='%s', sender_id='%d', recipient_id='%d', is_read='%d', creation_date='%d' WHERE id='%d'", $this->message, $this->senderId, $this->recipientId, $isRead, $this->creation_date, $this->id);
            $result = $conn->query($sql);

            if ($result) {
                return true;
            }
            return false;
        }
    }

    static public function loadMessageById(mysqli $conn, $id)
    {
        $sql = "SELECT * FROM message WHERE id=" . $id;
        $result = $conn->query($sql);

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $message = new Message();
            $message->id = $row['id'];
            $message->message = $row['message'];
            $message->isRead = $row['is_read'];
            $message->senderId = $row['sender_id'];
            $message->recipientId = $row['recipient_id'];
            $message->creation_date = $row['creation_date'];

            return $message;
        }
    }

    static public function loadSentMessagesByUser(mysqli $conn, $senderId)
    {
        $messages = [];
        $senderId = $conn->real_escape_string($senderId);
        $sql = "SELECT * FROM message WHERE sender_id=" . $senderId . " ORDER BY id DESC";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $message = new Message();
                $message->id = $row['id'];
                $message->message = $row['message'];
                $message->senderId = $row['sender_id'];
                $message->recipientId = $row['recipient_id'];
                $message->creation_date = $row['creation_date'];
                $message->isRead = $row['is_read'];

                $messages[] = $message;
            }

            return $messages;
        }
        return null;
    }

    static public function loadReceivedMessagesByUser(mysqli $conn, $recipientId)
    {
        $messages = [];
        $senderId = $conn->real_escape_string($recipientId);
        $sql = "SELECT * FROM message WHERE recipient_id=" . $recipientId . " ORDER BY id DESC";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $message = new Message();
                $message->id = $row['id'];
                $message->message = $row['message'];
                $message->senderId = $row['sender_id'];
                $message->recipientId = $row['recipient_id'];
                $message->creation_date = $row['creation_date'];
                $message->isRead = $row['is_read'];

                $messages[] = $message;
            }

            return $messages;
        }
        return null;
    }
}
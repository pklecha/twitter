<?php

session_start();

require_once '../src/connection.php';
require_once '../src/User.php';
require_once '../src/Message.php';

$errorMessage = "";

if (!isset($_GET['id'])) {
    header('Location: index.php');
}

if (isset($_SESSION['user'])) {
    $user = User::loadUserById($conn, $_SESSION['user']);
    $username = $user->getUsername();
    $message = Message::loadMessageById($conn, $_GET['id']);
    if (!$message->isRead()) {
        $message->setIsRead(true);
        $message->saveToDB($conn);
    }
} else {
    header('Location: login-register.php');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['replyAdd'])) {

    if(empty($_POST['replyText'])) {
        $errorMessage .= "<li>Your reply cannot be empty</li>";
    } elseif (strlen(trim($_POST['replyText'])) > 60) {
        $errorMessage .= "<li>Your message cannot be longer than 60 characters</li>";
    } else {
        $reply = new Message();
        $reply->setMessage($conn->real_escape_string($_POST['replyText']));
        $reply->setSenderId($_SESSION['user']);
        $reply->setRecipientId($message->getSenderId());
        $reply->setCreationDate(time());

        $sendReply = $reply->saveToDB($conn);
        $success = true;
    }

    if (!empty($errorMessage)) {
        $rawMessage = $errorMessage;
        $errorMessage = "<ul>" . $errorMessage . "</ul>";
    }
}



require_once 'templates/header.php';

?>

<div class="container main-content">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <h1>Message details</h1>
            <p>
                <a href="messages.php">&laquo; Back to list</a>
            </p>
            <p class="tweet-details">
            <?php
                echo "<strong>" . date("F j, Y", $message->getCreationDate()) . "</strong>";
                if ($message->getRecipientId() == $_SESSION['user']) {
                    $sender = User::loadUserById($conn, $message->getSenderId());
                    echo " from <strong><a href='profile.php?id=" . $sender->getId() . "'>" . $sender->getUsername() . "</strong></a>";
                } else {
                    $recipient = User::loadUserById($conn, $message->getRecipientId());
                    echo " to <strong><a href='profile.php?id=" . $recipient->getId() . "'>" . $recipient->getUsername() . "</strong></a>";
                }
            ?>
            </p>
            <p class="tweet-content"><?php echo $message->getMessage() ?></p>
            <?php if($message->getRecipientId() == $_SESSION['user']) : ?>
            <h4 class="mt-4">Reply</h4>
            <form action="" method="post">
                <div class="alert alert-danger mb-3 <?php if(empty($errorMessage)) { echo ' hidden'; } ?>">
                    <?php echo $errorMessage ?>
                </div>
                <div class="alert alert-success mb-3 login-screen <?php if(!isset($success)) {echo 'hidden';} ?>">
                    Your reply has been sent
                </div>
                <div class="form-group">
                    <textarea name="replyText" id="replyText" cols="30" rows="2" placeholder="Enter message" class="form-control"></textarea>
                    <small>60 characters max</small>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary" type="submit" name="replyAdd">Send reply</button>
                </div>
            </form>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php

require_once 'templates/footer.php';
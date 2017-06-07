<?php

session_start();

require_once '../src/connection.php';
require_once '../src/User.php';
require_once '../src/Tweet.php';
require_once '../src/Comment.php';
require_once '../src/Message.php';

$errorMessage = "";

if (!isset($_GET['id'])) {
    header('Location: index.php');
} else {
    $profile = User::loadUserById($conn, $_GET['id']);
    $profileTweets = Tweet::loadAllTweetsByUserId($conn, $profile->getId());
}

if (isset($_SESSION['user'])) {
    $user = User::loadUserById($conn, $_SESSION['user']);
} else {
    header('Location: login-register.php');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['messageAdd'])) {

    if(empty($_POST['messageText'])) {
        $errorMessage .= "<li>Your message cannot be empty</li>";
    } elseif (strlen(trim($_POST['messageText'])) > 60) {
        $errorMessage .= "<li>Your message cannot be longer than 60 characters</li>";
    } else {
        $newMessage = new Message();
        $newMessage->setMessage($conn->real_escape_string($_POST['messageText']));
        $newMessage->setSenderId($_SESSION['user']);
        $newMessage->setRecipientId($profile->getId());
        $newMessage->setCreationDate(time());

        $sendReply = $newMessage->saveToDB($conn);
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
            <h1><?php echo $profile->getUsername() ?></h1>
            <p>
                <a href="messages.php">&laquo; Back to list</a>
            </p>
            <h4>Send message</h4>
            <form action="" method="post">
                <div class="alert alert-danger mb-3 <?php if(empty($errorMessage)) { echo ' hidden'; } ?>">
                    <?php echo $errorMessage ?>
                </div>
                <div class="alert alert-success mb-3 login-screen <?php if(!isset($success)) {echo 'hidden';} ?>">
                    Your message has been sent
                </div>
                <div class="form-group">
                    <textarea name="messageText" id="messageText" cols="30" rows="2" placeholder="Enter message" class="form-control"></textarea>
                    <small>60 characters max</small>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary" type="submit" name="messageAdd">Send message</button>
                </div>
            </form>
            <h4>Tweets</h4>
            <?php if (count($profileTweets) > 0): ?>
            <?php foreach ($profileTweets as $tweet): ?>
                <div class="tweet">
                    <?php
                    $date = date("F j, Y", $tweet->getCreationDate());
                    $commentsQuantity = count(Comment::loadCommentsbyTweet($conn, $tweet->getId()));
                    ?>
                    <p class="tweet-details"><strong><?php echo $date ?></strong></p>
                    <p class="tweet-content"><a href="tweet.php?id=<?php echo $tweet->getId() ?>"><?php echo $tweet->getText() ?></a></p>
                    <p class="tweet-comments"><strong><?php echo $commentsQuantity ?> comments</strong></p>
                </div>
            <?php endforeach; ?>
            <?php else: ?>
                <p>User hasn't posted any tweets yet</p>
            <?php endif; ?>
        </div>
    </div>
</div>


<?php

require_once 'templates/footer.php';

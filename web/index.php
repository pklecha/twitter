<?php

session_start();

require_once '../src/connection.php';
require_once '../src/User.php';
require_once '../src/Tweet.php';
require_once '../src/Comment.php';

$errorMessage = "";

if (isset($_SESSION['user'])) {
    $user = User::loadUserById($conn, $_SESSION['user']);
    $username = $user->getUsername();
} else {
    header('Location: login-register.php');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['addTweet'])) {
    $text = $conn->real_escape_string($_POST['addTweetText']);
    if (empty($text)) {
        $errorMessage .= "Your tweet cannot be empty";
    } elseif (strlen($text) > 140) {
        $errorMessage .= "A tweet cannot exceed 140 characters";
    } else {
        $newTweet = new Tweet();

        $newTweet->setText($text);
        $newTweet->setUserId($user->getId());
        $newTweet->setCreationDate(time());

        $test = $newTweet->saveToDB($conn, $user->getId());
    }
}

require_once 'templates/header.php';

?>


<div class="container main-content">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="alert alert-danger<?php if(empty($errorMessage)) { echo ' hidden'; } ?>">
                <?php echo $errorMessage ?>
            </div>
            <?php
            $allTweets = Tweet::loadAllTweets($conn);
            foreach ($allTweets as $tweet):
            ?>
            <div class="tweet">
                <?php
                    $author = User::loadUserById($conn, $tweet->getUserId());
                    $date = date("F j, Y", $tweet->getCreationDate());
                    $commentsQuantity = count(Comment::loadCommentsbyTweet($conn, $tweet->getId()));
                ?>
                <p class="tweet-details"><strong><?php echo $date ?></strong> by <strong><a href="profile.php?id=<?php echo $author->getId() ?>"><?php echo $author->getUsername() ?></a></strong></p>
                <p class="tweet-content"><a href="tweet.php?id=<?php echo $tweet->getId() ?>"><?php echo $tweet->getText() ?></a></p>
                <p class="tweet-comments"><strong><?php echo $commentsQuantity ?> comments</strong></p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<?php
require_once 'templates/footer.php';
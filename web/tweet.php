<?php

session_start();

require_once '../src/connection.php';
require_once '../src/User.php';
require_once '../src/Tweet.php';
require_once '../src/Comment.php';

$errorMessage = "";

if (!isset($_GET['id'])) {
    header('Location: index.php');
}

if (isset($_SESSION['user'])) {
    $user = User::loadUserById($conn, $_SESSION['user']);
    $tweet = Tweet::loadTweetById($conn, $_GET['id']);
    $comments = Comment::loadCommentsbyTweet($conn, $_GET['id']);
    $username = $user->getUsername();
    $author = User::loadUserById($conn, $tweet->getUserId());
    $date = date("F j, Y", $tweet->getCreationDate());
} else {
    header('Location: login-register.php');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['tweetCommentAdd'])) {
    $text = $conn->real_escape_string($_POST['tweetCommentText']);
    if (empty($text)) {
        $errorMessage .= "Please add your comment";
    } elseif (strlen($text) > 60) {
        $errorMessage .= "Comment cannot exceed 60 characters";
    } else {
        $newComment = new Comment();

        $newComment->setComment($text);
        $newComment->setUserId($user->getId());
        $newComment->setTweetId($tweet->getId());
        $newComment->setCreationDate(time());

        $newComment->saveToDB($conn);

        $comments = Comment::loadCommentsbyTweet($conn, $_GET['id']);
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
    <link rel="stylesheet" href="css/custom.css">
</head>
<body>

<nav class="navbar fixed-top navbar-light light-blue-bckg">
    <div class="container">
        <nav class="navbar navbar-toggleable-md">
            <a class="navbar-brand" href="index.php">Welcome, <strong><?php echo $user->getUsername(); ?></strong></a>
            <ul class="navbar-nav mr-auto"></ul>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <button class="btn btn-primary" data-toggle="modal" data-target="#addTweet">+ Add tweet</button>
                </li>
                <li class="nav-item">
                    <a class="nav-link top-nav" href="">Messages</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link top-nav" href="">My Account</a>
                </li>
                <li class="nav-item">
                    <a href="" class="nav-link top-nav">Logout</a>
                </li>
            </ul>
        </nav>
    </div>
</nav>

<div class="container tweets-list">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <p>
                <a href="index.php">&laquo; Back to list</a>
            </p>
            <p class="tweet-details"><strong><?php echo $date ?></strong> by <strong><?php echo $author->getUsername() ?></strong></p>
            <p class="tweet-content"><?php echo $tweet->getText() ?></p>

            <h4 class="mt-4"><?php echo count($comments) ?> comments</h4>
            <?php if (count($comments)>0):?>
            <?php foreach ($comments as $comment): ?>
            <blockquote class="blockquote">
                <p class="tweet-comment-author"><strong><?php echo date("F j, Y", $comment->getCreationDate()); ?></strong> by <strong><?php echo $author->getUsername() ?></strong></p>
                <p class="mb-0 tweet-comment"><?php echo $comment->getComment() ?></p>
            </blockquote>
            <?php endforeach; ?>
            <?php endif; ?>
            <h4 class="mt-4">Add new comment</h4>
            <form action="" method="post">
                <div class="alert alert-danger<?php if(empty($errorMessage)) { echo ' hidden'; } ?>">
                    <?php echo $errorMessage ?>
                </div>
                <div class="form-group">
                    <textarea name="tweetCommentText" id="tweetCommentText" cols="30" rows="2" placeholder="Enter comment" class="form-control"></textarea>
                    <small>60 characters max</small>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary" type="submit" name="tweetCommentAdd">Add comment</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Add New Tweet Modal -->
<div class="modal fade" id="addTweet" tabindex="-1" role="dialog" aria-labelledby="addNewTweetModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add new tweet</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="index.php" method="post" id="addTweetForm">
                    <div class="form-group">
                        <textarea name="addTweetText" id="addTweetText" cols="30" rows="2" placeholder="Enter your tweet" class="form-control"></textarea>
                        <small>140 characters max</small>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" form="addTweetForm" name="addTweet" class="btn btn-primary">Add tweet</button>
            </div>
        </div>
    </div>
</div>



<!-- jQuery first, then Tether, then Bootstrap JS. -->
<script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
</body>
</html>
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

require_once 'templates/header.php';

?>


<div class="container main-content">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <p>
                <a href="index.php">&laquo; Back to list</a>
            </p>
            <p class="tweet-details"><strong><?php echo $date ?></strong> by <strong><a href="profile.php?id=<?php echo $author->getId() ?>"><?php echo $author->getUsername() ?></a></strong></p>
            <p class="tweet-content"><?php echo $tweet->getText() ?></p>

            <h4 class="mt-4"><?php echo count($comments) ?> comments</h4>
            <?php if (count($comments)>0):?>
            <?php foreach ($comments as $comment): ?>
            <blockquote class="blockquote">
                <p class="tweet-comment-author"><strong><?php echo date("F j, Y", $comment->getCreationDate()); ?></strong> by <strong><a href="profile.php?id=<?php echo $author->getId() ?>"><?php echo $author->getUsername() ?></a></strong></p>
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

<?php

require_once 'templates/footer.php';
<?php

session_start();

require_once '../src/connection.php';
require_once '../src/User.php';
require_once '../src/Tweet.php';

if (isset($_SESSION['user'])) {
    $user = User::loadUserById($conn, $_SESSION['user']);
    $username = $user->getUsername();
} else {
    header('Location: login-register.php');
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
            <a class="navbar-brand" href="#">Welcome, <strong><?php echo $username ?></strong></a>
            <ul class="navbar-nav mr-auto"></ul>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link top-nav" href="">Messages</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link top-nav" href="">My Account</a>
                </li>
                <li class="nav-item">
                    <a href="logout.php" class="nav-link top-nav">Logout</a>
                </li>
            </ul>
        </nav>
    </div>
</nav>

<div class="container tweets-list">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <?php
            $allTweets = Tweet::loadAllTweets($conn);
            echo "<pre>";
            var_dump($allTweets);
            echo "</pre>";

            foreach ($allTweets as $item) {
                echo $item;
            }
            ?>
            <div class="tweet">
                <a href="">
                    <p class="tweet-details"><strong>22 May 2017</strong> by <strong>pklecha</strong></p>
                    <p class="tweet-content">Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at, turpis.</p>
                    <p class="tweet-comments"><strong>2 comments</strong></p>
                </a>
            </div>
            <div class="tweet">
                <a href="">
                    <p class="tweet-details"><strong>22 May 2017</strong> by <strong>pklecha</strong></p>
                    <p class="tweet-content">Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at, turpis.</p>
                    <p class="tweet-comments"><strong>2 comments</strong></p>
                </a>
            </div>
            <div class="tweet">
                <a href="">
                    <p class="tweet-details"><strong>22 May 2017</strong> by <strong>pklecha</strong></p>
                    <p class="tweet-content">Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at, turpis.</p>
                    <p class="tweet-comments"><strong>2 comments</strong></p>
                </a>
            </div>
            <div class="tweet">
                <a href="">
                    <p class="tweet-details"><strong>22 May 2017</strong> by <strong>pklecha</strong></p>
                    <p class="tweet-content">Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at, turpis.</p>
                    <p class="tweet-comments"><strong>2 comments</strong></p>
                </a>
            </div>
            <div class="tweet">
                <a href="">
                    <p class="tweet-details"><strong>22 May 2017</strong> by <strong>pklecha</strong></p>
                    <p class="tweet-content">Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at, turpis.</p>
                    <p class="tweet-comments"><strong>2 comments</strong></p>
                </a>
            </div>
            <div class="tweet">
                <a href="">
                    <p class="tweet-details"><strong>22 May 2017</strong> by <strong>pklecha</strong></p>
                    <p class="tweet-content">Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at, turpis.</p>
                    <p class="tweet-comments"><strong>2 comments</strong></p>
                </a>
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
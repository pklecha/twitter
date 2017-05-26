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
                    <button class="btn btn-primary" data-toggle="modal" data-target="#addTweet">+ Add tweet</button>
                </li>
                <li class="nav-item">
                    <a class="nav-link top-nav" href="messages.php">Messages</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link top-nav" href="account.php">My Account</a>
                </li>
                <li class="nav-item">
                    <a href="logout.php" class="nav-link top-nav">Logout</a>
                </li>
            </ul>
        </nav>
    </div>
</nav>
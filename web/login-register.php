<?php

require_once '../src/connection.php';
require_once '../src/User.php';

$displayLoginError = false;
$displayRegisterError = false;
$errorMessage = "";

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['loginForm'])) {

        $username = $_POST['loginUsername'];
        $password = $_POST['loginPassword'];
        $user = User::loadUserByUsername($conn, $username);

        if (empty($username) || empty($password)) {
            $errorMessage = "<li>Plese provide username and password</li>";
        } elseif (!$user) {
            $errorMessage .= "<li>Username and/or password not recognized</li>";
        } else {
            if (password_verify($password, $user->getPassword())) {
                $_SESSION['user'] = $user->getId();
                header("Location: index.php");
            } else {
                $errorMessage .= "<li>Username and/or password not recognized</li>";
            }
        }

        if (!empty($errorMessage)) {
            $displayLoginError = true;
            $message = $errorMessage;
            $errorMessage = "<ul>" . $message . "</ul>";
        }
    }

    if (isset($_POST['registerForm'])) {
        $username = $_POST['registerUsername'];
        $email = $_POST['registerEmail'];
        $pass1 = $_POST['registerPasswordOne'];
        $pass2 = $_POST['registerPasswordTwo'];

        if (empty($username) || empty($email) || empty($pass1) || empty($pass2)) {
            $errorMessage .= "<li>Please fill in all fields</li>";
        } elseif ($pass1 != $pass2) {
            $errorMessage .= "<li>Please provide the same password twice</li>";
        } elseif (!filter_var(filter_var($email, FILTER_SANITIZE_EMAIL), FILTER_VALIDATE_EMAIL)) {
            $errorMessage .= "<li>Please provide correct email address</li>";
        } elseif (User::loadUserByUsername($conn, $username) != false) {
            $errorMessage .= "<li>Provided username already taken</li>";
        } elseif (User::loadUserByEmail($conn, $email) != false) {
            $errorMessage .= "<li>Provided email address already taken</li>";
        } else {
            $user = new User();
            $user->setUsername($username);
            $user->setEmail($email);
            $user->setPassword($password);
            $user->saveToDB($conn);
            $_SESSION['user'] = $user->getId();
            header('Location: index.php');
        }

        if (!empty($errorMessage)) {
            $displayRegisterError = true;
            $message = $errorMessage;
            $errorMessage = "<ul>" . $message . "</ul>";
        }
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

<div class="container">
    <div class="row">
        <div class="col-md-10 offset-md-1 mt-3 welcome-screen light-blue-bckg">
            <h1 class="title display-3 mt-3">Welcome to Twitter</h1>
            <p class="lead">Light-weight clone with all the features like the real one! Enjoy!</p>
            <hr>
            <div class="row">
                <div class="col-md-6">
                    <h4 class="mt-3">Login</h4>
                    <div class="alert alert-danger login-screen <?php if(!$displayLoginError) {echo 'hidden';} ?>">
                        <?php echo $errorMessage ?>
                    </div>
                    <form action="" method="post">
                        <div class="form-group">
                            <label class="mt-3" for="loginUsername">Username</label>
                            <input type="text" class="form-control" id="loginUsername" name="loginUsername" placeholder="Enter username">
                            <small>Your public username</small>
                        </div>
                        <div class="form-group">
                            <label class="mt-2" for="loginPassword">Password</label>
                            <input type="password" class="form-control" id="loginPassword" name="loginPassword" placeholder="Enter password">
                        </div>
                        <div class="form-group">
                            <button type="submit" name="loginForm" class="btn btn-primary mt-2">Login</button>
                        </div>
                    </form>
                </div>
                <div class="col-md-6 mt-3">
                    <h4>Register</h4>
                    <div class="alert alert-danger login-screen <?php if(!$displayRegisterError) {echo 'hidden';} ?>">
                        <?php echo $errorMessage ?>
                    </div>
                    <form action="" method="post">
                        <div class="form-group">
                            <label class="mt-3" for="registerUsername">Username</label>
                            <input type="text" class="form-control" id="registerUsername" name="registerUsername" placeholder="Enter username">
                            <small>Other users will recognize you by that name</small>
                        </div>
                        <div class="form-group">
                            <label class="mt-2" for="registerEmail">Email address</label>
                            <input type="email" class="form-control" id="registerEmail" name="registerEmail" placeholder="Enter email address">
                            <small>We will use it for notificataion purposes</small>
                        </div>
                        <div class="form-group">
                            <label class="mt-2" for="registerPasswordOne">Password</label>
                            <input type="password" class="form-control" id="registerPasswordOne" name="registerPasswordOne" placeholder="Enter password">
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" id="registerPasswordTwo" name="registerPasswordTwo" placeholder="Repeat password">
                            <small>Please make sure it's not easy to guess!</small>
                        </div>
                        <div class="form-group">
                            <button type="submit" name="registerForm" class="btn btn-primary mt-2">Register</button>
                        </div>
                    </form>
                </div>
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
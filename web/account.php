<?php

session_start();

require_once '../src/connection.php';
require_once '../src/User.php';

$errorMessage = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['accountSave'])) {
    $user = User::loadUserById($conn, $_POST['accountSave']);
    if (empty($_POST['accountPasswordOne']) xor empty($_POST['accountPasswordTwo'])) {
        $errorMessage .= "Please provide new password to both fields";
    } elseif (!empty($_POST['accountPasswordOne']) && !empty($_POST['accountPasswordTwo'])) {
        if ($_POST['accountPasswordOne'] != $_POST['accountPasswordTwo']) {
            $errorMessage .= "Please provide the same passwords to both fields";
        } else {
            $password = $conn->real_escape_string($_POST['accountPasswordOne']);
            $user->setPassword($password);
        }
    }

    $username = $conn->real_escape_string($_POST['accountUsername']);
    $email = $conn->real_escape_string($_POST['accountEmail']);
    $user->setUsername($username);
    $user->setEmail($email);

    $user->saveToDB($conn);

    $success = true;
}

if (isset($_SESSION['user'])) {
    $user = User::loadUserById($conn, $_SESSION['user']);
    $username = $user->getUsername();
} else {
    header('Location: login-register.php');
}

require_once 'templates/header.php';

?>



<div class="container main-content">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <h1>My account</h1>
            <div class="alert alert-danger login-screen <?php if(empty($errorMessage)) {echo 'hidden';} ?>">
                <?php echo $errorMessage ?>
            </div>
            <div class="alert alert-success login-screen <?php if(!isset($success)) {echo 'hidden';} ?>">
                Account has been updated.
            </div>
            <form action="" method="post">
                <div class="form-group">
                    <label class="mt-3" for="accountUsername">Username</label>
                    <input type="text" class="form-control" id="accountUsername" name="accountUsername" placeholder="Enter username" value="<?php echo $user->getUsername() ?>">
                    <small>Other users will recognize you by that name</small>
                </div>
                <div class="form-group">
                    <label class="mt-2" for="accountEmail">Email address</label>
                    <input type="email" class="form-control" id="accountEmail" name="accountEmail" placeholder="Enter email address" value="<?php echo $user->getEmail() ?>">
                    <small>We will use it for notificataion purposes</small>
                </div>
                <div class="form-group">
                    <label class="mt-2" for="accountPasswordOne">Password</label>
                    <input type="password" class="form-control" id="accountPasswordOne" name="accountPasswordOne" placeholder="Enter password">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" id="accountPasswordTwo" name="accountPasswordTwo" placeholder="Repeat password">
                    <small>Leave both fields blank if you don't want to change the password</small>
                </div>
                <div class="form-group">
                    <button type="submit" name="accountSave" value="<?php echo $user->getId() ?>" class="btn btn-primary mt-2">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php

require_once 'templates/footer.php';
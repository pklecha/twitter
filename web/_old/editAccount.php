<?php

require_once '../src/connection.php';
require_once '../src/User.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    var_dump($_POST);
}

if (isset($_SESSION['user'])) {
    $user = User::loadUserById($conn, $_SESSION['user']);
    $username = $user->getUsername();

    $username = $user->getUsername();
    $email = $user->getEmail();

}

?>

<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Twitter</title>
    </head>
<body>

<?php
if (isset($_SESSION['user']) && isset($username) && isset($email)) :
?>
<form method="post" action="">
    <p>
        <input name="username" type="text" placeholder="Your public name" value="<?php echo $username ?>">
    </p>
    <p>
        <input name="email" type="email" placeholder="Your email" value="<?php echo $email ?>">
    </p>
    <p>
        <input name="password" type="password" placeholder="Your password">
    </p>
    <p>
        <input type="submit" name="submit" value="Zapisz zmiany">
    </p>
</form>

<?php else : ?>
<p>Brak danych do edycji</p>
<?php endif ?>
</body>
</html>

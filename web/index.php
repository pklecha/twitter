<?php

require_once '../src/connection.php';
require_once '../src/User.php';

session_start();

if (isset($_SESSION['user'])) {
    $user = User::loadUserById($conn, $_SESSION['user']);
    $username = $user->getUsername();
}
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Twitter</title>
    </head>
    <body>
        <?php if(isset($user)) : ?>
        <h2>Witaj <?php echo $username; ?></h2>
            <a href="logout.php">Wyloguj</a> | <a href="editAccount.php">Edytuj konto</a>
        <?php else: ?>
        <a href="loginForm.php">Zaloguj</a> | <a href="registerForm.php">Zarejestruj</a>
        <?php endif ?>

        <hr>
        <pre>
            <?php
            $allUsers = User::loalAllUsers($conn);
            var_dump($allUsers);
            ?>
        </pre>
    </body>
</html>

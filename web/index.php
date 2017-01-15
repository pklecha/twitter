<?php 
session_start();
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
        <?php if(isset($_SESSION['user'])) : ?>
        <h2>Witaj <?php $_SESSION['user'] ?></h2>
        <?php else: ?>
        <a href="loginForm.php">Zaloguj</a> | <a href="registerForm.php">Zarejestruj</a>
        <?php endif ?>
    </body>
</html>

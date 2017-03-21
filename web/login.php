<?php

require_once '../src/connection.php';
require_once '../src/User.php';

session_start();

if ('POST' === $_SERVER['REQUEST_METHOD']) {
    if(isset($_POST['username']) && isset($_POST['password'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $user = User::loadUserByUsername($conn, $username);
    }
    
    if (!$user) {
        echo "Bledny login lub haslo!";
        exit;
    }
    
    if (password_verify($password, $user->getPassword())) {
        $_SESSION['user'] = $user->getId();
        header("Location: index.php");
        
    } else {
        echo "Bledny login lub haslo";
        exit;
    }
}
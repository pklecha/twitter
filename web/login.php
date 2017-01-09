<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once '../src/connection.php';
require_once '../src/User.php';

session_start();

if ('POST' === $_SERVER['REQUEST_METHOD']) {
    if(isset($_POST['username']) && isset($_POST['password'])) {
        $username = $_POST['username'];
        $user = User::loadUserByUsername($conn, $username);
    }
    
    if (!$user) {
        echo "Bledny login lub haslo";
        exit;
    }
    
    if (password_verify($password, $user->getPassword())) {
        $_SESSION['user'] = $user->getId();
        
    } else {
        echo "Bledny login lub haslo";
        exit;
    }
}

var_dump($_SESSION);
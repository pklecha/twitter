<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of User
 *
 * @author pawel
 */
class User {
    //put your code here
    
    private $id;
    private $username;
    private $email;
    private $password;
    
    public function __construct()
    {
        $this->id = -1;
        $this->email = '';
        $this->username = '';
        $this->password = '';
    }
    
    function setId($id) {
        $this->id = $id;
    }
    
    function setUsername($username) 
    {
        $this->username = $username;
    }

    function setEmail($email) 
    {
        $this->email = $email;
    }

    function setPassword($password) 
    {
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }
    
    function getPassword() 
    {
        return $this->password;
    }

    function getId() 
    {
        return $this->id;
    }
    
    public function setHash($hash) {
        $this->password = $hash;
    }
    
    public function save(mysqli $conn)
    {
        if (-1 === $this->id) {
           $sql = sprintf("INSERT INTO user (`email`,`username`,`password`) VALUES('%s','%s','%s')", $this->email, $this->username, $this->password);
        
            $result = $conn->query($sql);

            if($result) {
                $this->id = $conn->insert_id;
                return true;
            } else {
                return false;
    //            die ('Die Die Die!!!!' . $conn->errno);
            } 
        }
    }
    
    static public function loadUserByUsername(mysqli $conn, $username)
    {
        $conn->real_escape_string($username);
        $sql = "SELECT * FROM `user` WHERE id=$username";
        $result = $conn->query($sql);
        
        if(!$result) {
            die ("Query error: " . $conn->errno);
        }
        
        if ($result->num_rows === 1) {
            $userArray = $result->fetch_assoc();
            $user = new User();
            
            $user->setID($userArray['id']);
            $user->setEmail($userArray['email']);
            $user->setUsername($userArray['username']);
            $user->setHash($userArray['password']);
            
            return $user;
        } else {
            return false;
        }
    }
    
}

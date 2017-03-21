<?php

class User {

    private $id;
    private $username;
    private $email;
    private $password;
    
    public function __construct()
    {
        $this->id = -1;
        $this->email = '';
        $this->username = '';
        $this->setPassword = '';
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

    public function getEmail()
    {
        return $this->email;
    }

    public function getUsername()
    {
        return $this->username;
    }
    
    public function setHash($hash) {
        $this->password = $hash;
    }
    
    public function saveToDB(mysqli $conn)
    {
        if (-1 === $this->id) {
           $sql = sprintf("INSERT INTO twitter.user (`email`,`username`,`password`) VALUES('%s','%s','%s')", $this->email, $this->username, $this->password);
        
            $result = $conn->query($sql);

            if($result) {
                $this->id = $conn->insert_id;
                return true;
            }
            return false;
        } else {
            $sql = sprintf("UPDATE twitter.user SET username='%s', email='%s', password='%s' WHERE id='%d'",
                    $this->username, $this->email, $this->password, $this->id
                );
            $result = $conn->query($sql);

            if ($result) {
                return true;
            }
            return false;
        }
    }

    public function delete(mysqli $conn)
    {
        if ($this->id != -1) {
            $sql = "DELETE FROM twitter.user WHERE id=" . $this->id;
            $result = $conn->query($sql);
            if ($result == true) {
                $this->id = -1;
                return true;
            }
            return false;
        }
        return true;
    }
    
    static public function loadUserByUsername(mysqli $conn, $username)
    {
        $username = $conn->real_escape_string($username);
        $sql = "SELECT * FROM twitter.user WHERE username=\"$username\"";
        $result = $conn->query($sql);
        
        if(!$result) {
            die ("Query error: " . $conn->errno . ", " . $conn->error);
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

    static public function loadUserById(mysqli $conn, $id)
    {
        $id = $conn->real_escape_string($id);
        $sql = "SELECT * FROM twitter.user WHERE id=$id";
        $result = $conn->query($sql);

        if(!$result) {
            die ("Querry error: " . $conn->connect_errno . ", " . $conn->error);
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
    
    static public function loalAllUsers(mysqli $conn)
    {
        $sql = "SELECT * FROM twitter.user";
        $allUsers = [];

        $result = $conn->query($sql);

        if(!$result) {
            die ("Querry error: " . $conn->connect_errno . ", " . $conn->error);
        }

        if ($result && $result->num_rows > 0) {
            $usersArray = $result->fetch_assoc();

            foreach ($usersArray as $row) {
                $user = new User();

                $user->setId($row['id']);
                $user->setEmail($row['email']);
                $user->setUsername($row['username']);
                $user->setPassword($row['password']);

                $allUsers[] = $user;
            }
        }
        return $allUsers;
    }
}

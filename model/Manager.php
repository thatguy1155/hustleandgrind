<?php
class Manager {
    protected $_db;

    CONST HOST = "localhost";
    CONST DBNAME = "hustleandgrind";
    CONST LOGIN = "root";
    CONST PWD = "";
    
    // constructor
    function __construct() {
        $host = self::HOST;
        $dbname = self::DBNAME;
        $this->_db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", self::LOGIN, self::PWD);
    }

    
    public function getUserId($name, $email) {
        $user = $this->_db->prepare("SELECT id FROM users WHERE name = :name AND email = :email");
        $user->bindParam(':name', $name, PDO::PARAM_STR);
        $user->bindParam(':email', $email, PDO::PARAM_STR);
        $resp = $user->execute();
        if(!$resp) {
            throw new PDOException('Unable to retrieve user ID');
        }
        return $user->fetch();
    }

    public function addUser($name, $email) {
        $name = htmlspecialchars($name);
        $email = htmlspecialchars($email);      
        $addUser = $this->_db->prepare("INSERT INTO users(name, email) VALUES(:name, :email)");
        $addUser->bindParam(':name',$name,PDO::PARAM_STR);
        $addUser->bindParam(':email',$email,PDO::PARAM_STR);
        $status = $addUser->execute();
        if (!$status) {
            throw new PDOException('Impossible to add the member!');
        }
        $addUser->closeCursor(); 
    }
}
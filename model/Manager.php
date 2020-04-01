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
            throw new PDOException('Unable to add the user');
        }
        $addUser->closeCursor(); 
    }

    public function insertVote($userId,$questionId,$answer) {
        // $insertVote = $this->_db->prepare("INSERT INTO users(userId, vote) VALUES(:userId, :answer)");     
        $insertVote = $this->_db->prepare("INSERT INTO users(userId, questionId, vote) VALUES(:userId, :questionId, :answer)");
        $insertVote->bindParam(':userId',$userId,PDO::PARAM_STR);
        $insertVote->bindParam(':questionId',$username,PDO::PARAM_STR);
        $insertVote->bindParam(':answer',$answer,PDO::PARAM_STR);
        $status = $insertVote->execute();
        if (!$status) {
            throw new PDOException('Unable to add the vote');
        }
        $insertVote->closeCursor();
    }

    public function getQuestion() {        
        $getQuestion = $this->_db->prepare("SELECT * FROM questions WHERE green=NULL AND red=NULL");
        $getQuestion->bindParam(':userId',$userId,PDO::PARAM_STR);
        $getQuestion->bindParam(':answer',$answer,PDO::PARAM_STR);
        $status = $getQuestion->execute();
        if (!$status) {
            throw new PDOException('Impossible to get question ID');
        }
        $getQuestion->closeCursor();
    } 
}
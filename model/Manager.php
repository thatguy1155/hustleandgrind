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


    // ------------------vote functions


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
    
    
    public function tallyVotes($latestQ) {
        $tally = $this->_db->prepare('SELECT v.vote AS vote
                                    FROM votes v
                                    JOIN questions q
                                    ON v.questionId = q.id
                                    WHERE q.id = :latestQ');
        $tally->bindParam(':latestQ',$latestQ,PDO::PARAM_INT);
        $tallyResp = $tally->execute();
        if(!$tallyResp) {
            throw new PDOException('Unable to tally the votes!');
        }
        $tallyArray = [];
        while($data = $tally->fetch()){
            array_push($tallyArray,$data['vote']);
        }
        return $tallyArray;
        $tally->closeCursor();
    }

    public function pollsOpen($latestQ){
        $polls = $this->_db->prepare("UPDATE questions SET green = 0, red = 0 WHERE id = :latestQ");
        $polls->bindParam(':latestQ',$latestQ,PDO::PARAM_INT);
        $pollsOpen = $polls->execute();
        if(!$pollsOpen) {
            throw new PDOException('Unable to open the polls!');
        }
        $polls->closeCursor();
    }

    public function enterTally($latestQ,$voteCategory){
        if ($voteCategory == 'green'){
            $ballot = $this->_db->prepare("UPDATE questions SET green = green + 1 WHERE id = :latestQ");
        } else if ($voteCategory == 'red'){
            $ballot = $this->_db->prepare("UPDATE questions SET red = red + 1 WHERE id = :latestQ");
        }
        $ballot->bindParam(':latestQ',$latestQ,PDO::PARAM_INT);
        $pollsClosed = $ballot->execute();
        if(!$pollsClosed) {
            throw new PDOException('Unable to tally the votes!');
        }
        $ballot->closeCursor();
    }

    

    //-----------question functions---------------

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


    function doesQExist(){
        $qExists = $this->_db->prepare("SELECT id FROM questions ORDER BY id DESC LIMIT 0, 1");
        $resp = $qExists->execute();
        if(!$resp) {
            throw new PDOException('Unable to retrieve user ID');
        }
        return $qExists->fetch();
    }

    function makeQuestion(){      
        $addQ = $this->_db->prepare("INSERT INTO questions(green,red) VALUES(NULL, NULL)");
        $status = $addQ->execute();
        if (!$status) {
            throw new PDOException('Impossible to add the question!');
        }
        return "question made";
        $addQ->closeCursor();
    }
    
}
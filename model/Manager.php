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
          $user = $this->_db->prepare("SELECT ext_id, isAdmin FROM users WHERE name = :name AND email = :email");
          $user->bindParam(':name', $name);
          $user->bindParam(':email', $email);
          $resp = $user->execute();
          if(!$resp) {
             return false;
          }
          return $user->fetch(PDO::FETCH_ASSOC);
      }

    public function addUser($name, $email, $userId) {
        $name = htmlspecialchars($name);
        $email = htmlspecialchars($email);
        $addUser = $this->_db->prepare("INSERT INTO users(name, email, ext_id) VALUES(:name, :email, :userId)");
        $addUser->bindParam(':name',$name,PDO::PARAM_STR);
        $addUser->bindParam(':email',$email,PDO::PARAM_STR);
        $addUser->bindParam(':ext_id',$userId,PDO::PARAM_STR);
        $status = $addUser->execute();
        if (!$status) {
            throw new PDOException('Unable to add the user');
        }
        $addUser->closeCursor(); 
    }


    // ------------------vote functions


    public function insertVote($userId, $questionId, $answer) {
        // $insertVote = $this->_db->prepare("INSERT INTO users(userId, vote) VALUES(:userId, :answer)"); 
        $insertVote = $this->_db->prepare("INSERT INTO votes(`userId`, `questionId`, `vote`) VALUES((SELECT `id` FROM `users` where `ext_id` = :userId), :questionId, :answer)");
        $insertVote->bindParam(':userId',$userId,PDO::PARAM_STR);
        $insertVote->bindParam(':questionId',$questionId,PDO::PARAM_INT);
        $insertVote->bindParam(':answer',$answer,PDO::PARAM_STR);
        $status = $insertVote->execute();
        if (!$status) {
            print_r($this->_db->errorInfo());
            throw new PDOException('Unable to add the vote');
        }
        $insertVote->closeCursor();
        return;
    }
    
    
    public function getVotes($latestQ) {
        $tally = $this->_db->prepare('SELECT vote FROM votes WHERE questionId = :latestQ');
        // $tally = $this->_db->prepare('SELECT v.vote AS vote
        //                             FROM votes v
        //                             JOIN questions q
        //                             ON v.questionId = q.id
        //                             WHERE q.id = :latestQ');
        $tally->bindParam(':latestQ',$latestQ,PDO::PARAM_INT);
        $tallyResp = $tally->execute();
        if(!$tallyResp) {
            throw new PDOException('Unable to tally the votes!');
        }
        $allVotes = [];
        while($data = $tally->fetch(PDO::FETCH_ASSOC)){
            array_push($allVotes,$data['vote']);
        }
        return $allVotes;
        // $tally->closeCursor();
    }

    public function pollsOpen($latestQ){
        $polls = $this->_db->prepare("UPDATE questions SET blue = 0, red = 0 WHERE id = :latestQ");
        $polls->bindParam(':latestQ',$latestQ,PDO::PARAM_INT);
        $pollsOpen = $polls->execute();
        if(!$pollsOpen) {
            throw new PDOException('Unable to open the polls!');
        }
        $polls->closeCursor();
    }

    public function enterTally($latestQ,$voteCategory){
        if ($voteCategory == 'blue'){
            $ballot = $this->_db->prepare("UPDATE questions SET blue = blue + 1 WHERE id = :latestQ");
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

    public function didUserVote($userId, $questionId){
        $getUserVote = $this->_db->prepare("SELECT `votes`.`id` FROM `votes` JOIN `users` ON votes.userId = users.id WHERE `users`.`ext_id` = :userId AND `votes`.`questionId` = :questionId LIMIT 1");
        $getUserVote->bindParam(':userId', $userId , PDO::PARAM_INT);
        $getUserVote->bindParam(':questionId', $questionId , PDO::PARAM_INT);
        $getUserVote->execute();
        $status =  $getUserVote->fetch();
        if(!$status) {
            return false;
        }
        return true;
    }

    //-----------question functions---------------

    public function getQuestion() {        
        $getQuestion = $this->_db->prepare("SELECT id FROM questions WHERE blue IS null AND red IS null");
        
        $status = $getQuestion->execute();
        if (!$status) {
            throw new PDOException('Impossible to get question ID');
        }
        return $getQuestion->fetch();
    }


    // Get the current max id from the questions.
    function doesQExist(){
        //$qExists = $this->_db->prepare("SELECT id FROM questions ORDER BY id DESC LIMIT 0, 1");
        $qExists = $this->_db->prepare("SELECT max(id) as id FROM questions");
        $resp = $qExists->execute();
        if(!$resp) {
            throw new PDOException('Unable to retrieve user ID');
        }
        return $qExists->fetch();
    }

    function makeQuestion(){      
        $addQ = $this->_db->prepare("INSERT INTO questions(blue,red) VALUES(NULL, NULL)");
        $status = $addQ->execute();
        if (!$status) {
            throw new PDOException('Impossible to add the question!');
        }
        return "question made";
        $addQ->closeCursor();
    }
    
}
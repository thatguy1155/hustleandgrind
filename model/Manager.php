<?php
class Manager {
    protected $_db;
    
    // constructor
    function __construct() {
        $HOST = "localhost";
        $DBNAME = "hustleandgrind";
        $LOGIN = "root";
        $PWD = "";

	include(__DIR__.'/../config.php');  // Check to see if there are overrides.

        $this->_db = new PDO("mysql:host=$HOST;dbname=$DBNAME;charset=utf8", $LOGIN, $PWD);
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

    public function addUser($name, $email, $info, $userId) {
        $name = htmlspecialchars($name);
        $email = htmlspecialchars($email);
        $info = htmlspecialchars($info);
        $addUser = $this->_db->prepare("INSERT INTO users(name, email, info, ext_id) VALUES(:name, :email, :info, :userId)");
        $addUser->bindParam(':name',$name,PDO::PARAM_STR);
        $addUser->bindParam(':email',$email,PDO::PARAM_STR);
        $addUser->bindParam(':info',$info,PDO::PARAM_STR);
        $addUser->bindParam(':userId',$userId,PDO::PARAM_STR);
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
        // if (!$status) {
            // print_r($this->_db->errorInfo());
            // throw new PDOException('Unable to add the vote');
        // }
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

    public function getLastVotedQuestionId($userId){
        $getUserVote = $this->_db->prepare("SELECT max(`votes`.`questionId`) as id FROM `votes` JOIN `users` ON votes.userId = users.id WHERE `users`.`ext_id` = :userId LIMIT 1");
        $getUserVote->bindParam(':userId', $userId , PDO::PARAM_INT);
        $getUserVote->execute();
        // $status = $getUserVote->fetch();
        // if(!$status) {
        //     return false;
        // }
        return $getUserVote->fetch();
    }

    //-----------question functions---------------

    public function getQuestion($thisId) {        
        //$getQuestion = $this->_db->prepare("SELECT id, question, answerRed, answerBlue FROM questions WHERE blue IS null AND red IS null");
        $getQuestion = $this->_db->prepare("SELECT id, question, answerRed, answerBlue FROM questions WHERE id = :thisId");
        $getQuestion->bindParam(':thisId', $thisId , PDO::PARAM_INT); 

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

    function getCurrentQuestionId() {
        return $this->doesQExist();
    }

    function makeQuestion($question,$answerBlue,$answerRed){   
        // echo $question .$answerRed .$answerBlue; 
        $addQ = $this->_db->prepare("INSERT INTO questions (question, answerBlue, answerRed) VALUES(:question, :answerBlue, :answerRed)");
        $addQ->bindParam(':question', $question , PDO::PARAM_STR);
        $addQ->bindParam(':answerBlue', $answerBlue , PDO::PARAM_STR);
        $addQ->bindParam(':answerRed', $answerRed , PDO::PARAM_STR);
        
        $status = $addQ->execute();
        if (!$status) {
            throw new PDOException('Impossible to add the question!');
        }
        return "question made";
        $addQ->closeCursor();
    }
    
}

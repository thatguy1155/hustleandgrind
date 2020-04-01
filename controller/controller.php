<?php
    require_once("./model/Manager.php");

    function register($name, $email) {
        $cookieUserId = isset($_COOKIE['userId']) ? $_COOKIE['userId'] : '';
        $cookieAdminId = isset($_COOKIE['adminId']) ? $_COOKIE['adminId'] : '';
        $manager = new Manager();   
        $emptyFields = strlen(trim($name)) === 0 || strlen(trim($email)) === 0;    
        if (strlen(trim($email)) > 0 && strlen(trim($name)) > 0 && preg_match("#^[a-z0-9._-]+@[a-z0-9._-]+\.[a-z]{2,6}$#", $email)) {
            if (!$cookieUserId && !$cookieAdminId) {
                $addUser = $manager->addUser($name, $email);
                $user = $manager->getUserId($name, $email);
                if($name == "screenAdmin" && $email == 'screen_admin@wcoding.com'){
                    setcookie('adminId', $user['id']);
                } else{
                    setcookie('userId', $user['id']);
                }
            }

            header("Location:index.php");
              
              
        } else if ($emptyFields) {
            $errorMsg = 'Please complete the fields'; 
        } else if (!$emptyFields && !(preg_match("#^[a-z0-9._-]+@[a-z0-9._-]+\.[a-z]{2,6}$#", $email))) {
            $errorMsg = 'Please enter a correct email address';
        }
        require("view/register.php");
    }

    function vote($userId,$answerA,$answerB) {
        $manager = new Manager();

        $questionId = $manager->getQuestion();

        if ($answerA OR $answerB) {
            setcookie('hasVoted', $questionId['id'], time()+3*24*3600, null, null, false, true);
            if ($answerA) {
                $votes = $manager->insertVote($userId,$questionId['id'],$answerA);
            } elseif ($answerB) {
                $votes = $manager->insertVote($userId,$questionId['id'],$answerB);
            }
        }
        require("view/vote.php");
    }

    function admin() {
        require("view/admin.php");   //change to page 3 page name
    }



    function newQuestion() {
        $qManager = new Manager();
        $madeQ = $qManager->doesQExist();
        if(!$madeQ){
            $makeQ = $qManager->makeQuestion();
            echo $makeQ;
        } else {
            $tally = $qManager->tallyVotes($madeQ['id']);
            $openPolls = $qManager->pollsOpen($madeQ['id']);
            foreach($tally as $vote){
                if ($vote == 'a'){
                    $voteValue = 'green';
                } else if ($vote == 'b'){
                    $voteValue = 'red';
                }
                $ballotBox = $qManager->enterTally($madeQ['id'],$voteValue);
            }
            $newQ = $qManager->makeQuestion();
        }
        
        header('Location:index.php?action=admin');
    }

    function display() {
        $displayManager = new Manager();
        $latestQ=$displayManager->doesQExist();
        $tallyDisplay = $displayManager->tallyVotes($latestQ['id']);
        $finalVoteCount = ['a' => 0,'b' => 0];
        foreach($tallyDisplay as $vote){
            if ($vote == 'a'){
                $finalVoteCount['a'] += 1;
            } else if ($vote == 'b'){
                $finalVoteCount['b'] += 1;
            }
        }
        echo json_encode($finalVoteCount);
    }



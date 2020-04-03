<?php
    require_once("./model/Manager.php");
    function loadRegisterPage() {
        require("view/register.php");
    }

    function register($name, $email,$cookieUserId,$cookieAdminId) {
        $manager = new Manager();   
        $emptyFields = strlen(trim($name)) === 0 || strlen(trim($email)) === 0;
        $userExists = $manager->getUserId($name, $email);
        if($userExists){
            if($userExists['isAdmin']){
                setcookie('adminId', $userExists['id']);
            } else {
                setcookie('userId', $userExists['id']);
            }
            header("Location:index.php");
        } else {
            if (strlen(trim($email)) > 0 && strlen(trim($name)) > 0 && preg_match("#^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+\.[a-zA-Z]{2,6}$#", $email)) {
                if (!$cookieUserId && !$cookieAdminId) {
                    $addUser = $manager->addUser($name, $email);
                    $user = $manager->getUserId($name, $email);
                    setcookie('userId', $user['id']);
                }
                header("Location:index.php?action=vote");     
            } else if ($emptyFields) {
                $errorMsg = 'Please complete the fields'; 
            } else if (!$emptyFields && !(preg_match("#^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+\.[a-zA-Z]{2,6}$#", $email))) {
                $errorMsg = 'Please enter a correct email address';
            }
            require("view/register.php");
        } 
        
    }
    function loadVotePage() {
        require("view/vote.php");
    }

    function vote($userId,$answerA,$answerB, $cookieHasVoted) {
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
        header("Location:index.php?action=vote");// add param    
    }

    function admin() {
        require("view/admin.php");   //change to page 3 page name
    }

    function getQNumber($cookieHasVoted, $cookieUserId) {
        $qMessenger = new Manager();
        $madeQ = $qMessenger->doesQExist();
        $userAlreadyVoted =  $qMessenger->getUserVote($cookieUserId, $madeQ['id']);
        if($cookieHasVoted AND $cookieHasVoted != $madeQ['id']) {
            setcookie('hasVoted', "", time()+3*24*3600, null, null, false, true);
            echo "button";
        } else if($userAlreadyVoted == "voted"){
            echo "result";
        } else{
            echo "button";
        }  
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
                    $voteValue = 'blue';
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



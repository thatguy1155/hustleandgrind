<?php
    require_once("./model/Manager.php");

    function login() {
        require("view/login.php");  //change to pg 1 page name
    }

    function register($name, $email) {
        $cookieUserId = isset($_COOKIE['userId']) ? $_COOKIE['userId'] : '';
        $manager = new Manager();   
        $emptyFields = strlen(trim($name)) === 0 || strlen(trim($email)) === 0;    
        if (strlen(trim($email)) > 0 && strlen(trim($name)) > 0 && preg_match("#^[a-z0-9._-]+@[a-z0-9._-]+\.[a-z]{2,6}$#", $email)) {
            if (!$cookieUserId) {
                $addUser = $manager->addUser($name, $email);
                $user = $manager->getUserId($name, $email);
                setcookie('userId', $user['id']);
            }
            header("Location: view/vote.php");  
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
            require("view/vote.php");
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
        require("view/admin.php");
    }



<?php




function login() {
        require("view/login.php");  //change to pg 1 page name
    }


function vote($userId,$questionId,$answerA,$answerB) {
    $voteManager = new Manager();

    if ($answerA OR $answerB) {
        setcookie('hasVoted', $userId, time()+7*24*3600, null, null, false, true);
        if ($answerA) {
            $votes = $voteManager->insertVote($userId,$answerA);
            // $votes = $voteManager->insertVote($userId,$questionId,$answerA);
        } elseif ($answerB) {
            $votes = $voteManager->insertVote($userId,$answerB);
            // $votes = $voteManager->insertVote($userId,$questionId,$answerB);
        }
        
        require("view/vote.php");
    }
}

function admin() {
    require("view/admin.php");   //change to page 3 page name
}



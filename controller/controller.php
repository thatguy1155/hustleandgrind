<?php
require_once("./model/Manager.php");



function login() {
        require("view/login.php");  //change to pg 1 page name
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



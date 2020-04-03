<?php
require("./controller/controller.php");

$cookieUserId = isset($_COOKIE['userId']) ? $_COOKIE['userId'] : '';
$cookieIsAdmin = isset($_COOKIE['admin']) ? $_COOKIE['admin'] : '';

try {
    $action = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';
    if (isset($_REQUEST['action'])) {
        if ($action === 'admin') {
            //$round = isset($_REQUEST['round']) ? $_REQUEST['round'] : '';
            admin();     
        } else if ($action === 'register') {
            if ($cookieUserId !== '') {
                header('Location:index.php?action=vote');
            } else {
                $name = isset($_POST['name']) ? $_POST['name'] : null;
                $email = isset($_POST['email']) ? $_POST['email'] : null;
                $info = isset($_POST['info']) ? $_POST['info'] : '';
                //register($name, $email, $cookieUserId, $cookieIsAdmin);
                register($name, $email, $info);
            }
        }
        else if ($action === 'vote') {
            // $answerA = isset($_POST['a']) ? $_POST['a'] : '';
            // $answerB = isset($_POST['b']) ? $_POST['b'] : '';
            // if($cookieHasVoted){
            //     loadVotePage();
            // }
            // else
            if ($cookieUserId === '') {
                header('Location:index.php');
                return;
            }

            if (isset($_POST['answer'])) {
                $userId = isset($_COOKIE['userId']) ? $_COOKIE['userId'] : '';
                $answer = $_POST['answer'];
                $cookieHasVoted = isset($_COOKIE['lastVotedQuestion']) ? $_COOKIE['lastVotedQuestion'] : '';

                vote($userId, $answer, $cookieHasVoted);
            }

            loadVotePage();

        } else if ($action === 'newQuestion') {
            $answerRed = isset($_REQUEST['answerRed']) ? $_REQUEST['answerRed'] : '';
            $answerBlue = isset($_REQUEST['answerBlue']) ? $_REQUEST['answerBlue'] : '';
            $question = isset($_REQUEST['question']) ? $_REQUEST['question'] : '';
            newQuestion($question,$answerRed,$answerBlue);
        } else if ($action === 'display') {
            display();
        } else if ($action === 'isNewQuestion') {
            $cookieHasVoted = isset($_COOKIE['lastVotedQuestion']) ? $_COOKIE['lastVotedQuestion'] : '';
            isNewQuestion($cookieHasVoted, $cookieUserId);
        }
        else if ($action === 'getQuestionId') {
            getQuestionId();
        }
    } else {
        if ($cookieIsAdmin) {
            header('Location: index.php?action=admin');
        } else if ($cookieUserId) {
            header('Location:index.php?action=vote');
        } else {
            loadRegisterPage();
        }
    }
}
catch(PDOException $e) {
    $msg = $e->getMessage();
    $code = $e->getCode();
    $line = $e->getLine();
    $file = $e->getFile();
    require('./view/errorPDO.php');
}
catch(Exception $e) {
    $msg = $e->getMessage();
    $code = $e->getCode();
    $line = $e->getLine();
    $file = $e->getFile();
    require('./view/error.php');
}

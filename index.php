<?php
require("./controller/controller.php");
$cookieUserId = isset($_COOKIE['userId']) ? $_COOKIE['userId'] : '';
$cookieAdminId = isset($_COOKIE['adminId']) ? $_COOKIE['adminId'] : '';

try {
    $action = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';
    if (isset($_REQUEST['action'])) {
        if ($action === 'admin') {
            //$round = isset($_REQUEST['round']) ? $_REQUEST['round'] : '';
            admin();     
        } else if ($action === 'register') {
            if ($cookieUserId) {
                header('Location:index.php?action=vote');
            } else{
                $name = isset($_POST['name']) ? $_POST['name'] : null;
                $email = isset($_POST['email']) ? $_POST['email'] : null;
                register($name, $email,$cookieUserId,$cookieAdminId);
            }
        } else if ($action === 'vote') {
            $cookieHasVoted = isset($_COOKIE['hasVoted']) ? $_COOKIE['hasVoted'] : '';
            $userId = isset($_POST['userId']) ? $_POST['userId'] : '';
            $answerA = isset($_POST['a']) ? $_POST['a'] : '';
            $answerB = isset($_POST['b']) ? $_POST['b'] : '';
            if($cookieHasVoted){
                loadVotePage();   
            } else {
                if($answerA OR $answerB){
                    vote($userId,$answerA,$answerB, $cookieHasVoted);
                } else {
                    loadVotePage();
                }
            }
            
        } else if ($action === 'newQuestion') {
            $answerRed = isset($_REQUEST['answerRed']) ? $_REQUEST['answerRed'] : '';
            $answerBlue = isset($_REQUEST['answerBlue']) ? $_REQUEST['answerBlue'] : '';
            $question = isset($_REQUEST['question']) ? $_REQUEST['question'] : '';
            newQuestion($question,$answerRed,$answerBlue);
        } else if ($action === 'display') {
            display();
        } else if ($action === 'getQNumber') {
            $cookieHasVoted = isset($_COOKIE['hasVoted']) ? $_COOKIE['hasVoted'] : '';
            getQNumber($cookieHasVoted, $cookieUserId);
        }
    } else {
        if ($cookieAdminId) {
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

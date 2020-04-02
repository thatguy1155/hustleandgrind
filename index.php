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
                $name = isset($_POST['name']) ? $_POST['name'] : '';
                $email = isset($_POST['email']) ? $_POST['email'] : '';
                register($name, $email);
            }
        } else if ($action === 'vote') {
            $userId = isset($_POST['userId']) ? $_POST['userId'] : '';
            $answerA = isset($_POST['a']) ? $_POST['a'] : '';
            $answerB = isset($_POST['b']) ? $_POST['b'] : '';
            vote($userId,$answerA,$answerB);
        } else if ($action === 'newQuestion') {
            newQuestion();
        } else if ($action === 'display') {
            display();
        } else if ($action === 'displayView') {
            displayView();
        }
    } else {
        if ($cookieAdminId) {
            header('Location: index.php?action=admin');
        } else {
            if ($cookieUserId) {
                header('Location:index.php?action=vote');
            } else{
                header('Location:index.php?action=register');
            }
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

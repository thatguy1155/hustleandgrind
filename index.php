<?php
$cookieUserId = isset($_COOKIE['userId']) ? $_COOKIE['userId'] : '';
$cookieAdminId = isset($_COOKIE['adminId']) ? $_COOKIE['adminId'] : '';
if ($cookieAdminId) {
    require('view/admin.php');
} else if ($cookieUserId) {
    require('view/vote.php');
}

require("./controller/controller.php");

try {
    $action = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';
    if (isset($_REQUEST['action'])) {
        if ($action === 'admin') {
            //$round = isset($_REQUEST['round']) ? $_REQUEST['round'] : '';
            admin();
             
        } else if ($action === 'register') {
            $name = isset($_POST['name']) ? $_POST['name'] : '';
            $email = isset($_POST['email']) ? $_POST['email'] : '';
            register($name, $email);
        } else if ($action === 'vote') {
            $userId = isset($_POST['userId']) ? $_POST['userId'] : '';
            $answerA = isset($_POST['a']) ? $_POST['a'] : '';
            $answerB = isset($_POST['b']) ? $_POST['b'] : '';
            vote($userId,$answerA,$answerB);
        } else if ($action === 'newQuestion') {
            newQuestion();
        }
    } else {
        require('view/register.php');
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

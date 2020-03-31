<?php

require("./controller/controller.php");
/**
 * TODO: verify cookies, if cookies set, showAllPlaylists, if not showLandingPage
 */
try {
    $action = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';
    if (isset($_REQUEST['action'])) {
        if ($action === 'admin') {
            admin(); 
        } else if ($action === 'vote') {
            $userId = isset($_POST['userId']) ? $_POST['userId'] : '';
            $questionId = isset($_POST['userId']) ? $_POST['userId'] : '';
            $answerA = isset($_POST['a']) ? $_POST['a'] : '';
            $answerB = isset($_POST['b']) ? $_POST['b'] : '';
            vote($userId,$questionId,$answerA,$answerB); 
        } else {
            login();
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

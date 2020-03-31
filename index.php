<?php

require("./controller.php");
/**
 * TODO: verify cookies, if cookies set, showAllPlaylists, if not showLandingPage
 */
try {
    $action = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';
    if (isset($_REQUEST['action'])) {
        if ($action === 'admin') {
            admin(); 
        } else if ($action === 'vote') {
            vote(); 
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

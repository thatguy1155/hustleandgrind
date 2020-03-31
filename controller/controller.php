<?php
    require_once("./model/Manager.php");

    function register($name, $email) {
        $cookieUserId = isset($_COOKIE['userId']) ? $_COOKIE['userId'] : '';
        $manager = new Manager();
        if (!$cookieUserId) {
            $addUser = $manager->addUser($name, $email);
            $user = $manager->getUserId($name, $email);
            setcookie('userId', $user['id']);
        }
        require("view/vote.php");     
    }


    function vote() {
        require("view/vote.php");   //change to page 2 page name
    }

    function admin() {
        require("view/admin.php");   //change to page 3 page name
    }



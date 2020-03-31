<?php
    require_once("./model/Manager.php");

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
            require("view/vote.php");  
        } else if ($emptyFields) {
            $errorMsg = 'Please complete the fields'; 
        } else if (!$emptyFields && !(preg_match("#^[a-z0-9._-]+@[a-z0-9._-]+\.[a-z]{2,6}$#", $email))) {
            $errorMsg = 'Please enter a correct email address';
        }
        require("view/register.php");
    }


    function vote() {
        require("view/vote.php");   //change to page 2 page name
    }

    function admin() {
        require("view/admin.php");   //change to page 3 page name
    }



<?php
    require_once("./model/Manager.php");  // Load model.

    function loadRegisterPage($errorMsg = '') {
        require("view/register.php");
    }

    //function register($name, $email, $cookieUserId, $cookieIsAdmin) {
    function register($name, $email, $info) {
        $manager = new Manager();
        $len_name = strlen(trim($name));
        $len_email = strlen(trim($email));

        if($len_name > 0 && $len_email > 0){  // If both name and email have values...
            // Validate email.
            if (! preg_match("#^[A-Za-z0-9._-]+@[A-Za-z0-9._-]+\.[A-Za-z]{2,6}$#", $email)) {
                $errorMsg = 'Please enter a correct email address';
                loadRegisterPage($errorMsg);
                return;
            }

            // Check if the user is an admin user or an existing user in db.
            $userData = $manager->getUserId($name, $email);  // If no user, returns FALSE

            if (! $userData) {
                // New user.
                $new_id = md5($name . $email);
                $addUser = $manager->addUser($name, $email, $info, $new_id);
                // $user = $manager->getUserId($name, $email);
                setcookie('userId', $new_id);

                $encoded_name = urlencode($name);
                $encoded_info = urlencode($info);
                $curl = curl_init("http://localhost:8080/makelabel.php?name={$encoded_name}&info={$encoded_info}");
                curl_exec($curl);
                
                header("Location:index.php?action=vote");
                return;
            }
            else {
                // Existing user.

                if($userData['isAdmin'] === '1') {
                    setcookie('admin', '1');  // Cookies always set as strings.
                }

                setcookie('userId', $userData['ext_id']);
                // header("Location:index.php");
            }
            header("Location:index.php");
        }
        else {
            $errorMsg = 'Please complete the fields';
            loadRegisterPage();
        } 
    }

    function loadVotePage() {
        global $cookieUserId;
        $qMessenger = new Manager();
        $currQ = $qMessenger->getCurrentQuestionId();
        $lastVotedQuestionId = $qMessenger->getLastVotedQuestionId($cookieUserId);
        if ($lastVotedQuestionId === false) $lastVotedQuestionId['id'] = 0;
        // $userAlreadyVoted = $qMessenger->didUserVote($cookieUserId, $currQ['id']);
        $userAlreadyVoted = ($currQ['id'] === $lastVotedQuestionId['id']);

        $questionData = $qMessenger->getQuestion($currQ['id']);

        require("view/vote.php");
    }

    function vote($userId, $answer, $cookieHasVoted) {
        $manager = new Manager();
        if ($answer) {
            $questionId = $manager->getCurrentQuestionId();
            setcookie('lastVotedQuestion', ''.$questionId['id'], time()+3*24*3600, null, null, false, true);
            $manager->insertVote($userId, $questionId['id'], $answer);
            //header("Location:index.php?action=vote");
        }    
    }

    function admin() {
        $manager = new Manager();
        $questionId = $manager->getCurrentQuestionId();
        $questionData = $manager->getQuestion($questionId['id']);
        
        require("view/admin.php");   //change to page 3 page name
    }

    function isNewQuestion($cookieHasVoted, $cookieUserId) {
        $responseData = [];

        $qMessenger = new Manager();
        $madeQ = $qMessenger->doesQExist();
        $userAlreadyVoted = $qMessenger->didUserVote($cookieUserId, $madeQ['id']);

        if($userAlreadyVoted) {
            $responseData['newQuestion'] = false;
        }
        else {
            setcookie('lastVotedQuestion', "", time()+3*24*3600, null, null, false, true);
            $responseData['newQuestion'] = true;
        }

        echo json_encode($responseData);
    }

    function getQuestionId() {
        $responseData = [];
        $qManager = new Manager(); 
        $newIdRow = $qManager->getCurrentQuestionId();
        if (count($newIdRow) > 0) {
            $responseData['questionId'] = $newIdRow['id'];
        }

        echo json_encode($responseData);
    }

    function newQuestion($question,$answerRed,$answerBlue) {
        $qManager = new Manager();
        $madeQ = $qManager->doesQExist();
        if(!$madeQ){
            $makeQ = $qManager->makeQuestion($question,$answerRed,$answerBlue);
            echo $makeQ;
        } else {
            $tally = $qManager->getVotes($madeQ['id']);
            $openPolls = $qManager->pollsOpen($madeQ['id']);
            foreach($tally as $vote){
                if ($vote == 'a'){
                    $voteValue = 'blue';
                } else if ($vote == 'b'){
                    $voteValue = 'red';
                }
                $ballotBox = $qManager->enterTally($madeQ['id'],$voteValue);
            }
            $newQ = $qManager->makeQuestion($question,$answerRed,$answerBlue);
        }
        
        header('Location:index.php?action=admin');
    }

    function display() {
        $displayManager = new Manager();
        $latestQ = $displayManager->getCurrentQuestionId();
        $allVotes = $displayManager->getVotes($latestQ['id']);

        // Create the vote count and return.
        $finalVoteCount = ['a' => 0,'b' => 0];
        foreach($allVotes as $vote){
            if ($vote === 'a'){
                $finalVoteCount['a'] += 1;
            } else if ($vote === 'b'){
                $finalVoteCount['b'] += 1;
            }
        }

        $latestQData = $displayManager->getQuestion($latestQ['id']);

        array_push($finalVoteCount, isset($latestQData['question']) ? $latestQData['question'] : '');
        array_push($finalVoteCount, isset($latestQData['answerBlue']) ? $latestQData['answerBlue'] : '');
        array_push($finalVoteCount, isset($latestQData['answerRed']) ? $latestQData['answerRed'] : '');

        echo json_encode($finalVoteCount);
    }



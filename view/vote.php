<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Vote</title>
        <link rel="stylesheet" href="public/styles/style.css"/>
    </head> 
    <body>
    <?php 
    $votedValue="";
    if(isset($_COOKIE['lastVotedQuestion'])) {
        $votedValue = $_COOKIE['lastVotedQuestion'];
    }
    ?>
        <input type="hidden" name="action" id="votedValue" value="<?=$votedValue;?>"/>
        
        <div id="resultView" class='hide' >
            <?php include('results.php'); ?>
        </div>

        <div id="voteView">
            <?php include('buttons.php'); ?>
        </div>
       
        <script src="public/js/vote.js"></script>
        <!-- <script src="public/js/results.js"></script> -->
        <?php
            if (isset($userAlreadyVoted) && $userAlreadyVoted) {
                echo("<script>displayResults(true);</script>");
            }
        ?>
    </body>
</html>
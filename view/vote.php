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
        
        <?php if ($userAlreadyVoted) {
            ?>
            <div id="resultView">
                <?php include('results.php'); ?>
            </div>
        <?php }
        else {?>
            <div id="voteView">
                <?php include('buttons.php'); ?>
            </div>
        <?php } ?>
       
        <script src="public/js/vote.js"></script>
        <!-- <script src="public/js/results.js"></script> -->
        <?php
            // if (isset($userAlreadyVoted) && $userAlreadyVoted) {
            //     echo("<script>displayResults(true);</script>");
            // }
            // else {
                echo("<script>uiQuestionId = {$currQ['id']};\n uiVotedId = {$lastVotedQuestionId['id']}; </script>");
            // }
        ?>
    </body>
</html>
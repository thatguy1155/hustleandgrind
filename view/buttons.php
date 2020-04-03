<div id="buttons">
    <form method="POST" action="index.php" id="voteForm">
        <label class = 'answerLabel' value=></label>
        <label class = 'answerLabel'value=/></label>
        <label class = 'answerLabel'value=/></label>
        <input type="hidden" name="action" value="vote"/>
        <input type="hidden" name="userId" value=<?= $_COOKIE['userId']?> />
        <p class="question"><?=$questionData['question']?></p>
        <p class="option" id="optionA"><?=$questionData['answerRed']?></p>
        <input type="submit" name="a" value="a" id="aBtn"/>
        <p class="option" id="optionB"><?=$questionData['answerBlue']?></p>
        <input type="submit" name="b" value="b" id="bBtn"/>
    </form>
</div>
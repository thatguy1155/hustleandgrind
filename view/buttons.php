<div id="buttons">
    <form method="POST" action="index.php" id="voteForm">
        <input type="hidden" name="action" value="vote"/>
        <input type="hidden" name="userId" value=<?= $_COOKIE['userId']?> />
        <p class="question">Question</p>
        <p class="option" id="optionA">optionA</p>
        <input type="submit" name="a" value="a" id="aBtn"/>
        <p class="option" id="optionB">optionB</p>
        <input type="submit" name="b" value="b" id="bBtn"/>
    </form>
</div>
<div id="buttons">
    <form method="POST" action="index.php" id="voteForm">
        <input type="hidden" name="action" value="vote"/>
        <input type="hidden" name="userId" value=<?= $_COOKIE['userId']?> />
        <input type="submit" name="a" value="a" id="aBtn"/>
        <input type="submit" name="b" value="b" id="bBtn"/>
    </form>
</div>
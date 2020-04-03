<div id="buttons">
    <form method="POST" action="index.php" id="voteForm">
        <input type="hidden" name="action" value="vote"/>

        <p class="question"><?= isset($questionData['question']) ? $questionData['question'] : ''; ?></p>
        <input type="button" name="a" value="<?= isset($questionData['answerBlue']) ? $questionData['answerBlue'] : '';?>" id="aBtn"/>
        <input type="button" name="b" value="<?= isset($questionData['answerRed']) ? $questionData['answerRed'] : ''; ?>" id="bBtn"/>
        <input type="hidden" name="answer" id="answer" value=""/>
        <script>
            let buttonForm = document.querySelector("#voteForm");
            let answerInput = document.querySelector("#answer");
            document.querySelector("#aBtn").addEventListener("click", function() {
                answerInput.value = "a";
                buttonForm.submit();
            });
            document.querySelector("#bBtn").addEventListener("click", function() {
                answerInput.value = "b";
                buttonForm.submit();
            });
        </script>
    </form>
</div>
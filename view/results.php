<div id="results">
    <!-- <div id="resultContainer">             
        <div id="resultA" class="score"></div>   
        <div id="resultB" class="score"></div>            
    </div> -->

        
    <div id="resultContainer">
        <div id="resultText" style="">
            <div>Results of the Vote</div>
        </div>

        <p class="question"><?= isset($questionData['question']) ? $questionData['question'] : ''; ?></p>
        <p class="option" id="optionA"><?= isset($questionData['answerRed']) ? $questionData['answerRed'] : ''; ?></p>
        <div id="resultA" class="score"></div>   
        <p class="option" id="optionB"><?= isset($questionData['answerBlue']) ? $questionData['answerBlue'] : ''; ?></p>
        <div id="resultB" class="score"></div>           
    </div>

    <script src="public/js/results.js"></script>
</div>

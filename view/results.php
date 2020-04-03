<body id="results">
    <link rel="stylesheet" href="public/styles/style.css" rel="stylesheet"/>
        <!-- <span id="resultText">Results of the Vote</span> -->

            <!-- <button id="do">do shit</button> -->
        <p class="question"><?=$questionData['question']?></p>
        <div id="resultContainer">
            <p class="option" id="optionA"><?=$questionData['answerRed']?></p>
            <div id="resultA" class="score"></div>   
            <p class="option" id="optionB"><?=$questionData['answerBlue']?></p>
            <div id="resultB" class="score"></div>           
        </div>
    <script src="public/js/results.js"></script>
</body>

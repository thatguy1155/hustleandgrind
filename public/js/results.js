


// AJAX BELOW
var searchBox = document.getElementById('search');
var button = document.getElementById('do');
//grab elements for the textbox and the div that will ultimately host the results



function results() {
    let aResults = document.getElementById('resultA');
    let bResults = document.getElementById('resultB');
    let question = document.getElementsByClassName('question')[0];
    let answerBlue = document.getElementById('optionA');
    let answerRed = document.getElementById('optionB');

    var xhr = new XMLHttpRequest();

    xhr.open('GET', `index.php?action=display`);

    xhr.addEventListener('readystatechange', function () {
        if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
            obj = JSON.parse(xhr.response);
            print
            let aCount = (obj['a']);
            let bCount = (obj['b']);
            let q = obj[0];
            let ansA = obj[1];
            //console.log(answerBlue.innerHTML);
            let ansB = obj[2];
            //console.log(q);
            //console.log(ansB);


            aResults.innerHTML = `${aCount}`;
            bResults.innerHTML = `${bCount}`;
            question.innerText = q;
            answerBlue.innerText = ansA;
            answerRed.innerText = obj[2];

        } else if (xhr.readyState === XMLHttpRequest.DONE && xhr.status !== 200 & xhr.status === 0) {

            alert('there was an error \n\n Code:' + xhr.status + '\nText : ' + xhr.statusText);
            //just in case
        }

    });
    xhr.send(null);
};

results();
setInterval(function () {
    results();
}, 5000);

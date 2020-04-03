
let aBtn = document.getElementById('aBtn');
let bBtn = document.getElementById('bBtn');
let voteView = document.getElementById('voteView');
let resultView = document.getElementById('resultView');
let votedValue = document.getElementById('votedValue').value;

// console.log(votedValue);

function qQuery() {
    var xhr = new XMLHttpRequest();

    xhr.open('GET', 'index.php?action=isNewQuestion');

    xhr.addEventListener('readystatechange', function () {
        if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
            obj = JSON.parse(xhr.response);
            // console.log(obj);
            displayResults(!obj['newQuestion']);

            //} else if (xhr.readyState === XMLHttpRequest.DONE && xhr.status !== 200 & xhr.status === 0) {
        } else if (xhr.readyState === XMLHttpRequest.DONE && xhr.status !== 200) {
            alert('there was an error \n\n Code:' + xhr.status + '\nText : ' + xhr.statusText);
            //just in case
        }

    });
    xhr.send(null);
};

function displayResults(turnOn) {
    if (turnOn) {
        resultView.classList.remove('hide');
        voteView.classList.add('hide');
    } else {
        voteView.classList.remove('hide');
        resultView.classList.add('hide');
    }
}

qQuery();
setInterval(function () {
    qQuery();
}, 2000);
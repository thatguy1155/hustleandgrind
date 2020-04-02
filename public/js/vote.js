
let aBtn = document.getElementById('aBtn');
let bBtn = document.getElementById('bBtn');
let voteView = document.getElementById('voteView');
let resultView = document.getElementById('resultView');
let votedValue = document.getElementById('votedValue').value;

console.log(votedValue);

function qQuery() {
    var xhr = new XMLHttpRequest();

    xhr.open('GET', `index.php?action=getQNumber`);

    xhr.addEventListener('readystatechange', function() {
        if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
            obj = xhr.response;
            console.log(obj);
            if(obj == "button"){
                voteView.classList.remove('hide');
                resultView.classList.add('hide');
            } else {
                resultView.classList.remove('hide');
                voteView.classList.add('hide');  
            }

        } else if (xhr.readyState === XMLHttpRequest.DONE && xhr.status !== 200 & xhr.status === 0) {

            alert('there was an error \n\n Code:' + xhr.status + '\nText : ' + xhr.statusText);
            //just in case
        }

    });
    xhr.send(null);

};

setInterval(function() {
    qQuery();
}, 5000);
// AJAX BELOW
var searchBox = document.getElementById('search');
var button = document.getElementById('do');
//grab elements for the textbox and the div that will ultimately host the results



function results() {
    let aResults = document.getElementById('resultA');
    let bResults = document.getElementById('resultB');

    var xhr = new XMLHttpRequest();

    xhr.open('GET', `index.php?action=display`);

    xhr.addEventListener('readystatechange', function() {
        if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
            obj = JSON.parse(xhr.response);
            let aCount = (obj['a']);
            let bCount = (obj['b']);

            aResults.innerHTML = `${aCount}`;
            bResults.innerHTML = `${bCount}`;

        } else if (xhr.readyState === XMLHttpRequest.DONE && xhr.status !== 200 & xhr.status === 0) {

            alert('there was an error \n\n Code:' + xhr.status + '\nText : ' + xhr.statusText);
            //just in case
        }

    });
    xhr.send(null);

};

setInterval(function() {
    results();
}, 5000);
// get query selector for the hidden inputs
// set attribute of height for the resultA and B

// const valueA = document.querySelector('#heightA');
// const valueB = document.querySelector('#heightB');

// console.log(valueA.value);
// console.log(valueB.value);


// AJAX BELOW
var searchBox = document.getElementById('search');
var button = document.getElementById('do');
//grab elements for the textbox and the div that will ultimately host the results

let aResults = document.getElementById('resultA');
let bResults = document.getElementById('resultB');


// button.addEventListener('click', function() {
//     console.log('works here');

// run ajax request to backend w the contents of the text box
function results() {
    var xhr = new XMLHttpRequest();
    //IMPORTANT!!!!_-----------------

    //below is my url vs jeremy's url and mine. you might need to alter this to fit the absolute path that runs in your browser.
    //please don't delete mine so that I can test!
    
    // xhr.open('GET', `http://localhost/Git/Project_wcoding/hustleandgrind/index.php?action=display&xml=1`);
    xhr.open('GET', `http://localhost/project/hustleandgrind/index.php?action=display&xml=1`);

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

let aBtn = document.getElementById('aBtn');
let bBtn = document.getElementById('bBtn');
let voteView = document.getElementById('voteView');
let displayView = document.getElementById('displayView');


aBtn.addEventListener(click,function() {
    voteView.classList.add('hide');
    displayView.classList.remove('hide');



    // var xhr = new XMLHttpRequest();

    // xhr.open('GET', `index.php?action=display`);

    // xhr.addEventListener('readystatechange', function() {
    //     if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
    //         obj = JSON.parse(xhr.response);
    //         let aCount = (obj['a']);
    //         let bCount = (obj['b']);

    //         aResults.innerHTML = `${aCount}`;
    //         bResults.innerHTML = `${bCount}`;

    //     } else if (xhr.readyState === XMLHttpRequest.DONE && xhr.status !== 200 & xhr.status === 0) {

    //         alert('there was an error \n\n Code:' + xhr.status + '\nText : ' + xhr.statusText);
    //         //just in case
    //     }

    // });
    // xhr.send(null);

});






// function results() {
//     var xhr = new XMLHttpRequest();

//     xhr.open('GET', `index.php?action=display`);

//     xhr.addEventListener('readystatechange', function() {
//         if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
//             obj = JSON.parse(xhr.response);
//             let aCount = (obj['a']);
//             let bCount = (obj['b']);

//             aResults.innerHTML = `${aCount}`;
//             bResults.innerHTML = `${bCount}`;

//         } else if (xhr.readyState === XMLHttpRequest.DONE && xhr.status !== 200 & xhr.status === 0) {

//             alert('there was an error \n\n Code:' + xhr.status + '\nText : ' + xhr.statusText);
//             //just in case
//         }

//     });
//     xhr.send(null);

// };

// setInterval(function() {
//     results();
// }, 5000);
// get query selector for the hidden inputs
// set attribute of height for the resultA and B

const valueA = document.querySelector('#heightA');
const valueB = document.querySelector('#heightB');

console.log(valueA.value);
console.log(valueB.value);

document.getElementById('resultA').setAttribute("height", valueA.value);
document.getElementById('resultB').setAttribute("height", valueB.value);
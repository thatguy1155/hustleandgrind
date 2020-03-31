let registerForm = document.getElementById('registerForm');
let emailInput = document.getElementById('email');

registerForm.addEventListener('submit', checkCompleteForm);
registerForm.addEventListener('submit', checkEmail);

function checkCompleteForm() {
    let nameInput = document.getElementById('name');
    let incompleteError = document.getElementById('incompleteError');
    if (nameInput.value || emailInput.value) {
        incompleteError.display
    }
}

function checkEmail() { 
    let emailRegex = new RegExp("/^[a-z0-9._-]+@[a-z0-9._-]+\.[a-z]{2,6}$/"); 
    let emailError = document.getElementById('emailError');
    let emailCorrect = emailRegex.test(emailInput.value);
    if (emailCorrect) {
        emailError.classList.add('show');
    }
}
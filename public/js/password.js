const form = document.querySelector("form");

const submit = form.querySelector('button[type="submit"]');
const email = form.querySelector('input[name="email"]');;
const password = form.querySelector('input[name="new-password"]');
const rep_password = form.querySelector('input[name="repeated-password"]');


function isPassword(password) {
    return /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*]).{8,}$/.test(password);
}

function arePasswordsSame(password, confirmedPassword) {
    return password === confirmedPassword;
}

function markValidation(element, condition, message, parametersafter) {

    if (condition) {
        parametersafter.forEach(element => {
            element.disabled = false;
        });

        const existingError = form.querySelector(".warning-box");

        if (existingError) {
            existingError.remove();
            element.classList.remove('no-valid');
        }

    } else {
        const firstInput = form.querySelector('input[name="email"]');

        const errorMessage = document.createElement("p");
        errorMessage.className = "warning-box base-font";
        errorMessage.textContent = message;
    
        if (firstInput) {
            const existingError = form.querySelector(".warning-box");
    
            if (existingError) {
                existingError.remove();
            }
    
            form.insertBefore(errorMessage, firstInput);
            element.classList.add('no-valid');
    
            parametersafter.forEach(element => {
                element.disabled = 'disable';
            });
        }
    }
}

function validatePassword() {
    setTimeout(function () {const condition = isPassword(password.value); markValidation(password, condition, 'Password too weak!', [rep_password, submit]);}, 500);
}

function validatePasswords() {
    setTimeout(function () {const condition = arePasswordsSame(password.value, rep_password.value); markValidation(password, condition, 'Passwords are not the same!', [submit]);}, 100);
}
password.addEventListener('keyup', validatePassword);
rep_password.addEventListener('keyup', validatePasswords);
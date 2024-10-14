const form = document.querySelector("form");
const submit = form.querySelector('button[type="submit"]');

const email = form.querySelector('input[name="email"]');
const password = form.querySelector('input[name="password"]');

function isEmailValid(email) {
    return /\S+@\S+\.\S+/.test(email);
}

function isPasswordAlphanumeric(password) {
    return /^[a-zA-Z0-9]+$/.test(password);
}

function markValidation(element, condition, message, parametersAfter) {
    const existingError = element.previousElementSibling;

    if (condition) {
        parametersAfter.forEach(el => {
            el.disabled = false;
        });

        if (existingError && existingError.classList.contains("warning-box")) {
            existingError.remove();
        }
        element.classList.remove('no-valid');

    } else {
        const errorMessage = document.createElement("p");
        errorMessage.className = "warning-box base-font";
        errorMessage.textContent = message;

        if (existingError && existingError.classList.contains("warning-box")) {
            existingError.remove();
        }

        element.before(errorMessage);
        element.classList.add('no-valid');

        parametersAfter.forEach(el => {
            el.disabled = true;
        });
    }
}

function validateEmail() {
    setTimeout(function () {
        markValidation(email, isEmailValid(email.value), 'Please enter a valid email address!', [submit]);
    }, 1000);
}

function validatePassword() {
    setTimeout(function () {
        const condition = isPasswordAlphanumeric(password.value);
        markValidation(password, condition, 'Password must contain letters and numbers!', [submit]);
    }, 10);
}

email.addEventListener('keyup', validateEmail);
password.addEventListener('keyup', validatePassword);

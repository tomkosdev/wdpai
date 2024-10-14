const form = document.querySelector('form[action="add_map"]');
const submit = form.querySelector('button[type="submit"]');

// const hour = form.querySelector('input[name="hour"]');
// const zip = form.querySelector('input[name="zip_code"]');

// const city = form.querySelector('input[name="city"]');
// const address = form.querySelector('input[name="address"]');
// const max_slots = form.querySelector('input[name="max_slots"]');
const description = form.querySelector('input[name="description"]');

function isHour(hour) {
    return /^([0-1]?[0-9]|2[0-3]):[0-5][0-9]$/.test(hour);
}

function isZip(zipcode) {
    return /^[0-9\-\/]+$/.test(zipcode)
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
        const firstInput = form.querySelector('input[name="title"]');

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

function validateHour() {
    setTimeout(function () {markValidation(hour, isHour(hour.value), 'Incorrect time format!', [max_slots, address, city, zip, description, submit]);}, 1000);
}

function validateZip() {
    setTimeout(function () {markValidation(zip, isZip(zip.value), 'Incorrect zip code format!', [description, submit]);}, 1000);
}


hour.addEventListener('keyup', validateHour);
zip.addEventListener('keyup', validateZip);
/** Clears all the inputs of their values */
function clearFormInputs () {
    const form = document.querySelector('form');
    for(let i=0; i<form.elements.length - 1; i++) { // do not iterate over button
        form.elements[i].value = "";
    }
}

/**
 * Returns a boolean indicating whether the values in the inputs are valid
 * If not, displays appropriate error messages
 */
function validateForm () {
    let valid = true;

    const hoursInput = document.getElementById('hours');
    const workAreaInput = document.getElementById('work-area');
    const hoursInputError = hoursInput.nextElementSibling;
    // check for no input, negative input, or a non-number input
    if(hoursInput.value === "" || +hoursInput.value < 0 || isNaN(hoursInput.value)) {
        hoursInputError.textContent = "Please input a positive number";
        hoursInput.focus();
        if(valid) valid = false;
    }
    else {
        hoursInputError.textContent = "";
    }

    const datalist = document.querySelector('datalist');
    const optionValues = [...datalist.children].map(option => option.value.toLowerCase());
    const workAreaError = datalist.nextElementSibling;
    // check for no input or an input that is not on the list of work areas
    if(workAreaInput.value === "" || !optionValues.includes(workAreaInput.value.toLowerCase())) {
        workAreaError.textContent = "Please pick a valid work area";
        if(valid) {
            workAreaInput.focus(); // only focus if previous input was valid and this one is not
            valid = false;
        }
    }
    else {
        workAreaError.textContent = "";
    }

    return valid;
}

// initialize
(function () {
    const submit = document.getElementById('submit');
    submit.addEventListener('click', () => {
        let valid = validateForm();
        const buffer = document.querySelector('.buffer');
        if(valid) { // if form inputs are valid
            clearFormInputs();
            buffer.textContent = "Successfully submitted!";
        }
        else {
            buffer.textContent = "";
        }
    }, false);
})();
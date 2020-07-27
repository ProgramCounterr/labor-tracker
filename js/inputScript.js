// author: Peter Chen
/**
 * Returns a boolean indicating whether the values in the inputs are valid
 * If not, displays appropriate error messages
 */
function validateForm () {
    let valid = true;

    const hoursInput = document.getElementById('hours');
    const hoursInputError = hoursInput.nextElementSibling;
    // check for no input, negative input, or a non-number input
    if(hoursInput.value === "" || +hoursInput.value < 0 || isNaN(hoursInput.value)) {
        hoursInputError.textContent = "Please enter your hours for the day as a positive number <24 with no leading zeroes (ex: 8)";
        hoursInput.focus();
        if(valid) valid = false;
    }
    else
        hoursInputError.textContent = "";

    const datalist = document.querySelector('datalist');
    const optionValues = [...datalist.children].map(option => option.value.toLowerCase());
    const workAreaInput = document.getElementById('work-area');
    const workAreaError = datalist.nextElementSibling;
    // check for no input or an input that is not on the list of work areas
    if(workAreaInput.value === "" || !optionValues.includes(workAreaInput.value.toLowerCase())) {
        workAreaError.textContent = "Please pick a work area from the list";
        if(valid) {
            workAreaInput.focus(); // only focus if previous input was valid and this one is not
            valid = false;
        }
    }
    else
        workAreaError.textContent = "";

    const dateInput = document.getElementById('date');
    const dateInputError = dateInput.nextElementSibling;
    if(dateInput.value === "") {
        $date_msg = "Please enter the date that you worked these hours";
        if($valid) $valid = false;
    }
    else
        dateInputError.textContent = "";

    return valid;
}

// initialize
(function () {
    const submit = document.getElementById('submit');
    submit.addEventListener('click', (e) => {
        let valid = validateForm();
    }, false);
})();
/**
 * Returns a boolean indicating whether the values in the inputs are valid
 * If not, displays appropriate error messages
 */
function validateForm () {
    let valid = true;

    const usernameInput = document.getElementById('username');
    const passwordInput = document.getElementById('password');
    const usernameError = username.nextElementSibling;
    // TODO: check for registered username
    if(usernameInput.value === "") {
        usernameError.textContent = "Invalid username";
        usernameInput.focus();
        if(valid) valid = false;
    }
    else {
        usernameError.textContent = "";
    }
    const passwordError = document.getElementById('msg_password');
    // TODO: check for registered password
    if(passwordInput.value === "") {
        passwordError.textContent = "Invalid password";
        if(valid) {
            passwordInput.focus(); // only focus if previous input was valid and this one is not
            valid = false;
        }
    }
    else {
        passwordError.textContent = "";
    }

    return valid;
}

// initialize
(function () {
    const showPassword = document.querySelector('div.input-group-append');
    showPassword.addEventListener('click', () => {
        document.querySelector('i.fa-eye').classList.toggle('fa-eye-slash'); // change eye icon
        const passwordInput = document.getElementById('password');
        if(passwordInput.type === "text")
            passwordInput.type = "password";
        else if(passwordInput.type === "password")
            passwordInput.type = "text";
    }, false);
    
    const submit = document.querySelector('[type="submit"');
    submit.addEventListener('click', (e) => {
        let valid = validateForm();
        if(!valid)
            e.preventDefault(); // prevent form from submitting if not valid
    }, false);

})();
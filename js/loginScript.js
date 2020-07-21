
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

})();
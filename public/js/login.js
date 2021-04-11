    // Used for hiding the error login message if user account suspended.
    if(document.querySelector('.alert-danger'))
    {
        document.querySelector('.span__alert').style.display = "none";
    }

    /* This script is used to cancel autocomplete on email and password input */
    document.getElementById('inputPassword').setAttribute('autocomplete', 'new-password');


    /*  This script allows us to change informations, styles of labels and inputs on click or on blur */

    //Changing placeholders for email
    document.getElementById('inputEmail').onclick = function (evt) {
        evt.target.setAttribute('placeholder', 'jean.dupont@gmail.com');
    }

    //Adding event listeners on inputs
    let inputEmail = document.querySelector('#inputEmail');
    let inputPassword = document.querySelector('#inputPassword');
    let labelEmail = document.querySelector('#labelEmail');
    let labelPassword = document.querySelector('#labelPassword');

    if (inputEmail.value !== '') {
        labelEmail.style.top = "10px";
        labelEmail.style.left = "38px";
    }

    if (inputPassword.value !== '') {
        labelPassword.style.top = "10px";
        labelPassword.style.left = "38px";
    }

    inputEmail.addEventListener('focus', handleClickOnInputEmail, false);
    inputPassword.addEventListener('focus', handleClickOnInputPassword, false);

    function handleClickOnInputEmail(evt) {

        labelEmail.style.top = "10px";
        labelEmail.style.left = "38px";

        inputEmail.onblur = function () {
            if (!inputEmail.value) {
                inputEmail.classList.add('constraint');
            }
            else {
                inputEmail.classList.remove('constraint');
                inputEmail.classList.add('valid');
            }
        }

    }

    function handleClickOnInputPassword(evt) {

        labelPassword.style.top = "10px";
        labelPassword.style.left = "38px";

        inputPassword.onblur = function () {
            if (!inputPassword.value) {
                inputPassword.classList.add('constraint');
            }
            else {
                inputPassword.classList.remove('constraint');
                inputPassword.classList.add('valid');
            }
        }

    }


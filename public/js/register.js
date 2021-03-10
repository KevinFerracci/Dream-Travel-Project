/* This script is used to cancel autocomplete on email and password input */ 
document.getElementById('registration_form_password_first').setAttribute('autocomplete', 'new-password');
            
/* This script is used to style error message according to constraint validations*/ 


if(document.querySelectorAll('.invalid-feedback'))
{
    let formGroupDivs = document.querySelectorAll('.form-group');
    formGroupDivs.forEach(
        function(formGroupDiv)
        {
            if(formGroupDiv.querySelector('.invalid-feedback'))
            {
                let errorDiv = formGroupDiv.querySelector('.invalid-feedback');
                let errorIcon = errorDiv.querySelector('.form-error-icon');
                errorIcon.textContent = "Attention";
                let cloneErrorDiv = errorDiv.cloneNode(true);
                errorDiv.innerHTML = "";
                cloneErrorDiv.classList.remove('d-block');   
                formGroupDiv.appendChild(cloneErrorDiv);
            }

           
        }
    )     

    


}



/*  This script allows us to change informations, styles of labels and inputs on click or on blur */ 

//Changing placeholders for firstname, name and email
document.getElementById('registration_form_firstname').onclick = function(evt)
{
    evt.target.setAttribute('placeholder', 'Jean');
}

document.getElementById('registration_form_name').onclick = function(evt)
{
    evt.target.setAttribute('placeholder', 'Dupont');
}

document.getElementById('registration_form_email').onclick = function(evt)
{
    evt.target.setAttribute('placeholder', 'jean.dupont@gmail.com');
}

//Adding event listeners on inputs
let formGroups = document.querySelectorAll('.form-group');

formGroups.forEach(
    function(formGroup)
    {
        let input = formGroup.querySelector('input');
        let label = formGroup.querySelector('label');

        if(formGroup.querySelector('label').getAttribute('class') !== 'form-check-label required')
        {
            if(input.value !== '')
            {
                label.style.fontSize = "13px";
                label.style.top = "1px";
                label.style.left = "0px";
            }
            input.addEventListener('focus', handleClickOnInput, false);
            
        }                   
    }
)

function handleClickOnInput(evt)
{

    contentDiv = evt.target.closest('div');

    let label = contentDiv.querySelector('label');
    let input = contentDiv.querySelector('input');

    label.style.fontSize = "13px";
    label.style.top = "1px";
    label.style.left = "0px";

    input.onblur = function()
    {
        if(!input.value)
        {
            input.classList.add('constraint');
        }
        else
        {
            input.classList.remove('constraint');
            input.classList.add('valid');
        }
    }

}

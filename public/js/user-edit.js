
document.querySelectorAll('form')[0].setAttribute('class', 'user-form');
document.querySelectorAll('form')[1].setAttribute('class', 'user-delete');



// Remplir l'input d'une image avec son nom

document.querySelector('.custom-file-label').textContent = 'ma_photo.jpg';

let fileName = '';
document.querySelector('.custom-file-input').onchange = function () 
{
let name = document.querySelector('.custom-file-label').textContent = this.value.slice(12, this.value.length);
if(name.length > 20)
{
  fileName = name.slice(12, 20) + '...' + name.slice(name.length - 8, name.length);
  document.querySelector('.custom-file-label').textContent = fileName;
}
 document.querySelector('.custom-file-label').style.color = 'black';
}   

//Changer la couleur des values d'un input si changement

let firstname = document.getElementById('user_firstname').value;
document.getElementById('user_firstname').onchange = function () 
{ 
document.getElementById('user_firstname').style.color = 'black';
}

document.getElementById('user_firstname').onblur = function ()    
{ 
if(firstname !== document.getElementById('user_firstname').value)
{
    document.getElementById('user_firstname').style.color = 'black';
}

}

let name = document.getElementById('user_name').value;
document.getElementById('user_name').onchange = function () 
{ 
document.getElementById('user_name').style.color = 'black';
}

document.getElementById('user_name').onblur = function ()    
{ 
if(name !== document.getElementById('user_name').value)
{
    document.getElementById('user_name').style.color = 'black';
}

}

let username = document.getElementById('user_username').value;
document.getElementById('user_username').onchange = function () 
{ 
document.getElementById('user_username').style.color = 'black';
}

document.getElementById('user_username').onblur = function ()    
{ 
if(username !== document.getElementById('user_username').value)
{
    document.getElementById('user_username').style.color = 'black';
}

}

let description = document.querySelector('textarea').value;
document.querySelector('textarea').onchange = function () 
{ 
document.querySelector('textarea').style.color = 'black';
}

document.querySelector('textarea').onblur = function ()    
{ 
if(description !== document.querySelector('textarea').value)
{
    document.querySelector('textarea').style.color = 'black';
}

}


require('./scss/product.scss');
const $ = require('jquery');

let croix = document.getElementsByClassName('croix');
let hide = document.getElementsByClassName('hide');

for(let i=0; i<3; i++){
    croix[i].addEventListener('click', function(){
        hide[i].classList.toggle('animHide');
    });
}





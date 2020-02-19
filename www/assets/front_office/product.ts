require('./scss/product.scss');
const $ = require('jquery');

let croix = document.getElementsByClassName('croix');
let hide = document.getElementsByClassName('hide');

let couleur = $('.couleur li');
let taille = $('.taille li');

for(let i=0; i<3; i++){
    croix[i].addEventListener('click', function(){
        hide[i].classList.toggle('animHide');
    });
}

couleur.click(function(){
    $(this).append("<div class='selectCouleur'></div>");
    $(this).attr('select', 'true');
});

taille.click(function(){
   $(this).toggleClass('selectTaille');
});





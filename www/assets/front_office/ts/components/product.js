import * as $ from "jquery";
// Ici ce composant product (produit seul) peut être réutilisé dans plusieurs pages

const croix = document.getElementsByClassName('croix');
const hide = document.getElementsByClassName('hide');

const couleur = $('.couleur li');
const taille = $('.taille li');

for(let i=0; i<3; i++)
{
    croix[i].addEventListener('click', function(){
        hide[i].classList.toggle('animHide');
    });
}

couleur.click(function()
{
    $(this).append("<div class='selectCouleur'></div>");
    $(this).attr('select', 'true');
});

taille.click(function()
{
    $(this).toggleClass('selectTaille');
});

$(document).ready(function(){
    var moins = $('#moinsProduct');
    var plus = $('#plusProduct');
    var quant = $('#quant');
    var quantite = 0;


    $(plus).click(function(){
       quantite = quantite + 1;
       quant.html(quantite)
    });

    $(moins).click(function(){
        if(quantite === 0){
            alert('only positive');
        }else{
            quantite = quantite - 1;
            quant.html(quantite);
        }
    });
});
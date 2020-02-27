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

couleur.click(function(this: HTMLElement)
{
    $(this).append("<div class='selectCouleur'></div>");
    $(this).attr('select', 'true');
});

taille.click(function(this: HTMLElement)
{
    $(this).toggleClass('selectTaille');
});
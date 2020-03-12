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

$(document).ready(function(){
    var select = couleur.attr('select');
    var tab = new Array();

    if(select === "false"){
        couleur.click(function()
        {
            // tab.forEach(couleur){
            //     tab[i] = couleur.attr(select);
            // }

            $(this).append("<div class='selectCouleur'></div>");
            select = "true";
            $(this).attr('select', select);
        });
    }


    taille.click(function()
    {
        $(this).toggleClass('selectTaille');
    });

    var moins = $('#moinsProduct');
    var plus = $('#plusProduct');
    var quant = $('#quant');
    var quantite = 0;




    $(plus).click(function(){
       quantite = quantite + 1;
       quant.html(quantite)
        $('.quantity-input').val(quantite)
    });

    $(moins).click(function(){
        if(quantite === 0){
            return false;
        }else{
            quantite = quantite - 1;
            quant.html(quantite);
            $('.quantity-input').val(quantite)
        }
    });
});
require('./scss/proServiceList.scss');
require('./ts/partials/layout.ts');
/*
const $ = require('jquery');

$(".service").click(function () {
    if ( $(this).next().first().is( ":hidden" ) ) {
        $(this).next().slideDown("slow");
    }else{
        $(this).next().slideUp("slow");
    }
});
*/


let listService = document.getElementsByClassName("service") as HTMLCollectionOf<HTMLElement>;
let listDescription = document.getElementsByClassName("text_container") as HTMLCollectionOf<HTMLElement>;

let isCloseText = true;

let debugHauteurArrow:string;
//media queries
const debugHeight = window.matchMedia( "(max-width: 750px)" );
if (debugHeight.matches) {
    debugHauteurArrow= "-8px";
} else {
    debugHauteurArrow= "-16px";
}


function showHideDesc(i: number) {
    const arrowHeight = window.matchMedia( "(max-width: 550px)" );
    if(listDescription !== null){
        let actualText = listDescription[i];
        let actualArticle = listService[i];
        let listIco = actualArticle.getElementsByClassName("iconePro");
        let actualIco = listIco[0] as HTMLElement;

        if(actualText !== null){
            if(isCloseText){
                if(actualIco !== null){
                    if (!arrowHeight.matches) {
                        actualIco.style.transform = "rotate(90deg)";
                        if (debugHauteurArrow !== undefined) {
                            actualIco.style.marginTop = "0";
                        }
                    }
                }

                actualText.style.height = `${actualText.scrollHeight}px`;
                isCloseText = false;
            }else{
                if(actualIco !== null){
                    if (!arrowHeight.matches) {
                        actualIco.style.transform = "rotate(0deg)";
                        if (debugHauteurArrow !== undefined) {
                            actualIco.style.marginTop = debugHauteurArrow;
                        }
                    }
                }
                actualText.style.height = "0";
                isCloseText = true;
            }
        }
    }
}


if(listService !==null){
    for(let i = 0; i < listService.length; i++) {
        listService[i].addEventListener('click', function () {
            showHideDesc(i);
        });
    }
}

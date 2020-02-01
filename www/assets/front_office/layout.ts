require('./scss/partials/layout.scss');


/*function openNav() {
    document.getElementById("burger_nav").style.width = "100%"
}
*/

let burger_nav = document.getElementById("burger_nav");
let burgerIco = document.getElementById("rotation");
let nav_children = document.getElementById("a_list");

let isClose = true;

function closeNav() {
    if(burger_nav !== null){
        burger_nav.style.width = "0%";
        isClose = true;
    }
}

function rotate() {
    if(burgerIco !== null) {
        burgerIco.classList.toggle("change")
    }
}

function burger() {
    if(burger_nav !== null) {
        isClose ? (burger_nav.style.width = "100%", isClose = false) : (burger_nav.style.width = "0%", isClose = true)
    }
}

if(nav_children !==null){
    nav_children.addEventListener('click', function () {
        burger();
        rotate();
    });
}

if(burgerIco !==null) {
    burgerIco.addEventListener('click', function () {
        closeNav();
        rotate();
    });
}

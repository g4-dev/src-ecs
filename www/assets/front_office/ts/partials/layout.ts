let burger_nav = document.getElementById("burger_nav");
let burgerIco = document.getElementById("rotation");

let nav = document.getElementById("a_list");

let nav_children = null;
if(nav !== null){
    nav_children = nav.getElementsByTagName("a");
}

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
        if(isClose){
            burger_nav.style.width = "100%";
            isClose = false;
        }else{
            burger_nav.style.width = "0%";
            isClose = true;
        }
    }
}

if(nav_children !==null){
    for(let i = 0; i < nav_children.length; i++) {
        nav_children[i].addEventListener('click', function () {
            closeNav();
            rotate();
        });
    }
}

if(burgerIco !==null) {
    burgerIco.addEventListener('click', function () {
        burger();
        rotate();
    });
}

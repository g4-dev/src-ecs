require('./scss/partials/layout.scss');


/*function openNav() {
    document.getElementById("burger_nav").style.width = "100%"
}
*/
let isClose = true;

function closeNav() {
    document.getElementById("burger_nav").style.width = "0%";
    isClose = true;
}

function rotate() {
    document.getElementById("rotation").classList.toggle("change")
}

function burger() {
    isClose ? (document.getElementById("burger_nav").style.width = "100%", isClose = false) : (document.getElementById("burger_nav").style.width = "0%", isClose = true)
}

let burgerNav = document.getElementById("rotation");
let nav_children = document.getElementById("a_list");


nav_children.addEventListener('click', function () {
    burger();
    rotate();
});

burgerNav.addEventListener('click', function () {
    closeNav();
    rotate();
});

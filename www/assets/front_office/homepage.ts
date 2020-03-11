require('./scss/homepage.scss');
require('./ts/partials/layout.ts');
import * as $ from 'jquery';

/*
let slideIndex = 1;
showSlides(slideIndex);

let back = document.getElementById("slideback");
let forward = document.getElementById("slideforward");

if(back !==null){
    back.addEventListener('click', function () {
        showSlides(slideIndex += -1);
    });
}

if(forward !==null){
    forward.addEventListener('click', function () {
        showSlides(slideIndex += 1);
    });
}

function showSlides(n : number) {
    let i;
    let slides = document.getElementsByClassName("Slide")as HTMLCollectionOf<HTMLElement>;
    if (n > slides.length) {slideIndex = 1}
    if (n < 1) {slideIndex = slides.length}
    for (i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
    }
    slides[slideIndex-1].style.display = "flex";
}*/

$.fn.nextOrFirst = function(selector){
    var next = this.next(selector);
    return (next.length) ? next : this.prevAll(selector).last();
};

$.fn.prevOrLast = function(selector){
    var prev = this.prev(selector);
    return (prev.length) ? prev : this.nextAll(selector).last();
};

function slider() {
    var activeSlide = $(".active");

    activeSlide
        .removeClass("active")
        .nextOrFirst()
        .addClass("active");
}
setInterval(slider, 6000);

function controls() {
    var control = $(".controls");

    control.on('click', '.prev', function() {
        $(".active")
            .removeClass("active")
            .prevOrLast()
            .addClass("active");
    });

    control.on('click', '.next', function() {
        $(".active")
            .removeClass("active")
            .nextOrFirst()
            .addClass("active");
    });
}
controls();
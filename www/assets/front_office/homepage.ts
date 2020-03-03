require('./scss/homepage.scss');
require('./ts/partials/layout.ts');

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
}
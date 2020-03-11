// @ts-nocheck
import * as $ from "jquery";

$.fn.nextOrFirst = function(selector: string): any
{
    var next = this.next(selector);
    return (next.length) ? next : this.prevAll(selector).last();
};

$.fn.prevOrLast = function(selector: string): any
{
    var prev = this.prev(selector);
    return (prev.length) ? prev : this.nextAll(selector).last();
};

function slider() {
    var activeSlide = $(".active");
    if(activeSlide) {

        activeSlide
            .removeClass("active")
            .nextOrFirst()
            .addClass("active");
    }
}
setInterval(slider, 16000);

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
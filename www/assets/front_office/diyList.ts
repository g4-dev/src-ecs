require('./scss/diyList.scss');
import * as $ from "jquery";

var btnSearch = $('.input-diy');
var search = $('.diy-bar');

search.click(function () {
    btnSearch.addClass('showBtn');
});


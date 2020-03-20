require('./scss/diyList.scss');
require('./ts/partials/layout')
import * as $ from "jquery";

var btnSearch = $('.input-diy');
var search = $('.diy-bar');

search.click(function () {
    btnSearch.addClass('showBtn');
});


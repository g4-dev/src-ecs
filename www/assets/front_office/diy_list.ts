require('./scss/diy_list.scss');
const $ = require('jquery');

var btnSearch = $('.input-diy');
var search = $('.diy-bar');

search.click(function () {
    btnSearch.addClass('showBtn');
});


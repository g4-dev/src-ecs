require('./scss/diyList.scss');
const $ = require('jquery');

var btnSearch = $('.input-diy');
var search = $('.diy-bar');

search.click(function () {
    btnSearch.addClass('showBtn');
});


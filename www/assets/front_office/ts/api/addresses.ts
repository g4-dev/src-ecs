import * as $ from "jquery"

$(".autocomplete-address").autocomplete({
    source: function (request, response) {
        $.ajax({
            url: '',
            data: {
                query: request.term,
            },
            dataType: 'json',
            method: 'post'
        }).done(function (data) {
            response(data);
        });
    },
    minLength: 3
})
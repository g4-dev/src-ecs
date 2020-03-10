/*
import * as $ from "jquery"
// TODO install autocomplete
module.exports.autocomplete = (url: string): void {
    $(".autocomplete-address").autocomplete({
        source: function (request, response) {
            $.ajax({
                url: url,
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
}*/

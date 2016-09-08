$(function () {

    var formBooksSearch = $("#form-books-search");
    var btnBooksSearch = $("#btn-books-search");
    var divBooksResult = $("#div-books-result");
    var textKeyword = $("#text-keyword");

    formBooksSearch.ajaxForm();

    textKeyword.on('keypress',function(evt){
        if(evt.keyCode===13){
            btnBooksSearch.trigger('click');
        }
    });

    btnBooksSearch.on('click', function (evt) {
        var keyword=textKeyword.val().trim();
        if(keyword==""){
            return;
        }
        formBooksSearch.ajaxSubmit({
            url: 'scripts/php/books/search.php',
            methhod: 'get',
            success: function (response) {
                response = jQuery.parseJSON(response);
                if (response.html) {
                    divBooksResult.addClass('well');
                    divBooksResult.removeClass('alert alert-danger');
                    divBooksResult.css({ 'opacity': '0', 'margin-top': '30px' });
                    divBooksResult.html(response.html);
                    divBooksResult.animate({ 'opacity': '1', 'margin-top': '0px' }, 400);
                }
                else {
                    divBooksResult.removeClass('well');
                    divBooksResult.addClass('alert alert-danger');
                    divBooksResult.html("Ghosh! No results");
                }
            },
            error: function (error) {

            }
        });
    });
});
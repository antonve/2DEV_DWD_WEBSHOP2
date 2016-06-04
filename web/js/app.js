$(document).ready(function(){
    // ajax goto search & filter
    $('#search form').each(function(){
        $(this).submit(function(ev){
            ev.preventDefault();
            $.post($(this).attr('action'), {search_query: $('#search_query').val()}, function(data) {
                $('#content').fadeOut(100, function(){
                    $('#content').html(data);
                }).fadeIn(100);
            });
        });
    });

    var filterSetDefault = function() {
        // set to selected filter items
        $('#products-filter select').each(function(){
            var value = $(this).attr('title');

            $(this).children('option').filter(function() {
                return $(this).attr('value') == value;
            }).attr('selected', true);
        });
    };

    var filterPrepare = function() {
        $('#filter_form').submit(function(ev){
            ev.preventDefault();
            $.post($(this).attr('action'), {'products_filter[category]': $('#products_filter_category').val(), 'products_filter[type]': $('#products_filter_type').val()}, function(data) {
                $('#content').fadeOut(100, function(){
                    $('#content').html(data);
                }).fadeIn(100, function(){
                    filterSetDefault();
                    filterPrepare();
                });
            });
        });
    };

    filterPrepare();
    filterSetDefault();

    // placeholder text
    $('form input[type="text"], form input[type="password"]').each(function(){
        var value = $(this).val();

        // remove text on focus
        $(this).focus(function(){
            if ($(this).val() === value) {
                $(this).val('');
            }
        });

        // place text back on unfocus, if the text didn't change
        $(this).blur(function(){
            if ($(this).val() === '') {
                $(this).val(value);
            }
        });
    });
});

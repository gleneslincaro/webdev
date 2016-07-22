
/*
 * denial javascript
 *
 */
$(function() {
    $('#denial').click(function() {
        $('#form_denial').submit();
    });
    
    if ($('ul#denial_complete').children('li').length == 1) {
        $('#denial_complete li').attr("style", "float: none !important;");
    }
    
    if ($('ul#not_denial_complete').children('li').length == 1) {
        $('#not_denial_complete li').attr("style", "float: none !important;");
    }
});




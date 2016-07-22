
/*
 * keep javascript
 *
 */
$(function() {
    $('#keep').click(function() {
        $('#form_keep').submit();
    });
    
    if ($('ul#keep_complete').children('li').length == 1) {
        $('#keep_complete li').attr("style", "float: none !important;");
    }
});


      
  


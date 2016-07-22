
/*
 * denial javascript
 *
 */
$(function() {
    var type = window.location.hash.substr(1);
    if (type != '') {
        if ((/iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent)) || (!(/Android/i.test(navigator.userAgent)))) {
            $('html,body').animate({
                scrollTop: ($('#'+type).offset().top) - ($('.header_inner').height()-40)
            },100);
        }
    }
    
    $('#contact_us').click(function() { 
        $('#form_contact_us').submit();
    });    
});

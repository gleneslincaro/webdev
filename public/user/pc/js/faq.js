
/*
 * denial javascript
 *
 */
$(function() {
    var type = window.location.hash.substr(1);
    var animate_speed = 100;
    if (type != '') {
        if(type != 'form_contact') {
            scroll = ($('#'+type+'_1').offset().top);
            animate_speed = 800
        } else {
            scroll  = $('#'+type).offset().top;
        }
        if ((/iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent)) || (!(/Android/i.test(navigator.userAgent)))) {
            $('html,body').animate({
                scrollTop: scroll
            },animate_speed);
        }
    }
    
    $('#contact_us').click(function() { 
        $('#form_contact_us').submit();
        return false;
    });    
});




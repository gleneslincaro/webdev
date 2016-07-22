
/*
 * dictionary javascript
 *
 */
$(function() {
    $(".acoddion-gloup dd").css("display","none");
    $(".acoddion-gloup dt").click(function() {
        if ($("+dd",this).css("display")=="none") {
            $(this).addClass("slide_close");
            $("+dd",this).slideDown(200);
        } else {
            $(this).removeClass("slide_close");
            $("+dd",this).slideUp(200);
        }
    });
});


/*
 * inquiry javascript
 *
 */
$(function() {
    $(".pagination a").click(function() {
        var url = $(this).attr("href");
        $.post(url,{ajax:'0'},function(data) {
            $("#wrap").html(data);
        });
        return false;
    });
});

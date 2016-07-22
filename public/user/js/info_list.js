
/*
 * info_list javascript
 *
 */
$(function() {
    var offset = 0;
    var flag = 1;       
    if ($(window).scrollTop() + $(window).height() == $(document).height() && flag == 1) {   
        checkHasMoreNews();
    }
    $(window).scroll(function() {
        if ($(window).scrollTop() + $(window).height() == $(document).height() && flag == 1) {           
            flag = 0;
            checkHasMoreNews();
        }
    });        
    //show more News
    function checkHasMoreNews() {
        var offset = $('ul#news_wrapper').children('li').length;                              
        var count_all = parseInt($("#countall_news_id").val());
        var limit = parseInt($("#limit_news_id").val());            
        if (offset < count_all) {     
            $('#loader_wrapper').html('<img src="' + base_url +'public/owner/images/loading.gif" id="loader">');  
            $.ajax({
                url: base_url + "user/news/ajax_GetNews",
                type: "post",
                data: "limit=" + limit + "&offset" + offset,
                async: true,
                success: function(show_more) {
                    flag = 1;
                    $("#news_id").append(show_more);
                    $('#loader').remove();
                }
            })
            return false;
        }            
    }
});

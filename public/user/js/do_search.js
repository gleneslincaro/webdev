/*
 * do_search javascript
 *
 */
$(function(){
    ifck();
    var pageheight = window.innerHeight;
    var allCount = 0;

    $('#sendRefin').click(function() {
        $('.refine_search .page_wrap_inner').css({ 'height': pageheight - (2*110) });
        $('.refine_search_bg, .refine_search').show();
        $('body').css({ 'overflow': 'hidden' });
    });
    
    $('.refine_search_close').click(function() {
        $('body').css({ 'overflow': 'auto' });
        $('.refine_search_bg, .refine_search').hide();
        $(".footer_search_area").css("display","none");
        $('input:checked').each(function() {
            $(this).prop('checked', false);
        });

    });
    
    $('.all_check').change(function() {
        ifck();
    });
    $('#ck_all').change(function() {
        if ($(this).is(':checked')) {
            $('.all_check').prop('checked', true);
        }else{
            $('.all_check').prop('checked', false);
        }
        ifck();
    });


    function ifck() {
        var allVals = [];
        var searchurl = '';
        var ocount = 0;
        var arr_id = [];
        $('.city_search :checked').each(function() {
            if ($(this).val() != 'all_check') {
                allVals.push($(this).val());
                var str = $(this).data('id').toString().split(',');
                var uniqueNames = [];
                $.each(str, function(i, el){
                    if($.inArray(el, arr_id) === -1){
                        arr_id.push(el);
                    }
                });
            }

        });

        ocount = arr_id.length;
        $('.sCount').html(ocount);
        for (x=0;x<allVals.length;x++) {
            if (allVals[x] !== "undefined " || allVals[x] != null) {
                if (x == 0 || x == allVals.length) {
                    searchurl += allVals[x];
                } else {
                    searchurl += '-' + allVals[x];
                }
            }

        }
        
        var page_url = String(window.location);
        page_url_last_char = page_url.slice(-1);
        var backslash = '';
        if (page_url_last_char != '/') {
            backslash = '/'
        }
        $('.city_search_button a, .search_button_fix a').attr('href', page_url + backslash + $.trim(searchurl) + '/');
        
        if (ocount <= 0 ) {
            $('.city_search_button a').removeAttr('href');
            $('.search_button_fix a').removeAttr('href');
        } else {
            $('.city_search_button a ,.search_button_fix a').click(function() {
                $('#ck_all, .all_check').prop('checked', false);
            });
        }
    }
    
    $(document).on('change', 'input:checkbox', function() {
        var scope = $(this).closest('.city_search');
        var checked_cnt = $("input:checkbox:checked", scope).length;
        if (checked_cnt > 0) {
            $(".search_button_fix").css("display","block");
        } else {
            $(".search_button_fix").css("display","none");
        }
    });
    
    $('#sendRefin').click(function( ){
        $('#formRefin').submit();
        return false;
    });
    
    $(".section--search_conf .content_title").click(function() {
        if ($(".box_inner").css("display")=="none") {
            $(this).addClass("slide_close");
            $(".section--search_conf .box_inner").slideDown(200);
        } else {
            $(this).removeClass("slide_close");
            $(".section--search_conf .box_inner").slideUp(200);
        }
    });


    if(getHeight('.features_inner .comment_area',120)){
        $('.features_inner').next('.open_btn').remove();
    }
    if(getHeight('.features_inner1 .comment_area',120)){
        $('.features_inner1').next('.open_btn').remove();
    }
    if(getHeight('.features_inner2 .comment_area',120)){
        $('.features_inner2').next('.open_btn').remove();
    }

    $("#more_btn").on("click",function() {
        if ($("#more_btn").hasClass("close_btn")){
            $("#more_btn").removeClass("close_btn").addClass("open_btn");
            $("#more_btn i").removeClass("fa-chevron-up").addClass("fa-chevron-down");
            $(".features_inner .comment_area").css("max-height","120px");
            $("#more_btn span").text('もっと見る');
        }else{
            $("#more_btn").removeClass("open_btn").addClass("close_btn");
            $("#more_btn i").removeClass("fa-chevron-down").addClass("fa-chevron-up");
            $(".features_inner .comment_area").css("max-height","none");
            $("#more_btn span").text('閉じる');
        }
    });
    $("#more_btn1").on("click",function() {
        if ($("#more_btn1").hasClass("close_btn")){
            $("#more_btn1").removeClass("close_btn").addClass("open_btn");
            $("#more_btn1 i").removeClass("fa-chevron-up").addClass("fa-chevron-down");
            $(".features_inner1 .comment_area").css("max-height","120px");
            $("#more_btn1 span").text('もっと見る');
        }else{
            $("#more_btn1").removeClass("open_btn").addClass("close_btn");
            $("#more_btn1 i").removeClass("fa-chevron-down").addClass("fa-chevron-up");
            $(".features_inner1 .comment_area").css("max-height","none");
            $("#more_btn1 span").text('閉じる');
        }
    });
    $("#more_btn2").on("click",function() {
        if ($("#more_btn2").hasClass("close_btn")){
            $("#more_btn2").removeClass("close_btn").addClass("open_btn");
            $("#more_btn2 i").removeClass("fa-chevron-up").addClass("fa-chevron-down");
            $(".features_inner2 .comment_area").css("max-height","120px");
            $("#more_btn2 span").text('もっと見る');
        }else{
            $("#more_btn2").removeClass("open_btn").addClass("close_btn");
            $("#more_btn2 i").removeClass("fa-chevron-down").addClass("fa-chevron-up");
            $(".features_inner2 .comment_area").css("max-height","none");
            $("#more_btn2 span").text('閉じる');
        }
    });
    
    function getHeight(select,max_height){
        var h = $(select).height();
        if(h > max_height){
            $(select).css("max-height",max_height+"px");
            return false;
        }
        return true;
    }    
});
/*
 * do_search javascript
 *
 */
$(function(){
    var url   = location.href;
    var params    = url.split("?");

    var spparams   = params[1].split("&");
    var paramArray = [];
    var hashArray = [];
    var obj = {};

    vol = spparams[0].split("#");

    for (i = 0;i < vol.length;i++) {
        res = vol[i].split("=");
        var h = res[0];
        obj[h] = res[1];
    }

    var category_id = obj['c'];
    var first_page = obj['page'];
/*
    if (first_page == undefined) {
        console.log('undefined???');
    } else {
    }*/

        if (first_page == undefined) {
            console.log('undefined???');
            first_page = 1;
        }

        var json = $("input[name='owners_json']").val();
        var url = base_url+"user/faq/faq_ajax";
        $.ajax({
            type:"POST",
            url:base_url+"user/faq/faq_ajax",
            data:{page:first_page,next_page:first_page,owners_json:json,category_id:category_id},
            dataType: 'json'
        }).done(function(data){
            var page0 = 1;
            var page1 = data.count;
            if (first_page > 1) {
                var page0 = (first_page - 1) * page_line_max + 1;
                var page1 = (page0 + data.count) - 1;
            }
            $('.category_list_pager p strong').html(page0+' - '+page1);
            $('.everyone_qa_category_list').html(data.html);
            $("input[name='category_list_page_num']").val(first_page);
        }).fail(function(data){
            alert('error!!!');
        });

    $('.pager_nav .pager_left').on('click', function() {
        var num = $("input[name='category_list_page_num']").val();
        var json = $("input[name='owners_json']").val();
        var url = base_url+"user/faq/faq_ajax";

        if (1 < num) {
            var next_page = Number(num) - 1;
            $.ajax({
                type:"POST",
                url:base_url+"user/faq/faq_ajax",
                data:{page:1,next_page,next_page,owners_json:json,category_id:category_id},
                dataType: 'json'
            }).done(function(data){
                var page0 = 1;
                var page1 = data.count;
                if (next_page > 1) {
                    var page0 = (next_page - 1) * page_line_max + 1;
                    var page1 = (page0 + data.count) - 1;
                }
                $('.category_list_pager p strong').html(page0+' - '+page1);
                $('.everyone_qa_category_list').html(data.html);
                $("input[name='category_list_page_num']").val(next_page);
                location.hash = 'page='+next_page;
            }).fail(function(data){
                alert('error!!!');
            });
        }
        return false;
    });

    var page_max = $("input[name='page_max']").val();

    $('.pager_nav .pager_right').on('click', function() {
        var num_temp = $("input[name='category_list_page_num']").val();
        var num = Number(num_temp);
        var json = $("input[name='owners_json']").val();
        var url = base_url+"user/faq/faq_ajax";

        if (page_max > num) {
            var next_page = Number(num) + 1;
            $.ajax({
                type:"POST",
                url:base_url+"user/faq/faq_ajax",
                data:{page:1,next_page,next_page,owners_json:json,category_id:category_id},
                dataType: 'json'
            }).done(function(data){
                var page0 = 1;
                var page1 = data.count;
                if (next_page > 1) {
                    var page0 = (next_page - 1) * page_line_max + 1;
                    var page1 = (page0 + data.count) - 1;
                }
                $('.category_list_pager p strong').html(page0+' - '+page1);
                $('.everyone_qa_category_list').html(data.html);
                $("input[name='category_list_page_num']").val(next_page);
                location.hash = 'page='+next_page;
            }).fail(function(data){
                alert('error!!!');
            });
        }
        return false;
    });

});
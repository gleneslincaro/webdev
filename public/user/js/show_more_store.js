
/*
 * show_more_store javascript
 *
 */
$(function() {    
    check_has_load_more();
    //show more store    
    function checkHasMoreStore() {
        offset = $('ul#store_list').children('li').length;
        count_all = parseInt($("#countall_company_id").val());  
        var info_id = [];
        $('input[name^="info_id"]').each(function() {
            info_id.push($(this).val());
        });
        count_all = parseInt($("#countall_company_id").val());
        if (offset < count_all) {
            $('#loader_wrapper').html('<img src="'+ base_url + 'public/owner/images/loading.gif" id="loader">');
            $.ajax({
                url:base_url + "user/" + controller_name + '/' + ajax_load_more,
                type:"post",
                data:"count_all="+count_all+"&offset="+offset+search_area+"&info_id="+ info_id,
                async:true,
                success: function(show_message){                    
                    $("#store_list").append(show_message);
                    $('#loader').remove();
                    offset = $('#store_list ul#store_wrapper').children('li').length;
                    check_has_load_more();
                    if (offset == count_all) {
                        $('#more_company_id_result').hide();
                    }                    
                }
            })
            return false;
        }
    }
    
    function check_has_load_more() {
        var offset = $('ul#store_list').children('li.with_company_details').length;
        var count_all = parseInt($("#countall_company_id").val());   
        if (offset < 1) {
            $('#more_company_id_result').hide();       
        }
        if (offset == count_all) {
            $('#more_company_id_result').hide();
        }        
    }
    
    $('#more_company_id').click(function() {
       checkHasMoreStore();
    });
});
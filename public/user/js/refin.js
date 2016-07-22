
/*
 * refin javascript
 *
 */
$(function() {
    $(document).on('change', 'input:checkbox', function() {
        var jobs = [];
        var treatments = [];
        var searchurl = '';
        var ocount = 0;        
        var scope = $(this).closest('.refine_search_table');
        var checked_cnt = $("input:checkbox:checked", scope).length;
        if (checked_cnt > 0) {
            $(".footer_search_area").css("display","block");
        } else {
            $(".footer_search_area").css("display","none");
        }
        $('.f_left input:checked').each(function() {
            jobs.push($(this).val());
        });
        $('.f_right input:checked').each(function() {
            treatments.push($(this).val());
        });

        var lnktreatments = treatments.join('%2c');
        var lnkjobs = jobs.join('%2c');

        var search_guery = base_url + 'user/jobs/' + group_city_info + '/' + city_info_alph_name + '/' + town + '/';
        var search_guery = '';
        if(lnktreatments != '' || lnkjobs != ''){
            search_guery += '?';
            if(lnktreatments != ''){
                search_guery += 'treatment=' + lnktreatments;
                if(lnkjobs != ''){
                    search_guery += '&cate=' + lnkjobs;
                }
            }else{
                if(lnkjobs != ''){
                    search_guery += 'cate=' + lnkjobs;
                }
            }
        }
        $('.footer_search_area a').attr('href',search_guery);
    });
});

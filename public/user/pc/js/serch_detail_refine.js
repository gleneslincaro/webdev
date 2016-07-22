$(function(){


	/*-----------------------------------------------*/
	// search detail pc ver
	/*-----------------------------------------------*/
	// change select or checkbox
//	$(document).on('change', '.search_detail select, .search_detail :checkbox', function(e){
	$(document).on('change', '.search_detail :checkbox', function(e){
        var jobs = [];
        var user_charas = [];
        var treatments = [];

		var scope = $(this).closest('.search_detail');


		// count selected item
		var selected = 0;
		$('option:selected', scope).each(function(){
			if($(this).val() != ''){
				selected++;
			}
		});

		// count checked item
		var checked = 0;
//		checked = $(':checkbox:checked', scope).length;

        $('.search_conditions-job_types ul li input:checked', scope).each(function() {
            jobs.push($(this).val());
			checked++;
        });

        $('.search_conditions-treatments ul li input:checked', scope).each(function() {
            treatments.push($(this).val());
			checked++;
        });
        $('.search_conditions-treatments_others ul li input:checked', scope).each(function() {
            treatments.push($(this).val());
			checked++;
        });
        $('.search_conditions-user_character ul li input:checked', scope).each(function() {
            user_charas.push($(this).val());
			checked++;
        });

        var lnktreatments = treatments.join('%2c');
        var lnkjobs = jobs.join('%2c');
        var lnkcharas = user_charas.join('%2c');

			var search_guery = base_url + 'user/jobs/' + group_city_alph_name + '/' + city_info_alph_name + '/' + town + '/';
	        if(lnktreatments != '' || lnkjobs != '' || lnkcharas != ''){
	        	var query_count = 0;
	            if(lnktreatments != ''){
	            	search_guery += (query_count > 0)? '&':'?';
	                search_guery += 'treatment=' + lnktreatments;
		        	query_count++;
	            }
	            if(lnkjobs != ''){
	            	search_guery += (query_count > 0)? '&':'?';
					search_guery += 'cate=' + lnkjobs;
		        	query_count++;
	            }
	            if(lnkcharas != ''){
	            	search_guery += (query_count > 0)? '&':'?';
					search_guery += 'userchara=' + lnkcharas;
		        	query_count++;
	            }
	        }

			// button enable or disabled
			if(selected > 0 || checked > 0){
				$(".btn_search", scope).removeClass('disabled');
				$(".btn_search").attr('href',search_guery);
			}else{
				$(".btn_search", scope).addClass('disabled');
				$(".btn_search").attr('href','javascript:void(0)');
			}

	});

	// more button
	$('.search_detail .close').on('click', function(){
		$(this).toggleClass('open').next().slideToggle(200);
	});

});

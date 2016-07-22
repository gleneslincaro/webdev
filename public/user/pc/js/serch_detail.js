$(function(){

	/*-----------------------------------------------*/
	// search detail pc ver
	/*-----------------------------------------------*/
	// change select or checkbox
	var area_search_guery = '';
	var area_search_guery_town = '';
	$(document).on('change', '.search_detail select, .search_detail :checkbox', function(e){
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

		var class_name = $(this).attr('class');
		if(class_name == 'select_area_cityg'){
			$(".btn_search").addClass('disabled');
			$(".btn_search").attr('href','javascript:void(0)');
			var id = $(this).val();
			area_search_guery = '';
			area_search_guery_town = '';
			$.ajax({
				url:base_url+"user/jobs/ajax_cityname_list",
				type:"post",
				data:{q:'getCitys',city_groups_id:id}
			}).done(function(data){
				$('.select_prefecture').html(data);
				return;
			}).fail(function(data){
				alert('error!!!');
			});
		}else if(class_name == 'select_prefecture'){
			var group_city_id = $('.select_area_cityg').val();
			var id = $(this).val();
			if(id == ''){
				$(".btn_search").addClass('disabled');
				$(".btn_search").attr('href','javascript:void(0)');
				return;
			}
			$.ajax({
				url:base_url+"user/jobs/ajax_cityname_list",
				type:"post",
				dataType:"json",
				data:{q:'getTowns',city_groups_id:group_city_id,city_id:id}
			}).done(function(data){
				area_search_guery = base_url + 'user/jobs/' + data.cityGroup + '/' + data.city + '/';
				if(data.towns != ''){
					area_search_guery_town = data.towns;
					area_search_guery += data.towns+'/';
				}else{
					lnktreatments = '';
					lnkjobs = '';
					lnkcharas = '';
				}
				var search_guery = area_search_guery;
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
				if(selected > 1 && checked > 0){
					$(".btn_search").removeClass('disabled');
					$(".btn_search").attr('href',search_guery);
				}else{
					$(".btn_search").addClass('disabled');
					$(".btn_search").attr('href','javascript:void(0)');
				}
			}).fail(function(data){
				alert('error!!!');
			});
		}else{
			var search_guery = area_search_guery;
			if(area_search_guery_town != ''){
				area_search_guery += area_search_guery_town;
			}else{
				lnktreatments = '';
				lnkjobs = '';
				lnkcharas = '';
			}
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
			if(selected > 1 && checked > 0){
				$(".btn_search").removeClass('disabled');
				$(".btn_search").attr('href',search_guery);
			}else{
				$(".btn_search").addClass('disabled');
				$(".btn_search").attr('href','javascript:void(0)');
			}
		}

	});

	// more button
	$('.search_detail .close').on('click', function(){
		$(this).toggleClass('open').next().slideToggle(200);
	});

});
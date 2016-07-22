/*---------------------------------------*/
// change map image
/*---------------------------------------*/
function changeMapImage(imgPath){
	$('#district_map').attr('src', imgPath);
}

$(function(){

    var array = [];
    $('.section--joyspe_desc .container ul li').each(function(index, element){
      //console.log(index + ': ' + $(element).height());
      array.push($(element).height());
    });
    var h = Math.max.apply(null, array);
    $('.section--joyspe_desc .container ul li').height(h);

	/*---------------------------------------*/
	// tab
	/*---------------------------------------*/
	$(document).on('click', '.tab_menu li a', function(e){
		e.preventDefault();
		var scope = $(this).closest('.tab_wrap');
		var target = $($(this).attr('href'));

		// chage tab contents
		$('.tab_contents', scope).hide();
		target.show();
		// change active tab
		$('.tab_menu li', scope).removeClass('on');
		$(this).closest('li').addClass('on');
	});

	/*---------------------------------------*/
	// toggle function
	/*---------------------------------------*/
	$(document).on('click', '.func_toggle', function(e){
		e.preventDefault();
		// trigger
		var trigger = $(this);
		// scope
		var scope = $(this).closest('section');
		// target element
		var target = $($(this).attr('data-target'), scope);
		if(target.length == 0){
			return;
		}
		// default settings
		var defaults = {
			action : '',
			speed: 200
		};
		// opitons
		var options = {};
		options.action = trigger.attr('data-action');
		options.speed = trigger.attr('data-speed');
		var setting = $.extend(defaults, options);

		// toggle action
		if(target.is(':hidden')){
			if(setting.action == 'slide'){
				target.slideDown(setting.speed);
			}
			else if(setting.action == 'fade'){
				target.fadeIn(setting.speed);
			}
			else{
				target.show();
			}
			trigger.addClass('on');
		}else{
			if(setting.action == 'slide'){
				target.slideUp(setting.speed, function(){
					trigger.removeClass('on');
				});
			}
			else if(setting.action == 'fade'){
				target.fadeOut(setting.speed, function(){
					trigger.removeClass('on');
				});
			}
			else{
				target.hide();
				trigger.removeClass('on');
			}
		}
	})

	/*-----------------------------------------------*/
	// search detail pc ver
	/*-----------------------------------------------*/
	// change select or checkbox
/*
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
*/
	/*---------------------------------------*/
	// search tags
	/*---------------------------------------*/
	$(document).on('click', '.search_tags li', function(e){
		e.preventDefault();
		$(this).fadeOut(200);
		var remove_town = $(this).data('town');
		var remove_job = $(this).data('job');
		var remove_treatment = $(this).data('treatment');
		var towns = '';
		var jobs = '';
		var treatments = '';
		$('.search_tags-area li').each(function(){
			if (remove_town != $(this).data('town') && $(this).is(':visible')) {
				towns += $(this).data('town') + '-';
			}
		});
		$('.search_tags-job_types li').each(function(){
			if (remove_job != $(this).data('job') && $(this).is(':visible')) {
				jobs += $(this).data('job') + ',';
			}
		});
		$('.search_tags-treatments li').each(function(){
			if (remove_treatment != $(this).data('treatment') && $(this).is(':visible')) {
				treatments += $(this).data('treatment') + ',';
			}
		});
		if (towns) {
			window.location.href = base_url + 'user/jobs/' + group_city_alph_name + '/' + city_info_alph_name + '/' + towns.slice(0,-1) + (towns.slice(0,-1) != ''? '/' : '') + (treatments ? "?treatment="+ encodeURIComponent(treatments.slice(0,-1)) : '') + (jobs ? (treatments? "&cate=": "?cate=") + encodeURIComponent((jobs.slice(0,-1))) : '') ;
		} else {
			window.location.href = base_url + 'user/jobs/' + group_city_alph_name + '/' + city_info_alph_name + '/';
		}

		/*** refine datas ***/
	});

	/*---------------------------------------*/
	// btn keep
	/*---------------------------------------*/
	$(document).on('click', '.btn_keep_test', function(e){
		e.preventDefault();
		if($(this).hasClass('on')){
			$(this).removeClass('on');

			/*** execute keep off ***/

		}else{
			$(this).addClass('on');

			/*** execute keep on ***/

		}
	});

	/*---------------------------------------*/
	// btn block
	/*---------------------------------------*/
	$(document).on('click', '.btn_block_test', function(e){
		e.preventDefault();
		if($(this).hasClass('on')){
			$(this).removeClass('on');

			/*** execute block off ***/

		}else{
			$(this).addClass('on');

			/*** execute block on ***/

		}
	});

	/*---------------------------------------*/
	// slider pickup store
	/*---------------------------------------*/
	$(document).ready(function(){
		$('#slider_pickup_store').bxSlider({
			pager: false,
			maxSlides: 5,
			auto: false,
			pause: 6000,
			speed: 500,
			randomStart: false
		});
	});

	/*---------------------------------------*/
	// show pop up after logout
	/*---------------------------------------*/
	$(document).ready(function(){
		$('#btn_logout').click(function(){
			$.post('/user/login/logout/',function(data){
				if(data == 'true') {
					alert('ログアウトしました');
					window.location.href = '/';
				}
			});
		});

	});


	/*---------------------------------------*/
	// show more list experiences
	/*---------------------------------------*/
	$(document).ready(function(){
        $('.experience_load_more').on('click', function(){
            var page = $(this).attr('data-page');
            var btn = $(this);
            $.ajax({
                type:"post",
                async: true,
                url: '/user/experiences/experiences_load_more/',
                data: {'page': page},
                dataType: 'json',
                success: function(data){
                    var val = '';
                    if ((page) < data.count) {
                        for (var x = 0; x < data.info.length; x++) {
                            var new_msg = '';
                            if (data.info[x].new_status == 1) {
                            	var new_msg = '<li><span class="new_experiences">New</span><span class="experiences_ttl">';
                            }

                            val = '<li class="experiences_list"> <a class="link_detail" href="/user/experiences/experiences_detail/' + data.info[x].msg_id + '/">' +
                                        '<ul class="form_preview list">' +
                                            new_msg + '<span class="experiences_ttl">' + data.info[x].title + '</span></li>' +
                                            '<li><span class="area_age">' + data.info[x].age_name1 + '歳～' + data.info[x].age_name1 + '歳</span><span class="area_age">' + data.info[x].city_name + '</span></li>' +
                                        '</ul>' +
                                        '<ul class="information_list">' +
                                           ' <li><i class="fa fa-angle-right"></i></li>' +
                                        '</ul>' +
                                        '</a>' +
                                    '</li>';
                        	btn.parents('li').before(val);
                        }

                        btn.attr('data-page', data.offset);
                    } 

                    if (data.offset >= data.count) {
                        btn.hide();
                    }
                    
                }
            });
        });
    });

	/*---------------------------------------*/
	// Modal experiences send form
	/*---------------------------------------*/
	$(document).ready(function(){
        $.fn.extend({
            leanModal: function(options) {
                var defaults = {
                    top: 50,
                    overlay: 0.5
                }

                options = $.extend(defaults, options);
                return this.each(function() {
                    var o = options;
                    $(this).click(function(e) {
                        var title = $('.title').val();
                        var content = $('.content').val();
                        var overlay = $("<div id='lean_overlay'></div>");
                        var modal_id = $(this).attr("href");
                        var msg = '';

                        if (!$.trim(title) || !$.trim(content)) {
                            modal_id = '#experiences_send_modal_3';
                            msg  = (!$.trim(title)) ? "タイトルを記入してください。" : '';
                            msg  += (!$.trim(title) && !$.trim(content)) ? "<br>" : '';
                            msg  += (!$.trim(content)) ? "本文を記入してください。" : '';
        
                            $('.err').html(msg);
                        }

                        if ($(this).hasClass('experiences_send_btn')) {
                            $.ajax({
                                type:"post",
                                url: '/user/experiences/experiences_send/',
                                data: {'title': title, 'content': content},
                                success: function(kq){

                                }
                            });
                        }

                        $("body").append(overlay);
                        $("#lean_overlay").click(function() {
                            close_modal(modal_id);
                        });

                        var modal_height = $(modal_id).outerHeight();
                        var modal_width = $(modal_id).outerWidth();

                        $('#lean_overlay').css({
                            'display': 'block',
                            opacity: 0
                        });

                        $('#lean_overlay').fadeTo(200, o.overlay);
                        $(modal_id).css({
                            'display': 'block',
                            'position': 'fixed',
                            'opacity': 0,
                            'z-index': 11000,
                            'left': 50 + '%',
                            'margin-left': -(modal_width / 2) + "px",
                            'top': o.top + "px"

                        });

                        $(".cancel_btn").click(function() {
                            close_modal(modal_id);
                        });

                        $(modal_id).fadeTo(200, 1);
                        e.preventDefault();
                    });
                });

                function close_modal(modal_id) {
                    $("#lean_overlay").fadeOut(200);
                    $(modal_id).css({
                        'display': 'none'
                    });
                }
            }
        });
    $( 'a[rel*=leanModal]').leanModal();
    });
});

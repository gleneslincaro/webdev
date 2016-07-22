
/*
 * common javascript
 *
 */
$(function(){
	// scroll top
	$(window).scroll(function(){
		if($(this).scrollTop() > 300) {
			$('#scroll_top').fadeIn();
		}else if($(this).scrollTop() < 300){
			$('#scroll_top').fadeOut();
		}
	});
	$('#scroll_top').on('click', function(e){
    if ($(this).hasClass('section--store_keep')) {
        return true;
    }
		e.preventDefault();
		$('html,body').animate({ scrollTop: 0 }, 600);
	});
	
	// reset header position fiexd on old browser
	if(lowerAndroid(5)){
		$('body').addClass('none_fixed');
	}
});

/*--------------------------------------------*/
/* check android version
/*--------------------------------------------*/
function lowerAndroid(n) {
	var bo = false;
	var ua = navigator.userAgent.toLowerCase();
	var version = ua.substr(ua.indexOf('android')+8, 3);
	if(ua.indexOf("android")){
		if(parseFloat(version) < n){
			bo = true;
		}
	}
	return bo;
}


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
                        	var new_msg = '<li><span class="new_experiences">New</span>';
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

                    if ($(this).hasClass('experiences_send')) {
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

/*
 * company_detail javascript
 *
 */
$(function() {
    $( "#txtDateFrom").change(function() {
        var now = $.datepicker.formatDate('yy/mm/dd', new Date());
        var sdate = $('#txtDateFrom').val();
        if(now <  sdate){
        alert('無効な日付です。 \n今日以前の日付を入力してください。');
            $('#txtDateFrom').val("");
        }
    });

    var status_scout_spam_id=$("#status_scout_spam_id").val();

    if (status_scout_spam_id==0) {
        $("#deny_scout_id").show();
        $("#cancel_deny_scout_id").hide();
    } else {
        $("#deny_scout_id").hide();
        $("#cancel_deny_scout_id").show();
    }

    showMoreText();

    function showMoreText() {
        var slideHeight = 330;
        var defHeight = $('.show-more').height();
        if (defHeight >= slideHeight) {
            addShowMore(slideHeight, defHeight);
        }
    }

    function addShowMore(slideHeight, defHeight) {
        $('.show-more').css('height' , '330px');
        $('#read-more').append('<a href="#"><button id = "showmore_btn">もっと見る</button></a>');
        $('#read-more').css('padding', '8px 0');
        $('#read-more a').css('text-decoration', 'none');
        $('#read-more a').click(function(){
            var curHeight = $('.show-more').height();
            if (curHeight == slideHeight) {
                showMoreDisplay(defHeight);
            }
            return false;
        });
    }

    function showMoreDisplay(defHeight) {
        $('.show-more').animate({
            height: defHeight
        }, "fast");
        $('#showmore_btn').hide();
    }

    function hideMoreDisplay(slideHeight) {
        $('.show-more').animate({
            height: slideHeight
        }, "fast");
    }

    $(window).resize(function() {
        var defHeight = $('.show-more').height();
        if (defHeight > 330) {
            $('.company_info').css('border-bottom', '');
            if ($("#read-more:has(a)").length == 0) {
                addShowMore(330, defHeight);
            } else {
                $('#read-more a').remove();
                addShowMore(330, defHeight);
            }
            $('#read-more').show();
        }
    });
});
    
function show(inputData) {
    var objID=document.getElementById( "layer_" + inputData );
    var buttonID=document.getElementById( "category_" + inputData );
    if (objID.className=='close') {
        objID.style.display='block';
        objID.className='open';
    } else {
        objID.style.display='none';
        objID.className='close';
    }
}

$(function() {
    $(".btn_kanryo").click(function () {
        var $url    = baseUrl + "user/keep/keep_application_complete";
        var $ors_id = $('#ors_id');
        var $data   = {
            ors_id: $ors_id.val(),
            type_page: 0
        };

        var $login_url = baseUrl + "user/login/";

        $.ajax({
            type:'POST',
            url: $url,
            data: $data,
            success:function(ret) {
                if ( ret == true ) {
                    $("div p.henko").text("申請ありがとうございます");
                    $("div p.btn_kanryo").css("display","none");
                } else {
                    location.href = $login_url;
                }
            },
            error:function() {
                $("div p.henko").text("申請が失敗しました。お手数ですが、弊社へご連絡ください。");
                $("div p.btn_kanryo").css("display","none");
            }
        });
    });

    $("#contact_hp").click(function() {
        var href = $(this).attr("data-href");
        var childWindow = window.open('about:blank');
        var do_statistics_url = baseUrl + "user/statistics/updateClick";
        $.ajax({
            type: 'POST',
            url: do_statistics_url,
            data: {type: "HP"},
        }).done(function(jqXHR) {
            childWindow.location.href = href;
            childWindow = null;
            insertUserStatisticsLogHP(user_id, owner_id, ors_id, 5);
        }).fail(function(jqXHR) {
            childWindow.close();
            childWindow = null;
        });
    });

    $(".contact_tel").click(function() {
        var href = $(this).attr("data-href");
        var do_statistics_url = baseUrl + "user/statistics/updateClick";
        $.ajax({
            type:'POST',
            url: do_statistics_url,
            data: {type: "TEL"},
            success:function(ret_data) {
                insertUserStatisticsLog(user_id, owner_id, ors_id, 2, href);
            },
          error:function() {
              location.href = href; // redirect
          }
        });
    });

    $(".contact_mail").click(function() {
        var href = $(this).attr("href");
        var do_statistics_url = baseUrl + "user/statistics/updateClick";
        $.ajax({
            type:'POST',
            url: do_statistics_url,
            data: {type: "MAIL"},
            success:function(ret_data) {
                insertUserStatisticsLog(user_id, owner_id, ors_id, 1, href);
            },
            error:function() {
                location.href = href; // redirect
            }
        });
    });

    $(".contact_line").click(function() {
        var href = $(this).attr("data-href");
        var do_statistics_url = baseUrl + "user/statistics/updateClick";
        $.ajax({
            type:'POST',
            url: do_statistics_url,
            data: {type: "LINE"},
            success:function(ret_data) {
                insertUserStatisticsLog(user_id, owner_id, ors_id, 3, href);             
            },
            error:function() {
                location.href = href; // redirect
            }
        });
    });

    $("#contact_kuchikomi").click(function() {
        var href = $(this).attr("data-href");
        var do_statistics_url = baseUrl + "user/statistics/updateClick";
        $.ajax({
            type:'POST',
            url: do_statistics_url,
            data: {type: "KUCHIKOMI"},
            success:function(ret_data) {
                insertUserStatisticsLog(user_id, owner_id, ors_id, 6, href);
            },
            error:function() {
                location.href = href; // redirect
            }
        });
    });
});

$(function() {
    if ($('.pickup_info_content').height() <= 60) {
        $('#pickup_info_btn').hide();
    } else {
        $('.pickup_info_content').css('height', '60px').css('overflow', 'hidden');
    }
    // slider
    $('#slider--shop_main > ul').bxSlider({
        controls: false
    });

    $("#pickup_info_btn").on("click",function() {
        if ($(".pickup_info_content").hasClass("info_close")) {
            $(this).text("閉じる");
            $(".pickup_info_content").css("height","auto").removeClass("info_close").addClass("info_open");
        } else if ($(".pickup_info_content").hasClass("info_open")) {
            $(this).text("もっと見る");
            $(".pickup_info_content").css("height","60px").removeClass("info_open").addClass("info_close");
        }
    });    
});

function insertUserStatisticsLog(user_id, owner_id, ors_id, action_type, href) {
    $.post(baseUrl+'user/statistics/insertUserStatisticsLog', { user_id: user_id, owner_id: owner_id, ors_id: ors_id, action_type: action_type}, function(data) {
        if ( href != '' && (data == true || data == 'true') ) {
            location.href = href;
        }
    });
}

function insertUserStatisticsLogHP(user_id, owner_id, ors_id, action_type, href) {
    $.post(baseUrl+'user/statistics/insertUserStatisticsLog', { user_id: user_id, owner_id: owner_id, ors_id: ors_id, action_type: action_type}, function(data) {
    });
}

$(function(){
	// slider
	$('#slider--store_main > ul').bxSlider({
		controls: false
	});


	$('#slider--store_tabs > ul').bxSlider({
		controls: false
	});

	/*
    $('#slider--tabs_work_flow > ul').bxSlider({
        controls: false
    });
    */
});

$(function(){
  $('#store_conscription').hide();
	$("#trigger_senior").on("click",function(){
		$(".section--store_tabs .tabs_body").addClass("hide");
		$(".section--store_tabs .tabs_senior").removeClass("hide");
		$(".section--store_tabs li").removeClass("active");
		$("#trigger_senior").parent("li").addClass("active");
		return false;
	});
	$("#trigger_flow").on("click",function(){
        $(".section--store_tabs .tabs_body").addClass("hide");
        $(".section--store_tabs .tabs_work_flow").removeClass("hide");
        
        // set slider
        $('#slider--tabs_work_flow > ul').bxSlider({
            controls: false
        });

        $(".section--store_tabs li").removeClass("active");
        $("#trigger_flow").parent("li").addClass("active");
        return false;
    });
	$("#trigger_qa").on("click",function(){
		$(".section--store_tabs .tabs_body").addClass("hide");
		$(".section--store_tabs .tabs_qa").removeClass("hide");
		$(".section--store_tabs li").removeClass("active");
		$("#trigger_qa").parent("li").addClass("active");
		return false;
	});
	$("#trigger_store_info_content").on("click",function(){
		$(".store_info .tabs_body").addClass("hide");
		$("#store_info_content").removeClass("hide");
		$(".section--store_info li").removeClass("active");
		$(this).parent("li").addClass("active");
		return false;
	});
	$("#trigger_store_conscription").on("click",function(){
    $('#store_conscription').show();
		$(".store_info .tabs_body").addClass("hide");
		$("#store_conscription").removeClass("hide");
		$(".section--store_info li").removeClass("active");
		$(this).parent("li").addClass("active");
		return false;
	});
});

$(function(){  
	
	/* section--store_tabs tabs_work_flow */
	$(".section--store_tabs #tabs_work_flow .toggle_area .more_btn").on("click",function(){
		if($(this).hasClass("short")){
			$(this).removeClass("short").addClass("more").text("閉じる");            
			$(".section--store_tabs #tabs_work_flow .toggle_area p").css("height","auto");
		} else if($(this).hasClass("more")){
			$(this).removeClass("more").addClass("short").text("･･･もっと見る");
			$(".section--store_tabs #tabs_work_flow .toggle_area p").css("height","60px");
		}
	});
  
  /* section--store_tabs tabs_senior */
	$(".section--store_tabs #tabs_senior .toggle_area .more_btn").on("click",function(){
		if($(this).hasClass("short")){
			$(this).removeClass("short").addClass("more").text("閉じる");            
			$(".section--store_tabs #tabs_senior .toggle_area p").css("height","auto");
		} else if($(this).hasClass("more")){
			$(this).removeClass("more").addClass("short").text("･･･もっと見る");
			$(".section--store_tabs #tabs_senior .toggle_area p").css("height","58px");
		}
	});
  
  if ($("#tabs_qa .more_wrap").length) {
      q1 = $(".section--store_tabs #tabs_qa .toggle_area .more_wrap dt")[0].scrollHeight;
      q2 = $(".section--store_tabs #tabs_qa .toggle_area .more_wrap dt")[1].scrollHeight;
      a1 = $(".section--store_tabs #tabs_qa .toggle_area .more_wrap dd")[0].scrollHeight;
      a2 = $(".section--store_tabs #tabs_qa .toggle_area .more_wrap dd")[1].scrollHeight;
      
      var store_tabs_tabs_qa_h = q1 + q2 + a1 +a2;
      if(store_tabs_tabs_qa_h < $(".section--store_tabs #tabs_qa .toggle_area .more_wrap").scrollHeight){
        $(".section--store_tabs #tabs_qa .toggle_area .more_btn").addClass("hide");
      } else {
        $(".section--store_tabs #tabs_qa .toggle_area .more_wrap").css("height", store_tabs_tabs_qa_h + 7 + "px" );
      }
  }
   
  /* section--store_tabs tabs_qa */
	$(".section--store_tabs #tabs_qa .toggle_area .more_btn").on("click",function(){
		if($(this).hasClass("short")){
			$(this).removeClass("short").addClass("more").text("閉じる");            
			$(".section--store_tabs #tabs_qa .toggle_area dl").css("height","auto");
		} else if($(this).hasClass("more")){
			$(this).removeClass("more").addClass("short").text("･･･もっと見る");
			$(".section--store_tabs #tabs_qa .toggle_area dl").css("height", store_tabs_tabs_qa_h + 7 + "px");
		}
	});

  
  $('.senior_comment .more_wrap').each(function(){
      var height = $(this).height();     
      if (height < 60) {          
          $(this).parent('.senior_comment').children('.more_btn').addClass("hide");
          $(this).parent('.senior_comment').children('.short').removeClass("more_btn");
      } else {
          $(this).css("height","58px");
      }     
  });
  
	var store_tabs_work_flow_h = $(".section--store_tabs #tabs_work_flow .toggle_area .more_wrap").height();
	if(store_tabs_work_flow_h < 60){
		$(".section--store_tabs #tabs_work_flow .toggle_area .more_btn").addClass("hide");
    $(".section--store_tabs #tabs_work_flow .toggle_area .short").removeClass("more_btn");
	} else {
		$(".section--store_tabs #tabs_work_flow .toggle_area .more_wrap").css("height","60px");
	}
  
  var store_tabs_work_flow_h = $(".section--store_tabs #tabs_work_flow .toggle_area .more_wrap").height();
	if(store_tabs_work_flow_h < 60){
		$(".section--store_tabs #tabs_work_flow .toggle_area .more_btn").addClass("hide");
    $(".section--store_tabs #tabs_work_flow .toggle_area .short").removeClass("more_btn");
	} else {
		$(".section--store_tabs #tabs_work_flow .toggle_area .more_wrap").css("height","60px");
	}
  
	/* section--store_flow */
	$(".section--store_flow .toggle_area .more_btn").on("click",function(){
		if($(this).hasClass("short")){
			$(this).removeClass("short").addClass("more").text("閉じる");
			$(".section--store_flow .toggle_area .more_wrap").css("height","auto");
		} else if($(this).hasClass("more")){
			$(this).removeClass("more").addClass("short").text("･･･もっと見る");
			$(".section--store_flow .toggle_area .more_wrap").css("height","80px");
		}
	});
	var store_flow_h = $(".section--store_flow .toggle_area .more_wrap").height();
	if(store_flow_h < 80){
		$(".section--store_flow .toggle_area .more_btn").addClass("hide");
	} else {
		$(".section--store_flow .toggle_area .more_wrap").css("height","80px");
	}

	
	/* section--store_message */
	$(".section--store_message .toggle_area .more_btn").on("click",function(){
		if($(this).hasClass("short")){
			$(this).removeClass("short").addClass("more").text("閉じる");
			$(".section--store_message .toggle_area p").css("height","auto");
		} else if($(this).hasClass("more")){
			$(this).removeClass("more").addClass("short").text("･･･もっと見る");
			$(".section--store_message .toggle_area p").css("height","60px");
		}
	});
	var store_message_h = $(".section--store_message .toggle_area .more_wrap").height();
	if(store_message_h < 60){
		$(".section--store_message .toggle_area .more_btn").addClass("hide");
	} else {
		$(".section--store_message .toggle_area .more_wrap").css("height","60px");
	}


	/* section--store_interview */
	$(".section--store_interview .toggle_area .more_btn").on("click",function(){
		if($(this).hasClass("short")){
			$(this).removeClass("short").addClass("more").text("閉じる");
			$(".section--store_interview .toggle_area p").css("height","auto");
		} else if($(this).hasClass("more")){
			$(this).removeClass("more").addClass("short").text("･･･もっと見る");
			$(".section--store_interview .toggle_area p").css("height","60px");
		}
	});
	var store_interview_h = $(".section--store_interview .toggle_area .more_wrap").height();
	if(store_interview_h < 60){
		$(".section--store_interview .toggle_area .more_btn").addClass("hide");
	} else {
		$(".section--store_interview .toggle_area .more_wrap").css("height","60px");
	}


});

$(function(){
	$('.tabs_work_flow').addClass("hide");
	$('.tabs_qa').addClass("hide");
});
$(function() {
	$("#request_travel_expense").click(function(){
		if (user_id == '') {
			location.href = baseUrl + "user/login/";
			return false;
		}
        $('#campaingn_bonus_date').dialog({
            resizable: false,
            width: 300,
            modal: true,
            buttons: {
                "交通費申請": function() {
                    var reqDate = $('#txtDateFrom').val();
                    if(reqDate!="" && !reqDate.match(/^(19|20)\d\d\/(0\d|1[012])\/(0\d|1\d|2\d|3[01])$/)){
                        alert("日付が正しくありません。再入力してください。");
                        $('#txtDateFrom').val("");
                        return false;
			        }
                    if (reqDate != '') {
                    	if ( !confirm("このお店の面接交通費を申請してもよろしいでしょうか？") ) {
							return false;
						}
                        $.post(baseUrl+'user/joyspe_user/insertUserTravelExpense', {"owner_id": owner_id, "campaign_id": campaign_id, 'reqDate': reqDate},
					      	function(data) {
					        	if (data ) {
							    if ( data.ret == true ) {
					        		alert('申請が完了しました。');
					        		location.reload();
									$("#campaign_btn_area").html('<button class="btn50 btn" disabled>申請済み</button>');
								} else if ( data.ret == false ) {
									switch( data.error_code ) {
										case 1:
											location.href = baseUrl + "user/login/";
											break;
										case 2:
											alert("現在、キャンペーン終了か申請回数制限で受付終了になっております。")
											break;
										case 3:
											alert("現在、キャンペーン終了か申請回数制限で受付終了になっております。")
											break;
										default:
											alert("不明なエラーです。お手数ですが、弊社へご連絡してください。");
											break;
									}
								}
					      	} else {
								console.log("システムエラー");
							}
						},"json");
                    } else {
                        alert('来店日付の入力をお願いします');
                    }
                }
            }
        });

        return false;
    });
    var dialog;
  	dialog = $( "#dialog-form" ).dialog({
		autoOpen: false,
		height: $('#dialog-form').height() + 38,
		width: $('#dialog-form').width() - 20,
		modal: true,
		buttons: {
      	"送信": function() {
	         var valid = true;
	         if($('#user_title').val().length < 1) {
	            valid = false;
	            $('#validateTips1').text('件名を入力してください。');
	         }
	         else
	  	      $('#validateTips1').text('');

	  	  	if($('#owner_message').val().length < 1) {
	  	      	valid = false;
	            $('#validateTips2').text('メッセージを入力してください。');
	         }
	         else if($('#owner_message').val().indexOf('マシェモバ') != -1 ||
				    $('#owner_message').val().indexOf('承認') != -1 ||
					$('#owner_message').val().indexOf('申請') != -1 ){
	         	valid = false;
	         	alert('禁止ワードが入っています');
	         }else
	  	     	$('#validateTips2').text('');

	         if(valid) {
				var $msg_content = $('#bk_storename').val() + "様へ\r\n\r\n";
				$msg_content += $('#owner_message').val();
	            $.post(baseUrl+'user/joyspe_user/sendMessageToOwner',
	               {owner_id: $('#bk_owner_id').val(), title: $('#user_title').val(), content: $msg_content},
	               function(data) {
	              	dialog.dialog( "close" );
	                  if(data == true || data == 'true')
	                     alert('メッセージを送信しました。');
	                  else
	                     alert('メッセージを送信しませんでした。');
                      var count= parseInt($('#count_conversation').text())+1;
                      $('#count_conversation').text(count);
	               }
	            );
	         }
      	},
	},
	close: function() {
    	$('.validateTips').val('');
	}
	});


	$('.anonymous_ask').click(function(){
		$.get(baseUrl+'user/joyspe_user/if_login/', { url: baseUrl+'user/joyspe_user/company/'+ors_id }, function(data) {
		 if(data != 1) {
		    data = data.split('"').join('');
			    window.location.replace(baseUrl+'user/inquiry/'+ors_id);
		 }
		 else {
			$('#user_title').val('')
		    $('#owner_message').val('')
		    $('.validateTips').text('');
		    $('#dialog-form').dialog("open");
		}
		});
	});

    $('#btnclose').click(function(){
        $('#campaingn_bonus_date').dialog('close');
    });

	$("#request_campaingn_bonus_date").click(function(){
		if (user_id == '') {
			location.href = baseUrl + "user/login/";
			return false;
		}
        $('#campaingn_bonus_date').dialog({
            resizable: false,
            width: 300,
            modal: true,
            buttons: {
                "体験入店申請": function() {
                    var reqDate = $('#txtDateFrom').val();
                    if(reqDate!="" && !reqDate.match(/^(19|20)\d\d\/(0\d|1[012])\/(0\d|1\d|2\d|3[01])$/)){
                        alert("日付が正しくありません。再入力してください。");
                        $('#txtDateFrom').val("");
                        return false;
			        }
                    if (reqDate != '') {
                        $.ajax({
                            type:"POST",
                            url: getUrl + "user/joyspe_user/insertRequestCampaign",
                            data:{ "owner_id": owner_id, 'campaignBonusRequestId': campaignBonusRequestId, 'reqDate': reqDate},
                            dataType: 'json',
                            success: function(data){
                                if (data ) {
								    if ( data.ret == true ) {
						        		alert('申請が完了しました。');
										$("#campaign_btn_area").html('<button class="btn50 btn" disabled>申請済み</button>');
									} else if ( data.ret == false ) {
										switch( data.error_code ) {
											case 1:
												location.href = baseUrl + "user/login/";
												break;
											case 2:
												alert("現在、キャンペーン終了か申請回数制限で受付終了になっております。")
												break;
											case 3:
												alert("現在、キャンペーン終了か申請回数制限で受付終了になっております。")
												break;
											default:
												alert("不明なエラーです。お手数ですが、弊社へご連絡してください。");
												break;
										}
									}
						      	} else {
									console.log("システムエラー");
								}
								location.reload();
                            }
                        });
                    } else {
                        alert('来店日付の入力をお願いします');
                    }
                }
            }
        });

        return false;
    });

});
function close_dialog() {
    $("#dialog-form").dialog('close');
}
$(function() {
	$( "#txtDateFrom" ).datepicker({ dateFormat: "yy/mm/dd" });
});
/* Japanese initialisation for the jQuery UI date picker plugin. */
/* Written by Kentaro SATO (kentaro@ranvis.com). */
(function( factory ) {
	if ( typeof define === "function" && define.amd ) {

		// AMD. Register as an anonymous module.
		define([ "../datepicker" ], factory );
	} else {

		// Browser globals
		factory( jQuery.datepicker );
	}
}(function( datepicker ) {

datepicker.regional['ja'] = {
	closeText: '閉じる',
	prevText: '&#x3C;前',
	nextText: '次&#x3E;',
	currentText: '今日',
	monthNames: ['1月','2月','3月','4月','5月','6月',
	'7月','8月','9月','10月','11月','12月'],
	monthNamesShort: ['1月','2月','3月','4月','5月','6月',
	'7月','8月','9月','10月','11月','12月'],
	dayNames: ['日曜日','月曜日','火曜日','水曜日','木曜日','金曜日','土曜日'],
	dayNamesShort: ['日','月','火','水','木','金','土'],
	dayNamesMin: ['日','月','火','水','木','金','土'],
	weekHeader: '週',
	dateFormat: 'yy/mm/dd',
	firstDay: 0,
	isRTL: false,
	showMonthAfterYear: true,
	yearSuffix: '年'};
datepicker.setDefaults(datepicker.regional['ja']);

return datepicker.regional['ja'];

}));
$(function(){
    $( "#dialog-confirm" ).hide();
    $( "#dialog-list_of_hide_users" ).hide();
    $("#thm1").addClass("visited");

    $('.user-image').bind('contextmenu', function(e){
        return false;
    });

    $('table.user_apply td button').click(function() {
        var _this = this;
        var id = $(this).data('id');
        var approval_val = $(this).data('approval_val');
        $.post(baseUrl+'owner/index/responseToUserExpenseRequest', {id: id, approval_val: approval_val}, function(data){
            if(data == true || data == 'true') {
                if (approval_val == 1 ) {
                    alert("承認が完了しました。");
                } else {
                    alert("非承認が完了しました。");
                }
                $(_this).parent('td').parent('tr').fadeOut(1000);
            } else {
                    alert("エラーが発生します。");
            }
        });
    });

    $('table.user_request_bunos td button').click(function() {
        var _this = this;
        var id = $(this).data('id_req');
        var reqapproval_val = $(this).data('reqapproval_val');
        $.post(baseUrl+'owner/index/responseToUserBunosRequest', {id: id, reqapproval_val: reqapproval_val}, function(data){
            if(data == true || data == 'true') {
                if (reqapproval_val == 1 ) {
                  alert("承認が完了しました。");
                } else {
                  alert("非承認が完了しました。");
                }
                $(_this).parent('td').parent('tr').fadeOut(1000);
            } else {
                alert("エラーが発生します。");
            }
        });
    });

    $('#show_list_of_hide_users').click(function (){
		$.get(baseUrl+"owner/index/count_owner_hidden_users", function(data) {
			if(data > 0) {
			  	$.get(baseUrl+"owner/index/list_of_hide_users")
			  	  .done(function( data ) {
			  		$( "#dialog-list_of_hide_users" ).html( data );
			  		//var height = $( "#dialog-list_of_hide_users" ).height() + 80;
			  		$( "#dialog-list_of_hide_users" ).dialog({
						resizable: false,
				      	height: 421,
				      	width: 930,
				      	modal: true,
				      	buttons: {
					        "Ok": function() {
						    var sortUser = 'login_user0';
						    if($('#sortUsers').val() != '')
							    sortUser = $('#sortUsers').val();
					    	    $.post(baseUrl+"owner/index/list_of_users",{sort_type: sortUser, function_name: 'return sendScout();' })
					     	    .done(function(data){
					     	    $('.img-prof').html(data);
					            $('.sort span').removeClass('active_blue');
					            $('#'+sortUser).addClass('active_blue');
					            $('#sortUsers').val(sortUser);
							    $( "#dialog-list_of_hide_users" ).dialog("close");
					     	});
						  }
				  		}
				  	});
				});
			}else{
                alert('非表示されているユーザーがいません。');
            }
	    });
    });

});

function hide_user(id) {
	$( "#dialog-confirm" ).dialog({
	    resizable: false,
	    height:140,
	    width: 300,
	    modal: true,
	    closeOnEscape: true,
	    buttons: {
	        "はい": function() {
                $('#sort_in_progress').show();
		        $.post(baseUrl+'owner/index/remove_user_scout',{id: id},function(data){
			        if($('#checkrss' + id).is(":checked"))
			    	    $('#checkrss' + id).removeAttr('checked');
                    $('#user_'+id).fadeOut(200, function(){
                      var sortUser = 'login_user0';
                      if($('#sortUsers').val() != '')
                        sortUser = $('#sortUsers').val();
                        $.post(baseUrl+"owner/index/list_of_users",{sort_type: sortUser, function_name: 'return sendScout();' })
                        .done(function(data){
                            $('#sort_in_progress').hide();
                            $('.img-prof').html(data);
                        });
                    });
			  });
		      $( this ).dialog( "close" );
	        },
	        "いいえ": function() {
	          $( this ).dialog( "close" );
	        }
	    }
    });
}

function show_users(id) {
    $.post(baseUrl+"owner/index/show_scout_user", {id: id}, function(data) {
	if (data > 0 ) {
        $('#hide_user_'+id).fadeOut(200);
    } else {
        var sortUser = 'login_user0';
        if ($('#sortUsers').val() != '') {
            sortUser = $('#sortUsers').val();
        }
        $('#sort_in_progress').show();
 	    $.post(baseUrl+"owner/index/list_of_users",{sort_type: sortUser, function_name: 'return sendScout();' })
 	      .done(function(data){
            $('#sort_in_progress').hide();
 		    $('.img-prof').html(data);
            $('.sort span').removeClass('active_blue');
            $('#'+sortUser).addClass('active_blue');
            $('#sortUsers').val(sortUser);
	  	    $( "#dialog-list_of_hide_users" ).dialog("close");
 	    });
	}
});

}

function sortUsersFunc(e) {
    $('#sort_in_progress').show();
    $.post(baseUrl+"owner/index/list_of_users",{sort_type: e.id, function_name: 'return sendScout();' }, function(data){
        $('.img-prof').html(data);
        $('.sort span').removeClass('active_blue');
        $('#'+e.id).addClass('active_blue');
        $('#sortUsers').val(e.id);
        $('#sort_in_progress').hide();
    });
}

$(document).ready(function() {
// add multiple select / deselect functionality
    $("#ckAll").click(function() {
        $('.case').attr('checked', this.checked);
        sendScout();
    });

    // if all checkbox are selected, check the selectall checkbox
    // and viceversa
    $(".case").click(function() {

        if ($(".case").length == $(".case:checked").length) {
            $("#ckAll").attr("checked", "checked");
        } else {
            $("#ckAll").removeAttr("checked");
        }

    });

// add multiple select / deselect functionality
    $(".checkall").click(function() {
        var checkall = $(this).attr('id');
        $('.' + checkall).attr('checked', this.checked);
    });
});

function checkAll()
{
    if ($('#ckAll').is(':checked'))
    {
        $("input[name='checkrs[]']").each(function() {
            $(this).attr('checked', true);
        });
    }
    else
    {
        $("input[name='checkrs[]']").each(function() {
            $(this).removeAttr('checked');
        });
    }
}

function check()
{
    var flag = false;
    var str = "checkrs[]";
    var send_limit = document.getElementById('sendlimit').value;
    var chk_cnt = 0;
    var chk = document.getElementsByName(str);
    //console.log(chk);
    for (i = 0; i < chk.length; i++) {
        if (chk[i].checked == true) {
            flag = true;
            chk_cnt++;
        }
    }
    if (flag == false) {
        alert("チェックボックスが選択されておりません。対象を選択して下さい。");
        return false;
    }else{
        if ( chk_cnt > send_limit) {
             alert("本日のスカウト送信数をオーバーしています。選択数を減らしてください。");
             return false;
        }
    }
}

function sendScout(e)
{
    var str = "checkrs[]";
    var send_limit = document.getElementById('sendlimit').value;
    var chk_cnt = 0;
    var chk = document.getElementsByName(str);
    for (i = 0; i < chk.length; i++) {
        if (chk[i].checked == true) {
            chk_cnt++;
        }
    }
    if ( chk_cnt <= send_limit ) {
        var scout_action = baseUrl + "owner/scout/saveCheck";

        $('#sendScout').ajaxSubmit({
            url: scout_action,
            dataType:'json',
            success: function(responseText, statusText, xhr, $form){
            }
        });
    }
    else {
        document.getElementById(e.id).checked = false;
        alert("選択されたスカウトメール数は本日送信可能数を超えました。再選択ください。");
    }
}

function checkInterview()
{
    var flag = false;
    $.each($("input[name='ckUser[]']:checked"), function() {
        flag = true;
    });

    if (!flag)
    {
        alert('チェックボックスが選択されておりません。対象を選択して下さい。');
    }
    else
    {
        $('#userApply').submit();
    }
}
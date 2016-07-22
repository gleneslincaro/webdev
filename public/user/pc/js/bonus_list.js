
/*
 * bonus_list javascript
 *
 */
function more_bonus_application_history() {
    var limit = $('#bah_limit').val();
    $.ajax({
        url: "/user/bonus/bonus_application_history",
        type:"post",
        data: { more_bah: true, limit: limit},
        async:true,
        success: function(result) {
            var html = '';
            for (var i=0; i < result.data.length; i++) {
                html = html+'<tr>';
                if (result.data[i]['bonus_requested_date'] != null && result.data[i]['bonus_requested_date'] != '')
                    html = html+'<th>'+result.data[i]['bonus_requested_date']+'</th>';
                else
                    html = html+'<th>-----</th>';
                if (result.data[i]['bonus_money'] != null && result.data[i]['bonus_money'] != '')
                    html = html+'<td>'+Number(result.data[i]['bonus_money']).toLocaleString('en')+'円</td>';
                else
                    html = html+'<td>0円</td>';
                html = html+'</tr>';
            }
            $('#bonus_application_history').html(html);
            if (result.limit > result.total_smb) {
                document.getElementById("logout_text1").remove();
            } else
                $('#bah_limit').val(result.limit);
        }
    })
}

/*------------------------------------------*/
// common modal settings
/*------------------------------------------*/
var modal_setting = {
    autoOpen: false,
    modal: true,
    width: 'auto',
    height: 'auto',
    dialogClass: 'no-close',
    show: {
        effect: 'fade',
        duration: 200
    },
    hide: {
        effect: 'fade',
        duration: 100
    }
}
/*------------------------------------------*/
// click modal overlay
/*------------------------------------------*/
$(function(){
    $(document).on('click', '.ui-widget-overlay', function(){
        $('.ui-dialog-content').dialog('close');
    });
});

$(function(){
    /*------------------------------------------*/
    // confirm dialog
    /*------------------------------------------*/
    $('#submit_paying_out').on('click', function(e){
        e.preventDefault();
        if($(this).prop('disabled') == true || $(this).hasClass('disabled') == true){
            return;
        }
        var modal_conf = $('<div>').dialog(modal_setting);
        var bonus_money = $("#bonus_money").val();
        if (bonus_money < 2000) {
            modal_conf.dialog('option', {
                title: 'ボーナス申請できる金額は2,000円以上です。',
                buttons: [
                    {
                        text: 'OK',
                        class: 'btn-t_green',
                        click: function(){
                            $(this).dialog('close');
                        }
                    }
                ]
            });
        } else {
            modal_conf.dialog('option', {
                title: '申請を行なってもよろしいでしょうか？',
                buttons: [
                    {
                        text: 'いいえ',
                        class: 'btn-gray',
                        click: function(){
                            $(this).dialog('close');
                        }
                    },
                    {
                        text: 'はい',
                        class: 'btn-t_green',
                        click: function(){
                            $(this).dialog('close');
                            /* update data */
                            var modal_res = $('<div>').dialog(modal_setting);
                            $.ajax({
                                url: "/user/bonus/requestBonus",
                                type:"post",
                                data: {},
                                async:true,
                                success: function(result) {
                                    if (result) {
                                        // success
                                        modal_res.dialog('option', {
                                            title: '申請完了しました',
                                            buttons: [
                                                {
                                                    text: 'OK',
                                                    class: 'btn-t_green',
                                                    click: function(){
                                                        $(this).dialog('close');
                                                        location.reload();
                                                    }
                                                }
                                            ]
                                        });
                                    }
                                }
                            });
                            modal_res.html('').dialog('open');
                        }
                    }
                ]
            });
        }
        modal_conf.dialog('open');
    });
});




/*
 * bonus_list javascript
 *
 */
function more_bonus_application_history() {
    var limit = $('#bah_limit').val();
    $.ajax({
        url:base_url + "user/bonus/bonus_application_history",
        type:"post",
        data: { more_bah: true, limit: limit},
        async:true,
        success: function(result) {
            var html = '';
            for (var i=0; i < result.data.length; i++) {
                html = html+'<tr>';
                if (result.data[i]['bonus_requested_date'] != null && result.data[i]['bonus_requested_date'] != '')
                    html = html+'<td>'+result.data[i]['bonus_requested_date']+'</td>';
                else
                    html = html+'<td>-----</td>';
                if (result.data[i]['bonus_money'] != null && result.data[i]['bonus_money'] != '')
                    html = html+'<td>'+result.data[i]['bonus_money']+'円</td>';
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

function requestBonus(message) {    
    $url = base_url + "user/bonus/requestBonus";
    $form = document.getElementById('frmRequestBonus');
    $bonus_money = $("#bonus_money").val();
    if ($bonus_money < 2000) {
        alert("ボーナス申請できる金額は2,000円以上です。");
        return false;
    }
    if (confirm(message) == false) {
        return false;
    }
    if ($form){
        $form.action = $url;
        $form.submit();
    }
}

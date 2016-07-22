<script type="text/javascript">
$(function() {
    $(".approval").click(function(){
        var update_status = $(this).data('updatestatus');
        var confirm_flag = false;
        if ( update_status == 3 ) {
            confirm_flag = confirm("このユーザーのステップアップキャンペーンのボーナス申請を不承認してもよろしいでしょうか？");
        } else if ( update_status == 2 ) {
            confirm_flag = confirm("このユーザーのステップアップキャンペーンのボーナス申請を承認してもよろしいでしょうか？");
        }
        if (confirm_flag == false){
            return false;
        }
        var req_id  = $(this).data('reqid');
        var user_id = $(this).data('userid');
        var total = $(this).data('total');
        $.ajax({
            type:"POST",
            url:"<?php echo base_url(); ?>admin/campaign/approveMakiaRequest",
            data:{ reqid: req_id, updatestatus: update_status, userid: user_id, total: total},
            dataType: 'json',
            success: function(data){
                if(data.overbudgetMaxUser == false){
                    $("#approval_status_" + user_id).parent('tr').removeClass('wait-for-approval-req');
                    if (data.approve_flag == true) {
                        if ( data.update_status == 2 ) {
                            $("#approval_status_" + user_id).html("承認済み");
                            alert("承認が完了しました。");
                        } else if (data.update_status == 3 ) {
                            $("#approval_status_" + user_id).html("不承認済み");
                            alert("不承認が完了しました。");
                        }
                    }else{
                        alert("不承認が失敗しました。");
                    }
                }else{
                    alert("予算と最大人数が超えていますので、承認できません。");
                }
            }
        });
    });
});
</script>
<div class="expense-request-list" >
<table id="tblList">
    <tr>
        <th style="padding: 15px;">ID</th>
        <th style="padding: 15px;">ユーザーシステムID</th>
        <th style="padding: 15px;">キャンペーンID</th>
        <th style="padding: 15px;">５ステップの合計金額</th>
        <th style="padding: 15px;">面接回数</th>
        <th style="padding: 15px;">総申請金額</th>
        <th style="padding: 15px; width:115px; ">申請日</th>
        <th style="padding: 15px;">承認・不承認</th>
    </tr>
    <?php foreach ($data as $key): ?>
    <tr <?php echo ($key['request_money_flag'] == 1 ?'class="wait-for-approval-req"' : '') ?>>
        <td><?php echo $key['user_id']; ?></td>
        <td><?php echo $key['unique_id']; ?></td>
        <td><?php echo $key['step_up_campaign_id']; ?></td>
        <td><?php echo $key['money']; ?></td>
        <td><?php echo $key['no_of_interviews']; ?></td>
        <td><?php echo $key['total_money']; ?></td>
        <td><?php echo $key['request_money_date']; ?></td>
        <?php if ($key['request_money_flag'] == 1 ) :?>
        <td style="text-align: center;" id="approval_status_<?php echo $key['user_id']; ?>">
            <button class="approval" data-total="<?php echo $key['total_money']; ?>" data-reqid="<?php echo $key['step_up_campaign_id']; ?>" data-userid="<?php echo $key['user_id']; ?>" data-updatestatus="2">承認する</button>
            <button class="approval" data-total="<?php echo $key['total_money']; ?>" data-reqid="<?php echo $key['step_up_campaign_id']; ?>" data-userid="<?php echo $key['user_id']; ?>" data-updatestatus="3">不承認する</button>
        </td>
        <?php else:?>
        <?php if ($key['request_money_flag'] == 2 ) :?>
            <td style="text-align: center;">承認済み</td>
         <?php else:?>
            <td style="text-align: center;">不承認済み</td>
        <?php endif;?>
        <?php endif;?>
    </tr>
    <?php endforeach; ?>
</table>
</div>

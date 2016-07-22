<script type="text/javascript">
$(function() {
    $(".approval").click(function(){
        var update_status = $(this).data('updatestatus');
        var confirm_flag = false;
        if ( update_status == 4 ) {
            confirm_flag = confirm("このユーザーの体験入店お祝い金額申請を不承認してもよろしいでしょうか？");
        } else if ( update_status == 3 ) {
            confirm_flag = confirm("このユーザーの体験入店お祝い金額申請を承認してもよろしいでしょうか？");
        }
        if (confirm_flag == false){
            return false;
        }
        var req_id  = $(this).data('reqid');
        var user_id = $(this).data('userid');
        $.ajax({
            type:"POST",
            url:"<?php echo base_url(); ?>admin/campaign/approveBonusRequest",
            data:{ reqid: req_id, updatestatus: update_status, userid: user_id},
            dataType: 'json',
            success: function(data){
                if (data == true) {
                    if ( update_status == 3 ) {
                        $("#approval_status_" + req_id).html("承認済み");
                        alert("承認が完了しました。");
                    } else if (update_status == 4 ) {
                        $("#approval_status_" + req_id).html("不承認済み");
                        alert("不承認が完了しました。");
                    }
                }else{
                    alert("不承認が失敗しました。");
                }
            }
        });
    });
});
</script>

<center>
<div class="expense-request-list" >
<p>体験入店お祝い金額申請一覧</p>
  <div>
    <div class="request-filter-form">
      <form method="GET" action="<?php echo base_url(); ?>admin/campaign/bonusRequestStatus">
        <label>承認状態</label>
        <select name="filter_status" class="filter-select">
          <option value="">選択してください</option>
          <option value="1">承認待ち</option>
          <option value="3">承認済み</option>
          <option value="4">不承認済み</option>
          <option value="2">店舗不承認</option>
        </select>
        <input type="submit" value="絞り込む" />
      </form>
    </div>
    <?php if(isset($expense_pay_requests)) { ?>
    <table>
      <tbody>
        <tr>
          <th class="col-id">リクエストID</th>
          <th class="col-property">会員属性</th>
          <th class="col-id">会員ID</th>
          <th class="col-user-name">名前</th>
          <th class="col-id">店舗ID</th>
          <th class="col-owner-name">店舗名</th>
          <th class="col-owner-approve">店舗承認</th>
          <!-- <th class="col-id">申請回数</th> -->
          <th class="col-req-date">申請日付</th>
          <th class="col-req-approve">承認</th>
        </tr>
        <?php foreach ($expense_pay_requests as $request) {
            switch( $request['req_status'] ) {
                case 0: // 申請中
                $o_approval_status_str = "承認待ち";
                $a_approval_status_str = "店舗承認待ち";
                break;

                case 1: // 店舗承認済み
                $o_approval_status_str = "承認済み";

                //承認ボタン
                $a_approval_status_str = '<button class="approval" ';
                $a_approval_status_str .= 'data-reqid="' . $request['req_id'] . '" ';
                $a_approval_status_str .= 'data-userid="' . $request['user_id'] . '" ';
                $a_approval_status_str .= 'data-updatestatus="3">承認する</button>';
                //不承認ボタン
                $a_approval_status_str .= '<button class="approval" ';
                $a_approval_status_str .= 'data-reqid="' . $request['req_id'] . '" ';
                $a_approval_status_str .= 'data-userid="' . $request['user_id'] . '" ';
                $a_approval_status_str .= 'data-updatestatus="4">不承認する</button>';
                break;

                case 2: // 店舗不承認済み
                $o_approval_status_str = "不承認済み";
                $a_approval_status_str = "店舗不承認";
                break;

                case 3: // 店舗、管理者承認済み
                $o_approval_status_str = "承認済み";
                $a_approval_status_str = "承認済み";
                break;

                case 4: // 店舗諸運済み、管理者不承認済み
                $o_approval_status_str = "承認済み";
                $a_approval_status_str = "不承認済み";
                break;

                default:
                $o_approval_status_str = "エラー";
                $a_approval_status_str = "エラー";
                break;
            }

            switch($request['u_from_site']) {
                case 0:
                  $from_site = "JOYSPE内";
                  break;
                case 1:
                  $from_site = "マシェモバ";
                  break;
                case 2:
                  $from_site = "マキア";
                  break;
                default:
                  $from_site = "不明";
            }
            ?>
          <?php if ( $request['req_status'] == 0 || $request['req_status'] == 1 ) { /* 承認待ちのリクエスト */?>
          <tr class="wait-for-approval-req">
          <?php } else { ?>
          <tr>
          <?php } ?>
            <td><?php echo $request['req_id']; ?></td>
            <td><?php echo $from_site; ?></td>
            <td><?php echo $request['u_unique_id']; ?></td>
            <td><?php echo $request['u_name']; ?></td>
            <td><?php echo $request['o_unique_id']; ?></td>
            <td><?php echo $request['o_shop_name']; ?></td>
            <td><?php echo $o_approval_status_str; ?></td>
            <td><?php echo $request['req_date']; ?></td>
            <td style="text-align: center;" id="approval_status_<?php echo $request['req_id']; ?>">
                <?php echo $a_approval_status_str; ?>
            </td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
    <?php } else { ?>
    <center>申請リクエストがありません。</center>
    <?php } ?>
  </div>
  <br>
  <div><?php echo $this->pagination->create_links() ?></div>
</div>
</center>

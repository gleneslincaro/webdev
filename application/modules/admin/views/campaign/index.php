<script type="text/javascript">
$(function() {

      $('.ow_approval').click(function() {
        var _this = this;
        var approval_val = $(this).data('approval_val');
        var confirm_flag = false;
        if ( approval_val == 1 ) {
            confirm_flag = confirm("交通費申請を店舗様の代わりに承認します。");
        } else if ( approval_val == 2 ) {
            confirm_flag = confirm("交通費申請を店舗様の代わりに不承認します。");
        }
        if (confirm_flag == false){
            return false;
        }

        var req_id = $(this).data('reqid');
        var user_id = $(this).data('userid');
        $.post('<?php echo base_url();?>owner/index/responseToUserExpenseRequest', {id: req_id, approval_val: approval_val}, function(data){
         if(data == true || data == 'true') {
            if (approval_val == 1 ) {
              alert("代理承認が完了しました。");
              $("#shop_approval_status_"+req_id).html("承認済み");
               //承認ボタン
              var a_approval_status_str = '<button class="approval" ';
                  a_approval_status_str += 'data-reqid="'+req_id+'" ';
                  a_approval_status_str += 'data-userid="'+user_id+'" ';
                  a_approval_status_str += 'data-ownerid="'+owner_id+'" ';
                  a_approval_status_str += 'data-updatestatus="3">承認する</button>';
              //不承認ボタン
                  a_approval_status_str += '<button class="approval" ';
                  a_approval_status_str += 'data-reqid="'+req_id+'" ';
                  a_approval_status_str += 'data-userid="'+user_id+'" ';
                  a_approval_status_str += 'data-ownerid="'+owner_id+'" ';
                  a_approval_status_str += 'data-updatestatus="4">不承認する</button>';
              $("#approval_status_" + req_id).html(a_approval_status_str);
            } else {
              alert("代理不承認が完了しました。");
              $("#shop_approval_status_"+req_id).html("不承認済み");
              $("#approval_status_" + req_id).html("店舗不承認");
            }

            $(_this).parent('td').empty().html("---");

          } else {
            alert("エラーが発生します。");
          }
        });

      });

      $(document).on('click', '.approval', function(){
        var update_status = $(this).data('updatestatus');
        var confirm_flag = false;
        if ( update_status == 4 ) {
            confirm_flag = confirm("このユーザーの交通費申請を不承認してもよろしいでしょうか？");
        } else if ( update_status == 3 ) {
            confirm_flag = confirm("このユーザーの交通費申請を承認してもよろしいでしょうか？");
        }
        if (confirm_flag == false){
            return false;
        }
        var req_id  = $(this).data('reqid');
        var user_id = $(this).data('userid');
        var ownerid = $(this).data('ownerid');
        $.ajax({
            type:"POST",
            url:"<?php echo base_url(); ?>admin/campaign/approveExpenseRequest",
            data:{ reqid: req_id, updatestatus: update_status, userid: user_id, owner_id: ownerid},
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
<p>交通費申請一覧</p>
  <div>
    <div class="request-filter-form">
      <form method="GET" action="<?php echo base_url(); ?>admin/campaign/index">
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
          <th class="col-admin-approve">店舗承認・不承認</th>
          <th class="col-req-approve">承認</th>
        </tr>
        <?php foreach ($expense_pay_requests as $request) {
            switch( $request['req_status'] ) {
                case 0: // 申請中
                $o_approval_status_str = "承認待ち";
                $a_approval_status_str = "店舗承認待ち";

                //店舗様の代わりに承認
                $a_approval_ow_status_str = '<button class="ow_approval" ';
                $a_approval_ow_status_str .= 'data-reqid="' . $request['req_id'] . '" ';
                $a_approval_ow_status_str .= 'data-userid="' . $request['user_id'] . '" ';
                $a_approval_ow_status_str .= 'data-ownerid="' . $request['owner_id'] . '" ';
                $a_approval_ow_status_str .= 'data-approval_val="1">承認</button>';
                //店舗様の代わりに不承認ボタン
                $a_approval_ow_status_str .= '<button class="ow_approval" ';
                $a_approval_ow_status_str .= 'data-reqid="' . $request['req_id'] . '" ';
                $a_approval_ow_status_str .= 'data-userid="' . $request['user_id'] . '" ';
                $a_approval_ow_status_str .= 'data-ownerid="' . $request['owner_id'] . '" ';
                $a_approval_ow_status_str .= 'data-approval_val="2">不承認</button>';
                break;

                case 1: // 店舗承認済み
                $a_approval_ow_status_str = "---";
                $o_approval_status_str = "承認済み";

                //承認ボタン
                $a_approval_status_str = '<button class="approval" ';
                $a_approval_status_str .= 'data-reqid="' . $request['req_id'] . '" ';
                $a_approval_status_str .= 'data-userid="' . $request['user_id'] . '" ';
                $a_approval_status_str .= 'data-ownerid="' . $request['owner_id'] . '" ';
                $a_approval_status_str .= 'data-updatestatus="3">承認する</button>';
                //不承認ボタン
                $a_approval_status_str .= '<button class="approval" ';
                $a_approval_status_str .= 'data-reqid="' . $request['req_id'] . '" ';
                $a_approval_status_str .= 'data-userid="' . $request['user_id'] . '" ';
                $a_approval_status_str .= 'data-ownerid="' . $request['owner_id'] . '" ';
                $a_approval_status_str .= 'data-updatestatus="4">不承認する</button>';
                break;

                case 2: // 店舗不承認済み
                $a_approval_ow_status_str = "---";
                $o_approval_status_str = "不承認済み";
                $a_approval_status_str = "店舗不承認";
                break;

                case 3: // 店舗、管理者承認済み
                $a_approval_ow_status_str = "---";
                $o_approval_status_str = "承認済み";
                $a_approval_status_str = "承認済み";
                break;

                case 4: // 店舗諸運済み、管理者不承認済み
                $a_approval_ow_status_str = "---";
                $o_approval_status_str = "承認済み";
                $a_approval_status_str = "不承認済み";
                break;

                default:
                $a_approval_ow_status_str = "エラー";
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
            <td id="shop_approval_status_<?php echo $request['req_id']; ?>"><?php echo $o_approval_status_str; ?></td>
            <td><?php echo $request['req_date']; ?></td>
            <td>
                <?php echo $a_approval_ow_status_str; ?>
            </td>
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
  <div><?php echo $this->pagination->create_links() ?></div>
</div>
</center>

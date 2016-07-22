<script type="text/javascript">
$(function() {
  $(".campaign-close").click(function(){
    var confirm_flag = false;
    confirm_flag = confirm("このキャンペーンを終了してもよろしいでしょうか？");

    if (confirm_flag == false){
      return false;
    }
    var campaign_id  = $(this).data('campaign-id');
    $.ajax({
      type:"POST",
      url:"<?php echo base_url(); ?>admin/campaign/stopmstCampaign",
      data:{ campaign_id: campaign_id },
      dataType: 'json',
      success: function(data){
        if (data == true) {
          $("#campaign_status_" + campaign_id).html("終了");
          alert("このキャンペーンを終了しました。");
        }else{
          alert("このキャンペーン終了が失敗しました。");
        }
      }
    });
  });
});
</script>

<center>
<div class="expense-request-list" >
<p>体験入店お祝いキャンペーン</p>
<p><a href="<?php echo base_url(); ?>admin/campaign/bonusrequestcreate">キャンペーン作成はこちら</a></p>
  <div>
    <?php if(isset($campaigns)) { ?>
    <table>
      <tbody>
        <tr>
          <th class="col-id">キャンペーンID</th>
          <th class="col-property">ボーナス金額</th>
          <th class="col-user-name">上限額（予算）</th>
          <th class="col-req-date">開始日</th>
          <th class="col-req-date">終了日</th>
          <th class="col-owner-approve">上限回数<br>(一人当たり)</th>
          <th class="col-id">複数回で同店舗に申請可能か</th>
          <th class="col-req-date">状態</th>
        </tr>
        <?php foreach ($campaigns as $campaign) {
            if($campaign['display_flag']) {
              $active_str  = '<div id="campaign_status_'. $campaign["id"] . '">';
              $active_str .= '実施中&nbsp;<button class="campaign-close" data-campaign-id="';
              $active_str .= $campaign["id"] . '">終了する</button></div>';
            } else {
              $active_str = "終了";
            }
            ?>
          <?php if ( $campaign['display_flag'] == 1 ) { /* 実施中 */?>
          <tr class="wait-for-approval-req">
          <?php } else { ?>
          <tr>
          <?php } ?>
            <td><?php echo $campaign['id']; ?></td>
            <td><?php echo $campaign['bonus_money']; ?></td>
            <td><?php echo $campaign['budget_money']; ?></td>
            <td><?php echo $campaign['start_date']; ?></td>
            <td><?php echo $campaign['end_date']; ?></td>
            <td><?php echo $campaign['max_request_times']; ?></td>
            <td><?php echo $campaign['multi_request_per_owner_flag']; ?></td>
            <td><?php echo $active_str; ?></td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
    <?php } else { ?>
    <center>キャンペーンがありません。</center>
    <?php } ?>
  </div>
  <div><?php echo $this->pagination->create_links() ?></div>
</div>
</center>

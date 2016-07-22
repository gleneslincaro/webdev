<script type="text/javascript">
$(function() {
  var new_campaign_flag = <?php echo (isset($new_campaign_flag) ? $new_campaign_flag: '3'); ?>;
  campaign_flag(new_campaign_flag);
  $('#selectList').change(function(){
    $('#frmCampaignFlag').submit();
  });
  $(".campaign-close").click(function(){
    var confirm_flag = false;
    confirm_flag = confirm("このキャンペーンを終了してもよろしいでしょうか？");
    if (confirm_flag == false){
      return false;
    }
    var campaign_id  = $(this).data('campaign-id');
    $.ajax({
      type:"POST",
      url:"<?php echo base_url(); ?>admin/campaign/makiastopCampaign",
      data:{ campaign_id: campaign_id },
      dataType: 'json',
      success: function(data){
        if (data == true) {
          $("#campaign_status_" + campaign_id).html("終了");
          $("#campaign_status_" + campaign_id).parent('td').parent('tr').removeClass('wait-for-approval-req');
          alert("このキャンペーンを終了しました。");
        }else{
          alert("このキャンペーン終了が失敗しました。");
        }
      }
    });
  });
  function campaign_flag(flag){
    $('.setupcampaigncreate').show();
    if(flag == 1){
      $('.new').show();
      $('.exist').hide();
    }else if(flag == 0){
      $('.new').hide();
      $('.exist').show();
    }else{
      $('.setupcampaigncreate').hide();
    }
  }
});
</script>

<center>
<div class="expense-request-list" >
<p><a href="<?php echo base_url(); ?>admin/campaign/makiacampaigncreate">キャンペーン作成はこちら</a></p>
  <div>
  <form id="frmCampaignFlag" method="post">
    <p>キャンペーン種類を選択する</p>
    <p><select name="flag" id="selectList">
      <option value="3" <?php echo (isset($flag) && $flag == 3 ? 'selected': ''); ?>></option>
      <option value="1" <?php echo (isset($flag) && $flag == 1 ? 'selected': ''); ?>>新規</option>
      <option value="0" <?php echo (isset($flag) && $flag == 0 ? 'selected': ''); ?>>既存</option>
    </select>
    </p>
  </form>
    <?php if(isset($campaigns)) { ?>
    <table id="tblList">
        <tr>
          <th width="108">キャンペーンID</th>
          <th width="108">キャンペーン名</th>
          <th width="108">予算</th>
          <th width="108">上限人数</th>
          <?php if (!isset($flag)):?>
          <th width="108">期日1</th>
          <th class="col-req-date">開始日</th>
          <th class="col-req-date">終了日</th>
          <?php elseif ($flag == 1):?>
          <th width="108">期日1</th>
          <?php else:?>
          <th class="col-req-date">開始日</th>
          <th class="col-req-date">終了日</th>
          <?php endif; ?>
          <th width="108">期日2</th>
          <th width="108">キャンペーン2補足文</th>
          <th width="108">スカウトメールボーナス</th>
          <th width="108">お問い合わせボーナス</th>
          <th width="108">累計ログインボーナス</th>
          <th width="108">ページアクセスボーナス</th>
          <th width="108">面接ボーナス</th>
          <th width="108">複数店舗へ面接</th>
          <th width="108">編集</th>
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
            <td><?php echo $campaign['name']; ?></td>
            <td><?php echo $campaign['budget_money']; ?></td>
            <td><?php echo $campaign['max_user_no']; ?></td>
            <?php if (!isset($flag)):?>
            <td><?php echo $campaign['campaign1_valid_days']; ?></td>
            <td><?php echo $campaign['campaign2_start_date']; ?></td>
            <td><?php echo $campaign['campaign2_end_date']; ?></td>
            <?php elseif ($flag == 1):?>
            <td><?php echo $campaign['campaign1_valid_days']; ?></td>
            <?php else:?>
            <td><?php echo $campaign['campaign2_start_date']; ?></td>
            <td><?php echo $campaign['campaign2_end_date']; ?></td>
            <?php endif; ?>
            <td><?php echo $campaign['campaign_retry_days']; ?></td>
            <td><?php echo $campaign['more_info']; ?></td>
            <td><?php echo $campaign['scout_bonus_mag_times']; ?></td>
            <td><?php echo $campaign['msg_bonus_mag_times']; ?></td>
            <td><?php echo $campaign['login_bonus_mag_times']; ?></td>
            <td><?php echo $campaign['page_access_bonus_mag_times']; ?></td>
            <td><?php echo $campaign['interview_bonus_mag_times']; ?></td>
            <td><?php echo $campaign['max_interview_bonus_times']; ?></td>
            <td><?php if ( $campaign['display_flag'] == 1 ) : ?><a href="<?php echo base_url(); ?>admin/campaign/makiacampaigncreate/<?php echo $campaign['id']; ?>">編集</a><?php endif; ?></td>
            <td><?php echo $active_str; ?></td>
          </tr>
        <?php } ?>
    </table>
    <?php } else { ?>
    <center>キャンペーンがありません。</center>
    <?php } ?>
  </div>
  <div><?php echo $this->pagination->create_links() ?></div>
</div>
</center>

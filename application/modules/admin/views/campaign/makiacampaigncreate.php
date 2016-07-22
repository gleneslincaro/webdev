<script type="text/javascript">
  $(document).ready(function(){
    var new_campaign_flag = <?php echo (isset($new_campaign_flag) ? $new_campaign_flag: '3'); ?>;
    campaign_flag(new_campaign_flag);
    $("#start_date").datepicker({ dateFormat: "yy/mm/dd" });
    $("#end_date").datepicker({ dateFormat: "yy/mm/dd" });

    $("#start_date").change(function(){
      var start_date = $("#start_date").val();
      var end_date = $("#end_date").val();

      if( start_date!="" && !start_date.match(/^(19|20)\d\d\/(0\d|1[012])\/(0\d|1\d|2\d|3[01])$/)){
        alert("日付が正しくありません。再入力してください。");
        $('#start_date').val("");
      }
      else if( end_date != null ){
        if (Date.parse(start_date) > Date.parse(end_date)) {
          alert("日付範囲は無効です。終了日は開始日より後になります。")
          $("#start_date").val("");
          return false;
        }
      }
    });

    $("#end_date").change(function(){
      var start_date = $("#start_date").val();
      var end_date = $("#end_date").val();

      if( end_date != "" && !end_date.match(/^(19|20)\d\d\/(0\d|1[012])\/(0\d|1\d|2\d|3[01])$/)){
        alert("日付が正しくありません。再入力してください。");
        $('#end_date').val("");
      }
      else if( start_date != null ){
        if ( Date.parse(start_date) > Date.parse(end_date) ) {
          alert("日付範囲は無効です。終了日は開始日より後になります。")
          $("#start_date").val("");
          return false;
        }
      }
    });
    $('#selectList').change(function(){
      var flag = $(this).val();
      campaign_flag(flag);
    });
    $("#create_banner").click(function(){
      if ( !confirm("この設定でキャンペーンを作成してもよろしいでしょうか？") ) {
        return false;
      }
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

<form action="<?php echo (isset($editId)?  base_url() . 'admin/campaign/makiacampaigncreate/' . $editId :''); ?>" method="post">
  <div class="expense-request-list">
    <p><a href="<?php echo base_url(); ?>admin/campaign/makiacampaignall">キャンペーン一覧はこちら</a></p>
    <?php if ($edit == false) :?>
    <p>キャンペーン種類を選択する</p>
    <p><select name="new_campaign_flag" id="selectList">
      <option value="3" <?php echo (isset($new_campaign_flag) && $new_campaign_flag == 3 ? 'selected': ''); ?>></option>
      <option value="1" <?php echo (isset($new_campaign_flag) && $new_campaign_flag == 1 ? 'selected': ''); ?>>新規</option>
      <option value="0" <?php echo (isset($new_campaign_flag) && $new_campaign_flag == 0 ? 'selected': ''); ?>>既存</option>
    </select>
    </p>
    <?php endif; ?>
    <p style="color: blue;"><?php echo $this->session->flashdata('create_message'); ?></p>
    <div class="validation"><?php echo validation_errors(); ?></div>
    <table class="setupcampaigncreate" style="width:100%">
      <tr>
        <td>キャンペーン名：</td>
        <td><input type="text" name="name" value="<?php echo set_value("name"); echo isset($mcampaign)? $mcampaign[0]['name'] : ''; ?>"></td>
      </tr> 
      <tr>
        <td>予算：</td>
        <td><input type="text" name="budget_money" value="<?php echo set_value("budget_money"); echo isset($mcampaign)? $mcampaign[0]['budget_money'] : ''; ?>"> 円</td>
      </tr>
      <tr>
        <td>上限人数：</td>
        <td><input type="text" name="max_user_no" value="<?php echo set_value("max_user_no"); echo isset($mcampaign)? $mcampaign[0]['max_user_no'] : ''; ?>"> 人 <span style="float:right;">非表示: <input type="checkbox" name="max_user_display_flg" <?php echo ($max_user_display_flg == 1 ? 'checked':""); ?>></span></td>
      </tr>
       <tr class="new">
        <td>期日1:</td>
        <td><input type="text" id="campaign1_valid_days" name="campaign1_valid_days" value="<?php echo set_value("campaign1_valid_days"); echo isset($mcampaign) ? $mcampaign[0]['campaign1_valid_days'] : ''; ?>"></td>
      </tr>
      <tr class="exist">
        <td>期日1:</td>
        <td style="text-align: center;"><input style="float:left;" type="text" id="start_date" name="start_date" value="<?php echo set_value("start_date"); echo isset($mcampaign)? $mcampaign[0]['campaign2_start_date'] : ''; ?>">~<input style="float:right;" type="text" id="end_date" name="end_date" value="<?php echo set_value("end_date"); echo isset($mcampaign)? $mcampaign[0]['campaign2_end_date'] : ''; ?>"></td>
      </tr>
      <tr>
        <td>期日2:</td>
        <td><input type="text" name="campaign_retry_days" value="<?php echo set_value("campaign_retry_days"); echo isset($mcampaign)? $mcampaign[0]['campaign_retry_days'] : ''; ?>"></td>
      </tr>
      <tr>
        <td>キャンペーン2補足文:</td>
        <td><input type="text" name="more_info" value="<?php echo set_value("more_info"); echo isset($mcampaign)? $mcampaign[0]['more_info'] : ''; ?>"></td>
      </tr>
      <tr>
        <td>スカウトメールボーナス:</td>
        <td><input type="text"  name="scout_bonus_mag_times" value="<?php echo set_value("scout_bonus_mag_times"); echo isset($mcampaign)? $mcampaign[0]['scout_bonus_mag_times'] : ''; ?>"> 倍</td>
      </tr>
      <tr>
        <td>お問い合わせボーナス:</td>
        <td><input type="text" name="msg_bonus_mag_times" value="<?php echo set_value("msg_bonus_mag_times"); echo isset($mcampaign)? $mcampaign[0]['msg_bonus_mag_times'] : ''; ?>"> 倍</td>
      </tr>
      <tr>
        <td>累計ログインボーナス:</td>
        <td><input type="text" name="login_bonus_mag_times" value="<?php echo set_value("login_bonus_mag_times"); echo isset($mcampaign)? $mcampaign[0]['login_bonus_mag_times'] : ''; ?>"> 倍</td>
      </tr>
      <tr>
        <td>ページアクセスボーナス:</td>
        <td><input type="text" name="page_access_bonus_mag_times" value="<?php echo set_value("page_access_bonus_mag_times"); echo isset($mcampaign)? $mcampaign[0]['page_access_bonus_mag_times'] : ''; ?>"> 倍</td>
      </tr>
      <tr>
        <td>面接ボーナス:</td>
        <td><input type="text" name="interview_bonus_mag_times" value="<?php echo set_value("interview_bonus_mag_times"); echo isset($mcampaign)? $mcampaign[0]['interview_bonus_mag_times'] : ''; ?>"> 倍</td>
      </tr>
      <tr>
        <td>複数店舗へ面接:</td>
        <td><input type="text" name="max_interview_bonus_times" value="<?php echo set_value("max_interview_bonus_times"); echo isset($mcampaign)? $mcampaign[0]['max_interview_bonus_times'] : ''; ?>"></td>
      </tr>
      <tr>
        <td colspan="2">
          <?php if (isset($editId)) :?>
          <input type="submit" style="width:200px; height:50px;" name="edit" value="編集">
          <?php else: ?>
          <input id="create_banner" type="submit" style="width:200px; height:50px;" value="作成">
          <?php endif; ?>
        </td>
      </tr>
    </table>
  </div>
</form>
</center>

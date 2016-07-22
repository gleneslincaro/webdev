<script type="text/javascript">
$(function() {
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
    });
</script>

<center>
    <div class="expense-request-list" >
    <p>キャンペーン告知</p>
    <p><a href="<?php echo base_url(); ?>admin/campaign/ownercampaingnall">キャンペーン作成はこちら</a></p>
    <div class="validation"><?php echo validation_errors(); ?></div>
    <p style="color: blue;"><?php echo $this->session->flashdata('create_message'); ?></p>
    <form method="post">
        <table>
            <tr>
                <td>キャンペーン名</td>
                <td><input type="text" name="campaign_name" value="<?php echo set_value("campaign_name"); echo (isset($getCampaign)? $getCampaign[0]['campaign_name']: '' )?>"></td>
            </tr>
            <tr>
                <td>期間</td>
                <td><input id="start_date" type="text" name="start_date" value="<?php echo set_value("start_date"); echo (isset($getCampaign)? $getCampaign[0]['period_start']: '' ) ?>"> ~ <input id="end_date" type="text" name="end_date" value="<?php echo set_value("end_date"); echo (isset($getCampaign)? $getCampaign[0]['period_end']: '' )?>"></td>
            </tr>
            <tr>
                <td>リンク</td>
                <td><input type="text" name="link" value="<?php echo set_value("link"); echo (isset($getCampaign)? $getCampaign[0]['link']: '' )?>"></td>
            </tr>
            <tr>
                <td>状態</td>
                <td>
                    <select name="status">
                        <option value="1" <?php echo (isset($getCampaign) && ($getCampaign[0]['status'] == 1)? 'selected': '1' ); ?>>開催中</option>
                        <option value="2" <?php echo (isset($getCampaign) && ($getCampaign[0]['status'] == 2)? 'selected': '2' ); ?>>準備中</option>
                        <option value="3" <?php echo (isset($getCampaign) && ($getCampaign[0]['status'] == 3)? 'selected': '3' ); ?>>終了</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td colspan="2"><input id="create_banner" type="submit" style="width:200px; height:50px;" value="作成"></td>
            </tr>
        </table>
    </form>
    </div>
</center>
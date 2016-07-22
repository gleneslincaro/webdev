<script type="text/javascript">
  $(document).ready(function(){
    var message = "<?php echo $alert; ?>";
    if(message != '') {
      alert(message);
    }

  });
</script>
<div id="scoutMailQtySendPerDay">
  <div align="center"><p>１円ボーナス設定</p></div>
  <form method="post" action="<?php echo base_url().'admin/oneyenbonus/setpoint'; ?>" id="form_scoutPoints">
    <label class="mr30">１日ボーナスアクセス上限</label>
    <input type="text" name="page_limit" id="scoutPoint" value="<?php echo set_value('setpoint', $page_limit); ?>"><br><br>
    <label class="mr30">１回の付与ポイント</label>
    <input type="text" name="page_point" id="scoutPoint" value="<?php echo set_value('setpoint', $page_point); ?>"><br><br>
    <input type="submit" name="setpoint" value="設定">
  </form>
</div>

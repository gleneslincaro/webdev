<script type="text/javascript">
  $(document).ready(function(){      
    var message = "<?php echo $alert; ?>";    
    if(message != '') {
      alert(message);
    }
    
  });
</script>
<div id="scoutMailQtySendPerDay">
  <div align="center"><p>ボーナス金額設定</p></div>
  <form method="post" action="<?php echo base_url().'admin/setting/scoutPoints'; ?>" id="form_scoutPoints">    
    <label class="mr30">スカウトポイント</label>
    <input type="text" name="scoutPoint" id="scoutPoint" value="<?php echo set_value('scoutPoint', $point); ?>">
    <input type="submit" name="btnRegister" value="設定">
  </form>
</div>
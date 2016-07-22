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
  <form method="post" action="<?php echo base_url().'admin/setting/newsPoints'; ?>" id="form_newsPoints">    
    <label class="mr30">メールマガポイント</label>
    <input type="text" name="newsPoint" id="newsPoint" value="<?php echo set_value('newsPoint', $point); ?>">
    <input type="submit" name="btnRegister" value="設定">
  </form>
</div>
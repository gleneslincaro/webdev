<script type="text/javascript">
  $(document).ready(function(){      
    var message = "<?php echo $alert; ?>";    
    if(message != '') {
      alert(message);
    }
    
    var dsmpd = "<?php if(isset($_POST["commonEmailNoPerDay"])){echo $_POST["commonEmailNoPerDay"];}else{ echo $common_email_no_per_day; } ?>";
    var select = document.getElementById("commonEmailNoPerDay");   
    for (var i = 0; i < select.options.length; i++)
    {        
        if (select.options[i].value == dsmpd) {        
          select.options[i].selected = true;
          break;
        }
    }
    
    
  });
</script>
<div id="scoutMailQtySendPerDay">
  <div class="bld mb20">スカウト送信数設定</div>
  <form method="post" action="<?php echo base_url().'admin/setting/scoutMailQtySendPerDay'; ?>" id="form_scoutMailQtySendPerDay">    
    <label class="mr30">1日スカウト送信数</label>
    <select name="commonEmailNoPerDay" id="commonEmailNoPerDay" class="mr30">
      <option value="10">10</option>
      <option value="20">20</option>
      <option value="30">30</option>
      <option value="40">40</option>
      <option value="50">50</option>
      <option value="60">60</option>
      <option value="70">70</option>
      <option value="80">80</option>
      <option value="90">90</option>
      <option value="100">100</option>
      <option value="150">150</option>
      <option value="200">200</option>
      <option value="250">250</option>
      <option value="300">300</option>
      <option value="350">350</option>
      <option value="400">400</option>
      <option value="450">450</option>
      <option value="500">500</option>
      <option value="550">550</option>
      <option value="600">600</option>
      <option value="650">650</option>
      <option value="700">700</option>
      <option value="750">750</option>
      <option value="800">800</option>
      <option value="850">850</option>
      <option value="900">900</option>
      <option value="950">950</option>
      <option value="1000">1000</option>
    </select>               
    <input type="submit" name="btnRegister" value="登録">
  </form>
</div>
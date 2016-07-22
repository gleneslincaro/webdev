<script type="text/javascript">
  $(document).ready(function(){      
    var base = $("#base").attr("value");
  });
</script>
<center>
<p>オーナー情報をCSVからインポートする</p>
<?php if ( isset($error_msg) && $error_msg ) {
  echo "<div style='color:red;'>$error_msg</div>";
}
?>
</center>
<div id="csv">
  <div style="color:#4C57D8;">ファイル名を英語にして、選択してください。</div>
  <br>
  <form method="post" action="<?php echo base_url().'admin/setting/registerOwnerInfoFromCSV'; ?>" enctype="multipart/form-data" id="form_csv">
    <div>
    	<input type="file" name="flUpload" accept-charset="utf-8" id="uploadCsv">
    </div>
    <br>
    <div>
	    <input type="hidden" value="" id="fixName" name="filename">
	    <input type="submit" name="btnCsv" value="インポートする" disabled id="btnCsv">
	</div>
  </form>
</div>

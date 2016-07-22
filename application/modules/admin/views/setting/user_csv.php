<script type="text/javascript">
  $(document).ready(function(){
    var base = $("#base").attr("value");
  });
</script>
<center>
<p>ユーザー情報をCSVファイルからインポートする</p>
<?php if ( isset($error_msg) && $error_msg ) {
  echo "<div style='color:red;'>$error_msg</div>";
}
?>
</center>
<div id="csv" style=" width:100%;height:100%;">
  <form method="post" action="<?php echo base_url().'admin/setting/registerUserFromCSV'; ?>" enctype="multipart/form-data" id="form_csv">
    <table style="text-align:left; margin: 0 auto;">
    <tr align="left">
      <td style="width:70%;border:1px solid #000000;">最後の登録日付</td>
      <td style="border:1px solid #000000;"><?php echo $last_reg_date; ?></td>
    </tr>
    <tr align="left">
      <td style="border:1px solid #000000;">インポート元サイト<span style="color:red">（間違いないように）</span></td>
      <td style="border:1px solid #000000;">
        <select name="import_from">
          <option value="1">マシェモバから</option>}
          <option value="2">アルケシステムから</option>}
        </select>
      </td>
    </tr>
    <tr align="left" >
      <td style="border:1px solid #000000;" colspan="2">
    	  <input type="file" name="flUpload" accept-charset="utf-8" id="uploadCsv">
        <div style="color:#4C57D8;">ファイル名を英語にして、選択してください。</div>
      </td>
    </tr>
    <tr align="left">
      <td style="border:1px solid #000000;" colspan="2">既にデータ存在の場合、更新する？
      <input type="checkbox" name="update_flg"></td>
    </tr>
    <tr align="center">
      <td colspan="2" style="padding-top:40px;">
        <input type="hidden" value="" id="fixName" name="filename">
	      <input type="submit" name="btnCsv" value="インポートする" disabled id="btnCsv">
      </td>
	  </tr>
    </table>
  </form>
</div>

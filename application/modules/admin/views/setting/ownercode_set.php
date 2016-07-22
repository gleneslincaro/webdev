<script language='javascript'>
            $(document).ready(function(){
                checkValidationBeforeInsertOwnerCode();
            })
</script>
<center>
<p>項目・追加</p>
<p>登録サンプルURL　：　http://joyspe.co.jp/?mapc　コードは　/?　以降の英数字（mapc）を登録する</p>
<p>下記項目にコードがない場合は「その他」になる。</p>

<form name="forms" method="post" action="<?php echo base_url(); ?>index.php/admin/setting/checkBeforeInsertOwnerCode">
<p>
広告サイト　：　<input type="text" id="txtNameOC" name="txtNameOC" maxlength="255" value="<?php echo $name ?>">　
コード　：　<input type="text" id="txtCodeOC" name="txtCodeOC" maxlength="255" value="<?php echo $code ?>">
</p>
<?php if($flag == 1){
?>
<input type="hidden" id="txtFlagOC" name="txtFlagOC" value="<?php echo $flag ?>">
<?php } ?>
<p><input type="submit" value="　登録　" ></p>
</form>

</center>

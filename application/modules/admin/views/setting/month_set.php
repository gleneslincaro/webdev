<script language="javascript">
    $(document).ready(function(){
           checkValidationMonth();
           })
</script>

<center>
<p>項目・追加</p>

<form name="forms" method="post" action="<?php echo base_url(); ?>index.php/admin/setting/checkBeforeInsertMonth">
<p>時給目安　：　<input type="text" id="txtAmountMonth" name="txtAmountMonth" value="<?php echo $amount ?>">　万円</p>
<?php if($flag == 1){
?>
<input type="hidden" id="txtFlagMonth" name="txtFlagMonth" value="<?php echo $flag ?>">
<?php } ?>        
<p><input type="submit" value="　登録　" ></p>
</form>
</center>

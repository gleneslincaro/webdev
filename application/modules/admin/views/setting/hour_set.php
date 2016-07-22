<script language="javascript">
    $(document).ready(function(){
           checkValidationHour();
           })
</script>
<center>    
<p>項目・追加</p>

<form id="formHour" name="formHour" method="post" action="<?php echo base_url(); ?>index.php/admin/setting/checkBeforeInsertHour">
<p>時給目安　：　<input type="text" id="txtAmountHour" name="txtAmountHour" value="<?php echo $amount ?>">　円</p>
<?php if($flag == 1){
?>
<input type="hidden" id="txtFlagHour" name="txtFlagHour" value="<?php echo $flag ?>">
<?php } ?>        
<p><input type="submit" value="　登録　" ></p>
</form>

</center>

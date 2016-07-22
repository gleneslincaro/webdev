<script language='javascript'>
            $(document).ready(function(){
                checkValidationTreatment();
            })
</script>
<center>
<p>項目・追加</p>

<form name="forms" method="post" action="<?php echo base_url(); ?>index.php/admin/setting/checkBeforeInsertTreatment">
<p>待遇　：　<input type="text" id="txtNameTreatment" name="txtNameTreatment" size ="50" value="<?php echo $treatment ?>"></p>
<?php if($flag == 1){
?>
<input type="hidden" id="txtFlagTreatment" name="txtFlagTreatment" value="<?php echo $flag ?>">
<?php } ?>        
<p><input type="submit" value="　登録　" ></p>
</form>
</center>

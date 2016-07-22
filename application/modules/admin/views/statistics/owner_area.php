<center>

<p>統計・地域47都道府県</p>
<form name="forms" method="post" action="<?php echo base_url(); ?>index.php/admin/statistics/showOwnerAreaAfter" >
<p>地域
<select name="selectList">
<option value="">選択してください</option>
<?php foreach($cityGroupList as $row) { ?>
<option value="<?php echo $row["id"]; ?>"><?php echo$row["name"]; ?></option>
<?php } ?>
</select>
</p>

<p><BUTTON type="submit">　表示する　</BUTTON></p>
</form>
</center>


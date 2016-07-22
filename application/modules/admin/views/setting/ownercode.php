<script language='javascript'>
            $(document).ready(function(){
                checkValidationBeforeDeleteOwnerCode();
            })
</script>
<script language="javascript">
    $(document).ready(function(){
         var base = $("#base").attr("value");
        $("#btnset3").click(function(){
        window.location=base+"admin/setting/addOwnerCode";
    });
   
    })
    
</script>
<center>

<p>オーナー・コード登録</p>
<p>登録サンプルURL　：　http://joyspe.co.jp/?mapc　コードは　/?　以降の英数字（mapc）を登録する</p>
<p>下記項目にコードがない場合は「その他」になる。</p>

<form name="forms" method="post" action="<?php echo base_url(); ?>index.php/admin/setting/checkBeforeDeleteOwnerCode" >
<div style="margin:0px;padding:0px;" align="center">
<table width="40%" style="border-collapse: collapse;border:1px solid #000000;background-color:#FFFFFF;color:#000000;text-align:left;">
<tbody>
<tr>
<th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">広告サイト&nbsp;</th>
<th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">コード&nbsp;</th>
<th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">削除&nbsp;</th>
</tr>
<?php 
    if($flag == 1){
?>
<input type="hidden" id="txtFlagCheckboxOC" name="txtFlagCheckboxOC" value="<?php echo $flag ?>">
<input type="hidden" id="txtErrorOC" name="txtErrorOC" value="<?php echo $error_message ?>">
<?php 
    }
    if($flag == 2){
?>
<input type="hidden" id="txtFlagCheckboxOC" name="txtFlagCheckboxOC" value="<?php echo $flag ?>">
<input type="hidden" id="txtArrayOC" name="txtArrayOC" value="<?php foreach ($array1 as $key=>$c): echo $key;echo "_";endforeach;?>">
<?php 
    }
?>
<?php
    foreach ($ownerCodeList as $row): 
?>
<tr>
    <td style="border:1px solid #000000;">
        <?php echo $row['name']; ?>&nbsp;
    </td>
    <td style="border:1px solid #000000;">
        <?php echo $row['code']; ?>&nbsp;
    </td>
    <td style="border:1px solid #000000;text-align:center;">
        <input type="checkbox" id="chk[<?php echo $row['id'] ?>]" name="chk[<?php echo $row['id'] ?>]" <?php if($array1 != null){foreach ($array1 as $key=>$c){ if ($row['id']== $key && $flag == 2) {echo "checked = checked";}}} ?> value="<?php echo $row['display_flag'] ?>" >
    </td>
</tr>
<?php endforeach; ?>

</tbody>
</table>
</div>

<p>

<button type="button" id="btnset3">　追加　</button>　　<input type="submit" value="　削除　" >


</p>

</form>
</center>

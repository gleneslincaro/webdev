<script language='javascript'>
            $(document).ready(function(){
             insertAccount();
             deleteAccount();
            })
</script>  
<center>
<p>アカウント管理</p>
<form id="formAcc" name="formAcc" method="post" action="<?php echo base_url(); ?>index.php/admin/setting/checkBeforeInsertAccount">
<div style="margin:0px;padding:0px;" align="center">
<table width="70%" style="border-collapse: collapse;border:1px solid #000000;background-color:#FFFFFF;color:#000000;text-align:left;">
<tbody>
<tr>
<th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">ログインID&nbsp;</th>
<th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">パスワード&nbsp;</th>
<th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">追加&nbsp;</th>
</tr>
<?php if($flag_insert == 1){
?>
<input type="hidden" id="txtFlagInsertAcc" name="txtFlagInsertAcc" value="<?php echo $flag_insert ?>">
<?php } ?>
<tr>
<td style="border:1px solid #000000;"><input type="text" name="txtUsername" id="txtUsername" value="<?php echo $username ?>" size="30"></td>
<td style="border:1px solid #000000;"><input type="password" name="txtPassword" id="txtPassword" value="<?php echo $password  ?>" size="30"></td>
<td style="border:1px solid #000000;text-align:center;"><input type="submit" value="　追加　" ></td>
</tr>
</tbody>
</table>
</div>
</form>

<br>

<div style="margin:0px;padding:0px;" align="center">
<table id="tblAcc" width="70%" style="border-collapse: collapse;border:1px solid #000000;background-color:#FFFFFF;color:#000000;text-align:left;">
<tbody>
<tr>
<th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">ログインID&nbsp;</th>
<th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">パスワード&nbsp;</th>
<th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">変更&nbsp;</th>
<th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">削除&nbsp;</th>
</tr>
<?php
foreach ($accountList as $k=>$i){

    echo '<form action="'.base_url().'admin/setting/updateAcc" method="post" class="formshowpoint" onsubmit="return confirm(\'編集しますか？\');">';
    echo "<input type='hidden' value='".$i["id"]."' name='txtu_id'>";
    echo '<tr>
    <td style="border:1px solid #000000;">
        <input type="text" name="txtUsername1" size="30" value="'.$i['login_id'].'" id="l'.$i["id"].'">
    </td>
    <td style="border:1px solid #000000;"><input type="text" name="txtPass1" size="20" value="'.base64_decode($i['password']).'" id="p'.$i["id"].'"></td>
    <td style="border:1px solid #000000;text-align:center;"><input type="submit" value="変更" name="btnu_update"></td>
    <td style="border:1px solid #000000;text-align:center;"><a class="deleteAcc" href="#" id="'.$i["id"].'"><button type="button">削除</button></a></td>
    </tr>';
    echo '</form>';
}
?>

</tbody>
</table>
</div>

</center>

<script language="javascript">
    $(document).ready(function(){
            checkValidation();
            addText();
            })
</script>
<?php
//$flag=null;
if(isset($_POST["flag"])){$flag=$_POST["flag"];}
echo '<center>

 <form  method="post" action="'.base_url().'index.php/admin/maillan/showJoyspeMailForm?type=';
if(isset($_POST["type"])){echo $_POST["type"];}else {echo $type; }
    echo '">
    <p id="template_name">オーナー　→　joyspe・'.$info["template_name"].'</p>';
if($flag==11){
    echo '<input type="hidden" name="txtFlag" id="txtFlag" size="100" value="'.$flag.'">';
}        
echo '
<input type="hidden" name="type" id="type" size="100" value="'.$type.'">
<div style="margin:0px;padding:0px;" align="center">
<table width="95%" style="border-collapse: collapse;border:1px solid #000000;background-color:#FFFFFF;color:#000000;text-align:left;">
<tbody>
<tr>
<td style="border:1px solid #000000">件名</td>
<td colspan="3">
<input type="text"  maxlength="200" name="txtTitle" id="txtTitle" size="100" value="'.$info["title"].'"></td>
</tr>
<tr>
<td style="border:1px solid #000000;width:120px;"><span id="aspan">本文</span></td>
<td style="border:1px solid #000000;width:420px;">
<textarea name="context"  maxlength="50000" id="context" cols="65" rows="40">'.$info["content"].'
</textarea>
</td>
<td style="border:1px solid #000000;" width="40">';
echo '<input type="button" id="btnReplace" name="btnReplace" value="<="></td>';

echo '<td style="border:1px solid #000000;" width="100">
<select name="sltOptions" id="sltOptions" size="10">
<option value="店舗名">店舗名</option>
<option value="振込金額">振込金額</option>
<option value="振込名義">振込名義</option>
<option value="入金日">入金日</option>
<option value="決済種別">決済種別</option>
<option value="決済金額">決済金額</option>
<option value="決済ポイント">決済ポイント</option>
</select>
</td>

</tr>

<tr>
<td style="border:1px solid #000000;width:50;">配信アドレス&nbsp;</td>
<td colspan="3">
<input type="text" name="txtFromEmail"  maxlength="200" id="txtFromEmail" size="50" value="'.$info["mail_from"].'"></td>
</tr>


</tbody>
</table>


<p><input type="submit" value="　登録　" name="btnUpdateOwnerForm" id="btnUpdateOwnerForm"></p>
</center>
</form>
</div>';

?>

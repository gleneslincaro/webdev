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
    <form  method="post" action="'.base_url().'index.php/admin/maillan/showOwnerMailForm?type=';
if(isset($_POST["type"])){echo $_POST["type"];}else {echo $type; }
    echo '">
    <p id="template_name">オーナー側・'.$info["template_name"].'</p>';
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
<input type="text" name="txtTitle"  maxlength="200" id="txtTitle" size="100" value="'.$info["title"].'"></td>
</tr>
<tr>
<td style="border:1px solid #000000;width:120px;"><span id="aspan">本文</span></td>
<td style="border:1px solid #000000;width:420px;">
<textarea name="context" id="context"  maxlength="50000" cols="60" rows="40">'.$info["content"].'
</textarea>
</td>
<td style="border:1px solid #000000;" width="40">';
echo '<input type="button" id="btnReplace" name="btnReplace" value="<="></td>';

echo '<td style="border:1px solid #000000;" width="100">
<select name="sltOptions" id="sltOptions" size="10">
<option value="店舗名">店舗名</option>
<option value="店舗メールアドレス">店舗メールアドレス</option>
<option value="店舗パスワード">店舗パスワード</option>
<option value="店舗住所">店舗住所</option>
<option value="店舗電話番号">店舗電話番号</option>
<option value="店舗・金融機関名">店舗・金融機関名</option>
<option value="店舗・支店名">店舗・支店名</option>
<option value="店舗・口座種別">店舗・口座種別</option>
<option value="店舗・口座番号">店舗・口座番号</option>
<option value="店舗・口座名義">店舗・口座名義</option>
<option value="決済URL">決済URL</option>
<option value="決済金額">決済金額</option>
<option value="決済ポイント">決済ポイント</option>
<option value="決済日">決済日</option>
<option value="決済種別">決済種別</option>
<option value="決済後のポイント">決済後のポイント</option>
<option value="決済不足金額">決済不足金額</option>
<option value="決済不足ポイント">決済不足ポイント</option>
<option value="決済時の保有ポイント">決済時の保有ポイント</option>
<option value="振込金額">振込金額</option>
<option value="振込名義">振込名義</option>
<option value="入金日">入金日</option>
<option value="お祝い金">お祝い金</option>
<option value="採用金">採用金</option>
<option value="勤務・お祝い金申請時間">勤務・お祝い金申請時間</option>
<option value="ユーザーID">ユーザーID</option>
<option value="ユーザー地域">ユーザー地域</option>
<option value="スカウト人数">スカウト人数</option>
<option value="応募人数">応募人数</option>
<option value="店舗URL">店舗URL</option>
<option value="エリア地域">エリア地域</option>
<option value="エリア都道府県">エリア都道府県</option>
<option value="エリア都市">エリア都市</option>
<option value="業種">業種</option>
<option value="交通">交通</option>
<option value="給与">給与</option>
<option value="年齢">年齢</option>
<option value="身長">身長</option>
<option value="バスト（Ｂ）">バスト（Ｂ）</option>
<option value="ウェスト（Ｗ）">ウェスト（Ｗ）</option>
<option value="ヒップ（Ｈ）">ヒップ（Ｈ）</option>
</select>
</td>

</tr>

<tr>
<td style="border:1px solid #000000;"width="80">配信アドレス&nbsp;</td>
<td colspan="3">
<input type="text" name="txtFromEmail"  maxlength="200" id="txtFromEmail" size="50" value="'.$info["mail_from"].'"></td>
</tr>


</tbody>
</table>


<p><input type="submit" value="　登録　" name="btnUpdateOwnerForm" id="btnUpdateOwnerForm"></p>
</center>
</form>
</div>
<center>';

?>

<script language="javascript">
    $(document).ready(function(){
           addText();
           setCurrentDate();
           userNewMailQueue();
            })
</script>
<?php
            $today = date("Y-m-d-H-i-s");
            $arr2 = explode("-", $today);
if(isset($_POST["flag"])){$flag=$_POST["flag"];}
if($flag==11){
    echo '<input type="hidden" name="txtFlag" id="txtFlag" size="100" value="'.$flag.'">';
    echo '<input type="hidden" name="txtMessage" id="txtMessage" size="100" value="'.$error_message.'">';
}else if($flag==22){

    echo '<input type="hidden" name="txtFlag" id="txtFlag" size="100" value="'.$flag.'">';
}
echo '<form action="'.base_url().'index.php/admin/mail/checkValidateFormUserNew" method="post">';
echo '<input type="hidden" value="'.$array.'" name="arrayEmail" id="arrayEmail"/>';
echo '<input type="hidden" value="0" name="txtType" id="txtType"/>';
echo '<input type ="hidden" value="'.$owner_id.'" name="txtowner" id="txtowner" />';
echo '<center>
<p>ポイント付けメルマガ作成</p>
</center>

<center>
<p>
<input type="text" name="searchStore" id="searchStore" placeholder ="店舗名のキーワードを入力"/>
<button id="btnSearchStore" onclick="storeKeyword();return false;">検索</button>
店舗名一覧:
<select name="owner" id="owner">
<option value="">--店舗名一覧--</option>';
foreach($owners as $store):
echo '<option value="'.$store['id'].'" >'.$store['storename'].'</option>';
endforeach;
echo '</select>

<p>メールアドレスへ強引に送信 <input type="checkbox" id="set_send_mail" name="set_send_mail" '; if(isset($set_send_mail) && $set_send_mail) echo 'checked'; echo '></p>
</p>
<p>件名：&nbsp;<input type="text" maxlength="200" name="txtTitle" id="txtTitle" size="100" value="';
    if(isset($_POST["txtTitle"])){
        echo $_POST["txtTitle"];
    }
echo '" /></p>

</center>

<div style="margin:0px;padding:0px;" align="center">
<table width="95%" style="border-collapse: collapse;border:1px solid #000000;background-color:#FFFFFF;color:#000000;text-align:left;">
<tbody>
<tr>
<td style="border:1px solid #000000;width:120px;"><span id="aspan">送信内容</span></td>
<td style="border:1px solid #000000;width:450px;">
<textarea name="context" id="context" cols="60" rows="40" maxlength="50000">';
if(isset($_POST["context"])){
        echo $_POST["context"];
}else {
echo $content['content'];}
echo '</textarea>
</td>
<td style="border:1px solid #000000;" width="40">';
echo '<input type="button" id="btnReplace" name="btnReplace" value="<="></td>';

echo '<td style="border:1px solid #000000;" width="100">
<select name="sltOptions" id="sltOptions" size="10">
<option value="ユーザーメールアドレス">ユーザーメールアドレス</option>
<option value="ユーザーパスワード">ユーザーパスワード</option>
<option value="ユーザーID">ユーザーID</option>
<option value="ユーザー地域">ユーザー地域</option>
<option value="ユーザー氏名">ユーザー氏名</option>
<option value="トップページURL(メルマガポイント付き)">トップページURL(メルマガポイント付き)</option>
<option value="店舗URL(メルマガポイント付き)">店舗URL(メルマガポイント付き)</option>
<option value="現在の報酬額">現在の報酬額</option>
</select>
</td>

</tr>

<tr>
<td style="border:1px solid #000000;"width="80">配信アドレス&nbsp;</td>
<td colspan="3">
<input type="text" name="txtFromEmail" id="txtFromEmail" size="50" value="';
if(isset($_POST["txtFromEmail"])){
        echo $_POST["txtFromEmail"];
    }else {
        echo 'info@joyspe.com';
    }
echo '"></td>
</tr>


</tbody>
</table>
</div>

<center>
<p><input type="submit" value="送信メール作成"></p>
</center>
</form>';

?>

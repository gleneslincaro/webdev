<script language="javascript">
$(document).ready(function(){
               pagingByAjax();
               $( "#txtLastLoginFrom" ).datepicker({ dateFormat: "yy/mm/dd" });
               $( "#txtLastLoginTo" ).datepicker({ dateFormat: "yy/mm/dd" });              
            })
</script>
<?php
   $EmailAddress=null;
   $StoreName=null;
   $LastLoginFrom=null;
   $LastLoginTo=null;
   $Note=null;
   $arrayEmail= null;
   $status =  null;
   if(isset($_POST["txtEmailAddress"])){$EmailAddress=$_POST["txtEmailAddress"];}
   if(isset($_POST["txtStoreName"])){$StoreName=$_POST["txtStoreName"];}
   if(isset($_POST["txtLastLoginFrom"])){$LastLoginFrom=$_POST["txtLastLoginFrom"];}
   if(isset($_POST["txtLastLoginTo"])){$LastLoginTo=$_POST["txtLastLoginTo"];}
   if(isset($_POST["txtNote"])){$Note=$_POST["txtNote"];}
   if(isset($_POST["sltShopClubs"])){$status=$_POST["sltShopClubs"];}
  // if($countRows!=null){echo $countRows;}
   
    echo ' <center>
<p>メルマガ・会社・店舗検索項目</p>';


echo'<form name="input" action="'.base_url().'index.php/admin/mail/searchSendMailOwner" method="POST">
<table border="0" cellspacing="10">
<tr>
<td ><p>アドレス&nbsp;
<input type="text" name="txtEmailAddress" size="40" id="txtEmailAddress" value="'.$EmailAddress.'" maxlength="200" >';

echo'</p></td>
<td ><p>店舗名&nbsp;
<input type="text" name="txtStoreName" size="40" id="txtStoreName" value="'.$StoreName.'" maxlength="100" ></p></td>
</tr>

</table>

<p>

<tr>
最終ログイン&nbsp;
<input type="text" name="txtLastLoginFrom" class="txtLastLoginFrom" size="40" id="txtLastLoginFrom" value="'.$LastLoginFrom.'" maxlength="50">　〜　<input type="text" name="txtLastLoginTo" size="40" id="txtLastLoginTo" value="'.$LastLoginTo.'" maxlength="50" >
</tr>
<br>

</p>

<p>
<tr>メモ&nbsp;<input type="text" name="txtNote" size="80" id="txtNote" maxlength="200" value="'.$Note.'"></tr>
</p>

<p>

会社・店舗状態　：
<select name="sltShopClubs" id="sltShopClubs">
<option value=""';if($status==null) echo 'selected="selected"'; echo '>選択して下さい</option>
<option value="0"';if($status!=null&&$status==0) echo 'selected="selected"'; echo '>仮登録</option>
<option value="1"';if($status!=null&&$status==1) echo 'selected="selected"'; echo '>ステルス</option>
<option value="2"';if($status!=null&&$status==2) echo 'selected="selected"'; echo '>本登録</option>
<option value="3"';if($status!=null&&$status==3) echo 'selected="selected"'; echo '>ペナルティ</option>
<option value="4"';if($status!=null&&$status==4) echo 'selected="selected"'; echo '>無効</option>
</select>

</p>

<p>※日付・入力形式（YYYY/MM/DD）※項目が空白の場合、全件表示が問題なければ全件表示</p>
<p>※検索後の結果は「配信OK」のみ表示される</p>

<p><input type="submit" name="btnSearchEmail" id="btnSearchEmail" value="   検索   " /></p>';

echo'</form>';
echo'<form name="sendMail" action="'.base_url().'index.php/admin/mail/sendMailOwners" method="POST">';
if(isset($info)){
        echo'<center>';
    echo '<p>合計件数：'.$totalRows.'</p>';
    echo '<input type="submit" name="btnSendEmail" id="btnSendEmail" value="メルマガ作成"'; 
    if($totalRows ==0){
    echo 'disabled="disabled"';    
    }
    echo '/><br><br>';
    echo'<table class ="template1">';
      echo '<tr>
            <th class="email">アドレス</th>
            <th>状態</th>
            <th width="50%">店舗名</th>
        </tr>';
    foreach($info as $k=>$item){    
        echo '<tr>
            <td>'.$item["email_address"].'</td>
            <td>'; if($item["owner_status"]==0){echo '仮登録';}elseif($item["owner_status"]==1){echo 'ステルス';}
                elseif($item["owner_status"]==2){echo '本登録';}elseif($item["owner_status"]==3){echo 'ペナルティ';}elseif($item["owner_status"]==4){echo '無効';}
            echo '</td>
            <td>'.$item["storename"].'</td>
        </tr>';
      } 
        echo'</table>';
        echo '<div id="jquery_link" align="center">';
	echo $this->pagination->create_links();
	echo '</div>';
        echo'</center>';
        
}
if($listEmail!=null){
    foreach($listEmail as $k=>$item){
        if($k==0)$arrayEmail = $item["email_address"];
        else $arrayEmail = $arrayEmail.','.$item["email_address"];
    }
    echo '<input type="hidden" value="'.$arrayEmail.'" name="arrayEmail" />';
}
echo'</center>';
echo '</form>';

?>

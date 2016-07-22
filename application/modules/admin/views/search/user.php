<script language="javascript">
$(document).ready(function(){    
    pagingByAjax_nm();  
    $( "#mn_txtf_dktam" ).datepicker({ dateFormat: "yy/mm/dd" });
    $( "#mn_txtt_dktam" ).datepicker({ dateFormat: "yy/mm/dd" });
    $( "#mn_txtf_dk" ).datepicker({ dateFormat: "yy/mm/dd" });
    $( "#mn_txtt_dk" ).datepicker({ dateFormat: "yy/mm/dd" });
})
</script>
<?php
$status = null;
$mail = null;
 if(isset($_POST["sltstatus"])){$status=$_POST["sltstatus"];}
  if(isset($_POST["sltmail"])){$mail=$_POST["sltmail"];}
echo '<center>

<p>ユーザー検索項目</p>';

echo "<form action='".base_url()."admin/search/searchUser' method='post'>";
echo '<table border="0" cellspacing="10">
<tr>
<td >システムID&nbsp;
<input type="text" name="txtunique_id" size="40" id="mn_txtunique_id" value="';
    if(isset($_POST["txtunique_id"])){
        echo $_POST["txtunique_id"];
    }
echo '" /></td>
<td>氏名　　　&nbsp;
<input type="text" name="txtname" size="40" id="mn_txtname" value="';
  if(isset($_POST["txtname"])){
        echo $_POST["txtname"];
  }
echo '"/></td>
</tr>

<tr>
<td>アドレス　&nbsp;
<input type="text" name="txtEmailAddress" size="40" id="mn_txtEmailAddress" value="';
  if(isset($_POST["txtEmailAddress"])){
        echo $_POST["txtEmailAddress"];
  }
echo '"></td>
<td>振込名義　&nbsp;
<input type="text" name="txtaccountname" size="40" id="mn_txtaccountname" value="';
    if(isset($_POST["txtaccountname"])){
        echo $_POST["txtaccountname"];
  }
echo'"></td>
</tr>

</table>


<p>
<tr>仮登録日&nbsp;<input type="text" name="txtf_dktam" size="30" id="mn_txtf_dktam" value="';
   if(isset($_POST["txtf_dktam"])){
        echo $_POST["txtf_dktam"];
  }
echo'">〜
<input type="text" name="txtt_dktam" size=" 30" id="mn_txtt_dktam" value="';
  if(isset($_POST["txtt_dktam"])){
        echo $_POST["txtt_dktam"];
  }
echo'"></tr><br>

<tr>本登録日&nbsp;<input type="text" name="txtf_dk" size="30" id="mn_txtf_dk" value=';
if(isset($_POST["txtf_dk"])){
        echo $_POST["txtf_dk"];
}
echo '>〜
<input type="text" name="txtt_dk" size="30" id="mn_txtt_dk" value=';
if(isset($_POST["txtt_dk"])){
        echo $_POST["txtt_dk"];
}
echo'></tr><br>

<tr>メモ&nbsp;<input type="text" name="txtmemo" size="80" id="mn_txtmemo" value="';
if(isset($_POST["txtmemo"])){
        echo $_POST["txtmemo"];
}
echo '"/></tr>
</p>

<p>

電話番号 : <input type="text" name="txttelephone" id="txttelephone" maxlength="25" size="30" value="';
if(isset($_POST['txttelephone'])) {
    echo $_POST['txttelephone'];
}
echo '"> <br><br>

電話対応記録 : <input type="text" name="txttelrecord" id="txttelrecord" size="80" value="';
if(isset($_POST['txttelrecord'])) {
    echo $_POST['txttelrecord'];
}

echo '">

</p>

<p>
登録サイト：
<select name="sltwebs" id="mn_sltwebs">';
echo '<option value="">選択して下さい</option>';
foreach ($webs as $k=>$w){
    echo '<option value="'.$w["id"].'"';
    if( isset($_POST["sltwebs"]) && $_POST["sltwebs"]==$w["id"]){
        echo "selected='selected'";
    }
    echo '>'.$w["name"].'</option>';
}
echo '</select>

　　

登録状態　：
<select name="sltstatus" id="mn_sltstatus">
<option value=""';if($status==null) echo 'selected="selected"'; echo '>選択して下さい</option>
<option value="0"';if($status!=null&&$status==0) echo 'selected="selected"'; echo '>仮登録</option>
<option value="1"';if($status!=null&&$status==1) echo 'selected="selected"'; echo '>本登録</option>
<option value="2"';if($status!=null&&$status==2) echo 'selected="selected"'; echo '>無効</option>
<option value="3"';if($status!=null&&$status==3) echo 'selected="selected"'; echo '>ステルス</option>
<option value="4"';if($status!=null&&$status==4) echo 'selected="selected"'; echo '>確認待ち</option>
</select>

<br>

メルマガ配信　：
<select name="sltmail" id="mn_sltmail">
<option value=""';if($mail==null) echo 'selected="selected"'; echo '>選択して下さい</option>
<option value="1"';if($mail!=null&&$mail==1) echo 'selected="selected"'; echo '>配信OK</option>
<option value="0"';if($mail!=null&&$mail==0) echo 'selected="selected"'; echo '>配信NG</option>
</select>

</p>

<p>※日付・入力形式（YYYY/MM/DD）※項目が空白の場合、全件表示が問題なければ全件表示</p>';
if(isset($count)){
    echo '<p>合計件数:'.$count.'</p>';
}
echo '<p><input type="submit" name="btnsearch_us" value="   検索   " /></p>';
//ket qua search
if(isset($userinfo)){    
    echo "</form>";
    echo '</center>';  
    echo '<div style="margin:0px;padding:0px;" align="center">
    <table style="border-collapse: collapse;border:1px solid #000000;background-color:#FFFFFF;color:#000000;text-align:left;width:102%;margin-bottom:20px;">
    <tbody>

    <tr>
    <th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">システムID&nbsp;</th>
    <th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">状態&nbsp;</th>
    <th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">氏名&nbsp;</th>
    <th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">登録サイト&nbsp;</th>
    <th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">アドレス&nbsp;</th>
    <th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">最終ログイン&nbsp;</th>
    <th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">仮登録日&nbsp;</th>
    <th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">本登録日&nbsp;</th>
    <th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">詳細&nbsp;</th>
    <th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">プロフ&nbsp;</th>
    </tr>';
    foreach($userinfo as $k=>$list){
        echo '<tr>
        <td style="border:1px solid #000000;">'.$list["unique_id"].'&nbsp;</td>
        <td style="border:1px solid #000000;">';
            if($list["user_status"]==0){
                echo "仮登録";
            }elseif($list["user_status"]==1){
                echo "本登録";
            }elseif($list["user_status"]==2){
                echo "無効";
            }elseif($list["user_status"]==3){
                echo "ステルス";
            }elseif($list["user_status"]==4){
                echo "確認まち";
            }
        echo'&nbsp;</td>
        <td style="border:1px solid #000000;">'.$list["uname"].'&nbsp;</td>
        <td style="border:1px solid #000000;">'.$list["wname"].'&nbsp;</td>
        <td style="border:1px solid #000000;">'.$list["email_address"].'&nbsp;</td>
        <td style="border:1px solid #000000;">';
            if($list["last_visit_date"]!=null){               
                echo date("Y/m/d H:i", strtotime($list["last_visit_date"]));
            }else{
                echo "";
            }
        
        echo '&nbsp;</td>
        <td style="border:1px solid #000000;">';
         if($list["temp_reg_date"]!=null){
                echo date("Y/m/d H:i", strtotime($list["temp_reg_date"]));
        }else{
                echo "";
         }
        echo '&nbsp;</td>
        <td style="border:1px solid #000000;">';
             if($list["offcial_reg_date"]!=null){
                echo date("Y/m/d H:i", strtotime($list["offcial_reg_date"]));
        }else{
                echo "";
         }
        echo'&nbsp;</td>
        <td style="border:1px solid #000000;text-align:center;"><a href="'.base_url().'admin/search/userDetail?uid='.$list["uid"].'">開く&nbsp;</a></td>';

        echo'&nbsp;</td>
        <td style="border:1px solid #000000;text-align:center;"><a href="'.base_url().'admin/search/user_profile/'.$list["uid"].'">開く&nbsp;</a></td>
        </tr>';

    }
    echo '</tbody>
    </table>
    </div>
    <center>'; 
    echo "<div id='pagi'>".$this->pagination->create_links()."</div>";
}
echo '</center>';

?>

<script language="javascript">
    $(document).ready(function(){
            pagingByAjax();
           checkUpdateFlag_NewsForUserToInsert();
           setCurrentDate();
           
            })
</script>
<?php
            $today = date("Y-m-d-H-i-s");
            $arr2 = explode("-", $today);
if(isset($_POST["flag"])){$flag=$_POST["flag"];}
if($flag==11){
    echo '<input type="hidden" name="txtMessage" id="txtMessage" size="100" value="'.$error_message.'">';
}
echo '<input type="hidden" name="txtFlag" id="txtFlag" size="100" value="'.$flag.'">';
echo '<input type="hidden" name="txtDate" id="txtDate" size="100" value="'.$send_date.'">';
echo '<form action="'.base_url().'index.php/admin/news/checkValidateFormUser" method="post">';            
echo '<center>
<p>ユーザー側・ニュース</p>
</center>


<div style="margin:0px;padding:0px;" align="center">
<table width="90%" style="border-collapse: collapse;border:1px solid #000000;background-color:#FFFFFF;color:#000000;text-align:left;">
<tbody>

<tr>
<td style="border:1px solid #000000;width:80px">タイトル&nbsp;</td>
<td style="border:1px solid #000000;"><input type="text"  maxlength="200" name="txtTitle" id="txtTitle" size="100" value="';
if(isset($_POST["txtTitle"])){
        echo $_POST["txtTitle"];
}
echo '"></td>
</tr>

<tr>
<td style="border:1px solid #000000;"width="120">登録日&nbsp;</td>
<td style="border:1px solid #000000;">';
echo '<select name="sltYear" id="sltYear">';
for($i = 0;$i<2;$i++){
    $year = (int)$arr2[0]+ $i;
    echo '<option value="'.$year.'">'.$year.'</option>';  
}
echo '</select>
／
<select name="sltMonth" id="sltMonth">
<option value="01">01</option>
<option value="02">02</option>
<option value="03">03</option>
<option value="04">04</option>
<option value="05">05</option>
<option value="06">06</option>
<option value="07">07</option>
<option value="08">08</option>
<option value="09">09</option>
<option value="10">10</option>
<option value="11">11</option>
<option value="12">12</option>
</select>
／
<select name="sltDay" id="sltDay">
<option value="01">01</option>
<option value="02">02</option>
<option value="03">03</option>
<option value="04">04</option>
<option value="05">05</option>
<option value="06">06</option>
<option value="07">07</option>
<option value="08">08</option>
<option value="09">09</option>
<option value="10">10</option>
<option value="11">11</option>
<option value="12">12</option>
<option value="13">13</option>
<option value="14">14</option>
<option value="15">15</option>
<option value="16">16</option>
<option value="17">17</option>
<option value="18">18</option>
<option value="19">19</option>
<option value="20">20</option>
<option value="21">21</option>
<option value="22">22</option>
<option value="23">23</option>
<option value="24">24</option>
<option value="25">25</option>
<option value="26">26</option>
<option value="27">27</option>
<option value="28">28</option>
<option value="29">29</option>
<option value="30">30</option>
<option value="31">31</option>
</select>
      <input type="button" name="btnSetDate" id="btnSetDate" value="現在日時" /> ←これをクリックすると当日の日付が選択される。
</td>
</tr>

<tr>
<td style="border:1px solid #000000;"width="120">ニュース&nbsp;</td>
<td style="border:1px solid #000000;">
<textarea name="txtContent" id="txtContent" maxlength="50000" cols="65" rows="20">';
if(isset($_POST["txtContent"])){
        echo $_POST["txtContent"];
}
echo '</textarea>
</tr>

</td>

</tr>
</tbody>
</table>
</div>

<center>
<p><input type="submit" value="　ニュース追加　" ></p>
</center>

</form>
<center>';
echo '<p>合計件数：'.$totalRows.'</p>';
echo '</center>

<div style="margin:0px;padding:0px;" align="center">
<table class="template1">
<tbody>
<tr>
<th width="15%">登録日&nbsp;</th>
<th >タイトル&nbsp;</th>
<th colspan="2" width="22%">　編集　&nbsp;</th>
</tr>';
if($info!=null){
    foreach($info as $k=>$item){    
        echo '<tr>
            <td>'.strftime("%Y-%m-%d", strtotime($item["created_date"])).'</td>
            <td>'.$item["title"].'</td>
            <td><input type="button" value="　編集　" onClick="{location.href=\''.base_url().'index.php/admin/news/showEditNewForUser?newId='.$item["id"].'\'}">&nbsp;</td>
            <td><input type="button" value="　削除　" onClick="res=confirm(\'削除しますか？\');if(res==true){location.href=\''.base_url().'index.php/admin/news/deactiveNew?newId='.$item["id"].'\'}">&nbsp;</td>
        </tr>';
      } 
        echo'</table>';
        echo '<div id="jquery_link_news" align="center">';
	echo $this->pagination->create_links();
	echo '</div>';
        echo'</center>';
        
}
echo '
</tbody>
</table>
</div>

</form>';
?>


<script language="javascript">
    $(document).ready(function(){
           checkUpdateFlag_NewsForUserToUpdate();
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
echo '<form  method="post" action="'.base_url().'index.php/admin/news/showEditNewForUser?newId=';
if(isset($_POST["txtID"])){echo $_POST["txtID"];}else {echo $txtID; }
    echo '">';
echo '<center>';
echo '<input type="hidden" name="txtID" id="txtID" size="100" value="'.$txtID.'">
<p>ユーザー側・ニュース</p>
</center>


<div style="margin:0px;padding:0px;" align="center">
<table width="80%" style="border-collapse: collapse;border:1px solid #000000;background-color:#FFFFFF;color:#000000;text-align:left;">
<tbody>

<tr>
<td style="border:1px solid #000000;"width="20%">タイトル&nbsp;</td>
<td style="border:1px solid #000000;"><input type="text" name="txtTitle"  maxlength="200" id="txtTitle" size="100" value="'.$txtTitle.'"></td>
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
<textarea name="txtContent" id="txtContent" cols="65"  maxlength="50000" rows="20">'.$txtContent.'</textarea>
</tr>

</td>

</tr>
</tbody>
</table>
</div>

<center>
<p><input type="submit" value="　変更する　" ></p>
</center>

</form>';
?>

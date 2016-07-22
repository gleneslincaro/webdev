<script language="javascript">
    $(document).ready(function(){
           addText();
           setCurrentDate();
           checkFlag();
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
echo '<form action="'.base_url().'index.php/admin/mail/checkValidateFormUser" method="post">';
echo '<input type="hidden" name="txtDate" id="txtDate" size="100" value="'.$send_date.'">';
echo '<input type="hidden" value="'.$array.'" name="arrayEmail" id="arrayEmail"/>';  
echo '<input type="hidden" value="0" name="txtType" id="txtType"/>'; 
echo '<center>
<p>メルマガ作成</p>
</center>

<center>
<tr>
<p>件名：&nbsp;<input type="text" maxlength="200" name="txtTitle" id="txtTitle" size="100" value="';
    if(isset($_POST["txtTitle"])){
        echo $_POST["txtTitle"];
    }
echo '" /></p>
</tr>
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
echo 'メルマガの本文をココに記載します。※文字数：5000文字
各メールのテンプレートをここに記入します。

※右端のセレクトボックスから項目を選択して　【　＜＝　】　を
クリックすると下記のような変数が表示される。
メルマガ配信時は下記の変数が変換され配信される。

【例】メルマガ作成時：/--ユーザー氏名--/　→　メルマガ配信時：小島　雅子

/--ユーザーメールアドレス--/
/--ユーザーパスワード--/
/--ユーザーID--/
/--ユーザー地域--/
/--ユーザー職種--/
/--ユーザー氏名--/




';}
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
<option value="ユーザー職種">ユーザー職種</option>
<option value="ユーザー氏名">ユーザー氏名</option>
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

<p>配信日時';
echo '<select name="sltYear" id="sltYear">';
for($i = 0;$i<3;$i++){
    $year = (int)$arr2[0]+ $i;
    echo '<option value="'.$year.'">'.$year.'</option>';   
}
echo '</select>
/
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
　
<select name="sltHour" id="sltHour">
<option value="00">00</option>
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
</select>
：
<select name="sltMinute" id="sltMinute">
<option value="00">00</option>
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
<option value="32">32</option>
<option value="33">33</option>
<option value="34">34</option>
<option value="35">35</option>
<option value="36">36</option>
<option value="37">37</option>
<option value="38">38</option>
<option value="39">39</option>
<option value="40">40</option>
<option value="41">41</option>
<option value="42">42</option>
<option value="43">43</option>
<option value="44">44</option>
<option value="45">45</option>
<option value="46">46</option>
<option value="47">47</option>
<option value="48">48</option>
<option value="49">49</option>
<option value="50">50</option>
<option value="51">51</option>
<option value="52">52</option>
<option value="53">53</option>
<option value="54">54</option>
<option value="55">55</option>
<option value="56">56</option>
<option value="57">57</option>
<option value="58">58</option>
<option value="59">59</option>
</select>
　　　<input type="button" name="btnSetDate" id="btnSetDate" value="現在時刻" />　
</center>

<center>
<p><input type="submit" value="　送信　"></p>
</center>
</form>';

?>

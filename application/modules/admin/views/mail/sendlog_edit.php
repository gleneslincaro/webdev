<script language="javascript">
    $(document).ready(function(){
            deactiveMessage();
           setCurrentDate();
           checkFlagLog();
            })
</script>
<?php
            $today = date("Y-m-d-H-i-s");
            $arr2 = explode("-", $today);
            $dataDate = explode(" ", $info["send_date"]);
            $dateArray =explode("-", $dataDate[0]);
            $timeArray =explode(":", $dataDate[1]);
if(isset($_POST["flag"])){$flag=$_POST["flag"];}
if($flag==11){
    echo '<input type="hidden" name="txtMessage" id="txtMessage" size="100" value="'.$error_message.'">';
}
echo '<input type="hidden" name="txtFlag" id="txtFlag" size="100" value="'.$flag.'">';
echo '<form  method="post" action="'.base_url().'index.php/admin/mail/showLog_edit?message_id=';
if(isset($_POST[$info["id"]])){echo $_POST[$info["id"]];}else {echo $info["id"]; }
    echo '">';
echo '<input type="hidden" name="txtDate" id="txtDate" size="100" value="'.$send_date.'">';
echo '<center>
<p>配信ログ・閲覧</p>
</center>
<center>
<tr>
<p>件名：&nbsp;<input type="text" name="txtTitle" id="txtTitle" size="100" value="'.$info["title"].'" maxlength="200"></p>

</tr>
</center>

<div style="margin:0px;padding:0px;" align="center">
<table width="70%" style="border-collapse: collapse;border:1px solid #000000;background-color:#FFFFFF;color:#000000;text-align:left;">
<tbody>
<tr>
<td style="border:1px solid #000000;width:120px;"><span id="aspan">送信内容</span></td>
<td style="border:1px solid #000000;width:450px;">
<textarea name="txtContent" id="txtContent" cols="70" rows="40" maxlength="50000">'.$info["content"].'

</textarea>
</td>
</tr>
</tbody>
</table>
</div>';
echo '<center>

<p>配信日時&nbsp;&nbsp;:&nbsp;&nbsp;';
echo '<select name="sltYear" id="sltYear">';
for($i = 0;$i<3;$i++){
    $year = (int)$arr2[0]+ $i;
            echo "<option value='".$year."'";
            if($year==$dateArray[0]){
                echo "selected='selected'";
            }
        echo ">".$year."</option>";
}
echo '</select>
/    
<select name="sltMonth" id="sltMonth">';
for($month = 1;$month<=12;$month++){
           if($month<10){
                    echo "<option value='0".$month."'";
                    if($month==$dateArray[1]){
                        echo "selected='selected'";
                    }
                    echo ">0".$month."</option>";
             }else {
                    echo "<option value='".$month."'";
                    if($month==$dateArray[1]){
                        echo "selected='selected'";
                    }
                    echo ">".$month."</option>";
             }

}
echo '</select>
/    
<select name="sltDay" id="sltDay">';
for($day = 1;$day<=31;$day++){
   if($day<10){
                    echo "<option value='0".$day."'";
                    if($day==$dateArray[2]){
                        echo "selected='selected'";
                    }
                   echo ">0".$day."</option>";
            }else {
                    echo "<option value='".$day."'";
                    if($day==$dateArray[2]){
                        echo "selected='selected'";
                    }
                    echo ">".$day."</option>";
            }
}
echo '</select>
　
<select name="sltHour" id="sltHour">';
for($hour = 0;$hour<=23;$hour++){
            if($hour<10){
                echo "<option value='0".$hour."'";
                if($hour==$timeArray[0]){
                    echo "selected='selected'";
                }
               echo ">0".$hour."</option>";
            }else {
                echo "<option value='".$hour."'";
                if($hour==$timeArray[0]){
                    echo "selected='selected'";
                }
               echo ">".$hour."</option>";
            }
}
echo '</select>
:    
<select name="sltMinute" id="sltMinute">';
for($minute = 0;$minute<=59;$minute++){
   // $year = (int)$arr2[0]+ $i;
            if($minute<10){
                echo "<option value='0".$minute."'";
                if($minute==$timeArray[1]){
                    echo "selected='selected'";
                }
               echo ">0".$minute."</option>";
            }else {
                echo "<option value='".$minute."'";
                if($minute==$timeArray[1]){
                    echo "selected='selected'";
                }
               echo ">".$minute."</option>";
            }
}
echo '</select>
    
<input type="button" name="btnSetDate" id="btnSetDate" value="現在時刻" />　

</center>

<center>
<center>
<p>
<input type="hidden" value="'.$info["id"].'" name="txtMessageID" id="txtMessageID"></p>
<input type="submit" value="　編集　"></p>

<p><input type="button" value="　取消　" name="btnDeactive_h" id="btnDeactive_h" ></p>

</center>
</form>';                    
         
?>

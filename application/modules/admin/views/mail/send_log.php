<script language="javascript">
$(document).ready(function(){
               $( "#txtLastLoginFrom" ).datepicker({ dateFormat: "yy/mm/dd" });
               $( "#txtLastLoginTo" ).datepicker({ dateFormat: "yy/mm/dd" });   
            pagingByAjax();   
                
            })
</script>
<?php

   $LastLoginFrom=null;
   $LastLoginTo=null;
   if(isset($_POST["txtLastLoginFrom"])){$LastLoginFrom=$_POST["txtLastLoginFrom"];}
   if(isset($_POST["txtLastLoginTo"])){$LastLoginTo=$_POST["txtLastLoginTo"];}
   $today = time();
echo '<center>
<form name="input" action="'.base_url().'index.php/admin/mail/searchLog" method="POST">    
<p>配信ログ</p>

<p>日付　
<input type="text" name="txtLastLoginFrom" id="txtLastLoginFrom" value="'.$LastLoginFrom.'" maxlength="100">　〜　<input type="text" name="txtLastLoginTo" id="txtLastLoginTo" value="'.$LastLoginTo.'" maxlength="100"></p>

<p>※日付・入力形式（YYYY/MM/DD）※項目が空白の場合、全件表示が問題なければ全件表示</p>

<p><input type="submit" name="btnSearchLog" id="btnSearchLog" value="   検索   " /></p>
</form>
</center>';

echo'<form name="sendMail" action="" method="POST">';
if(isset($info)){
    echo'<center>';
    echo '<p>合計数：'.$countRows.'</p>';
    
    echo'<table class="template1">';
      echo '<tr>
            <th>カテゴリ</th>
            <th>件名</th>
            <th>作成日時</th>
            <th>配信日時</th>
            <th>閲覧</th>
            <th>編集</th>
     
        </tr>';
    
    foreach($info as $k=>$item){
        $sent_date = strtotime($item["send_date"]);
        if($today>$sent_date){
            $tempString1 =  '--';
        }else{ 
            //
            $tempString1 = '<a href="'.base_url().'index.php/admin/mail/showLog_edit?message_id='.$item["id"].'">はい</a>';
            }
        if($item["member_type"]==0){
            $memberType =  'ユーザー';
        }else if($item["member_type"]==1){ 
           $memberType =  'オーナー ';
            }
        echo '<tr>
            <td>'.$memberType.'</td>
            <td>'.$item["title"].'</td>
            <td>'.strftime("%Y/%m/%d %H:%M", strtotime($item["created_date"])).'</td>
            <td>'.strftime("%Y/%m/%d %H:%M", strtotime($item["send_date"])).'</td>
            <td style="text-align:center"><a href="'.base_url().'index.php/admin/mail/showLog_browse?message_id='.$item["id"].'">はい</a></td>
            <td style="text-align:center">'.$tempString1.'</td>
        </tr>';
      } 
        echo'</table>';
        echo '<div id="jquery_link_log" align="center">';
	echo $this->pagination->create_links();
	echo '</div>';
        echo'</center>';
        
}
echo'</center>';
echo '</form>';

?>

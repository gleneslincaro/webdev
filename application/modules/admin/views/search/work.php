<?php

echo '<form id="frmWork" action="'.base_url().'index.php/admin/search/work_after" method="post" enctype="multipart/form-data">
<center>

<p>勤務申請一覧</p>


<table border="0" cellspacing="10">
<tr>
<td >アドレス&nbsp;
<input type="text" name="txtEmail" maxlength="200" size="40" value="'; if(isset($_POST["txtEmail"])){echo $_POST["txtEmail"];} echo '" id="txtEmail"></td>
<td >店舗名　&nbsp;
<input type="text" name="txtStoreName" maxlength="100" size="40" value="'; if(isset($_POST["txtStoreName"])){echo $_POST["txtStoreName"];} echo '" id="txtStoreName"></td>
</tr>

<tr>
<td>UserID　&nbsp;
<input type="text" name="txtUserId" maxlength="100" size="40" value="'; if(isset($_POST["txtUserId"])){echo $_POST["txtUserId"];} echo '" id="txtUserId"></td>
<td>User氏名&nbsp;
<input type="text" name="txtUserName" maxlength="100" size="40" value="'; if(isset($_POST["txtUserName"])){echo $_POST["txtUserName"];} echo '" id="txtUserName"></td>
</tr>

</table>

<tr>勤務申請日付&nbsp;<input type="text" maxlength="20" name="txtApplicationDateFrom" size="30" id="txtDatePickerCommonFrom" value="'; if(isset($_POST["txtApplicationDateFrom"])){echo $_POST["txtApplicationDateFrom"];} echo '">
〜　<input type="text" maxlength="20" name="txtApplicationDateTo" size="30" id="txtDatePickerCommonTo" value="'; if(isset($_POST["txtApplicationDateTo"])){echo $_POST["txtApplicationDateTo"];} echo '"></tr>

<p>
状態：
<select name="cbSelect" id="cbSelect">
<option value="0" '; if(isset($_POST["cbSelect"])){if($_POST["cbSelect"]==0)echo 'selected';} echo '>選択して下さい</option>
<option value="5" '; if(isset($_POST["cbSelect"])){if($_POST["cbSelect"]==5)echo 'selected';} echo '>未対応</option>
<option value="6" '; if(isset($_POST["cbSelect"])){if($_POST["cbSelect"]==6)echo 'selected';} echo '>決済完了</option>
<option value="7" '; if(isset($_POST["cbSelect"])){if($_POST["cbSelect"]==7)echo 'selected';} echo '>非承認</option>
</select>
　　
<input type="checkbox" name="ckCheck" value="1" '; if(isset($_POST["ckCheck"])){if($_POST["ckCheck"]==1) echo 'checked';} echo' id="ckCheck"> 7日間アクションなし
</p>

<p>※日付・入力形式（YYYY/MM/DD）※項目が空白の場合、全件表示が問題なければ全件表示</p>

<p><input type="submit" value="　検索　" /></p>';
if(isset($records)){
echo '<p>合計件数：'; if(isset($totalNumber)){echo $totalNumber;} echo '</p>

</center>


<div style="margin:0px;padding:0px;" align="center">
<table class="template1" width="80%">
<tbody>
<tr>
<th width="10%">店舗ID&nbsp;</th>
<th width="35%">店舗名&nbsp;</th>
<th width="10%">ユーザーID&nbsp;</th>
<th width="20%">氏名&nbsp;</th>
<th width="15%">勤務申請日付&nbsp;</th>
<th width="10%">状態&nbsp;</th>
</tr>';
foreach ($records as $row) {
echo '<tr>
<td width="10%">'.$row["unique_id_ow"].'</td>
<td width="35%">'.$row["storename"].'</td>
<td width="10%">'.$row["unique_id_us"].'</td>
<td width="20%">'.$row["name"].'</td>
<td width="15%">'; echo $row["request_money_date"] == null ? '' : date("Y/m/d H:i",  strtotime($row["request_money_date"])); echo '</td>
<td width="10%">'; 
    if($row["user_payment_status"]==5){echo '未対応';}
    elseif($row["user_payment_status"]==6){echo '決済完了';}
    elseif($row["user_payment_status"]==7){echo '非承認';}
echo '</td>
</tr>';
}
echo '</tbody>
</table>
</div>

<div style="margin:0px;padding:0px;" align="center" id="pagination_work_kanri">'.$this->pagination->create_links().'</div>';
}
echo '</form>';

?>

<script type="text/javascript">
    $( "#txtDatePickerCommonFrom" ).datepicker({ dateFormat: "yy/mm/dd" });
    $( "#txtDatePickerCommonTo" ).datepicker({ dateFormat: "yy/mm/dd" });
    
    pagination_work_kanri();
    
    $("#txtDatePickerCommonFrom").change(function(){
        var dateFrom = $("#txtDatePickerCommonFrom").val();
        var dateTo = $("#txtDatePickerCommonTo").val();
        if(dateFrom!="" && !dateFrom.match(/^(19|20)\d\d\/(0\d|1[012])\/(0\d|1\d|2\d|3[01])$/)){
            alert("日付が正しくありません。再入力してください。");
            $('#txtDatePickerCommonFrom').val("");
        }
        else if(dateTo!=null){
            if (Date.parse(dateFrom) > Date.parse(dateTo)) {
            alert("日付範囲は無効です。終了日は開始日より後になります。")
            document.getElementById("txtDatePickerCommonFrom").value = "";
            return false;
            } 
        }
    });
    $("#txtDatePickerCommonTo").change(function(){
        var dateFrom = $("#txtDatePickerCommonFrom").val();
        var dateTo = $("#txtDatePickerCommonTo").val();
        if(dateTo!="" && !dateTo.match(/^(19|20)\d\d\/(0\d|1[012])\/(0\d|1\d|2\d|3[01])$/)){
            alert("日付が正しくありません。再入力してください。");
            $('#txtDatePickerCommonTo').val("");
        }
        else if(dateFrom!=null){
            if (Date.parse(dateFrom) > Date.parse(dateTo)) {
            alert("日付範囲は無効です。終了日は開始日より後になります。")
            document.getElementById("txtDatePickerCommonTo").value = "";
            return false;
            } 
        }
    });

</script>
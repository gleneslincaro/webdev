<?php
echo '<form id="frmBankAfter" action="'.base_url().'index.php/admin/payment/bank_after" method="post" enctype="multipart/form-data">
<center>

<p>振込完了メール</p>


<table border="0" cellspacing="10">
<tr>
<td >アドレス&nbsp;
<input type="text" name="txtEmail" size="30" value="'; if(isset($_POST["txtEmail"])){echo $_POST["txtEmail"];} echo '" id="txtEmail"></td>
<td >店舗名　&nbsp;
<input type="text" name="txtStoreName" size="30" value="'; if(isset($_POST["txtStoreName"])){echo $_POST["txtStoreName"];} echo '" id="txtStoreName"></td>
</tr>

<tr>
<td >振込名義&nbsp;
<input type="text" name="txtPaymentName" size="30" value="'; if(isset($_POST["txtPaymentName"])){echo $_POST["txtPaymentName"];} echo '" id="txtPaymentName"></td>
</tr>


</table>

<tr>仮申請日&nbsp;<input type="text" name="txtCreateDateFrom" size="20" id="txtDatePickerCommonFrom" value="'; if(isset($_POST["txtCreateDateFrom"])){echo $_POST["txtCreateDateFrom"];} echo '">　〜　
<input type="text" name="txtCreateDateTo" size="20" id="txtDatePickerCommonTo" value="'; if(isset($_POST["txtCreateDateTo"])){echo $_POST["txtCreateDateTo"];} echo '"></tr>

<p>
状態：
<select name="cbPaymentStatus" id="cbPaymentStatus">
<option value="3" '; if(isset($_POST["cbPaymentStatus"])){if($_POST["cbPaymentStatus"]==3)echo 'selected';} echo '>選択して下さい</option>
<option value="0" '; if(isset($_POST["cbPaymentStatus"])){if($_POST["cbPaymentStatus"]==0)echo 'selected';} echo '>登録</option>
<option value="1" '; if(isset($_POST["cbPaymentStatus"])){if($_POST["cbPaymentStatus"]==1)echo 'selected';} echo '>振込完了</option>
<option value="2" '; if(isset($_POST["cbPaymentStatus"])){if($_POST["cbPaymentStatus"]==2)echo 'selected';} echo '>処理済</option>
</select>

　　
カテゴリ：
<select name="cbPaymentCase" id="cbPaymentCase">
<option value="0">選択して下さい</option>';
foreach ($listPaymentCase as $row) { 
echo '<option value="'.$row['id'].'"'; if(isset($_POST["cbPaymentCase"])){if($_POST["cbPaymentCase"]==$row['id'])echo 'selected';}  echo '>'.$row['name'].'</option>';
} 
echo '</select>
</p>

<p>※日付・入力形式（YYYY/MM/DD）※項目が空白の場合、全件表示が問題なければ全件表示</p>

<p><input type="submit" value="　検索　" /></p>';
if(isset($records)){
echo '<p>合計件数：'; if(isset($totalNumber)){echo $totalNumber;} echo '</p>

</center>

<div style="margin:0px;padding:0px;" align="center">
<table class="template1">
<tbody>
<tr>
<th width="23%">アドレス&nbsp;</th>
<th width="15%">店舗名&nbsp;</th>
<th width="12%">振込名義&nbsp;</th>
<th width="8%">状態&nbsp;</th>
<th width="10%">カテゴリ&nbsp;</th>
<th width="13%">仮申請日&nbsp;</th>
<th width="13%">申請日&nbsp;</th>
<th width="6%">詳細&nbsp;</th>
</tr>';
foreach ($records as $row) {
echo '<tr>
<td>'.$row['email_address'].'</td>
<td>'.$row['storename'].'</td>
<td>'.$row['payment_name'].'</td>
<td>'; if($row['payment_status']==0){echo '登録';}elseif($row['payment_status']==1){echo '振込完了';}elseif($row['payment_status']==2){echo '処理済';} echo '</td>
<td>'.$row['name'].'</td>
<td>';echo $row["created_date"]==null ? '' : date("Y/m/d H:i",  strtotime($row['created_date'])); echo '</td>
<td>';echo $row["tranfer_date"]==null ? '' : date("Y/m/d H:i",  strtotime($row['tranfer_date'])); echo '</td>
<td align="center">';
    if($row['payment_status']==0 || $row['payment_status']==2){echo '---';}else{
        echo '<input type="button" value="　詳細　" onClick="{location.href=\''.base_url().'index.php/admin/payment/bank_detail/'.$row['id'].'\'}">&nbsp;';
    } 
echo '</td>
<tr>';
}
echo '</tbody>
</table>
</div>

<div style="margin:0px;padding:0px;" align="center" id="pagination_bank_kanri">'.$this->pagination->create_links().'</div>';
}
echo '</form>';
?>

<script type="text/javascript">
    $( "#txtDatePickerCommonFrom" ).datepicker({ dateFormat: "yy/mm/dd" });
    $( "#txtDatePickerCommonTo" ).datepicker({ dateFormat: "yy/mm/dd" });
    
    pagination_bank_kanri();
    
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
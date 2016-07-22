<?php

echo '<form id="frmCompanyAfter" action="'.base_url().'index.php/admin/search/company_after" method="post" enctype="multipart/form-data">
<center>
<p>店舗検索項目</p>
<table border="0" cellspacing="10">
<tr>
<td >アドレス&nbsp;
<input type="text" name="txtEmail" size="40" value="'; if(isset($_POST["txtEmail"])){echo $_POST["txtEmail"];} echo '" maxlength="200" id="txtEmail"></td>
<td >店舗名　　&nbsp;
<input type="text" name="txtStoreName" size="40" value="'; if(isset($_POST["txtStoreName"])){echo $_POST["txtStoreName"];} echo '" maxlength="100" id="txtStoreName"></td>
</tr>
<tr>
<td>担当者　　&nbsp;
<input type="text" name="txtPic" size="40" value="'; if(isset($_POST["txtPic"])){echo $_POST["txtPic"];} echo '" maxlength="100" id="txtPic"></td>
<td>IPアドレス　&nbsp;
<input type="text" name="txtIP" size="40" value="'; if(isset($_POST["txtIP"])){echo $_POST["txtIP"];} echo '" maxlength="100" id="txtIP"></td>
</tr>
<td>電話番号　&nbsp;
<input type="text" name="txtTel" size="40" value="'; if(isset($_POST["txtTel"])){echo $_POST["txtTel"];} echo '" maxlength="100" id="txtTel"></td>
</tr>
</table>
<tr>仮登録日&nbsp;<input type="text" name="txtTempRegDateFrom" size="30" id="txtDatePickerCommonFrom" value="'; if(isset($_POST["txtTempRegDateFrom"])){echo $_POST["txtTempRegDateFrom"];} echo '" maxlength="20">〜
<input type="text" name="txtTempRegDateTo" size="30" id="txtDatePickerCommonTo" value="'; if(isset($_POST["txtTempRegDateTo"])){echo $_POST["txtTempRegDateTo"];} echo '" maxlength="20"></tr><br>
<tr>本登録日&nbsp;<input type="text" name="txtCreatedDateFrom" size="30" id="txtDatePickerCommonFrom2" value="'; if(isset($_POST["txtCreatedDateFrom"])){echo $_POST["txtCreatedDateFrom"];} echo '" maxlength="20">〜
<input type="text" name="txtCreatedDateTo" size="30" id="txtDatePickerCommonTo2" value="'; if(isset($_POST["txtCreatedDateTo"])){echo $_POST["txtCreatedDateTo"];} echo '" maxlength="20"></tr><br>
<tr>住所&nbsp;<input type="text" name="txtAddress" size="80" value="'; if(isset($_POST["txtAddress"])){echo $_POST["txtAddress"];} echo '" maxlength="200" id="txtAddress"></tr><br>
<tr>メモ&nbsp;<input type="text" name="txtMemo" size="80" value="'; if(isset($_POST["txtMemo"])){echo $_POST["txtMemo"];} echo '" maxlength="200" id="txtMemo"></tr>
<p>
店舗状態　：
<select name="cbOwnerStatus" id="cbOwnerStatus">
<option value="-1" '; if(isset($_POST["cbOwnerStatus"])){if($_POST["cbOwnerStatus"]==-1)echo 'selected';} echo '>選択して下さい</option>
<option value="0" '; if(isset($_POST["cbOwnerStatus"])){if($_POST["cbOwnerStatus"]==0)echo 'selected';} echo '>仮登録</option>
<option value="5" '; if(isset($_POST["cbOwnerStatus"])){if($_POST["cbOwnerStatus"]==5)echo 'selected';} echo '>リクエスト</option>
<option value="2" '; if(isset($_POST["cbOwnerStatus"])){if($_POST["cbOwnerStatus"]==2)echo 'selected';} echo '>本登録</option>
<option value="3" '; if(isset($_POST["cbOwnerStatus"])){if($_POST["cbOwnerStatus"]==3)echo 'selected';} echo '>ペナルティ</option>
<option value="1" '; if(isset($_POST["cbOwnerStatus"])){if($_POST["cbOwnerStatus"]==1)echo 'selected';} echo '>ステルス</option>
<option value="4" '; if(isset($_POST["cbOwnerStatus"])){if($_POST["cbOwnerStatus"]==4)echo 'selected';} echo '>無効</option>
</select>
メルマガ配信　：
<select name="cbCreditResult" id="cbCreditResult">
<option value="1" '; if(isset($_POST["cbCreditResult"])){if($_POST["cbCreditResult"]==1)echo 'selected';} echo '>選択して下さい</option>
<option value="2" '; if(isset($_POST["cbCreditResult"])){if($_POST["cbCreditResult"]==2)echo 'selected';} echo '>配信OK</option>
<option value="3" '; if(isset($_POST["cbCreditResult"])){if($_POST["cbCreditResult"]==3)echo 'selected';} echo '>配信NG</option>
</select>
</p>
<p>店舗情報 ：
<select name="rdPublicFlag" id="rdPublicFlag">
<option value="">選択して下さい</option>
<option value="1" '; if(isset($_POST["rdPublicFlag"])){ if($_POST["rdPublicFlag"]==1) echo 'selected';} echo '>公開</option>
<option value="0" '; if(isset($_POST["rdPublicFlag"])){ if($_POST["rdPublicFlag"] != '' && $_POST["rdPublicFlag"]==0) echo 'selected';} echo '>非公開</option>
</select>
</p>
<p>
広告サイト　：
<select name="cbWebsite" id="cbWebsite">
<option value="0" '; if(isset($_POST["cbWebsite"])){if($_POST["cbWebsite"]==0)echo 'selected';} echo '>選択して下さい</option>';
foreach ($listWebsite as $value) {
    echo '<option value="'.$value["id"].'" '; if(isset($_POST["cbWebsite"])){if($_POST["cbWebsite"]==$value["id"])echo 'selected';} echo '>'.$value["name"].'</option>';
}
if($listWebsite==null){
    echo '<option value="-1">その他</option>';
}
echo '</select>
</p>
<p><button id="download_csv" name="download_csv" value="1">DOWNLOAD CSV</button></p>
<p>※日付・入力形式（YYYY/MM/DD）※項目が空白の場合、全件表示が問題なければ全件表示</p>
<p><input id="btnSearch" type="submit" value="　検索　" name="btnSearch" /></p>';
if(isset($records)){
echo '<p>合計件数：'; if(isset($totalNumber)){echo $totalNumber;} echo '</p>
</center>
<div style="margin:0px;padding:0px;width:100%;overflow-x:scroll;overflow-y:hidden;" align="center">
<table class="template1" style="width:1400px;">
<tbody>
<tr>
<th width="5%">店舗ID&nbsp;</th>
<th width="5%">状態&nbsp;</th>
<th width="14%">店舗名&nbsp;</th>
<th width="12%">担当者&nbsp;</th>
<th width="7%">電話番号&nbsp;</th>
<th width="15%">アドレス&nbsp;</th>
<th width="8%">最終ログイン&nbsp;</th>
<th width="8%">仮登録日&nbsp;</th>
<th width="8%">本登録日&nbsp;</th>
<th width="5%">ポイント&nbsp;</th>
<th width="5%">累計購入&nbsp;</th>
<th width="4%">詳細&nbsp;</th>
<th width="4%">プロフ&nbsp;</th>
</tr>';
foreach ($records as $row) {
echo '<tr>
<td>'.$row["unique_id"].'</td>
<td>'; if($row["owner_status"]==0){echo '仮登録';}elseif($row["owner_status"]==1){echo 'ステルス';}
elseif($row["owner_status"]==2){echo '本登録';}elseif($row["owner_status"]==3){echo 'ペナルティ';}elseif($row["owner_status"]==4){echo '無効';}
echo '</td>
<td>'.$row["storename"].'</td>
<td>'.$row["pic"].'</td>
<td>'.$row["tel"].'</td>
<td>'.$row["email_address"].'</td>
<td>'; echo $row["last_visit_date"] != null ? date("Y/m/d H:i", strtotime($row["last_visit_date"])) : ''; echo '</td>
<td>'; echo $row["temp_reg_date"] != null ? date("Y/m/d H:i", strtotime($row["temp_reg_date"])) : ''; echo '</td>
<td>'; echo $row["offcial_reg_date"] != null ? date("Y/m/d H:i", strtotime($row["offcial_reg_date"])) : ''; echo '</td>
<td style="text-align: right;">'.number_format($row['total_point'], 0, '.', ',').'</td>
<td style="text-align: right;">'; echo '\\'.number_format($row['amountSave'], 0, '.', ','); echo '</td>
<td style="text-align: center;"><a href="'.base_url().'index.php/admin/search/company_detail/'.$row["id"].'">開く&nbsp;</a></td>
<td style="text-align: center;">'; echo $row['recruit_status'] == 2 ? '<a href="'.base_url().'index.php/admin/search/company_profile/'.$row["oreid"].'">開く&nbsp;</a>':'---'; echo '</td>
</tr>';
}
echo '</tbody>
</table>
</div>
<div style="margin:0px;padding:0px;" align="center" id="pagination_company_kanri">'.$this->pagination->create_links().'</div>';
}
echo '</form>';

?>

<script type="text/javascript">
    $( "#txtDatePickerCommonFrom" ).datepicker({ dateFormat: "yy/mm/dd" });
    $( "#txtDatePickerCommonTo" ).datepicker({ dateFormat: "yy/mm/dd" });
    $( "#txtDatePickerCommonFrom2" ).datepicker({ dateFormat: "yy/mm/dd" });
    $( "#txtDatePickerCommonTo2" ).datepicker({ dateFormat: "yy/mm/dd" });
    
    pagination_company_kanri();
    
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
    
    $("#txtDatePickerCommonFrom2").change(function(){
        var dateFrom = $("#txtDatePickerCommonFrom2").val();
        var dateTo = $("#txtDatePickerCommonTo2").val();
        if(dateFrom!="" && !dateFrom.match(/^(19|20)\d\d\/(0\d|1[012])\/(0\d|1\d|2\d|3[01])$/)){
            alert("日付が正しくありません。再入力してください。");
            $('#txtDatePickerCommonFrom2').val("");
        }
        else if(dateTo!=null){
            if (Date.parse(dateFrom) > Date.parse(dateTo)) {
            alert("日付範囲は無効です。終了日は開始日より後になります。")
            document.getElementById("txtDatePickerCommonFrom2").value = "";
            return false;
            } 
        }
    });
    $("#txtDatePickerCommonTo2").change(function(){
        var dateFrom = $("#txtDatePickerCommonFrom2").val();
        var dateTo = $("#txtDatePickerCommonTo2").val();
        if(dateTo!="" && !dateTo.match(/^(19|20)\d\d\/(0\d|1[012])\/(0\d|1\d|2\d|3[01])$/)){
            alert("日付が正しくありません。再入力してください。");
            $('#txtDatePickerCommonTo2').val("");
        }
        else if(dateFrom!=null){
            if (Date.parse(dateFrom) > Date.parse(dateTo)) {
            alert("日付範囲は無効です。終了日は開始日より後になります。")
            document.getElementById("txtDatePickerCommonTo2").value = "";
            return false;
            } 
        }
    });

    $('input').keypress(function(e) {
        if(e.which == 13) {
            $('#download_csv').val(0);
        } else {
            $('#download_csv').val(1);
        }
    });

    <?php if ((isset($_POST['download_csv']) && $_POST['download_csv'] == 1) && !isset($_POST['btnSearch'])) : ?>
        window.location.replace('<?php echo base_url() . "index.php/admin/search/downloadSearchCsv?result_array=" . urlencode(serialize($_POST)); ?>');
    <?php endif; ?>

    
</script>
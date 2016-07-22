<center>

<p>お祝い金・履歴</p>

<form id="frmPaidAfter" action="<?php echo base_url(); ?>index.php/admin/payment/view_paid" method="post" enctype="multipart/form-data">
<table border="0" cellspacing="10">
<tr>
<td ><p>システムID&nbsp;
        <input type="text" name="txtUniqueId" size="20" value="<?php if(isset($_POST["txtUniqueId"])){echo $_POST["txtUniqueId"];} ?>" id="txtUniqueId"></p></td>
<td ><p>振込名義&nbsp;
        <input type="text" name="txtAccountName" size="20" value="<?php if(isset($_POST["txtAccountName"])){echo $_POST["txtAccountName"];} ?>" id="txtAccountName"></p></td>
</tr>
</table>



    <tr>支払日&nbsp;<input type="text" name="txtPaymentDateFrom" size="20" value="<?php if(isset($_POST["txtPaymentDateFrom"])){echo $_POST["txtPaymentDateFrom"];} ?>" id="txtDatePickerCommonFrom" >　
    ～　<input type="text" name="txtPaymentDateTo" size="20" value="<?php if(isset($_POST["txtPaymentDateTo"])){echo $_POST["txtPaymentDateTo"];} ?>" id="txtDatePickerCommonTo"></tr>

<p>※日付・入力形式（YYYY/MM/DD）※項目が空白の場合、全件表示が問題なければ全件表示</p>

<p>※確定日：オーナーより決済処理の確認できた時刻となります。</p>
<p>※支払日：joyspeスタッフが　お祝い金支払ページ　の　ダウンロード　した時刻となります。</p>

<p><input type="submit" value="　検索　" /></p>

<p>合計件数：<?php echo $totalNumber; ?></p>
</form>


<div style="margin:0px;padding:0px;" align="center">
<table class="template1">
<tbody>
<tr>
<th width="10%">システムID&nbsp;</th>
<th width="12%">氏名&nbsp;</th>
<th width="10%">承認日&nbsp;</th>
<th width="10%">銀行名&nbsp;</th>
<th width="10%">支店名&nbsp;</th>
<th width="8%">口座種別&nbsp;</th>
<th width="10%">口座番号&nbsp;</th>
<th width="13%">名義&nbsp;</th>
<th width="7%">金額&nbsp;</th>
<th width="10%">支払日&nbsp;</th>
</tr>
<?php foreach ($records as $row) { ?>
    <tr>
    <td width="10%"><?php echo $row["unique_id"]; ?></td>
    <td width="12%"><?php echo $row["name"]; ?></td>
    <td width="10%"><?php echo $row["approved_date"]==null ? '' : date("Y/m/d",  strtotime($row["approved_date"])); ?></td>
    <td width="10%"><?php echo $row["bank_name"]; ?></td>
    <td width="10%"><?php echo $row["bank_agency_name"]; ?></td>
    <td width="8%"><?php if($row["account_type"]==0){echo ' 普通';}elseif($row["account_type"]==1){echo '普通';} ?></td>
    <td width="10%"><?php echo $row["account_no"]; ?></td>
    <td width="13%"><?php echo $row["account_name"]; ?></td>
    <td width="7%" style="text-align: right;"><?php echo number_format($row['user_happy_money'], 0, '.', ','); ?></td>
    <td width="10%"><?php echo $row["payment_date"]==null ? '' : date("Y/m/d",  strtotime($row["payment_date"])); ?></td>
    </tr>
<?php } ?>
</tbody>
</table>
</div>

<div style="margin:0px;padding:0px;" align="center" id="pagination_paid_kanri">
    <?php echo $this->pagination->create_links(); ?>
</div>

</center>

<script type="text/javascript">
    $( "#txtDatePickerCommonFrom" ).datepicker({ dateFormat: "yy/mm/dd" });
    $( "#txtDatePickerCommonTo" ).datepicker({ dateFormat: "yy/mm/dd" });
    
    pagination_paid_kanri();
    
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
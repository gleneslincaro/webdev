<form id="frmSettlementLog" action="<?php echo base_url(); ?>index.php/admin/log/view_settlementlog" method="post" enctype="multipart/form-data">
<center>

<p>決済ログ</p>

<tr>
<p>アドレス&nbsp;
<input type="text" name="txtEmail" size="20">

　　
種類
<select name="cbPaymentCases">
    <option value="0">選択して下さい</option>
    <?php foreach ($paymentcases as $row) { ?>
    <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
    <?php } ?>
</select>

</p>
</tr>

<p>
決済種類
<select name="cbPaymentMethods">
    <option value="0">選択して下さい</option>
    <?php foreach ($paymentmethods as $row) { ?>
    <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
    <?php } ?>
</select>
　　
クレジット決済結果
<select name="cbCreditResult">
<option value="1">選択して下さい</option>
<option value="2">OK</option>
<option value="3">NG</option>
</select>
</p>

<tr>
<p>処理日&nbsp;
<input type="text" name="txtTranferDateFrom" size="15" id="txtDatePickerCommonFrom">　
〜　<input type="text" name="txtTranferDateTo" size="15" id="txtDatePickerCommonTo"></p>
</tr>

<p>※日付・入力形式（YYYY/MM/DD）※項目が空白の場合、全件表示が問題なければ全件表示</p>

<input type="submit" value="　検索　" />

</center>
</form>

<script type="text/javascript">
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
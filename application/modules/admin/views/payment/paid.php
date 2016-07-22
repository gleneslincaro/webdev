<center>

<p>お祝い金・履歴</p>

<form id="frmPaid" action="<?php echo base_url(); ?>index.php/admin/payment/view_paid" method="post" enctype="multipart/form-data">
<table border="0" cellspacing="10">
<tr>
<td ><p>システムID&nbsp;
<input type="text" name="txtUniqueId" size="20" id="txtUniqueId"></p></td>
<td ><p>振込名義&nbsp;
<input type="text" name="txtAccountName" size="20" id="txtAccountName"></p></td>
</tr>
</table>

    <tr>支払日&nbsp;<input type="text" name="txtPaymentDateFrom" size="20" id="txtDatePickerCommonFrom">　
    ～　<input type="text" name="txtPaymentDateTo" size="20" id="txtDatePickerCommonTo"></tr>

<p>※日付・入力形式（YYYY/MM/DD）※項目が空白の場合、全件表示が問題なければ全件表示</p>

<p><input type="submit" value="　検索　" /></p>
</form>

</center>

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
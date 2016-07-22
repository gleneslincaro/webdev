<form id="frmPointLogAfter" action="<?php echo base_url(); ?>index.php/admin/log/view_pointlog" method="post" enctype="multipart/form-data">
<center>

<p>ポイントログ</p>

<tr>
<p>アドレス&nbsp;
    <input type="text" name="txtEmail" size="20" value="<?php if(isset($_POST["txtEmail"])){echo $_POST["txtEmail"];} ?>" id="txtEmail">

　　
種類
<select name="cbPaymentCases" id="cbPaymentCases">
    <option value="0" <?php if(isset($_POST["cbPaymentCases"])){if($_POST["cbPaymentCases"]==0)echo 'selected';} ?>>選択して下さい</option>
    <?php foreach ($paymentcases as $row) { ?>
    <option value="<?php echo $row['id']; ?>" <?php if(isset($_POST["cbPaymentCases"])){if($_POST["cbPaymentCases"]==$row['id'])echo 'selected';} ?>><?php echo $row['name']; ?></option>
    <?php } ?>
</select>

</p>
</tr>

<tr>
<p>処理日&nbsp;
    <input type="text" name="txtCreatedDateFrom" size="15" id="txtDatePickerCommonFrom" value="<?php if(isset($_POST["txtCreatedDateFrom"])){echo $_POST["txtCreatedDateFrom"];} ?>">　
    〜　<input type="text" name="txtCreatedDateTo" size="15" id="txtDatePickerCommonTo" value="<?php if(isset($_POST["txtCreatedDateTo"])){echo $_POST["txtCreatedDateTo"];} ?>"></p>
</tr>

<p>※日付・入力形式（YYYY/MM/DD）※項目が空白の場合、全件表示が問題なければ全件表示</p>

<input type="submit" value="　検索　" />

</center>
<p></p>
<div style="margin:0px;padding:0px;" align="center">
<table width="20%" style="border-collapse: collapse;border:1px solid #000000;background-color:#FFFFFF;color:#000000;text-align:left;">
<tbody>
<tr>
<td colspan="2" style="background-color:#808080;color:#FFFFFF;text-align:center;">期間合計</td>
</tr>
<tr>
<td style="border:1px solid #000000;text-align:center;">ポイント数&nbsp;</td>
<td style="border:1px solid #000000;text-align:center;">件数&nbsp;</td>
</tr>
<tr>
<td style="border:1px solid #000000;text-align:center;"><?php echo number_format($sumPoint['sumpoint'], 0, '.', ','); ?> pt&nbsp;</td>
<td style="border:1px solid #000000;text-align:center;"><?php echo $countAll;?></td>
</tr>
</tbody>
</table>
</div>

<br>

<div style="margin:0px;padding:0px;" align="center">
<table width="60%" style="border-collapse: collapse;border:1px solid #000000;background-color:#FFFFFF;color:#000000;text-align:left;">
<tbody>
<tr>
<th width="20%" style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">会社ID&nbsp;</th>
<th width="30%" style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">ポイント数&nbsp;</th>
<th width="30%" style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">処理日&nbsp;</th>
<th width="20%" style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">種類&nbsp;</th>
</tr>
<?php foreach ($records as $row) { ?>
    <tr>
    <td width="20%" style="border:1px solid #000000;text-align:left;"><?php echo $row['unique_id']; ?></td>
    <td width="30%" style="border:1px solid #000000;text-align:right;"><?php echo number_format($row['point'], 0, '.', ','); ?></td>
    <td width="30%" style="border:1px solid #000000;text-align:left;"><?php echo $row["created_date"]==null ? '' : date("Y/m/d H:i",  strtotime($row['created_date'])); ?></td>
    <td width="20%" style="border:1px solid #000000;text-align:left;"><?php echo $row['name']; ?></td>
    </tr>
<?php } ?>
</tbody>
</table>
</div>

<div style="margin:0px;padding:0px;" align="center" id="pagination_pointlog_kanri">
    <?php echo $this->pagination->create_links(); ?>
</div>

</form>

<script type="text/javascript">
    $( "#txtDatePickerCommonFrom" ).datepicker({ dateFormat: "yy/mm/dd" });
    $( "#txtDatePickerCommonTo" ).datepicker({ dateFormat: "yy/mm/dd" });
    
    pagination_pointlog_kanri();
    
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
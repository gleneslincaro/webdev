<script language='javascript'>
            $(document).ready(function(){
                $("#txtDateFrom").datepicker({ dateFormat: "yy/mm/dd" });
                $("#txtDateTo").datepicker({ dateFormat: "yy/mm/dd" });
                pagingByAjaxSearchApplication();
            })
</script>
<center>

<p>応募一覧</p>

<form name="formSearchApplication" method="post" action="<?php echo base_url(); ?>index.php/admin/search/searchApplicationAfter" >
<table border="0" cellspacing="10" >
<tr>
<td >アドレス&nbsp;
<input type="text" id="txtOwnerEmail" name="txtOwnerEmail" maxlength="200" value="<?php echo $email; ?>" size="40"></td>
<td >店舗名　&nbsp;
<input type="text" id="txtOwnerName" name="txtOwnerName" maxlength="100" value="<?php echo $name; ?>" size="40"></td>
</tr>

<tr>
<td>UserID　&nbsp;
<input type="text" id="txtUserId" name="txtUserId" maxlength="100" value="<?php echo $user_id; ?>" size="40"></td>
<td>User氏名&nbsp;
<input type="text" id="txtUserName" name="txtUserName" maxlength="100" value="<?php echo $user_name; ?>" size="40"></td>
</tr>

</table>

<tr>応募日付&nbsp;<input type="text" id="txtDateFrom" maxlength="20" name="txtDateFrom" value="<?php echo $dateFrom; ?>" size="30">　〜　<input type="text" id="txtDateTo" maxlength="20" name="txtDateTo" value="<?php echo $dateTo; ?>" size="30"></tr>

<p>
状態：
<select name="selectList" id="selectList">
<option value="10" <?php if ($val == 10) {echo "selected=selected";} ?>>選択して下さい</option>
<option value="1" <?php if ($val == 1) {echo "selected=selected";} ?>>購入済・未対応</option>
<option value="3" <?php if ($val == 3) {echo "selected=selected";} ?>>購入済・検討</option>
<option value="4" <?php if ($val == 4) {echo "selected=selected";} ?>>購入済・情報公開</option>
<option value="2" <?php if ($val == 2) {echo "selected=selected";} ?>>購入済・採用見送</option> 
<option value="0" <?php if ($val == 0) {echo "selected=selected";} ?>>未購入</option> 
</select>

</p>

<p>※日付・入力形式（YYYY/MM/DD）※項目が空白の場合、全件表示が問題なければ全件表示</p>

<p><BUTTON type="submit">　検索　</BUTTON></p>
</form>
<?php
    if($info==null && $flag==1){
?>
<p>合計件数：<?php echo $sum; ?></p>

<div style="margin:0px;padding:0px;" align="center">
<table width="85%" style="border-collapse: collapse;border:1px solid #000000;background-color:#FFFFFF;color:#000000;text-align:left;">
<tbody>
<tr>
<th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">店舗ID&nbsp;</th>
<th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">店舗名&nbsp;</th>
<th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">ユーザーID&nbsp;</th>
<th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">氏名&nbsp;</th>
<th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">応募時間&nbsp;</th>
<th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">状態&nbsp;</th>
</tr>
<?php
    }
    if($info!=null && $flag==1){
?>
<p>合計件数：<?php echo $sum?></p>

<div style="margin:0px;padding:0px;" align="center">
<table width="80%" style="border-collapse: collapse;border:1px solid #000000;background-color:#FFFFFF;color:#000000;text-align:left;">
<tbody>
<tr>
<th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">店舗ID&nbsp;</th>
<th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">店舗名&nbsp;</th>
<th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">ユーザーID&nbsp;</th>
<th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">氏名&nbsp;</th>
<th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">応募時間&nbsp;</th>
<th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">状態&nbsp;</th>
</tr>
<?php
        foreach ($info as $row): 
?>
<tr>
<td style="border:1px solid #000000;"><?php echo $row["idOfOwner"]?>&nbsp;</td>
<td style="border:1px solid #000000;text-align:left;"><?php echo $row["storename"]?>&nbsp;</td>
<td style="border:1px solid #000000;"><?php echo $row["idOfUser"]?>&nbsp;</td>
<td style="border:1px solid #000000;text-align:left;"><?php echo $row["nameOfUser"]?>&nbsp;</td>
<td style="border:1px solid #000000;text-align:left;">
    <?php 
    if($row["apply_date"]==null){ echo ""; }
    else{echo date("Y/m/d H:i",  strtotime($row['apply_date']));}
    ?>&nbsp;
</td>
<td style="border:1px solid #000000;text-align:left;">
    <?php 
        if($row["user_payment_status"]==1){echo "購入済・未対応";}
        if($row["user_payment_status"]==3){echo "購入済・検討";}
        if($row["user_payment_status"]==4){echo "購入済・情報公開";}
        if($row["user_payment_status"]==2){echo "購入済・採用見送";}
        if($row["user_payment_status"]==0){echo "未購入";}
        if($row["user_payment_status"]!=1&&$row["user_payment_status"]!=3&&$row["user_payment_status"]!=4&&$row["user_payment_status"]!=2&&$row["user_payment_status"]!=0){echo " ---- ";}
    ?>&nbsp;
</td>
</tr>
</tbody>
<?php endforeach; ?>
</table>
    <br/>
<div id="jquery_link_searchApplication" align="center"><?php echo $this->pagination->create_links()?></div>
</div>

<?php } ?>
</center>

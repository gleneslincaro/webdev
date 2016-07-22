<script language='javascript'>
            $(document).ready(function(){
                $("#txtDateFrom").datepicker({ dateFormat: "yy/mm/dd" });
                $("#txtDateTo").datepicker({ dateFormat: "yy/mm/dd" });
                pagingByAjaxSearch();
            })
</script>
<center>
<p>お祝い金申請履歴</p>

<p>
<form name="formSearchCelebration" method="post" action="<?php echo base_url(); ?>index.php/admin/log/searchCelebrationAfter" >    
日付&nbsp;<input type="text" id="txtDateFrom" name="txtDateFrom" value="<?php echo $dateFrom; ?>">　〜　<input type="text" id="txtDateTo" name="txtDateTo" value="<?php echo $dateTo; ?>"></p>

<p>
入金状態：
<select name="selectList" id="selectList">
<option value="" <?php if ($val == "") {echo "selected=selected";} ?>>選択して下さい</option>
<option value="5" <?php if ($val == 5) {echo "selected=selected";} ?>>未入金</option>
<option value="6" <?php if ($val == 6) {echo "selected=selected";} ?>>入金済</option>
<option value="7" <?php if ($val == 7) {echo "selected=selected";} ?>>非承認</option>
</select>
</p>


<p>※日付・入力形式（YYYY/MM/DD）※項目が空白の場合、全件表示が問題なければ全件表示</p>

<p><BUTTON type="submit">　検索　</BUTTON></p>
</form>
<?php
    if($info==null && $flag==1){
?>
<p>合計数：<?php echo $sum?></p>

<div style="margin:0px;padding:0px;" align="center">
<table width="100%" style="border-collapse: collapse;border:1px solid #000000;background-color:#FFFFFF;color:#000000;text-align:left;">
<tbody>
<tr>
<th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">アドレス&nbsp;</th>
<th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">店舗名&nbsp;</th>
<th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">ユーザーID&nbsp;</th>
<th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">氏名&nbsp;</th>
<th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">申請日&nbsp;</th>
<th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">承認日&nbsp;</th>
<th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">入金状態&nbsp;</th>
<th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">採用金&nbsp;</th>
<th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">お祝い金&nbsp;</th>
<th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">利益&nbsp;</th>
<th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">消費ポイント&nbsp;</th>
</tr>
<?php
    }
    if($info!=null && $flag==1){
?>
<p>合計数：<?php echo $sum?></p>

<div style="margin:0px;padding:0px;" align="center">
<table width="100%" style="border-collapse: collapse;border:1px solid #000000;background-color:#FFFFFF;color:#000000;text-align:left;">
<tbody>
<tr>
<th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">アドレス&nbsp;</th>
<th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">店舗名&nbsp;</th>
<th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">ユーザーID&nbsp;</th>
<th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">氏名&nbsp;</th>
<th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">申請日&nbsp;</th>
<th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">承認日&nbsp;</th>
<th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">入金状態&nbsp;</th>
<th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">採用金&nbsp;</th>
<th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">お祝い金&nbsp;</th>
<th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">利益&nbsp;</th>
</tr>
<?php
        foreach ($info as $row): 
?>
<tr>
<td style="border:1px solid #000000;text-align:left;"><?php echo $row["email_address"]?>&nbsp;</td>
<td style="border:1px solid #000000;text-align:left;"><?php echo $row["storename"]?>&nbsp;</td>
<td style="border:1px solid #000000;text-align:right;"><?php echo $row["idOfUser"]?>&nbsp;</td>
<td style="border:1px solid #000000;text-align:left;"><?php echo $row["nameOfUser"]?>&nbsp;</td>
<td style="border:1px solid #000000;text-align:left;">
    <?php 
    if($row["request_money_date"]==null){ echo ""; }
    else{echo date("Y/m/d",  strtotime($row['request_money_date']));}
    ?>&nbsp;
</td>
<td style="border:1px solid #000000;text-align:left;">
    <?php if($row["approved_date"]==null){ echo ""; }
    else{echo date("Y/m/d",  strtotime($row['approved_date']));}
    ?>&nbsp;
</td>
<td width="6%" style="border:1px solid #000000;text-align:left;">
    <?php 
        if($row["user_payment_status"]==5){echo "未入金";}
        if($row["user_payment_status"]==6){echo "入金済";}
        if($row["user_payment_status"]==7){echo "非承認";}
        if($row["user_payment_status"]!=5&&$row["user_payment_status"]!=6&&$row["user_payment_status"]!=7){echo " ---- ";}
    ?>&nbsp;
</td>
<td width="8%" style="border:1px solid #000000;text-align:right;">
    <?php if($row["user_payment_status"]!= 6){ echo " ---- "; }
    else{ echo number_format($row["joyspe_happy_money"]);}
    ?>&nbsp;
</td>
<td width="8%" style="border:1px solid #000000;text-align:right;">
    <?php if($row["user_payment_status"]!= 6){ echo " ---- "; }
    else{ echo number_format(($row["user_happy_money"]), 0, '.', ',');}
    ?>&nbsp;
</td>
<td width="7%" style="border:1px solid #000000;text-align:right;">
    <?php if($row["user_payment_status"]!= 6){ echo " ---- "; }
    else{ echo number_format(($row["joyspe_happy_money"] - $row["user_happy_money"]), 0, '.', ',');}
    ?>&nbsp;
</td>
</tr>
</tbody>
<?php endforeach; ?>
</table>
<br/>
<div id="jquery_link_searchCelebration" align="center"><?php echo $this->pagination->create_links()?></div>   
</div>
<?php } ?>
</center>

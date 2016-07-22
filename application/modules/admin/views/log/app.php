<script language='javascript'>
            $(document).ready(function(){
                $("#txtDateFrom").datepicker({ dateFormat: "yy/mm/dd" });
                $("#txtDateTo").datepicker({ dateFormat: "yy/mm/dd" });
                pagingByAjaxSearch();
            })
</script>
<center>
<p>応募者閲覧履歴</p>

<p>
<form name="formSearchApp" method="post" action="<?php echo base_url(); ?>index.php/admin/log/searchAppAfter" >
日付&nbsp;<input type="text" id="txtDateFrom" name="txtDateFrom" value="<?php echo $dateFrom; ?>">　〜　<input type="text" id="txtDateTo" name="txtDateTo" value="<?php echo $dateTo; ?>"></p>

<p>※日付・入力形式（YYYY/MM/DD）※項目が空白の場合、全件表示が問題なければ全件表示</p>

<p><BUTTON type="submit">　検索　</BUTTON></p>
</form>

<?php
    if($info==null && $flag==1){
?>
<p>合計数：<?php echo $sum?></p>
<div style="margin:0px;padding:0px;" align="center">
<table width="80%" style="border-collapse: collapse;border:1px solid #000000;background-color:#FFFFFF;color:#000000;text-align:left;">
<tbody>
<tr>
<th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">アドレス&nbsp;</th>
<th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">店舗名&nbsp;</th>
<th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">ユーザーID&nbsp;</th>
<th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">氏名&nbsp;</th>
<th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">日付&nbsp;</th>
</tr>
<?php
    }
    if($info!=null && $flag==1){
?>
<p>合計数：<?php echo $sum?></p>
<div style="margin:0px;padding:0px;" align="center">
<table width="80%" style="border-collapse: collapse;border:1px solid #000000;background-color:#FFFFFF;color:#000000;text-align:left;">
<tbody>
<tr>
<th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">アドレス&nbsp;</th>
<th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">店舗名&nbsp;</th>
<th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">ユーザーID&nbsp;</th>
<th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">氏名&nbsp;</th>
<th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">日付&nbsp;</th>
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
    if($row["updated_date"]==null){ echo " ---- "; }
    else{echo date("Y/m/d H:i",  strtotime($row['updated_date']));}
    ?>&nbsp;
</td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
<br/>
<div id="jquery_link_searchApp" align="center"><?php echo $this->pagination->create_links()?></div>   
</div>
<?php } ?>
</center>

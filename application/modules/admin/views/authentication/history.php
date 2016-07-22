<script language='javascript'>
            $(document).ready(function(){
                $("#txtDateFrom").datepicker({ dateFormat: "yy/mm/dd" });
                $("#txtDateTo").datepicker({ dateFormat: "yy/mm/dd" });
                pagingByAjaxSearchOwnerApproved();
            })
</script>
<center>
<p>承認履歴</p>
<form name="formSearchOwnerApproved" method="post" action="<?php echo base_url(); ?>index.php/admin/authentication/searchOwnerApprovedAfter" >
<p>
アドレス&nbsp;<input type="text" maxlength="200" id="txtOwnerEmail" name="txtOwnerEmail" value="<?php echo $email; ?>" size="40">　　
店舗名&nbsp;<input type="text" maxlength="100" id="txtOwnerName" name="txtOwnerName" value="<?php echo $name; ?>" size="40"></p>

<p>承認日付&nbsp;<input type="text" id="txtDateFrom" name="txtDateFrom" maxlength="50" value="<?php echo $dateFrom; ?>" size="20">　〜　<input type="text" id="txtDateTo" name="txtDateTo" maxlength="50"  value="<?php echo $dateTo; ?>" size="20"></p>


<p>※日付・入力形式（YYYY/MM/DD）※項目が空白の場合、全件表示が問題なければ全件表示</p>

<p><button type="submit">　検索　</button></p>
</form>

<?php
    if($info==null && $flag==1){
?>
<p>合計件数：<?php echo $sum?></p>

<div style="margin:0px;padding:0px;" align="center">
<table style="border-collapse: collapse;border:1px solid #000000;background-color:#FFFFFF;color:#000000;text-align:left;">
<tbody>

<tr>
<th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">アドレス&nbsp;</th>
<th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">店舗名&nbsp;</th>
<th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">作成時間&nbsp;</th>
<th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">承認時間&nbsp;</th>
<th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">詳細&nbsp;</th>
</tr>
<?php
    }
    if($info!=null && $flag==1){
?>
<p>合計件数：<?php echo $sum?></p>


<div style="margin:0px;padding:0px;" align="center">
<table width="100%" style="border-collapse: collapse;border:1px solid #000000;background-color:#FFFFFF;color:#000000;text-align:left;">
<tbody>

<tr>
<th width="25%" style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">アドレス&nbsp;</th>
<th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">店舗名&nbsp;</th>
<th width="15%" style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">作成時間&nbsp;</th>
<th width="15%" style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">承認時間&nbsp;</th>
<th width="5%" style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">詳細&nbsp;</th>
</tr>
<?php
        foreach ($info as $row): 
?>
<tr>
<td style="border:1px solid #000000;text-align:left;"><?php echo $row["email_address"]?>&nbsp;</td>
<td style="border:1px solid #000000;text-align:left;"><?php echo $row["storename"]?>&nbsp;</td>
<td style="border:1px solid #000000;text-align:left;">
    <?php 
    if($row["created_date"]==null){ echo ""; }
    else{echo date("Y/m/d H:i",  strtotime($row['created_date']));}
    ?>&nbsp;
</td>
<td style="border:1px solid #000000;text-align:left;">
    <?php 
    if($row["recruit_approve_date"]==null){ echo ""; }
    else{echo date("Y/m/d H:i",  strtotime($row['recruit_approve_date']));}
    ?>&nbsp;
</td>
<td style="border:1px solid #000000;text-align:center;"><a href="<?php echo base_url(); ?>index.php/admin/authentication/listProfile01/<?php echo $row["id"]?>">開く&nbsp;</a></td>
</tr>

<?php endforeach; ?>
</tbody>
</table>
<br/>
<div id="jquery_link_searchOwnerApproved" align="center"><?php echo $this->pagination->create_links()?></div>
</div>
<?php } ?>
</center>

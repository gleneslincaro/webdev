<script language='javascript'>
    $(document).ready(function(){
        $("#txtDateFrom").datepicker({ dateFormat: "yy/mm/dd" });
        $("#txtDateTo").datepicker({ dateFormat: "yy/mm/dd" });
        pagingByAjaxSearch();
    })
</script>
<center>
<p>1円ボーナス履歴</p>

<p>
<form name="formSearchSends" method="get" action="<?php echo base_url(); ?>index.php/admin/oneyenbonus/searchAfter" >
日付&nbsp;<input type="text" id="txtDateFrom" name="txtDateFrom" value="<?php echo $dateFrom; ?>">　〜　<input type="text" id="txtDateTo" name="txtDateTo" value="<?php echo $dateTo; ?>"></p>

<p>※日付・入力形式（YYYY/MM/DD）※項目が空白の場合、全件表示が問題なければ全件表示</p>

<p><BUTTON type="submit">　検索　</BUTTON></p>
</form>
<?php if (isset($info)) {?>
<div style="margin:0px;padding:0px;" align="center">
<p style="color: red; padding: 5px 0; margin: 0;">付与金額：<?php if (isset($total)) { echo $total; } ?>円</p>
<div id="jquery_link_searchSends" align="center"><?php echo $this->pagination->create_links()?></div>
<br>
<table width="70%" style="border-collapse: collapse;border:1px solid #000000;background-color:#FFFFFF;color:#000000;text-align:left;">
<tr>
<th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">オーナー&nbsp;</th>
<th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">ユーザＩＤ&nbsp;</th>
<th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">アクセスポイント&nbsp;</th>
<th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">訪問日付&nbsp;</th>
</tr>
<?php
if ($info !=null && $flag==1) {
    foreach ($info as $row):
?>
<tr>
<td style="border:1px solid #000000;text-align:left;"><?php echo $row["owner_id"]?>&nbsp;</td>
<td style="border:1px solid #000000;text-align:left;"><?php echo $row["user_id"]?>&nbsp;</td>
<td style="border:1px solid #000000;text-align:left;"><?php echo $row["access_point"]?>&nbsp;</td>
<td style="border:1px solid #000000;text-align:right;"><?php echo $row["visited_date"]?>&nbsp;</td>
</tr>
<?php endforeach;?>
</table>
<br/>
<div id="jquery_link_searchSends" align="center"><?php echo $this->pagination->create_links()?></div>
</div>
<?php
    }
} ?>
</center>

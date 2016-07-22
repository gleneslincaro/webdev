<center>
<p>応募者閲覧履歴</p>

<p>日付　
<form name="forms" method="post" action="<?php echo base_url(); ?>index.php/admin/log/searchAppAfter" >
<input type="text" name="txtDateFrom">　〜　<input type="text" name="txtDateTo"></p>

<p>※日付・入力形式（YYYY/MM/DD）※項目が空白の場合、全件表示が問題なければ全件表示</p>

<p><BUTTON type="submit">　検索　</BUTTON></p>
</form>

<p>１、２、３、４、５　次へ　※１ページに５０件表示</p>
<p>合計数：３４</p>
<?php
    if($info!=null){
?>
<div style="margin:0px;padding:0px;" align="center">
<table width="70%" style="border-collapse: collapse;border:1px solid #000000;background-color:#FFFFFF;color:#000000;text-align:left;">
<tbody>
<tr>
<th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">アドレス&nbsp;</th>
<th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">店舗名&nbsp;</th>
<th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">ユーザーID&nbsp;</th>
<th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">氏名&nbsp;</th>
<th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">決済種別&nbsp;</th>
<th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">日付&nbsp;</th>
</tr>
<?php
    foreach ($info as $row): 
?>
<tr>
<td style="border:1px solid #000000;text-align:center;"><?php echo $row["owner_recruit_id"]?>&nbsp;</td>
<td style="border:1px solid #000000;text-align:center;">小島代理店&nbsp;</td>
<td style="border:1px solid #000000;text-align:center;">userkojima&nbsp;</td>
<td style="border:1px solid #000000;text-align:center;">小島 雅子&nbsp;</td>
<td style="border:1px solid #000000;text-align:center;">クレジット&nbsp;</td>
<td style="border:1px solid #000000;text-align:center;"><?php echo $row["last_scout_date"]?>&nbsp;</td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
<br/>
<div id="jquery_link_searchApp" align="center"><?php echo $this->pagination->create_links()?></div>   
</div>
<?php } ?>
<p>・</p>
<p>・</p>
<p>・</p>
<p>・</p>

</center>

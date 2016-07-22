<script language="javascript">
$(document).ready(function(){    
    pagingByAjaxPen_nm();  
})
</script>
<?php
    echo '<center>

<p>会社・ペナルティ検索項目</p>';



echo "<form action='".base_url()."admin/search/searchPen' method='post'>";
echo '<table border="0" cellspacing="10">

<tr>
<td ><p>アドレス&nbsp;
<input type="text" name="txtpemail" id="txtpemail" size="40" value="';
if(isset($_POST["txtpemail"])){
    echo $_POST["txtpemail"];
}
echo '"></p></td>
<td ><p>店舗名　&nbsp;
<input type="text" name="txtpstore" id="txtpstore" size="40" value="';
if(isset($_POST["txtpstore"])){
    echo $_POST["txtpstore"];
}
echo '"></p></td>
</tr>

</table>



</p>

<p>※項目が空白の場合、全件表示が問題なければ全件表示</p>

<p><input type="submit" name="btnshowpenalty" id="btnpen" value="   検索   "/></p>';
echo "</form>";

echo '</center>';
echo '</center>';
if(isset($listpe)){
    echo "<center><p>合計件数:";
    echo $count;
echo "</p></center>";
echo '<div style="margin:0px;padding:0px;" align="center">
<table width="60%" style="border-collapse: collapse;border:1px solid #000000;background-color:#FFFFFF;color:#000000;text-align:left;">
<tbody>

<tr>
<th width="30%" style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">アドレス&nbsp;</th>
<th width="30%" style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">店舗名&nbsp;</th>
<th width="30%" style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">ペナルティ時間&nbsp;</th>
<th width="10%" style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">詳細&nbsp;</th>
</tr>';
foreach($listpe as $k=>$lpe){
echo '<tr>
<td width="30%" style="border:1px solid #000000;">'.$lpe["email_address"].'&nbsp;</td>
<td width="30%" style="border:1px solid #000000;">'.$lpe["storename"].'&nbsp;</td>
<td width="30%" style="border:1px solid #000000;">'.strftime("%Y/%m/%d %H:%M", strtotime($lpe["penalty_date"])).'&nbsp;</td>
<td width="10%" class="center" style="border:1px solid #000000;"><a href="'.base_url().'admin/search/company_detail/'.$lpe["id"].'">開く&nbsp;</a></td>
</tr>';
}
}

echo '</tbody>
</table>
</div>

<center>';
echo "<div id='pagipen'>".$this->pagination->create_links()."</div>";
echo '</center>';

?>

<center>

<p>統計・職種</p>

<form name="forms" method="post" action="<?php echo base_url(); ?>index.php/admin/statistics/showUserJobAfter" >
<p><BUTTON type="submit">　表示する　</BUTTON></p>
</form>

</center>

<div style="margin:0px;padding:0px;" align="center">
<table width="25%" style="border-collapse: collapse;border:1px solid #000000;background-color:#FFFFFF;color:#000000;text-align:left;">
<tbody>
<tr>
<th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">カテゴリ&nbsp;</th>
<th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">件数&nbsp;</th>
<th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">割合&nbsp;</th>
</tr>

<?php
    foreach ($userJobList as $row): 
?>
<tr>
    <td style="border:1px solid #000000;">
        <?php echo $row['name']; ?>&nbsp;
    </td>
    <td style="border:1px solid #000000;text-align:center;">
        <?php echo $row['numbers']; ?>&nbsp;
    </td>
    <td style="border:1px solid #000000;text-align:center;">
        <?php echo $row['rate']; ?>%&nbsp;
    </td>
</tr>
<?php endforeach; ?>

</tbody>
</table>
</div>

<center>
<p>合計件数：<?php echo $count; ?></p>
</center>

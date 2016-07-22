<center>

<p>月給目安</p>

<form name="forms" method="post" action="<?php echo base_url(); ?>index.php/admin/setting/doUpdateMonth" onsubmit="return confirm('編集しますか？');">
<div style="margin:0px;padding:0px;" align="center">
<table width="20%" style="border-collapse: collapse;border:1px solid #000000;background-color:#FFFFFF;color:#000000;text-align:left;">
<tbody>
<tr>
<th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">NO&nbsp;</th>
<th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">月給目安&nbsp;</th>
<th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">アクティブ&nbsp;</th>
</tr>

<?php
    foreach ($monthSalaryList as $row): 
?>
<tr>
    <td style="border:1px solid #000000;text-align:center;" >
        <?php echo $index++; ?>&nbsp;
    </td>
    <td style="border:1px solid #000000;text-align:right;">
        <?php echo number_format($row['amount'], 0, '.', ','); ?>&nbsp;
    </td>
    <td style="border:1px solid #000000;text-align:center;">
        <input type="checkbox" name="chk[<?php echo $row['id'] ?>]" <?php if ($row['display_flag'] == 1) {echo "checked = checked";} ?> value="<?php echo $row['display_flag'] ?>" >
    </td>
</tr>
<?php endforeach; ?>

</tbody>
</table>
</div>

<p>
<button type="button" <?php  echo 'onClick="{location.href=\''.base_url().'index.php/admin/setting/addMonth\'}"' ?>>　追加　</button>　　<input type="submit" value="　編集　" >
</p>
</form>

</center>

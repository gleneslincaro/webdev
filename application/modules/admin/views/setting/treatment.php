<script language='javascript'>
            $(document).ready(function(){
                moveTreatmentUp();
                moveTreatmentDown();
                
            })
</script>
<script language="javascript">
    $(document).ready(function(){
         var base = $("#base").attr("value");
        $("#btnset1").click(function(){
        window.location=base+"admin/setting/addTreatment";
    });
   
    })
    
</script>
<center>

<p>待遇</p>

<form name="forms" method="post" action="<?php echo base_url(); ?>index.php/admin/setting/doUpdateTreatment" onsubmit="return confirm('編集しますか？');">
<div style="margin:0px;padding:0px;" align="center">
<table width="40%" style="border-collapse: collapse;border:1px solid #000000;background-color:#FFFFFF;color:#000000;text-align:left;">
<tbody>
<tr>
<th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">NO&nbsp;</th>
<th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">待遇&nbsp;</th>
<th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">表示変更&nbsp;</th>
<th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">アクティブ&nbsp;</th>
</tr>

<?php
    foreach ($treatmentList as $row): 
?>
<tr>
    <td style="border:1px solid #000000;text-align:center;">
        <?php echo $index++; ?>&nbsp;
    </td>
    <td style="border:1px solid #000000;">
        <?php echo $row['name']; ?>&nbsp;
    </td>
    <td style="border:1px solid #000000;text-align:center;">　<a href="" class="treat_up" id="<?php echo $row['id'] ?>">↑</a>　<a href="" class="treat_down" id="<?php echo $row['id'] ?>">↓</a>　&nbsp;</td>
    <td style="border:1px solid #000000;text-align:center;">
        <input type="checkbox" name="chk[<?php echo $row['id'] ?>]" <?php if ($row['display_flag'] == 1) {echo "checked = checked";} ?> value="<?php echo $row['display_flag'] ?>" >
    </td>
</tr>
<?php endforeach; ?>

</tbody>
</table>
</div>


<p>

<button type="button" id="btnset1">　追加　</button> <input type="submit" value="　編集　" >


</p>
</form>

</center>

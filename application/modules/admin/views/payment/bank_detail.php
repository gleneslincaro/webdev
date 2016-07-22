<form id="frmBankDetail" action="<?php echo base_url(); ?>index.php/admin/payment/bank_ok" method="post" enctype="multipart/form-data">
<center>

<p>振込完了メール・詳細</p>

<input type="hidden" name="hrId" value="<?php echo $records['id'] ;?>"/>
<input type="hidden" name="hrPaymentCaseId" value="<?php echo $records['payment_case_id'] ;?>"/>
<input type="hidden" name="hrIdOwner" value="<?php echo $records['idowner'] ;?>"/>
<div style="margin:0px;padding:0px;" align="center">
<table width="30%" style="border-collapse: collapse;border:1px solid #000000;background-color:#FFFFFF;color:#000000;text-align:left;">
<tbody>
<tr>
<th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;" colspan="2">入金処理&nbsp;</th>
</tr>
<tr>
<td style="border:1px solid #000000;">会社ID&nbsp;</td>
<td style="border:1px solid #000000;"><?php echo $records['unique_id'] ;?></td>
</tr>
<tr>
<td style="border:1px solid #000000;">会社名&nbsp;</td>
<td style="border:1px solid #000000;"><?php echo $records['storename'] ;?></td>
</tr>
<tr>
<td style="border:1px solid #000000;">振込名義&nbsp;</td>
<td style="border:1px solid #000000;"><?php echo $records['payment_name'] ;?></td>
</tr>
<tr>
<td style="border:1px solid #000000;">入金日&nbsp;</td>
<td style="border:1px solid #000000;"><?php echo $records["tranfer_date"]==null ? '' : date("Y/m/d",  strtotime($records['tranfer_date'])) ;?></td>
</tr>
<tr>
<td style="border:1px solid #000000;">振込金額&nbsp;</td>
<td style="border:1px solid #000000;"><?php echo number_format($records['amount'], 0, '.', ',') ;?>円&nbsp;</td>
</tr>

</tbody>
</table>
</div>

<p><input type="button" value="　入金処理　" onClick="doSubmit();" /></p>

</center>
</form>

<script type="text/javascript">
    function doSubmit(){
        res=confirm('入金処理しますか？');
        if(res==true){
            $("#frmBankDetail").submit();
        }
    }
</script>
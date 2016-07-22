<center>

<p>お祝い金・削除リスト</p>

<p><?php echo $numRecord;?>件</p>

<p>※確定日：オーナーより決済処理の確認できた時刻となります。</p>

<form id="frmReturn" action="<?php echo base_url(); ?>index.php/admin/payment/reward_return_ok" method="post" enctype="multipart/form-data">
<div style="margin:0px;padding:0px;" align="center">
<table class="template1">
<tbody>
<tr>
<th width="10%">システムID&nbsp;</th>
<th width="15%">氏名&nbsp;</th>
<th width="10%">承認日&nbsp;</th>
<th width="10%">銀行名&nbsp;</th>
<th width="10%">支店名&nbsp;</th>
<th width="10%">口座種別&nbsp;</th>
<th width="10%">口座番号&nbsp;</th>
<th width="10%">名義&nbsp;</th>
<th width="10%">金額&nbsp;</th>
<th width="5%">戻す&nbsp;</th>
</tr>
<?php foreach ($records as $row) { ?>
    <tr>
    <td width="10%"><?php echo $row["unique_id"]; ?></td>
    <td width="15%"><?php echo $row["name"]; ?></td>
    <td width="10%"><?php echo $row["approved_date"]==null ? '' : date("Y/m/d",  strtotime($row["approved_date"])); ?></td>
    <td width="10%"><?php echo $row["bank_name"]; ?></td>
    <td width="10%"><?php echo $row["bank_agency_name"]; ?></td>
    <td width="10%"><?php if($row["account_type"]==0){echo ' 普通';}elseif($row["account_type"]==1){echo '普通';} ?></td>
    <td width="10%"><?php echo $row["account_no"]; ?></td>
    <td width="10%"><?php echo $row["account_name"]; ?></td>
    <td width="10%" style="text-align: right;"><?php echo number_format($row['user_happy_money'], 0, '.', ','); ?></td>
    <td width="5%" style="text-align:center;"><input type="checkbox" class="clCheck" 
                                                            id="id-<?php echo $row["id"]; ?>" name="ckReturn-<?php echo $row["id"]; ?>" 
                                                            value="<?php echo $row["id"]; ?>"></td>
    </tr>
<?php } ?>
</tbody>
</table>
</div>

<p>
<input type="button" value="　お祝い金支払へ戻す　" onClick="doConfirm();" 
<?php if(count($records)==0){ ?>
disabled="disabled"
<?php } ?>
/>  
</p>
</form>
</center>
<script type="text/javascript">
    function doConfirm(){
        var isCheck = false;
        
        $(".clCheck").each(function(){
            var id = $(this).attr("id");
            if($('#' + id).is(":checked")){
                isCheck = true;
            }
        });
        
        if(isCheck){
            res=confirm('戻しますか？'); if(res==true){
                $("#frmReturn").submit();
            }
        }else{
            alert("チェックボックスが選択されておりません。対象を選択して下さい。");
        }
    }
    
</script>
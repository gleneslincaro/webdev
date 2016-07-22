<script language="javascript">
    $(document).ajaxStart($.blockUI).ajaxStop($.unblockUI);
    $(document).ready(function(){
            var base = $("#base").attr("value");
           $("#btdownload").click(function(){
                 //$("#export_csv").trigger('click');
                 window.location=base+"admin/payment/reward_download";
                 $(".template1").remove();
                 $("#divdownload").append('<table class="template1"><tbody><tr><th width="9%">システムID&nbsp;</th><th width="10%">氏名&nbsp;</th><th width="10%">承認日&nbsp;</th><th width="15%">銀行名&nbsp;</th><th width="13%">支店名&nbsp;</th><th width="10%">口座種別&nbsp;</th><th width="8%">口座番号&nbsp;</th><th width="10%">名義&nbsp;</th><th width="10%">金額&nbsp;</th><th width="5%">削除&nbsp;</th></tr></table>');
                 $("#btdownload").remove();
                 $("#btdel").attr("disabled","disabled");
                 $("#num").html("0");
            });
    })
</script>
<center>

<p>お祝い金・支払リスト</p>
<p><?php echo "<span id='num'>".$numRecord."</span>";?>件</p>

<p>※確定日：オーナーより決済処理の確認できた時刻となります。</p>

<p>
<?php if(count($records)>0){ ?>
<input type="button" value="　ダウンロード　" id="btdownload"/>
</p>
<?php } ?>
<form id="frmReward" action="<?php echo base_url(); ?>index.php/admin/payment/reward_delete" method="post" enctype="multipart/form-data">
<div style="margin:0px;padding:0px;" align="center" id="divdownload">
<table class="template1">
<tbody>
<tr>
<th width="9%">システムID&nbsp;</th>
<th width="10%">氏名&nbsp;</th>
<th width="10%">承認日&nbsp;</th>
<th width="15%">銀行名&nbsp;</th>
<th width="13%">支店名&nbsp;</th>
<th width="10%">口座種別&nbsp;</th>
<th width="8%">口座番号&nbsp;</th>
<th width="10%">名義&nbsp;</th>
<th width="10%">金額&nbsp;</th>
<th width="5%">削除&nbsp;</th>
</tr>
<?php foreach ($records as $row) { ?>
    <tr>
    <td width="9%"><?php echo $row["unique_id"]; ?></td>
    <td width="15%"><?php echo $row["name"]; ?></td>
    <td width="10%"><?php echo $row["approved_date"]==null ? '' : date("Y/m/d",  strtotime($row["approved_date"])); ?></td>
    <td width="13%"><?php echo $row["bank_name"]; ?></td>
    <td width="10%"><?php echo $row["bank_agency_name"]; ?></td>
    <td width="8%"><?php echo $row["account_type"] == 0 ? '普通' : '当座'; ?></td>
    <td width="10%"><?php echo $row["account_no"]; ?></td>
    <td width="10%"><?php echo $row["account_name"]; ?></td>
    <td width="10%" style="text-align: right;"><?php echo number_format($row['user_happy_money'], 0, '.', ','); ?></td>
    <td width="5%" style="text-align:center;"><input type="checkbox" class="clCheck" 
                                                                   id="id-<?php echo $row["id"]; ?>" name="ckDelete-<?php echo $row["id"]; ?>"
                                                                   value="<?php echo $row["id"]; ?>"></td>
    </tr>
<?php } ?>
</tbody>
</table>
</div>

<p>
<input type="button" value="　削除　" onClick="doConfirm();" id="btdel" 
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
            res=confirm('削除しますか？'); if(res==true){
                $("#frmReward").submit();
            }
        }else{
            alert("チェックボックスが選択されておりません。対象を選択して下さい。");
        }
    }
</script>
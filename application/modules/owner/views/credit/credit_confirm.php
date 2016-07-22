<script language="JavaScript">
	$(document).ready(function() {
		$('#pay_by_credit_btn').click(function() {
			var option = document.forms['credit_card_form']['option'].value;
			var url = baseUrl + "owner/credit/add_point/" + option;
			$.ajax({
				type: 'get',
				url: url,
				data: {},
				success: function(data){
					if(data == 1){
						$('#credit_card_form').submit();
					}else{
						return false;
					}
				}
			})
		});
	});
</script>

<div class="crumb">TOP ＞ ポイント購入 ＞　ポイント購入確認</div>
<div class="owner-box"><?php echo $owner_info['storename']; ?>　様　ポイント：<?php echo number_format($total_point); ?>pt　</div>
<div class="list-box"><!-- list-box ここから -->
    <div class="list-title">ポイント購入確認</div>
    <div class="contents-box-wrapper">
    <div style="width: 800px; margin:0 auto;"><img src="<?php echo base_url(); ?>public/owner/images/tag_confirm.gif"></div>
    <div class="table-list-wrapper">

		<table>
			<form id="credit_card_form" action="<? echo $credit_url; ?>" method="POST" >
				<tr>
					<td colspan="2"><font size="4" color="#FFFFFF"><strong>決済内容</strong></font></td>
				</tr>
				<tr>
					<td>決済方法</td>
					<td>クレジット決済</td>
				</tr>
				<tr>
					<td>決済金額</td>
					<td><?php echo number_format($confrm_money); ?>円</td>
				</tr>
				<tr>
					<td>ポイント数</td>
					<td><?php echo number_format($confrm_point); ?>pt</td>
				</tr>
				<tr>
					<td colspan="2">
						<input type="button" value="戻る" style="width: 100px;" onClick="window.history.back()">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name="ボタン" type="button" style="width: 100px;" value="決済手続き" id = "pay_by_credit_btn">
					</td>
				</tr>
            <INPUT TYPE = "HIDDEN" NAME = "clientip" VALUE = "<?php echo CREDIT_CARD_CLIENTIP; ?>">
            <INPUT TYPE = "HIDDEN" NAME = "sendid" VALUE = "<?php echo $sendid; ?>">
            <INPUT TYPE = "HIDDEN" NAME = "money" VALUE = "<?php echo $confrm_money; ?>">
            <INPUT TYPE = "HIDDEN" NAME = "redirect_url" VALUE = "<?php echo base_url().'owner/credit/credit_complete'; ?>">
            <INPUT TYPE = "HIDDEN" NAME = "option" VALUE = "<?php echo $credit_hash; ?>">
            <?php if ( isset($usrtel) ){ ?>
            	<INPUT TYPE = "HIDDEN" NAME = "usrtel" VALUE = "<?php echo $usrtel; ?>">
            <?php } ?>
            <?php if ( isset($user_list) ){ ?>
            <INPUT TYPE = "HIDDEN" NAME = "user_list" VALUE = "<?php echo $user_list; ?>">
            <?php } ?>
			</form>
		</table>

	</div><!-- / . table-list-wrapper -->
	</div><!-- / .contents-box-wrapper -->
</div><!-- list-box ここまで -->

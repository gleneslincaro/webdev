<div id="container">
	<div style="float:right"><?php echo $owner_info['storename']; ?>　様　ポイント：<?php echo number_format($total_point); ?>pt　
	</div>
TOP ＞ ポイント購入
	<div class="list-box"><!-- list-box ここから -->

	<div class="list-title">■クレジット決済エラー</div>
	<br ><br ><br >
	<div class="message_box">
	<table class="message">
	<tr>
	クレジット決済が正常に完了しませんでした。　お手数ですが、クレジット会社までご確認くださいませ。<br>
	<br>
	</tr>
	</table>
	</div>
	<br><br>
	<center><a href="<?php echo base_url() . 'owner/index' ?>">TOPページへ</a></center>
	</div><!-- list-box ここまで -->
	</div><!-- container ここまで -->
<center>

<p>IP制限設定</p>
<p>
</p>
<div style="margin:0px;padding:0px;" align="center">
<table width="60%" style="border-collapse: collapse;border:1px solid #000000;background-color:#FFFFFF;color:#000000;text-align:left;">
<tbody>
<?php echo form_error('ip_address','<div style="color:red;">', '</div>'); ?>
<?php
if ( isset($error_ip_id) ) {
	echo form_error('ip_address_'.$error_ip_id,'<div style="color:red;">', '</div>');
}
?>
<form name="add_oiwaipay" action="<?=base_url();?>admin/setting/limitip" method="post" >
	<tr>
		<th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">IP&nbsp;</th>
		<th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">メモ&nbsp;</th>
		<th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">追加&nbsp;</th>
	</tr>
	<tr>
		<?php if ( !isset($add_success_flag) ){ ?>
			<td style="border:1px solid #000000;">
				<input type="text" name="ip_address" size="20" value="<?php echo set_value('ip_address',''); ?>">
			</td>
			<td style="border:1px solid #000000;">
				<input type="text" name="note" size="50"  value="<?php echo set_value('note',''); ?>">
			</td>
		<?php }else{ ?>
			<td style="border:1px solid #000000;">
				<input type="text" name="ip_address" size="20" >
			</td>
			<td style="border:1px solid #000000;">
				<input type="text" name="note" size="50">
			</td>
		<?php } ?>
		<td style="border:1px solid #000000;text-align:center;"><input type="submit" value="追加"></td>
		<input type="hidden" name="mode" value="add">
	</tr>
</form>
</tbody>
</table>
</div>
<br>
<div style="margin:0px;padding:0px;" align="center">
<table width="60%" style="border-collapse: collapse;border:1px solid #000000;background-color:#FFFFFF;color:#000000;text-align:left;">
<tbody>
<tr>
	<th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">IP&nbsp;</th>
	<th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">メモ&nbsp;</th>
	<th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">変更&nbsp;</th>
	<th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">アクティブ&nbsp;</th>
</tr>
<?php if ( $allow_ip_list && is_array($allow_ip_list) ){
	foreach ( $allow_ip_list as $an_ip ){ ?>
		<?php
		$check = false; //アクティブかチェック
		if ( isset($an_ip['disable_flag']) && $an_ip['disable_flag'] == 0) {
			$check = true;
		echo "<tr>";
		}else{
		echo "<tr style='background:#E6E6E6;'>";
		}?>
		<form class="change_oiwaipay_one" name="changeip_<?= $an_ip['idip']; ?>"
			  action="<?=base_url();?>admin/setting/limitip" method="post">
		<input type="hidden" name="ip_id" value="<?= $an_ip['idip']; ?>"/>
		<td style="border:1px solid #000000;">
		<input 	type="text" name="ip_address_<?= $an_ip['idip']; ?>" size="20"
							value="<?php echo set_value('ip_address_'.$an_ip['idip'], $an_ip['ip_address']); ?>" />
		</td>
		<td style="border:1px solid #000000;">
		<input 	type="text" name="note_<?= $an_ip['idip']; ?>" size="50"
							value="<?php echo  set_value('memo_'.$an_ip['idip'], $an_ip['note']); ?>" />
		</td>
		<td style="border:1px solid #000000;text-align:center;">
		<input type="submit" value="変更" />
		</td>
		<td style="border:1px solid #000000;text-align:center;">
		<input TYPE="checkbox" NAME="active_flag_<?= $an_ip['idip']; ?>" <?php if( $check ){echo "CHECKED";} ?> />
		</td>
		<input type="hidden" name="mode" value="change">
		</form>
		</tr>
	<?php
	}
}?>
</tbody>
</table>
</div>
</center>
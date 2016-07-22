<center>

<p>採用金・お祝い金設定</p>
<p>
</p>
<div style="margin:0px;padding:0px;" align="center">
<table width="60%" style="border-collapse: collapse;border:1px solid #000000;background-color:#FFFFFF;color:#000000;text-align:left;">
<tbody>
<form name="add_oiwaipay" action="<?=base_url();?>admin/setting/changeOiwaipay/1" method="post" >
<tr>
<th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">採用金&nbsp;</th>
<th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">お祝い金&nbsp;</th>
<th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">追加&nbsp;</th>
</tr>
<tr>
<?php if ( !isset($add_success_flag) ){ ?>
	<td style="border:1px solid #000000;"><input type="text" name="joyspe_happy_money" size="30" value="<?php echo set_value('joyspe_happy_money',''); ?>"></td>
	<td style="border:1px solid #000000;"><input type="text" name="user_happy_money" size="30"  value="<?php echo set_value('user_happy_money',''); ?>"></td>
<?php }else{ ?>
	<td style="border:1px solid #000000;"><input type="text" name="joyspe_happy_money" size="30" ></td>
	<td style="border:1px solid #000000;"><input type="text" name="user_happy_money" size="30"></td>
<?php } ?>
<td style="border:1px solid #000000;text-align:center;"><input type="submit" value="追加"></td>
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
<th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">採用金&nbsp;</th>
<th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">お祝い金&nbsp;</th>
<th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">変更&nbsp;</th>
<th style="border:1px solid #000000;background-color:#808080;color:#FFFFFF;text-align:center;">アクティブ&nbsp;</th>
</tr>

<?php if ( $happyMoneyList && is_array($happyMoneyList) ){
	foreach ( $happyMoneyList as $hm_item ){ ?>
		<?php
		$check = false; //アクティブかチェック
		if ($hm_item['display_flag'] && $hm_item['display_flag'] == 1) {
			$check = true;
			echo "<tr>";
		}else{
			echo "<tr style='background:#E6E6E6;'>";
		}?>
			<form class="change_oiwaipay_one" name="change_oiwaipay_one_<?= $hm_item['id']; ?>" action="<?=base_url();?>admin/setting/changeOiwaipay/2" method="post">
				<input type="hidden" name="money_no" value="<?= $hm_item['id']; ?>"/>
				<td style="border:1px solid #000000;">
					<input 	type="text" name="joyspe_happy_money_<?= $hm_item['id']; ?>" size="20"
							value="<?php echo set_value('joyspe_happy_money_'.$hm_item['id'], $hm_item['joyspe_happy_money']); ?>" />
				</td>
				<td style="border:1px solid #000000;">
					<input 	type="text" name="user_happy_money_<?= $hm_item['id']; ?>" size="20"
							value="<?php echo  set_value('user_happy_money_'.$hm_item['id'], $hm_item['user_happy_money']); ?>" />
				</td>
				<td style="border:1px solid #000000;text-align:center;">
					<input type="submit" value="変更" />
				</td>
				<td style="border:1px solid #000000;text-align:center;">
					<INPUT TYPE="checkbox" NAME="active_<?= $hm_item['id']; ?>" <?php if( $check ){echo "CHECKED";} ?> />
				</td>
			</form>
		</tr>
	<?php
	}
}?>
</tbody>
</table>
</div>
<p>
	<form id = "change_oiwaipay_all" name="change_oiwaipay_all" action="<?=base_url();?>admin/setting/changeOiwaipay/3" method="post" >
		<input type="button" value="　編集　" onClick="javascript: change_pay_all();">
	</form>
</p>
</center>
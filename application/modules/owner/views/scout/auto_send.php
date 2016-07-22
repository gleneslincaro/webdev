<script type="text/javascript">
	$(document).ready(function(){
		$("#th8").addClass("visited");
		var default_scout_mails_per_day = <?php echo $default_scout_mails_per_day;?>;
		var ifchecked = <?php echo $ifchecked;?>;
		var err = false;
		if(default_scout_mails_per_day < $('#setMailTotal').text()){
			err = true;
		}
		if(ifchecked != 0){
			$("#ckautosend").attr('checked','checked');
		}
	    $('#boxTemplate input').keyup(function (e) {
			var totalVal = 0;
			$("#boxTemplate input").each(function() {
			    totalVal = Number(totalVal) + Number($(this).val());
			});
			if(default_scout_mails_per_day < totalVal){
				alert('スカウト通数がオーバーしています');
				err = true
				return false;
			}
			err = false;
			$('#setMailTotal').text(totalVal);
		});
		$('#btn_auto_send').click(function(){
			if(err == true){
				alert('スカウト通数がオーバーしています');
				return false;
			}
			var fieldblank = true;
			var fieldnotblank = true;
			var err2 = false;
			for(x=0;x<5;x++){
				fieldblank =  ($("#selArea" + (x + 1)).val() == '' && $("#selStatus" + (x + 1)).val() == '' && $("#numSend" + (x + 1)).val() == '' ? true : false);
				fieldnotblank =  ($("#selArea" + (x + 1)).val() != '' && $("#selStatus" + (x + 1)).val() != '' && $("#numSend" + (x + 1)).val() != '' ? true : false);
				if(fieldblank == false){
					if(fieldnotblank == false){
						err2 = true;
					}
				}
			}
			if(err2 == true) {
				alert('必要な情報を入力して下さい');
				return false;
			}
			var msg = false;
			fieldblank =  ($("#selStatusCheck1").val() == '' && $("#selStatusCheck2").val() == '' && $("#selStatusCheck3").val() == ''? true : false);
			if(fieldblank == true){
				msg = true;
			}
			if ($('#ckautosend').is(':checked')) {
				if(msg == true){
					alert('右の状態とテンプレートを選択してください。');
					return false;
				}
			}
		});
		$('#switch_fl').click(function(){
			var msgconfirm = false;
			if($('#switchfl').val() == 0){
				var msgconfirm = confirm('この機能を無効にします。よろしいでしょうか？');
			}else{
				var msgconfirm = confirm("この機能を有効にします。よろしいでしょうか？");
			}
			if (msgconfirm != true) {
				return false;
			}
		});
	});
</script>
<script type="text/javascript">
		function numbersonly(myfield, e, dec){
		var key;
		var keychar;
		if (window.event){
		   key = window.event.keyCode;
		}else if (e){
		   key = e.which;
		}else{
		   return true;
		}
		keychar = String.fromCharCode(key);
		// control keys
		if ((key==null) || (key==0) || (key==8) ||
		    (key==9) || (key==13) || (key==27) ){
		   return true;
		// numbers
		}else if ((("0123456789").indexOf(keychar) > -1)){
		   return true;
		// decimal point jump
		}else if (dec && (keychar == ".")){
		   myfield.form.elements[dec].focus();
		   return false;
		}else{
		   return false;
		}
	}
</script>
<div class="crumb">TOP ＞ スカウト自動送信</div>
<div style="margin: auto; width: 100%; padding: 50px 0;">
	<?php if($auto_send_finish == true): ?>
	<p style="padding: 15px;text-align: center;background: #D4E4EC;color: #375E7B;font-size: 13px;  font-weight: bold;">正常に保存されました。</p>
	<?php endif;?>
	<form id='formSwitchfl' method="POST" action="<?php echo base_url() ?>owner/scout/auto_send_finish">
		<div class='box_switch' style="padding-bottom:10px; text-align: center;">
			<input style="width:150px; height:40px;" type='submit' id="switch_fl" name='switch_fl' value=' <?php if(isset($getAutoSend[0]['switch_flag'])) {echo ($getAutoSend[0]['switch_flag'] == 0 ? 'この機能を無効にする': 'この機能を有効にする');}else{ echo 'この機能を無効にする';}?> '>
			<input type="hidden" id='switchfl' name='switchfl' value="<?php if(isset($getAutoSend[0]['switch_flag'])) { echo $getAutoSend[0]['switch_flag'];}else{ echo '0';}?>">
			<?php if(isset($getAutoSend[0]['switch_flag'])):if($getAutoSend[0]['switch_flag'] == 1): ?>
				<p style="color:red; text-align: center; padding-bottom: 0; margin-bottom: 0;">現在、この機能は無効の状態になっています。ご注意ください。</p>
			<?php endif;endif;?>
		</div>
	</form>
	<form method="POST" action="<?php echo base_url() ?>owner/scout/auto_send_finish">
		<table class="regional-table-wrapper" style="float:left; width: auto; margin:0;">
			<tr>
				<th style="background: #fff;"></th>
				<th>都道府県</th>
				<th>状態</th>
			</tr>
			<?php for($x=0;$x<5;$x++): ?>
			<tr>
				<td height="25">第<?php echo $x + 1;?>候補</td>
				<td>
					<select name="selArea<?php echo $x + 1;?>" id="selArea<?php echo $x + 1;?>" style="height: 20px;">
						<option></option>
						<?php
							$area_pick = '';
							$status1_pick = '';
							foreach ($getAutoSend as $val) {
								if($x + 1 == $val['pick_num_order'] && $val['selected_flag'] == 0){
									$area_pick = $val['area'];
									$status1_pick = $val['status_target_1'];
								}
							}
							foreach ($city as $key) {
								if($area_pick == $key['id']){
									echo '<option selected="selected" value="' . $key['id'] . '">' . $key['name'] . '</option>';
								}else{
									echo '<option value="' . $key['id'] . '">' . $key['name'] . '</option>';
								}
							}
						?>
					</select>
				</td>
				<td>
					<select name="selStatus<?php echo $x + 1;?>" id="selStatus<?php echo $x + 1;?>" style="height: 20px;">
						<option></option>
						<option <?php echo $status = ($status1_pick == '1' ? 'selected': '');  ?> value="1">新規登録</option>
						<option <?php echo $status = ($status1_pick == '2' ? 'selected': '');  ?> value="2">１ヶ月以内ログイン</option>
						<option <?php echo $status = ($status1_pick == '3' ? 'selected': '');  ?> value="3">開封済み</option>
					</select>
				</td>
			</tr>
			<?php endfor; ?>
		</table>
		<table  class="regional-table-wrapper" id="boxTemplate" style="float:left; width: auto; margin: 0;">
			<tr>
				<th>テンプレート</th>
				<th>通数</th>
			</tr>
			<?php
				$totalsetnum = 0;
				for($x=0;$x<5;$x++):
			?>
			<tr>
				<td height="25">
					<select name="selTemplate<?php echo $x + 1;?>" id="selTemplate<?php echo $x + 1;?>" style="width: 141px; height: 20px;">
					<?php
						$template_pick= '';
						$setnum_pick= '';
						foreach ($getAutoSend as $val) {
							if($x + 1 == $val['pick_num_order'] && $val['selected_flag'] == 0){
								$template_pick = $val['template_target_1'];
								$setnum_pick = $val['setnum_scout_mail'];
								$totalsetnum = $totalsetnum + $setnum_pick;
							}
						}
						foreach ($owner_scout_pr_text_data as $key) {
							if($template_pick == $key['id']){
								echo '<option selected="selected" value="' . $key['id']  . '">' . $key['title'] . '</option>';
							}else{
								echo '<option value="' . $key['id'] . '">' . $key['title'] . '</option>';
							}
						}
					?>
					</select>
				</td>
				<td style="width: 82px;"><input id='numSend<?php echo $x + 1;?>' type="text" name="numSend<?php echo $x + 1;?>" value="<?php echo $setnum_pick; ?>" style="width: 78px;" onKeyPress="return numbersonly(this, event)"></td>
			</tr>
			<?php endfor; ?>
			<tr>
				<td style="background: #fff;"></td>
				<td>合計　　<span id="setMailTotal"><?php echo $totalsetnum; ?></span>通</td>
			</tr>
		</table>
		<div style="float: right; margin-top: 2px; border: 3px solid #1db6b6;  padding: 11px 5px 5px 5px; height: 234px; width: 342px;">
			<input type="checkbox" name='ckautosend' id="ckautosend" style="float: left;"><p style="padding: 0 0 0 20px; margin: 0;">対象が見つからない場合は全国から送信を行う<br>（チェックが無い場合は送信数が残ります）</p>
			<table style="margin-top: 43px;">
			<tr>
				<th></th>
				<th>状態</th>
				<th>テンプレート</th>
			</tr>
			<?php for($x=0;$x<3;$x++): ?>
			<tr>
				<td height="25">第<?php echo $x + 1;?>候補</td>
				<td>
					<select name="selStatusCheck<?php echo $x + 1;?>" id="selStatusCheck<?php echo $x + 1;?>" style="height: 20px;">
						<?php
							$status2_pick = '';
							$template2_pick = '';
							foreach ($getAutoSend as $val) {
								if($x + 1 == $val['pick_num_order']){
									$status2_pick = $val['status_target_2'];
									$template2_pick = $val['template_target_2'];
								}
							}
						?>
						<option></option>
						<option <?php echo $status = ($status2_pick == '1' ? 'selected': '');  ?> value="1">新規登録</option>
						<option <?php echo $status = ($status2_pick == '2' ? 'selected': '');  ?> value="2">１ヶ月以内ログイン</option>
						<option <?php echo $status = ($status2_pick == '3' ? 'selected': '');  ?> value="3">開封済み</option>
					</select>
				</td>
				<td>
					<select name="selTemplateCheck<?php echo $x + 1;?>" id="selTemplateCheck<?php echo $x + 1;?>" style="width: 141px; height: 20px;">
					<?php
						foreach ($owner_scout_pr_text_data as $key) {
							if($template2_pick == $key['id']){
								echo '<option selected="selected" value="' . $key['id'] . '">' . $key['title'] . '</option>';
							}else{
								echo '<option value="' . $key['id'] . '">' . $key['title'] . '</option>';
							}
						}
					?>
					</select>
				</td>
			</tr>
			<?php endfor; ?>
		</table>
		</div>
		<div style="margin: auto; clear: both; text-align: center; padding-top: 10px;">
			<input type="submit" id="btn_auto_send" name="btn_auto_send" value="設定" style="width:150px; height:40px;">
		</div>
		<div style="color: red; text-align: center">
			<p style="font-size:15px">トライアル中</p>
			<p>※予告無くサービスを停止する場合がございます</p>
		</div>
	</form>
</div>

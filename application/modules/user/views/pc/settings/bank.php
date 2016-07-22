<h3>
	<span>銀行口座</span>
	<span class="ttl_note">※この情報は求人サービスを利用される際に必要です。</span>
</h3>
<div class="settings_bank_data">
	<form method="post" action="" name="form_bank_account" id="form_bank_account">
		<input type="hidden" value="do_user_change" name="do_user_recruits_change">
		<div class="settings_inner">
			<dl>
				<dt><span>金融機関名</span></dt>
				<dd>
					<div class="ui_msg ui_msg-error error_bank_name" style="display:none;"></div>
					<input id="bank_name" type="text" class="size_max" name="bank_name" placeholder="○○銀行" value="<?php echo set_value('bank_name',$Uniqueid['bank_name']); ?>">
				</dd>
			</dl>
			<dl>
				<dt><span>支店名</span></dt>
				<dd>
					<div class="ui_msg ui_msg-error error_bank_agency_name" style="display:none;"></div>
					<input id="bank_agency_name" type="text" class="size_max" name="bank_agency_name" placeholder="○○支店" value="<?php echo set_value('bank_agency_name',$Uniqueid['bank_agency_name']); ?>">					
				</dd>
			</dl>
			<dl>
				<dt><span>支店名カナ</span></dt>
				<dd>
					<div class="ui_msg ui_msg-error error_bank_agency_kara_name" style="display:none;"></div>
					<input id="bank_agency_kara_name" type="text" class="size_max" name="bank_agency_kara_name" placeholder="○○シテン" value="<?php echo set_value('bank_agency_kara_name',$Uniqueid['bank_agency_kara_name']); ?>">
				</dd>
			</dl>
			<dl>
				<dt><span>口座種別</span></dt>
				<dd>
					<div>
						<ul>
							<li>
								<label>
									<input id="account_type0" type="radio" name="account_type" value="0" <?php echo set_radio('account_type','0'); ?> <?php if ($Uniqueid['account_type'] == 0) echo "checked"; ?>>
									普通 </label>
							</li>
							<li>
								<label>
                                	<input id="account_type1" type="radio" name="account_type" value="1" <?php echo set_radio('account_type','1'); ?> <?php if ($Uniqueid['account_type'] == 1) echo "checked"; ?>>
									当座 </label>
							</li>

						</ul>
					</div>
				</dd>
			</dl>
			<dl>
				<dt><span>口座番号</span></dt>
				<dd>
					<div class="ui_msg ui_msg-error error_account_no" style="display:none;"></div>
					<input id="account_no" type="text" class="size_max" name="account_no" placeholder="12345678" value="<?php echo set_value('account_no',$Uniqueid['account_no']); ?>">
				</dd>
			</dl>
			<dl>
				<dt><span>口座名義</span></dt>
				<dd>
					<div class="ui_msg ui_msg-error error_account_name" style="display:none;"></div>
					<input id="account_name" type="text" class="size_max" name="account_name" placeholder="ジョイスペタロウ" value="<?php echo set_value('account_name',$Uniqueid['account_name']); ?>">
				</dd>
			</dl>
		</div>
		<div class="btn_wrap t_center m_t_40">
			<ul>
				<li><button class="ui_btn ui_btn--large ui_btn--bg_magenta" id="submit_bank_change" disabled>登録・変更</button></li>
			</ul>
		</div>
	</form>
</div>
<script>
$(function(){
	/*------------------------------------------*/
	// change button enable / disable
	/*------------------------------------------*/
	$('#form_bank_account input').on('change', function(){
		var scope = $(this).closest('form');
		var disabled = false;
		$('input', scope).each(function(){
			if($(this).val() == ''){
				disabled = true;
			}
		});
		if(disabled){
			$('#submit_bank_change', scope).prop('disabled', true);
		}else{
			$('#submit_bank_change', scope).prop('disabled', false);
		}
	});
	$("#form_bank_account input").each(function(){
		$(this).bind('keyup',keycheck(this));
	});
	function keycheck(elm){
		var v, old = elm.value;
		return function(){
			if(old != (v=elm.value)){
				old = v;
				str = $(this).val();
				if(str == ''){
					$('#submit_bank_change').prop('disabled', true);
				}else{
					var disabled = false;
					var id = '#'+$(this).attr('id');
					$('#form_bank_account input:not('+id+')').each(function(){
						if($(this).val() == ''){
							disabled = true;
						}
					});
					if(disabled){
						$('#submit_bank_change').prop('disabled', true);
					}else{
						$('#submit_bank_change').prop('disabled', false);
					}
				}
			}
		}
	}
	/*------------------------------------------*/
	// confirm dialog
	/*------------------------------------------*/
	$('#submit_bank_change').on('click', function(e){
		$('.ui_msg').hide();
		e.preventDefault();
		if($(this).prop('disabled') == true || $(this).hasClass('disabled') == true){
			return;
		}
		var upload_action = base_url + "user/profile_change/do_user_recruits_validation_pc";
		$('#form_bank_account').ajaxSubmit({
		    type:'post',
		    url: upload_action,
		    dataType: 'json',
		    success: function(res, statusText, xhr, $form) {
		    	if (!res.error) {
					$.each (res.error_ar, function(i, val) {
   						$('.error_' + i).html(val).show();
					});
		    	} else {
					var modal_conf = $('<div>').dialog(modal_setting);
					modal_conf.dialog('option', {
						title: '登録・変更します',
						buttons: [
							{
								text: 'いいえ',
								class: 'btn-gray',
								click: function(){
									$(this).dialog('close');
								}
							},
							{
								text: 'はい',
								class: 'btn-t_green',
								click: function(){
									$(this).dialog('close');
									/* update data */
									var upload_action = base_url + "user/profile_change/do_user_recruits_change_pc";
									$('#form_bank_account').ajaxSubmit({
									    type:'post',
									    url: upload_action,
									    dataType: 'json',
									    success: function(res, statusText, xhr, $form) {
											var modal_comp = $('<div>').dialog(modal_setting);
											modal_comp.dialog('option', {
												title: '登録・変更が完了しました',
												buttons: [
													{
														text: 'OK',
														class: 'btn-t_green',
														click: function(){
                                                            <?php 
                                                            //if user from external then redirect to external site
                                                            if (isset($external_ref)) {
                                                            ?>
                                                                window.location = '<?php echo $external_ref; ?>';
                                                            <?php } ?>
															$(this).dialog('close');
														}
													}
												]
											});
											modal_comp.html('').dialog('open');
									    }
									});
									
								}
							}
						]
					});
					modal_conf.html('よろしいですか？').dialog('open');
		    	}
		    }
		});

	});
});
</script>
<h3><span>基本設定</span></h3>
        <div class="error_message_box"></div>
<div class="settings_basic_data">
	<form method="post" action="#" name="form_user_change" id="form_user_change">
		<input type="hidden" value="do_user_change" name="do_user_change">
		<dl class="basic_address">
			<dt><span>メールアドレス</span></dt>
			<dd>
				<div class="ui_msg ui_msg-error error_email_address" style="display:none;"></div>
				<p>
					<input id="email_address" type="email" name="email_address" placeholder="メールアドレス" value="<?php echo set_value('email_address',$Uniqueid['email_address']); ?>">
				</p>
			</dd>
		</dl>
		<dl class="basic_password">
			<dt><span>現在のパスワード</span></dt>
			<dd>
				<div class="ui_msg ui_msg-error error_oldpassword" style="display:none;"></div>
<!--				<p>********************</p>  -->
				<p><input id="oldpassword" type="password" class="size_max" name="oldpassword" placeholder="現在のパスワード" /></p>
				<small>※セキュリティ上表示できません</small>
			</dd>
		</dl>
		<dl class="basic_new_password">
			<dt><span>新パスワード</span></dt>
			<dd>
				<div class="ui_msg ui_msg-error error_newpassword" style="display:none;"></div>
				<p>
					<input id="newpassword" type="password" name="newpassword" placeholder="新しパスワードを入力…" value="">
				</p>
				<small>※半角英数字4文字以上20文字以内</small>
			</dd>
		</dl>
		<dl class="basic_new_password_conf">
			<dt><span>新パスワードを確認</span></dt>
			<dd>
				<div class="ui_msg ui_msg-error error_confirmpassword" style="display:none;"></div>
				<p>
					<input id="confirmpassword" type="password" name="confirmpassword" placeholder="確認用でもう一度新しパスワードを入力…" value="">
				</p>
			</dd>
		</dl>
		<dl class="basic_id">
			<dt><span>ユーザーID</span></dt>
			<dd>
				<p><?php echo set_value('name',($Uniqueid['unique_id'])); ?></p>
				<small>※ユーザーIDは変更できません</small>
				<small>※このidは求人サービスを利用される際に必要です。</small>
			</dd>
		</dl>
		<div class="btn_wrap t_center m_t_20">
			<ul>
				<li><button class="ui_btn ui_btn--large ui_btn--bg_magenta" id="submit_user_change" disabled>登録・変更</button></li>
<!--                <li><a class="ui_btn ui_btn--large ui_btn--bg_magenta" href="javascript:void(0)" id="submit_user_change">登録・変更</a></li>  -->
			</ul>
		</div>
	</form>
</div>
<script>
$(function(){
	$('.ui_msg').hide();
	/*------------------------------------------*/
	// change button enable / disable
	/*------------------------------------------*/
	$("#form_user_change input").each(function(){
		$(this).bind('keyup',keycheck(this));
	});
	function keycheck(elm){
		var v, old = elm.value;
		return function(){
			if(old != (v=elm.value)){
				old = v;
				str = $(this).val();
				if(str == ''){
					$('#submit_user_change').prop('disabled', true);
				}else{
					var disabled = false;
					var id = '#'+$(this).attr('id');
					$('#form_user_change input:not('+id+')').each(function(){
						if($(this).val() == ''){
							disabled = true;
						}
					});
					if(disabled){
						$('#submit_user_change').prop('disabled', true);
					}else{
						$('#submit_user_change').prop('disabled', false);
					}
				}
			}
		}
	}

	$('#form_user_change input').on('focus blur', function(){
		var disabled = false;
		$('#form_user_change input').each(function(){
			if($(this).val() == ''){
				disabled = true;
			}
		});
		if(disabled){
			$('#submit_user_change').prop('disabled', true);
		}else{
			$('#submit_user_change').prop('disabled', false);
		}
	});
	/*------------------------------------------*/
	// confirm dialog
	/*------------------------------------------*/
	$('#submit_user_change').on('click', function(e){
		$('.ui_msg').hide();
		e.preventDefault();
		if($(this).prop('disabled') == true || $(this).hasClass('disabled') == true){
			return;
		}

		var upload_action = base_url + "user/profile_change/do_user_validation_pc";
		$('#form_user_change').ajaxSubmit({
		    type:'post',
		    url: upload_action,
		    dataType: 'json',
		    success: function(res, statusText, xhr, $form) {
			    	console.dir(res);
		    	if (!res.error) {
					$.each (res.error_ar, function(i, val) {
   						$('.error_' + i).html(val).show();
					});
		    	} else {
		    		$('.error_message_box').html('');
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
							        var upload_action = base_url + "user/profile_change/do_user_change_pc";
							        $('#form_user_change').ajaxSubmit({
							            type:'post',
							            url: upload_action,
							            dataType: 'json',
							            success: function(res, statusText, xhr, $form) {
							                if (res.success) {
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
							                } else {
							                	$('error_message_box').html(res.validation);
							                }
							            }
							        });

								}
							}
						]
					});
					modal_conf.html('よろしいですか？').dialog('open');
		    	}
			return false;
		    }
		});

	});
});
</script>
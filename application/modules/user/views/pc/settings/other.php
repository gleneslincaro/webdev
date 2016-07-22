<h3>
	<span>その他設定</span>
	<span class="ttl_note">※この情報は求人サービスを利用される際に必要です。</span>
</h3>
<div class="settings_identification_data">
	<form method="post" name="form_age_verification" id="form_age_verification" enctype="multipart/form-data">
		<input type="hidden" value="do_form_age_verification" name="do_form_age_verification">
		<input type="hidden" value="0" name="linkid">
		<div class="settings_inner">
			<h4>ご本人様確認</h4>
			<h5>身分証明書<span class="ml_30">※交通費・体験入店申請の際に必要です。</span></h5>
			<input type="file" accept="image/jpg/jpeg/png" name="img" style="display:none;" id="select_file_hide">
			<ul class="select_file_wrap">
				<li><a href="javascript:void(0);" class="select_file" id="select_file">ファイルを選択</a></li>
				<li id="select_file_txt">選択されていません</li>
			</ul>
			<div class="btn_wrap t_center m_t_40">
				<ul>
					<li><button class="ui_btn ui_btn--large ui_btn--bg_magenta disabled" id="submit_identification">身分証明書の提出</button></li>
				</ul>
			</div>
			<ul class="m_t_20">
				<li class="t_center"> <a class="t_link" href="mailto:info@joyspe.com?subject=joyspe年齢認証&amp;body=撮っていただいたお写真を添付しそのままお送りくださいませ"> &gt;&gt; 年齢認証メールを送る &lt;&lt; </a> </li>
			</ul>
		</div>
	</form>
	<form method="post" id="form_transfer_change" name="form_transfer_change">
		<input type="hidden" value="do_transfer_change" name="do_transfer_change">
		<div class="settings_notice_data m_t_50">
			<div class="settings_inner">
				<h4>お知らせ通知設定</h4>
				<h5>登録メールアドレスへ転送</h5>
				<ul class="mail_transfer">
					<li>
						<label>
                            <input type="radio" name="set_send_mail" value="1" <?php echo set_radio('set_send_mail','1'); ?> <?php if ($radiosetsendmail['set_send_mail'] == 1) echo "checked"; ?>>
							転送する	</label>
					</li>
					<li>
						<label>
                            <input type="radio" name="set_send_mail" value="0" <?php echo set_radio('set_send_mail','0'); ?> <?php if ($radiosetsendmail['set_send_mail'] == 0) echo "checked"; ?>>
							転送しない</label>
					</li>
				</ul>
				<div class="btn_wrap t_center m_t_20">
					<ul>
						<li><button class="ui_btn ui_btn--large ui_btn--bg_magenta" id="submit_notice_change">登録・変更</button></li>
					</ul>
				</div>
			</div>
		</div>
	</form>
</div>
<script>
$(function(){
	$("#select_file").on("click",function(){
		$("#select_file_hide").click();
	});
	$("#select_file_hide").on("change",function(){
		var file = this.files[0];
		if(file != null) {
			$("#select_file_txt").text(file.name);
			$('#submit_identification').removeClass('disabled');
		} else{
			$("#select_file_txt").text("選択されていません");
			$('#submit_identification').addClass('disabled');
		}
		
	});

	$('#submit_identification').on('click', function(e){
		e.preventDefault();
		if($(this).prop('disabled') == true || $(this).hasClass('disabled') == true){
			return;
		}
		var modal_conf = $('<div>').dialog(modal_setting);
		modal_conf.dialog('option', {
			title: '身分証明書を提出します。',
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
						var upload_action = base_url + "user/profile_change/do_certificate_pc";
						$('#form_age_verification').ajaxSubmit({
							type:'post',
							url: upload_action,
							dataType: 'json',
							success: function(res, statusText, xhr, $form) {
								if (!res.success) {
									$('.error_message_box').html(res.error_message);
								} else {
									$('.error_message_box').html('');
									var modal_comp = $('<div>').dialog(modal_setting);
									modal_comp.dialog('option', {
										title: '身分証明書の提出が完了しました',
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

							}
						});
					}
				}
			]
		});
		modal_conf.html('よろしいですか？').dialog('open');
	});
	/*------------------------------------------*/
	// confirm dialog
	/*------------------------------------------*/
	$('#submit_notice_change').on('click', function(e){
		e.preventDefault();
		if($(this).prop('disabled') == true || $(this).hasClass('disabled') == true){
			return;
		}
		var modal_conf = $('<div>').dialog(modal_setting);
		modal_conf.dialog('option', {
			title: '登録メールアドレスへ転送、登録・変更します',
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
						var upload_action = base_url + "user/profile_change/do_transfer_change_pc";
						$('#form_transfer_change').ajaxSubmit({
							type:'post',
							url: upload_action,
							dataType: 'json',
							success: function(res, statusText, xhr, $form) {
								if (!res.success) {
									$('.error_message_box').html(res.error_message);
								} else {
									$('.error_message_box').html('');
									var modal_comp = $('<div>').dialog(modal_setting);
									modal_comp.dialog('option', {
										title: '登録・変更が完了しました',
										buttons: [
											{
												text: 'OK',
												class: 'btn-t_green',
												click: function(){
													$(this).dialog('close');
												}
											}
										]
									});
									modal_comp.html('').dialog('open');
                                    <?php 
                                    //if user from external then redirect to external site
                                    if (isset($external_ref)) {
                                    ?>
                                        window.location = '<?php echo $external_ref; ?>';
                                    <?php } ?>
								}
							}
						});
					}
				}
			]
		});
		modal_conf.html('よろしいですか？').dialog('open');
	});
});
</script>
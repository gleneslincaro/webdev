<link rel="stylesheet" href="<?php echo base_url(); ?>public/owner/css/jquery-ui_new.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo base_url(); ?>public/owner/css/component.css?v=20150603" type="text/css" media="screen" />
<script type="text/javascript" src="<?php echo base_url() ?>public/owner/js/jquery-ui.js"></script>
<script type="text/javascript">
		$(document).ready(function() {
			// ESCAPE key pressed
			$(document).keydown(function(e)
			{
					if (e.which == 27) {
						 $('#dialog-form').dialog('destroy');
					}
			});

			$('#dialog-form').hide();
			$("#th7").addClass("visited");

			$('.user-image').bind('contextmenu', function(e){
				return false;
			});

			$('.read_message').click(function() {
				$(this).removeClass('inbox_not_read');
				$(this).addClass('inbox_is_read');
				$(this).children('div').children('.user_info').children('.user_title').children('')
															.children('img[src="<?php echo base_url()."public/owner/images/mail_icon_midoku.gif"; ?>"]')
															.attr("src","<?php echo base_url()."public/owner/images/mail_icon_kidoku.gif"; ?>");
					$.ajax({
							url:  '<?php echo base_url(); ?>owner/inbox/getUnreadMsgNo',
							type: 'post'
					}).done(function(data) {
							var unreadCount = Number(data);
							if (unreadCount != NaN) {
								if (unreadCount == 0){
										$('#newmsg_no').hide();
								} else {
										$('#newmsg_no').show().html(unreadCount);
								}
							}

					});
			});

			$('#dialog-form2').dialog({
				autoOpen: false,
				modal: true,
				buttons: {
						'送信': function() {
								$(this).dialog('close');
								var checked = $("[name=public_flag]").prop("checked");
								var public_flag = (checked)? 1:0;
								$('#sort_in_progress').show();
								$("#dialog-form").dialog('close');
								var current_window =  window.location.href;
								$.post("<?php echo base_url(); ?>owner/inbox/saveOwnerMessage", {
									user_id: $("#user_id").val(),
									none_member_id: $("#none_member_id").val(),
									orgin_msg_id: $("#orgin_msg_id").val(),
									message: $('#reply_message').val(),
									title: $('#user_title').val(),
									signature: $('#insert_signature').val(),
									public_flag:public_flag
								},function(data) {
									$('#sort_in_progress').hide();
									$("#dialog-form").dialog('close');
									if (data == true || data == 'true') {
											alert('メッセージを送信しました。');
												window.location.href = current_window;
									} else {
											alert('メッセージを送信しませんでした。');
									}
								});
						},
						'キャンセル': function() {
								$(this).dialog('close');
						},
				}
			});
		});

		function read_message(msg_id, user_id, nmu_id) {
			$.post("<?php echo base_url(); ?>owner/inbox/displayMessageContent", { msg_id: msg_id , user_id: user_id, nmu_id: nmu_id}, function(data) {
				$('#dialog-form').css('height','0px');
				$('#dialog-form').html(data);
				$("#dialog-form").dialog({
						 width: $('#container').width(),
						 modal: true,
						 closeOnEscape: true,
					});

				$('#reply_message_container').hide();
			});
		}

		function close_dialog() {
			$("#dialog-form").dialog('close').dialog('destroy');
		}

		function reply_message() {
			$('#validateTips').hide();
			$('#reply_button').hide();
			//var height = $('#dialog-form').height() + 155;
			//$('#dialog-form').css('height', height);
			$('#reply_message_container').show();
		}

		function reply_message_send() {
			var reply_message = $('#reply_message').val();
			reply_message = $.trim(reply_message);
			if (reply_message.length > 0) {
				$('#dialog-form2').dialog('open');
			} else {
				$('#validateTips').show();
			}
		}

</script>

<div class="crumb">TOP ＞ 受信ボックス</div>
<!--
<div class="owner-box">
	<?php echo $owner_data['storename']; ?>　様　ポイント：<?php echo number_format($owner_data['total_point']); ?>pt　<img src="<?php echo base_url(); ?>public/owner/images/point-icon.png" width="13" height="13" alt="ポイントアイコン"><a href="<?php echo base_url() . 'owner/settlement/settlement' ?>" target="_blank">ポイント購入</a>
</div>
-->
<br >
<div class="list-box section--owner_inbox">
	<div class="list-title">お問い合わせ履歴</div>
	<div class="contents-box-wrapper">
	<div id="dialog-form"></div>
	<div id="dialog-form2" title="確認">
	    <p>この内容で送信しますか？</p>
		<input type="checkbox" name="public_flag" value="1" checked="checked">公開する<br>
	    <span style="color:#F00; ">(全ユーザーが閲覧できるものとします。)</span>
	</div>
		<?php if(isset($inbox) && count($inbox) > 0): ?>
				<?php foreach($inbox as $value):?>
				<ul>     
						<li class="inbox read_message <?php echo ($value['is_read_flag'] == 1)?"fbolder inbox_not_read":"inbox_is_read"; ?>" onclick="read_message(<?php echo $value['id']; ?>, <?php echo $value['user_id']; ?>, <?php echo $value['none_member_id']; ?>)" >
								<div class="f_left">
										<img class="user-image f_left mr_10" src="<?php
												$data_from_site = $value['user_from_site'];
												if ( $value['profile_pic'] ){
														 $pic_path = getcwd()."/".$this->config->item('upload_userdir').'images/'.$value['profile_pic'];
														if ( file_exists($pic_path) ){
																$src = base_url().$this->config->item('upload_userdir').'images/'.$value['profile_pic'];
														}else{
																if ( $data_from_site == 1 ){
																		$src = $this->config->item('machemoba_pic_path').$value['profile_pic'];
																}else{
																		$src = $this->config->item('aruke_pic_path').$value['profile_pic'];
																}
														}
														echo $src;
												}else{
														echo base_url().'/public/user/image/no_image.jpg';
												}
										?>" height="90" alt="">
										<div class="f_left user_info">
												<p>
														<?php echo ($value['unique_id']? $value['unique_id'] : "非会員"); ?> <span class="f_right">
														<a href="<?php echo base_url().'owner/history/history_transmission/'.$value['user_id'].'/1'.'/'.$value['none_member_id']; ?>">送信履歴</a>
														<?php $date = date_create($value['created_date']); ?>
														<?php echo date_format($date, 'y/m/d H:i'); ?></span><br />
														<?php echo $value['city_name'];?> <br />
														<?php echo ($value['age_name1'])?$value['age_name1']."~".$value['age_name2']: "&nbsp;";?>
												</p>
												<p class="user_title">
														<img class="f_left mail_icon" src="<?php
														if ($value['is_replied_flag'] == 1){
															$icon_gif = "mail_icon_return.gif";
														}else if ($value['is_read_flag'] == 0){
															$icon_gif = "mail_icon_kidoku.gif";
														}else{
															$icon_gif = "mail_icon_midoku.gif";
														}
														echo base_url()."public/owner/images/".$icon_gif; ?>">
														<span class="ml10"><?php echo $value['title']; ?></span>
												</p>
										</div>
								</div>
						</li>
				</ul>
				<?php endforeach; ?>
		<?php else: ?>
				<div class="t_center">現在、ユーザーからのメッセージがありません。</div>
		<?php endif; ?>

		<div class="btn_box" style="text-align: center">
						<?php
						if ($totalpage > 1) {
								 ?>
								<!--<a data-sort="<?php echo (isset($sort))?$sort:''; ?>" href="<?php echo $first_link; ?>" onclick='return setSortBlue(this)' class="_pagination"><img style="border: 0" src="<?php echo base_url() . 'public/owner/images/btn_back.png' ?>" alt="前へ"></a>-->
								<?php echo $paging; ?>
								<!--<a data-sort="<?php echo (isset($sort))?$sort:''; ?>" href="<?php echo $last_link; ?>" onclick='return setSortBlue(this)' class="_pagination"><img style="border: 0" src="<?php echo base_url() . 'public/owner/images/btn_next.png' ?>" alt="次へ"></a>-->
						<?php
						}
						?>

				</div>
</div><!-- / .contents-box-wrapper -->
</div><!-- /.list-box -->
<?php
		$this->load->view('index/wait_for_sort');
?>

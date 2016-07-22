<?php $this->load->view('user/pc/header/header'); ?>
<section class="section--main_content_area">
	<div class="container p_b_50">
		<div class="box_white">
				<section class="section--info_detail">
						<h2 class="ttl_style_1">オファーメール</h2>
						<div class="box_white">
							<div class="info_detail_header">
									<dl>
										<dt>受信日時</dt>
										<dd><?php echo ($send_type == 1)?strftime("%Y/%m/%d %H:%M", strtotime($data['send_date'])):strftime("%Y/%m/%d %H:%M", strtotime($data['created_date'])); ?></dd>
									</dl>
									<dl>
										<dt>From</dt>
										<dd><?php echo ($send_type == 1)?(($data['user_message_status']==1)? $data['store_name']:"Joyspe"):$data['storename']; ?></dd>
									</dl>
							</div>
							<h3><?php echo ($send_type == 1)?$title:$data['title']; ?></h3>
							<div class="info_detail_massage">
									<?php if($send_type != 1): ?>
					                    <p><?php echo $data['unique_id'].' 様';?><br />
					                        いつもご利用ありがとうございます。 <br /><br />
					                        お問い合わせ頂いた店舗様から返信がありました。
					                    </p>
					                <?php endif; ?>
									<div class="stre_url">
										<?php if($send_type == 1) { echo $body; } else { echo nl2br($data['content']); } ;?>
									</div>
							</div>
						</div>
						<div class="btn_wrap m_t_30 m_b_30">
								<ul>
										<li> <a href="<?php if ($message_list == 1) { echo base_url() . 'user/message_list/0/'; } else { echo base_url() . 'user/message_list_garbage/0/'; } ?>" class="ui_btn ui_btn--large ui_btn--line ui_btn--line_gray ui_btn--c_gray">一覧へ戻る</a> </li>
										<li> <a href="<?php if ($message_list == 1) { echo base_url() . 'user/delete_message/' . $data['id'].'/'.$send_type.'/'; } else { echo base_url() . 'user/return_message/' . $data['id'].'/'; } ?>" class="ui_btn ui_btn--large ui_btn--line ui_btn--line_gray ui_btn--c_gray">メールを削除</a> </li>
								</ul>
						</div>
						<div class="go_to_store"><a href="<?php echo base_url() . 'user/joyspe_user/company/' . $data['ors_id'].'/'; ?>" class="ui_btn ui_btn--large ui_btn--line ui_btn--line_magenta ui_btn--c_magenta">店舗情報を見る</a></div>
						<!-- // .container --> 
				</section>
		</div>
	</div>
</section>
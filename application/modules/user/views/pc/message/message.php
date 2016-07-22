<?php $this->load->view('user/pc/header/header'); ?>
<section class="section--main_content_area">
	<div class="container p_b_50">
		<div class="box_white">

			<section class="section--message_list">
					<div class="box_head">
							<h2 class="ttl_stile_2">オファーメール</h2>
							<p class="cnt_txt"><span><strong><?php echo $count_all;?></strong>件</span></p>
					</div>
					<div class="box_head_btn">

							<div class="massage_box_btn <?php echo ($message_list == 1) ? '' : 'off'?>"><a href="<?php echo base_url().'user/message_list/'?>">受信一覧</a></div>
							<div class="garbage_box_btn <?php echo ($message_list == 1) ? 'off' : ''?>"><a href="<?php echo base_url() . 'user/message_list_garbage/'.$gettype; ?>/">ゴミ箱</a></div>
					</div>
					<?php if(count($data) > 0): ?>
					<div class="line_area">
						<form id='frmMessRecep' action="<?php if ($message_list == 1) { echo base_url() . 'user/user_messege/delete_messages/'; } else {  echo base_url() . 'user/user_messege/return_messages/'; }; ?>" method="post">
						<?php foreach ($data as $key => $val) : ?>
					       <ul class="offer_mail_list <?php echo (($val['is_read'] == "0" && $val['send_type'] == 1) || ($val['is_read'] == "1" && $val['send_type'] == 2))? '' :'read'; ?>">
								<li class="left_box cb_area">
									<label>
										<input class="clCheck" id="id-<?php echo $val['id']; ?>" name="cbkdel[]" type="checkbox" value="<?php echo $val['id'].':'.$val['send_type']; ?>">
									</label>
								</li>
								<li class="ttl_mail">
									<a href="<?php echo base_url() . 'user/message_detail/' . $val['id'].'/'.$val['send_type'].'/'.$message_list; ?>/">
			                        	<p class="title"><?php echo $chuoi[$key]; ?></p>
			                        	<p class="datetime"><?php echo strftime("%Y/%m/%d %H:%M", strtotime($val['send_date'])); ?></p>
				                        <p class="from">
				                            <?php
				                                if ($val['user_message_status']==1) {
				                                    echo $val['store_name'];
				                                }
				                                else {
				                                    echo "Joyspe";
				                                }
				                            ?>
				                        </p>
			                    	</a>
								</li>
							</ul>
					    <?php endforeach; ?>
					    </form>
					</div>
					<?php else:?>
					<p>受信メールがありません。</p>
					<?php endif;?>
					<div class="delete_btn"><a href="javascript:void(0)" class="ui_btn ui_btn--large ui_btn--line ui_btn--line_gray ui_btn--c_gray" onclick="doCheck();"><?php echo ($message_list == 1)? '選択したメールを削除' : '選択したメールを受信一覧に戻す' ;?></a></div>
			</section>
			<div class="ui_pager">
					<ul>
							<?php echo $page_links;?>
					</ul>
			</div>

		</div>
		<!-- // .box_white -->
	</div>
	<!-- // .container -->

</section>

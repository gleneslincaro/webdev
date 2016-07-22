<?php $this->load->view('user/pc/header/header'); ?>
<style type="text/css">
	.display_none {
		display: none;
	}

</style>
<section class="section--main_content_area">
	<div class="container cf">
		<div class="box_white">
			<section class="section--contact">
				<form id="form_inquiry" method="post">
					<div class="infomation">
						<h2 class="ttl_style_1">お問い合わせ</h2>
						<dl class="form_style_1">
							<?php echo form_error('uname');?>
							<dt>お名前（ニックネーム）</dt>
							<dd>
								<input type="<?php echo (isset($confirm)? "hidden":"text"); ?>" name="uname" value="<?php echo set_value("uname"); ?>" placeholder="例）Joyspe 花子" required="" class="size_max">
								<?php if (isset($confirm)) : ?>
									<p class="sub_txt"><?php echo set_value("uname"); ?></p>
								<?php else:?>
									<p class="sub_txt">（全角15文字/半角30文字以内）</p>
								<?php endif;?>
							</dd>
							<?php echo form_error('age');?>
							<dt>年齢</dt>
							<dd>
								<?php if (isset($confirm)) : ?>
									<p class="sub_txt"><?php echo set_value("age"); ?><input type="hidden" name="age" value="<?php echo set_value("age"); ?>"></p>
								<?php else : ?>
									<select name="age" class="select_grey">
				                        <?php for ($i=18; $i <= 100; $i++) : ?>
				                        <option><?php echo $i;?></option>
				                        <?php endfor; ?>
				                    </select>
				                    <p class="sub_txt">（18最未満・高校生の応募はできません）</p>
				                <?php endif; ?>

							</dd>
							<?php echo form_error('contact');?>
							<dt>メールアドレス</dt>
							<dd>
								<input type="<?php echo (isset($confirm)? "hidden":"text"); ?>" name="contact"  value="<?php echo set_value("contact"); ?>" placeholder="例）Joyspe@co.jp" required="" class="size_max">
								<?php if (isset($confirm)) : ?>
				                    <p class="sub_txt"><?php echo set_value("contact"); ?></p>
				                <?php else : ?>
				                    <p class="sub_txt">(連絡先を知られずにやり取りができます)</p>
				                <?php endif; ?>
							</dd>
							<?php echo form_error('storname');?>
							<dt>店舗名</dt>
							<dd>
								<input type="<?php echo (isset($confirm)? "hidden":"text"); ?>" name="storname" value="<?php echo $ownerRecruitInfo['storename']; ?>" readonly  class="size_max">
								<?php if (isset($confirm)) : ?>
				                    <p class="sup_contact"><?php echo set_value("storname"); ?></p>
				                <?php endif; ?>
							</dd>
							<?php echo form_error('user_title');?>
							<dt>件名</dt>
							<dd>
								 <?php if (isset($confirm)) : ?>
								 	<?php echo set_value("user_title"); ?><input type="hidden" name="user_title" value="<?php echo set_value("user_title"); ?>">
								 <?php else:?>
								 	<select id="user_title" name="user_title" class="messege_width100 messege_width100_a select_grey">
				                        <option selected="" value="質問">質問</option>
				                        <option value="応募">応募</option>
				                        <option value="面接依頼">面接依頼</option>
				                        <option value="その他">その他</option>
				                    </select>
								 <?php endif;?>

							</dd>
							<?php echo form_error('mess');?>
							<dt>聞きたいこと</dt>
							<dd>
								<p <?php echo (isset($confirm)? 'class="sub_txt"' : ""); ?>><?php echo nl2br(set_value("mess")); ?><textarea <?php echo (isset($confirm) ? "class=display_none size_max" : "class=size_max"); ?> name="mess" placeholder="例）未経験なんですが、1日のお給料はどのくらい稼げますか？"><?php echo set_value("mess"); ?></textarea></p>
				                <?php if (!isset($confirm)) : ?>
				                    <p class="sub_txt">（全角500文字/半角1000文字以内）</p>
				                <?php endif; ?>
							</dd>
						</dl>
					</div>
					<div class="btn_wrap m_t_20">
						<ul>
							<li>
								<?php if (isset($confirm)) : ?>
			                        <button onclick="window.history.back()" class="ui_btn ui_btn--large ui_btn--line ui_btn--line_gray ui_btn--c_gray">戻る</button>
			                        <button type="submit" id="btn_send" class="ui_btn ui_btn--large ui_btn--line ui_btn--line_magenta ui_btn--c_magenta">送信する</button>
			                    	<input type="hidden" name="send_mail" value="send">
			                    <?php else : ?>
			                        <button type="submit" id="btn_send" class="ui_btn ui_btn--large ui_btn--line ui_btn--line_magenta ui_btn--c_magenta">送信する</button>
			                    <?php endif; ?>
							</li>
						</ul>
					</div>
					<div class="comment">
						営業日：平日（土日祝日を除く）<br>
						営業時間：12:00～18:00<br>
						登録メールが届かない場合<br>
						セキュリティ設定のためユーザー受信拒否と認識されているか、お客様が迷惑メール対策等で、ドメイン指定受信を設定されている場合に、メールが正しく届かないことがございます。<br>
						以下のドメインを受信できるように設定してください。<br>
						@joyspe.jp
					</div>
					<!-- // .container -->
				</form>
			</section>
		</div>
	</div>
</section>

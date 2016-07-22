<section class="section section--store_application cf">
    <div class="section_inner">
        <div class="store_application">
            <h3>応募・お問い合わせ連絡先</h3>
			<div class="application_block">
				<ul>
					<li>
						<a href="javascript:void(0)" class="contact_tel" data-href="tel:<?php echo $data['apply_tel']; ?>"><span class="icon_wrap"><span class="icon--phone icons"><img src="<?php echo base_url(); ?>public/user/image/icon_phone.png"></span><span class="item">電話</span></span></a>
					</li>
				</ul>
			</div>
			<div class="application_block">
				<ul>
					<li>
						<?php echo $apply_email_address; ?>
					</li>
				</ul>
			</div>
			<div class="application_block ask_area">
				<ul>
					<li>
						<a href="javascript:void(0)" class="anonymous_ask"><span class="icon_wrap"><span class="icon--question icons"><img src="<?php echo base_url(); ?>public/user/image/icon_question.png"></span><span class="item">匿名質問</span></span></a>
					</li>
				</ul>
				<?php if($login_flag && $count_exchange_conversation > 0): ?>
				<ul class="many_ask">
					<li>
						<a href="<?php echo '/user/joyspe_user/history_inquiry/'.$ors_id?>">
							<span class="icon_wrap t_center">やりとり回数:<span id='count_conversation'><?php echo $count_exchange_conversation;?></span>回</span>
						</a>
					</li>
				</ul>
				<p class="caution">※直アドじゃないから匿名性が保たれます</p>
	            <?php endif; ?>
			</div>

			<div class="application_block">
				<?php if ($data['line_url'] || $data['line_id']): ?>
				<dl>
					<dt><span class="icon--line icons"><img src="/public/user/image/icon_line.png"></span>IDをコピー</dt>
					<dd><a href="javascript:void(0)" class="contact_line" data-href="<?php echo $data['line_url']; ?>">
						<span class="item"><input class="line_id" type="text" value="<?php echo $data['line_url'] ? '友だち追加':"" . $data['line_id']; ?>" onfocus="this.selectionStart=0; this.selectionEnd=this.value.length;" onmouseup="return false"></span>
					</a></dd>
				</dl>
				<?php endif ?>
			</div>
        </div>
    </div>
</section>

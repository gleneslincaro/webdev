<?php
if (isset($new_mail_flag)) { ?>
<section class="section--notification m_b_20">
	<div class="new_scout_mail">
		<ul>
			<li><a class="new" href="<?php echo base_url() . 'user/message_list/' ?>"><span class="blink_text">スカウトメッセージが届いています！</span></a></li>
		</ul>
	</div>
</section>
<?php }?>

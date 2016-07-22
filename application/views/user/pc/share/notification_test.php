<section class="section--notification m_b_20">

	<div class="new_scout_mail">
		<ul>
		<?php
		$countScout = HelperGlobal::checkscoutmail(UserControl::getId());
		if($countScout['quantity']!=0){?>
			<li><a class="new" href="<?php echo base_url() . 'user/message_list/' ?>"><span>スカウトメッセージが届いています！</span></a></li>
		<?php }?>

		</ul>
	</div>
</section>

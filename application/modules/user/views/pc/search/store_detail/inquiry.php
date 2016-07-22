

<div class="inquiry box_gray">
	<h3 class="sub_ttl ic ic-anonymous">匿名質問</h3>
	<small>※直アドじゃないから匿名性が保たれます。</small>
	<div class="col_wrap">
		<div class="col_left">
<!--			<a href="javascript:void(0)" class="ui_btn ui_btn--bg_black ui_btn--large anonymous_ask">質問する</a>  -->
		<?php if($login_flag): ?>
			<a href="<?php echo base_url() . 'user/inquiry_user/' . $ors_id ?>" class="ui_btn ui_btn--bg_black ui_btn--large anonymous_ask">質問する</a>
		<?php else: ?>
			<a href="<?php echo base_url() . 'user/inquiry/' . $ors_id ?>" class="ui_btn ui_btn--bg_black ui_btn--large anonymous_ask">質問する</a>
		<?php endif; ?>
		</div>
		<?php if($login_flag && $count_exchange_conversation > 0): ?>
		<div class="col_right">
			<p class="cnt"><a href="<?php echo '/user/joyspe_user/history_inquiry/'.$ors_id?>">やりとり回数：<em><?php echo $count_exchange_conversation;?></em>&nbsp;回</a></p>
		</div>
		<?php endif; ?>
	</div>
</div>

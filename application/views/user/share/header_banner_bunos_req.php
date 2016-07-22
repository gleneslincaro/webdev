<?php if (isset($banner_bonus_req) && $banner_bonus_req) : ?>
<?php if ( 0 ) { ?>

<div id="banner" class="border_1 mb_20 t_center">
	<p>体験入店お祝い金キャンペーン<br />
		体験入店をすると、ジョイスペから<br />
		<?php echo (isset($banner_bonus_req['bonus_money']))?$banner_bonus_req['bonus_money']:0; ?>円の交通費を支給中！</p>
	<div class="t_center"> <a href="<?php echo base_url(); ?>user/contact#bonus_request"> <img class="width_98p" src="<?php echo base_url().$banner_bonus_req['banner_path']; ?>"> </a> </div>
	<p>※キャンペーンは予告なく終了する場合はがございます。</p>
</div>
<?php } else { ?>
<div class="t_center p_02p1em2p"> <a href="<?php echo base_url(); ?>user/contact#trial_work"> <img class="width_100p" src="<?php echo base_url().$banner_bonus_req['banner_path']; ?>"> </a> </div>
<?php } ?>
<?php endif; ?>

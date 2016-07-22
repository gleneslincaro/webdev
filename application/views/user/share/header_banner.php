<?php if ( 0 ) { ?>
<div id="banner" class="border_1 mb_20 t_center">
  <p>面接応援キャンペーン<br />面接に行くとジョイスペから<br /><?php echo (isset($banner_data['travel_expense']))?$banner_data['travel_expense']:0; ?>円の交通費を支給中！</p>
  <div class="t_center">
      <a href="<?php echo base_url(); ?>user/contact#travel_expense">
          <img class="width_98p" src="<?php echo base_url().$banner_data['banner_path']; ?>">
      </a>
  </div>
  <p>※キャンペーンは予告なく終了する場合はがございます。</p>
</div>
<?php } else { ?>
<div class="p_2p t_center">
    <a href="<?php echo base_url(); ?>user/contact#travel_expense">
      <img class="width_100p" src="<?php echo base_url().$banner_data['banner_path']; ?>">
    </a>
</div>
<?php } ?>

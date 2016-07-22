<section class="section--heading_area">
	<h1><img src="<?php echo base_url(); ?>public/user/pc/image/heading_logo.png" width="685" height="246" alt="安心・安全、毎日がお給料日！風俗求人・高収入アルバイト情報ジョイスペ" /></h1>
</section>
<section class="section--area_map">
	<div class="area_map">
		<div class="area_map_layer" id="area_map_layer"><div></div></div>
		<ul class="area_map_navi">
			<li class="hokkaido"><a href="<?php echo base_url(); ?>user/jobs/<?php echo $city_group[0]['alph_name']; ?>/" data-area="hokkaido">北海道・東北</a></li>
			<li class="kitakanto"><a href="<?php echo base_url(); ?>user/jobs/<?php echo $city_group[2]['alph_name']; ?>/" data-area="kitakanto">北関東</a></li>
			<li class="kanto"><a href="<?php echo base_url(); ?>user/jobs/<?php echo $city_group[1]['alph_name']; ?>/" data-area="kanto">関東</a></li>
			<li class="hokuriku"><a href="<?php echo base_url(); ?>user/jobs/<?php echo $city_group[3]['alph_name']; ?>/" data-area="hokuriku">北陸・甲信越</a></li>
			<li class="tokai"><a href="<?php echo base_url(); ?>user/jobs/<?php echo $city_group[4]['alph_name']; ?>/" data-area="tokai">東海</a></li>
			<li class="kansai"><a href="<?php echo base_url(); ?>user/jobs/<?php echo $city_group[5]['alph_name']; ?>/" data-area="kansai">関西</a></li>
			<li class="shikoku"><a href="<?php echo base_url(); ?>user/jobs/<?php echo $city_group[6]['alph_name']; ?>/" data-area="shikoku">中国・四国</a></li>
			<li class="kyushu"><a href="<?php echo base_url(); ?>user/jobs/<?php echo $city_group[7]['alph_name']; ?>/" data-area="kyushu">九州・沖縄</a></li>
		</ul>
	</div>
</section>
<section class="section--prefectures_list m_t_40 m_l_30">
    <?php foreach ($getCity as $key => $value) : ?>
	<dl>
		<dt class="toptext_<?php echo $value['alph_name']; ?>"><a href="<?php echo base_url(); ?>user/jobs/<?php echo $value['alph_name']; ?>/"><?php echo $value['name']; ?></a></dt>
		<dd>
			<ul>
                <?php
            		$city_group_id = $value['id'];
    				foreach ($getCity[$key][$city_group_id] as $value1) :
                ?>
					<li><a href="<?php echo base_url(); ?>user/jobs/<?php echo $value['alph_name']; ?>/<?php echo $value1['alph_name']; ?>/"><?php echo $value1['name']; ?></a></li>
            	<?php endforeach; ?>
			</ul>
		</dd>
	</dl>
  	<?php endforeach; ?>
</section>
<script>
$(function(){
	// mouse enter
	$(".area_map_navi a").on('mouseenter',function(e){
		e.preventDefault();
		var area = $(this).attr('data-area');
		// change map hover
		$("#area_map_layer > div").removeClass();
		$("#area_map_layer > div").addClass(area);
		$("#area_map_layer").fadeIn(200);
	});
	// mouse leave
	$(".area_map_navi a").on('mouseleave', function(e){
		e.preventDefault();
		$("#area_map_layer").hide();
	});
});
</script>
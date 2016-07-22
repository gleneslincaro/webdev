<div class="page_wrap">
	<?php $this->load->view('user/pc/header/header'); ?>
	<div class="treatment_wrap">
		<div class="treatment image_area daily_payment">
			<h3 class="treatment_h"><?php echo $info_name; ?><span>の風俗求人</span></h3>
			<div class="dis_wrap">
				<div class="dis">
					<h3 class="treatment_sub_h ic"><?php echo nl2br($treatment_info['name']); ?>とは？</h3>
					<div class="box_inner">
						<p><?php echo $treatment_info['contents']; ?></p>
					</div>
				</div>
			</div>
			<figure><img src="<?php echo $image_area_path; ?>"> </figure>
		</div>
		<div class="treatment container cf">
			<div class="f_left">
				<section class="section--treatment">
					<article class="left_top_area m_b_30">
						<div class="column l">
							<ul>
								<li class="block s">
									<?php if ($treatment_info['contents2'] != '') : ?>
									<h4 class="type_h ic">こんな人におすすめ</h4>
									<div class="content_box type">
										<div class="box_inner">
											<?php echo nl2br($treatment_info['contents2']); ?>
<!--
											<ul>
												<li>{なんとしてでも今日中にお金が必要な人}</li>
												<li>{いつも手元にお金を持っていたい人}</li>
											</ul>
-->
										</div>
									</div>
									<?php endif; ?>
								</li>
								<li class="block s">
									<div class="column_inner">
										<?php if ($treatment_info['contents3'] != '') : ?>
										<h4 class="rec_job_h ic">おすすめ業種</h4>
										<div class="content_box rec">
											<div class="box_inner">
											<?php echo $treatment_info['contents3']; ?>
<!--
												<ul>
													<li>{デリヘル}</li>
													<li>{ホテヘル}</li>
													<li>{ファッションヘルス}</li>
													<li>{ソープ}</li>
													<li>{ピンサロ}</li>
													<li>{風俗全般}</li>
												</ul>
-->
											</div>
										</div>
										<?php endif; ?>
									</div>
								</li>
							</ul>
						</div>
						<div class="column r">
							<ul>
								<li class="block r">
									<article class="article--pre_search_detail">
										<h4 class="add_seach_h"><?php echo $treatment_info['name']; ?>で絞り込む</h4>
										<div class="prefectures_box">
											<div class="prefectures_detail">
												<?php foreach ($getCity as $key => $value) : ?>
												<dl>
													<dt class="toptext_<?php echo $value['alph_name']; ?>"><a href="<?php echo base_url(); ?>treatment_<?php echo $treatment; ?>/<?php echo $value['alph_name']; ?>/"><?php echo $value['name']; ?></a></dt>
													<dd>
														<ul>
														<?php
															$city_group_id = $value['id'];
															foreach ($getCity[$key][$city_group_id] as $value1) :
														?>
															<li><a href="<?php echo base_url(); ?>treatment_<?php echo $treatment; ?>/<?php echo $value['alph_name']; ?>/<?php echo $value1['alph_name']; ?>/"><?php echo $value1['name']; ?></a></li>
														<?php endforeach; ?>
														</ul>
													</dd>
												</dl>
												<?php endforeach; ?>
											</div>
										</div>
									</article>
								</li>
							</ul>
						</div>
					</article>
				</section>
			</div>
			<div class="f_right">
                <?php $this->load->view('user/pc/share/aside'); ?>
			</div>
		</div>
	</div>
	<?php //include './inc/footer.html'; ?>
</div>
</body>
</html>

<!--
<section class="section">
<div>
待遇
</div>
</section>
<section class="section--area_map">
	<div class="area_map">
		<div class="area_map_layer" id="area_map_layer"><div></div></div>
		<ul class="area_map_navi">
			<li class="hokkaido"><a href="<?php echo base_url(); ?>treatment_<?php echo $treatment; ?>/<?php echo $city_group[0]['alph_name']; ?>/" data-area="hokkaido">北海道・東北</a></li>
			<li class="kitakanto"><a href="<?php echo base_url(); ?>treatment_<?php echo $treatment; ?>/<?php echo $city_group[2]['alph_name']; ?>/" data-area="kitakanto">北関東</a></li>
			<li class="kanto"><a href="<?php echo base_url(); ?>treatment_<?php echo $treatment; ?>/<?php echo $city_group[1]['alph_name']; ?>/" data-area="kanto">関東</a></li>
			<li class="hokuriku"><a href="<?php echo base_url(); ?>treatment_<?php echo $treatment; ?>/<?php echo $city_group[3]['alph_name']; ?>/" data-area="hokuriku">北陸・甲信越</a></li>
			<li class="tokai"><a href="<?php echo base_url(); ?>treatment_<?php echo $treatment; ?>/<?php echo $city_group[4]['alph_name']; ?>/" data-area="tokai">東海</a></li>
			<li class="kansai"><a href="<?php echo base_url(); ?>treatment_<?php echo $treatment; ?>/<?php echo $city_group[5]['alph_name']; ?>/" data-area="kansai">関西</a></li>
			<li class="shikoku"><a href="<?php echo base_url(); ?>treatment_<?php echo $treatment; ?>/<?php echo $city_group[6]['alph_name']; ?>/" data-area="shikoku">中国・四国</a></li>
			<li class="kyushu"><a href="<?php echo base_url(); ?>treatment_<?php echo $treatment; ?>/<?php echo $city_group[7]['alph_name']; ?>/" data-area="kyushu">九州・沖縄</a></li>
		</ul>
	</div>
</section>
<section class="section--prefectures_list m_t_40 m_l_30">
    <?php foreach ($getCity as $key => $value) : ?>
	<dl>
		<dt class="toptext_<?php echo $value['alph_name']; ?>"><a href="<?php echo base_url(); ?>treatment_<?php echo $treatment; ?>/<?php echo $value['alph_name']; ?>/"><?php echo $value['name']; ?></a></dt>
		<dd>
			<ul>
                <?php
            		$city_group_id = $value['id'];
    				foreach ($getCity[$key][$city_group_id] as $value1) :
                ?>
					<li><a href="<?php echo base_url(); ?>treatment_<?php echo $treatment; ?>/<?php echo $value['alph_name']; ?>/<?php echo $value1['alph_name']; ?>/"><?php echo $value1['name']; ?></a></li>
            	<?php endforeach; ?>
			</ul>
		</dd>
	</dl>
  	<?php endforeach; ?>
</section>
-->
				<section class="section--search_tags m_b_20">
					<ul class="search_tags search_tags-area <?php echo $city; ?>">
					<?php
						$towns_name = array();
						for ($x = 0; $x < count($towns); $x++) {
							if (isset($towns_name[$towns_alph_name[$x]])) {
								$towns_name[$towns_alph_name[$x]] .= $towns[$x] . ',';
							} else {
								$towns_name[$towns_alph_name[$x]] = $towns[$x] . ',';
							}
						}
						foreach ($towns_name as $key => $value) :
					?>
						<li data-town="<?php echo $key; ?>"><?php echo trim($value, ','); ?></li>
					<?php endforeach; ?>
<!--					
						<li>池袋</li>
						<li>新宿</li>
						<li>歌舞伎町</li>
						<li>新大久保</li>
						<li>渋谷</li>
						<li>恵比寿</li>
						<li>五反田</li>
						<li>銀座</li>
						<li>錦糸町</li>
						<li>鶯谷</li>
						<li>上野</li>
						<li>秋葉原</li>
						<li>小岩</li>
						<li>新小岩</li>
						<li>高円寺</li>
						<li>吉祥寺</li>
						<li>町田</li>
						<li>立川</li>
-->						
					</ul>
                    <?php if (isset($cate_name) && $cate_name) : ?>
                    <ul class="search_tags search_tags-job_types">
                    <?php for ($x = 0; $x < count($cate_name); $x++) : ?>
                    <li data-job="<?php echo $cate_alph_name[$x]; ?>"><?php echo $cate_name[$x]; ?></li>
                    <?php endfor; ?>
                    </ul>
					<script>
					$(function(){
						var arr = ["<?php echo implode('","',$cate_alph_name);?>"];
						$.each(arr, function() {
							$('#check_job_type_'+this).prop("checked",true);
						});
					});
					</script>
                    <?php endif;?>
                    <?php if (isset($treatment_name) && $treatment_name) : ?>
                    <ul class="search_tags search_tags-treatments">
                        <?php for ($x = 0; $x < count($treatment_name); $x++) : ?>
                            <li data-treatment="<?php echo $treatment_alph_name[$x]; ?>"><?php echo $treatment_name[$x]; ?></li>
                        <?php endfor; ?>
                    </ul>
					<script>
					$(function(){
						var arr = ["<?php echo implode('","',$treatment_alph_name);?>"];
						$.each(arr, function() {
							$('#check_treatments_'+this).prop("checked",true);
						});
					});
					</script>
                    <?php endif;?>
				</section>

				<section class="section--search_find m_b_20 <?php echo $city; ?>">
					<h2><?php echo (count($towns) < 2) ? $town_info['name'].'の' : ''; ?>検索結果</h2>
					<?php if ($count_all > 0) : ?>
					<p class="cnt_txt"><span><strong><?php echo $count_all; ?></strong>件</span>見つかりました</p>
					<?php else: ?>
					<p class="cnt_txt"><span><strong>0</strong>件</span></p>
					<p class="empty_txt">検索内容を変更して再度検索してください。</p>
					<?php endif; ?>
				</section>
				<?php $this->load->view('user/pc/search_detail_refine'); ?>
				<?php $this->load->view('user/pc/store_list'); /* 店舗のリスト表示 */ ?>
				<?php //$this->load->view('user/pc/search_detail_refine'); ?>

	<section class="section--main_content_area">
		<div class="container cf">
			<section class="section--city_features">
			<ul class="m_b_20">
				<li><a href="<?php echo $back_url ?>" class="ui_btn ui_btn--bg_brown btn_back"><?php echo $town_info['name']; ?>求人へ戻る</a></li>
			</ul>
			<div class="features_area_box">
				<h3 class="ttl"><?php echo $town_info['name']; ?>の特徴</h3>
				<div class="desc_area">
					<?php 
						if (isset($town_contents) && $town_contents) {
							echo nl2br($town_contents); 
						}
					?>
				</div>
			</div>
			</section>
		</div>
		<!-- // .container --> 
	</section>
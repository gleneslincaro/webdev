<script type="text/javascript">    
    var group_city = '<?php echo $groupCity_info["id"];?>';
    var city = '<?php echo $city_info["id"];?>';
    var town = "<?php echo $arrTown;?>";
    var group_city_alph_name = '<?php echo $groupCity_info["alph_name"]; ?>';
    var city_info_alph_name = '<?php echo $city_info["alph_name"]; ?>';
    var base_url = "<?php echo base_url(); ?>";
</script>
<section class="section--search_detail section--search_detail_refine m_b_30">
	<form action="#">
		<h2 class="ttl_bar func_toggle" data-target=".search_detail" data-action="slide" data-speed="300"><i class="fa fa-search fa-fw"></i>さらに詳しく絞り込む<span class="ic_toggle"></span></h2>
		<div class="search_detail hide">
			<div class="section_inner">
<!--
				<div class="search_conditions search_conditions-area">
					<h3>エリア</h3>
					<dl>
						<dt>地域</dt>
						<dd>
							<select class="select_area">
								<option value="" selected>選択してください</option>
								<option value="1">北海道・東北</option>
								<option value="2">北関東</option>
								<option value="3">関東</option>
								<option value="4">北陸・甲信越</option>
								<option value="5">東海</option>
								<option value="6">関西</option>
								<option value="7">中国・四国</option>
								<option value="8">九州・沖縄</option>
							</select>
						</dd>
					</dl>
					<dl>
						<dt>都道府県</dt>
						<dd>
							<select class="select_prefecture">
								<option value="" selected>選択してください</option>
								<option value="1">北海道</option>
								<option value="2">青森</option>
								<option value="3">岩手</option>
							</select>
						</dd>
					</dl>
				</div>
-->
				<div class="search_conditions search_conditions-job_types">
					<h3>職種</h3>
					<ul>
					<?php foreach ($allJobType as $key => $value) : ?>
						<li>
							<input id="check_job_type_<?php echo $value['alph_name']; ?>" type="checkbox" value="<?php echo $value['alph_name']; ?>">
							<label for="check_job_type_<?php echo $value['alph_name']; ?>"><?php echo $value['name']; ?></label>
						</li>
					<?php endforeach; ?>
					</ul>
				</div>
				<div class="search_conditions search_conditions-treatments">
					<h3>お金や時間に関する待遇</h3>
					<ul>
					<?php foreach ($treatments_group[1] as $key => $value) : ?>
						<li>
							<input id="check_treatments_<?php echo $value['alph_name']; ?>" type="checkbox" value="<?php echo $value['alph_name']; ?>">
							<label for="check_treatments_<?php echo $value['alph_name']; ?>"><?php echo $value['name']; ?></label>
						</li>
					<?php endforeach; ?>
					</ul>
				</div>
				<div class="search_conditions search_conditions-treatments_others">
					<h3>その他待遇</h3>
					<ul>
					<?php foreach ($treatments_group[0] as $key => $value) : ?>
						<li>
							<input id="check_treatments_<?php echo $value['alph_name']; ?>" type="checkbox" value="<?php echo $value['alph_name']; ?>">
							<label for="check_treatments_<?php echo $value['alph_name']; ?>"><?php echo $value['name']; ?></label>
						</li>
					<?php endforeach; ?>
					</ul>
				</div>
<!--
				<div class="search_conditions search_conditions-user_character">
					<h3>こんな方も大丈夫</h3>
					<ul>
					<?php foreach ($AllUserChar as $key => $value) : ?>
						<li>
							<input id="check_user_character_<?php echo $value['id']; ?>" type="checkbox" value="<?php echo $value['id']; ?>">
							<label for="check_user_character_<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
						</li>
					<?php endforeach; ?>
					</ul>
				</div>
-->
			</div><!-- // .section_inner -->
<!--			<a style="" href="<?php echo base_url(); ?>"><button class="ui_btn ui_btn--bg_green ui_btn--large btn_search" disabled>絞込み検索</button></a>  -->
			<a href="javascript:void(0)" class="ui_btn ui_btn--bg_green ui_btn--large btn_search disabled" >絞込み検索</a>
		</div>
	</form>
</section>
<script src="/public/user/pc/js/serch_detail_refine.js"></script>
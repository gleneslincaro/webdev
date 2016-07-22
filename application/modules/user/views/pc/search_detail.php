<link rel="stylesheet" type="text/css" href="/public/user/pc/css/common.css">
<script type="text/javascript">    
    var group_city = '<?php echo $groupCity_info["id"];?>';
    var group_city_alph_name = '';
    var city_info_alph_name = '';
    var base_url = "<?php echo base_url(); ?>";
</script>
<section class="section--search_detail m_t_30">
	<form action="#">
		<h2 class="ttl_bar"><i class="fa fa-search fa-fw"></i> 絞り込み検索</h2>
		<div class="search_detail">
			<div class="section_inner">
				<div class="search_conditions search_conditions-area">
					<h3>エリア</h3>

<?php //var_dump($getCityGroup); ?>
					<dl>
						<dt>地域</dt>
						<dd>
							<select class="select_area_cityg">
								<option value="" selected>選択してください</option>
								<?php foreach ($getCityGroup as $k => $v) : ?>
								<option value="<?php echo $v['id']; ?>"><?php echo $v['name']; ?></option>
								<?php endforeach; ?>
							</select>
						</dd>
					</dl>
					<dl>
						<dt>都道府県</dt>
						<dd>
							<select class="select_prefecture">
								<option value="" selected>選択してください</option>
							</select>
						</dd>
					</dl>
				</div>
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
			</div>
			<p class="btn_more func_toggle" data-target=".search_detail_more" data-action="slide" data-speed="300"></p>
			<div class="search_detail_more" style="display:none;">
				<div class="section_inner">
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
							<input id="check_treatments_other_<?php echo $value['alph_name']; ?>" type="checkbox" value="<?php echo $value['alph_name']; ?>">
							<label for="check_treatments_other_<?php echo $value['alph_name']; ?>"><?php echo $value['name']; ?></label>
						</li>
					<?php endforeach; ?>
						</ul>
					</div>
<?php
/*
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
*/
?>
				</div>
			</div>
			<a class="ui_btn ui_btn--bg_green ui_btn--large btn_search disabled">絞込み検索</a>
		</div>
	</form>
</section>
<script src="/public/user/pc/js/serch_detail.js"></script>
<script>
</script>
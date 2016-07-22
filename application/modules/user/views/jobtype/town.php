<script type="text/javascript" src="<?php echo base_url(); ?>public/user/js/do_search.js?v=20160517"></script>
<div class="page_wrap page_wrap--prefectures">
	<div class="page_wrap_inner pagebody--gray">
		<ul class="mybreadcrumb pagebody--white">
			<li><a href="<?php echo base_url(); ?>">TOP</a></li>
			<li><a href="<?php echo base_url(); ?>jobtype_<?php echo $jobtype_info['alph_name']; ?>/"><?php echo $info_name; ?></a></li>
			<li><a href="<?php echo base_url(); ?>jobtype_<?php echo $jobtype_info['alph_name']; ?>/<?php echo $groupCity_info['alph_name']; ?>/"><?php echo $groupCity_info['name']; ?></a></li>
			<li class="active"><?php echo $City_info['name']; ?></li>
		</ul>
		<section class="section section--city_search cf">
			<h2 class="h_ttl_1 ic ic--area_search"><span class="type_h"><?php echo $info_name; ?></span>エリア検索</h2>
			<form>
				<div class="box_inner">
					<h3 class="city_ttl_1"><?php echo $City_info['name']; ?></h3>
					<div class="city_checkbox">
						<ul>
							<li>
								<label><span class="checkbox_area pl_15">
									<input type="checkbox" id="all_check" value="check_all">
									<span class="select_area"><?php echo $City_info['name'].$City_info['district']; ?>全て</span></label>
							</li>

							<?php foreach ($towns as $key => $val) : ?>
							<li>
								<label><span class="checkbox_area">
									<input type="checkbox"  value="<?php echo $val['alph_name']; ?>">
									</span><span class="select_area"><?php echo $val['name']; ?></span>
								</label>
								<a href="<?php echo base_url().'user/jobs/'.$groupCity_info['alph_name'].'/'.$City_info['alph_name'].'/'.$val['alph_name'].'/'.$search_que.$jobtype; ?>">
									<img src="/public/user/image/common/ui/follow.png" alt="{エリア名}">
								</a>
							</li>
							<?php endforeach; ?>
						</ul>
					</div>
					<div class="city_search_button">
						<p class="ic--area_search"> <a href="http://static.mgra.jp/joyspe_v2/sp/kanto/tokyo/shibuya/">検索する</a> </p>
					</div>
					<div class="search_button_fix">
						<p class="ic--area_search"> <a href="http://static.mgra.jp/joyspe_v2/sp/kanto/tokyo/shibuya/">検索する</a> </p>
					</div>
				</div>
			</form>
		</section>

		<?php $this->load->view("user/template/search_contents.php"); ?>
<!--
		<section class="section section--features">
			<div class="box_inner">
				<div class="features_inner">
					<h3>{東京の特徴}</h3>
					<p class="close_btn">{東京コンテンツの記述テストです}</p>
				</div>
			</div>
		</section>
-->
		<?php //include($_SERVER['DOCUMENT_ROOT'] . '/joyspe_v2/sp/inc/company_info.html'); ?>
	</div>
	<!-- // .pagebody_inner --> 
	
</div>
<!-- // .page_wrap_inner -->
</div>
<!-- // page_wrap -->

<script type="text/javascript">
$(function(){
	// side drawer navigation
	$('#simple-menu').sidr({
		name: 'sidr',
		side: 'right'
	});

	// mutiple select
	$('.ui_multiple_select').change(function(){
		console.log($(this).val());
	}).multipleSelect({
		placeholder: '選択してください',
		selectAllText: 'すべて選択',
		selectAllDelimiter: ['',''],
		allSelected : 'すべて選択',
		minimumCountSelected: 99,
		countSelected: '% 件中 # 件 選択済',
		noMatchesFound: '一致する条件が見つかりません',
		width: '100%'
	});
});
</script><script>
$(function(){
	// init area category
	displayAreaList($('#select_area_cat').val());

	// change area category
	$('#select_area_cat').on('change', function(){
		var area_cat_id = $(this).val();
		displayAreaList(area_cat_id);
	});

	// display area list
	function displayAreaList(area_cat_id){
		$('.area_list').hide();
		$('#area_list--' + area_cat_id).slideDown();
	}

	// reset search conditions
	$('#btn_search_reset').on('click', function(e){
		e.preventDefault();
		clearSelect('#select_area_cat');
		displayAreaList('');
		$('.multiple_select_wrap select').multipleSelect('uncheckAll');
	});

	// clear select
	function clearSelect(id){
		var elem = $(id);
		elem.each(function() {
			$('option', elem).removeAttr('selected');
			elem.selectedIndex  = 0;
		});
	}
});
</script> 
<script>
$(function(){
	$("#all_check").on('change',function(){
		if($("#all_check").is(":checked")){
			$(".checkbox_area input").prop("checked",true);
		}else{
			$(".checkbox_area input").prop("checked",false);
		};
		ifck();
	});
	
});
</script> 
<script>
$(function() {
    $(document).on('change', 'input:checkbox', function() {
		var scope = $(this).closest('.city_checkbox');
        var checked_cnt = $("input:checkbox:checked", scope).length;
        if (checked_cnt > 0) {
            $(".search_button_fix").css("display","block");
        } else {
            $(".search_button_fix").css("display","none");
        }
		ifck();
    });
	
});
$(function() {
    $(document).on('change', 'input:checkbox', function() {
		var all_scope = $(this).closest('.city_checkbox');
		var all_cnt = $("input:checkbox:checked:not('#all_check')", all_scope).length;
		var all_checkbox = $("input:checkbox:not('#all_check')", all_scope).length;
		if(all_cnt >= all_checkbox) {
			$("input#all_check").prop("checked",true);
		} else {
			$("input#all_check").prop("checked",false);
		}
		ifck();
	});
});

function ifck(){
    var allVals = [];
	var searchurl = '';
	$('.city_checkbox .checkbox_area input:checked').each(function(index, checkbox) {
        if ($(this).val() != 'check_all') {
            allVals.push($(this).val());
        }
	});
    for (x=0;x<allVals.length;x++) {
        if (allVals[x] !== "undefined " || allVals[x] != null) {
            if (x == 0 || x == allVals.length) {
                searchurl += allVals[x];
            } else {
                searchurl += '-' + allVals[x];
            }
        }
    }

//    console.log(searchurl);
	var url = "<?php echo base_url().'user/jobs/'.$groupCity_info['alph_name'].'/'.$City_info['alph_name'].'/'; ?>" + $.trim(searchurl) + "<?php echo '/'.$search_que.$jobtype; ?>";
	$('.city_search_button a').attr('href', url);
	$('.search_button_fix a').attr('href', url);
}
</script>
<div class="page_wrap">
	<?php $this->load->view('user/pc/header/header'); ?>
	<section class="section--main_content_area">
		<div class="container cf">
			<div class="f_left">

			<section class="section--area_search <?php echo $groupCity_info['alph_name']; ?>">
				<h1 class="m_b_20"><?php echo $City_info['name']; ?>の<?php echo $info_name; ?>の求人</h1>
				<div class="area_wrap">
					<div class="area_navi">
						<ul>
						<?php foreach ($city_group as $key => $value) : ?>
						<li class="area_<?php echo $value['alph_name']; ?> <?php if($groupCity_info['alph_name'] == $value['alph_name']){ ?> active<?php }; ?>">
							<a href="<?php echo base_url(); ?><?php echo $search_type.$jobtype; ?>/<?php echo $value['alph_name']; ?>" class="ui_btn"><?php echo $value['name']; ?></a>
						</li>
						<?php endforeach; ?>
						</ul>
					</div>
					<div class="area_detail">
						<p class="area_ttl">表示したいエリアを選択して下さい<span>※複数選択可能</span></p>
						<div class="select_city_box" id="select_city_box">
							<form action="./search_result.html">
								<ul class="check_list_all cf">
									<li><label><input type="checkbox" class="check_all">すべて</label></li>
								</ul>
								<ul class="check_list cf">
								<?php foreach ($towns as $key => $val) : ?>
									<li><label><input type="checkbox" value="<?php echo $val['alph_name']; ?>"><?php echo $val['name']; ?></label></li>
								<?php endforeach; ?>
								</ul>
							</form>
							<a><button class="btn_search" disabled><i class="fa fa-search fa-fw"></i>検索</button></a>
						</div>
					</div>
				</div>
			</section>
			<?php //include './inc/search_detail.html'; ?>
			</div>
			<div class="f_right">
                <?php $this->load->view('user/pc/share/aside'); ?>
			</div>
		</div>
	</section>
	<?php //include './inc/pickup_store.html'; ?>
	<?php //include './inc/pickup_column.html'; ?>
	<?php $this->load->view('user/pc/share/footer_msg'); ?>
	<?php //include './inc/peripheral.html'; ?>
	<?php //include './inc/footer.html'; ?>
</div>
<script>
$(function(){
	/*-----------------------------------------------*/
	// select city box
	/*-----------------------------------------------*/
	// check
	$(document).on('change', '#select_city_box :checkbox', function(e){
		var scope = $(this).closest('#select_city_box');
		if($(this).prop('checked')){
			$(this).closest('li').addClass('on');
		}else{
			$(this).closest('li').removeClass('on');
		}
		// button enable or disabled
		if($(':checkbox:checked', scope).length > 0){
			$(".btn_search", scope).prop('disabled', false);
		}else{
			$(".btn_search", scope).prop('disabled', true);
		}
		// sync check all
		if(!$(this).hasClass('check_all')){
			var cnt_checkbox = $(':checkbox:not(.check_all)', scope).length;
			var cnt_checked = $(':checkbox:checked:not(.check_all)', scope).length;
			var check_all = $(':checkbox.check_all', scope);
			if(cnt_checkbox == cnt_checked){
				check_all.prop('checked', true);
				check_all.closest('li').addClass('on');
			}else{
				check_all.prop('checked', false);
				check_all.closest('li').removeClass('on');
			}
		}
		ifck();
	});

	// check all
	$(document).on('change', '#select_city_box :checkbox.check_all', function(e){
		var scope = $(this).closest('#select_city_box');
		if($(this).prop('checked')){
			$('#select_city_box .check_list li').addClass('on');
			$('#select_city_box .check_list li :checkbox').prop('checked', true);
		}else{
			$('#select_city_box .check_list li').removeClass('on');
			$('#select_city_box .check_list li :checkbox').prop('checked', false);
			$(".btn_search", scope).prop('disabled', true);
		}
		ifck();
	});
});

function ifck(){
    var allVals = [];
	var searchurl = '';
	$('#select_city_box .check_list li input:checked').each(function(index, checkbox) {
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
	var url = "<?php echo base_url().'user/jobs/'.$groupCity_info['alph_name'].'/'.$City_info['alph_name'].'/'; ?>" + $.trim(searchurl) + "<?php echo '/'.$search_que.$jobtype; ?>";
	$('#select_city_box a').attr('href', url);
}
</script>
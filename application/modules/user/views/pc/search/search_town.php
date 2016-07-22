<section class="section--area_search <?php echo $groupCity_info['alph_name']; ?> <?php echo $city_info['alph_name']; ?>">
	<h1 class="m_b_20"><?php echo $city_info['name']; ?>エリア</h1>
	<p>検索結果<span><strong><?php echo $owCount; ?></strong>件</span>見つかりました</p>
	<div class="area_wrap">
		<div class="area_navi">
			<ul>
			<?php foreach($getCityGroup as $key => $value) :
				$active = ($value['alph_name'] == $group_city) ? 'active':'';
			?>
				<li class="area_<?php echo $value['alph_name'];?> <?php echo $active; ?>"><a href="<?php echo base_url().'user/jobs/'.$value['alph_name']; ?>" class="ui_btn"><?php echo $value['name'];?></a></li>
			<?php endforeach; ?>
			</ul>
		</div>
		<div class="area_detail">
			<p class="area_ttl">表示したいエリアを選択して下さい<span>※複数選択可能</span></p>
			<div class="select_city_box" id="select_city_box">
				<form autocomplete="off">
					<ul class="check_list_all cf">
						<li><label><input type="checkbox" class="check_all">すべて</label></li>
					</ul>
					<ul class="check_list cf">
						<?php foreach($towns as $key => $value) :
								if ($value['alph_name'] != '') :
						?>
						<li><label><input type="checkbox" class="all_check" value="<?php echo $value['alph_name']; ?>" ><?php echo $value['name']; ?></label></li>
						<?php
								endif;
						 	endforeach;
						?>
					</ul>
				</form>
					<a><button class="btn_search" disabled><i class="fa fa-search fa-fw"></i>検索</button></a>
			</div>
		</div>
	</div>
</section>
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
	$('.all_check:checked').each(function(index, checkbox) {
        if ($(this).val() != 'all_check') {
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
    var url = base_url +"<?php echo 'user/jobs/'.$group_city.'/'.$city_info['alph_name'].'/'; ?>" + $.trim(searchurl) + '/';
    $('#select_city_box a').attr('href', url);
}
</script>
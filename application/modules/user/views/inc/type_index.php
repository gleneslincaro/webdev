
<section class="section--type_search_index">
	<article class="article--jobtype_index">
		<h3 class="h_ttl_1 ic ic--search">業種で探す</h3>
		<div class="search_box_inner">
			<ul>
				<li><a href="<?php echo base_url().'jobtype_'; ?>hoteheru/">ホテルヘルス</a></li>
				<li><a href="<?php echo base_url().'jobtype_'; ?>este/">エステマッサージ</a></li>
				<li><a href="<?php echo base_url().'jobtype_'; ?>koukyuuhakennherusu/">高級派遣ヘルス</a></li>
				<li><a href="<?php echo base_url().'jobtype_'; ?>rannpabu/">ランジェリーパブ</a></li>
				<li><a href="<?php echo base_url().'jobtype_'; ?>telephonelady/">テレフォンレディ</a></li>
				<li><a href="<?php echo base_url().'jobtype_'; ?>imekura/">イメクラ </a></li>
			</ul>
			<div class="acordion_tree">
				<ul class="close_btn">
					<li><a href="<?php echo base_url().'jobtype_'; ?>deliheal/">デリヘル </a></li>
					<li><a href="<?php echo base_url().'jobtype_'; ?>chatlady/">チャット・メール</a></li>
					<li><a href="<?php echo base_url().'jobtype_'; ?>soap/">ソープランド </a></li>
					<li><a href="<?php echo base_url().'jobtype_'; ?>kyabakura/">キャバクラ </a></li>
					<li><a href="<?php echo base_url().'jobtype_'; ?>sm/">SM M性感</a></li>
					<li><a href="<?php echo base_url().'jobtype_'; ?>onakura/">オナクラ</a></li>
					<li><a href="<?php echo base_url().'jobtype_'; ?>hakennaroma/">派遣アロマエステ</a></li>
					<li><a href="<?php echo base_url().'jobtype_'; ?>kousaikurabu/">交際クラブ</a></li>
					<li><a href="<?php echo base_url().'jobtype_'; ?>pinsalo/">ピンクサロン </a></li>
					<li><a href="<?php echo base_url().'jobtype_'; ?>sekukyaba/">セクシーキャバ </a></li>
					<li><a href="<?php echo base_url().'jobtype_'; ?>fashion/">店舗型ヘルス </a></li>
					<li><a href="<?php echo base_url().'jobtype_'; ?>purodakushon/">AV・モデル </a></li>
					<li><a href="<?php echo base_url().'jobtype_'; ?>other_cate/">その他</a></li>
				</ul>
			</div>
			<div class="open_btn">
				<p class="more_btn"><i class="fa fa-chevron-down"></i><span>もっと見る</span></p>
			</div>
		</div>
	</article>
	<article class="article--treatment_index">
		<h3 class="h_ttl_1 ic ic--search">待遇で探す</h3>
		<div class="search_box_inner">
			<ul>
              <?php foreach ($treatments_ar as $key => $val) : ?>
                <?php if ($val['alph_name'] != null) : ?>
                <li><a href="<?php echo base_url().'treatment_'.$val['alph_name'].'/'; ?>"><?php echo $val['name']; ?></a></li>
                <?php endif; ?>
              <?php endforeach; ?>
			</ul>
			<div class="acordion_tree">
				<ul class="close_btn">
				<?php foreach ($treatments_ar2 as $key => $val) : ?>
					<?php if ($val['alph_name'] != null) : ?>
					<li><a href="<?php echo base_url().'treatment_'.$val['alph_name'].'/'; ?>"><?php echo $val['name']; ?></a></li>
					<?php endif; ?>
				<?php endforeach; ?>
				</ul>
			</div>
			<div class="open_btn">
				<p class="more_btn"><i class="fa fa-chevron-down"></i><span>もっと見る</span></p>
			</div>
		</div>
	</article>
</section>
<script type="text/javascript">
	$(".article--jobtype_index .more_btn").on("click",function(){
		if($(".article--jobtype_index .acordion_tree ul").hasClass("close_btn")){
			$(".article--jobtype_index .acordion_tree ul").removeClass("close_btn").addClass("open_btn");
			$(".article--jobtype_index .more_btn i").removeClass("fa-chevron-down").addClass("fa-chevron-up");
			$(".article--jobtype_index .more_btn span").text('閉じる');
		} else{
			$(".article--jobtype_index .acordion_tree ul").removeClass("open_btn").addClass("close_btn");
			$(".article--jobtype_index .more_btn i").removeClass("fa-chevron-up").addClass("fa-chevron-down");
			$(".article--jobtype_index .more_btn span").text('もっと見る');
		}
		
	});
		
	$(".article--treatment_index .more_btn").on("click",function(){
		if($(".article--treatment_index .acordion_tree ul").hasClass("close_btn")){
			$(".article--treatment_index .acordion_tree ul").removeClass("close_btn").addClass("open_btn");
			$(".article--treatment_index .more_btn i").removeClass("fa-chevron-down").addClass("fa-chevron-up");
			$(".article--treatment_index .more_btn span").text('閉じる');
		} else{
			$(".article--treatment_index .acordion_tree ul").removeClass("open_btn").addClass("close_btn");
			$(".article--treatment_index .more_btn i").removeClass("fa-chevron-up").addClass("fa-chevron-down");
			$(".article--treatment_index .more_btn span").text('もっと見る');
		}
	});
</script>
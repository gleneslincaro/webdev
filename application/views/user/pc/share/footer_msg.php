<?php if (isset($getCity) && !isset($is_top) && isset($city_group_contents) && $city_group_contents) : ?>
<section class="section--footer_msg m_b_40">
	<div class="container">
		<div class="footer_msg_box">
			<h3 class="ttl"><?php echo $groupCity_info['name']; ?>の特徴</h3>
			<div class="desc_area"><?php echo nl2br($city_group_contents); ?></div>
		</div>
	</div>
</section>
<?php elseif (isset($getTowns) && isset($city_contents) && $city_contents) : ?>
	<section class="section--footer_msg m_b_40">
		<div class="container">
			<div class="footer_msg_box">
				<h3 class="ttl"><?php echo $city_info['name']; ?>の特徴</h3>
				<div class="desc_area"><?php echo nl2br($city_contents); ?></div>
			</div>
		</div>
	</section>
<?php elseif (isset($storeOwner) && isset($town_contents) && $town_contents) : ?>
	<section class="section--footer_msg m_b_40">
		<div class="container">
			<div class="footer_msg_box">
				<h3 class="ttl"><?php echo $town_info['name']; ?>の特徴</h3>
				<div class="desc_area"><?php echo nl2br($town_contents); ?>
				</div>
			</div>
			<?php if (isset($feature_url)) : ?>
				<div class="btn_more">
					<a href="<?php echo $feature_url; ?>">もっとみる</a>
				</div>
			<?php endif; ?>
		</div>
	</section>
<?php elseif (isset($is_top)) : ?>
<section class="section--footer_msg m_b_40">
	<div class="container">
		<div class="footer_msg_box">
			<h3 class="ttl">ジョイスペをご覧の皆様へ</h3>
			<div class="desc_area">
				ジョイスペは全国の風俗求人、高収入アルバイト情報を凝縮したポータルサイトです。<br>
				短時間で普通のOLの数倍を稼ぐことができるデリヘル、ホテヘル、エステ、ピンサロ、チャットレディーなどの求人情報が盛りだくさん！<br>
				大人気の主婦（人妻）向けの高収入求人情報も満載！日払い、体験入店、託児所などの条件からお店を検索することができます。<br>
				関東（首都圏）、関西、東海、北海道、東北、甲信越、北陸、中国、四国、九州、沖縄にある求人情報から最新の内容をご紹介いたします。<br>
				風俗未経験者が抱く不安や業界用語、風俗業界についてのコラムも連載中。<br>
				ジョイスペを使ってワンランク上のライフスタイルを手に入れちゃおう！
			</div>
		</div>
	</div>
</section>

<section class="section--new_store m_b_40">
	<div class="container cf">
		<div class="container_inner left cf">
		<h3 class="content_ttl">新着風俗求人情報　<?php echo date("Y年n月"); ?></h3>
			<ul class="update_content">
			<?php foreach ($new_store_ar as $key => $val) : ?>
				<li class="b_link">
					<time><?php echo date("n月j日",  strtotime($val['new_store_date'])); ?></time>
					<a href="<?php echo base_url(); ?>user/joyspe_user/company/<?php echo $val['id']; ?>/">【<?php echo $val['name']; ?>】<?php echo $val['storename']; ?></a>
				</li>
			<?php endforeach; ?>
			</ul>
		</div>

		<div class="container_inner right cf">
		<h3 class="content_ttl">新着Q&Aみんなの質問</h3>
			<ul class="update_content">
			<?php foreach ($everyones_question_ar as $key => $val) : ?>
				<li class="b_link">
					<a href="<?php echo base_url(); ?>user/joyspe_user/company/<?php echo $val['owr_id']; ?>/<?php echo $val['category_id']; ?>/<?php echo $val['id']; ?>"><?php echo mb_strimwidth($val['content'], 0, 64, "...", "utf8"); ?></a>
				</li>
			<?php endforeach; ?>
			</ul>
		</div>
	</div>
</section>
<?php /*
<section class="section--aruaru_new m_b_40">
	<div class="container cf">
		<div class="container_inner left cf">
		<h3 class="content_ttl">新着あるある</h3>
			<ul class="update_content">
			<?php foreach ($latest_post as $key => $val) : ?>
				<li class="b_link">
					<time><?php echo date("Y/m/d",  strtotime($val['create_date'])); ?></time>
					<a href="https://aruaru.joyspe.com/reaction/<?php echo $val['id']; ?>/"><?php echo preg_replace('/あるある$/', '', $val['title']); ?></a>
				</li>
			<?php endforeach; ?>
			</ul>
		</div>

		<div class="container_inner right cf">
		<h3 class="content_ttl">注目のあるある</h3>
			<ul class="update_content">
			<?php foreach ($popular as $key => $val) : ?>
				<li class="b_link">
					<a href="https://aruaru.joyspe.com/reaction/<?php echo $val['id']; ?>/"><?php echo preg_replace('/あるある$/', '', $val['title']); ?></a>
				</li>
			<?php endforeach; ?>
			</ul>
		</div>
	</div>
</section>
*/ ?>
<section class="section--pickup_area m_b_40">
	<div class="container">
		<div class="pickup_box">
			<h3 class="pickup_area_h">自分に合った業種からお仕事を探す</h3>
			<ul>
             <?php foreach ($jobtypes_ar as $key => $val) : ?>
                <?php if ($val['alph_name'] != null) : ?>
                <li><a href="<?php echo base_url().'jobtype_'.$val['alph_name'].'/'; ?>"><?php echo $val['name']; ?></a></li>
                <?php endif; ?>
              <?php endforeach; ?>
			</ul>
		</div>
	</div>
</section>
<section class="section--pickup_area m_b_40">
	<div class="container">
		<div class="pickup_box">
			<h3 class="pickup_area_h">気になる待遇からお仕事を探す</h3>
			<ul>
              <?php foreach ($treatments_ar as $key => $val) : ?>
                <?php if ($val['alph_name'] != null) : ?>
                <li><a href="<?php echo base_url().'treatment_'.$val['alph_name'].'/'; ?>"><?php echo $val['name']; ?></a></li>
                <?php endif; ?>
              <?php endforeach; ?>
			</ul>
		</div>
	</div>
</section>

<section class="section--pickup_area m_b_40">
	<div class="container">
		<div class="pickup_box">
			<h3 class="pickup_area_h">人気の風俗高収入バイト</h3>
			<ul>
				<li><a href="https://www.joyspe.com/user/jobs/kanto/tokyo/ikebukuro/">池袋風俗求人</a></li>
				<li><a href="https://www.joyspe.com/user/jobs/kanto/tokyo/shinjuku/">新宿風俗求人</a></li>
				<li><a href="https://www.joyspe.com/user/jobs/kanto/tokyo/shibuya/">渋谷風俗求人</a></li>
				<li><a href="https://www.joyspe.com/user/jobs/kanto/tokyo/yoshiwara/">吉原風俗求人</a></li>
				<li><a href="https://www.joyspe.com/user/jobs/kanto/tokyo/gotanda/">五反田風俗求人</a></li>
				<li><a href="https://www.joyspe.com/user/jobs/kanto/kanagawa/yokohama/">横浜風俗求人</a></li>
				<li><a href="https://www.joyspe.com/user/jobs/kanto/kanagawa/kawasaki/">川崎風俗求人</a></li>
				<li><a href="https://www.joyspe.com/user/jobs/kanto/chiba/chibashi/">千葉市風俗求人</a></li>
				<li><a href="https://www.joyspe.com/user/jobs/kanto/chiba/funabashi/">船橋風俗求人</a></li>
				<li><a href="https://www.joyspe.com/user/jobs/kanto/saitama/saitamashi/">さいたま市（他）風俗求人</a></li>
				<li><a href="https://www.joyspe.com/user/jobs/kanto/saitama/koshigaya/">越谷風俗求人</a></li>
				<li><a href="https://www.joyspe.com/user/jobs/tokai/aichi/nagoya/">名古屋風俗求人</a></li>
				<li><a href="https://www.joyspe.com/user/jobs/kansai/osaka/umeda/">梅田風俗求人</a></li>
				<li><a href="https://www.joyspe.com/user/jobs/kansai/osaka/namba/">難波風俗求人</a></li>
				<li><a href="https://www.joyspe.com/user/jobs/kansai/osaka/kyobashi/">京橋風俗求人</a></li>
				<li><a href="https://www.joyspe.com/user/jobs/kyushu/fukuoka/fukuokashi/">福岡市風俗求人</a></li>
			</ul>
			<p>ジョイスペでは安心・安全高収入のアルバイト情報をリアルタイムで更新しております。不明な点はお気軽に<a class="go_faq" href="https://www.joyspe.com/user/contact/">お問い合わせ</a>ください。</p>
		</div>
	</div>
</section>
<?php endif; ?>
<?php if (isset($treatment_info)) : ?>
	<div class="features_area_box">
		<h3><?php echo $treatment_info['name']; ?>とは？</h3>
		<div class="comment_area">
			<?php echo nl2br($treatment_info['contents']); ?>
		</div>
	</div>
<?php endif; ?>
<?php if (isset($category_info)) : ?>
	<div class="features_area_box">
		<h3><?php echo $category_info['name']; ?>とは？</h3>
		<div class="comment_area">
			<?php echo nl2br($category_info['contents']); ?>
		</div>
	</div>
<?php endif; ?>
<?php if (isset($getTowns) && count($towns) > 0) : ?>
<section class="section--peripheral_area m_b_40">
	<div class="container">
		<div class="peripheral_area">
			<h3 class="ttl"><?php echo $city_info['name']; ?>エリア</h3>
			<ul>
			<?php foreach($towns as $key => $value) :
					if ($value['alph_name'] != '') :
			?>
			<li><a href="<?php echo base_url() . 'user/jobs/' . $group_city . '/' . $city . '/' . $value['alph_name']; ?>/" ><?php echo $value['name']; ?></a></li>
			<?php
					endif;
			 	endforeach;
			?>
			</ul>
		</div>
	</div>
</section>
<?php endif; ?>
<?php if (isset($feature_url)) : ?>
<script type="text/javascript">
$(function(){
	var h = $('.footer_msg_box').height();
	if(h < 500){
		$('.btn_more').hide();
	}else{
		$('.btn_more').show();
		$('.footer_msg_box').height(500);
	}
});
</script>
<?php endif; ?>
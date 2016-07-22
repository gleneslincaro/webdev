<?php if (isset($city_group_contents)) : ?>
<section class="section section--features">
	<div class="box_inner">
		<div class="features_inner">
			<h3><?php echo $groupCity_info['name']; ?>の特徴</h3>
			<div class="comment_area"><?php echo nl2br($city_group_contents); ?></div>
		</div>
		<div class="open_btn">
			<p id="more_btn" class="more_btn open_btn"><i class="fa fa-chevron-down"></i><span>もっと見る</span></p>
		</div>
	</div>
</section>
<?php endif; ?>
<?php if (isset($city_contents)) : ?>
<section class="section section--features">
	<div class="box_inner">
		<div class="features_inner">
			<h3><?php echo $city_info['name']; ?>の特徴</h3>
			<div class="comment_area"><?php echo nl2br($city_contents); ?></div>
		</div>
		<div class="open_btn">
			<p id="more_btn" class="more_btn open_btn"><i class="fa fa-chevron-down"></i><span>もっと見る</span></p>
		</div>
	</div>
</section>
<?php endif; ?>

<?php if (isset($town_contents)) : ?>
<section class="section section--features">
    <div class="box_inner">
		<div class="features_inner">
			<h3><?php echo $town_info['name']; ?>の特徴</h3>
			<div class="comment_area"><?php echo nl2br($town_contents); ?></div>
		</div>
		<div class="open_btn">
				<p id="more_btn" class="more_btn open_btn"><i class="fa fa-chevron-down"></i><span>もっと見る</span></p>
		</div>
    </div>

<?php if (isset($treatment_info)) : ?>
    <div class="box_inner">
		<div class="features_inner1">
			<h3><?php echo $treatment_info['name']; ?>とは？</h3>
			<div class="comment_area"><?php echo nl2br($treatment_info['contents']); ?></div>
		</div>
		<div class="open_btn">
				<p id="more_btn1" class="more_btn open_btn"><i class="fa fa-chevron-down"></i><span>もっと見る</span></p>
		</div>
    </div>
<?php endif; ?>
<?php if (isset($category_info)) : ?>
    <div class="box_inner">
		<div class="features_inner2">
			<h3><?php echo $category_info['name']; ?>とは？</h3>
			<div class="comment_area"><?php echo nl2br($category_info['contents']); ?></div>
		</div>
		<div class="open_btn">
				<p id="more_btn2" class="more_btn open_btn"><i class="fa fa-chevron-down"></i><span>もっと見る</span></p>
		</div>
    </div>
<?php endif; ?>

</section>
<?php endif; ?>
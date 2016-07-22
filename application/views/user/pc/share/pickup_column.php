<?php
// column_data structure
// 1. pubdate (YYYY-MM-DD)
// 2. category
// 3. title
// 4. description
// 5. link
if (isset($column_data) && count($column_data > 0)) { ?>
<section class="section--pickup_column m_b_30" >
	<div class="container">
		<h2 class="headline m_b_15"><i class="fa fa-pencil-square-o"></i> 最新の人気コラム ~高収入バイト探しの息抜きにどうぞ~</h2>
		<ul class="column_list">
			<li> <a href="/column/"><img src="<?php echo base_url(); ?>public/user/pc/image/banner/column_banner.jpg" /> </li>
		</ul>
	</div>
</section>
<?php } ?>
<style>
.section--pickup_column .column_item .pic{
	background-size:cover;
	background-position:center center;
	background-repeat:no-repeat;
	background-color: #E8E8E8;
}
</style>

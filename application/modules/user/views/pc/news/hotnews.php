<?php $this->load->view('user/pc/header/header'); ?>
	<section class="section--main_content_area">
		<div class="container p_b_50">
			<div class="box_white">
				<section class="section--info_list">
					<h2 class="ttl_style_1">お知らせ一覧</h2>
		            <?php echo $this->load->view("pc/news/list_hot_news")?>
				</section>
				<div class="ui_pager">
					<ul id="pagination">
						<?php echo $page_links; ?>
					</ul>
				</div>
			</div><!-- // .box_white -->
		</div><!-- // .container --> 
	</section>
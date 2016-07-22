<script type="text/javascript" src="<?php echo base_url(); ?>public/user/js/do_search.js?v=20160517"></script>
<div class="page_wrap page_wrap--area">
	<div class="page_wrap_inner pagebody--gray">
		<ul class="mybreadcrumb pagebody--white">
			<li><a href="<?php echo base_url(); ?>">TOP</a> <span class="divider"></span></li>
			<li><a href="<?php echo base_url(); ?><?php echo $search_type.$jobtype_info['alph_name']; ?>/"><?php echo $info_name; ?></a><span class="divider"></span></li>
			<li class="active"><?php echo  $groupCity_info['name']; ?></li>
		</ul>
		<section class="section section--area_search cf">
			<h2 class="h_ttl_1 ic ic--area_search"><span class="type_h"><?php echo $info_name; ?></span>エリア検索</h2>
			<div class="box_inner pb_20 cf">
				<h3 class="search_ttl_1"><?php echo  $groupCity_info['name']; ?></h3>
				<ul>
					<?php foreach ($city_towns_ar as $key => $val) : ?>
					<li><a href="<?php echo base_url(); ?><?php echo $search_type.$jobtype; ?>/<?php echo $groupCity_info['alph_name'] ?>/<?php echo $val['alph_name']; ?>" style="display:block"><?php echo $val['name']; ?></a></li>
					<?php endforeach; ?>
				</ul>
			</div>
		</section>

		<?php echo $this->load->view("user/template/campaign_banner.php"); ?>

<!--
		<section class="section section--campaign">
			<h3 class="h_ttl_1 ic ic--campaign">キャンペーン</h3>
			<div class="box_inner pt_15">
				<div class="campaign_list">
					<ul>
						<li> <a href="http://joyspe.fdc-inc.com/user/misc/koutsuhi01/"> <img class="banner" src="http://joyspe.fdc-inc.com/public/user/image/koutsuhi0115000.jpg" alt="ジョイスペ保証 面接交通費 5000円プレゼント"> </a> </li>
						<li> <a href="http://joyspe.fdc-inc.com/user/contact#trial_work"> <img class="banner" src="http://joyspe.fdc-inc.com/public/user/uploads/banner/BlscE.jpg"> </a> </li>
						<li>
							<input type="hidden" id="time-left" name="time-left" value="">
						</li>
					</ul>
				</div>
			</div>
		</section>
-->
		<?php $this->load->view("user/template/search_contents.php"); ?>

		<?php //$this->load->view('user/inc/company_info.html'); ?>
		<?php //include'../inc/company_info.html'; ?>
	</div>
	<!-- // .page_wrap_inner --> 
</div>
<!-- // page_wrap -->
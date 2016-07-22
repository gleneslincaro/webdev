<div class="page_wrap">
	<?php $this->load->view('user/pc/header/header'); ?>
	<section class="section--main_content_area">
		<div class="container cf">
			<div class="f_left">

				<section class="section--area_search <?php echo  $groupCity_info['alph_name']; ?>">
					<h1 class="m_b_20"><?php echo $groupCity_info['name']; ?>の<?php echo $info_name; ?>の求人</h1>
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
							<p class="area_ttl">表示したいエリアを選択して下さい</p>
							<div class="left_box">
								<ul class="area_map">
									<?php foreach ($city_towns_ar as $key => $val) : ?>
									<li class="<?php echo $val['alph_name']; ?> on">
									<a href="<?php echo base_url(); ?><?php echo $search_type.$jobtype; ?>/<?php echo $groupCity_info['alph_name'] ?>/<?php echo $val['alph_name']; ?>"><?php echo $val['name']; ?></a>
									</li>
								<!--	<li class="hokkaido on"><a href="./area.html?area=hokkaido&prefecture=sample">北海道</a></li> -->
									<?php endforeach; ?>
								</ul>
							</div>
							<div class="right_box">
								<?php foreach ($city_towns_ar as $key1 => $val1) : ?>
								<dl>
									<dt><span><a href="<?php echo base_url(); ?><?php echo $search_type.$jobtype; ?>/<?php echo $groupCity_info['alph_name'] ?>/<?php echo $val1['alph_name']; ?>"><?php echo $val1['name']; ?></a></span></dt>
									<dd>
										<ul>
											<?php foreach ($val1['towns'] as $key2 => $val2) : ?>
											<li><a href="<?php echo base_url(); ?>user/jobs/<?php echo $groupCity_info['alph_name'] ?>/<?php echo $val1['alph_name']; ?>/<?php echo $val2['alph_name']; ?><?php echo '/'.$search_que.$jobtype; ?>"><?php echo $val2['name']; ?></a></li>
											<?php endforeach; ?>
										</ul>
									</dd>
								</dl>
								<?php endforeach; ?>
							</div>

						</div>
					</div>
				</section>

				<?php
/*				
					if(!empty($_GET['prefecture'])){
						include './inc/area_search/prefecture/index.html';
					}
					elseif(!empty($_GET['area'])){
						include './inc/area_search/area/' . $_GET['area'] . '.html';
					}
					else{
						include './inc/area_search/jobtype/area.html';
					}
*/					
				?>
			</div>
			<div class="f_right">
                <?php $this->load->view('user/pc/share/aside'); ?>
			</div>
		</div>
	</section>
	<?php ///include './inc/pickup_store.html'; ?>
	<?php $this->load->view('user/pc/share/pickup_column'); ?>
	<?php $this->load->view('user/pc/share/footer_msg'); ?>
	<?php ///include './inc/peripheral.html'; ?>
	<?php ///include './inc/footer.html'; ?>
</div>
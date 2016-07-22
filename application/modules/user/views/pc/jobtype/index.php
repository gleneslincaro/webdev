<div class="page_wrap">
	<?php $this->load->view('user/pc/header/header'); ?>
	<div class="job_type_wrap">
		<div class="job_type image_area">
			<h3 class="jobtype_h"><?php echo $jobtype_info['name']; ?><span>の風俗求人</span></h3>
			<div class="dis_wrap">
				<div class="dis">
					<h3 class="jobtype_sub_h ic"><?php echo nl2br($jobtype_info['name']); ?>とは？</h3>
					<div class="box_inner">
						<p><?php echo $jobtype_info['contents']; ?>
						</p>
					</div>
				</div>
			</div>
			<figure><img src="<?php echo $image_area_path; ?>"> </figure>
		</div>
		<div class="job_type container cf">
			<div class="f_left">
				<section class="section--job_type">
					<article class="left_top_area">
						<div class="column  m_b_30">
							<ul>
								<li class="block s">
									<?php if ($jobtype_info['contents3'] != '') : ?>
									<h4 class="type_h ic">こんな人におすすめ</h4>
									<div class="content_box type cf">
										<div class="box_inner">
											<p><?php echo nl2br($jobtype_info['contents3']); ?></p>
										</div>
									</div>
									<?php endif; ?>
								</li>
								<li class="block l">
									<article class="article--pre_search_detail">
										<h4 class="add_seach_h"><?php echo $jobtype_info['name']; ?>で絞り込む</h4>
										<div class="prefectures_box">
											<div class="prefectures_detail">
												<?php foreach ($getCity as $key => $value) : ?>
												<dl>
													<dt class="toptext_<?php echo $value['alph_name']; ?>"><a href="<?php echo base_url(); ?>jobtype_<?php echo $jobtype; ?>/<?php echo $value['alph_name']; ?>/"><?php echo $value['name']; ?></a></dt>
													<dd>
														<ul>
														<?php
															$city_group_id = $value['id'];
															foreach ($getCity[$key][$city_group_id] as $value1) :
														?>
															<li><a href="<?php echo base_url(); ?>jobtype_<?php echo $jobtype; ?>/<?php echo $value['alph_name']; ?>/<?php echo $value1['alph_name']; ?>/"><?php echo $value1['name']; ?></a></li>
														<?php endforeach; ?>
														</ul>
													</dd>
												</dl>
												<?php endforeach; ?>
											</div>
										</div>
									</article>
								</li>
							</ul>
						</div>
						<div class="column m_b_50">
							<ul>
								<li class="block s">
									<?php if ($jobtype_info['contents2'] != '' OR $jobtype_info['income'] != '') : ?>
									<div class="column_inner">
										<h4 class="average_h ic">平均月収</h4>
										<div class="content_box average cf">
											<div class="box_inner">
												<p class="pay"><?php echo nl2br($jobtype_info['income']); ?></p>
												<p><?php echo nl2br($jobtype_info['contents2']); ?></p>
											</div>
										</div>
									</div>
									<?php endif; ?>
								</li>
								<li class="block l">
									<?php if ($jobtype_info['contents4'] != '') : ?>
									<div class="column_inner">
										<h4 class="search_point_h ic">探すときのポイント</h4>
										<div class="content_box search_point cf">
											<div class="box_inner b_none">
												<p><?php echo nl2br($jobtype_info['contents4']); ?></p>
											</div>
										</div>
									</div>
									<?php endif; ?>
								</li>
							</ul>
						</div>
					</article>
				</section>
			</div>
			<div class="f_right">
                <?php $this->load->view('user/pc/share/aside'); ?>
			</div>
		</div>
	</div>
	<?php //include './inc/footer.html'; ?>
</div>
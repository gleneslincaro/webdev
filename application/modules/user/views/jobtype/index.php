<div class="page_wrap page_wrap--job_type">
	<ul class="mybreadcrumb pagebody--white">
		<li><a href="<?php echo base_url(); ?>">TOP</a> <span class="divider"></span></li>
		<li class="active"><?php echo $jobtype_info['name']; ?></li>
	</ul>
	<div class="page_wrap_inner">
		<div class="pagebody">
			<div class="pagebody_inner cf">
			<section class="section--job_type">
				<div class="image_area">
					<h3 class="jobtype_h"><?php echo $jobtype_info['name']; ?><span>の風俗求人</span></h3>
					<figure><img src="<?php echo $image_area_path; ?>" alt="ホテルヘルス"></figure>
				</div>
				<div class="job_type container cf">
					<section class="section--job_type">
						<h3 class="jobtype_sub_h ic"><?php echo $jobtype_info['name']; ?>とは？</h3>
						<div class="content_box dis_wrap">
							<div class="dis">
								<div class="box_inner">
									<p><?php echo nl2br($jobtype_info['contents']); ?></p>
								</div>
							</div>
						</div>
						<div class="column">
							<ul>
								<li class="block">
									<article class="article--pre_search_detail">
										<h4 class="add_seach_h"><?php echo $jobtype_info['name']; ?>で絞り込む</h4>
										<div class="prefectures_box">
											<div class="prefectures_detail">
												<?php foreach ($getCity as $key => $value) : ?>
												<dl>
													<dt class="toptext_<?php echo $value['alph_name']; ?>">
														<a href="<?php echo base_url(); ?>jobtype_<?php echo $jobtype; ?>/<?php echo $value['alph_name']; ?>/"><?php echo $value['name']; ?></a>
													</dt>
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
								<li class="block">
									<?php if ($jobtype_info['contents3'] != '') : ?>
									<h4 class="type_h ic">こんな人におすすめ</h4>
									<div class="content_box type cf">
										<div class="box_inner">
											<p><?php echo nl2br($jobtype_info['contents3']); ?></p>
										</div>
									</div>
									<?php endif; ?>
								</li>
							</ul>
						</div>
						<div class="column">
							<ul>
								<li class="block">
									<?php if ($jobtype_info['contents2'] != '' OR $jobtype_info['income'] != '') : ?>
									<div class="column_inner">
										<h4 class="average_h ic">平均月収</h4>
										<div class="content_box average cf">
											<div class="box_inner">
												<p class="pay"><?php echo $jobtype_info['income']; ?></p>
												<p><?php echo nl2br($jobtype_info['contents2']); ?></p>
											</div>
										</div>
									</div>
									<?php endif; ?>
								</li>
								<li class="block">
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
					</section>
				</div>
				</div>
				<!-- // .container --> 
			</section>
		</div>
		<!-- // .pagebody_inner --> 
	</div>
	<!-- // .pagebody --> 
	
</div>
<!-- // .page_wrap_inner -->
</div>
<!-- // page_wrap -->
<!--
<?php include'./inc/company_info.html'; ?>
<?php include './inc/footer.html'; ?>
<?php include './inc/script.html'; ?>
</body>
</html>
-->
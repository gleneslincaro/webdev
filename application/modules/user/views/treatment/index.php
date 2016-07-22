<div class="page_wrap page_wrap--treatment">
	<ul class="mybreadcrumb pagebody--white">
		<li><a href="<?php echo base_url(); ?>">TOP</a> <span class="divider"></span></li>
		<li class="active"><?php echo $info_name; ?></li>
	</ul>
	<div class="page_wrap_inner">
		<div class="pagebody">
			<div class="pagebody_inner cf">
				<section class="section--treatment">
					<div class="image_area">
						<h3 class="treatment_h"><?php echo $info_name; ?><span>の風俗求人</span></h3>
						<figure><img src="<?php echo $image_area_path; ?>" alt="ホテルヘルス"></figure>
					</div>
					<div class="treatment container cf">
						<section class="section--treatment">
							<h3 class="treatment_sub_h ic"><?php echo $treatment_info['name']; ?>とは？</h3>
							<div class="content_box dis_wrap">
								<div class="dis">
									<div class="box_inner">
										<p><?php echo nl2br($treatment_info['contents']); ?></p>
									</div>
								</div>
							</div>
							<div class="column">
								<ul>
									<li class="block">
										<article class="article--pre_search_detail">
											<h4 class="add_seach_h"><?php echo $treatment_info['name']; ?>で絞り込む</h4>
											<div class="prefectures_box">
												<div class="prefectures_detail">
												<?php foreach ($getCity as $key => $value) : ?>
												<dl>
													<dt class="toptext_<?php echo $value['alph_name']; ?>"><a href="<?php echo base_url(); ?>treatment_<?php echo $treatment; ?>/<?php echo $value['alph_name']; ?>/"><?php echo $value['name']; ?></a></dt>
													<dd>
														<ul>
														<?php
															$city_group_id = $value['id'];
															foreach ($getCity[$key][$city_group_id] as $value1) :
														?>
															<li><a href="<?php echo base_url(); ?>treatment_<?php echo $treatment; ?>/<?php echo $value['alph_name']; ?>/<?php echo $value1['alph_name']; ?>/"><?php echo $value1['name']; ?></a></li>
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
										<?php if ($treatment_info['contents3'] != '') : ?>
										<div class="column_inner">
											<h4 class="rec_job_h ic">おすすめ業種</h4>
											<div class="content_box rec cf">
												<div class="box_inner"><?php echo $treatment_info['contents3']; ?></div>
											</div>
										</div>
										<?php endif; ?>
									</li>
									<li class="block">
										<?php if ($treatment_info['contents2'] != '') : ?>
										<h4 class="type_h ic">こんな人におすすめ</h4>
										<div class="content_box type cf">
											<div class="box_inner">
												<p><?php echo nl2br($treatment_info['contents2']); ?></p>
											</div>
										</div>
										<?php endif; ?>
									</li>
								</ul>
							</div>
						</section>
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
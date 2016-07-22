<?php if (isset($articles) && $articles && count($articles) > 0) { ?>
<section class="section--pickup_store m_t_30">
	<div class="container">
		<h3><i class="fa fa-exclamation-circle"></i>&nbsp;新着急募情報&nbsp;<i class="fa fa-exclamation-circle"></i></h3>
	</div>

	<div class="slider_overlay m_b_20">
		<div class="slider_wrap">
			<div class="slider" id="slider_pickup_store">
			    <?php foreach ($articles as $data) :?>
					<div class="slider_item">
						<a href="<?php echo '/user/joyspe_user/company/' .$data['ors_id']; ?>/">
							<div class="store_box_2">
							<?php
/*
								<?php if ($data['main_image'] != 0 && $data['image' . $data['main_image']] ) : ?>
									<img class="banner" src="<?php echo base_url().'public/owner/uploads/images/'.$data['image'.$data['main_image']]; ?>" alt="<?php echo ($data['storename'] != '')?$data['storename']:'&nbsp;'; ?>">
								<?php else : ?>
									<img class="banner" src="<?php echo base_url() . 'public/owner/images/no_image_top.jpg'; ?>" alt="<?php echo ($data['storename'] != '')?$data['storename']:'&nbsp;'; ?>">
								<?php endif; ?>
*/
							?>
								<h4 class="store_name t_truncate"><?php echo ($data['storename'] != '')? $data['storename']:'&nbsp;'; ?></h4>
								<p class="desc t_truncate"><?php echo ($data['message'] != '')? mb_strimwidth($data['message'], 0, 44, "...", "utf8"):'&nbsp;'; ?></p>
								<div class="store_data">
									<table>
										<tbody>
											<tr>
												<th>職種</th>
												<td><p class="t_truncate"><?php echo ' '.$data['job_name']; ?></p></td>
											</tr>
											<?php
/*
											<tr>
												<th>応募資格</th>
												<td><p class="t_truncate"><?php echo ' '.$data['con_to_apply']; ?></p></td>
											</tr>
											<tr>
												<th>給与</th>
												<td><p class="t_truncate"><?php echo ' '.$data['salary']; ?></p></td>
											</tr>
*/
											?>
											<tr>
												<th>勤務地</th>
												<td><p class="t_truncate"><?php echo ' '.$data['town_name']; ?></p></td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</a>
					</div><!--// slider_item-->
			    <?php endforeach; ?>

			</div><!-- // .slider -->
		</div><!-- // .slider_wrap -->
	</div><!-- // .slider_overlay -->
</section>
<?php } ?>

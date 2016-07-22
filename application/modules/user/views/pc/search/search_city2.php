
<section class="section--area_search <?php echo $groupCity_info['alph_name']; ?>">
	<h1 class="m_b_20"><?php echo $groupCity_info['name']; ?>エリア</h1>
	<div class="area_wrap">
		<div class="area_navi">
			<ul>
			<?php foreach($getCityGroup as $key => $value) :
				$active = ($value['alph_name'] == $group_city) ? 'active':'';
			?>
				<li class="area_<?php echo $value['alph_name'];?> <?php echo $active; ?>"><a href="<?php echo base_url().'user/jobs/'.$value['alph_name']; ?>" class="ui_btn"><?php echo $value['name'];?></a></li>
			<?php endforeach; ?>
			</ul>
		</div>
		<div class="area_detail city">
		    <?php foreach ($city_towns as $key => $value1): ?>
		    <?php // get the array of city infor with key = city_id
			$city_towns_array[$value1['id']] = $value1;
			?>
		    <?php endforeach; ?>

			<p class="area_ttl">表示したいエリアを選択して下さい</p>
			<div class="left_box">
				<ul class="area_map">
					<?php foreach ($getCity as $key => $value1):?>
						<li class="<?php echo $value1['alph_name']; echo ($city_towns_array[$value1['id']]['count_all_owners'] > 0) ? ' on': ''; ?>">
							<a href="<?php echo base_url().'user/jobs/'.$group_city; ?>/<?php echo $value1['alph_name']; ?>/"><?php echo $value1['name']; ?></a>
						</li>
					<?php endforeach ?>
				</ul>
			</div>
			<div class="right_box">
				<?php foreach ($city_towns as $key1 => $value1): ?>
				<dl>
					<dt>
						<span>
						<a href="<?php echo base_url().'user/jobs/'.$group_city; ?>/<?php echo $value1['alph_name']; ?>/" class="<?php echo ($value1['count_all_owners'] > 0)? ' on': ' off';?>"><?php echo $value1['name']; ?></a>
						</span>
					</dt>
					<dd>
						<ul>
							<?php foreach ($value1['towns'] as $key2 => $value2): ?>
							<li>
							<a href="<?php echo base_url().'user/jobs/'.$group_city.'/'.$value1['alph_name'].'/'.$value2['alph_name'].'/' ?>" class="<?php echo ($value2['owners_count'] > 0)? : ' off' ; ?>" ><?php echo $value2['name']; ?></a>
							</li>
							<?php endforeach; ?>
						</ul>
					</dd>
				</dl>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</section>

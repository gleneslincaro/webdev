<?php
	if (isset($data['job_type_alph_name'])) {
		$job_type_alph_name = array($data['job_type_alph_name']);
	} else {
		$job_type_alph_name = array();
		if (isset($cate_alph_name)) {
			$job_type_alph_name = $cate_alph_name;
		}

		$data['group_alph_name'] = $group_city;
		$data['city_alph_name'] = $city;
		$data['town_alph_name'] = $town;
		$data['town_name'] = $town_info['name'];
	}
?>
<?php if (count($jobs_in_town) > 1) {
$town_url  = base_url() . "user/jobs/" . $data['group_alph_name'] . "/" . $data['city_alph_name'] . "/" . $data['town_alph_name'];
?>
<div class="rel_link rel_link-job_type box_wrap box_wrap-gray">
	<h3 class="box_ttl"><?php echo $data['town_name']; ?>の違う業種で探す</h3>
	<div class="box_inner">
		<ul>
			<?php
			foreach ($jobs_in_town as $job) {
				if (!in_array($job['job_alp_name'], $job_type_alph_name)) {
					$get_param = "?cate=" . $job['job_alp_name'];
			?>
			<li><a href="<?php echo $town_url . $get_param; ?>"><?= $job['job_name']; ?></a></li>
			<?php
				}
			}
			?>
		</ul>
	</div>
</div>
<?php
} ?>

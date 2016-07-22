<?php
    $no_area = false;
    if (!is_array($this_town_id)) {
        $town_alph_name = array($town_alph_name);
    } else {
        $data['group_alph_name'] = $group_city;
        $data['city_alph_name'] = $city;
        if (count($towns) <= count($town_alph_name)) {
            $no_area = true;
        }
    }
?>
<?php if (count($towns) > 1 && isset($this_town_id) && isset($this_town_name) && $no_area == false) :?>
<div class="rel_link rel_link-area box_wrap box_wrap-gray">
	<h3 class="box_ttl"><?php echo $this_town_name; ?>の周辺エリアから探す</h3>
	<div class="box_inner">
		<ul>
            <?php
                foreach ($towns as $key_id => $field) :?>
                <?php if (!in_array($field['alph_name'], $town_alph_name)) :?>
                    <li><a href="<?php echo base_url(); ?>user/jobs/<?php echo $data['group_alph_name']; ?>/<?php echo $data['city_alph_name']; ?>/<?php echo $field['alph_name']; ?>/"><?php echo $field['name']; ?></a></li>
                <?php endif; ?>
            <?php endforeach; ?>
		</ul>
	</div>
</div>
<?php endif; ?>

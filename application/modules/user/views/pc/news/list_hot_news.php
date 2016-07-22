<ul>
<?php foreach($listnews as $data => $v) : ?>
	<li><a href="<?php echo base_url().'user/info_detail/'.$v['id']; ?>/">
		<p><span class="post_date"><?php echo date('Y年n月j日', strtotime($v['created_date'])); ?></span></p>
		<p><span class="info_ttl"><?php echo $v['title']?></span></p>
		</a>
	</li>
<?php endforeach; ?>
</ul>

<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
<?php foreach ($cityGroup_ar as $data) : ?>
<url>
<loc><?php echo base_url(); ?>user/jobs/<?php echo $data['alph_name']; ?>/</loc>
</url>
<?php endforeach; ?>
<?php foreach ($city_ar as $data) : ?>
<url>
<loc><?php echo base_url(); ?>user/jobs/<?php echo $data['alph_name']; ?>/</loc>
</url>
<?php endforeach; ?>
<?php foreach ($town_ar as $data) : ?>
<url>
<loc><?php echo base_url(); ?>user/jobs/<?php echo $data['alph_name']; ?>/</loc>
</url>
<?php endforeach; ?>
<?php foreach ($city_cate_ar as $data) : ?>
<url>
<loc><?php echo base_url(); ?><?php echo $data['alph_name']; ?></loc>
</url>
<?php endforeach; ?>
<?php foreach ($city_treatment_ar as $data) : ?>
<url>
<loc><?php echo base_url(); ?><?php echo $data['alph_name']; ?></loc>
</url>
<?php endforeach; ?>
<?php foreach ($town_cate_ar as $data) : ?>
<url>
<loc><?php echo base_url(); ?>user/jobs/<?php echo $data['alph_name']; ?></loc>
</url>
<?php endforeach; ?>
<?php foreach ($town_treatment_ar as $data) : ?>
<url>
<loc><?php echo base_url(); ?>user/jobs/<?php echo $data['alph_name']; ?></loc>
</url>
<?php endforeach; ?>
</urlset>

<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
<?php foreach ($shop_ar as $data) : ?>
<url>
<loc><?php echo $data['url']; ?>/</loc>
</url>
<?php endforeach; ?>
<?php foreach ($shop_qa_ar as $data) : ?>
<url>
<loc><?php echo $data['url']; ?>/</loc>
</url>
<?php endforeach; ?>
</urlset>

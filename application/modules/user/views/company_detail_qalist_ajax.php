<?php foreach ($owner_faq_ar as $entry): ?>
<li><a href="<?php echo base_url().'user/joyspe_user/company/'.$ors_id.'/'.$entry['reply_category_id'].'/'.$entry['id'];?>"><?php echo $entry['content']; ?></a></li>
<?php endforeach; ?>

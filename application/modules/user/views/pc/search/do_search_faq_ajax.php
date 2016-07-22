<?php foreach($category_message_ar as $data) : ?>
<li><a href="<?php echo base_url().'user/joyspe_user/company/'.$data['owr_id'].'/'.$data['reply_category_id'].'/'.$data['id']; ?>"><? echo $data['content']; ?></a></li>
<?php endforeach; ?>
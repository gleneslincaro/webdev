<!--
<script type="text/javascript" src="<?php echo base_url(); ?>public/user/js/jquery-ui.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>public/user/css/jquery-ui.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>public/user/css/interviewer.css" />
-->
<!--
<script type="text/javascript">
    var baseUrl = '<?php echo base_url(); ?>';
    var ors_id = '<?php echo $ors_id; ?>';
    var user_id = '<?php echo (isset($user_id)? $user_id: "" ); ?>';
    var owner_id = '<?php echo $owner_id; ?>';
    var campaign_id = '<?php echo (isset($campaign_id))?$campaign_id:''; ?>';
    var campaignBonusRequestId = '<?php echo (isset($campaignBonusRequest))?$campaignBonusRequest["id"]:''; ?>';
    var getUrl = "<?php echo base_url(); ?>";
</script>
-->
<!-- <script type="text/javascript" src="<?php echo base_url(); ?>public/user/js/send_message.js?v=20150609" ></script>  -->
<?php if(isset($message)) : ?>
    <div class="center">
        <br /><br /><br />
        <b><?php echo $message; ?></b>
        <br /><br />
    </div>
<?php endif; ?>
<script type="text/javascript" src="<?php echo base_url(); ?>public/user/js/company_detail.js?v=20150630" ></script>
<?php foreach ($company_data as $data) : ?>
    <section class="section section--store cf">
        <ul class="mybreadcrumb">
            <li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="<?php echo base_url(); ?>" itemprop="url"><span itemprop="title">TOP</span></a></li>
			<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="<?php echo base_url(); ?>user/jobs/<?php echo $data['group_alph_name']; ?>/" itemprop="url"><span itemprop="title"><?php echo $data['group_name']; ?></span></a></li>
            <li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="<?php echo base_url(); ?>user/jobs/<?php echo $data['group_alph_name']; ?>/<?php echo $data['city_alph_name']; ?>/" itemprop="url"><span itemprop="title"><?php echo $data['city_name']; ?></span></a></li>
            <li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="<?php echo base_url(); ?>user/jobs/<?php echo $data['group_alph_name']; ?>/<?php echo $data['city_alph_name']; ?>/<?php echo $data['town_alph_name']; ?>/" itemprop="url"><span itemprop="title"><?php echo $data['town_name']; ?></span></a></li>
            <li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="<?php echo base_url(); ?>user/jobs/<?php echo $data['group_alph_name']; ?>/<?php echo $data['city_alph_name']; ?>/<?php echo $data['town_alph_name']; ?>/?cate=<?php echo $data['job_type_alph_name']; ?>" itemprop="url"><span itemprop="title"><?php print_r($data['jobtypename'][0]['name']);?></span></a></li>
        </ul>
        <div class="store_title">
            <h2><?php echo $company_data[0]['storename'];?></h2>
        </div>
        <div class="slider slider--store_main" id="slider--store_main">
            <ul>
                <li>
                    <figure class="banner">
                        <?php if ($data['main_image'] != 0 && $data['image' . $data['main_image']] ) : ?>
                            <img width="350px" src="<?php echo base_url().'public/owner/uploads/images/'.$data['image'.$data['main_image']]; ?>" alt="<?php echo $data['storename']; ?>" />
                        <?php else : ?>
                            <img width="350px" src="<?php echo base_url() . 'public/owner/images/no_image_top.jpg'; ?>" alt="<?php echo $data['storename']; ?>" />
                        <?php endif; ?>
                    </figure>
                </li>
                <?php for ($i = 1; $i<=6; $i++) : ?>
                    <?php if ($data['image'.$data['main_image']] != $data['image'.$i] && $data['image'.$i] != '') : ?>
                    <li>
                        <figure class="banner">
                            <?php if($data['image'.$i] ) : ?>
                                <img width="350px" src="<?php echo base_url().'public/owner/uploads/images/'.$data['image'.$i]; ?>" alt="<?php echo $data['storename']; ?>" />
                            <?php else : ?>
                                <img width="350px" src="<?php echo base_url() . 'public/owner/images/no_image_top.jpg'; ?>" alt="<?php echo $data['storename']; ?>" />
                        <?php endif; ?>
                        </figure>
                    </li>
                    <?php endif; ?>
                <?php endfor; ?>
            </ul>
        </div>
        <div class="store_comment">
            <p class="store_treatment"><?php echo (isset($data['salary']) && $data['salary'])?$data['salary']:''; ?></p>
            <p class="store_purpose"><?php echo (isset($data['title']) && $data['title'])?nl2br($data['title']):'';?></p>
        </div>
    </section>

    <section class="section section--everyone_qa pb_5 cf">
        <p class="store_name"><a href="<?php echo base_url().'user/joyspe_user/company/'.$ors_id.'/';?>" class="t_link"><?php echo $company_data[0]['storename'];?>の求人を見る</a></p>
        <div class="everyone_qa_detail cf">
            <h3 class="category_detail_ttl"><strong><?php echo $owner_faq_ar['content'];?></strong></h3>
            <p class="answer_sup cf">
                <span class="answer_day"><?php echo $owner_faq_ar['created_date']; ?></span>
            </p>
            <p class="answer_comment"><?php echo $owner_faq_ar['reply_content'];?></p>
            <a href="<?php echo base_url().'user/joyspe_user/company/'.$ors_id.'/'.$owner_faq_ar['reply_category_id'];?>" class="t_link"><?php echo $owner_faq_ar['reply_category_name'];?></a>
        </div>
    </section>
	<section class="section section--everyone_qa_category pb_10 cf">
		<div class="section_inner">
			<div class="everyone_qa_category">
				<h3 class="section_item_ttl"><img src="<?php echo base_url(); ?>public/user/image/icon_qa.png"><strong>みんなの質問</strong>カテゴリー</h3>
				<ul>
                <?php foreach ($category_message_num as $entry) : ?>
                    <li><a class="t_link" href="<?php echo base_url().'user/joyspe_user/company/'.$ors_id.'/'.$entry['id'];?>"><?php echo $entry['name'].'('.$entry['count'].')'; ?></a></li>
                <?php endforeach; ?>
				</ul>
			</div>
		</div>
	</section>

<?php endforeach; ?>
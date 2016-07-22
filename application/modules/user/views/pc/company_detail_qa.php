<script type="text/javascript" src="<?php echo base_url(); ?>public/user/js/jquery-ui.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>public/user/css/jquery-ui.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>public/user/css/interviewer.css" />
<script type="text/javascript" src="<?php echo base_url(); ?>public/user/js/company_detail.js"></script>
<script type="text/javascript">
    var page_line_max = '<?php echo $page_line_max; ?>';
    var category_id = '<?php echo $current_cate['id']; ?>';
    var baseUrl = '<?php echo base_url(); ?>';
    var ors_id = '<?php echo $ors_id; ?>';
    var user_id = '<?php echo (isset($user_id)? $user_id: "" ); ?>';
    var owner_id = '<?php echo $owner_id; ?>';
    var campaign_id = '<?php echo (isset($campaign_id))?$campaign_id:''; ?>';
    var campaignBonusRequestId = '<?php echo (isset($campaignBonusRequest))?$campaignBonusRequest["id"]:''; ?>';
    var getUrl = "<?php echo base_url(); ?>";
</script>
<script type="text/javascript" src="<?php echo base_url(); ?>public/user/js/send_message.js?v=20150726" ></script>
<script type="text/javascript" src="<?php echo base_url(); ?>public/user/js/company_detail_qalist.js?v=20160216" ></script>
<style>
#campaingn_bonus_date {
  text-align: center;
  background: #fff;
  padding: 10px;
  display: none;
}
#campaingn_bonus_date div {
  text-align: right;
  padding: 0 0 20px 0;
  font-weight: bold;
  font-size: 25px;
}
#campaingn_bonus_date input {
  width: 175px;
}
</style>
    <?php $this->load->view('user/pc/header/header'); ?>
    <section class="section--main_content_area">
    <?php foreach ($company_data as $data) : ?>
        <div class="container cf">
            <section class="section--store_detail">
                <div class="m_b_20">
                    <a href="<?php echo base_url().'user/joyspe_user/company/'.$ors_id.'/';?>" class="ui_btn ui_btn--bg_brown btn_back">戻る</a>
                </div>

                <div class="top_info_1 cf">
                    <?php //$this->load->view('user/pc/search/store_detail/special_phrase'); ?>
                    <h1 class="store_name"><!-- <span class="tag tag-new">NEW</span>--><?php echo $company_data[0]['storename'];?></h1>
                    <div class="col_wrap">
                        <div class="col_left">
                            <div class="slider_wrap">
                                <ul class="slider_store_banner" id="slider_store_banner">
                                <li>
                                    <?php if ($data['main_image'] != 0 && $data['image' . $data['main_image']] ) : ?>
                                        <img src="<?php echo base_url().'public/owner/uploads/images/'.$data['image'.$data['main_image']]; ?>" alt="<?php echo $data['storename']; ?>" />
                                    <?php else : ?>
                                        <img width="350px" src="<?php echo base_url() . 'public/owner/images/no_image_top.jpg'; ?>" alt="<?php echo $data['storename']; ?>" />
                                    <?php endif; ?>
                                </li>
                                <?php for ($i = 1; $i<=6; $i++) : ?>
                                    <?php if ($data['image'.$data['main_image']] != $data['image'.$i] && $data['image'.$i] != '') : ?>
                                    <li>
                                        <?php if($data['image'.$i] ) : ?>
                                                <img  src="<?php echo base_url().'public/owner/uploads/images/'.$data['image'.$i]; ?>" alt="<?php echo $data['storename']; ?>" />
                                        <?php else : ?>
                                                <img  src="<?php echo base_url() . 'public/owner/images/no_image_top.jpg'; ?>" alt="<?php echo $data['storename']; ?>" />
                                        <?php endif; ?>
                                    </li>
                                    <?php endif; ?>
                                <?php endfor; ?>
                                </ul>
                            </div>
                        </div><!-- // .col_left -->
                        <div class="col_right">
                            <p class="desc_1"><?php echo (isset($data['title']) && $data['title'])?nl2br($data['title']):'';?></p>
                            <div class="data_1">
                                <dl>
                                    <dt>給料</dt>
                                    <dd><?php echo nl2br($data['salary']); ?></dd>
                                </dl>
                            </div>
                        </div><!-- // .col_right -->
                    </div><!-- // .col_wrap -->
                </div><!-- // .top_info_1 -->

                <div class="everyone_qa_detail m_b_30">
                    <h3 class="category_detail_ttl"><strong><?php echo $owner_faq_ar['content'];?></strong></h3>
                    <p class="answer_comment"><?php echo $owner_faq_ar['reply_content'];?></p>
                    <p class="answer_sup">
                    <span class="answer_day"><?php echo $owner_faq_ar['created_date']; ?></span>
                    <a href="<?php echo base_url().'user/joyspe_user/company/'.$ors_id.'/'.$owner_faq_ar['reply_category_id'];?>" class="t_link">このお店のみんなの質問：<?php echo $owner_faq_ar['reply_category_name'];?>一覧</a>
                    </p>
                </div>

                <p>
                    <a href="<?php echo base_url().'user/joyspe_user/company/'.$ors_id.'/';?>" class="t_link"><?php echo $company_data[0]['storename'];?>求人へ戻る</a>
                </p>
                <br>
                <div class="everyone_qa box_wrap m_b_30">
                    <h2 class="ttl box_ttl ic ic-qa"><strong>みんなの</strong>質問カテゴリー</h2>
                    <div class="box_inner">
                        <ul class="everyone_qa_search_list">
                            <?php foreach($category_message_num as $key => $entry) : ?>
                            <?php if($entry['name'] == '全て') : ?>
                            <li><a href="<?php echo base_url().'user/joyspe_user/company/'.$ors_id.'/'.$entry['id'];?>" class="t_link"><?php echo $company_data[0]['storename'];?>の<strong><?php echo $entry['name']; ?></strong>の質問一覧（<strong><?php echo $entry['count']; ?></strong>）</a></li>
                            <?php else: ?>
                            <li><a href="<?php echo base_url().'user/joyspe_user/company/'.$ors_id.'/'.$entry['id'];?>" class="t_link"><?php echo $company_data[0]['storename'];?>の<strong>【<?php echo $entry['name']; ?>】</strong>に関する質問一覧（<strong><?php echo $entry['count']; ?></strong>）</a></li>
                            <?php endif; ?>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>

            </section>
        <div id="campaingn_bonus_date">
            <div><button onclick="return close_dialog()" id="btnclose" class="j-ui-x-button c_pointer">×</button></div>
            来店日付 <input type="text" id="txtDateFrom" name="daterequest" placeholder="YYYY/MM/DD"><br><br>
        </div>
        <?php $this->load->view('user/pc/template/send_message'); ?>
        </div><!-- // .container -->
    <?php endforeach; ?>
    </section>
<?php $this->load->view('user/pc/share/script'); ?>
<script src="<?php echo base_url().'public/user/pc/'; ?>js/jquery.bxslider.js"></script>
<script>
$(function(){
    /*---------------------------------------*/
    // slider senior
    /*---------------------------------------*/
<?php if (isset($tab_senior_flag) && isset($owner_senior_profile)) :
    $profile_count = count($owner_senior_profile);
        if ($profile_count > 2) :
?>
    $(document).ready(function(){
		if($('#slider_senior .senior_box').length < 4 ){
			$('#slider_senior').bxSlider({
				pager: false,
				auto: false,
				pause: 6000,
				speed: 500,
				infiniteLoop: false
			});
		} else {
			$('#slider_senior').bxSlider({
				pager: false,
				auto: false,
				pause: 6000,
				speed: 500,
				infiniteLoop: true,
			});
		}
    });
<?php   endif;
endif; ?>
    /*---------------------------------------*/
    // slider store banner
    /*---------------------------------------*/
    $(document).ready(function(){
        $('#slider_store_banner').bxSlider({
            pager: true,
            controls: false,
            auto: false,
            pause: 6000,
            speed: 500
        });
    });
});
</script>

<script type="text/javascript">
    var search_area = "<?php echo (isset($groupCity_info) && isset($city_info) && isset($arrTownId)? '&cityGroup=' . $groupCity_info['id'] . '&city=' .  $city_info['id'] . '&town=' . $arrTownId . '&treatment=' . $arrTreatment . '&cate=' . $arrCate : '' );?>";
    var controller_name = "<?php echo $this->router->fetch_class(); ?>";
    var base_url = "<?php echo base_url(); ?>";
    var ajax_load_more = "<?php echo isset($ajax_load_more)?$ajax_load_more:''; ?>";
    var page_line_max = '<?php echo $page_line_max; ?>';
</script>
<!-- <script type="text/javascript" src="<?php echo base_url(); ?>public/user/js/show_more_store.js?v=20150522"></script>  -->
<script type="text/javascript" src="<?php echo base_url(); ?>public/user/js/do_search_faq.js?v=20160216"></script>
<ul class="mybreadcrumb pagebody--white">
    <li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="<?php echo base_url();?>" itemprop="url"><span itemprop="title">TOP</span></a></li>
    <li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="<?php echo base_url().'user/jobs/'.$group_city.'/'; ?>" itemprop="url"><span itemprop="title"><?php echo $groupCity_info['name']; ?></span></a></li>
    <li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="<?php echo base_url().'user/jobs/'.$group_city.'/'.$city.'/'; ?>" itemprop="url"><span itemprop="title"><?php echo $city_info['name']; ?></span></a></li>
    <li class="active"><?php echo $breadText; ?></li>
</ul>
    <section class="section section--everyone_qa pb_5 cf">
        <p class="store_name"><a href="<?php echo base_url().'user/jobs/'.$group_city.'/'.$city.'/'.$town.'/'; ?>" class="t_link"><?php echo $town_name; ?>の求人一覧に戻る</a></p>
        <div class="everyone_qa_detail">
            <h3 class="category_list_ttl"><?php echo $town_name; ?>のみんなの質問：<strong><?php echo $current_category['name']; ?></strong></h3>
            <div class="category_list_pager">
                <input type="hidden" name="cate_all_count" value="<?php echo $cate_all_count; ?>">
                <input type="hidden" name="page_max" value="<?php echo $page_max; ?>">
                <input type="hidden" name="category_list_page_num" value="1">
                <input type="hidden" name="owners_json" value='<?php echo $owners_json; ?>'>
                <p><strong>1 - 10</strong> / <?php echo $cate_all_count; ?>件中</p>
                <ul class="pager_nav">
                    <li><a class="pager_left" href="<?php echo base_url().'user/faq/'.$group_city.'/'.$city.'/'.$town.'/?c='.$default_category_id; ?>"><i class="fa fa-chevron-left"></i></a></li>
                    <li><a class="pager_right" href="<?php echo base_url().'user/faq/'.$group_city.'/'.$city.'/'.$town.'/?c='.$default_category_id; ?>"><i class="fa fa-chevron-right"></i></a></li>
                </ul>
            </div>
            <ul class="everyone_qa_category_list">
                <?php foreach($category_message_ar as $data) : ?>
                <li><a href="<?php echo base_url().'user/joyspe_user/company/'.$data['owr_id'].'/'.$data['reply_category_id'].'/'.$data['id']; ?>"><? echo $data['content']; ?></a></li>
                <?php /*  ここに挿入される  /application/modules/user/views/search/do_search_faq_ajax.php */ ?>
                <?php endforeach; ?>
            </ul>

            <div class="category_list_pager">
                <p><strong>1 - 10</strong> / <?php echo $cate_all_count; ?>件中</p>
                <ul class="pager_nav">
                    <li><a class="pager_left" href="<?php echo base_url().'user/faq/'.$group_city.'/'.$city.'/'.$town.'/?c='.$default_category_id; ?>"><i class="fa fa-chevron-left"></i></a></li>
                    <li><a class="pager_right" href="<?php echo base_url().'user/faq/'.$group_city.'/'.$city.'/'.$town.'/?c='.$default_category_id; ?>"><i class="fa fa-chevron-right"></i></a></li>
                </ul>
            </div>
        </div>
    </section>
    <section class="section section--everyone_qa_category pb_5 cf">
        <div class="section_inner">
            <div class="everyone_qa_category">
                <h3 class="section_item_ttl"><img src="/public/user/image/icon_qa.png" alt=""><?php echo $town_name; ?>の<strong>みんなの質問</strong>を探す</h3>
                <ul>
                <?php foreach($category_message_num as $key => $data) : ?>
                    <li><a class="t_link" href="<?php echo base_url().'user/faq/'.$group_city.'/'.$city.'/'.$town.'/?c='.$key; ?>"><?php echo $data['name'].'('.$data['count'].')'; ?></a></li>
                <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </section>

    <section class="section section--refine_search cf">
    <?php $this->load->view('user/search/refin'); ?>
    </section>


<?php if (!isset($city)) : ?>
<?php echo $this->load->view("user/template/campaign_banner.php"); ?>
<?php endif; ?>
<?php $this->load->view("user/template/search_contents.php"); ?>

<?php if (isset($town_curr_event_info)) { ?>
<section class="section section--town_introduction cf">
    <div class="section_inner">
        <div class="links_box">
            <p>鶴岡で働く前にしっておきたいこと</p>
            <a href="<?=$tsuruoka_top_link.'fuuzokudekasegi' ?>">一度ハマルと長居してしまう鶴岡での出稼ぎ</a>
            <a href="<?=$tsuruoka_top_link.'fuuzokukasegeru' ?>">鶴岡の風俗は稼げる</a>
        </div>
        <div class="links_box">
            <p>出稼ぎ向け情報</p>
            <a href="<?=$tsuruoka_top_link.'dekasegishousai' ?>">鶴岡市の平均家賃、平均時給、物価、都心からの交通（交通費）</a>
        </div>
        <div class="links_box">
            <p>お子さんをお持ちのお母さんやシングルマザー必見！</p>
            <a href="<?=$tsuruoka_top_link.'fuuzokutakujisho' ?>">鶴岡市の託児所や保育園の調査結果</a>
        </div>
        <div class="links_box">
            <p>イベント情報</p>
            <p><?php echo nl2br($town_curr_event_info); ?></p>
        </div>
    </div>
</section>
<?php } ?>

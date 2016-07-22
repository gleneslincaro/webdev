<script type="text/javascript">
    var search_area = "<?php echo (isset($groupCity_info) && isset($city_info) && isset($arrTownId)? '&cityGroup=' . $groupCity_info['id'] . '&city=' .  $city_info['id'] . '&town=' . $arrTownId . '&treatment=' . $arrTreatment . '&cate=' . $arrCate : '' );?>";
    var controller_name = "<?php echo $this->router->fetch_class(); ?>";
    var base_url = "<?php echo base_url(); ?>";
    var ajax_load_more = "<?php echo isset($ajax_load_more)?$ajax_load_more:''; ?>";
    var page_line_max = '<?php echo $page_line_max; ?>';
</script>
<script type="text/javascript" src="<?php echo base_url(); ?>public/user/js/show_more_store.js?v=20150522"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>public/user/js/do_search_faq.js?v=20160218"></script>
<?php
    $this->load->view('user/pc/header/header');
    $section_area = '';
    if (isset($getCity)) {
        $section_area = 'city';
    }
?>
    <section class="section--main_content_area">
        <div class="container cf">
            <div class="m_b_20">
                <a href="<?php echo base_url().'user/jobs/'.$group_city.'/'.$city.'/'.$town.'/'; ?>" class="ui_btn ui_btn--bg_brown btn_back">戻る</a>
            </div>
            <div class="f_left <?php echo $section_area; ?>">
                <div class="everyone_qa_list m_b_30">
                    <h3 class="category_list_ttl"><?php if($breadText=='検索結果'){echo $city_info['name'].'の複数地域';}else{echo $breadText;}?>のお店のみんなの質問：<strong><?php echo $current_category['name']; ?></strong></h3>
                    <div class="category_list_pager">
                        <input type="hidden" name="cate_all_count" value="<?php echo $cate_all_count; ?>">
                        <input type="hidden" name="page_max" value="<?php echo $page_max; ?>">
                        <input type="hidden" name="category_list_page_num" value="1">
                        <input type="hidden" name="owners_json" value='<?php echo $owners_json; ?>'>
                        <p><strong>1 - 10</strong> / <?php echo $cate_all_count; ?>件中</p>
                        <ul class="pager_nav">
                            <li><a class="pager_left" href=""><i class="fa fa-chevron-left"></i></a></li>
                            <li><a class="pager_right" href=""><i class="fa fa-chevron-right"></i></a></li>
                        </ul>
                    </div>
                    <ul class="everyone_qa_category_list">
                    <?php /*  ここに挿入される  /application/modules/user/views/pc/search/do_search_faq_ajax.php */ ?>
                    </ul>
                    <div class="category_list_pager">
                        <p><strong>1 - 10</strong> / <?php echo $cate_all_count; ?>件中</p>
                        <ul class="pager_nav">
                            <li><a class="pager_left" href=""><i class="fa fa-chevron-left"></i></a></li>
                            <li><a class="pager_right" href=""><i class="fa fa-chevron-right"></i></a></li>
                        </ul>
                    </div>
                </div>

            </div>
            <div class="f_right">
                <?php $this->load->view('user/pc/share/aside'); ?>
            </div>
        </div>

        <div class="container section--store_detail">
            <section class="section--store_detail m_b_30">
                <div class="everyone_qa box_wrap">
                    <h2 class="ttl box_ttl ic ic-qa"><?php if($breadText=='検索結果'){echo $city_info['name'].'の複数地域';}else{echo $breadText;}?>の<strong>みんなの質問</strong>を探す</h2>
                    <div class="box_inner">
                        <ul class="everyone_qa_search_list">
                            <?php foreach($category_message_num as $key => $data) : ?>
                            <li><a href="<?php echo base_url().'user/faq/'.$group_city.'/'.$city.'/'.$town.'/?c='.$key; ?>" class="t_link"><strong>【<?php echo $data['name']; ?>】</strong>の質問一覧（<strong><?php echo $data['count']; ?></strong>）</a></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </section>
        </div>

    </section>
<?php $this->load->view('user/pc/share/pickup_column'); ?>
<?php $this->load->view('user/pc/share/footer_msg'); ?>

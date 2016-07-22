<script type="text/javascript">
    var search_area = "<?php echo (isset($groupCity_info) && isset($city_info) && isset($arrTownId)? '&cityGroup=' . $groupCity_info['id'] . '&city=' .  $city_info['id'] . '&town=' . $arrTownId . '&treatment=' . $arrTreatment . '&cate=' . $arrCate : '' );?>";
    var controller_name = "<?php echo $this->router->fetch_class(); ?>";
    var base_url = "<?php echo base_url(); ?>";
    var ajax_load_more = "<?php echo isset($ajax_load_more)?$ajax_load_more:''; ?>";
</script>
<script type="text/javascript" src="<?php echo base_url(); ?>public/user/js/show_more_store.js?v=20150522"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>public/user/js/do_search.js?v=20150525"></script>
<ul class="mybreadcrumb pagebody--white">
    <li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="<?php echo base_url();?>" itemprop="url"><span itemprop="title">TOP</span></a></li>
    <?php if (isset($getTowns)) : ?>
    <li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="../" itemprop="url"><span itemprop="title"><?php echo $groupCity_info['name']; ?></span></a></li>
    <li class="active"  itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><span itemprop="title"><?php echo $city_info['name']; ?></span></li>

    <?php elseif (isset($storeOwner)) : ?>
    <li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="../../" itemprop="url"><span itemprop="title"><?php echo $groupCity_info['name']; ?></span></a></li>
    <li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="../" itemprop="url"><span itemprop="title"><?php echo $city_info['name']; ?></span></a></li>
    <li class="active"><?php echo $breadText; ?></li>
    <?php else :?>
    <li class="active" itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><span itemprop="title"><?php echo $groupCity_info['name']; ?></span></li>
    <?php endif; ?>
</ul>
<section class="section <?php echo (isset($storeOwner)?'section--search_conf':((!isset($getCity))?'section--city_search':'section--area_search')); ?> cf">
    <?php if (isset($storeOwner)) : ?>
        <div class="content_title">
            <p><span>検索結果内容の確認</span></p>
        </div>
        <div class="box_inner" style="overflow: hidden; display: none;">
            <dl class="box_inner_top">
                <dt>地域</dt>
                <dd class="p13">
                    <?php echo str_replace(",", "、", $town_info['name']);?>
                </dd>
            </dl>
            <?php if($cate || $treatment):?>
            <dl class="box_bottom">
                <dt>絞り込み</dt>
                <dd>
                    <?php if(isset($cate) && $cate):?>
                    <div class="job_category">
                        <p>
                            <strong>・業種</strong> <br/>
                            <?php echo str_replace(",", "、", $cate);?>
                        </p>
                    </div>
                    <?php endif;?>
                    <?php echo (isset($cate) && isset($treatment))?'<hr/>':'';?>
                    <?php if(isset($treatment) && $treatment):?>
                    <div class="job_features">
                        <p>
                            <strong>・特徴</strong> <br/>
                            <?php echo str_replace(",", "、", $treatment);?>
                        </p>
                    </div>
                    <?php endif;?>
                </dd>
            </dl>
            <?php endif;?>
        </div>
    <h2 class="h_ttl_2 pos_parent"><?php echo (isset($town_contents)) ? $town_info['name'].'の':''; ?>検索結果<span class="result_number"><?php echo $count_all; ?></span>件<span class="sort">
    <a id='sendRefin' href="#">絞り込む</a></span>
    </h2>
    <?php else: ?>
    <h2 class="h_ttl_1 ic ic--area_search">エリアから検索</h2>
    <?php endif; ?>
    <?php if (isset($getCity)) : ?>
    <div class="box_inner pb_0 cf pb_20">
        <div class="area_search">
        <h3 class="search_ttl_1"><?php echo $groupCity_info['name']; ?></h3>
            <ul>
                <?php foreach ($getCity as $key) : ?>
                <li><a style="display:block" href="<?php echo base_url(); ?>user/jobs/<?php echo $group_city; ?>/<?php echo $key['alph_name']; ?>/"><?php echo $key['name']; ?></a></li>
            <?php endforeach; ?>
            </ul>
        </div>
    </div>
    <?php endif;
    if (isset($getTowns)) : ?>
    <div class="box_inner pb_20">
        <div class="city_search">
            <h3 class="search_ttl_1"><?php echo $city_info['name']; ?>（<?php echo $owCount; ?>件）</h3>
            <form>
                <div class="city_checkbox">
                    <nav>
                        <ul>
                            <li>
                                <label><span class="checkbox_area pl_15">
                                    <input type="checkbox" id="ck_all" value="all_check">
                                    </span><span class="select_area"><?php echo $city_info['name']; ?>全て</span>
                                </label>
                            </li>
                            <?php
                            foreach ($getTowns as $key) : ?>
                            <li>
                                <label><span class="checkbox_area"><input data-ocount="<?php echo $key['ocount']; ?>" data-id="<?php echo $key['owner_id']; ?>" type="checkbox" value="<?php echo $key['alph_name']; ?>" class="all_check"></span>
                                       <span class="select_area"><?php echo $key['name']; ?></span>
                                </label>
                                <a href="<?php echo base_url().'user/jobs/'.$group_city.'/'.$city.'/'.$key['alph_name'].'/'; ?>"><img src="<?php echo base_url().'public/user/image/follow.png'; ?>" alt="<?php echo $key['name']; ?>"></a>
                            </li>
                        <?php endforeach; ?>
                        </ul>
                    </nav>
                </div>
            </form>
            <div class="city_search_button">
                <a href="#"><p class="ic--area_search"> 検索する（&nbsp;<span class="sCount">0</span>件） </p></a>
            </div>
            <div class="search_button_fix">
                <a href="#"><p class="ic--area_search"> 検索する（&nbsp;<span class="sCount">0</span>件） </p></a>
            </div>
        </div>

    </div>
    <?php endif; ?>
</section>

<?php if (isset($storeOwner)) : ?>

<?php if (isset($getuserInfo) && (time() > mktime(15, 0, 0, 4, 16, 2015))): ?>
    <?php if ($groupCity_info['alph_name'] == 'kanto' && ($getuserInfo['user_from_site'] == '1' || $getuserInfo['user_from_site'] == '2') ) : ?>
<section class="section section--campaign cf">
            <div class="campaign_list">
                <ul>
                    <li><a href="<?php echo base_url(); ?>user/misc/tokyohibarai/"><img class="banner" width="100%" src="<?php echo base_url() . 'public/user/image/tokyohibarai.jpg'; ?>" alt="東京日払いキャンペーン"></a></li>
                </ul>
            </div>
</section>
    <?php endif; ?>
<?php endif; ?>

<section class="section section--jobs cf">
    <div class="box_inner pt_15 pb_7 cf">
        <div class="city_1 cf">
            <input type="hidden" value="<?php echo $count_all?>" id="countall_company_id">
            <ul id="store_list">
                <?php if (count($storeOwner) < 1 || $storeOwner == null): ?>
                    <li class="company_details">お店が見つかりません。</li>
                <?php else: ?>
                    <?php $this->load->view('user/share/company_list'); ?>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</section>

<section class="section section--refine_search cf">
    <?php
        $this->load->view('user/search/refin');
    ?>
</section>
    <div id="loader_wrapper" class="t_center"></div>
    <div class="more mt t_center" id="more_company_id_result">
        <a href="javascript:void(0)" id="more_company_id" name="more_hpm_id">▼次の<?php echo STORE_LIMIT; ?>件を表示</a>
    </div>

<?php if (isset($category_message_ar)) : ?>
<section class="section section--everyone_qa pb_5 cf">
    <div class="everyone_qa_detail cf">
        <h3 class="category_list_ttl mb_10"><strong><?php if($breadText=='検索結果'){echo $city_info['name'].'の複数地域';}else{echo $breadText;}?></strong>：新着みんなの質問</h3>
        <ul class="everyone_qa_category_list">
            <?php foreach($category_message_ar as $data) : ?>
            <li><a href="<?php echo base_url().'user/joyspe_user/company/'.$data['owr_id'].'/'.$data['category_id'].'/'.$data['id'] ?>"><? echo $data['content']; ?></a></li>
            <?php endforeach; ?>
        </ul>
        <p class="t_right mt_10"><a href="<?php echo base_url().'user/faq/'.$group_city.'/'.$city.'/'.$town.'/?c=0'; ?>" class="t_link"><?php if($breadText=='検索結果'){echo $city_info['name'].'の複数地域';}else{echo $breadText;}?>：みんなの質問一覧</a></p>
    </div>
</section>
<?php endif; ?>

<?php if (isset($category_message_num)) : ?>
<section class="section section--everyone_qa_category pb_5 cf">
    <div class="section_inner">
        <div class="everyone_qa_category">
            <h3 class="section_item_ttl"><img src="/public/user/image//icon_qa.png" alt=""><?php echo $breadText; ?>の<strong>みんなの質問</strong>を探す</h3>
            <ul>
                <?php foreach($category_message_num as $key => $data) : ?>
                <li><a class="t_link" href="<?php echo base_url().'user/faq/'.$group_city.'/'.$city.'/'.$town.'/?c='.$key; ?>"><?php echo $data['name'].'('.$data['count'].')'; ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</section>
<?php endif; ?>

<?php endif; ?>

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

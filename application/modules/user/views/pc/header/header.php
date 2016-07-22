<script>
$(function(){
    $('#search_keyword_btn').click(function() {
        $('#search_keyword_form').submit();
    });
});
</script>
<?php
$total_users = HelperGlobal::getUserTotalNumber();
$total_owners = HelperGlobal::gettotalHeader();
?>

<header class="header">
    <div class="container cf">
    <?php if (isset($area_hi)) : ?>
        <div class="left_column">
            <p>
                <a href="/"><img src="<?php echo base_url().'public/user/pc/'; ?>image/header_logo.png" alt="高収入アルバイト情報" /></a>
            </p>
        </div>
        <div  class="center_column">
            <?php  if (!isset($is_top)) : ?>
            <h1><?php echo (isset($area_hi))? $area_hi:''; ?></h1>
            <?php endif; ?>
        </div>
    <?php else: ?>
        <div class="left_column logo">
            <h1>
                <a href="/"><img src="<?php echo base_url().'public/user/pc/'; ?>image/header_logo.png" alt="高収入アルバイト情報" /></a>
            </h1>
        </div>
    <?php endif; ?>
        <div class="right_column">
            <?php if (isset($total_users) && isset($total_owners)) { ?>
            <ul class="header_counter">
                <li class="cnt_member">会員数：<span class="cnt"><?php echo $total_users; ?></span>人</li>
                <li class="cnt_store">掲載店舗数：<span class="cnt"><?php echo $total_owners; ?></span>店舗</li>
                <li class="user_stutas">
                    <?php $user = HelperApp::get_session('user_info');?>
                    <?php if ($user) : ?>
                    <?php
                        $data_from_site = $user['user_from_site'];
                        if ($user['profile_pic']) {
                            $pic_path = getcwd()."/".$this->config->item('upload_userdir').'images/'.$user['profile_pic'];
                            if (file_exists($pic_path)) {
                                $src = base_url().$this->config->item('upload_userdir').'images/'.$user['profile_pic'];
                            } else {
                                if ($data_from_site == 1) {
                                    $src = $this->config->item('machemoba_pic_path').$user['profile_pic'];
                                } else {
                                    $src = $this->config->item('aruke_pic_path').$user['profile_pic'];
                                }
                            }
                        } elseif ($user['profile_pic2']) {
                            $pic_path = getcwd()."/".$this->config->item('upload_userdir').'images/'.$user['profile_pic2'];
                            if (file_exists($pic_path)) {
                                $src = base_url().$this->config->item('upload_userdir').'images/'.$user['profile_pic2'];
                            } else {
                                if ($data_from_site == 1) {
                                    $src = $this->config->item('machemoba_pic_path').$user['profile_pic2'];
                                } else {
                                    $src = $this->config->item('aruke_pic_path').$user['profile_pic2'];
                                }
                            }
                        } elseif ($user['profile_pic3']) {
                            $pic_path = getcwd()."/".$this->config->item('upload_userdir').'images/'.$user['profile_pic3'];
                            if (file_exists($pic_path)) {
                                $src = base_url().$this->config->item('upload_userdir').'images/'.$user['profile_pic3'];
                            } else {
                                if ($data_from_site == 1) {
                                    $src = $this->config->item('machemoba_pic_path').$user['profile_pic3'];
                                } else {
                                    $src = $this->config->item('aruke_pic_path').$user['profile_pic3'];
                                }
                            }
                        } else {
                            $src = base_url().'public/user/image/sample_user.png';
                        }
                    ?>

                    <p class="user_thumbnail">
                    <img src="<?php echo $src; ?>">
                    </p>

                    <p>
                        ようこそ<span><?php echo $user['unique_id']; ?></span>さん
                    </p>
                    <?php endif; ?>
                </li>
            </ul>
            <?php } ?>

            <div class="box_wrap">
                <div class="left_box p_r_20">
                    <ul class="utility_menu">
                        <?php  if (UserControl::LoggedIn() == true) : ?>
                        <li><a href="/user/settings/" class=""><i class="fa fa-cog fa-lg"></i>登録情報確認・変更</a></li>
                        <?php endif; ?>
                        <li><a href="/user/info_list/" class="">お知らせ</a></li>
                        <li><a href="/user/contact/" class="">FAQ / お問い合わせ</a></li>
                    </ul>
                </div>
                <div class="right_box">
                    <ul class="btn_wrap">
                    <?php  if (UserControl::LoggedIn() != true) : ?>
                        <li><a href="<?php echo base_url().'user/login/'; ?>" class="ui_btn ui_btn--bg_green">ログイン</a></li>
                        <li><a href="<?php echo base_url().'user/signup/'; ?>" class="ui_btn ui_btn--bg_magenta">新規会員登録</a></li>
                    <?php endif; ?>
                    <?php  if (UserControl::LoggedIn() == true) : ?>
                        <li></li>
                        <li><a href="javascript:void(0)" id="btn_logout" class="ui_btn ui_btn--bg_brown">ログアウト</a></li>        
                    <?php endif; ?>
                    </ul>
                </div>
            </div>

        </div>


    </div>
    <nav>
        <div class="container">
            <ul>
                <li><a href="/"><i class="fa fa-home fa-lg"></i></a></li>
                <li><a href="/user/bonus/bonus_list/ "><i class="fa fa-subway"></i>ボーナス確認</a></li>
                <li><a href="/user/campaign/ "><i class="fa fa-gift"></i>面接交通費/入店お祝い金申請</a></li>
                <li><a href="/user/message_list/ "><i class="fa fa-envelope"></i>オファーメール</a></li>
                <li><a href="/user/keep_list/ "><i class="fa fa-star"></i>キープ一覧</a></li>
            <?php if (isset($data_from_site ) && $data_from_site != 0) : ?>
                <li><a href="/user/experiences/"><i class="fa fa-pencil-square-o"></i>みんなの体験談</a></li>
            <?php endif; ?>
                <li><a href="/user/dictionary/"><i class="fa fa-book fa-fw"></i>用語辞典</a></li>
            </ul>
        </div>
    </nav>
    <div class="breadcrumb">
        <div class="container">
            <ul>
            <li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="<?php echo base_url();?>" itemprop="url"><span itemprop="title">HOME</span></a></li>
        <?php if (isset($searchRes)) { ?>
            <?php if (isset($keyword)) { ?>
            <li itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
                <span itemprop="title"><?php print_r($keyword); ?></span>
            </li>
            <?php } ?>
        <?php } else if (isset($breadscrumb_array) && is_array($breadscrumb_array)) { ?>
            <?php foreach ($breadscrumb_array as $breadscrumb) : ?>
            <li itemscope itemtype="http://data-vocabulary.org/Breadcrumb" class="<?=$breadscrumb['class']; ?>">
                <?php if ($breadscrumb['link']) : ?>
                <a href="<?=$breadscrumb['link']; ?>"><span itemprop="title"><?=$breadscrumb['text']; ?></span></a>
                <?php else : ?>
                <span class="current" itemprop="title"><?=$breadscrumb['text']; ?></span>
                <?php endif; ?>
            </li>
            <?php endforeach; ?>
        <?php } else { ?>
            <?php if (isset($getFeature)) : ?>
            <li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="../../" itemprop="url"><span itemprop="title"><?php echo $groupCity_info['name']; ?></span></a></li>
            <li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="../" itemprop="url"><span itemprop="title"><?php echo $city_info['name']; ?></span></a></li>
            <li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="<?php echo $back_url ?>" itemprop="url"><span itemprop="title"><?php echo $town_info['name']; ?></span></a></li>
            <li ><span class="current">特徴</span></li>
            <?php elseif (isset($getTowns)) : ?>
            <li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="../" itemprop="url"><span itemprop="title"><?php echo $groupCity_info['name']; ?></span></a></li>
            <li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><span class="current" itemprop="title"><?php echo $city_info['name']; ?></span></li>
            <?php elseif (isset($storeOwner)) : ?>
            <li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="../../" itemprop="url"><span itemprop="title"><?php echo $groupCity_info['name']; ?></span></a></li>
            <li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="../" itemprop="url"><span itemprop="title"><?php echo $city_info['name']; ?></span></a></li>
            <li ><span class="current"><?php echo $breadText; ?></span></li>
            <?php elseif (isset($storeTown)) : ?>
            <li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="<?php echo base_url().'user/jobs/'.$group_city.'/'; ?>" itemprop="url"><span itemprop="title"><?php echo $groupCity_info['name']; ?></span></a></li>
            <li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="<?php echo base_url().'user/jobs/'.$group_city.'/'.$city.'/'; ?>" itemprop="url"><span itemprop="title"><?php echo $city_info['name']; ?></span></a></li>
            <li class="active"><?php echo $breadText; ?></li>
<!--
            <li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="<?php echo base_url().'user/jobs/'.$group_city.'/'.$city.'/'.$town.'/'; ?>" itemprop="url"><span itemprop="title"><?php echo $breadText; ?></span></a></li>
-->
            <?php elseif (isset($header_storeDetail)) :?>
            <li itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
                <a href="<?php echo base_url().'user/jobs/'.$area_info['group_alph_name'];?>/" itemprop="url"><span itemprop="title"><?php echo $area_info['group_name']; ?></span></a>
            </li>
            <li itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
                <a href="<?php echo base_url().'user/jobs/'.$area_info['group_alph_name'].'/'.$area_info['city_alph_name'];?>/" itemprop="url"><span itemprop="title"><?php echo $area_info['city_name']; ?></span></a>
            </li>
            <li itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
                <a href="<?php echo base_url().'user/jobs/'.$area_info['group_alph_name'].'/'.$area_info['city_alph_name'];?>/<?php echo $area_info['town_alph_name']; ?>/" itemprop="url"><span itemprop="title"><?php echo $area_info['town_name']; ?></span></a>
            </li>
            <li itemscope itemtype="http://data-vocabulary.org/Breadcrumb" class="colon">
                <a href="<?php echo base_url(); ?>user/jobs/<?php echo $area_info['group_alph_name']; ?>/<?php echo $area_info['city_alph_name']; ?>/<?php echo $area_info['town_alph_name']; ?>/?cate=<?php echo $area_info['job_type_alph_name']; ?>" itemprop="url"><span itemprop="title"><?php echo $area_info['job_type_name'];?></span></a>
            </li>
            <?php else :?>
            <li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><span class="current" itemprop="title"><?php echo isset($groupCity_info['name']) && $groupCity_info['name'] ? $groupCity_info['name'] : ''; ?></span></li>
            <?php endif; ?>
        <?php } ?>
            </ul>
            <form id="search_keyword_form" method="get" action="<?php echo base_url()."user/search/search_list" ?>/">
            <p>
                <input type="text" value="" class="input_keyword" name="search_keyword" id="search_keyword" placeholder="フリーワード：例）店舗名、日払い、デリヘル等...">
                <button id="search_keyword_btn"><i class="fa fa-search"></i></button>
            </p>
            </form>
        </div>
    </div>

    <?php if (isset($header_storeDetail)) :?>
    <div class="breadcrumb">
        <div class="container">
        <ul>
        <li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="<?php echo base_url();?>" itemprop="url"><span itemprop="title">HOME</span></a></li>

        <li itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
            <a href="<?php echo base_url(); ?>jobtype_<?php echo $area_info['job_type_alph_name']; ?>/" itemprop="url"><span itemprop="title"><?php echo $area_info['job_type_name'];?></span></a>
        </li>

        <li itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
            <a href="<?php echo base_url().'jobtype_'.$area_info['job_type_alph_name'].'/'.$area_info['group_alph_name'];?>/" itemprop="url"><span itemprop="title"><?php echo $area_info['group_name']; ?></span></a>
        </li>
        <li itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
            <a href="<?php echo base_url().'jobtype_'.$area_info['job_type_alph_name'].'/'.$area_info['group_alph_name'].'/'.$area_info['city_alph_name'];?>/" itemprop="url"><span itemprop="title"><?php echo $area_info['city_name']; ?></span></a>
        </li>
        <li itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
            <a href="<?php echo base_url(); ?>user/jobs/<?php echo $area_info['group_alph_name']; ?>/<?php echo $area_info['city_alph_name']; ?>/<?php echo $area_info['town_alph_name']; ?>/?cate=<?php echo $area_info['job_type_alph_name']; ?>" itemprop="url"><span itemprop="title"><?php echo $area_info['town_name'];?></span></a>
        </li>
        </ul>
        </div>
    </div>
    <?php endif;?>

    <?php if (isset($breadscrumb_array2) && is_array($breadscrumb_array2)) { ?>
    <div class="breadcrumb">
        <div class="container">
            <ul>
            <li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="<?php echo base_url();?>" itemprop="url"><span itemprop="title">HOME</span></a></li>
            <?php foreach ($breadscrumb_array2 as $breadscrumb) : ?>
            <li itemscope itemtype="http://data-vocabulary.org/Breadcrumb" class="<?php echo $breadscrumb['class']; ?>">
                <?php if ($breadscrumb['link']) : ?>
                <a href="<?php echo $breadscrumb['link']; ?>"><span itemprop="title"><?php echo $breadscrumb['text']; ?></span></a>
                <?php else : ?>
                <span class="current" itemprop="title"><?php echo $breadscrumb['text']; ?></span>
                <?php endif; ?>
            </li>
            <?php endforeach; ?>
            </ul>
        </div>
    </div>
    <?php } ?>
</header>
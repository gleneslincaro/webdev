<link rel="stylesheet" href="/public/user/pc/css/aruaru_style.css">
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
                <a href="https://aruaru.joyspe.com/"><img src="<?php echo base_url().'public/user/pc/'; ?>image/header_logo.png" alt="高収入アルバイト情報" /></a>
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
                <a href="https://aruaru.joyspe.com/"><img src="<?php echo base_url().'public/user/pc/'; ?>image/aruaru/logo.png" alt="高収入アルバイト情報" /></a>
            </h1>
        </div>
    <?php endif; ?>
        <div class="right_column">
            <?php if (isset($total_users) && isset($total_owners)) { ?>
            <ul class="header_counter">
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

        </div>

    </div>
    <div class="breadcrumb">
        <div class="container">
            <ul>
            <li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="https://aruaru.joyspe.com/" itemprop="url"><span itemprop="title">HOME</span></a></li>
        <?php
        if (isset($breadscrumb_array) && is_array($breadscrumb_array)) { ?>
            <?php foreach ($breadscrumb_array as $breadscrumb) : ?>
            <li itemscope itemtype="http://data-vocabulary.org/Breadcrumb" class="<?=$breadscrumb['class']; ?>">
                <?php if ($breadscrumb['link']) : ?>
                <a href="<?=$breadscrumb['link']; ?>"><span itemprop="title"><?=$breadscrumb['text']; ?></span></a>
                <?php else : ?>
                <span class="current" itemprop="title"><?=$breadscrumb['text']; ?></span>
                <?php endif; ?>
            </li>
            <?php endforeach; ?>
        <?php } ?>
            </ul>
        </div>
    </div>

</header>
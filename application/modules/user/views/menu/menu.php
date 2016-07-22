<?php
    $user = UserControl::getUser();
    $gettype =1;
    $user_from_site = $user['user_from_site'];
    if ($user) {
        if ($user_from_site == 1 || $user_from_site == 2) { // マキア&マシェモバユーザの場合
            $display_bonus_menu_flg = 1;
        } else {
            $display_travel_expense_flg = 1;
        }
    }
 ?>
<ul>
    <!--<li class="sidr_ttl">MENU</li>-->
    <li><a href="<?php echo base_url(); ?>"><span class="ic_top">TOP</span></a></li>
    <li><a href="<?php echo base_url().'user/message_list/'?>"><span class="ic_mail">スカウトメール</span></a></li>
    <?php if (isset($display_bonus_menu_flg) && $display_bonus_menu_flg == 1) { ?>
    <li><a href="<?php echo base_url().'user/bonus/bonus_list/'?>"><span class="ic_info">ボーナス確認</span></a></li>
    <li><a href="<?php echo base_url()?>user/misc/more_point1/"><span class="ic_mail">多くのボーナスを獲得するには</span></a></li>
    <?php } ?>
    <?php if (isset($display_travel_expense_flg) && $display_travel_expense_flg == 1) { ?>
        <li><a href="<?php echo base_url().'user/bonus/bonus_list/'?>"><span class="ic_info">面接交通費確認</span></a></li>
    <?php } ?>
    <?php if (isset($user_from_site) && ($user_from_site == 1 || $user_from_site == 2)) { ?>
        <?php if (Musers::canJoinStepUpCampaign($user['id'])) : ?>
        <li><a href="<?php echo base_url().'user/mission/index'?>"><span class="ic_info">ミッション確認</span></a></li>
        <?php endif; ?>
        <?php if (isset($stepUpNewCamp)): ?>
        <li><a href="<?php echo base_url().'user/misc/stepUpDescription'?>"><span class="ic_info">ステップアップボーナス説明</span></a></li>
        <?php endif; ?>
    <li><a href="<?php echo base_url().'user/misc/more_point2'?>"><span class="ic_info">匿名用質問集</span></a></li>
    <?php }?>
    <li><a href="<?php echo base_url().'user/campaign/'?>"><span class="ic_info">面接交通費/入店お祝い金申請一覧</span></a></li>
    <li><a href="<?php echo base_url().'user/keep_list/'?>"><span class="ic_fav">キープ一覧</span></a></li>
    <li><a href="<?php echo base_url().'user/experiences/'?>"><span class="ic_pen">みんなの体験談</span></a></li>
    <li><a href="<?php echo base_url().'user/info_list/'?>"><span class="ic_info">お知らせ</span></a></li>
    <li><a href="<?php echo base_url().'user/settings/'?>"><span class="ic_settings">設定</span></a></li>
    <li><a href="<?php echo base_url().'user/contact/'?>"><span class="ic_help">FAQ/お問合せ</span></a></li>
    <li><a href="<?php echo base_url().'user/dictionary/'?>"><span class="ic_books">用語辞典</span></a></li>
    <li><a href="<?php echo ARUARU_PROTOCOL.ARUARU_URL; ?>"><span class="ic_info">あるある掲示板</span></a></li>
<?php  if (UserControl::LoggedIn() != true) : ?>
    <li>
        <p class="menu_new_regist">
            <a href="<?php echo base_url().'user/signup/'; ?>">新規会員登録<i class="fa fa-chevron-circle-right"></i></a>
        </p>
        <p>
            <a href="<?php echo base_url().'user/login/'; ?>">ログイン<i class="fa fa-chevron-circle-right"></i></a>
        </p>
    </li>
<?php endif; ?>
<?php  if (UserControl::LoggedIn() == true) : ?>
    <li class="t_center"><p class="menu_logout_btn"><a href="<?php echo base_url(); ?>user/login/logout/">ログアウト</a></p></li>
<?php endif; ?>
</ul>

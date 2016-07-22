<?php  if (UserControl::LoggedIn() == true) { ?>
    <?php /*after log in*/ ?>
    <?php  if ($idheader == null || $idheader == '') : ?>
        <div id="logout_text"><a href="<?php echo base_url(); ?>user/login/logout">ログアウト</a></div>
        <div id="header_text">
            <label>高収入・情報サイト！ 掲載店舗数：<?php echo HelperGlobal::gettotalHeader() ?>件</label>
            <p>現在 <?php echo HelperGlobal::getUserTotalNumber() ?>人が利用してます！</p>
        </div>
        <?php 
            if(isset($monthly_campaign_result_ads) && $monthly_campaign_result_ads):
                $this->load->view('user/share/monthly_campaign_result_ads'); 
            endif;
        ?>
        <div id="header_text">
            <label>joyspe内でのIDは <?php echo UserControl::getUnique_id() ?> です。</label>
            <p><a href="<?php echo base_url() ?>user/misc/koutsuhi01">
                <img class="width_96p" src="<?php echo base_url() ?>public/user/image/koutsuhi0115000.jpg"></a></p>
        </div>
      <?php
        if(isset($banner_data) && $banner_data):
            $this->load->view('user/share/header_banner');
        endif;
        if(isset($banner_bonus_req) && $banner_bonus_req):
            $this->load->view('user/share/header_banner_bunos_req');
        endif;
      ?>
      <?php
        if (time() > mktime(12,0,0,3,18,2015)){
            if (isset($user_from_site) && ($user_from_site == 1 || $user_from_site == 2)){
                $this->load->view('user/share/line_banner');
            }
        }
      ?>
      <?php if(isset($stepUpNewCamp) && $this->router->fetch_class() == 'joyspe_user'): ?>
          <?php $this->load->view('user/share/step_up_campaign'); ?>
      <?php endif; ?>
      <?php $countScout=HelperGlobal::checkscoutmail(UserControl::getId());
        if($countScout['quantity']!=0){?>
        <a class="new" href="<?php echo base_url() . 'user/user_messege/messege_reception/' ?>">・スカウトメッセージが届いています！</a><br>
      <?php }?>

        <?php $countScout=HelperGlobal::checknewmail(UserControl::getId());
        if($countScout['quantity']!=0){?>
        <a class="new" href="<?php echo base_url() . 'user/user_messege/messege_reception/'.'2' ?>">・「重要なご案内」が届いています！</a><br>
      <?php }?>

       <?php $countScout=  HelperGlobal::checkinterviewmail(UserControl::getId());
        if($countScout['quantity']!=0){?>
        <a class="new" href="<?php echo base_url() . 'user/user_messege/messege_reception/'.'3' ?>">・「面接へのご案内」が届いています！</a><br>
      <?php }?>
      <?php
         $day_happy_money=  $this->config->item('day_happymoney');
         $countScout=  HelperGlobal::checktakehapymoney(UserControl::getId(),$day_happy_money);
        if($countScout['quantity']!=0){?>
        <a class="new" href="<?php echo base_url().'user/celebration/celebration_list'?>">・お祝い金　申請はコチラから行えます！</a><br>
      <?php }?>
        <?php $countScout=  HelperGlobal::checkhappymoneymail(UserControl::getId());
        if($countScout['quantity']!=0){?>
        <a class="new" href="<?php echo base_url() . 'user/user_messege/messege_reception/'.'4'?>">・「お祝い金」についてのお知らせ！</a>
      <?php }?>
    <?php endif;  ?>
    <?php /*detail*/ ?>
    <?php  if ($idheader == 1) : ?>
        <div id="logout_text"><a href="<?php echo base_url(); ?>user/login/logout">ログアウト</a></div>
        <div id="header_text">
            <label>高収入・情報サイト！ 掲載店舗数：<?php echo HelperGlobal::gettotalHeader() ?>件</label>
            <p>現在 <?php echo HelperGlobal::getUserTotalNumber() ?>人が利用してます！</p>
        </div>
        <div id="header_text">
                <label>joyspe内でのIDは <?php echo UserControl::getUnique_id() ?> です。</label>
        </div>
        <?php 
            if(isset($monthly_campaign_result_ads) && $monthly_campaign_result_ads):
                $this->load->view('user/share/monthly_campaign_result_ads'); 
            endif;
        ?>
        <?php
        if(isset($banner_data) && $banner_data):
          $this->load->view('user/share/header_banner');
        endif;
        if(isset($banner_bonus_req) && $banner_bonus_req):
            $this->load->view('user/share/header_banner_bunos_req');
        endif;
        ?>
        <?php if(isset($stepUpNewCamp) && $this->router->fetch_class() == 'joyspe_user'): ?>
            <?php $this->load->view('user/share/step_up_campaign'); ?>
        <?php endif; ?>
        <?php $countScout=HelperGlobal::checkscoutmail(UserControl::getId());
        if($countScout['quantity']!=0){?>
        <a class="new" href="<?php echo base_url() . 'user/user_messege/messege_reception/' ?>">・スカウトメッセージが届いています！</a><br>
    <?php }?>
    <?php
         $day_happy_money=  $this->config->item('day_happymoney');
         $countScout=  HelperGlobal::checktakehapymoney(UserControl::getId(),$day_happy_money);
        if($countScout['quantity']!=0){?>
        <a class="new" href="<?php echo base_url().'user/celebration/celebration_list'?>">・お祝い金　申請はコチラから行えます！</a><br>
    <?php }?>
    <?php endif;  ?>
    <?php /*top*/ ?>
    <?php /*image*/ ?>
    <?php  if ($idheader == 3) : ?>
         <div id="header_logo"><img src="<?php echo base_url(); ?>public/user/image/joyspe_logo.png" width="70%"></div>
    <?php endif;  ?>
    <?php /*space*/ ?>
    <?php  if ($idheader == 4) : ?>
        <div></div>
    <?php endif;  ?>
    <?php /*login*/ ?>
    <?php  if ($idheader == 5) : ?>
        <div id="logout_text"><a href="<?php echo base_url().'user/login/logout' ?>">ログアウト</a></div>
        <div id="header_text">
            <label>高収入・情報サイト！ 掲載店舗数：<?php echo HelperGlobal::gettotalHeader() ?>件</label>
            <p>現在 <?php echo HelperGlobal::getUserTotalNumber() ?>人が利用してます！</p>
        </div>
        <div id="header_text">
            <label>joyspe内でのIDは <?php echo UserControl::getUnique_id() ?> です。</label>
        </div>
    <?php endif;  ?>
<?php } else { ?>
<?php /* not login */ ?>
    <?php  if ($idheader == null || $idheader == '') : ?>
        <div id="header_btn_box">
            <div id="header_btn_l">
                <a class="btn" href="<?php echo base_url().'user/login/'; ?>">ログイン</a>
            </div>
            <div id="header_btn_r">
                <a class="btn" href="<?php echo base_url().'user/registration'; ?>">新規会員登録</a>
            </div>
        </div>
        <br class="clr_both">
        <div id="header_text">
            <label>高収入・情報サイト！ 掲載店舗数：<?php echo HelperGlobal::gettotalHeader() ?>件</label>
            <p>現在 <?php echo HelperGlobal::getUserTotalNumber() ?>人が利用してます！</p>
        </div>
        <?php 
            if(isset($monthly_campaign_result_ads) && $monthly_campaign_result_ads):
                $this->load->view('user/share/monthly_campaign_result_ads'); 
            endif;
        ?>
        <div id="header_text">
            <p><a href="<?php echo base_url() ?>user/misc/koutsuhi01">
               <img class="width_96p" src="<?php echo base_url() ?>public/user/image/koutsuhi0115000.jpg"></a></p>
        </div>
    <?php endif;  ?>
    <?php  if ($idheader == 2) : ?>
        <div class="margin_p5400">
         <a href="<?php echo base_url(); ?>user/joyspe_user/index">&gt;TOPへ戻る</a>
        </div>
     <?php endif;  ?>

    <?php if(isset($banner_data) && $banner_data):
        $this->load->view('user/share/header_banner');
    endif;
    if(isset($banner_bonus_req) && $banner_bonus_req):
        $this->load->view('user/share/header_banner_bunos_req');
    endif;
    ?>

<?php
}?>

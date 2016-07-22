<?php if ($idheader == null || $idheader == '') : ?>

<section class="section section--campaign">
    <h3 class="h_ttl_1 ic ic--campaign">キャンペーン</h3>
    <div class="box_inner pt_15">
        <div class="campaign_list">
            <ul>
                <?php if(isset($monthly_campaign_result_ads) && $monthly_campaign_result_ads): ?>
                <li>
                    <?php
                        // キャンペーン集計情報表示
                        //$this->load->view('user/share/monthly_campaign_result_ads');
                    ?>
                </li>
                <?php endif; ?>
                <!--
                <li>
                    <a href="<?php echo base_url() ?>user/misc/koutsuhi01/"> <img class="banner" src="<?php echo base_url() ?>public/user/image/koutsuhi0115000.jpg" alt="ジョイスペ保証 面接交通費 5000円プレゼント" /> </a>
                </li>
                -->
                <?php if(isset($banner_data) && $banner_data): ?>
                <li id="banner">
                        <?php if (0) { ?>
                        <a href="<?php echo base_url(); ?>user/contact#travel_expense"> <img class="banner" src="<?php echo base_url().$banner_data['banner_path']; ?>"> </a>
                        <?php } else { ?>
                        <a href="<?php echo base_url(); ?>user/contact#travel_expense"> <img class="banner" src="<?php echo base_url().$banner_data['banner_path']; ?>"> </a>
                        <?php } ?>
                </li>
                <?php endif; ?>

                <?php if (isset($banner_bonus_req) && $banner_bonus_req) { ?>
                <li>
                    <a href="<?php echo base_url(); ?>user/contact#trial_work"> <img class="banner" src="<?php echo base_url().$banner_bonus_req['banner_path']; ?>"> </a>
                </li>
                <?php } ?>
                <li>
                        <?php //echo $this->load->view('user/share/line_banner'); ?>
                </li>
                <li>
                        <?php echo $this->load->view('user/share/step_up_campaign'); ?>
                </li>
                <li>
                        <?php echo $this->load->view('user/template/message_campaign'); ?>
                </li>
            </ul>
        </div>
    </div>
    <!-- // .box_inner -->
</section>
<?php endif; ?>

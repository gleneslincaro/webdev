
<div id="container">

    <?php
    foreach ($company_data as $data) {
        //お祝い金表示用のフォントサイズ調整
        $user_hm = 0;
        $money_font_size = OIWAI_PAY_MONEY_FONTSIZE_LARGE;
        $yen_font_size = OIWAI_PAY_YEN_FONTSIZE_LARGE;
        $num_of_characters = strlen($data['user_happy_money']);
        if ( $num_of_characters > 6){
            $money_font_size = OIWAI_PAY_MONEY_FONTSIZE_SMALL;
            $yen_font_size = OIWAI_PAY_YEN_FONTSIZE_SMALL;
        }
        if ($data['user_happy_money'] ){
            $user_hm = number_format($data['user_happy_money']);
        }
        ?>
        <div class="box">
            <div class="box_title">
                <?php echo $data['storename']; ?>

                株式会社アイエヌネットワーク</div>
            <div class="box_in">

                <img src="<?php echo base_url().'public/user/image/oiwai.jpg'; ?>" />
                <div class="vertical_align_wrapper">
                    <div class="outer">
                        <div class="middle">
                            <div class="inner" style="font-size: <?=$money_font_size;?>px;">
                                <?=$user_hm;?><span style="font-size:<?=$yen_font_size;?>px;">円</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="happy_text">
                    <span style="color:black;"><?php echo OIWAI_PAY_TEXT_PRFEFIX; ?>
                    <span style="color:#ff2b00"><?php echo OIWAI_PAY_TEXT_MIDDLE."</span>".OIWAI_PAY_TEXT_SUFFIX; ?></span>
                </div>

                <div class="job_box">
                     <div class="photo_box_c">

                        <div id="wrapper">
    
                            <div class="slider-wrapper theme-default">
                                <div id="slider" class="nivoSlider " style="border: 1px solid #005702;">
                                    <?php
                                    for ($i = 1; $i < 7; $i++) {
                                        ?>
                                        <img src="<?php echo base_url() . $data['image' . $i]; ?>" width="100%"   />


                                        <?php
                                    }
                                    ?>
                                </div>
                                <div id="htmlcaption" class="nivo-html-caption">
        
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
                <br style="clear:both">

                <b>会社情報：</b><br >
                <?php echo $data['company_info']; ?>
                <hr size="1px" color="#666666">
                <b>業種：</b><br >
                  <?php
                            $count = count($data['jobtypename']);
                            $num = 0;
                        ?>
                        <?php foreach ($data['jobtypename'] as $j): ?>
                            <?php $num++; ?>
                            <?php echo $j['name'] ;echo $count == $num? "":"、" ?>                       
                        <?php endforeach; ?> 
                
               
                <hr size="1px" color="#666666">
                <b>お祝い金・達成条件：</b><br >
                <?php echo $data['user_happy_money']; ?>円・初日<?php echo $data['cond_happy_money']; ?>時間以上 勤務
                <hr size="1px" color="#666666">
                <b>地域：</b> <?php echo $data['citiname']; ?>
                <hr size="1px" color="#666666">                                
                <b>待遇：</b>
                <div class="job_box">
                    <div class="job_treatment_box">
                        <?php
                        $br = 0;
                        foreach ($data['treatment'] as $t) {
                            ?>
                            <div class="job_treatment"><?php
                                $br++;
                                echo $t['name'];
                                if ($br == 3) {
                                    echo "<br/>";
                                }
                                ?></div>
    <?php } ?>
                    </div>
                    <br style="clear:both">
                </div>
                <hr size="1px" color="#666666">
                <br >
                <?php if($user_hm > 0): ?>
                  <div class="btn"><a href="<?php echo base_url() . 'user/Keeplist_controller/keep_application/' . $data['ors_id']; ?>/">応募する</a></div>
                <?php endif ?>

                <div class="job_menu">
                    <a href="<?php echo base_url() . 'user/keep/index/' . $data['ors_id']; ?>/">キープする</a>
                </div>


                <div class="job_menu">
                    <a href="<?php echo base_url() . 'user/denial/index/' . $data['ors_id']; ?>/">スカウトを拒否する</a>
                </div>

                <div class="job_menu">
                    <a href="<?php echo base_url() . 'user/denial/not_denial' . $data['ors_id']; ?>/">スカウトが拒否状態です</a>
                </div>

            </div>
        </div>

<?php } ?>
</div>




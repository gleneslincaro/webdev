<?php foreach($storeOwner as $data) : ?>
    <?php if($data['owner_status'] == 2):?>
    <li class="cf company_details with_company_details">
        <p class="shop_name"><?php echo $data['storename']; ?><p>
        <input type="hidden" name="info_id[]" value="<?php echo $data['orid']; ?>">
        <?php if ($data['happy_money_type'] && $data['happy_money'] != 0) : ?>
        <p class="fc_red"><?php echo $data['happy_money_type']; ?>お祝い金：<?php echo $data['happy_money']; ?>円</p>
        <?php endif;?>
        
        <figure class="banner">
            <a href="<?php echo base_url() . 'user/joyspe_user/company/' . $data['orid']; ?>/">
                <?php if($data['main_image'] != 0 && $data['image' . $data['main_image']] ): ?>
                    <img width="350px" src="<?php echo $imagePath . $data['image' . $data['main_image']]; ?>" alt="<?php echo $data['storename']; ?>" />
                <?php else: ?>
                    <img width="350px" src="<?php echo base_url() . 'public/owner/images/no_image_top.jpg'; ?>" alt="<?php echo $data['storename']; ?>" />
                <?php endif; ?>
            </a>
        </figure>
        <p class="area_cat">
            <span class="area"><?php echo $data['town_name']; ?></span>
            <span class="cat">
              <?php if( isset($data['jtname']) ) { echo INDUSYTRY_PREFIX.$data['jtname']; }?>
            </span>
        </p>
        <p class="payment">
            <?php if($data['salary']) : ?>
              <?php
                  $data['salary'] = Helper::displayLines($data['salary'],2);
                  echo nl2br($data['salary']);
              ?>
            <?php endif; ?>
        </p>
        <div class="guarantee">
            <?php if( isset($travel_expense)) : ?>
                <div class="traffic_bn">
                    <p><?php echo number_format($data['travel_expense_bonus']); ?></p>
                </div>
            <?php endif;?>
            <?php if( isset($campaignBonusRequest)) : ?>
                <div class="trial_bn">
                    <p><?php echo number_format($data['bonus_money']); ?></p>
                </div>
            <?php endif;?>
        </div>
       <?php 
            $treatmentsID = explode(",", $data['treatmentsID']);
            $treatmentsName = explode(",", $data['treatmentsName']);
        ?>
        <div class="tags tags--benefit cf">
            <ul>
                <?php for ($x=0;$x<sizeof($treatments);$x++) : ?>
                <li>
                    <img class="tag" src="<?php echo base_url(); ?>public/user/image/tags/treatment/<?php echo in_array($treatments[$x]['id'] , $treatmentsID)? $treatments[$x]['id'] . "_on" : $treatments[$x]['id'] . "_off"; ?>.png">
                </li>
                <?php endfor; ?>
            </ul>
        </div>
        <div class="ui_btn_wrap ui_btn_wrap--half pt_5 pb_5 cf">
            <ul>
                <li>
                    <?php if (isset($data['keepstt']) && $data['keepstt'] == 0) : ?>
                        <a href="<?php echo base_url().'user/keep/index/'.$data['orid']; ?>/" class="ui_btn ui_btn--keep ui_btn--fav">キープする</a>
                    <?php elseif ((isset($data['keepstt']) && $data['keepstt'] == 1) || !isset($data['keepstt'])) : ?>
                        <a href="<?php echo base_url(); ?>user/keep/keep_clear/<?php echo $data['orid']; ?>/" class="ui_btn ui_btn--keepout ui_btn--fav">キープ解除</a>
                    <?php endif; ?>
                </li>
                <li> <a href="<?php echo base_url(); ?>user/joyspe_user/company/<?php echo $data['orid']; ?>/" class="ui_btn ui_btn--shop_details ui_btn--shop_arrow_right">詳細を見る</a> </li>
            </ul>
        </div>
    </li>
    <?php else:?>
        <li class="cf company_details with_company_details">
            <p class="shop_name"><?php echo $data['storename']; ?></p>
            <p>
                <input type="hidden" name="info_id[]" value="<?php echo $data['orid']; ?>">
            </p>
            <p class="area_cat">
                <span class="area"><?php echo $data['town_name']; ?></span>
                <span class="cat">
                  <?php if( isset($data['jtname']) ) { echo INDUSYTRY_PREFIX.$data['jtname']; }?>
                </span>
            </p>
            <div class="ui_btn_wrap ui_btn_wrap--half pt_5 pb_5 cf">
                <ul>
                    <li> 
                        <a class="ui_btn ui_btn--shop_details ui_btn--shop_arrow_right" href="<?php echo base_url(); ?>user/joyspe_user/company/<?php echo $data['orid']; ?>/">詳細を見る</a> 
                    </li>
                </ul>
            </div>
        </li>
    <?php endif;?>
<?php endforeach; ?>




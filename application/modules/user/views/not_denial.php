<section class="section section--not_denial cf">
    <h3 class="ttl_1">応募</h3>
    <div class="box_inner pt_15 pb_7 cf">
        <div class="pt_20 pb_15 cf t_center">
           <p><?php echo $storename; ?>の拒否を解除しますか？</p>                     
        </div>                                                  
        <div class="ui_btn_wrap ui_btn_wrap--half pt_5 pb_5 cf">
            <ul>
                <li>
                    <a class="ui_btn ui_btn--not_denial ui_btn--fav" href="<?php echo base_url()."user/denial/not_denial_complete/".$ors_id;?>/" id="not_denial">解除する</a>
                </li>
                <li>
                    <a class="ui_btn ui_btn--back ui_btn--shop_arrow_right" href="javascript:void(0)" onClick="location.href='javascript:history.go(-1)'">やめる</a>
                </li>
            </ul>
        </div>                            
    </div>
</section>
<script type="text/javascript" src="<?php echo base_url(); ?>public/user/js/denial.js?v=20150511" ></script>
<section class="section section--denial cf">
    <h3 class="ttl_1">応募</h3>
    <div class="box_inner pt_15 pb_7 cf">
        <div class="pt_20 pb_15 cf t_center">
           <p><?php echo $storename; ?>を拒否しますか？</p>                     
        </div>
        <form method="post" action="<?php echo base_url().'user/denial/denial_complete'?>" enctype="multipart/form-data" id="form_denial">
            <input type="hidden" name="ors_id" value="<?php echo $ors_id;?>"/>                    
            <div class="ui_btn_wrap ui_btn_wrap--half pt_5 pb_5 cf">
                <ul>
                    <li>
                        <a class="ui_btn ui_btn--denial ui_btn--fav" href="javascript:void(0)" id="denial">拒否する</a>
                    </li>
                    <li>
                        <a class="ui_btn ui_btn--back ui_btn--shop_arrow_right" href="javascript:void(0)" onClick="location.href='javascript:history.go(-1)'">やめる</a>
                    </li>
                </ul>
            </div>            
        </form>
    </div>
</section>

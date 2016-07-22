<?php $countScout=HelperGlobal::checkscoutmail(UserControl::getId()); ?>
<?php if ($countScout['quantity']!=0) : ?>
<section>         
    <div class="box_inner pt_15 pb_7 cf">
        <div class="area_list cf">
            <a class="new_scout_mail" href="<?php echo base_url() . 'user/message_list/' ?>"><span class="blink_text">スカウトメッセージが届いています！</span></a><br>                  
        </div>  
    </div>
</section>
<?php endif; ?>
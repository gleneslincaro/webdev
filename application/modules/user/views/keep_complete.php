<script type="text/javascript" src="<?php echo base_url(); ?>public/user/js/keep.js?v=20150511" ></script>
<section class="section section--keep cf">
    <h3 class="ttl_1">キープ</h3>
    <div class="box_inner pt_15 pb_7 cf">
        <div class="pt_20 pb_15 cf t_center">
           <p><?php echo $storename; ?>のキープが完了しました。</p>                     
        </div>                
        <div class="ui_btn_wrap ui_btn_wrap--half pt_5 pb_5 cf">
            <ul id="keep_complete">
                <?php if ($type_page==1) : ?>
                <li>
                    <a class="ui_btn ui_btn--symphonyblue ui_btn--bg_symphonyblue btn_search" href="<?php echo base_url(); ?>user/search/search_list/">検索後のページへ戻る</a>
                </li>
                <?php endif; ?>
                <li>
                    <a class="ui_btn ui_btn--back ui_btn--shop_arrow_right" href="<?php echo base_url(); ?>user/joyspe_user/index/">TOPへ</a>
                </li>
            </ul>
        </div>            
    </div>
</section>


<?php $this->load->view('user/pc/header/header'); ?>
<script type="text/javascript" src="<?php echo base_url(); ?>public/user/js/keep.js?v=20150511" ></script>

<section class="section--main_content_area">
    <div class="container cf">
        <div class="box_white">
            <form method="post" action="<?php echo base_url().'user/keep/keep_clear_complete'?>" enctype="multipart/form-data" id="form_keep">
            <input type="hidden" name="ors_id" value="<?php echo $ors_id;?>"/>
                <section class="section--denial">
                    <div class="denial">
                        <h2 class="ttl_style_1">キープ</h2>
                        <p class="confirmation"><?php echo $storename; ?>を解除しますか？</p>
                    </div>
                    <div class="select_btn">
                        <ul>
                            <li> <a class="ui_btn ui_btn--large ui_btn btn_keep on" href="javascript:void(0)" id="keep"></a> </li>
                            <li> <a class="ui_btn ui_btn--large ui_btn--line ui_btn--line_magenta ui_btn--c_magenta" href="javascript:void(0)" onClick="location.href='javascript:history.go(-1)'">やめる</a> </li>
                        </ul>
                    </div>
                </section>
            </form>
        </div>
    </div>
</section>

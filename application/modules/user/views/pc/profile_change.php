<script type="text/javascript">
    var base_url = "<?php echo base_url(); ?>";
</script>
<script type="text/javascript" src="<?php echo base_url(); ?>public/user/js/jquery-form.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>public/user/pc/js/settings.js" ></script>
<script>
/*------------------------------------------*/
// common modal settings
/*------------------------------------------*/
var modal_setting = {
    autoOpen: false,
    modal: true,
    width: 'auto',
    height: 'auto',
    dialogClass: 'no-close',
    show: {
        effect: 'fade',
        duration: 200
    },
    hide: {
        effect: 'fade',
        duration: 100
    }
}
/*------------------------------------------*/
/* click modal overlay
/*------------------------------------------*/
$(function(){
    $(document).on('click', '.ui-widget-overlay', function(){
        $('.ui-dialog-content').dialog('close');
    });
});
</script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>
<?php $this->load->view('user/pc/header/header'); ?>
    <section class="section--main_content_area">
        <div class="container p_b_50">
            <section class="section section--settings cf">
                <h2 class="ttl_1">登録情報確認・変更</h2>
                <div class="col_left">
                    <ul>
                        <li><a href="<?php echo base_url(); ?>user/settings/profile/" class="<?php echo ($active_menu == 'profile') ? 'active' : ''; ?>">プロフィール設定</a></li>
                        <li><a href="<?php echo base_url(); ?>user/settings/basic/" class="<?php echo ($active_menu == 'basic') ? 'active' : ''; ?>">基本設定</a></li>
                        <li><a href="<?php echo base_url(); ?>user/settings/bank/" class="<?php echo ($active_menu == 'bank') ? 'active' : ''; ?>">銀行口座</a></li>
                        <li><a href="<?php echo base_url(); ?>user/settings/other/" class="<?php echo ($active_menu == 'other') ? 'active' : ''; ?>">その他設定</a></li>
                    </ul>
                </div>
                <div class="col_right">
                    <?php if (isset($load_setting)) : ?>
                        <?php $this->load->view($load_setting); ?>
                    <?php endif; ?>
                </div>
                
            </section>
        </div>
        <!-- // .container --> 
    </section>
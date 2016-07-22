<div id="footer">
    <div id="footer-text">
        <a href="<?php echo base_url() ?>owner/privacy/privacy">プライバシーポリシー</a> ｜
        <a href="<?php echo base_url() ?>owner/agreement/agreement"> 利用規約</a> ｜
        <a href="http://uni-inc.biz/" target="_blank">運営会社</a> ｜
        <a href="<?php echo base_url() ?>owner/inquiry/inquiry"> お問合せ</a> ｜
	    <a href="<?php echo base_url() ?>owner/help/help"> ヘルプ</a>
        <?php if (OwnerControl::LoggedIn()): ?>
         ｜<a href="<?php echo base_url() ?>owner/login/logout"> ログアウト</a>
        <?php endif; ?>
        <br >
        <address>Copyright &copy; joyspe All Rights Reserved.</address>
    </div>
</div>
<?php include_once("analyticstracking.php") ?>
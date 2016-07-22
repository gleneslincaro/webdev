<!-- THIS IS  A VIEW FILE FOR KAME CREDENTIAL HEADER-->
<div id="header-kame">
    <div id="kame-container">
        <a target="_blank" href="http://kame.tv/portal/shopadmin/login.php"><img src="<?php echo base_url().'public/owner/images/button.png'?>"></a>
    </div>
    <p id="kame-login">
        ユーザー名 : <?php echo HelperApp::get_session('kame_login'); ?>
    </p>
    <p id="kame-password">
      パスワード: <?php echo base64_decode(HelperApp::get_session('kame_password'));?>
    </p>
    
</div>

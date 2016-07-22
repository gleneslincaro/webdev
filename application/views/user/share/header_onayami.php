<?php
$bonus_data = HelperGlobal::getUserCurrentBonus();
$onayami_url = ONAYAMI_PROTOCOL.ONAYAMI_URL;
?>
<header class="header" id="header">
	<div class="header_inner cf">
		<h1 class="logo"> <a href="<?php echo $onayami_url; ?>"> <img src="<?php echo $onayami_url; ?>/sp/image/common/logo.png" alt="ロゴ" width="117" height="50" /></a> </h1>
        <a id="simple-menu" href="javascript:void(0)"><span class="btn_menu" id="btn_menu"></span></a>
        <div id="sidr" class="menu sidr right" style="display: none;">
        <?php echo $this->load->view("menu/menu")?>
		</div>
	</div>
</header>
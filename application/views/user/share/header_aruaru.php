<?php
$bonus_data = HelperGlobal::getUserCurrentBonus();
?>
<header class="header" id="header">
	<div class="header_inner cf">
		<h1 class="logo"> <a href="https://aruaru.joyspe.com/"> <img src="<?php echo base_url(); ?>public/user/image/aruaru/logo.png" alt="風俗求人・高収入アルバイト情報ジョイスペ" width="150" height="50" /></a> </h1>
        <a id="simple-menu" href="javascript:void(0)"><span class="btn_menu" id="btn_menu"></span></a>
        <?php if (UserControl::LoggedIn()) { ?>
        <div class="bonus_total_h">
            現在の報酬<br>
            <?php
                if (count($bonus_data) > 0) {
                    $bonus_money = $bonus_data['bonus_money'];
                } else {
                    $bonus_money = 0;
                }
                echo Helper::numberToMoney($bonus_data['bonus_money']);
            ?>         
        </div>
        <?php } ?>
        <div id="sidr" class="menu sidr right" style="display: none;">
        <?php echo $this->load->view("menu/menu")?>
		</div>
	</div>
</header>
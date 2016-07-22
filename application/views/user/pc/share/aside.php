<aside class="aside--sidebar">
	<?php if (isset($is_top) && UserControl::LoggedIn() != true) : ?>
	<div class="aside_btns">
		<ul>
			<li><a href="<?php echo base_url().'user/login/'; ?>" class="ui_btn ui_btn--bg_green">ログイン</a></li>
			<li><a href="<?php echo base_url().'user/signup/'; ?>" class="ui_btn ui_btn--bg_magenta">新規会員登録</a></li>
		</ul>
	</div>
	<?php endif; ?>
	<div class="campaign_banner_list m_b_15">
		<ul>
<?php
/*
			<li>
				<p><a href="<?php echo base_url() ?>user/misc/koutsuhi01/"> <img class="banner radius" src="/public/user/pc/image/banner/merit_koutsuhi_1.png" alt="出稼ぎ限定 面接交通費 15,000円プレゼント" /> </a></p>
				<p>※予告なく終了する場合があります。</p>
			</li>
*/
?>
			<?php if(isset($banner_data) && $banner_data): ?>
			<li>
				<p><a href="/campaign/travel_expense"><img class="banner radius" src="/public/user/pc/image/banner/merit_koutsuhi_2.png" alt="全員もらえる 面接交通費 5,000円プレゼント"></a></p>
			</li>
			<?php endif; ?>
			<?php if (isset($banner_bonus_req) && $banner_bonus_req) : ?>
			<li>
				<p><a href="/campaign/trial_work"><img class="banner radius" src="/public/user/pc/image/banner/merit_trial.png" alt="たった1日の体験入店で15,000円のお祝い金"></a></p>
			</li>
			<?php endif; ?>
			<?php if(isset($banner_data) OR isset($banner_bonus_req)): ?>
			<li>
				<p>※予告なく終了する場合があります。</p>
			</li>
			<?php endif; ?>
		</ul>
	</div>
	<div class="qr_mobile m_b_15">
		<h4 class="ttl">スマホ版もご利用ください</h4>
		<div class="box_inner">
			<img src="<?php echo base_url().'public/user/pc/'; ?>image/banner/qr_mobile.png" alt="QRコード">
		</div>
	</div>
	<div class="joyspe_relation m_b_15">
		<p><a href="http://aruaru.joyspe.com/"><img class="banner radius" src="<?php echo base_url().'public/user/pc/'; ?>image/banner/banner_aruaru-280_50.png" alt="女性のあるある掲示板"></a></p>
	</div>
<?php
/*
	<div class="campaign_banner_list">
		<ul>
			<li><a href="<?php echo base_url('user/features/hibarai')?>"><img class="banner radius" src="<?php echo base_url().'public/user/pc/'; ?>image/banner/feature_hibarai.png" alt="特集 | 日払いでもらえるお店"></a></li>
			<li><a href="<?php echo base_url('user/features/trial')?>"><img class="banner radius" src="<?php echo base_url().'public/user/pc/'; ?>image/banner/feature_trial.png" alt="特集 | 体験入店できるお店"></a></li>
			<li><a href="<?php echo base_url('user/features/deriheru')?>"><img class="banner radius" src="<?php echo base_url().'public/user/pc/'; ?>image/banner/feature_delivery.png" alt="特集 | デリヘルで安全に稼ぐ"></a></li>
		</ul>
	</div>
*/
?>
</aside>

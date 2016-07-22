<?php
if (!isset($onayami_url)) {
	$onayami_url = ONAYAMI_PROTOCOL.ONAYAMI_URL;
}
?>
<footer>
	<div class="footer_inner cf">
		<div class="l_column">
			<a href="<?php echo $onayami_url; ?>"><img src="<?php echo $onayami_url; ?>/pc/image/common/logo.png" alt="風俗求人・高収入アルバイト情報ジョイスペ"></a>
			<?php if (isset($is_top) && UserControl::LoggedIn() != true) : ?>
			<ul class="btn_wrap footer m_t_15">
				<li><a href="<?php echo base_url().'user/login/'; ?>" class="ui_btn ui_btn--bg_green">ログイン</a></li>
				<li><a href="<?php echo base_url().'user/signup/'; ?>" class="ui_btn ui_btn--bg_magenta">新規会員登録</a></li>
			</ul>
			<?php endif; ?>
		</div>
		<div class="r_column">
			<dl class="nav_onayami">
				<dt><a href="<?php echo $onayami_url; ?>">カテゴリー一覧</a></dt>
				<dd>
					<ul>
						<li><a href="<?php echo $onayami_url; ?>/cate1">性（セックス）</a></li>
						<li><a href="<?php echo $onayami_url; ?>/cate2">カラダ</a></li>
						<li><a href="<?php echo $onayami_url; ?>/cate3">生理</a></li>
						<li><a href="<?php echo $onayami_url; ?>/cate4">恋愛と結婚</a></li>
						<li><a href="<?php echo $onayami_url; ?>/cate5">バスト（おっぱい）</a></li>
						<li><a href="<?php echo $onayami_url; ?>/cate6">妊娠・出産・産後</a></li>
						<li><a href="<?php echo $onayami_url; ?>/cate7">性交痛</a></li>
						<li><a href="<?php echo $onayami_url; ?>/cate8">オナニー</a></li>
						<li><a href="<?php echo $onayami_url; ?>/cate9">男性の性</a></li>
						<li><a href="<?php echo $onayami_url; ?>/cate10">コンドーム・避妊</a></li>
						<li><a href="<?php echo $onayami_url; ?>/cate11">シングルマザー</a></li>
						<li><a href="<?php echo $onayami_url; ?>/cate12">男性に答えて欲しい</a></li>
						<li><a href="<?php echo $onayami_url; ?>/cate13">風俗のお仕事</a></li>
						<li><a href="<?php echo $onayami_url; ?>/cate14">チャットレディ</a></li>
				</ul>
				</dd>
			</dl>
			<dl class="nav_joyspe">
				<dt><a href="<?php echo base_url(); ?>">全国の風俗求人情報</a></dt>
				<dd>
					<ul>
						<li><a href="<?php echo base_url(); ?>user/jobs/hokkaido/">北海道・東北</a></li>
						<li><a href="<?php echo base_url(); ?>user/jobs/kanto/">関東</a></li>
						<li><a href="<?php echo base_url(); ?>user/jobs/kitakanto/">北関東</a></li>
						<li><a href="<?php echo base_url(); ?>user/jobs/hokuriku/">北陸・甲信越</a></li>
						<li><a href="<?php echo base_url(); ?>user/jobs/tokai/">東海</a></li>
						<li><a href="<?php echo base_url(); ?>user/jobs/kansai/">関西</a></li>
						<li><a href="<?php echo base_url(); ?>user/jobs/shikoku/">中国・四国</a></li>
						<li><a href="<?php echo base_url(); ?>user/jobs/kyushu/">九州・沖縄</a></li>
					</ul>
				</dd>
			</dl>
			<ul class="footer_sitemap">
				<li><a href="<?php echo base_url(); ?>user/tos/">利用規約</a></li>
				<li><a href="<?php echo base_url(); ?>user/privacy/">個人情報保護方針</a></li>
				<li><a href="<?php echo base_url(); ?>user/company/">運営会社</a></li>
				<li><a href="<?php echo base_url(); ?>owner/top/">掲載について</a></li>
				<li><a href="<?php echo base_url(); ?>user/contact/">FAQ/お問い合わせ</a></li>
				<li><a href="<?php echo base_url(); ?>user/dictionary/">用語辞典</a></li>
				<li><a href="<?php echo base_url(); ?>column/">コラム</a></li>
			</ul>
			<small>Copyright &copy; Joyspe All Rights Reserved.</small> </div>
	</div>
</footer>

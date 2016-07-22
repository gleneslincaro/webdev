<!-- モーダル部分 -->
<div class="modal wd">
	<div class="modal-body">
		<div class="modal-content">
			<img src="<?php echo base_url(); ?>public/user/image/joyspe_logo.png" alt="ジョイスペロゴ" width="468" height="110">
			<div class="text">
				<p>当サイトは、18歳未満または高校生のご利用はお断りします。</p>
				<p>あなたは18歳以上ですか？</p>
			</div>
			<div class="choose">
				<?php
					$external_site = HelperApp::from_external_site();
				?>
				<p><a class="enter" href="">Enter<span>はい、18歳以上です</span></a></p>
				<p><a class="leave" href="<?php echo ($external_site) ? $this->agent->referrer() : 'http://yahoo.co.jp/'; ?>">Leave<span>いいえ、18歳未満です</span></a></p>
			</div>
		</div>
	</div>
	<div class="modal-bk"></div>
</div>
<script type="text/javascript">
$(function(){
	var mW = $('.wd').find('.modal-body').innerWidth() / 2;
	var mH = $('.wd').find('.modal-body').innerHeight() / 2;
	$('.wd').find('.modal-body').css({'margin-left':-mW,'margin-top':-mH});
	$('.wd').fadeIn(500);
	$('.enter').click(function(){
		$.cookie("over18_flag",1,{ path:"/", expires: 365});
		$('.wd').fadeOut(500);
		return false;
	});
});
</script>
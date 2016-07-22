<!-- モーダル部分 -->
<div class="modal wd">
	<div class="modal-body">
		<div class="modal-content-wrap">
			<div class="modal-content">
				<div class="wrapper-logo">
					<img src="<?php echo base_url(); ?>public/user/image/joyspe_logo.png" alt="ジョイスペロゴ" width="468" height="110">
				</div>
				<div class="text">
					<p>当サイトは、18歳未満、または<br />高校生のご利用はお断りします。</p>
					<p>あなたは18歳以上ですか？</p>
				</div>
				<?php
					$external_site = HelperApp::from_external_site();
				?>
				<div class="choose">
					<p><a class="enter" href="">Enter<span>はい、18歳以上です</span></a></p>
					<p><a class="leave" href="<?php echo ($external_site) ? $this->agent->referrer() : 'http://yahoo.co.jp/'; ?>">Leave<span>いいえ、18歳未満です</span></a></p>
				</div>
			</div>
		</div>
	</div>
	<div class="modal-bk"></div>
</div>
<script type="text/javascript">
  	// モーダル部分
	$(function(){
		$('.wd').fadeIn(500);
		$('.enter').click(function(){
			$.cookie("over18_flag",1,{ path:"/", expires: 365});
			$('.wd').fadeOut(500);
			return true;
		});

		// Androidレイアウト崩れ
		var ua = navigator.userAgent;
		if( (ua.indexOf('Android') > 0 && ua.indexOf('Mobile') > 0 )) {
			$('.modal-body').css({
				'top' : '20%',
				'bottom' : '40%',
				'height' : 'auto',
			});
			$('.modal-content img').css({
				'height' : 'auto',
			});
		}
	});

	// Android meta viewport変更
	var ua = navigator.userAgent;
	if( (ua.indexOf('Android') > 0 && ua.indexOf('Mobile') > 0 )) {
	var metalist = document.getElementsByTagName('meta');
	for(var i = 0; i < metalist.length; i++) {
	    var name = metalist[i].getAttribute('name');
	    if(name && name.toLowerCase() === 'viewport') {
	        metalist[i].setAttribute('content', 'target-densitydpi=device-dpi, width=device-width, maximum-scale=1.0, user-scalable=yes');
	        break;
	    }
	}
	}
</script>
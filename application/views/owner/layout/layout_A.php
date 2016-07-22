<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $title; ?></title>
<meta name="robots" content="noindex">
<meta name="language" content="en" />
<link href="/public/owner/css/common.css?v=20150703" rel="stylesheet"/>
<script type="text/javascript" src="/public/owner/js/jquery-1.8.0.min.js"></script>
<script type="text/javascript"> var title="<?php echo (isset($cTitle))?$cTitle:''; ?>"; </script>
<script type="text/javascript" src="/public/user/js/jquery.nivo.slider.js"></script>
<script language="javascript" src="/public/admin/js/jquery-form.js"></script>
<script language="javascript" src="/public/owner/js/jquery.datetimepicker.js"></script>

<link rel="stylesheet" href="/public/owner/css/themes/default/default.css" type="text/css" media="screen" />
<link rel="stylesheet" href="/public/owner/css/themes/light/light.css" type="text/css" media="screen" />
<link rel="stylesheet" href="/public/owner/css/themes/dark/dark.css" type="text/css" media="screen" />
<link rel="stylesheet" href="/public/owner/css/themes/bar/bar.css" type="text/css" media="screen" />
<link rel="stylesheet" href="/public/owner/css/nivo-slider.css" type="text/css" media="screen" />
<link rel="stylesheet" href="/public/owner/css/jquery.datetimepicker.css" type="text/css" media="screen" />
<link rel="stylesheet" href="/public/owner/css/kame.css?v=20150505" type="text/css" media="screen" />
<link rel="stylesheet" id="font-awesome-css" href="/public/owner/css/font-awesome.min.css?v=20151217" type="text/css" media="screen" />
<link rel="shortcut icon" href="/public/owner/images/favicon.ico">
<script type="text/javascript">
var baseUrl = '<?php echo base_url(); ?>';
</script>
<script type="text/javascript">
$(window).load(function(){
    $('#slider').nivoSlider({
        manualAdvance:true,
    });
});
$(function() {
	// 未読メール数の取得・表示処理
	$.ajax({
		url:  '/owner/inbox/getUnreadMsgNo',
		type: 'post'
	}).done(function(data) {
		var unreadCount = Number(data);
		if (unreadCount) {
			$('#newmsg_no').show().html(unreadCount);
		}
	});
});
</script>
</head>
<body oncontextmenu ="return false">
<?php $this->load->view('owner/share/header'); ?>
<?php $this->load->view('owner/share/navi'); ?>
    <div id="wrapper">
        <div id="container">
<!--		<p style="color: red;">＜サーバーメンテナンス情報＞
			<br>
			日程：９月７日
			<br>
			時間：10:30-12:30
			<br>
			※場合によりメンテナンス時間が前後する場合がございます。<br>何卒ご了承くださいませ。</p>  -->
        <?php $this->load->view($loadPage); ?>

        </div><!-- container ここまで -->
    </div><!-- wrapper ここまで -->

    <?php $this->load->view('owner/share/footer'); ?>
    <input type="hidden" id ="base_id" value="<?php echo base_url()?>"/>
</body>
</html>

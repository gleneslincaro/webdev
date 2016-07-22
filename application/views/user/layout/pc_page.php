<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>風俗・求人と言えば高収入アルバイトのジョイスペ！</title>
<meta name="globalsign-domain-verification" content="EWViljVEJ_QOS1trhJ_t11IoisbuWZSdbMg5mFnJWg" />
<meta name="keywords" content="高収入,アルバイト,スマホ,スマートフォン,日本全国,お祝い金" />
<meta name="description" content="スマホで日本全国の高収入アルバイトが簡単に見つかる！さらにお祝い金がもらえる！" />
<link rel="stylesheet" type="text/css" href="<? echo base_url();?>public/user/css/common.css" />
<?php
$over18_flag = $this->input->cookie('over18_flag',TRUE);
if ( $over18_flag != 1 ){ ?>

<script type="text/javascript" src="<?php echo base_url(); ?>public/user/js/jquery-1.9.0.min.js"></script>
<script type="text/javascript" src="<? echo base_url();?>public/user/js/jquery.cookie.js" /></script>
<link rel="stylesheet" type="text/css" href="<? echo base_url();?>public/user/css/modal.css" />

<?php } ?>
</head>
<body>

<div id="lp_header_area">
	<div id="lp_header"><h1><a href="<? echo base_url();?>" alt="joyspe">joyspe</a></h1></div>
</div>

<div id="lp_area01">
	<div class="lp_contents"><img src="<? echo base_url();?>public/user/image/img01.png"></div>
</div>

<div id="lp_area02">
	<div class="lp_border_lace"></div>
	<div class="lp_contents"><img src="<? echo base_url();?>public/user/image/img02.png"></div>
</div>

<div id="lp_area03">
	<div class="lp_border_lace"></div>
	<div class="lp_contents"><img src="<? echo base_url();?>public/user/image/img03.png"></div>
</div>

<div id="lp_area04">
	<div class="lp_border_lace"></div>
	<div class="lp_contents"><img src="<? echo base_url();?>public/user/image/img04.png"></div>
</div>

<div id="lp_footer_area">
	<div id="lp_footer">

		<a href="http://www.joyspe.com/owner/" target="_blank"><img src="<? echo base_url();?>public/user/image/banner.jpg"></a><br />
		<a href="<?php echo base_url();?>user/footer/pdictionary_a" class="yogo_link">用語辞典</a>
<br />
		Copyright &copy; joyspe All Rights Reserved.


	</div>
</div>
<?php if ( $over18_flag != 1){ ?>
<!-- モーダル部分 -->
<?php $this->load->view('over18_modal'); ?>
<?php } ?>

<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-49474968-2']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'stats.g.doubleclick.net/dc.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
</body>
</html>

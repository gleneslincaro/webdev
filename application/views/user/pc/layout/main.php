<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo $titlePage ?></title>
<meta name="language" content="ja" />
<meta name="globalsign-domain-verification" content="EWViljVEJ_QOS1trhJ_t11IoisbuWZSdbMg5mFnJWg" />
<meta name=viewport content="width=device-width, initial-scale=1">
<?php if (isset($webtest)) : ?>
<meta name="robots" content="noindex">
<?php endif; ?>
<?php if (isset($keywords)) : ?>
<meta name="keywords" content="<?php echo $keywords; ?>">
<?php endif; ?>
<?php if(isset($makia) && $makia == true):?>
<meta name="robots" content="noindex,nofollow" />
<?php endif;?>
<?php if (isset($description)) : ?>
<meta name="description" content="<?php echo $description; ?>">
<?php endif; ?>
<?php if(isset($makia) && $makia == true):?>
<link rel='canonical' href='/user/registration/' />
<?php endif;?>
<?php if(isset($feature_canonical)) : ?>
<link rel="canonical" href="<?php echo $feature_canonical; ?>" />
<?php endif;?>
<?php
$get_treatment = $this->input->get('treatment');
$get_cate = $this->input->get('cate');
?>
<?php if (isset($from_404)) :?>
<meta name="robots" content="noindex">
<?php elseif ($get_treatment || $get_cate) : ?>
<?php if ((isset($storeOwner) && count($storeOwner) < 1) && (isset($count_all) && $count_all < 1)) : ?>
<meta name="robots" content="noindex">
<?php endif;?>
<?php endif; ?>
<?php if (isset($regist_page) && ($regist_page == 'signup')) : ?>
<link rel="canonical" href="<?php echo base_url(); ?>user/signup/" >
<?php endif; ?>
<?php if (isset($site_type) && ($site_type == 'aruaru')) : ?>
<link rel="shortcut icon" href="<?php echo base_url(); ?>public/user/pc/image/common/icon/favicon_aruaru.ico">
<?php else: ?>
<link rel="shortcut icon" href="<?php echo base_url(); ?>public/user/image/favicon.ico">
<?php endif; ?>
<?php
$over18_flag = $this->input->cookie('over18_flag', TRUE);
if (isset($skip_over18_page_flg) && $skip_over18_page_flg == true) {
    $over18_flag = 1;
}
?>
<link rel="stylesheet" type="text/css" href="/public/user/pc/css/jquery-ui.min.css">
<link rel="stylesheet" type="text/css" href="/public/user/pc/css/reset.css">
<link rel="stylesheet" type="text/css" href="/public/user/pc/css/html5reset.css">
<link rel="stylesheet" type="text/css" href="/public/user/pc/css/jquery.bxslider.css">
<link rel="stylesheet" type="text/css" href="/public/user/pc/css/adjust.css">
<link rel="stylesheet" type="text/css" href="/public/user/pc/css/common.css?v=20160714">
<link rel="stylesheet" type="text/css" href="/public/user/pc/css/component.css?v=20160714">
<link rel="stylesheet" type="text/css" href="/public/user/pc/css/dictionary.css" >
<link rel="stylesheet" type="text/css" href="/public/user/pc/css/style.css" />
<link rel="stylesheet" type="text/css" href="/public/user/css/modal.css" />
<link rel="stylesheet" type="text/css" href="/public/user/css/font-awesome.min.css" />
<?php if (!isset($webtest)) : ?>
<script src="/public/user/pc/js/jquery-2.2.0.min.js"></script>
<script src="/public/user/pc/js/jquery-ui.min.js"></script>
<?php endif; ?>
</head>
<body>
<?php if (isset($webtest)) : ?>
テスト
<?php endif; ?>
<div class="page_wrap">
	<?php // include '/share/header.html'; ?>
<?php if (!isset($webtest)) : ?>
    <?php  $this->load->view($load_page); ?>
	<?php
		if (isset($site_type)) {
			if ($site_type == 'aruaru') {
				$this->load->view('user/pc/share/footer_aruaru');
			} elseif ($site_type == 'onayami') {
		        $this->load->view('user/pc/share/footer_onayami');
		    }
		} else {
			$this->load->view('user/pc/share/footer');
		}
	?>
<?php endif; ?>
</div>
<?php $this->load->view('user/pc/share/script'); ?>
<?php if (!isset($webtest)) : ?>
<?php
	if ($over18_flag != 1) {
		$this->load->view('over18_modal');
	}
?>
<?php endif; ?>
</body>
</html>

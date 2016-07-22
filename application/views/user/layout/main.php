<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title><?php echo $titlePage ?></title>
<meta name="globalsign-domain-verification" content="EWViljVEJ_QOS1trhJ_t11IoisbuWZSdbMg5mFnJWg" />
<meta name=viewport content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
<?php if(isset($makia) && $makia == true):?>
<meta name="robots" content="noindex,nofollow" />
<?php endif;?>
<?php if( isset($keywords) ){?>
<meta name="keywords" content="<?php echo $keywords; ?>">
<?php } ?>
<?php if( isset($description) ){?>
<meta name="description" content="<?php echo $description; ?>">
<?php } ?>
<?php if(isset($makia) && $makia == true):?>
<link rel='canonical' href='/user/registration/' />
<?php endif;?>
<?php if (((isset($_GET['treatment']) && isset($_GET['cate'])) || (isset ($storeOwner) && count($storeOwner) < 1 )  ) && (isset($count_all) && $count_all < 1)  ):?>
<meta name="robots" content="noindex">
<?php endif;?>
<?php if (isset($site_type) && ($site_type == 'aruaru')) : ?>
<link rel="shortcut icon" href="/public/user/pc/image/common/icon/favicon_aruaru.ico">
<?php else: ?>
<link rel="shortcut icon" href="/public/user/image/favicon.ico">
<?php endif; ?>
<link rel="stylesheet" type="text/css" href="/public/user/css/bootstrap.css" />
<link rel="stylesheet" type="text/css" href="/public/user/css/html5reset.css" />
<link rel="stylesheet" type="text/css" href="/public/user/css/reset.css" />
<link rel="stylesheet" type="text/css" href="/public/user/css/experiences.css" />
<link rel="stylesheet" type="text/css" href="/public/user/css/font-awesome.min.css" />
<link rel="stylesheet" type="text/css" href="/public/user/css/margin.css?v=20150609" />
<link rel="stylesheet" type="text/css" href="/public/user/css/jquery.sidr.css" />
<link rel="stylesheet" type="text/css" href="/public/user/css/multiple-select.css" />
<link rel="stylesheet" type="text/css" href="/public/user/css/jquery-bxslider.css?v=20150702" />
<link rel="stylesheet" type="text/css" href="/public/user/css/common.css?v=20160519" />
<link rel="stylesheet" type="text/css" href="/public/user/css/component.css?v=20160526" />
<link rel="stylesheet" type="text/css" href="/public/user/css/page_details.css" />
<link rel="stylesheet" type="text/css" href="/public/user/css/campaign_details.css" />
<?php if (!isset($company_detail_page)) :?>
<link rel="stylesheet" type="text/css" href="/public/user/css/mybootstrap.css?v=20150706" />
<?php endif; ?>
<link rel="stylesheet" type="text/css" href="/public/user/css/user_modal.css?v=20151102" />
<?php if (isset($load_css)) :?>
<?php $this->load->view($load_css); ?>
<?php endif; ?>
<!--<script type="text/javascript" src="http://www.google.com/jsapi"></script>-->
<script type="text/javascript" src="/public/user/js/jquery-1.9.0.min.js"></script>
<script type="text/javascript"> var title="<?php echo (isset($title))?$title:''; ?>"; </script>
<script type="text/javascript" src="/public/user/js/common.js?v=20150609"></script>
<script type="text/javascript" src="/public/user/js/jquery.sidr.min.js"></script>
<script type="text/javascript" src="/public/user/js/jquery.biggerlink.js"></script>
<script type="text/javascript" src="/public/user/js/jquery.smoothscroll.js"></script>
<script type="text/javascript" src="/public/user/js/jquery.multiple.js"></script>
<script type="text/javascript" src="/public/user/js/jquery.bxslider.js"></script>
<script type="text/javascript" src="/public/user/js/jquery.nivo.slider.js"></script>
<script type="text/javascript" src="/public/user/js/jquery-form.js"></script>
<script type="text/javascript" src="/public/user/js/jquery.leanModal.min.js"></script>
<script type="text/javascript" src="/public/user/js/main.js?v=20150513"></script>
<?php
$over18_flag = $this->input->cookie('over18_flag',TRUE);
$onedayclose_flag = $this->input->cookie('dialog_oneday_flag',TRUE);
$modal_close = $this->session->userdata('modal');
if ( isset($skip_over18_page_flg) && $skip_over18_page_flg == true ) {
    $over18_flag = 1;
}
if ($over18_flag != 1){ ?>
    <script type="text/javascript" src="<?php echo base_url();?>public/user/js/jquery.cookie.js"></script>
    <?php
    $this->load->library('user_agent');
    if($this->agent->is_mobile()){ ?>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>public/user/css/modal_sp.css" />
    <?php }else{ ?>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>public/user/css/modal.css" />
    <?php } ?>
<?php } ?>
<?php if($onedayclose_flag != 1):?>
    <script type="text/javascript" src="<?php echo base_url();?>public/user/js/jquery.cookie.js"></script>
<?php endif;?>
</head>
<body>
    <?php if (isset($page_wrap_qa_list)) :?>

    <div class="page_wrap <?php echo $page_wrap_qa_list; /* page_wrap--store_everyone_qa_list */ ?>">
                <?php $this->load->view($load_page); ?>
                <input type="hidden" value="<?php echo base_url() ?>" id="base" />
                <div id="kq"></div>

                <?php if (!isset($noCompanyInfo)) :?>
                    <?php $this->load->view('user/template/company_info'); ?>
                <?php endif; ?>
    </div>
    <?php else: ?>
    <?php
        if (isset($site_type)) {
            if ($site_type == 'aruaru') {
                $this->load->view('user/share/header_aruaru');
            } elseif ($site_type == 'onayami') {
                $this->load->view('user/share/header_onayami');
            }
        } else {
            $this->load->view('user/share/header');
        }
    ?>
    <div class="page_wrap
        <?php echo isset($class_ext)? ' page_wrap--'.$class_ext:''; echo (isset($getCity)? ' page_wrap--area':''); echo (isset($getTowns)? ' page_wrap--prefectures':''); echo (isset($storeOwner)? ' page_wrap--city':''); echo (isset($groupCity_info)? ' group_'.$groupCity_info['alph_name']:''); echo (isset($page_wrap_qa_list)? ' '.$page_wrap_qa_list:''); ?>">
        <div class="page_wrap_inner">
            <div class="pagebody">
                <div class="pagebody_inner">
                <?php $this->load->view($load_page); ?>
                <input type="hidden" value="<?php echo base_url() ?>" id="base" />
                <div id="kq"></div>
                <?php if (!isset($noCompanyInfo)) :?>
                    <?php $this->load->view('user/template/company_info'); ?>
                <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <?php $this->load->view('user/share/footer'); ?>
    <?php
        $time_to_display = isset($time_to_display) ? $time_to_display : 0;
        if ($over18_flag != 1) {
            if ($this->agent->is_mobile()) {
                $this->load->view('over18_modal_sp');
            }else{
                $this->load->view('over18_modal');
            }
        }
        if((isset($priority))) {
            if(($onedayclose_flag != 1 && $modal_close != 1 && $time_to_display <= $priority['time_to_display'])) {
                if($this->agent->is_mobile()) {
                    $this->load->view('dialog_modal_sp');
                }
            }
        }
        
         if((isset($time_to_display)&&isset($priority))&&($time_to_display >= $priority['time_to_display'] && $onedayclose_flag != 1)) {
            if($this->agent->is_mobile()) {
                $this->load->view('dialog_modal_sp');
            }
        }
    ?>
</body>
</html>

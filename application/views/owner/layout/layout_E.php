<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title><?php echo $title; ?></title>
        <meta name="robots" content="noindex">
        <meta name="language" content="en" />
        <link href="<?php echo base_url(); ?>public/owner/css/common.css?v=20150525" rel="stylesheet"/>
        <link href="<?php echo base_url(); ?>public/owner/css/jquery.sticky-placeholder.css" rel="stylesheet"/>
        <link rel="shortcut icon" href="<?php echo base_url(); ?>public/owner/images/favicon.ico">
        <script type="text/javascript" src="<?php echo base_url();?>public/owner/js/jquery-1.8.0.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>public/owner/js/jquery-form.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>public/owner/js/jquery.js"></script>

        <script type="text/javascript">
            var baseUrl = '<?php echo base_url(); ?>';
        </script>
    </head>

    <body oncontextmenu ="return false">

        <?php $this->load->view('owner/share/header'); ?>

        <div id="wrapper">
            <div id="container">
                <?php $this->load->view($loadPage); ?>
            </div><!-- container ここまで -->
        </div><!-- wrapper ここまで -->

        <?php $this->load->view('owner/share/footer'); ?>



    </body>
</html>

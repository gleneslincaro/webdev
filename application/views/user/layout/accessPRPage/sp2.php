<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <title><?php echo $titlePage ?></title>
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">    
    <meta name="description" content="">
    <meta name="keywords" content="">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>public/user/css/remoteLoginSp/sp2/html5reset.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>public/user/css/remoteLoginSp/sp2/common.css">
    
    <script type="text/javascript" src="<?php echo base_url(); ?>public/user/js/jquery-1.9.0.min.js"></script>
  </head>

  <body class="top">
    <div id="main">
     <?php $this->load->view($load_page); ?>       
    </div><!--//main-->
    <footer>
      <address>Copyright © joyspe All Rights Reserved.</address>
    </footer>
  </body>
</html>
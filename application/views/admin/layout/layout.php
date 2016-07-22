<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="robots" content="noindex">        
<title><?php echo $titlePage ?></title>
<link type="text/css" rel="stylesheet" href="<?php echo base_url()."public/admin/css/style.css?v=20150611" ?>" />
<script language="javascript" src='<?php echo base_url()."public/admin/js/jquery-1.8.0.min.js" ?>'></script>
<script language="javascript" src='<?php echo base_url()."public/admin/js/jquery-form.js" ?>'></script>
<script language="javascript" src='<?php echo base_url()."public/admin/js/admin.js?v=20150611" ?>'></script>
<script language="javascript" src='<?php echo base_url()."public/admin/js/popup.js" ?>'></script>
<link type="text/css" rel="stylesheet" href="<?php echo base_url()."public/admin/css/jquery-ui.css" ?>">
<script language="javascript" src='<?php echo base_url()."public/admin/js/jquery-ui-1.9.2.custom.min.js" ?>'></script>
<script language="javascript" src='<?php echo base_url()."public/admin/js/jquery-ui-1.9.2.custom.js" ?>'></script>
<script language="javascript" src='<?php echo base_url()."public/admin/js/underscore.js" ?>'></script>
<script language="javascript" src='<?php echo base_url()."public/admin/js/backbone.js" ?>'></script>
<script language="javascript" src='<?php echo base_url()."public/admin/js/jqueryupload.js" ?>'></script>
<script language='javascript'>
    $(document).ready(function(){
        deletePoint();
        upRecord();
        checked();
        downRecord();
        displayPopupError();
        pagingByAjax_nm();
        aprovideUS();
        pagingByAjaxPen_nm();
        checkFromDateAndToDate();
        changeSelectOptions();
   })
</script>
</head>
    <body>
        <div id='main'>
            <div id='leftmenu'>
                <?php $this->load->view("admin/layout/leftmenu.php"); ?>
            </div>
            <div id="content">
                <?php $this->load->view($loadPage) ?>  
                <?php 
                    if(isset($message)){
                        echo Helper::print_error($message); 
                    }
                ?> 
                <input type="hidden" value="<?php echo base_url() ?>" id="base" />
            </div>
        </div>
    </body>
</html>

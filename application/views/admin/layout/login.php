<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="robots" content="noindex">        
        <title>joyspe管理画面</title>
        <script language="javascript" src='<?php echo base_url()."public/admin/js/jquery-1.8.0.min.js" ?>'></script>
        <script language="javascript" src='<?php echo base_url()."public/admin/js/jquery-form.js" ?>'></script>
        <link type="text/css" rel="stylesheet" href="<?php echo base_url()."public/admin/css/jquery-ui.css" ?>">
       
        <script language='javascript'>
            $(document).ready(function(){
 
       var div_error = $(".hide-error");
        if (div_error.length > 0) {
            var error = div_error.text();
            var arr = error.split('● ');
            var strErr = "";
            for (i = 1; i < arr.length; i++)
            {                   
                strErr += '● ' + arr[i] + "\n";
            }
            alert(strErr);
        }
        
           })
        </script>
        <style>
            .hide-error{
                display: none;
            }
        </style>
    </head>

    <body>
            <?php $this->load->view($loadPage) ?>
         <?php 
                    if(isset($message)){
                        echo Helper::print_error($message); 
                    }
                ?> 
           
    </body>
</html>

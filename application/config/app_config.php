<?php
    /**
    * @author  [IVS] Nguyen Bao Trieu
    * @name 	null
    * @todo 	config send mail
    * @param 	null
    * @return 	null
    */
    $config['useragent']   = 'PHPMailer';  
    $config['protocol']    = 'mail';  
    $config['smtp_host']   = 'mail.joyspe.com';  
    $config['smtp_user']   = 'info@joyspe.com';    
    $config['charset']     = 'utf-8';  
    $config['wordwrap']    = FALSE;
    $config['newline']     = "\r\n";  
    $config['mailtype']    = 'text';
    $config['validation']  = TRUE; // bool whether to validate email or not
    $ci =& get_instance();  
    $ci->load->library('email');  
    $ci->email->initialize($config);  
?>

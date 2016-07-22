<?php

class testing extends MY_Controller {

    private $viewData = array();
    private $common;
    private $validator;
    private $layout = 'user/layout/main';
    private $message = array('success' => true, 'error' => array());

    public function __construct() {
        parent::__construct();
        error_reporting(E_ALL);
        ini_set("display_errors", 1);
		$this->redirect_pc_site();
        $this->common = new Common();
        $this->validator = new FormValidator();
        $this->viewData['idheader'] = 2;
        $this->viewData['div'] = '';
        $this->viewData['module'] = $this->router->fetch_module();
        $this->load->library('email');
        $this->load->helper('email');
        $this->form_validation->CI = & $this;
    }

    public function index() {
        $from = $this->config->item('smtp_user');
        $to = "stefengratz@gmail.com";
        //$to = "lhthanh@vitenet.net";
        $subject = "Test mail ";
        

        echo "========== TESTING SENDMAIL FUNCTION============ <br/> <br/>";
        echo "FROM USER: $from <br/>";
        
        echo "========= STMP FUNCTION ============ <br/>";
        $this->sendMailSmtp($from, $to, $subject);
        echo "<br/> <br/>";
        echo "========= NORMAL FUNCTION ========== <br/>";
        $this->sendMailNormal($from,$to, $subject);
        
        
        die;
    }

    private function sendMailSmtp($from, $to, $subject) {
        $body = "Send mail SMTP";
        $microtimeFrom = microtime(true);
        echo " FROM: ". $microtimeFrom. " (".date('Y-m-d H:i:s',$microtimeFrom).") " . "<br/>";
        //send_email($to, $subject, $body);

        /*
        $this->email->clear();
        $this->email->from($from, "joyspe");
        $this->email->to($to);
        //$this->email->cc($cc);
        //$this->email->bcc($bcc);
        $this->email->subject($subject);
        $this->email->message($body); */
        $config['useragent']   = 'PHPMailer';  
        $config['protocol']    = 'mail';  
        $config['smtp_host']    = 'mail.joyspe.com';  
        $config['smtp_user']    = 'info@joyspe.com';    
        $config['charset']    = 'utf-8';  
        $config['wordwrap'] = FALSE;
        $config['newline']    = "\r\n";  
        $config['mailtype'] = 'text';
        $config['priority'] = "1";
        $config['validation'] = TRUE; // bool whether to validate email or not
        $this->email->initialize($config);  
        try {
            //$this->email->send();
            $this->email                        
                            ->from($from,"joyspe")                        
                            ->to($to)
                            //->cc($cc)
                            //->bcc($bcc)
                            ->subject($subject)
                            ->message($body)
                            ->send();
        } catch (phpmailerException $e) {
            echo $e->getMessage();
        }
        $microtimeTo = microtime(true);
        echo "SEND DONE!!!! <br/>";
        echo " TO: ". $microtimeTo. " (".date('Y-m-d H:i:s',$microtimeTo).") " . "<br/>";
        echo "<br/>TOTAL COST REAL TIME: <strong>" . ($microtimeTo - $microtimeFrom) . "</strong> Seconds";
        echo "<br/>TOTAL COST ROUND TIME: <strong>" . round($microtimeTo - $microtimeFrom) . "</strong> Seconds";
    }

    private function sendMailNormal($from,$to,$subject) {
        $body = "Send mail NORMAL";
        $microtimeFrom = microtime(true);
        echo " FROM: ". $microtimeFrom. " (".date('Y-m-d H:i:s',$microtimeFrom).") " . "<br/>";
        try {
            $header =
                "MIME-Version: 1.0\r\n" .
                "Content-type: text/html; charset=UTF-8\r\n" .
                "From: jupiter.vjsol.jp <$from>\r\n" .
                "Reply-to: $from" .
                "Date: " . date("r") . "\r\n";
            
            mail($to, $subject, $body,$header);
        } catch (Exception $e) {
            echo $e->getMessage() . "<br/>";
        }
        $microtimeTo = microtime(true);
        echo "SEND DONE!!!! <br/>";
        echo " TO: ". $microtimeTo. " (".date('Y-m-d H:i:s',$microtimeTo).") " . "<br/>";
        echo "<br/>TOTAL COST REAL TIME: <strong>" . ($microtimeTo - $microtimeFrom) . "</strong> Seconds";
        echo "<br/>TOTAL COST ROUND TIME: <strong>" . round($microtimeTo - $microtimeFrom) . "</strong> Seconds";
    }

}
?>



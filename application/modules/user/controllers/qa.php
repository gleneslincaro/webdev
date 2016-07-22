<?php
class qa extends MY_Controller{
    private $viewData = array();
    private $common;
    private $validator;
    private $layout = 'user/layout/main';
    private $message = array('success' => true, 'error' => array());
    private $device;
    public function __construct() {
        parent::__construct();
        $this->redirect_pc_site();
        $this->common = new Common();
        $this->validator = new FormValidator();  
        $this->viewData['idheader'] = NULL;
        $this->viewData['email'] = '';
        $this->viewData['class_ext'] = 'contact';
        $this->viewData['total_users'] = HelperGlobal::getUserTotalNumber();
        $this->viewData['total_owners'] = HelperGlobal::gettotalHeader();
        $this->load->library('user_agent');
        $this->device = ($this->agent->is_mobile() OR $this->input->get('device') == 'sp') ? 'sp' : 'pc';
    }
    public function index() {    
    }
    /**
    * @author [IVS] My Phuong Thi Le
    * @name   qa
    * @todo   send mail
    * @param  
    * @return void
    */
    public function qa_page()
    {
        if ($_POST) 
            $this->qa_reply_complete();
        if (UserControl::LoggedIn()){
            $this->viewData['email'] = UserControl::getEmail();
        }

        if ($this->device == 'sp') {
            $this->viewData['load_page'] = 'user/qa';
            $this->viewData['titlePage']= 'お問い合わせ｜風俗求人・高収入アルバイトのジョイスペ';
        /* pc */
        } else {
            $this->layout = 'user/pc/layout/main';
            $this->viewData['load_page'] = 'user/pc/qa';
            $this->viewData['titlePage']= 'お問い合わせ｜風俗求人・高収入アルバイトのジョイスペ';
            $breadscrumb_array = array(
                array("class" => "", "text" => "FAQ / お問い合わせ", "link"=>""),
            );
            $this->viewData['breadscrumb_array'] = $breadscrumb_array;
        }
        $this->viewData['noCompanyInfo'] = true;
        $this->viewData['message'] = $this->message;
        $this->load->view($this->layout, $this->viewData);
    }
    /**
    * @author [IVS] My Phuong Thi Le
    * @name   qa_reply_complete
    * @todo   send mail success -> den page qa_reply_complete
    * @param
    * @return void
    */
    public function qa_reply_complete()
    {
        //get values
        $joyspe= $this->config->item('smtp_user');
        $email = trim($this->input->post('email'));
        $subject = trim($this->input->post('subject'));
        $body = trim($this->input->post('body'));
        //set values
        $this->form_validation->set_rules('email', 'メールアドレス', 'required|valid_email|checkStringByte');
        $this->form_validation->set_rules('subject', '件名', 'required');
        $this->form_validation->set_rules('body', '本文', 'required');

        $this->form_validation->set_error_delimiters('<div class="ui_msg ui_msg-error"><p>', '</p></div>');
        $form_validation = $this->form_validation->run();
        $this->message['success'] = !$form_validation ? FALSE : TRUE;
        if (!$form_validation) {
            return false;
        } else {
            //send mail
            $this->common->sendMailObject($email, $joyspe, '', '', $subject, $body, '');
            //send success
            redirect(base_url() . "user/contact/complete/");
        }
    }
    /**
    * @author [IVS] My Phuong Thi Le
    * @name   qa_complete
    * @todo   send mail
    * @param  
    * @return void
    */
    public function qa_complete()
    {
        if ($this->device == 'sp') {
            $this->viewData['load_page'] = 'user/qa_reply_complete';
        /* pc */
        } else {
            $this->layout = 'user/pc/layout/main';
            $this->viewData['load_page'] = 'user/pc/qa_reply_complete';

            $breadscrumb_array = array(
                array("class" => "", "text" => "お問い合わせ・送信完了", "link"=>""),
            );
            $this->viewData['breadscrumb_array'] = $breadscrumb_array;

        }
        $this->viewData['titlePage']= '送信完了｜風俗求人・高収入アルバイトのジョイスペ';
        $this->viewData['message'] = $this->message;
        $this->load->view($this->layout, $this->viewData);
    }
}
?>

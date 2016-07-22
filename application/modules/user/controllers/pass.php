<?php
class pass extends MY_Controller{
    private $viewData = array();
    private $common;
    private $validator;
    private $layout = 'user/layout/main';
    private $message = array('success' => true, 'error' => array());
    private $device = 'sp';
    public function __construct() {
        parent::__construct();
		$this->redirect_pc_site();
        $this->common = new Common();
        $this->validator = new FormValidator();
        $this->viewData['idheader'] = null;
        $this->viewData['div'] = '';
        $this->viewData['module'] = $this->router->fetch_module();
        $this->viewData['total_users'] = HelperGlobal::getUserTotalNumber();
        $this->viewData['total_owners'] = HelperGlobal::gettotalHeader();
        $this->form_validation->CI = & $this;
        $this->load->library('user_agent');
        $this->device = ($this->agent->is_mobile()) ? 'sp' : 'pc';
    }
    public function index() {

    }
    /**
    * @author [IVS] My Phuong Thi Le
    * @name   resend_password
    * @todo   resend_password
    * @param
    * @return void
    */
    public function resend_password()
    {
        //get values
        $email = trim($this->input->post('email'));
        //set values
        $this->form_validation->set_rules('email', 'メールアドレス', 'required|valid_email|checkStringByte');
        $this->form_validation->set_error_delimiters('<div class="ui_msg ui_msg-error"><p>', '</p></div>');
        $form_validation = $this->form_validation->run();
        $this->message['success'] = !$form_validation ? FALSE : TRUE;

        if (!$form_validation) {
            return false;
        } else {
            $users = $this->Musers->get_users_by_email($email);  
            $userid= $users['id'];
            if ($this->checkEmailnotExits()) {
                $this->common->sendMail('', '', '', array('us13'), '', '', $userid, '', '', '', '', '', '');
            }
            redirect(base_url() . "user/pass/pass_complete");
        }
     }
     /**
     * author: [IVS] My Phuong Thi Le
     * name : checkEmailExits
     * todo : check email,password
     * @param null
     * @return null
     */
     public function checkEmailnotExits()
     {
        $email = trim($this->input->post('email'));
        if ($email == "")
            return false;
        if (!$this->Musers->check_emailexit($email))
           return false;
        return true;
     }
     /**
     * @author [IVS] My Phuong Thi Le
     * @name   pass
     * @todo   send email to admin check
     * @param  
     * @return void
     */
    public function pass_page()
    {
        if ($this->device == 'sp') {
            $this->viewData['load_page'] = 'user/pass';
        /* pc */
        } else {
            $breadscrumb_array = array(
                array("class" => "", "text" => "パスワードを忘れた場合", "link"=>""),
            );
            $this->viewData['breadscrumb_array'] = $breadscrumb_array;

            $this->viewData['load_page'] = 'user/pc/pass';
            $this->layout = "user/pc/layout/main";
        }
        if ($_POST) {
            $this->resend_password();
        } 
        $this->viewData['titlePage']= 'joyspe｜パスワードを忘れた場合';
        $this->viewData['message'] = $this->message;
        $this->load->view($this->layout, $this->viewData);
     }

     public function pass_complete()
     {
        if ($this->device == 'sp') {
            $this->viewData['load_page'] = 'user/qasend_reply_complete';
        /* pc */
        } else {
            $breadscrumb_array = array(
                array("class" => "", "text" => "パスワードの再送完了", "link"=>""),
            );
            $this->viewData['breadscrumb_array'] = $breadscrumb_array;
            $this->viewData['load_page'] = 'user/pc/qasend_reply_complete';
            $this->layout = "user/pc/layout/main";
        }
        $this->viewData['titlePage']= 'joyspe｜送信完了';
        $this->viewData['message'] = $this->message;
        $this->load->view($this->layout, $this->viewData);
     }
}
?>



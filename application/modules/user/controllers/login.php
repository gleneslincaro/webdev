<?php
class login extends MY_Controller{
    private $viewData = array();
    private $common;
    private $validator;
    private $layout = 'user/layout/main';
    private $message = array('success' => true, 'error' => array());

    public function __construct() {
        parent::__construct();
		$this->redirect_pc_site();
        $this->common = new Common();
        $this->validator = new FormValidator();
        $this->viewData['idheader'] = 2;
        $this->viewData['div'] = '';
        $this->viewData['module'] = $this->router->fetch_module();
        $this->form_validation->CI = & $this;
        $this->load->model("user/Mcaptcha");
        $this->viewData['total_users'] = HelperGlobal::getUserTotalNumber();
        $this->viewData['total_owners'] = HelperGlobal::gettotalHeader();
        $this->load->library('user_agent');
    }
    public function index() {
        
        $from_external_site = HelperApp::from_external_site();
        if ($from_external_site) {
            if (UserControl::LoggedIn()) {
                redirect($this->agent->referrer()); 
            }
            //if not logged in and from external, set external flag
            HelperApp::add_session("external_site_flag", true);
            HelperApp::add_session("external_site_referrer", $this->agent->referrer());   
            $this->viewData['site_type'] = HelperApp::aruaru_or_onayami($this->agent->referrer());
        }   
        if (UserControl::LoggedIn()) {
            redirect(base_url());
        }  
        //if referral from external add flag to redirect back
        if ($from_external_site) {
            HelperApp::add_session("external_site_flag", true);
            HelperApp::add_session("external_site_referrer", $this->agent->referrer());    
        }

        if ($_POST && (!$this->input->post('onayamilogin'))) {
            $this->do_login();
        }

        $backurl = '';
        if ($this->input->post('onayamilogin')) {
            if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on')
            {
                $temp = 'https://';
            } else {
                $temp = 'http://';
            }
            $string = $_SERVER["HTTP_HOST"];
            $pattern = '/www/i';
            $replacement = 'onayami';
            $dome = preg_replace($pattern, $replacement, $string);

            $backurl = $temp . $dome . "/";

        }
        $this->viewData['backurl'] = $backurl;


        $this->load->library('user_agent');
        /* sp */
        if ($this->agent->is_mobile()) {
            $this->viewData['load_page'] = 'user/login';
        /* pc */
        } else {
            $this->layout = 'user/pc/layout/main';
            $this->viewData['load_page'] = 'user/pc/login';
            $breadscrumb_array = array(
                array("class" => "", "text" => "ログイン", "link"=>"")
            );
            $this->viewData['breadscrumb_array'] = $breadscrumb_array;
        }
        $this->viewData['titlePage']= 'ログイン｜風俗求人・高収入アルバイトのジョイスペ';
        $this->viewData['message'] = $this->message;
        $this->viewData['class_ext'] = 'login';
        $this->load->view($this->layout, $this->viewData);
    }
     /**
     * @author [IVS] My Phuong Thi Le
     * @name   do_login
     * @todo   login
     * @param
     * @return void
     */
    public function do_login() {
        $backurl = '';
        if ($this->input->post('backurl')) {
            $backurl = $this->input->post('backurl');
        }
        $email = trim($this->input->post('email'));
        $has_captcha = $this->input->post('has_captcha');
        $pass = base64_encode($this->input->post('password'));
        $this->form_validation->set_rules('email', 'メールアドレス', 'trim|required|valid_email|max_length[200]|checkStringByte|callback_checkEmailnotExits|callback_checkLogin|callback_checkDisableuser');
        $this->form_validation->set_rules('password', 'パスワード', 'trim|required|min_length[4]|max_length[20]|checkStringByte');
        //check if captcha exist.
        if ($has_captcha) {
            $this->form_validation->set_rules('captcha', 'キャップトチャ', 'callback_check_captcha');
        }
        $form_validation = $this->form_validation->run();
        $this->message['success'] = !$form_validation ? FALSE : TRUE;
        $users = $this->Musers->get_users_by_email($email);
        $module = $this->router->fetch_module();
        $unique_id = isset($users['unique_id'])?$users['unique_id']:null;
        if (!$form_validation){
            //display captcha if fail login times >= LOGIN_FAILS_LIMIT
            $img = $this->common->display_captcha($module, $unique_id, $email);
            if ($img) {
                $this->viewData['captcha_img'] = $img['image'];
            }
            return false;
        }
        else {
            //Reset fail login times if success login.
            $is_reset = $this->Mcaptcha->reset_fail_login_times($module, $unique_id, $_SERVER["REMOTE_ADDR"], false, $email);
            HelperApp::add_session('id', $users['id']);
            HelperApp::add_session('user_info', array('unique_id' => $users['unique_id'],'user_from_site' => $users['user_from_site'], 'profile_pic' => $users['profile_pic'], 'profile_pic2' => $users['profile_pic2'], 'profile_pic3' => $users['profile_pic3']));
            $data = array(
            'last_visit_date' => date("y-m-d H:i:s"),
            );
            $this->Musers->update_User($data, $users['id']);

            // check if user can join campaign
            if ($users['user_from_site'] == 1 || $users['user_from_site'] == 2) {// just for makia/machemoba user
                if ($stp_cpgn_id = $this->Musers->canJoinStepUpCampaign($users['id'])) {
                    // insert data for step up campaign data(if not created)
                    $this->Musers->startJoinACampaign($users['id'], $stp_cpgn_id);
                }
            }

            //check if user has already login within this day
            $this->common->updateLoginBonus($users['id'], $users['user_from_site'], $users['last_visit_date']);
            
            $external_site_flag = HelperApp::get_session('external_site_flag');
            if ($external_site_flag) {
                $backurl = HelperApp::get_external_referrer(); //get external referrer
                HelperApp::remove_session('external_site_flag');
            }
            
            $linklog = base_url() . "user/login";
            $return_url = isset($_GET['return_url']) && trim($_GET['return_url']) != "" ? urldecode(trim($_GET['return_url'])) : base_url();
            if (!$this->Musers->check_email_user_status0($email, $pass)) {
                $user_recruits= $this->Musers->get_user_recruits($users['id']);
                if ($backurl != '') {
                    redirect($backurl);
                }
                if(current_url()!=$linklog){
                    redirect($return_url);
                }
                if(current_url()==$linklog){
                   redirect(base_url());
                }
            }else {
                if ($backurl != '' && HelperApp::aruaru_or_onayami($backurl) !== false) {
                    redirect($backurl);
                }
                redirect(base_url() . "user/settings/");
            }
        }
    }
     /**
     * author: [IVS] My Phuong Thi Le
     * name : checkLogin
     * todo : check email,password
     * @param null
     * @return null
     */
    public function checkLogin() {

        $email = trim($this->input->post('email'));
        $pass = base64_encode($this->input->post('password'));
        if ($pass == "")
            return false;
        if(!$this->Musers->check_emailpassexit($email,$pass))
           return false;
        return true;
    }
     /**
     * author: [IVS] My Phuong Thi Le
     * name : checkEmailnotExits
     * todo : check email
     * @param null
     * @return null
     */
    public function checkEmailnotExits() {

        $email = trim($this->input->post('email'));
        if(!$this->Musers->check_emailexit($email))
           return false;
        return true;
    }
     /**
     * author: [IVS] My Phuong Thi Le
     * name : checkDisableuser
     * todo : check disable
     * @return boolean
     */
    public function checkDisableuser() {
        $email = trim($this->input->post('email'));
        $pass = base64_encode($this->input->post('password'));
        if ($email == "")
            return false;
        if ($pass == "")
            return false;
        if ($this->Musers->check_email_user_status($email,$pass))
           return false;
        return true;
    }
     /**
     * author: [IVS] My Phuong Thi Le
     * name : logout
     * todo : clear sesion of users return top index
     * @param null
     * @return null
     */
    public function logout() {
        $this->load->library('user_agent');
        HelperApp::clear_session();
        $this->session->unset_userdata('modal');
        if($this->agent->is_mobile()){
            redirect(base_url());
        } else {
            echo 'true';
        }
    }

    /**
     * Check if the captcha inputted value is correct/match.
     *
     * @param   string  $str an inputted captcha value.
     * @return  true or false
     */
    public function check_captcha($str)
    {
        return $this->common->check_captcha($str);
    }
}
?>

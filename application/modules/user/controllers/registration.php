<?php
class registration extends MY_Controller{
    private $viewData = array();
    private $common;
    private $validator;
    private $layout = 'user/layout/main';
    private $message = array('success' => true, 'error' => array());
    public function __construct() {
        parent::__construct();
		$this->redirect_pc_site();
        $this->load->library("session");
        $this->common = new Common();
        $this->validator = new FormValidator();
        $this->viewData['idheader'] = 2;
        $this->viewData['divemail'] = '';
        $this->viewData['class_ext'] = 'signup';
        $this->viewData['module'] = $this->router->fetch_module();
        $this->viewData['skip_over18_page_flg'] = true;
        $this->form_validation->CI = & $this;
        $this->viewData['total_users'] = HelperGlobal::getUserTotalNumber();
        $this->viewData['total_owners'] = HelperGlobal::gettotalHeader();
        $this->load->library('user_agent');
        $this->device = ($this->agent->is_mobile()) ? 'sp' : 'pc';
    }
    public function index() {
        $now = getdate();
        
        $from_external_site = HelperApp::from_external_site();
        if ($from_external_site) {
            if (UserControl::LoggedIn()) {
                redirect($this->agent->referrer());
            }
            HelperApp::add_session("external_site_flag", true);
            HelperApp::add_session("external_site_referrer", $this->agent->referrer());
            $this->viewData['site_type'] = HelperApp::aruaru_or_onayami($this->agent->referrer());
        }
        if($_POST && (!$this->input->post('onayamisignup'))) { 
            $this->do_registration(false);
        }
        if($now['month']<4){
            $this->viewData['year'] = $now['year']-17;
        }else{
            $this->viewData['year'] = $now['year']-18;
        }

        $backurl = '';
        if ($this->input->post('onayamisignup') || $this->input->post('backurl')) {

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

         //------ check owner went from where---------
        $get = $this->uri->segment(4);
        $websiteId = '';
        if(!empty($get))
        {
            $websiteId = $this->mowner->getIdWebSite($get);
        }
        $this->viewData['webside']   =$websiteId;

        $device = '';
        if (isset($_GET['device'])) {
            $device = $_GET['device'];
        }
        $this->load->library('user_agent');
        /* sp */
        if ($this->agent->is_mobile() OR $device == 'sp') {
            $this->viewData['load_page'] = 'user/registration';
        /* pc */
        } else {
           $this->layout = 'user/pc/layout/main';
           $this->viewData['load_page'] = 'user/pc/registration';
           $breadscrumb_array = array(
               array("class" => "", "text" => "新規会員登録", "link"=>"")
           );
           $this->viewData['breadscrumb_array'] = $breadscrumb_array;
        }

        $this->viewData['regist_page'] = 'signup';

        $this->viewData['titlePage'] = '新規会員登録｜風俗求人・高収入アルバイトのジョイスペ';
        $this->viewData['message'] = $this->message;
        $this->load->view($this->layout, $this->viewData);
   }
    /**
    * @author [IVS] My Phuong Thi Le
    * @name   registration_after
    * @todo   after registration to page registration_after
    * @param
    * @return void
    */
   public function registration_after() {
        $this->viewData['load_page'] = 'user/registration_after';
        $this->viewData['titlePage'] = '風俗求人 -ジョイスペ-｜新規会員登録';
        $this->viewData['message'] = $this->message;
        $this->load->view($this->layout, $this->viewData);
   }
    /**
    * author: [IVS] My Phuong Thi Le
    * name : checkEmailExits
    * todo : check email,password
    * @param null
    * @return null
    */
    public function checkEmailExits() {
        $email = trim($this->input->post('email_address'));
        if ($email == "")
            return false;
        if($this->Musers->check_emailexit($email))
           return false;
        return true;
    }
     /**
     * @author [IVS] My Phuong Thi Le
     * @name   do_registration
     * @todo   registration
     * @param
     * @return void
     */
   private function do_registration($makia = false) {
        $now = getdate();
        $user_from_site = 0;
        
        if($now['month']<4){
            $this->viewData['year'] = $now['year']-17;
        }else{
            $this->viewData['year'] = $now['year']-18;
        }
        // get values
        $uniqueid = random_string('alnum', 8);
        $email_address = $this->input->post('email_address');
        $reg_address = $this->input->post('reg_address');
        //get webside id
        $service_in_user = $this->input->post('service_in_use');
        $webside = ($service_in_user != '')?$service_in_user:$this->input->post('webside');
        $password = base64_encode($this->input->post('password'));
        // set values
        $this->form_validation->set_rules('email_address', 'メールアドレス', 'required|valid_email|checkStringByte|max_length[200]|callback_checkEmailExits');
        $this->form_validation->set_rules('password', 'パスワード', 'required|checkStringByte|min_length[4]|max_length[20]');
        if($makia) {
            //$this->form_validation->set_rules('service_in_use', 'ご利用中のサービス', 'required');
            $this->form_validation->set_rules('reg_address', 'AMM/ZIP/Amanteで使用しているメールアドレス', 'required');
            $this->viewData['service_in_user']= 44; //$service_in_user; 02/09 仕様変更でデフォルト44にします
            $webside = 44; //02/09 仕様変更でデフォルト44にします
            HelperApp::add_session("makia_flag", true);
            $user_from_site = 2;
            $reg_address = "マキア登録-" . $reg_address;
        }
        if( HelperApp::get_session('external_site_flag')){
            $referrer = HelperApp::get_session('external_site_referrer');
            $aruaru_or_onayami = HelperApp::aruaru_or_onayami($referrer);
            if ($aruaru_or_onayami !== false) {
                if ($aruaru_or_onayami == 'aruaru') {
                    $user_from_site = 3;
                } else if ($aruaru_or_onayami == 'onayami') {
                    $user_from_site = 4;
                }
            }
        } 
        $this->form_validation->set_error_delimiters('<div class="ui_msg ui_msg-error"><p>', '</p></div>');
        $form_validation = $this->form_validation->run();
        $this->message['success'] = !$form_validation ? FALSE : TRUE;
        if (!$form_validation){
            return false;
        }
        else {
            $data = array(

            'unique_id' => $uniqueid,
            'email_address' => $email_address,
            'password' => $password,
            'user_status' => 1,
            'display_flag'=> 1,
            'created_date' => date("y-m-d H:i:s"),
            'updated_date'=> date("y-m-d H:i:s"),
            'temp_reg_date'=> date("y-m-d H:i:s"),
            'offcial_reg_date'=> date("y-m-d H:i:s"),
            'memo'=> $reg_address,
            'website_id'=>$webside,
            'user_from_site' => $user_from_site
            );
            if ($user_from_site == 3 || $user_from_site == 4) { //default to not use if from aruaru or onayami
                $data['scout_target_flag'] = 1; //1 = not use, 0 or null = use
            }
            $this->Musers->insert_users($data);
            //send email
            $usernew = $this->Musers->get_users_by_email($email_address);
            $this->Musers->insert_User_recruits(array('user_id' => $usernew['id'], 'created_date' => date("y-m-d H:i:s")));
            if ($usernew) { // update firt login time
                $this->common->updateLoginBonus($usernew['id'], $user_from_site, "1970 00:00:01");
            }
            if($makia) {
              $this->load->Model("admin/Musers");
              $this->Musers->addNewScoutMailBonus($usernew['id']);
            }

            $url=base_url()."user/settings";
            $this->load->Model("admin/Msearch");
            $this->Msearch->approveUS($usernew['id'],date("Y-m-d-H-i-s"));
            $this->common->sendMail('', '','',array('us02'),'','',$usernew['id'],'','','','',$url,'');
            HelperApp::add_session('id', $usernew['id']);
            // update success;
            $from_site = $usernew['user_from_site'];
            if ($from_site == 3 || $from_site == 4) {
                HelperApp::remove_session('external_site_flag');
            }
            $backurl = $this->input->post('backurl');
            if ($backurl != '') {
                redirect(base_url() . "user/onayami_signup_complete");
            } else {
                redirect(base_url() . "user/signup_complete");
            }
        }
    }

    public function onayami_signup_complete() {
        if(HelperApp::get_session('makia_flag')){
            $this->viewData['makia'] = true;
            HelperApp::remove_session('makia_flag');
        }

        if ($this->device == 'sp') {
            $this->viewData['load_page'] = 'user/recommended_profile_reg';
        } else {
            $breadscrumb_array = array(
               array("class" => "", "text" => "会員登録完了", "link"=>"")
            );
            $this->viewData['breadscrumb_array'] = $breadscrumb_array;

            $backurl = '';
            if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {
                $temp = 'https://';
            } else {
                $temp = 'http://';
            }
            $string = $_SERVER["HTTP_HOST"];
            $pattern = '/www/i';
            $replacement = 'onayami';
            $dome = preg_replace($pattern, $replacement, $string);
            $backurl = $temp . $dome . "/";
            if (HelperApp::aruaru_or_onayami($backurl) === false) { 
                $backurl = $temp.ONAYAMI_URL;
            }
            $this->viewData['to_url'] = $backurl;

            $this->layout = 'user/pc/layout/main';
            //$this->viewData['load_page'] = 'user/pc/onayami_signup_conplete';
            $this->viewData['load_page'] = 'user/pc/recommended_profile_reg';
            $this->viewData['is_signup'] = true;
        }
        $this->viewData['titlePage'] = '登録完了｜風俗求人・高収入アルバイトのジョイスペ';
        $this->load->view($this->layout, $this->viewData);
    }

    public function recommended_profile_reg() {
        if(HelperApp::get_session('makia_flag')){
            $this->viewData['makia'] = true;
            HelperApp::remove_session('makia_flag');
        }
        
        if ($this->device == 'sp') {
            $this->viewData['load_page'] = 'user/recommended_profile_reg';
        } else {
            $breadscrumb_array = array(
               array("class" => "", "text" => "会員登録完了", "link"=>"")
            );
            $this->viewData['breadscrumb_array'] = $breadscrumb_array;
            $this->layout = 'user/pc/layout/main';
            $this->viewData['load_page'] = 'user/pc/recommended_profile_reg';
            $this->viewData['is_signup'] = true;
        }
        $this->viewData['to_url'] = base_url();
        if (UserControl::LoggedIn()) {
            if (UserControl::getFromSiteStatus() == 3 || UserControl::getFromSiteStatus() == 4) {
                $to_url = HelperApp::get_external_referrer(false); //get external referrer
                $this->viewData['to_url'] = $to_url; //use external url if user is from external
            }
        }
        $this->viewData['titlePage'] = '登録完了｜風俗求人・高収入アルバイトのジョイスペ';
        $this->load->view($this->layout, $this->viewData);
    }

    public function makia() {
        $mid = $this->input->post('mid');
        if ($mid) { // register with user id from Makia
            $ret = $this->Musers->checkUserExistFrom($mid);
            if (!$ret) {
                // create a new user
                $ret = $this->common->create_user_with_waiting_state($mid, 2);
            }
            //どこからのリクエスト切り分け
            $this->viewData['authOkButWaiting'] = true;
            $this->viewData['titlePage'] = '新規会員登録｜風俗求人・高収入アルバイトのジョイスペ';
            $this->viewData['load_page'] = 'user/accessPRPage/fsp2';
            $this->load->view('user/layout/accessPRPage/fsp2', $this->viewData);
        } else { // register normal user
            $now = getdate();
            if ($this->input->post("email_address")) {
                $makia = true;
                $this->do_registration($makia);
            }
            if($now['month']<4) {
                $this->viewData['year'] = $now['year']-17;
            }else{
                $this->viewData['year'] = $now['year']-18;
            }
            //------ check owner went from where---------
            $get = $this->uri->segment(4);
            $websiteId = '';
            if(!empty($get)) {
                $websiteId = $this->mowner->getIdWebSite($get);
            }
            $this->viewData['makia']= true;
            $this->viewData['webside']=$websiteId;
            $this->viewData['load_page'] = 'user/registration';
            $this->viewData['titlePage'] = '新規会員登録｜風俗求人・高収入アルバイトのジョイスペ';
            $this->viewData['message'] = $this->message;
            $this->load->view($this->layout, $this->viewData);
        }
    }
    
    /**
    * @name: unsetExternalSession
    * @desc: clears external referrer session
    * @parameters: none
    * @return: ajax response
    */
    public function unsetExternalSession() {
        $return = array();
        $referrer = HelperApp::get_session('external_site_referrer');
        if (isset($referrer)) {
            HelperApp::remove_session('external_site_referrer');
        }
        $return['status'] = 'success';
        echo json_encode($return);
        exit;
    }
    
}
?>

<?php
class profile_change extends MY_Controller{
    private $viewData = array();
    private $validator;
    private $layout = 'user/layout/main';
    private $message = array('success' => true, 'error' => array());
    private $common;
    private $file__name = '';
    private $file__temp_name = '';
    private $file__type = '';

    public function __construct() {
        parent::__construct();
        $this->redirect_pc_site();
        HelperGlobal::require_login(current_url());
        $this->load->model("owner/muser");
        $this->viewData['idheader'] = 1;
        $this->validator = new FormValidator();
        $this->viewData['divsuccessa'] = '';
        $this->viewData['divsuccessb'] = '';
        $this->viewData['divsuccessc'] = '';
        $this->viewData['divsuccessd'] = '';
        $this->viewData['divsuccesse'] = '';
        $this->viewData['total_users'] = HelperGlobal::getUserTotalNumber();
        $this->viewData['total_owners'] = HelperGlobal::gettotalHeader();
        $this->viewData['module'] = $this->router->fetch_module();
        $this->viewData['class_ext'] = 'settings';
        $this->form_validation->CI = & $this;
        $this->common = new Common();
    }
    public function index() {

    }
    public function load_profile_change($settings = '')
    {
        $this->load->library('user_agent');
        $device = $this->input->get('device');

        $id = UserControl::getId();
        if (UserControl::getUserStt()==0) {
            redirect(base_url()."user/certificate/certificate_after/");
        }
        $from_external = HelperApp::from_external_site();
        if ($from_external) {
            HelperApp::add_session("external_site_referrer", $this->agent->referrer());
        }
        $user_from_site = UserControl::getFromSiteStatus();

        if ($this->agent->is_mobile() OR $device == 'sp') {
            $external_site_referrer = HelperApp::get_external_referrer(false); //param false means unset session later.
        } else {
            $referrer_session_set = HelperApp::external_referrer_session_set();
            $external_site_referrer = HelperApp::get_external_referrer();
        }
       
        if (isset($_POST['do_user_change'])) {
            $res = $this->do_user_change();
            if ($res) {
                
                if ($external_site_referrer !== false) {
                    redirect(HelperApp::get_external_referrer());
                }
                $this->viewData['divsuccessa'] = '基本情報<br>あなたの情報が正常に更新されました';
            }
        }
        if (isset($_POST['do_user_recruits_change'])) {
            $res = $this->do_user_recruits_change();
            if ($res) {
                if ($external_site_referrer !== false) {
                    redirect(HelperApp::get_external_referrer());
                }
                $this->viewData['divsuccessb'] = '銀行口座<br>あなたの情報が正常に更新されました';
            }
        }
        if (isset($_POST['do_user_recruitslist_change'])) {
            $res = $this->do_user_recruitslist_change();
            if ($res) {
                if ($external_site_referrer !== false) {
                    redirect(HelperApp::get_external_referrer());
                }
                $this->viewData['divsuccessc'] = '求人情報<br>あなたの情報が正常に更新されました';
            }
        }
        if (isset($_POST['do_form_age_verification'])) {
            $res = $this->do_certificate();
            if ($res) {
                if ($external_site_referrer !== false) {
                    redirect(HelperApp::get_external_referrer());
                }
                $this->viewData['divsuccessd'] = 'ご本人様確認<br>あなたの情報が正常に更新されました';
            }
        }
        if (isset($_POST['do_transfer_change'])) {
            $res = $this->do_transfer_change();
            if ($res) {
                if ($external_site_referrer !== false) {
                    redirect(HelperApp::get_external_referrer());
                }
                $this->viewData['divsuccesse'] = '登録メールアドレスへ転送<br>あなたの情報が正常に更新されました';
            }
        }

        $Uniqueid = $this->Musers->get_users($id);
        $this->viewData['Uniqueid'] = $Uniqueid;

        //load user_recruits
        $uprofile = $this->Musers->get_user_recruits($id);
        $this->viewData['uprofile'] = $uprofile;
        //load combobox
        $agelist = $this->Musers->list_combobox($tbl='mst_ages');
        $this->viewData['agelist'] = $agelist;

        $heightlist = $this->Musers->list_combobox($tbl='mst_height');
        $this->viewData['heightlist'] = $heightlist;

        $citylist = $this->Musers->list_combobox($tbl='mst_cities');
        $this->viewData['citylist'] = $citylist;

        $bustlist = $this->Musers->list_combobox($tbl='mst_busts');
        $this->viewData['bustlist'] = $bustlist;

        $waistlist = $this->Musers->list_combobox($tbl='mst_waists');
        $this->viewData['waistlist'] = $waistlist;

        $hiplist = $this->Musers->list_combobox($tbl='mst_hips');
        $this->viewData['hiplist'] = $hiplist;

        $salary_range_list = $this->Musers->list_combobox($tbl='mst_salary_range');
        $this->viewData['salary_range_list'] = $salary_range_list;

        //load checkbox
        $listJobTypename = $this->Musers->list_JobType_name($id);
        $this->viewData['listJobTypename'] = $listJobTypename;

        $listJobTypenamenot = $this->Musers->list_JobType_name_not($id);
        $this->viewData['listJobTypenamenot'] = $listJobTypenamenot;
        //load radio
        $radiosetsendmail = $this->Musers->radio_set_send_mail($id);
        $this->viewData['radiosetsendmail'] = $radiosetsendmail;
        //success
        $this->viewData['noCompanyInfo'] = true;
        $this->viewData['message'] = $this->message;

        // $device = 'sp';
        /* sp */
        if ($this->agent->is_mobile() OR $device == 'sp') {
            $this->viewData['titlePage'] = 'joyspe｜プロフィール変更';
            $this->viewData['load_page'] = 'user/profile_change';
        /* pc */
        } else {
            $this->layout = 'user/pc/layout/main';
            $this->viewData['load_page'] = 'user/pc/profile_change';

            $breadscrumb_array = array(
               array("class" => "", "text" => "登録情報確認・変更", "link"=>"")
            );
            
           
            $this->viewData['breadscrumb_array'] = $breadscrumb_array;
            
            if ($settings == '' OR $settings == 'basic' OR $settings == 'profile' OR $settings == 'bank' OR $settings == 'other') {
                
                if ($referrer_session_set !== false) {
                    $this->viewData['external_ref'] = $referrer_session_set;
                }
                $settings_type = ($settings == '') ? 'profile' : $settings;
                $this->viewData['load_setting'] = 'user/pc/settings/' . $settings_type;
                $this->viewData['active_menu'] = ($settings != '')? $settings : 'profile';
                switch ($settings) {
                    case 'profile':
                            $title_txt = 'プロフィール設定';
                        break;
                    case 'bank':
                            $title_txt = '銀行口座';
                        break;
                    case 'other':
                            $title_txt = 'その他設定';
                        break;
                    case 'basic':
                            $title_txt = '基本設定';
                        break;
                    default:
//                            $title_txt = '基本設定';
                            $title_txt = 'プロフィール設定';
                        break;
                }
                $this->viewData['titlePage'] = 'joyspe｜' . $title_txt;
            }
        }
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
        $id = UserControl::getId();
        $Uniqueid = $this->Musers->get_users($id);
        $email = trim($this->input->post('email_address'));
        if($Uniqueid['email_address']!=$email){
            if ($email == "")
                return false;
            if($this->Musers->check_emailexit($email))
            return false;
        }
        return true;
    }

     public function _check_password() {
        $id = UserControl::getId();
        if (!$id) {
            return;
        }
        $Uniqueid = $this->Musers->get_users($id);
        $password = base64_encode($this->input->post('oldpassword'));
        if (!$Uniqueid || $Uniqueid['password'] != $password) {
            $this->form_validation->set_message('_check_password', '現在のパスワードは正しくありません。');
            return false;
        }
        return true;
    }
    /**
    * @author [IVS] My Phuong Thi Le
    * @name   do_user_change
    * @todo   update user
    * @param
    * @return void
    */
    public function do_user_change() {
        // get values
        $this->viewData['divsuccessc'] = '';
        $this->viewData['divsuccessb'] = '';
        $this->viewData['divsuccessa'] = '';
        $this->viewData['divsuccessd'] = '';
        $this->viewData['divsuccesse'] = '';
        $id = UserControl::getId();
        $name = $this->input->post('name');
        $email_address = $this->input->post('email_address');
        $oldpassword = base64_encode($this->input->post('oldpassword'));
        $password = base64_encode($this->input->post('newpassword'));
        $set_send_mail = $this->input->post('set_send_mail');
        // set values
        $this->form_validation->set_rules('email_address', 'メールアドレス', 'required|max_length[200]|valid_email|checkStringByte|callback_checkEmailExits');
        $this->form_validation->set_rules('oldpassword', '現在のパスワード', 'required|min_length[4]|max_length[20]|checkStringByte|callback__check_password');
        $this->form_validation->set_rules('newpassword', '新パスワード', 'required|min_length[4]|max_length[20]|checkStringByte|matches[confirmpassword]');
        $this->form_validation->set_rules('confirmpassword', '新パスワードを確認', 'trim');
        // set values not ok
        $form_validation = $this->form_validation->run();
        $this->message['success'] = !$form_validation && count($_POST) > 0 ? FALSE : TRUE;
        if (!$form_validation) {
            return false;
        } else {
            $data = array(
            'email_address' => $email_address,
            'password' => $password
            );
            $this->Musers->update_User($data, $id);
            return true;
        }
    }


    public function do_user_validation_pc() {
        $id = UserControl::getId();
        $name = $this->input->post('name');
        $email_address = $this->input->post('email_address');
        $oldpassword = base64_encode($this->input->post('oldpassword'));
        $password = base64_encode($this->input->post('newpassword'));
        $set_send_mail = $this->input->post('set_send_mail');
        // set values
        $this->form_validation->set_rules('email_address', 'メールアドレス', 'required|max_length[200]|valid_email|checkStringByte|callback_checkEmailExits');
        $this->form_validation->set_rules('oldpassword', '現在のパスワード', 'required|min_length[4]|max_length[20]|checkStringByte|callback__check_password');
        $this->form_validation->set_rules('newpassword', '新パスワード', 'required|min_length[4]|max_length[20]|checkStringByte|matches[confirmpassword]');
        $this->form_validation->set_rules('confirmpassword', '新パスワードを確認', 'trim');
        // set values not ok
        $this->form_validation->set_error_delimiters('<p>', '</p>');
        $form_validation = $this->form_validation->run();
        $this->message['success'] = !$form_validation && count($_POST) > 0 ? FALSE : TRUE;

        $array = array();
        $array['error_message'] = '';
        $success = !$form_validation && count($_POST) > 0 ? FALSE : TRUE;
        $error_message = $this->form_validation->error_string();

        $ar = array();
        $array['error'] = $success;
        if (!$success) {
            $error_mess = form_error('email_address');
            if ($error_mess != '') {
                $ar['email_address'] = $error_mess;
            }
            $error_mess = form_error('oldpassword');
            if ($error_mess != '') {
                $ar['oldpassword'] = $error_mess;
            }
            $error_mess = form_error('newpassword');
            if ($error_mess != '') {
                $ar['newpassword'] = $error_mess;
            }
            $error_mess = form_error('confirmpassword');
            if ($error_mess != '') {
                $ar['confirmpassword'] = $error_mess;
            }
            $array['error_ar'] = $ar;
        }
        echo json_encode($array);
    }

    public function do_user_change_pc() {
        $id = UserControl::getId();
        $name = $this->input->post('name');
        $email_address = $this->input->post('email_address');
        $oldpassword = base64_encode($this->input->post('oldpassword'));
        $password = base64_encode($this->input->post('newpassword'));
        $set_send_mail = $this->input->post('set_send_mail');
        // set values
        $this->form_validation->set_rules('email_address', 'メールアドレス', 'required|max_length[200]|valid_email|checkStringByte|callback_checkEmailExits');
        $this->form_validation->set_rules('oldpassword', '現在のパスワード', 'required|min_length[4]|max_length[20]|checkStringByte|callback__check_password');
        $this->form_validation->set_rules('newpassword', '新パスワード', 'required|min_length[4]|max_length[20]|checkStringByte|matches[confirmpassword]');
        $this->form_validation->set_rules('confirmpassword', '新パスワードを確認', 'trim');
        // set values not ok
        $form_validation = $this->form_validation->run();
        $this->message['success'] = !$form_validation && count($_POST) > 0 ? FALSE : TRUE;

        $error_message = $this->form_validation->error_string();

        if (!$form_validation) {
            $array = array('success' => true,'validation' => $error_message);
        } else {
            $data = array(
            'email_address' => $email_address,
            'password' => $password
            );
            $this->Musers->update_User($data, $id);
            $array = array('success' => true);
        }
        echo json_encode($array);
    }

    public function do_transfer_change() {
        // get values
        $this->viewData['divsuccessc'] = '';
        $this->viewData['divsuccessb'] = '';
        $this->viewData['divsuccessa'] = '';
        $this->viewData['divsuccessd'] = '';
        $this->viewData['divsuccesse'] = '';
        $id = UserControl::getId();
        $set_send_mail = $this->input->post('set_send_mail');
        // set values
        $this->form_validation->set_rules('set_send_mail', '転送設定', 'required');
        // set values not ok
        $form_validation = $this->form_validation->run();
        $this->message['success'] = !$form_validation && count($_POST) > 0 ? FALSE : TRUE;
        if (!$form_validation) {
            return false;
        } else {
            $data = array('set_send_mail' => $set_send_mail);
            $this->Musers->update_User($data, $id);
            return true;
        }
    }
    public function do_transfer_change_pc() {
        $res = $this->do_transfer_change();
        if ($res) {
            $array = array('success' => true);
        } else {
            $error_message = $this->form_validation->error_string();
            $array = array('success' => false,'error_message' => $error_message);
        }
        echo json_encode($array);
    }
    /**
    * @author [IVS] My Phuong Thi Le
    * @name   do_user_recruits_change
    * @todo   update user_recruits
    * @param
    * @return void
    */
    public function do_user_recruits_change() {
        // get values
        $this->viewData['divsuccessc'] = '';
        $this->viewData['divsuccessb'] = '';
        $this->viewData['divsuccessa'] = '';
        $this->viewData['divsuccessd'] = '';
        $this->viewData['divsuccesse'] = '';
        $bank_name = $this->input->post('bank_name');
        $bank_agency_name = $this->input->post('bank_agency_name');
        $bank_agency_kana_name = $this->input->post('bank_agency_kara_name');
        $account_type = $this->input->post('account_type');
        $account_no = $this->input->post('account_no');
        $account_name = $this->input->post('account_name');
        // set values
        $this->form_validation->set_rules('bank_name', '金融機関名', 'required|max_length[15]|double');
        $this->form_validation->set_rules('bank_agency_name', '支店名', 'required|max_length[15]|double');
        $this->form_validation->set_rules('bank_agency_kara_name', '支店名カナ', 'required|max_length[30]|katakana|double');
        $this->form_validation->set_rules('account_type', '口座種別', 'required');
        $this->form_validation->set_rules('account_no', '口座番号', 'required|max_length[10]|checkStringByte|is_numeric');
        $this->form_validation->set_rules('account_name', '口座名義', 'required|max_length[15]|double');
        // set values not ok
        $form_validation = $this->form_validation->run();
        $this->message['success'] = !$form_validation ? FALSE : TRUE;
        if (!$form_validation){
            return false;
        }
        else{
            $userid = UserControl::getId();
            $data = array(
            'bank_name' => $bank_name,
            'bank_agency_name' => $bank_agency_name,
            'bank_agency_kara_name' => $bank_agency_kana_name,
            'account_type' => $account_type,
            'account_no' => $account_no,
            'account_name' => $account_name,
            'updated_date'=> date("y-m-d H:i:s"),
            );
            $this->Musers->update_User($data, $userid);
            return true;
        }
    }

    public function do_user_recruits_validation_pc()
    {

        $bank_name = $this->input->post('bank_name');
        $bank_agency_name = $this->input->post('bank_agency_name');
        $bank_agency_kana_name = $this->input->post('bank_agency_kara_name');
        $account_type = $this->input->post('account_type');
        $account_no = $this->input->post('account_no');
        $account_name = $this->input->post('account_name');
        // set values
        $this->form_validation->set_rules('bank_name', '金融機関名', 'required|max_length[15]|double');
        $this->form_validation->set_rules('bank_agency_name', '支店名', 'required|max_length[15]|double');
        $this->form_validation->set_rules('bank_agency_kara_name', '支店名カナ', 'required|max_length[30]|katakana|double');
        $this->form_validation->set_rules('account_type', '口座種別', 'required');
        $this->form_validation->set_rules('account_no', '口座番号', 'required|max_length[10]|checkStringByte|is_numeric');
        $this->form_validation->set_rules('account_name', '口座名義', 'required|max_length[15]|double');
        // set values not ok
        $form_validation = $this->form_validation->run();
        $success = !$form_validation ? FALSE : TRUE;
        $ar = array();
        $array['error'] = $success;
        if (!$success) {
            $error_mess = form_error('bank_name');
            if ($error_mess != '') {
                $ar['bank_name'] = $error_mess;
            }
            $error_mess = form_error('bank_agency_name');
            if ($error_mess != '') {
                $ar['bank_agency_name'] = $error_mess;
            }
            $error_mess = form_error('bank_agency_kara_name');
            if ($error_mess != '') {
                $ar['bank_agency_kara_name'] = $error_mess;
            }
            $error_mess = form_error('account_type');
            if ($error_mess != '') {
                $ar['account_type'] = $error_mess;
            }
            $error_mess = form_error('account_no');
            if ($error_mess != '') {
                $ar['account_no'] = $error_mess;
            }
            $error_mess = form_error('account_name');
            if ($error_mess != '') {
                $ar['account_name'] = $error_mess;
            }
            $array['error_ar'] = $ar;
        }
        echo json_encode($array);
    }

    public function do_user_recruits_change_pc()
    {
        $res = $this->do_user_recruits_change();
        if ($res) {
            $array = array('success' => true);
        } else {
            $error_message = $this->form_validation->error_string();
            $array = array('success' => false,'error_message' => $error_message);
        }
        echo json_encode($array);
    }

    /**
    * @author [IVS] My Phuong Thi Le
    * @name   do_user_recruits_change
    * @todo   update user_recruits
    * @param
    * @return void
    */
    public function do_user_recruitslist_change() {
        // get values
        $this->viewData['divsuccessc'] = '';
        $this->viewData['divsuccessb'] = '';
        $this->viewData['divsuccessa'] = '';
        $this->viewData['divsuccessd'] = '';
        $this->viewData['divsuccesse'] = '';
        $nick_name = $this->input->post('nickName');
        $scout_target_flag = $this->input->post('bbsAcceptScoutMail');
        $age_id = $this->input->post('age_id');
        $height_id = $this->input->post('height_id');
        $city_id = $this->input->post('city_id');
        $bust_size = $this->input->post('bust_size');
        $waist_size = $this->input->post('waist_size');
        $hip_size = $this->input->post('hip_size');

        $working_exp = $this->input->post('working_exp');
        $hope_salary = $this->input->post('hope_salary_id');
        $pr_message = $this->input->post('pr_message');
        
        $this->load->library('user_agent');
        $device = $this->input->get('device');
        
        if ($this->agent->is_mobile()) {
            $this->form_validation->set_rules('bbsAcceptScoutMail', '求人サービスをご利用になる場合はチェックしてください。', 'numeric | xss_clean');
        } else {
            // set values
            $this->form_validation->set_rules('age_id', '年齢', 'required');
            $this->form_validation->set_rules('height_id', '身長', 'required');
            $this->form_validation->set_rules('city_id', '地域', 'required');  
        }
        // set values not ok
        $form_validation = $this->form_validation->run();
        $this->message['success'] = !$form_validation ? FALSE : TRUE;
        if (!$form_validation){
            return false;
        }
        else
        {
            // update users
            $user = UserControl::getuser();
            $userid = $user['id'];
            $user_from_site = $user['user_from_site'];
            $udata = array(
                'nick_name' => $nick_name,
                'bust' => $bust_size,
                'waist' => $waist_size,
                'hip' => $hip_size,
                'updated_date' => date("y-m-d H:i:s"),
            );

            if (($user_from_site == 3 || $user_from_site == 4) && $scout_target_flag != '') {
                $udata['scout_target_flag'] = $scout_target_flag;
            }
            $ret = $this->Musers->update_User($udata, $userid);
            if ($ret){
                // update user_recruits
                $data = array(
                    'age_id' => $age_id,
                    'height_id' => $height_id,
                     'working_exp' => $working_exp,
                    'hope_salary_id' => $hope_salary,
                    'pr_message' => $pr_message,
                    'city_id' => $city_id,
                    'updated_date' => date("y-m-d H:i:s")
                );
                $this->Musers->update_User_recruits($data, $userid);
            }
            return true;
        }
    }

    public function do_user_recruitslist_change_pc() {
        $res = $this->do_user_recruitslist_change();
        if ($res) {
            $array = array('success' => true);
        } else {
            $array = array('success' => false);
        }
        echo json_encode($array);
    }

    /**
    * author: [IVS] My Phuong Thi Le
    * name : required
    * todo : check checkbox
    * @return boolean
    */
    public function required() {
        if (!isset($_POST['job_type_id'])&&!isset($_POST['job_type_id1'])){
            return false;
        }else {
            return true;
        }
    }

    /**
    * author: VJS
    * name : fileUploadAjx
    * todo : upload profile pic to tmp
    * @return boolean
    */
    public function fileUploadAjx($user_id=null) {
        $path = $this->config->item('upload_userdir') . 'tmp/';
        if (!is_dir($path)) {
          mkdir($path, 0777, true);
        }
        if( $user_id ){
            $this->folderName = $user_id;
        }else{
            $this->folderName = UserControl::getId();
        }
        if (!is_dir($path . $this->folderName)) {
            mkdir($path . $this->folderName);
        }

        $config['upload_path'] = $path . $this->folderName;
        $config['allowed_types'] = 'jpeg|jpg|png';
        $config['max_size'] = 4096;
        $config['overwrite'] = true;
        $this->load->library('upload', $config);

        $num = $this->input->post('profile_pic_num');
        switch ($num) {
        case 1:
            if (!$this->upload->do_upload_user("profile_pic_file")) {
                $array = array('error' => substr($this->upload->display_errors(), 3,  strlen($this->upload->display_errors() ) - 7)) ;
                echo json_encode($array);
                die;
            } else {
                $source_image = $path.$this->folderName.'/'.$_FILES['profile_pic_file']['name'] ;
                $fn = $path.$this->folderName.'/'.$_FILES['profile_pic_file']['name'] ;
                $url = base_url() . $this->config->item('upload_userdir') . 'tmp/' . $this->folderName . '/' . $_FILES['profile_pic_file']["name"];
                $fileName = $this->folderName . '/' . $_FILES['profile_pic_file']["name"];
            }
            break;
        case 2:
            if (!$this->upload->do_upload_user("profile_pic_file2")) {
                $array = array('error' => substr($this->upload->display_errors(), 3,  strlen($this->upload->display_errors() ) - 7)) ;
                echo json_encode($array);
                die;
            } else {
                $source_image = $path.$this->folderName.'/'.$_FILES['profile_pic_file2']['name'] ;
                $fn = $path.$this->folderName.'/'.$_FILES['profile_pic_file2']['name'] ;
                $url = base_url() . $this->config->item('upload_userdir') . 'tmp/' . $this->folderName . '/' . $_FILES['profile_pic_file2']["name"];
                $fileName = $this->folderName . '/' . $_FILES['profile_pic_file2']["name"];
            }
            break;
        case 3:
            if (!$this->upload->do_upload_user("profile_pic_file3")) {
                $array = array('error' => substr($this->upload->display_errors(), 3,  strlen($this->upload->display_errors() ) - 7)) ;
                echo json_encode($array);
                die;
            } else {
                $source_image = $path.$this->folderName.'/'.$_FILES['profile_pic_file3']['name'] ;
                $fn = $path.$this->folderName.'/'.$_FILES['profile_pic_file3']['name'] ;
                $url = base_url() . $this->config->item('upload_userdir') . 'tmp/' . $this->folderName . '/' . $_FILES['profile_pic_file3']["name"];
                $fileName = $this->folderName . '/' . $_FILES['profile_pic_file3']["name"];
            }
            break;
        }

        $config['image_library'] = 'gd2';
        $config['source_image'] = $source_image;
        $config['maintain_ratio'] = FALSE;
        $size = getimagesize($fn);
        $ratio = $size[0]/$size[1];// width/height
//        $config['height'] = 90;
//        $config['width'] = 90*$ratio;
        $config['height'] = 270;
        $config['width'] = 270*$ratio;
        $this->load->library('image_lib', $config);
        $this->image_lib->resize();

        $array = array('url' => $url, 'fileName' => $fileName);
        echo json_encode($array);
    }

    /**
    * author: VJS
    * name : updateProfilePic
    * todo : upload profile pic
    * @return null
    */
    public function updateProfilePic($userid=null){
        $ret = false;
        $udata = array();
        $array = array();
        $json = array();
//        $update_photo_flag = true;
        $update_photo_flag = false;

            $num = $this->input->post('profile_pic_num');
            switch($num){
                case 1:
                $profile_path = $this->input->post('profile_pic_file_path');
                    $dataname = 'profile_pic';
                    $name = 'profile_pic_file';
                    $profile_pic_file_path = 'profile_pic_file_path';
                    break;
                case 2:
                $profile_path = $this->input->post('profile_pic_file_path2');
                    $dataname = 'profile_pic2';
                    $name = 'profile_pic_file2';
                    $profile_pic_file_path = 'profile_pic_file_path2';
                    break;
                case 3:
                $profile_path = $this->input->post('profile_pic_file_path3');
                    $dataname = 'profile_pic3';
                    $name = 'profile_pic_file3';
                    $profile_pic_file_path = 'profile_pic_file_path3';
                    break;
            }

            $file_name = "";
            if($profile_path){
                $file_name = substr(strstr($profile_path, 'tmp/'), 4);
                $this->common->fileUpload($file_name,false,$userid); //copy file from /tmp to /images
                // delete files from /tmp folder
                $this->common->deleteFolder(false,$userid);

                // update profile path in DB
                if($file_name){
                    if ( !$userid ){
                        $userid = UserControl::getId();
                    }

                    $ar = array();
                    $ar = $this->Musers->get_users_by_id($userid);
                    if(($ar["profile_pic2"] == null) && ($ar["profile_pic3"] == null)){
                        $update_photo_flag = true;
                    }

                    $udata[$dataname] = $file_name;
                    $ret = $this->Musers->update_User($udata, $userid);
                }

                if ( $ret == false ){
                    break;
                }elseif($profile_path != ""){
                    $array[$dataname] = base_url() . $this->config->item('upload_userdir').'images/'.$file_name;
                }
            }

        if($ret == false){
            $json = array('error'=>"プロフィル写真の更新が失敗しました。");
        }else{
            if($update_photo_flag){
                $this->send_mail_photo_update($ar);
            }
            $json["url"] = $array;
            $json["name"] = $name;
            $json["path"] = $profile_pic_file_path;
        }
        $email = UserControl::getEmail();
        $users = $this->Musers->get_users_by_email($email);print_r($users );
        HelperApp::add_session('user_info',array('unique_id' => $users['unique_id'],'user_from_site' => $users['user_from_site'], 'profile_pic' => $users['profile_pic'], 'profile_pic2' => $users['profile_pic2'], 'profile_pic3' => $users['profile_pic3']));
        echo json_encode($json);
    }

    //写真更新報告メール
    public function send_mail_photo_update($ar){
        $message = <<< EOT
{$ar['name']}様({$ar['unique_id']})のプロフィール写真が更新されました。
EOT;
        mb_language("ja");
        mb_internal_encoding("UTF-8");
        $subject = '【ジョイスペ】'.$ar['name'].'様('.$ar['unique_id'].')プロフィール写真更新';
        $from = "ジョイスペ写真更新";
        mb_send_mail("info@joyspe.com",$subject,$message,'From:'.$from,'-f info@joyspe.com');
//        mb_send_mail("suzuki_kiyo@innetwork.jp",$subject,$message,'From:'.$from,'-f info@joyspe.com');
        return;
    }

    /**
    * author: VJS
    * name : deleteProfilePic
    * todo : delete profile pic
    * @return null
    */
    public function deleteProfilePic($userid=null){
        $ret = false;
        if ( !$userid ){
           $userid = UserControl::getId();
        }
        if ( $userid ){
            //　Get the current profile file path
            $user_data = $this->Musers->get_users($userid);
            $old_profile_path = "";
            if ( $user_data ){

                $num = $this->input->post('profile_pic_num');
                switch($num){
                case 1:
                    $dataname = 'profile_pic';
                    $profile_pic_file_path = 'profile_pic_file_path';
                    $old_profile_path = $user_data['profile_pic'];
                    $old_profile_path = FCPATH . $this->config->item('upload_userdir').'images/'. $old_profile_path;
                    break;
                case 2:
                    $dataname = 'profile_pic2';
                    $profile_pic_file_path = 'profile_pic_file_path2';
                    $old_profile_path = $user_data['profile_pic2'];
                    $old_profile_path = FCPATH . $this->config->item('upload_userdir').'images/'. $old_profile_path;
                    break;
                case 3:
                    $dataname = 'profile_pic3';
                    $profile_pic_file_path = 'profile_pic_file_path3';
                    $old_profile_path = $user_data['profile_pic3'];
                    $old_profile_path = FCPATH . $this->config->item('upload_userdir').'images/'. $old_profile_path;
                    break;
                }
            }
            // Update DB
            $udata = array(
                $dataname => "",
            );
            $ret = $this->Musers->update_User($udata, $userid);

            if ( $ret ){
                // Delete file from disk
                if ( $old_profile_path ){
                    if ( file_exists($old_profile_path) ){
                        unlink($old_profile_path);
                    }
                }
            }
        }
        if ( $ret == false ){
            $array = array('error'=>"プロフィル写真の削除が失敗しました。");
        }else{
            $array = array('url'=> base_url() . "public/user/image/no_image.jpg");
        }
        $email = UserControl::getEmail();
        $users = $this->Musers->get_users_by_email($email);print_r($users );
        HelperApp::add_session('user_info',array('unique_id' => $users['unique_id'],'user_from_site' => $users['user_from_site'], 'profile_pic' => $users['profile_pic'], 'profile_pic2' => $users['profile_pic2'], 'profile_pic3' => $users['profile_pic3']));
        echo json_encode($array);
    }

    /**
     * @author [IVS] My Phuong Thi Le
     * @name   do_certificate
     * @todo   update image for user
     * @param
     * @return void
     */
    public function do_certificate() {
        $this->viewData['divsuccessc'] = '';
        $this->viewData['divsuccessb'] = '';
        $this->viewData['divsuccessa'] = '';
        $this->viewData['divsuccessd'] = '';
        $this->viewData['divsuccesse'] = '';
        // get id of user
        $id = UserControl::getId();
        $this->file__name= $_FILES['img']['name'];
        $this->file__temp_name= $_FILES['img']['tmp_name'];
        $this->file__type= $_FILES['img']['type'];
        // set values
        $this->form_validation->set_rules('img', 'image', 'callback_checking_if_null');
        $form_validation = $this->form_validation->run();
        $this->message['success'] = !$form_validation ? FALSE : TRUE;
        if (!$form_validation){
            return false;
        }
        else {
            $path = $this->config->item('upload_userdir') . '/images/';
            $this->folderName = $id;
            if (!is_dir($path.$this->folderName )) {
                mkdir($path.$this->folderName, 0777, true);
            }
            $config['upload_path'] = $path . $this->folderName;
            $config['allowed_types'] = 'jpeg|jpg|png';
            $config['max_size'] = 4096;
            $config['overwrite'] = true;
            // echo filesize($_FILES['img']['tmp_name']);die;
            $this->load->library('upload', $config);
            if (!$this->upload->do_upload("img")) {
                $this->form_validation->set_rules('img', 'image', 'callback_check_jpg_jpeg_png');
                $this->form_validation->set_rules('img', 'image', 'callback_checkimg2MB');
                $form_validation = $this->form_validation->run();
                $this->message['success'] = !$form_validation ? FALSE : TRUE;
                if (!$form_validation){
                    return false;
                }
            } else {
                $config['image_library'] = 'gd2';
                $config['source_image'] = $path . $this->folderName . '/' . $_FILES['img']['name'];
                $config['maintain_ratio'] = FALSE;
                $config['width'] = 400;
                $config['height'] = 300;
                $this->load->library('image_lib', $config);
                $this->image_lib->resize();
                $data = array(
                    'image1' => $this->folderName . '/' .$_FILES['img']["name"],
                );
                $this->Musers->update_User($data, $id);
                $this->common->sendMail( '', '', '', array('ss02'), '', 'joyspe', $id);
                return true;
            }
        }
    }

    public function do_certificate_pc()
    {
        $res = $this->do_certificate();
        if ($res) {
            $array = array('success' => true);
        } else {
            $array = array('success' => false);
        }
        echo json_encode($array);
    }

    public function checking_if_null() {
       if($this->file__name == null || $this->file__name == '') {
           $this->form_validation->set_message('checking_if_null', '写真を選択してください。');
           return false;
       }
       return true;
    }

    public function checkimg2MB() {
        $size = filesize($this->file__temp_name);
        if ($size > 2097152)
           return false;
        return true;
    }
     /**
     * author: [IVS] My Phuong Thi Le
     * name : check_jpg_jpeg_png
     * todo : check image jpg_jpeg_png
     * @return boolean
     */
    public function check_jpg_jpeg_png() {
       if($this->file__type != "image/jpeg" && $this->file__type != "image/jpg" && $this->file__type != "image/png" )
           return false;
        return true;
    }
}
?>

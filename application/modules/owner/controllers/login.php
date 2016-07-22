<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Login extends MX_Controller {

    private $data;
    private $common;
    private $message = array('success' => true, 'error' => array());
    private $folderName;

    public function __construct() {

        parent::__construct();
        $this->load->Model(array('owner/mowner','owner/mtemplate','owner/mcommon', 'user/Mcaptcha'));
        $this->common = new Common();
        $this->data['module'] = $this->router->fetch_module();
        $this->form_validation->CI = & $this;
    }

    /**
     * author: [IVS] Nguyen Bao Trieu
     * name : index
     * todo : show login
     * @param null
     * @return null
     */
    function index() {
        if ($_POST) {
            if($this->doLogin())
            {
                $this->mowner->updateLavisitDate(HelperApp::get_session('ownerId'));
            }
        }
        HelperGlobal::checkScreen('');
        $this->data['loadPage'] = 'login/login';
        $this->data['title'] = 'joyspe｜ログイン - 求人情報登録';
        $this->data['message'] = $this->message;
        $this->data['frame'] = base_url() . "/public/owner/html/terms.php";
        $this->load->view($this->data['module'] . '/layout/layout_C', $this->data);

    }

    /**
     * author: [IVS] Nguyen Bao Trieu
     * name : doLogin
     * todo : do check login
     * @param null
     * @return null
     */
    private function doLogin() {
        $email = trim($this->input->post('txtEmail'));
        $pass = trim($this->input->post('txtPassword'));
        $owner = $this->mowner->getByEmail($email);
        $has_captcha = $this->input->post('has_captcha');
        $this->form_validation->set_rules('txtEmail', 'メールアドレス', 'trim|required|valid_email|max_length[200]|callback__checkLogin');
        $this->form_validation->set_rules('txtPassword', 'パスワード', 'trim|required|min_length[4]|max_length[20]|checkStringByte');
        //check if captcha exist.
        if ($has_captcha) {
            $this->form_validation->set_rules('captcha', 'キャップトチャ', 'callback_check_captcha');
        }
        $form_validation = $this->form_validation->run();
        $this->message['success'] = !$form_validation && count($_POST) > 0 ? FALSE : TRUE;
        $module = $this->router->fetch_module();
        $unique_id = isset($owner['unique_id'])?$owner['unique_id']:null;
        if (!$form_validation) {
            //display captcha if fail login times >= LOGIN_FAILS_LIMIT
            $img = $this->common->display_captcha($module, $unique_id, $email);
            if ($img) {
                $this->data['captcha_img'] = $img['image'];
            }
            return false;
        }
        //Reset fail login times if success login.
        $is_reset = $this->Mcaptcha->reset_fail_login_times($module, $unique_id, $_SERVER["REMOTE_ADDR"], false, $email);
        $where = 'AND scout_auto_send_flag = 1';
        $sNav = $this->mowner->getAutoSend($owner['id'], $where);
        $urgentRecruitment = $this->mowner->getUrgentRecruitmentStatus($owner['id']);
        HelperApp::add_session('urgentRecruitment', $urgentRecruitment);
        HelperApp::add_session('free_owner', $owner['free_owner_flag']);
        HelperApp::add_session('snav', count($sNav));
        HelperApp::add_session('ownerId', $owner['id']);
        OwnerControl::LoggedIn();
        return true;
    }

    /**
     * author: [IVS] Nguyen Bao Trieu
     * name : checkLogin
     * todo : check password
     * @param null
     * @return null
     */
    function _checkLogin() {
        $ret = false;
        $email = trim($this->input->post('txtEmail'));
        if ($email) {
            $owner = $this->mowner->getByEmail($email);
            $password = trim($this->input->post('txtPassword'));
            if ($password && $owner && is_array($owner)) {
                if ($owner['owner_status'] != 4 && $owner['password'] === base64_encode($password)) {
                    $ret = true;
                }
            }
        }

        return $ret;
    }

    /**
     * author: [IVS] Nguyen Bao Trieu
     * name : login_company
     * todo : show regist login company
     * @param null
     * @return null
     */
    function login_company() {
      $this->city_groups = $this->mowner->getGroups();
      $this->jobTypes = $this->mowner->getJobType();
      $this->treatments = $this->mowner->getOwnerTreatment();
      $this->happyMoneys = $this->mowner->getHappyMoney();
      $this->defaultMoney = $this->mowner->getDefaultMoney();
      if ( $this->defaultMoney ){
        $this->data['defaultMoney'] = $this->defaltMoney['id'];
      }else{
        $this->data['defaultMoney'] = 0;
      }
      $this->data['hdError'] = 0;
      $this->data['image1'] = '';
      $this->data['image2'] = '';
      $this->data['image3'] = '';
      $this->data['image4'] = '';
      $this->data['image5'] = '';
      $this->data['image6'] = '';

      //------ check owner went from where---------
      $get = $this->uri->segment(4);
      $websiteId = '';
      if(!empty($get))
      {
          $websiteId = $this->mowner->getIdWebSite($get);
      }
      //-------------------------------------------

      if ($_POST) {
        $this->data['area'] = $_POST['city_group_id'];
        $this->data['city'] = $_POST['city_id'];
        $this->data['town'] = $_POST['town_id'];
        $this->data['image1'] = $_POST['hdImage1'];
        $this->data['image2'] = $_POST['hdImage2'];
        $this->data['image3'] = $_POST['hdImage3'];
        $this->data['image4'] = $_POST['hdImage4'];
        $this->data['image5'] = $_POST['hdImage5'];
        $this->data['image6'] = $_POST['hdImage6'];
        if ($this->checkLoginCompny()) {
          if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
          } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
          } else {
            $ip = $_SERVER['REMOTE_ADDR'];
          }

          $data['unique_id'] = $this->createUniqueId();
          $data['email_address'] = $_POST['txtEmailAddress'];
          $data['password'] = base64_encode($_POST['txtPassword']);
          $data['storename'] = $_POST['txtStoreName'];
          $data['address'] = $_POST['txtAddress'];
          $data['ip_address'] = $ip;
          $data['website_id'] = $websiteId;
          $data['created_date'] = date('Y-m-d H:i:s');
          $data['temp_reg_date'] = date('Y-m-d H:i:s');
          $default_scout_mail_num = $this->mowner->getCommonEmailNoPerDay();
          $data['default_scout_mails_per_day'] = $default_scout_mail_num;
          $data['remaining_scout_mail'] = $default_scout_mail_num;

          //insert new data to owners table
          $ownerId = $this->mowner->insertOwner($data);

          $dataRecruits['owner_id'] = $ownerId;
          $dataRecruits['image1'] = (substr(strstr($_POST['hdImage1'], 'tmp/'), 4)!=""?substr(strstr($_POST['hdImage1'], 'tmp/'), 4):"");
          $dataRecruits['image2'] = (substr(strstr($_POST['hdImage2'], 'tmp/'), 4)!=""?substr(strstr($_POST['hdImage2'], 'tmp/'), 4):"");
          $dataRecruits['image3'] = (substr(strstr($_POST['hdImage3'], 'tmp/'), 4)!=""?substr(strstr($_POST['hdImage3'], 'tmp/'), 4):"");
          $dataRecruits['image4'] = (substr(strstr($_POST['hdImage4'], 'tmp/'), 4)!=""?substr(strstr($_POST['hdImage4'], 'tmp/'), 4):"");
          $dataRecruits['image5'] = (substr(strstr($_POST['hdImage5'], 'tmp/'), 4)!=""?substr(strstr($_POST['hdImage5'], 'tmp/'), 4):"");
          $dataRecruits['image6'] = (substr(strstr($_POST['hdImage6'], 'tmp/'), 4)!=""?substr(strstr($_POST['hdImage6'], 'tmp/'), 4):"");
          $dataRecruits['main_image'] = $_POST['sltImageDefault'];
          $dataRecruits['company_info'] = $_POST['txtShopInfo'];
          $dataRecruits['city_group_id'] = $_POST['city_group_id'];
          $dataRecruits['city_id'] = $_POST['city_id'];
          $dataRecruits['town_id'] = $_POST['town_id'];
          $dataRecruits['title'] = $_POST['txtTitle'];
          $dataRecruits['work_place'] = $_POST['txtWorkPlace'];
          $dataRecruits['working_day'] = $_POST['txtWorkingDay'];
          $dataRecruits['working_time'] = $_POST['txtWorkingTime'];
          $dataRecruits['how_to_access'] = $_POST['txtHowToAccess'];
          $dataRecruits['salary'] = $_POST['txtSalary'];
          $dataRecruits['con_to_apply'] = $_POST['txtConToApply'];
          $dataRecruits['visiting_benefits_title_1'] = $_POST['visiting_benefits_title_1'];
          $dataRecruits['visiting_benefits_title_2'] = $_POST['visiting_benefits_title_2'];
          $dataRecruits['visiting_benefits_title_3'] = $_POST['visiting_benefits_title_3'];
          $dataRecruits['visiting_benefits_content_1'] = $_POST['visiting_benefits_content_1'];
          $dataRecruits['visiting_benefits_content_2'] = $_POST['visiting_benefits_content_2'];
          $dataRecruits['visiting_benefits_content_3'] = $_POST['visiting_benefits_content_3'];
          $dataRecruits['apply_time'] = $_POST['txtTimeOfApply'];
          $dataRecruits['apply_tel'] = $_POST['txtTelForApp'];
          $dataRecruits['apply_emailaddress'] = $_POST['txtMailForApp'];
          $dataRecruits['new_msg_notify_email'] = $_POST['txtMailForReply'];
          $dataRecruits['home_page_url'] = $_POST['txtHomePageUrl'];
          $dataRecruits['line_id'] = $_POST['txtLineId'];
          $dataRecruits['line_url'] = $_POST['txt_line_url'];
          $dataRecruits['recruit_status'] = 2;
          $dataRecruits['happy_money_id']   = $this->mowner->getZeroHappyMoneyID(); // default set to no happy money
          $dataRecruits['cond_happy_money'] = 1; // default set to none
          $dataRecruits['created_date'] = date('Y-m-d H:i:s');

          //------- campaign(limited time only) text 
          $dataRecruits['campaign_note'] = isset($_POST['campaign_note']) ? $_POST['campaign_note'] : '';

          //Insert data to owner_recruits
          $idOwnerRecruit = $this->mowner->insertOwnerRecruit($dataRecruits);

          //Insert jobtype owner
          if (isset($_POST['ckJobType'])) {
            $jobtype = $_POST['ckJobType'];
            if ( $jobtype ){
              $jobTypeData['owner_recruit_id'] = $idOwnerRecruit;
              $jobTypeData['job_type_id'] = $jobtype;
              $this->mowner->insertJopTypeOwner($jobTypeData);
            }
          }

          //Insert treatment owner
          if (isset($_POST['ckTreatMents'])) {
            $treatments = $_POST['ckTreatMents'];
            foreach ($treatments as $key => $value) {
              $treatmentData['owner_recruit_id'] = $idOwnerRecruit;
              $treatmentData['treatment_id'] = $value;
              $this->mowner->insertTreatmentOwner($treatmentData);
            }
          }

          //Upload file
          for ($i = 1; $i <= 6; $i++) {
            if (!empty($_POST['hdImage' . $i])) {
              $this->common->fileUpload(substr(strstr($_POST['hdImage' . $i], 'tmp/'), 4));
            }
          }
          $this->common->deleteFolder();

          $template = $this->mcommon->getTemplate('ow01');
          $templData ['template_id'] = $template['id'];
          $templData['owner_id'] = $ownerId;
          $templData['created_date'] = date('Y-m-d H:i:s');
          $this->common->sendMail('', '', '', array('ow01'), $ownerId , '','','','','','','','');
          $this->common->sendMail('', '', '', array('ss01'),  $ownerId , '','','','','','','','');

          $this->mtemplate->insertOwnerTemplate($templData);

          redirect(base_url() . "owner/login/login_guide");
        }
      }

      $this->data['frame'] = base_url() . "/public/owner/html/terms.php";
      $this->data['loadPage'] = 'login/login_company';
      $this->data['title_Page'] = '';
      $this->data['imagePath'] = base_url() . "/public/owner/images/";
      $this->data['city_groups'] = $this->city_groups;
      $this->data['wesiteId'] = $websiteId;
      $this->data['treatments'] = $this->treatments;
      $this->data['happyMoneys'] = $this->happyMoneys;
      $this->data['jobTypes'] = $this->jobTypes;
      $this->data['message'] = $this->message;
      $this->data['title'] = 'joyspe｜ログイン - 新規会員登録フォーム';
      $this->load->view($this->data['module'] . '/layout/layout_C', $this->data);
    }

    /**
     * author: [IVS] Nguyen Bao Trieu
     * name : checkLoginCompny
     * todo : check validation
     * @param null
     * @return boolean
     */
    function checkLoginCompny() {
      $this->form_validation->set_rules('txtEmailAddress', 'メールアドレス', 'trim|required|max_length[200]|checkStringByte|valid_email|callback_checkEmailExits');
      $this->form_validation->set_rules('txtPassword', 'パスワード', 'trim|required|min_length[4]|max_length[20]|checkStringByte');
      $this->form_validation->set_rules('city_group_id', 'エリア地域', 'required');
      $this->form_validation->set_rules('city_id', 'エリア都道府県', 'required');
      $this->form_validation->set_rules('town_id', 'エリア都市', 'required');
      $this->form_validation->set_rules('txtTitle', 'タイトル', 'trim|required|min_length[4]|max_length[100]');
      $this->form_validation->set_rules('txtStoreName', '店舗名', 'trim|required|max_length[100]');
      $this->form_validation->set_rules('txtAddress', '住所', 'trim|required|max_length[200]');
      $this->form_validation->set_rules('ckJobType', '業種', 'required');
      $this->form_validation->set_rules('txtWorkPlace', '勤務地', 'trim|required|max_length[200]');
      $this->form_validation->set_rules('txtWorkingDay', '勤務日', 'trim|required|max_length[200]');
      $this->form_validation->set_rules('txtWorkingTime', '勤務時間', 'trim|required|max_length[200]');
      $this->form_validation->set_rules('txtHowToAccess', '交通', 'trim|required|max_length[200]');
      $this->form_validation->set_rules('txtSalary', '給与', 'trim|required|max_length[200]');
      $this->form_validation->set_rules('txtConToApply', '応募資格', 'trim|required|max_length[200]');
      $this->form_validation->set_rules('ckTreatMents[]', '待遇');
      $this->form_validation->set_rules('txtShopInfo', 'お店からのメッセージ', 'trim|required');
      $this->form_validation->set_rules('txtTimeOfApply', '応募時間', 'trim|required|max_length[20]');
      $this->form_validation->set_rules('txtTelForApp', '応募用電話番号', 'trim|required|max_length[24]|checkStringByte|validNumber');
      $this->form_validation->set_rules('txtMailForApp', '応募用メールアドレス', 'trim|required|max_length[200]|checkStringByte|valid_email');
      $this->form_validation->set_rules('txtMailForReply', 'お問い合わせ通知用のメールアドレス', 'trim|max_length[200]|checkStringByte|valid_email');
      $this->form_validation->set_rules('txtHomePageUrl', 'オフィシャルHP', 'trim|required|max_length[100]');
      $this->form_validation->set_rules('txtLineId', 'LINEID');
      $this->form_validation->set_rules('hdImage1', 'hdImage1');
      $this->form_validation->set_rules('hdImage2', 'hdImage2');
      $this->form_validation->set_rules('hdImage3', 'hdImage3');
      $this->form_validation->set_rules('hdImage4', 'hdImage4');
      $this->form_validation->set_rules('hdImage5', 'hdImage5');
      $this->form_validation->set_rules('hdImage6', 'hdImage6');
      $this->form_validation->set_rules('ckImage[]', '写真');
      $this->form_validation->set_rules('sltImageDefault', 'メイン画像');
      $this->form_validation->set_rules('visiting_benefits_title_1', 'visiting_benefits_title_1');
      $this->form_validation->set_rules('visiting_benefits_title_2', 'visiting_benefits_title_2');
      $this->form_validation->set_rules('visiting_benefits_title_3', 'visiting_benefits_title_3');
      $this->form_validation->set_rules('visiting_benefits_content_1', 'visiting_benefits_content_1');
      $this->form_validation->set_rules('visiting_benefits_content_2', 'visiting_benefits_content_2');
      $this->form_validation->set_rules('visiting_benefits_content_3', 'visiting_benefits_content_3');
      $this->form_validation->set_rules('txt_line_url', 'txt_line_url');
      $this->form_validation->set_rules('fileAttachment', 'fileAttachment');
      $this->form_validation->set_rules('campaign_note', 'campaign_note');
      
      $form_validation = $this->form_validation->run();
      $this->message['success'] = !$form_validation && count($_POST) > 0 ? FALSE : TRUE;

      if (!$form_validation) {
          return false;
      }

      return true;
    }

    /**
     * @author	[IVS]Trieu Nguyen Bao
     * @name	checkEmailExits
     * @todo	check Email Exits
     * @return  boolen
     * @param	$str - string
     */
    function checkEmailExits($email) {

        $obj = $this->mowner->getByEmail($email);
        if (count($obj))
            return false;
        return true;
    }

    /**
     * author: [IVS] Nguyen Bao Trieu
     * name : login_guide
     * todo : show login guide page
     * @param null
     * @return null
     */
    function login_guide() {
      //  HelperGlobal::requireOwnerLogin();
        $this->data['loadPage'] = 'login/login_guide';
        $this->data['title'] = 'joyspe｜新規登録';
        $this->load->view($this->data['module'] . '/layout/layout_C', $this->data);
    }

    /**
     * author: [IVS] Nguyen Bao Trieu
     * name : logout
     * todo : clear sesion of owner
     * @param null
     * @return null
     */
    public function logout() {
        $this->common->deleteFolder();
        HelperApp::clear_session();
        redirect(base_url() . "owner/login");
    }

     /**
     * author: [IVS] Nguyen Bao Trieu
     * name : checkFromTo
     * todo : check From To
     * @param null
     * @return null
     */
    public function checkFromEqualTo()
    {
        $from = $this->input->post('sltWorkingHourFrom');
        $fromArr = mb_split(':', $from);
        $to = $this->input->post('sltWorkingHourTo');
        $toArr = mb_split(':', $to);

        if($fromArr[0] >= $toArr[0])
        {
            return false;
        }
        return true;

    }

    /**
     * author: [IVS] Nguyen Bao Trieu
     * name : fileUploadAjx
     * todo : upload file into folder temp
     * @param null
     * @return null
     */
    public function fileUploadAjx() {

        $path = $this->config->item('upload_owner_dir') . 'tmp/';
        if (!is_dir($path)) {
          mkdir($path, 0777, true);
        }
        $this->folderName = OwnerControl::getId();
        if (!is_dir($path . $this->folderName)) {
            mkdir($path . $this->folderName);
        }

        $config['upload_path'] = $path . $this->folderName;
        $config['allowed_types'] = 'jpeg|jpg|png';
        $config['max_size'] = 4096;
        $config['overwrite'] = true;
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload_owner("flUpload")) {
            $array = array('error' => substr($this->upload->display_errors(), 3,  strlen($this->upload->display_errors() ) - 7)) ;
            echo json_encode($array);
            die;
        } else {
            $fn = $_FILES['flUpload']['tmp_name'];
            $size = getimagesize($fn);
            $ratio = $size[0]/$size[1]; // width/height
            $config['image_library'] = 'gd2';
            $config['source_image'] = $path.$this->folderName.'/'.$_FILES['flUpload']['name'] ;
            $config['maintain_ratio'] = FALSE;
            $config['width'] = 350;
            $config['height'] = 350/$ratio;
            $this->load->library('image_lib', $config);
            $this->image_lib->resize();
            $array = array('url' => base_url() . $this->config->item('upload_owner_dir') . 'tmp/' . $this->folderName . '/' . $_FILES['flUpload']["name"], 'fileName' => $this->folderName . '/' . $_FILES['flUpload']["name"]);
            echo json_encode($array);
            die;
        }
    }


    /**
     * check document file
     * @param null
     * @return array confirmation
     */
    public function documentCheckAjx() {
        $err = '';
        $ext = preg_replace("/.*\.([^.]+)$/","\\1", $_FILES['file_attachment']['name']);
        $allowed_file = array('1' => 'pdf','2' => 'doc','3' => 'docx','4' => 'xlsx','5' => 'xls','6' => 'xlw','7' => 'jpg','8' => 'jpeg','9' => 'gif','10' => 'png');
        if ($_FILES['file_attachment']['size'] > 5000000) {
            $err = "ファイルサイズが5MBを超えています。5MBを超えないように調整をお願いします。";
        }

        if (!array_search(strtolower($ext), $allowed_file)) {
            $err = "ファイル形式が正しくありません。アップロードできません。";
        }

        $array = array('err' => $err, 'fileName' => $_FILES['file_attachment']['name']);
        echo json_encode($array);
    }

    /**
     * author: [IVS] Nguyen Bao Trieu
     * name : happyMoneyPayUser
     * todo : happy Money Pay User
     * @param null
     * @return null
     */
    public function happyMoneyPayUser() {

        $this->id = $_POST['id'];
        $this->data = $this->mowner->getHappyMoneyPayUser($this->id);
        echo json_encode(array('user_happy_money'=>number_format($this->data['user_happy_money'])));
        die;

    }


    /**
     * author: [IVS] Nguyen Bao Trieu
     * name : createUniqueId
     * todo : create UniqueId
     * @param null
     * @return null
     */
    public function createUniqueId()
    {
        $flag = true;
        $uniqueId = '';
        while($flag)
        {
            $uniqueId = Ultilities::random('alpha',8);
            $uniqueIdData = $this->mowner->checkUniqueId($uniqueId);

            if($uniqueIdData['countId'] == 0)
            {
                $flag = false;
            }
        }
        return $uniqueId;
    }

    public function getDataList() {
      $this->output->set_content_type('application/json');
      if($_POST['type'] == 'city_group')
        $data = $this->mowner->getGroupCities($_POST['id']);
      elseif($_POST['type'] == 'city')
        $data = $this->mowner->getCityTowns($_POST['id']);
      echo json_encode($data);
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

    /* -----------------------Login Store end------------------------------------- */
}

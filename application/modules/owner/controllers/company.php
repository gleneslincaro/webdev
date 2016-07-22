<?php

class Company extends MX_Controller {

    private $viewData;
    private $common;
    private $message = array('success' => true, 'error' => array());

    public function __construct() {
        parent::__construct();
        $this->load->model('owner/Mcompany');
        $this->load->model('owner/Mowner');
        $this->load->model('owner/Mmessage');
        $this->load->model('owner/Mcommon');
        $this->form_validation->CI = & $this;
        $this->common = new Common();
        $this->output->set_header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate");
        $this->output->set_header("Cache-Control: post-check=0, pre-check=0");
        $this->output->set_header("Pragma: no-cache");
        if (!OwnerControl::LoggedIn()) {
            redirect(base_url() . "owner/login/");
        }
    }

    /**
     * @author  [IVS] Nguyen Van Phong
     * @todo 	show owner and owner recruit information
     * @use in
     * @param
     * @return
     */
    public function index() {
        $owner_id = OwnerControl::getId();
        $owner_data = HelperGlobal::owner_info($owner_id);
        $owner_recruit_info1 = $this->Mcompany->getCompanyRecruitInfo1($owner_id);
        $owner_recruit_info1['password'] = base64_decode($owner_recruit_info1['password']);
        $owner_recruit_info2 = $this->Mcompany->getCompanyRecruitInfo2($owner_id);
        //var_dump($owner_recruit_info2); exit;

        $this->viewData['owner_recruit_info1'] = $owner_recruit_info1;
        $this->viewData['owner_recruit_info2'] = $owner_recruit_info2;
        // Treatments area:
        $this->treatmentProcessing($owner_id);
        // End treatments area
        // Job type area:
        $this->jobtypeProcessing($owner_id);
        // End job type area
        $this->viewData['imagePath'] = base_url() . "/public/owner/";
        $this->viewData['owner_data'] = $owner_data;
        $this->viewData['title'] = 'joyspe｜基本情報';
        $this->viewData['loadPage'] = 'owner/company/company';
        $this->load->view("owner/layout/layout_A", $this->viewData);
    }

    /**
     * @author  [IVS] Nguyen Van Phong
     * @todo 	Check email existed
     * @use in
     * @param
     * @return
     */
    public function checkEmailExits($newEmail = '') {
        $owner = OwnerControl::getOwner();
        if (strcmp($newEmail, $owner['email_address']) == 0)
            return true;
        $obj = $this->Mowner->getByEmail($newEmail);
        if (count($obj))
            return false;
        return true;
    }

    // ++++++++ company store edit area ++++++++
    /**
     * @author  [IVS] Nguyen Van Phong
     * @todo 	Insert new owner_recruit when old owner_recruit has recruit_status = 2 (approved)
     * @use in
     * @param
     * @return
     */
    public function company_store() {
        $this->city_groups = $this->Mowner->getGroups();
        $owner_id = OwnerControl::getId();
        $owner_data = HelperGlobal::owner_info($owner_id);
        $owner_recruit = $this->Mowner->getOwnerRecruit($owner_id);
        $status = $this->Mcompany->getLastOwnerRecruitStatus($owner_id);
        $owner_id = OwnerControl::getId();

        // Job type area:
        $this->jobtypeProcessing($owner_id);
        // End job type area
        //Treatment area:
        $this->treatmentProcessing($owner_id);
        // End treatment area

        $data = $this->Mcompany->companyStoreEdit($owner_id);
        $owner_info = $this->Mcompany->getCompanyInfo($owner_id);
        $this->viewData['set_send_mail'] = $owner_info['set_send_mail'];
        $this->viewData['public_info_flag'] = $owner_info['public_info_flag'];

        $this->viewData['hdmain_image'] = $owner_recruit['main_image'];
        $this->viewData['city_id'] = $owner_recruit['city_id'];
        $this->viewData['joyspe_happy_money'] = $data['happy_money_id'];
        $this->viewData['cond_happy_money'] = $data['cond_happy_money'];
        $this->viewData['scout_pr_text'] = $data['scout_pr_text'];
        $this->viewData['hdError'] = 0;
        $this->viewData['happyMoneyType'] = $data['happy_money_type'];
        $this->viewData['txthappyMoney'] = $data['happy_money'];
        $this->viewData['image1'] = empty($data['image1']) ? base_url() . 'public/owner/images/no_image.jpg' : base_url() . 'public/owner/uploads/images/' . $data['image1'];
        $this->viewData['image2'] = empty($data['image2']) ? base_url() . 'public/owner/images/no_image.jpg' : base_url() . 'public/owner/uploads/images/' . $data['image2'];
        $this->viewData['image3'] = empty($data['image3']) ? base_url() . 'public/owner/images/no_image.jpg' : base_url() . 'public/owner/uploads/images/' . $data['image3'];
        $this->viewData['image4'] = empty($data['image4']) ? base_url() . 'public/owner/images/no_image.jpg' : base_url() . 'public/owner/uploads/images/' . $data['image4'];
        $this->viewData['image5'] = empty($data['image5']) ? base_url() . 'public/owner/images/no_image.jpg' : base_url() . 'public/owner/uploads/images/' . $data['image5'];
        $this->viewData['image6'] = empty($data['image6']) ? base_url() . 'public/owner/images/no_image.jpg' : base_url() . 'public/owner/uploads/images/' . $data['image6'];

        if ($_POST) {
          $this->viewData['happyMoneyType'] = isset($_POST['happyMoneyType'])?$_POST['happyMoneyType']:'';
          $this->viewData['txthappyMoney'] = $_POST['txthappyMoney'];
          $this->viewData['image1'] = $_POST['hdImage1'];
          $this->viewData['image2'] = $_POST['hdImage2'];
          $this->viewData['image3'] = $_POST['hdImage3'];
          $this->viewData['image4'] = $_POST['hdImage4'];
          $this->viewData['image5'] = $_POST['hdImage5'];
          $this->viewData['image6'] = $_POST['hdImage6'];
          $this->viewData['hdmain_image'] = $_POST['main_image'];
          $this->viewData['ckjobTypeOwnerRecruit'] = $_POST['ckJobType'];
          $this->viewData['city_id'] = $_POST['city_id'];
          $this->viewData['ckownerTreatment'] = $_POST['cktreatment'];
          //$this->viewData['joyspe_happy_money'] = $_POST['happy_money'];
          //$this->viewData['cond_happy_money'] = $_POST['cond_happy_money'];
          $this->viewData['set_send_mail'] = $this->input->post('set_send_mail');
          //$this->viewData['scout_mail_title'] = $this->input->post('scout_mail_title');
          $this->viewData['scout_pr_text'] = $this->input->post('scout_pr_text');
          $this->viewData['public_info_flag'] = $this->input->post('public_info_flag');
          $this->do_edit_company_store($owner_id);
        }
        // 0: chua nhap, 1: da nhap, dang cho approve
        if (( $status == 0) | ($status == 1 )) {
            redirect(base_url() . 'owner/dialog/dialog_request/1');
        }
        // 3 bi tu choi, co loi quay ve message_approval de sua lai
        if ($status == 3) {
            redirect(base_url() . 'owner/message/message_approval/');
        }

        $this->viewData['cities'] = $this->Mowner->getCity();
        $this->viewData['happyMoneys'] = $this->Mowner->getHappyMoney();
        $this->viewData['owner_recruit'] = $owner_recruit;
        $this->viewData['message'] = $this->message;
        $this->viewData['city_groups'] = $this->city_groups;
        $this->viewData['data'] = $data;
        $this->viewData['owner_data'] = $owner_data;
        $this->viewData['imagePath'] = base_url() . "/public/owner/";
        $this->viewData['title'] = 'joyspe｜会社情報 -求人情報変更';
        $this->viewData['loadPage'] = 'owner/company/company_store';
        $this->load->view("owner/layout/layout_A", $this->viewData);
    }

    /**
     * @author  [IVS] Nguyen Van Phong
     * @todo 	Insert new owner_recruits, its treatments, its jobtypes...
     * @use in  Function: company_store
     * @param
     * @return
     */
    public function do_edit_company_store($owner_id = NULL) {
        if ($owner_id != NULL) {
            if (!$this->validateCompanyStore()) {
                $this->viewData['hdError'] = 0;
                return false;
            }

            /*******************get owner recruit id **********************/
            $owner_recruit_id = $this->Mcompany->getCurrentOwnerRecruitId($owner_id);
            $jobTypeOfOwnerRecruitId = $this->Mowner->getJobTypeOfOwnerRecruit($owner_recruit_id);
            /*************************************************************/

            // Get owner_recruit id
            $orid = $this->input->post('orid');
            $listImageUrl = $this->Mmessage->listImageUrl($orid);
            $l = $listImageUrl;
            $l_to_save = $listImageUrl;
            for ($i = 1; $i <= 6; $i++) {
              $url = $_POST['hdImage' . $i];
              // Nếu URL ko rỗng & có chứa 'images/' & không chứa no_image.jpg => Hình cũ
              if (!empty($url) && strpos($url, 'images/')) {
                  $url = substr(strstr($url, 'images/'), 7);
                  // Neu url co chua no_image => Bo trong
                  if ($url == 'no_image.jpg') {
                      $url = '';
                  }
              }
              // Nếu URL khác với đường dẫn cũ => Bị thay đổi hoặc bị xóa thành no_image
              else if ((strcmp($url, $l['image' . $i]) != 0)) {
                  if (empty($url)) {
                      $url = '';
                  } else {
                      // Nếu url có đuôi (sau images/) nằm trong image[i],
                      // Tức lấy hình sau đè lên hình trước, thì url = image[i]
                      $url = substr(strstr($url, 'tmp/'), 4);
                      $this->common->fileUpload($url);
                  } // End else
              } // End else if
              $l_to_save['image' . $i] = $url;
            } //End for

            $this->common->deleteFolder();

            $dataOwner = array(
              'email_address' => $this->input->post('txtEmailAddress'),
              'password' => base64_encode($this->input->post('txtPassword')),
              'storename' => $this->input->post('txtStoreName'),
              'address' => $this->input->post('txtAddress'),
              'public_info_flag' => $this->input->post('public_info_flag'),
              'set_send_mail' => $this->input->post('set_send_mail'),
              'updated_date' => date("Y-m-d H:i:s"),
              'happy_money_type' => $this->input->post('happyMoneyType')?$this->input->post('happyMoneyType') : NULL,
              'happy_money' => $this->input->post('txthappyMoney')
            );

            $this->Mowner->updateOwner($dataOwner, $owner_id);
            $this->Mmessage->updateOwnerRecruit2(array('display_flag' => 0), $owner_id);
            $dataOwnerRecruit = array(
              'owner_id' => $owner_id,
              'main_image' => $this->input->post('main_image'),
              'company_info' => $this->input->post('txtShopInfo'),
              'city_group_id' => $this->input->post('city_group_id'),
              'city_id' => $this->input->post('city_id'),
              'town_id' => $this->input->post('town_id'),
              'title' => $this->input->post('txtTitle'),
              'work_place' => $this->input->post('txtWorkPlace'),
              'working_day' => $this->input->post('txtWorkingDay'),
              'working_time' => $this->input->post('txtWorkingTime'),
              'how_to_access' => $this->input->post('txtHowToAccess'),
              'salary' => $this->input->post('txtSalary'),
              'con_to_apply' => $this->input->post('txtConToApply'),
              'visiting_benefits_title_1' => $this->input->post('visiting_benefits_title_1'),
              'visiting_benefits_title_2' => $this->input->post('visiting_benefits_title_2'),
              'visiting_benefits_title_3' => $this->input->post('visiting_benefits_title_3'),
              'visiting_benefits_content_1' => $this->input->post('visiting_benefits_content_1'),
              'visiting_benefits_content_2' => $this->input->post('visiting_benefits_content_2'),
              'visiting_benefits_content_3' => $this->input->post('visiting_benefits_content_3'),
              'other_service' => $this->input->post('other_service'),
              'apply_time' => $this->input->post('txtTimeOfApply'),
              'apply_tel' => $this->input->post('txtTelForApp'),
              'apply_emailaddress' => $this->input->post('txtMailForApp'),
              'home_page_url' => $this->input->post('txtHomePageUrl'),
              'line_id' => $this->input->post('txtLineId'),
              'line_url' => $this->input->post('txt_line_url'),
              'new_msg_notify_email' => $this->input->post('txtNewMsgNotifyEmail'),
              //'cond_happy_money' => 1, // default set to none
              'happy_money_id' => $this->Mowner->getZeroHappyMoneyID(), // default set to no happy money
              //'recruit_status' => 2,
              //'created_date' => date("Y-m-d H:i:s"),
              'image1' => $l_to_save['image1'],
              'image2' => $l_to_save['image2'],
              'image3' => $l_to_save['image3'],
              'image4' => $l_to_save['image4'],
              'image5' => $l_to_save['image5'],
              'image6' => $l_to_save['image6'],
              'scout_pr_text' => ($this->input->post('scout_pr_text') == '' ? NULL: $this->input->post('scout_pr_text')),
              'display_flag' => 1
            );

            $this->Mowner->updateOwnerRecruits($dataOwnerRecruit, $owner_recruit_id);
            $jobtype = array();
            $jobtype = $this->input->post('jobType');
            $treatment = array();
            $treatment = $this->input->post('treatment');
            $toInsert = array();

            // Delete owner treatments
            $this->Mmessage->deleteTreatmentsOwners($owner_recruit_id);
            // Insert new treatments get from views
            if (isset($_POST['cktreatment'])) {
              $treatment = $this->input->post('cktreatment');
              foreach ($treatment as $key => $value) {
                $toInsert = array(
                    'owner_recruit_id' => $owner_recruit_id,
                    'treatment_id' => $value
                );
                $this->Mmessage->insertTreatmentsOwners($toInsert);
              }
            }

            // Delete owner jobtype
            $this->Mmessage->deleteJobTypeOwners($owner_recruit_id);
            // Insert new jobtype get from views
            if (isset($_POST['ckJobType'])) {
                $jobs = $this->input->post('ckJobType');
                $toInsert = array(
                  'owner_recruit_id' => $owner_recruit_id,
                  'job_type_id' => $jobs
                );
                $this->Mmessage->insertJobTypeOwners($toInsert);
            }
            // End Insert Jobtype and Treatment area
            redirect(base_url() . 'owner/company/company');
        } else {
            show_404();
        }
    }

    /**
     * @author  [IVS] Nguyen Van Phong
     * @todo 	validate
     * @use in
     * @param
     * @return
     */
    public function validateCompanyStore() {
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
      $this->form_validation->set_rules('cktreatment[]', '待遇', 'required');
      $this->form_validation->set_rules('txtShopInfo', 'お店からのメッセージ', 'trim|required');
      $this->form_validation->set_rules('txtTimeOfApply', '応募時間', 'trim|required|max_length[20]');
      $this->form_validation->set_rules('txtTelForApp', '応募用電話番号', 'trim|required|max_length[24]|checkStringByte|validNumber');
      $this->form_validation->set_rules('txtMailForApp', '応募用メールアドレス', 'trim|required|max_length[200]|checkStringByte|valid_email');
      $this->form_validation->set_rules('txtHomePageUrl', 'オフィシャルHP', 'trim|required|max_length[100]');
      $this->form_validation->set_rules('txtLineId', 'LINEID');
      $this->form_validation->set_rules('txtNewMsgNotifyEmail', 'お問い合わせ通知用のメールアドレス', 'trim|required|max_length[200]|checkStringByte|valid_email');
      $this->form_validation->set_rules('hdImage1', 'hdImage1');
      $this->form_validation->set_rules('hdImage2', 'hdImage2');
      $this->form_validation->set_rules('hdImage3', 'hdImage3');
      $this->form_validation->set_rules('hdImage4', 'hdImage4');
      $this->form_validation->set_rules('hdImage5', 'hdImage5');
      $this->form_validation->set_rules('hdImage6', 'hdImage6');
      $this->form_validation->set_rules('ckImage[]', '写真');
      $this->form_validation->set_rules('visiting_benefits_title_1', 'visiting_benefits_title_1');
      $this->form_validation->set_rules('visiting_benefits_title_2', 'visiting_benefits_title_2');
      $this->form_validation->set_rules('visiting_benefits_title_3', 'visiting_benefits_title_3');
      $this->form_validation->set_rules('visiting_benefits_content_1', 'visiting_benefits_content_1');
      $this->form_validation->set_rules('visiting_benefits_content_2', 'visiting_benefits_content_2');
      $this->form_validation->set_rules('visiting_benefits_content_3', 'visiting_benefits_content_3');
      $form_validation = $this->form_validation->run();
      $this->message['success'] = !$form_validation && count($_POST) > 0 ? FALSE : TRUE;
        if (!$form_validation) {
            return false;
        }
        return true;
    }

    /**
     * author: [IVS] Nguyen Bao Trieu
     * name : checkFromTo
     * todo : check From To
     * @param null
     * @return null
     */
    public function checkFromEqualTo() {
        $from = $this->input->post('working_hour_from');
        $to = $this->input->post('working_hour_to');

        if ($from >= $to) {
            return false;
        }
        return true;
    }

    /**
     * @author  [IVS] Nguyen Van Phong
     * @todo 	joy types processing to show in view
     * @use in  this class
     * @param
     * @return
     */
    public function jobtypeProcessing($owner_id = 0) {
        $data = $this->Mcompany->companyStoreEdit($owner_id);
        $allJobtype = array();
        $jobTypeOfOwnerRecruit = array();
        $jobTypeOwnerRecruit = array();
        $jobType = array();
        $allJobtype = $this->Mowner->getJobType();
        $jobTypeOfOwnerRecruit = $this->Mowner->getJobTypeOfOwnerRecruit($data['orid']);
        if (count($jobTypeOfOwnerRecruit)) {
            foreach ($jobTypeOfOwnerRecruit as $j) {
                $jobTypeOwnerRecruit[] = $j['id'];
            }
        }
        if (count($allJobtype)) {
            foreach ($allJobtype as $a) {
                $jobType [] = $a;
            }
        }

        $this->viewData['jobType'] = $jobType;
        $this->viewData['ckjobTypeOwnerRecruit'] = $jobTypeOwnerRecruit;
        $this->viewData['ownerJobType'] = isset($jobTypeOfOwnerRecruit[0]['name']) ? $jobTypeOfOwnerRecruit[0]['name'] : "";
    }

    /**
     * @author  [IVS] Nguyen Van Phong
     * @todo 	Treatments processing
     * @use in  This class
     * @param
     * @return
     */
    public function treatmentProcessing($owner_id = 0) {
        $ownerTreatment = array();
        $allOwnerTreatment = array();
        $orid = $this->Mcompany->getCurrentOwnerRecruitId($owner_id);
        $companyTreatmentInfo = $this->Mcompany->getTreatmentOwner($orid);
        $allTreatments = $this->Mcompany->getAllTreatments();
        if (count($companyTreatmentInfo) > 0) {
            foreach ($companyTreatmentInfo as $c) {
                $ownerTreatment[] = $c['id'];
            }
        }
        if (count($allTreatments) > 0) {
            foreach ($allTreatments as $a) {
                $allOwnerTreatment [] = $a['name'];
            }
        }

        $this->viewData['ckownerTreatment'] = $ownerTreatment;
        $this->viewData['allTreatments'] = $allTreatments;
    }

    // ++++++++ company store edit area ++++++++

    public function getDataList() {
      $this->output->set_content_type('application/json');
      if($_POST['type'] == 'city_group')
        $data = $this->Mowner->getGroupCities($_POST['id']);
      elseif($_POST['type'] == 'city')
        $data = $this->Mowner->getCityTowns($_POST['id']);
      echo json_encode($data);
    }
}

?>

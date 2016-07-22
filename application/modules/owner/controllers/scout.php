<?php

class Scout extends Common {

    private $viewData = array();
    public $message = array('success' => true, 'error' => array());

    function __construct() {
        parent::__construct();
        $this->load->model('owner/Mscout');
        $this->load->model('owner/Mhistory');
        $this->load->model('owner/muser');
        $this->load->model('owner/Mowner');
        $this->load->model('owner/Mpoint');
        $this->load->model('user/Musers');
        $this->load->model('owner/Mcommon');
        $this->load->model('owner/Mtemplate');
        $this->load->library('session');
        $this->load->helper('breabcrumb_helper');
        $this->common = new Common();
        $this->output->set_header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate");
        $this->output->set_header("Cache-Control: post-check=0, pre-check=0");
        $this->output->set_header("Pragma: no-cache");
        $this->form_validation->CI = & $this;
        HelperApp::start_session();
    }

    /**
     * @author  [IVS] Phan Ngoc Minh Luan
     * @name 	scout_settlement
     * @todo 	pay scout message for every user
     * @param 	int $user_id
     * @return 	void
     */
    public function scout_settlement() {
        $email_address = OwnerControl::getEmail();
        $owner_id = OwnerControl::getId();
        $arr_user_id = Array();
        $count = 0;
        $count_unsent = 0;
        $count_spams = 0;
        if (HelperApp::get_session('arr_user_id_unsent') != NULL) {
            $arr_user_id = HelperApp::get_session('arr_user_id_unsent');
            $user_profiles = $this->Mhistory->getArrUserProfiles($arr_user_id);
        }
        if ($this->input->post('array_user_id') != null) {
            $arr_user_id = $this->input->post('array_user_id');
            $user_profiles = $this->Mhistory->getArrUserProfiles($arr_user_id);
        }
        if (isset($_POST['arr_user_id_unsent'])) {
            $arr_user_id = $_POST['arr_user_id_unsent'];
            $user_profiles = $this->Mhistory->getArrUserProfiles($arr_user_id);
        }
         foreach ($arr_user_id as $value) {
                $count++; // number checked box
            }
        if ($count != 0) {
            // get scout money purchase
            $scout = $this->Mhistory->getCharge('0');
            $total_scout_money = $scout['amount'] * $count;
            $total_scout_point = $scout['point'] * $count;
            // get total point and amount of owner
            $owners = $this->Mhistory->getTotal($email_address);
            $owner_info = HelperGlobal::owner_info($owner_id);
            $this->viewData['owner_info'] = $owner_info;
            $point_owner = $owners['total_point'];
            $money_owner = $owners['total_amount'];
            $paramPoint = $scout['point'] / $scout['amount'];
            $this->viewData['count_unsent'] = $count;
            $this->viewData['total_scout_money'] = $total_scout_money;
            $this->viewData['point_owner'] = $point_owner;
            $this->viewData['total_scout_point'] = $total_scout_point;
            $remainder_point = $point_owner - $total_scout_point;
            $remainder_money = $money_owner - $total_scout_money;
            $this->viewData['remainder_point'] = $remainder_point;
            $this->viewData['remainder_money'] = $remainder_money;
            $this->viewData['scout_money'] = $scout['amount'];
            $this->viewData['scout_point'] = $scout['point'];
            $this->viewData['user_profiles'] = $user_profiles;
            $this->viewData['loadPage'] = "owner/scout/scout_settlement";
            $this->viewData['title'] = 'joyspe｜決済完了';
//            HelperApp::remove_session('arr_user_id_unsent');
            $this->load->view('owner/layout/layout_B', $this->viewData);
        } else {
            redirect(base_url() . "owner/scout/scout_after");
        }
    }

    /**
     * author: [IVS] Phan Ngoc Minh Luan
     * name : scout_settlement_check
     * todo : check and return data for view scout_settlement
     * @param null
     * @return void
     */
    public function scout_settlement_check() {
        $arr_user_id = $_POST['user_id'];
        $owner_id = OwnerControl::getId();
        $count = $count_unsent = $count_spams = 0;
        $str_unique_id = "";
        foreach ($arr_user_id as $value) {
            $count++; // number checked box
            $flag_compare = $this->Mhistory->compareScoutMessageSpam($value, $owner_id);
            if ($flag_compare > 0) {
                $count_spams++; // have spam
                $unique_id = $this->Mscout->getUserUniqueId($value);
                $str_unique_id = $unique_id . "," . $str_unique_id;
            } else { //don't have spam
                $count_unsent++; // number of users are unsent scout message
                $arr_user_id_unsent[] = $value;
            }
        }
        $str_unique_id = substr($str_unique_id, 0, -1);
        if ($count_spams == $count) {
            $arr_param = array(
                'str_unique_id' => $str_unique_id,
                'count_unsent' => $count_unsent,
                'count' => $count,
                'count_spams' => $count_spams,
            );
        }
        if (0 < $count_spams && $count_spams < $count) {
            $arr_param = array(
                'str_unique_id' => $str_unique_id,
                'count_unsent' => $count_unsent,
                'count' => $count,
                'count_spams' => $count_spams,
                'arr_user_id_unsent' => array('arr_user_id_unsent[]' => $arr_user_id_unsent),
            );
        }
        if ($count == $count_unsent) {
            $arr_param = array(
                'count_unsent' => $count_unsent,
                'count' => $count,
                'count_spams' => $count_spams,
            );
            HelperApp::add_session('arr_user_id_unsent', $arr_user_id_unsent);
            HelperApp::add_session('count_unsent', $count_unsent);
        }
        echo json_encode($arr_param);
        die;
    }

    /**
     * @author  [IVS] Nguyen Hong Duc
     * @name 	scout_after
     * @todo 	load page
     * @param
     * @return 	void
     */
    public function scout_after() {

    	if(isset($_SESSION['sRetainCheckrs']))
    		HelperApp::remove_session('sRetainCheckrs');
        if(isset($_SESSION['sSortActive']))
          HelperApp::remove_session('sSortActive');

        if (isset($_SESSION['sCheckrs'])) {
            HelperApp::remove_session('sCheckrs');
            $unique_id = $this->input->get("u");
        }
        $owner_id = OwnerControl::getId();
        $owner_data = HelperGlobal::owner_info($owner_id);
        $hourly = $this->Mscout->getHourlySalary();
        $monthly = $this->Mscout->getMonthlySalary();
        $hopetimeworking = $this->Mscout->getHopeTimeWorking();
        $hopedayworking = $this->Mscout->getHopeDayWorking();
        $age = $this->Mscout->getAge();
        $jobtype = $this->Mscout->getJobType();
        $groupcity = $this->Mscout->getGroupCity();
        $city = $this->Mscout->getCity();
        $arrcss = array(0 => "150", 1 => "140", 2 => "180", 3 => "140", 4 => "145", 5 => "140");
        // HTML
        $resultbegin = "<div id='result_search' style='display: none' >";
        $resultend = "<div>";

        $this->viewData['arrcss'] = $arrcss;
        $this->viewData['groupcity'] = $groupcity;
        $this->viewData['city'] = $city;
        $this->viewData['hourly'] = $hourly;
        $this->viewData['monthly'] = $monthly;
        $this->viewData['hopetimeworking'] = $hopetimeworking;
        $this->viewData['hopedayworking'] = $hopedayworking;
        $this->viewData['age'] = $age;
        $this->viewData['jobtype'] = $jobtype;
        $this->viewData['owner_data'] = $owner_data;
        $this->viewData['owner'] = $owner_data;
        $this->viewData['resultbegin'] = $resultbegin;
        $this->viewData['resultend'] = $resultend;
        $this->viewData['message'] = $this->message;
        $this->viewData['loadPage'] = 'owner/scout/scout_after';
        $this->viewData["title"] = "joyspe｜スカウト機能";
        $this->viewData["flag"] = 0;
        $this->viewData["unique_id"] = '';
        $this->load->view("owner/layout/layout_A", $this->viewData);
    }

    /**
     * @author  [IVS] Nguyen Hong Duc
     * @name 	doSearch
     * @todo 	search with condition
     * @param 	$page = 1
     * @return 	void
     */
    public function doSearch($page = 1) {
        if (isset($_SESSION['resendUserScoutMail'])) {         
            HelperApp::remove_session('resendUserScoutMail');     
        }
        if ($_POST) {
        	$doSearch = $this->input->post('doSearch');
        	if($doSearch)
        		HelperApp::remove_session('sRetainCheckrs');
            if (isset($_SESSION['sCheckrs']) && !isset($_SESSION['sRetainCheckrs'])) {
                HelperApp::remove_session('sCheckrs');
            }
            if(isset($_SESSION['sSortActive']))
              HelperApp::remove_session('sSortActive');
        }
        $arrId = array();
        if(isset($_SESSION['sRetainCheckrs'])) {
        	$s_checkers = HelperApp::get_session('sCheckrs');
        	if(count($s_checkers) > 0) {
	        	foreach ($s_checkers as $key => $value) {
	        		foreach ($value as $vl) {
	        			$arrId[] = $vl;
	        		}
	        	}
        	}
        	$this->viewData['sRetainCheckrs'] = $arrId;
        }
        if(isset($_SESSION['sSortActive']))
          $sort_type = $this->viewData['sSortActive'] = HelperApp::get_session('sSortActive');
        else
          $sort_type = '';
        $owner_id = OwnerControl::getId();
        $owner_data = HelperGlobal::owner_info($owner_id);
        $ors_id = $this->Mowner->getOwnerRecruitId($owner_id);
        $groupcity = $this->Mscout->getGroupCity();
        $city = $this->Mscout->getCity();
        $arrcss = array(0 => "150", 1 => "140", 2 => "180", 3 => "140", 4 => "145", 5 => "140");

        $this->viewData['arrcss'] = $arrcss;
        $this->viewData['groupcity'] = $groupcity;
        $this->viewData['city'] = $city;

        // GET VALUE FROM POST
        $checkall = $this->input->post("checkall");

        $strCity = "";
        $checkcity = $this->input->post("checkcity");
        if ($checkcity != '') {
            foreach ($checkcity as $id) {
                $strCity .= $id . ',';
            }
            $strCity = substr($strCity, 0, -1);
        }

        if ($_POST) {
            HelperApp::add_session('sCheckall', $checkall);
            HelperApp::add_session('sCity', $checkcity);
        }
        if (!$_POST) {
            $checkcity = HelperApp::get_session('sCity');
            if ($checkcity != '') {
                foreach ($checkcity as $id) {
                    $strCity .= $id . ',';
                }
                $strCity = substr($strCity, 0, -1);
            }
        }
        $this->viewData['sCheckall'] = HelperApp::get_session('sCheckall');
        $this->viewData['sCity'] = HelperApp::get_session('sCity');
        $ownerHiddenUsers = $this->Mowner->getOwnerHiddenUsers($owner_id);
        $todayRegisteredUser = $this->muser->countRegisteredUser(date('Ymd'));
        $yesterdayRegisteredUser = $this->muser->countRegisteredUser(date('Ymd', strtotime(date("Y-m-d")."-1 days")));

        $unique_id = $this->input->post("u");

        // GET VALUE WITH ID
        //$page = $page > 1 ? $page : 1;
        $ppp = $this->config->item('per_page');
        $total = $this->Mscout->countData($strCity, $owner_id, $ownerHiddenUsers, $unique_id);    
        
        // HTML
        $resultbegin = "<div id='result_search'>";
        $resultend = "<div>";
        if ($ppp != 0) {
          $totalpage = ceil($total / $ppp);
        }

        $page = (isset($page))?($page > 1)?$page:1:1;
        if(strlen($page) >= 7)
          $page = intval(substr($page, 3, strlen($page)-6));
        $paging = $this->scoutPaging($page, $totalpage);

        $flag = 1;
        if ($_POST) {
          if ($this->validate()) {
            $flag = 1;
          } else {
            $flag = 0;
          }
        }

        $this->viewData['doSearch_flag'] = true;
        if ($flag == 1) {
            $data = $this->Mscout->dataSearch($strCity, $page, $ppp, $owner_id, $sort_type, $ownerHiddenUsers, $unique_id);
            $this->viewData['todayRegisteredUser'] = $todayRegisteredUser;
            $this->viewData['yesterdayRegisteredUser'] = $yesterdayRegisteredUser;
            $this->viewData['page'] = $page;
            $this->viewData['ppp'] = $ppp;
            $this->viewData['str_city'] = $strCity;
            $this->viewData['paging'] = $paging;
            $this->viewData['newUser'] = $data;
            $this->viewData['owner_data'] = $owner_data;
            $this->viewData['owner'] = $owner_data;
            $this->viewData['resultbegin'] = $resultbegin;
            $this->viewData['resultend'] = $resultend;
            $this->viewData['total'] = $total;
            $this->viewData['totalpage'] = $totalpage;
            $this->viewData['message'] = $this->message;
            $this->viewData['curpage'] = $page;
            $this->viewData['sCheckrs'] = HelperApp::get_session('sCheckrs');
            $this->viewData['function_name'] = "return resultsearch(this);";
            $this->viewData['loadPage'] = 'owner/scout/scout_after';
            $this->viewData["title"] = "joyspe｜スカウト機能";
            $this->viewData["flag"] = 1;
            $this->viewData["unique_id"] = $unique_id;
            $this->load->view("owner/layout/layout_A", $this->viewData);
        } else {
            $this->viewData['owner_data'] = $owner_data;
            $this->viewData['owner'] = $owner_data;
            $this->viewData['message'] = $this->message;
            $this->viewData['sCheckrs'] = HelperApp::get_session('sCheckrs');
            $this->viewData['function_name'] = "return resultsearch(this);";
            $this->viewData['loadPage'] = 'owner/scout/scout_after';
            $this->viewData["title"] = "joyspe｜スカウト機能";
            $this->viewData["flag"] = 0;
            $this->load->view("owner/layout/layout_A", $this->viewData);
        }
    }

    /**
     * @author  [IVS] Nguyen Hong Duc
     * @name 	savecheck
     * @todo 	sace checkbox paging
     * @param 	null
     * @return 	void
     */
    public function saveCheck() {
      if(isset($_SESSION['sCheckrs']))
        HelperApp::remove_session('sCheckrs');
        $checkrs = ($this->input->post("checkrs"))?$this->input->post("checkrs"):array();
        $curpage = $this->input->post("hdPage");
        $sessionArr[$curpage] = array();
        if (!isset($_SESSION['sCheckrs']) && $checkrs) {
            foreach ($checkrs as $value) {

                $sessionArr[$curpage][] = $value;
            }
            HelperApp::add_session('sCheckrs', $sessionArr);
        } else {
            unset($_SESSION['sCheckrs'][$curpage]);

            foreach ($checkrs as $value) {

                $_SESSION['sCheckrs'][$curpage][] = $value;
            }
        }
        echo json_encode($checkrs);
    }

    /**
     * @author: [IVS] Nguyen Hong Duc
     * @name : checkMail
     * @todo : check storename, email, title, body
     * @param null
     * @return boolean
     */
    public function validate() {
        $this->form_validation->set_rules('hourly1', '時給目安', 'callback_checkFromTo');
        $this->form_validation->set_rules('monthly1', '月給目安', 'callback_checkFromTo2');
        $this->form_validation->set_rules('age1', '年齢', 'callback_checkFromTo3');
        $this->form_validation->set_rules('hopeday1', '勤務日数　週', 'callback_checkFromTo4');
        $this->form_validation->set_rules('hopetime1', '勤務時間　1回勤務', 'callback_checkFromTo5');

        $form_validation = $this->form_validation->run();
        $this->message['success'] = !$form_validation && count($_POST) > 0 ? FALSE : TRUE;

        if (!$form_validation) {
            return false;
        }
        return true;
    }

    /**
     * @author: [IVS] Nguyen Bao Trieu
     * @name : checkFromTo
     * @todo : check From To
     * @param null
     * @return null
     */
    public function checkFromTo() {
        $get_hourly1 = 0;
        $get_hourly2 = 0;
        $hourly1 = $this->input->post('hourly1');
        $hourly2 = $this->input->post('hourly2');
        if ($hourly2 == '0') {
            return true;
        }
        if ($hourly1 > 0) {
            $get_hourly1 = $this->Mscout->getHourlySalaryAmount($hourly1);
        }
        if ($hourly2 > 0) {
            $get_hourly2 = $this->Mscout->getHourlySalaryAmount($hourly2);
        }
        if ($get_hourly1 > $get_hourly2) {
            return false;
        }
        return true;
    }

    /**
     * @author: [IVS] Nguyen Hong Duc
     * @name : checkFromTo
     * @todo : check From To
     * @param null
     * @return null
     */
    public function checkFromTo2() {
        $get_monthly1 = 0;
        $get_monthly2 = 0;
        $monthly1 = $this->input->post("monthly1");
        $monthly2 = $this->input->post("monthly2");
        if ($monthly2 == '0') {
            return true;
        }
        if ($monthly1 > 0) {
            $get_monthly1 = $this->Mscout->getMonthlySalaryAmount($monthly1);
        }
        if ($monthly2 > 0) {
            $get_monthly2 = $this->Mscout->getMonthlySalaryAmount($monthly2);
        }
        if ($get_monthly1 > $get_monthly2 && $get_monthly2 != 0) {
            return false;
        }
        return true;
    }

    /**
     * @author: [IVS] Nguyen Hong Duc
     * @name : checkFromTo
     * @todo : check From To
     * @param null
     * @return null
     */
    public function checkFromTo3() {
        $get_age1 = 0;
        $get_age2 = 0;
        $age1 = $this->input->post("age1");
        $age2 = $this->input->post("age2");
        if ($age2 == '0') {
            return true;
        }
        if ($age1 > 0) {
            $get_age1 = $this->Mscout->getAge1($age1);
        }
        if ($age2 > 0) {
            $get_age2 = $this->Mscout->getAge2($age2);
        }
        if ($get_age1 > $get_age2 && $get_age2 != 0) {
            return false;
        }
        return true;
    }

    /**
     * @author: [IVS] Nguyen Hong Duc
     * @name : checkFromTo
     * @todo : check From To
     * @param null
     * @return null
     */
    public function checkFromTo4() {
        $get_hopeday1 = 0;
        $get_hopeday2 = 0;
        $hopeday1 = $this->input->post("hopeday1");
        $hopeday2 = $this->input->post("hopeday2");
        if ($hopeday2 == '0') {
            return true;
        }
        if ($hopeday1 > 0) {
            $get_hopeday1 = $this->Mscout->getHopeDayWorkingValue1($hopeday1);
        }
        if ($hopeday2 > 0) {
            $get_hopeday2 = $this->Mscout->getHopeDayWorkingValue2($hopeday2);
        }
        if ($get_hopeday1 > $get_hopeday2 && $get_hopeday2 != 0) {
            return false;
        }
        return true;
    }

    /**
     * @author: [IVS] Nguyen Hong Duc
     * @name : checkFromTo
     * @todo : check From To
     * @param null
     * @return null
     */
    public function checkFromTo5() {
        $get_hopetime1 = 0;
        $get_hopetime2 = 0;
        $hopetime1 = $this->input->post("hopetime1");
        $hopetime2 = $this->input->post("hopetime2");
        if ($hopetime2 == '0') {
            return true;
        }
        if ($hopetime1 > 0) {
            $get_hopetime1 = $this->Mscout->getHopeTimeWorkingValue1($hopetime1);
        }
        if ($hopetime2 > 0) {
            $get_hopetime2 = $this->Mscout->getHopeTimeWorkingValue2($hopetime2);
        }
        if ($get_hopetime1 > $get_hopetime2 && $get_hopetime2 != 0) {
            return false;
        }
        return true;
    }
   /**
     * @author  VJS
     * @name    scout_finish
     * @todo    finish sending scout
     * @param
     * @return  void
     */
    public function scout_finish() {
        $email_address = OwnerControl::getEmail();
        $owner_status = OwnerControl::getOwnerStatus();
        $owner_id = OwnerControl::getId();

        $scout_mail_template_id = HelperApp::get_session('scout_mail_template_id');
        HelperApp::remove_session('scout_mail_template_id');

        if ($owner_id != NULL) {
            $owner_recruit_id = $this->Mowner->getOwnerRecruitId($owner_id);
            $ownerData = $this->Mhistory->getOwnerRecruitHappyMoney($owner_recruit_id);
            if($ownerData[0]['user_happy_money'] > 0) {
              $vOw = 'ow04';
              $vUs = 'us03';
            }
            else {
              $vOw = 'ow23';
              $vUs = 'us14';
            }
            $arr_user_id = HelperApp::get_session('arr_user_id_unsent');
            $count_unsent = HelperApp::get_session('count_unsent');
            if (!$arr_user_id || !$count_unsent) {
                return false;
            }
            $owner_recruit_id = $this->Mpoint->getOwnerRecruitId($owner_id);
            $count_users_checked = 0;
            $count_exist = $this->Mpoint->checkExistList($owner_recruit_id, $arr_user_id);
			if($arr_user_id):
            foreach ($arr_user_id as $user_id):
                if ($this->Mpoint->checkExistListUserMessage($owner_recruit_id, $user_id)) {
                    $count_users_checked++;
                }
                else {
                	$resend = $this->Mowner->getUserOpenScoutMail($user_id, $owner_id);
                	if(isset($resend[0]['is_read'])) {
                            if ($resend[0]['is_read'] == 1 ||
                                (isset($resend[0]['created_date']) &&
                                $resend[0]['last_visit_date'] >= $resend[0]['created_date']))
                			$count_users_checked++;
                	}
                }
            endforeach;
			endif;
            if (isset($_SESSION['resendUserScoutMail'])) {
                $count_users_checked = 1;
                HelperApp::remove_session('resendUserScoutMail');
            }
            if (/*$count_unsent == $count_users_checked && */$owner_status != 1 /* dont send mail for steath owner */) {
                $created_date = $this->Mpoint->getCurrentDate();
				if($arr_user_id):
                foreach ($arr_user_id as $user_id):
                    $flagsetsendmail = $this->Musers->get_users($user_id);
                    $payment_message_status = 1; // enough money
                    $list_user_message_id = $this->Mpoint->insertListUserMessage($owner_recruit_id, $user_id, $vUs, $payment_message_status, $scout_mail_template_id);

                    $this->Mpoint->insertListOpenRate($user_id);

                    $this->Mpoint->insertListReciveOpenMail($owner_id,$user_id);

                    $owner_recruit = $this->Mowner->getOwnerRecruit($owner_id);
                    $url = base_url() . 'user/joyspe_user/company/' . $owner_recruit['id']."/";
                    if ($flagsetsendmail['set_send_mail'] == 1 && $owner_status != 1) {
                        // send mail us03 for user
                        $this->sendMail('', '', '', array($vUs), $owner_id, '', $user_id, 'getUserSelect', 'getJobUser', 'getJobTypeOwnerForScout', array($user_id), $url, '', $list_user_message_id);
                    }
                    /* sending data to other site */
                    if($flagsetsendmail['user_status'] == 1 && $flagsetsendmail['user_from_site'] != 0 && $owner_status != 1) {
                        $userEmailContent = $this->getUserEmailContent($owner_id, $user_id, $url, $list_user_message_id, $flagsetsendmail['user_from_site']);
                        // add <a> tag to URL
                        $pattern = "/(?i)\b((?:https?:\/\/|www\d{0,3}[.]|[a-z0-9.\-]+[.][a-z]{2,4}\/)(?:[^\s()<>]+|\(([^\s()<>]+|(\([^\s()<>]+\)))*\))+(?:\(([^\s()<>]+|(\([^\s()<>]+\)))*\)|[^\s`!()\[\]{};:'\".,<>?«»“”‘’]))/";
                        $userEmailContent = preg_replace($pattern, "<a href=\"$1\">$1</a>", $userEmailContent);
                        if($flagsetsendmail['user_from_site'] == 1)
                            $url = REMOTE_LOGIN_SITE_1.'/scoutmail.php';
                        elseif($flagsetsendmail['user_from_site'] == 2)
                            $url = REMOTE_LOGIN_SITE_2.'/scoutmail.php';
						  else
							$url = '';
                        if ($url) {
                            $id = $flagsetsendmail['old_id'];
                            $md5_id = md5(MOBA_PREFIX.$id);
                            $data = $this->Mowner->getScoutPoint();
                            $point = 0;
                            if ( $data ){
                            $point = $data['point'];
                            }
                            $postdata = array("point" => $point,
                                            "loginid"   => $md5_id,
                                            "scoutmail_title" => $userEmailContent['title'],
                                            "scoutmail_content" => $userEmailContent['body']);
                            $ch = curl_init($url);
                            curl_setopt($ch, CURLOPT_POST, true);
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                            curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
                            curl_setopt($ch, CURLOPT_TIMEOUT,50);
                            $result = curl_exec($ch);
                            curl_close($ch);
                        }
                    }
                endforeach;
				endif;
                if (OwnerControl::getSetSendMail()) {
                    // send mail ow04 for owner
                    $this->sendMail('', '', '', array($vOw), $owner_id, $senderName = null, $user_id = null, 'getUserSelect', 'getJobUser', 'getJobOwnerForScout', $arr_user_id, '', $count_unsent);
                    $templOwner04 = $this->Mcommon->getTemplate($vOw);
                    $dataOwner04['owner_id'] = $owner_id;
                    $dataOwner04['template_id'] = $templOwner04['id'];
                    $dataOwner04['created_date'] = date("y-m-d H:i:s");
                    $this->Mtemplate->insertOwnerList($dataOwner04);
                }
                $ownerData1 = $this->Mowner->getOwner($owner_id);
                $this->Mowner->updateRemainingScoutMail($owner_id, array('remaining_scout_mail' => $ownerData1['remaining_scout_mail'] - $count_unsent));
            }
            $owner_info = HelperGlobal::owner_info($owner_id);
            $this->viewData['owner_info'] = $owner_info;
            $owners = $this->Mhistory->getTotal($email_address);
            $this->viewData['total_point'] = $owners['total_point'];
            HelperApp::remove_session('sCheckrs');
            HelperApp::remove_session('count_unsent');
            HelperApp::remove_session('arr_user_id_unsent');
            $this->viewData['loadPage'] = "owner/point/sendscoutok";
            $this->viewData['title'] = 'joyspe｜スカウトメール送信完了';
            $this->load->view("owner/layout/layout_B", $this->viewData);
        } else {
            redirect(base_url() . 'owner/login');
        }
    }

    public function scoutPaging($page, $totalpage) {
      $encrypt = date('sHi');
      if($page != $totalpage) {
        $data[0] = substr_replace($encrypt, $page+1, 3, 0);
      }
      if($page == $totalpage) {
        $data[0] = substr_replace($encrypt, $page-1, 3, 0);
      }
      if($page > 1 && $page != $totalpage) {
        $data[1] = substr_replace($encrypt, $page-1, 3, 0);
      }
      return $data;
    }

    public function scout_pagination() {
        $owner_id = OwnerControl::getId();
        // GET VALUE WITH ID
        //$page = $page > 1 ? $page : 1;
        $ppp = $this->config->item('per_page');
        $page = $this->input->post('page');
        $curpage = $this->input->post('cur_page');
        $unique_id = $this->input->post("u");
        $sort_type = $this->input->post('sort_type');
        $total = $this->Mscout->countData($this->input->post('str_city'), $owner_id, $this->Mowner->getOwnerHiddenUsers($owner_id),$unique_id,$sort_type);
        if ($ppp != 0) {
            $totalpage = ceil($total / $ppp);
        }

        $page = (isset($page))?($page > 1)?$page:1:1;
        if(strlen($page) >= 7){
            $page = intval(substr($page, 3, strlen($page)-6));
        }
        if($total < ($page * $ppp)){
            $page = ceil($total / $ppp);
        }
        $paging = $this->scoutPaging($page, $totalpage);
        $this->viewData['paging'] = $paging;
        $this->viewData['curpage'] = $page;
        $this->viewData['totalpage'] = $totalpage;
        $this->viewData['total'] = $total;
        $this->load->view("owner/scout/scout_paging", $this->viewData);
    }

    public function list_of_users() {
        $s_checkers = HelperApp::get_session('sCheckrs');
    	if(count($s_checkers) > 0) {
    		foreach ($s_checkers as $key => $value) {
    		    foreach ($value as $vl) {
    			    $arrId[] = $vl;
    		    }
    	    }
            $this->viewData['sRetainCheckrs'] = $arrId;
        }

        $owner_id = OwnerControl::getId();
        $owner = $this->Mowner->getOwner($owner_id);
        $strCity = $this->input->post('str_city');
        $page = $this->input->post('page');
        $page = (isset($page))?($page > 1)?$page:1:1;
        if(strlen($page) >= 7){
            $page = intval(substr($page, 3, strlen($page)-6));
        }

        $ppp = $this->config->item('per_page');
        $sort_type = $this->input->post('sort_type');

        $unique_id = $this->input->post("u");

        $ownerHiddenUsers = $this->Mowner->getOwnerHiddenUsers($owner_id);        
        $total = $this->Mscout->countData($strCity, $owner_id, $ownerHiddenUsers, $unique_id, $sort_type);
        if($total < ($page * $ppp)){
            $page = ceil($total / $ppp);
        }

        $data = $this->Mscout->dataSearch($strCity, $page, $ppp, $owner_id, $sort_type, $ownerHiddenUsers,$unique_id);
        $this->viewData['owner'] = $owner;
        $this->viewData['newUser'] = $data;
        $this->viewData['function_name'] = $this->input->post('function_name');
        $this->load->view("owner/index/list_of_users", $this->viewData);
    }

    public function retainSaveCheck() {
	  HelperApp::add_session('sRetainCheckrs', true);
	  exit;
    }

    public function saveCheck1() {
    	$id = $this->input->post("id");
    	$check_type = $this->input->post("checked");
    	$curpage = $this->input->post("hdPage");

    	if (!isset($_SESSION['sCheckrs'])) {

    		$user[$curpage][] = $id;
    		HelperApp::add_session('sCheckrs', $user);
    	} else {
    		if($check_type == 1) {
    			$_SESSION['sCheckrs'][$curpage][] = $id;
    		}
    		else {
    			if(($key = array_search($id, $_SESSION['sCheckrs'][$curpage])) !== false) {
    				unset($_SESSION['sCheckrs'][$curpage][$key]);
    				if(empty($_SESSION['sCheckrs'][$curpage]))
    					unset($_SESSION['sCheckrs'][$curpage]);
    			}
    		}
    	}
    	exit;
    }

    public function list_of_hide_users() {
    	$strCity = $this->input->post('str_city');
    	$owner_id = OwnerControl::getId();
    	$newUser = $this->Mscout->getListOfHideUsers($strCity, $owner_id, $this->Mowner->getOwnerHiddenUsers($owner_id));
    	$this->viewData['owner_id'] = $owner_id;
    	$this->viewData['newUser'] = $newUser;
    	$this->load->view("owner/index/list_of_hide_users", $this->viewData);
    }

    public function remove_user_scout() {
    	$owner_id = OwnerControl::getId();
    	$saveCheck1 = $this->input->post('remove');
    	$id = $this->input->post('id');
    	if($saveCheck1 && isset($_SESSION['sCheckrs'])) {
    		$curpage = $this->input->post("hdPage");
    		if(($key = array_search($id, $_SESSION['sCheckrs'][$curpage])) !== false) {
    			unset($_SESSION['sCheckrs'][$curpage][$key]);
    			if(empty($_SESSION['sCheckrs'][$curpage]))
    				unset($_SESSION['sCheckrs'][$curpage]);
    		}
    	}
    	$this->Mowner->insertOwnerHiddenUser(array('owner_id' => $owner_id, 'user_id' => $id));
    	$ownerHiddenUsers = $this->Mowner->getOwnerHiddenUsers($owner_id);

    	exit;
    }

    public function auto_send(){
        $owner_id = OwnerControl::getId();
        if ($owner_id != NULL) {
            $owner_data = HelperGlobal::owner_info($owner_id);
            $auto_send_finish = HelperApp::get_session('auto_send_finish');
            $city = $this->Mscout->getCity();
            
            $owner_recruit  = $this->Mowner->getOwnerRecruit($owner_id);
            $ownerData = $this->Mowner->getOwner($owner_id);
            $scout_pr_text = $owner_recruit['scout_pr_text'];
            $ownerRecruitId = $owner_recruit['id'];
            $company_data = $this->Mhistory->getOwnerRecruitHappyMoney($ownerRecruitId);
            $user_happy_money = $company_data[0]['user_happy_money'];
            $mst_template = $this->Mhistory->getMtemplatesTitle(($user_happy_money > 0) ? 'us03':'us14');
            $defaul_mail_title = str_replace('/--店舗名--/', $ownerData['storename'], $mst_template['title']);
            $owner_scout_pr_text_data = $this->Mowner->getListOfOwnerScoutPrText($owner_id);
            $this->viewData['owner_scout_pr_text_data'] = $owner_scout_pr_text_data;
            $o_s_pr_text_total = count($owner_scout_pr_text_data);
            if ($o_s_pr_text_total == 0) {
                $scout_pr_id = $this->_insertOwnerScoutPrText($owner_id, '名称未設定', $scout_pr_text, $defaul_mail_title);
                redirect(base_url() . 'owner/scout/auto_send');
            }

            $getAutoSend = $this->Mowner->getAutoSend($owner_id);
            $andWhere = 'AND selected_flag = 2';
            $ifchecked = $this->Mowner->getAutoSend($owner_id, $andWhere);
            $getOwner = $this->Mowner->getOwner($owner_id);
            $this->viewData['city'] = $city;
            $this->viewData['loadPage'] = "owner/scout/auto_send";
            $this->viewData['title'] = 'joyspe｜スカウト自動送信';
            $this->viewData['owner_data'] = $owner_data;
            $this->viewData['getAutoSend'] = $getAutoSend;
            $this->viewData['ifchecked'] = count($ifchecked);
            $this->viewData['auto_send_finish'] = $auto_send_finish;
            $this->viewData['owner_scout_pr_text_data'] = $owner_scout_pr_text_data;
            $this->viewData['default_scout_mails_per_day'] = $getOwner['default_scout_mails_per_day'];
            $this->load->view("owner/layout/layout_A", $this->viewData);
            HelperApp::remove_session('auto_send_finish');
        }else{
            redirect(base_url() . 'owner/login');
        }
    }
    public function auto_send_finish(){
        $owner_id = OwnerControl::getId();
        $data = array();
        $getOwner = $this->Mowner->getAutoSend($owner_id);
        for($x=0;$x<5;$x++){
            if(isset($_POST['switchfl'])){
                $switchfl = ($_POST['switchfl'] == 0 ? 1 : 0);
                $data = array('owner_id' => $owner_id, 'pick_num_order' => ($x+1), 'selected_flag' => 0, 'switch_flag' => $switchfl);
            }else{
                $data = array('owner_id' => $owner_id, 'area' => $_POST['selArea' . ($x+1)], 'status_target_1' => $_POST['selStatus' . ($x+1)],'template_target_1' => $_POST['selTemplate' . ($x+1)],'setnum_scout_mail' => $_POST['numSend' . ($x+1)], 'pick_num_order' => ($x+1), 'selected_flag' => 0);
            }
            if(count($getOwner) != 0){
                $pick_num_order = $x+1;
                $this->Mowner->updateAutoSend($owner_id, $data, $pick_num_order);
            }else{
                $this->Mowner->insertAutoSend($data);
            }
        }
        if(isset($_POST['ckautosend'])){
            $selected_flag = 2;
        }else{
            $selected_flag = 1;
        }
        for($x=0;$x<3;$x++){
            if(isset($_POST['switchfl'])){
                $switchfl = ($_POST['switchfl'] == 0 ? 1 : 0);
                $data = array('owner_id' => $owner_id, 'pick_num_order' => ($x+1), 'selected_flag' => $selected_flag, 'switch_flag' => $switchfl);
            }else{
                $data = array('owner_id' => $owner_id, 'status_target_2' => $_POST['selStatusCheck' . ($x+1)],'template_target_2' => $_POST['selTemplateCheck' . ($x+1)], 'pick_num_order' => ($x+1), 'selected_flag' => $selected_flag);
            }
            if(count($getOwner) != 0){
                $pick_num_order = $x+1;
                $this->Mowner->updateAutoSend($owner_id, $data, $pick_num_order, $selected_flag);
            }else{
                $this->Mowner->insertAutoSend($data);
            }
        }
        HelperApp::add_session('auto_send_finish', true);
        redirect(base_url() . "owner/scout/auto_send");
    }

    public function checkIfUserIsChecked() {
        $ret  = false;
        $user_id = $this->input->get('user_id');
        if ( isset($_SESSION['sRetainCheckrs']) ) {
            $s_checkers = HelperApp::get_session('sCheckrs');
            if ( count($s_checkers) > 0 ) {
              foreach  ($s_checkers as $key => $value ) {
                  if ( in_array($user_id, $value) ) {
                      $ret = true;
                      break;
                  }
              }
            }
        }
        echo json_encode($ret);
        die;
    }

    private function _insertOwnerScoutPrText($owner_id, $title, $pr_text, $pr_title) {
      $data = array(
        'owner_id' => $owner_id,
        'title' => $title,
        'pr_text' => $pr_text,
        'pr_title' => $pr_title,
        'created_date' => date("y-m-d H:i:s")
      );
      $scout_pr_id = $this->Mowner->insertOwnerScoutPrText($data);
      return $scout_pr_id;
    }
}

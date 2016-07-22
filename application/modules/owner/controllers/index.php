<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Index extends MX_Controller {

    private $data;

    public function __construct() {
        parent::__construct();
        $this->load->Model(array('owner/mowner','owner/muser','user/mcampaign_bonus_request', 'owner/Mownercampaingn'));
        $this->common = new Common();
        $this->data['module'] = $this->router->fetch_module();
        $this->form_validation->CI = & $this;
        HelperApp::start_session();
    }

    /**
     * @author  [IVS] Nguyen Bao Trieu
     * @name 	index
     * @todo 	show index for owner
     * @param 	null
     * @return 	null
    */
    public function index()
    {
        $this->load->model('user/mcampaign');
        $step_up_campaign_flag = true;
        //HelperGlobal::requireOwnerLogin();
        if ( !OwnerControl::LoggedIn() ){
            //ランディングページへ遷移
            $url = base_url() .'owner/top';
            redirect($url);
        }

        if(isset($_SESSION['sRetainCheckrs']))
        	HelperApp::remove_session('sRetainCheckrs');
        if (isset($_SESSION['sCheckrs']) && !isset($_SESSION['s_owner_index'])) {
        	HelperApp::remove_session('sCheckrs');
        }

        if(isset($_SESSION['sCheckrs']) && isset($_SESSION['s_owner_index'])) {
        	$s_checkers = HelperApp::get_session('sCheckrs');
        	if(count($s_checkers) > 0) {
        		foreach ($s_checkers as $key => $value) {
        			foreach ($value as $vl) {
        				$arrId[] = $vl;
        			}
        		}
        		$this->data['sRetainCheckrs'] = $arrId;
        	}
        	HelperApp::remove_session('s_owner_index');
        }

        if ( $step_up_campaign_flag ) {
            $this->data['step_up_campaign_flag'] = true;
        }

        $todayRegisteredUser = $this->muser->countRegisteredUser(date('Ymd'));
        $yesterdayRegisteredUser = $this->muser->countRegisteredUser(date('Ymd', strtotime(date("Y-m-d")."-1 days")));
        HelperGlobal::checkScreen(current_url());
        $owner_id = OwnerControl::getId();
        $ors_id = $this->mowner->getOwnerRecruitId($owner_id);
        $appMoney = $this->muser->getApplyMoney($owner_id);
        $userApply = $this->muser->getUserApply($owner_id);
        $travelExpenseRequest = $this->muser->getUserTrvlExpRequest($owner_id);
        $masterCampaignRequest = $this->mcampaign_bonus_request->getRequestMasterCampaign($owner_id);
        $countUser = $this->muser->countAllUsersApply($owner_id);
        $newUser = $this->muser->getNewUser($owner_id, '', $this->mowner->getOwnerHiddenUsers($owner_id));
        $news = $this->mowner->getOwnerNews();
        $owner = $this->mowner->getOwner($owner_id);
        $totalUserNo = $this->muser->getTotalUserNo();
        $campaign_ads = $this->mowner->getMonthlyCampaignResultAds();
        $lastWeekNewUserNo = $this->muser->getLstWeekNewUserNo();
        $strtotalUserNo = $this->getTotalNumber($totalUserNo);
        $strTotalTravelExpense = $this->getTotalNumber((isset($campaign_ads['travel_expense_total_paid_money']))?$campaign_ads['travel_expense_total_paid_money']:0);
        $strTotalTrialWorkExpense = $this->getTotalNumber((isset($campaign_ads['trial_work_total_paid_money']))?$campaign_ads['trial_work_total_paid_money']:0);
        $getOwnerDisplayCampaign = $this->Mownercampaingn->getNewOwnerCampaingn(5);
        $this->data['getOwnerDisplayCampaign'] = $getOwnerDisplayCampaign;
        $this->data['interviewreport'] = $this->mcampaign->getInterviewReport(1);
        $this->data['totalTravelExpense'] = $strTotalTravelExpense;
        $this->data['totalTrialWorkExpense'] = $strTotalTrialWorkExpense;
        $this->data['campaignMonth'] = isset($campaign_ads['month'])?$campaign_ads['month']:'';
        $this->data['todayRegisteredUser'] = $todayRegisteredUser;
        $this->data['yesterdayRegisteredUser'] = $yesterdayRegisteredUser;
        $this->data['totalUserNo'] = $strtotalUserNo;
        $this->data['lastWeekNewUserNo'] = $lastWeekNewUserNo;
        $this->data['appMoney'] = $appMoney;
        $this->data['userApply'] = $userApply;
        $this->data['travelExpenseRequest'] = $travelExpenseRequest;
        $this->data['masterCampaignRequest'] = $masterCampaignRequest;
        $this->data['countUser'] = $countUser;
        $this->data['newUser'] = $newUser;
        $this->data['news'] = $news;
        $this->data['owner'] = $owner;
        $this->data['title'] = 'joyspe｜TOPページ';
        $this->data['loadPage'] = 'index/index';
        if ((isset($owner['kame_login_id']) && isset($owner['kame_password'])) && ($owner['kame_login_id'] && $owner['kame_password'])) {
            HelperApp::add_session('kame_credentials',true);
            HelperApp::add_session('kame_login',$owner['kame_login_id']);
            HelperApp::add_session('kame_password',$owner['kame_password']);
        }
        $this->load->view($this->data['module'].'/layout/layout_A',$this->data);
    }

    /**
     * @author  [IVS] Nguyen Van Phong
     * @name 	index03
     * @todo 	show owner recruits will was errored
     * @param 	int $page
     * @return 	null
    */
    public function index03($page = 1) {
        HelperGlobal::requireOwnerLogin();
        $page = $page > 1 ? $page : 1;
        $ppp = $this->config->item('per_page');
        $data = $this->Mowner->getOwnerNotPayUserHappyMoney(OwnerControl::getId(),array(), $page, $ppp);
        $total = $this->Mowner->countOwnerNotPayUserHappyMoney(OwnerControl::getId());

        $totalpage = 1;
        if($ppp != 0)
        {
            $totalpage = ceil($total/$ppp);
        }
        $this->data['totalpage'] = $totalpage;

        $this->data['paging'] = HelperApp::get_paging($ppp, base_url() . "owner/index/index03", $total, $page);

        $this->data['data'] = $data;
        $this->data['loadPage'] = 'index/index03';
        $this->data['imagePath'] = base_url() . "/public/owner/";
        $this->data['title'] = 'joyspe｜勤務確認依頼（お祝い申請）７日間経過';
        $this->load->view($this->data['module'].'/layout/layout_F',$this->data);
    }

    public function list_of_users() {
      $s_checkers = HelperApp::get_session('sCheckrs');
      $arrId = array();
      if(count($s_checkers) > 0) {
    	foreach ($s_checkers as $key => $value) {
    	  foreach ($value as $vl) {
    		$arrId[] = $vl;
    	  }
    	}
    	$this->data['sRetainCheckrs'] = $arrId;
      }
      $owner_id = OwnerControl::getId();
      $owner = $this->mowner->getOwner($owner_id);
      $sort_type = $this->input->post('sort_type');

      $newUser = $this->muser->getNewUser($owner_id, $sort_type, $this->mowner->getOwnerHiddenUsers($owner_id));
      $this->data['owner'] = $owner;
      $this->data['newUser'] = $newUser;
      $this->data['function_name'] = $this->input->post('function_name');
      $this->load->view("owner/index/list_of_users", $this->data);
    }

    public function remove_user_scout() {
      $this->mowner->insertOwnerHiddenUser(array('owner_id' => OwnerControl::getId(), 'user_id' => $this->input->post('id')));
      exit;
    }

    public function count_owner_hidden_users() {
      $this->output->set_content_type('application/json');
	  $cntOwnerHiddenUsers = $this->mowner->countOwnerHiddenUsers(OwnerControl::getId());
	  echo json_encode($cntOwnerHiddenUsers);
	  exit;
    }

   	public function list_of_hide_users() {
   	  $owner_id = OwnerControl::getId();
  	  $newUser = $this->muser->getListOfHideUsers($owner_id, $this->mowner->getOwnerHiddenUsers($owner_id));
  	  $this->data['owner_id'] = $owner_id;
	  $this->data['newUser'] = $newUser;
	  $this->load->view("owner/index/list_of_hide_users", $this->data);
   	}

   	public function show_scout_user() {
   	  $owner_id = OwnerControl::getId();
   	  $this->output->set_content_type('application/json');
   	  $this->mowner->deleteOwnerHiddenUser($owner_id, $this->input->post('id'));
   	  $cntOwnerHiddenUsers = $this->mowner->countOwnerHiddenUsers($owner_id);
   	  echo json_encode($cntOwnerHiddenUsers);
   	  exit;
   	}

    public function responseToUserExpenseRequest() {
        $ret = false;
        $this->load->Model('user/MTravel_expense');
        if ( $this->input->post() ) {
            $status = $this->input->post('approval_val');
            $request_id = $this->input->post('id');
            if ( $request_id && ( $status == 1 || $status == 2 ) ) { // 念のため、データ確認
                $data = array('status' => $status,
                              'updated_date' => date('Y-m-d H:i:s'));
                $update = $this->MTravel_expense->updateTravelExpense( $data, $request_id );
                if($update) {
                    $ret = true;
                } else {
                    $ret = false;
                }
            }
        }

        echo json_encode( $ret );
        exit;
    }

    public function responseToUserBunosRequest() {
        $ret = false;
        $owner_id = OwnerControl::getId();
        if ( $this->input->post() ) {
            $status = $this->input->post('reqapproval_val');
            $request_id = $this->input->post('id');
            if ( $request_id && ( $status == 1 || $status == 2 ) ) {
                $data = array('status' => $status,
                              'updated_date' => date('Y-m-d H:i:s'));
                $update = $this->mcampaign_bonus_request->updateBonusRequest( $data, $request_id, $owner_id);
                if($update) {
                    $ret = true;
                } else {
                    $ret = false;
                }
            }
        }

        echo json_encode( $ret );
        exit;
    }
  
    private function getTotalNumber($totals) {
        $strtotalUserNo = 0;
        if ( $totals < 10000 ) {
            $strtotalUserNo = $totals;
        } else {
            $ten_thousands = (int)($totals/10000);
            $below_ten_thousands = $totals - (10000*$ten_thousands);
            if ( $below_ten_thousands == 0){
                $strtotalUserNo = $ten_thousands."万";
            }else{
                $strtotalUserNo = $ten_thousands."万".$below_ten_thousands;
            }
        }
        return $strtotalUserNo;
    }
}

?>

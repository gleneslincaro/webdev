<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Campaign extends MX_Controller{
    protected $_data;
    private   $common;
    public function __construct() {
      parent::__construct();
      AdminControl::CheckLogin();
      $this->_data["module"] = $this->router->fetch_module();
      $this->form_validation->CI =& $this;
      $this->common = new Common();
      $this->output->set_header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
      $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate");
      $this->output->set_header("Cache-Control: post-check=0, pre-check=0");
      $this->output->set_header("Pragma: no-cache");
      // モデルロード
      $this->load->Model("user/Musers");
      $this->load->Model("user/Mcampaign");
      $this->load->Model("user/Mtravel_expense");
      $this->load->Model("user/Mcampaign_bonus_request");
      $this->load->Model("owner/Mownercampaingn");
    }

    // リクエスト一覧表示
    public function index() {
      $expense_pay_requests = null;

      // リクエストリスト取得
      $filter_status = $this->input->get('filter_status');

      // Pagination
      $total_number             = $this->Mtravel_expense->getAllRequestNo( $filter_status );
      $config['base_url']       = base_url('index.php/admin/campaign/index');
      $config['total_rows']     = $total_number;
      $config['constant_num_links'] = TRUE;
      $config['uri_segment']    = 4;
      $config["per_page"]       = $req_per_page = $this->config->item('per_page');
      // GET データ保存
      if ( $filter_status ){
        $config['suffix'] = '?filter_status=' . (int)$filter_status;
        $config['first_url'] = $config['base_url'] . '?filter_status=' . (int)$filter_status;
      }
      $this->pagination->initialize($config);

      $start_offset = intval($this->uri->segment(4));
      if ($start_offset == NULL) {
          $start_offset = 0;
      }
      $expense_pay_requests = $this->Mtravel_expense->getAllRequest($req_per_page, $start_offset, $filter_status);

      $this->_data["loadPage"]  = "campaign/index";
      $this->_data["titlePage"] = "交通費申請一覧";
      $this->_data['expense_pay_requests'] = $expense_pay_requests;
      $this->load->view($this->_data["module"]."/layout/layout", $this->_data);
    }

    // 承認・不承認を行う
    public function approveExpenseRequest() {
      $approve_flag = false;
      $request_id    = $this->input->post('reqid');
      $update_status = $this->input->post('updatestatus');
      $user_id       = $this->input->post('userid');
      $owner_id       = $this->input->post('owner_id');
      // 念のため、パラメータチェック
      if ( $update_status != 3 && $update_status != 4 ) {
          echo json_encode( $approve_flag );
      }

      if ( $request_id && $update_status ) {
        $data = array(
          'status' => $update_status,
          'approved_date' => date('Y-m-d H:i:s')
        );
        $approve_flag = $this->Mtravel_expense->updateTravelExpense($data, $request_id);
        if ( $approve_flag == true && $update_status == 3 && $user_id) {
            // ポイント付与
            $campaign_id    = $this->Mtravel_expense->getCampaignIdFrmReqId( $request_id );
            $campaign_money = $this->Mcampaign->getCampaignMoney( $campaign_id, $owner_id );
            $add_point_flag = $this->Musers->updateBonusPoint($user_id, $campaign_money, BONUS_REASON_INTERVIEW, $owner_id);
            if ( $add_point_flag ) {
              // 面接交通費支給通知メールをユーザーに送る
              $this->common->sendNotifToUserExpenseApproval( $user_id );
            }
        }
      }
      echo json_encode( $approve_flag );
    }

    // キャンペーン作成
    public function create() {
      $this->_data["loadPage"]  = "campaign/create";
      $this->_data["titlePage"] = "面接交通費支援キャンペーン作成";
      if ( $this->input->post() ) {
        $this->form_validation->set_rules('travel_expense', '金額', 'trim|required|max_length[20]|greater_than[0]');
        $this->form_validation->set_rules('budget_money', '予算', 'trim|required|max_length[20]|greater_than[0]');
        $this->form_validation->set_rules('start_date', '開始日', 'trim|required');
        $this->form_validation->set_rules('end_date', '終了日', 'trim|required');
        $this->form_validation->set_rules('max_request_times', '申請上限回数','trim|required|greater_than[0]');
        $this->form_validation->set_rules('multi_request_per_owner_flag', 'ユーザが複数店舗に申請可能','trim');
        $banner_photo = '';
        $path = $this->config->item('upload_userdir').'banner/travel_expense/';
        $default_banner_photo = '/public/user/image/default_trvl_expen_campn_banner.jpg';
        if (!is_dir($path)) {
          mkdir($path, 0777, true);
        }
        $config['upload_path'] = $path;
        $config['allowed_types'] = 'jpeg|jpg|png';
        $config['max_size'] = 4096;
        $config['overwrite'] = true;
        $this->load->library('upload', $config);
        if ( $this->form_validation->run() ) {
          //start of upload new banner pic
          if (!$this->upload->do_upload_user("banner_pic_file")) {
              $banner_photo = $default_banner_photo;
          } else {
              $config = array();
              $temp_photo = '';
              $option_banner = $this->input->post('option_default_banner');
              if ($option_banner == 1) {
                  $temp_photo = $path.$_FILES['banner_pic_file']["name"];
                  $banner_photo = $default_banner_photo;
              } else {
                  $banner_photo = $path.$_FILES['banner_pic_file']["name"];
              }
              $config['image_library'] = 'gd2';
              $config['source_image'] = ($option_banner==1)?$temp_photo : $banner_photo;
              $config['maintain_ratio'] = FALSE;
              $config['width'] = ($option_banner==1)?1:620;
              $config['height'] = ($option_banner==1)?1:100;
              $this->load->library('image_lib', $config);
              $this->image_lib->resize();
              if ($option_banner == 1) {
                  unlink($temp_photo);
              }
          }
          //end of upload new banner pic

          // データ作成
          $travel_expense = $this->input->post("travel_expense");
          $budget_money   = $this->input->post("budget_money");
          $start_date     = $this->input->post("start_date");
          $end_date       = $this->input->post("end_date");
          $banner_path    = $banner_photo;
          $max_request_times    = $this->input->post("max_request_times");
          $banner_filename= $this->input->post('banner_name');
          $multi_request_per_owner_flag = false;
          if ( $this->input->post('multi_request_per_owner_flag') ) {
            $multi_request_per_owner_flag = true;
          }
          // 開始日時と終了日時は日時間と日終了時間に時間を調整する
          $start_date_obj = new DateTime($start_date);
          $start_date = $start_date_obj->format ('Y-m-d 00:00:01');
          $end_date_obj = new DateTime($end_date);
          $end_date = $end_date_obj->format ('Y-m-d 23:59:59');
          $create_data = array(
            "travel_expense"  => $travel_expense,
            "budget_money"    => $budget_money,
            "start_date"      => $start_date,
            "end_date"        => $end_date,
            "banner_path"     => $banner_path,
            "max_request_times" => $max_request_times,
            "multi_request_per_owner_flag" => $multi_request_per_owner_flag,
            "created_date"    => date('Y-m-d H:i:s')
          );
          $create_flag = $this->MCampaign->createNewCampaign( $create_data );
          if ( $create_flag ) {
            $create_message = "キャンペーンの作成が完了しました。";
          } else {
            $create_message = "キャンペーンの作成が失敗しました。";
          }
          $this->session->set_flashdata('create_message', $create_message );
          redirect(current_url());
        }

      }
      $this->load->view($this->_data["module"]."/layout/layout", $this->_data);
    }

    // キャンペーン一覧
    public function all() {
      // Pagination
      $total_number             = $this->MCampaign->getAllCampaignNo();
      $config['base_url']       = base_url('/admin/campaign/all');
      $config['total_rows']     = $total_number;
      $config['constant_num_links'] = TRUE;
      $config['uri_segment']    = 4;
      $config["per_page"]       = $req_per_page = $this->config->item('per_page');
      $this->pagination->initialize($config);

      $start_offset = intval($this->uri->segment(4));
      if ($start_offset == NULL) {
        $start_offset = 0;
      }
      $campaigns = $this->MCampaign->getAllCampaign( $req_per_page, $start_offset );

      $this->_data["campaigns"]  = $campaigns;
      $this->_data["titlePage"] = "面接交通費支援キャンペーン一覧";
      $this->_data["loadPage"]  = "campaign/all";
      $this->load->view($this->_data["module"]."/layout/layout", $this->_data);
    }

    // キャンペーンを終了させる
    public function stopCampaign() {
      $stop_flag = false;

      $campaign_id = (int)$this->input->post('campaign_id');
      if ( $campaign_id ) {
        $update_data = array (
          'display_flag' => 0,
          'updated_date' => date('Y-m-d H:i:s')
        );
        $stop_flag = $this->Mcampaign->updateCampaignData( $campaign_id, $update_data );
      }

      echo json_encode( $stop_flag );
    }

    public function makiacampaignlist($id = false, $step = false, $inOut = false){
      if($id && $inOut){
        $this->_data["listUser"] = $this->MCampaign->getmakiaUserCampaign($id, $step, $inOut);
      }else{
        $makiaCampaign = $this->MCampaign->getMakiaCampaignid();
        $config['base_url'] = base_url('/admin/campaign/all');
        $this->_data["makiaCampaign"]  = $makiaCampaign;
      }
      if ( $this->input->post() ) {
        $data = array();
        $campaign_id = $this->input->post("makiaCampaignId");
        if($campaign_id){
          $list = $this->MCampaign->getmakiaCampaignProgress($campaign_id, 1);
          $this->_data["list"] = $list;
          $this->_data["campaign_id"] = $campaign_id;
        }
      }
      $this->_data["loadPage"]  = "campaign/makiacampaignlist";
      $this->_data["titlePage"] = "キャンペーン管理ページ ";
      $this->load->view($this->_data["module"]."/layout/layout", $this->_data);
    }
    public function makiacampaigncreate($editid = false){
      if ($editid) {
        $mcampaign = $this->Mcampaign->getMakiaCampaignid($editid);
        $this->_data["editId"] = $editid;
        if ($this->input->post("edit") == false) {
           $this->_data["mcampaign"] = $mcampaign;
        }
        $this->_data["new_campaign_flag"] = $mcampaign[0]['new_campaign_flag'];
      }
      $this->_data["loadPage"]  = "campaign/makiacampaigncreate";
      $this->_data["titlePage"] = "作成";
      $max_user_display_flg = 0;
      if ( $this->input->post() ) {
        $flag = ($editid == false ? $this->input->post("new_campaign_flag") : $mcampaign[0]['new_campaign_flag']);
        $this->_data["new_campaign_flag"] = $flag;
        $max_user_display_flg = ($this->input->post("max_user_display_flg") != ''? 1: 0);
        $this->form_validation->set_rules('name', 'キャンペーン名', 'trim|required');
        $this->form_validation->set_rules('budget_money', '予算', 'trim|required|max_length[20]|greater_than[0]');
        $this->form_validation->set_rules('max_user_no', '上限人数', 'trim|required|max_length[20]|greater_than[0]');
        $this->form_validation->set_rules('scout_bonus_mag_times', 'スカウトメールボーナス', 'trim|required|max_length[20]|greater_than[0]');
        if($flag == 1){
          $this->form_validation->set_rules('campaign1_valid_days', '期日1', 'trim|required');
        }elseif($flag == 0){
          $this->form_validation->set_rules('start_date', '期日1開始日', 'trim|required');
          $this->form_validation->set_rules('end_date', '期日1終了日', 'trim|required');
        }
        $this->form_validation->set_rules('campaign_retry_days', '期日2', 'trim|required|max_length[20]|greater_than[0]');
        $this->form_validation->set_rules('more_info', 'キャンペーン2補足文  ', '');
        $this->form_validation->set_rules('msg_bonus_mag_times', 'お問い合わせボーナス', 'trim|required|max_length[20]|greater_than[0]');
        $this->form_validation->set_rules('login_bonus_mag_times', '累計ログインボーナス', 'trim|required|max_length[20]|greater_than[0]');
        $this->form_validation->set_rules('page_access_bonus_mag_times', 'ページアクセスボーナス', 'trim|required|max_length[20]|greater_than[0]');
        $this->form_validation->set_rules('interview_bonus_mag_times', '面接ボーナス  ', 'trim|required|max_length[20]|greater_than[0]');
        $this->form_validation->set_rules('max_interview_bonus_times', '複数店舗へ面接  ', 'trim|required|max_length[20]|greater_than[0]');
        if ( $this->form_validation->run() ) {
          $name = $this->input->post("name");
          $budget_money = $this->input->post("budget_money");
          $max_user_no = $this->input->post("max_user_no");
          $scout_bonus_mag_times = $this->input->post("scout_bonus_mag_times");
          $campaign_retry_days = $this->input->post("campaign_retry_days");
          $more_info = $this->input->post("more_info");
          $msg_bonus_mag_times = $this->input->post("msg_bonus_mag_times");
          $login_bonus_mag_times = $this->input->post("login_bonus_mag_times");
          $page_access_bonus_mag_times = $this->input->post("page_access_bonus_mag_times");
          $interview_bonus_mag_times = $this->input->post("interview_bonus_mag_times");
          $max_interview_bonus_times = $this->input->post("max_interview_bonus_times");
          $create_data = array(
              "new_campaign_flag"             => $flag,
              "name"                          => $name,
              "budget_money"                  => $budget_money,
              "max_user_no"                   => $max_user_no,
              "max_user_display_flg"          => $max_user_display_flg,
              "more_info"                     => $more_info,
              "scout_bonus_mag_times"         => $scout_bonus_mag_times,
              "campaign_retry_days"           => $campaign_retry_days,
              "msg_bonus_mag_times"           => $msg_bonus_mag_times,
              "login_bonus_mag_times"         => $login_bonus_mag_times,
              "page_access_bonus_mag_times"   => $page_access_bonus_mag_times,
              "interview_bonus_mag_times"     => $interview_bonus_mag_times,
              "max_interview_bonus_times"     => $max_interview_bonus_times
            );
          if($flag == 1){
            $campaign1_valid_days = $this->input->post("campaign1_valid_days");
            $arrnewexist = array(
              "campaign1_valid_days"          => $campaign1_valid_days
            );
          }elseif($flag == 0){
            $start_date = $this->input->post("start_date");
            $end_date = $this->input->post("end_date");
            $arrnewexist = array(
              "campaign2_start_date"          => $start_date,
              "campaign2_end_date"            => $end_date
            );
          }
          $create_flag = false;
          $data = array_merge($create_data,$arrnewexist);
          if ($editid == false) {
            $create_date = array(
              "created_date"                  => date('Y-m-d H:i:s')
            );
            $data = array_merge($data,$create_date);
            $create_flag = $this->MCampaign->makiacampaigncreate($data);
            $this->Mcampaign->updateFlagCampaignProgress($campaign_id, array('display_flag' => 0)) ;
          } else {
            $create_flag = $this->MCampaign->updateMakiaCampaignData( $editid, $data );
          }

          if ( $create_flag ) {
            $create_message = "キャンペーンの作成が完了しました。";
          } else {
            $create_message = "キャンペーンの作成が失敗しました。";
          }
          $this->session->set_flashdata('create_message', $create_message );
          if ($editid == false) {
            redirect(current_url());
          }else{
            redirect(base_url() . 'admin/campaign/makiacampaignall');
          }
        }
      }
      $this->_data["edit"] = $editid;
      $this->_data["max_user_display_flg"] = $max_user_display_flg;
      $this->load->view($this->_data["module"]."/layout/layout", $this->_data);
    }

    public function makiacampaignall(){
      $this->_data["loadPage"]  = "campaign/makiacampaignall";
      $this->_data["titlePage"] = "一覧";
      $max_user_display_flg = 0;
      $flag = null;
      if ( $this->input->post() ) {
        $flag = $this->input->post("flag");
        if ($flag == 1 || $flag == 0){
          $this->_data["flag"] = $flag;
        }

      }
      $this->_data["campaigns"] = $this->MCampaign->getMakiaCampaignfl($flag);
      $this->load->view($this->_data["module"]."/layout/layout", $this->_data);
    }

    public function makiastopCampaign(){
      $stop_flag = false;
      $campaign_id = (int)$this->input->post('campaign_id');
      if ( $campaign_id ) {
        $update_data = array (
          'display_flag' => 0,
          'updated_date' => date('Y-m-d H:i:s')
        );
        $stop_flag = $this->Mcampaign->updateMakiaCampaignData( $campaign_id, $update_data );
      }

      echo json_encode( $stop_flag );
    }

    public function makiarequest(){
        $this->_data["loadPage"] = "campaign/makiarequest";
        $this->_data["titlePage"] = "一覧";
        $users = $this->MCampaign->getStepUpCampaignProgressFinish();
        $data = $this->makiaUserTotalMoney($users);
        $this->_data["data"] = $data;
        $this->load->view($this->_data["module"]."/layout/layout", $this->_data);
    }

    public function approveMakiaRequest(){
        $approve_flag = false;
        $overbudgetMaxUser = false;
        $request_id = $this->input->post('reqid');
        $update_status = $this->input->post('updatestatus');
        $user_id = $this->input->post('userid');
        $total = $this->input->post('total');
        if (!$request_id || !$update_status || !$user_id || !$total) {
            echo json_encode( array('approve_flag' => false));
            exit;
        }
        $users = $this->MCampaign->getStepUpCampaignProgressFinish();
        $userTotalMoney = $this->makiaUserTotalMoney($users);
        $alltotal = 0;
        $budget_money = 0;
        $count = 0;
        foreach ($userTotalMoney as $key) {
            if ($key['step_up_campaign_id'] == $request_id) {
                $budget_money = $key['budget_money'];
                $max_user_no = $key['max_user_no'];
                if ($max_user_no <= $count) {
                  $overbudgetMaxUser = true;
                  break;
                }
                $count++;
                if ($key['request_money_flag'] == 2) {
                  $alltotal = $alltotal + $key['total_money'];
                }
            }
        }
        $data = array(
            'request_money_flag' => $update_status,
            'finish_flag' => 1
        );
        if ($budget_money < $alltotal + $total) {
            $overbudgetMaxUser = true;
        }

        if ($overbudgetMaxUser == false) {
            $approve_flag = $this->MCampaign->updateCampaignProgress($data, $request_id, $user_id);
            if ($update_status == 2 && $approve_flag == true) {
                $this->Musers->updateBonusPoint($user_id, $total, BONUS_REASON_STEP_UP_CAMPAIGN);
            }
        }
        echo json_encode( array('approve_flag' => $approve_flag, 'update_status' => $update_status, 'overbudgetMaxUser' => $overbudgetMaxUser) );
    }

    public function makiaUserTotalMoney($users) {
        $data = array();
        foreach ($users as $key) {
            $userId = $key['user_id'];
            $stepUpNewCampProg = $this->Musers->getNewStepUpCampaignProgress($userId, $key['step_up_campaign_id']);
            $scoutMailBonus = $this->Musers->getCampaignBonus($userId, BONUS_REASON_OPEN_SCOUT_MAIL, $stepUpNewCampProg['campaign_join_date']);
            $inquiryBonus = $this->Musers->getCampaignBonus($userId, BONUS_REASON_FIRST_MSG, $stepUpNewCampProg['campaign_join_date']);
            $loginBonus = $this->Musers->getCampaignBonus($userId, BONUS_REASON_LOGIN, $stepUpNewCampProg['campaign_join_date']);
            $pageAccessBonus = $this->Musers->getCampaignBonus($userId, BONUS_REASON_PAGE_ACCESS, $stepUpNewCampProg['campaign_join_date']);
            $interviewBonus = $this->Musers->getCampaignBonus($userId, BONUS_REASON_INTERVIEW, $stepUpNewCampProg['campaign_join_date']);
            $stepUpNewCamp = $this->Musers->getNewStepUpCampaign($stepUpNewCampProg['step_up_campaign_id']);
            $totalPoint = ($scoutMailBonus * $stepUpNewCamp['scout_bonus_mag_times']) + ($inquiryBonus * $stepUpNewCamp['msg_bonus_mag_times']);
            $totalPoint += ($loginBonus * $stepUpNewCamp['login_bonus_mag_times']) + ($pageAccessBonus * $stepUpNewCamp['page_access_bonus_mag_times']);
            $totalPoint += ($interviewBonus * $stepUpNewCamp['interview_bonus_mag_times']) - 1 * $interviewBonus;
            $noOfInterview = ($stepUpNewCampProg['no_of_interviews'] > 0)?$stepUpNewCampProg['no_of_interviews']:1;
            $grandTotalPoint = $totalPoint * $noOfInterview;
            $data[] = array('user_id' => $userId,
                            'unique_id' => $key['unique_id'],
                            'step_up_campaign_id' => $key['step_up_campaign_id'],
                            'money' => $totalPoint,
                            'no_of_interviews' => $key['no_of_interviews'],
                            'total_money' => $grandTotalPoint,
                            'request_money_date' => $key['request_money_date'],
                            'request_money_flag' => $key['request_money_flag'],
                            'budget_money' => $key['budget_money'],
                            'max_user_no' => $key['max_user_no']
                );
        }
        return $data;
    }
    public function bonusRequestStatus() {
        $expense_pay_requests = null;

        // リクエストリスト取得
        $filter_status = $this->input->get('filter_status');

        // Pagination
        $total_number             = $this->Mcampaign_bonus_request->getAllRequestNo( $filter_status );
        $config['base_url']       = base_url('admin/campaign/bonusRequestStatus');
        $config['total_rows']     = $total_number;
        $config['constant_num_links'] = TRUE;
        $config['uri_segment']    = 4;
        $config["per_page"]       = $req_per_page = $this->config->item('per_page');
        // GET データ保存
        if ( $filter_status ){
        $config['suffix'] = '?filter_status=' . (int)$filter_status;
        $config['first_url'] = $config['base_url'] . '?filter_status=' . (int)$filter_status;
        }
        $this->pagination->initialize($config);

        $start_offset = intval($this->uri->segment(4));
        if ($start_offset == NULL) {
            $start_offset = 0;
        }
        $expense_pay_requests = $this->Mcampaign_bonus_request->getAllRequest($req_per_page, $start_offset, $filter_status);

        $this->_data["loadPage"]  = "campaign/bonusrequeststatus";
        $this->_data["titlePage"] = "体験入店お祝い金申請一覧";
        $this->_data['expense_pay_requests'] = $expense_pay_requests;
        $this->load->view($this->_data["module"]."/layout/layout", $this->_data);
    }

    public function approveBonusRequest() {
        $approve_flag = false;
        $request_id    = $this->input->post('reqid');
        $update_status = $this->input->post('updatestatus');
        $user_id       = $this->input->post('userid');
        if ( $update_status != 3 && $update_status != 4 ) {
          echo json_encode( $approve_flag );
        }

        if ( $request_id && $update_status ) {
        $data = array(
          'status' => $update_status,
          'approved_date' => date('Y-m-d H:i:s')
        );

        $approve_flag = $this->Mcampaign_bonus_request->updateBonusRequest($data, $request_id);
        if ( $approve_flag == true && $update_status == 3 && $user_id) {
            $campaign_id    = $this->Mcampaign_bonus_request->getCampaignIdFrmReqId( $request_id );
            #check if the the owner has trial work bonus point
            $ownerTrialWorkMoney = $this->Mcampaign->getOwnerTrialWorkPointById($request_id);
            if ($ownerTrialWorkMoney > 0 ) {
                $campaign_money = $ownerTrialWorkMoney;
            } else {
                $campaign_money = $this->Mcampaign->getMstCampaignMoney( $campaign_id );  
            }
            $add_point_flag = $this->Musers->updateBonusPoint($user_id, $campaign_money, BONUS_REASON_TRIAL_WORK);
            if ( $add_point_flag ) {
                $this->common->sendNotifToUserCampaignApproval( $user_id );
            }
        }
        if ( $approve_flag == true && $update_status == 4 && $user_id) {
            $this->common->sendNotifToUserCampaignDisapproval( $user_id );
        }

      }

      echo json_encode( $approve_flag );
    }

    public function bonusrequestcreate() {
        $this->_data["loadPage"]  = "campaign/bonusrequestcreate";
        $this->_data["titlePage"] = "体験入店お祝い金キャンペーン作成";
        $imgPath = "public/user/uploads/";

        if ( $this->input->post() ) {
            $this->form_validation->set_rules('bonus_money', 'ボーナス金額', 'trim|required|max_length[20]|greater_than[0]');
            $this->form_validation->set_rules('budget_money', '予算', 'trim|required|max_length[20]|greater_than[0]');
            $this->form_validation->set_rules('start_date', '開始日', 'trim|required');
            $this->form_validation->set_rules('end_date', '終了日', 'trim|required');
            $this->form_validation->set_rules('max_request_times', '申請上限回数','trim|required|greater_than[0]');
            $this->form_validation->set_rules('multi_request_per_owner_flag', 'ユーザが複数店舗に申請可能','trim');
            if (empty($_FILES['banner_path']['name'])) {
                    $this->form_validation->set_rules('banner_path', 'デフォルトバナー','trim|required');
            }

            if ( $this->form_validation->run() ) {
                $bonus_money = $this->input->post("bonus_money");
                $budget_money   = $this->input->post("budget_money");
                $start_date     = $this->input->post("start_date");
                $end_date       = $this->input->post("end_date");
                $max_request_times    = $this->input->post("max_request_times");
                $multi_request_per_owner_flag = false;

                $i = 0;
                $possible_keys = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
                $keys_length = strlen($possible_keys);
                $flname = ""; //Let's declare the string, to add later.
                while($i<5) {
                    $rand = mt_rand(1,$keys_length-1);
                    $flname.= $possible_keys[$rand];
                    $i++;
                }

                $path = $this->config->item('upload_userdir');
                if (!is_dir($path)) {
                  mkdir($path, 0777, true);
                }

                $this->folderName = 'banner';
                if (!is_dir($path . $this->folderName)) {
                    mkdir($path . $this->folderName);
                }

                $config['file_name'] = $flname;
                $config['upload_path'] = $path . $this->folderName;
                $config['allowed_types'] = 'jpeg|jpg|png';
                $config['max_size'] = 4096;
                $config['overwrite'] = true;
                $this->load->library('upload', $config);
                if (!$this->upload->do_upload_user("banner_path")) {
                    $array = array('error' => substr($this->upload->display_errors(), 3,  strlen($this->upload->display_errors() ) - 7)) ;
                    echo json_encode($array);
                    die;
                }

                if ( $this->input->post('multi_request_per_owner_flag') ) {
                    $multi_request_per_owner_flag = true;
                }
                $fltype = $_FILES['banner_path']['name'];
                $ext = pathinfo($fltype, PATHINFO_EXTENSION);
                $start_date_obj = new DateTime($start_date);
                $start_date = $start_date_obj->format ('Y-m-d 00:00:01');
                $end_date_obj = new DateTime($end_date);
                $end_date = $end_date_obj->format ('Y-m-d 23:59:59');

                $create_data = array(
                    "bonus_money"  => $bonus_money,
                    "budget_money"    => $budget_money,
                    "start_date"      => $start_date,
                    "end_date"        => $end_date,
                    "banner_path"     => $imgPath . $this->folderName . '/' .  $flname . '.' . $ext,
                    "max_request_times" => $max_request_times,
                    "multi_request_per_owner_flag" => $multi_request_per_owner_flag,
                    "created_date"    => date('Y-m-d H:i:s')
                );
                $create_flag = $this->MCampaign->createMstCampaign( $create_data );
                if ( $create_flag ) {
                    $create_message = "キャンペーンの作成が完了しました。";
                } else {
                    $create_message = "キャンペーンの作成が失敗しました。";
                }
                $this->session->set_flashdata('create_message', $create_message );
                redirect(current_url());
            }
        }

      $this->load->view($this->_data["module"]."/layout/layout", $this->_data);
    }

    public function bonusrequestall() {
        // Pagination
        $total_number             = $this->MCampaign->getAllMstCampaignNo();
        $config['base_url']       = base_url('/admin/campaign/bonusrequestall');
        $config['total_rows']     = $total_number;
        $config['constant_num_links'] = TRUE;
        $config['uri_segment']    = 4;
        $config["per_page"]       = $req_per_page = $this->config->item('per_page');
        $this->pagination->initialize($config);

        $start_offset = intval($this->uri->segment(4));
        if ($start_offset == NULL) {
        $start_offset = 0;
        }
        $campaigns = $this->MCampaign->getAllMstCampaign( $req_per_page, $start_offset );

        $this->_data["campaigns"]  = $campaigns;
        $this->_data["titlePage"] = "体験入店お祝いキャンペーン";
        $this->_data["loadPage"]  = "campaign/bonusrequestall";
        $this->load->view($this->_data["module"]."/layout/layout", $this->_data);
    }

    public function stopmstCampaign() {
        $stop_flag = false;
        $campaign_id = (int)$this->input->post('campaign_id');
        if ( $campaign_id ) {
        $update_data = array (
          'display_flag' => 0,
          'updated_date' => date('Y-m-d H:i:s')
        );
        $stop_flag = $this->Mcampaign->updateCampaignBonusRequest( $campaign_id, $update_data );
        }
        echo json_encode( $stop_flag );
    }

    public function messagecampaignownerlist() {
        $this->_data["message_campaign"] = $message_campaign = $this->Mcampaign->getMessageCampaignOwnerList();
        $this->_data["count_owners"] = count($message_campaign);
        $this->_data["loadPage"]  = "campaign/messagecampaignownerlist";
        $this->_data["titlePage"] = "問い合わせキャンペーン店舗一覧";
        $this->load->view($this->_data["module"]."/layout/layout", $this->_data);
    }

    public function messagecampaignaddowner() {
        if ($this->input->post()) {
            if ($this->validatemessgecampaignowner()) {
                $data = array(
                    'area' => $this->input->post('area'),
                    'storename' => $this->input->post('storename'),
                    'url' => $this->input->post('url'),
                    'created_date' => date('Y-m-d H:i:s')
                );
                $has_inserted = $this->Mcampaign->messageCampaignAddOwner($data);
                if ($has_inserted) {
                    $this->_data['_message'] = '正常に店舗が追加されました。';
                }
            }
        }
        $this->_data["loadPage"]  = "campaign/messagecampaignaddowner";
        $this->_data["titlePage"] = "問い合わせキャンペーンに店舗追加";
        $this->load->view($this->_data["module"]."/layout/layout", $this->_data);
    }

    public function messagecampaigneditowner($id) {
        if ($this->input->post()) {
            if ($this->validatemessgecampaignowner()) {
                $data = array(
                    'area' => $this->input->post('area'),
                    'storename' => $this->input->post('storename'),
                    'url' => $this->input->post('url'),
                    'updated_date' => date('Y-m-d H:i:s')
                );
                $has_updated = $this->Mcampaign->messageCampaignUpdateOwner($data, $id);
                if ($has_updated) {
                    $this->_data['_message'] = '正常にキャンペーン店舗が更新されました。';
                }
            }
        } else {
            $this->_data["owner_data"]  = $this->Mcampaign->getMessageCampaignOwner($id);
        }
        $this->_data["loadPage"]  = "campaign/messagecampaignaddowner";
        $this->_data["titlePage"] = "問い合わせキャンペーン店舗修正";
        $this->load->view($this->_data["module"]."/layout/layout", $this->_data);
    }

    public function messagecampaigndeleteowner() {
        $id = $this->input->get('id');
        $has_deleted = $this->Mcampaign->messageCampaignDeleteOwner($id);
        echo json_encode($has_deleted);
    }

    private function validatemessgecampaignowner() {
        $ret = false;
        $this->form_validation->set_rules('area', 'エリア名', 'trim|required|max_length[50]');
        $this->form_validation->set_rules('storename', '店舗名', 'trim|required|max_length[100]');
        $this->form_validation->set_rules('url', '店舗名に対するＵＲＬ', 'trim|required|max_length[100]');
        if ($this->form_validation->run()) {
            $ret = true;
        }
        return $ret;
    }

    public function interviewreports() {
        $this->_data["titlePage"] = '面接報告';
        $this->_data["loadPage"] = 'campaign/interviewreport';
        $this->load->view($this->_data["module"]."/layout/layout", $this->_data);
    }

    public function insertInterviewReport() {
        $date_interview = trim($this->input->post('date_interview'));
        $unique_id = trim($this->input->post('unique_id'));
        if ($this->input->post()) {
            $this->form_validation->set_rules('date_interview', '面接日付', 'trim|required');
            $this->form_validation->set_rules('unique_id', 'ユニークＩＤ', 'trim|required');
            if ($this->form_validation->run()) {
                $this->Mcampaign->insertInterviewReport($date_interview,$unique_id);
                echo true;
            } else {
                echo false;
            }
        }

    }

    public function interviewreportlist() {
        $interview_reports = $this->Mcampaign->getInterviewReport();
        $this->_data["titlePage"] = '面接報告一覧';
        $this->_data["loadPage"] = 'campaign/interviewreportlist';
        $this->_data["reports"] = $interview_reports;
        $this->load->view($this->_data["module"]."/layout/layout", $this->_data);

    }

    public function changeStatusReport() {
        if ($this->input->post('hide_report')) {
            $id = $this->input->post('hide_report');
            echo $this->Mcampaign->changeStatusReport($id,0);
        } else {
            $id = $this->input->post('show_report');
            echo $this->Mcampaign->changeStatusReport($id,1);
        }
    }

    // create a campaign infor to display in owner page
    public function ownercampaingncreate(){
        $this->_data["titlePage"] = "キャンペーン作成";
        $this->_data["loadPage"]  = "campaign/ownercampaingncreate";
        if ( $this->input->post() ) {
            $this->form_validation->set_rules('campaign_name', 'キャンペーン名', 'trim|required');
            $this->form_validation->set_rules('start_date', '開始日', 'trim|required');
            $this->form_validation->set_rules('end_date', '終了日', 'trim|required');
            $this->form_validation->set_rules('link', 'リンク', 'trim|required');
            if ( $this->form_validation->run() ) {
                $campaign_name   = $this->input->post("campaign_name");
                $start_date   = $this->input->post("start_date");
                $end_date   = $this->input->post("end_date");
                $link   = $this->input->post("link");
                $status   = $this->input->post("status");
                $create_data = array(
                    "campaign_name"     => $campaign_name,
                    "period_start"      => $start_date,
                    "period_end"        => $end_date,
                    "link"              => $link,
                    "status"            => $status,
                    "created_date"      => date('Y-m-d H:i:s')
                );

                $create_flag = $this->Mownercampaingn->createNewOwnerCampaingn($create_data);
                if ( $create_flag ) {
                    $create_message = "キャンペーンの作成が完了しました。";
                } else {
                    $create_message = "キャンペーンの作成が失敗しました。";
                }

                $this->session->set_flashdata('create_message', $create_message );
                redirect(current_url());
            }
        }
        $this->load->view($this->_data["module"]."/layout/layout", $this->_data);
    }

    // all campaigns displayed in owner page
    public function ownercampaingnall(){
        if ($this->input->post()) {
            $post_delete = $this->input->post("delete");
            if ($post_delete) {
                $campaignId = $post_delete[0];
                $data = array('display_flag' => 0);
                $ret = $this->Mownercampaingn->editNewOwnerCampaingn($campaignId, $data);
                if ( $ret ) {
                    $retMsg = "キャンペーンの削除が完了しました。";
                } else {
                    $retMsg = "キャンペーンの削除が失敗しました。";
                }

                $this->session->set_flashdata('retMsg', $retMsg );
                redirect(current_url());
            }
        }
        $this->_data["titlePage"] = "キャンペーン一覧";
        $this->_data["loadPage"]  = "campaign/ownercampaingnall";
        $getOwnerDisplayCampaign = $this->Mownercampaingn->getNewOwnerCampaingn();
        $this->_data['getOwnerDisplayCampaign'] = $getOwnerDisplayCampaign;
        $this->load->view($this->_data["module"]."/layout/layout", $this->_data);
    }

    // edit campaign information
    public function ownercampaingnedit($id){
        $this->_data["titlePage"] = "キャンペーン編集";
        $this->_data["loadPage"]  = "campaign/ownercampaingnedit";
        if ( $this->input->post() ) {
            $this->form_validation->set_rules('campaign_name', 'キャンペーン名', 'trim|required');
            $this->form_validation->set_rules('start_date', '開始日', 'trim|required');
            $this->form_validation->set_rules('end_date', '終了日', 'trim|required');
            $this->form_validation->set_rules('link', 'リンク', 'trim|required');
            if ( $this->form_validation->run() ) {
                $campaign_name   = $this->input->post("campaign_name");
                $start_date   = $this->input->post("start_date");
                $end_date   = $this->input->post("end_date");
                $link   = $this->input->post("link");
                $status   = $this->input->post("status");

                $data = array(
                    "campaign_name"     => $campaign_name,
                    "period_start"      => $start_date,
                    "period_end"        => $end_date,
                    "link"              => $link,
                    "status"            => $status
                );

                $edit_flag = $this->Mownercampaingn->editNewOwnerCampaingn($id, $data);
                if ($edit_flag) {
                    $create_message = "キャンペーンの編集が完了しました。";
                } else {
                    $create_message = "キャンペーンの編集が失敗しました。";
                }
                $this->session->set_flashdata('create_message', $create_message );
                redirect(current_url());
            }
        } else {
            $getCampaign = $this->Mownercampaingn->getNewOwnerCampaingnId($id);
            $this->_data['getCampaign'] = $getCampaign;
        }

        $this->load->view($this->_data["module"]."/layout/layout", $this->_data);
    }
  }

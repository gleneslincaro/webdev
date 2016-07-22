<?php
class bonus extends MY_Controller
{
  private $viewdata= array();
  private $layout="user/layout/main";
  function __construct() {
    parent::__construct();
    $this->redirect_pc_site();
    $this->load->model("user/Mhappymoney");
    $this->load->model("user/Mstyleworking");
    $this->load->model("user/Mnewjob_model");
    $this->load->model("user/Musers");
    if ( $this->uri->segment(3) != "checkbonus" ){
      HelperGlobal::require_login(current_url());
    }
    $this->common = new Common();
    $this->load->library('user_agent');
    $this->viewdata['idheader'] = 1;
  }

  public function bonus_list(){
    $userId = UserControl::getId();
    $user_from_site = UserControl::getFromSiteStatus();
    $this->viewdata['total_smb'] = $this->Musers->countUserScoutMailBonus1($userId);
    $this->viewdata['limit'] = 5;
    $this->viewdata['userSMBData0'] = $this->Musers->getUserScoutMailBonus0($userId);
    $this->viewdata['userSMBData1'] = $this->Musers->getUserScoutMailBonus1($userId, 5);
    $logs_total_rows = $this->Musers->get_user_scout_mail_bonusCount($userId);
    $limit = 10;
    if ($this->uri->segment(4)) {
        $current_page = ($this->uri->segment(4)) ;
        $offset = ($current_page - 1) * $limit;
    } else {
        $current_page = 1;
        $offset = 0;
    }
    $get_all_bonus = $this->Musers->get_user_scout_mail_bonus($userId, $offset, $limit);
    $pagination = HelperApp::get_paging($limit, '/user/bonus/bonus_list/', $logs_total_rows, $current_page, 'bootstrap');
    $this->viewdata['pagination_links'] = $pagination;
    $data_user_bonus = array();
    $count = 0;
    foreach ($get_all_bonus as &$key) {
        $bonus_title = '';
        switch ($key['reason']) {
            case BONUS_REASON_OPEN_SCOUT_MAIL:
                $bonus_title = '受信メールボーナス';
                break;

            case BONUS_REASON_TRIAL_WORK:
                $bonus_title = '体験入店お祝金';
                break;

            case BONUS_REASON_INTERVIEW:
                $bonus_title = '面接交通費';
                break;

            case BONUS_REASON_STEP_UP_CAMPAIGN:
                $bonus_title = 'ステップアップボーナス';
                break;

            case BONUS_REASON_FIRST_MSG:
                $bonus_title = '初回問合せボーナス';
                break;

            case BONUS_REASON_LOGIN:
                $bonus_title = '累計ログインボーナス';
                break;

            default:
                $bonus_title = $key['reason'];
                break;
        }

        if ($bonus_title) {
            $data_user_bonus[$count] = $key;
            $data_user_bonus[$count]['bonus_title'] = $bonus_title;
            $count++;
        }

    }
    $this->viewdata['data_user_bonus'] = $data_user_bonus;
    $this->viewdata['class_ext'] = 'bonus_list';

    /* sp */
    if ($this->agent->is_mobile()) {
        if ( $user_from_site == 0 ) {
            $this->viewdata['load_page']="bonus/travel_expense";
        }
    /* pc */
    } else {
        $this->viewdata['total_users'] = HelperGlobal::getUserTotalNumber();
        $this->viewdata['total_owners'] = HelperGlobal::gettotalHeader();
        if ( $user_from_site == 0 ) {
            $this->viewdata['load_page']="pc/bonus/travel_expense";
            $this->layout = "user/pc/layout/main";
            $breadscrumb_array = array(array("class" => "", "text" => "現在の保有金額", "link"=>""));
            $this->viewdata['breadscrumb_array'] = $breadscrumb_array;
        }
    }
    if ( !$user_from_site == 0 ) { // マシェモバのユーザーかマキアのユーザー
        $this->viewdata['load_page']="bonus/bonus_list";
        $last_visited_date = UserControl::getLastVisitedDate();
        $this->common->updateLoginBonus($userId, $user_from_site, $last_visited_date);
    }
    $this->viewdata['load_css'] = "user/layout/bonus_list";
    $this->viewdata['titlePage'] = 'joyspe｜現在の保有金額';
    $this->load->view($this->layout, $this->viewdata);
  }

  public function bonus_application_history() {
    $this->output->set_content_type('application/json');
    $userId = UserControl::getId();
    $limit = $this->input->post('limit');
    $more_bah = $this->input->post('more_bah');
    if($more_bah) {
      $limit = $limit+5;
      $total_smb = $this->Musers->countUserScoutMailBonus1($userId);
      $userSMBData1 = $this->Musers->getUserScoutMailBonus1($userId, $limit);
      $data = array('total_smb' => $total_smb, 'limit' => $limit, 'data' => $userSMBData1);
      echo json_encode($data);
    }
  }
  /*
  * Action for a request of bonus money from user
  */
  public function requestBonus(){
    $ret = false;
    $userId = UserControl::getId();
    if ( $userId ){
      $ret = $this->Musers->requestBonus($userId);
    }

    /* sp */
    if ($this->agent->is_mobile()) {
       redirect(base_url()."user/bonus/bonus_list");
    /* pc */
    } else {
        //echo $ret;
        redirect(base_url()."user/bonus/bonus_list");
    }
  }
  /*
  * Login and display bonus list
  */
  public function checkbonus(){
    if(!$this->session->flashdata('flag')) {
      if($this->input->get('li') || $this->input->get('lk') || $this->input->get('frm')) {
        $this->load->Model("user/Musers");
        $loginId = $this->input->get('li');
        $pass = $this->input->get('lk');
        $frm = $this->input->get('frm');
        if ( $frm == 1 ){ //for machemoba
          $check_login = $this->Musers->checkRemoteLoginIdAndPassword($loginId, $pass);
          if ( $check_login ){
            $user_id = $this->Musers->getUserIDFromMd5ID($loginId);
            $this->session->set_flashdata('flag', true);
            $this->session->set_flashdata('userId', $user_id);
            redirect(base_url()."user/bonus/checkbonus");
          }
        }
      }
    }
    else {
      $userId = $this->session->flashdata('userId');
      HelperApp::add_session('id',$userId);
      $data = array(
        'last_visit_date' => date("y-m-d H:i:s"),
      );
      $this->Musers->update_User($data, $userId);
    }
    setcookie('over18_flag',1, time() + (10 * 365 * 24 * 60 * 60), "/");
    // redirect to bonus list
    redirect(base_url()."user/bonus/bonus_list");
  }
}
?>

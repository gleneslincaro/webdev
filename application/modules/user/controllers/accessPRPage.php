<?php
  class accessPRPage extends MY_Controller{
    private $viewData = array();
    private $common;
    private $validator;
    private $layout = 'user/layout/main';
    private $message = array('success' => true, 'error' => array());
    private $encrypt_id_pass_flg = true;
    public function __construct() {
      parent::__construct();
    $this->redirect_pc_site();
      $this->common = new Common();
      $this->validator = new FormValidator();
      $this->viewData['idheader'] = 2;
      $this->viewData['div'] = '';
      $this->viewData['module'] = $this->router->fetch_module();
      $this->form_validation->CI = & $this;

    }
    // check remote login with md5 encrypted old_id and pasword
    public function index() {
      $loginId = $this->input->get('li');
      $password = $this->input->get('lk');
      $flag = false; //認証済みフラグ
      $isWaitingState = false; //確認待ち状態フラグ
      $authOkButWaiting  = false; //joyspeに登録されていないユーザが、認証にＯＫフラグ
      $dType = 'sp'; //スマホかガラケー

      // 一度、認証されたかどうかチェック
      if ( $loginId && $password ){
        // 登録済みアカウント
        if( $this->Musers->checkRemoteLoginIdAndPassword($loginId,$password,true) ){
          $flag = true;
        }else{
          // 確認待ちアカウント
          if ( $this->Musers->checkIfUserInWaitingState($loginId) ){
            $isWaitingState = true;
            $flag = true;
          }
        }
      }

      $no = 0;
      $ua = $_SERVER['HTTP_USER_AGENT'];
      if(preg_match("/DoCoMo/",$ua) || preg_match("/J-PHONE/",$ua) || preg_match("/Vodafone/",$ua) ||
        preg_match("/MOT/",$ua) || preg_match("/SoftBank/",$ua) || preg_match("/PDXGW/",$ua) ||
        preg_match("/UP.Browser/",$ua) || preg_match("/ASTEL/",$ua) || preg_match("/DDIPOCKET/",$ua))
      {
        $dType = 'ga';
        $this->viewData['titlePage']= 'joyspe｜ガラケ';
      }
      elseif(preg_match("/iPhone/",$ua) || preg_match("/iPod/",$ua) || preg_match("/Android/",$ua))
      {
        $dType = 'sp';
        $this->viewData['titlePage']= 'joyspe｜スマホでライブチャットマシェリ';
      }
      else {
        redirect(base_url() . "user/joyspe_user/index");
      }
      if( !$flag ){
          if($_POST) {
            $loginId = $this->input->post('pr_li'); // MD5 loginID
            $password = $this->input->post('pr_lk'); // MD5 pass
          }else{
            if ( $dType != 'ga' ){
              if($this->session->flashdata('flag')) {
                $loginId = $this->session->flashdata('loginId');
                $password = $this->session->flashdata('pass');
              }
            }
          }

          $users = $this->Musers->getUserByOldIdAndPassword($loginId, $password);
          if ( $users && $users['user_from_site'] == 1 ){
            $no = 1;
            $this->viewData['load_page'] = 'user/accessPRPage/'.$dType.'1';
            $this->layout = 'user/layout/accessPRPage/'.$dType.'1';
          }else if ( $users && $users['user_from_site'] == 2 ){
            $no = 2;
            $this->viewData['load_page'] = 'user/accessPRPage/'.$dType.'2';
            $this->layout = 'user/layout/accessPRPage/'.$dType.'2';
          }else{
            // IDはjoyspeに存在しない場合、default = 1(TODO: マキア対応の時、データ存在しない処理時、ユーザはどこからくるのをチェックする必要ある)
            $no = 1;
            $this->viewData['load_page'] = 'user/accessPRPage/'.$dType.'1';
            $this->layout = 'user/layout/accessPRPage/'.$dType.'1';
          }
          $flag = false;
          $form_validation = false;
          if($_POST) {
            $loginId = $this->input->post('pr_li'); // MD5 loginID
            $password = $this->input->post('pr_lk'); // MD5 pass
            $this->form_validation->set_rules('pr_li', 'Login Id', 'trim|required');
            $this->form_validation->set_rules('pr_lk', 'Pass', 'trim|required|callback_checkLogin');
            $form_validation = $this->form_validation->run();
            $this->message['success'] = !$form_validation ? FALSE : TRUE;
            if (!$form_validation){ //joyspeに存在していないユーザ
              if ( $no == 1 ){
                $this->viewData['load_page'] = 'user/accessPRPage/f'.$dType.'1';
                $this->layout = 'user/layout/accessPRPage/f'.$dType.'1';
              }else{
                $this->viewData['load_page'] = 'user/accessPRPage/f'.$dType.'2';
                $this->layout = 'user/layout/accessPRPage/f'.$dType.'2';
              }
              $old_id = file_get_contents(GET_MACHERIE_ID_API.$loginId);
              $authOkButWaiting = true;
              if ( $old_id ){
                // check if user is already existed
                $ret = $this->Musers->checkUserExistFrom($old_id);
                if ( !$ret ){
                  // create a new user
                  $ret = $this->common->create_user_with_waiting_state($old_id, $no);
                  // マシェモバ・マキアサイトにOKを返す
                  $this->sendAuthResult($old_id, $no, 1);
                }
              }
            }
            else {
              $flag = true;
              $update_data = array('remote_scout_flag' => 1,'accept_remote_scout_datetime' => date("Y-m-d-H-i-s"), 'last_visit_date'=> date("Y-m-d-H-i-s"));
              $result = $this->Musers->updateUserScoutFlag($update_data, $loginId);
              if ( $result == true ){
                $users = $this->Musers->getUserByOldIdAndPassword($loginId, $password);
                // scout_mail_bonusに報酬用のレコード作成
                if ( $users && $users['id'] ){
                  $this->Musers->addNewScoutMailBonus($users['id']);
                }
                // マシェモバへ認証結果送信
                $this->sendAuthResult($users['old_id'], $users['user_from_site'], 1);
              }
            }
          }
          else {
            // ログイン情報をURLに表示しないように、flashdataを使用
            if ( $dType != 'ga' ){
              if(!$this->session->flashdata('flag')) {
                $this->session->set_flashdata('flag', true);
                $this->session->set_flashdata('loginId', $loginId);
                $this->session->set_flashdata('pass', $password);
                redirect(base_url() . "user/accessPRPage");
              }
              else {
                $this->viewData['loginId'] = $loginId = $this->session->flashdata('loginId');
                $this->viewData['password'] = $password = $this->session->flashdata('pass');
              }
            }else{
              $this->viewData['loginId'] = $loginId;
              $this->viewData['password'] = $password;
            }
          }
      }

      if( $flag ) { //if authentification is successful
        if ( $isWaitingState ){
          $user_info = $this->Musers->getUserInfoFromMd5OldID($loginId);
          if ( $user_info ){
            $no = $user_info['user_from_site'];
            if ( $no == 1 ){
              $this->viewData['load_page'] = 'user/accessPRPage/f'.$dType.'1';
              $this->layout = 'user/layout/accessPRPage/f'.$dType.'1';
            }else{
              $this->viewData['load_page'] = 'user/accessPRPage/f'.$dType.'2';
              $this->layout = 'user/layout/accessPRPage/f'.$dType.'2';
            }
          }
        }else{
          $users = $this->Musers->getUserByOldIdAndPassword($loginId, $password);
          HelperApp::add_session('id',$users['id']);
          $data = array(
            'last_visit_date' => date("y-m-d H:i:s"),
          );
          $this->Musers->update_User($data, $users['id']);
          setcookie('over18_flag',1, time() + (10 * 365 * 24 * 60 * 60), "/");
          redirect(base_url() . "user/joyspe_user/index",'location', 302);
        }
      }

      //どこからのリクエスト切り分け
      $this->viewData['authOkButWaiting'] = $authOkButWaiting;
      $this->viewData['referrer'] = "";
      $this->load->view($this->layout, $this->viewData);
    }

    public function checkLogin($logID) {
      $loginId = trim($this->input->post('pr_li'));
      $password = $this->input->post('pr_lk');
      if ($password == "") {
        $this->form_validation->set_message('checkLogin', 'ログインID、またはパスワードが不正です。');
        return false;
      }
      else{
        if ( $this->encrypt_id_pass_flg == false ){
          $password  = base64_encode($password);
        }
      }
      if( !$this->Musers->checkRemoteLoginIdAndPassword($loginId,$password) ) {
        $this->form_validation->set_message('checkLogin', 'ログインID、またはパスワードが不正です。');
        return false;
      }
      return true;
    }

    public function noAccept(){
      if ( $_SERVER['SERVER_ADDR'] == SERVER_ADDRESS ){
        $loginId = $this->input->get("lid");
        $users = $this->Musers->getUserIDFromMd5ID($loginId);
        if ( $users ){
          $this->sendAuthResult($users['old_id'],1,0);
        }
      }
      $pPageUrl = $this->input->get('pPage');
      redirect($pPageUrl);
    }
    /**
     * @author VJS
     *　@name  sendAuthResult
     * @todo  send authentication result to aruke or machemoba
     * @param $old_id: id from machemoba or makia
     * @param $fromsite: 1(to machemoba), 2(to makia)
     * @param $result: 0(NG), 1(OK)
     */
  private function sendAuthResult($old_id, $fromSite, $result){
    if ( !$old_id ){
      return;
    }
    if ( $fromSite !=1 && $fromSite != 2 ){
      return;
    }else if ( $fromSite == 1 ){
      $url = REMOTE_LOGIN_SITE_1.'/scoutcheck.php';
    }else{
      $url = REMOTE_LOGIN_SITE_2.'/scoutcheck.php';
    }

    if ( $result == 1 ){
      $result = "OK";
    }else{
      $result = "NG";
    }
    $postdata = array("RESULT" => $result,
                      "id"     => md5(MOBA_PREFIX.$old_id));
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
    curl_setopt($ch, CURLOPT_TIMEOUT,50);
    $ret = curl_exec($ch);
    curl_close($ch);
  }
}
?>

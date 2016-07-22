<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Inbox extends MX_Controller {

	private $data;
  const   DATA_PER_PAGE = 10;
  
    public function __construct() {
        parent::__construct();
        $this->load->Model(array('owner/mowner','owner/muser', 'user/Musers'));
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
    public function index($page = 1)
    {
        //HelperGlobal::requireOwnerLogin();
        if ( !OwnerControl::LoggedIn() ){
            //ランディンzグページへ遷移
            $url = base_url() .'owner/top';
            redirect($url);
        }

        $owner_id = OwnerControl::getId();

        $page = $page > 1 ? $page : 1;
        $ppp = $this->config->item('per_page');

        $inbox = $this->mowner->getUserOwnerMessages($owner_id, $page, $ppp);
        $total = $this->mowner->countUserMessages($owner_id);
        $totalpage = '';
        if ($ppp != 0)
        	$totalpage = ceil($total / $ppp);

        $this->data['page'] = $page;
        $this->data['ppp'] = $ppp;
        $this->data['totalpage'] = $totalpage;
        $this->data['first_link'] = base_url() . 'owner/inbox';
        $this->data['last_link']  = base_url() . 'owner/inbox/index/'.$totalpage;
        $this->data['paging'] = HelperApp::get_paging($ppp, base_url() . "owner/inbox/index", $total, $page);
        $this->data['inbox'] = $inbox;
        $this->data['owner_data'] = OwnerControl::getOwner();
        $this->data['title'] = 'joyspe｜TOPページ';
        $this->data['loadPage'] = 'inbox/index';
        $this->load->view($this->data['module'].'/layout/layout_A',$this->data);
    }

    public function displayMessageContent() {
        header('Content-Type: text/html; charset=utf-8');
        $owner_id = OwnerControl::getId();
        $owner_data = $this->mowner->getOwner($owner_id);
        $owner_recruit_data = $this->mowner->getOwnerRecruit($owner_id);
        $user_id = $this->input->post('user_id');
        $nmu_id = $this->input->post('nmu_id');
        $this->data['apply_emailaddress'] = $owner_recruit_data['apply_emailaddress'];
        $this->data['owner_recruit_id'] = $owner_data['owner_recruit_id'];
        $this->data['storename'] = $owner_data['storename'];
        $this->data['tel'] = $owner_recruit_data['apply_tel'];
        $msg_id = $this->input->post('msg_id');
        $this->mowner->updateUserMessageIsRead($msg_id);
        $this->data['message_data'] = $this->mowner->getUserMessage($msg_id);        
        $this->data['user_id'] = $user_id;
        $this->data['nmu_id'] = $nmu_id;
        $this->data['msg_history_total'] = $this->Mowner->getUsrOwrMessageCnt($owner_id, $user_id, $nmu_id);
        if ($this->data['message_data']) {
          $this->data['message_data']['orgin_msg_id'] = $msg_id;
        }
        $this->load->view("owner/inbox/message_content", $this->data);

    }

    public function saveOwnerMessage() {
        $owner_id = OwnerControl::getId();
        $owner_data = $this->mowner->getOwner($owner_id);
        $owner_recruit_data = $this->mowner->getOwnerRecruit($owner_id);
        $user_id = $this->input->post('user_id');
        $none_member_id = $this->input->post('none_member_id');
        $title = $this->input->post('title');
        $content = $this->input->post('message');
        $orgin_msg_id = $this->input->post('orgin_msg_id');
        $signature = $this->input->post('signature');
        $public_flag = $this->input->post('public_flag');
        if ($signature == 1 && !$none_member_id) {
            $none_member_id = 0;
            $owner_url = base_url() . "user/joyspe_user/company/" . $owner_recruit_data["id"]."/";
            $content .= "\n\n店舗名: " . $owner_data['storename'];
            $content .= "\n電話番号: ". $owner_recruit_data['apply_tel'];
            $content .= "\nメールアドレス: " . $owner_recruit_data['apply_emailaddress'];

            $content .= "\n\n【匿名の返信はこちら】";
            $content .= "\nURL: " . $owner_url;
            // add <a> tag to URL
            $pattern = "/(?i)\b((?:https?:\/\/|www\d{0,3}[.]|[a-z0-9.\-]+[.][a-z]{2,4}\/)(?:[^\s()<>]+|\(([^\s()<>]+|(\([^\s()<>]+\)))*\))+(?:\(([^\s()<>]+|(\([^\s()<>]+\)))*\)|[^\s`!()\[\]{};:'\".,<>?«»“”‘’]))/";
            $content = preg_replace($pattern, "<a href=\"$1\">$1</a>", $content);
		}
    	$data = array('user_id' => $user_id,
                      'none_member_id' => $none_member_id,
                      'owner_id' => OwnerControl::getId(),
                      'title' => 'Re: '.$title,
                      'content' => $content,
                      'created_date' => date("y-m-d H:i:s"),
                      'updated_date' => date("y-m-d H:i:s"),
                      'msg_from_flag' => 1,
                      'owner_res_flag' => $public_flag
                      );

		$this->db->trans_start();
    	$sent = $this->Musers->insert_user_owner_message($data);
		if ($sent) {
            // get new message id
			$reply_id = $this->db->insert_id();
			// set original mesasge with is_replied_flag = 1 (true)
			$update_data = array(
				'is_replied_flag' => 1,
				'reply_id' => $reply_id,
                'owner_res_flag' => $public_flag,
                'updated_date' => date("y-m-d H:i:s"));
			$this->Musers->update_user_owner_message($update_data, $orgin_msg_id);
		}
		$this->db->trans_complete();

        if ($none_member_id) {
            $noneMemberInfo = $this->Musers->getNoneMemberId($none_member_id);
            $ret = $this->common->sendToNonMemberAdmin($owner_recruit_data, $noneMemberInfo, $owner_data, $title, $content);
            echo json_encode($ret);
            exit();
        }

    	$flagsetsendmail = $this->Musers->get_users($user_id);
    	if($flagsetsendmail['user_from_site'] == 1)
    		$url = REMOTE_LOGIN_SITE_1.'/scoutmail.php';
    	elseif($flagsetsendmail['user_from_site'] == 2)
    	$url = REMOTE_LOGIN_SITE_2.'/scoutmail.php';
    	else
    		$url = '';
    	if( $url ){
    		$id = $flagsetsendmail['old_id'];
    		$md5_id = md5(MOBA_PREFIX.$id);
    		$data = $this->Mowner->getScoutPoint();
    		$point = 0;
    		if ( $data ){
    			$point = $data['point'];
    		}
    		$postdata = array("point" => 0,
    				"loginid"   => $md5_id,
    				"scoutmail_title" => 'Re: '.$title,
    				"scoutmail_content" => $content);
    		$ch = curl_init($url);
    		curl_setopt($ch, CURLOPT_POST, true);
    		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    		curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
    		curl_setopt($ch, CURLOPT_TIMEOUT,50);
    		$result = curl_exec($ch);
    		curl_close($ch);
    	}

    	if($sent)
    		echo json_encode(true);
    	else
    		echo json_encode(false);
    	exit;
    }
	public function getUnreadMsgNo(){
        $ret = 0;
		if ( !OwnerControl::LoggedIn() ){
			echo $ret;
		}

		$owner_id = OwnerControl::getId();
		$unread_msg_no = $this->Musers->get_unread_msg($owner_id);
		if ($unread_msg_no && $unread_msg_no > 0){
			$ret = $unread_msg_no;
		}

		echo $ret;
	}
  
  /**
   * Get the user owner message history.
   *
   * @param type post: string $type, string $user_id, string $offset
   * @return html display
   */
  public function getSendHistory(){ 
    if ($this->input->post()) {
      $owner_id = OwnerControl::getId();
      $type = $this->input->post('type');     
      $user_id = $this->input->post('user_id');
      $nmu_id = $this->input->post('nmu_id');
      $offset = $this->input->post('offset');
      $ret_data = array();
      $limit = self::DATA_PER_PAGE;
      if ($type == 1) { // get send/receive message history
        $msg_history = $this->Mowner->get_user_owner_message_history($owner_id, $user_id, $nmu_id, $limit, intval($offset));
        $data['msg_history'] = $msg_history;
        $this->load->view('owner/template/message_history', $data);        
      }      
    }
  }
}

?>

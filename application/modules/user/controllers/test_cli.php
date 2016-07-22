<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Test_cli extends Common {
	private $remaining_scout_mail;
	private $arr_userid = array();
	private $userCount = 0;
	const   MAILS_PER_RUN_MAX = 500; // number of mails can be sent per run

	function __construct() {
		parent::__construct();
		if(!$this->input->is_cli_request()){ exit; };
		$this->load->model('owner/Mowner');
		$this->load->model('owner/Mpoint');
		$this->load->model('user/Musers');
		$this->load->model('owner/Mcommon');
		$this->load->model('owner/Mtemplate');
	}
	public function auto_send() {
		$this->_sendMailToUser(6028, 1690, 122127, 2);
	}

	private function _sendMailToUser($owner_id, $template_id, $userId, $owner_status){
		$owner_recruit_id = $this->Mpoint->getOwnerRecruitId($owner_id);
		$vUs = 'us14';
		$payment_message_status = 1;

		// 1: send to joyspe's mail box
		$list_user_message_id = $this->Mpoint->insertListUserMessage($owner_recruit_id, $userId, $vUs, $payment_message_status, $template_id);
		$flagsetsendmail = $this->Musers->get_users($userId);

		$url = "http://www.joyspe.com/user/joyspe_user/company/".$owner_recruit_id;
		if ($flagsetsendmail['set_send_mail'] == 1 && $owner_status != 1) {
			// 2: send us14/us03 to user's email address
			$this->sendMail('', '', '', array($vUs), $owner_id, '', $userId, 'getUserSelect', 'getJobUser', 'getJobTypeOwnerForScout', array($userId), $url, '', $list_user_message_id);

		}
		if($flagsetsendmail['user_status'] == 1 && $flagsetsendmail['user_from_site'] != 0 && $owner_status != 1) {
			// 3: send to other site's mail box
			$userEmailContent = $this->getUserEmailContent($owner_id, $userId, $url, $list_user_message_id, $flagsetsendmail['user_from_site']);
			// add <a> tag to URL
			$pattern = "/(?i)\b((?:https?:\/\/|www\d{0,3}[.]|[a-z0-9.\-]+[.][a-z]{2,4}\/)(?:[^\s()<>]+|\(([^\s()<>]+|(\([^\s()<>]+\)))*\))+(?:\(([^\s()<>]+|(\([^\s()<>]+\)))*\)|[^\s`!()\[\]{};:'\".,<>?«»“”‘’]))/";
			$userEmailContent = preg_replace($pattern, "<a href=\"$1\">$1</a>", $userEmailContent);
			$outside_url = '';
			if ($flagsetsendmail['user_from_site'] == 1) {
				$outside_url = REMOTE_LOGIN_SITE_1.'/scoutmail.php';
			} elseif ($flagsetsendmail['user_from_site'] == 2) {
				$outside_url = REMOTE_LOGIN_SITE_2.'/scoutmail.php';
			}

			if ($outside_url) {
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
				$ch = curl_init($outside_url);
				curl_setopt($ch, CURLOPT_POST, true);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
				curl_setopt($ch, CURLOPT_TIMEOUT,50);
				$result = curl_exec($ch);
				curl_close($ch);
			}
		}
	}
}

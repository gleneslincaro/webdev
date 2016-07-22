<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
set_time_limit(20*60 - 5); // 20x60 - 5: 20mins
class Cli_controller extends Common {
	private $remaining_scout_mail;
	private $arr_userid = array();
	private $userCount = 0;
	private $site_url = "https://www.joyspe.com";
	private $joyspe_email = "info@joyspe.com";
    const   MAILS_PER_RUN_MAX = 500; // number of mails can be sent per run
	const	DAILY_MAILS_PER_HOUR_MAX = 1500; // number of mails can be sent per hour
	function __construct() {
        parent::__construct();
		//not allow access from URL
		if(!$this->input->is_cli_request()){ exit; };
        //$this->load->model('owner/Mscout');
        //$this->load->model('owner/Mhistory');
        //$this->load->model('owner/muser');
        $this->load->model('owner/Mowner');
        $this->load->model('owner/Mpoint');
        $this->load->model('user/Musers');
        $this->load->model('owner/Mcommon');
        $this->load->model('owner/Mtemplate');
        $this->load->library('cipher');
		switch (ENVIRONMENT) {
			case 'development':
				$this->site_url = "http://joyspe-local.com";
				break;
			case 'production':
				$this->site_url = "https://www.joyspe.com";
				break;
		}
    }
	public function auto_send() {
        ini_set("max_execution_time",0);
		$owner_array = $this->Mowner->getAllAutoSend();
		if (!$owner_array || !is_array($owner_array)) {
			return;
		}
		$sowner = $this->Mowner->getSendLog();
		foreach ($owner_array as $owner) {
			if ($owner->scout_auto_send_flag == 0) {
				continue;
			}
			$owner_id 		= $owner->owner_id;
			$this->arr_userid = array(); // reset array
			$ownerInfo 		= $this->Mowner->getOwner($owner_id);
			$owner_data 	= HelperGlobal::owner_info($owner_id);
			$owner_status 	= $owner_data['owner_status'];
			$num_scout_mail = $this->Mowner->getOwner($owner_id);
			$this->remaining_scout_mail = $num_scout_mail['remaining_scout_mail'];
			$ownerHiddenUsers = $this->Mowner->getOwnerHiddenUsers($owner_id);
			$totalsent 		= $this->userCount;
			$fndOwner 		= false;
			foreach ($sowner as $key ) {
				if($owner_id == $key->owner_id){
					$fndOwner = true;
					break;
				}
			}
			if ($fndOwner == true){
				continue;
			}
			// get all candidates to send (max: 8)
			$getAutoSend = $this->Mowner->getAutoSend($owner_id);
		    foreach ($getAutoSend as $key => $value) {
		    	$area 				= $value['area'];
		    	$status_target_1 	= $value['status_target_1'];
		    	$template_target_1 	= $value['template_target_1'];
		    	$setnum_scout_mail 	= $value['setnum_scout_mail'];
		    	$status_target_2 	= $value['status_target_2'];
		    	$template_target_2 	= $value['template_target_2'];
		    	$selected_flag 		= $value['selected_flag'];
		    	$switch_flag 		= $value['switch_flag'];
				if ($switch_flag == 1) { // the function is OFF
					continue;
				}
				// check sending type
				$sending_type = null;
				if ( $area ) {
					if ($status_target_1 >= 1 && $status_target_1 <= 3 && (int)$setnum_scout_mail > 0) {
						$sending_type = 1;
					} else{
						continue;
					}
				} else {
					if ($status_target_2 >= 1 && $status_target_2 <= 3 && $selected_flag == 2) {
						$sending_type = 2;
					} else {
						continue;
					}
				}

				if ($sending_type == 1) {
					$user_list = $this->Mowner->getUsersToSend($owner_id, $ownerHiddenUsers, $this->arr_userid, $setnum_scout_mail, $status_target_1, $area);
					$this->_processSendingMails($user_list, $owner_id, $template_target_1, $owner_status);
				}

				if ($sending_type == 2) {
					// if owner still has mail quota to send
					if ($this->remaining_scout_mail > 0) {
						$user_list = $this->Mowner->getUsersToSend($owner_id, $ownerHiddenUsers, $this->arr_userid, $this->remaining_scout_mail, $status_target_2);
						$this->_processSendingMails($user_list, $owner_id, $template_target_2, $owner_status);
					}
				}
		    }
		    if (count($this->arr_userid) > 0) {
				$sent_mail_number = count($this->arr_userid);
				// send notification mail to owner
				if ($this->Musers->setSendMailOwner($owner_id)) {
					$vOw = 'ow23';
			        // send mail ow04 for owner
			       	$this->sendMail('', '', '', array($vOw), $owner_id, $senderName = null, $user_id = null,
									'getUserSelect', 'getJobUser', 'getJobOwnerForScout', $this->arr_userid, '', $sent_mail_number);

			        $templOwner04 					= $this->Mcommon->getTemplate($vOw);
			        $dataOwner04['owner_id'] 		= $owner_id;
			        $dataOwner04['template_id'] 	= $templOwner04['id'];
			        $dataOwner04['created_date'] 	= date("y-m-d H:i:s");
			        $this->Mtemplate->insertOwnerList($dataOwner04);
				}
				$update_data = array('remaining_scout_mail' => $this->remaining_scout_mail >= 0 ? $this->remaining_scout_mail : 0);
				$this->Mowner->updateRemainingScoutMail($owner_id, $update_data);
		    }
		    $totalsent = $this->userCount - $totalsent;
            if ($totalsent > 0) {
                $this->Mowner->insertSendLog($owner_id, $totalsent);
			}
		}
	}

	private function _processSendingMails($user_list, $owner_id, $template_id, $owner_status ) {
		if ($user_list) {
			foreach ($user_list as $user) {
				if ($this->remaining_scout_mail > 0 && isset($user['user_id']) && $user['user_id']) {
					$user_id = $user['user_id'];
					$this->remaining_scout_mail--;
					$this->arr_userid[] = $user_id;
					$this->userCount++;
					// actually send mails
					$this->_sendMailToUser($owner_id, $template_id, $user_id, $owner_status);

				} else {
					break;
				}
			}
		}
	}
	private function _sendMailToUser($owner_id, $template_id, $userId, $owner_status){
		$owner_recruit_id = $this->Mpoint->getOwnerRecruitId($owner_id);
        $vUs = 'us14';
        $payment_message_status = 1;

        // 1: send to joyspe's mail box
		$list_user_message_id = $this->Mpoint->insertListUserMessage($owner_recruit_id, $userId, $vUs, $payment_message_status, $template_id);
		$flagsetsendmail = $this->Musers->get_users($userId);
        $this->Mpoint->insertListOpenRate($userId);
		$this->Mpoint->insertListReciveOpenMail($owner_id,$userId);

		$url = $this->site_url . "/user/joyspe_user/company/" . $owner_recruit_id;
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

	// send daily mail to list of users booked on mail_queue_magazine
	public function auto_send_magazine() {
        ini_set("max_execution_time",0);
        $remaining_scout_mail;
        $userCount = 0;
        $time = date("H") . ":00";
        $target_users = $this->mmail->auto_send_magazine_time($time);
        foreach ($target_users as $key => $data) {
            $arrEmail = explode(",", $data['from_mail']);
			$owner_id = $data['owner_id'];
			$owner_recruit = $this->Mowner->getOwnerRecruit($owner_id);
			$owner_recruit_id = null;
			if ($owner_recruit) {
				$owner_recruit_id = $owner_recruit['id'];
			}
            if ($arrEmail && is_array($arrEmail)) {
                $cnt = 0;
                foreach($arrEmail as $email) {
                    $unread_no_str = '';
                    $bonus_money = '';
                    $mail_data = $this->mmail->get_unread_message($email);
					if (!$mail_data || $mail_data['not_read'] <=0) {
						continue; // dont send to user with no unread scout mail
					}
                    $user_info = $this->Musers->get_users_by_email($email);
					if (!$user_info) {
						continue;
					}

					$unread_no_str = $mail_data['not_read'] . '通';
                    $password = $user_info['password'];
                    $encoded_login_str = $this->_encode_login_info($data['id'], $email, $password);
                    $template_body  = $data['content'];
					$template_title = $data['title'];
					$curr_bonus_money = ($mail_data['bonus_money'] ? $mail_data['bonus_money'] : 0) . '円';

					$send_data_info = $this->getDailyMailContent(
										$this->site_url,
										$template_title,
										$template_body,
										$email,
										$owner_recruit_id,
										$encoded_login_str,
										$curr_bonus_money,
										$unread_no_str);
					if ($send_data_info) {
						// send mail
						$this->sendMailUsingMbSendMail($send_data_info['title'], $send_data_info['body'], $this->joyspe_email, $email);
					}
                }
            }
        }
    }
    private function _encode_login_info($id, $email, $password) {
        $arr_account = array('email' => $email,
                            'password' => $password,
                            'created_date' => date("Y-m-d H:i:s"));
        $arr = serialize($arr_account);
        $encrypt = $this->cipher->encrypt($arr);

        $data = array('random_encode_string' => $encrypt,
                      'mail_magazine_id' => $id,
                      'created_date' => date("Y-m-d H:i:s")
        );

        $this->mmail->insert_mail_magazine_log($data);

        return $encrypt;
    }

    /**
     * Auto send count none opened mail (none members)
     */
    public function none_openmail_nonemember(){
        ini_set("max_execution_time",0);
        $data = $this->Mowner->get_count_none_member();
        $template = 'ow25';
        foreach ($data as $key => $value) {
            $owner_id = $value['owner_id'];
            $this->sendMail('', '', '', array($template), $owner_id);
        }

    }

    /**
     * get_urgent_recruit
     */
    public function get_urgent_recruit(){
        $this->load->model('user/Mbuffer');
 		$this->load->model('owner/Mowner');
        $owners = $this->Mowner->getUrgentRecruitmentActiveOwners();
        foreach ((array)$owners as $owner_data){
            $increment_flag = true;
            $latest_posted_date = $this->Mowner->getUrgentRecruitmentLogLatestDate($owner_data['id']);
            if (!$latest_posted_date) {
                $latest_posted_date = $this->Mowner->getFirstOwnerUrgentRecruitmentDate($owner_data['id']);
                $increment_flag = false;
            }

            if ($latest_posted_date) {
                if ($increment_flag) {
                    $start_date = strtotime(date('Y-m-d H:i:s', strtotime($latest_posted_date . "+1 days")));
                } else {
                    $start_date = strtotime($latest_posted_date);
                    $increment_flag = true;
                }
                $end_date = strtotime(date('Y-m-d H:i:s'));
                while (intval($start_date) <= intval($end_date)) {
                  $data = $this->Mowner->getUrgentRecruitmentPostHistory(date('Y-m-d H:i:s', $start_date), $owner_data['id']);
                  if (isset($data) && $data) {
                      if ($data['posted_date'] == '') {
                          $post_hour = (intval($data['post_hour']) > 10)?$data['post_hour'].":00":'0'.$data['post_hour'].":00";
                          $data['posted_date'] = date('Y-m-d ', $start_date).$post_hour;
                      }
                      unset($data['post_hour']);
                      $is_inserted = $this->Mowner->insertUrgentRecruitmentPostHistory($data);
                  }
                  $sdate = date('Y-m-d H:i:s', $start_date);
                  $start_date = strtotime(date('Y-m-d H:i:s', strtotime($sdate . "+1 days")));
                }
            }
        }

        $ar = $this->Mowner->getUrgentRecruitmentsLatestPost(0);/* 新着 */
		$this->Mbuffer->get_urgent_recruit($ar);
    }

    /**
     * get_column
     */
    public function get_column(){
        $this->load->model('user/Mbuffer');
        $this->common = new Common();
        $ar = $this->common->get_latest_column_posts(4, false); // get latest posts from wordpress
        $this->Mbuffer->set_column_buffer($ar);/* バッファへセット */
    }

    public function city_owner_count($group_city = null)
    {
        if ($group_city == null) {
            echo "urlにエリアを入力して下さい";
            exit();
        }

        $GroupCity = $this->mcity->getGroupCityByAlphaName($group_city);

        $owner_status = "2,5";

        $city_group_id = $GroupCity['id'];
        $getCity = $this->mcity->getCity($city_group_id);
        foreach ($getCity as $key => $val) {
            $owCount = $this->Mowner->countOwnersTown($val['id'], $owner_status);
            //echo "id:".$val['id']."=".$val['alph_name'];
            //echo "->";
            //echo $owCount;
            //echo "<br>";
            $this->mcity->updateCityOwnerCount($val['id'], $owCount);
        }

        echo "都市店舗数更新完了しました。";
    }

    public function town_owner_count($group_city = null)
    {

        if ($group_city == null) {
            echo "urlにエリアを入力して下さい";
            exit();
        }

        echo "エリア求人データ更新!";
                    echo "<br>";

        $groupCity = $this->mcity->getCityGroup();

        $owner_status = "2,5";

        $towns_ar = array();
        $area_ar = array();

        $city_index = 0;
        $index = 0;

        $GroupCity = $this->mcity->getGroupCityByAlphaName($group_city);

        $city_group_id = $GroupCity['id'];
        $getCity = $this->mcity->getCity($city_group_id);
        foreach ($getCity as $key2 => $val2) {
            $arr_town = $this->mcity->getTownIds($val2['id']);
            //echo "city_id".$val2['id'];
            //echo "<br>";
            $area_ar[$val2['id']]['city'] = $val2['id'];
            $temp_towns = $this->mcity->getTownUserCountIds($val2['id'], $owner_status);
            $area_ar[$val2['id']]['town'] = $temp_towns;

            $towns_ar[$index] = $temp_towns;
            $index++;
        }
/*
        foreach ($area_ar as $key => $val) {
            $city_id = $val['city'];
            if (count($area_ar[$city_id]['town']) > 0) {
                echo "num=".count($area_ar[$city_id]['town']);
                echo "<br>";
                foreach ($area_ar[$city_id]['town'] as $key2 => $val2) {
                    echo "id=".$val2['id'].' '."name=".$val2['name'].' '."alph_name=".$val2['alph_name'].' '."ocount=".$val2['ocount'];
                    echo "<br>";
                }
            }
        }
*/
        foreach ($area_ar as $key => $val) {
            $city_id = $val['city'];
            if (count($area_ar[$city_id]['town']) > 0) {
                foreach ($area_ar[$city_id]['town'] as $key2 => $val2) {
                    $this->mcity->updateTownOwnerCount($val2);
                }
            }
        }

    }

}
/* End of file cli_controller.php */
/* Location: ./application/controllers/cli_controller.php */
?>
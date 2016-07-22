<?php
  class Request extends MX_Controller{
    protected $_data;
    private $message = array('success' => true, 'error' => array());
    private $common;
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
    }

    public function authentication() {
      $where = '';
      $start = 0;
      $this->_data["loadPage"]="request/authentication";
      $this->_data["titlePage"]="スカウト認証申込一覧";
      if($_POST) {
        $this->_data['txtUserUniqueId'] = $uniqueId = trim($this->input->post('txtUserUniqueId'));
        $this->_data['txtUserName'] = $name = trim($this->input->post('txtUserName'));
        $this->_data['siteType'] = $siteType = trim($this->input->post('siteType'));
        $this->_data['txtOldId'] = $oldid = trim($this->input->post('txtOldId'));
        $this->_data['bunosReceivingFlag'] = $bunosReceivingFlag = trim($this->input->post('bunosReceivingFlag'));
        $this->_data['txtAgreementDateFrom'] = $txtAgreementDateFrom = trim($this->input->post('txtAgreementDateFrom'));
        $this->_data['txtAgreementDateTo'] = $txtAgreementDateTo = trim($this->input->post('txtAgreementDateTo'));
        $this->_data['txtReceiveBonusDateFrom'] = $txtReceiveBonusDateFrom = trim($this->input->post('txtReceiveBonusDateFrom'));
        $this->_data['txtReceiveBonusDateTo'] = $txtReceiveBonusDateTo = trim($this->input->post('txtReceiveBonusDateTo'));
        $this->_data['phoneDealing'] = $phoneDealing = trim($this->input->post('phoneDealing'));
        $this->_data['txtLastVisitDateFrom'] = $txtLastVisitDateFrom = trim($this->input->post('txtLastVisitDateFrom'));
        $this->_data['txtLastVisitDateTo'] = $txtLastVisitDateTo = trim($this->input->post('txtLastVisitDateTo'));
        
        if($uniqueId != "")
          $where.=" AND us.unique_id LIKE '%".$this->db->escape_like_str($uniqueId)."%' ";
        if($name != "")
          $where.=" AND us.name LIKE '%".$this->db->escape_like_str($name)."%' ";
        if($siteType != "") {
          if($siteType != -1) {
            $where.=" AND us.user_from_site = ".$this->db->escape_str($siteType);
          }
        }
        if($bunosReceivingFlag != "") {
          if($bunosReceivingFlag != -1) {
            $where.=" AND us.received_bonus_flag = ".$this->db->escape_str($bunosReceivingFlag);
          }
        }
        if ( $oldid ){
          $where.=" AND old_id like '%".$this->db->escape_str($oldid)."%' ";
        }
        if($txtAgreementDateFrom != "")
          $where.=" AND DATE_FORMAT(us.accept_remote_scout_datetime,'%Y/%m/%d') >= '".$this->db->escape_str($txtAgreementDateFrom)."' ";
        if($txtAgreementDateTo != "")
          $where.=" AND DATE_FORMAT(us.accept_remote_scout_datetime,'%Y/%m/%d') <= '".$this->db->escape_str($txtAgreementDateTo)."' ";
        if($txtReceiveBonusDateFrom != "")
          $where.=" AND DATE_FORMAT(us.received_bonus_datetime,'%Y/%m/%d') >= '".$this->db->escape_str($txtReceiveBonusDateFrom)."' ";
        if($txtReceiveBonusDateTo != "")
          $where.=" AND DATE_FORMAT(us.received_bonus_datetime,'%Y/%m/%d') <= '".$this->db->escape_str($txtReceiveBonusDateTo)."' ";
        if($txtLastVisitDateFrom != "")
          $where.=" AND DATE_FORMAT(us.last_visit_date,'%Y/%m/%d') >= '".$this->db->escape_str($txtLastVisitDateFrom)."' ";
        if($txtLastVisitDateTo != "")
          $where.=" AND DATE_FORMAT(us.last_visit_date,'%Y/%m/%d') <= '".$this->db->escape_str($txtLastVisitDateTo)."' ";
        if($phoneDealing!="-1") {
          $where .= " AND us.telephone_record_flag = " . $this->db->escape_str($phoneDealing);
        }
        

        $this->load->Model("admin/Msearch");
        $totalNumber = $this->Msearch->countUserFromSite1or2($where);
        $totalNumber = $totalNumber[0]['total_number'];
        //Start Page
        $config['base_url'] = base_url('index.php/admin/request/authentication');
        $config['total_rows'] = $totalNumber;
        $config['constant_num_links'] = TRUE;
        $config['uri_segment']=4;
        $config["per_page"]=$this->config->item('per_page');
        $this->pagination->initialize($config);
        $start1 = $this->uri->segment(4);
        if($start1!=NULL) $start=$start1;
        $this->_data["records"]=$this->Msearch->searchUserFromSite1or2($where, $config['per_page'], $start);
        $this->_data["totalNumber"] = $totalNumber;
        $this->_data['where'] = $where;
        $this->_data['number'] = $config['per_page'];
        $this->_data['start'] = $start;
      }
      if($this->input->post('ajax')!=null)
        $this->load->view("request/authentication",$this->_data);
      else
        $this->load->view($this->_data["module"]."/layout/layout",$this->_data);
    }

    public function updateUserReceivedBonus() {
      if($_POST['type'] == 'uAuthentication') {
        $this->load->Model("user/Musers");
        $rbf = $this->input->post('userReceivedBonusFlag');
        $id = $this->input->post('userId');
        $data = array(
                  'received_bonus_flag' => ($rbf == 0)? 1: 0,
                  'received_bonus_datetime' => ($rbf == 0)? date("Y-m-d-H-i-s"): null,
                );
        $this->Musers->updateUser($data, $id);
        echo json_encode(array('rbDatetime' => $data['received_bonus_datetime']));
      }
      if($_POST['type'] == 'bonus') {
        $this->load->Model("user/Musers");
        $rbf = $this->input->post('smbReceivedBonusFlag');
        $id = $this->input->post('smbId');
        $bonus_requested_date = $this->input->post('requested_date');
        $user_id = $this->input->post('user_id');
        $date = date("Y-m-d-H-i-s");
        $data = array(
              'received_bonus_flag' => ($rbf == 0)? 1: 0,
              'received_bonus_date' => ($rbf == 0)? $date: null
            );
        $data_joyspe = array_merge($data, array('updated_date' => $date));
        $this->Musers->updateScoutMailBonus($data_joyspe, $id);
        $data_aruaru = array_merge($data, array('update_date' => $date));
        $this->Musers->updateExternalSiteBonus($data_aruaru, $user_id, $bonus_requested_date);
        echo json_encode(array('rbDate' => $data['received_bonus_date']));
      }
      if($_POST['type'] == 'makia_bonus') {
          $this->load->Model("user/Musers");
          $rbf = $this->input->post('smbReceivedBonusFlag');
          $id = $this->input->post('smbId');
          $data = array(
              'received_bonus_flag' => ($rbf == 0)? 1: 0,
              'received_bonus_datetime' => ($rbf == 0)? date("Y-m-d H:i:s"): null,
          );
          $this->Musers->updateUser($data, $id);
          echo json_encode(array('rbDate' => $data['received_bonus_datetime']));
      }
    }

    public function updateUsersReceivedBonus() {
      $this->load->Model("admin/Msearch");
      $this->load->Model("user/Musers");
      if($_POST['type'] == 'uAuthentication') {
        $data1 = null;
        $rbf = $this->input->post('userReceivedBonusFlag');
        $users = $this->input->post('users');
        $number = $this->input->post('number');
        $start = $this->input->post('start');
        $users_in_str = implode("','", $users);
        $where = " AND unique_id in ('".$users_in_str."')";
        $data = $this->Msearch->searchUserFromSite1or2($where, $number, $start);
        $cntr = 0;
        foreach($data as $key => $val) {
          if($val['received_bonus_flag'] == $rbf) {
            $id = $val['id'];
            $data = array(
                'received_bonus_flag' => ($rbf == 0)? 1: 0,
                'received_bonus_datetime' => ($rbf == 0)? date("Y-m-d-H-i-s"): null,
              );
            $this->Musers->updateUser($data, $id);
            $data1[$cntr]['id'] = $id;
            $data1[$cntr]['received_bonus_flag'] = $data['received_bonus_flag'];
            $data1[$cntr]['received_bonus_datetime'] = $data['received_bonus_datetime'];
            $cntr++;
          }
        }
        echo json_encode(array('data' => $data1));
      }
      if($_POST['type'] == 'bonus' || $_POST['type'] == 'makia_bonus') {
        $data = null;
        $data1 = null;
        $rbf = $this->input->post('smbReceivedBonusFlag');
        $users = $this->input->post('users');
        $number = $this->input->post('number');
        $start = $this->input->post('start');
        $users_in_str = implode("','", $users);
        $where = " AND unique_id in ('".$users_in_str."')";
        if($_POST['type'] == 'bonus') {
          $data = $this->Msearch->searchUserBonusFromSite1or2($where, $number, $start);
        }
        else {
          if($_POST['type'] == 'makia_bonus') {
            $data = $this->Msearch->searchMakiaUsers($where, $number, $start);
          }
        }
        $cntr = 0;
        foreach($data as $key => $val) {
          if($val['received_bonus_flag'] == $rbf) {
            $date = date("Y-m-d H-i-s");
            $id = $val['id'];
            $data = array(
              'received_bonus_flag' => ($rbf == 0)? 1: 0,
              'received_bonus_date' => ($rbf == 0)? $date: null
            );
            $bonus_requested_date = $val['bonus_requested_date'];
            $data_joyspe = array_merge($data, array('updated_date' => $date));
            $this->Musers->updateScoutMailBonus($data_joyspe, $id);
            $data_aruaru = array_merge($data, array('update_date' => $date));
            $user_id = $val['user_id'];
            $this->Musers->updateExternalSiteBonus($data_aruaru, $user_id, $bonus_requested_date);
            $data1[$cntr]['id'] = $id;
            $data1[$cntr]['received_bonus_flag'] = $data['received_bonus_flag'];
            $data1[$cntr]['received_bonus_date'] = $data['received_bonus_date'];
            $cntr++;
          }
        }
        echo json_encode(array('data' => $data1));
      }
    }

    public function bonus() {
      $where = '';
      $start = 0;
      $this->_data["loadPage"]="request/bonus";
      $this->_data["titlePage"]="申請・ボーナス関係・ボーナス申請リスト";
      if($_POST) {
        $this->_data['txtUserUniqueId'] = $uniqueId = trim($this->input->post('txtUserUniqueId'));
        $this->_data['txtUserName'] = $name = trim($this->input->post('txtUserName'));
        $this->_data['siteType'] = $siteType = trim($this->input->post('siteType'));
        $this->_data['txtOldId'] = $oldid = trim($this->input->post('txtOldId'));
        $this->_data['bunosReceivingFlag'] = $bunosReceivingFlag = trim($this->input->post('bunosReceivingFlag'));
        $this->_data['txtBonusAppDateFrom'] = $txtBonusAppDateFrom = trim($this->input->post('txtBonusAppDateFrom'));
        $this->_data['txtBonusAppDateTo'] = $txtBonusAppDateTo = trim($this->input->post('txtBonusAppDateTo'));
        $this->_data['txtBonusGrantDateFrom'] = $txtBonusGrantDateFrom = trim($this->input->post('txtBonusGrantDateFrom'));
        $this->_data['txtBonusGrantDateTo'] = $txtBonusGrantDateTo = trim($this->input->post('txtBonusGrantDateTo'));
        if($uniqueId != "")
          $where.=" AND us.unique_id LIKE '%".$this->db->escape_like_str($uniqueId)."%' ";
        if($name != "")
          $where.=" AND us.name LIKE '%".$this->db->escape_like_str($name)."%' ";
        if($oldid != "")
          $where.=" AND us.old_id LIKE '%".$this->db->escape_like_str($oldid)."%' ";
        if($siteType != "") {
          if($siteType != -1) {
            $where.=" AND us.user_from_site = ".$this->db->escape_str($siteType);
          }
        }
        if($bunosReceivingFlag != "") {
          if($bunosReceivingFlag != -1) {
            $where.=" AND smb.received_bonus_flag = ".$this->db->escape_str($bunosReceivingFlag);
          }
        }
        if($txtBonusAppDateFrom != "")
          $where.=" AND DATE_FORMAT(smb.bonus_requested_date,'%Y/%m/%d') >= '".$this->db->escape_str($txtBonusAppDateFrom)."' ";
        if($txtBonusAppDateTo != "")
          $where.=" AND DATE_FORMAT(smb.bonus_requested_date,'%Y/%m/%d') <= '".$this->db->escape_str($txtBonusAppDateTo)."' ";
        if($txtBonusGrantDateFrom != "")
          $where.=" AND DATE_FORMAT(smb.received_bonus_date,'%Y/%m/%d') >= '".$this->db->escape_str($txtBonusGrantDateFrom)."' ";
        if($txtBonusGrantDateTo != "")
          $where.=" AND DATE_FORMAT(smb.received_bonus_date,'%Y/%m/%d') <= '".$this->db->escape_str($txtBonusGrantDateTo)."' ";

        $this->load->Model("admin/Msearch");
        $totalNumber = $this->Msearch->countUserBonusFromSite1or2($where);
        $totalNumber = $totalNumber[0]['total_number'];
        //Start Page
        $config['base_url'] = base_url('index.php/admin/request/bonus');
        $config['total_rows'] = $totalNumber;
        $config['constant_num_links'] = TRUE;
        $config['uri_segment']=4;
        $config["per_page"]=$this->config->item('per_page');
        $this->pagination->initialize($config);
        $start1 = $this->uri->segment(4);
        if($start1!=NULL) $start=$start1;
        $this->_data["records"]=$this->Msearch->searchUserBonusFromSite1or2($where, $config['per_page'], $start);
        $this->_data["totalNumber"] = $totalNumber;

        $this->_data['where'] = $where;
        $this->_data['number'] = $config['per_page'];
        $this->_data['start'] = $start;
      }
      if($this->input->post('ajax')!=null)
        $this->load->view("request/bonus",$this->_data);
      else
        $this->load->view($this->_data["module"]."/layout/layout",$this->_data);
    }

    // bonus list for first message sending
    public function firstMessageBonusList() {
      $this->load->Model('owner/Mowner');

      $first_message = false; // is first message or not
      $user_name = null; // user real name
      $storename = null; // store name
      $chkbox_public_message = null;
      if ($this->input->post()) {
          if ($this->input->post('chkbox_first_message')) {
              $this->_data["chkbox_first_message"] = true;
              $first_message = true;
          }
          $storename = $this->input->post('txt_storename');
          if ($this->input->post('txt_member_name')) {
              $user_name = $this->input->post('txt_member_name');
          }
          if ($this->input->post('txt_storename')) {
              $storename = $this->input->post('txt_storename');
          }

          if ($this->input->post('chkbox_public_message')) {
              $this->_data["chkbox_public_message"] = true;
              $chkbox_public_message = 1;
//              $chkbox_public_message = ($this->input->post('chkbox_public_message') == 1)? 0:1;
          }
      }
      // get total user messages
      $totalNumber = $this->Mowner->getTotalUserMessages($first_message, $user_name, $storename, $chkbox_public_message);

      // pagination
      $config['base_url'] = base_url('index.php/admin/request/firstMessageBonusList');
      $config['total_rows'] = $totalNumber;
      $config['constant_num_links'] = TRUE;
      $config['uri_segment'] = 4;
      $config["per_page"] = $msg_per_page = $this->config->item('per_page');
      $this->pagination->initialize($config);

      $start = intval($this->uri->segment(4));
      if ($start == NULL) {
        $start = 0;
      }

      // get user messages
      $messages = $this->Mowner->getUserMessages($msg_per_page, $start, $first_message, $user_name, $storename, $chkbox_public_message);
//var_dump($messages);
      $this->_data["loadPage"] ="request/first_message_bonus_list";
      $this->_data["titlePage"]="ユーザーからの問い合わせ一覧";
      foreach ($messages as $key => $val) {
        if ($val['is_read_flag'] == 0 && $val['is_replied_flag'] == 1 && $val['owner_res_flag'] == 1 && $val['public_flag'] == 0) {
          $messages[$key]['public_flag_style'] = true;
        } else {
          $messages[$key]['public_flag_style'] = false;
        }
      }
      $this->_data['messages'] = $messages;
      if ($this->input->post('ajax')!=null) {
          $this->load->view("request/first_message_bonus_list",$this->_data);
      } else {
          $this->load->view($this->_data["module"]."/layout/layout",$this->_data);
      }
    }
    //download csv of firstmessageslist
    public function downloadFirstMessageCsv(){
        //Download CSV
        $this->load->Model('owner/Mowner');
        $limit = 5000;

        $first_message = false; // is first message or not
        $user_name = null; // user real name
        $storename = null; // store name
        if ($this->input->post()) {
            if ($this->input->post('chkbox_first_message')) {
                $this->_data["chkbox_first_message"] = true;
                $first_message = true;
            }
            $storename = $this->input->post('txt_storename');
            if ($this->input->post('txt_member_name')) {
                $user_name = $this->input->post('txt_member_name');
            }
            if ($this->input->post('txt_storename')) {
                $storename = $this->input->post('txt_storename');
            }
        }
        $messages = $this->Mowner->getUserMessages($limit, 0, $first_message, $user_name, $storename);

        $data = array();
        $result = array( 'ID', '会員名前', '日時', '店舗ＩＤ', '店舗名', '内容', '初回メッセージかどうか');
        $result1 = array();
        array_push($data, $result);
        foreach ($messages as $value) {
            $result = array(($value['unique_id']? $value['unique_id']:'非会員'), ($value['users_name'] ? $value['users_name'] : $value['none_member_name']), $value['created_date'],$value['owner_id'],$value['storename'], $value['content'], ($value['first_message_flag']==1?"初回メッセージ":''));
            array_push($data, $result);
        }
        $str=$this->_arrayToCsv($data);
        $this->load->helper('download');
        $nameFile="resultFirstMessages".date("Ymd").".csv";
        force_download($nameFile, $str);
    }
    private function _arrayToCsv( array $fields, $delimiter = ',', $enclosure = '"', $encloseAll = false, $nullToMysqlNull = false ) {
        $delimiter_esc = preg_quote($delimiter, '/');
        $enclosure_esc = preg_quote($enclosure, '/');

        $outputString = "";
        foreach($fields as $tempFields) {
            $output = array();
            foreach ( $tempFields as $field ) {
                if ($field === null && $nullToMysqlNull) {
                    $output[] = 'NULL';
                    continue;
                }

                // Enclose fields containing $delimiter, $enclosure or whitespace
                if ( $encloseAll || preg_match( "/(?:${delimiter_esc}|${enclosure_esc}|\s)/", $field ) ) {
                    $field = $enclosure . str_replace($enclosure, $enclosure . $enclosure, $field) . $enclosure;
                }
                $output[] = $field." ";
            }
            $outputString .= implode( $delimiter, $output )."\r\n";
        }
        return mb_convert_encoding($outputString,'Shift-JIS','UTF-8');
    }

    public function declineMsgBonus(){
      if ($this->input->post()) {
        $msg_id = $this->input->post('msgid');
        $user_id = $this->input->post('userid');
        $noneuserid = $this->input->post('noneuserid');
        $first_message_flag = $this->input->post('first_message_flag');
        $this->load->Model('owner/Mowner');
        $ret = $this->Mowner->declineMessageBonusPoint($user_id, $noneuserid, $msg_id, USER_FIRST_MSG_BONUS, $first_message_flag);
        if ($ret == true) {
          echo json_encode(true);
        }else{
          echo json_encode(false);
        }
      }
      exit;
    }

    public function editUserMessage() {
      $this->Mowner->updateListUserOwnerMessage(array('content' => $this->input->post('content')), $this->input->post('msg_id'));
      exit;
    }

    public function makia_user() {
      $where = '';
      $start = 0;
      $this->_data["loadPage"]="request/makia_user";
      $this->_data["titlePage"]="マキアユーザー";
      if($_POST) {
        $this->_data['txtUserUniqueId'] = $uniqueId = trim($this->input->post('txtUserUniqueId'));
        $this->_data['txtUserName'] = $name = trim($this->input->post('txtUserName'));
        $this->_data['txtUserInquiryAmount'] = trim($this->input->post('txtUserInquiryAmount'));
        $this->_data['websiteType'] = $websiteType = trim($this->input->post('websiteType'));
        $this->_data['receivedBonusFlag'] = $receivedBonusFlag = trim($this->input->post('receivedBonusFlag'));
        $this->_data['txtReceiveBonusDateFrom'] = $txtReceiveBonusDateFrom = trim($this->input->post('txtReceiveBonusDateFrom'));
        $this->_data['txtReceiveBonusDateTo'] = $txtReceiveBonusDateTo = trim($this->input->post('txtReceiveBonusDateTo'));

        if($uniqueId != "")
          $where.=" AND us.unique_id LIKE '%".$this->db->escape_like_str($uniqueId)."%' ";
        if($name != "")
          $where.=" AND us.name LIKE '%".$this->db->escape_like_str($name)."%' ";

        if($websiteType != "") {
          if($websiteType != -1) {
            $where.=" AND us.website_id = ".$this->db->escape_str($websiteType);
          }
        }
        if($receivedBonusFlag != "") {
          if($receivedBonusFlag != -1) {
            $where.=" AND us.received_bonus_flag = ".$this->db->escape_str($receivedBonusFlag);
          }
        }

        if($txtReceiveBonusDateFrom != "")
          $where.=" AND DATE_FORMAT(us.received_bonus_datetime,'%Y/%m/%d') >= '".$this->db->escape_str($txtReceiveBonusDateFrom)."' ";
        if($txtReceiveBonusDateTo != "")
          $where.=" AND DATE_FORMAT(us.received_bonus_datetime,'%Y/%m/%d') <= '".$this->db->escape_str($txtReceiveBonusDateTo)."' ";

        $this->load->Model("admin/Msearch");
        $totalNumber = $this->Msearch->countMakiaUsers($where);
        //Start Page
        $config['base_url'] = base_url('index.php/admin/request/makia_user');
        $config['total_rows'] = $totalNumber;
        $config['constant_num_links'] = TRUE;
        $config['uri_segment']=4;
        $config["per_page"]=$this->config->item('per_page');
        $config['use_page_numbers'] = TRUE;
        $this->pagination->initialize($config);
        $start1 = $this->uri->segment(4);
        if($start1!=NULL) $start=$start1;
        $this->_data["records"]=$this->Msearch->searchMakiaUsers($where, $config['per_page'], $start);
        $this->_data["totalNumber"] = $totalNumber;
        $this->_data['where'] = $where;
        $this->_data['number'] = $config['per_page'];
        $this->_data['start'] = $start;
      }
      if($this->input->post('ajax')!=null)
        $this->load->view("request/makia_user",$this->_data);
      else
        $this->load->view($this->_data["module"]."/layout/layout",$this->_data);
    }

    public function changeTelephoneRecord() {
      $this->load->Model("user/Musers");
      $id = $this->input->post('id');
      $tel_record_flag = $this->input->post('tel_record_flag');
      $telephone_record = ($tel_record_flag == 0) ? 0 : 1;
      $this->Musers->update_telephone_record($id,$telephone_record);
    }
}
?>

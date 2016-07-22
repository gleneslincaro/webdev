<?php
    class Mail extends MX_Controller{
    protected $_data;
    private $message = array('success' => true, 'error' => array());

    public function __construct() {
        parent::__construct();
        AdminControl::CheckLogin();
        $this->_data["module"] = $this->router->fetch_module();
        $this->load->Model("admin/mmail");
		$this->load->library('common');
        $this->load->library('cipher');
        $this->form_validation->CI =& $this;
        $this->lang->load('list_message', 'english');
        $this->output->set_header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate");
        $this->output->set_header("Cache-Control: post-check=0, pre-check=0");
        $this->output->set_header("Pragma: no-cache");

        HelperApp::start_session();
    }

    /**
    * @author  [IVS] Ho Quoc Huy
    * @name 	company_after
    * @todo 	Go to mail/company.php
    * @param
    * @return
    */
    public function company_after(){
        $this->_data["info"] = null;
        $this->_data["listEmail"] = null;
        $this->_data["loadPage"]="mail/company";
        $this->_data["titlePage"]="メルマガ・会社・店舗検索項目";
        $this->load->view($this->_data["module"]."/layout/layout",$this->_data);
    }

    /**
    * @author  [IVS] Ho Quoc Huy
    * @name 	searchSendMailOwner
    * @todo 	search Owner to send Email
    * @param
    * @return 	return data_info
    */
    public function searchSendMailOwner(){
        $start = 0;
        //get info of shop
        $emailAddress = trim($this->input->post('txtEmailAddress'));
        $storeName = trim($this->input->post('txtStoreName'));
        $lastLoginTo = trim($this->input->post('txtLastLoginTo'));
        $lastLoginFrom = trim($this->input->post('txtLastLoginFrom'));
        $note = trim($this->input->post('txtNote'));
        $styleShopClub = trim($this->input->post('sltShopClubs'));

             //init sql query to search shop

        $array= $this->mmail->getSearchShopNameQuery($emailAddress,$storeName,$note,$lastLoginFrom,$lastLoginTo,$styleShopClub);
        $sql = $array[0];
        $params = $array[1];
        //get totalRows
        $countRows  = $this->mmail->countDataByQuery($sql,$params);

        //get totalRecords
        $this->_data["listEmail"] = $this->mmail->getDataByQuery($sql,$params);


        //init config to paging
        $config['base_url'] = base_url().'admin/mail/searchSendMailOwner';
        $config['total_rows'] = $countRows;
        $config['constant_num_links'] = TRUE;
        $config['uri_segment']=4;
        $config["per_page"]=$this->config->item('per_page');
        $this->load->library("pagination",$config);
        $this->pagination->initialize($config);

        //start1 has value after clicking paging link
        $start1 = $this->uri->segment(4);
        if($start1!=NULL) $start=$start1;

        //data_info show data with paging
        $this->_data["info"] = $this->mmail->searchDataToShow($sql,$this->config->item('per_page'),$start,$params);
        $this->pagination->create_links();
        $this->_data["totalRows"] = $countRows;
        $this->_data["loadPage"]="mail/company";
        $this->_data["titlePage"]="メルマガ・会社・店舗検索項目";

        //paging by ajax
        if($this->input->post('ajax')!=null){
           $this->load->view("mail/company",$this->_data);
        }else{
            $this->load->view($this->_data["module"]."/layout/layout",$this->_data);
        }
    }

    /**
    * @author  [IVS] Ho Quoc Huy
    * @name 	sendMailOwners
    * @todo 	go to mail/comp_mail_creat.php
    * @param
    * @return
    */
    public function sendMailOwners(){
         $uid=$this->input->post('arrayEmail');

        if($uid==""){
            redirect(base_url()."admin/system/errorPage");
        }
        $this->_data["array"] =$this->input->post('arrayEmail');
        $this->_data["flag"]='00';
        $this->_data["info"] = null;

        $this->_data["send_date"] = date("Y-m-d-H-i-s");
        $this->_data["loadPage"]="mail/comp_mail_creat";
        $this->_data["titlePage"]="メルマガ・会社・店舗検索";
        $this->load->view($this->_data["module"]."/layout/layout",$this->_data);
    }


    /**
    * @author  [IVS] Ho Quoc Huy
    * @name 	getDateTime
    * @todo 	get current time
    * @param
    * @return 	string
    */
    public function getDateTime(){

        echo $today = date("Y-m-d-H-i-s");
    }

    /**
    * @author  [IVS] Ho Quoc Huy
    * @name 	checkDateTime
    * @todo 	check send_date  and insert record to Mail_queue
    * @param
    * @return 	string result
    */
    public function checkDateTime(){
        //get data from url

        $send_date =$this->input->post('dataDate');
        $title =$this->input->post('title');
        $listEmail =$this->input->post('listEmail');
        $fromEmail =$this->input->post('fromEmail');
        $context =$this->input->post('context');
        $temp_send_date = strtotime($send_date);
        $time_now = time();

        //check validation
        $this->form_validation->set_rules('context','内容', 'required');
        $this->form_validation->set_rules('title','見出し', 'required');
        $this->form_validation->set_rules('fromEmail','メールアドレス', 'required|valid_email');
        $form_validation = $this->form_validation->run($this);
        if($form_validation==false){
            echo "Please insert Title,Email and Email_body";
        }else if($temp_send_date<$time_now){
           echo "配信日時が過去の時間帯になっています。再設定して下さい。";
        }else{
            //insert data to mail_queue
            $this->mmail->insertInfoToMailQueue($fromEmail,$title,$listEmail,$context,$send_date);
           echo "Insert success";
        }

    }

    /**
    * @author  [IVS] Ho Quoc Huy
    * @name 	searchUser
    * @todo 	Go to mail/user.php
    * @param
    * @return
    */
    public function searchUser(){
        $this->_data["info"] = null;
        $this->_data["listEmail"] = null;
        $this->_data["loadPage"]="mail/user";
        $this->_data["titlePage"]="ユーザー検索";
        $this->load->view($this->_data["module"]."/layout/layout",$this->_data);
    }

    /**
    * @author  [IVS] Ho Quoc Huy
    * @name 	searchUsers_after
    * @todo 	search User
    * @param
    * @return 	return data_info
    */
    public function searchUsers_after(){
        $start = 0;
        //get info of Users
        $systemID = trim($this->input->post('txtSystemID'));
        $emailAddress = trim($this->input->post('txtEmailAddress'));
        $userName = trim($this->input->post('txtUserName'));
        $lastLoginTo = trim($this->input->post('txtLastLoginTo'));
        $lastLoginFrom = trim($this->input->post('txtLastLoginFrom'));
        $scout_date_start = trim($this->input->post('scout_date_start'));
        $scout_date_end = trim($this->input->post('scout_date_end'));
        $rec_money_range_start = trim($this->input->post('rec_money_range_start'));
        $rec_money_range_end = trim($this->input->post('rec_money_range_end'));
        $note = trim($this->input->post('txtNote'));
        $statusOfRegistration = trim($this->input->post('sltStatusOfRegistration'));
        $bonus_grant = trim($this->input->post('bonus_grant'));
        $this->_data['bonus_grant'] = $bonus_grant;
        //init sql query to search shop
        $user_from_site = '0,1,2,3';
        $array = $this->mmail->getSearchUserQuery($systemID, $emailAddress,$userName, $note,
                            $lastLoginFrom,$lastLoginTo,$statusOfRegistration, $bonus_grant,
                            $scout_date_start, $scout_date_end, $rec_money_range_start, $rec_money_range_end, $user_from_site);

        $sql = $array[0];
        $params = $array[1];
        //get totalRows
        $countRows  = $this->mmail->countDataByQuery($sql,$params);

        //get totalRecords
        $this->_data["listEmail"] = $this->mmail->getDataByQuery($sql,$params);

        //init config to paging
        $config['base_url'] = base_url().'admin/mail/searchUsers_after';
        $config['total_rows'] = $countRows;

        $config['constant_num_links'] = TRUE;
        $config['uri_segment']=4;
        $config["per_page"]=$this->config->item('per_page');
        $this->load->library("pagination",$config);
        $this->pagination->initialize($config);

        //start1 has value after clicking paging link
        $start1 = $this->uri->segment(4);
        if($start1!=NULL) $start=$start1;

        //data_info show data with paging
        $this->_data["info"] = $this->mmail->searchDataToShow($sql,$config['per_page'],$start,$params);
        $this->pagination->create_links();
        $this->_data["totalRows"] = $countRows;
        $this->_data["loadPage"]="mail/user";
        $this->_data["titlePage"]="ユーザー検索";

        //paging by ajax
        if ($this->input->post('ajax') != null){
            if ($this->input->post('new_newsletter_flag') != null) {
                $this->load->view("mail/new_user",$this->_data);
            } else {
                $this->load->view("mail/user",$this->_data);
            }
        }else{
            $this->load->view($this->_data["module"]."/layout/layout",$this->_data);
        }
    }

    /**
    * @author  [IVS] Ho Quoc Huy
    * @name 	sendEmailUsers
    * @todo 	Go to mail/user_mail_creat.php
    * @param
    * @return
    */
    public function sendEmailUsers(){
        $uid=$this->input->post('arrayEmail');
            if($uid==""){
                redirect(base_url()."admin/system/errorPage");
            }
        $this->_data["array"] =$this->input->post('arrayEmail');
        $this->_data["flag"]='00';
        $this->_data["info"] = null;
        $this->_data["send_date"] = date("Y-m-d-H-i-s");
        $this->_data["loadPage"]="mail/user_mail_creat";
        $this->_data["titlePage"]="メルマガ・会社・店舗検索";
        $this->load->view($this->_data["module"]."/layout/layout",$this->_data);

    }

    /**
    * @author  [IVS] Ho Quoc Huy
    * @name 	goToSendLog
    * @todo 	Go to mail/send_log.php
    * @param
    * @return
    */
    public function goToSendLog(){
        $this->_data["info"] = null;
        $this->_data["listEmail"] = null;
        $this->_data["loadPage"]="mail/send_log";
        $this->_data["titlePage"]="joyspe管理画面";
        $this->load->view($this->_data["module"]."/layout/layout",$this->_data);
    }

    /**
    * @author  [IVS] Ho Quoc Huy
    * @name 	searchLog
    * @todo 	go to mail/searchLog
    * @param
    * @return 	return data_info
    */
    public function searchLog(){
        $start = 0;
        //get info of Logs
        $lastLoginTo = trim($this->input->post('txtLastLoginTo'));
        $lastLoginFrom = trim($this->input->post('txtLastLoginFrom'));

        //init sql query to search shop
        $array = $this->mmail->getSearchLogQuery($lastLoginFrom,$lastLoginTo);
        $sql = $array[0];
        $params = $array[1];
        //get totalRows
        $countRows  = $this->mmail->countDataByQuery($sql,$params);

        //init config to paging
        $config['base_url'] = base_url().'admin/mail/searchLog';
        $config['total_rows'] = $countRows;
        $config['constant_num_links'] = TRUE;
        $config['uri_segment']=4;
        $config["per_page"]=$this->config->item('per_page');
        $this->load->library("pagination",$config);
        $this->pagination->initialize($config);

        //start1 has value after clicking paging link
        $start1 = $this->uri->segment(4);
        if($start1!=NULL) $start=$start1;

        //data_info show data with paging
        $this->_data["info"] = $this->mmail->searchDataToShow($sql,$this->config->item('per_page'),$start,$params);
        $this->pagination->create_links();
        $this->_data["loadPage"]="mail/send_log";
        $this->_data["titlePage"]="joyspe管理画面";
        $this->_data["countRows"] = $countRows;
        //paging by ajax
        if($this->input->post('ajax')!=null){
           $this->load->view("mail/send_log",$this->_data);
        }else{
            $this->load->view($this->_data["module"]."/layout/layout",$this->_data);
        }
    }

    /**
    * @author  [IVS] Ho Quoc Huy
    * @name 	showLog_browse
    * @todo 	Go to mail/sendlog_browse.php
    * @param
    * @return
    */
    public function showLog_browse(){
        $uid=trim($this->input->get('message_id'));
        $this->_data["detail"]=$this->mmail->getMessageByID($uid);
           if(empty($this->_data["detail"]) || $uid==""){
                redirect(base_url()."admin/system/errorPage");
            }
        $this->_data["info"] = null;
        $this->_data["listEmail"] = null;
        $this->_data["loadPage"]="mail/sendlog_browse";
        $this->_data["titlePage"]="メルマガ・会社・店舗検索";

        //get data to query
        $messageID = trim($this->input->get('message_id'));

         //search data to show
         $this->_data["info"] = $this->mmail->getMessageByID($messageID);

         $this->load->view($this->_data["module"]."/layout/layout",$this->_data);
    }

    /**
    * @author  [IVS] Ho Quoc Huy
    * @name 	showLog_edit
    * @todo 	Go to mail/sendlog_edit.php
    * @param
    * @return
    */
    public function showLog_edit(){
        $uid=trim($this->input->get('message_id'));
        $this->_data["detail"]=$this->mmail->getMessageByID($uid);
           if(empty($this->_data["detail"]) || $uid==""){
                redirect(base_url()."admin/system/errorPage");
            }
        if($_POST){
            $this->checkValidateFormLog();
        }else {
        $this->_data["flag"]='00';

        $this->_data["info"] = null;
        $this->_data["listEmail"] = null;
        $this->_data["loadPage"]="mail/sendlog_edit";
        $this->_data["titlePage"]="メルマガ・会社・店舗検索";

        //get data to query

        $messageID = trim($this->input->get('message_id'));
        //search data to show
        $this->_data["info"] = $this->mmail->getMessageByID($messageID);
        $this->_data["send_date"] = $this->_data["info"]["send_date"];

        $this->load->view($this->_data["module"]."/layout/layout",$this->_data);
        }
    }


    /**
    * @author  [IVS] Ho Quoc Huy
    * @name 	insertToListMessage
    * @todo 	update data into  mail_queue
    * @param 	$title,$context,$send_date,$messageID
    * @return 	string result
    */
    public function insertToListMessage(){
        //get data from url
        $send_date =$this->input->post('txtDate');
        $title =$this->input->post('txtTitle');
        $context =$this->input->post('txtContent');
        $messageID =$this->input->post('messageID');
        //update data into mail_queue
        $this->mmail->updateTemplateContent($title,$context,$send_date,$messageID);
        //echo $send_date."@@".$title."@@".$context."@@".$messageID;
    }

    /**
    * @author  [IVS] Ho Quoc Huy
    * @name 	deactiveMessage
    * @todo 	deactive Message in mail_queue
    * @param
    * @return 	string result
    */
    public function deactiveMessage(){
        //get data from url
        $messageID =$this->input->post('messageID');

        //deactive message by ID (display_flag = '0')
        $this->mmail->deactiveMessage($messageID);
        echo "Deactive message successfully";
    }

          /**
    * @author  [IVS] Ho Quoc Huy
    * @name 	checkValidateFormOwner
    * @todo 	check validation in comp_mail_create page
    * @param
    * @return 	flag string
    */
    public function checkValidateFormOwner(){
        $year =$this->input->post('sltYear');
        $month =$this->input->post('sltMonth');
        $day =$this->input->post('sltDay');
        $hour =$this->input->post('sltHour');
        $minute =$this->input->post('sltMinute');
        $temp_minute = $minute+1;
        $post_send_date = $year."-".$month."-".$day." ".$hour.":".$minute;
        $send_date = $year."-".$month."-".$day." ".$hour.":".$temp_minute;
        //convert string to datetime style

        $temp_send_date = strtotime($send_date);
        $time_now = time();
        $this->_data["flag"]='00';
        $this->form_validation->set_rules('txtFromEmail', 'メールアドレス', 'trim|required|valid_email');
        $this->form_validation->set_rules('txtTitle', '見出し', 'trim|required|max_length[200]');
        $this->form_validation->set_rules('context', '内容', 'trim|required|max_length[50000]');
        $form_validation = $this->form_validation->run();
        $this->message['success'] = !$form_validation && count($_POST) > 0 ? FALSE : TRUE;
       if ($form_validation==false) {
            $this->_data['message']= $this->message;
        }else if($temp_send_date<$time_now){
            $this->_data["flag"]='11';
            $msg =  $this->lang->line('checkAuto_sent_date');
            $this->_data["error_message"]= $msg;
        }else{
             $this->_data["flag"]='22';

        }

        $this->_data["send_date"] = $post_send_date;
        $this->_data["context"] =$this->input->post('context');
        $this->_data["txtTitle"] =$this->input->post('txtTitle');
        $this->_data["array"] =$this->input->post('arrayEmail');
        $this->_data["loadPage"]="mail/comp_mail_creat";
        $this->_data["titlePage"]="メルマガ・会社・店舗検索項目";
        $this->load->view($this->_data["module"]."/layout/layout",$this->_data);
    }

        /**
    * @author  [IVS] Ho Quoc Huy
    * @name 	insertToMailQueue
    * @todo 	insert data to MailQueue Table
    * @param 	$fromEmail,$title,$listEmail,$context,$send_date,$type
    * @return
    */
    public function insertToMailQueue(){
        //get data from url
        $context =$this->input->post('context');
        $title =$this->input->post('txtTitle');
        $listEmail =$this->input->post('arrayEmail');
        $send_date =$this->input->post('txtDate');
        $fromEmail =$this->input->post('txtFromEmail');
        $type =$this->input->post('type');
        $this->mmail->insertInfoToMailQueue($fromEmail,$title,$listEmail,$context,$send_date,$type);
    }

              /**
    * @author  [IVS] Ho Quoc Huy
    * @name 	mailcomp
    * @todo 	go to mail_comp.php
    * @param
    * @return
    */
    public function mailcomp(){
        //get data from url
        $this->_data["info"] = null;
        $this->_data["listEmail"] = null;
        $this->_data["count"]=$this->uri->segment(4);
        $this->_data["loadPage"]="mail/mail_comp";
        $this->_data["titlePage"]="メルマガ配信";
        $this->load->view($this->_data["module"]."/layout/layout",$this->_data);
    }

         /**
    * @author  [IVS] Ho Quoc Huy
    * @name 	checkValidateFormUser
    * @todo 	check validation in user_mail_creat page
    * @param
    * @return 	flag string
    */
    public function checkValidateFormUser(){
        $year =$this->input->post('sltYear');
        $month =$this->input->post('sltMonth');
        $day =$this->input->post('sltDay');
        $hour =$this->input->post('sltHour');
        $minute =$this->input->post('sltMinute');
        $temp_minute = $minute+1;
        $post_send_date = $year."-".$month."-".$day." ".$hour.":".$minute;
        $send_date = $year."-".$month."-".$day." ".$hour.":".$temp_minute;
        //convert string to datetime style

        $temp_send_date = strtotime($send_date);
        $time_now = time();
        $this->_data["flag"]='00';
        $this->form_validation->set_rules('txtFromEmail', 'メールアドレス', 'trim|required|valid_email');
        $this->form_validation->set_rules('txtTitle', '見出し', 'trim|required|max_length[200]');
        $this->form_validation->set_rules('context', '内容', 'trim|required|max_length[50000]');
        $form_validation = $this->form_validation->run();
        $this->message['success'] = !$form_validation && count($_POST) > 0 ? FALSE : TRUE;
       if ($form_validation==false) {
            $this->_data['message']= $this->message;
        }else if($temp_send_date<$time_now){
            $this->_data["flag"]='11';
            $msg =  $this->lang->line('checkAuto_sent_date');
            $this->_data["error_message"]= $msg;
        }else{
             $this->_data["flag"]='22';

        }

        $this->_data["send_date"] = $post_send_date;
        $this->_data["context"] =$this->input->post('context');
        $this->_data["txtTitle"] =$this->input->post('txtTitle');
        $this->_data["array"] =$this->input->post('arrayEmail');
        $this->_data["loadPage"]="mail/user_mail_creat";
        $this->_data["titlePage"]="joyspe管理画面";
        $this->load->view($this->_data["module"]."/layout/layout",$this->_data);
    }

    /**
    * @author  [IVS] Ho Quoc Huy
    * @name 	checkValidateFormLog
    * @todo 	check validation in sendlog_edit page
    * @param
    * @return 	flag string
    */
    public function checkValidateFormLog(){
        $year =$this->input->post('sltYear');
        $month =$this->input->post('sltMonth');
        $day =$this->input->post('sltDay');
        $hour =$this->input->post('sltHour');
        $minute =$this->input->post('sltMinute');
        $temp_minute = $minute+1;
        $post_send_date = $year."-".$month."-".$day." ".$hour.":".$minute;
        $send_date = $year."-".$month."-".$day." ".$hour.":".$temp_minute;
        //convert string to datetime style

        $temp_send_date = strtotime($send_date);
        $time_now = time();
        $this->_data["flag"]='00';
        $this->form_validation->set_rules('txtTitle', '見出し', 'trim|required|max_length[200]');
        $this->form_validation->set_rules('txtContent', '内容', 'trim|required|max_length[50000]');
        $form_validation = $this->form_validation->run();
        $this->message['success'] = !$form_validation && count($_POST) > 0 ? FALSE : TRUE;
        if ($form_validation==false) {
            $this->_data['message']= $this->message;
        }else if($temp_send_date<$time_now){
            $this->_data["flag"]='11';
            $msg =  $this->lang->line('checkAuto_sent_date');
            $this->_data["error_message"]= $msg;
        }else{
             $this->_data["flag"]='22';

        }

        $this->_data["send_date"] = $post_send_date;
        $this->_data["info"]["send_date"] =$post_send_date;
        $this->_data["info"]["content"] =$this->input->post('txtContent');
        $this->_data["info"]["title"] =$this->input->post('txtTitle');
        $this->_data["info"]["id"] =$this->input->post('txtMessageID');
        $this->_data["loadPage"]="mail/sendlog_edit";
        $this->_data["titlePage"]="メルマガ・会社・店舗検索";
        $this->load->view($this->_data["module"]."/layout/layout",$this->_data);
    }
    /**
    * @author  [IVS] Ho Quoc Huy
    * @name 	sendcomp
    * @todo 	go to mail/send_comp
    * @param
    * @return
    */
    public function sendcomp(){
        //get data from url
        $this->_data["info"] = null;
        $this->_data["listEmail"] = null;
        $this->_data["loadPage"]="mail/send_comp";
        $this->_data["titlePage"]="メルマガ配信";
        $this->load->view($this->_data["module"]."/layout/layout",$this->_data);
    }

    /**
    * @author  [IVS] Ho Quoc Huy
    * @name 	deactiveMail
    * @todo 	go to mail/cancel
    * @param
    * @return
    */
    public function deactiveMail(){
        //get data from url
        $this->_data["info"] = null;
        $this->_data["listEmail"] = null;
        $this->_data["loadPage"]="mail/cancel";
        $this->_data["titlePage"]="メルマガ配信";
        $this->load->view($this->_data["module"]."/layout/layout",$this->_data);
    }
    public function newsLetter() {
        $this->load->model('owner/Mpoint');
        $arrayEmail = $this->input->post('arrayEmail');
        $from = $this->input->post('txtFromEmail');
        $template_title = $this->input->post('txtTitle');
        $template_body = $this->input->post('context');
        $owner_id = $this->input->post('owner');
        $set_send_mail = $this->input->post('set_send_mail') == 1? true: false;
        $arrEmail = explode(",", $arrayEmail);
        if ($arrEmail && is_array($arrEmail)) {
            foreach($arrEmail as $email) {
                $mail_data = $this->mmail->get_unread_message($email);
                $curr_bonus_money = ($mail_data['bonus_money'] ? $mail_data['bonus_money'] : 0) . '円';
                $this->sendNewsMail($template_body, $template_title, $email, $owner_id, $from, $set_send_mail,$curr_bonus_money);
            }
        }
    }

    public function userNewMailQueue () {
        $this->load->model('owner/Mpoint');
        $arrayEmail = $this->input->post('arrayEmail');
        $from = $this->input->post('txtFromEmail');
        $template_title = $this->input->post('txtTitle');
        $template_body = $this->input->post('context');
        $owner_id = $this->input->post('owner');
        $set_send_mail = $this->input->post('set_send_mail') == 1? true: false;
        $arrEmail = explode(",", $arrayEmail);

        $data = array(
                'owner_id' => $owner_id,
                'to_mail' => $arrayEmail,
                'from_mail' => $from,
                'title' => $template_title,
                'content' => $template_body,
                'set_send_mail' => $set_send_mail,
                'created_date' => date('Y-m-d')
            );
        $ret = $this->mmail->insertListUserMailGroup($data);
        if ($ret) {
            echo count($arrEmail);
        } else {
            echo 'error';
        }
        
    }

    public function searchUserNewMailQueue($page = 0) {
        if ($this->input->post()) {
            
            if ($this->input->post('btn_send')) {
                $id = $this->input->post('btn_send');
                foreach ($id as $key => $value) {
                    $id = $value;
                }
                redirect(base_url() . 'admin/mail/sendingMail/' . $id);
                exit;
            }

            if ($this->input->post('btn_disable')) {
                $id = $this->input->post('btn_disable');
                foreach ($id as $key => $value) {
                    $id = $value;
                }
                $data = array('display_flag' => 0);
                $this->mmail->modifyListUserMailGroup($id, $data);
            }
        }

        $queue_mails = array();
        $queue_mail = $this->mmail->allListUserMailGroup();
        $number_display = $this->config->item('per_page'); // number of list display
        $uri_segment = 4; // pagination max number display

        $config = array();
        $config["base_url"] = base_url() .'admin/mail/searchUserNewMailQueue/';
        $config["total_rows"] = count($queue_mail);
        $config["per_page"] = $number_display;
        $config["uri_segment"] = $uri_segment;
        $config['constant_num_links'] = TRUE;
        $this->load->library("pagination",$config);
        $this->pagination->initialize($config);

        $this->_data["links"] = $this->pagination->create_links();
        //$queue_mail = array_slice($queue_mail, $page, $number_display);

        $queue_mail = array_slice($queue_mail, $page, $number_display);
        foreach ($queue_mail as $index => $in) {
            $queue_mail[$index]['count_mail'] = count(explode(',', $in['to_mail']));
        }

        $this->_data["info"] = null;
        $this->_data["listEmail"] = null;
        $this->_data["loadPage"]="mail/user_mail_queue_list";
        $this->_data["titlePage"]="メルマガ配信";
        $this->_data["queue_mail"] = $queue_mail;
        $this->load->view($this->_data["module"]."/layout/layout",$this->_data);
    }

    public function sendingMail($id = 0){
        if ($this->input->post()) {
            $ret = true;
            $id = $this->input->post('id');
            $group_id = $id;
            $email = $this->input->post('email_address');
            $queue_mail = $this->mmail->idListUserMailGroup($id);
            $isSend = $this->mmail->getMsgEmailmailGroup($id, $email);

            if (!$isSend) {
                $mail_data = $this->mmail->get_unread_message($email);
                $curr_bonus_money = ($mail_data['bonus_money'] ? $mail_data['bonus_money'] : 0) . '円';
                $ret = $this->sendNewsMail($queue_mail['content'], $queue_mail['title'], $email, $queue_mail['owner_id'], $queue_mail['from_mail'], $queue_mail['set_send_mail'], $curr_bonus_money, $group_id);
            } if (count($isSend) != 0) {
                $ret = 'already send';
            }

            echo json_encode(array('email' => $email, 'err' => $ret));
            exit();
        } else {
            $queue_mail = $this->mmail->idListUserMailGroup($id);
            $mail_log = $this->mmail->get_magazine_log_mail_group($queue_mail['id']);
            $mail_to_send_count = count(explode(",",$queue_mail['to_mail']));
            $mail_count_send = count($mail_log);

            if (!$queue_mail || ($mail_to_send_count <= $mail_count_send)) {
                redirect(base_url() . 'admin/mail/searchUserNewMailQueue/');
            }

            $this->_data["url"] = 'admin/mail/searchUserNewMailQueue/';
            $this->_data["info"] = null;
            $this->_data["listEmail"] = null;
            $this->_data["loadPage"]="mail/sending_mail";
            $this->_data["titlePage"]="メルマガ配信";
            $this->_data["id"]= $id;
            $this->_data["queue_mail"]= $queue_mail['to_mail'];
            $this->load->view($this->_data["module"]."/layout/layout",$this->_data);
        }
    }

    function sendNewsMail($template_body, $template_title, $email, $owner_id, $from, $set_send_mail,$curr_bonus_money, $group_id = 0) {
        // check parameters
        $this->load->model('owner/Mpoint');
        if (!$template_body || !$template_title || !$email || !$owner_id || !$from) {
            return;
        }
        $phrase = '';
        $payment_msg_status = 1;

        $user_data = $this->Musers->get_users_by_email($email);
        if (!$user_data) {
            return false;
        }

        $password = $user_data['password'];

        $ownerDetail = $this->mmail->getOwnerStat($owner_id);
        $mail_type = 'ss09';
        $lst_ur_msg_id = $this->Mpoint->insertListUserMessage($ownerDetail['id'], $user_data['id'], $mail_type, $payment_msg_status, "");
        if (!$lst_ur_msg_id) {
            return false;
        }

        $encoded_login_str = $this->_encode_login_info($email,$password, $group_id, $lst_ur_msg_id);
        // get mail data(title and body)
        $send_data_info = $this->common->getMailDataFromTemplate($template_title,
                                                                 $template_body,
                                                                 $email,
                                                                 $ownner_recruit_id=$ownerDetail['id'],
                                                                 $content_type = 1,
                                                                 $lst_ur_msg_id,
                                                                 $curr_bonus_money,
                                                                 $encoded_login_str);

        if ($send_data_info) {
            // send to email address
            if (($user_data['set_send_mail'] == 1 && $ownerDetail['owner_status'] != 1) || $set_send_mail) {
                // send mail
                $this->common->sendMailUsingMbSendMail($send_data_info['title'], $send_data_info['body'], $from, $email);
            }
            // sending mail to machemoba
            if($user_data['user_status'] == 1 && $user_data['user_from_site'] == 1 && $ownerDetail['owner_status'] != 1) {
                // add <a> tag to URL
                $pattern = "/(?i)\b((?:https?:\/\/|www\d{0,3}[.]|[a-z0-9.\-]+[.][a-z]{2,4}\/)(?:[^\s()<>]+|\(([^\s()<>]+|(\([^\s()<>]+\)))*\))+(?:\(([^\s()<>]+|(\([^\s()<>]+\)))*\)|[^\s`!()\[\]{};:'\".,<>?«»“”‘’]))/";
                $send_data_info = preg_replace($pattern, "<a href=\"$1\">$1</a>", $send_data_info);
                $other_site_url = REMOTE_LOGIN_SITE_1.'/scoutmail.php';
                $id = $user_data['old_id'];
                $md5_id = md5(MOBA_PREFIX.$id);
                $this->load->model('admin/Msetting');
                $data = $this->Msetting->getNewsPoints();
                $point = 0;
                if ($data) {
                    $point = $data['point'];
                }
                $postdata = array("point" => $point,
                				"loginid" => $md5_id,
                				"scoutmail_title" => $send_data_info['title'],
                				"scoutmail_content" => $send_data_info['body']);
                $ch = curl_init($other_site_url);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
                curl_setopt($ch, CURLOPT_TIMEOUT,50);
                $result = curl_exec($ch);
                curl_close($ch);
            }
        }

        $this->mmail->insertAdminScoutMail($template_body, $template_title, $lst_ur_msg_id);
        return true;
    }
	public function searchUserNew() {
		$this->_data["info"] = null;
		$this->_data["listEmail"] = null;
		$this->_data["loadPage"]="mail/new_user";
		$this->_data["titlePage"]="ユーザー検索";
		$this->load->view($this->_data["module"]."/layout/layout",$this->_data);
	}
	public function searchNewUser_after(){
		$start = 0;
		//get info of Users
		$systemID = trim($this->input->post('txtSystemID'));
		$emailAddress = trim($this->input->post('txtEmailAddress'));
		$userName = trim($this->input->post('txtUserName'));
		$lastLoginTo = trim($this->input->post('txtLastLoginTo'));
        $lastLoginFrom = trim($this->input->post('txtLastLoginFrom'));
        $scout_date_start = trim($this->input->post('scout_date_start'));
		$scout_date_end = trim($this->input->post('scout_date_end'));
        $rec_money_range_start = trim($this->input->post('rec_money_range_start'));
        $rec_money_range_end = trim($this->input->post('rec_money_range_end'));
		$note = trim($this->input->post('txtNote'));
        $statusOfRegistration = trim($this->input->post('sltStatusOfRegistration'));
        $bonus_grant = trim($this->input->post('bonus_grant'));
        $last_login = trim($this->input->post('last_login'));
        $this->_data['bonus_grant'] = $bonus_grant;
        $this->_data['last_login'] = $last_login;
        $user_from_site = $this->input->post('user_from_site');
        $arr_from_site = array();
        if ($_POST) {
            if ($user_from_site) {
                foreach ($user_from_site as $value) {
                    switch ($value) {
                        case 0:
                            $this->_data['joyspe'] = 0;
                            $arr_from_site[] = 0;
                            break;
                        case 1:
                            $this->_data['machemobile'] = 1;
                            $arr_from_site[] = 1;
                            break;
                        case 2:
                            $this->_data['makia'] = 2;
                            $arr_from_site[] = 2;
                            break;
                        case 3:
                            $this->_data['aruaru'] = 3;
                            $arr_from_site[] = 3;
                            break;
                    }
                }
                $user_from_site = implode(',', $arr_from_site);
            } else {
                $user_from_site = 'NULL';
            }
        } else {
            $user_from_site = '0,1,2,3';
        }

		//init sql query to search shop
		$array = $this->mmail->getSearchUserQuery($systemID, $emailAddress, $userName, $note,$lastLoginFrom,
                                $lastLoginTo,$statusOfRegistration, $bonus_grant, $scout_date_start, $scout_date_end,
                                $rec_money_range_start, $rec_money_range_end, $user_from_site, $last_login);
		$sql = $array[0];
		$params = $array[1];
		//get totalRows
		$countRows  = $this->mmail->countDataByQuery($sql, $params);
		//get totalRecords
		$this->_data["listEmail"] = $this->mmail->getDataByQuery($sql, $params);
		//init config to paging
		$config['base_url'] = base_url().'admin/mail/searchNewUser_after';
		$config['total_rows'] = $countRows;
		$config['constant_num_links'] = TRUE;
		$config['uri_segment'] = 4;
		$config["per_page"] = $this->config->item('per_page');
		$this->load->library("pagination",$config);
		$this->pagination->initialize($config);

		//start1 has value after clicking paging link
		$start1 = $this->uri->segment(4);
		if($start1!=NULL) $start=$start1;

		//data_info show data with paging
		$this->_data["info"] = $this->mmail->searchDataToShow($sql,$config['per_page'],$start,$params);
		$this->pagination->create_links();
		$this->_data["totalRows"] = $countRows;
		$this->_data["loadPage"]="mail/new_user";
		$this->_data["titlePage"]="ユーザー検索";

		//paging by ajax
		if ($this->input->post('ajax')!=null){
		   $this->load->view("mail/new_user",$this->_data);
		} else {
			$this->load->view($this->_data["module"]."/layout/layout",$this->_data);
		}
	}
	public function sendEmailUsersNew(){
		$uid=$this->input->post('arrayEmail');
		if($uid==""){
			redirect(base_url()."admin/system/errorPage");
		}
		$owner_id = $this->input->post('txtowner');
		$this->_data["owner_id"] = $this->input->post('owner');
		$this->_data["array"] =$this->input->post('arrayEmail');
		$this->_data["flag"]='00';
		$this->_data["info"] = null;
		$this->_data["send_date"] = date("Y-m-d-H-i-s");
		$this->_data["content"] = $this->mmail->getContentNewsletter();
		$this->_data["owners"] = $this->mmail->getStore();
		$this->_data["loadPage"]="mail/user_mail_create";
		$this->_data["titlePage"]="メルマガ・会社・店舗検索";
		$this->load->view($this->_data["module"]."/layout/layout",$this->_data);
	}
	public function checkValidateFormUserNew(){
		$this->_data["flag"]='00';
		$this->form_validation->set_rules('txtFromEmail', 'メールアドレス', 'trim|required|valid_email');
		$this->form_validation->set_rules('txtTitle', '見出し', 'trim|required|max_length[200]');
		$this->form_validation->set_rules('context', '内容', 'trim|required|max_length[50000]');
        $this->form_validation->set_rules('owner','オーナー','trim|required');
        $set_send_mail = $this->input->post('set_send_mail');
		$form_validation = $this->form_validation->run();
		$this->message['success'] = !$form_validation && count($_POST) > 0 ? FALSE : TRUE;
	   if ($form_validation==false) {
			$this->_data['message']= $this->message;
		}else{
			 $this->_data["flag"]='22';
	   }
        $this->_data["set_send_mail"] =$set_send_mail;
		$this->_data["context"] =$this->input->post('context');
		$this->_data["txtTitle"] =$this->input->post('txtTitle');
		$this->_data["array"] =$this->input->post('arrayEmail');
		$this->_data["owner_id"] = $this->input->post('owner');
		$this->_data["owners"] = $this->mmail->getStore();
		$this->_data["loadPage"]="mail/user_mail_create";
		$this->_data["titlePage"]="joyspe管理画面";
		$this->load->view($this->_data["module"]."/layout/layout",$this->_data);
	}
	public function storeKeyword(){
		$storeKeyword = $this->input->post('keyword');
		$data  = $this->mmail->getStoreByKeyword($storeKeyword);
		echo json_encode($data);
	}

    /**
    * @author  [VJS] Kiyoshi Suzuki
    * @name 	monthlySend
    */
    public function monthlySend(){
        $this->_data["loadPage"]="mail/monthly_send";
        $this->_data["titlePage"]="月次配信";
        $this->load->view($this->_data["module"]."/layout/layout",$this->_data);
    }

    function analysissend() {
        $this->load->Model("owner/Manalysis");
        $this->load->Model("owner/Mowner");

        $day = date('d');
        if($day > 20){
          $from_date =  date('Y-m')."-21 00:00:00";
          $to_date = date('Y-m-').$day." 23:59:59";
        }else{
          $from_date =  date('Y-m', strtotime(date('Y-m-1') . '-1 month'))."-21 00:00:00";
          $to_date = date('Y-m-').$day." 23:59:59";
        }

        $owner_array = $this->Mowner->getSendOwners();
        foreach ($owner_array as $owner){
            $analysis_array = $this->Manalysis->doUserAnalysis($owner['id'],$from_date,$to_date);
            if($owner["month_send_flag"]==1){
                $this->AnalysisMailToOwner($owner['email_address'],$owner['storename'],$analysis_array);
            }
            if($owner["ag_month_send_flag"]==1){
                $this->AnalysisMailToOwner($owner['ag_email_address'],$owner['ag_email_address'],$analysis_array);
            }
        }
        $res = true;
        echo json_encode($res);
    }

    public function AnalysisMailToOwner($to,$storename,$ar){
        $scout_open_rate = round(($ar["scout_open_rate"] * 100),1);
        $message = <<< EOT
{$storename}様

いつもお世話になっております。

ジョイスペ事務局です。

今月度の活動報告を致します。
スカウト送信数　{$ar["scout_mail_send"]}件
開封数　　　　　{$ar["scout_mail_open"]}件
開封率　　　　　{$scout_open_rate}％
アクセス　　　　{$ar["shop_access_num"]}件
ＨＰ　　　　　　{$ar["hp_click_num"]}件
クチコミ　　　　{$ar["kuchikomi_click_num"]}件
電話　　　　　　{$ar["tel_click_num"]}件
Email　　　　　{$ar["mail_click_num"]}件
匿名質問　　　　{$ar["question_num"]}件
面接　　　　　　{$ar["travel_num"]}件
体験入店　　　　{$ar["campaign_bonus_num"]}件
※集計期間は前月21日から今月20日までで集計

以上、ご報告申し上げます。

求人活動の参考になれば幸いでございます。
今後とも何卒よろしくお願いいたします。

-------------------------------------
■ジョイスペサポートセンター
Mail:info@joyspe.com

■サポート対応時間：平日10:00～18:00
土日・祝日を除く
-------------------------------------
EOT;
        mb_language("ja");
        mb_internal_encoding("UTF-8");
        $subject = '【ジョイスペ】月次活動報告';
        $from = "ジョイスペサポートセンター"."<info@joyspe.com>";
        mb_send_mail($to,$subject,$message,'From:'.$from,'-f info@joyspe.com');
        return;
    }

    public function send_complete(){
        $this->_data["loadPage"]="mail/send_complete";
        $this->_data["titlePage"]="月次配信完了";
        $this->load->view($this->_data["module"]."/layout/layout",$this->_data);
    }

    public function create_auto_send_magazine(){
        $start = 0;
        if ($this->input->post()) {
            //get info of Users
            $this->form_validation->set_rules('txtSystemID', 'システムID', 'trim');
            $this->form_validation->set_rules('txtUserName', '氏名', 'trim');
            $this->form_validation->set_rules('txtEmailAddress', 'アドレス', 'trim');
            $this->form_validation->set_rules('txtLastLoginFrom', '最終ログイン ', 'trim');
            $this->form_validation->set_rules('txtLastLoginTo', '最終ログイン ', 'trim');
            $this->form_validation->set_rules('scout_date_start', 'ジョイスペ認証日   ', 'trim');
            $this->form_validation->set_rules('scout_date_end', 'ジョイスペ認証日   ', 'trim');
            $this->form_validation->set_rules('rec_money_range_start', 'これまでの累計報酬獲得金額円', 'trim');
            $this->form_validation->set_rules('rec_money_range_end', 'これまでの累計報酬獲得金額円', 'trim');
            $this->form_validation->set_rules('txtNote', 'メモ', 'trim');
            $sltStatusOfRegistration = trim($this->input->post('sltStatusOfRegistration'));
            $this->_data['userStatus'] = $sltStatusOfRegistration;
            $bonus_grant = trim($this->input->post('bonus_grant'));
            $this->_data['bonus_grant'] = $bonus_grant;

            if ($this->form_validation->run()) {
                $txtSystemID = trim($this->input->post('txtSystemID'));
                $txtEmailAddress = trim($this->input->post('txtEmailAddress'));
                $txtUserName = trim($this->input->post('txtUserName'));
                $txtLastLoginTo = trim($this->input->post('txtLastLoginTo'));
                $txtLastLoginFrom = trim($this->input->post('txtLastLoginFrom'));
                $scout_date_start = trim($this->input->post('scout_date_start'));
                $scout_date_end = trim($this->input->post('scout_date_end'));
                $rec_money_range_start = trim($this->input->post('rec_money_range_start'));
                $rec_money_range_end = trim($this->input->post('rec_money_range_end'));
                $txtNote = trim($this->input->post('txtNote'));
                $this->_data["post_condition"] = serialize($this->input->post());
                $user_from_site = '1,2';
                $array = $this->mmail->getSearchUserQuery($txtSystemID, $txtEmailAddress, $txtUserName, $txtNote,$txtLastLoginFrom,
                                $txtLastLoginTo, $sltStatusOfRegistration, $bonus_grant, $scout_date_start, $scout_date_end,
                                $rec_money_range_start, $rec_money_range_end, $user_from_site);
                $sql = $array[0];
                $params = $array[1];
                //get totalRows
                $countRows  = $this->mmail->countDataByQuery($sql,$params);

                //get totalRecords
                $listEmail= $this->mmail->getDataByQuery($sql,$params);

                //init config to paging
                $config['base_url'] = base_url().'admin/mail/create_auto_send_magazine';
                $config['total_rows'] = $countRows;

                $config['constant_num_links'] = TRUE;
                $config['uri_segment']=4;
                $config["per_page"]=$this->config->item('per_page');
                $this->load->library("pagination",$config);
                $this->pagination->initialize($config);

                //start1 has value after clicking paging link
                $start1 = $this->uri->segment(4);
                if($start1!=NULL) $start=$start1;

                //data_info show data with paging
                $this->_data["info"] = $this->mmail->searchDataToShow($sql,$config['per_page'],$start,$params);
                $this->_data["totalRows"] = $countRows;
            }
        }
        $arrayEmail = '';
        if (isset($listEmail)) {
            foreach($listEmail as $k=>$item){
                if ($k==0) {
                    $arrayEmail = $item["email_address"];
                } else {
                    $arrayEmail = $arrayEmail.','.$item["email_address"];
                }
            }
        }


        $this->_data["arrayEmail"]= $arrayEmail;
        if ($this->input->post('ajax')!=null){
           header('Content-Type: text/html; charset=utf-8');
           $this->load->view("mail/auto_send_magazine_create",$this->_data);
        } else {
            $this->_data["titlePage"]="ユーザー検索";
            $this->_data["loadPage"]="mail/auto_send_magazine_create";
            $this->load->view($this->_data["module"]."/layout/layout",$this->_data);
        }

    }


    public function edit_auto_send_magazine($id){
        if (!$id) {
            redirect('admin/mail/create_auto_send_magazine');
        }

        $this->_data['edit_id'] = $id;
        $start = 0;
        if ($this->input->post()) {
            //get info of Users
            $this->form_validation->set_rules('txtSystemID', 'システムID', 'trim');
            $this->form_validation->set_rules('txtUserName', '氏名', 'trim');
            $this->form_validation->set_rules('txtEmailAddress', 'アドレス', 'trim');
            $this->form_validation->set_rules('txtLastLoginFrom', '最終ログイン ', 'trim');
            $this->form_validation->set_rules('txtLastLoginTo', '最終ログイン ', 'trim');
            $this->form_validation->set_rules('scout_date_start', 'ジョイスペ認証日   ', 'trim');
            $this->form_validation->set_rules('scout_date_end', 'ジョイスペ認証日   ', 'trim');
            $this->form_validation->set_rules('rec_money_range_start', 'これまでの累計報酬獲得金額円', 'trim');
            $this->form_validation->set_rules('rec_money_range_end', 'これまでの累計報酬獲得金額円', 'trim');
            $this->form_validation->set_rules('txtNote', 'メモ', 'trim');
            $sltStatusOfRegistration = trim($this->input->post('sltStatusOfRegistration'));
            $this->_data['userStatus'] = $sltStatusOfRegistration;
            $bonus_grant = trim($this->input->post('bonus_grant'));
            $this->_data['bonus_grant'] = $bonus_grant;

            if ($this->form_validation->run()) {
                $txtSystemID = trim($this->input->post('txtSystemID'));
                $txtEmailAddress = trim($this->input->post('txtEmailAddress'));
                $txtUserName = trim($this->input->post('txtUserName'));
                $txtLastLoginTo = trim($this->input->post('txtLastLoginTo'));
                $txtLastLoginFrom = trim($this->input->post('txtLastLoginFrom'));
                $scout_date_start = trim($this->input->post('scout_date_start'));
                $scout_date_end = trim($this->input->post('scout_date_end'));
                $rec_money_range_start = trim($this->input->post('rec_money_range_start'));
                $rec_money_range_end = trim($this->input->post('rec_money_range_end'));
                $txtNote = trim($this->input->post('txtNote'));
                $this->_data["post_condition"] = serialize($this->input->post());
            }
        } else {
            $mail_magazine_condition = $this->mmail->auto_send_magazine_id($id);
            $data = unserialize($mail_magazine_condition['conditions']);
            $txtSystemID = isset($data['txtSystemID']) ? trim($data['txtSystemID']) : '';
            $txtEmailAddress = isset($data['txtEmailAddress']) ? trim($data['txtEmailAddress']) : '';
            $txtUserName = isset($data['txtUserName']) ? trim($data['txtUserName']) : '';
            $txtLastLoginTo = isset($data['txtLastLoginTo']) ? trim($data['txtLastLoginTo']) : '';
            $txtLastLoginFrom = isset($data['txtLastLoginFrom']) ? trim($data['txtLastLoginFrom']) : '';
            $scout_date_start = isset($data['scout_date_start']) ? trim($data['scout_date_start']) : '';
            $scout_date_end = isset($data['scout_date_end']) ? trim($data['scout_date_end']) : '';
            $rec_money_range_start = isset($data['rec_money_range_start']) ? trim($data['rec_money_range_start']) : '';
            $rec_money_range_end = isset($data['rec_money_range_end']) ? trim($data['rec_money_range_end']) : '';
            $txtNote = isset($data['txtNote']) ? trim($data['txtNote']) : '';

            $sltStatusOfRegistration = isset($data['sltStatusOfRegistration']) ? trim($data['sltStatusOfRegistration']) : '';
            $this->_data['userStatus'] = $sltStatusOfRegistration;
            $bonus_grant = isset($data['bonus_grant']) ? trim($data['bonus_grant']) : '';
            $this->_data['bonus_grant'] = $bonus_grant;
            $this->_data["post_condition"] = $mail_magazine_condition['conditions'];
            $this->_data["condition"] = $data;

        }

        $user_from_site = '1,2';
        $array = $this->mmail->getSearchUserQuery($txtSystemID, $txtEmailAddress, $txtUserName, $txtNote,$txtLastLoginFrom,
                        $txtLastLoginTo, $sltStatusOfRegistration, $bonus_grant, $scout_date_start, $scout_date_end,
                        $rec_money_range_start, $rec_money_range_end, $user_from_site);
        $sql = $array[0];
        $params = $array[1];
        //get totalRows
        $countRows  = $this->mmail->countDataByQuery($sql,$params);

        //get totalRecords
        $listEmail= $this->mmail->getDataByQuery($sql,$params);

        //init config to paging
        $config['base_url'] = base_url().'admin/mail/edit_auto_send_magazine/' . $id . '/';
        $config['total_rows'] = $countRows;

        $config['constant_num_links'] = TRUE;
        $config['uri_segment'] = 5;
        $config["per_page"] = $this->config->item('per_page');
        $this->load->library("pagination",$config);
        $this->pagination->initialize($config);

        //start1 has value after clicking paging link
        $start1 = $this->uri->segment(5);
        if($start1!=NULL) $start = $start1;

        //data_info show data with paging
        $this->_data["info"] = $this->mmail->searchDataToShow($sql,$config['per_page'],$start,$params);
        $this->_data["totalRows"] = $countRows;

        $arrayEmail = '';
        if (isset($listEmail)) {
            foreach($listEmail as $k=>$item){
                if ($k==0) {
                    $arrayEmail = $item["email_address"];
                } else {
                    $arrayEmail = $arrayEmail.','.$item["email_address"];
                }
            }
        }

        $this->_data["arrayEmail"]= $arrayEmail;
        if ($this->input->post('ajax')!=null){
           header('Content-Type: text/html; charset=utf-8');
           $this->load->view("mail/auto_send_magazine_create",$this->_data);
        } else {
            $this->_data["titlePage"]="ユーザー検索";
            $this->_data["loadPage"]="mail/auto_send_magazine_create";
            $this->load->view($this->_data["module"]."/layout/layout",$this->_data);
        }
    }

    public function saveAutoSendMagazine($id = null){
        if (!$_POST['arrayEmail']) {
            redirect('admin/mail/create_auto_send_magazine');
        }
        $this->_data['edit_id'] = $id;
        if ($id) {
            $mail_magazine = $this->mmail->auto_send_magazine_id($id);
            $this->_data["owner_id"] = $mail_magazine['owner_id'];
            $this->_data["title"] = $mail_magazine['title'];
            $this->_data["send_time"] = date("H",strtotime($mail_magazine['send_time']));
        }

        if ($this->input->post() && isset($_POST['btn_save'])) {
            $owner =$this->input->post('owner');
            $context =$this->input->post('context');
            $title =$this->input->post('txtTitle');
            $listEmail =$this->input->post('arrayEmail');
            $send_date =$this->input->post('time_to_send');
            $post_condition =$this->input->post('post_condition');
            $fromEmail =$this->input->post('txtFromEmail');
            $data = array(
                    'owner_id' => $owner,
                    'to_mail' => $fromEmail,
                    'from_mail' => $listEmail,
                    'title' => $title,
                    'content' => $context,
                    'send_time' => $send_date,
                    'conditions' => $post_condition,
                    'created_date' => date("Y-m-d-H-i-s")
                );

            if ($id) {
                $this->mmail->update_mail_queue_magazine($id, $data);
            } else {
                $this->mmail->insert_mail_queue_magazine($data);
            }

            redirect(base_url()."admin/mail/mailcomp/" . count(explode(",", $listEmail)));
        }

        $this->_data["owners"] = $this->mmail->getStore();
        $this->_data["arrayEmail"] = trim($this->input->post('arrayEmail'));;
        $this->_data["post_condition"] = trim($this->input->post('post_condition'));;
        $this->_data["content"] = $this->mmail->get_content_magazine();
        $this->_data["titlePage"]="ユーザー検索";
        $this->_data["loadPage"]="mail/auto_send_magazine_save";
        $this->load->view($this->_data["module"]."/layout/layout",$this->_data);
    }

    public function bookMailMagazine() {
        $start = 0;

        $display_flag = 1;
        $this->_data['sort'] = '';
        if($this->input->post('sort_magazine')) {
            //1 = active , 2 = disable , 3= both
            $display_flag = $this->input->post('sort_magazine');
            $this->_data['sort'] = $display_flag;
            if($display_flag == 2) {
                $display_flag = 0;
            }

        }

        //init config to paging
        $config['base_url'] = base_url().'admin/mail/bookMailMagazine';
        $config['total_rows'] = $this->mmail->countMailQueue($display_flag);

        $config['constant_num_links'] = TRUE;
        $config['uri_segment'] = 4;
        $config["per_page"]=$this->config->item('per_page');
        $this->load->library("pagination",$config);
        $this->pagination->initialize($config);
        //start1 has value after clicking paging link
        $start1 = $this->uri->segment(4);
        if($start1!=NULL) $start= (int)$start1;

        $this->_data["queue_mail"] = $this->mmail->getBookMailMagazine($config['per_page'],$start,$display_flag);
        if ($this->input->post('ajax')!=null){
           $this->load->view("mail/book_mail_magazine",$this->_data);
        } else {
            $this->_data["titlePage"]="自動送信メルマガ予約一覧";
            $this->_data["loadPage"]="mail/book_mail_magazine";
            $this->load->view($this->_data["module"]."/layout/layout",$this->_data);
        }
        if($this->input->post('disable')!=null) {
            $id = $this->input->post('disable');
            $disable = $this->mmail->updateStatusMail($id,0);
            redirect(current_url());
        } elseif ($this->input->post('enable')!=null) {
            $id = $this->input->post('enable');
            $disable = $this->mmail->updateStatusMail($id,1);
            redirect(current_url());
        }

    }

    private function _encode_login_info($email, $password, $group_id, $lst_ur_msg_id) {
        $arr_account = array('email' => $email,
                            'password' => $password,
                            'created_date' => date("Y-m-d H:i:s"));
        $arr = serialize($arr_account);
        $encrypt = $this->cipher->encrypt($arr);
        $data = array('random_encode_string' => $encrypt,
                      'user_mail_group_id' => $group_id,
                      'msg_id' => $lst_ur_msg_id,
                      'created_date' => date("Y-m-d H:i:s")
                     );
        $this->mmail->insert_mail_magazine_log($data);
        return $encrypt;
    }

    public function mail_magazine_history() {
        if ($this->input->post()) {
            $id = $this->input->post('id');
            $data = $this->mmail->get_mail_magazine_history($id);

            $number_display = $this->config->item('per_page'); // number of list display
            $uri_segment = 4; // pagination max number display
            $config = array();
            $config['base_url'] = base_url().'admin/mail/mail_magazine_history';
            $config["total_rows"] = count($data);
            $config["per_page"] = $number_display;
            $config["uri_segment"] = $uri_segment;
            $config['constant_num_links'] = TRUE;
            $this->load->library("pagination",$config);
            $this->pagination->initialize($config);
            $start = $this->uri->segment(4);

            $data = array_slice($data, $start, $number_display);
            $data[] = array('pagination' => $this->pagination->create_links());

            echo json_encode($data);
        }
    }
}
?>

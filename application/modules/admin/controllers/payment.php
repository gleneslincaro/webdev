<?php
  class Payment extends MX_Controller{
        protected $_data;
        private $common;
        public function __construct() {
            parent::__construct();
            AdminControl::CheckLogin();
            $this->_data["module"] = $this->router->fetch_module();
            $this->common = new Common();
            $this->output->set_header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
            $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate");
            $this->output->set_header("Cache-Control: post-check=0, pre-check=0");
            $this->output->set_header("Pragma: no-cache");
        }
        
        /**
    	 * @author     [IVS] Nguyen Van Vui
    	 * @name 	reward
    	 * @todo 	view info reward
    	 * @param 	 
    	 * @return 	
    	 */
        
        function reward(){
            $this->load->Model("admin/Mpayment");
            $records=$this->Mpayment->listRewardDelete();
            $this->_data["records"]=$records;
            $this->_data["numRecord"]=count($records);
            $this->_data["loadPage"]="payment/reward";
            $this->_data["titlePage"]="お祝い金リスト";
            $this->load->view($this->_data["module"]."/layout/layout",$this->_data);
        }
        
        /**
    	 * @author     [IVS] Nguyen Van Vui
    	 * @name 	reward_download
    	 * @todo 	view dowload completed
    	 * @param 	 
    	 * @return 	
    	 */
        
        function reward_download(){
            //Get data
            $this->load->Model("admin/Mpayment");
            $records=$this->Mpayment->listRewardDelete();
            if(count($records)>0){
                $id = array();
                $idowner = array();
                $iduser = array();
                $senduser=array();
                foreach ($records as $row){
                    array_push($id, $row['id']);
                    array_push($idowner, $row['ownerid'].','.$row['userid']);
                    array_push($iduser, $row['userid'].','.$row['ownerid'].','.$row['osr_id']);
                    array_push($senduser, $row['userid']);
                    
                }
                //send mail owners
                
                foreach ($idowner as $value) {
                    $array_value = explode(',', $value);
                    $row=$this->Mpayment->select_set_send_mail_from('owners',$value);
                    $set_send_mail_owner=$row['set_send_mail'];
                    if($set_send_mail_owner==1){
                        $this->common->sendMail( '', '', '', array('ow20'),$array_value[0],'', $array_value[1],'getUserSelect','getJobUser','getJobOwner' ,array($array_value[1]),'','');
                    }
                }
                //send mail
                foreach ($iduser as $value) {
      
                    $array_value = explode(',', $value);
                    $row=$this->Mpayment->select_set_send_mail_from('users',$array_value[0]);
                    $set_send_mail_user=$row['set_send_mail'];
                    //[IVS]Nguyen Ngoc Phuong
                    $mst_templates = $this->Musers->get_mst_templates($template_type ='us12');
                  
                    $this->Musers->insert_list_user_messages($array_value[0],$array_value[2],date("y-m-d H:i:s"),$mst_templates);
                    if($set_send_mail_user==1){    
                        $url = base_url('user/joyspe_user/company/'.$array_value[2]);
                        $this->common->sendMail('', '', 'Joyspe', array('us12'),$array_value[1],'', $array_value[0],'getUserSelect','','getJobOwner','',$url,'');
                        //$this->common->sendMail('', '', '', array('us11'), $id_owner, '', $id,'getUserSelect','','getJobOwner' ,'', $urlus11,'');
                    }
                }
                
                //Download CSV
                $result_array=$this->Mpayment->listRewardReturnDownload();
                $data = array();
                $result = array( '承認日', '銀行名', '支店名', '口座種別', '口座番号', '名義', '金額' );
                array_push($data, $result);
                foreach ($result_array as $value) {
                    $account_type = '';
                    if($value['account_type']==0){
                        $account_type = '普通';
                    }else{
                        $account_type = '当座';
                    }
                    $result = array($value['approved_date'],$value['bank_name'],$value['branch_name'],
                        $account_type,$value['account_no'],$value['account_name'],$value['user_happy_money']);
                    array_push($data, $result);
                }
                
                $str=self::arrayToCsv($data);
                
                //Update payment_date
                $this->Mpayment->updatePaymentDate($id);
                $this->load->helper('download');
                $nameFile="reward_".date("Ymd").".csv";
                force_download($nameFile, $str);
            }
        }
        
        /**
    	 * @author     [IVS] Nguyen Van Vui
    	 * @name 	arrayToCsv
    	 * @todo 	convert array to string csv
    	 * @param 	 
    	 * @return 	string
    	 */
        
        public static function arrayToCsv( array $fields, $delimiter = ';', $enclosure = '"', $encloseAll = false, $nullToMysqlNull = false ) {
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
            return $outputString; 
        }
        
        /**
    	 * @author     [IVS] Nguyen Van Vui
    	 * @name 	reward_delete
    	 * @todo 	view dowload deleted
    	 * @param 	 
    	 * @return 	
    	 */
        
        function reward_delete(){

            //Get ID checkbox selected
            $id_arr = $_POST;
            $id = array();
            foreach ($id_arr as $key => $value){
                array_push($id, $value);
            }
            
            if(count($id)>0){
                $this->load->Model("admin/Mpayment");
                $this->Mpayment->deleteReward($id);
                $this->_data["loadPage"]="payment/reward_delete";
                $this->_data["titlePage"]="削除が完了しました。";
                $this->load->view($this->_data["module"]."/layout/layout",$this->_data);
            }
        }
        
        /**
    	 * @author     [IVS] Nguyen Van Vui
    	 * @name 	reward_return
    	 * @todo 	rerurn info reward
    	 * @param 	 
    	 * @return 	
    	 */
        
        function reward_return(){
            $this->load->Model("admin/Mpayment");
            $records=$this->Mpayment->listRewardReturn();
            $this->_data["records"]=$records;
            $this->_data["numRecord"]=  count($records);
            $this->_data["loadPage"]="payment/reward_return";
            $this->_data["titlePage"]="お祝い金リスト";
            $this->load->view($this->_data["module"]."/layout/layout",$this->_data);
        }
        
        /**
    	 * @author     [IVS] Nguyen Van Vui
    	 * @name 	reward_return_ok
    	 * @todo 	view reward return completed
    	 * @param 	 
    	 * @return 	
    	 */
        
        function reward_return_ok(){
            //Get ID checkbox selected
            $id_arr = $_POST;
            $id = array();
            foreach ($id_arr as $key => $value){
                array_push($id, $value);
            }
            
            if(count($id)>0){
                $this->load->Model("admin/Mpayment");
                $this->Mpayment->returnReward($id);
                $this->_data["loadPage"]="payment/reward_return_ok";
                $this->_data["titlePage"]="お祝い金支払へ戻しました。";
                $this->load->view($this->_data["module"]."/layout/layout",$this->_data);
            }
                
        }
        
        /**
    	 * @author     [IVS] Nguyen Van Vui
    	 * @name 	paid
    	 * @todo 	view search paid
    	 * @param 	 
    	 * @return 	
    	 */
        
        function paid(){
            $this->_data["loadPage"]="payment/paid";
            $this->_data["titlePage"]="お祝い金・履歴";
            $this->load->view($this->_data["module"]."/layout/layout",$this->_data);
        }
        
        /**
    	 * @author     [IVS] Nguyen Van Vui
    	 * @name 	view_paid
    	 * @todo 	view data paid by condition
    	 * @param 	
    	 * @return 	
    	 */
        
        function view_paid(){
            $start = 0;
            $uniqueId=trim($this->input->post("txtUniqueId"));
            $accountName=trim($this->input->post("txtAccountName"));
            $paymentDateFrom=trim($this->input->post("txtPaymentDateFrom"));
            $paymentDateTo=trim($this->input->post("txtPaymentDateTo"));
            $where="";
            if($uniqueId!=""){
                $where.=" AND u.`unique_id` LIKE '%".$this->db->escape_like_str($uniqueId)."%' ";
            }
            if($accountName!=""){
                $where.=" AND o.`account_name` LIKE '%".$this->db->escape_like_str($accountName)."%' ";
            }
            if($paymentDateFrom !=""){
                $where.=" AND DATE_FORMAT(up.`payment_date`,'%Y/%m/%d') >= ".$this->db->escape($paymentDateFrom);
            }
            if($paymentDateTo!=""){
                $where.=" AND DATE_FORMAT(up.`payment_date`,'%Y/%m/%d') <= ".$this->db->escape($paymentDateTo);
            }
            
            $this->load->Model("admin/Mpayment");
            $totalNumber=$this->Mpayment->countReward($where);
            //Start Page
            $config['base_url'] = base_url('index.php/admin/payment/view_paid');
            $config['total_rows'] = $totalNumber;
            $config['constant_num_links'] = TRUE;
            $config['uri_segment']=4;
            $config["per_page"]=$this->config->item('per_page');
            $this->pagination->initialize($config); 
            $start1 = $this->uri->segment(4);
            if($start1!=NULL) $start=$start1;
            $this->_data["records"]=$this->Mpayment->searchReward($where,$config['per_page'],$start); 
            //End page
            $this->_data["totalNumber"]=$totalNumber;
            $this->_data["loadPage"]="payment/paid_after";
            $this->_data["titlePage"]="お祝い金・履歴";
            //paging by ajax
            if($this->input->post('ajax')!=null){
               $this->load->view("payment/paid_after",$this->_data); 
            }else{
                $this->load->view($this->_data["module"]."/layout/layout",$this->_data);   
            }
        }
        
        /**
    	 * @author     [IVS] Nguyen Van Vui
    	 * @name 	bank
    	 * @todo 	search bank
    	 * @param 	 
    	 * @return 	
    	 */
        
        function bank(){
            $this->load->Model("admin/Mpayment");
            $this->_data["listPaymentCase"]=$this->Mpayment->listPaymentCase();
            $this->_data["loadPage"]="payment/bank";
            $this->_data["titlePage"]="振込完了メール";
            $this->load->view($this->_data["module"]."/layout/layout",$this->_data);
        }
        
        /**
    	 * @author     [IVS] Nguyen Van Vui
    	 * @name 	bank_after
    	 * @todo 	search bank results
    	 * @param 	 
    	 * @return 	
    	 */
        
        function bank_after(){
            $start = 0;
            $where='';
            
            //get values
            $txtEmail=trim($this->input->post('txtEmail'));
            $txtStoreName=trim($this->input->post('txtStoreName'));
            $txtPaymentName=trim($this->input->post('txtPaymentName'));
            $txtCreateDateFrom=trim($this->input->post('txtCreateDateFrom'));
            $txtCreateDateTo=trim($this->input->post('txtCreateDateTo'));
            $cbPaymentStatus=trim($this->input->post('cbPaymentStatus'));
            $cbPaymentCase=trim($this->input->post('cbPaymentCase'));
            
            //set conditions
            if($txtEmail!=""){
                $where.=" AND ow.`email_address` LIKE '%".$this->db->escape_like_str($txtEmail)."%' ";
            }
            if($txtStoreName!=""){
                $where.=" AND ow.`storename` LIKE '%".$this->db->escape_like_str($txtStoreName)."%' ";
            }
            if($txtPaymentName!=""){
                $where.=" AND pm.`payment_name` LIKE '%".$this->db->escape_like_str($txtPaymentName)."%' ";
            }
            if($txtCreateDateFrom !=""){
                $where.=" AND DATE_FORMAT(pm.`created_date`,'%Y/%m/%d') >= ".$this->db->escape($txtCreateDateFrom);
            }
            if($txtCreateDateTo!=""){
                $where.=" AND DATE_FORMAT(pm.`created_date`,'%Y/%m/%d') <= ".$this->db->escape($txtCreateDateTo);
            }
            if($cbPaymentStatus!=""){
                if($cbPaymentStatus!=3){
                    $where.=" AND pm.`payment_status` = ".$this->db->escape_str($cbPaymentStatus);
                }
            }
            if($cbPaymentCase!=""){
                if($cbPaymentCase!=0){
                    $where.=" AND pm.`payment_case_id` = ".$this->db->escape_str($cbPaymentCase);
                }
            }
            $where.=" ORDER BY pm.`created_date` DESC ";
            $this->load->Model("admin/Mpayment");
            $this->_data["listPaymentCase"]=$this->Mpayment->listPaymentCase();
            $totalNumber=$this->Mpayment->countBank($where);
            //Start Page
            $config['base_url'] = base_url('index.php/admin/payment/bank_after');
            $config['total_rows'] = $totalNumber;
            $config['constant_num_links'] = TRUE;
            $config['uri_segment']=4;
            $config["per_page"]=$this->config->item('per_page');
            $this->pagination->initialize($config); 
            $start1 = $this->uri->segment(4);
            if($start1!=NULL) $start=$start1;
            $this->_data["records"]=$this->Mpayment->searchBank($where,$config['per_page'],$start); 
            //End page
            
            $this->_data["totalNumber"]=$totalNumber;
            $this->_data["loadPage"]="payment/bank";
            $this->_data["titlePage"]="振込完了メール";
            //paging by ajax
            if($this->input->post('ajax')!=null){
               $this->load->view("payment/bank",$this->_data);    
            }else{
                $this->load->view($this->_data["module"]."/layout/layout",$this->_data);   
            }
        }
        
        /**
    	 * @author     [IVS] Nguyen Van Vui
    	 * @name 	bank_detail
    	 * @todo 	bank detail
    	 * @param 	 
    	 * @return 	
    	 */
        
        function bank_detail($id){
            $this->load->Model("admin/Mpayment");
            $records = $this->Mpayment->loadBankDetail($id);
            if(count($records) > 0){
                $this->_data["records"] = $records;
                $this->_data["loadPage"]="payment/bank_detail";
                $this->_data["titlePage"]="振込完了メール・詳細";
                $this->load->view($this->_data["module"]."/layout/layout",$this->_data);
                
            }else{
                redirect(base_url()."admin/system/errorPage");
            }
        }
        
        /**
    	 * @author     [IVS] Nguyen Minh Ngoc
    	 * @name 	bank_ok
    	 * @todo 	bank completed
    	 * @param 	 
    	 * @return 	
    	 */
        
        function bank_ok(){
            $to_email=$this->config->item('smtp_user');
            $id=$this->input->post('hrId');
            $id_owner=$this->input->post('hrIdOwner');
            $payment_case_id=$this->input->post('hrPaymentCaseId');
            $this->load->Model("admin/Mpayment");
            //update payment
            $this->Mpayment->updatePayment($id);
            //get user list id
            $list = $this->Mpayment->getListUser($id);   
            foreach ($list as $k=>$l){
                $arr_user_id = explode(",",$l["user_list"]);
            }
             $count_unsent = count($arr_user_id);
            //get owner recruit id to send us03
            $irus03=$this->Mpayment->urlUs03($id_owner);
            foreach ($irus03 as $k=>$i){
                $owr03=$i["id"];
            }
            $urlus03=base_url()."user/joyspe_user/company/".$owr03;
            //get owner recruit id to send us03
            $irus11=$this->Mpayment->urlUs11($id_owner);
            if(count($irus11)!=0){
                foreach ($irus11 as $k=>$e){
                    $owr11=$e["id"];
                }
                $urlus11=base_url()."user/joyspe_user/company/".$owr11;
            }
            //update owner
            if($payment_case_id==4){
                $this->Mpayment->update_owner_by_payment_id($id);
            }
            
            $row=$this->Mpayment->select_set_send_mail_from('owners',$id_owner);
            $arremail=$this->Mpayment->getEmail($id_owner);
            foreach($arremail as $k=>$e){
                $email=$e["email_address"];
            }
            $set_send_mail_owner=$row['set_send_mail'];
            if($payment_case_id==1){
                $this->common->sendMail('', '', '', array('ss03'), $id, $senderName = null, $user_id = null,'getUserSelect','getJobUser','getJobOwner' ,$arr_user_id, '',$count_unsent);
                
                if ($set_send_mail_owner==1) {
                        $this->common->sendMail('', '', '', array('ow06'), $id, $senderName = null, $id_owner,'getUserSelect','getJobUser','getJobOwner' ,$arr_user_id, '',$count_unsent);
                         // send mail ow04 for user
                      $this->common->sendMail('', '', '', array('ow04'), $id_owner, $senderName = null, $user_id = null,'getUserSelect','getJobUser','getJobOwner' ,$arr_user_id, '',$count_unsent);
                        // send mail us03 for user
                        foreach ($arr_user_id as $uid){
                            $this->common->sendMail('', '', '', array('us03'), $id_owner, '', $uid,'getUserSelect','getJobUser','getJobTypeOwnerForScout' ,$arr_user_id, $urlus03,'');
                        }
                }
                //update payment message status
                $this->Mpayment->updatePaymentMessage($id);
                
            }elseif($payment_case_id==2){
                if($set_send_mail_owner==1){
                    $this->common->sendMail('', '', 'Joyspe', array('ow09'), $id, '', '','getUserSelect','getJobUser','getJobOwner' ,$arr_user_id, '',$count_unsent);
                }
                $arr_user2 = $this->Mpayment->select_user_id_by_owner_id_ss05($id_owner);
                $this->common->sendMail('', '', '', array('ss05'), $id, $senderName = null, $id=null,'getUserSelect','getJobUser','getJobOwner' ,$arr_user_id, '',$count_unsent);
            }
            elseif($payment_case_id==3){
                 //update payment message status
                if($set_send_mail_owner==1){
                    $this->common->sendMail('', '', '', array('ow19'), $id, '', '','getUserSelect','getJobUser','getJobOwner' ,$arr_user_id, '','');
                    $this->common->sendMail('', '', '', array('ss06'), $id, $senderName = null, $id=null,'getUserSelect','getJobUser','getJobOwner' ,$arr_user_id, '','');
                    
                   foreach ($arr_user_id as $id){
                        $this->common->sendMail('', '', '', array('us11'), $id_owner, '', $id,'getUserSelect','','getJobOwner' ,'', $urlus11,'');
                    }
                }
                $sid=$this->input->post('hrId');
                $this->Mpayment->updatePaymentMessage2($sid);
                //$this->common->sendMail('', $to_email, '', '', '', array('ss06'), $id, $senderName = null, $id,'getUserSelect','getJobUser','getJobOwner' ,$arr_user_id, '',$count_unsent=null);
            }
            elseif($payment_case_id==4){
                if($set_send_mail_owner==1){
                    $this->common->sendMail('', '', 'Joyspe', array('ow21'), $id, '', '','getUserSelect','getJobUser','getJobOwner' ,$arr_user_id, '','');
                }
                $this->common->sendMail('', '', '', array('ss04'), $id, $senderName = null, $id,'getUserSelect','getJobUser','getJobOwner' ,$arr_user_id, '',$count_unsent);
            }
            $this->_data["loadPage"]="payment/bank_ok";
            $this->_data["titlePage"]="入金処理が完了しました。";
            $this->load->view($this->_data["module"]."/layout/layout",$this->_data);
        }
        
        function test_send_mail() {
            $this->load->Model("admin/Mpayment");
            $to_email=$this->config->item('smtp_user');
            $id_owner = 100;
            $arr_user = $this->Mpayment->select_user_id_by_owner_id($id_owner);
            foreach ($arr_user as $user) {
                $arr_user_id[] = $user['user_id'];
            }
            $this->common->sendMail('', '', '', '', 'Joyspe', array('ow09'), $id_owner, '', '','getUserSelect','getJobUser','getJobOwner' ,$arr_user_id, '','');

            $arr_user2 = $this->Mpayment->select_user_id_by_owner_id_ss05($id_owner);
            foreach ($arr_user2 as $user) {
                $arr_user_id2[] = $user['user_id'];
            }
            $this->common->sendMail('', $to_email, '', '', 'Joyspe', array('ss05'), $id_owner, '', '','getUserSelect','getJobUser','getJobOwner' ,$arr_user_id2, '','');
            
        }
        
    }
?>
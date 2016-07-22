<?php

class Point extends Common {

    private $viewData;

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('breabcrumb_helper');
        $this->load->model('owner/Mpoint');
        $this->load->model('owner/Mhistory');
        $this->load->model('owner/Mdialog');
        $this->load->model('owner/Mcommon');
        $this->load->model('user/Musers');
        $this->load->model('owner/Mowner');
        $this->load->model('owner/Mtemplate');
        $this->common = new Common();
        $this->output->set_header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate");
        $this->output->set_header("Cache-Control: post-check=0, pre-check=0");
        $this->output->set_header("Pragma: no-cache");
    }

    /**
     * @author  [IVS] Phan Ngoc Minh Luan
     * @name 	pointcomp_recruit
     * @todo 	processing payment recruit money + send mail ow18 , us11 + load view pointcomp
     * @param 	
     * @return 	void
     */
    public function pointcomp_recruit() {
        $email_address = OwnerControl::getEmail();
        $owner_status = OwnerControl::getOwner();
        $owner_id = OwnerControl::getId();
        if ($owner_id != NULL) {
            $recruit_point = $this->input->post('recruit_point');
            $recruit_money = $this->input->post('recruit_money');
            $money = $this->input->post('remainder_money');
            $point = $this->input->post('remainder_point');
            $user_id = $this->input->post('user_id');
            $owner_recruit_id = $this->input->post('owner_recruit_id');
            $user_payment_id = $this->Mpoint->getUserPaymentId($user_id, $owner_recruit_id);
            $user_payment_status = $this->Mpoint->setStatusUserPayments($user_id, $owner_recruit_id, 5, 6); // set user_payment_status approve
            if ($user_payment_status == 6) {  // owner approved for user
                // update total point and total amount of owner
                $this->Mpoint->updateTotalPointAndMount($money, $point, $email_address);
                $created_date = $this->Mpoint->getCurrentDate();
                // insert transaction with payment_case: 3 (money recruit)
                $this->Mpoint->insertTransactions($owner_id, $user_payment_id, 3, '', $recruit_money, $recruit_point, $created_date);
                $owners = $this->Mpoint->getTotal($email_address);
                // send mail ow18 for owner's mail
                $from = $to = $email_address;
                $flagsetsendmail = $this->Musers->get_users($user_id);
                if ($flagsetsendmail['set_send_mail'] == 1 && $owner_status != 1) {
                    $owner_recruit = $this->Mowner->getOwnerRecruitIdNM($owner_id, $user_id);
                    $url = base_url() . 'user/joyspe_user/company/' . $owner_recruit;
                    $this->sendMail('', '', '', array('us11'), $owner_id, '', $user_id, 'getUserSelect', '', 'getJobOwnerNoDisplay', '', $url, '');
                    //$this->sendMail('', '', '', array('us09'), $owner_id, '', $user_id, 'getUserSelect', '', 'getJobOwner', '', $url, '');
                }
                $info_user = $this->Mhistory->getHistoryAppConf($user_id, $owner_id);
                $templUser = $this->Mcommon->getTemplate('us11');
                foreach ($info_user as $listid) {
                    $dataUser['owner_recruit_id'] = $listid['owner_recruit_id'];
                    $dataUser['user_id'] = $listid['usid'];
                    $dataUser['user_message_status'] = 1;
                    $dataUser['template_id'] = $templUser['id'];
                    $date = date("y-m-d H:i:s");
                    $dataUser['created_date'] = $date;
                    $dataUser['updated_date'] = $date;
                    $this->Mtemplate->insertUserList($dataUser);
                }
                $this->sendMail('', '', '', array('ss06'), $owner_id, '', $user_id, 'getUserSelect', 'getJobUser', '', array($user_id), '', '');
                if (OwnerControl::getSetSendMail()) {
                    $this->common->sendMail('', '', '', array('ow18'), $owner_id, $senderName = null, $user_id, 'getUserSelect', 'getJobUser', 'getJobOwnerNoDisplay', array($user_id), '', '');
                }
                $templOwner = $this->Mcommon->getTemplate('ow18');
                $dataOwner['owner_id'] = $owner_id;
                $dataOwner['template_id'] = $templOwner['id'];
                $dataOwner['created_date'] = date("y-m-d H:i:s");
                $this->Mtemplate->insertOwnerList($dataOwner);

                $this->viewData['total_point'] = $owners['total_point'];
            } else {
                $owners = $this->Mpoint->getTotal($email_address);
                $this->viewData['total_point'] = $owners['total_point'];
            }
            $count_penalty = $this->Mdialog->countPenalty($owner_id);
            if ($count_penalty == 0) {
                $owner = $this->Mowner->getOwner($owner_id);
                if ($owner['owner_status'] == 3) {
                    //update owner_status = 2
                    $this->Mdialog->updateOwnerStatus($owner_id, 2);
                }
            }
            $owner_info = HelperGlobal::owner_info($owner_id);
            $this->viewData['owner_info'] = $owner_info;
            $this->viewData['point'] = $point;
            $this->viewData['title'] = 'joyspe｜決済完了';
            $this->viewData['loadPage'] = "owner/point/pointcomp";
            $this->load->view("owner/layout/layout_B", $this->viewData);
        } else {
            redirect(base_url() . 'owner/login');
        }
    }

    /**
     * @author  [IVS] Phan Ngoc Minh Luan
     * @name 	pointcomp_info
     * @todo 	processing payment info money + send mail ow08, ss05 + load view pointcomp
     * @param 	
     * @return 	void
     */
    public function pointcomp_info() {
        $email_address = OwnerControl::getEmail();
        $owner_id = OwnerControl::getId();
        if ($owner_id != NULL) {
            $count_unview = HelperApp::get_session('count_unview');
            // get app_conf money purchase
            $info = $this->Mhistory->getCharge('1');
            $info_point = $info['point'];
            $info_money = $info['amount'];
            // get total point and amount of owner
            $owners = $this->Mhistory->getTotal($email_address);
            $point_owner = $owners['total_point'];
            $money_owner = $owners['total_amount'];
            $money = $money_owner - $info_money * $count_unview;
            $point = $point_owner - $info_point * $count_unview;
            $arr_owner_recruit = $this->Mpoint->getArrOwnerRecruitId($owner_id);
            $count_apply = 0;
            foreach ($arr_owner_recruit as $owner_recruit) {
                $count_apply += $this->Mpoint->countUserPaymentStatusApply($owner_recruit['id']);
                $arr_owner_recruit_id[] = $owner_recruit['id'];
            }
            if ($count_apply == $count_unview && $count_unview != 0) {  // owner purchase info
                //get array user_id
                $arr_user = $this->Mpoint->getArrayAppSettlement($owner_id);
                foreach ($arr_user as $user) {
                    $arr_user_id[] = $user['user_id'];
                }

                $arr_user_payment = $this->Mpoint->getArrUserPaymentId($arr_owner_recruit_id);
                $created_date = $this->Mpoint->getCurrentDate();
                foreach ($arr_user_payment as $user_payment) {
                    $arr_user_payment_id[] = $user_payment['id'];
                    // insert transaction with payment_case:2 (money info)
                    $this->Mpoint->insertTransactions($owner_id, $user_payment['id'], 2, '', $info_money, $info_point, $created_date);
                }
                //update total point and total amount of owner
                $this->Mpoint->updateTotalPointAndMount($money, $point, $email_address);
                $owners = $this->Mpoint->getTotal($email_address);
                $this->common->sendMail('', '', '', array('ss05'), '', $senderName = null, $owner_id, 'getUserSelect', 'getJobUser', '', $arr_user_id, '', '');
                if (OwnerControl::getSetSendMail()) {
                    // send mail ow08 for owner's mail
                    $this->sendMail('', '', '', array('ow08'), $owner_id, $senderName = null, $user_id = null, 'getUserSelect', 'getJobUser', 'getJobOwner', $arr_user_id, '', '');
                }
                $this->Mpoint->updateStatusPayForApplyUserPayment($arr_user_payment_id, 0, 1); // set user_payment_status pay for apply   
                $templOwner = $this->Mcommon->getTemplate('ow08');
                $dataOwner['owner_id'] = $owner_id;
                $dataOwner['template_id'] = $templOwner['id'];
                $dataOwner['created_date'] = date("y-m-d H:i:s");
                $this->Mtemplate->insertOwnerList($dataOwner);
                $this->viewData['total_point'] = $owners['total_point'];
            } else {
                $owners = $this->Mpoint->getTotal($email_address);
                $this->viewData['total_point'] = $owners['total_point'];
            }
            $owner_info = HelperGlobal::owner_info($owner_id);
            $this->viewData['owner_info'] = $owner_info;
            $this->viewData['point'] = $point;
            HelperApp::remove_session('count_unview');
            $this->viewData['loadPage'] = "owner/point/pointcomp";
            $this->viewData['title'] = 'joyspe｜決済完了';
            $this->load->view("owner/layout/layout_B", $this->viewData);
        } else {
            redirect(base_url() . 'owner/login');
        }
    }

    /**
     * @author  [IVS] Phan Ngoc Minh Luan
     * @name 	pointcomp_scout
     * @todo 	processing payment scout money + send mail ow04, ow05, us03, ss03 + load view point
     * @param 	
     * @return 	void
     */
    public function pointcomp_scout() {
        $email_address = OwnerControl::getEmail();
        $owner_status = OwnerControl::getOwnerStatus();
        $owner_id = OwnerControl::getId();
        
        if ($owner_id != NULL) {  
            $owner_recruit_id = $this->Mowner->getOwnerRecruitId($owner_id);    
            $ownerData = $this->Mhistory->getOwnerRecruitHappyMoney($owner_recruit_id);           
            if($ownerData[0]['user_happy_money'] > 0) {
              $vOw = 'ow04';
              $vUs = 'us03';
            }
            else {
              $vOw = 'ow23';
              $vUs = 'us14';
            }  
            $arr_user_id = HelperApp::get_session('arr_user_id_unsent');
            $count_unsent = HelperApp::get_session('count_unsent');
            // get scout money purchase
            $scout = $this->Mhistory->getCharge('0');
            $scout_point = $scout['point'];
            $scout_money = $scout['amount'];
            // get total point and amount of owner
            $owners = $this->Mhistory->getTotal($email_address);
            $point_owner = $owners['total_point'];
            $money_owner = $owners['total_amount'];
            $money = $money_owner - $scout_money * $count_unsent;            
            $point = $point_owner - $scout_point * $count_unsent;
            $owner_recruit_id = $this->Mpoint->getOwnerRecruitId($owner_id);
            $count_users_checked = 0;
            $count_exist = $this->Mpoint->checkExistList($owner_recruit_id, $arr_user_id);
            foreach ($arr_user_id as $user_id):
                if ($this->Mpoint->checkExistListUserMessage($owner_recruit_id, $user_id)) {
                    $count_users_checked++;
                }
            endforeach;
            if ($count_unsent == $count_users_checked) {
                //$this->Mpoint->updateDisplayFlagListUserMessage($owner_recruit_id);
                $created_date = $this->Mpoint->getCurrentDate();
                foreach ($arr_user_id as $user_id):
                    $flagsetsendmail = $this->Musers->get_users($user_id);
                    $payment_message_status = 1; // enough money
                    $list_user_message_id = $this->Mpoint->insertListUserMessage($owner_recruit_id, $user_id, $vUs, $payment_message_status);
                    if ($flagsetsendmail['set_send_mail'] == 1 && $owner_status != 1) {
                        $owner_recruit = $this->Mowner->getOwnerRecruit($owner_id);
                        $url = base_url() . 'user/joyspe_user/company/' . $owner_recruit['id'];
                        $user_payment_id = $this->Mpoint->getUserPaymentId($user_id, $owner_recruit_id);
                        // send mail us03 for user                        
                        $this->sendMail('', '', '', array($vUs), $owner_id, '', $user_id, 'getUserSelect', 'getJobUser', 'getJobTypeOwnerForScout', array($user_id), $url, '');
                    }

                    // insert transaction with payment_case:1 (money scout)
                    $this->Mpoint->insertTransactions($owner_id, $list_user_message_id, 1, '', $scout_money, $scout_point, $created_date);
                endforeach;

                // update total point and total amount of owner
                $this->Mpoint->updateTotalPointAndMount($money, $point, $email_address);
                $from = $to = $email_address;
                $this->common->sendMail('', '', '', array('ss03'), '', $senderName = null, $owner_id, 'getUserSelect', 'getJobUser', 'getJobOwner', $arr_user_id, '', $count_unsent);
                if (OwnerControl::getSetSendMail()) {
                    // send mail ow04,ow05 for owner                                    
                    $this->sendMail('', '', '', array($vOw), $owner_id, $senderName = null, $user_id = null, 'getUserSelect', 'getJobUser', 'getJobOwnerForScout', $arr_user_id, '', $count_unsent);
                    $templOwner04 = $this->Mcommon->getTemplate($vOw);
                    $dataOwner04['owner_id'] = $owner_id;
                    $dataOwner04['template_id'] = $templOwner04['id'];
                    $dataOwner04['created_date'] = date("y-m-d H:i:s");
                    $this->Mtemplate->insertOwnerList($dataOwner04);
                    $this->sendMail('', '', '', array('ow05'), $owner_id, $senderName = null, $user_id = null, 'getUserSelect', 'getJobUser', 'getJobOwner', $arr_user_id, '', $count_unsent);
                    $templOwner05 = $this->Mcommon->getTemplate('ow05');
                    $dataOwner05['owner_id'] = $owner_id;
                    $dataOwner05['template_id'] = $templOwner05['id'];
                    $dataOwner05['created_date'] = date("y-m-d H:i:s");
                    $this->Mtemplate->insertOwnerList($dataOwner05);
                }
            }
            $owner_info = HelperGlobal::owner_info($owner_id);
            $this->viewData['owner_info'] = $owner_info;
            $owners = $this->Mhistory->getTotal($email_address);
            $this->viewData['total_point'] = $owners['total_point'];
            HelperApp::remove_session('sCheckrs');
            HelperApp::remove_session('count_unsent');
            HelperApp::remove_session('arr_user_id_unsent');
            $this->viewData['loadPage'] = "owner/point/pointcomp";
            $this->viewData['title'] = 'joyspe｜決済完了';
            $this->load->view("owner/layout/layout_B", $this->viewData);
        } else {
            redirect(base_url() . 'owner/login');
        }
    }

    /**
     * @author  [IVS] Phan Ngoc Minh Luan
     * @name 	checkPenalty
     * @todo 	check penalty
     * @param 	 
     * @return 	void
     */
    public function checkPenalty() {
        $owner_id = OwnerControl::getId();
        $count_penalty = $this->Mdialog->countPenalty($owner_id);
        if ($count_penalty == 0) {
            $owner = $this->Mowner->getOwner($owner_id);
            if ($owner['owner_status'] == 3) {
                //update owner_status = 2
                $this->Mdialog->updateOwnerStatus($owner_id, 2);
            }
        }
        $data = array(
            'count_penalty' => $count_penalty,
        );
        echo json_encode($data);
    }

}

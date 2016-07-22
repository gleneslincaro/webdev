<?php

class Dialog extends Common {

    private $viewData;
    private $common;

    function __construct() {
        parent::__construct();
        $this->load->model('owner/Mdialog');
        $this->load->model('owner/Muser');
        $this->load->model('owner/Mtemplate');
        $this->load->model('owner/Mowner');
        $this->load->model('owner/Mpoint');
        $this->load->model('owner/Mhistory');
        $this->load->model('owner/Mcommon');
        $this->load->model('user/Musers');
        $this->common = new Common();
        $this->output->set_header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate");
        $this->output->set_header("Cache-Control: post-check=0, pre-check=0");
        $this->output->set_header("Pragma: no-cache");
    }

    /**
     * @author  [IVS] Phan Ngoc Minh Luan
     * @name 	dialog_unapproved
     * @todo 	show view dialog_unapproved + send mail ow15, us09
     * @param 	 
     * @return 	void
     */
    public function dialog_unapproved() {
        $owner_id = OwnerControl::getId();
        $owner_status = OwnerControl::getOwnerStatus();
        if ($owner_id != NULL) {
            $user_id = $this->input->post('user_id');
            $owner_recruit_id = $this->input->post('owner_recruit_id');
            $user_payment_status = $this->Mdialog->setStatusUserPayments($user_id, $owner_recruit_id, 5, 7); // set user_payment_status deny
            if ($user_payment_status == 7) {
                if (OwnerControl::getSetSendMail()) {
                    $from = $to = OwnerControl::getEmail();
                    // send mail ow15 for owner mail  and us09 for user           
                    $this->sendMail('', '', '', array('ow15'), $owner_id, '', $user_id, 'getUserSelect', 'getJobUser', '', array($user_id), '', '');
                }
                $templOwner = $this->Mcommon->getTemplate('ow15');
                $dataOwner['owner_id'] = $owner_id;
                $dataOwner['template_id'] = $templOwner['id'];
                $dataOwner['created_date'] = date("y-m-d H:i:s");
                $this->Mtemplate->insertOwnerList($dataOwner);

                $flagsetsendmail = $this->Musers->get_users($user_id);
                if ($flagsetsendmail['set_send_mail'] == 1 && $owner_status != 1) {
                    //[IVS] Nguyen Minh Ngoc
                    $owner_recruit = $this->Mowner->getOwnerRecruitIdNM($owner_id, $user_id);
                    $url = base_url() . 'user/joyspe_user/company/' . $owner_recruit;
                    //[IVS] Nguyen Minh Ngoc
                    $this->sendMail('', '', '', array('us09'), $owner_id, '', $user_id, 'getUserSelect', '', 'getJobOwnerNoDisplay', '', $url, '');
                }
                $templUser = $this->Mcommon->getTemplate('us09');
                $info_user = $this->Mhistory->getHistoryAppConf($user_id, $owner_id);
                foreach ($info_user as $listid) {
                    $dataUser['owner_recruit_id'] = $listid['owner_recruit_id'];
                    $dataUser['user_id'] = $listid['usid'];
                    $dataUser['user_message_status'] = 1;
                    $dataUser['template_id'] = $templUser['id'];
                    $dataUser['created_date'] = date("y-m-d H:i:s");
                    $dataUser['updated_date'] = date("y-m-d H:i:s");
                    $this->Mtemplate->insertUserList($dataUser);
                }
            }
            $this->viewData['loadPage'] = "owner/dialog/dialog_unapproved";
            $this->viewData['title'] = 'joyspe｜履歴一覧 - 非承認';
            $this->load->view("owner/layout/layout_E", $this->viewData);
        } else {
            redirect(base_url() . "owner/login");
        }
    }

    /**
     * @author  [IVS] Phan Ngoc Minh Luan
     * @name 	checkDialogUnapproved
     * @todo 	check penalty
     * @param 	 
     * @return 	void
     */
    public function checkDialogPenalty() {
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

    /**
     * @author  [IVS] Phan Ngoc Minh Luan
     * @name 	dialog_tranfer
     * @todo 	show view dialog_unapproved
     * @param 	 
     * @return 	void
     */
    public function dialog_tranfer() {
        $owner_id = OwnerControl::getId();
        $email_address = OwnerControl::getEmail();
        if (HelperApp::get_session('settlement') != 'settlement') {
            $this->Mdialog->updateTotalPointAndMount(0, 0, $email_address);
        }
        if ($owner_id != NULL) {
            $payment_id = HelperApp::get_session('payment_id');
            $tranfer_date = HelperApp::get_session('tranfer_date');
            $payment_name = HelperApp::get_session('payment_name');
            if ($payment_id != NULL) {
                $user_payment_status = HelperApp::get_session('user_payment_status');
                if ($user_payment_status == 0) { // case app_conf
                    $arr_user_payment_id = HelperApp::get_session('arr_user_payment_id');
                    $this->Mpoint->updateStatusPayForApplyUserPayment($arr_user_payment_id, 0, 1); // set user_payment_status pay for apply   
                } else if ($user_payment_status == 5) { 

                    // case recruit
                    $user_list = HelperApp::get_session('user_list');
                     $payment_message_status = 0; // not enough money
                    $owner_recruit_id = HelperApp::get_session('owner_recruit_id');
                    $list_user_message_id = $this->Mpoint->insertListUserMessage($owner_recruit_id, $user_list, 'us11', $payment_message_status);
                    
                    
                    $this->Mpoint->setStatusUserPayments($user_list, $owner_recruit_id, 5, 6); // set user_payment_status approve
                } else if ($user_payment_status == -1) {
                    $owner_recruit_id = $this->Mpoint->getOwnerRecruitId($owner_id);
                    // get scout money purchase
                    $scout = $this->Mdialog->getCharge('0');
                    $scout_point = $scout['point'];
                    $scout_money = $scout['amount'];
                    $payment_message_status = 0; // not enough money
                    $created_date = $this->Mdialog->getCurrentDate();
                    $arr_user_id = HelperApp::get_session('arr_user_id_unsent');
                    foreach ($arr_user_id as $user_id):
                        $list_user_message_id = $this->Mpoint->insertListUserMessage($owner_recruit_id, $user_id, 'us03', $payment_message_status);
                        // insert transaction with payment_case:1 (money scout)
                        $this->Mpoint->insertTransactions($owner_id, $list_user_message_id, 1, $payment_id, $scout_money, $scout_point, $created_date);
                    endforeach;
                }
                $this->Mdialog->updateStatusTranferPayment($payment_id, $payment_name, $tranfer_date);
                // send ow17 and sp01
                $from = $to = OwnerControl::getEmail();
                if (OwnerControl::getSetSendMail()) {
                    $this->sendMail('', '', '', array('ow17'), $payment_id, '', '', '', '', '', '', '', '');
                }
                $templOwner = $this->Mcommon->getTemplate('ow17');
                $dataOwner['owner_id'] = $owner_id;
                $dataOwner['template_id'] = $templOwner['id'];
                $dataOwner['created_date'] = date("y-m-d H:i:s");
                $this->Mtemplate->insertOwnerList($dataOwner);
                $this->sendMail('', '', '', array('sp01'), $payment_id, '', '', '', '', '', '', '', '');
            }
            $count_penalty = $this->Mdialog->countPenalty($owner_id);
            if ($count_penalty == 0) {
                $owner = $this->Mowner->getOwner($owner_id);
                if ($owner['owner_status'] == 3) {
                    //update owner_status = 2
                    $this->Mdialog->updateOwnerStatus($owner_id, 2);
                }
            }
            HelperApp::remove_session('settlement');
            HelperApp::remove_session('payment_id');
            HelperApp::remove_session('tranfer_date');
            HelperApp::remove_session('payment_name');
            HelperApp::remove_session('arr_user_payment_id');
            HelperApp::remove_session('user_payment_status');
            HelperApp::remove_session('owner_recruit_id');
            HelperApp::remove_session('arr_user_id_unsent');
            $this->viewData['loadPage'] = "owner/dialog/dialog_tranfer";
            $this->viewData['title'] = 'joyspe｜銀行決済・振込完了お知らせメール';
            $this->load->view("owner/layout/layout_E", $this->viewData);
        } else {
            redirect(base_url() . "owner/login");
        }
    }

    /**
     * @author [IVS] Lam Tu My Kieu
     * @name   dialog_transmission
     * @todo   show dialog transmission and insert to db
     * @param $user_id, $flag
     * @return void
     */
    public function dialog_transmission($user_id = null, $flag = null) {

        $title = 'joyspe｜履歴一覧 - アクションメッセージ・テンプレート作成';

        if ($user_id != null) {
            $owner_id = OwnerControl::getId();
            $set_send_mail_ow = OwnerControl::getSetSendMail();
            $set_send_mail_us = $this->Musers->setSendMailUser($user_id);
            $owner_status = OwnerControl::getOwnerStatus($owner_id);
            $owner_recruit_id = $this->Mowner->getOwnerRecruitIdOld($owner_id, $user_id);
            $user_data = $this->Muser->getDataUser($user_id);
            if (($user_data != NULL) && ($flag == '1' || $flag == '0')) {

                $d = date('y-m-d H:i:s');
                if ($flag == '1') {
                    $tem_ow = $this->Mtemplate->getTemp('ow11');
                    $tem_us = $this->Mtemplate->getTemp('us06');
                    $data_up = array(
                        'user_payment_status' => 3,
                        'reply_date' => $d);
                }
                if ($flag == '0') {
                    $tem_ow = $this->Mtemplate->getTemp('ow10');
                    $tem_us = $this->Mtemplate->getTemp('us05');

                    $data_up = array(
                        'user_payment_status' => 2,
                        'deny_for_apply_date' => $d);
                }
                $data_us = array(
                    'owner_recruit_id' => $owner_recruit_id,
                    'user_id' => $user_id,
                    'template_id' => $tem_us['id'],
                    'created_date' => $d,
                    'user_message_status' => 1,
                    'updated_date' => $d);
                $data_ow = array(
                    'owner_id' => $owner_id,
                    'template_id' => $tem_ow['id'],
                    'created_date' => $d);
                if ($set_send_mail_us[0]['set_send_mail'] == 1 && $owner_status != 1) {
                    try {
                        $this->send_user_mail($user_id, $owner_id, $flag);
                    } catch (Exception $exc) {
                        throw new Exception;
                    }
                }
                $this->Mtemplate->insertUserList($data_us);
                $this->Mtemplate->updateUserPayment($data_up, $user_id, $owner_recruit_id);
                if ($set_send_mail_ow == 1) {
                    try {
                        $this->send_owner_mail($user_id, $owner_id, $flag);
                    } catch (Exception $exc) {
                        throw new Exception;
                    }
                }
                $this->Mtemplate->insertOwnerList($data_ow);
                $this->viewData['loadPage'] = 'owner/dialog/dialog_transmission';
                $this->viewData['title'] = $title;
                $this->load->view("owner/layout/layout_B", $this->viewData);
            } else {
                show_404();
            }
        } else {
            $this->viewData['loadPage'] = 'owner/dialog/dialog_transmission';
            $this->viewData['title'] = $title;
            $this->load->view("owner/layout/layout_E", $this->viewData);
        }
    }

    /**
     * @author [IVS] Lam Tu My Kieu
     * @name   send_owner_mail
     * @todo   send owner mail
     * @param $user_id, $owner_id, $flag
     * @return void
     */
    public function send_owner_mail($user_id, $owner_id, $flag) {
        $url = 'joyspe-candom.vjsol.jp';
        if ($flag == 0) {
            $this->common->sendMail('', '', '', array('ow10'), $owner_id, '', $user_id, 'getUserSelect', 'getJobTypeSelect', '', $user_id, $url, '');
        } else {
            if ($flag == 1) {
                $this->common->sendMail('', '', '', array('ow11'), $owner_id, '', $user_id, 'getUserSelect', 'getJobTypeSelect', '', $user_id, $url, '');
            } else {
                $this->common->sendMail('', '', '', array('ow04'), $owner_id, '', $user_id, 'getUserSelect', 'getJobTypeSelect', 'getJobTypeOwnerForScout', $user_id, $url, 1);
            }
        }
    }

    /**
     * @author [IVS] Lam Tu My Kieu
     * @name   send_user_mail
     * @todo   send user mail
     * @param $user_id, $owner_id, $flag
     * @return void
     */
    public function send_user_mail($user_id, $owner_id, $flag) {
        if ($flag != 3) {
            $owner_recruit_id = $this->Mowner->getOwnerRecruitIdOld($owner_id, $user_id);
        } else {
            $owner_recruit_id = $this->Mowner->getOwnerRecruitId($owner_id);
        }
        $url = base_url() . 'user/joyspe_user/company/' . $owner_recruit_id;
        if ($flag == 0) {
            $this->common->sendMail('', '', '', array('us05'), $owner_id, '', $user_id, 'getUserSelect', '', '', $user_id, $url, '');
        } else {
            if ($flag == 1) {
                $this->common->sendMail('', '', '', array('us06'), $owner_id, '', $user_id, 'getUserSelect', '', 'getJobTypeOwner', $user_id, $url, '');
            } else {
                $this->load->model("user/Mnewjob_model");
                $company_data= $this->Mnewjob_model->getAllCompany($owner_recruit_id);
                $user_happy_money = $company_data[0]['user_happy_money'];   
                $this->common->sendMail('', '', '', array(($user_happy_money > 0)?'us03':'us14'), $owner_id, '', $user_id, 'getUserSelect', 'getJobTypeSelect', 'getJobTypeOwnerForScout', $user_id, $url, 1);
            }
        }
    }

    /**
     * @author [IVS] Lam Tu My Kieu
     * @name   dialog_hide
     * @todo   show dialog hide and insert to db
     * @param $user_id
     * @return void
     */
    public function dialog_hide($user_id = null, $flag = null) {

        if ($user_id != Null) {
            $owner_id = OwnerControl::getId();
            $owner_recruit_id = $this->Mowner->getOwnerRecruitIdOld($owner_id, $user_id);
            $title = 'joyspe｜履歴一覧 - アクションメッセージ・テンプレート作成';
            $data = array(
                'is_hide' => 0
            );
            $this->Mtemplate->updateUserPaymentHideOrReturn($data, $user_id, $owner_recruit_id);
            $this->viewData['loadPage'] = 'owner/dialog/dialog_hide';
            $this->viewData['title'] = $title;
            $this->viewData['flag'] = $flag;
            $this->load->view("owner/layout/layout_B", $this->viewData);
        } else {
            show_404();
        }
    }

    /**
     * @author [IVS] Lam Tu My Kieu
     * @name   dialog_return
     * @todo   show dialog return and insert to db
     * @param $user_id
     * @return void
     */
    public function dialog_return($user_id = NULL) {
        if ($user_id != NULL) {
            $owner_id = OwnerControl::getId();
            $owner_recruit_id = $this->Mowner->getOwnerRecruitIdOld($owner_id, $user_id);
            $title = 'joyspe｜戻す';
            $data = array(
                'is_hide' => 1
            );
            $this->Mtemplate->updateUserPaymentHideOrReturn($data, $user_id, $owner_recruit_id);
            $this->viewData['loadPage'] = 'owner/dialog/dialog_return';
            $this->viewData['title'] = $title;
            $this->load->view("owner/layout/layout_B", $this->viewData);
        } else {
            show_404();
        }
    }

    /**
     * @author [IVS] Lam Tu My Kieu
     * @name   dialog_scout
     * @todo   show dialog scout and insert to db
     * @param $user_id, $flag
     * @return void
     */
    public function dialog_scout($user_id = null, $flag = null) {
        $this->load->model("user/Mnewjob_model");
        $title = 'joyspe｜スカウト送信';
        $set_send_mail_ow = OwnerControl::getSetSendMail();        
        $owner_id = OwnerControl::getId();          
        $owner_recruit_id = $this->Mowner->getOwnerRecruitId($owner_id);                   
        $company_data= $this->Mnewjob_model->getOwnerRecruitHappyMoney($owner_recruit_id);            
        $user_happy_money = $company_data[0]['user_happy_money']; 

        $owner_status = OwnerControl::getOwnerStatus($owner_id);
        $set_send_mail_us = $this->Musers->setSendMailUser($user_id);
        $user_data = $this->Muser->getDataUser($user_id);
        if ($user_data != NULL && $flag == '3') {
            $d = date('y-m-d G:i:s', now());
            $tem_ow = $this->Mtemplate->getTemp(($user_happy_money > 0)?'ow04':'ow23');
            $tem_us = $this->Mtemplate->getTemp(($user_happy_money > 0)?'us03':'us14');
            $data_ow = array(
                'owner_id' => $owner_id,
                'template_id' => $tem_ow['id'],
                'created_date' => $d);
//            $data_us = array(
//                'is_read' => 0,
//                'updated_date' => $d
//            );
            //$this->Mtemplate->updateUserListForScout($data_us, $user_id, $tem_us['id'], $owner_recruit_id);
            // payment already
            $payment_message_status = 1;
            $this->Mtemplate->insertUserListForScout($owner_recruit_id, $user_id, $tem_us['id'], $payment_message_status);
            $this->Mtemplate->insertOwnerList($data_ow);
            if ($set_send_mail_us[0]['set_send_mail'] == 1 && $owner_status != 1) {
                try {
                    $this->send_user_mail($user_id, $owner_id, $flag);
                } catch (Exception $exc) {
                    throw new Exception;
                }
            }
            if ($set_send_mail_ow == 1) {
                try {
                    $this->send_owner_mail($user_id, $owner_id, $flag);
                } catch (Exception $exc) {
                    throw new Exception;
                }
            }
            $this->viewData['loadPage'] = 'owner/dialog/dialog_scout';
            $this->viewData['title'] = $title;
            $this->load->view("owner/layout/layout_B", $this->viewData);
        } else {
            show_404();
        }
    }

    /**
     * @author [IVS] Nguyen Van Phong
     * @name   dialog_request
     * @todo   
     * @param 
     * @return void
     */
    public function dialog_request($flag = NULL) {
        if ($flag != NULL) {
            $title = 'joyspe｜承認依頼';
            $this->viewData['title'] = $title;
            $this->viewData['flag'] = $flag;
            $this->viewData['loadPage'] = 'owner/dialog/dialog_request';
            $this->load->view("owner/layout/layout_B", $this->viewData);
        } else {
            show_404();
        }
    }

    /**
     * @author [IVS] Nguyen Van Phong
     * @name   dialog_change
     * @todo   
     * @param 
     * @return void
     */
    public function dialog_change() {
        $title = 'joyspe｜変更';
        $this->viewData['title'] = $title;
        $this->viewData['loadPage'] = 'owner/dialog/dialog_change';
        $this->load->view("owner/layout/layout_B", $this->viewData);
    }

}

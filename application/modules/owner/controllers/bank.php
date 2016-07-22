<?php

class Bank extends Common {

    protected $_data;
    private $viewData;
    private $message = array('success' => true, 'error' => array());

    function __construct() {
        parent::__construct();
        HelperGlobal::requireOwnerLogin(current_url());
        $this->load->helper('breabcrumb_helper');
        $this->load->model('owner/Mbank');
        $this->load->model('owner/Mcommon');
        $this->load->model('owner/Mpoint');
        $this->load->model('user/Musers');
        $this->common = new Common();
        $this->output->set_header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate");
        $this->output->set_header("Cache-Control: post-check=0, pre-check=0");
        $this->output->set_header("Pragma: no-cache");
    }

    /**
     * author: [IVS] Phan Ngoc Minh Luan
     * name : scout
     * todo : banking payment with payment case scout
     * @param null
     * @return void
     */
    public function scout() {
        $email_address = OwnerControl::getEmail();
        $owner_id = OwnerControl::getId();
        if ($owner_id) {
            if (isset($_POST['submit_bank'])) {
                if ($this->validateTranferName()) {
                    $tranfer_name = $this->input->post('txtTranferName');
                    $year = $this->input->post('sltYear');
                    $month = $this->input->post('sltMonth');
                    $day = $this->input->post('sltDay');
                    $hour = $this->input->post('sltHour');
                    $str_date = $year . "-" . $month . "-" . $day . " " . $hour . ":00:00";
                    $post_send_date = date('Y-m-d H:i:s', strtotime($str_date));
                    HelperApp::remove_session('remainder_money');
                    HelperApp::remove_session('remainder_point');
                    HelperApp::remove_session('payment_money');
                    HelperApp::remove_session('payment_point');
                    

                    HelperApp::add_session('tranfer_date', $post_send_date);
                    HelperApp::add_session('payment_name', $tranfer_name);
                    redirect(base_url() . "owner/dialog/dialog_tranfer");
                }
            }
            $money = HelperApp::get_session('remainder_money');
            $point = HelperApp::get_session('remainder_point');
            $payment_money = HelperApp::get_session('payment_money');
            $payment_point = HelperApp::get_session('payment_point');
            $arr_user_id = HelperApp::get_session('arr_user_id_unsent');
            $user_list = "";
            $payment_method_id = 2; // banking payment
            $payment_id = 0;
            $payment_case_id = 1; // case scout
            $count_users_checked = 0;
            if ($money != 0 && $point != 0) {
                $owner_recruit_id = $this->Mpoint->getOwnerRecruitId($owner_id);
                $count_exist = $this->Mpoint->checkExistList($owner_recruit_id, $arr_user_id);
                foreach ($arr_user_id as $user_id) {
                    $user_list .= ($user_list != NULL ? ',' : '') . $user_id;
                }
                if ($count_exist == 0) {
                    $this->Mbank->deleteRowsPaymentStatusRegis($owner_id);
                    $payment_id = $this->Mbank->insertStatusRegisPayment($owner_id, $payment_money, $payment_point, $money, $point, $payment_method_id, $payment_case_id, $user_list);
                    HelperApp::add_session('payment_id', $payment_id);
                    HelperApp::add_session('user_payment_status', -1);
                }
            }
            $owners = $this->Mbank->getTotal($email_address);
            $owner_info = HelperGlobal::owner_info($owner_id);
            $this->viewData['owner_info'] = $owner_info;
            $this->viewData['action'] = "scout";
            $this->viewData['total_point'] = $owners['total_point'];
            $this->viewData['payment_id'] = $payment_id;
            $this->viewData['money'] = $money;
            $this->viewData['point'] = $point;
            $this->viewData['message'] = $this->message;
            $this->viewData['loadPage'] = "owner/bank/bank";
            $this->viewData['title'] = 'joyspe｜銀行決済';
            $this->load->view('owner/layout/layout_B', $this->viewData);
        } else {
            redirect(base_url() . "owner/login");
        }
    }

    /**
     * author: [IVS] Phan Ngoc Minh Luan
     * name : app_cont
     * todo : banking payment with payment case app_conf
     * @param null
     * @return void
     */
    public function app_conf() {
        $email_address = OwnerControl::getEmail();
        $user_list = '';
        $owner_id = OwnerControl::getId();
        if ($owner_id) {
            if (isset($_POST['submit_bank'])) {
                if ($this->validateTranferName()) {
                    $tranfer_name = $this->input->post('txtTranferName');
                    $year = $this->input->post('sltYear');
                    $month = $this->input->post('sltMonth');
                    $day = $this->input->post('sltDay');
                    $hour = $this->input->post('sltHour');
                    $str_date = $year . "-" . $month . "-" . $day . " " . $hour . ":00:00";
                    $post_send_date = date('Y-m-d H:i:s', strtotime($str_date));
                    HelperApp::remove_session('remainder_money');
                    HelperApp::remove_session('remainder_point');
                    HelperApp::remove_session('payment_money');
                    HelperApp::remove_session('payment_point');

                    HelperApp::add_session('tranfer_date', $post_send_date);
                    HelperApp::add_session('payment_name', $tranfer_name);
                    redirect(base_url() . "owner/dialog/dialog_tranfer");
                }
            }
            $payment_money = HelperApp::get_session('payment_money');
            $payment_point = HelperApp::get_session('payment_point');
            $money = HelperApp::get_session('remainder_money');
            $point = HelperApp::get_session('remainder_point');
            $payment_method_id = 2; // banking payment
            $payment_case_id = 2; // case app_conf
            $payment_id = 0;
            if ($money != 0 && $point != 0) {
                $arr_owner_recruit = $this->Mbank->getArrOwnerRecruitId($owner_id);
                foreach ($arr_owner_recruit as $owner_recruit) {
                    $userId = $this->Mbank->getArrUserIdAppSettlement($owner_recruit['id']);
                    $user_list .= ($user_list != null ? ',' : '') . $userId > 0 ? $userId : "";
                    $arr_owner_recruit_id[] = $owner_recruit['id'];
                }
                // get app_conf money purchase
                $info = $this->Mbank->getCharge('1');
                $info_point = $info['point'];
                $info_money = $info['amount'];
                $arr_user_payment = $this->Mpoint->getArrUserPaymentId($arr_owner_recruit_id);
                if ($arr_user_payment != 0) {
                    $this->Mbank->deleteRowsPaymentStatusRegis($owner_id);
                    $payment_id = $this->Mbank->insertStatusRegisPayment($owner_id, $payment_money, $payment_point, $money, $point, $payment_method_id, $payment_case_id, $user_list);
                    HelperApp::add_session('payment_id', $payment_id);
                    $created_date = $this->Mbank->getCurrentDate();
                    foreach ($arr_user_payment as $user_payment) {
                        $arr_user_payment_id[] = $user_payment['id'];
                        // insert transaction with payment_case:2 (money info)
                        $this->Mpoint->insertTransactions($owner_id, $user_payment['id'], 2, $payment_id, $info_money, $info_point, $created_date);
                    }
                    HelperApp::add_session('arr_user_payment_id', $arr_user_payment_id);
                    HelperApp::add_session('user_payment_status', 0); // set user_payment_status app_conf for processing dialog_tranfer view
//                    $this->Mpoint->updateStatusPayForApplyUserPayment($arr_user_payment_id, 0, 1); // set user_payment_status pay for apply   
                }
            }
            $owners = $this->Mbank->getTotal($email_address);
            $owner_info = HelperGlobal::owner_info($owner_id);
            $this->viewData['owner_info'] = $owner_info;
            $this->viewData['action'] = "app_conf";
            $this->viewData['total_point'] = $owners['total_point'];
            $this->viewData['payment_id'] = $payment_id;
            $this->viewData['money'] = $money;
            $this->viewData['point'] = $point;
            $this->viewData['message'] = $this->message;
            $this->viewData['loadPage'] = "owner/bank/bank";
            $this->viewData['title'] = 'joyspe｜銀行決済';
            $this->load->view('owner/layout/layout_B', $this->viewData);
        } else {
            redirect(base_url() . "owner/login");
        }
    }

    /**
     * author: [IVS] Phan Ngoc Minh Luan
     * name : check_app_conf
     * todo : check app conf
     * @param null
     * @return void
     */
    public function check_app_conf() {
        $email_address = OwnerControl::getEmail();
        $owner_id = OwnerControl::getId();
        $count_unview = $_POST['count_unview'];
        $remainder_money = $_POST['remainder_money'];
        $remainder_point = $_POST['remainder_point'];
        $arr_owner_recruit = $this->Mbank->getArrOwnerRecruitId($owner_id);
        $count_apply = 0;
        foreach ($arr_owner_recruit as $owner_recruit) {
            $count_apply += $this->Mbank->countUserPaymentStatusApply($owner_recruit['id']);
        }
        $param = array(
            'count_unview' => $count_unview,
            'count_apply' => $count_apply,
            'remainder_money' => $remainder_money,
            'remainder_point' => $remainder_point,
        );
        HelperApp::add_session('remainder_money', $remainder_money);
        HelperApp::add_session('remainder_point', $remainder_point);
        echo json_encode($param);
        die;
    }

    /**
     * author: [IVS] Phan Ngoc Minh Luan
     * name : recruit
     * todo : banking payment with payment case recruit
     * @param null
     * @return void
     */
    public function recruit() {
        $email_address = OwnerControl::getEmail();
        $owner_id = OwnerControl::getId();
        if ($owner_id) {
            if (isset($_POST['submit_bank'])) {
                if ($this->validateTranferName()) {
                    $tranfer_name = $this->input->post('txtTranferName');
                    $year = $this->input->post('sltYear');
                    $month = $this->input->post('sltMonth');
                    $day = $this->input->post('sltDay');
                    $hour = $this->input->post('sltHour');
                    $str_date = $year . "-" . $month . "-" . $day . " " . $hour . ":00:00";
                    $post_send_date = date('Y-m-d H:i:s', strtotime($str_date));
                    HelperApp::remove_session('remainder_money');
                    HelperApp::remove_session('remainder_point');
                    HelperApp::remove_session('payment_money');
                    HelperApp::remove_session('payment_point');

                    HelperApp::add_session('tranfer_date', $post_send_date);
                    HelperApp::add_session('payment_name', $tranfer_name);
                    redirect(base_url() . "owner/dialog/dialog_tranfer");
                }
            }

            $money = HelperApp::get_session('remainder_money');
            $point = HelperApp::get_session('remainder_point');
            $payment_money = HelperApp::get_session('payment_money');
            $payment_point = HelperApp::get_session('payment_point');
            $payment_method_id = 2; // banking payment
            $payment_case_id = 3; // case recruit
            $payment_id = 0;
            if ($money != 0 && $point != 0) {
                $user_list = HelperApp::get_session('user_list');
                $owner_recruit_id = HelperApp::get_session('owner_recruit_id');
                HelperApp::add_session('user_payment_status', 5); // set user_payment_status recruit for processing dialog_tranfer view
                //$payment_message_status = 0; // not enough money
                $created_date = $this->Mbank->getCurrentDate();
                $user_payment_id = $this->Mpoint->getUserPaymentId($user_list, $owner_recruit_id);
              //  $list_user_message_id = $this->Mpoint->insertListUserMessage($owner_recruit_id, $user_list, 'us11', $payment_message_status);
//                $this->Mbank->deleteRowsPaymentStatusRegis($owner_id);
                $payment_id = $this->Mbank->insertStatusRegisPayment($owner_id, $payment_money, $payment_point, $money, $point, $payment_method_id, $payment_case_id, $user_list);
                HelperApp::add_session('payment_id', $payment_id);
                $this->Mbank->insertTransactions($owner_id, $user_payment_id, 3, $payment_id, $payment_money, $payment_point, $created_date);
            }
            $owners = $this->Mbank->getTotal($email_address);
            $owner_info = HelperGlobal::owner_info($owner_id);
            $this->viewData['owner_info'] = $owner_info;
            $this->viewData['action'] = "recruit";
            $this->viewData['total_point'] = $owners['total_point'];
            $this->viewData['payment_id'] = $payment_id;
            $this->viewData['money'] = $money;
            $this->viewData['point'] = $point;
            $this->viewData['message'] = $this->message;
            $this->viewData['loadPage'] = "owner/bank/bank";
            $this->viewData['title'] = 'joyspe｜銀行決済';
            $this->load->view('owner/layout/layout_B', $this->viewData);
        } else {
            redirect(base_url() . "owner/login");
        }
    }

    /**
     * author: [IVS] Phan Ngoc Minh Luan
     * name : add_point
     * todo : banking payment with payment add point
     * @param null
     * @return void
     */
    public function add_point() {
        $email_address = OwnerControl::getEmail();
        $owner_id = OwnerControl::getId();
        if ($owner_id) {
            if (isset($_POST['submit_bank'])) {
                if ($this->validateTranferName()) {
                    $tranfer_name = $this->input->post('txtTranferName');
                    $year = $this->input->post('sltYear');
                    $month = $this->input->post('sltMonth');
                    $day = $this->input->post('sltDay');
                    $hour = $this->input->post('sltHour');
                    $str_date = $year . "-" . $month . "-" . $day . " " . $hour . ":00:00";
                    $post_send_date = date('Y-m-d H:i:s', strtotime($str_date));
                    HelperApp::remove_session('remainder_money');
                    HelperApp::remove_session('remainder_point');


                    HelperApp::add_session('tranfer_date', $post_send_date);
                    HelperApp::add_session('payment_name', $tranfer_name);
                    redirect(base_url() . "owner/dialog/dialog_tranfer");
                }
            }

            if (isset($_POST['submit_settlement'])) {
                $money = $money_payment = $this->input->post('money');
                $point = $point_payment = $this->input->post('point');
                HelperApp::add_session('remainder_money', $money);
                HelperApp::add_session('remainder_point', $point);
            }
            $money = $money_payment = HelperApp::get_session('remainder_money');
            $point = $point_payment = HelperApp::get_session('remainder_point');
            $payment_method_id = 2; // banking payment
            $payment_case_id = 4; // case add point    
            $payment_id = 0;
            if ($money != 0 && $point != 0) {
                $this->Mbank->deleteRowsPaymentStatusRegis($owner_id);
                $payment_id = $this->Mbank->insertStatusRegisPayment($owner_id, $money_payment, $point_payment, $money, $point, $payment_method_id, $payment_case_id, '');
                HelperApp::add_session('payment_id', $payment_id);
            }
            $owners = $this->Mbank->getTotal($email_address);
            $owner_info = HelperGlobal::owner_info($owner_id);
            $this->viewData['owner_info'] = $owner_info;
            $this->viewData['action'] = "add_point";
            $this->viewData['total_point'] = $owners['total_point'];
            $this->viewData['payment_id'] = $payment_id;
            $this->viewData['money'] = $money;
            $this->viewData['point'] = $point;
            $this->viewData['message'] = $this->message;
            $this->viewData['loadPage'] = "owner/bank/bank";
            $this->viewData['title'] = 'joyspe｜銀行決済';
            $this->load->view('owner/layout/layout_B', $this->viewData);
        } else {
            redirect(base_url() . "owner/login");
        }
    }

    /**
     * author: [IVS] Phan Ngoc Minh Luan
     * name : validate_bank
     * todo : check storename
     * @param null
     * @return boolean
     */
    public function validateTranferName() {
        $this->form_validation->set_rules('txtTranferName', '振込名義 ', 'trim|required|max_length[100]');
        $form_validation = $this->form_validation->run();
        $this->message['success'] = !$form_validation && count($_POST) > 0 ? FALSE : TRUE;
        if (!$form_validation) {
            return false;
        }
        return true;
    }

}

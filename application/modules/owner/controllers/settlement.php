<?php

class Settlement extends Common {

    private $viewData;

    function __construct() {
        parent::__construct();
        $this->load->helper('breabcrumb_helper');
        $this->load->model('owner/Msettlement');
        $this->load->model('owner/Mpoint');
        $this->load->model("owner/Mdialog");
        $this->load->model("owner/Mcredit");
        $this->output->set_header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate");
        $this->output->set_header("Cache-Control: post-check=0, pre-check=0");
        $this->output->set_header("Pragma: no-cache");
    }

    /**
     * author: [IVS] Phan Ngoc Minh Luan
     * name : doSettlement
     * todo : show view settlement
     * @param null
     * @return void
     */
    public function index() {
        $owner_id = OwnerControl::getId();
        if ($owner_id) {
            $email_address = OwnerControl::getEmail();
            $card_point_masters = $this->Msettlement->getCardPointMasters();
            $bank_point_masters = $this->Msettlement->getBankPointMasters();
            $owners = $this->Msettlement->getTotal($email_address);
            $owner_info = HelperGlobal::owner_info($owner_id);
            HelperApp::add_session('settlement', 'settlement');
            HelperApp::add_session('user_payment_status', -2);
            $this->viewData['owner_info'] = $owner_info;
            $this->viewData['total_point'] = $owners['total_point'];
            $this->viewData['card_point_masters'] = $card_point_masters;
            $this->viewData['bank_point_masters'] = $bank_point_masters;
            $this->viewData['loadPage'] = "settlement/settlement";
            $this->viewData['title'] = 'joyspe｜ポイント購入';
            $this->load->view('owner/layout/layout_B', $this->viewData);
        } else {
            redirect(base_url() . "owner/login");
        }
    }

     /**
     * クレジットカード 都度決済処理
     *
     * @param
     * @return view
     * @throws Exception
     */
    function finish_credit(){
        log_message('INFO', __METHOD__ . " START");
        //決済データ受け取りのレスポンス
        echo "SuccessOK";
        $this->credit();
        log_message('INFO', __METHOD__ . " END");
    }

    /**
     * クレジットカード スピード決済処理
     *
     * @param
     * @return view
     * @throws Exception
     */
    function finish_speed(){
        log_message('INFO', __METHOD__ . " START");
        //決済データ受け取りのレスポンス
        echo "SuccessOK";
        $this->credit();
        log_message('INFO', __METHOD__ . " END");
    }
    /**
     * Credit Card 処理
     *
     * @param
     * @return
     * @throws Exception
     */
    private function credit(){
    log_message('INFO', __METHOD__ ." START");
// error_reporting(E_ALL);
// ini_set('display_errors',1);
// $path = "/var/www/arche_html/joyspe/web/application/modules/owner/controllers/log/debug_log.txt";

        $ret = false;
        //テレコムのIPからしか受け取れない
        $allow_ips = unserialize(ALLOWED_SERVERS);
        if ( !in_array($_SERVER['REMOTE_ADDR'],$allow_ips) ){
            //不正なアクセス
            log_message('ERROR', __METHOD__ ."クレジットカード決済: 不正なアクセス");
            return $ret;
        }
        $get_array=$this->input->get(); //TODO: セキュリティのため,postへ変更しよう
        if ( $get_array ){
            $result             = $this->input->get('rel',TRUE);
            $credit_hash        = $this->input->get('option',TRUE);
            $charge             = $this->input->get('money', TRUE);
            $owner_unique_id    = $this->input->get('sendid', TRUE);
            $credit_telno       = $this->input->get('telno', TRUE);

            if ( $result != 'yes' ){//決済失敗
                if ( $credit_hash && $owner_unique_id ){
                    //決済が失敗しました。なにもしない
                }
            }else{  //決済成功
                if ( $credit_hash && $charge && $owner_unique_id ){
                    $this->load->Model("admin/Mpayment");
                    $transaction = $this->Mpayment->get_payment_transaction($credit_hash, $owner_unique_id);
                    //クレジットトランザクションが存在しない場合のエラー処理
                    if( !$transaction || !is_array($transaction) ){
                        log_message('ERROR', __METHOD__ ."決済失敗：　クレジットトランザクションが存在しません");
                    }else{
                        //決済成功
                        $payment_id = $transaction[0]['id'];
                        $payment_name = "ポイント購入";//デフォルト
                        if ( $transaction[0]['name'] ){
                            $payment_name = $transaction[0]['name'];
                        }
                        $payment_case_id = $transaction[0]['payment_case_id'];
                        //paymentsテーブル情報更新
                        $payment_update_ret = $this->Mpayment->updatePayment($payment_id,$payment_name,$credit_telno);
                        if ( $payment_update_ret ){
                            //ポイント更新
                            if($payment_case_id == 4){
                                $this->Mpayment->update_owner_by_payment_id($payment_id);
                            }else if(   $payment_case_id == 1 ||
                                        $payment_case_id == 2 ||
                                        $payment_case_id == 3
                                    ){
                                CommonQuery::updateTotalPointAndMount(0, 0, "", $owner_unique_id);
                            }
                            $this->load->model('Owner/Mowner');
                            $result_owner_id = $this->Mowner->getOwnerIDFromUniqueID($owner_unique_id);
                            if ( $result_owner_id ){
                                $owner_id       = $result_owner_id['id'];
                                $list           = $transaction[0]['user_list'];
                                $arr_user_id    = explode(",",$list);
                                $count_unsent   = 0;
                                if ( $arr_user_id ){
                                    $count_unsent = count($arr_user_id);
                                }
                                $set_mail = $this->Mpayment->select_set_send_mail_from('owners',$owner_id);
                                //メール送信かどうかフラグ取得
                                $set_send_mail_owner = 0;
                                if ( $set_mail && is_array($set_mail)){
                                    $set_send_mail_owner=$set_mail['set_send_mail'];
                                }
                                $created_date = CommonQuery::getCurrentDate();

                                switch ( $payment_case_id ){
                                case 1: //スカウト

                                    // オンナー求人ID取得
                                    $owner_recruit_id = $this->Mpoint->getOwnerRecruitId($owner_id);
                                    //　スカウト金額取得
                                    $scout = $this->Mdialog->getCharge('0');
                                    $scout_point = $scout['point'];
                                    $scout_money = $scout['amount'];
                                    $payment_message_status = 0; // not enough money
                                    foreach ($arr_user_id as $user_id){
                                        $list_user_message_id = $this->Mpoint->insertListUserMessage($owner_recruit_id, $user_id, 'us03', $payment_message_status);
                                        // insert transaction with payment_case:1 (money scout)
                                        $this->Mpoint->insertTransactions($owner_id, $list_user_message_id, 1, $payment_id, $scout_money, $scout_point, $created_date);
                                    }

                                    $this->sendMail('', '', '', array('ss03'), $payment_id,null,null,'getUserSelect','getJobUser','getJobOwner' ,$arr_user_id,'',$count_unsent);
                                    if ($set_send_mail_owner==1) {
                                        //owner recruit id取得
                                        $irus03=$this->Mpayment->urlUs03($owner_id);
                                        foreach ($irus03 as $k=>$i){
                                            $owr03=$i["id"];
                                        }
                                        $urlus03=base_url()."user/joyspe_user/company/".$owr03;

                                        $this->sendMail('', '', '', array('ow06'), $payment_id, null, $owner_id,'getUserSelect','getJobUser','getJobOwner' ,$arr_user_id, '',$count_unsent);
                                        // send mail ow04 for user
                                        $this->sendMail('', '', '', array('ow04'), $owner_id,null, null,'getUserSelect','getJobUser','getJobOwner' ,$arr_user_id, '',$count_unsent);
                                        // （テンプレートus03）スカウトメール送信
                                        foreach ($arr_user_id as $uid){
                                            $this->sendMail('', '', '', array('us03'), $owner_id, '', $uid,'getUserSelect','getJobUser','getJobTypeOwnerForScout' ,$arr_user_id, $urlus03,'');
                                        }
                                    }
                                    //update payment message status
                                    $this->Mpayment->updatePaymentMessage($payment_id);
                                    break;
                                case 2: //応募確認情報
                                    $arr_owner_recruit = $this->Mcredit->getArrOwnerRecruitId($owner_id);
                                    foreach ($arr_owner_recruit as $owner_recruit) {
                                        $arr_owner_recruit_id[] = $owner_recruit['id'];
                                    }
                                    // 応募確認に必要金額取得
                                    $info = $this->Mcredit->getCharge('1');
                                    $info_point = $info['point'];
                                    $info_money = $info['amount'];
                                    $arr_user_payment = $this->Mpoint->getArrUserPaymentId($arr_owner_recruit_id);
                                    if ( $arr_user_payment != 0 ){
                                        $arr_user_payment_id = array();
                                        foreach ($arr_user_payment as $user_payment) {
                                            $arr_user_payment_id[] = $user_payment['id'];
                                        }
                                        //　購入状態更新
                                        $this->Mpoint->updateStatusPayForApplyUserPayment($arr_user_payment_id, 0, 1);
                                    }


                                    if($set_send_mail_owner==1){
                                        $this->sendMail('', '', 'Joyspe', array('ow09'), $payment_id, '', '','getUserSelect','getJobUser','getJobOwner' ,$arr_user_id, '',$count_unsent);
                                    }
                                    $this->sendMail('', '', '', array('ss05'), $payment_id,null,null,'getUserSelect','getJobUser','getJobOwner' ,$arr_user_id, '',$count_unsent);
                                    break;
                                case 3: //採用金
                                    $owner_recruit_id = $transaction[0]['payment_name'];
                                    foreach ($arr_user_id as $user_id){
                                        $user_payment_id = $this->Mpoint->getUserPaymentId($user_id, $owner_recruit_id);
                                        $payment_message_status = 0; // not enough money
                                        $list_user_message_id = $this->Mpoint->insertListUserMessage($owner_recruit_id, $user_id, 'us11', $payment_message_status);

                                        $ret_req = $this->Mpoint->setStatusUserPayments($user_id, $owner_recruit_id, 5, 6); // set user_payment_status approve
                                    }

                                    //update payment message status
                                    if($set_send_mail_owner==1){
                                        $urlus11 = "";
                                        $irus11=$this->Mpayment->urlUs11($owner_id);
                                        if(count($irus11)!=0){
                                            $owr11 = $irus11[0]["id"];
                                            $urlus11=base_url()."user/joyspe_user/company/".$owr11;
                                        }
                                        $this->sendMail('', '', '',array('ow19'), $payment_id, '', '','getUserSelect','getJobUser','getJobOwner' ,$arr_user_id, '','');
                                        $this->sendMail('', '', '',array('ss06'),$payment_id,null,null,'getUserSelect','getJobUser','getJobOwner' ,$arr_user_id, '','');
                                        foreach ($arr_user_id as $user_id){
                                            $this->sendMail('', '', '', array('us11'), $owner_id, '', $user_id,'getUserSelect','','getJobOwner' ,'', $urlus11,'');
                                        }
                                    }

                                    $this->Mpayment->updatePaymentMessage2($payment_id);
                                    break;
                                case 4: //ポイント購入
                                    //オンナーへ決済成功メール送信
                                    if($set_send_mail_owner == 1){
                                        $this->sendMail('', '', 'Joyspe', array('ow21'), $payment_id, '', $owner_id,'getUserSelect','getJobUser','getJobOwner' ,'', '','');
                                    }
                                    //管理者へ購入済みメール送信
                                    $this->sendMail('', '', '', array('ss04'), $payment_id, $senderName = null, $owner_id,'getUserSelect','getJobUser','getJobOwner' ,'', '',1);
                                    break;
                                default:
                                }
                                if ( $payment_case_id != 4 ){
                                    $count_penalty = $this->Mdialog->countPenalty($owner_id);
                                    if ($count_penalty == 0) {
                                        $owner = $this->Mowner->getOwner($owner_id);
                                        if ($owner['owner_status'] == 3) {
                                            //update owner_status = 2
                                            $this->Mdialog->updateOwnerStatus($owner_id, 2);
                                        }
                                    }
                                }
                                $ret = true;
                            }
                        }
                        if ( $ret == false ){
                            //決済が失敗しました。なにもしない
                        }
                    }
                }
            }
        }else{
            log_message('ERROR', __METHOD__ ."クレジットカード決済: 不正なアクセス");
        }
        log_message('INFO', __METHOD__ . " END");
    }
}

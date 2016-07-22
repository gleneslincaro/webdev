<?php


class Credit extends Common {

    private $viewData;
    private $common;

    function __construct() {
        parent::__construct();
        $this->load->helper('breabcrumb_helper');
        $this->load->model('owner/Mhistory');
        $this->load->model('owner/Muser');
        $this->load->model('owner/Mtemplate');
        $this->load->model('owner/Mowner');
        $this->load->model('owner/Mpoint');
        $this->load->model('owner/Mcommon');
        $this->load->model('owner/Mcredit');
        $this->load->model('owner/Msettlement');
        $this->load->model('admin/Mpayment');
        $this->load->model("owner/Mdialog");
        $this->common = new Common();
        $this->output->set_header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate");
        $this->output->set_header("Cache-Control: post-check=0, pre-check=0");
        $this->output->set_header("Pragma: no-cache");
        if (!OwnerControl::LoggedIn()) {
            redirect(base_url() . "owner/login/");
        }
    }

    /**
     * @author [IVS] Lam Tu My Kieu
     * @name   credit_information
     * @todo   get credit information
     * @param  
     * @return void
     */
    /**************削除************
    public function credit_information() {
        $title='joyspe｜クレジット情報';
        $owner_id = OwnerControl::getId();
        $owner_data = HelperGlobal::owner_info($owner_id);
        $this->viewData['owner_data'] = $owner_data;
        $this->viewData['title'] = $title;
        $this->viewData['loadPage'] = 'owner/credit/credit_information';
        $this->load->view("owner/layout/layout_D", $this->viewData);
    }
    */
    /**
     * @author [IVS] Lam Tu My Kieu
     * @name   credit_complete
     * @todo   get credit complete
     * @param  
     * @return void
     */
    public function credit_complete() {
// error_reporting(E_ALL);
// ini_set('display_errors',1);
// $path = "/var/www/arche_html/joyspe/web/application/modules/owner/controllers/log/debug_log.txt";
        $title='joyspe｜クレジット決済';
        $owner_id = OwnerControl::getId();
        $pay_flag = false;
        if ($owner_id) {
            $email_address = OwnerControl::getEmail();
            $owners = $this->Msettlement->getTotal($email_address);
            $owner_data = HelperGlobal::owner_info($owner_id);
            $this->viewData['total_point'] = $owners['total_point'];

            $payment_id = HelperApp::get_session("payment_id");//決済情報一時保存id

            //payment_idが存在しない場合はポイント購入TOPへ
            if (!$payment_id) {
                redirect('owner/settlement', 'refresh');
            }
            HelperApp::remove_session('payment_id');
            $transaction = $this->Mpayment->get_payment_transaction_from_id($payment_id);
            if ($transaction) {
                $pay_flag = true;
            }

            HelperApp::remove_session('arr_user_payment_id');
            HelperApp::remove_session('owner_recruit_id');
            HelperApp::remove_session('arr_user_id_unsent');

            $this->viewData['owner_info'] = $owner_data;
            $this->viewData['title'] = $title;
            if ( $pay_flag ){
                $this->viewData['loadPage'] = 'owner/credit/credit_ok';
            }else{
                 $this->viewData['loadPage'] = 'owner/credit/credit_ng';
            }
            $this->load->view("owner/layout/layout_B", $this->viewData);
        }else{
            redirect(base_url() . "owner/login");
        }
    }
    /**
     * @author [IVS] Lam Tu My Kieu
     * @name   credit_ng
     * @todo   get credit ng
     * @param  
     * @return void
     */
    public function credit_ng() {
        $title='joyspe｜クレジット決済';
        $owner_id = OwnerControl::getId();
        $owner_data = HelperGlobal::owner_info($owner_id);
        
        
        $this->viewData['owner_data'] = $owner_data;
        $this->viewData['title'] = $title;
        $this->viewData['loadPage'] = 'owner/credit/credit_ng';
        $this->load->view("owner/layout/layout_D", $this->viewData);
    }
    
    /**
     * @author [IVS] Lam Tu My Kieu
     * @name   credit
     * @todo   get credit 
     * @param  
     * @return void
     */
    public function index() {
        /*$title='joyspe｜クレジット決済';
        $owner_id = OwnerControl::getId();
        $owner_data = HelperGlobal::owner_info($owner_id);
        $this->viewData['owner_data'] = $owner_data;
        $this->viewData['title'] = $title;
        $this->viewData['loadPage'] = 'owner/credit/credit';
        $this->load->view("owner/layout/layout_D", $this->viewData);
        */
    }
    /**
     * クレジットカード 決済確認画面表示
     *
     * @param　 なし
     * @return view
     * @throws Exception
     */
    function credit_confirm(){
        $owner_id = OwnerControl::getId();
        if ($owner_id) {
            $email_address = OwnerControl::getEmail();
            $owners = $this->Msettlement->getTotal($email_address);
            $owner_info = HelperGlobal::owner_info($owner_id);
            $credit_hash = substr(md5("crdit".$owner_id.time()),1,15);
            $owner_unique_id = $owner_info['unique_id'];
            $money = $this->input->post('money');
            $point = $this->input->post('point');
            if ( $money && $point && $owner_unique_id){
                HelperApp::remove_session('credit_money');
                HelperApp::remove_session('credit_point');
                HelperApp::add_session('credit_money', $money);
                HelperApp::add_session('credit_point', $point);

                $payment_case_id = $this->input->post('payment_case');
                if ( !$payment_case_id ){
                    $payment_case_id = 4; //デフォルトはポイント購入
                }
                $user_list = "";
                if ( $payment_case_id != 4 ){
                    if ( $payment_case_id == 3 ){ //採用金の場合
                        $arr_user_id = HelperApp::get_session('user_list');
                    }else{
                    $arr_user_id = HelperApp::get_session('arr_user_id_unsent');
                    }
                    HelperApp::remove_session('user_list');
                    HelperApp::add_session('user_list', $arr_user_id);
                }
                HelperApp::add_session('payment_case_id', $payment_case_id);
                $this->viewData['owner_info'] = $owner_info;
                $this->viewData['total_point'] = $owners['total_point'];
                $this->viewData['loadPage']     = "credit/credit_confirm";
                $this->viewData['confrm_money'] = $money;
                $this->viewData['confrm_point'] = $point;
                $this->viewData['credit_hash'] = $credit_hash;
                $this->viewData['sendid'] = $owner_unique_id;
                $this->viewData['title'] = 'joyspe｜ポイント購入確認';
                $check_used_card_result = $this->Mpayment->checkUseCreditCard($owner_id);
                if ( $check_used_card_result ){ //スピード決済か都度決済
                    $this->viewData['credit_url'] = CREDIT_CARD_COMPANY_URL_SPEED;
                    $this->viewData['usrtel'] = $check_used_card_result; //オンナーの登録電話番号
                }else{
                    $this->viewData['credit_url'] = CREDIT_CARD_COMPANY_URL_NORMAL;
                }
                $this->load->view('owner/layout/layout_B', $this->viewData);
            }
        } else {
            redirect(base_url() . "owner/login");
        }
    }
     /**
     * author: VJソリューションズ
     * name : add_point
     * todo : クレジットカード決済情報をDBに登録する
     * @param  sendid
     * @return void
     */
    public function add_point($credit_hash) {
        if ( !$credit_hash ){
            echo 0;
        }
        $owner_id = OwnerControl::getId();
        if ( $owner_id ) {
            $money = $money_payment = HelperApp::get_session('credit_money');
            $point = $point_payment = HelperApp::get_session('credit_point');
            HelperApp::remove_session('credit_point');
            HelperApp::remove_session('credit_money');
            $payment_method_id  = 1;   // クレジットカード決済
            $payment_case_id = HelperApp::get_session('payment_case_id');
            HelperApp::remove_session('payment_case_id');
            if ( !$payment_case_id ){
                $payment_case_id    = 4;   // ポイント購入
            }
            $user_list = NULL;
            $arr_user_id = NULL;
            if ( ($payment_case_id != 4) ){
                $arr_user_id = HelperApp::get_session('user_list');
                if ( is_array($arr_user_id) ){
                    foreach ($arr_user_id as $user_id_itm) {
                        $user_list .= ($user_list != NULL ? ',' : '') . $user_id_itm;
                    }
                }else{
                    $user_list = $arr_user_id;
                }
                HelperApp::remove_session('user_list');
            }
            $payment_id = 0;
            if ($money != 0 && $point != 0) {
                $this->Mcredit->deleteRowsPaymentStatusRegis($owner_id);
                if ( $payment_case_id == 3 /* 採用金額 */){
// error_reporting(E_ALL);
// ini_set('display_errors',1);
// $path = "/var/www/arche_html/joyspe/web/application/modules/owner/controllers/log/debug_log.txt";
                    $owner_recruit_id=HelperApp::get_session('owner_recruit_id');
// $msg="owner_recruit_id: ".$owner_recruit_id;
// error_log($msg,3,$path);

                    //一時的にpayment_nameにowner_recruit_idを保管する
                    $payment_id = $this->Mcredit->insertStatusRegisPayment($owner_id, $money_payment, $point_payment, $money, $point, $payment_method_id, $payment_case_id, $user_list, $credit_hash, $owner_recruit_id);
                }else{
                    $payment_id = $this->Mcredit->insertStatusRegisPayment($owner_id, $money_payment, $point_payment, $money, $point, $payment_method_id, $payment_case_id, $user_list, $credit_hash);
                }

                HelperApp::remove_session('payment_id');
                if ( $payment_id == -1 ){ //登録失敗の場合
                    echo 0;
                    exit;
                }else{
                    HelperApp::add_session('payment_id',$payment_id);

                    $created_date = $this->Mcredit->getCurrentDate();

                    //トランザクション登録
                    switch($payment_case_id){
                    case 1: /* スカウト */
                        break;
                    case 2: /* 応募者確認 */
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
                                // payment_case_id:2(応募情報確認)の支払いトランザクション追加
                                $this->Mcredit->insertTransactions($owner_id, $user_payment['id'], 2, $payment_id, $info_money, $info_point, $created_date);
                            }
                        }
                        break;
                    case 3: /* 採用金 */
                        $arr_payment_user_ids = array();
                        if ( is_array($arr_user_id) ){
                            $arr_payment_user_ids = $arr_user_id;
                        }else{
                            $arr_payment_user_ids[] = $arr_user_id;
                        }
                        $owner_recruit_id = HelperApp::get_session('owner_recruit_id');
                        foreach ($arr_payment_user_ids as $user_id){
                            $user_payment_id = $this->Mpoint->getUserPaymentId($user_id, $owner_recruit_id);
                            $this->Mcredit->insertTransactions($owner_id, $user_payment_id, 3, $payment_id, $money, $point, $created_date);
                        }
                        break;
                    default:
                    }
                }
            }
            echo 1;
        } else {
            redirect(base_url() . "owner/login");
        }
    }
}

?>

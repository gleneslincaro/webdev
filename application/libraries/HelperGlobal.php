<?php

class HelperGlobal {

    private static $instance = null;

    public function __construct() {

    }
    /**
     * author: [IVS] Le Thi My Phuong
     * name : require_login
     * todo : require login
     */
    public static function require_login($return_url = '') {

        if (!UserControl::LoggedIn()) {
            $url = base_url()."user/login";
            if($return_url != '')
                $url = $url."?return_url=".  urlencode($return_url);
            redirect($url);
            die;
        }
    }
    /**
     * author: [IVS] Le Thi My Phuong
     * name : gettotalHeader
     * todo : get total owner in Header
     */
    public static function gettotalHeader() {
        $Musers = new Musers();
        $owner_status = "2,5";
        self::$instance = $Musers->count_Owners($owner_status);
        return self::$instance;
    }

    /**
    * author: VJS
    * name : getNumberOfUser
    * todo : get total user in
    */
    public static function getUserTotalNumber() {
        $Musers = new Musers();
        $total = $Musers->getTotalUserNo();
        if ( $total < 10000 ){
             $strtotalUserNo = $total;
        }else{
            $ten_thousands = (int)($total/10000);
            $below_ten_thousands = $total - (10000*$ten_thousands);
            if ( $below_ten_thousands == 0){
                $strtotalUserNo = $ten_thousands."万";
            }else{
                $strtotalUserNo = $ten_thousands."万".$below_ten_thousands;
            }
        }

        return $strtotalUserNo;
    }


    /**
     * author: [IVS] Nguyen Bao Trieu
     * name : requireOwnerLogin
     * todo : check current page
     * @param string $return_url
     * @return null
     */
    public static function requireOwnerLogin($return_url = '') {

        if (!OwnerControl::LoggedIn()) {
            $url = base_url() . "owner/login";
            if ($return_url != '')
                $url = $url . "?return_url=" . urlencode($return_url);
            redirect($url);
            die;
        }

    }


     /**
     * @author [IVS] Lam Tu My Kieu
     * @name   owner_info
     * @todo   return owner_info
     * @param
     * @return void
     */

    public static function owner_info($owner_id) {
        $Mowner = new Mowner();
        self::$instance = $Mowner->getOwner($owner_id);
        return self::$instance;
    }

   /**
     * author: [IVS] Nguyen Bao Trieu
     * name : checkScreen
     * todo : check Screen
     * @param null
     * @return string url
    */
    public static function checkScreen($url = null)
    {
        $Mowner = new Mowner();

        if(HelperApp::get_session('ownerId')!='')
        {
            $owner = $Mowner->getOwner(HelperApp::get_session('ownerId'));
            $owner_recruit = $Mowner->getOwnerRecruit($owner['id']);
            if ($owner['owner_status'] == 0) {  // 仮登録
                redirect(base_url() . "owner/login/login_guide");
            } else if ($owner['owner_status'] == 1 || $owner['owner_status'] == 2) { //ステルス  //本登録
                //現在日付取得
                $date_array = getdate();
                //オープン日付取得
                $open_date_stamp = strtotime(OPEN_DATE);
                $open_date_day = date('d', $open_date_stamp);
                $open_date_mon = date('m', $open_date_stamp);
                $open_date_year = date('Y', $open_date_stamp);
                $is_open_flg =  ( ($date_array['mday'] == $open_date_day) &&
                                ($date_array['mon'] == $open_date_mon) &&
                                ($date_array['year'] == $open_date_year) )
                                ?
                                TRUE : FALSE;
                //管理者のオンナーか、OPEN_FLAGかオープンデートになった場合、通常ページ表示
                if (($owner && $owner['admin_owner_flag'] == 1) || OPEN_FLAG  == 1 || $is_open_flg == TRUE){
                    if (count($owner_recruit) == 0) { // hasn't got a recruit
                        redirect(base_url() . "owner/login/login_store");
                    } else if($owner_recruit['recruit_status'] == 1) { // had recruit
                        redirect(base_url() . "owner/login/login_store_after");
                    } else if($owner_recruit['recruit_status'] == 2) { // recruit was be approved
                        if($url != (base_url().'index.php/owner/index'))
                        {
                            redirect(base_url() . "owner/index");
                        }
                    }
                    else if($owner_recruit['recruit_status'] == 3) // recruit was be denied
                    {
                        redirect(base_url() . "owner/message/message_approval_profile");
                    }
                }else{ //オープンデートまで、オープンお知らせページ表示
                    redirect(base_url() . "owner/open");
                }
            } elseif ($owner['owner_status'] == 3) { //ペナルティ
                redirect(base_url() . "owner/index/index03");
            }
        }
    }
      /**
     * author: [IVS] Nguyen Ngoc Phuong
     * name : checkscoutmail
     * todo : check Scout mail
     * @param null
     * @return string User_id
    */
    public static function checkscoutmail($user_id=0){
        $Musers = new Musers();
        self::$instance = $Musers->check_scout_mail($user_id);
        return self::$instance;

    }
      /**
     * author: [IVS] Nguyen Ngoc Phuong
     * name : checksinterviewmail
     * todo : check interview mail
     * @param null
     * @return string User_id
    */
    public static function checkinterviewmail($user_id=0){
        $Musers = new Musers();
        self::$instance = $Musers->check_interview_mail($user_id);
        return self::$instance;
    }
    /**
     * author: [IVS] Nguyen Ngoc Phuong
     * name : checknewmail
     * todo : check new mail
     * @param null
     * @return string User_id
    */
    public static function checknewmail($user_id=0){
        $Musers = new Musers();
        self::$instance = $Musers->check_new_mail($user_id);
        return self::$instance;
    }
    /**
     * author: [IVS] Nguyen Ngoc Phuong
     * name : checkhappymoneymail
     * todo : check happymoney mail
     * @param null
     * @return string User_id
    */
    public static function checkhappymoneymail($user_id=0){
        $Musers = new Musers();
        self::$instance = $Musers->check_happymoney_mail($user_id);
        return self::$instance;
    }

     /**
     * author: [IVS] Nguyen Ngoc Phuong
     * name : checktakehappymoney
     * todo : check takehappymoney
     * @param null
     * @return string User_id
    */
    public static function checktakehapymoney($user_id=0,$day_happy_money){
        $Musers = new Musers();
        self::$instance = $Musers->check_take_happymoney($user_id,$day_happy_money);
        return self::$instance;
    }

    public static function writeToLog($log_msg) {
        if (1) {
            error_log($log_msg, 3, "/tmp/joyspe_log");
        } else {
            error_log($log_msg, 3, "C:/98_Software/TranPC/xammp/htdocs/joyspe/logs/joyspe_log");
        }
    }
    
     /**
    * name : getUserCurrentBonus
    * desc : get user current bonus
    * return : array
    */
    public static function getUserCurrentBonus() {
        $Musers = new Musers();
        if (UserControl::LoggedIn()) {
            $user_id =  UserControl::getId();
            
            $bonus_data = $Musers->getUserScoutMailBonus0($user_id);
            if (count($bonus_data) > 0) {
                return $bonus_data;
            }
        }
    }

}

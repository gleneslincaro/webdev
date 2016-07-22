<?php

class AdminControl {

    private static $instance = null;
    private static $fetch = false;
    
    /**
    * @author     [IVS] Phan Van Thuyet
    * @name 	CheckLogin
    * @todo 	check login
    * @param 	 
    * @return 	
    */
    public static function CheckLogin(){
        self::CheckIP();
        //ログインチェック
        if(!self::LoggedIn()){
            redirect(base_url().'admin/system/login');
        }
    }
    /**
    * @author   VJソリューションズ
    * @name     CheckIP
    * @todo     アクセス可能IPかチェック
    * @param    なし
    * @return   TRUE:可能、 FALSE:不可
    */
    public static function CheckIP(){
        //IP制限
        $CI =& get_instance();
        $CI->load->model('admin/mipaddress');
        $accessable_ips = $CI->mipaddress->getAccessableIP();
        if ( $accessable_ips ){
            $remote_ip = $_SERVER['REMOTE_ADDR'];
            if ( in_array($remote_ip, $accessable_ips) == false ){
                redirect(base_url().'admin/system/denyAcess');
            }
        }
    }
    /**
    * @author     [IVS] Phan Van Thuyet
    * @name 	LoggedIn
    * @todo 	description Check if admin is logged in by validate user cookie data
    * @param 	 
    * @return 	bool
    */
    public static function LoggedIn() {
        
        self::FetchAdminInstance();

        if (is_null(self::$instance)){
            return false;
        } else {
            return true;
        }
    }
    /**
    * @author     [IVS] Phan Van Thuyet
    * @name 	FetchAdminInstance
    * @todo 	Fetch admin instance
    * @param 	 
    * @return 	bool
    */
    private static function FetchAdminInstance() {
        if(self::$fetch) return;        
        $login_id = HelperApp::get_session('loginId');
        
        if ($login_id == null) {
            self::$fetch = true;            
            return false;
        } else {                     
            self::$instance = $login_id;
        }
        self::$fetch = true;
    }
    
    /**
    * @author     [IVS] Phan Van Thuyet
    * @name 	getMember
    * @todo 	get info member
    * @param 	 
    * @return 	
    */
    public static function getMember(){
        self::FetchAdminInstance();
        return self::$instance;
    }
    
    /**
    * @author     [IVS] Phan Van Thuyet
    * @name 	DoLogout
    * @todo 	do logout
    * @param 	 
    * @return 	
    */
    public static function DoLogout() {
        HelperApp::clear_cookie();
        HelperApp::clear_session();
    }
    /**
    * @author     [IVS] Phan Van Thuyet
    * @name 	getLoginId
    * @todo 	get loginId
    * @param 	 
    * @return 	
    */
    public static function getLoginId(){
        self::FetchAdminInstance();
        return self::$instance;
    }
   
   

}
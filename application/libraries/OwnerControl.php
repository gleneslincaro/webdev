<?php
class OwnerControl{
       
    private static $instance = null;
    private static $fetch = false;
    
    public static function LoggedIn() {
        
        self::FetchOwnerInstance();
        if (is_null(self::$instance)){
            return false;
        } else {
            return true;
        }
    }
    
    private static function FetchOwnerInstance() {
        
      //  if(self::$fetch) return;         
        
        $owner_id = HelperApp::get_session('ownerId');
      
        if ($owner_id == null) {
            self::$fetch = true;  
            return false;
        } else {
            $Mowner = new Mowner();        
            self::$instance = $Mowner->getOwner($owner_id);
            
              }
        self::$fetch = true;
        
    }
    
    public static function getOwner(){
        self::FetchOwnerInstance();
        return self::$instance;
    }
    
    public static function doLogout() {        
        HelperApp::clear_session();
    }
    
    public static function getId(){
        self::FetchOwnerInstance();
        return self::$instance['id'];
    }
    
    public static function getUnique_id(){
        self::FetchOwnerInstance();
        return self::$instance['unique_id'];
    }
    
    public static function getEmail(){
        self::FetchOwnerInstance();
        return self::$instance['email_address'];
    }
    
    public static function getPassword(){
        self::FetchOwnerInstance();
        return self::$instance['password'];
    }
    
    public static function getOwnerStatus()
    {
        self::FetchOwnerInstance();
        return self::$instance['owner_status'];
    }
    
    public static function getRecruitStatus()
    {
        self::FetchOwnerInstance();
        return self::$instance['recruit_status'];
    }
    
    public static function getStoreName()
    {
        self::FetchOwnerInstance();
        return self::$instance['storename'];
    }
    
    public static function getSetSendMail()
    {
        self::FetchOwnerInstance();
        return self::$instance['set_send_mail'];
    }
    
    
}
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>

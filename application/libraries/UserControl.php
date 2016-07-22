<?php

class UserControl {
    /**
     * @description Check if user is logged in by validate user cookie data
     * @return bool
     * author: [IVS] Le Thi My Phuong
     * name : UserControl
     */
    private static $instance = null;
    private static $fetch = false;
    public static function LoggedIn() {
        self::FetchUserInstance();
        if (is_null(self::$instance)){
            return false;
        } else {
            return true;
        }
    }
    public static function FetchUserInstance() {
        if(self::$fetch) return;
        $user_id = HelperApp::get_session('id');

        if ($user_id == null) {
            self::$fetch = true;
            return false;
        } else {
            $Musers = new Musers();
            self::$instance = $Musers->get_users($user_id);
              }
        self::$fetch = true;

    }
    public static function getuser(){
        self::FetchUserInstance();
        return self::$instance;
    }

    public static function DoLogout() {
        HelperApp::clear_cookie();
        HelperApp::clear_session();
    }

    public static function getId(){
        self::FetchUserInstance();
        return self::$instance['id'];
    }

    public static function getUnique_id(){
        self::FetchUserInstance();
        return self::$instance['unique_id'];
    }

    public static function getEmail(){
        self::FetchUserInstance();
        return self::$instance['email_address'];
    }

    public static function getPassword(){
        self::FetchUserInstance();
        return self::$instance['password'];
    }
    public static function getUserStt(){
        self::FetchUserInstance();
        return self::$instance['user_status'];
    }
    public static function getFromSiteStatus(){
        self::FetchUserInstance();
        return self::$instance['user_from_site'];
    }
    public static function getLastVisitedDate(){
        self::FetchUserInstance();
        return self::$instance['last_visit_date'];
    }
}

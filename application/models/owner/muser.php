<?php

class Muser extends CommonQuery {

    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

    /**
     * @author  [IVS] Lam Tu My Kieu
     * @name 	getDataUser
     * @todo 	get all data for user
     * @param 	int $user_id
     * @return 	data
     */
     function getDataUser($user_id) {

        $sql = "SELECT *

                FROM users u
                WHERE u.id like ?";
        $query = $this->db->query($sql, $user_id);
        return $query->result_array();
    }



    /**
     * @author  [IVS] Lam Tu My Kieu
     * @name 	getAllUsers
     * @todo 	get all users request happy money
     * @param 	int $owner_id, $args, $page = 1, $posts_per_page = 10
     * @return 	data
     */
    function getAllUsersWork($owner_id, $args, $page = 1, $posts_per_page = 10) {
        $params = array($owner_id);
        $custom = "";
        $page = ($page - 1) * $posts_per_page;
        $sql = "SELECT owr.`id` AS owner_recruit_id, u.profile_pic, u.user_from_site, u.id, u.unique_id, u.name AS username, mc.name AS cityname, ma.name1, ma.name2, up.apply_date, up.request_money_date

                FROM users u INNER JOIN user_payments up ON u.`id` = up.user_id
                    INNER JOIN owner_recruits owr ON owr.id = up.owner_recruit_id
                    INNER JOIN owners ow ON ow.id = owr.owner_id
                    INNER JOIN user_recruits ur ON u.id = ur.user_id
                    LEFT JOIN mst_ages ma ON ma.id = ur.age_id
                    LEFT JOIN mst_cities mc ON mc.id= ur.city_id
                WHERE u.display_flag = 1 AND u.`user_status` = 1 AND up.user_payment_status = 5 AND ow.id LIKE ?
                GROUP BY u.`id`
                ORDER BY up.request_money_date DESC
            LIMIT ?,?";

        $params[] = $page;
        $params[] = $posts_per_page;
        $query = $this->db->query($sql, $params);
        return $query->result_array();
    }

    /**
     * @author  [IVS] Lam Tu My Kieu
     * @name 	countUsersWork
     * @todo 	count the number of getAllUsers rows
     * @param 	int $owner_id, $args
     * @return 	int
     */
    public function countUsersWork($owner_id, $args) {
        $params = array($owner_id);
        $sql = "SELECT COUNT(*) AS total

                FROM users u INNER JOIN user_payments up ON u.`id` = up.user_id
                    INNER JOIN owner_recruits owr ON owr.id = up.owner_recruit_id
                    INNER JOIN owners ow ON ow.id = owr.owner_id
                    INNER JOIN user_recruits ur ON u.id = ur.user_id

                WHERE u.display_flag = 1 AND u.`user_status`=1 AND up.user_payment_status = 5 AND ow.id = ?";
        $query = $this->db->query($sql, $params);
        $row = $query->row_array();
        return $row['total'];
    }

    /**
     * @author  [IVS] Lam Tu My Kieu
     * @name 	getAllUsersHide
     * @todo 	get all users hide
     * @param 	int $owner_id, $args, $page = 1, $posts_per_page = 10
     * @return 	void
     */
    function getAllUsersHide($owner_id, $args, $page = 1, $posts_per_page = 10) {
        $params = array($owner_id);
        $custom = "";
        $page = ($page - 1) * $posts_per_page;

        $sql = "SELECT u.id, u.unique_id, u.name AS username, mc.name AS cityname, ma.name1, ma.name2,
                       up.apply_date, up.deny_for_apply_date,
                       up.user_payment_status

                FROM users u INNER JOIN user_payments up ON u.`id` = up.user_id
                    INNER JOIN owner_recruits owr ON owr.id = up.owner_recruit_id
                    INNER JOIN owners ow ON ow.id = owr.owner_id
                    INNER JOIN user_recruits ur ON u.id = ur.user_id
                    LEFT JOIN mst_ages ma ON ma.id = ur.age_id
                    LEFT JOIN mst_cities mc ON mc.id= ur.city_id
                WHERE u.display_flag = 1  AND u.`user_status` = 1 AND (up.user_payment_status = 1
                OR up.`user_payment_status` = 2 OR up.`user_payment_status` = 3 OR up.`user_payment_status` = 4)
                AND up.`is_hide`=0 AND ow.id = ?
                GROUP BY u.`id`
                ORDER BY up.apply_date DESC
            LIMIT ?,?";

        $params[] = $page;
        $params[] = $posts_per_page;
        $query = $this->db->query($sql, $params);
        return $query->result_array();
    }

    /**
     * @author  [IVS] Lam Tu My Kieu
     * @name 	countUsersHide
     * @todo 	count the number of getAllUsersHide rows
     * @param 	int $owner_id,  $args
     * @return 	void
     */
    public function countUsersHide($owner_id, $args) {
        $params = array($owner_id);
        $sql = "SELECT COUNT(*) AS total

                FROM users u INNER JOIN user_payments up ON u.`id` = up.user_id
                    INNER JOIN owner_recruits owr ON owr.id = up.owner_recruit_id
                    INNER JOIN owners ow ON ow.id = owr.owner_id
                    INNER JOIN user_recruits ur ON u.id = ur.user_id

                WHERE u.display_flag = 1  AND u.`user_status` = 1 AND (up.user_payment_status = 1
                OR up.`user_payment_status` = 2 OR up.`user_payment_status` = 3 OR up.`user_payment_status` = 4)
                AND up.`is_hide`=0 AND ow.id = ?";
        $query = $this->db->query($sql, $params);
        $row = $query->row_array();
        return $row['total'];
    }

    /**
     * @author  [IVS] Lam Tu My Kieu
     * @name 	getAllUsersWorkApp
     * @todo 	get all users for work app
     * @param 	int $owner_id,$args, $page = 1, $posts_per_page = 10
     * @return 	data
     */
    function getAllUsersWorkApp($owner_id,$args, $page = 1, $posts_per_page = 10) {
        $params = array($owner_id, $owner_id);
        $custom = "";
        $page = ($page - 1) * $posts_per_page;
        $sql = "SELECT u.id, u.user_from_site, u.unique_id, u.profile_pic, u.name AS username, mc.name AS cityname, ma.name1, ma.name2,
   hp.`joyspe_happy_money`, up.apply_date, up.reply_date,up.interview_date, up.user_payment_status

                FROM users u INNER JOIN user_payments up ON u.id = up.user_id
                    INNER JOIN owner_recruits owr ON owr.id = up.owner_recruit_id
                    INNER JOIN owners ow ON ow.id = owr.owner_id
                    INNER JOIN user_recruits ur ON u.id = ur.user_id
                    LEFT JOIN mst_ages ma ON ma.id = ur.age_id
                    LEFT JOIN mst_cities mc ON mc.id= ur.city_id
                    INNER JOIN mst_happy_moneys hp ON owr.happy_money_id = hp.id
                 WHERE u.display_flag = 1  AND u.`user_status` = 1 AND up.is_hide = 1 AND ow.id = ?
                 GROUP BY u.`id`
                 ORDER BY up.apply_date DESC
                 ";
        $params[] = $page;
        $params[] = $posts_per_page;
        $query = $this->db->query($sql, $params);
        return $query->result_array();
    }


    /**
     * @author  [IVS] Lam Tu My Kieu
     * @name 	countAllUsersApply
     * @todo 	count all users apply
     * @param 	int $owner_id
     * @return 	int
     */
    function countAllUsersApply($owner_id) {
        $sql = "SELECT COUNT(*) AS total
                FROM users u INNER JOIN user_payments up ON u.`id` = up.user_id
                    INNER JOIN owner_recruits owr ON owr.id = up.owner_recruit_id
                    INNER JOIN owners ow ON ow.id = owr.owner_id
                WHERE u.display_flag = 1  AND u.`user_status` = 1 AND up.`user_payment_status` = 0 AND ow.id = ?";

        $query = $this->db->query($sql, array($owner_id));
        $row = $query->row_array();
        return $row['total'];
    }

    /**
     * @author  [IVS] Lam Tu My Kieu
     * @name 	countUserWorkApp
     * @todo 	get user for reply messages (work app)
     * @param 	int $owner_id, $user_id
     * @return 	data
     */
    function getUserWorkApp($owner_recruit_id, $user_id) {
        $sql = "SELECT u.id, u.unique_id, u.name AS username, mc.name AS cityname, ma.name1, ma.name2,
			hp.`joyspe_happy_money`, up.`apply_date`, up.`reply_date`,up.`interview_date`, up.user_payment_status

                FROM users u INNER JOIN user_payments up ON u.`id` = up.user_id
                    INNER JOIN owner_recruits owr ON owr.id = up.owner_recruit_id
                    INNER JOIN owners ow ON ow.id = owr.owner_id
                    INNER JOIN user_recruits ur ON u.id = ur.user_id
                    LEFT JOIN mst_ages ma ON ma.id = ur.age_id
                    LEFT JOIN mst_cities mc ON mc.id= ur.city_id
                    INNER JOIN  mst_happy_moneys hp ON owr.happy_money_id = hp.id
                WHERE u.display_flag = 1 AND u.`user_status` = 1  AND up.user_payment_status = 1
                AND up.`is_hide` = 1 AND up.`owner_recruit_id` like ?
                AND u.`id` LIKE ?";

        $query = $this->db->query($sql, array($owner_recruit_id,$user_id));
        return $query->result_array();
    }

    /**
     * @author  [IVS] Lam Tu My Kieu
     * @name 	countUserWorkAppNot
     * @todo 	get user for deny messages (not work app)
     * @param 	int $owner_id, $user_id
     * @return 	data
     */
    function getUserWorkAppNot($owner_recruit_id,$user_id) {
        $sql = "SELECT u.id, u.unique_id, u.name AS username, mc.name AS cityname, ma.name1, ma.name2,
    hp.`joyspe_happy_money`, up.`apply_date`, up.`reply_date`,up.`interview_date`, up.user_payment_status
                FROM users u INNER JOIN user_payments up ON u.`id` = up.user_id
                    INNER JOIN owner_recruits owr ON owr.id = up.owner_recruit_id
                    INNER JOIN owners ow ON ow.id = owr.owner_id
                    INNER JOIN user_recruits ur ON u.id = ur.user_id
                    LEFT JOIN mst_ages ma ON ma.id = ur.age_id
                    INNER JOIN  mst_happy_moneys hp ON owr.happy_money_id = hp.id
                    LEFT JOIN mst_cities mc ON mc.id= ur.city_id
                WHERE u.display_flag = 1  AND u.`user_status` = 1 AND (up.user_payment_status = 1 OR
                up.`user_payment_status` = 3 OR up.`user_payment_status` = 4) AND up.`is_hide` = 0 AND up.`owner_recruit_id` LIKE ?
                AND u.`id` LIKE ?";


        $query = $this->db->query($sql, array($owner_recruit_id, $user_id));
        return $query->result_array();
    }

    /**
     * @author  [IVS] Lam Tu My Kieu
     * @name 	getAllUsersAdoption
     * @todo 	get all users adoption
     * @param 	int $owner_id, $args, $page = 1, $posts_per_page = 10
     * @return 	data
     */
    function getAllUsersAdoption($owner_id, $args, $page = 1, $posts_per_page = 10) {
        $params = array($owner_id, $owner_id);
        $custom = "";
        $page = ($page - 1) * $posts_per_page;

        $sql = "SELECT u.id, u.user_from_site, u.unique_id, u.profile_pic, u.name AS username, mc.name AS cityname, ma.name1, ma.name2, up.apply_date,
up.`request_money_date`,up.`approved_date`
                FROM users u INNER JOIN user_payments up ON u.id = up.user_id
                    INNER JOIN owner_recruits owr ON owr.id = up.owner_recruit_id
                    INNER JOIN owners ow ON ow.id = owr.owner_id
                    INNER JOIN user_recruits ur ON u.id = ur.user_id
                    LEFT JOIN mst_ages ma ON ma.id = ur.age_id
                    LEFT JOIN mst_cities mc ON mc.id= ur.city_id
                    INNER JOIN `transactions` tr ON up.`id` = tr.`reference_id`
                 WHERE tr.`payment_id` = 0 AND u.display_flag = 1  AND u.`user_status` = 1 AND (up.user_payment_status = 6) AND up.is_hide = 1 AND ow.id = ?
                 GROUP BY u.`id`
                 UNION
SELECT u.id, u.user_from_site,u.unique_id, u.profile_pic,u.name AS username, mc.name AS cityname, ma.name1, ma.name2,
up.apply_date, up.`request_money_date`,up.`approved_date`
                FROM users u INNER JOIN user_payments up ON u.id = up.user_id
                    INNER JOIN owner_recruits owr ON owr.id = up.owner_recruit_id
                    INNER JOIN owners ow ON ow.id = owr.owner_id
                    INNER JOIN user_recruits ur ON u.id = ur.user_id
                    LEFT JOIN mst_ages ma ON ma.id = ur.age_id
                    LEFT JOIN mst_cities mc ON mc.id= ur.city_id
                    INNER JOIN `transactions` tr ON up.`id` = tr.`reference_id`
                    INNER JOIN `payments` pm ON tr.`payment_id` = pm.id
                 WHERE tr.`payment_id` <> 0 AND pm.`payment_status` = 2 AND u.display_flag = 1  AND u.`user_status` = 1 AND (up.user_payment_status = 6) AND pm.owner_id = ?
                 GROUP BY u.`id`
             LIMIT ?,?";

        $params[] = $page;
        $params[] = $posts_per_page;
        $query = $this->db->query($sql, $params);
        return $query->result_array();
    }

    /**
     * @author  [IVS] Lam Tu My Kieu
     * @name 	countAllUsersAdoption
     * @todo 	count all users for adoption
     * @param 	int $owner_id
     * @return 	int
     */
    function countAllUsersAdoption($owner_id) {
        $sql = "SELECT COUNT(*) AS total

                FROM users u INNER JOIN user_payments up ON u.`id` = up.user_id
                    INNER JOIN owner_recruits owr ON owr.id = up.owner_recruit_id
                    INNER JOIN owners ow ON ow.id = owr.owner_id
                    INNER JOIN user_recruits ur ON u.id = ur.user_id
                WHERE u.display_flag = 1  AND u.`user_status` = 1 AND up.user_payment_status = 6 AND ow.id = ?";

        $query = $this->db->query($sql, array($owner_id));
        $row = $query->row_array();
        return $row['total'];
    }

    /**
     * @author  [IVS] Lam Tu My Kieu
     * @name 	getAllUsersScout
     * @todo 	get all users for scout
     * @param 	int $owner_id,$args, $page = 1, $posts_per_page = 10
     * @return 	data
     */
    function getAllUsersScout($owner_id,$args, $page = 1, $posts_per_page = 10, $scout_start_date=null, $scout_end_date=null, $sort = null,$unique_id=null) {
        $params = array($owner_id);
        $custom = "";
        $page = ($page - 1) * $posts_per_page;

        $sql = "SELECT u.id,ow.id owner_id, u.profile_pic, owr.id AS owner_recruit_id, u.unique_id, u.name AS username, mc.name AS cityname, ma.name1, ma.name2, up.`apply_date`,MAX(lu.`updated_date`) updated_date,MAX(lu.`created_date`) created_date, up.`user_payment_status`,u.user_from_site,
                       IF ( lu.is_read = 1, MAX(lu.scout_mail_open_date), '未' ) as mail_open_date

                FROM users u INNER JOIN list_user_messages lu ON u.`id` = lu.`user_id`
                INNER JOIN mst_templates temp ON temp.`id` = lu.`template_id`
                    INNER JOIN owner_recruits owr ON owr.id = lu.owner_recruit_id
                    INNER JOIN owners ow ON ow.id = owr.owner_id
                    INNER JOIN user_recruits ur ON u.id = ur.user_id
                    LEFT JOIN mst_ages ma ON ma.id = ur.age_id
                    LEFT JOIN mst_cities mc ON mc.id= ur.city_id
                    LEFT JOIN user_payments up ON up.`user_id` = lu.`user_id` AND up.`owner_recruit_id`= lu.`owner_recruit_id`
                WHERE
                ow.id = ?
                AND u.display_flag = 1
                AND u.`user_status` = 1 AND ow.`display_flag`=1
                AND (temp.`template_type`='us03' or temp.`template_type` = 'us14') AND lu.payment_message_status = 1 ";
        if ( $scout_start_date || $scout_end_date){//} && strtotime($scout_start_date) <= strtotime($scout_end_date)){
            $scout_start_date = date("Y-m-d 00:00:01", strtotime($scout_start_date));
            if ( $scout_end_date ){
                $scout_end_date   = date("Y-m-d 23:59:59", strtotime($scout_end_date));
            }else{
                $scout_end_date   = date("Y-m-d H:i:s");
            }
            $sql .= " AND (lu.created_date >= ? AND lu.created_date <= ?) ";
            $params[] = $scout_start_date;
            $params[] = $scout_end_date;
        }
        if($unique_id){
            $sql .= " AND u.unique_id LIKE ?  ";
            $params[] = "%$unique_id%";
        }
        $sql .="GROUP BY u.id ";
        if($sort != null && $sort != '') {
          $sql .="ORDER BY $sort DESC LIMIT ?,?";
        } else {
          $sql .="ORDER BY created_date DESC LIMIT ?,?";
        }

        $params[] = $page;
        $params[] = intval($posts_per_page);
        $query = $this->db->query($sql, $params);
        return $query->result_array();
    }

    /**
     * @author  [IVS] Lam Tu My Kieu
     * @name 	countAllUsersScout
     * @todo 	count all users for scout
     * @param 	int $user_id
     * @return 	void
     */
    function countAllUsersScout($owner_id, $scout_start_date=null, $scout_end_date=null,$unique_id=null) {
        $sql = "SELECT COUNT(DISTINCT u.id) AS total
                FROM users u INNER JOIN list_user_messages lu ON u.`id` = lu.`user_id`
                INNER JOIN mst_templates temp ON temp.`id` = lu.`template_id`
                    INNER JOIN owner_recruits owr ON owr.id = lu.owner_recruit_id
                    INNER JOIN owners ow ON ow.id = owr.owner_id
                    INNER JOIN user_recruits ur ON u.id = ur.user_id

                WHERE u.display_flag = 1 AND u.`user_status` = 1 AND ow.`display_flag`=1
                AND (temp.`template_type`='us03' or temp.`template_type` = 'us14')
                AND lu.payment_message_status = 1 AND ow.id = ?";
        $params = array($owner_id);
        if ( $scout_start_date || $scout_end_date ){//&& strtotime($scout_start_date) <= strtotime($scout_end_date) ){
            $scout_start_date = date("Y-m-d 00:00:01", strtotime($scout_start_date));
            if ( $scout_end_date ){
                $scout_end_date   = date("Y-m-d 23:59:59", strtotime($scout_end_date));
            }else{
                $scout_end_date   = date("Y-m-d H:i:s");
            }
            $sql .= " AND (lu.created_date >= ? AND lu.created_date <= ?) ";
            $params[] = $scout_start_date;
            $params[] = $scout_end_date;
        }
        if ($unique_id) {
            $sql .= " AND u.unique_id LIKE ?";
            $params[] = "%$unique_id%";
        }
        $query = $this->db->query($sql, $params);
        $row = $query->row_array();
        return $row['total'];
    }
    /**
     * @author  VJS
     * @name    getNumberOfMailOpened
     * @todo    count number of scout mail opened
     * @param   int $user_id
     * @return  void
     */
    function getNumberOfMailOpened($owner_id, $scout_start_date=null, $scout_end_date=null,$unique_id=null){
        $sql = "SELECT COUNT(DISTINCT u.id) AS total
                FROM users u INNER JOIN list_user_messages lu ON u.`id` = lu.`user_id`
                INNER JOIN mst_templates temp ON temp.`id` = lu.`template_id`
                    INNER JOIN owner_recruits owr ON owr.id = lu.owner_recruit_id
                    INNER JOIN owners ow ON ow.id = owr.owner_id
                    INNER JOIN user_recruits ur ON u.id = ur.user_id
                WHERE u.display_flag = 1 AND u.`user_status` = 1 AND ow.`display_flag`=1
                AND (temp.`template_type`='us03' or temp.`template_type` = 'us14')
                AND lu.payment_message_status = 1 AND ow.id = ?
                AND lu.is_read = 1 ";
        $params = array($owner_id);
        if ( $scout_start_date || $scout_end_date ){//&& strtotime($scout_start_date) <= strtotime($scout_end_date) ){
            $scout_start_date = date("Y/m/d 00:00:01", strtotime($scout_start_date));
            if ( $scout_end_date ){
                $scout_end_date   = date("Y-m-d 23:59:59", strtotime($scout_end_date));
            }else{
                $scout_end_date   = date("Y-m-d H:i:s");
            }
            $sql .= " AND (lu.created_date >= ? AND lu.created_date <= ?) ";
            $params[] = $scout_start_date;
            $params[] = $scout_end_date;
        }
        if($unique_id){
          $sql .= " AND u.unique_id LIKE ?";
          $params[] = "%$unique_id%";
        }
        $query = $this->db->query($sql, $params);
        $ret = 0;
        if ($query){
            $row = $query->row_array();
            if ( $row && $row['total'] ){
                $ret = $row['total'];
            }
        }
        return $ret;
    }

    /**
     * @author  [IVS] Lam Tu My Kieu
     * @name 	getUserForScoutAgain
     * @todo 	get user for scout again
     * @param 	int $owner_id, $user_id
     * @return 	data
     */
    function getUserForScoutAgain($owner_id, $user_id) {
        $sql = "SELECT u.id, u.unique_id, u.user_from_site, u.profile_pic,u.bust,u.waist,u.hip,u.name AS username, mc.name AS cityname, ma.name1, ma.name2, mth.name1 AS height_l, mth.name2 AS height_h
                FROM users u INNER JOIN list_user_messages lu ON u.`id` = lu.`user_id`
                INNER JOIN mst_templates temp ON temp.`id` = lu.`template_id`
                LEFT JOIN user_payments up ON up.`user_id` = lu.`user_id`
                    INNER JOIN owner_recruits owr ON owr.id = lu.owner_recruit_id
                    INNER JOIN owners ow ON ow.id = owr.owner_id
                    INNER JOIN user_recruits ur ON u.id = ur.user_id
                    LEFT JOIN mst_ages ma ON ma.id = ur.age_id
                    LEFT JOIN mst_cities mc ON mc.id= ur.city_id
                    LEFT JOIN mst_height mth ON ur.height_id = mth.id
                WHERE u.display_flag = 1 AND u.`user_status` = 1 AND ow.`display_flag`=1
                AND (temp.`template_type` = 'us03' or temp.`template_type` = 'us14')
                AND ow.id = ? AND u.`id` LIKE ?
                GROUP BY u.`id`";

        $query = $this->db->query($sql, array($owner_id, $user_id));
        return $query->result_array();
    }

    /**
     * @author  [IVS] Nguyen Bao Trieu
     * @name 	getApplyMoney
     * @todo 	get data user apply money
     * @param 	int $ownerId
     * @return 	data
     */
    public function getApplyMoney($ownerId)
    {
        $sql = "SELECT owr.id as owner_recruit_id,u.profile_pic,u.user_from_site, u.id, u.unique_id, u.name AS username,
                       mc.name AS cityname, ma.name1, ma.name2,
                       up.apply_date, up.request_money_date
                FROM users u
                    INNER JOIN user_payments up ON u.`id` = up.user_id
                    INNER JOIN owner_recruits owr ON owr.id = up.owner_recruit_id
                    INNER JOIN owners ow ON ow.id = owr.owner_id
                    INNER JOIN user_recruits ur ON u.id = ur.user_id
                    LEFT JOIN mst_ages ma ON ma.id = ur.age_id
                    LEFT JOIN mst_cities mc ON mc.id= ur.city_id
                WHERE u.display_flag = 1 AND u.`user_status` = 1  AND up.user_payment_status = 5 AND ow.id = ?
                GROUP BY u.id
                ORDER BY up.request_money_date DESC
                LIMIT 0,5";
        $query = $this->db->query($sql,  array($ownerId));
        return $query->result_array();
    }

   /**
     * @author  [IVS] Nguyen Bao Trieu
     * @name 	getUserApply
     * @todo 	get data user apply
     * @param 	int $ownerId
     * @return 	data
     */
    public function getUserApply($ownerId)
    {
        $sql = "SELECT u.id, u.user_from_site, u.unique_id,u.profile_pic, u.name AS username, mc.name AS cityname, ma.name1, ma.name2,
   hp.`joyspe_happy_money`, up.apply_date, up.reply_date,up.interview_date, up.user_payment_status

                FROM users u INNER JOIN user_payments up ON u.id = up.user_id
                    INNER JOIN owner_recruits owr ON owr.id = up.owner_recruit_id
                    INNER JOIN owners ow ON ow.id = owr.owner_id
                    INNER JOIN user_recruits ur ON u.id = ur.user_id
                    LEFT JOIN mst_ages ma ON ma.id = ur.age_id
                    LEFT JOIN mst_cities mc ON mc.id= ur.city_id
                    INNER JOIN mst_happy_moneys hp ON owr.happy_money_id = hp.id

                 WHERE u.display_flag = 1  AND u.`user_status` = 1 AND up.is_hide = 1 AND ow.id = ?
                 GROUP BY u.`id`
                 ORDER BY up.apply_date DESC
                 LIMIT 0,5 ";
        $query = $this->db->query($sql,  array($ownerId, $ownerId));
        return $query->result_array();
    }

    /**
    * @author  [VJS]
    * @name 	getUserTrvlExpRequest
    * @todo 	get list of travel expense list(交通費申請リストを取得する)
    * @param 	owner id
    * @return 	data
    */
    public function getUserTrvlExpRequest($owner_id) {
        $ret = null; //

        if ( !$owner_id ) {
            return $ret;
        }

        $sql  = "SELECT ";
        $sql .= "tl.id, tl.status, tl.requested_date, tl.interview_date, us.unique_id, us.user_from_site, us.profile_pic, tl.user_id,";
        $sql .= "ifnull(us.bust, 0) bust, ifnull(us.waist, 0) waist, ifnull(us.hip, 0) hip,";
        $sql .= "ma.name1 AS ageName1, ma.name2 AS ageName2,";
        $sql .= "mth.name1 AS height_l, mth.name2 AS height_h ";
        $sql .= "FROM travel_expense_list tl ";
        $sql .= "LEFT JOIN users us ON tl.user_id = us.id ";
        $sql .= "LEFT JOIN user_recruits usr ON us.id = usr.user_id ";
        $sql .= "LEFT JOIN mst_ages ma ON usr.age_id = ma.id ";
        $sql .= "LEFT JOIN mst_height mth ON usr.height_id = mth.id ";
        $sql .= "LEFT JOIN owners ow ON tl.owner_id = ow.id ";
        $sql .= "WHERE tl.display_flag = 1 AND us.display_flag = 1 ";
        $sql .= "AND ow.id = ? AND ow.display_flag = 1 AND tl.status = 0 ";
        $sql .= "ORDER BY tl.id DESC";

        $query = $this->db->query($sql, $owner_id);

        if ( $query ) {
            $ret = $query->result_array();
        }

        return $ret;
    }

     /**
     * @author  [IVS] Nguyen Bao Trieu
     * @name 	getNewUser
     * @todo 	get new user
     * @param 	null
     * @return 	data
     */
    public function getNewUser($owner_id, $sort_type, $owner_hidden_users)
    {
        return $this->searchUsers($owner_id, $sort_type, $owner_hidden_users);
    }

    public function getListOfHideUsers($owner_id, $owner_hidden_users) {
        $ret_user_info = array();
        foreach ($owner_hidden_users as $hidden_user) {
            $hidden_user_id = $hidden_user['user_id'];
            $params = array();
            $sql = "SELECT DISTINCT u.id, u.user_from_site, u.unique_id, u.profile_pic, u.bust,u.waist, u.hip, ";
            $sql .= "mc.name AS cityName, ma.name1 AS ageName1, ma.name2 AS ageName2, mth.name1 AS height_l, mth.name2 AS height_h, ";
            $sql .= "u.last_visit_date, u.offcial_reg_date, tmp.is_read, ";
            $sql .= "IF(DATE_ADD(IFNULL(u.accept_remote_scout_datetime, u.offcial_reg_date), INTERVAL 2 DAY) >= NOW(), 1, 0) as new_flg, ";
            $sql .= "CASE WHEN stat1.received_no IS NULL OR stat1.received_no = '' THEN 0 ELSE stat1.received_no END AS received_no, ";
            $sql .= "CASE WHEN stat1.openned_no IS NULL OR stat1.openned_no = '' THEN 0 ELSE stat1.openned_no END AS openned_no, ";
            $sql .= "CASE WHEN stat2.reply_no IS NULL OR stat2.reply_no = '' THEN 0 ELSE stat2.reply_no END AS reply_no, ";
            $sql .= "CASE WHEN stat2.hp_no IS NULL OR stat2.hp_no = '' THEN 0 ELSE stat2.hp_no END AS hp_no, ";
            $sql .= "tmp.created_date as sm_created_date ";

            $sql .= "FROM  users u ";

            $sql .= "INNER JOIN user_recruits ur ON u.id = ur.user_id ";
            $sql .= "LEFT JOIN mst_cities mc ON ur.city_id = mc.id ";
            $sql .= "LEFT JOIN mst_ages ma ON ma.id = ur.age_id ";
            $sql .= "LEFT JOIN mst_height mth ON ur.height_id = mth.id ";
            $sql .= "LEFT JOIN ";
            $sql .= "    (SELECT COUNT(lum.id) AS received_no, SUM(CASE WHEN is_read = 1 THEN 1 ELSE 0 END) AS openned_no ";
            $sql .= "    FROM  list_user_messages lum WHERE user_id = ? GROUP BY user_id) AS stat1 ON 1=1 ";
            $params[] = $hidden_user_id;
            $sql .= "LEFT JOIN ";
            $sql .= "    (SELECT (mail_click + tel_click + line_click + question_no) AS reply_no, (hp_click + kuchikomi_click) AS hp_no ";
            $sql .= "    FROM user_statistics WHERE user_id = ? ) AS stat2 ON 1 = 1 ";
            $params[] = $hidden_user_id;
            $sql .= "LEFT JOIN ";
            $sql .= "    (SELECT lum.owner_recruit_id, lum.user_id,lum.created_date, lum.is_read ";
            $sql .= "    FROM  owners ow INNER JOIN owner_recruits owr ON ow.id = owr.owner_id ";
            $sql .= "    INNER JOIN list_user_messages lum ON  owr.id = lum.owner_recruit_id ";
            $sql .= "    INNER JOIN  mst_templates mt ON mt.id = lum.template_id ";
            $sql .= "    WHERE ow.id = ? AND (mt.template_type = 'us03' or mt.template_type = 'us14') ";
            $params[] = $owner_id;
            $sql .= "    and lum.user_id = ? ORDER BY lum.id DESC LIMIT 1) tmp ON 1=1 ";
            $params[] = $hidden_user_id;
            $sql .= "WHERE u.user_status = 1 AND u.display_flag = 1 AND u.id = ? ";
            $params[] = $hidden_user_id;

            $query = $this->db->query($sql, $params);
            if ($query) {
                $user_addition_infor = $query->result_array();
                if ($user_addition_infor && is_array($user_addition_infor)) {
                    $ret_user_info[] = $user_addition_infor[0];
                }
            }
        }
    	return $ret_user_info;
    }

    public function checkIfUserHasMessageToOwner($owner_id, $user_id) {
    	$ret = false;
    	$sql = "SELECT id FROM list_user_owner_messages
                WHERE user_id = '$user_id'
                AND owner_id = '$owner_id'
                AND display_flag = 1";
    	$query = $this->db->query($sql);
    	if ($query && $query->num_rows() > 0)
    		$ret = true;
    	return $ret;
    }

     /**
     * @author  [IVS] Nguyen Bao Trieu
     * @name    getScoutMailStat
     * @todo    get user statistics infor
     * @param   user id
     * @return  data
     */
    public function getScoutMailStat($user_id){
        $ret_stat_data = array(); //戻り値
        if ( !$user_id ){
            return $ret_stat_data;
        }

        // メール受信数、開封数取得
        $sql = "SELECT user_id, count(id) as received_no, SUM(case when is_read = 1 then 1 else 0 end) as openned_no
                FROM  `list_user_messages`
                WHERE user_id in (?)
                GROUP BY user_id";
        $query = $this->db->query($sql, $user_id);
        $stat_data1 = array();
        if ( $query ){
            $stat_data1 = $query->result_array();
        }

        // HPクリック数、クチコミクリック数取得
        $sql = "SELECT user_id, (mail_click + tel_click + line_click + question_no) as reply_no, (hp_click + kuchikomi_click) as hp_no
                FROM `user_statistics`
                WHERE user_id in (?) ";
        $query = $this->db->query($sql, $user_id);
        $stat_data2 = array();
        if ( $query ){
            $stat_data2 = $query->result_array();
        }
        $ret_stat_data = array( 'received_no' => 0,
                                'openned_no'  => 0,
                                'reply_no'    => 0,
                                'hp_no'       => 0 );

        if ( $stat_data1 && $stat_data1[0]['user_id'] == $user_id ){
            $ret_stat_data['received_no'] = $stat_data1[0]['received_no']; // スカウトメール受信数
            $ret_stat_data['openned_no']  = $stat_data1[0]['openned_no'];  // 開封数
        }
        if ( $stat_data2 && $stat_data2[0]['user_id'] == $user_id){
            $ret_stat_data['reply_no']    = $stat_data2[0]['reply_no'];  // 開封数
            $ret_stat_data['hp_no']       = $stat_data2[0]['hp_no'];  // 開封数
        }

        return $ret_stat_data;
    }
    /**
     * @author  VJS
     * @name    getTotalUserNo
     * @todo    get total number of users
     * @param   null
     * @return  total number of users
     */
    public function getTotalUserNo(){
        $ret = 0; //ユーザー総数
        $sql = "SELECT count(*) AS user_total_no
                FROM users WHERE display_flag = '1' ";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0)
        {
            $row = $query->row();
            if ( $row ){
                $ret = $row->user_total_no;
            }
        }
        return $ret;
    }
    /**
     * @author  VJS
     * @name    getLstWeekNewUserNo
     * @todo    get number of new users in the last seven days
     * @param   null
     * @return  number of new users in the last seven days
     */
    public function getLstWeekNewUserNo(){
        $ret = 0; //ユーザー総数
        $sql = "SELECT count(*) AS user_total_no
                FROM users
                WHERE display_flag = '1'
                AND created_date >= ADDDATE(CURDATE(),-7)";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0)
        {
            $row = $query->row();
            if ( $row ){
                $ret = $row->user_total_no;
            }
        }
        return $ret;
    }

    public function countRegisteredUser($date) {
        $sql = "SELECT id FROM users
                WHERE DATE_FORMAT(offcial_reg_date,  '%Y%m%d' ) = ?";
        return $this->db->query($sql, array($date))->num_rows();
    }
  
    public function getLatestUserAccessLog($owner_id) {
        $sql = "SELECT sol.owner_id,sol.user_id,sol.visited_date,u.unique_id 
                FROM scout_owner_log sol
                LEFT JOIN users u ON sol.user_id = u.id 
                WHERE sol.owner_id = ?  
                ORDER BY sol.visited_date DESC LIMIT 5";
        $query = $this->db->query($sql,array($owner_id));
        return $query->result_array();
    }
  
    public function countAccessLog($owner_id) {
        $cnt = 0;
        $sql ="SELECT COUNT(id) as count_access from scout_owner_log WHERE owner_id = ? ";
        $query = $this->db->query($sql,array($owner_id));
        if ($query && $ret =  $query->result_array()) {
               $cnt = $ret[0]['count_access'];
        }
        return $cnt;
    }

    public function inser_faq_messages($msg_id, $flag_msg = false, $data = array()){
        if ($flag_msg) {
            $sql = "SELECT msg_owner.owner_id, msg_owner.content msg_owner_content, msg_user.content msg_user_content 
                    FROM list_user_owner_messages AS msg_owner
                    LEFT JOIN list_user_owner_messages AS msg_user ON msg_owner.reply_id = msg_user.id
                    WHERE msg_owner.id = ? ";
            $query = $this->db->query($sql, array($msg_id));
            $msg = $query->row_array();

            $data = array('owner_id'         => $msg['owner_id'],
                          'question' => $msg['msg_owner_content'],
                          'answer'   => $msg['msg_user_content'],
                          'created_date'     => date('Y-m-d H:i:s')
                         );
            $this->db->insert('owner_faq', $data);
            return ($this->db->affected_rows() != 1) ? false : true;
        } else { 
            $this->db->insert('owner_faq', $data);
            return ($this->db->affected_rows() != 1) ? false : true;
        }

    }
}

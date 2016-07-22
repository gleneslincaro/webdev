<?php

class Mscout extends CommonQuery {

    function __construct() {
        parent::__construct();
    }

    /**
     * @author  [IVS] Phan Ngoc Minh Luan
     * @name 	getSmallUserProfiles
     * @todo 	get a few User Profiles
     * @param 	int $user_id
     * @return 	array
     */
    public function getSmallUserProfiles($user_id) {
        $this->db->select('user_recruits.user_id uid, unique_id, mst_cities.name as city_name, mst_ages.name as age_name');
        $this->db->from('user_recruits');
        $this->db->join('users', 'users.id = user_recruits.user_id');
        $this->db->join('mst_ages', 'mst_ages.id = user_recruits.age_id', 'left');
        $this->db->join('mst_cities', 'mst_cities.id = user_recruits.city_id', 'left');
        $param = array(
            'user_recruits.user_id' => $user_id,
            'user_recruits.display_flag' => 1
        );
        $this->db->where($param);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return 0;
    }

    /**
     * @author  [IVS] Nguyen Hong Duc
     * @name 	getHourlySalary
     * @todo 	getHourlySalary
     * @param 	null
     * @return null
     */
    public function getHourlySalary() {
        $sql = "select * from mst_hourly_salaries where display_flag=1";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    /**
     * @author  [IVS] Nguyen Hong Duc
     * @name 	getMonthlySalary
     * @todo 	getMonthlySalary
     * @param 	null
     * @return null
     */
    public function getMonthlySalary() {
        $sql = "select * from mst_monthly_salaries where display_flag=1";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    /**
     * @author  [IVS] Nguyen Hong Duc
     * @name 	getHopeTimeWorking
     * @todo 	getHopeTimeWorking
     * @param 	null
     * @return null
     */
    public function getHopeTimeWorking() {
        $sql = "select * from mst_hope_time_working where display_flag=1";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    /**
     * @author  [IVS] Nguyen Hong Duc
     * @name 	getHopeDayWorking
     * @todo 	getHopeDayWorking
     * @param 	null
     * @return null
     */
    public function getHopeDayWorking() {
        $sql = "select * from mst_hope_day_working where display_flag=1";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    /**
     * @author  [IVS] Nguyen Hong Duc
     * @name 	getAge
     * @todo 	getAge
     * @param 	null
     * @return null
     */
    public function getAge() {
        $sql = "select * from mst_ages where display_flag=1";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    /**
     * @author  [IVS] Nguyen Hong Duc
     * @name 	getJobType
     * @todo 	getJobType
     * @param 	null
     * @return null
     */
    public function getJobType() {
        $sql = "select * from mst_job_types where display_flag=1";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    /**
     * @author  [IVS] Nguyen Hong Duc
     * @name 	getHourlySalaryAmount
     * @todo 	getHourlySalaryAmount
     * @param 	null
     * @return null
     */
    public function getHourlySalaryAmount($id) {
        $sql = "select * from mst_hourly_salaries where display_flag=1 and id= ?";
        $query = $this->db->query($sql, array($id));
        $row = $query->row_array();
        return $row['amount'];
    }

    /**
     * @author  [IVS] Nguyen Hong Duc
     * @name 	getMonthlySalaryAmount
     * @todo 	getMonthlySalaryAmount
     * @param 	null
     * @return null
     */
    public function getMonthlySalaryAmount($id) {
        $sql = "select * from mst_monthly_salaries where display_flag=1 and id= ?";
        $query = $this->db->query($sql, array($id));
        $row = $query->row_array();
        return $row['amount'];
    }

    /**
     * @author  [IVS] Nguyen Hong Duc
     * @name 	getAge1
     * @todo 	getAge1
     * @param 	null
     * @return null
     */
    public function getAge1($id) {
        $sql = "select * from mst_ages where display_flag=1 and id= ?";
        $query = $this->db->query($sql, array($id));
        $row = $query->row_array();
        return $row['name1'];
    }

    /**
     * @author  [IVS] Nguyen Hong Duc
     * @name 	getAge2
     * @todo 	getAge2
     * @param 	null
     * @return null
     */
    public function getAge2($id) {
        $sql = "select * from mst_ages where display_flag=1 and id= ?";
        $query = $this->db->query($sql, array($id));
        $row = $query->row_array();
        return $row['name2'];
    }

    /**
     * @author  [IVS] Nguyen Hong Duc
     * @name 	getHopeDayWorkingValue1
     * @todo 	getHopeDayWorkingValue1
     * @param 	null
     * @return null
     */
    public function getHopeDayWorkingValue1($id) {
        $sql = "select * from mst_hope_day_working where display_flag=1 and id= ?";
        $query = $this->db->query($sql, array($id));
        $row = $query->row_array();
        return $row['name1'];
    }

    /**
     * @author  [IVS] Nguyen Hong Duc
     * @name 	getHopeDayWorkingValue2
     * @todo 	getHopeDayWorkingValue2
     * @param 	null
     * @return null
     */
    public function getHopeDayWorkingValue2($id) {
        $sql = "select * from mst_hope_day_working where display_flag=1 and id= ?";
        $query = $this->db->query($sql, array($id));
        $row = $query->row_array();
        return $row['name2'];
    }

    /**
     * @author  [IVS] Nguyen Hong Duc
     * @name 	getHopeTimeWorkingValue1
     * @todo 	getHopeTimeWorkingValue1
     * @param 	null
     * @return null
     */
    public function getHopeTimeWorkingValue1($id) {
        $sql = "select * from mst_hope_time_working where display_flag=1 and id= ?";
        $query = $this->db->query($sql, array($id));
        $row = $query->row_array();
        return $row['name1'];
    }

    /**
     * @author  [IVS] Nguyen Hong Duc
     * @name 	getHopeTimeWorkingValue2
     * @todo 	getHopeTimeWorkingValue2
     * @param 	null
     * @return null
     */
    public function getHopeTimeWorkingValue2($id) {
        $sql = "select * from mst_hope_time_working where display_flag=1 and id= ?";
        $query = $this->db->query($sql, array($id));
        $row = $query->row_array();
        return $row['name2'];
    }

    /**
     * @author  [IVS] Nguyen Hong Duc
     * @name 	getGroupCity
     * @todo 	getGroupCity
     * @param 	null
     * @return null
     */
    public function getGroupCity() {
        $sql = "SELECT * FROM `mst_city_groups` mcg WHERE mcg.`display_flag` = 1";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    /**
     * @author  [IVS] Nguyen Hong Duc
     * @name 	getCity
     * @todo 	getCity
     * @param 	null
     * @return null
     */
    public function getCity() {
        $sql = "SELECT * FROM `mst_cities` mc WHERE mc.`display_flag` = 1";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    /**
     * @author  [IVS] Nguyen Hong Duc
     * @name 	dataSearch
     * @todo 	search with condition
     * @param 	null
     * @return null
     */
    public function dataSearch($checksub, $page = 1, $posts_per_page = 1, $owner_id, $sort_type, $owner_hidden_users, $unique_id = "") {
        return $this->searchUsers($owner_id, $sort_type, $owner_hidden_users, $checksub, $page, $posts_per_page, $unique_id);
    }

    public function getListOfHideUsers($checksub, $owner_id, $owner_hidden_users) {
    	if ($owner_hidden_users && is_array($owner_hidden_users)){
    		$owner_hidden_users_list = array();
    		foreach ($owner_hidden_users as $key => $value) {
    			$owner_hidden_users_list[]  = $value['user_id'];
    		}
    		$owner_hidden_users_str = join("','",$owner_hidden_users_list);
    	}
    	$sqlchecksub = "";
    	if ( !$owner_id ){
    		return null;
    	}
    	// CHECK CITY
    	if ($checksub != "") {
    		$sqlchecksub = " AND mc.id IN (" . $this->db->escape_str($checksub) . ")";
    	}

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
            $sql .= $sqlchecksub;

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

    /**
     * @author  [IVS] Nguyen Hong Duc
     * @name 	countData
     * @todo 	countData
     * @param 	null
     * @return null
     */
    public function countData($checksub, $owid, $owner_hidden_users, $unique_id = "",$sort_type = "") {
    	if ($owner_hidden_users && is_array($owner_hidden_users)){
    		$owner_hidden_users_list = array();
    		foreach ($owner_hidden_users as $key => $value) {
    			$owner_hidden_users_list[]  = $value['user_id'];
    		}
    		$owner_hidden_users_str = join("','",$owner_hidden_users_list);
    	}


        $sqlchecksub = "";
        $strCount = "";
        $ownerid = $owid;
        if ( !$owid ){
            return 0;
        }
        // CHECK CITY
        if ($checksub != "") {
            $sqlchecksub = " AND mct.`id` IN (" . $this->db->escape_str($checksub) . ")";
        }

        $sql = "SELECT DISTINCT us.id as total ";
        if ($sort_type == 'open_rate') {
        $sql .="FROM user_sort_list usl
                INNER JOIN users us ON us.id = usl.user_id
                INNER JOIN user_recruits usr ON us.id = usr.user_id ";
        } else {
        $sql .= "FROM users us
                INNER JOIN user_recruits usr ON us.id = usr.user_id ";
        }
        $sql .="LEFT JOIN mst_cities mct ON usr.city_id = mct.id
                LEFT JOIN mst_ages mage ON usr.age_id = mage.id
                LEFT JOIN mst_height mth ON usr.height_id = mth.id
                WHERE us.user_status = 1 ";
                if ($unique_id != '') {
                    $sql .="AND us.unique_id = ? ";
                    $params[] = $unique_id;
                }
        $sql .="AND us.id NOT IN
                (SELECT lum.user_id
                FROM list_user_messages lum
                INNER JOIN users us1
                ON lum.user_id = us1.id
                LEFT JOIN owner_recruits owr1
                ON lum.owner_recruit_id = owr1.id
                LEFT JOIN owners ow1
                ON owr1.owner_id = ow1.id
                INNER JOIN mst_templates mt ON mt.id = lum.template_id
                WHERE ow1.id = ? AND lum.is_read = 0 AND us1.last_visit_date < lum.created_date
                AND (mt.template_type = 'us03' OR mt.template_type = 'us14'))
                AND us.id NOT IN (SELECT sms.user_id
                FROM scout_message_spams sms
                LEFT JOIN users us1
                ON sms.user_id = us1.id
                LEFT JOIN owners ow1
                ON sms.owner_id = ow1.id WHERE sms.display_flag = 1
                AND sms.owner_id = ? )
                AND usr.display_flag = 1 ";
                $params[] = $owid;
                $params[] = $owid;

        $params[] = $this->db->escape($ownerid);
	    if(count($owner_hidden_users) > 0 )
	    	$sql = $sql." AND us.`id` NOT IN ('$owner_hidden_users_str')";
	    $sql .= $sqlchecksub;
	    $sql .= " ORDER BY IFNULL(us.last_visit_date, us.offcial_reg_date) DESC";
        $query = $this->db->query($sql, $params);
        return $query->num_rows();
    }
}
<?php

class Mowner extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    /**
     * author: [IVS] Nguyen Bao Trieu
     * name : insertOwner
     * todo : add owner into database
     * @param array $owner
     * @return new id
     */
    public function insertOwner($owner) {
        $this->db->insert('owners', $owner);
        return $this->db->insert_id();
    }

    public function insertOwnerHiddenUser($data) {
    	$this->db->insert('owner_hidden_users', $data);
    	return $this->db->insert_id();
    }


    /**
     * author: Jeffrey G. Sabellon
     * name : updateOwner
     * todo : update Owner
     * @param array $data, int $id
     * @return null
     */
    public function updateOwner($data, $id) {
      $this->db->where('id', $id);
      $this->db->update('owners', $data);
    }

    public function updateListUserOwnerMessage($data, $id) {
    	$this->db->where('id', $id);
    	$this->db->update('list_user_owner_messages', $data);
    }

		public function updateOwnerRecruits($data, $id) {
      $this->db->where('id', $id);
      $this->db->update('owner_recruits', $data);
    }


     /**
     * author: [IVS] Nguyen Bao Trieu
     * name : updateLavisitDate
     * todo : update Lavisit Date
     * @param int $ownerId
     * @return null
     */
    public function updateLavisitDate($ownerId)
    {
        $this->db->where('id', $ownerId);
        $this->db->update('owners',array('last_visit_date' => date('Y-m-d H:i:s')));

    }

    /**
     * author: [IVS] Nguyen Bao Trieu
     * name : insertOwnerRecruit
     * todo : add owner_recruit into database
     * @param array $ownerRecruit
     * @return new id
     */
    public function insertOwnerRecruit($ownerRecruit) {
        $this->db->insert('owner_recruits', $ownerRecruit);
        return $this->db->insert_id();
    }

    /**
     * author: [IVS] Nguyen Bao Trieu
     * name : insertJopTypeOwner
     * todo : add jop type owner into database
     * @param array $data
     * @return new id
     */
    public function insertJopTypeOwner($data) {
        $this->db->insert('job_type_owners', $data);
        return $this->db->insert_id();
    }

    /**
     * author: [IVS] Nguyen Bao Trieu
     * name : insertTreatmentOwner
     * todo : add treatment owner into database
     * @param array $data
     * @return new id
     */
    public function insertTreatmentOwner($data) {
        $this->db->insert('treatments_owners', $data);
        return $this->db->insert_id();
    }

    /**
     * author: [IVS] Nguyen Bao Trieu
     * name : getOwner
     * todo : get owner
     * @param int $ownerId
     * @return data
     */
    public function getOwner($ownerId = null) {
        $sql = 'SELECT ow.*,owr.id AS owner_recruit_id FROM owners ow
                INNER JOIN owner_recruits owr ON owr.owner_id = ow.id
                WHERE ow.display_flag = 1 AND owr.display_flag = 1 AND  ow.id = ?';
        $query = $this->db->query($sql, $ownerId);
        return $query->row_array();
    }

    /**
     * author: [Vjsol] Kiyoshi Suzuki
     * name : getOwners
     * todo : get owners
     * @return data
     */
    public function getSendOwners() {
        $sql = 'SELECT * FROM owners WHERE display_flag = 1 AND (month_send_flag=1 OR ag_month_send_flag=1)';
        $query = $this->db->query($sql);
        return $query->result_array();
    }


    public function getOwnerHiddenUsers($owner_id) {
    	$sql = "SELECT user_id FROM owner_hidden_users WHERE owner_id = '$owner_id'";
    	$query = $this->db->query($sql);
    	return $query->result_array();
    }

    public function getListOfOwnerScoutPrText($ownerId = null) {
      $sql = 'SELECT * FROM owner_scout_pr_text WHERE active_flag = 1 and owner_id = ? LIMIT 5';
      $query = $this->db->query($sql, $ownerId);
      return $query->result_array();
    }

    public function getUserOwnerMessages($ownerId = null, $page, $ppp) {
    	$page = ($page - 1) * $ppp;
    	$sql = "SELECT luom.*, us.unique_id, us.profile_pic, mc.name AS city_name,
          ma.name1 AS age_name1, ma.name2 AS age_name2, us.user_from_site
    			FROM list_user_owner_messages luom
    			LEFT JOIN users us ON luom.user_id = us.id
          LEFT JOIN user_recruits usr ON us.id = usr.user_id
          LEFT JOIN mst_cities mc ON usr.city_id = mc.id
          LEFT JOIN mst_ages ma ON ma.id = usr.age_id
    			WHERE luom.display_flag = 1 and luom.owner_id = '$ownerId' and luom.msg_from_flag = 0
    			ORDER BY luom.id DESC
    			LIMIT ?, ?";
    	$query = $this->db->query($sql, array(intval($page), intval($ppp)));
    	return $query->result_array();
    }

    /**
     * author: [VJS]
     * name : getUsrOwrMessageHistory
     * todo : get messages exchanged between user and owner or none_member_user and owner
     * @param owner id, user id, nmu_id, current page, no of messages per page
     * @return message infor
     */
    public function getUsrOwrMessageHistory($owner_id, $user_id, $nmu_id, $page=1, $msg_per_page=1) {
        $ret = null;
        $params = array();
        // check parameters
        if (!$owner_id || (!$user_id && !$nmu_id)) {
            return $ret;
        }

        if ($page <1) {
            $page = 1;
        }
        $page = ($page - 1) * $msg_per_page;
        $sql = 'SELECT  *
                FROM    list_user_owner_messages
                WHERE   display_flag = 1 and owner_id = ?';
        $params[] = $owner_id;
        if ($user_id && $user_id != 0) {
            $sql .= " AND user_id = ?";
            $params[] = $user_id;
        } elseif ($nmu_id && $nmu_id != 0) {
            $sql .= " AND none_member_id = ?";
            $params[] = $nmu_id;
        }

        $sql .= ' ORDER BY id DESC LIMIT ?, ?';
        $params[] = $page;
        $params[] = $msg_per_page;
        $query = $this->db->query($sql, $params);
        if ($query && $query->result_array()) {
            $ret = $query->result_array();
        }
        return $ret;
    }
    /**
     * author: [VJS]
     * name : getUsrOwrMessageCnt
     * todo : get total number of messages exchanged between user and owner or none_member_user and owner
     * @param owner id, user id, nmu_id
     * @return total number of messages
     */
    public function getUsrOwrMessageCnt($owner_id, $user_id, $nmu_id){
        $ret = 0;
        $params = array();
        // check parameters
        if (!$owner_id || (!$user_id && !$nmu_id)) {
            return $ret;
        }
        $sql = 'SELECT  count(*) as msg_cnt
                FROM    list_user_owner_messages
                WHERE   display_flag = 1 and owner_id = ?';
        $params[] = $owner_id;
        if ($user_id && $user_id != 0) {
            $sql .= " AND user_id = ?";
            $params[] = $user_id;
        } elseif ($nmu_id && $nmu_id != 0) {
            $sql .= " AND none_member_id = ?";
            $params[] = $nmu_id;
        }

        $sql .= " ORDER BY id DESC";

        $query = $this->db->query($sql, $params);
        if ($query && $row = $query->row_array()) {
            $ret = $row['msg_cnt'];
        }
        return $ret;
    }

    public function countUserMessages($ownerId = nulll) {
    	$sql = "SELECT luom.id
    			FROM list_user_owner_messages luom
    			LEFT JOIN users us ON luom.user_id = us.id
    			WHERE luom.display_flag = 1 and luom.owner_id = '$ownerId' and luom.msg_from_flag = 0
    			ORDER BY luom.id DESC";
    	$query = $this->db->query($sql);
    	return $query->num_rows();
    }

    public function getUserMessage($msg_id = null) {
    	$sql = "SELECT luom.created_date, luom.`title`, luom.`content`, luom.user_id, us.user_from_site, us.unique_id, us.profile_pic,
    			us.bust, us.waist, us.hip, mc.name as cityName, ma.name1 AS ageName1, ma.name2 AS ageName2,
    			mth.name1 AS height_l, mth.name2 AS height_h, nmus.id AS none_member_id,
    			CASE WHEN stat1.received_no IS NULL OR stat1.received_no = '' THEN 0 ELSE stat1.received_no END AS received_no,
				CASE WHEN stat1.openned_no IS NULL OR stat1.openned_no = '' THEN 0 ELSE stat1.openned_no END AS openned_no,
                CASE WHEN stat2.reply_no IS NULL OR stat2.reply_no = '' THEN 0 ELSE stat2.reply_no END AS reply_no,
                CASE WHEN stat2.hp_no IS NULL OR stat2.hp_no = '' THEN 0 ELSE stat2.hp_no END AS hp_no
    			FROM list_user_owner_messages luom
                LEFT JOIN users us ON luom.user_id = us.id
    			LEFT JOIN none_member_users nmus ON luom.none_member_id =  nmus.id
    			LEFT JOIN user_recruits usrs ON us.id = usrs.user_id
    			LEFT JOIN mst_height mth ON usrs.height_id = mth.id
    			LEFT JOIN mst_ages ma ON ma.id = usrs.age_id
    			LEFT JOIN mst_cities mc ON usrs.city_id = mc.id
    			LEFT JOIN owners ow ON luom.owner_id = ow.id
    			LEFT JOIN (
    			    SELECT user_id, COUNT(id) AS received_no, SUM(CASE WHEN active_flag = 0 THEN 1 ELSE 0 END) AS openned_no
                    FROM  `list_user_messages` GROUP BY user_id
    			) AS stat1 ON luom.user_id = stat1.user_id
    			LEFT JOIN (SELECT user_id, (mail_click + tel_click + line_click + question_no) AS reply_no, (hp_click + kuchikomi_click) AS hp_no
                    FROM `user_statistics`
    			) AS stat2 ON luom.user_id = stat2.user_id
    			WHERE luom.display_flag = 1 and luom.id = ? and luom.display_flag = 1";
    	$query = $this->db->query($sql, $msg_id);
    	return $query->row_array();
    }

    public function getOwnerScoutPrText($active_flag = null, $ownerId = null, $id = null) {
        $sql = 'SELECT * FROM owner_scout_pr_text WHERE active_flag = ? and owner_id = ? and id = ?';
        $query = $this->db->query($sql, array($active_flag, $ownerId, $id));
        return $query->row_array();
    }

    public function getOwnerFirstScoutMail($ownerId = null) {
        $sql = 'SELECT id, pr_text, title, pr_title FROM owner_scout_pr_text WHERE active_flag = 1 and owner_id = ? ORDER BY id ASC ';
        $query = $this->db->query($sql, $ownerId);
        return $query->row_array();
    }

    public function getCommonEmailNoPerDay() {
      $sql = 'SELECT * FROM mst_scout_mail WHERE display_flag = 1';
      $query = $this->db->query($sql);
      $row = $query->row_array();
      return $row['common_email_no_per_day'];
    }

    public function getOwnerRecruitByowrId($owrId = null)
    {
        $sql = 'SELECT ors.*, ow.storename FROM owner_recruits AS ors
                LEFT JOIN owners AS ow ON ors.owner_id = ow.id
                WHERE ors.display_flag = 1 and ors.id = ? ';
        $query = $this->db->query($sql, $owrId);
        return $query->row_array();
    }

     /**
     * author: [IVS] Nguyen Bao Trieu
     * name : getOwnerRecruit
     * todo : get Owner Recruit
     * @param int $ownerId
     * @return data
     */
    public function getOwnerRecruit($ownerId = null)
    {
        $sql = 'SELECT ors.*, ow.storename FROM owner_recruits AS ors
                LEFT JOIN owners AS ow ON ors.owner_id = ow.id
                WHERE ors.display_flag = 1 and ors.owner_id = ? ';
        $query = $this->db->query($sql, $ownerId);
        return $query->row_array();
    }

    /**
     * @author  [IVS] Nguyen Bao Trieu
     * @name 	getVariableListValue
     * @todo 	get variable list value
     * @param 	int $group_id
     * @return 	data
     */
    public function getVariableListValue($group_id = null) {
        $sql = 'SELECT * FROM mst_variable_list WHERE display_flag = 1 and group_id = ?';
        $query = $this->db->query($sql, array($group_id));
        return $query->result_array();
    }

    /**
     * @author  [IVS] Nguyen Bao Trieu
     * @name 	getByEmail
     * @todo 	get by email
     * @param 	string email
     * @return 	data
     */
    public function getByEmail($email = null) {
        $sql = 'SELECT * FROM owners WHERE display_flag = 1 and email_address = ?';
        $query = $this->db->query($sql, array($email));
        return $query->row_array();
    }

    /**
     * @author  [IVS] Nguyen Bao Trieu
     * @name 	getCity
     * @todo 	get City
     * @param 	null
     * @return 	data
     */
    public function getCity() {
        $sql = 'SELECT id, name FROM mst_cities WHERE display_flag =1 ORDER BY id';
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    /**
     * @author  Jeffrey G. Sabellon
     * @name 	getGroups
     * @todo 	get list of Groups
     * @param 	null
     * @return 	data
     */
    public function getGroups() {
        $sql = 'SELECT id, name FROM mst_city_groups WHERE display_flag =1 ORDER BY id';
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    /**
     * @author  Jeffrey G. Sabellon
     * @name 	getGroupCities
     * @todo 	get list of Group Cities
     * @param 	null
     * @return 	data
     */
    public function getGroupCities($city_group_id = null) {
        $sql = 'SELECT id, name FROM mst_cities WHERE display_flag =1 AND city_group_id = ? ORDER BY id';
        $query = $this->db->query($sql, $city_group_id);
        return $query->result_array();
    }

    /**
     * @author  Jeffrey G. Sabellon
     * @name 	getCityTowns
     * @todo 	get list of City Towns
     * @param 	null
     * @return 	data
     */
    public function getCityTowns($city_id = null) {
        $sql = 'SELECT id, name FROM mst_towns WHERE display_flag =1 AND city_id = ? ORDER BY id';
        $query = $this->db->query($sql, $city_id);
        return $query->result_array();
    }

    /**
     * @author  [IVS] Nguyen Bao Trieu
     * @name 	getHourlySalary
     * @todo 	get Hourly Salary
     * @param 	null
     * @return 	data
     */
    public function getHourlySalary() {
        $sql = 'SELECT id, amount FROM mst_hourly_salaries WHERE display_flag =1 ORDER BY amount';
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    /**
     * @author  [IVS] Nguyen Bao Trieu
     * @name 	getMonthlySalary
     * @todo 	get Monthly Salary
     * @param 	null
     * @return 	data
     */
    public function getMonthlySalary() {
        $sql = 'SELECT id, amount FROM mst_monthly_salaries WHERE display_flag =1 ORDER BY amount';
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    /**
     * @author  [IVS] Nguyen Bao Trieu
     * @name 	getOwnerTreatment
     * @todo 	get Owner Treatment
     * @param 	null
     * @return 	data
     */
    public function getOwnerTreatment() {
        $sql = 'SELECT id, name, group_id FROM mst_treatments WHERE display_flag =1 ORDER BY priority';
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    /**
     * @author  [IVS] Nguyen Bao Trieu
     * @name 	getHappyMoney
     * @todo 	get Happy Money
     * @param 	null
     * @return 	data
     */
    public function getHappyMoney() {
        $sql = 'SELECT id, joyspe_happy_money, default_money
                FROM mst_happy_moneys
                WHERE display_flag = 1
                ORDER BY joyspe_happy_money ';
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    /**
     * @author  VJS
     * @name    getZeroHappyMoneyID
     * @todo    get zero happy money ID
     * @param   null
     * @return  ID
     */
    public function getZeroHappyMoneyID() {
        $ret = null;
        $sql = 'SELECT id
                FROM mst_happy_moneys
                WHERE display_flag = 1 and user_happy_money = 0 and joyspe_happy_money = 0
                ';
        $query = $this->db->query($sql);
        if ( $query && $row = $query->result_array()){
            $ret = $row['0']['id'];
        }
        return $ret;
    }
    /**
     * @author  [IVS] Nguyen Bao Trieu
     * @name 	getHappyMoneyPayUser
     * @todo 	get Happy Money Pay User
     * @param 	null
     * @return 	data
     */
    public function getHappyMoneyPayUser($id = null) {
        $sql = 'SELECT user_happy_money
                FROM mst_happy_moneys
                WHERE display_flag = 1  AND id= ?
                ORDER BY joyspe_happy_money ';
        $query = $this->db->query($sql, array($id));
        return $query->row_array();
    }

    /**
     * @author  [IVS] Nguyen Bao Trieu
     * @name 	getJobType
     * @todo 	get Job Type
     * @param 	null
     * @return 	data
     */
    public function getJobType() {
        $sql = 'SELECT id, name FROM mst_job_types WHERE display_flag = 1 ORDER BY priority';
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    /**
     * @author  [IVS] Nguyen Bao Trieu
     * @name 	getOwnerRecruitErr
     * @todo 	get Owner Recruit Error
     * @param 	null
     * @return 	data
     */
    public function getOwnerRecruitErr($loginId = null) {
        $sql = "SELECT owners.storename, owner_recruits.recruit_status, owner_recruits.created_date
                FROM owners, owner_recruits
                WHERE owners.id = owner_recruits.owner_id AND owners.display_flag = 1 AND owner_recruits.display_flag = 1
                AND(owners.owner_status = 1 OR owners.owner_status = 2) AND (owner_recruits.recruit_status = 1 OR owner_recruits.recruit_status = 3) AND owner_id = ?";

        $query = $this->db->query($sql, array($loginId));
        return $query->row_array();
    }

    // Phong
    public function getJobTypeOfOwnerRecruit($owner_recruit_id = null) {
        $sql = 'SELECT MJT.id, MJT.name
            FROM mst_job_types MJT INNER JOIN job_type_owners JTO ON MJT.id = JTO.job_type_id
                INNER JOIN owner_recruits ORC ON JTO.owner_recruit_id = ORC.id
            WHERE  JTO.owner_recruit_id  = ? AND ORC.display_flag = 1 AND MJT.display_flag = 1
            ORDER BY MJT.priority';
        $query = $this->db->query($sql, array($owner_recruit_id));
        return $query->result_array();
    }

    /**
     * @author  [IVS] Nguyen Bao Trieu
     * @name 	getOwnerNews
     * @todo 	get owner news
     * @param 	null
     * @return 	data
     */
    public function getOwnerNews() {
        $sql = "SELECT id, title, content,created_date
                FROM mst_news
                WHERE member_type = 1 AND display_flag =1
                ORDER BY id DESC
                LIMIT 0,5";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    /**
     * @author  [IVS] Nguyen Van Phong
     * @name 	getOwnerNotPayUserHappyMoney
     * @todo 	get Owner Not Pay User Happy Money
     * @param 	$owner_recruit_id,$args,$posts_per_page,$page,$posts_per_page
     * @return 	data
     */
    public function getOwnerNotPayUserHappyMoney($owner_recruit_id = 0, $args, $page = 1, $posts_per_page) {
        $sql = '
           SELECT
                US.id AS userid, US.`unique_id` AS user_unique_id, URS.id AS URCID, MC.name AS city_name, MA.name1 AS age1, MA.name2 AS age2, UP.`apply_date`, UP.`request_money_date`, UP.owner_recruit_id,
                    US.user_from_site, US.profile_pic
           FROM
                `owner_recruits` ORS
                INNER JOIN `user_payments` UP
                ON ORS.id= UP.`owner_recruit_id`
                INNER JOIN users US
                ON US.id= UP.`user_id`
                INNER JOIN owners OW
                ON OW.id= ORS.owner_id
                INNER JOIN `user_recruits` URS
                ON URS.user_id= US.id
                LEFT JOIN `mst_cities` MC
                ON URS.`city_id`= MC.id
                LEFT JOIN `mst_ages` MA
                ON MA.id= URS.`age_id`
           WHERE
                OW.id= ? AND
                UP.`display_flag`=1
                AND ORS.`recruit_status`=2 AND
                US.`display_flag`=1 AND US.user_status=1
                AND UP.`user_payment_status`=5
                AND TIME_TO_SEC(TIMEDIFF(NOW(),UP.request_money_date))/3600 > ?
            LIMIT ?,? ';

        $params = array($owner_recruit_id);
        $params[] = $this->config->item('hours');
        $page = ($page - 1) * $posts_per_page;
        $params[] = $page;
        $params[] = $posts_per_page;
        $query = $this->db->query($sql,$params);
        return $query->result_array();
    }

    /**
     * @author  [IVS] Nguyen Van Phong
     * @name 	countOwnerNotPayUserHappyMoney
     * @todo 	count Owner Not Pay User Happy Money
     * @param 	$owner_recruit_id
     * @return 	count data
     */
    public function countOwnerNotPayUserHappyMoney($owner_recruit_id = 0) {
        $sql = '
            SELECT USR.userid, USR.user_unique_id, USR.URCID, USR.city_name, USR.age1, USR.age2, USR.hopedayworkingname1, USR.hopedayworkingname2,
            USR.hopetimeworkingname1, USR.hopetimeworkingname2,
            UP.`apply_date`, UP.`request_money_date`
            FROM user_payments UP
                    INNER JOIN
                    (
                            SELECT ORC.id
                            FROM owners OW INNER JOIN owner_recruits ORC ON OW.id = ORC.owner_id
                            WHERE OW.display_flag = 1 AND OW. id = ?
                            LIMIT 1
                    ) OWR
                    ON UP.`owner_recruit_id` = OWR.id
                    INNER JOIN
                    (
                            SELECT UR.id AS userid, UR.unique_id AS user_unique_id, URC.id AS URCID, MC.name AS city_name, MA.name1 AS age1, MA.name2 AS age2,
                            MHDW.name1 AS hopedayworkingname1, MHDW.name2 AS hopedayworkingname2,
                            MHTW.name1 AS hopetimeworkingname1, MHTW.name2 AS hopetimeworkingname2
                            FROM users UR
                            INNER JOIN user_recruits URC ON UR.id = URC.user_id
                            LEFT JOIN mst_cities MC ON URC.city_id = MC.id
                            LEFT JOIN mst_ages MA ON URC.age_id = MA.id
                            LEFT JOIN mst_hope_day_working MHDW ON URC.hope_day_working_id = MHDW.id
                            LEFT JOIN mst_hope_time_working MHTW ON URC.hope_time_working_id = MHTW.id

                            WHERE UR.display_flag = 1 AND URC.display_flag = 1 AND MC.display_flag=1 AND MA.display_flag=1
                            AND MHDW.display_flag=1 AND MHTW.display_flag=1
                    ) USR
                    ON UP.`user_id` = USR.userid

            WHERE UP.display_flag = 1 AND UP.user_payment_status = 5 AND DATEDIFF(CURRENT_DATE(),UP.request_money_date) > 7
            GROUP BY USR.URCID, USR.city_name, USR.age1, USR.age2, USR.hopedayworkingname1, USR.hopedayworkingname2,
            USR.hopetimeworkingname1, USR.hopetimeworkingname2,
            UP.`apply_date`, UP.`request_money_date`
            ';
        $query = $this->db->query($sql,array($owner_recruit_id));
        return count($query->result_array());
    }

    /**
     * @author: [IVS] Nguyen Bao Trieu
     * @name : checkUniqueId
     * @todo : check UniqueId
     * @param string $uniqueId
     * @return data
     */
    public function checkUniqueId($uniqueId)
    {
        $sql = 'SELECT COUNT(unique_id) AS countId FROM owners WHERE display_flag = 1 and unique_id = ? ';
        $query = $this->db->query($sql, array($uniqueId));
        return $query->row_array();
    }

    /**
     * @author: VJS
     * @name : checkRegisteredEmail
     * @todo : check if an email is used or not
     * @param string $email
     * @return TRUE: used, FALSE: not used
     */
    public function checkRegisteredEmail($email)
    {
        $ret = false;
        $sql = 'SELECT email_address FROM owners WHERE display_flag = 1 and email_address = ? ';
        $query = $this->db->query($sql, array($email));
        if ( $query && ($rows = $query->row_array()) && count($rows) > 0 ){
            $ret = true;
        }
        return $ret;
    }

     /**
     * @author: [IVS] Nguyen Bao Trieu
     * @name : getDefaultMoney
     * @todo : get Default Money
     * @param : null
     * @return data
     */
    public function getDefaultMoney()
    {
        $sql = 'SELECT id FROM mst_happy_moneys WHERE display_flag =1 and default_money = 1';
        $query = $this->db->query($sql);
        return $query->row_array();
    }


     /**
     * @author  [IVS] Nguyen Bao Trieu
     * @name 	getIdWebSite
     * @todo 	getId WebSite
     * @param 	$data
     * @return 	data
     */
    public function getIdWebSite($websiteId)
    {
        $sql = 'SELECT id FROM `mst_websites` WHERE code LIKE ?';
        $query = $this->db->query($sql, $websiteId);
        $row =  $query->row_array();
        return $row['id'];
    }

     /**
     * @author  [IVS] Lam Tu My Kieu
     * @name 	getOwnerStatus
     * @todo 	getOwnerStatus
     * @param 	$data
     * @return 	data
     */
    public function getOwnerStatus($ownerId)
    {
        $sql = 'SELECT owner_status FROM `owners` WHERE id LIKE ?';
        $query = $this->db->query($sql, $ownerId);
        $row =  $query->row_array();
        return $row['owner_status'];
    }

     /**
     * @author  [IVS] Lam Tu My Kieu
     * @name 	countOwnerRecruit
     * @todo 	countOwnerRecruit
     * @param 	$data
     * @return 	data
     */
    public function countOwnerRecruit($ownerId)
    {
        $sql = 'SELECT COUNT(*) AS total FROM `owner_recruits` WHERE owner_id LIKE ?';
        $query = $this->db->query($sql, $ownerId);
        $row =  $query->row_array();
        return $row['total'];
    }

    /**
     * @author  [IVS] Lam Tu My Kieu
     * @name 	getOwnerRecruitIdOld
     * @todo 	getOwnerRecruitIdOld
     * @param 	$data
     * @return 	data
     */
    public function getOwnerRecruitIdOld($ownerId, $userId)
    {
        $sql = 'SELECT orr.`id`
FROM owners o
INNER JOIN owner_recruits orr ON orr.`owner_id`=o.`id`
INNER JOIN user_payments up ON up.`owner_recruit_id`=orr.`id`

WHERE up.`user_id` like ? AND o.`id` like ?';
        $query = $this->db->query($sql,array($userId, $ownerId));
        $row =  $query->row_array();
        return $row['id'];
    }

     /**
     * @author  [IVS] Nguyen Minh Ngoc
     * @name 	getOwnerRecruitIdNM
     * @todo 	getOwnerRecruitIdNM
     * @param 	$data
     * @return 	data
     */
    public function getOwnerRecruitIdNM($ownerId, $userId)
    {
        $sql = 'SELECT owr.`id`
                FROM owner_recruits owr
                INNER JOIN user_payments up ON owr.`id` = up.`owner_recruit_id`
                WHERE owner_id = ? AND up.`user_id` = ?';
        $query = $this->db->query($sql,array($ownerId, $userId));
        $row =  $query->row_array();
        return $row['id'];
    }

    /**
     * @author  [IVS] Lam Tu My Kieu
     * @name 	getOwnerRecruitId
     * @todo 	getOwnerRecruitId
     * @param 	$data
     * @return 	data
     */
    public function getOwnerRecruitId($ownerId)
    {
        $sql = 'SELECT orr.`id`
        FROM owners o
        INNER JOIN owner_recruits orr ON orr.`owner_id`=o.`id`

        WHERE orr.`display_flag`=1 AND o.`id` LIKE ?';
        $query = $this->db->query($sql,array($ownerId));
        $row =  $query->row_array();
        return $row['id'];
    }
    /**
     * author: VJソリューションズ
     * name : getOwnerIDFromUniqueID
     * todo : オンナーユニックIDからID取得
     * @param int $ownerUniqueId
     * @return オンナーID
     */
    public function getOwnerIDFromUniqueID($ownerUniqueId) {
        if ( !$ownerUniqueId ){
            return null;
        }

        $sql = 'SELECT id FROM owners WHERE display_flag = 1 and unique_id = ?';
        $result = $this->db->query($sql, $ownerUniqueId);
        if ( $result ){
            return $result->row_array();
        }else{
            return null;
        }
    }

    public function getScoutMailQtySendPerDay() {
      $sql = 'SELECT common_email_no_per_day
              FROM mst_scout_mail
              WHERE display_flag = 1';
      $query = $this->db->query($sql);
      return $query->row_array();
    }

    public function getScoutPoint() {
      $sql = 'SELECT point
              FROM mst_scout_point
              WHERE display_flag = 1';
      $query = $this->db->query($sql);
      return $query->row_array();
    }
    public function getAccessPoint() {
      $sql = 'SELECT *
              FROM mst_point_access
              WHERE display_flag = 1';
      $query = $this->db->query($sql);
      return $query->row_array();
    }
    public function getAutoSend($owner_id, $andWhere = '') {
      $sql = 'SELECT *
              FROM owner_auto_send
              WHERE owner_id = ? ' . $andWhere .' ORDER BY id';
      $query = $this->db->query($sql, $owner_id);
      return $query->result_array();

    }
    public function getAllAutoSend(){
        $this->db->group_by('owner_id');
        $this->db->order_by('id');
        $query = $this->db->get('owner_auto_send');
        return $query->result();
    }

    public function inactiveScoutMailQty($data) {
      $this->db->where('display_flag', 1);
      $this->db->update('mst_scout_mail', $data);
    }

    public function inactiveCurrentScoutPoint($data) {
      $this->db->where('display_flag', 1);
      $this->db->update('mst_scout_point', $data);
    }
    public function inactiveCurrentAccessPoint($data) {
      $this->db->where('display_flag', 1);
      $this->db->update('mst_point_access', $data);
    }

    public function insertOwnerScoutPrText($data) {
      $this->db->insert('owner_scout_pr_text', $data);
      return $this->db->insert_id();
    }

    public function insertAutoSend($data) {
      $this->db->insert('owner_auto_send', $data);
      return $this->db->insert_id();
    }

    public function insertScoutMailQty($data) {
      $this->db->insert('mst_scout_mail', $data);
      return $this->db->insert_id();
    }

    public function insertScoutPoint($data) {
      $this->db->insert('mst_scout_point', $data);
      return $this->db->insert_id();
    }
    public function insertAccessPoint($data) {
      $this->db->insert('mst_point_access', $data);
      return $this->db->insert_id();
    }

    public function setDefaultScoutMailQtyToOwners($data) {
      $this->db->where('display_flag', 1);
      $this->db->update('owners', $data);
    }
    public function resetScoutMailQtyToOwners() {
      $sql = "UPDATE owners
              SET `remaining_scout_mail` = `default_scout_mails_per_day`
              WHERE `display_flag` = 1";
      $this->db->query($sql);
    }
    public function updateRemainingScoutMail($ownerId, $data ) {
      $this->db->where('id', $ownerId);
      $this->db->update('owners', $data);
    }

    public function updateUserMessageIsRead($msg_id) {
    	$this->db->where('id', $msg_id);
    	$this->db->update('list_user_owner_messages', array('is_read_flag' => 0));
    }

    public function updateOwnerScoutMailPrText($id, $data) {
      $this->db->where('id', $id);
      $this->db->update('owner_scout_pr_text', $data);
    }
    public function updateAutoSend($owner_id, $data, $pick_num_order = false, $selected_flag = false) {
      $this->db->where('owner_id', $owner_id);
      if($pick_num_order != false){
        $this->db->where('pick_num_order', $pick_num_order);
      }
      if($selected_flag != true){
        $this->db->where('selected_flag', '0');
      }else{
        $this->db->where('selected_flag !=', '0');
      }
      $this->db->update('owner_auto_send', $data);
    }
    public function updateAutoSendFlag($owner_id, $autoSendFlag){
      $this->db->where('owner_id', $owner_id);
      $this->db->update('owner_auto_send', array('scout_auto_send_flag' => $autoSendFlag));
    }

    // get number of scout mail able to send left on the day
    public function getRemainingScoutEmail($owner_id) {
      $ret = 0;
      if ( $owner_id ){
        $this->db->select('remaining_scout_mail');
        $this->db->where('id', $owner_id);
        $this->db->where('display_flag', '1');
        $query = $this->db->get('owners');
        if ( $query && $row = $query->row_array() ){
            $ret = $row['remaining_scout_mail'];
        }
      }
      return $ret;
    }


    public function getUserScoutMails($ownerId = null, $userId = null, $page = 1, $post_per_page = 1) {
      if ( $page < 1 ) {
        return null;
      }

      $page = ($page - 1) * $post_per_page;
      $sql = "SELECT ors.id AS owner_recruit_id, mhm.user_happy_money, lum.template_id,
              lum.created_date as sent_date,lum.scout_mail_open_date,lum.id as scout_mail_id,ospt.pr_title
              FROM owners ow
              LEFT JOIN owner_recruits ors ON ow.id  = ors.owner_id
              LEFT JOIN mst_happy_moneys mhm ON ors.happy_money_id = mhm.id
              LEFT JOIN list_user_messages lum ON ors.id = lum.owner_recruit_id
              LEFT JOIN owner_scout_pr_text ospt ON lum.owner_scout_mail_pr_id = ospt.id
              WHERE ow.id = ? AND lum.user_id = ?
              ORDER BY lum.id DESC
              LIMIT ?, ?";
      $query = $this->db->query($sql, array($ownerId, $userId, intval($page), $post_per_page));
    return $query->result_array();
    }

    public function countUserScoutMails($ownerId = null, $userId = null) {
      $sql = 'SELECT ors.id AS owner_recruit_id
              FROM owners ow
              LEFT JOIN owner_recruits ors ON ow.id  = ors.owner_id
              LEFT JOIN list_user_messages lum ON ors.id = lum.owner_recruit_id
              WHERE ow.id = ? AND lum.user_id = ?';

      $query = $this->db->query($sql, array($ownerId, $userId));
      return $query->num_rows();
    }

    public function countOwnerHiddenUsers($owner_id) {
      $sql = "SELECT id FROM owner_hidden_users WHERE owner_id = '$owner_id'";
      $query = $this->db->query($sql);
      return $query->num_rows();
    }

    public function countOwnerScoutMailSent($userId = null, $ownerId = null) {
      $sql = "select lum.is_read
              from list_user_messages lum
              left join owner_recruits owr on lum.owner_recruit_id = owr.id
              left join owners ow on owr.owner_id = ow.id
              where lum.user_id = ? and ow.id = ?";

      $query = $this->db->query($sql, array($userId, $ownerId));
      return array($query->num_rows());
    }

    public function getCountOwnerIdRecruit($recruitId){
        if(preg_match('/^[0-9]+$/',$recruitId)){
            $sql = "SELECT id, owner_id FROM owner_recruits WHERE id = ? AND display_flag = 1";
            $query = $this->db->query($sql, $recruitId);
            return $query->row_array();
        }else{
            return array();
        }
    }

    public function getUserOpenScoutMail($userId = null, $ownerId = null) {
      $sql = "select lum.id, lum.is_read, us.last_visit_date, lum.created_date
              from list_user_messages lum
              inner join owner_recruits owr on lum.owner_recruit_id = owr.id
              inner join owners ow on owr.owner_id = ow.id
              inner join users us on lum.user_id = us.id
              WHERE lum.user_id = ? AND ow.id = ?
              order by lum.id desc limit 1";

      $query = $this->db->query($sql, array($userId, $ownerId));
      return array($query->row_array());
    }

    public function deleteOwnerHiddenUser($owner_id, $user_id) {
    	$sql = "DELETE FROM owner_hidden_users WHERE owner_id = '$owner_id' AND user_id = '$user_id'";
    	$this->db->query($sql);
    }

    /**
    * Get user messages exchanged between users and owners
    * @param int $limit: number of message to get
    * @param int $offset: start from this offset
    * @param BOOLEAN $first_message: get first message only or not
    * @param string $member_name: user real name
    * @param string $storename: owner's store name
    * @return array user messages
    */
    public function getUserMessages($limit = 1, $offset = 0, $first_message = false, $member_name = null, $storename = null, $public_flag = null)
    {
        $ret = array();

        $this->db->select("
                luom.id as msg_id, 
                luom.user_id, nmus.id as none_member_id, us.unique_id, luom.title, luom.content, luom.created_date, luom.owner_res_flag, luom.display_flag,luom.public_flag,luom.category_id,
                ow.unique_id as owner_id, ow.storename, luom.first_message_flag, luom.is_read_flag,luom.is_replied_flag, luom.reply_id, us.name AS users_name, nmus.name AS none_member_name
        ");
        $this->db->from('list_user_owner_messages luom');
        $this->db->join('users AS us', 'luom.user_id = us.id', 'LEFT');
        $this->db->join('none_member_users AS nmus', 'luom.none_member_id = nmus.id', 'LEFT');
        $this->db->join('owners AS ow', 'luom.owner_id = ow.id', 'LEFT');
        $this->db->where('luom.msg_from_flag', 0);
/*
        $sql =  "SELECT luom.id as msg_id, luom.user_id, nmus.id as none_member_id, us.unique_id, luom.title, luom.content, luom.created_date, luom.owner_res_flag, luom.display_flag,luom.public_flag,luom.category_id,
        		ow.unique_id as owner_id, ow.storename, luom.first_message_flag, luom.is_read_flag,luom.is_replied_flag, luom.reply_id, us.name AS users_name, nmus.name AS none_member_name
                FROM list_user_owner_messages luom
                LEFT JOIN users us ON luom.user_id = us.id
                LEFT JOIN none_member_users nmus ON luom.none_member_id = nmus.id
                LEFT JOIN owners ow ON luom.owner_id = ow.id
                WHERE luom.msg_from_flag = 0";
*/
    //    $this->db->where('luom.reply_id !=', 'NULL');
      //      $this->db->where('luom.public_flag', 0);
        //    $this->db->where('luom.owner_res_flag', 1);


        if ($first_message) {
            $this->db->where('luom.first_message_flag', 1);
        }

        if ($member_name) {
            $this->db->like('us.name', $this->db->escape_like_str($member_name));
        }

        if ($storename) {
            $this->db->like('ow.storename', $this->db->escape_like_str($storename));
        }

        if ($public_flag == 1) {
            $this->db->where('luom.reply_id !=', 'NULL');
            $this->db->where('luom.public_flag', 0);
            $this->db->where('luom.owner_res_flag', 1);
        }

        $this->db->order_by("luom.id", "DESC");
        $this->db->limit($limit, $offset);
        $result = $this->db->get();
//        $sql .= " ORDER BY luom.id DESC LIMIT ? OFFSET ?";
//        $result = $this->db->query($sql, array($limit, $offset) );


        if ($result && $data = $result->result_array()) {

//echo $this->db->last_query();

            foreach ($data as $message_data) {
                $reply_id = $message_data["reply_id"];
                // 返事内容取得(get reply-message content, title)
                $addition_data = array('reply_content' => '', 'reply_title' => '');
                if ($reply_id) {
                    $tmp = false;
                    $sql = "SELECT id AS reply_id, content AS reply_content, title AS reply_title, category_id AS reply_category_id ";
//                    $sql = "SELECT content AS reply_content, title AS reply_title ";
                    $sql .= "FROM list_user_owner_messages ";
                    if ($public_flag == 1) {
                        $sql .= "WHERE msg_from_flag = 1 AND id = ? AND public_flag = 0";
                        $sql .= " AND owner_res_flag = 1";
                        $result = $this->db->query($sql, $reply_id);
                    } else {
                        $sql .= "WHERE msg_from_flag = 1 AND id = ?";
                        $result = $this->db->query($sql, $reply_id);
                    }

//echo $this->db->last_query();
                    if ($result && $tmp = $result->row_array()) {
                        $addition_data = $tmp;
                    }
                }
                if ($public_flag == 1) {
//                var_dump($tmp);
                    $ret[] = array_merge($message_data, $addition_data);
                } else {
                    $ret[] = array_merge($message_data, $addition_data);
                }
            }
        }
        return $ret;
    }

    /**
    * getUserMessages_public
    * @param $ar
    * @return array user messages
    */
    public function getUserMessages_public($ar, $limit = null)
    {
        $this->db->select('id, title, content, reply_id, category_id');
        $this->db->from('list_user_owner_messages');
        $sql = '(';
        foreach ($ar as $key => $val) {
            $sql .= ($key > 0)? ' OR ':'';
            $sql .= 'owner_id='.$val['id'];
        }
        $sql .= ')';
        $this->db->where($sql);
        $this->db->where('owner_res_flag', 1);
        $this->db->where('msg_from_flag', 0);
        $this->db->where('reply_id !=', 'NULL');
        $this->db->where('public_flag', 1);
        $result = $this->db->get();

        $ret = array();
        $new_ret = array();
        $new_ret_count = 0;
        if ($result && $data = $result->result_array()) {
            foreach ($data as $message_data) {
                $reply_id = $message_data["reply_id"];
                // 返事内容取得(get reply-message content, title)
                $addition_data = array('reply_content' => '', 'reply_title' => '');
                if ($reply_id) {
                    $this->db->select('luom.id AS reply_id, luom.content AS reply_content, luom.title AS reply_title, luom.category_id AS reply_category_id, luom.owner_id, owr.id AS owr_id, ow.storename');
                    $this->db->from('list_user_owner_messages luom');
                    $this->db->join('owner_recruits owr', 'owr.owner_id = luom.owner_id', 'INNER');
                    $this->db->join('owners AS ow', 'ow.id = owr.owner_id', 'INNER');
                    $this->db->where('owr.display_flag', 1);
                    $this->db->where('luom.msg_from_flag', 1);
                    $this->db->where('luom.id', $reply_id);
                    $this->db->order_by('luom.created_date DESC');
                    $this->db->limit(3);
                    $result = $this->db->get();
                    if ($result && $tmp = $result->row_array()) {
                        $addition_data = $tmp;
                    }
                }
                $ret[] = array_merge($message_data, $addition_data);
                if ($new_ret_count < 10) {
                    $new_ret[] = array_merge($message_data, $addition_data);
                    $new_ret_count++;
                }
            }
        }

        $count_ar = array();
        $category_name_ar= array();
        $category_name_ar[0] = array('id'=>0,'name'=>'全て','count'=>count($ret));
        $category_name_ar[6] = array('id'=>6, 'name'=>'仕事内容','count'=>0);
        $category_name_ar[1] = array('id'=>1, 'name'=>'報酬','count'=>0);
        $category_name_ar[2] = array('id'=>2, 'name'=>'待遇','count'=>0);
        $category_name_ar[3] = array('id'=>3, 'name'=>'面接・体験入店','count'=>0);
        $category_name_ar[4] = array('id'=>4, 'name'=>'休暇','count'=>0);
        $category_name_ar[5] = array('id'=>5, 'name'=>'未経験','count'=>0);
        $category_name_ar[100] = array('id'=>100, 'name'=>'その他','count'=>0);
        foreach ($ret as $key => $val) {
            $category_name_ar[$val['reply_category_id']]['count']++;
        }
        foreach ($category_name_ar as $key => $val) {
            if ($val['count'] < 1) {
                unset($category_name_ar[$val['id']]);
            }
        }


        foreach ($new_ret as $key => $val) {
            $storename = $val['storename'];
            $content = $val['content'];
            $str = preg_replace('/'.$storename.'様へ/', '', $content);
            $new_ret[$key]['content'] = $str;
        }
        $ret_ar['new_cate_message'] = $new_ret;

        if (count($ret > 0)) {
            $ret_ar['cate_count'] = $category_name_ar;
        } else {
            $ret_ar['cate_count'] = false;
        }
        return $ret_ar;
    }

    public function getUserMessages_public_contents_new($limit = 20)
    {
        $this->db->select('owr.id AS owr_id, alias2.id, alias2.title, alias2.content, alias2.reply_id, alias2.category_id, alias2.owner_res_flag, alias1.content AS reply_content');
        $this->db->from('list_user_owner_messages AS alias1');
        $this->db->join('list_user_owner_messages AS alias2', 'alias1.id = alias2.reply_id', 'INNER');
        $this->db->join('owner_recruits AS owr', 'owr.owner_id = alias2.owner_id', 'INNER');
        $this->db->join('owners AS ow', 'ow.id = owr.owner_id', 'INNER');

        $this->db->where('owr.display_flag', 1);
        $this->db->where('alias1.public_flag', 1);
        $this->db->where('alias2.reply_id !=', 'NULL');
        $this->db->where('alias2.owner_res_flag', 1);
        $this->db->order_by("alias2.created_date", "DESC");
        if ($limit > 0) {
            $this->db->limit($limit);
        }
        $result = $this->db->get();
//echo $this->db->last_query();
        $arr = $result->result_array();
        return $arr;
    }


    public function getUserMessages_public_contents($ar, $category_id, $offset = 0, $limit = 0)
    {
        $this->db->select('luom.id, luom.title, luom.content, luom.reply_id, luom.category_id, luom.owner_res_flag');
        $this->db->from('list_user_owner_messages AS luom');
        $this->db->join('owner_recruits AS owr', 'owr.owner_id = luom.owner_id');
        $this->db->join('owners AS ow', 'ow.id = luom.owner_id');
        $this->db->where('owr.display_flag', 1);
        $sql = '(';
        foreach ($ar as $key => $val) {
            $sql .= ($key > 0)? ' OR ':'';
            $sql .= 'luom.owner_id='.$val['id'];
        }
        $sql .= ')';
        $this->db->where($sql);
        $this->db->where('luom.msg_from_flag', 0);
        $this->db->where('luom.reply_id !=', 'NULL');
        $this->db->where('luom.public_flag', 1);
        $this->db->where('luom.owner_res_flag', 1);
        $result = $this->db->get();
        $arr = $result->result_array();

        $ret_ar['last_query'][] = $this->db->last_query();


        $count_ar = array();

        $cate_all_count = count($arr);
        $ret_ar['cate_all_count'] = $cate_all_count;

        $category_name_ar= array();
        $category_name_ar[0] = array('id'=>0,'name'=>'全て','count'=>$cate_all_count);
        $category_name_ar[6] = array('id'=>6, 'name'=>'仕事内容','count'=>0);
        $category_name_ar[1] = array('id'=>1, 'name'=>'報酬','count'=>0);
        $category_name_ar[2] = array('id'=>2, 'name'=>'待遇','count'=>0);
        $category_name_ar[3] = array('id'=>3, 'name'=>'面接・体験入店','count'=>0);
        $category_name_ar[4] = array('id'=>4, 'name'=>'休暇','count'=>0);
        $category_name_ar[5] = array('id'=>5, 'name'=>'未経験','count'=>0);
        $category_name_ar[100] = array('id'=>100, 'name'=>'その他','count'=>0);

        foreach ($arr as $key => $val) {
            if ($val['category_id'] > 0) {
                $category_name_ar[$val['category_id']]['count']++;
            }
        }
        foreach ($category_name_ar as $key => $val) {
            if ($val['count'] < 1) {
                unset($category_name_ar[$val['id']]);
            }
        }
        $ret_ar['current_cate'] = $category_name_ar[$category_id];
        if ($category_id > 0) {
            $ret_ar['cate_all_count'] = $category_name_ar[$category_id]['count'];
        }
        unset($category_name_ar[$category_id]);

        $ret = array();
        foreach ($arr as $message_data) {
            $arr_category_id = $message_data["category_id"];
            if ($category_id == $arr_category_id) {
                $ret[] = $message_data;
            }
        }

        $this->db->select('alias2.id, alias2.reply_id, alias2.content, alias1.content AS reply_content,
        alias1.owner_res_flag AS owner_res_flag1,alias2.owner_res_flag AS owner_res_flag2, alias1.msg_from_flag AS msg_from_flag1, alias2.msg_from_flag AS msg_from_flag2,
        alias2.title AS reply_title, alias1.category_id AS reply_category_id,alias1.created_date, owr.id AS owr_id, ow.storename');
        $this->db->from('list_user_owner_messages AS alias1');
        $this->db->join('list_user_owner_messages AS alias2', 'alias1.id = alias2.reply_id', 'INNER');
        $this->db->join('owner_recruits AS owr', 'owr.owner_id = alias2.owner_id', 'INNER');
        $this->db->join('owners AS ow', 'ow.id = owr.owner_id', 'INNER');
        $this->db->where('owr.display_flag', 1);
        $this->db->where('alias1.msg_from_flag', 1);
        $this->db->where('alias1.public_flag', 1);
        if ($category_id > 0) {
            $i = 0;
            $sql = '(';
            foreach ($arr as $message_data) {
                $arr_category_id = $message_data["category_id"];
                if ($category_id == $arr_category_id) {
                    $sql .= ($i > 0)? ' OR ':'';
                    $sql .= 'alias2.id='.$message_data["id"];
                    $i++;
                }
            }
            $sql .= ')';
            $this->db->where($sql);
            $this->db->where('alias1.category_id', $category_id);
        } else {
            $i = 0;
            $sql = '(';
            foreach ($arr as $message_data) {
                $sql .= ($i > 0)? ' OR ':'';
                $sql .= 'alias2.id='.$message_data["id"];
                $i++;
            }
            $sql .= ')';
            $this->db->where($sql);
        }
        $this->db->order_by("alias1.created_date", "DESC");

        if ($limit > 0) {
            $this->db->limit($limit);
        }
        if ($offset > 0) {
            $this->db->offset($offset);
        }

        $result = $this->db->get();
        $res = $result->result_array();

        $ret_ar['last_query'][] = $this->db->last_query();

        foreach ($res as $key => $val) {
            $storename = $val['storename'];
            $content = $val['content'];
            $str = preg_replace('/'.$storename.'様へ/', '', $content);
            $res[$key]['content'] = $str;
        }
        $ret = $res;
//echo $this->db->last_query();
        $ret_ar['cate_message_ar'] = $ret;
        $ret_ar['cate_count'] = $category_name_ar;
        return $ret_ar;
    }


    /* 店舗詳細内カウント表示 */
    public function getUserMessages_owner_public($owner_id) {
/*
        $this->db->select('alias2.id, alias2.reply_id, alias2.content, alias1.content AS reply_content, alias2.title AS reply_title, alias1.category_id AS reply_category_id,alias1.created_date');
        $this->db->from('list_user_owner_messages AS alias1');
        $this->db->join('list_user_owner_messages AS alias2', 'alias1.id = alias2.reply_id', 'INNER');
        $this->db->where('alias1.msg_from_flag', 1);
        $this->db->where('alias1.public_flag', 1);
        $this->db->where('alias1.$owner_id', $owner_id);
        $this->db->order_by("alias1.created_date", "DESC");
//        $this->db->limit(10);
        $result = $this->db->get();
        $res = $result->result_array();
        $ret = $res;
*/


        $this->db->select('id, title, content, reply_id, category_id');
        $this->db->from('list_user_owner_messages');
        $this->db->where('owner_id', $owner_id);
        $this->db->where('msg_from_flag', 0);
        $this->db->where('reply_id !=', 'NULL');
        $this->db->where('public_flag', 1);
        $result = $this->db->get();
        $arr = $result->result_array();

        $count_ar = array();
        $category_name_ar= array();
        $category_name_ar[0] = array('id'=>0, 'name'=>'全て','count'=>count($arr));
        $category_name_ar[6] = array('id'=>6, 'name'=>'仕事内容','count'=>0);
        $category_name_ar[1] = array('id'=>1, 'name'=>'報酬','count'=>0);
        $category_name_ar[2] = array('id'=>2, 'name'=>'待遇','count'=>0);
        $category_name_ar[3] = array('id'=>3, 'name'=>'面接・体験入店','count'=>0);
        $category_name_ar[4] = array('id'=>4, 'name'=>'休暇','count'=>0);
        $category_name_ar[5] = array('id'=>5, 'name'=>'未経験','count'=>0);
        $category_name_ar[100] = array('id'=>100, 'name'=>'その他','count'=>0);

        foreach ($arr as $key => $val) {
            $category_name_ar[$val['category_id']]['count']++;
        }
        foreach ($category_name_ar as $key => $val) {
            if ($val['count'] < 1) {
                unset($category_name_ar[$val['id']]);
            }
        }
//        $ret_ar['cate_message_ar'] = $ret;
        $ret_ar['cate_count'] = $category_name_ar;
        return $ret_ar;
    }

    // decline bonus point for inappropriate message
    public function declineMessageBonusPoint($user_id, $noneuserid, $msg_id, $msg_bonus_point, $first_message_flag) {
        $ret = false;
        $set_none_member = '';
        // check parameters
        if ( (!$user_id && !$noneuserid) || !$msg_id || $msg_bonus_point <= 0 ){
            return $ret;
        }

        if ($noneuserid) {
            $set_none_member = " AND none_member_id = '" . $noneuserid ."'";
        }

        $sql = "UPDATE list_user_owner_messages
                SET display_flag = 0, updated_date = NOW()
                WHERE display_flag = 1
                AND id = ? AND user_id = ? " . $set_none_member;
        if ($first_message_flag == 1) { // for first message only
            $sql .= " AND first_message_flag = 1";
        }

        $this->db->trans_start();
        $result = $this->db->query($sql, array($msg_id, $user_id));
        if (!$noneuserid) {
            if($result && $this->db->affected_rows() > 0) {
                if ( $first_message_flag != 1 ) {
                    $ret = true;
                } else {
                    // minus message bonus point
                    $sql = "UPDATE scout_mail_bonus
                      SET bonus_money = bonus_money - ?, updated_date = NOW()
                      WHERE user_id = ?
                      AND bonus_requested_flag = 0
                      AND display_flag = 1
                      AND bonus_money >= ?";
                    $result = $this->db->query($sql, array($msg_bonus_point, $user_id, $msg_bonus_point));
                    if ($result && $this->db->affected_rows() > 0){
                      $ret = true;
                    }
                }
            }
        } else {
            $ret = true;
        }

        $this->db->trans_complete();
        return $ret;
    }

    /**
    * Get total user messages exchanged between users and owners
    * @param BOOLEAN $first_message: get first message only or not
    * @param string $member_name: user real name
    * @param string $storename: owner's store name
    * @return int total messages
    */
    public function getTotalUserMessages($first_message = false, $member_name = null, $storename = null, $chkbox_public_message = null) {
        $ret = 0;
        $sql = "SELECT count(luom.id) as msg_total_no
                FROM list_user_owner_messages luom
                LEFT JOIN users us ON luom.user_id = us.id
                LEFT JOIN owners ow ON luom.owner_id = ow.id
                WHERE luom.msg_from_flag = 0";

        if ($first_message) {
            $sql .= " AND luom.first_message_flag = 1 ";
        }

        if ($member_name) {
            $sql .= " AND us.`name` LIKE '%".$this->db->escape_like_str($member_name)."%' ";
        }

        if ($storename) {
            $sql .= " AND ow.`storename` LIKE '%".$this->db->escape_like_str($storename)."%' ";
        }

        if ($chkbox_public_message == 1) {
            $sql .= " AND luom.reply_id != 'NULL'";//.$chkbox_public_message;
            $sql .= " AND luom.public_flag = 0";//.$chkbox_public_message;
            $sql .= " AND luom.owner_res_flag = 1 ";
        }

        $result = $this->db->query($sql);
        if ($result && $data = $result->row_array()) {
            $ret = $data['msg_total_no'];
        }

        return $ret;
    }
    public function getSendLog(){
        $this->db->where('date(sent_date_time)', date("Y-m-d"));
        $query = $this->db->get('owner_auto_send_log');
        return $query->result();
    }
    public function insertSendLog($owner_id, $num_scout_mail){
        $data = array('owner_id' => $owner_id, 'sent_date_time' => date("y-m-d H:i:s"), 'number_of_sent_mails' => $num_scout_mail);
        $this->db->insert('owner_auto_send_log', $data);
        return $this->db->insert_id();
    }
    // parameter "status"
    // 1: new user
    // 2: login within a month
    // 3: openned mail
    // ret: list of user_id
    public function getUsersToSend($owner_id, $owner_hidden_users, $sent_user_id_list, $max_mail_numbers, $status, $area_id = null){
        $ret_user_list = array();

        // check parameters
        if ($status != 1 && $status != 2 && $status != 3) {
            return $ret_user_list;
        }

        if ((int)$max_mail_numbers <= 0) {
            return $ret_user_list;
        }

        // get not-to-send users
        $not_select_users = array();
        if (is_array($sent_user_id_list) && count($sent_user_id_list) > 0) {
            $not_select_users = $sent_user_id_list;
        }
        if ($owner_hidden_users && is_array($owner_hidden_users)){
            $owner_hidden_users_list = array();
            foreach ($owner_hidden_users as $key => $value) {
                $owner_hidden_users_list[]  = $value['user_id'];
            }
            $not_select_users = array_merge($not_select_users, $owner_hidden_users_list);
        }
        $not_select_users_str = null;
        if (count($not_select_users) > 0) {
            $not_select_users_str = join("','", $not_select_users);
        }

        // create sql
        $sql  = "SELECT u.id as user_id FROM users u ";
        $sql .= "INNER JOIN  user_recruits ur ON ur.user_id = u.id ";
        $sql .= "WHERE u.user_status = 1 AND ";

        $params = array();
        // check status
        switch($status) {
            case 1: // new user
                $sql  .= " DATE_ADD(IFNULL(u.accept_remote_scout_datetime, u.offcial_reg_date), INTERVAL 2 DAY) >= NOW() ";
                break;
            case 2: // last login within a month
                $sql  .= " DATE_ADD(u.last_visit_date, INTERVAL 1 MONTH) >= NOW() ";
                break;
            case 3: // openned mail
                $sql  .= " u.id = (SELECT lum.user_id FROM list_user_messages lum ";
                $sql  .= "         INNER JOIN owner_recruits owr ON (lum.owner_recruit_id = owr.id and owr.owner_id = ?)";
                $sql  .= "         WHERE lum.user_id = u.id and lum.is_read = 1 LIMIT 1)";
                $params[] = $owner_id;
                break;
        }

        // check area
        if ( $area_id ) {
            $sql     .= " AND ur.city_id = ? ";
            $params[] = $area_id;
        }

        // not in spam list
        $sql  .= " AND u.id NOT IN (SELECT `user_id` FROM `scout_message_spams` WHERE `display_flag` = 1 AND `owner_id` = ?)";
        $params[] = $owner_id;
        if ($not_select_users_str) {
            $sql .= " AND u.`id` NOT IN ('" . $not_select_users_str . "')";
        }
        $sql .= " ORDER BY last_visit_date DESC LIMIT " . $max_mail_numbers;

        $query = $this->db->query($sql, $params);
        if ($query) {
            $ret_user_list = $query->result_array();
        }

        return $ret_user_list;
    }

    //use to insert the interviewers data in the db
    public function interviewer($interviewee_data){
        $this->db->insert('owner_interviewer', $interviewee_data);
        return true;
    }

    public function getMonthlyCampaignResultAds() {
        $ret = null;
        $sql = "SELECT month, trial_work_total_paid_money, travel_expense_total_paid_money
                FROM monthly_campaign_result_ads
                WHERE display_flag = 1";
        $query = $this->db->query($sql);
        if ($query && $row = $query->row_array()) {
            $ret = $row;
        }

        return $ret;
    }

    public function countOwnersTown($city_id,$owner_status=2){
        $sql = "SELECT owr.id , owc.category_id, mc.id AS mcid FROM owner_recruits AS owr
                LEFT JOIN `owner_category` AS owc ON owr.id = owc.owner_id
                INNER JOIN `owners` AS ow ON owr.owner_id = ow.id
                LEFT JOIN `mst_city_groups` AS mcg ON owr.city_group_id = mcg.id
                LEFT JOIN `mst_cities` AS mc ON owr.city_id = mc.id
                LEFT JOIN `mst_towns` AS mt ON mt.display_flag = 1
                WHERE  mcg.display_flag = 1 AND mc.display_flag = 1 AND mt.display_flag = 1 AND ow.owner_status IN (".$owner_status.")
                AND owr.display_flag = 1 AND ow.display_flag = 1 AND ow.public_info_flag = 1 AND (mc.id = ?
                OR (owc.category_id = mt.id AND mt.city_id = ?))
                GROUP BY owr.id";
                $query = $this->db->query($sql,array($city_id, $city_id));

        return $query->num_rows();
    }

    public function getOwnerRankSetting($owner_id) {
        $sql = "SELECT id, remaining_update, time_1, time_2, time_3, time_4, time_5 FROM site_rank WHERE owner_id = ? AND display_flag = 1";
        return $this->db->query($sql, array($owner_id))->row_array();
    }

    public function updateSiteRankSettings($data, $id) {
        $this->db->where('id', $id);
        $this->db->update('site_rank', $data);
    }

    public function insertSiteRankSettings($data) {
        $this->db->insert('site_rank', $data);
    }

    public function resetSiteRankRemainingUpdates() {
        $this->db->where('display_flag', 1);
        $this->db->update('site_rank', array('remaining_update' => 5));
    }

    public function updateInterviewer($data ,$owner_id) {
        $this->db->where('owner_id',$owner_id);
        $this->db->update('owner_interviewer',$data);
        return true;
    }

    public function getOwnerUrgentRecruitments($owner_id, $recruitment_type) {
        $ret = null;
        $sql =  "SELECT id, message, CONCAT(date_format(post_date, '%Y-%m-%d '), IF(post_hour < 10, CONCAT('0',post_hour,':00'), CONCAT(post_hour, ':00'))) AS post_date, post_day, post_hour, recruitment_type FROM urgent_recruitment
                 WHERE owner_id = ? AND recruitment_type = ? AND display_flag = 1 ";
        $params[] = $owner_id;
        $params[] = $recruitment_type;
        if ($recruitment_type == 1) {
            $sql .= "AND ((post_date = ? AND post_hour > ?) OR post_date > ?) ORDER BY post_date DESC, post_hour ASC";
            $params[] = date('Y-m-d');
            $params[] = date('H');
            $params[] = date('Y-m-d');
        } elseif ($recruitment_type == 2) {
            $sql .= "ORDER BY post_day";
        }
        $query = $this->db->query($sql, $params);
        if ($query) {
            $ret = $query->result_array();
        }
        return $ret;
    }

    public function checkDayHasScheduleWeekly($owner_id, $day, $urw_day) {
        $ret = false;
        $sql = "SELECT 1 FROM urgent_recruitment
                WHERE owner_id = ? AND post_day = ? AND display_flag = 1 AND recruitment_type = 2 AND display_flag = 1 ";
        $params[] = $owner_id;
        $params[] = $day;
        if ($urw_day) {
            $sql .= "  AND post_day != ?";
            $params[] = $urw_day;
        }

        $cnt = $this->db->query($sql,$params)->num_rows();
        if ($cnt > 0) {
            $ret = true;
        }
        return $ret;
    }

    public function checkDayHasScheduleOccasional($owner_id, $date) {
        $ret = false;
        $sql = "SELECT * FROM urgent_recruitment
                WHERE owner_id = ? AND display_flag = 1 AND recruitment_type = 1 AND date_format(post_date, '%Y-%m-%d') = ?";
        $params[] = $owner_id;
        $params[] = $date;
        $cnt = $this->db->query($sql, $params)->num_rows();
        if ($cnt > 0) {
            $ret = true;
        }
        return $ret;
    }

    public function getUrgentRecruitmentPostDate($ur_id) {
        $ret = false;
        $sql = "SELECT date_format(post_date, '%Y-%m-%d') as post_date FROM urgent_recruitment WHERE display_flag = 1 AND id = ? AND display_flag = 1 ";
        $query = $this->db->query($sql, array($ur_id));
        if ($query && $row = $query->row_array()) {
            $ret = $row['post_date'];
        }
        return $ret;
    }

    public function insertUrgentRecruitment($data) {
        $this->db->insert('urgent_recruitment', $data);
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    public function getUrgentRecruitment($ur_id) {
        $ret = null;
        $sql = "SELECT date_format(post_date, '%Y-%m-%d %H:%s') as post_date, recruitment_type, message, post_day, post_hour FROM urgent_recruitment
                WHERE id = ? AND display_flag = 1";
        $query = $this->db->query($sql, array($ur_id));
        if ($query) {
            $ret = $query->row_array();
        }
        return $ret;
    }

    public function getOwnerUrgentRecruitmentPostDate($ur_id) {
        $ret = null;
        $sql = "SELECT post_day, date_format(post_date, '%Y-%m-%d %H:%s') as post_date FROM urgent_recruitment WHERE display_flag = 1 AND id = ?";
        $query = $this->db->query($sql, array($ur_id));
        if ($query){
            $ret = $query->row_array();
        }
        return $ret;
    }

    public function updateUrgentRecruitment($data, $id) {
        $this->db->where('id', $id);
        return $this->db->update('urgent_recruitment', $data);
    }

    public function getOwnerUrgentRecruitment($owner_id) {
        $ret = null;
        $sql = "SELECT * FROM (SELECT owner_id, message, recruitment_type, post_hour,
                CONCAT(post_date,' ', IF(post_hour < 10, CONCAT('0',post_hour,':00'), CONCAT(post_hour, ':00'))) AS c_post_date, post_date
                FROM urgent_recruitment
                WHERE
                (DATE_FORMAT(post_date, '%Y-%m-%d') = ? AND owner_id = ? AND post_hour <= ? AND display_flag = 1 AND recruitment_type = 1)
                OR (DATE_FORMAT(post_date, '%Y-%m-%d') < ? AND owner_id = ? AND display_flag = 1 AND recruitment_type = 1)) AS a ORDER BY a.post_date DESC LIMIT 1";

        $params[] = date('Y-m-d');
        $params[] = $owner_id;
        $params[] = date('H');
        $params[] = date('Y-m-d');
        $params[] = $owner_id;

        $query = $this->db->query($sql, $params);
        if ($query && $row = $query->row_array()) {
            $ret = $row;
        }
        $date = date('Y-m-d H:i:s');
        $cnt = 1;
        while ($cnt <= 7) {
            $params = array();
            $day = date('w', strtotime($date));
            if ($ret && $date == date('Y-m-d', strtotime($ret['post_date']))) {
                break;
            } else {
                $sql = "SELECT owner_id, message, recruitment_type, post_hour, post_day
                        FROM urgent_recruitment
                        WHERE owner_id = ? AND post_day = ? AND recruitment_type = 2 AND display_flag = 1 ";

                $params[] = intval($owner_id);
                $params[] = intval(date('w', strtotime($date)));
                if (date('Y-m-d') == date('Y-m-d', strtotime($date))) {
                    $sql .= " AND post_hour <= ?";
                    $params[] = date('H', strtotime($date));
                }
                $query = $this->db->query($sql, $params);
                if ($query && $row = $query->row_array()) {
                    if (!$ret || ($ret && $ret['post_date'] < date('Y-m-d', strtotime($date)))) {
                        $hour = ($row['post_hour'] < 10)?'0'.$row['post_hour']:$row['post_hour'];
                        $row['post_date'] = date('Y-m-d', strtotime($date));
                        $row['c_post_date'] = date('Y-m-d', strtotime($date)).' '.$hour.':00';
                        $ret = $row;
                    }
                    break;
                }
            }
            $date = date('Y-m-d', strtotime($date. "-1 days"));
            $cnt++;
        }
        return $ret;

    }

    public function getUrgentRecruitmentLogLatestDate($owner_id) {
        $ret = false;
        $sql = "SELECT posted_date FROM urgent_recruitment_log where owner_id = ? ORDER BY id DESC limit 1";
        $query = $this->db->query($sql, array($owner_id));
        if ($query && $row = $query->row_array()) {
            $ret = $row['posted_date'];
        }
        return $ret;
    }

    public function getUrgentRecruitmentPostHistory($date, $owner_id) {
        $hasOccasional = $this->checkHasOccasional($date, $owner_id);
        $sql = "SELECT id AS ur_id, owner_id, message, now() AS created_date, post_hour,
                IFNULL(CONCAT(DATE_FORMAT(post_date, '%Y-%m-%d '), IF(post_hour < 10, CONCAT('0',post_hour,':00'), CONCAT(post_hour, ':00'))), '') AS posted_date
               FROM urgent_recruitment WHERE owner_id = ? AND display_flag = 1";
        $params[] = intval($owner_id);
        if ($hasOccasional) {
            $sql .= " AND post_date = ? AND post_hour <= ? AND recruitment_type = 1";
            $params[] = date('Y-m-d', strtotime($date));
            $params[] = intval(date('H'));
        } else {
            $sql .= " AND post_day = ? AND post_hour <= ? AND recruitment_type = 2";
            $params[] = intval(date("w", strtotime($date)));
            $params[] = intval(date('H'));
        }
        $sql .= " LIMIT 1";
        $query = $this->db->query($sql, $params);
        if ($query) {
            $ret = $query->row_array();
        }
        return $ret;
    }

    public function getFirstOwnerUrgentRecruitmentDate($owner_id) {
        $ret = false;
        $sql = "SELECT created_date FROM urgent_recruitment WHERE owner_id = ? AND display_flag = 1 ORDER BY id LIMIT 1";
        $query = $this->db->query($sql, array($owner_id));
        if ($query && $row = $query->row_array()) {
            $ret = $row['created_date'];
        }
        return $ret;
    }

    public function insertUrgentRecruitmentPostHistory($data) {
        $this->db->insert('urgent_recruitment_log', $data);
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    public function getOwnerUrgentRecruitmentPostHistory($page = 1, $posts_per_page = 10, $owner_id, $ph_id) {
        $ret = null;
        $sql = "SELECT message, id, DATE_FORMAT(posted_date, '%Y-%m-%d %H:%s') AS posted_date FROM urgent_recruitment_log ";
        if ($owner_id) {
            $sql .= "WHERE owner_id = ?";
            $params[] = $owner_id;
        }
        if ($ph_id) {
            $sql .= "WHERE id = ?";
            $params[] = $ph_id;
        }
        $sql .= " ORDER by posted_date DESC ";
        if ($page && $posts_per_page) {
            $page = ($page - 1) * $posts_per_page;
            $sql .= " LIMIT ?,?";
            $params[] = $page;
            $params[] = intval($posts_per_page);
        }
        $query = $this->db->query($sql, $params);
        if ($query) {
            $ret = $query->result_array();
        }
        return $ret;
    }

    public function countOwnerUrgentRecruitmentPostHistory($owner_id) {
        $sql = "SELECT 1 FROM urgent_recruitment_log WHERE owner_id = ?";
        return $this->db->query($sql, array($owner_id))->num_rows();
    }

    public function countAllUrgentRecruitment() {
        $sql = "SELECT 1 FROM (SELECT owner_id FROM urgent_recruitment WHERE DATE_FORMAT(post_date, '%Y-%m-%d') = ? OR (post_day = ? AND created_date <= ?)";

        $params[] = date('Y-m-d');
        $params[] = date("w", strtotime(date('Y-m-d')));
        $params[] = date('Y-m-d H:i:s');

        $sql .= " ORDER BY id DESC, recruitment_type) AS a GROUP BY a.owner_id";
        return $this->db->query($sql, $params)->num_rows();
    }

    public function getUrgentRecruitmentStatus($owner_id) {
        $ret = false;
        $sql = "SELECT urgent_recruitment_flag FROM owners WHERE id = ?";
        $query = $this->db->query($sql, array($owner_id))->row_array();
        if(count($query) > 0 && $query['urgent_recruitment_flag'] == 1) {
            $ret = true;
        }
        return $ret;
    }

    private function checkHasOccasional($date, $owner_id) {
        $ret = false;
        $sql = "SELECT 1 FROM urgent_recruitment WHERE owner_id = ? and post_date = ? and recruitment_type = 1 AND display_flag = 1 ";
        $cntr = $this->db->query($sql, array($owner_id, date('Y-m-d', strtotime($date))))->num_rows();
        if ($cntr >= 1) {
            $ret = true;
        }
        return $ret;
    }

    public function checkOwnerHasPostedToday($owner_id, $post_date) {
        $ret = false;
        $sql = "SELECT 1 FROM urgent_recruitment_log WHERE owner_id = ? AND DATE_FORMAT(posted_date, '%Y-%m-%d') = ? AND display_flag = 1 ";
        $cnt = $this->db->query($sql, array($owner_id, date('Y-m-d', strtotime($post_date))))->num_rows();
        if ($cnt > 0) {
            $ret = true;
        }
        return $ret;
    }

    public function getUrgentRecruitmentFirstPostDate() {
        $ret = null;

        $sql = "SELECT post_date FROM urgent_recruitment WHERE post_date IS NOT NULL and recruitment_type = 1 AND display_flag = 1 ORDER BY post_date LIMIT 1";
        $query = $this->db->query($sql);

        if ($query && $query->num_rows() > 0) {
            $row = $query->row_array();
            $ret = $row['post_date'];
        }
        $sql = "SELECT post_day, created_date, post_hour FROM urgent_recruitment where recruitment_type = 2 AND display_flag = 1 ORDER BY created_date LIMIT 1";
        $query = $this->db->query($sql);

        if ($query && $query->num_rows() > 0) {
            $row = $query->row_array();
            $date = $row['created_date'];
            while (true) {
                if ($row['post_day'] == date("w", strtotime($date))) {
                    if ($ret) {
                        if ($ret <= date('Y-m-d', strtotime($date))) {
                            $ret = $ret;
                        } else {
                            $ret = date('Y-m-d', strtotime($date));
                        }
                    } else {
                        $ret = date('Y-m-d', strtotime($date));
                    }
                    break;
                }
                $date = date('Y-m-d H:i:s',strtotime($date . "+1 days"));
            }
        }

        return $ret;
    }

    public function getUrgentRecruitmentActiveOwners() {
        $ret = null;
        $sql = "SELECT ur.owner_id as id FROM urgent_recruitment ur
                INNER JOIN owners ow ON ow.id = ur.owner_id
                WHERE ow.display_flag = 1 AND ow.urgent_recruitment_flag = 1 AND ow.public_info_flag = 1
                AND ow.owner_status = 2 AND ur.display_flag = 1
                GROUP BY ur.owner_id";

        $query = $this->db->query($sql);
        if ($query && $r_array = $query->result_array()) {
            $ret = $r_array;
        }

        return $ret;
    }
    /* 急募情報投稿 */
    public function getUrgentRecruitmentsLatestPost($image_flag = 1) {
        $ret = null;

        if ($image_flag == 1) {
        $sql = "SELECT url.owner_id, url.ur_id, url.message, owr.id AS ors_id, ow.storename, url.posted_date as post_date, mt.name AS town_name,
                owr.salary,owr.con_to_apply, mjt.name AS job_name, owr.`main_image`, owr.`image1`, owr.`image2`, owr.`image3`, owr.`image4`, owr.`image5`, owr.`image6`";
        } else {
        $sql = "SELECT url.owner_id, url.ur_id, url.message, owr.id AS ors_id, ow.storename, url.posted_date as post_date, mt.name AS town_name,
                owr.salary,owr.con_to_apply, mjt.name AS job_name";
        }
        $sql.=" FROM urgent_recruitment_log url
                LEFT JOIN owners ow ON url.owner_id = ow.id AND ow.display_flag = 1
                LEFT JOIN owner_recruits owr ON url.owner_id = owr.owner_id AND owr.display_flag = 1
                LEFT jOIN job_type_owners jto ON owr.id = jto.owner_recruit_id
                LEFT jOIN mst_job_types mjt ON jto.job_type_id = mjt.id
                LEFT JOIN mst_towns mt ON owr.town_id = mt.id AND mt.display_flag = 1
                WHERE url.posted_date <= ? AND url.display_flag = 1 ORDER BY url.posted_date DESC LIMIT 10";
        $query = $this->db->query($sql, array(date('Y-m-d H:i:s')));
        if ($query && $results = $query->result_array()) {
            $ret = $results;
        }
        return $ret;
    }

    /**
     * Get all owners
     *
     * @param   null
     * @return  all owners info
     */
    public function get_all_owners(){
        $ret = null;
        $sql = "SELECT owr.id AS owner_recruit_id, ow.id AS owner_id FROM owners AS ow
                INNER JOIN owner_recruits AS owr ON ow.id = owr.owner_id
                WHERE ow.display_flag = 1 AND ow.owner_status = 2 AND ow.public_info_flag = 1 AND owr.display_flag = 1";
        $query = $this->db->query($sql);
        if ($results = $query->result_array()) {
            $ret = $results;
        }

        return $ret;
    }

    /**
     * Get messages exchanged between user and owner
     * @param owner id, user id, limit, offset
     * @return message info
     */
    public function get_user_owner_message_history($owner_id, $user_id, $nmu_id, $limit=0, $offset=0) {
        $ret = null;
        $params = array();
        // check parameters
        if (!$owner_id || (!$user_id && !$nmu_id)) {
            return $ret;
        }

        $sql = 'SELECT  luom.*, us.profile_pic, us.user_from_site
                FROM    list_user_owner_messages luom
                LEFT JOIN users us ON luom.user_id = us.id
                WHERE   luom.display_flag = 1 and luom.owner_id = ?';
        $params[] = $owner_id;
        if ($user_id && $user_id != 0) {
            $sql .= " AND luom.user_id = ? AND us.display_flag = 1";
            $params[] = $user_id;
        } elseif ($nmu_id && $nmu_id != 0) {
            $sql .= " AND luom.none_member_id = ?";
            $params[] = $nmu_id;
        }
        $sql .= " ORDER BY id DESC LIMIT ? OFFSET ?";
        $params[] = $limit;
        $params[] = $offset;
        $query = $this->db->query($sql, $params);
        if ($query && $query->result_array()) {
            $ret = $query->result_array();
        }
        return $ret;
    }


    /**
     * Get owner_category
     * @param int owner id
     * @return return data array
     */
    public function get_owner_category($id) {
        $sql = 'SELECT * FROM owner_category WHERE owner_id = ?';
        $query = $this->db->query($sql, array($id));
        return $query->result_array();
    }

    /**
     * Insert onwer data in owner category
     * @param int owner id
     * @return null
     */
    public function insert_owner_category($all_category, $id){
        $this->db->where('owner_id', $id);
        $this->db->delete('owner_category');
        foreach ($all_category as $value) {
           $data = array('owner_id' => $id, 'category_id' => $value, 'created_date' => date("y-m-d H:i:s"));
            $this->db->insert('owner_category', $data);
        }
    }

    public function get_owner_info($ownerId) {
        $sql = 'SELECT ow.id AS id, ow.owner_status ,owr.id AS orid, owr.main_image, owr.image1, owr.image2,
                owr.image3, owr.image4, owr.image5, owr.image6, owr.company_info,owr.apply_tel AS telephone,owr.title,ow.id AS owID, ow.storename,
                mcg.name AS group_name, mc.name AS city_name, mto.name AS town_name, owr.salary, ow.happy_money_type AS happy_money_type,
                ow.happy_money AS happy_money,mjt.name as jtname, ow.travel_expense_bonus_point,ow.trial_work_bonus_point,
                GROUP_CONCAT(mt.id ORDER BY mt.priority ASC) AS treatmentsID, GROUP_CONCAT(mt.name) AS treatmentsName
                FROM `owners` AS ow
                INNER JOIN `owner_recruits` AS owr ON ow.id = owr.owner_id
                INNER JOIN `mst_city_groups` AS mcg ON owr.city_group_id = mcg.id
                INNER JOIN `mst_cities` AS mc ON owr.city_id = mc.id
                INNER JOIN `mst_towns` AS mto ON owr.town_id = mto.id 
                INNER JOIN treatments_owners tro ON tro.owner_recruit_id = owr.id
                INNER JOIN mst_treatments mt ON mt.id = tro.treatment_id
                INNER JOIN job_type_owners jto ON jto.owner_recruit_id = owr.id
                INNER JOIN mst_job_types mjt ON jto.job_type_id = mjt.id
                WHERE ow.display_flag = 1 AND owr.display_flag = 1 AND owr.id = ?';
        $query = $this->db->query($sql, $ownerId);
        return $query->row_array();

    }

    /**
     * Get owner none read message from none member users
     * @param owner id
     * @return data array
     */
    public function get_count_none_member(){
        $get_date = date('Y-m-d H:i:s', strtotime('-3 day', strtotime(date('Y-m-d'))));
        $get_date_hr = date('Y-m-d H:i:s', strtotime('+18 hour', strtotime($get_date)));
        $sql = "SELECT SUM(CASE WHEN msg_from_flag = 0 THEN 1 ELSE 0 END) as count, luom.`owner_id`, ow.`email_address`
                FROM list_user_owner_messages AS luom
                INNER JOIN owners AS ow ON luom.`owner_id` = ow.`id`
                INNER JOIN owner_recruits AS ors ON ow.`id` = ors.`owner_id`
                WHERE luom.`is_read_flag` = 1 AND 
                      luom.`msg_from_flag` = 0 AND
                      luom.`display_flag` = 1 AND
                      ow.`display_flag` = 1 AND
                      ors.`display_flag` = 1 AND
                      ow.`set_send_mail` = 1 AND
                      ors.`recruit_status` = 2 AND
                      luom.`created_date` >= ?
                GROUP BY ow.`id`";
        $query = $this->db->query($sql, array($get_date_hr));
        return $query->result_array();
    }

    public function update_list_user_owner_messages($id, $msgid, $ar){
//        $this->db->where('id', $id);
        $this->db->or_where('id', $id);
        $this->db->or_where('id', $msgid);
        $res = $this->db->update('list_user_owner_messages', $ar);
        if ($res) {
            return true;
        }
        return false;
    }

}

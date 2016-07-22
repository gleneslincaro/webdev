<?php

class Musers extends CI_Model {

    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

    /**
     * @author  [IVS] VTAN
     * @name 	getOwnerIDByUserID
     * @todo 	getOwnerIDByUserID
     * @param 	$userId, $ownerId
     */
    public function getOwnerIDByUserID($listUId) {
        $sql = 'SELECT o.owner_id
                FROM owner_recruits o
                INNER JOIN list_user_messages lu
                ON lu.owner_recruit_id = o.id
                WHERE lu.id = ?
                AND  o.recruit_status = 2
                AND lu.`display_flag` = 1';
        $query = $this->db->query($sql, array($listUId));
        return $query->result_array();
    }

    /**
     * @author  [IVS] My Phuong Thi Le
     * @name 	count_Owners
     * @todo 	coumt total Owners
     * @param
     */
    public function count_Owners($owner_status=2) {
        $sql = 'SELECT * FROM owners OW
            INNER JOIN `owner_recruits` ORS
            ON OW.id = ORS.`owner_id`
            WHERE
            OW.`owner_status` IN ('.$owner_status.')
            AND OW.`display_flag`=1
            AND ORS.`display_flag`=1
            AND ORS.`recruit_status`=2
            AND OW.public_info_flag = 1';
        $query = $this->db->query($sql);
        return $count = $query->num_rows();
    }

    /**
     * @author  [IVS] My Phuong Thi Le
     * @name 	get_users
     * @todo 	get data users
     * @param 	id
     */
    public function get_users($id = null) {
        $sql = 'SELECT * FROM users WHERE display_flag = 1 and id = ?';
        $query = $this->db->query($sql, $id);
        return $query->row_array();
    }


    public function get_user($id) {
    	$sql = 'SELECT us.*, usrs.*, mh.*, mc.name AS cityName FROM users us
    			LEFT JOIN user_recruits usrs on (us.id = usrs.user_id and usrs.display_flag = 1)
    			LEFT JOIN mst_height mh on usrs.height_id = mh.id
    			LEFT JOIN mst_cities mc ON usrs.city_id = mc.id
    			WHERE us.display_flag = 1 and us.id = ?';
    	$query = $this->db->query($sql, $id);
    	return $query->row_array();
    }

    /**
     * @author  [IVS] My Phuong Thi Le
     * @name 	get_user_recruits
     * @todo 	get data user_recruits
     * @param 	id
     */
    public function get_user_recruits($id) {
        $sql = 'SELECT * FROM user_recruits WHERE user_id = ? AND display_flag=1';
        $query = $this->db->query($sql, array($id));
        return $query->row_array();
    }

    public function getUserScoutMailBonus0($userId) {
      $sql = "
            SELECT 
                IFNULL(SUM(money), 0) AS bonus_money
            FROM
                (SELECT 
                    bonus_requested_flag, SUM(IFNULL(point, 0)) AS money
                FROM
                    aruaru_bbs_points
                WHERE
                    user_id = $userId
                    AND validity = 1 
                    AND bonus_requested_flag = 0
                UNION SELECT 
                    bonus_requested_flag, IFNULL(bonus_money, 0) AS money
                FROM
                    scout_mail_bonus
                WHERE
                    user_id = $userId
                    AND display_flag = 1 
                UNION SELECT 
                    bonus_requested_flag, SUM(IFNULL(point, 0)) AS money
                FROM
                    bbs_points
                WHERE
                    user_id = $userId 
                    AND validity = 1
                    AND bonus_requested_flag = 0
                    ) AS t
            WHERE
                t.bonus_requested_flag = 0
          ";
      $query = $this->db->query($sql);
      return $query->row_array();
    }

    public function getUserScoutMailBonus1($userId, $limit) {
      $sql = "
            SELECT user_id, IFNULL(SUM(bonus_money), 0) as bonus_money, bonus_requested_flag, bonus_requested_date, received_bonus_flag, received_bonus_date
            FROM (
                SELECT user_id, bonus_money, bonus_requested_flag, bonus_requested_date, received_bonus_flag, received_bonus_date FROM scout_mail_bonus
                WHERE user_id = $userId
                AND display_flag = 1
                AND bonus_requested_flag = 1
                GROUP BY bonus_requested_date
            UNION
                SELECT user_id, SUM(point) as bonus_money, bonus_requested_flag, bonus_requested_date, received_bonus_flag, received_bonus_date FROM aruaru_bbs_points
                WHERE user_id = $userId
                AND validity = 1
                AND bonus_requested_flag = 1
                GROUP BY bonus_requested_date
            UNION
                SELECT user_id, SUM(point) as bonus_money, bonus_requested_flag, bonus_requested_date, received_bonus_flag, received_bonus_date FROM bbs_points
                WHERE user_id = $userId
                AND validity = 1
                AND bonus_requested_flag = 1
                GROUP BY bonus_requested_date
             ) x 
            GROUP BY bonus_requested_date
            ORDER BY bonus_requested_date DESC
                  LIMIT $limit
            ";

      $query = $this->db->query($sql);
       return $query->result_array();
    }
    // check if record for receiving bonus exits
    public function checkBonusRecordExist($userId){
      $ret = false;
      $sql = 'SELECT id FROM scout_mail_bonus
              WHERE user_id = ?
              AND display_flag = 1
              AND bonus_requested_flag = 0';
      $query = $this->db->query($sql, array($userId));
      if ( $query && $query->num_rows() > 0){
        $ret = true;
      }
      return $ret;
    }
    public function countUserScoutMailBonus1($userId) {
      $sql = 'SELECT count(smb.id) AS total from scout_mail_bonus AS smb
              WHERE smb.user_id = ?
              AND display_flag = 1
              AND bonus_requested_flag = 1';
      $query = $this->db->query($sql, array($userId));
      $row = $query->row_array();
      return $row['total'];
    }

    /**
     * @author  [IVS] My Phuong Thi Le
     * @name 	list_combobox
     * @todo 	load data combobox
     * @param 	table name
     */
    function list_combobox($tbl) {
        $sql = 'SELECT * FROM ' . $tbl . ' WHERE display_flag = 1';
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return 0;
    }
    /**
     * @author  [IVS] My Phuong Thi Le
     * @name 	list_combobox
     * @todo 	load data combobox
     * @param 	table name
     */
    function list_comboboxorderby($tbl) {
        $sql = 'SELECT * FROM ' . $tbl . ' WHERE display_flag = 1 order by amount';
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return 0;
    }
    /**
     * @author  [IVS] My Phuong Thi Le
     * @name 	list_JobType_name
     * @todo 	load JobType_name in job_type_users
     * @param 	id
     */
    function list_JobType_name($id) {
        $sql = "SELECT `mst_job_types`.`id`,`mst_job_types`.`name` FROM `mst_job_types` INNER JOIN `job_type_users` WHERE `mst_job_types`.`id`=`job_type_users`.`job_type_id` AND `job_type_users`.`user_id` = ? AND display_flag=1 ORDER BY priority ASC";
        $query = $this->db->query($sql, array($id));
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return 0;
    }

    /**
     * @author  [IVS] My Phuong Thi Le
     * @name 	list_JobType_name_not
     * @todo 	load JobType_name not in job_type_users
     * @param 	id
     */
    function list_JobType_name_not($id) {
        $sql = "SELECT id,name FROM mst_job_types WHERE id NOT IN (SELECT `mst_job_types`.`id` FROM `mst_job_types` INNER JOIN `job_type_users` WHERE `mst_job_types`.`id`=`job_type_users`.`job_type_id` AND `job_type_users`.`user_id` = ?) AND display_flag=1 ORDER BY priority ASC";
        $query = $this->db->query($sql, array($id));
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return 0;
    }

    /**
     * @author  [IVS] My Phuong Thi Le
     * @name 	list_jobType_name_all
     * @todo 	load all name of JobType_name
     * @param
     */
    function list_jobType_name_all() {
        $sql = "SELECT id,name FROM mst_job_types where display_flag=1 ORDER BY priority ASC ";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return 0;
    }

    /**
     * @author  [IVS] My Phuong Thi Le
     * @name 	radio_set_send_mail
     * @todo 	update send mail or not send mail
     * @param 	id
     */
    function radio_set_send_mail($id) {
        $sql = "SELECT `users`.`id`,`users`.`set_send_mail` FROM `users` WHERE `users`.`id`= ? AND display_flag=1";
        $query = $this->db->query($sql, array($id));
        return $query->row_array();
    }

    /**
     * @author  [IVS] My Phuong Thi Le
     * @name 	update_User
     * @todo 	update User
     * @param 	id,data
     */
    public function update_User($data, $id) {
        $this->db->where('id', $id);
        $this->db->update('users', $data);
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    public function updateUserFirstMessage($data, $id) {
      $this->db->where('id', $id);
      $this->db->update('list_user_owner_messages', $data);
      return ($this->db->affected_rows() != 1) ? false : true;
    }

    public function updateListUserMessagesActiveFlagTo0($id) {
      $this->db->where('id', $id);
      $this->db->update('list_user_messages', array('active_flag' => 0, 'scout_mail_open_date' => date('Y-m-d H:i:s')));
      if ( $this->db->affected_rows() >= 1 ){
        return true;
      }else{
        return false;
      }
    }

    public function updateUserScoutFlag($data, $oldId) {
      $this->db->where('remote_scout_flag',0);
      $this->db->where('md5(old_id)', $oldId);
      $this->db->update('users', $data);
      if ( $this->db->affected_rows() >= 1 ){
        return true;
      }else{
        return false;
      }
    }

    public function updateListUserMessage($hash, $orId, $userId, $list_user_msg_id=null) {
        $this->db->where('owner_recruit_id', $orId);
        $this->db->where('user_id', $userId);
        if ($list_user_msg_id) {
            $this->db->where('id', $list_user_msg_id);
        }
        $this->db->update('list_user_messages', $hash);
    }

    /**
     * @author  [IVS] My Phuong Thi Le
     * @name 	update_User_recruits
     * @todo 	update User_recruits
     * @param 	data, userid
     */
    public function update_User_recruits($data, $userid) {
        $this->db->where('user_id', $userid);
        $this->db->update('user_recruits', $data);
        return ($this->db->affected_rows() == 1) ? true : false;
    }

    /**
     * @author  [IVS] My Phuong Thi Le
     * @name 	insert_User_recruits
     * @todo 	insert_User_recruits
     * @param 	$data
     */
    public function insert_User_recruits($data) {
        $this->db->insert('user_recruits', $data);
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    public function insert_user_owner_message($data) {
    	$this->db->insert('list_user_owner_messages', $data);
    	return $this->db->insert_id();
    }

    /**
     * @author  [VJS]
     * @name    update_user_owner_message
     * @todo    update update_user_owner_message with msg id
     * @param   true: successs, false: failed
     */
    public function update_user_owner_message($data, $id) {
        $this->db->where('id', $id);
        $this->db->update('list_user_owner_messages', $data);
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    /**
     * @author  [VJS]
     * @name    get_unread_msg
     * @todo    get number of unread user messages of an owner
     * @param   number of unread msg
     */
    public function get_unread_msg($owner_id) {
        $ret = 0;
        if (!$owner_id) {
            return $ret;
        }

        // get number of unread messages
        $sql = 'SELECT count(id) as msg_no
                FROM list_user_owner_messages
                WHERE owner_id = ? and msg_from_flag = 0 and display_flag = 1 and is_read_flag = 1';
        $query = $this->db->query($sql, $owner_id);
        $row   = $query->row_array();
        if ($row) {
            $ret = $row['msg_no'];
        }
        return $ret;
    }

    public function updateUser($data, $id) {
      $this->db->where('id', $id);
      $this->db->update('users', $data);
      return ($this->db->affected_rows() > 0) ? true : false;
    }

    public function updateScoutMailBonus($data, $id = 0) {
      if ($id == 0) return;
      $this->db->where('id', $id);
      $this->db->update('scout_mail_bonus', $data);
      return ($this->db->affected_rows() > 0) ? true : false;
    }

    public function updateExternalSiteBonus($data, $user_id = 0, $bonus_requested_date = '') {
        if ($bonus_requested_date == '' || $user_id == 0) return;
        $tables = array(
                'aruaru_bbs_points', // aruaru points table
                'bbs_points'         // onayami points table
            );
        foreach ($tables as $table) {
            $this->db->where('bonus_requested_date', $bonus_requested_date);
            $this->db->where('user_id', $user_id);
            $this->db->update($table, $data);
        }
        return ($this->db->affected_rows() > 0) ? true : false;     
    }


    /**
     * @author  [IVS] My Phuong Thi Le
     * @name 	update_Job_type_users
     * @todo 	update Job_type_users
     * @param 	data, userid
     */
    public function update_Job_type_users($data, $userid) {
        $this->db->where('user_id', $userid);
        $this->db->update('job_type_users', $data);
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    /**
     * @author  [IVS] My Phuong Thi Le
     * @name 	insert_Job_type_users
     * @todo 	insert Job_type_users
     * @param 	user_id,job_type_id
     */
    public function insert_Job_type_users($user_id, $job_type_id) {
        $data = array(
            'user_id' => $user_id,
            'job_type_id' => $job_type_id,
        );
        $this->db->insert('job_type_users', $data);
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    /**
     * @author  [IVS] My Phuong Thi Le
     * @name 	delete_Job_type_users
     * @todo 	delete Job_type_users
     * @param 	user_id
     */
    public function delete_Job_type_users($user_id) {
        $this->db->where('user_id', $user_id);
        $this->db->delete('job_type_users');
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    /**
     * @author  [IVS] My Phuong Thi Le
     * @name 	insert_users
     * @todo 	insert_users
     * @param 	$data
     */
    public function insert_users($data) {

        $this->db->insert('users', $data);
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    /**
     * @author  [IVS] My Phuong Thi Le
     * @name 	insert_scout_message_spams
     * @todo 	insert to scout_message_spams
     * @param 	$userid,$ownerid
     */
    public function insert_scout_message_spams($userid, $ownerid) {
        // $this->db->insert('scout_message_spams',$data);
        $sql = 'INSERT INTO `scout_message_spams`(`user_id`,`owner_id`,`display_flag`) VALUE(' . $userid . ',' . $ownerid . ',1)';
        $query = $this->db->query($sql);
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    /**
     * @author  [IVS] My Phuong Thi Le
     * @name 	update_scout_message_spams
     * @todo 	update to scout_message_spams
     * @param 	$data,$userid,$ownerid
     */
    public function update_scout_message_spams($data, $userid, $ownerid) {
        $this->db->where('user_id', $userid);
        $this->db->where('owner_id', $ownerid);
        $this->db->update('scout_message_spams', $data);
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    /**
     * @author  [IVS] My Phuong Thi Le
     * @name 	insert_favorite_lists
     * @todo 	insert to favorite_lists
     * @param 	$userid,$ownerid
     */
    public function insert_favorite_lists($userid, $ownerid) {
        // $this->db->insert('scout_message_spams',$data);
        $sql = 'INSERT INTO `favorite_lists`(`user_id`,`owner_recruit_id`,`display_flag`) VALUE(' . $userid . ',' . $ownerid . ',1)';
        $query = $this->db->query($sql);
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    /**
     * @author  [IVS] My Phuong Thi Le
     * @name 	update_favorite_lists
     * @todo 	update to favorite_lists
     * @param 	$data,$userid,$ownerid
     */
    public function update_favorite_lists($data, $userid, $ownerid) {
        $this->db->where('user_id', $userid);
        $this->db->where('owner_recruit_id', $ownerid);
        $this->db->update('favorite_lists', $data);
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    /**
     * @author  [IVS] My Phuong Thi Le
     * @name 	get_keep
     * @todo 	get keep
     * @param 	$userid,$ownerid
     */
    public function get_keep($userid, $ownerid) {
        $sql = 'SELECT user_id,owner_recruit_id,display_flag FROM favorite_lists WHERE user_id = ? and owner_recruit_id=?';
        $query = $this->db->query($sql, array($userid, $ownerid));
        $row = $query->row_array();
        return $row['display_flag'];
    }

    /**
     * @author  [IVS] My Phuong Thi Le
     * @name 	check_keep
     * @todo 	check keep or clear keep
     * @param 	$userid,$ownerid
     */
    public function check_keep($userid, $ownerid) {
        $sql = 'SELECT count(*) as total FROM favorite_lists WHERE user_id = ?' . ' and owner_recruit_id=?';
        $query = $this->db->query($sql, array($userid, $ownerid));
        $row = $query->row_array();
        return $row['total'];
    }

    /**
     * @author  [IVS] My Phuong Thi Le
     * @name 	get_denial
     * @todo 	get denial
     * @param 	$userid,$ownerid
     */
    public function get_denial($userid, $ownerid) {
        $sql = 'SELECT user_id,owner_id,display_flag FROM scout_message_spams WHERE user_id = ?' . ' and owner_id=?';
        $query = $this->db->query($sql, array($userid, $ownerid));
        $row = $query->row_array();
        return $row['display_flag'];
    }

    /**
     * @author  [IVS] My Phuong Thi Le
     * @name 	check_denial
     * @todo 	check denial or not denial
     * @param 	$userid,$ownerid
     */
    public function check_denial($userid, $ownerid) {
        $sql = 'SELECT count(*) as total FROM scout_message_spams WHERE user_id = ?' . ' and owner_id=?';
        $query = $this->db->query($sql, array($userid, $ownerid));
        $row = $query->row_array();
        return $row['total'];
    }

    /**
     * @author  [IVS] My Phuong Thi Le
     * @name 	get_user_payments
     * @todo 	to keep application
     * @param 	$userid,$ownerid
     */
    public function get_user_payments($userid, $ownerid) {
        $sql = 'SELECT DISTINCT user_id,owner_recruit_id,user_payment_status,display_flag FROM user_payments WHERE user_id = ?' . ' and owner_recruit_id=?';
        $query = $this->db->query($sql, array($userid, $ownerid));
        $row = $query->row_array();
        return $row['user_payment_status'];
    }

    /**
     * @author  [IVS] My Phuong Thi Le
     * @name 	check_user_payments
     * @todo 	check to keep application
     * @param 	$userid,$ownerid
     */
    public function check_user_payments($userid, $ownerid) {
        $sql = 'SELECT count(*) as total FROM user_payments WHERE user_id = ?' . ' and owner_recruit_id=? AND display_flag = 1';
        $query = $this->db->query($sql, array($userid, $ownerid));
        $row = $query->row_array();
        return $row['total'];
    }

    /**
     * @author  [IVS] My Phuong Thi Le
     * @name 	insert_user_payments
     * @todo 	insert to user_payments
     * @param 	$userid,$ownerid
     */
    public function insert_user_payments($userid, $ownerid, $date) {
        // $this->db->insert('scout_message_spams',$data);
        $sql = 'INSERT INTO `user_payments`(`user_id`,`owner_recruit_id`,`user_payment_status`,apply_date,interview_date) VALUE(?,?,4,?,?)';
        $query = $this->db->query($sql, array($userid, $ownerid, $date, $date));
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    /**
     * @author  [IVS] My Phuong Thi Le
     * @name 	update_user_payments
     * @todo 	update to user_payments
     * @param 	$data,$userid,$ownerid,$date
     */
    public function update_user_payments($data, $userid, $ownerid) {
        $this->db->where('user_id', $userid);
        $this->db->where('owner_recruit_id', $ownerid);
        $this->db->update('user_payments', $data);
        return ($this->db->affected_rows() != 1) ? false : true;
    }
    /**
     * @author  [IVS] My Phuong Thi Le
     * @name 	get_by_email
     * @todo 	get_user by_email
     * @param 	$email
     */
    public function get_users_by_email($email = null) {
        $sql = 'SELECT * FROM users WHERE email_address = ? AND display_flag=1';
        $query = $this->db->query($sql, array($email));
        return $query->row_array();
    }

    /**
     * @author  [IVS] Nguyen Minh Ngoc
     * @name 	get_by_email
     * @todo 	get_user by_id
     * @param 	$email
     */
    public function get_users_by_id($id = null) {
        $sql = 'SELECT * FROM users WHERE id = ? AND display_flag=1';
        $query = $this->db->query($sql, array($id));
        return $query->row_array();
    }

    public function getUserByOldIdAndPassword($oldId = null, $password = null) {
        $ret = null;
        if ( $oldId && $password ){
            $sql = 'SELECT * FROM users WHERE md5(old_id) = ? AND display_flag=1';
            $query = $this->db->query($sql, array($oldId));
            if ( $query && $row = $query->row_array() ){
                if ( md5( base64_decode($row['password']) ) == $password ){
                    $ret = $query->row_array();
                }
            }
        }
        return $ret;
    }

    /**
     * @author  [IVS] My Phuong Thi Le
     * @name 	check_email
     * @todo 	check_email exit
     * @param 	$email
     */
    public function check_emailexit($email) {
        $sql = 'SELECT count(*) as total FROM users WHERE email_address = ? AND display_flag=1';
        $query = $this->db->query($sql, array($email));
        $row = $query->row_array();
        return $row['total'];
    }

    /**
     * @author  [IVS] My Phuong Thi Le
     * @name 	check_PASSexit
     * @todo 	check_pass
     * @param 	$email
     */
    public function check_emailpassexit($email, $pass) {
        $sql = 'SELECT count(*) as total FROM users WHERE email_address = ?' . ' and password =? AND display_flag=1';
        $query = $this->db->query($sql, array($email, $pass));
        $row = $query->row_array();
        return $row['total'];
    }

    public function checkRemoteLoginIdAndPassword($loginId, $password, $scoutFlag=null) {
        $ret = false;
        $sql = "SELECT password FROM users WHERE MD5(old_id) = ? AND display_flag=1 AND user_from_site != 0";
        if ( $scoutFlag ){
            $sql .= " AND remote_scout_flag = 1 ";
        }
        $query = $this->db->query($sql, array($loginId));
        if ($query && $query->num_rows() > 0)
        {
            $row = $query->row();
            if ( $password == md5( base64_decode( $row->password )) )
            {
                $ret = true;
            }
        }
        return $ret;
    }
    /**
     * @author  VJS
     * @name    checkIfUserInWaitingState
     * @todo    check if user is in waiting state or not
     * @param   $email
     */
    public function checkIfUserInWaitingState($loginId) {
        $ret = false;
        if ( $loginId ){
            $sql = "SELECT id FROM users
                    WHERE MD5(old_id) = ?
                    AND display_flag=1
                    AND user_status=4
                    AND user_from_site != 0
                    AND remote_scout_flag = 1 ";
            $query = $this->db->query($sql, array($loginId));
            if ($query && $query->num_rows() > 0)
            {
                $ret = true;
            }
        }
        return $ret;
    }
    /**
     * @author  [IVS] My Phuong Thi Le
     * @name 	check_email_user_status
     * @todo 	check_email and user_status=2 exit
     * @param 	$email
     */
    public function check_email_user_status($email, $pass) {
        $sql = 'SELECT count(*) as total FROM users WHERE email_address = ?' . ' and password =?' . ' and user_status =2';
        $query = $this->db->query($sql, array($email, $pass));
        $row = $query->row_array();
        return $row['total'];
    }

    /**
     * @author  [IVS] My Phuong Thi Le
     * @name 	check_email_user_status
     * @todo 	check_email and user_status=0 exit
     * @param 	$email
     */
    public function check_email_user_status0($email, $pass) {
        $sql = 'SELECT count(*) as total FROM users WHERE email_address = ?' . ' and password =?' . ' and user_status =0';
        $query = $this->db->query($sql, array($email, $pass));
        $row = $query->row_array();
        return $row['total'];
    }

    /**
     * @author  [IVS] My Phuong Thi Le
     * @name 	get_mst_templates
     * @todo 	get id
     * @param 	template_type
     */
    public function get_mst_templates($template_type = null) {
        $sql = 'SELECT * FROM mst_templates WHERE template_type = ? AND display_flag=1';
        $query = $this->db->query($sql, $template_type);
        $row = $query->row_array();
        return $row['id'];
    }

    /**
     * @author  [IVS] My Phuong Thi Le
     * @name 	get_mst_templatesb
     * @todo 	get title
     * @param 	template_type
     */
    public function get_mst_templatesb($template_type = null) {
        $sql = 'SELECT * FROM mst_templates WHERE template_type = ? AND display_flag=1';
        $query = $this->db->query($sql, $template_type);
        $row = $query->row_array();
        return $row['title'];
    }

    /**
     * @author  [IVS] My Phuong Thi Le
     * @name 	insert_list_user_messages
     * @todo 	insert to list_user_messages
     * @param 	$userid,$ownerid
     */
    public function insert_list_user_messages($userid, $ownerid, $date, $tempid) {
        // $this->db->insert('list_user_messages',$data);
        $sql = 'INSERT INTO `list_user_messages`(`user_id`,`owner_recruit_id`,`created_date`,updated_date,`template_id`,`user_message_status`) VALUE(?,?,?,?,?,0)';
        $query = $this->db->query($sql, array($userid, $ownerid, $date,$date, $tempid));
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    /**
     * @author  [IVS] My Phuong Thi Le
     * @name 	get_owner
     * @todo 	get owner
     * @param 	template_type
     */
    public function get_owner($ors_id = null) {
        $sql = 'SELECT * FROM owners WHERE id = ? AND display_flag=1';
        $query = $this->db->query($sql, $ors_id);
        return $query->row_array();
    }

    /**
     * @author  [IVS] My Phuong Thi Le
     * @name 	insert_list_owner_messages
     * @todo 	insert to list_owner_messages
     * @param 	$userid,$ownerid
     */
    public function insert_list_owner_messages($ownerid, $date, $tempid) {
        // $this->db->insert('list_owner_messages',$data);
        $sql = 'INSERT INTO `list_owner_messages`(`owner_id`,`template_id`,`created_date`,`display_flag`) VALUE(?,?,?,1)';
        $query = $this->db->query($sql, array($ownerid, $tempid, $date));
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    /**
     * @author  [IVS] Nguyen Ngoc Phuong
     * @name 	get Ownerid
     * @return 	owner id
     * @param 	$owner_recruits_id
     */
    public function getOwnerId($ors_id) {
        $sql = "SELECT `owner_id` FROM `owner_recruits` WHERE id=?";
        $query = $this->db->query($sql, array($ors_id));
        $row = $query->row_array();
        return $row['owner_id'];
    }

    /**
     * @author  [IVS] VTAn
     * @name 	get OwnerRecruitId
     * @return 	OwnerRecruitId
     * @param 	$id
     */
     public function getOwnerRecruitId($id) {
        $sql = "SELECT `owner_recruit_id` FROM `list_user_messages` WHERE id= ? AND display_flag=1";
        $query = $this->db->query($sql, array($id));
        $row = $query->row_array();
        return $row['owner_recruit_id'];
    }

    public function _getOwnerRecruitId($id) {
        $sql = "SELECT `owner_recruit_id` FROM `list_user_messages` WHERE id= ?";
        $query = $this->db->query($sql, array($id));
        $row = $query->row_array();
        return $row['owner_recruit_id'];
    }

    /**
     * @author  [IVS] Nguyen Ngoc Phuong
     * @name 	setSendMail
     * @return 	data
     * @param 	$user_id
     */
    public function setSendMail($user_id) {
        $sql = "SELECT set_send_mail FROM users WHERE id=? AND display_flag=1";
        $query = $this->db->query($sql, array($user_id));
        $row = $query->row_array();
        return $row['set_send_mail'];
    }

     /**
     * @author  [IVS] Lam Tu My Kieus
     * @name 	setSendMailUser
     * @return 	data
     * @param 	$user_id
     */
    public function setSendMailUser($user_id = null) {
        $sql = "SELECT set_send_mail FROM users WHERE id like ?";
        $query = $this->db->query($sql, $user_id);
        return $query->result_array();
    }


    /**
     * @author  [IVS] Nguyen Ngoc Phuong
     * @name 	setSendMail
     * @return 	owner id
     * @param 	$user_id
     */
    public function setSendMailOwner($owner_id) {
        $sql = "SELECT set_send_mail FROM owners WHERE id=?";
        $query = $this->db->query($sql, array($owner_id));
        $row = $query->row_array();
        return $row['set_send_mail'];
    }
      /**
     * @author  [IVS] Nguyen Ngoc Phuong
     * @name 	check_user_payments
     * @todo 	check to control page
     * @param 	$userid,$ownerid
     */
    public FUNCTION check_user_apply($userid, $ownerid) {
        $SQL = 'SELECT count(*) as total FROM user_payments WHERE user_id = ? and owner_recruit_id=? AND
              user_payments.`user_payment_status` NOT IN (2)';
        $QUERY = $this->db->QUERY($SQL, array($userid, $ownerid));
        $ROW = $QUERY->row_array();
        RETURN $ROW['total'];
    }
     /**
     * @author  [IVS] Nguyen Ngoc Phuong
     * @name 	check scout mail
     * @todo 	check scout mail
     * @param 	$userid,$ownerid
     */
    public function check_scout_mail($userid){
        $sql="SELECT COUNT(id)as quantity FROM `list_user_messages` LU WHERE
            LU.`is_read`=0 AND
            LU.`display_flag`=1 AND
            LU.`payment_message_status`=1
             AND (LU.`template_id` = 25 or LU.`template_id` = 63 or LU.`template_id` = 64)
            AND LU.`user_id`=? ";
       return $this->db->query($sql,array($userid))->row_array();
    }
    /**
     * @author  [IVS] Nguyen Ngoc Phuong
     * @name 	check interview mail
     * @todo 	check interview mail
     * @param 	$userid,$ownerid
     */
    public function check_interview_mail($userid){
        $sql="SELECT COUNT(id)as quantity FROM `list_user_messages` LU WHERE
            LU.`is_read`=0 AND
            LU.`display_flag`=1 AND
            LU.`payment_message_status`=1
             AND LU.`template_id` =29
            AND LU.`user_id`=? ";
       return $this->db->query($sql,array($userid))->row_array();
    }
    /**
     * @author  [IVS] Nguyen Ngoc Phuong
     * @name 	check new mail
     * @todo 	check new mail
     * @param 	$userid,$ownerid
     */
    public function check_new_mail($userid){
        $sql="SELECT COUNT(id)as quantity FROM `list_user_messages` LU WHERE
            LU.`is_read`=0 AND
            LU.`display_flag`=1 AND
            LU.`payment_message_status`=1
            AND LU.`template_id` IN (27,28,50)
            AND LU.`user_id`=? ";
       return $this->db->query($sql,array($userid))->row_array();
    }
    /**
     * @author  [IVS] Nguyen Ngoc Phuong
     * @name 	check happy money mail
     * @todo 	check happymoney mail
     * @param 	$userid,$ownerid
     */
    public function check_happymoney_mail($userid){
        $sql="SELECT COUNT(id)as quantity FROM `list_user_messages` LU WHERE
            LU.`is_read`=0 AND
            LU.`display_flag`=1 AND
            LU.`payment_message_status`=1
            AND LU.`template_id` IN (55,58)
            AND LU.`user_id`=? ";
       return $this->db->query($sql,array($userid))->row_array();
    }
    /**
     * @author  [IVS] Nguyen Ngoc Phuong
     * @name 	check take happy money
     * @todo 	check take happy money
     * @param 	$userid,$ownerid
     */
    public function check_take_happymoney($userid,$day_happy_money){
        $sql="SELECT
            COUNT(id) AS quantity
          FROM
            `user_payments` UP
          WHERE
          (UP.`user_payment_status` = 7 OR (UP.`user_payment_status` = 4 AND (DATE_ADD(UP.`interview_date`, INTERVAL ? HOUR) < CURRENT_TIMESTAMP)))
              AND UP.`user_id`=?
           ";
       return $this->db->query($sql,array($day_happy_money,$userid))->row_array();
    }
    /**
     * @author  VJS
     * @name    get city ID from city name (prefecture name)
     * @param   city name
     * @return  city id
     */
    public function getCityID($city_name) {
        $ret = null;

        $sql = "SELECT id FROM mst_cities WHERE name=? and display_flag = 1";
        $query = $this->db->query($sql, array($city_name));
        if ( $query ){
            $row = $query->row_array();
            if ( $row ){
                $ret = $row['id'];
            }
        }
        return $ret;
    }
    /**
     * @author  VJS
     * @name    get age ID from real age
     * @param   real age
     * @return  age id
     */
    public function getAgeID($real_age) {
        $ret = null;

        if ( $real_age && $real_age > 0 ){
            $sql = "SELECT id FROM mst_ages WHERE name2 >= ? and name1 <= ? and display_flag = 1";
            $query = $this->db->query($sql, array($real_age,$real_age));
            if ( $query ){
                $row = $query->row_array();
                if ( $row ){
                    $ret = $row['id'];
                }
            }
        }
        return $ret;
    }
    /**
     * @author  VJS
     * @name    get height ID from real height
     * @param   real height
     * @return  height id
     */
    public function getHeightID($real_height) {
        $ret = null;

        if ( $real_height && $real_height > 0 ){
            $sql = "SELECT id FROM mst_height
                    WHERE
                    name1 <= ? and display_flag = 1 and
                    case
                        when name2 > 0 then name2 >= ?
                        else 1=1
                    end
                    ";
            $query = $this->db->query($sql, array($real_height,$real_height));
            if ( $query ){
                $row = $query->row_array();
                if ( $row ){
                    $ret = $row['id'];
                }
            }
        }
        return $ret;
    }
    /**
     * @author  VJS
     * @name    get user ID from unique ID
     * @param   unique ID
     * @return  user id
     */
    public function getUserID($unique_id) {
        $ret = null;

        if ( $unique_id ){
            $sql = "SELECT id FROM users WHERE unique_id = ? and display_flag = 1";
            $query = $this->db->query($sql, array($unique_id));
            if ( $query ){
                $row = $query->row_array();
                if ( $row ){
                    $ret = $row['id'];
                }
            }
        }
        return $ret;
    }
    /**
     * @author  VJS
     * @name    get user ID from email
     * @param   user email
     * @return  user id
     */
    public function getUserIDFromEmail($email) {
        $ret = null;

        if ( $email ){
            $sql = "SELECT id FROM users
                    WHERE email_address = ? and display_flag = 1";
            $query = $this->db->query($sql, array($email));
            if ( $query ){
                $row = $query->row_array();
                if ( $row ){
                    $ret = $row['id'];
                }
            }
        }
        return $ret;
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
        $sql = 'SELECT email_address FROM users WHERE display_flag = 1 and email_address = ? ';
        $query = $this->db->query($sql, array($email));
        if ( $query && ($rows = $query->row_array()) && count($rows) > 0 ){
            $ret = true;
        }
        return $ret;
    }
    /**
     * @author: VJS
     * @name : getLastImportDate
     * @todo : get the last import date
     * @param null
     * @return last imported date
     */
    public function getLastImportDate() {
        $last_import_date = null;
        $sql = "Select Max(ifnull(updated_date,created_date)) as last_date from users where user_from_site <> 0 ";
        $result = $this->db->query($sql);
        if ( $result ){
            if ($result->num_rows() > 0){
                $row = $result->row();
                $last_import_date = $row->last_date;
            }
        }
        return $last_import_date;
    }

    public function getUserLoginIdAndPassByOrIdAndHash($hash, $orId = null) {
        $sql = 'SELECT u.old_id, u.password, u.last_visit_date,
                u.user_from_site, u.id AS user_id, l.id as lum_id, l.active_flag
                FROM list_user_messages l
                INNER JOIN users u ON (l.user_id = u.id AND u.display_flag = 1 AND u.user_status <> 2)
                WHERE l.u_hash = ?';
        $params[] = $hash;
        if ($orId) {
            $sql .= " AND l.owner_recruit_id = ?";
            $params[] = $orId;
        }
        $query = $this->db->query($sql, $params);
        return $query->row_array();
    }

        /**
     * @author: VJS
     * @name : addNewScoutMailBonus
     * @todo : add a new record for bonus data
     * @param  user id
     * @return TRUE: success, FALSE: failed
     */
    public function addNewScoutMailBonus($user_id){
        $ret = false;
        if ( $user_id ){
            $sql = 'INSERT INTO scout_mail_bonus
                    SET user_id = ?, bonus_money = 0, bonus_requested_flag = 0, received_bonus_flag =0, display_flag = 1, created_date = NOW() ';
            $query = $this->db->query($sql, array($user_id));
        }
        if ( $this->db->affected_rows() == 1 ){
            $ret = true;
        }
        return $ret;
    }
    /**
     * @author: VJS
     * @name : requestBonus
     * @todo : add data for new request to get bonus money
     * @param  user id
     * @return TRUE: success, FALSE: failed
     */
    public function requestBonus($user_id = 0){
       if ($user_id == 0) return false;
        $request_date = date('Y-m-d H:i:s');
        $sql = "UPDATE scout_mail_bonus
                SET bonus_requested_flag = 1,
                    bonus_requested_date = '$request_date'
                WHERE user_id = $user_id
                and bonus_requested_flag = 0
                and display_flag = 1 ";
        $query = $this->db->query($sql);
        $this->requestExternalSiteBonus($user_id, $request_date);
        if ( $this->db->affected_rows() == 1 ){
            return $this->addNewScoutMailBonus($user_id);
        }
    }
    /**
     * @name : requestExternalSiteBonus
     * @todo : request aruaru and onayami bonus for payout
     * @param  user_id, request_date
     * @return true: SUCCESS, false: FAILED
     */
    public function requestExternalSiteBonus($user_id = 0, $request_date = '') {
        if ($user_id ==0 || $request_date == '') return false;
        $tables = array(
            'aruaru_bbs_points', // aruaru points table
            'bbs_points'         // onayami points table
        );
        foreach ($tables as $table) {
            $data = array(
                    'bonus_requested_flag' => 1,
                    'bonus_requested_date' => "$request_date"
                );
            $this->db->where('bonus_requested_flag', 0);
            $this->db->where('user_id', $user_id);
            $this->db->where('validity', 1);
            $this->db->update($table, $data);
        }
        return ($this->db->affected_rows() > 0) ? true : false;     
    }
    /**
     * @author: VJS
     * @name : getBonusPointForScout
     * @todo : get bonus point when scout
     * @param  none
     * @return bonus point
     */
    public function getBonusPointForScout() {
      $point = 0;
      $sql = 'SELECT point
              FROM mst_scout_point
              WHERE display_flag = 1';
      $query = $this->db->query($sql);
      if ( $query && $row = $query->row_array() ){
        $point = $row['point'];
      }
      return $point;
    }
    /**
     * @author: VJS
     * @name : updateBonusPoint
     * @todo : update bonus point when user opens scout mail
     * @param  user_id: user id
     * @param  add_point: points to be added
     * @return true
     */
    public function updateBonusPoint($user_id, $add_point, $reason = "", $owner_id = null){
        $ret = false;
        if ( $user_id && $add_point ){
            // check if scout bonus record exits
            if ( !$this->checkBonusRecordExist($user_id) ){
                // if not, create a new record
                $this->addNewScoutMailBonus($user_id);
            }
            $sql = "Update scout_mail_bonus
                    SET bonus_money = bonus_money + ?, updated_date = NOW()
                    WHERE user_id = ? and bonus_requested_flag = 0
                    AND display_flag = 1 ";
            $result = $this->db->query($sql, array($add_point,$user_id));
            if ( $this->db->affected_rows() > 0 ){
                $ret = true;

                // add log
                $bonus_data = $this->getUserScoutMailBonus0( $user_id );
                $new_bonus_money = 0;
                if ( $bonus_data ) {
                  $new_bonus_money = $bonus_data['bonus_money'];
                  $old_bonus_money = (int)($new_bonus_money - $add_point);
                }

                $sql  = "INSERT INTO scout_mail_bonus_log SET ";
                $sql .= "user_id = ?, bonus_money = ?, old_bonus_money = ?, ";
                $sql .= "new_bonus_money = ?, reason = ?, created_date = NOW()";
                $params = array($user_id, $add_point, $old_bonus_money, $new_bonus_money, $reason);
                $this->db->query( $sql, $params );
                $this->checkAndUpdateCampaignProgress($user_id, $reason, $owner_id);
            }
        }
        return $ret;
    }
    /**
     * @author: VJS
     * @name : getUserIDFromMd5ID
     * @todo : get userID from md5 ID
     * @param  loginID: login to search for
     * @param  IDEncryptetFlag (true: ID is already encrypted, false: not encrypted)
     * @return user id
     */
    public function getUserIDFromMd5ID($loginID){
        $ret = null;
        if ( $loginID ){
            $sql = "SELECT id FROM users
                    WHERE display_flag = 1
                    AND md5(old_id) = ? ";
            $result = $this->db->query($sql, array($loginID));
            if ( $result && $row = $result->row_array() ){
                $ret = $row['id'];
            }
        }
        return $ret;
    }
    /**
     * @author: VJS
     * @name : checkUserExistFrom
     * @todo : check if a user is already registerd
     * @param  old id
     * @return TRUE: exist, FALSE: not existed
     */
    public function checkUserExistFrom($old_id){
        $ret = false;
        if ( $old_id ){
            $sql = "SELECT id FROM users
                    WHERE display_flag = 1
                    AND old_id = ? ";
            $result = $this->db->query($sql, array($old_id));
            if ( $result && $result->num_rows() > 0 ){
                $ret = true;
            }
        }
        return $ret;
    }
    /**
     * @author: VJS
     * @name : getUserIDFromOldID
     * @todo : get user id from old id
     * @param  old id
     * @return user id
     */
    public function getUserIDFromOldID($old_id){
        $ret = null;
        if ( $old_id ){
            $sql = "SELECT id FROM users
                    WHERE  display_flag = 1
                    AND    old_id = ? ";
            $result = $this->db->query($sql, array($old_id));
            if ( $result && $row = $result->row_array() ){
                $ret = $row['id'];
            }
        }
        return $ret;
    }
    /**
     * @author: VJS
     * @name : getUserInfoFromOldID
     * @todo : get user info from old id
     * @param  md5 of old id
     * @return user info
     */
    public function getUserInfoFromMd5OldID($md5_old_id){
        $ret = null;
        if ( $md5_old_id ){
            $sql = "SELECT * FROM users
                    WHERE  display_flag = 1
                    AND    md5(old_id) = ? ";
            $result = $this->db->query($sql, array($md5_old_id));
            if ( $result && $row = $result->row_array() ){
                $ret = $row;
            }
        }
        return $ret;
    }

    public function checkIfUserFirstTimeMessageToOwner($user_id) {
    	$ret = true;
    	$sql = "SELECT id FROM list_user_owner_messages
    	WHERE user_id = '$user_id'";
    	$query = $this->db->query($sql);
    	if ($query && $query->num_rows() > 1)
    		$ret = false;
    		return $ret;
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
    public function getByHash($hash){
            $sql  = "SELECT l.id as lum_id,l.user_id,l.owner_recruit_id,l.u_hash,l.active_flag,u.old_id,u.name,u.email_address
                     FROM list_user_messages AS l
                     LEFT JOIN users AS u ON u.id=l.user_id
                     WHERE l.u_hash = ?";
            $query = $this->db->query($sql,array($hash));
            return $query->row_array();
    }
    public function getNewsPoint() {
      $point = 0;
      $sql = 'SELECT point
              FROM mst_newsletter_point
              WHERE display_flag = 1';
      $query = $this->db->query($sql);
      if ( $query && $row = $query->row_array() ){
        $point = $row['point'];
      }
      return $point;
    }
	public function setMailTitleSs09($user_id,$lum_id){
		$sql = "SELECT lum.id,lum.user_id,lum.created_date,asml.mail_title
				FROM list_user_messages lum
				INNER JOIN admin_scout_mail_log asml ON lum.id=asml.list_user_message_id
				WHERE lum.user_id = ? AND lum.id = ?
				ORDER BY lum.created_date DESC
				";
		$query = $this->db->query($sql,array($user_id,$lum_id));
		return $query->row_array();
	}
    public function getHashByListUrMsgID($lst_ur_msg_id) {
        $ret_hash = "";
        $sql = "SELECT u_hash FROM list_user_messages WHERE id = ? LIMIT 1";
        $query = $this->db->query($sql, $lst_ur_msg_id);
        if ($query && $row = $query->row_array()) {
            $ret_hash = $row['u_hash'];
        }
        return $ret_hash;
    }
    public function getPeriodScoutOwnerlogQuery($dateFrom, $dateTo){
      $sql = '';
      if($dateFrom == '' && $dateTo != ''){
        $sql = "SELECT * from scout_owner_log WHERE DATE(visited_date) <= '".date('Y-m-d', strtotime($dateTo)) . "' ORDER BY id desc ";
      }elseif($dateTo == '' && $dateFrom != ''){
        $sql = "SELECT * from scout_owner_log WHERE DATE(visited_date) >= '". date('Y-m-d', strtotime($dateFrom)) . "' ORDER BY id desc ";
      }elseif($dateFrom == '' && $dateTo == ''){
        $sql = "SELECT * from scout_owner_log ORDER BY id desc ";
      }else{
        $sql = "SELECT * from scout_owner_log WHERE DATE(visited_date) BETWEEN '" .date('Y-m-d', strtotime($dateFrom))."' AND '" .date('Y-m-d', strtotime($dateTo))."' ORDER BY id desc ";
      }
      return $sql;
    }
    public function getSumPeriodScoutOwnerlog($dateFrom, $dateTo){
      $sql = '';
      if($dateFrom == '' && $dateTo != ''){
        $sql = "SELECT sum(access_point) as access_point from scout_owner_log WHERE DATE(visited_date) <= '".date('Y-m-d', strtotime($dateTo)) . "' ";
      }elseif($dateTo == '' && $dateFrom != ''){
        $sql = "SELECT sum(access_point) as access_point from scout_owner_log WHERE DATE(visited_date) >= '". date('Y-m-d', strtotime($dateFrom)) . "' ";
      }elseif($dateFrom == '' && $dateTo == ''){
        $sql = "SELECT sum(access_point) as access_point from scout_owner_log ";
      }else{
        $sql = "SELECT sum(access_point) as access_point from scout_owner_log WHERE DATE(visited_date) BETWEEN '" .date('Y-m-d', strtotime($dateFrom))."' AND '" .date('Y-m-d', strtotime($dateTo))."'";
      }
      $query = $this->db->query($sql);
      $ret = $query->row_array();
      return $ret;
    }
    public function getPeriodScoutOwnerlog($dateFrom, $dateTo, $sql){
      $query = $this->db->query($sql);
      $ret = $query->result_array();
      return $ret;
    }

    public function getUserCountOwnerlog($user_id, $owner_id, $accessPoint, $user_from_site){
        $ret = true;
        $now  = date('Y-m-d');
        if (!isset($accessPoint['page_limit']) || !$accessPoint['page_limit']) {
            return $ret;
        }
        $sql = "SELECT u.id, sol.owner_id, orc.owner_id orcOwnerId
        FROM users AS u
        LEFT JOIN scout_owner_log AS sol ON sol.user_id = u.id
        LEFT JOIN owner_recruits AS orc ON orc.owner_id = sol.owner_id
        WHERE u.id = ? AND u.user_from_site = ? AND u.display_flag = 1 AND orc.display_flag = 1 AND DATE(sol.visited_date) = ?";
        $query = $this->db->query($sql, array($user_id, $user_from_site, $now));
        $result = $query->result();
        if(count($result) < $accessPoint['page_limit']){
            $ret = false;
            foreach ($result as $key) {
                if($owner_id == $key->orcOwnerId){
                    $ret = true;
                    break;
                }
            }
        }
        return $ret;
    }

    public function insertUserCountOwnerlog($owner_id,$user_id, $accessPoint){
        $data = array('owner_id' => $owner_id, 'user_id' => $user_id, 'access_point' => $accessPoint, 'visited_date' => date("y-m-d H:i:s"));
        $this->db->insert('scout_owner_log', $data);
    }

    public function insertUserCountOwnerlogCookie($owner_id){
        $flag = false;
        if (isset($_COOKIE['joyspeaccess'])){

            $set_cookie_ar = array();
            $search_array = array();
            $search_array = $_COOKIE['joyspeaccess'];

            $nowtime = date("Y-m-d H:i:s",time());//現在時刻

            if (array_key_exists($owner_id,$search_array)){
                $from = $search_array[$owner_id];
                // 日時からタイムスタンプを作成
                $fromSec = strtotime($from);
                $toSec   = strtotime($nowtime);
                // 秒数の差分を求める
                $sec = $toSec - $fromSec;
                //5分経過していたらセット
                if($sec >= (60*5)){
                    $set_cookie_ar[$owner_id] = $nowtime;
                    $flag = true;
                }else{
                    $set_cookie_ar[$owner_id] = $search_array[$owner_id];
                }
                unset($search_array[$owner_id]);
            }else{
                $set_cookie_ar[$owner_id] = $nowtime;
                $flag = true;
            }
            $time_ar = $search_array;
            //登録分時間判定
            foreach($time_ar as $k => $v){
                $from = $v;
                $fromSec = strtotime($from);
                $toSec   = strtotime($nowtime);
                $sec = $toSec - $fromSec;
                if($sec < (60*5)){
                    $set_cookie_ar[$k] = $v;
                }
            }

            foreach($set_cookie_ar as $k => $v){
                setcookie("joyspeaccess[$k]","$v",time()+(60*5));
            }

        }else{
            $nowtime = date("Y-m-d H:i:s",time());//現在時刻
            setcookie("joyspeaccess[$owner_id]","$nowtime",time()+(60*5));
            $flag = true;
        }
        return $flag;
    }

    public function getUserSite($user_id) {
        $ret = null;
        $sql = "SELECT user_from_site FROM users where display_flag = 1 and id = ?";
        $query = $this->db->query($sql, array($user_id));
        if ($query && $row = $query->row_array()) {
          $ret = $row;
        }
        return $ret;
    }

    public function getNewStepUpCampaign($campaign_id) {
        $sql = "SELECT new_campaign_flag, budget_money, name, max_user_no, campaign1_valid_days, campaign2_start_date, campaign2_end_date,
                       campaign_retry_days, scout_bonus_mag_times, msg_bonus_mag_times, login_bonus_mag_times, more_info,
                       page_access_bonus_mag_times, interview_bonus_mag_times, created_date, max_interview_bonus_times, max_user_display_flg
                FROM mst_step_up_campaign
                WHERE display_flag = 1 AND id = ?";

        $query = $this->db->query($sql, array($campaign_id));
        return $query->row_array();
    }

    public function getStepUpCampaignRemainingSlot($campaign_id) {
        $sql = "SELECT COUNT(sucp.id) AS c_finish_user, mstuc.max_user_no
                FROM mst_step_up_campaign mstuc
                LEFT JOIN step_up_campaign_progress sucp ON mstuc.id = sucp.step_up_campaign_id  AND sucp.finish_flag = 1
                WHERE mstuc.id = ?";
        $query = $this->db->query($sql, array($campaign_id));
        return $query->row_array();
    }

    public function getLatestStepUpCampaign($new_campaign_flag) {
        $sql = "SELECT id, max_user_no, campaign2_start_date, campaign2_end_date, created_date FROM mst_step_up_campaign
                WHERE display_flag = 1 AND new_campaign_flag = ?";
        $query = $this->db->query($sql, array($new_campaign_flag));
        return $query->row_array();
    }

    public function checkUserHasNoLatestNewCampaignProgressData($user_id, $campaign_id) {
        $ret = false;
        $sql = "SELECT id FROM step_up_campaign_progress
                WHERE user_id = ? AND step_up_campaign_id = ?";
        $query = $this->db->query($sql, array($user_id, $campaign_id));
        if ( $query->num_rows() == 0) {
          $ret = true;
        }

        return $ret;
    }

    public function insertStepUpCampaignProgressData($data) {
        $this->db->insert('step_up_campaign_progress', $data);
    }

    public function checkCanAvailStepUpCampaign($step_up_campaign_id, $max_user_no) {
        $ret = false;
        $sql = "SELECT count(id) FROM step_up_campaign_progress
                WHERE step_up_campaign_id = ? AND finish_flag = 1";
        $query = $this->db->query($sql, array($step_up_campaign_id));
        if ( $query->num_rows() < $max_user_no) {
          $ret = true;
        }

        return $ret;
    }

    public function updateStepUpCampaignProgress($data, $id) {
        $this->db->where('id', $id);
        $this->db->update('step_up_campaign_progress', $data);
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    public function updateUserLoginNoOfDays($user_id) {
      $ret = 1;
      $hasLoginNoOfDays = $this->checkUserNoHasLoginNoOfDays($user_id);
      if($hasLoginNoOfDays) {
        $this->db->insert('user_login_day', array('user_id' => $user_id, 'days_of_login' => 1));
      }
      else {
        $sql = "SELECT days_of_login FROM user_login_day WHERE user_id = $user_id";
        $data = $this->db->query($sql)->row_array();
        $this->db->where('user_id', $user_id);
        $days_of_login = $data['days_of_login'] + 1;
        $this->db->update('user_login_day', array('days_of_login' => $days_of_login));
        $ret = $days_of_login;
      }
      return $ret;
    }

    public function checkUserNoHasLoginNoOfDays($user_id) {
      $ret = false;
      $sql = "SELECT id FROM user_login_day
              WHERE user_id = $user_id";
      $query = $this->db->query($sql);
      if($query->num_rows() == 0) {
        $ret = true;
      }
      return $ret;
    }

    public function getLoginBonusPoint($no_of_days) {
      $sql = "SELECT bonus_point FROM mst_point_login_bonus
              WHERE display_flag = 1 and number_of_days = ?";
      $query = $this->db->query($sql, array($no_of_days));
      return $query->row_array();
    }

    public function insertUserLoginLog($user_id) {
      $this->db->insert('user_login_log', array('user_id' => $user_id, 'login_time' => date('Y-m-d H:i:s', now())));
    }


    // add a new step up campaign progress data
    public function startJoinACampaign($user_id, $campaign_id) {
        $ret = false;
        if (!$user_id || !$campaign_id) {
            return $ret;
        }
        $data_not_exist = $this->checkUserHasNoLatestNewCampaignProgressData($user_id, $campaign_id);
        if ($data_not_exist == false) { // already exist, no need to create new one
            return true;
        }
        $data = array('step_up_campaign_id' => $campaign_id,
        'user_id' => $user_id,
        'campaign_join_date' => date('Y-m-d H:i:s'));
        $this->db->insert('step_up_campaign_progress', $data);
        $ret = $this->db->affected_rows() > 0 ? true : false;
        if ($ret) {
            // reset days of login to allow gettting new login bonus round
            $this->db->where('user_id', $user_id);
            $this->db->update('user_login_day', array('days_of_login' => 0));

            // just in case, stop other joining campaign data if any
            $this->db->where('step_up_campaign_id != ', $campaign_id, false);
            $this->db->where('user_id', $user_id);
            $this->db->update('step_up_campaign_progress', array('finish_flag' => 1));
        }

        return $ret;
    }

    // check if user can join any step up campaign
    // return value: valid campaign_id
    public function canJoinStepUpCampaign($user_id) {
        if (!$user_id) {
            return null;
        }
        // check if user can join new campaign(新規)
        $sql  = 'SELECT msuc.id FROM mst_step_up_campaign msuc, users us ';
        $sql .= 'WHERE us.id = ? AND ';
        $sql .= ' DATE(DATE_ADD(us.offcial_reg_date, interval (msuc.campaign1_valid_days + msuc.campaign_retry_days) day)) >= DATE(now()) ';
        $sql .= ' AND msuc.display_flag = 1 and msuc.new_campaign_flag = 1 ';
        $sql .= ' AND msuc.id not in ';
        $sql .= '   (SELECT step_up_campaign_id FROM step_up_campaign_progress WHERE user_id = ? and finish_flag = 1) ';
        $sql .= 'ORDER BY msuc.id DESC ';
        $sql .= 'LIMIT 1';
        $query = $this->db->query($sql, array($user_id, $user_id));
        if ($query) {
            $row = $query->row_array();
            if (isset($row['id'])) {
                return $row['id']; // new campaign ID
            }
        }

        // check if user can join existing campaing(既存)
        $sql  = 'SELECT msuc.id ';
        $sql .= 'FROM mst_step_up_campaign msuc ';
        $sql .= 'WHERE (DATE(now()) BETWEEN DATE(msuc.campaign2_start_date) ';
        $sql .= '  AND DATE(DATE_ADD(msuc.campaign2_end_date, interval msuc.campaign_retry_days day))) ';
        $sql .= '  AND msuc.display_flag = 1 and msuc.new_campaign_flag = 0 ';
        $sql .= '  AND msuc.id not in ';
        $sql .= '    (SELECT step_up_campaign_id FROM step_up_campaign_progress WHERE user_id = ? and finish_flag = 1) ';
        $sql .= 'ORDER BY msuc.id DESC ';
        $sql .= 'LIMIT 1';
        $query = $this->db->query($sql, $user_id);
        if ($query) {
            $row = $query->row_array();
            if (isset($row['id'])) {
                return $row['id']; // existing campaign ID
            }
        }

        return null;
    }

    // update all steps status
    public function checkAndUpdateCampaignProgress($user_id, $reason = null, $owner_id = null) {
        if (!$user_id) {
            return;
        }
        // check if user is in any campaign
        $campaign_id = $this->canJoinStepUpCampaign($user_id);
        if (!$campaign_id) {
            return;
        }

        $data_not_exit = $this->checkUserHasNoLatestNewCampaignProgressData($user_id, $campaign_id);
        if ($data_not_exit) { // if not exist, no need to update
            return;
        }

        // update data
        $data = array();
        if (!$reason) {// if not reason, update all
            // check if step 1 is finished
            if ($this->_checkStep1($user_id, $campaign_id)) {
                $data['step1_fin_flag'] = 1; // finish step 1
            }
            // check if step 2 is finished
            if ($this->_checkStep2($user_id, $campaign_id)) {
                $data['step2_fin_flag'] = 1; // finish step 2
            }
            // check if step 3 is finished
            if ($this->_checkStep3($user_id, $campaign_id)) {
                $data['step3_fin_flag'] = 1; // finish step 3
            }
            // check if step 4 is finished
            if ($this->_checkStep4($user_id, $campaign_id)) {
                $data['step4_fin_flag'] = 1; // finish step 4
            }
            // check if step 5 is finished
            if ($this->_checkStep5($user_id, $campaign_id)) {
                $data['step5_fin_flag'] = 1; // finish step 5
            }
        } else {
            switch($reason) {
            case BONUS_REASON_OPEN_SCOUT_MAIL:
                // check if step 1 is finished
                if ($this->_checkStep1($user_id, $campaign_id)) {
                    $data['step1_fin_flag'] = 1; // finish step 1
                }
            break;

            case BONUS_REASON_FIRST_MSG:
                // check if step 2 is finished
                if ($this->_checkStep2($user_id, $campaign_id)) {
                    $data['step2_fin_flag'] = 1; // finish step 2
                }
            break;

            case BONUS_REASON_LOGIN:
                // check if step 3 is finished
                if ($this->_checkStep3($user_id, $campaign_id)) {
                    $data['step3_fin_flag'] = 1; // finish step 3
                }
            break;

            case BONUS_REASON_PAGE_ACCESS:
                // check if step 4 is finished
                if ($this->_checkStep4($user_id, $campaign_id)) {
                        $data['step4_fin_flag'] = 1; // finish step 4
                }
            break;

            case BONUS_REASON_INTERVIEW:
                // update number of interview
                $update_flag = $this->_updateNoOfInterView($campaign_id, $user_id, $owner_id);
                // check if step 5 is finished
                if ($update_flag && $this->_checkStep5($user_id, $campaign_id)) {
                    $data['step5_fin_flag'] = 1; // finish step 5
                }

            break;
            } //  end switch
        }

        // update step_up_campaign_progress
        if ($data && count($data) > 0) {
            $this->db->where('step_up_campaign_id', $campaign_id);
            $this->db->where('user_id', $user_id);
            $this->db->where('finish_flag', 0);
            $this->db->where('display_flag', 1);
            $this->db->update('step_up_campaign_progress', $data);
        }
    }

    private function _updateNoOfInterView($campaign_id, $user_id, $owner_id) {
        $ret = false;
        if (!$campaign_id || !$user_id || !$owner_id) {
            return false;
        }
        $sql_owner_count = "SELECT 1 FROM owners WHERE id = ? AND travel_expense_bonus_point = 0";
        $query = $this->db->query($sql_owner_count, array($owner_id));
        if ($query->num_rows() > 0) {
            $sql  = "UPDATE step_up_campaign_progress SET no_of_interviews = no_of_interviews + 1 ";
            $sql .= 'WHERE step_up_campaign_id = ? AND user_id = ? ';
            $sql .='AND finish_flag = 0 AND display_flag = 1 ';
            $sql .='AND (no_of_interviews + 1) <= ';
            $sql .='(SELECT max_interview_bonus_times FROM mst_step_up_campaign WHERE id = ? )';
            $query = $this->db->query($sql, array($campaign_id, $user_id, $campaign_id));
            $ret = true;
        }
        return $ret;
    }
    // check if user completed step1
    private function _checkStep1($user_id, $campaign_id) {
        $ret = false;
        $sql  = "SELECT 1 FROM list_user_messages lum ";
        $sql .= "INNER JOIN step_up_campaign_progress sucp ";
        $sql .= " ON (sucp.user_id = lum.user_id AND sucp.display_flag = 1 ";
        $sql .= "     AND sucp.finish_flag = 0 AND sucp.step_up_campaign_id = ? AND sucp.step1_fin_flag = 0) ";
        $sql .= "WHERE lum.user_id = ? and lum.active_flag = 0 AND lum.created_date > sucp.campaign_join_date AND lum.display_flag = 1 LIMIT 1 ";
        $query = $this->db->query($sql, array($campaign_id, $user_id));
        if ($query && $row = $query->row_array()) {
            $ret = true; // completed
        }
        return $ret;
    }
    // check if user completed step2
    private function _checkStep2($user_id, $campaign_id) {
        $ret = false;
        $sql  = "SELECT 1 FROM list_user_owner_messages luom ";
        $sql .= "INNER JOIN step_up_campaign_progress sucp ";
        $sql .= " ON (sucp.user_id = luom.user_id AND sucp.display_flag = 1 AND sucp.finish_flag = 0
        AND sucp.step_up_campaign_id = ? AND sucp.step2_fin_flag = 0) ";
        $sql .= "WHERE luom.user_id = ? AND luom.msg_from_flag = 0 AND luom.created_date > sucp.campaign_join_date AND luom.display_flag = 1 LIMIT 1";
        $query = $this->db->query($sql, array($campaign_id, $user_id));
        if ($query && $row = $query->row_array()) {
            $ret = true; // completed
        }
        return $ret;
    }
    // check if user completed step3
    private function _checkStep3($user_id, $campaign_id) {
        $ret = false;
        $sql  = "SELECT count(1) as login_no FROM ( ";
        $sql .= "SELECT 1 FROM user_login_log ull ";
        $sql .= "INNER JOIN step_up_campaign_progress sucp ";
        $sql .= " ON (sucp.user_id = ull.user_id AND sucp.display_flag = 1 AND
        sucp.finish_flag = 0 AND sucp.step_up_campaign_id = ? AND sucp.step3_fin_flag = 0) ";
        $sql .= "WHERE ull.user_id = ? AND ull.login_time >= sucp.campaign_join_date ";
        $sql .= "GROUP BY DATE(ull.login_time)";
        $sql .= ") tmp";
        $query = $this->db->query($sql, array($campaign_id, $user_id));
        if ($query && $row = $query->row_array()) {
            if($row['login_no'] >= MISSION_LOGIN_DAYS) {
                $ret = true; // completed
            }
        }
        return $ret;
    }
    // check if user completed step4
    private function _checkStep4($user_id, $campaign_id) {
        $ret = false;
        $sql  = "SELECT count(1) as access_days FROM ( ";
        $sql .= "SELECT 1, count(DATE(sol_sub.visited_date)) as access_per_day FROM ";
        $sql .= "(
                    SELECT sol.visited_date FROM scout_owner_log sol
                    INNER JOIN step_up_campaign_progress sucp
                    ON (sucp.user_id = sol.user_id AND sucp.display_flag = 1 AND
                    sucp.finish_flag = 0 AND sucp.step_up_campaign_id = ? AND sucp.step4_fin_flag = 0)
                    WHERE sol.user_id = ? AND sol.visited_date > sucp.campaign_join_date
                    group by owner_id, DATE(sol.visited_date)
                ) sol_sub ";
        $sql .= "GROUP BY DATE(sol_sub.visited_date)";
        $sql .= " ) tmp WHERE tmp.access_per_day >= 3"; // at least 3 times a day
        $query = $this->db->query($sql, array($campaign_id, $user_id));
        if ($query && $row = $query->row_array()) {
            if ($row['access_days'] >= MISSION_ACCESS_PAGE_DAYS) {
                $ret = true; // completed
            }
        }
        return $ret;
    }
    // check if user completed step5
    private function _checkStep5($user_id, $campaign_id) {
        $ret = false;
        $sql = "SELECT 1 FROM travel_expense_list tel ";
        $sql .= "INNER JOIN step_up_campaign_progress sucp ";
        $sql .= " ON (sucp.user_id = tel.user_id AND sucp.display_flag = 1 AND
        sucp.finish_flag = 0 AND sucp.step_up_campaign_id = ? AND sucp.step5_fin_flag = 0) ";
        $sql .= "WHERE tel.user_id = ? AND tel.requested_date >= sucp.campaign_join_date AND tel.status = 3 ";
        $query = $this->db->query($sql, array($campaign_id, $user_id));
        if ($query && $row = $query->row_array()) {
            $ret = true; // completed
        }
        return $ret;
    }

    // check if user is joining a campaign
    public function isUserInCampaign($user_id) {
        if (!$user_id) {
            return false;
        }
        $ret = false;
        $sql  = "SELECT 1 FROM step_up_campaign_progress sucp ";
        $sql .= "INNER JOIN mst_step_up_campaign msuc ";
        $sql .= "  ON (sucp.step_up_campaign_id = msuc.id AND msuc.display_flag = 1) ";
        $sql .= "WHERE sucp.user_id = ? AND sucp.display_flag = 1 AND sucp.finish_flag = 0 ";
        $query = $this->db->query($sql, $user_id);
        if ($query && $query->row_array()) {
            $ret = true;
        }
        return $ret;
    }

    // get current joining campaign data
    public function getCurStepUpCampaign($user_id) {
        if (!$user_id) {
            return null;
        }
        $ret = null;
        $sql  = "SELECT sucp.* FROM step_up_campaign_progress sucp ";
        $sql .= "INNER JOIN mst_step_up_campaign msuc ";
        $sql .= "  ON (sucp.step_up_campaign_id = msuc.id AND msuc.display_flag = 1) ";
        $sql .= "WHERE sucp.user_id = ? AND sucp.display_flag = 1 AND sucp.finish_flag = 0 ";
        $query = $this->db->query($sql, $user_id);
        if ($query && $row = $query->row_array()) {
            $ret = $row;
        }
        return $ret;
    }

    // check if first message after a specific date
    public function isFirstMessageSinceJoinedCampaign($user_id, $campaign_join_date) {
        $ret = false;
        if (!$user_id || !$campaign_join_date) {
            return $ret;
        }

        $sql  = "SELECT count(1) as msg_cnt FROM list_user_owner_messages ";
        $sql .= "WHERE user_id = ? AND created_date > ? ";
        $sql .= "AND msg_from_flag = 0 ";
        $sql .= "AND display_flag = 1 ";
        $query = $this->db->query($sql, array($user_id, $campaign_join_date));
        if ($query && $row = $query->row_array()) {
            if($row['msg_cnt'] == 1) {
                $ret = true;
            }
        }

        return $ret;
    }
    public function getNewStepUpCampaignProgress($user_id, $campaign_id) {
        $sql = "SELECT sucp.id, sucp.step_up_campaign_id, sucp.campaign_join_date, sucp.step1_fin_flag, sucp.step2_fin_flag, sucp.request_money_flag,
                       sucp.step3_fin_flag, sucp.step4_fin_flag, sucp.step5_fin_flag, sucp.finish_flag, sucp.no_of_interviews, sucp.finish_flag, us.offcial_reg_date
                FROM step_up_campaign_progress sucp
                INNER JOIN users us ON sucp.user_id = us.id
                WHERE sucp.display_flag = 1 AND sucp.user_id = ? AND sucp.step_up_campaign_id = ?";
        $query = $this->db->query($sql, array($user_id, $campaign_id));
        return $query->row_array();
    }

    public function getCampaignBonus($user_id, $reason, $campaign_join_date) {
        $ret_bonus_point = 0;
        if (!$user_id || !$reason || !$campaign_join_date) {
            return 0;
        }
        switch ($reason) {
            case BONUS_REASON_OPEN_SCOUT_MAIL:
                $sql  = "SELECT sum(bonus_money) AS bonus_money ";
                $sql .= "FROM scout_mail_bonus_log WHERE user_id = ? AND reason = ? AND created_date >= ?";
                $query = $this->db->query($sql, array($user_id, $reason, $campaign_join_date));
                if ($query && $row = $query->row_array()) {
                    $ret_bonus_point = $row['bonus_money'];
                }
                break;
            case BONUS_REASON_FIRST_MSG:
                $ret_bonus_point = 100; //default point for 1 message
                break;
            case BONUS_REASON_LOGIN:
                $sql  = "SELECT sum(bonus_point) as bonus_money FROM mst_point_login_bonus ";
                $sql .= " WHERE display_flag = 1 AND number_of_days <= ?";
                $query = $this->db->query($sql, MISSION_LOGIN_DAYS);
                if ($query && $row = $query->row_array()) {
                    $ret_bonus_point = $row['bonus_money'];
                }
                break;
            case BONUS_REASON_PAGE_ACCESS:
                $sql  = "SELECT page_limit, page_point FROM mst_point_access ";
                $sql .= " WHERE display_flag = 1 LIMIT 1";
                $query = $this->db->query($sql);
                if ($query && $row = $query->row_array()) {
                    if ($row['page_limit'] && $row['page_point']) {
                        $ret_bonus_point = MISSION_ACCESS_PAGE_DAYS * ($row['page_limit'] * $row['page_point']);
                    }
                }
                break;
            case BONUS_REASON_INTERVIEW:
                $sql  = "SELECT travel_expense FROM campaign_list ";
                $sql .= "WHERE display_flag = 1 AND start_date <= ? ";
                $sql .= "ORDER BY id DESC LIMIT 1";
                $query = $this->db->query($sql, array($campaign_join_date));
                if ($query && $row = $query->row_array()) {
                    $ret_bonus_point = $row['travel_expense'];
                }
                break;
        }

        return $ret_bonus_point;
    }

    // get all travel expense paid to user in the campaign
    public function getTotalTravelExpensePaid($campaign_id, $user_id) {
        if (!$campaign_id || !$user_id) {
            return 0;
        }
        $paid_travel_expense = 0;

        $sql  = "SELECT sum(smbl.bonus_money) AS paid_bonus_money FROM scout_mail_bonus_log smbl ";
        $sql .= " INNER JOIN step_up_campaign_progress sucp ";
        $sql .= " ON (sucp.user_id = smbl.user_id AND sucp.display_flag = 1 AND ";
        $sql .= " sucp.finish_flag = 0 AND sucp.step_up_campaign_id = ? AND ";
        $sql .= " smbl.created_date >= sucp.campaign_join_date ) ";
        $sql .= " WHERE smbl.user_id = ? AND smbl.reason = ? ";
        $query = $this->db->query($sql, array($campaign_id, $user_id, BONUS_REASON_INTERVIEW));

        if ($query && $row = $query->row_array()) {
            $paid_travel_expense = $row['paid_bonus_money'];
        }

        return $paid_travel_expense;
    }
    public function getUserTotalLoginDaysAchieved($campaign_id, $user_id) {
        $ret = 0;
        $sql = "SELECT COUNT(1) AS login_no FROM (
            SELECT 1 FROM user_login_log ull
            INNER JOIN step_up_campaign_progress sucp
            ON (sucp.user_id = ull.user_id AND sucp.display_flag = 1 AND
            sucp.finish_flag = 0 AND sucp.step_up_campaign_id = ? AND sucp.step3_fin_flag = 0)
            WHERE ull.user_id = ? AND ull.login_time >= sucp.campaign_join_date
            GROUP BY DATE(ull.login_time)) tmp ";
        $query = $this->db->query($sql, array($campaign_id, $user_id));
        if ($query && $row = $query->row_array()) {
            $ret = $row['login_no'];
        }
        return $ret;
    }

    public function getUserPageAccessDaysAchieved($campaign_id, $user_id) {
        $ret = 0;
        $sql = "SELECT COUNT(1) AS access_days FROM (
            SELECT 1, COUNT(DATE(sol_sub.visited_date)) AS access_per_day FROM
            (
                SELECT sol.visited_date FROM scout_owner_log sol
                INNER JOIN step_up_campaign_progress sucp
                ON (sucp.user_id = sol.user_id AND sucp.display_flag = 1 AND
                sucp.finish_flag = 0 AND sucp.step_up_campaign_id = ? AND sucp.step4_fin_flag = 0)
                WHERE sol.user_id = ? AND sol.visited_date > sucp.campaign_join_date
                group by owner_id, DATE(sol.visited_date)
            ) sol_sub
            GROUP BY DATE(sol_sub.visited_date)) tmp WHERE tmp.access_per_day >= 3";
        $query = $this->db->query($sql, array($campaign_id, $user_id));
        if ($query && $row = $query->row_array()) {
            $ret = $row['access_days'];
        }
        return $ret;
    }
    //get the interviewer of the company
    public function getInterviewer($ors_id) {
        $sql = "SELECT oi.owner_id,oi.interviewer_photo,oi.description,
                oi.age,oi.gender,oi.hobby ,owr.id, oi.interviewer_name
                FROM owner_interviewer oi
                LEFT JOIN owner_recruits owr ON oi.owner_id = owr.owner_id
                WHERE owr.id = ? AND oi.display_flag = 1
                LIMIT 1";
        $query = $this->db->query($sql,array($ors_id));
        $ret = $query->row_array();
        return $ret;
    }

    // ページの交通費リクエスト取得
    public function getUserBonusCampaign($req_per_page = 1, $start_offset = 0, $filter_status = "", $user_id = "") {
        $all_request_data = null;
        if ( $req_per_page < 0 || $start_offset < 0 ) {
            return $all_request_data;
        }
        $sql ="SELECT
                tel.id as req_id,
                tel.user_id as user_id,
                us.user_from_site as u_from_site,
                us.name as u_name,
                ow.unique_id as o_unique_id,
                ow.storename as o_shop_name,
                tel.requested_date as req_date,
                tel.status as req_status,
                '面接' as classification
            FROM travel_expense_list tel
            INNER JOIN users us ON us.id = tel.user_id
            INNER JOIN owners ow ON ow.id = tel.owner_id
            WHERE tel.display_flag = 1 AND us.id=?";
        $params[] = $user_id;

        $sql .="UNION
            SELECT
                camp.id as req_id,
                camp.user_id as user_id,
                us.user_from_site as u_from_site,
                us.name as u_name,
                ow.unique_id as o_unique_id,
                ow.storename as o_shop_name,
                camp.requested_date as req_date,
                camp.status as req_status,
                '入店' as classification
            FROM campaign_bonus_request_list camp
            INNER JOIN users us ON us.id = camp.user_id
            INNER JOIN owners ow ON ow.id = camp.owner_id
            WHERE camp.display_flag = 1 AND us.id=?";
            $params[] = $user_id;

        if ($filter_status) {
            if ( $filter_status == 1 /* 承認待ち */) {
                $sql .= "AND (tel.status = 0 OR tel.status = 1) ";
            } else {
                $sql .= "AND tel.status = ? ";
                $params[] = (int)$filter_status;
            }
        }
        //$sql .= " ORDER BY tel.id DESC, tel.user_id ";
        $sql .= " LIMIT ? OFFSET ? ";
        $params[] = $req_per_page;
        $params[] = $start_offset;

        $query = $this->db->query( $sql, $params );
        if ( $query && $all_data = $query->result_array() ) {
            $all_request_data = $all_data;
        }

        return $all_request_data;
    }

    public function getAllRequestNo($filter_status = "" , $user_id = "") {
        if ($user_id) {
            $this->db->where('user_id',$user_id);
        }
        if ($filter_status) {
            if ($filter_status == 1 /* 承認待ち */) {
                $add_where = "(status = 0 OR status = 1)";
                $this->db->where($add_where);
            } else {
                $this->db->where('status', (int)$filter_status);
            }
        }
        $this->db->where('display_flag', '1');
        $this->db->from('travel_expense_list');
        $total = $this->db->count_all_results();

        if ($user_id) {
            $this->db->where('user_id',$user_id);
        }
        if ($filter_status) {
            if ($filter_status == 1 /* 承認待ち */) {
                $add_where = "(status = 0 OR status = 1)";
                $this->db->where($add_where);
            } else {
                $this->db->where('status', (int)$filter_status);
            }
        }
        $this->db->from('campaign_bonus_request_list');
        $total += $this->db->count_all_results();
        return $total;
    }

    public function countExchangeConversation($user_id,$owrs_id){
        $sql = 'SELECT COUNT(1) AS count_conversation FROM list_user_owner_messages luom
                INNER JOIN owner_recruits owrs ON luom.owner_id = owrs.owner_id
                WHERE luom.user_id = ? AND owrs.id = ? ' ;
        $query = $this->db->query($sql,array($user_id,$owrs_id));
        $row = $query->row_array();
        return $row['count_conversation'];

    }
    public function exchangeConversation($user_id,$owrs_id,$limit=0,$offset=0){
        $params = array($user_id,$owrs_id);
        $sql = 'SELECT luom.title,luom.content,luom.created_date,luom.msg_from_flag
                FROM list_user_owner_messages luom
                INNER JOIN owner_recruits owrs ON luom.owner_id = owrs.owner_id
                WHERE luom.user_id = ? AND owrs.id = ?
                ORDER BY luom.created_date DESC ';
        if ($limit != 0 && $offset != 0 ) {
            $sql .= ' LIMIT ? OFFSET ? ';
            array_push($params,$limit,$offset);
        } elseif ($limit > 0 && $offset <= 0) {
            $sql .= ' LIMIT ? ';
            array_push($params,$limit);
        }
        $query = $this->db->query($sql,$params);
        $ret = $query->result_array();
        return $ret;
    }
    public function countConversation($user_id,$owrs_id){
        $sql = 'SELECT COUNT(1) as count_conversation
                FROM list_user_owner_messages luom
                INNER JOIN owner_recruits owrs ON luom.owner_id = owrs.owner_id
                WHERE luom.user_id = ? AND owrs.id = ?
                ORDER BY luom.created_date DESC';
        $params = array($user_id,$owrs_id);
        $query = $this->db->query($sql,$params);
        $ret = $query->row_array();
        return $ret['count_conversation'];
    }

    public function hasInterviewer($owner_id) {
      $sql = "SELECT COUNT(1) as counts
                FROM owner_interviewer
                WHERE owner_id = ? AND display_flag = 1
                LIMIT 1";
        $query = $this->db->query($sql,array($owner_id));
        $ret = $query->row_array();
        return $ret;
    }

    public function getExistingInterviewer($owner_id) {
        $sql = "SELECT *
                FROM owner_interviewer
                WHERE owner_id = ? AND display_flag = 1
                LIMIT 1";
        $query = $this->db->query($sql,array($owner_id));
        $ret = $query->row_array();
        return $ret;
    }

    public function getNoneMemberId($id){
        $this->db->where('id', $id);
        $query = $this->db->get('none_member_users');
        return $query->row_array();
    }

    public function getNoneMemberEmail($email){
        $this->db->where('email_address', $email);
        $query = $this->db->get('none_member_users');
        return $query->row_array();
    }

    public function insertNoneMember($data){
        $this->db->insert('none_member_users', $data);
        return $this->db->insert_id();
    }

    public function get_user_scout_mail_bonus($id, $offset = 0, $limit = 10){
        $sql = "
                SELECT * FROM (
                    SELECT id, created_date, bonus_money, old_bonus_money, new_bonus_money, reason, user_id 
                        FROM scout_mail_bonus_log 
                    
                    UNION
                    
                    SELECT id, created_date, bonus_money, old_bonus_money, new_bonus_money, reason, user_id 
                        FROM bbs_point_logs 
                    
                    UNION
                    
                    SELECT abpl.id, abpl.created_date, abpl.bonus_money, abpl.old_bonus_money, abpl.new_bonus_money, abpl.reason , abpl.user_id
                        FROM aruaru_bbs_points_log abpl
                        LEFT JOIN aruaru_bbs_points abp ON abp.id = abpl.point_id
                        
                ) as t
                WHERE t.user_id = $id
                AND t.created_date BETWEEN DATE_SUB(NOW(), INTERVAL 30 DAY) AND NOW() 
                ORDER BY t.created_date DESC, t.id DESC
                LIMIT $limit OFFSET $offset
                ";
        $query = $this->db->query($sql);
        $ret = $query->result_array();
        return $ret;
    }

    function get_user_scout_mail_bonusCount($id = 0) 
        {
            if ($id == 0) {
                return;
            }
            $sql = "
                SELECT id
                    FROM scout_mail_bonus_log 
                    WHERE  user_id = $id
                    AND created_date BETWEEN DATE_SUB(NOW(), INTERVAL 30 DAY) AND NOW()   
                UNION
                SELECT id
                    FROM bbs_point_logs
                    WHERE  user_id = $id
                    AND created_date BETWEEN DATE_SUB(NOW(), INTERVAL 30 DAY) AND NOW()   
                UNION
                SELECT abpl.id
                    FROM aruaru_bbs_points_log abpl
                    LEFT JOIN aruaru_bbs_points abp ON abp.id = abpl.point_id
                    WHERE abpl.user_id = $id
                    AND created_date BETWEEN DATE_SUB(NOW(), INTERVAL 30 DAY) AND NOW() 
                ";
            $query = $this->db->query($sql);
            return $query->num_rows();
        }

    /**
     * Get owners FAQ messages
     *
     * @param   string owner id
     * @return  FAQ messages
     */
    public function faq_messages_by_owner($owner_id){
        $ret = array();
        $sql = "SELECT * FROM `owner_faq` WHERE owner_id = ? AND display_flag = 1";
        $query = $this->db->query($sql, array($owner_id));
        $ret = $query->result_array();
        return $ret;
    }

    /**
     * Get message question and answer with limit
     *
     * @param   string owner id
     * @return  data
     */
    public function all_question_answer_limit($owner_id, $count = 0){
        $ret = array();
        $sql = "SELECT msg.id as question_id, msg.content as question, reply.id as answer_id , reply.content as answer FROM `list_user_owner_messages` AS msg
                LEFT JOIN list_user_owner_messages reply ON msg.reply_id = reply.id
                WHERE msg.is_replied_flag != 0 AND msg.display_flag = 1 AND msg.owner_id = ? LIMIT ? OFFSET ?";
        $query = $this->db->query($sql, array($owner_id, TOTAL_DISPLAY_FAQ, intval($count)));
        $ret = $query->result_array();
        return $ret;
    }


    /**
     * Get message question and answer
     *
     * @param   string owner id
     * @return  data
     */
    public function all_question_answer($owner_id){
        $ret = array();
        $sql = "SELECT msg.id as question_id, msg.content as question, reply.id as answer_id , reply.content as answer FROM `list_user_owner_messages` AS msg
                LEFT JOIN list_user_owner_messages reply ON msg.reply_id = reply.id
                WHERE msg.is_replied_flag != 0 AND msg.display_flag = 1 AND msg.owner_id = ?";
        $query = $this->db->query($sql, array($owner_id));
        $ret = $query->num_rows();
        return $ret;
    }

    /**
     * Update owners FAQ messages
     *
     * @param   string owner_faq id, array data
     * @return  boolean
     */
    public function update_faq_messages($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('owner_faq', $data);
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    /**
     * Remove owners FAQ messages
     *
     * @param   string owner_faq id
     * @return  boolean
     */
    public function delete_faq_messages($id) {
        $data = array('display_flag' => 0);
        $this->db->where('id', $id);
        $this->db->update('owner_faq', $data);
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    /**
     * Get owners senior profile
     *
     * @param   string owner id
     * @return  data
     */
    public function get_senior_profile($id) {
        $sql = "SELECT * FROM `owner_senior_profile` WHERE owner_id = ? AND display_flag = 1";
        $query = $this->db->query($sql, array($id));
        $ret = $query->result_array();
        return $ret;
    }

    /**
     * Insert owners senior profile info
     *
     * @param   array data
     * @return  boolean
     */
    public function insert_senior_profile($data){
        $this->db->insert('owner_senior_profile', $data);
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    /**
     * Delete owners senior profile info
     *
     * @param   string owner id
     * @return  boolean
     */
    public function delete_senior_profile($id){
        $this->db->where('owner_id', $id);
        $this->db->delete('owner_senior_profile');
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    /**
     * Get user character
     *
     * @param   owner recruit id
     * @return  data
     */
    public function get_user_character($owner_recruit_id) {
        $ret = null;
        $sql = "SELECT muc.*, uc.character_id  FROM user_characters AS uc
                INNER JOIN mst_user_character AS muc ON muc.id = uc.character_id AND uc.owner_recruit_id = ?
                WHERE display_flag = 1 ORDER BY muc.id";
        $query = $this->db->query($sql, array($owner_recruit_id));
        if ($query) {
            $ret = $query->result_array();
        }
        return $ret;
    }

    /**
     * Insert treatments interviewer
     *
     * @param   array data
     * @return  boolean
     */
    public function insert_user_characters($data){
        $this->db->insert('user_characters', $data);
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    /**
     * Delete treatments interviewer
     *
     * @param   string owner recruit id
     * @return  boolean
     */
    public function delete_user_characters($id){
        $this->db->where('owner_recruit_id', $id);
        $this->db->delete('user_characters');
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    /**
     * Get faq between owner and users
     * @param string $owner_id
     * @return array $ret
     */
    public function get_faq($owner_id)
    {
        $ret = null;
        $sql = "SELECT * FROM owner_faq WHERE owner_id = ? AND display_flag = 1";
        $query = $this->db->query($sql, array($owner_id));
        if ($query) {
            $ret = $query->result_array();
        }

        return $ret;
    }

    /**
     * Get all user characters
     * @param
     * @return array $ret
     */
    public function get_all_user_characters() {
        $ret = null;
        $sql = 'SELECT id, name FROM mst_user_character WHERE display_flag =1 ORDER BY priority';
        $query = $this->db->query($sql);
        if ($query) {
            $ret = $query->result_array();
        }

        return $ret;
    }


    public function update_telephone_record($id,$tel_record_flag){
        $this->db->where('id', $id);
        $this->db->update('users',array('telephone_record_flag'=>$tel_record_flag));
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    public function insert_owner_recruit_log($ors_id){
        $data = array(
            'owner_recruit_id'  => $ors_id,
            'date_created'      => date('Y-m-d')
        );
        $this->db->insert('owner_registration_logs',$data);
        return ($this->db->affected_rows() != 1) ? false : true;

    }

    public function get_owner_recruit_flag($ors_id){
        $sql = "SELECT COUNT(1) as count FROM owner_registration_logs WHERE owner_recruit_id = ? ";
        $query = $this->db->query($sql,array($ors_id));
        $ret = $query->row_array();
        return $ret['count'];
    }
}

?>

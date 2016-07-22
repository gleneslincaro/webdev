<?php

class Muser_messege extends CI_Model {
    function __construct() {
        parent::__construct();
    }
    /**
     * @author : [IVS]Nguyen Ngoc Phuong
     * @param  :id of user and type of mail
     * count mail is unrear
     */
    public function getCount($user_id, $gettype) {
        $template_type = "";
        if($gettype == 0){
            $template_type = " AND MTP.`template_type` not in ('us04','us08')";
        }
        if ($gettype == 1) {
            $template_type = " AND MTP.`template_type`='us03'";
        }
        if ($gettype == 2) {
           $template_type = " AND MTP.`template_type` in ('us05','us06','us09')";
        }
        if ($gettype == 3) {
             $template_type = " AND MTP.`template_type`='us07'";
        }
        if ($gettype == 4) {
            $template_type = " AND MTP.`template_type` in ('us11','us12')";
        }
        $sql = "SELECT COUNT(LU.id) AS count_messege
                FROM list_user_messages LU
                INNER JOIN owner_recruits ORS
                 ON
                LU.`owner_recruit_id`= ORS.`id`
                INNER JOIN owners OW
                ON ORS.`owner_id`= OW.id
                INNER JOIN `mst_templates` MTP
                ON LU.`template_id`= MTP.id
                WHERE LU.`display_flag`= 1 AND LU.`user_id`= ?
                AND LU.is_read= 0
                AND LU.payment_message_status = 1
                AND ORS.recruit_status = 2
                 $template_type
                ORDER BY LU.created_date DESC ";

        $query = $this->db->query($sql, array($user_id));
        $row = $query->row_array();
        $count = count($row);
        if ($count == 0) {
            return 0;
        }
        else
            return $row['count_messege'];
    }
    /**
     * @author : [IVS]Nguyen Ngoc Phuong
     * @param  :id of user, limit and type of mail
     * get message in mailbox
     */
    public function getMessege_reception($user_id, $limit, $gettype, $offset) {
        $template_type = "";
        if($gettype == 0){
            $template_type = " AND MTP.`template_type` not in ('us04','us08')";
        }
        if ($gettype == 1) {
            $template_type = " AND MTP.`template_type`in ('us03','us14')";
        }
        if ($gettype == 2) {
           $template_type = " AND MTP.`template_type` in ('us05','us06','us09')";
        }
        if ($gettype == 3) {
             $template_type = " AND MTP.`template_type`in ('us07')";
        }
        if ($gettype == 4) {
            $template_type = " AND MTP.`template_type` in ('us11','us12')";
        }
        $sql = "SELECT
	        MTP.id AS mst_id,MTP.`template_type`,
	        MTP.`content` AS content,
	        LU.display_flag AS display_flag,
	        LU.id AS id,LU.owner_recruit_id as ors_id,
	        LU.`updated_date` AS send_date,
	        MTP.`title` AS title,
	        OW.`storename` AS store_name,
	        is_read,OW.id AS owner_id,
	        LU.user_message_status, IF(MTP.id != NULL, 1, 1) AS `send_type`
	      FROM
	        list_user_messages LU
	        INNER JOIN owner_recruits ORS
	          ON LU.`owner_recruit_id` = ORS.`id`
	        INNER JOIN owners OW
	          ON ORS.`owner_id` = OW.id
	        INNER JOIN `mst_templates` MTP
	          ON LU.`template_id` = MTP.id
		WHERE LU.`display_flag` = 1
	        AND LU.`user_id` = ?
	        AND LU.`payment_message_status`=1
	        AND ORS.recruit_status = 2
	        $template_type
	    UNION
		SELECT  luom.id AS mst_id, luom.id AS template_type, luom.content AS content,
			luom.display_flag, luom.id, owr.id AS ors_id, luom.created_date AS send_date,
			luom.title AS title, ow.storename AS store_name, is_read_flag AS is_read, ow.id AS owner_id,
			IF(luom.id != NULL, 1, 1) AS user_messsage_status, IF(luom.id != NULL, 2, 2) AS `send_type`
			FROM list_user_owner_messages luom
			LEFT JOIN owners ow ON luom.owner_id = ow.id
			LEFT JOIN owner_recruits owr ON ow.id = owr.owner_id
			WHERE luom.user_id = '$user_id'
			AND owr.display_flag = 1
			AND ow.display_flag = 1
			AND luom.msg_from_flag = 1
      ORDER BY send_date DESC LIMIT ? OFFSET ?";
		$query = $this->db->query($sql,array($user_id, $limit, intval($offset)));
		return $query->result_array();
    }
    /*
    * @author: IVS_Nguyen_Ngoc_Phuong
    * count all record in user message
    * @param: $user id and message type
    */
    public function coutMessage($user_id,$gettype){
        $template_type = "";
        if($gettype == 0){
            $template_type = " AND MTP.`template_type` not in ('us04','us08')";
        }
        if ($gettype == 1) {
            $template_type = " AND MTP.`template_type`in ('us03','us14')";
        }
        if ($gettype == 2) {
           $template_type = " AND MTP.`template_type` in ('us05','us06','us09')";
        }
        if ($gettype == 3) {
             $template_type = " AND MTP.`template_type`in ('us07')";
        }
        if ($gettype == 4) {
            $template_type = " AND MTP.`template_type` in ('us11','us12')";
        }
        $sql = "SELECT
	        MTP.id AS mst_id,MTP.`template_type`,
	        MTP.`content` AS content,
	        LU.display_flag AS display_flag,
	        LU.id AS id,LU.owner_recruit_id as ors_id,
	        LU.`updated_date` AS send_date,
	        MTP.`title` AS title,
	        OW.`storename` AS store_name,
	        is_read,OW.id AS owner_id,
	        LU.user_message_status, IF(MTP.id != NULL, 1, 1) AS `send_type`
	      FROM
	        list_user_messages LU
	        INNER JOIN owner_recruits ORS
	          ON LU.`owner_recruit_id` = ORS.`id`
	        INNER JOIN owners OW
	          ON ORS.`owner_id` = OW.id
	        INNER JOIN `mst_templates` MTP
	          ON LU.`template_id` = MTP.id
		WHERE LU.`display_flag` = 1
	        AND LU.`user_id` = ?
	        AND LU.`payment_message_status`=1
	        AND ORS.recruit_status = 2
	        $template_type
	    UNION
		SELECT  luom.id AS mst_id, luom.id AS template_type, luom.content AS content,
			luom.display_flag, luom.id, owr.id AS ors_id, luom.created_date AS send_date,
			luom.title AS title, ow.storename AS store_name, is_read_flag AS is_read, ow.id AS owner_id,
			IF(luom.id != NULL, 1, 1) AS user_messsage_status, IF(luom.id != NULL, 2, 2) AS `send_type`
			FROM list_user_owner_messages luom
			LEFT JOIN owners ow ON luom.owner_id = ow.id
			LEFT JOIN owner_recruits owr ON ow.id = owr.owner_id
			WHERE luom.user_id = '$user_id'
			AND owr.display_flag = 1
			AND ow.display_flag = 1
			AND luom.msg_from_flag = 1
      ORDER BY send_date DESC";
        return $this->db->query($sql ,array($user_id))->num_rows();
    }
    /**
     * @author: [IVS]Nguyen Ngoc Phuong
     * get conten of mail
     * @param : user id, list user message id, type of mail
     */
    public function getMessege_reception_in($user_id, $id,$gettype) {
          $template_type = "";
        if($gettype == 0){
            $template_type = " AND MTP.`template_type` not in ('us04','us08')";
        }
        if ($gettype == 1) {
            $template_type = " AND MTP.`template_type`in ('us03','us14')";
        }
        if ($gettype == 2) {
           $template_type = " AND MTP.`template_type` in ('us05','us06','us09')";
        }
        if ($gettype == 3) {
             $template_type = " AND MTP.`template_type`in ('us07')";
        }
        if ($gettype == 4) {
            $template_type = " AND MTP.`template_type` in ('us11','us12')";
        }
        $sql = "SELECT ORS.id AS ors_id ,MTP.id AS mst_id,MTP.`content` AS content
                ,LU.id as lum_id,LU.display_flag AS display_flag ,
				LU.user_message_status,LU.u_hash
                ,LU.id AS id,LU.`updated_date` as send_date,MTP.`template_type`
                , MTP.`title` as title ,OW.`storename` as store_name, is_read
                FROM list_user_messages LU
                INNER JOIN owner_recruits ORS
                ON LU.`owner_recruit_id`= ORS.`id`
                INNER JOIN owners OW
                ON ORS.`owner_id`= OW.id
                INNER JOIN `mst_templates` MTP
                ON LU.`template_id`= MTP.id
                WHERE LU.`user_id`= ?
                AND ORS.recruit_status = 2
                AND LU.id = ?
                $template_type
                ORDER BY LU.created_date DESC
                limit 1 ";
        $query = $this->db->query($sql, array($user_id,$id));
        return $query->row_array();
    }

    public function getMessege_reception_in1($user_id, $id) {
    	$sql = "SELECT luom.*, us.unique_id, ow.storename, owr.id AS ors_id
			    FROM list_user_owner_messages luom
			    LEFT JOIN users us ON luom.user_id = us.id
			    LEFT JOIN owners ow ON luom.owner_id = ow.id
			    LEFT JOIN owner_recruits owr ON owr.owner_id = ow.id
			    WHERE luom.id = '$id' AND
			    ow.display_flag = 1 AND
    			luom.user_id = '$user_id'";
    	$query = $this->db->query($sql);
    	return $query->row_array();
    }
    /*
     * author: IVS_Nguyen_Ngoc_Phuong
     * update is_read of scout message
     */
    public function updateIsRead($id){
        $data = array(
              'is_read' => 1,
              'scout_mail_open_date' => date('Y-m-d H:i:s') );
        $this->db->where('id', $id);
        $this->db->where('is_read', 0);
        $this->db->update('list_user_messages', $data);
    }

    /**
     * @author  Kiyoshi Suzuki
     * @param   int $user_id
     */
    public function insertListOpenRate($user_id) {
        if (!$user_id) {
            return;
        }
        $sql  = 'INSERT INTO user_sort_list(user_id, received_no, openned_no, open_rate) ';
        $sql  .='SELECT user_id, COUNT(user_id) as received_no, SUM(is_read) as openned_no, SUM(is_read) / COUNT(user_id) AS open_rate ';
        $sql  .='FROM list_user_messages AS lum ';
        $sql  .='INNER JOIN mst_templates mt ON lum.template_id = mt.id AND (mt.template_type = "us03" OR mt.template_type = "us14") ';
        $sql  .='WHERE user_id = ? and lum.display_flag = 1 ';
        $sql  .='ON DUPLICATE KEY UPDATE open_rate = VALUES(open_rate), received_no = values(received_no), openned_no = values(openned_no)';
        $this->db->query($sql,$user_id);
    }

    /*
    * @author Kiyoshi Suzuki
    * @param int $owner_id, $user_id
    */
    public function insertListReciveOpenMail($owner_id,$user_id){
        if (!$user_id || !$owner_id) {
            return;
        }
        $params = array();
        $sql ='INSERT INTO owner_sort_list(owner_user_id,owner_id,user_id,receive_num,open_mail_num) ';
        $sql .='SELECT concat(?,"_",?) AS owner_user_id,';
        $params[] = $owner_id;
        $params[] = $user_id;
        $sql .='owr.owner_id AS owner_id,user_id,COUNT(list_user_messages.user_id) AS receive_num,SUM(list_user_messages.is_read) AS open_mail_num ';
        $sql .='FROM list_user_messages ';
        $sql .='INNER JOIN owner_recruits owr ON list_user_messages.owner_recruit_id = owr.id AND owr.display_flag = 1 ';
        $sql .='INNER JOIN mst_templates mt ON list_user_messages.template_id = mt.id AND (mt.template_type = "us03" OR mt.template_type = "us14") ';
        $sql .='AND owr.owner_id = ? AND user_id = ? AND list_user_messages.display_flag = 1 ';
        $params[] = $owner_id;
        $params[] = $user_id;
        $sql .='ON DUPLICATE KEY UPDATE receive_num = VALUES(receive_num),open_mail_num = VALUES(open_mail_num)';
        $this->db->query($sql, $params);
    }

    public function updateIsReadFromOwner($id){
    	$data = array(
    			'is_read_flag' => 0  );
    	$this->db->where('id', $id);
    	$this->db->update('list_user_owner_messages', $data);
    }

    public function messege_delete1($id) {
    	$sql = "UPDATE list_user_owner_messages SET display_flag = 0 WHERE id = '$id' ";
    	$this->db->query($sql);
    }

    public function checkbox_messege1($data) {
    	$sql = "UPDATE list_user_owner_messages SET display_flag = 0 WHERE id IN ('$data') ";
    	$this->db->query($sql);
    }


    public function restore_reception_messege($id) {
        $data = array(
            "display_flag" => 1
        );
        $where = array(
            "id" => $id,
        );
        $this->db->where($where);
        $this->db->update("list_user_messages", $data);
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    public function checkbox_messege($id, $display_flag) {
        $this->db->set("display_flag", $display_flag);
        $this->db->where_in('id', $id);
        $this->db->update("list_user_messages");
    }
    public function messege_delete($id) {
        $data = array(
            "display_flag" => "0",
        );
        $where = array(
            "id" => $id
        );
        $this->db->where($where);
        $this->db->update("list_user_messages", $data);
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    /**
     * @author [IVS] Nguyen Ngoc Phuong
     * @param id of user, limit and type of mail
     * get mail was deleted
     */
    public function getMessege_dustbox($user_id, $limit, $gettype, $offset) {
        $template_type = "";
        if($gettype == 0){
            $template_type = " AND MTP.`template_type` not in ('us04','us08')";
        }
        if ($gettype == 1) {
            $template_type = " AND MTP.`template_type`in ('us03','us14')";
        }
        if ($gettype == 2) {
           $template_type = " AND MTP.`template_type` in ('us05','us06','us09')";
        }
        if ($gettype == 3) {
             $template_type = " AND MTP.`template_type`in ('us07')";
        }
        if ($gettype == 4) {
            $template_type = " AND MTP.`template_type` in ('us11','us12')";
        }
        $sql = "SELECT
        MTP.id AS mst_id,MTP.`template_type`,
        MTP.`content` AS content,
        LU.display_flag AS display_flag,
        LU.id AS id,LU.owner_recruit_id as ors_id,
        LU.`updated_date` AS send_date,
        MTP.`title` AS title,
        OW.`storename` AS store_name,
        is_read,OW.id AS owner_id,
        LU.user_message_status, IF(MTP.id != NULL, 1, 1) AS `send_type`
        FROM
        list_user_messages LU
        INNER JOIN owner_recruits ORS
          ON LU.`owner_recruit_id` = ORS.`id`
        INNER JOIN owners OW
          ON ORS.`owner_id` = OW.id
        INNER JOIN `mst_templates` MTP
          ON LU.`template_id` = MTP.id
	WHERE LU.`display_flag` = 0
        AND LU.`user_id` = ?
        AND LU.`payment_message_status`=1
        $template_type
        AND ORS.recruit_status = 2
        ORDER BY send_date DESC LIMIT ? OFFSET ?";
         $query = $this->db->query($sql, array($user_id,$limit, intval($offset)));
         return $query->result_array();
    }
    public function countallMessege_dustbox($user_id, $gettype) {
        $template_type = "";
        if($gettype == 0){
            $template_type = " AND MTP.`template_type` not in ('us04','us08')";
        }
        if ($gettype == 1) {
            $template_type = " AND MTP.`template_type`in ('us03','us14')";
        }
        if ($gettype == 2) {
           $template_type = " AND MTP.`template_type` in ('us05','us06','us09')";
        }
        if ($gettype == 3) {
             $template_type = " AND MTP.`template_type`in ('us07')";
        }
        if ($gettype == 4) {
            $template_type = " AND MTP.`template_type` in ('us11','us12')";
        }
        $sql = "SELECT
        MTP.id AS mst_id,MTP.`template_type`,
        MTP.`content` AS content,
        LU.display_flag AS display_flag,
        LU.id AS id,
        LU.`updated_date` AS send_date,
        MTP.`title` AS title,
        OW.`storename` AS store_name,
        is_read,OW.id AS owner_id,
        LU.user_message_status
        FROM
        list_user_messages LU
        INNER JOIN owner_recruits ORS
          ON LU.`owner_recruit_id` = ORS.`id`
        INNER JOIN owners OW
          ON ORS.`owner_id` = OW.id
        INNER JOIN `mst_templates` MTP
          ON LU.`template_id` = MTP.id
	WHERE LU.`display_flag` = 0
        AND LU.`user_id` = ?
        AND LU.`payment_message_status`=1
        $template_type
        AND ORS.recruit_status = 2 ";
        return $this->db->query($sql, array($user_id))->num_rows();
    }

    /**
     * Check if news or scout mail opened is not greater than the given expiration date.
     * @param   $lum_id
     * @return  true or false
     */
    public function check_mail_expiration($lum_id)
    {
        $ret = false;
        $sql = "SELECT DATE_ADD(created_date, INTERVAL " . SCOUT_MAIL_LIMIT_HOURS . " HOUR) AS expiration_date FROM list_user_messages WHERE id = ?";
        $query = $this->db->query($sql, array($lum_id));
        if ($query && $row = $query->row_array()) {
            if (date('Y-m-d H:i:s') > $row['expiration_date']) {
                $ret  = true;
            }
        }
        return $ret;
    }
    /**
     * get owner recruit data from scout mail ID
     * @param   $lum_id
     * @return  owner's data(array)
     */
    public function get_owner_recruit_data_from($lum_id) {
        $ret = null;
        if (!$lum_id) {
            return $ret;
        }
        $sql = "SELECT owr.* FROM owner_recruits owr
                INNER JOIN list_user_messages lum ON owr.id = lum.owner_recruit_id
                WHERE lum.id = ? ";
        $query = $this->db->query($sql, array($lum_id));
        if ($query && $row = $query->row_array()) {
            $ret = $row;
        }
        return $ret;
    }
}
?>

<?php
    class Mmail extends CI_Model{
        public function __construct() {
            parent::__construct();

        }

        /**
        * @author  [IVS] Ho Quoc Huy
        * @name 	getSearchShopNameQuery
        * @todo 	get Search_Shop_Name_Query
        * @param 	$emailAddress,$storeName,$note,$lastLoginFrom,$lastLoginTo,$styleShopClub
        * @return 	string sql
        */
        public function getSearchShopNameQuery($emailAddress, $userName, $note, $lastLoginFrom, $lastLoginTo, $status){
            $stringTempSql1 = null;
            $stringTempSql2 = null;
            $stringTempSql3 = null;
            $params = array();
            $params[] = "%".$emailAddress."%";
            $params[] ="%".$userName."%";
            $params[] ="%".$note."%";
            if($lastLoginFrom!=null && $lastLoginFrom !=""){
                $stringTempSql1 = " AND DATEDIFF(?,last_visit_date) <= 0 ";
                $params[] = $lastLoginFrom;
            }
            if($lastLoginTo!=null && $lastLoginTo !=""){
                $stringTempSql2 = " AND DATEDIFF(?,last_visit_date) >= 0 ";
                $params[] = $lastLoginTo;
            }
            if($status!=null){
            $stringTempSql3 = " AND owner_status = ? ";
            $params[] = $status;
            }
            $sql = "SELECT unique_id,email_address,owner_status,storename FROM owners WHERE display_flag='1'AND magazine_status = 1 AND email_address LIKE ? AND storename LIKE ? AND IFNULL(memo,' ') LIKE ?".$stringTempSql1." ".$stringTempSql2." ".$stringTempSql3." ";
            return array($sql,$params);
        }

        /**
        * @author  [IVS] Ho Quoc Huy
        * @name 	searchDataToShow
        * @todo 	search Data To Show (paging)
        * @param 	$sql,$limit,$offset
        * @return 	data_result
        */
        public function searchDataToShow($sql,$limit,$offset,$params = array()){
            $sql = $sql."LIMIT ".$limit." OFFSET ".$offset."";
            return $this->db->query($sql,$params)->result_array();
        }

        /**
        * @author  [IVS] Ho Quoc Huy
        * @name 	getDataByQuery
        * @todo 	get total data by query
        * @param 	$sql
        * @return 	data_result
        */
        public function getDataByQuery($sql,$params = array()){
            return $this->db->query($sql,$params)->result_array();
        }

        /**
        * @author  [IVS] Ho Quoc Huy
        * @name 	count Data By Query
        * @todo 	get total rows (paging)
        * @param 	$sql
        * @return 	data_result
        */
        public function countDataByQuery($sql,$params = array()){
            return $this->db->query($sql,$params)->num_rows();
        }


        /**
        * @author  [IVS] Ho Quoc Huy
        * @name 	insertInfoToMailQueue
        * @todo 	insert data to mail_queue
        * @param 	$fromEmail,$title,$listEmail,$context,$date
        * @return
        */
        public function insertInfoToMailQueue($fromEmail,$title,$listEmail,$context,$date,$member_type){
            $sql = "INSERT INTO mail_queue(from_mail,to_mail,title,content,send_date,created_date,member_type) VALUES (?,?,?,?,?+ INTERVAL 5 MINUTE,?,?)";
            $this->db->query($sql,array($fromEmail,$listEmail,$title,$context,$date,date("Y-m-d-H-i-s"),$member_type));
        }

        /**
        * @author  [IVS] Ho Quoc Huy
        * @name 	getSearchShopNameQuery
        * @todo 	get Search_Shop_Name_Query
        * @param 	$emailAddress,$storeName,$note,$lastLoginFrom,$lastLoginTo,$styleShopClub
        * @return 	string sql
        */
        public function getSearchUserQuery( $systemID,$emailAddress,$userName,$note,
                                            $lastLoginFrom,$lastLoginTo,$statusOfRegistration, $bonus_grant = false,
                                            $scout_date_start = null, $scout_date_end = null, $rec_money_range_start = 0, $rec_money_range_end = 0, $user_from_sites, $last_login = 0){
            $params = array();
            $sql = "SELECT  unique_id, sum(smb.bonus_money) as total_bonus_money, email_address,
                            user_status, a.name as userName, website_id, b.name as websiteName
                    FROM users a
                    LEFT JOIN mst_websites b ON a.website_id = b.id AND b.display_flag = 1
                    LEFT JOIN scout_mail_bonus smb ON smb.user_id = a.id AND smb.display_flag = 1
                    WHERE a.display_flag = 1 AND a.magazine_status = 1
                    AND (a.user_from_site = 0 || (a.user_from_site <> 0 AND a.remote_scout_flag = 1)) ";

            if ($emailAddress) {
                $sql .= "AND a.email_address LIKE ? ";
                $params[] = "%" . $emailAddress . "%";
            }
            if ($userName) {
                $sql .= "AND a.name LIKE ? ";
                $params[] ="%" . $userName . "%";
            }
            if ($systemID) {
                $sql .= "AND a.unique_id LIKE ? ";
                $params[] ="%".$systemID."%";
            }
            if ($note) {
                $sql .= "AND IFNULL(a.memo,' ') LIKE ? ";
                $params[] ="%" . $note . "%";
            }
            if ($lastLoginFrom) {
                $sql .= " AND DATEDIFF(?, a.last_visit_date) <= 0 ";
                $params[] = $lastLoginFrom;
            }
            if ($lastLoginTo) {
                $sql .= " AND DATEDIFF(?, a.last_visit_date) >= 0 ";
                $params[] = $lastLoginTo;
            }

            if ($statusOfRegistration != null) {
                $sql .= " AND a.user_status =? ";
                $params[] = $statusOfRegistration;
            }

            if ($scout_date_start) {
                $sql .= " AND DATEDIFF(?, a.accept_remote_scout_datetime) <= 0 ";
                $params[] = $scout_date_start;
            }

            if ($scout_date_end) {
                $sql .= " AND DATEDIFF(?, a.accept_remote_scout_datetime) >= 0 ";
                $params[] = $scout_date_end;
            }

            if ($bonus_grant) {
                $sql .= " AND a.received_bonus_flag = 0 AND a.remote_scout_flag = 1";
            }

            if ($last_login) {
                $sql .= " AND (a.last_visit_date = '' OR a.last_visit_date IS NULL) ";
            }

            $sql .= " AND a.user_from_site IN (" . $user_from_sites. ") ";
            $sql .= " GROUP BY unique_id ORDER BY a.id DESC ";
            $sql = "SELECT * FROM (" . $sql . ") work_tbl ";
            if ($rec_money_range_start != null || $rec_money_range_end != null) {
                $sql .= "WHERE work_tbl.total_bonus_money >= ? AND work_tbl.total_bonus_money <= ? ";
                $params[] = $rec_money_range_start;
                $params[] = $rec_money_range_end;
            }

            return array($sql, $params);
        }
        /**
        * @author  [IVS] Ho Quoc Huy
        * @name 	getSearchUserLogQuery
        * @todo 	get Search_User_Log_Query
        * @param 	$emailAddress,$storeName,$note,$lastLoginFrom,$lastLoginTo,$styleShopClub
        * @return 	string sql*/
        public function getSearchLogQuery($lastLoginFrom,$lastLoginTo) {
            $stringTempSql1 = null;
            $stringTempSql2 = null;
             $params = array();

            if($lastLoginFrom!=null && $lastLoginFrom !=""){
                $stringTempSql1 = " AND DATEDIFF(?,send_date) <= 0 ";
                $params[] =$lastLoginFrom;
            }
            if($lastLoginTo!=null && $lastLoginTo !=""){
                $stringTempSql2 = " AND DATEDIFF(?,send_date) >= 0 ";
                $params[] =$lastLoginTo;
            }
            $sql = "(SELECT* FROM mail_queue ".$stringTempSql1." ".$stringTempSql2." ORDER BY send_date DESC)";

            return array($sql,$params);
        }

        /**
        * @author  [IVS] Ho Quoc Huy
        * @name 	getTemplateByID
        * @todo 	get Template By ID
        * @param 	$sql
        * @return 	data_result
        */
        public function getTemplateByID($templateId){
            $sql ="SELECT * FROM mst_templates where id=? AND display_flag='1'";
            return $this->db->query($sql,array($templateId))->row_array();
        }

        /**
        * @author  [IVS] Ho Quoc Huy
        * @name 	getMessageByID
        * @todo 	get Message By ID
        * @param 	$sql
        * @return 	data_result
        */
        public function getMessageByID($messageID){

            $sql = "SELECT * FROM mail_queue WHERE id= ?";
            return $this->db->query($sql,array($messageID))->row_array();
        }


        /**
        * @author  [IVS] Ho Quoc Huy
        * @name 	updateTemplateContent
        * @todo 	update Template by ID
        * @param 	$templateID,$title,$context
        * @return
        */
        public function updateTemplateContent($title,$context,$send_date,$messageID){
           $sql = " UPDATE mail_queue SET title = ?, content=?, send_date=? + INTERVAL 5 MINUTE WHERE id= ?";
           $this->db->query($sql,array($title,$context,$send_date,$messageID));
        }

        /**
        * @author  [IVS] Ho Quoc Huy
        * @name 	deactiveMessage
        * @todo 	deactive Message by ID
        * @param 	$id
        * @return
        */
        public function deactiveMessage($id){
        $data=array(
           "display_flag"=>"0",
        );
        $where=array(
           "id"=>$id
        );
        $this->db->where($where);
        $this->db->update("mail_queue",$data);
        }
        public function getStore() {
            $sql = "SELECT storename, id FROM owners ow WHERE display_flag = 1 AND ((owner_status = 2 AND public_info_flag = 1) OR email_address = ?)";
            $query = $this->db->query($sql, "info@joyspe.com");
            return $query->result_array();
        }
        public function getUserId($email_address){
            $sql = "SELECT id,email_address FROM users WHERE email_address = ?";
            $query = $this->db->query($sql,array($email_address))->row_array();
            return $query;
        }
        public function emailQuery($emailaddress) {
            $sql = "SELECT email_address,user_from_site,users.password,users.name,users.id AS userId,users.old_id as login_id,users.`unique_id`,
                    mst_cities.`name` AS city_name,
                    GROUP_CONCAT(mst_job_types.name SEPARATOR '、') AS job_type
                    FROM users
                    LEFT JOIN user_recruits ON users.id = user_recruits.user_id AND user_recruits.`display_flag` = '1'
                    LEFT JOIN mst_cities ON user_recruits.city_id = mst_cities.id AND mst_cities.`display_flag` = '1'
                    LEFT JOIN job_type_users ON user_recruits.user_id = job_type_users.user_id
                    LEFT JOIN mst_job_types ON job_type_users.job_type_id = mst_job_types.id AND mst_job_types.`display_flag` = '1'
                    WHERE users.display_flag = 1 AND users.email_address = ?
                    GROUP BY user_recruits.id";
            $query = $this->db->query($sql, array($emailaddress))->row_array();
            return $query;
        }
        public function insertAdminScoutMail($context = null,$title = null,$list_user_message_id=null) {
            $data = array(
                'list_user_message_id'=>$list_user_message_id,
                'mail_title'=>$title,
                'mail_content'=>$context,
                'created_date'=>date('y-m-d H:i:s')

            );
            $this->db->insert('admin_scout_mail_log',$data);
        }
        public function variableList() {
            $sql = "SELECT * FROM mst_variable_list WHERE display_flag = ? AND group_type = ? ";
            $query = $this->db->query($sql,array(1, 'usCommon'));
            return $query->result_array();
        }
        public function getListUserId($owner_recruit_id,$user_id) {
            $sql = "SELECT id,
                    owner_recruit_id,
                    user_id
                    FROM list_user_messages
                    WHERE owner_recruit_id = ?
                    AND user_id = ? ORDER BY id DESC";
            $query = $this->db->query($sql,array($owner_recruit_id,$user_id));
            return $query->row_array();
        }
		public function getStoreByKeyword($keyword) {
			 $sql = "SELECT storename, id FROM owners
                     WHERE display_flag = 1 AND ((owner_status = 2 AND public_info_flag = 1) OR email_address = ?) AND storename LIKE '%$keyword%' ";
            $query = $this->db->query($sql, "info@joyspe.com");
            return $query->result_array();
		}
		public function getContentNewsletter(){
			$sql = "SELECT content
					FROM mst_templates
					WHERE template_type = 'ss09' ";
			$query = $this->db->query($sql);
			return $query->row_array();
		}
		public function getOwnerStat($owner_id){
			$sql = "SELECT owr.id, owr.owner_id,ow.storename,ow.owner_status
					FROM owner_recruits owr
					INNER JOIN owners ow ON (owr.owner_id = ow.id and owr.display_flag = 1)
					WHERE ow.id = ?";
			$query = $this->db->query($sql,array($owner_id));
			return $query->row_array();
		}

        /**
         * Insert insert_mail_queue_magazine
         * @param $data array
         * @return
         */
        public function insert_mail_queue_magazine($data) {
            $this->db->insert('mail_queue_magazine', $data);
        }

        /**
         * Update update_mail_queue_magazine
         * @param $id mail magazine id, $data array
         * @return
         */
        public function update_mail_queue_magazine($id, $data) {
            $this->db->where('id', $id);
            $this->db->update("mail_queue_magazine",$data);
        }

        /**
         * Get mail magazine by time
         * @param time
         * @return return array
         */
        public function auto_send_magazine_time($time) {
            $sql = "SELECT * FROM mail_queue_magazine
                    WHERE send_time = ?
                        AND display_flag = 1";
            $query = $this->db->query($sql,array($time));
            return $query->result_array();
        }

        /**
         * Get mail magazine by ID
         * @param ID
         * @return return array
         */
        public function auto_send_magazine_id($id) {
            $sql = "SELECT * FROM mail_queue_magazine
                    WHERE id = ?
                        AND display_flag = 1";
            $query = $this->db->query($sql,array($id));
            return $query->row_array();
        }

        /**
         * Get template info
         * @param null
         * @return return array
         */

        public function get_content_magazine() {
            $sql = "SELECT content
                    FROM mst_templates
                    WHERE template_type = 'ss10' ";
            $query = $this->db->query($sql);
            return $query->row_array();
        }

        /**
         * Get user unread scout mail
         * @param string $email: user's email address
         * @return return array
         */

        public function get_unread_message($email) {
            if (!$email) {
                return null;
            }
            $sql = "SELECT smb.bonus_money, SUM(IF(lum.is_read = 0 &&
                                (lum.created_date > DATE_SUB(NOW(), INTERVAL " . SCOUT_MAIL_LIMIT_HOURS . "  HOUR)), 1, 0)) AS not_read
                    FROM list_user_messages AS lum
                    LEFT JOIN users AS us ON (lum.user_id = us.id AND us.display_flag = 1)
                    LEFT JOIN scout_mail_bonus AS smb ON (smb.user_id = us.id AND smb.bonus_requested_flag = 0 and smb.display_flag = 1)
                    WHERE us.email_address = ? ";
            $query = $this->db->query($sql, array($email));
            return $query->row_array();
        }

        /**
         * Insert mail_queue_magazine_log
         * @param $data array
         * @return
         */

        public function insert_mail_magazine_log($data) {
            $this->db->insert('mail_queue_magazine_log', $data);
        }

        /**
         * Select mail_queue_magazine_log by user_mail_group_id
         * @param field user_mail_group_id
         * @return array
         */
        public function get_magazine_log_mail_group($id) {
            $sql = "SELECT * FROM mail_queue_magazine_log
                    WHERE user_mail_group_id = ?";
            $query = $this->db->query($sql, array($id));
            return $query->result_array();
        }


        /**
         * Insert mail_queue_magazine_log
         * @param $encode_string string, $created_date date
         * @return array
         */
        public function get_mail_magazine_log($encode_string, $created_date) {
            $sql = "SELECT * FROM mail_queue_magazine_log
                    WHERE random_encode_string = ? AND created_date = ? AND created_date > DATE_SUB(NOW(), INTERVAL " . LOGIN_EXPIRE_HOURS . " HOUR)";
            $query = $this->db->query($sql, array($encode_string, $created_date));
            return $query->row_array();
        }

        /**
         * Search mail_queue_magazine
         * @param $limit,$offset
         * @return array
         */
        public function getBookMailMagazine($limit,$offset=0,$display_flag=1) {
            $sql = "SELECT id,to_mail,from_mail,title,content,send_time,display_flag
                    FROM mail_queue_magazine ";
            if($display_flag != 3) {
                $sql .= " WHERE display_flag = $display_flag ";
            }
            $sql .= " LIMIT ? OFFSET ? ";
            $query = $this->db->query($sql,array($limit,$offset));
            return $query->result_array();

        }

        /**
         * Update mail_queue_magazine
         * @param int $id, int $display_flag
         * @return boolean
         */
        public function updateStatusMail($id,$display_flag) {
            $sql = "UPDATE mail_queue_magazine SET display_flag = ? WHERE id = ?";
            $query = $this->db->query($sql,array($display_flag,$id));
            if ($query) return true;
        }

        /**
         * Update mail_queue_magazine
         * @param null
         * @return int
         */
        public function countMailQueue($display_flag) {
            $sql = "SELECT COUNT(1) as count FROM mail_queue_magazine ";

            if($display_flag != 3) {
                $sql .= " WHERE display_flag = $display_flag ";
            }

            $query = $this->db->query($sql);
            $count = $query->row_array();
            return $count['count'];
        }

        /**
         * Get by id list_user_mail_group
         * @param table id
         * @return array
         */
        public function idListUserMailGroup($id){
            $sql = "SELECT * FROM list_user_mail_group WHERE id = ? ";
            $query = $this->db->query($sql, array($id));
            $ret = $query->row_array();
            return $ret;
        }

         /**
         * Get by id list_user_mail_group
         * @param table id
         * @return array
         */
        public function getMsgEmailmailGroup($id, $email){
            $sql = "SELECT us.email_address, lum.id FROM list_user_mail_group lumg
                    INNER JOIN mail_queue_magazine_log mqml ON lumg.id = mqml.user_mail_group_id
                    INNER JOIN list_user_messages lum ON mqml.msg_id = lum.id
                    LEFT JOIN users us ON lum.user_id = us.id
                    WHERE lumg.id = ? AND us.email_address = ?";
            $query = $this->db->query($sql, array($id, $email));
            $ret = $query->row_array();
            return $ret;
        }

        /**
         * Get all list_user_mail_group
         * @param null
         * @return array
         */
        public function allListUserMailGroup(){
            $sql = "SELECT lumg.*,
                           COUNT(mqml.id) AS count_mail_sent,
                           COUNT(lum.id) AS count_mail_open
                        FROM
                           list_user_mail_group AS lumg
                                LEFT JOIN
                           mail_queue_magazine_log AS mqml ON mqml.user_mail_group_id = lumg.id AND mqml.display_flag = 1
                                LEFT JOIN
                           list_user_messages AS lum ON mqml.msg_id = lum.id AND lum.is_read = 1 AND lum.display_flag = 1
                        WHERE
                           lumg.display_flag = 1
                        GROUP BY lumg.id
                        ORDER BY lumg.created_date DESC , lumg.id DESC";
            $query = $this->db->query($sql);
            $ret = $query->result_array();
            return $ret;
        }

        /**
         * Get by id list_user_messages
         * @param table id
         * @return array
         */
        public function getIdListUserMessage($id){
            $sql = "SELECT * FROM list_user_messages WHERE id = ?";
            $query = $this->db->query($sql, array($id));
            $ret = $query->row_array();
            return $ret;
        }

        /**
         * Insert list_user_mail_group
         * @param data table and values array
         * @return boolean
         */
        public function insertListUserMailGroup($data){
            $ret = $this->db->insert('list_user_mail_group', $data);
            return $ret;
        }

        /**
         * Modify list_user_mail_group
         * @param data table and values array
         * @return boolean
         */
        public function modifyListUserMailGroup($id, $data){
            $this->db->where('id', $id);
            $this->db->update('list_user_mail_group', $data); 
        }

        /**
         * Search mail_queue_magazine_log by mail_queue_magazine id
         * @param data table and values array
         * @return boolean
         */
        public function get_mail_magazine_history($id){
            $sql = "SELECT count(mqml.created_date) AS count_sent, mqml.created_date date_sent FROM mail_queue_magazine AS mqm
                    INNER JOIN mail_queue_magazine_log AS mqml ON mqm.id = mqml.mail_magazine_id
                    WHERE mqm.id = ? GROUP BY DATE_FORMAT( mqml.created_date , '%Y-%m-%d' ) DESC";
            $query = $this->db->query($sql, array($id));
            $ret = $query->result_array();
            return $ret;
        }

        

    }
?>

<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

if (!class_exists('CI_Model')) {
    require_once(BASEPATH . 'core/Model.php');
}

class CommonQuery extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->helper('date');
    }

    /**
     * @author  [IVS] Phan Ngoc Minh Luan
     * @name 	getOwnerId
     * @todo 	get Owner Id
     * @param 	string $email_address
     * @return 	int
     */
    public function getOwnerId($email_address) {
        $query = $this->db->get_where('owners', array('email_address' => $email_address));
        if ($query->num_rows() > 0) {
            $row = $query->row_array();
            return $row['id'];
        }
        return 0;
    }

    /**
     * @author  [IVS] Phan Ngoc Minh Luan
     * @name 	getUniqueId
     * @todo 	get unique_id user's
     * @param 	string $email_address
     * @return 	int
     */
    public function getUserUniqueId($user_id) {
        $query = $this->db->get_where('users', array('id' => $user_id));
        if ($query->num_rows() > 0) {
            $row = $query->row_array();
            return $row['unique_id'];
        }
        return 0;
    }

    /**
     * @author  [IVS] Phan Ngoc Minh Luan
     * @name 	getOwnerRecruitId
     * @todo 	get Owner Recruit Id
     * @param 	int $owner_id
     * @return 	int
     */
    public function getOwnerRecruitId($owner_id) {
        $data = array(
            'owner_id' => $owner_id,
            'display_flag' => 1,
        );
        $query = $this->db->get_where('owner_recruits', $data);
        if ($query->num_rows > 0) {
            $row = $query->row_array();
            return $row['id'];
        }
        return 0;
    }

    /**
     * @author  [IVS] Phan Ngoc Minh Luan
     * @name 	getUserPaymentId
     * @todo 	get User Payment Id
     * @param 	int $owner_id, $user_id
     * @return 	int
     */
    public function getUserPaymentId($user_id, $owner_recruit_id) {
        $data = array(
            'user_id' => $user_id,
            'owner_recruit_id' => $owner_recruit_id,
            'display_flag' => 1,
        );
        $query = $this->db->get_where('user_payments', $data);
        if ($query->num_rows > 0) {
            $row = $query->row_array();
            return $row['id'];
        }
        return 0;
    }

    /**
     * @author  [IVS] Phan Ngoc Minh Luan
     * @name 	getUserPaymentId
     * @todo 	get User Payment Id
     * @param 	int $owner_id, $user_id
     * @return 	int
     */
    public function getArrUserPaymentId($arr_owner_recruit_id) {
        $data = array(
            'user_payment_status' => 0,
            'display_flag' => 1,
        );
        $this->db->select('id');
        $this->db->where_in('owner_recruit_id', $arr_owner_recruit_id);
        $query = $this->db->get_where('user_payments', $data);
        if ($query->num_rows > 0) {
            return $query->result_array();
        }
        return 0;
    }

    /**
     * @author  [IVS] Phan Ngoc Minh Luan
     * @name 	getArrOwnerRecruitId
     * @todo 	get array owner_recruit_id
     * @param 	int $owner_id, $user_id
     * @return 	int
     */
    public function getArrOwnerRecruitId($owner_id) {
        $cond = array(
            'owner_id' => $owner_id,
        );
        $this->db->select('id');
        $query = $this->db->get_where('owner_recruits', $cond);
        if ($query->num_rows > 0) {
            return $query->result_array();
        }
        return 0;
    }

    /**
     * @author  [IVS] Phan Ngoc Minh Luan
     * @name 	getTotalPoint
     * @todo 	get Total Point
     * @param 	string $email_address
     * @return 	int
     */
    public function getTotal($email_address) {
        $this->db->select('total_point, total_amount');
        $query = $this->db->get_where('owners', array('email_address' => $email_address));
        if ($query->num_rows() > 0) {
            $row = $query->row_array();
            return $row;
        }
        return 0;
    }

    /**
     * @author  [IVS] Phan Ngoc Minh Luan
     * @name 	getParamPoint
     * @todo 	get Param Point (setting: $point/$amount)
     * @param
     * @return 	int
     */
    public function getParamPoint() {
        $this->db->select('amount, point');
        $cond = array(
//            'point_setting_status'=>1,
            'display_flag' => 1,
        );
        $this->db->from('mst_point_setting');
        $this->db->where($cond);
        $this->db->order_by('updated_date', 'desc');
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $row = $query->row_array();
            $param_point = $row['point'] / $row['amount'];
            return $param_point;
        }
        else
            return 0;
    }

    /**
     * @author  [IVS] Phan Ngoc Minh Luan
     * @name 	getCurrentDate
     * @todo 	get Current Time
     * @param
     * @return 	date
     */
    public function getCurrentDate() {
        $time = date('y-m-d H:i:s');
        return $time;
    }

    /**
     * @author  [IVS] Phan Ngoc Minh Luan
     * @name 	setStatusUserPayments
     * @todo 	set status of table UserPayments, (change current status into last_status) (0:apply, 1:pending, 2:request, 3:approve, 4:deny)
     * @param 	int $user_id, $owner_recruit, $current_status, $last_status
     * @return 	int
     */
    public function setStatusUserPayments($user_id, $owner_recruit_id, $current_status, $last_status) {
        if ($current_status == 5 && $last_status == 6) {// approve request recruit money
            $data = array(
                'user_payment_status' => $last_status,
                'approved_date' => $this->getCurrentDate(),
            );
        }
        if ($current_status == 5 && $last_status == 7) {// deny request recruit money
            $data = array(
                'user_payment_status' => $last_status,
                'deny_date' => $this->getCurrentDate(),
            );
        }

        $cond = array(
            'user_id' => $user_id,
            'owner_recruit_id' => $owner_recruit_id,
            'user_payment_status' => $current_status,
        );
        $this->db->where($cond);
        $this->db->update('user_payments', $data);
        if ($this->db->affected_rows() > 0) {
            return $last_status;
        }
        return 0;
    }

    /**
     * @author  [IVS] Phan Ngoc Minh Luan
     * @name 	insertTransactionMoneyRecruit
     * @todo 	insert Transaction Money ( 0: pay scout message, 1: pay info money, 2:pay money recruit
     * @param 	int $user_id
     * @return 	int
     */
    public function insertTransactions($owner_id, $reference_id = null, $payment_case_id, $payment_id = null, $money, $point, $created_date) {
        $data = array(
            'owner_id' => $owner_id,
            'payment_case_id' => $payment_case_id,
            'reference_id' => $reference_id,
            'payment_id' => $payment_id,
            'amount' => $money,
            'point' => $point,
            'created_date' => $created_date
        );
        $this->db->insert('transactions', $data);
        return $this->db->affected_rows();
    }

    /**
     * @author  [IVS] Phan Ngoc Minh Luan
     * @name 	getTemplateFromTemplate_type
     * @todo 	get Template From Template_type
     * @param 	string $template_type
     * @return 	array
     */
    public function getTemplateFromTemplate_type($template_type) {
        $this->db->select('id,title,content');
        $query = $this->db->get_where('mst_templates', array('template_type' => $template_type, 'display_flag' => 1));
        if ($query->num_rows() > 0) {
            $row = $query->row_array();
            return $row;
        }
        return 0;
    }

    /**
     * @author  [IVS] Phan Ngoc Minh Luan
     * @name 	getSmallUserProfiles
     * @todo 	get a few User Profiles
     * @param 	int $user_id
     * @return 	array
     */
    public function compareScoutMessageSpam($user_id, $owner_id) {
        $param = array(
            'user_id' => $user_id,
            'owner_id' => $owner_id,
            'display_flag' => 1,
        );
        $query = $this->db->get_where('scout_message_spams', $param);
        if ($query->num_rows() > 0) {
            return $user_id;
        }
        return 0;
    }

    /**
     * @author  [IVS] Phan Ngoc Minh Luan
     * @name 	deleteRowsPaymentStatusRegis
     * @todo 	insert Status Register of table payment
     * @param
     * @return 	int
     */
    public function deleteRowsPaymentStatusRegis($owner_id) {

        $param = array(
            'display_flag' => 0,
        );
        $cond = array(
            'owner_id' => $owner_id,
            'payment_status' => 0,
            'display_flag' => 1,
        );
        $this->db->where($cond);
        $this->db->update('payments', $param);
        if ($this->db->affected_rows()) {
            return 1;
        }
        return 0;
    }

    /**
     * @author  [IVS] Phan Ngoc Minh Luan
     * @name 	getTemplateFromTemplate_type
     * @todo 	get Template From Template_type
     * @param 	string $template_type
     * @return 	array
     */
    public function getPaymentId($owner_id, $payment_method_id, $payment_case_id) {
        $this->db->select('id');
        $cond = array(
            'owner_id' => $owner_id,
            'payment_method_id' => $payment_method_id,
            'payment_case_id' => $payment_case_id,
            'display_flag' => 1,
        );
        $query = $this->db->get_where('payments', $cond);
        if ($query->num_rows() > 0) {
            $row = $query->row_array();
            return $row['id'];
        }
        return FALSE;
    }

    /**
     * @author  [IVS] Phan Ngoc Minh Luan
     * @name 	insertStatusRegisPayment
     * @todo 	insert Status Register of table payment
     * @param
     * @return 	int
     */
    public function insertStatusRegisPayment($owner_id, $money_payment, $point_payment, $money, $point, $payment_method_id, $payment_case_id, $user_list) {

        $param = array(
            'owner_id' => $owner_id,
            'amount_payment' => $money_payment,
            'point_payment' => $point_payment,
            'amount' => $money,
            'point' => $point,
            'payment_method_id' => $payment_method_id,
            'payment_case_id' => $payment_case_id,
            'payment_status' => 0,
            'created_date' => $this->getCurrentDate(),
            'user_list' => $user_list,
        );
        $this->db->insert('payments', $param);
        return $this->db->insert_id();
    }

    /**
     * @author  [IVS] Phan Ngoc Minh Luan
     * @name 	updateMoneyPayment
     * @todo 	update point and amount in table Payment
     * @param   $owner_id, $money, $point, $payment_method_id, $payment_case_id
     * @return 	int
     */
    public function updateMoneyPayment($owner_id, $money, $point, $payment_method_id, $payment_case_id) {

        $param = array(
            'amount' => $money,
            'point' => $point,
            'created_date' => $this->getCurrentDate(),
        );
        $cond = array(
            'owner_id' => $owner_id,
            'payment_method_id' => $payment_method_id,
            'payment_case_id' => $payment_case_id,
        );
        $this->db->where($cond);
        $this->db->update('payments', $param);
        if ($this->db->affected_rows()) {
            return 1;
        }
        return 0;
    }

    /**
     * @author  [IVS] Phan Ngoc Minh Luan
     * @name 	getCharge
     * @todo
     * @param 	int $point_setting_status ( 0:scout message money, 1: info money)
     * @return 	int
     */
    public function getCharge($point_setting_status) {
        $this->db->select('amount,point');
        $this->db->from('mst_point_setting');
        $cond = array(
            'point_setting_status' => $point_setting_status,
            'display_flag' => 1,
        );
        $this->db->where($cond);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $row = $query->row_array();
            return $row;
        }
        return 0;
    }

    /**
     * @author  [IVS] Phan Ngoc Minh Luan
     * @name 	countUserPaymentStatusApply
     * @todo 	check owner_recruit_id and user_id exist or not
     * @param 	int $owner_recruit_id
     * @return 	int
     */
    public function countUserPaymentStatusApply($owner_recruit_id) {
        $sql = "
            SELECT
  COUNT(user_id) AS count_apply
FROM
  user_payments up
  INNER JOIN owner_recruits owr
    ON owr.id = up.owner_recruit_id
  INNER JOIN users u
    ON u.id = up.user_id
WHERE owner_recruit_id = ?
  AND up.display_flag = 1
  AND `user_status` = 1
  AND user_payment_status = 0
            ";
        $query = $this->db->query($sql, array($owner_recruit_id));
        if ($this->db->affected_rows()) {
            $row = $query->row_array();
            return $row['count_apply'];
        }
        return 0;
    }

    /**
     * @author  [IVS] Phan Ngoc Minh Luan
     * @name 	getArrUserIdAppSettlement
     * @todo 	check owner_recruit_id and user_id exist or not
     * @param 	int $owner_recruit_id
     * @return 	int
     */
    public function getArrUserIdAppSettlement($owner_recruit_id) {
        $str_user_id = '';
        $sql = "
            SELECT
  user_id
FROM
  user_payments up
  INNER JOIN owner_recruits owr
    ON owr.id = up.owner_recruit_id
  INNER JOIN users u
    ON u.id = up.user_id
WHERE owner_recruit_id = ?
  AND up.display_flag = 1
  AND `user_status` = 1
  AND user_payment_status = 0
            ";
        $query = $this->db->query($sql, array($owner_recruit_id));
        if ($this->db->affected_rows()) {
            $arr_user = $query->result_array();
            foreach ($arr_user as $user) {
                $str_user_id .= ($str_user_id != null ? ',' : '') . $user['user_id'];
            }
            return $str_user_id;
        }
        return 0;
    }

    /**
     * @author  [IVS] Phan Ngoc Minh Luan
     * @name 	updateTotalPointAndMount
     * @todo 	update Total Point and Total Amount of owner
     * @param 	int $money, $point
     * @param   string $email_address
     * @param   string $unique_id
     * @return 	int
     */
    public function updateTotalPointAndMount($money, $point, $email_address, $unique_id = "") {
        $data = array(
            'total_amount' => $money,
            'total_point' => $point,
        );
        if ( $email_address ){
            $param = array(
                'email_address' => $email_address,
            );
        }else{
            $param = array(
                'unique_id' => $unique_id,
            );
        }
        $this->db->where($param);
        $this->db->update('owners', $data);
        return $this->db->affected_rows();
    }

    /**
     * @author  [IVS] Phan Ngoc Minh Luan
     * @name 	updateTotalPointAndMount
     * @todo 	update Total Point and Total Amount of owner
     * @param 	int $money, $point
     * @param   string $email_address
     * @return 	int
     */
    public function getMTemplates($template) {
        $this->db->select('title,content');
        $cond = array(
          'template_type'=>$template,
            'display_flag'=>1,
        );
        $query = $this->db->get_where('mst_templates',$cond);
        if($query->num_rows()>0){
            return $query->row_array();
        }
        return 0;

    }

		public function getMTemplatesTitle($template) {
        $this->db->select('title');
        $cond = array(
          'template_type'=>$template,
            'display_flag'=>1,
        );
        $query = $this->db->get_where('mst_templates',$cond);
        if($query->num_rows()>0){
            return $query->row_array();
        }
        return 0;

    }
	public function getNewTemplateTitle($owner_id,$scout_pr_id=null){
		$this->db->select('pr_title');
		$cond = array(
			'active_flag' 	=> 1,
			'owner_id'		=> $owner_id
		);
		if($scout_pr_id!=null){
			$cond['id'] = $scout_pr_id;
		}
		$query = $this->db->get_where('owner_scout_pr_text',$cond);
		if($query->num_rows()>0){
            return $query->row_array();
		}
		return 0;
	}

    /*
    Purpose: search for users to send scout mail
    Params:
     $posts_per_page: users per page (default 15: default display on owner top page)
    */
    public function searchUsers($owner_id, $sort_type, $owner_hidden_users, $checksub = null, $page = 1, $posts_per_page = 15, $unique_id = null) {
        $ret_user_info = null;
        if ($owner_hidden_users && is_array($owner_hidden_users)){
            $owner_hidden_users_list = array();
            foreach ($owner_hidden_users as $key => $value) {
                $owner_hidden_users_list[]  = $value['user_id'];
            }
            $owner_hidden_users_str = join("','", $owner_hidden_users_list);
        }

        if (!$owner_id){
            return null;
        }

        // CHECK CITY
        $sqlchecksub = "";
        if ($checksub) {
            $sqlchecksub = " AND mct.id IN (" . $this->db->escape_str($checksub) . ")";
        }

        //default JOIN
//        $sqljoin  ="FROM users u ";
//        $sqljoin .="LEFT JOIN owner_sort_list osl ON u.id = osl.user_id AND owner_id = ? ";

        switch ($sort_type) {
            case 'login_order1':
            $order_by = 'u.last_visit_date ASC';
            break;
            case 'login_order0':
            $order_by = 'u.last_visit_date DESC';
            break;
            case 'open_mail1':
//            $sqljoin  ="FROM owner_sort_list osl ";
//            $sqljoin .="INNER JOIN users u ON u.id = osl.user_id AND owner_id = ? ";
            $order_by = 'openned_no ASC';
            break;
            case 'open_mail0':
//            $sqljoin  ="FROM owner_sort_list osl ";
//            $sqljoin .="INNER JOIN users u ON u.id = osl.user_id AND owner_id = ? ";
            $order_by = 'openned_no DESC';
            break;
            case 'reg_users':
            $order_by = 'offcial_reg_date DESC';
            break;
            case 'open_rate':
            $order_by = 'usl.open_rate DESC';
            break;
            case 'age_users':
            $order_by = 'ur.age_id = 0,ur.age_id ASC';
            break;
            default:
            $order_by = 'u.last_visit_date DESC';
            break;
        }

        switch ($sort_type) {
            case 'open_rate':
                $params = array();
                $sql = "SELECT u.id, u.user_from_site, u.unique_id,u.profile_pic,u.profile_pic2,u.profile_pic3,u.bust,u.waist,u.hip, ";
                $sql .="ur.working_exp,ur.hope_salary_id,ur.pr_message, ";                
                $sql .="mct.name AS cityName, ma.name1 AS ageName1, ma.name2 AS ageName2, mth.name1 AS height_l, mth.name2 AS height_h, ";
                $sql .="mts.range1 AS salary_l, mts.range2 AS salary_h, ";
                $sql .="usl.open_rate, ";
                $sql .="u.last_visit_date, u.offcial_reg_date, ";
                $sql .="IF(DATE_ADD(IFNULL(u.accept_remote_scout_datetime, u.offcial_reg_date), INTERVAL 2 DAY) >= NOW(), 1, 0) as new_flg ";
                $sql .="FROM user_sort_list usl ";
                $sql .="INNER JOIN users u ON u.id = usl.user_id ";
                $sql .="INNER JOIN user_recruits ur ON u.id = ur.user_id ";
                $sql .="LEFT JOIN mst_cities mct ON ur.city_id = mct.id ";
                $sql .="LEFT JOIN mst_ages ma ON ma.id = ur.age_id ";
                $sql .="LEFT JOIN mst_height mth ON ur.height_id = mth.id ";
                $sql .="LEFT JOIN mst_salary_range mts ON ur.hope_salary_id = mts.id ";
                $sql .="WHERE u.user_status = 1 AND (u.scout_target_flag != 1 OR u.scout_target_flag IS NULL) AND u.display_flag = 1 ";
                if ($unique_id) {
                    $sql .= " AND u.unique_id=? ";
                    $params[] = $unique_id;
                }
                $sql .="AND u.id NOT IN(SELECT lum.user_id ";
                $sql .="FROM owners INNER JOIN owner_recruits ON owners.id = owner_recruits.owner_id ";
                $sql .="  INNER JOIN list_user_messages lum ON owner_recruits.id = lum.owner_recruit_id ";
                $sql .="  INNER JOIN mst_templates mt ON mt.id = lum.template_id ";
                $sql .="WHERE owners.display_flag = 1 AND owners.id = ? AND lum.is_read = 0 ";
                $params[] = $owner_id;
                $sql .='AND u.last_visit_date < lum.created_date ';
                $sql .='AND (mt.template_type = "us03" OR mt.template_type = "us14")) ';
                $sql .="AND u.id NOT IN (SELECT user_id FROM scout_message_spams WHERE display_flag = 1 AND owner_id = ?)";
                $params[] = $owner_id;
                if( count($owner_hidden_users) > 0 ) {
                    $sql .= " AND u.id NOT IN ('" . $owner_hidden_users_str . "') ";
                }
                $sql .= $sqlchecksub;
                $sql .= " ORDER BY " . $order_by . ' LIMIT ?,? ';
                $page = ($page - 1) * intval($posts_per_page);
                $params[] = $page;
                $params[] = intval($posts_per_page);
                $params[] = $owner_id;

                // 1. First get search users
                $query = $this->db->query($sql, $params);
                $user_id_list = $query->result_array();

                // 2. Second get additional information for those search users
                if ($user_id_list && is_array($user_id_list)) {
                    foreach ($user_id_list as $user_info) {
                        $user_id = $user_info['id'];

                        $user_addition_infor = array();
                        // get scout mail send/read number
                        if ($receive_read_data = $this->_get_receive_read_data($user_id)) {
                            $user_addition_infor = array_merge($user_addition_infor, $receive_read_data);
                        }
                        // get action statistics from user
                        if ($user_statistics_data = $this->_get_user_action_statistics($owner_id, $user_id)) {
                            $user_addition_infor = array_merge($user_addition_infor, $user_statistics_data);
                        }
                        // get scout mail status
                        if ($mail_status_data = $this->_get_scout_mail_status($owner_id, $user_id)) {
                            $user_addition_infor = array_merge($user_addition_infor, $mail_status_data);
                        }
                        if ($user_addition_infor && is_array($user_addition_infor)) {
                            $ret_user_info[] = array_merge($user_info, $user_addition_infor);
                        }
                    }
                }
            break;
            case 'open_mail1':
            case 'open_mail0':
            case 'reg_users':
            case 'login_order1':
            case 'login_order0':
            case 'age_users':
            default:
                $params = array();
                $sql = "SELECT u.id, u.user_from_site, u.unique_id,u.profile_pic,u.profile_pic2,u.profile_pic3,u.bust,u.waist,u.hip, ";
                $sql .="ur.working_exp,ur.hope_salary_id,ur.pr_message, ";                
                $sql .="mct.name AS cityName, ma.name1 AS ageName1, ma.name2 AS ageName2, mth.name1 AS height_l, mth.name2 AS height_h, ";
                $sql .="mts.range1 AS salary_l, mts.range2 AS salary_h, ";
                $sql .="osl.receive_num AS received_no, osl.open_mail_num AS openned_no,";
                $sql .="u.last_visit_date, u.offcial_reg_date, ";
                $sql .="IF(DATE_ADD(IFNULL(u.accept_remote_scout_datetime, u.offcial_reg_date), INTERVAL 2 DAY) >= NOW(), 1, 0) as new_flg ";
                $sql .="FROM users u ";
                $sql .="LEFT JOIN owner_sort_list osl ON u.id = osl.user_id AND owner_id = ? ";

                $params[] = $owner_id;
                $sql .="INNER JOIN user_recruits ur ON u.id = ur.user_id ";
                $sql .="LEFT JOIN mst_cities mct ON ur.city_id = mct.id ";
                $sql .="LEFT JOIN mst_ages ma ON ma.id = ur.age_id ";
                $sql .="LEFT JOIN mst_height mth ON ur.height_id = mth.id ";
                $sql .="LEFT JOIN mst_salary_range mts ON ur.hope_salary_id = mts.id ";
                $sql .="WHERE u.user_status = 1 AND (u.scout_target_flag != 1 OR u.scout_target_flag IS NULL) AND u.display_flag = 1 ";
                if ($unique_id) {
                    $sql .= " AND u.unique_id=? ";
                    $params[] = $unique_id;
                }
                $sql .="AND u.id NOT IN(SELECT lum.user_id ";
                $sql .="FROM owners INNER JOIN owner_recruits ON owners.id = owner_recruits.owner_id ";
                $sql .="  INNER JOIN list_user_messages lum ON owner_recruits.id = lum.owner_recruit_id ";
                $sql .="  INNER JOIN mst_templates mt ON mt.id = lum.template_id ";
                $sql .="WHERE owners.display_flag = 1 AND owners.id = ? AND lum.is_read = 0 ";
                $params[] = $owner_id;
                $sql .='AND u.last_visit_date < lum.created_date ';
                $sql .='AND (mt.template_type = "us03" OR mt.template_type = "us14")) ';
                $sql .="AND u.id NOT IN (SELECT user_id FROM scout_message_spams WHERE display_flag = 1 AND owner_id = ?)";
                $params[] = $owner_id;
                if( count($owner_hidden_users) > 0 ) {
                    $sql .= " AND u.id NOT IN ('" . $owner_hidden_users_str . "') ";
                }
                $sql .= $sqlchecksub;
                $sql .= " ORDER BY " . $order_by . ' LIMIT ?,? ';
                $page = ($page - 1) * intval($posts_per_page);
                $params[] = $page;
                $params[] = intval($posts_per_page);
                $params[] = $owner_id;

                // 1. First get search users
                $query = $this->db->query($sql, $params);
                $user_id_list = $query->result_array();

                // 2. Second get additional information for those search users
                if ($user_id_list && is_array($user_id_list)) {
                    foreach ($user_id_list as $user_info) {
                        $user_id = $user_info['id'];
                        $user_addition_infor = array();
                        // get scout mail send/read number per owner
                        if ($receive_read_data = $this->_get_receive_read_data_per_owner($owner_id, $user_id)) {
                            $user_addition_infor = array_merge($user_addition_infor, $receive_read_data);
                        }
                        // get action statistics from user
                        if ($user_statistics_data = $this->_get_user_action_statistics($owner_id, $user_id)) {
                            $user_addition_infor = array_merge($user_addition_infor, $user_statistics_data);
                        }
                        // get scout mail status
                        if ($mail_status_data = $this->_get_scout_mail_status($owner_id, $user_id)) {
                            $user_addition_infor = array_merge($user_addition_infor, $mail_status_data);
                        }
                        if ($user_addition_infor && is_array($user_addition_infor)) {
                            $ret_user_info[] = array_merge($user_info, $user_addition_infor);
                        }
                    }
                }
            break;
        }

        return $ret_user_info;
    }

    // get number of mail sent by owner_id and read by user_id
    private function _get_receive_read_data($user_id) {
        $ret = array( "received_no" => 0, "openned_no" => 0); // default
        if (!$user_id) {
            return $ret;
        }
        $sql = "SELECT received_no, openned_no,";
        $sql .= "CASE WHEN usl.open_rate IS NULL OR usl.open_rate = '' THEN 0 ELSE usl.open_rate END AS open_rate ";//
        $sql .= "FROM user_sort_list usl ";///
        $sql .= "WHERE user_id = ? ";
        $params[] = $user_id;

        $query = $this->db->query($sql, $params);
        if ($query && $query->num_rows() > 0) {
            $ret = $query->row_array();
        }

        return $ret;
    }

    // get number of mail sent by owner_id and read by user_id
    private function _get_receive_read_data_per_owner($owner_id, $user_id) {
        $ret = null;
        if (!$owner_id || !$user_id) {
            return $ret;
        }
        $sql  = "SELECT ";
        $sql .= "CASE WHEN osl.receive_num IS NULL OR osl.receive_num = '' THEN 0 ELSE osl.receive_num END AS received_no,";
        $sql .= "CASE WHEN osl.open_mail_num IS NULL OR osl.open_mail_num = '' THEN 0 ELSE osl.open_mail_num END AS openned_no,";
        $sql .= "CASE WHEN usl.open_rate IS NULL OR usl.open_rate = '' THEN 0 ELSE usl.open_rate END AS open_rate ";//
        $sql .= "FROM users us ";
        $sql .= "LEFT JOIN user_sort_list usl ON us.id = usl.user_id ";///
        $sql .= "LEFT JOIN owner_sort_list osl ON us.id = osl.user_id AND osl.owner_id = ? AND osl.user_id = ? ";
        $params[] = $owner_id;
        $params[] = $user_id;
        $sql .= " WHERE us.id = ? AND us.user_status = 1 AND us.display_flag = 1";
        $params[] = $user_id;

        $query = $this->db->query($sql, $params);
        if ($query && $query->num_rows() > 0) {
            $ret = $query->row_array();
        }

        return $ret;
    }


    private function _get_user_action_statistics($owner_id, $user_id) {
        $ret = null;
        if (!$user_id || !$owner_id) {
            return $ret;
        }
        $sql = "SELECT ";
        $sql .= "IFNULL(mail_click + tel_click + line_click + question_no, 0) AS reply_no, ";
        $sql .= "IFNULL(hp_click + kuchikomi_click, 0) AS hp_no, ";
        $sql .= "IFNULL(tel.status, 0) AS travel_status ";
        $sql .= "FROM users us ";
        $sql .= "LEFT JOIN user_statistics ust ON ust.user_id = us.id ";
        $sql .= "LEFT JOIN travel_expense_list tel ON ";
        $sql .= "  tel.user_id = us.id AND tel.display_flag = 1 AND tel.status = 3 AND tel.owner_id = ? AND tel.user_id = ? ";
        $params[] = $owner_id;
        $params[] = $user_id;
        $sql .= " WHERE us.id = ? AND us.user_status = 1 AND us.display_flag = 1";
        $params[] = $user_id;

        $query = $this->db->query($sql, $params);
        if ($query && $query->num_rows() > 0) {
            $ret = $query->row_array();
        }

        return $ret;
    }

    private function _get_scout_mail_status($owner_id, $user_id) {
        $ret = array("is_read" => 0, "sm_created_date" => null);
        if (!$user_id || !$owner_id) {
            return $ret;
        }

        $sql = "SELECT IFNULL(lum.is_read, 0) AS is_read, lum.created_date as sm_created_date ";
        $sql .= "FROM list_user_messages lum ";
        $sql .= "INNER JOIN owner_recruits owr ON lum.owner_recruit_id = owr.id ";
        $sql .= "INNER JOIN owners ow ON ow.id = owr.owner_id ";
        $sql .= "INNER JOIN mst_templates mt ON mt.id = lum.template_id AND (mt.template_type = 'us03' or mt.template_type = 'us14') ";
        $sql .= "WHERE ow.id = ? AND lum.user_id = ? and lum.display_flag = 1 ";
        $sql .= "order by lum.id desc LIMIT 1";
        $params[] = $owner_id;
        $params[] = $user_id;

        $query = $this->db->query($sql, $params);
        if ($query && $query->num_rows() > 0) {
            $ret = $query->row_array();
        }

        return $ret;
    }
}

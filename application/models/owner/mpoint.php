<?php

class Mpoint extends CommonQuery {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    /**
     * @author  [IVS] Phan Ngoc Minh Luan
     * @name 	updateStatusPayForApplyUserPayment
     * @todo 	update Status pay for apply in table user_payments
     * @param 	int $owner_recruit_id, $current_status, $last_status
     * @param   string $email_address
     * @return 	int
     */
    public function updateStatusPayForApplyUserPayment($arr_payment_id, $current_status, $last_status) {
        $data = array(
            'user_payment_status' => $last_status,
        );
        $param = array(
            'user_payment_status' => $current_status,
        );
        $this->db->where_in('id', $arr_payment_id);
        $this->db->where($param);
        $this->db->update('user_payments', $data);
        return $this->db->affected_rows();
    }

    /**
     * @author  [IVS] Phan Ngoc Minh Luan
     * @name 	updateDisplayFlagListUserMessage
     * @todo 	update display_flag table list_user_messages
     * @param 	int $owner_recruit_id, $current_status, $last_status
     * @param   string $email_address
     * @return 	int
     */
    public function updateDisplayFlagListUserMessage($owner_recruit_id) {
        $data = array(
            'display_flag' => 0,
        );
        $param = array(
            'owner_recruit_id' => $owner_recruit_id,
        );
        $this->db->where($param);
        $this->db->update('list_user_messages', $data);
        return $this->db->affected_rows();
    }

    /**
     * @author  [IVS] Phan Ngoc Minh Luan
     * @name 	getArrayUserIdFromUserPayment
     * @todo 	get Array user_id From user_payments
     * @param 	$arr_owner_recruit_id, $user_payment_status
     * @return 	int
     */
    public function getArrayUserIdFromUserPayment($arr_owner_recruit_id, $user_payment_status) {
        $data = array(
            'user_payment_status' => $user_payment_status,
            'display_flag' => 1,
        );
        $this->db->select('user_id');
        $this->db->where_in('owner_recruit_id', $arr_owner_recruit_id);
        $this->db->group_by('user_id');
        $query = $this->db->get_where('user_payments', $data);
        if ($query->num_rows > 0) {
            return $array_user_id = $query->result_array();
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
    public function insertListUserMessage($owner_recruit_id, $user_id,$template, $payment_message_status, $scout_mail_template_id) {
        $row = $this->getTemplateFromTemplate_type($template);
        $date = $this->getCurrentDate();
        $data = array(
            'owner_recruit_id' => $owner_recruit_id,
            'user_id' => $user_id,
            'owner_scout_mail_pr_id' => $scout_mail_template_id,
            'user_message_status' => 1,
            'template_id' => $row['id'],
            'is_hide' => 1,
            'is_read' => 0,
            'created_date' => $date,
            'updated_date' => $date,
            'payment_message_status' => $payment_message_status,
        );
        $this->db->insert('list_user_messages', $data);
        return $this->db->insert_id();
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
        $sql  .='SELECT user_id, COUNT(user_id) as received_no, SUM(is_read) as openned_no,  SUM(is_read) / COUNT(user_id) AS open_rate FROM list_user_messages AS lum ';
        $sql  .='INNER JOIN mst_templates mt ON lum.template_id = mt.id AND (mt.template_type = "us03" OR mt.template_type = "us14") ';
        $sql  .='WHERE lum.user_id = ? and lum.display_flag = 1 ';
        $sql  .=' ON DUPLICATE KEY UPDATE open_rate = VALUES(open_rate), received_no = values(received_no), openned_no = values(openned_no)';
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
        $sql .='AND owr.owner_id = ? AND user_id = ? ';
        $params[] = $owner_id;
        $params[] = $user_id;
        $sql .='ON DUPLICATE KEY UPDATE receive_num = VALUES(receive_num),open_mail_num = VALUES(open_mail_num)';
        $this->db->query($sql, $params);
    }

    /**
     * @author  [IVS] Phan Ngoc Minh Luan
     * @name 	checkExistListUserMessages
     * @todo 	check owner_recruit_id and user_id exist or not
     * @param 	int $owner_recruit_id, $user_id
     * @return 	int
     */
    public function checkExistListUserMessage($owner_recruit_id, $user_id) {
        $param = array(
            'owner_recruit_id' => $owner_recruit_id,
            'user_id' => $user_id,
            'payment_message_status' => 1,
        );
        $query = $this->db->get_where('list_user_messages', $param);
        if ($this->db->affected_rows()) {
            return 0;
        }
        return 1;
    }

    /**
     * @author  [IVS] Phan Ngoc Minh Luan
     * @name 	checkExistListUserMessages
     * @todo 	check owner_recruit_id and user_id exist or not
     * @param 	int $owner_recruit_id, $user_id
     * @return 	int
     */
    public function checkExistList($owner_recruit_id, $arr_user_id) {
        $param = array(
            'owner_recruit_id' => $owner_recruit_id,
        );
        $this->db->where_in('user_id', $arr_user_id);
        $query = $this->db->get_where('list_user_messages', $param);
        if ($this->db->affected_rows()) {
            return $query->num_rows();
        }
        return 0;
    }

    /**
     * @author  [IVS] Phan Ngoc Minh Luan
     * @name 	getArrayAppSettlement
     * @todo 	get Array user app settlement
     * @param 	$owner_id
     * @return 	int
     */
    public function getArrayAppSettlement($owner_id) {
        $cond = array(
            'user_payment_status' => 0,
            'owner_id' => $owner_id,
        );
        $this->db->select('user_id');
        $this->db->from('owner_recruits');
        $this->db->join('user_payments', 'user_payments.owner_recruit_id = owner_recruits.id');
        $this->db->where($cond);
        $query = $this->db->get();
        if ($query->num_rows > 0) {
            return $array_user_id = $query->result_array();
        }
        return 0;
    }

}

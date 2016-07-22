<?php

class Mtemplate extends CI_Model {

    
    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

     /**
     * @author  [IVS] Lam Tu My Kieu
     * @name 	getTemp
     * @todo 	get all templates (by template_type)
     * @param 	var $type
     * @return 	data
     */
    function getTemp($type) {

        $sql = "SELECT id, title, content 
        FROM mst_templates 
        WHERE template_type =?";
        $query = $this->db->query($sql,array($type));
        return $query->row_array();
    }
    
     /**
     * @author  [IVS] Lam Tu My Kieu
     * @name 	getOwnerRecruit
     * @todo 	get owner recruit by owner_id
     * @param 	int $owner_id
     * @return 	data
     */
    function getOwnerRecruit($owner_id)
    {
        $sql="SELECT id 
              FROM owner_recruits
              WHERE display_flag=1 AND owner_recruits.owner_id = ?";
        $query=$this->db->query($sql, array($owner_id));
        return $query->result_array();
    }
    
     /**
     * @author  [IVS] Lam Tu My Kieu
     * @name 	updateUserPayment
     * @todo 	update user payment
     * @param 	$data_up, int $user_id
     * @return 	data
     */

    
     public function updateUserPayment($data_up, $user_id, $owner_recruit_id) {                 
        $this->db->where('user_id', $user_id);
        $this->db->where('owner_recruit_id', $owner_recruit_id);
        $this->db->update('user_payments', $data_up);
    }
    
     /**
     * @author  [IVS] Lam Tu My Kieu
     * @name 	updateUserPaymentHideOrReturn
     * @todo 	update user payment hide or return
     * @param 	$data, $user_id, $owner_id
     * @return 	data
     */
    
    public function updateUserPaymentHideOrReturn($data, $user_id, $owner_recruit_id) {
        $this->db->where('user_id', $user_id);
        $this->db->where('owner_recruit_id', $owner_recruit_id);
        $this->db->update('user_payments', $data);
    }

     /**
     * @author  [IVS] Lam Tu My Kieu
     * @name 	insertOwnerList
     * @todo 	insert owner list
     * @param 	$data_ow
     * @return 	data
     */
    
    public function insertOwnerList($data_ow) {
        
        $this->db->insert('list_owner_messages', $data_ow);
    }
    
     /**
     * @author  [IVS] Lam Tu My Kieu
     * @name 	insertUserList
     * @todo 	insert user list
     * @param 	$data_us
     * @return 	data
     */
    
    public function insertUserList($data_us) {
       
        $this->db->insert('list_user_messages', $data_us);
    }
    
    /**
     * @author  [IVS] Lam Tu My Kieu
     * @name 	updateUserListForScout
     * @todo 	update user list for scout
     * @param 	$data_us, $user_id
     * @return 	data
     */
    
//    public function updateUserListForScout($data_us, $user_id, $tem_id, $owner_recruit_id) {
//       
//      
//        $this->db->where('user_id', $user_id);
//        $this->db->where('template_id', $tem_id);
//        $this->db->where('owner_recruit_id', $owner_recruit_id);
//        $this->db->update('list_user_messages', $data_us);
//    }
    
    /**
     * @author  [IVS] Phan Ngoc Minh Luan
     * @name 	insertUserListForScout
     * @todo 	insert user list for scout
     * @param 	$data_us, $user_id
     * @return 	data
     */
    
    public function insertUserListForScout($owner_recruit_id, $user_id, $tem_id, $payment_message_status) {             
        $date = date('y-m-d G:i:s', now());
        $data = array(
            'owner_recruit_id' => $owner_recruit_id,
            'user_id' => $user_id,
            'user_message_status' => 1,
            'template_id' => $tem_id,
            'is_hide' => 1,
            'is_read' => 0,
            'created_date' => $date,
            'updated_date' => $date,
            'payment_message_status' => $payment_message_status,
        );
        $this->db->insert('list_user_messages', $data);
    }

     /**
     * @author  [IVS] Lam Tu My Kieu
     * @name 	checkScoutUser
     * @todo 	check send scout for user
     * @param 	$data_us, $user_id
     * @return 	data
     */
    
    public function checkScoutUser($user_id, $owner_id) {
       
      $params = array($user_id, $owner_id);
        $sql = "SELECT COUNT(*) AS total

FROM users u
INNER JOIN scout_message_spams s ON s.`user_id` = u.`id`
INNER JOIN owners o ON s.`owner_id`=o.`id`
     
WHERE u.display_flag = 1 AND o.`display_flag`=1 AND s.display_flag = 1
AND u.id = ? AND o.`id`=?";
        
        $query = $this->db->query($sql, $params);
        $row = $query->row_array();
        return $row['total'];
    }
    
   
    
    
   /**
     * @author  [IVS] Nguyen Bao Trieu
     * @name 	insertOwnerTemplate
     * @todo 	insert Owner Template
     * @param 	$data
     * @return 	data
     */    
    public function insertOwnerTemplate($data)
    {
        $this->db->insert('list_owner_messages', $data);
    }
    
    /**
     * @author  [IVS] Nguyen Hong Duc
     * @name 	updateUserPayment
     * @todo 	update user payment status
     * @param 	$data_up, int $user_id,$owner_recruit_id
     * @return 	data
     */

    
     public function updateUserPaymentStatus($data_up, $user_id, $owner_recruit_id) {                 
        $this->db->where('user_id', $user_id);
        $this->db->where('owner_recruit_id', $owner_recruit_id);
        $this->db->update('user_payments', $data_up);
    }
}
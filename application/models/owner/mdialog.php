<?php

class Mdialog extends CommonQuery {

    function __construct() {
        parent::__construct();
    }

    /**
     * @author  [IVS] Phan Ngoc Minh Luan
     * @name 	updateStatusTranferPayment
     * @todo 	update point and amount in table Payment
     * @param   $owner_id,$payment_method_id, $payment_case_id
     * @return 	int
     */
    public function updateStatusTranferPayment($payment_id, $payment_name, $tranfer_date) {

        $param = array(
            'payment_status' => 1,
            'payment_name' => $payment_name,
            'updated_date' => $this->getCurrentDate(),
            'tranfer_date' => $tranfer_date,
        );
        $cond = array(
            'id' => $payment_id,
            'payment_status' => 0,
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
     * @name 	countPenalty
     * @todo 	count number user penalty
     * @param   $owner_id
     * @return 	int
     */
    public function countPenalty($owner_id) {
        $hours = $this->config->item('hours');
        $sql = "SELECT *
                FROM
                    user_payments UP 
                    INNER JOIN 
                    owner_recruits ORC
                    ON ORC.id = UP.owner_recruit_id                                     
                WHERE UP.display_flag = 1 
                    AND UP.user_payment_status = 5 
                    AND TIME_TO_SEC(TIMEDIFF(NOW(),request_money_date))/3600 > ?  
                    AND ORC.owner_id = ? ";
        $query = $this->db->query($sql, array($hours,$owner_id));
        if($this->db->affected_rows()){
            return 1;
        }
        return 0;
    }
    
    /**
     * @author  [IVS] Phan Ngoc Minh Luan
     * @name 	updateOwnerStatus
     * @todo 	update OwnerStatus
     * @param   $status
     * @return 	int
     */
    public function updateOwnerStatus($owner_id,$status) {
        $this->db->where(array('id'=>$owner_id));
        $this->db->update('owners',array('owner_status'=>$status));
    }

}

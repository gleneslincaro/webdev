<?php
    class Mpayment extends CI_Model{
        public function __construct() {
            parent::__construct();
        }
        
        /**
         * @author     [IVS] Nguyen Van Vui
         * @name        listRewardDelete
         * @todo        view info reward will delete
         * @param 	 
         * @return 	
         */

        function listRewardDelete(){
            $sql="SELECT up.`id`, u.`unique_id`, u.`name`, up.`approved_date`, u.`bank_name`, u.`bank_agency_name`, osr.id osr_id,
                         u.`account_type`, u.`account_no`, u.`account_name`, mhm.`user_happy_money`, o.`id` AS ownerid, u.`id` AS userid
                        FROM users u
                        INNER JOIN user_payments up
                                ON u.id= up.user_id 
                        INNER JOIN owner_recruits osr
                                ON osr.id= up.`owner_recruit_id`
                        INNER JOIN owners o
                                ON osr.`owner_id` = o.`id`
                        INNER JOIN mst_happy_moneys mhm
                                ON mhm.id = osr.`happy_money_id`
                        WHERE up.`user_payment_status`=6
                        AND up.payment_date IS NULL 
                        AND up.`display_flag` = 1";
            $result=$this->db->query($sql);
            return $result->result_array();
        }
        
        /**
         * @author     [IVS] Nguyen Van Vui
         * @name        listRewardReturnDownload
         * @todo        view info reward will delete to download file csv
         * @param 	 
         * @return 	
         */

        function listRewardReturnDownload(){
            $sql="SELECT up.`approved_date`, u.`bank_name`, u.`bank_agency_name`,
                         u.`account_type`, u.`account_no`, u.`account_name`, mhm.`user_happy_money`
                        FROM users u
                        INNER JOIN user_payments up
                                ON u.id= up.user_id 
                        INNER JOIN owner_recruits osr
                                ON osr.id= up.`owner_recruit_id`
                        INNER JOIN owners o
                                ON osr.`owner_id` = o.`id`
                        INNER JOIN mst_happy_moneys mhm
                                ON mhm.id = osr.`happy_money_id`
                        WHERE up.`user_payment_status`=6
                        AND up.payment_date IS NULL
                        AND up.`display_flag` = 1";
            return $this->db->query($sql)->result_array();
        }
        
        /**
         * @author     [IVS] Nguyen Van Vui
         * @name        listRewardReturn
         * @todo        view info reward will return
         * @param 	 
         * @return 	
         */
        
        function listRewardReturn(){
            $sql="SELECT up.`id`, u.`unique_id`, u.`name`, up.`approved_date`, u.`bank_name`, u.`bank_agency_name`,
                         u.`account_type`, u.`account_no`, u.`account_name`, mhm.`user_happy_money`
                        FROM users u
                        INNER JOIN user_payments up
                                ON u.id= up.user_id 
                        INNER JOIN owner_recruits osr
                                ON osr.id= up.`owner_recruit_id`
                        INNER JOIN owners o
                                ON osr.`owner_id` = o.`id`
                        INNER JOIN mst_happy_moneys mhm
                                ON mhm.id = osr.`happy_money_id`
                        WHERE up.`user_payment_status`=6
                        AND up.`display_flag` = 0";
            $result=$this->db->query($sql);
            return $result->result_array();
        }
        
        /**
         * @author     [IVS] Nguyen Van Vui
         * @name        deleteReward
         * @todo        delete reward
         * @param 	 Array $where
         * @return 	
         */
        
        function deleteReward($where) {
            $this->db->set("display_flag", 0); 
            $this->db->where_in('id', $where);
            $this->db->update("user_payments");
        }
        
        /**
         * @author     [IVS] Nguyen Van Vui
         * @name        updatePaymentDate
         * @todo        delete reward
         * @param 	 Array $id
         * @return 	
         */
        
        function updatePaymentDate($id) {
            $this->db->set('payment_date', date('Y-m-d'));
            $this->db->where_in('id', $id);
            $this->db->update('user_payments');
        }
        
        /**
         * @author     [IVS] Nguyen Van Vui
         * @name        returnReward
         * @todo        return reward
         * @param 	 Array $where
         * @return 	
         */
        
        function returnReward($where) {
            $this->db->set("display_flag", 1);

            $this->db->where_in('id', $where);
            $this->db->update("user_payments");
        }
        
        /**
         * @author     [IVS] Nguyen Van Vui
         * @name        searchReward
         * @todo        search reward
         * @param 	 String $where, int $number, int $offset
         * @return 	
         */
        
        function searchReward($where,$number,$offset) {
            $sql="SELECT u.`unique_id`, u.`name`, up.`approved_date`, u.`bank_name`, u.`bank_agency_name`,
                         u.`account_type`, u.`account_no`, u.`account_name`, mhm.`user_happy_money`, up.`payment_date`
                        FROM users u
                        INNER JOIN user_payments up
                                ON u.id= up.user_id 
                        INNER JOIN owner_recruits osr
                                ON osr.id= up.`owner_recruit_id`
                        INNER JOIN owners o
                                ON osr.`owner_id` = o.`id`
                        INNER JOIN mst_happy_moneys mhm
                                ON mhm.id = osr.`happy_money_id`
                        WHERE up.`user_payment_status`=6
                        AND up.payment_date IS NOT NULL
                        AND up.`display_flag` = 1 ";
            $sql.=$where;
            $sql = $sql." ORDER BY up.`payment_date` DESC LIMIT ".$number." OFFSET ".$offset."";
            
            return $this->db->query($sql)->result_array();
            
        }
        
        /**
         * @author     [IVS] Nguyen Van Vui
         * @name        countReward
         * @todo        count reward
         * @param 	 String $where
         * @return 	
         */
         
        function countReward($where) {
            $sql="SELECT u.`unique_id`, u.`name`, up.`approved_date`, u.`bank_name`, u.`bank_agency_name`,
                         u.`account_type`, u.`account_no`, u.`account_name`, mhm.`user_happy_money`, up.`payment_date`
                        FROM users u
                        INNER JOIN user_payments up
                                ON u.id= up.user_id 
                        INNER JOIN owner_recruits osr
                                ON osr.id= up.`owner_recruit_id`
                        INNER JOIN owners o
                                ON osr.`owner_id` = o.`id`
                        INNER JOIN mst_happy_moneys mhm
                                ON mhm.id = osr.`happy_money_id`
                        WHERE up.`user_payment_status`=6
                        AND up.payment_date IS NOT NULL
                        AND up.`display_flag` = 1 ";
            $sql.=$where;
            
            return $this->db->query($sql)->num_rows();
            
        }
        
        /**
         * @author     [IVS] Nguyen Van Vui
         * @name        listPaymentCase
         * @todo        list Payment Case
         * @param 	 
         * @return 	
         */
         
        function listPaymentCase() {
            $sql='SELECT * FROM `mst_payment_cases` pc WHERE pc.`display_flag` = 1';
            return $this->db->query($sql)->result_array();
        }
        
        /**
         * @author     [IVS] Nguyen Van Vui
         * @name        countBank
         * @todo        count Bank
         * @param 	 
         * @return 	
         */
         
        function countBank($where) {
            $sql='SELECT pm.`id`, ow.`email_address`, ow.`storename`, pm.`payment_name`,
                    pm.`payment_status`, mpc.`name`, pm.`created_date`, pm.`tranfer_date`
                   FROM payments pm 
                   INNER JOIN owners ow ON pm.`owner_id` = ow.`id`
                   LEFT JOIN `mst_payment_cases` mpc ON  pm.`payment_case_id` = mpc.`id`
                   WHERE pm.`display_flag` = 1 ';
            $sql.=$where;
            return $this->db->query($sql)->num_rows();
        }
        
        /**
         * @author     [IVS] Nguyen Van Vui
         * @name        searchBank
         * @todo        view search bank
         * @param 	 
         * @return 	
         */
         
        function searchBank($where,$number,$offset) {
            $sql='SELECT pm.`id`, ow.`email_address`, ow.`storename`, pm.`payment_name`,
                    pm.`payment_status`, mpc.`name`, pm.`created_date`, pm.`updated_date` AS tranfer_date
                   FROM payments pm 
                   INNER JOIN owners ow ON pm.`owner_id` = ow.`id`
                   LEFT JOIN `mst_payment_cases` mpc ON  pm.`payment_case_id` = mpc.`id`
                   WHERE pm.`display_flag` = 1
                   AND pm.payment_status NOT IN (0) ';
            $sql.=$where;
            $sql = $sql." LIMIT ".$number." OFFSET ".$offset."";
            return $this->db->query($sql)->result_array();
        }
        
        /**
         * @author     [IVS] Nguyen Van Vui
         * @name        loadBankDetail
         * @todo        view Bank Detail by ID
         * @param 	 String $id
         * @return 	
         */
         
        function loadBankDetail($id) {
            $sql='SELECT pm.`id`, ow.`unique_id`, ow.`storename`, pm.`payment_name`,
                         pm.`tranfer_date`, pm.`amount`, pm.`payment_case_id`, ow.`id` idowner
                     FROM payments pm 
                     INNER JOIN owners ow ON pm.`owner_id` = ow.`id`
                     WHERE pm.`display_flag` = 1 AND pm.`id` = ?';
            return $this->db->query($sql,$id)->row_array();
        }
        
        /**
         * @author     [IVS] Nguyen Van Vui
         * @name        updatePayment
         * @todo        update payment
         * @param 	 String $id
         * @return 	    成功：　TRUE
         *              失敗: FALSE
         */
        function updatePayment($id, $payment_name = "", $credit_telno=""){
            $ret = false;
            $this->db->set('payment_status', 2);
            $this->db->set('approved_date', date('Y-m-d H:i:s'));
            if ( $payment_name ){
                $this->db->set('payment_name', $payment_name);
            }
            if ( $credit_telno ){
                $this->db->set('credit_telno', $credit_telno);
            }
            $this->db->where('id', $id);
            $this->db->update('payments');
            if($this->db->affected_rows() > 0){
                $ret = true;
            }
            return $ret;
        }
        

        /**
         * @author     [IVS] Nguyen Van Vui
         * @name        update_owner_by_payment_id
         * @todo        update total_amount, total_point owner
         * @param 	 String $id
         * @return 	
         */
         
        function update_owner_by_payment_id($id){
            $sql=   'UPDATE owners
                    SET total_amount = total_amount + (SELECT pm.`amount` FROM `payments` pm WHERE pm.`id` = ?),
                    total_point = total_point + (SELECT pm.`point` FROM `payments` pm WHERE pm.`id` = ?) 
                    WHERE id = (SELECT pm.`owner_id` FROM `payments` pm WHERE pm.`id` = ?)';
            return $this->db->query($sql,array($id,$id,$id));
        }
        
        /**
	 * @author  [IVS] Nguyen Van Vui
	 * @name    countDataByQuery	
	 * @todo 	
	 * @param 	 
	 * @return 	
	*/
        public function select_set_send_mail_from($table_name,$id){
            $sql='SELECT set_send_mail FROM '.$table_name.' WHERE id = ?';
            return $this->db->query($sql,$id)->row_array();
        }
        
        /**
	 * @author  [IVS] Nguyen Van Vui
	 * @name    select_user_id_by_owner_id	
	 * @todo 	select user_id by owner_id
	 * @param 	 
	 * @return 	
	*/
        public function select_user_id_by_owner_id($id){
            $sql='SELECT DISTINCT 
                    OW.`email_address`,
                    PM.`amount`,
                    PM.`payment_name` AS payment_case,
                    PM.`point`,
                    PM.`amount_payment`,
                    PM.`point_payment`,
                    OW.`storename`,
                    OW.`total_amount`,
                    US.id AS user_id
                  FROM
                    `payments` PM 
                    INNER JOIN `mst_payment_methods` MPM 
                      ON PM.`payment_method_id` = MPM.`id` 
                    INNER JOIN `mst_payment_cases` MPC 
                      ON MPC.`id` = PM.`payment_case_id` 
                    INNER JOIN `owner_recruits` ORS 
                      ON ORS.`owner_id` = PM.`owner_id` 
                    INNER JOIN `user_payments` UP 
                      ON UP.`owner_recruit_id` = ORS.`id` 
                    INNER JOIN users US 
                      ON US.id = UP.`user_id` 
                    INNER JOIN owners OW 
                      ON ORS.`owner_id` = OW.`id` 
                  WHERE PM.`display_flag` = 1 
                    AND PM.`payment_status` = 2 
                    AND MPC.`display_flag` = 1 
                    AND ORS.`recruit_status` = 2 
                    AND UP.`display_flag` = 1 
                    AND UP.`user_payment_status` = 0 
                    AND PM.`payment_case_id` = 2 
                    AND OW.`id` = ? ';
            return $this->db->query($sql,$id)->result_array();
        }
          /**
	 * @author  [IVS] Nguyen Van Vui
	 * @name    select_user_id_by_owner_id	
	 * @todo 	select_user_id_by_owner_id_3
	 * @param 	 $id
	 * @return 	
	*/
        public function select_user_id_by_owner_id_3($id){
            $sql='SELECT DISTINCT 
                    OW.`email_address`,
                    PM.`amount`,
                    PM.`payment_name` AS payment_case,
                    PM.`point`,
                    PM.`amount_payment`,
                    PM.`point_payment`,
                    OW.`storename`,
                    OW.`total_amount`,
                    US.id AS user_id
                  FROM
                    `payments` PM 
                    INNER JOIN `mst_payment_methods` MPM 
                      ON PM.`payment_method_id` = MPM.`id` 
                    INNER JOIN `mst_payment_cases` MPC 
                      ON MPC.`id` = PM.`payment_case_id` 
                    INNER JOIN `owner_recruits` ORS 
                      ON ORS.`owner_id` = PM.`owner_id` 
                    INNER JOIN `user_payments` UP 
                      ON UP.`owner_recruit_id` = ORS.`id` 
                    INNER JOIN users US 
                      ON US.id = UP.`user_id` 
                    INNER JOIN owners OW 
                      ON ORS.`owner_id` = OW.`id` 
                  WHERE PM.`display_flag` = 1 
                    AND PM.`payment_status` = 2 
                    AND MPC.`display_flag` = 1 
                    AND ORS.`recruit_status` = 2 
                    AND UP.`display_flag` = 1 
                    AND UP.`user_payment_status` = 0 
                    AND PM.`payment_case_id` = 3 
                    AND OW.`id` = ? ';
            return $this->db->query($sql,$id)->result_array();
        }
        
        public function select_user_id_by_owner_id_ss05($id){
            $sql='SELECT DISTINCT OW.`total_amount`,
                    OW.`email_address`,
                    PM.`amount`,
                    PM.`payment_name` AS payment_case,
                    PM.`point`,
                    OW.`storename`,                   
                    US.id AS user_id
                  FROM
                    `payments` PM 
                    INNER JOIN `mst_payment_methods` MPM 
                      ON PM.`payment_method_id` = MPM.`id` 
                    INNER JOIN `mst_payment_cases` MPC 
                      ON MPC.`id` = PM.`payment_case_id` 
                    INNER JOIN `owner_recruits` ORS 
                      ON ORS.`owner_id` = PM.`owner_id` 
                    INNER JOIN `user_payments` UP 
                      ON UP.`owner_recruit_id` = ORS.`id` 
                    INNER JOIN users US 
                      ON US.id = UP.`user_id` 
                    INNER JOIN owners OW 
                      ON ORS.`owner_id` = OW.`id` 
                  WHERE PM.`display_flag` = 1 
                    AND PM.`payment_status` = 2 
                    AND MPC.`display_flag` = 1 
                    AND ORS.`recruit_status` = 2 
                    AND UP.`display_flag` = 1 
                    AND UP.`user_payment_status` = 0 
                    AND PM.`payment_case_id` = 2 
                    AND OW.`id` = ?';
            return $this->db->query($sql,$id)->result_array();
        }
        /**
	 * @author  [IVS] Nguyen Minh Ngoc
	 * @name    getListUser
	 * @todo 	select user_list from payments table
	 * @param 	 $id
	 * @return 	
	*/
        public function getListUser($id){
            $sql="select user_list from payments where id = ?";
            return $this->db->query($sql,$id)->result_array();
        }
          /**
	 * @author  [IVS] Nguyen Minh Ngoc
	 * @name    updatePaymentMessage
	 * @todo 	update payment_message_status from list_user_message table
	 * @param 	 $pid
	 * @return 	
	*/
        public function updatePaymentMessage($pid){
            $sql="UPDATE `list_user_messages` SET list_user_messages.`payment_message_status`= 1 
                WHERE id IN ( SELECT transactions.`reference_id` 
                FROM transactions INNER JOIN `payments` ON payments.`id` = `transactions`.`payment_id` 
                WHERE transactions.`display_flag` = 1 AND payments.`id` = ? )";
            $this->db->query($sql,$pid);
        }
            /**
	 * @author  [IVS] Nguyen Minh Ngoc
	 * @name    updatePaymentMessage
	 * @todo 	update payment_message_status from list_user_message table
	 * @param 	 $pid
	 * @return 	
	*/
        public function updatePaymentMessage2($pid){
            $sql="UPDATE `list_user_messages` SET list_user_messages.`payment_message_status`= 1 
                WHERE `user_id` IN (SELECT  `user_payments`.`user_id`
                 FROM `payments` 
                INNER JOIN `transactions`  ON payments.id= transactions.`payment_id` AND payments.owner_id=`transactions`.`owner_id`
                INNER JOIN `user_payments` ON  `user_payments`.`id`= `transactions`.`reference_id`
                WHERE transactions.`display_flag` = 1 AND payments.`id` = ?)
                AND `owner_recruit_id` IN ( SELECT user_payments.`owner_recruit_id`AS ors_id
                 FROM `payments` 
                INNER JOIN `transactions`  ON payments.id= transactions.`payment_id` AND payments.owner_id=`transactions`.`owner_id`
                INNER JOIN `user_payments` ON  `user_payments`.`id`= `transactions`.`reference_id`
                WHERE transactions.`display_flag` = 1 AND payments.`id` = ?)
                AND `template_id`= 58";
            $this->db->query($sql,array($pid,$pid));
        }
           /**
	 * @author  [IVS] Nguyen Minh Ngoc
	 * @name    updatePaymentMessage
	 * @todo 	update payment_message_status from list_user_message table
	 * @param 	 $pid
	 * @return 	
	*/
        public function getEmail($id){
            $sql="select email_address from owners where id= ?";
            return $this->db->query($sql,$id)->result_array();
        }
       /**
	 * @author  [IVS] Nguyen Minh Ngoc
	 * @name    urlUs03
	 * @todo 	
	 * @param 	 $id
	 * @return 	
	*/
        public function urlUs03($id){
            $sql="SELECT id FROM `owner_recruits` WHERE `owner_id`=? AND `display_flag`=1 AND `recruit_status`=2";
            return $this->db->query($sql,$id)->result_array();
        }
    /**
	 * @author  [IVS] Nguyen Minh Ngoc
	 * @name    urlUs11
	 * @todo 
	 * @param 	 $id
	 * @return 	
	*/
        public function urlUs11($id){
            $sql="SELECT DISTINCT ORS.id FROM `owner_recruits` ORS 
                INNER JOIN `user_payments` UP
                ON UP.`owner_recruit_id`= ORS.id
                WHERE
                ORS.`recruit_status`=2 
                AND UP.display_flag=1
                AND UP.`user_payment_status`=6
                AND ORS.owner_id=?";
            return $this->db->query($sql,$id)->result_array();
        }
        /**
     * @author  VJソリューションズ
     * @name    get_payment_transaction
     * @todo    クレジットカード決済トランクトラクション取得
     * @param   ハッシュコード、　オンナーユニックID
     * @return  
    */
    public function get_payment_transaction($credit_hash, $owner_unique_id){
        $sql="  SELECT DISTINCT pm.*,m_pc.name FROM payments pm
                INNER JOIN mst_payment_cases m_pc
                ON pm.payment_case_id = m_pc.id
                WHERE pm.display_flag=1
                AND pm.credit_hash  = ?
                AND pm.payment_method_id = 1
                AND pm.payment_status = 0
                AND pm.owner_id = (select owner_id from owners where unique_id = ? limit 1)
                 ";
        $result = $this->db->query($sql,array($credit_hash, $owner_unique_id));
        if ( $result ){
            return $result->result_array();
        }else{
            return null;
        }
    }
       /**
     * @author  VJソリューションズ
     * @name    get_payment_transaction_from_id
     * @todo    クレジットカード決済トランクトラクション取得
     * @param   payment_id
     * @return  
    */
    public function get_payment_transaction_from_id($payment_id){
        $sql="SELECT DISTINCT * FROM payments
                WHERE display_flag = 1
                AND payment_method_id = 1
                AND id=?";
        $result = $this->db->query($sql,$payment_id);
        if ( $result ){
            return $result->result_array();
        }else{
            return null;
        }
    }
    /**
     * @author  VJソリューションズ
     * @name    checkUseCreditCard
     * @todo    クレジットカード決済使用履歴フラグ
     * @param   オンナーID
     * @return  使用したことあり クレジットカード最初に使用したときの電話番号
     *          使用したことあり FALSE
    */
    public function checkUseCreditCard($owner_id){
        $ret = false;
        if ( !$owner_id ){
            return $ret;
        }
        $sql="  SELECT credit_telno
                FROM payments
                WHERE display_flag=1
                AND credit_hash  <> ''
                AND payment_method_id = 1
                AND payment_status = 2
                AND payment_name <> ''
                AND approved_date <> ''
                AND credit_telno <> ''
                AND owner_id = ?
                ORDER BY created_date DESC
                ";
        $result = $this->db->query($sql, $owner_id);

        if ( $result && count($transactions = $result->result_array() ) > 0){
            $ret = $transactions[0]['credit_telno']; //一覧最新の電話番号を取得
        }
        return $ret;
    }
    /**
     * @author  VJソリューションズ
     * @name    delete_payment_transaction
     * @todo    クレジットカード決済トランクトラクション取得
     * @param   ハッシュコード、　オンナーユニックID
     * @return  削除成功 TRUE
     *          削除失敗 FALSE
    */
    public function delete_payment_transaction($credit_hash, $owner_unique_id){
        if ( !$credit_hash ){
            return false;
        }
        if ( !$owner_unique_id ){
            return false;
        }
        $sql=  "UPDATE payments
                SET display_flag = 0
                WHERE credit_hash  = ?
                AND payment_method_id = 1
                AND payment_status = 1
                AND owner_id = (select owner_id from owners where unique_id = ? limit 1) ";
        $this->db->query($sql,array($credit_hash, $owner_unique_id));
        if($this->db->affected_rows() > 0){
            $ret = true;
        }else{
            return false;
        }
    }
}
?>

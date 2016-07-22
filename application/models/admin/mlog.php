<?php
    class Mlog extends CI_Model{
        public function __construct() {
            parent::__construct();

        }
        /**
         * @author     [IVS] Phan Van Thuyet
         * @name        searchBySettlement
         * @todo        search by settlement
         * @param 	 
         * @return 	
         */
        public function searchBySettlement($where){
            $sql = "SELECT DATE_FORMAT(approved_date,'%Y/%m/%d') AS updated_date,
                           SUM(amount) AS amount, COUNT(approved_date) AS rowcount
                    FROM payments
                    WHERE `display_flag` = 1 AND payment_status = 2";                    
            $sql .= $where;
            $sql .= " GROUP BY DATE_FORMAT(`approved_date`, '%Y/%m/%d')";                
            return $this->db->query($sql)->result_array();
        }

        /**
         * @author     [IVS] Nguyen Van Vui
         * @name        listPaymentCases
         * @todo        view list payment cases
         * @param 	 
         * @return 	
         */

        function listPaymentCases(){
            $sql='SELECT id, name FROM mst_payment_cases WHERE `display_flag` = 1';
            $result=$this->db->query($sql);
            return $result->result_array();
        }
        
        /**
         * @author     [IVS] Nguyen Van Vui
         * @name        listPaymentCases
         * @todo        view list payment cases
         * @param 	 
         * @return 	
         */

        function listPaymentCasesPontLog(){
            $sql='SELECT id, name FROM mst_payment_cases WHERE `display_flag` = 1 AND id <> 4';
            $result=$this->db->query($sql);
            return $result->result_array();
        }
        
        /**
         * @author     [IVS] Nguyen Van Vui
         * @name        listPaymentMethods
         * @todo        view list payment methods
         * @param 	 
         * @return 	
         */

        function listPaymentMethods(){
            $sql='SELECT id, name FROM mst_payment_methods WHERE `display_flag` = 1';
            $result=$this->db->query($sql);
            return $result->result_array();
        }
        
        /**
         * @author     [IVS] Nguyen Van Vui
         * @name        listsettlementLog
         * @todo        view info settlement log
         * @param 	 String $where
         * @return 	
         */

        function listSettlementLog($where,$number,$offset) {
            $sql='SELECT o.unique_id, mpm.`name`, p.`amount`, p.payment_status, ifnull(p.`approved_date`,ifnull(p.`updated_date`,p.`created_date`)) AS tranfer_date, mpc.`name` AS mpcname
                    FROM `owners` o
                    INNER JOIN `payments` p
                    ON o.id = p.`owner_id`
                    LEFT JOIN `mst_payment_methods` mpm
                    ON p.`payment_method_id` = mpm.`id`
                    LEFT JOIN `mst_payment_cases` mpc
                    ON p.`payment_case_id` = mpc.id
                    WHERE o.`owner_status`= 2
                    AND o.`display_flag`=1
                    AND p.`display_flag`=1 ';
            $sql.=$where;
            $sql = $sql." ORDER BY tranfer_date DESC LIMIT ".$number." OFFSET ".$offset."";
            $result=$this->db->query($sql);
            return $result->result_array();
        }
        
        /**
         * @author     [IVS] Nguyen Van Vui
         * @name        sumAmount
         * @todo        view list payment methods
         * @param 	 String $where
         * @return 	
         */

        function sumAmount($where){
            $sql='SELECT SUM(p.`amount`) AS sumamount
                    FROM `owners` o
                    INNER JOIN `payments` p
                    ON o.id = p.`owner_id`
                    LEFT JOIN `mst_payment_methods` mpm
                    ON p.`payment_method_id` = mpm.`id`
                    LEFT JOIN `mst_payment_cases` mpc
                    ON p.`payment_case_id` = mpc.id
                    WHERE o.`owner_status`= 2 
                    AND o.`display_flag`=1
                    AND p.`display_flag`=1 ';
            $sql.=$where;
            $result=$this->db->query($sql);
            return $result->row_array();
        }
        
        
        
        /**
         * @author     [IVS] Nguyen Van Vui
         * @name        countSettlementLog
         * @todo        count settlement log
         * @param 	 String $where
         * @return 	
         */
         
        function countSettlementLog($where) {
            $sql='SELECT o.unique_id, mpm.`name`, p.`amount`, p.payment_status, p.`tranfer_date`, mpc.`name` AS mpcname
                    FROM `owners` o
                    INNER JOIN `payments` p
                    ON o.id = p.`owner_id`
                    LEFT JOIN `mst_payment_methods` mpm
                    ON p.`payment_method_id` = mpm.`id`
                    LEFT JOIN `mst_payment_cases` mpc
                    ON p.`payment_case_id` = mpc.id
                    WHERE o.`owner_status`= 2 
                    AND o.`display_flag`=1
                    AND p.`display_flag`=1 ';
            $sql.=$where;
            return $this->db->query($sql)->num_rows();
            
        }
        /**
         * @author     [IVS] Nguyen Van Vui
         * @name        listPointLog
         * @todo        view info point log
         * @param 	 String $where
         * @return 	
         */
        function listPointLog($where,$number,$offset) {
            $sql='SELECT ow.unique_id, sum(tr.`point`) as point, tr.`created_date`, mpc.`name`
                    FROM transactions tr
                    INNER JOIN owners ow 
                    ON ow.`id`= tr.`owner_id`
                    INNER JOIN mst_payment_cases mpc 
                    ON tr.`payment_case_id` = mpc.`id`
                    WHERE
                    ow.`owner_status`= 2 AND
                    tr.`display_flag`=1';                                        
            $sql.=$where;
            $sql.= ' GROUP BY ow.unique_id, DATE_FORMAT(tr.`created_date`,"%Y/%m/%d %H:%i"), mpc.`name` ORDER BY tr.`created_date` DESC';
            $sql = $sql." LIMIT ".$number." OFFSET ".$offset."";
            $result=$this->db->query($sql);
            return $result->result_array();
        }
        /**
	 * @author  [IVS] Nguyen Hoai Nam
	 * @name    getSearchAppQuery	
	 * @todo 	
	 * @param 	 
	 * @return 	
	*/
        public function getSearchAppQuery($dateFrom, $dateTo){
            $strQuery1 = "";
            $strQuery2 = "";
            if($dateFrom !=""){
                $strQuery1 = " AND DATEDIFF('".$this->db->escape_str($dateFrom)."',l.apply_date) <= 0 ";   
            }
            if($dateTo !=""){
                $strQuery2 = " AND DATEDIFF('".$this->db->escape_str($dateTo)."',l.apply_date) >= 0 ";   
            }
            return $sql = "SELECT o.email_address AS email_address, o.storename AS storename, u.unique_id AS idOfUser, 
                                    u.name AS nameOfUser, l.apply_date AS updated_date 
                           FROM user_payments l 
                           INNER JOIN users u ON l.user_id = u.id 
                           INNER JOIN owner_recruits r ON l.owner_recruit_id = r.id 
                           INNER JOIN owners o ON r.owner_id = o.id 
                           WHERE l.user_payment_status < 5
                           AND l.display_flag = 1".$strQuery1." ".$strQuery2." 
                           ORDER BY updated_date DESC ";
        }
        /**
	 * @author  [IVS] Nguyen Hoai Nam
	 * @name    countDataByQuery	
	 * @todo 	
	 * @param 	 
	 * @return 	
	*/
        public function countDataByQuery($sql){
            return $this->db->query($sql)->num_rows();
        }
        /**
	 * @author  [IVS] Nguyen Hoai Nam
	 * @name    getDataByQuery	
	 * @todo 	
	 * @param 	 
	 * @return 	
	*/
        public function getDataByQuery($sql){
            return $this->db->query($sql)->result_array();
        }
        /**
	 * @author  [IVS] Nguyen Hoai Nam
	 * @name    getResultSearchApp 	
	 * @todo 	
	 * @param 	 
	 * @return 	
	*/
        public function getResultSearchApp($sql,$limit,$offset){
            $sql = $sql."LIMIT ".$limit." OFFSET ".$offset."";
            return $this->db->query($sql)->result_array();
        }
        /**
	 * @author  [IVS] Nguyen Hoai Nam
	 * @name    getSearchSendsQuery	
	 * @todo 	
	 * @param 	 
	 * @return 	
	*/
        public function getSearchSendsQuery($dateFrom, $dateTo){
            $strQuery1 = "";
            $strQuery2 = "";
            if($dateFrom !=""){
                $strQuery1 = " AND DATEDIFF('".$this->db->escape_str($dateFrom)."',l.updated_date) <= 0 ";   
            }
            if($dateTo !=""){
                $strQuery2 = " AND DATEDIFF('".$this->db->escape_str($dateTo)."',l.updated_date) >= 0 ";   
            }
            return $sql = "SELECT DISTINCT  o.email_address AS email_address, o.storename AS storename, u.unique_id AS idOfUser, 
                                    u.name AS nameOfUser, l.updated_date AS pay_for_apply_date, l.scout_mail_open_date
                           FROM list_user_messages l 
                           INNER JOIN `mst_templates` mt ON l.`template_id` = mt.`id`
                           INNER JOIN users u ON l.user_id = u.id  
                           INNER JOIN owner_recruits r ON l.owner_recruit_id = r.id 
                           INNER JOIN owners o ON r.owner_id = o.id 
                           WHERE l.payment_message_status = 1
                           AND (mt.`template_type` ='us03' or mt.`template_type` ='us14') ".$strQuery1." ".$strQuery2." 
                           ORDER BY l.updated_date DESC ";
        }
    /* @author VJS
     *
     * @name    getOpenedRate    
     * @todo    get scout mail opened rate
     * @param   searching period: start data & end date
     * @return  percentage of opened mails / sent mail
    */
    public function getOpenedRate($dateFrom, $dateTo) {
        $ret = ""; // return value

        $sql = "SELECT count(l.id) as data_cnt FROM list_user_messages l
                INNER JOIN `mst_templates` mt ON l.`template_id` = mt.`id`
                WHERE (mt.`template_type` ='us03' or mt.`template_type` ='us14') ";

        $params = array();
        if ($dateFrom) {
            $sql .= " AND created_date >= ? ";
            $params[] = date("Y/m/d 00:00:01", strtotime($dateFrom));
        }
        if ($dateTo) {
            $sql .= " AND created_date <= ? ";
            $params[] = date("Y/m/d 23:59:59", strtotime($dateTo));
        }

        // get number of scout mails
        $total_mail_no = 0; // 
        $opened_no = 0;

        $query = $this->db->query($sql, $params);
        if ($query && $data = $query->row_array()) {
            $total_mail_no = $data['data_cnt'];
        }
        if ($total_mail_no > 0) {
            // get number of mails opened
            $sql .= " AND (active_flag = 0 or is_read = 1)"; // check opened mail
            $query = $this->db->query($sql, $params);
             if ($query && $data = $query->row_array()) {
                $opened_no = $data['data_cnt'];
             }
        }
        if ($total_mail_no > 0){
            $ret = number_format( ($opened_no * 100) / $total_mail_no, 1) . "% (".$opened_no."/".$total_mail_no.")";
        }

        return $ret;
    }
        /**
	 * @author  [IVS] Nguyen Hoai Nam
	 * @name    getResultSearchSends 	
	 * @todo 	
	 * @param 	 
	 * @return 	
	*/
        public function getResultSearchSends($sql,$limit,$offset){
            $sql = $sql."LIMIT ".$limit." OFFSET ".$offset."";
            return $this->db->query($sql)->result_array();
        }
        /**
	 * @author  [IVS] Nguyen Hoai Nam
	 * @name    getSearchCelebrationQuery	
	 * @todo 	
	 * @param 	 
	 * @return 	
	*/
        public function getSearchCelebrationQuery($dateFrom, $dateTo, $val){
            $strQuery1 = "";
            $strQuery2 = "";
            $strQuery3 = "";
            if($dateFrom !=""){
                $strQuery1 = " AND DATEDIFF('".$this->db->escape_str($dateFrom)."',l.approved_date) <= 0 ";   
            }
            if($dateTo !=""){
                $strQuery2 = " AND DATEDIFF('".$this->db->escape_str($dateTo)."',l.approved_date) >= 0 ";   
            }
            if($val !=""){
                $strQuery3 = " AND l.user_payment_status = ".$this->db->escape_str($val)." ";   
            }
            return $sql = "SELECT o.email_address AS email_address, o.storename AS storename, u.unique_id AS idOfUser, 
                                    u.name AS nameOfUser, l.request_money_date AS request_money_date, l.approved_date AS approved_date,
                                    l.user_payment_status AS user_payment_status, m.joyspe_happy_money AS joyspe_happy_money, m.user_happy_money AS user_happy_money
                           FROM user_payments l 
                           LEFT OUTER JOIN users u ON l.user_id = u.id 
                           LEFT OUTER JOIN owner_recruits r ON l.owner_recruit_id = r.id 
                           LEFT OUTER JOIN owners o ON r.owner_id = o.id
                           LEFT OUTER JOIN mst_happy_moneys m ON r.happy_money_id = m.id
                           WHERE l.user_payment_status > 4        
                           AND l.display_flag = 1".$strQuery1." ".$strQuery2." ".$strQuery3." 
                           ORDER BY approved_date DESC";
        }
        /**
	 * @author  [IVS] Nguyen Hoai Nam
	 * @name    getResultSearchCelebration	
	 * @todo 	
	 * @param 	 
	 * @return 	
	*/
        public function getResultSearchCelebration($sql,$limit,$offset){
            $sql = $sql." LIMIT ".$limit." OFFSET ".$offset."";
            return $this->db->query($sql)->result_array();
        }
        /**
         * @author     [IVS] Nguyen Van Vui
         * @name        sumAmount
         * @todo        view list payment methods
         * @param 	 String $where
         * @return 	
         */

        function sumPoint($where){
            $sql='SELECT SUM(tr.`point`)  AS sumpoint
                    FROM transactions tr
                    INNER JOIN owners ow 
                    ON ow.`id`= tr.`owner_id`
                    INNER JOIN mst_payment_cases mpc 
                    ON tr.`payment_case_id` = mpc.`id`
                    WHERE
                    ow.`owner_status`= 2 AND
                    tr.`display_flag`=1 ';
            $sql.=$where;
            $result=$this->db->query($sql);
            return $result->row_array();
        }
        
        /**
         * @author     [IVS] Nguyen Van Vui
         * @name        countPoint
         * @todo        count point log
         * @param 	 String $where
         * @return 	
         */
         
        function countPoint($where) {
            $sql='SELECT ow.unique_id, sum(tr.`point`), tr.`created_date`, mpc.`name`
                    FROM transactions tr
                    INNER JOIN owners ow 
                    ON ow.`id`= tr.`owner_id`
                    INNER JOIN mst_payment_cases mpc 
                    ON tr.`payment_case_id` = mpc.`id`
                    WHERE
                    ow.`owner_status`= 2 AND
                    tr.`display_flag`=1';                     
            $sql.=$where;
            $sql.= ' GROUP BY ow.unique_id, DATE_FORMAT(tr.`created_date`,"%Y/%m/%d %H:%i"), mpc.`name` ';
            
            return $this->db->query($sql)->num_rows();
            
        }
        
         /**
         * @author     [IVS] Nguyen Van Vui
         * @name        listPaymentCases
         * @todo        view list payment cases
         * @param 	 
         * @return 	
         */

        function listApprove(){
            $sql='SELECT id, name FROM mst_payment_cases WHERE `display_flag` = 1';
            $result=$this->db->query($sql);
            return $result->result_array();
        }
        public function searchOwnerStatistics($txtDateFrom=null,$txtDateTo=null,$limit=null,$start=0){
            $condition = '';
            $param = array();
            if ($txtDateFrom!=null&&$txtDateTo!=null) {
                $condition = " AND DATE(lum.created_date) BETWEEN ? AND ? ";
                $param = array($txtDateFrom,$txtDateTo,$txtDateFrom,$txtDateTo,$txtDateFrom,$txtDateTo);
            } elseif($txtDateFrom!=null && $txtDateTo==null) {
                $condition = " AND DATE(lum.created_date) >= ? ";
                $param = array($txtDateFrom,$txtDateFrom,$txtDateFrom);
            } elseif($txtDateFrom==null && $txtDateTo!=null) {
                $condition = " AND DATE(lum.created_date) <= ? ";
                $param = array($txtDateTo,$txtDateTo,$txtDateTo);
            }
            $sql = "SELECT ow.id,ow.unique_id,ow.storename,ow.last_visit_date,mcg.name AS area,
                  (SELECT COUNT(1) FROM list_user_messages lum
                      INNER JOIN owner_recruits owr ON (lum.owner_recruit_id = owr.id $condition)
                      WHERE owr.owner_id = ow.id AND lum.display_flag = 1 AND lum.is_read = 1) AS scout_mail_open,
                  (SELECT COUNT(1) FROM list_user_messages lum
                      INNER JOIN owner_recruits owr ON (lum.owner_recruit_id = owr.id $condition)
                      WHERE owr.owner_id = ow.id and lum.display_flag = 1) AS scout_mail_send,
                  (SELECT COUNT(1) FROM list_user_owner_messages lum WHERE owner_id = ow.id AND msg_from_flag= 0 AND display_flag = 1 $condition ) AS mails_receive
                  FROM owners ow
                  INNER JOIN owner_recruits owr ON (owr.owner_id = ow.id AND owr.display_flag = 1)
                  LEFT JOIN mst_city_groups mcg ON owr.city_group_id = mcg.id  
                  WHERE ow.display_flag = 1 and ow.public_info_flag = 1 and ow.owner_status = 2";
            if($limit!=null && $start > 0) {
                $sql .= " LIMIT $limit OFFSET $start ";
            } else if($limit!=null&& $start<=0) {
                $sql .= " LIMIT $limit OFFSET $start ";
            }
            $query = $this->db->query($sql,$param);
            $ret = $query->result_array();
            return $ret;
        }

         /**
         * @author     [VJS] KIyoshi Suzuki
         * @name        searchOwnerStatisticsAnalysis
         * @todo        view アクセス解析
         * @param    
         * @return  
         */
        public function searchOwnerStatisticsAnalysis($txtDateFrom=null,$txtDateTo=null,$limit=null,$start=0){
            $arrey1 = $this->searchOwnerAnalysis($limit,$start);
            $arrey2 = $this->searchOwnerAccessAnalysis($txtDateFrom,$txtDateTo,$arrey1);
            $arrey3 = $this->searchOwnerTravelAnalysis($txtDateFrom,$txtDateTo,$arrey1);
            $arrey4 = $this->searchOwnerCampaignBonusAnalysis($txtDateFrom,$txtDateTo,$arrey1);
            $arrey5 = $this->searchOwnerScoutAnalysis($txtDateFrom,$txtDateTo,$arrey1);
            $arrey6 = $this->searchOwnerClickAnalysis($txtDateFrom,$txtDateTo,$arrey1);
            $arrey7 = $this->searchOwnerContactAnalysis($txtDateFrom,$txtDateTo,$arrey1);
            foreach($arrey1 as $key1=>$ar1){
                $this->searchUserAnalysisScanning($arrey1[$key1],$arrey2,array('shop_access_num'));
                $this->searchUserAnalysisScanning($arrey1[$key1],$arrey3,array('travel_num'));
                $this->searchUserAnalysisScanning($arrey1[$key1],$arrey4,array('campaign_bonus_num'));
                $this->searchUserAnalysisScanning($arrey1[$key1],$arrey5,array("scout_mail_send","scout_mail_open","scout_open_rate"));
                $this->searchUserAnalysisScanning($arrey1[$key1],$arrey6,array("mail_click_num","tel_click_num","line_click_num","question_num","hp_click_num","kuchikomi_click_num"));
                $this->searchUserAnalysisScanning($arrey1[$key1],$arrey7,array('mails_receive'));
            }
            $ret = $arrey1;
            return $ret;
        }
        //UniqueID、店舗名、エリア、最終ログイン
        public function searchOwnerAnalysis($limit=null,$start=0){
            $param = array();
            $sql  = "SELECT ow.id,ow.unique_id,ow.storename,ow.last_visit_date,mcg.name AS area ";
            $sql .= "FROM owners ow ";
            $sql .= "INNER JOIN owner_recruits owr ON (owr.owner_id = ow.id AND owr.display_flag = 1) ";
            $sql .= "AND ow.display_flag = 1 and ow.public_info_flag = 1 and ow.owner_status = 2 ";
            $sql .= "LEFT JOIN mst_city_groups mcg ON owr.city_group_id = mcg.id ";
            if($limit!=null && $start > 0) {
                $sql .= " LIMIT $limit OFFSET $start ";
            } else if($limit!=null&& $start<=0) {
                $sql .= " LIMIT $limit OFFSET $start ";
            }
            return $this->db->query($sql,$param)->result_array();
        }
        //アクセス
        public function searchOwnerAccessAnalysis($txtDateFrom=null,$txtDateTo=null,$ar = array()){
            $condition2 = "";
            $param = array();
            if ($txtDateFrom!=null&&$txtDateTo!=null) {
                $condition2 = " AND visited_date >= ? AND visited_date <= ? ";
                $param = array($txtDateFrom,$txtDateTo);
            } elseif($txtDateFrom!=null && $txtDateTo==null) {
                $condition2 = " AND visited_date >= ? ";
                $param = array($txtDateFrom);
            } elseif($txtDateFrom==null && $txtDateTo!=null) {
                $condition2 = " AND visited_date <= ? ";
                $param = array($txtDateTo);
            }
            $sql  = "SELECT owner_id,COUNT(owner_id) AS shop_access_num ";
            $sql .= "FROM scout_owner_log";
            $sql .= " WHERE ";
            foreach ($ar as $key => $val){
                $sql .= ($key > 0)? " OR":"(";
                $sql .= " owner_id = ".$val["id"]; 
            }
            $sql .= ")";
            $sql .= $condition2;
            $sql .= " GROUP BY owner_id";
            return $this->db->query($sql,$param)->result_array();
        }
        //面接交通費
        public function searchOwnerTravelAnalysis($txtDateFrom=null,$txtDateTo=null,$ar = array()){
            $condition1 = "";
            $param = array();
            if ($txtDateFrom!=null&&$txtDateTo!=null) {
                $condition1 = " AND created_date >= ? AND created_date <= ? ";
                $param = array($txtDateFrom,$txtDateTo);
            } elseif($txtDateFrom!=null && $txtDateTo==null) {
                $condition1 = " AND created_date >= ? ";
                $param = array($txtDateFrom);
            } elseif($txtDateFrom==null && $txtDateTo!=null) {
                $condition1 = " AND created_date <= ? ";
                $param = array($txtDateTo);
            }
            $sql  = "SELECT owner_id,COUNT(owner_id) AS travel_num ";
            $sql .= "FROM travel_expense_list ";
            $sql .= " WHERE ";
            foreach ($ar as $key => $val){
                $sql .= ($key > 0)? " OR":"(";
                $sql .= " owner_id = ".$val["id"]; 
            }
            $sql .= ")".$condition1." GROUP BY owner_id";
            return $this->db->query($sql,$param)->result_array();
        }
        //体験入店
        public function searchOwnerCampaignBonusAnalysis($txtDateFrom=null,$txtDateTo=null,$ar=array()){
            $condition1 = "";
            $param = array();
            if ($txtDateFrom!=null&&$txtDateTo!=null) {
                $condition1 = " AND created_date >= ? AND created_date <= ? ";
                $param = array($txtDateFrom,$txtDateTo);
            } elseif($txtDateFrom!=null && $txtDateTo==null) {
                $condition1 = " AND created_date >= ? ";
                $param = array($txtDateFrom);
            } elseif($txtDateFrom==null && $txtDateTo!=null) {
                $condition1 = " AND created_date <= ? ";
                $param = array($txtDateTo);
            }
            $sql  = "SELECT owner_id,COUNT(owner_id) AS campaign_bonus_num ";
            $sql .= "FROM campaign_bonus_request_list ";
            $sql .= " WHERE ";
            foreach ($ar as $key => $val){
                $sql .= ($key > 0)? " OR":"(";
                $sql .= " owner_id = ".$val["id"]; 
            }
            $sql .= ")".$condition1." GROUP BY owner_id";
            return $this->db->query($sql,$param)->result_array();
        }
        //スカウト送信、開封数、開封率
        public function searchOwnerScoutAnalysis($txtDateFrom=null,$txtDateTo=null,$ar=array()){
            $condition3 = '';
            $param = array();
            if ($txtDateFrom!=null&&$txtDateTo!=null) {
                $condition3 = " AND lum.created_date >= ? AND lum.created_date <= ? ";
                $param = array($txtDateFrom,$txtDateTo);
            } elseif($txtDateFrom!=null && $txtDateTo==null) {
                $condition3 = " AND lum.created_date >= ? ";
                $param = array($txtDateFrom);
            } elseif($txtDateFrom==null && $txtDateTo!=null) {
                $condition3 = " AND lum.created_date <= ? ";
                $param = array($txtDateTo);
            }
            $sql   = "SELECT owner_id,";
            $sql  .= "COUNT(owr.owner_id) AS scout_mail_send,";
            $sql  .= "SUM(lum.is_read) AS scout_mail_open,";
            $sql  .= "COALESCE(SUM(lum.is_read) / COUNT(owr.owner_id),0) AS scout_open_rate ";
            $sql  .= "FROM list_user_messages lum ";
            $sql  .= "INNER JOIN owner_recruits owr ON lum.owner_recruit_id = owr.id ";
            $sql .= " WHERE ";
            foreach ($ar as $key => $val){
                $sql .= ($key > 0)? " OR":"(";
                $sql .= " owr.owner_id = ".$val["id"]; 
            }
            $sql .= ")".$condition3." GROUP BY owr.owner_id";
            return $this->db->query($sql,$param)->result_array();
        }
        //email,電話,line,匿名,HP,クチコミ
        public function searchOwnerClickAnalysis($txtDateFrom=null,$txtDateTo=null,$ar=array()){
            $condition1 = '';
            $param = array();
            if ($txtDateFrom!=null&&$txtDateTo!=null) {
                $condition1 = " AND created_date >= ? AND created_date <= ? ";
                $param = array($txtDateFrom,$txtDateTo);
            } elseif($txtDateFrom!=null && $txtDateTo==null) {
                $condition1 = " AND created_date >= ? ";
                $param = array($txtDateFrom);
            } elseif($txtDateFrom==null && $txtDateTo!=null) {
                $condition1 = " AND created_date <= ? ";
                $param = array($txtDateTo);
            }
            $sql = "SELECT owner_id,
                COUNT(if(action_type = 1, 1, null)) AS mail_click_num,
                COUNT(if(action_type = 2, 1, null)) AS tel_click_num,
                COUNT(if(action_type = 3, 1, null)) AS line_click_num,
                COUNT(if(action_type = 4, 1, null)) AS question_num, 
                COUNT(if(action_type = 5, 1, null)) AS hp_click_num, 
                COUNT(if(action_type = 6, 1, null)) AS kuchikomi_click_num FROM user_statistics_log ";
            $sql .= " WHERE ";
            foreach ($ar as $key => $val){
                $sql .= ($key > 0)? " OR":"(";
                $sql .= " owner_id = ".$val["id"]; 
            }
            $sql .= ")".$condition1." GROUP BY owner_id";
            return $this->db->query($sql,$param)->result_array();
        }
        //お問い合わせ受信数
        public function searchOwnerContactAnalysis($txtDateFrom=null,$txtDateTo=null,$ar=array()){
            $condition = '';
            $param = array();
            if ($txtDateFrom!=null&&$txtDateTo!=null) {
                $condition = " AND DATE(lum.created_date) BETWEEN ? AND ? ";
                $param = array($txtDateFrom,$txtDateTo);
            } elseif($txtDateFrom!=null && $txtDateTo==null) {
                $condition = " AND DATE(lum.created_date) >= ? ";
                $param = array($txtDateFrom);
            } elseif($txtDateFrom==null && $txtDateTo!=null) {
                $condition = " AND DATE(lum.created_date) <= ? ";
                $param = array($txtDateTo);
            }
            $sql  = "SELECT owner_id,COUNT(1) AS mails_receive "; 
            $sql .= "FROM list_user_owner_messages lum";
            $sql .= " WHERE ";
            foreach ($ar as $key => $val){
                $sql .= ($key > 0)? " OR":"(";
                $sql .= " owner_id = ".$val["id"]; 
            }
            $sql .= ") AND msg_from_flag= 0 AND display_flag = 1 ".$condition." GROUP BY owner_id";
            return $this->db->query($sql,$param)->result_array();
        }
        //解析データ配列結合
        public function searchUserAnalysisScanning(&$arrey1,&$arrey2,$keyname = array()){
            foreach($keyname as $key=>$val){
                $arrey1["$val"] = 0;
            }
            foreach($arrey2 as $key2=>$ar2){
                if($arrey1["id"] === $ar2["owner_id"]){
                    foreach($keyname as $key=>$val){
                        $arrey1["$val"] =  $ar2["$val"];
                    }
                    unset($arrey2[$key2]);
                    break;
                }
            }
            return;
        }

        public function searchUserStatisticsLog($dateFrom=null,$dateTo=null,$limit=0,$offset=0){
            $where = '';
            $subWhere = '';
            $limitCondition = '';
            $param = array();
            switch(true){
                  case ($dateFrom!=null&&$dateTo!=null):
                      $where = " WHERE DATE(usl.created_date) BETWEEN ? AND ? ";
                      $param[] = $dateFrom;
                      $param[] = $dateTo;
                      break;
                  case ($dateFrom!=null && $dateTo==null):
                      $where = " WHERE DATE(usl.created_date) >= ? ";
                      $param[] = $dateFrom;ak;
                  case ($dateFrom==null && $dateTo!=null):
                      $where = " WHERE DATE(usl.created_date) <= ? ";
                      $param[] = $dateTo;
                      break;
            }
            if($limit > 0) {
                $limitCondition = " LIMIT $limit OFFSET $offset ";
            }
            $sql = "SELECT usl.user_id,u.unique_id,usl.created_date,u.name,u.id,
                      SUM(IF(usl.action_type=1,1,0)) 'count_mail',
                      SUM(IF(usl.action_type=2,1,0)) 'count_tel',
                      SUM(IF(usl.action_type=3,1,0)) 'count_line',
                      SUM(IF(usl.action_type=4,1,0)) 'question_no',
                      SUM(IF(usl.action_type=5,1,0)) 'hp_click',
                      SUM(IF(usl.action_type=6,1,0)) 'count_kuchikomi'
                      FROM user_statistics_log usl
                      INNER JOIN users u ON usl.user_id = u.id 
                      ".$where." GROUP BY usl.user_id".$limitCondition; 
                      
            $query = $this->db->query($sql,$param);
            $ret = $query->result_array();
            return $ret;
        }
        
    }
?>

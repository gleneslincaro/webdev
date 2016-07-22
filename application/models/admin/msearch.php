<?php
    class Msearch extends CI_Model{
        public function __construct() {
            parent::__construct();
        }
          /**
	 * @author  [IVS] Nguyen Minh Ngoc
	 * @name 	getSearchUser
	 * @todo 	search user
	 * @param 	$emailAddress,$unique_id,$name,$account_name,$web_id,$datef_dktam,$datet_dktam,$datef_dk,$datet_dk,$m_status,$status,$memo
	 * @return
	*/
        public function getSearchUser($param){
            $stringTempSql1 = null;
            $stringTempSql2 = null;
            $stringTempSql3 = null;
            $stringTempSql4 = null;
            $stringTempSql5 = null;
            
            if($param['account_name']!=NULL){
                $stringTempSql1 = " AND us.account_name LIKE '%".$this->db->escape_like_str($param['account_name'])."%'";
            }
            if($param['datef_dktam']!=null && $param['datef_dktam'] !=""){
                $stringTempSql2 = " AND DATEDIFF('".$this->db->escape_str($param['datef_dktam'])."',temp_reg_date) <= 0 ";
            }
            if($param['datet_dktam']!=null && $param['datet_dktam'] !=""){
                $stringTempSql3 = " AND DATEDIFF('".$this->db->escape_str($param['datet_dktam'])."',temp_reg_date) >= 0 ";
            }
            if($param['datef_dk']!=null && $param['datef_dk']!=""){
                $stringTempSql4 = " AND DATEDIFF('".$this->db->escape_str($param['datef_dk'])."',offcial_reg_date) <= 0 ";
            }
            if($param['datet_dk']!=null && $param['datet_dk'] !=""){
                $stringTempSql5 = " AND DATEDIFF('".$this->db->escape_str($param['datet_dk'])."',offcial_reg_date) >= 0 ";
            }
         return $sql = "SELECT *,us.id as uid,web.name as wname,us.name as uname FROM users as us LEFT JOIN user_recruits as u ON us.id = u.id LEFT JOIN mst_websites as web ON web.id = us.website_id WHERE us.email_address LIKE '%".$this->db->escape_like_str($param['email_address'])."%'
             AND us.display_flag=1 AND us.unique_id LIKE '%".$this->db->escape_like_str($param['unique_id'])."%' AND us.name LIKE '%".$this->db->escape_like_str($param['name'])."%' AND us.website_id LIKE '%".$this->db->escape_like_str($param['web_id'])."%' AND us.magazine_status LIKE '%".$this->db->escape_like_str($param['m_status'])."%' AND us.user_status LIKE '%".$this->db->escape_like_str($param['status'])."%' AND IFNULL(us.memo,' ')
                 LIKE '%".$this->db->escape_like_str($param['memo'])."%' AND IFNULL(us.telephone_number, ' ') LIKE '%".$this->db->escape_like_str($param['telephone_number'])."%' AND IFNULL(us.telephone_record, ' ') LIKE '%".$this->db->escape_like_str($param['telephone_record'])."%' ".$stringTempSql1." ".$stringTempSql2." ".$stringTempSql3." ".$stringTempSql4." ".$stringTempSql5." ";
        }
       /**
	 * @author  [IVS] Nguyen Minh Ngoc
	 * @name 	listUser
	 * @todo
	 * @param
	 * @return
	*/
        public function listUser($sql,$limit,$offset){
            $sql = $sql." LIMIT ".$limit." OFFSET ".$offset."";
            return $this->db->query($sql)->result_array();
        }
         /**
	 * @author  [IVS] Nguyen Minh Ngoc
	 * @name 	showWebsite
	 * @todo
	 * @param
	 * @return
	*/
        public function showWebsite(){
            $this->db->select("*");
            $where=array(
                "type"=>1,
                "display_flag"=>1
            );
            $this->db->where($where);
            return $this->db->get("mst_websites")->result_array();
        }
          /**
	 * @author  [IVS] Nguyen Minh Ngoc
	 * @name 	countSearch
	 * @todo 	get total rows (paging)
	 * @param 	$sql
	 * @return 	data_result
	*/
        public function countSearch($sql){
          return $this->db->query($sql)->num_rows();
        }

        /**
	 * @author     [IVS] Nguyen Van Vui
	 * @name 	companyDetail
	 * @todo 	view company details
	 * @param
	 * @return
	 */

        function companyDetail($id) {
            $sql='SELECT ow.*, ws.`name` websitename
                    FROM `owners` ow
                    LEFT JOIN `mst_websites` ws ON ow.`website_id`=ws.`id`
                    WHERE ow.`id` = ?';
            return $this->db->query($sql,$id)->row_array();
        }

        /**
	 * @author     [IVS] Nguyen Van Vui
	 * @name 	countApplicants
	 * @todo 	Number of applicants
	 * @param
	 * @return
	 */

        function countApplicants($id) {
            $sql='SELECT *
                    FROM `user_payments` up
                    INNER JOIN `owner_recruits` owr
                    ON up.`owner_recruit_id` = owr.`id`
                    INNER JOIN owners ow
                    ON owr.`owner_id` = ow.`id`
                    WHERE ow.`id`= ?';
            return $this->db->query($sql,$id)->num_rows();
        }

        /**
	 * @author     [IVS] Nguyen Van Vui
	 * @name 	countApplicants
	 * @todo 	Public information number
	 * @param
	 * @return
	 */

        function countPublicInfo($id) {
            $sql='SELECT *
                    FROM `user_payments` up
                    INNER JOIN `owner_recruits` owr
                    ON up.`owner_recruit_id` = owr.`id`
                    INNER JOIN owners ow
                    ON owr.`owner_id` = ow.`id`
                    WHERE ow.`id`= ?
                    AND up.`interview_date` IS NOT NULL';
            return $this->db->query($sql,$id)->num_rows();
        }

        /**
	 * @author     [IVS] Nguyen Van Vui
	 * @name 	countScoutSent
	 * @todo 	count Scout Sent
	 * @param
	 * @return
	 */

        function countScoutSent($id) {
            $sql='SELECT *
                    FROM `list_user_messages` lum
                    INNER JOIN `owner_recruits` owr
                    ON lum.`owner_recruit_id` = owr.`id`
                    INNER JOIN owners ow
                    ON owr.`owner_id` = ow.`id`
                    WHERE ow.`id`= ? AND lum.`template_id`= 25';
            return $this->db->query($sql,$id)->num_rows();
        }

        /**
	 * @author     [IVS] Nguyen Van Vui
	 * @name 	countWorkingApprove
	 * @todo 	Count Working Approve
	 * @param
	 * @return
	 */

        function countWorkingApprove($id) {
            $sql='SELECT *
                    FROM `user_payments` up
                    INNER JOIN `owner_recruits` owr
                    ON up.`owner_recruit_id` = owr.`id`
                    INNER JOIN owners ow
                    ON owr.`owner_id` = ow.`id`
                    WHERE ow.`id`= ?
                    AND up.`user_payment_status` = 6';
            return $this->db->query($sql,$id)->num_rows();
        }

        /**
	 * @author     [IVS] Nguyen Van Vui
	 * @name 	countSendNumber
	 * @todo 	Count Send Number
	 * @param
	 * @return
	 */

        function countSendNumber($id) {
            $sql='SELECT *
                    FROM `user_payments` up
                    INNER JOIN `owner_recruits` owr
                    ON up.`owner_recruit_id` = owr.`id`
                    INNER JOIN owners ow
                    ON owr.`owner_id` = ow.`id`
                    WHERE ow.`id`= ?
                    AND up.`user_payment_status` = 7';
            return $this->db->query($sql,$id)->num_rows();
        }

        /**
	 * @author     [IVS] Nguyen Van Vui
	 * @name 	listPaymentMethod
	 * @todo 	List Payment Method
	 * @param
	 * @return
	 */

        function listPaymentMethod() {
            $sql='SELECT pm.`id`,pm.`name`
                    FROM `mst_payment_methods` pm
                    WHERE pm.`display_flag`=1';
            return $this->db->query($sql)->result_array();
        }

        /**
	 * @author     [IVS] Nguyen Van Vui
	 * @name 	listPaymentMethod
	 * @todo 	List Payment Method
	 * @param
	 * @return
	 */

        function updateOwnerRegister($id) {
            $this->db->set('owner_status', 2);
            $this->db->set('offcial_reg_date', date('Y/m/d H:i:s'));
            $this->db->where('id', $id);
            $this->db->update('owners');
        }

        /**
	 * @author     [IVS] Nguyen Van Vui
	 * @name 	updateOwner
	 * @todo 	Update Owner
	 * @param 	Array $values
	 * @return
	 */

        function updateOwner($id,$values){
            $this->db->where('id', $id);
            $this->db->update('owners',$values);
        }

        /**
	 * @author     [IVS] Nguyen Van Vui
	 * @name 	updatePenaltyOnwer
	 * @todo 	Update date penalty for owner
	 * @param 	String $id
	 * @return
	 */

        function updatePenaltyOnwer($id){
            $this->db->set('penalty_date', date('Y-m-d H:i:s'));
            $this->db->where('id', $id);
            $this->db->update('owners');
        }

        /**
	 * @author     [IVS] Nguyen Van Vui
	 * @name 	listJobTypename
	 * @todo 	list Job Type name
	 * @param
	 * @return
	 */

        function listJobTypename(){
            $sql='SELECT * FROM mst_job_types jt ORDER BY jt.priority';
            return $this->db->query($sql)->result_array();
        }

        /**
	 * @author     [IVS] Nguyen Van Vui
	 * @name 	listJobTypenameById
	 * @todo 	list Job Type name By Id
	 * @param 	Array $id
	 * @return
	 */

        function listJobTypenameById($id){
            $sql='SELECT mst_job_types.`id` FROM mst_job_types
                    INNER JOIN job_type_users ON mst_job_types.`id` = job_type_users.`job_type_id`
                    WHERE job_type_users.`user_id` = ?';
            return $this->db->query($sql,$id)->result_array();
        }

        /**
	 * @author  [IVS] Nguyen Minh Ngoc
	 * @name 	showDetailUS
	 * @todo 	show detail information of user
	 * @param 	$uid
	 * @return
	*/
        public function showDetailUS($uid){
            $sql="SELECT *,web.name as wname, us.name as uname,us.id as uid FROM users as us LEFT JOIN user_recruits as u ON us.id = u.id
                LEFT JOIN mst_websites as web ON web.id = us.website_id WHERE us.id= ? AND us.display_flag= 1 ";
            return $this->db->query($sql,array($uid))->result_array();
        }
        /**
	 * @author  [IVS] Nguyen Minh Ngoc
	 * @name 	countUS
	 * @todo 	count total user
	 * @param 	$uid,$type
	 * @return
	*/
        public function countUS($type,$uid){
            $sql="SELECT * FROM list_user_messages AS lis LEFT
                JOIN mst_templates AS tem ON lis.template_id = tem.id WHERE tem.template_type= ? AND lis.user_id = ? AND lis.display_flag= 1";
            return $this->db->query($sql,array($type,$uid))->num_rows();
        }
        /**
	 * @author  [IVS] Nguyen Minh Ngoc
	 * @name 	countApply
	 * @todo 	count list apply
	 * @param 	$uid
	 * @return
	*/
         public function countApply($uid){
            $this->db->select("*");
            $where =array(
                "user_id"=>$uid,
                "display_flag"=>1
            );
            $this->db->where($where);
            return $this->db->get("user_payments")->num_rows();
        }
       /**
	 * @author  [IVS] Nguyen Minh Ngoc
	 * @name 	approveUS
	 * @todo 	count list approve
	 * @param 	$id
	 * @return
	*/
        public function approveUS($id,$time){
           $data=array(
               "user_status"=> 1,
               "offcial_reg_date"=>$time
           );
           $where=array(
               "id"=>$id
           );
           $this->db->where($where);
           $this->db->update("users",$data);
        }
         /**
	 * @author  [IVS] Nguyen Minh Ngoc
	 * @name 	updateUS
	 * @todo 	update information of user
	 * @param 	$id,$pass,$status,$email,$birthday,$charge,$bank,$bankkana,$ac_type,$ac_no,$ac_name,$getmail,$memo,$image1,$image2
	 * @return
	*/
        public function  updateUS($id,$pass,$status,$email,$birthday,$charge,$bank,$bankkana,$ac_type,$ac_no,$ac_name,$getmail,$memo,$image1,$image2,$time,$time1,$uname,$old_id=null,$telephone_number=null,$phone_document=null){
           $param = array($pass,$status,$email,$birthday,$charge,$getmail,$memo,$image1,$image2,$bank,$bankkana,$ac_type,$ac_no,$ac_name,$time,$time1,$uname,$telephone_number,$phone_document);
           $sql="UPDATE users set password=?, user_status=?, email_address=?, birthday=?,
               charge=?, magazine_status=?, memo=?, image1=?,image2=?,
               bank_name=?,bank_agency_kara_name=?, account_type=?, account_no=?,
               account_name=?,updated_date=?,offcial_reg_date=?,name= ? , telephone_number= ? , telephone_record = ? ";

            if ( $old_id ){
                $sql .= ",old_id =? ";
                $param[] = $id;
            }

            $sql .="WHERE id=?";
            $param[] = $old_id;
            $this->db->query($sql,$param);
        }
         /**
	 * @author  [IVS] Nguyen Minh Ngoc
	 * @name 	updateUS
	 * @todo 	update information of user
	 * @param 	$id,$pass,$status,$email,$birthday,$charge,$bank,$bankkana,$ac_type,$ac_no,$ac_name,$getmail,$memo,$image1,$image2
	 * @return
	*/
        public function  updateUSSub($id,$pass,$status,$email,$birthday,$charge,$bank,$bankkana,$ac_type,$ac_no,$ac_name,$getmail,$memo,$image1,$image2,$time,$uname,$old_id=null,$telephone_number=null,$phone_document=null){
           $param = array($pass,$status,$email,$birthday,$charge,$getmail,$memo,$image1,$image2,$bank,$bankkana,$ac_type,$ac_no,$ac_name,$time,$uname,$telephone_number,$phone_document);
           $sql="UPDATE users set password=?, user_status=?, email_address=?, birthday=?,
               charge=?, magazine_status=?, memo=?, image1=?,image2=?,
               bank_name=?,bank_agency_kara_name=?, account_type=?, account_no=?,
               account_name=?,updated_date=?,name= ? , telephone_number = ? , telephone_record = ? ";
            if ( $old_id ){
                $sql .= ",old_id =? ";
                $param[] = $old_id;
            }

            $sql .="WHERE id=?";
            $param[] = $id;
            $this->db->query($sql,$param);
        }

        /**
	 * @author  [IVS] Nguyen Minh Ngoc
	 * @name 	showApplyScout
	 * @todo 	show list apply scout
	 * @param 	$id
	 * @return
	*/
        public function showApplyScout($id){
           $sql="SELECT user_payment_status,ow.email_address, ow.storename, up.request_money_date, up.approved_date, mhm.joyspe_happy_money FROM user_payments up INNER JOIN owner_recruits owr
                    ON up.owner_recruit_id = owr.id
                    LEFT JOIN owners ow
                    ON ow.id = owr.owner_id
                    LEFT JOIN mst_happy_moneys mhm
                    ON owr.happy_money_id = mhm.id
                    WHERE up.display_flag = 1 AND up.user_id =?";
            return $this->db->query($sql,array($id))->result_array();
        }
        /**
	 * @author  [IVS] Nguyen Minh Ngoc
	 * @name 	searchPenalty
	 * @todo 	search penalty list
	 * @param 	$email,$storename,$limit,$offset
	 * @return
	*/
        public function searchPenalty($email,$storename,$limit,$offset){
           $sql="SELECT *,email_address,storename,penalty_date FROM owners
                WHERE email_address LIKE '%".$this->db->escape_like_str($email)."%' AND storename LIKE '%".$this->db->escape_like_str($storename)."%' AND display_flag=1 AND owner_status=3 ORDER BY penalty_date DESC LIMIT ".$limit." OFFSET ".$offset." ";
            return $this->db->query($sql)->result_array();
        }
           /**
	 * @author  [IVS] Nguyen Minh Ngoc
	 * @name 	count
	 * @todo 	count penalty list
	 * @param 	$email,$storename,$limit,$offset
	 * @return
	*/
        public function countPen($email,$storename){
           $sql="SELECT *,email_address,storename,penalty_date FROM owners
                WHERE email_address LIKE '%".$this->db->escape_like_str($email)."%' AND storename LIKE '%".$this->db->escape_like_str($storename)."%' AND display_flag=1 AND owner_status=3";
            return $this->db->query($sql)->num_rows();
        }

        /**
	 * @author     [IVS] Nguyen Van Vui
	 * @name 	search_company
	 * @todo 	search company
	 * @param 	String $where,$number,$offset
	 * @return
	 */

        function search_company($where,$number = 0 ,$offset = 0) {
            $sql='SELECT ow.*, SUM(pm.amount) AS amountSave, ore.id AS oreid, ore.recruit_status
                    FROM `owners` ow
                    LEFT JOIN owner_recruits ore
                    ON ow.`id` = ore.owner_id
                    LEFT JOIN `payments` pm
                    ON ow.`id` = pm.owner_id AND payment_status = 2
                    WHERE ow.`display_flag` = 1
                    AND ore.`display_flag` = 1 AND ore.`recruit_status` = 2';
            $sql.=$where;
            $sql.= " GROUP BY ow.id ";
            if ($number || $offset) {
                $sql = $sql." LIMIT ".$number." OFFSET ".$offset."";
            }
            

            return $this->db->query($sql)->result_array();
        }

        /**
         * @author     [IVS] Nguyen Van Vui
         * @name        countReward
         * @todo        count reward
         * @param 	 String $where
         * @return
         */

        function countCompany($where) {
            $sql='SELECT count(ow.id) as total_number
                    FROM `owners` ow
                    LEFT JOIN owner_recruits ore
                    ON ow.`id` = ore.owner_id
                    AND ore.`recruit_status` = 2
                    AND ore.`display_flag` = 1
                    WHERE ow.`display_flag` = 1 ';
            $sql.=$where;
            return $this->db->query($sql)->result_array();

        }

        /**
         * @author     [IVS] Nguyen Van Vui
         * @name        listWebsite
         * @todo        list website
         * @param
         * @return
         */

        function listWebsite() {
            $sql='SELECT * FROM `mst_websites` ws WHERE ws.`type` = 0 AND ws.`display_flag` = 1';
            return $this->db->query($sql)->result_array();
        }

        /**
         * @author     [IVS] Nguyen Van Vui
         * @name        countWork
         * @todo        count Work
         * @param 	 String $where
         * @return
         */

        function countWork($where) {
            $sql='SELECT ow.`unique_id` AS unique_id_ow, ow.`storename`, us.`unique_id` AS unique_id_us,
                            us.`name`, up.`request_money_date`, up.`user_payment_status`
                     FROM `user_payments` up
                     INNER JOIN `owner_recruits` owr ON up.`owner_recruit_id` = owr.`id`
                     INNER JOIN `owners` ow ON ow.`id` = owr.`owner_id` AND ow.`display_flag` = 1
                     INNER JOIN users us ON up.`user_id` = us.`id`  AND us.`display_flag` = 1
                     WHERE up.`display_flag` = 1
                     AND up.`user_payment_status` > 4 ';
            $sql.=$where;
            return $this->db->query($sql)->num_rows();

        }

        /**
	 * @author     [IVS] Nguyen Van Vui
	 * @name 	search_work
	 * @todo 	search work
	 * @param 	String $where,$number,$offset
	 * @return
	 */

        function search_work($where,$number,$offset) {
            $sql='SELECT ow.`unique_id` AS unique_id_ow, ow.`storename`, us.`unique_id` AS unique_id_us,
                            us.`name`, up.`request_money_date`, up.`user_payment_status`
                     FROM `user_payments` up
                     INNER JOIN `owner_recruits` owr ON up.`owner_recruit_id` = owr.`id`
                     INNER JOIN `owners` ow ON ow.`id` = owr.`owner_id` AND ow.`display_flag` = 1
                     INNER JOIN users us ON up.`user_id` = us.`id`  AND us.`display_flag` = 1
                     WHERE up.`display_flag` = 1
                     AND up.`user_payment_status` > 4 ';
            $sql.=$where;
            $sql = $sql." ORDER BY up.`request_money_date` DESC LIMIT ".$number." OFFSET ".$offset."";

            return $this->db->query($sql)->result_array();
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
	 * @name    getSearchApplicationQuery
	 * @todo
	 * @param
	 * @return
	*/
        public function getSearchApplicationQuery($email, $name, $user_id, $user_name, $dateFrom, $dateTo, $val){
            $strQuery1 = "";
            $strQuery2 = "";
            $strQuery3 = "";
            $strQuery4 = "";
            $strQuery5 = "";
            $strQuery6 = "";
            $strQuery7 = "";
            if($email !=""){
                $strQuery1 = " AND o.email_address LIKE '%".$this->db->escape_like_str($email)."%' ";
            }
            if($name !=""){
                $strQuery2 = " AND o.storename LIKE '%".$this->db->escape_like_str($name)."%' ";
            }
            if($user_id !=""){
                $strQuery3 = " AND u.unique_id LIKE '%".$this->db->escape_like_str($user_id)."%' ";
            }
            if($user_name !=""){
                $strQuery4 = " AND u.name LIKE '%".$this->db->escape_like_str($user_name)."%' ";
            }
            if($dateFrom !=""){
                $strQuery5 = " AND DATEDIFF('".$this->db->escape_str($dateFrom)."',l.apply_date) <= 0 ";
            }
            if($dateTo !=""){
                $strQuery6 = " AND DATEDIFF('".$this->db->escape_str($dateTo)."',l.apply_date) >= 0 ";
            }
            if($val !="" && $val < 5){
                $strQuery7 = " AND l.user_payment_status = ".$this->db->escape_str($val)." ";
            }
            return $sql = "SELECT o.unique_id AS idOfOwner, o.storename AS storename, u.unique_id AS idOfUser,
                                    u.name AS nameOfUser, l.apply_date AS apply_date,
                                    l.user_payment_status AS user_payment_status
                           FROM user_payments l
                           LEFT OUTER JOIN users u ON l.user_id = u.id
                           LEFT OUTER JOIN owner_recruits r ON l.owner_recruit_id = r.id
                           LEFT OUTER JOIN owners o ON r.owner_id = o.id
                           WHERE l.user_payment_status < 5
                           AND l.display_flag = 1".$strQuery1." ".$strQuery2." ".$strQuery3." ".$strQuery4." ".$strQuery5." ".$strQuery6." ".$strQuery7."
                           ORDER BY apply_date DESC ";
        }
        /**
	 * @author  [IVS] Nguyen Hoai Nam
	 * @name    getResultSearchApplication
	 * @todo
	 * @param
	 * @return
	*/
        public function getResultSearchApplication($sql,$limit,$offset){
            $sql = $sql." LIMIT ".$limit." OFFSET ".$offset."";
            return $this->db->query($sql)->result_array();
        }

       /**
	 * @author  [IVS] Nguyen Minh Ngoc
	 * @name 	companyStoreEdit
	 * @todo 	view owner profile
	 * @param 	$owner_id
	 * @return
	*/
        public function companyStoreEdit($owner_id){
        $sql = "SELECT *,ORC.happy_money_id,ORC.main_image,OW.email_address,OW.storename,ORC.id AS orid, ORC.owner_id AS oid, ORC.image1, ORC.image2, ORC.image3, ORC.image4, ORC.image5, ORC.image6,
            ORC.nearest_station, ORC.company_info, ORC.city_id, ORC.working_hour_from, ORC.working_hour_to, ORC.working_hour_24h,
            ORC.cond_happy_money,
            ORC.working_style_note, MHM.joyspe_happy_money, ORC.scout_pr_text, DATE_FORMAT(ORC.created_date,'%Y/%m/%d') as orc_created_date

            FROM owner_recruits ORC INNER JOIN owners OW ON ORC.owner_id = OW.id
                INNER JOIN mst_happy_moneys MHM ON ORC.happy_money_id = MHM.id

            WHERE ORC.display_flag = 1 AND OW.display_flag = 1 AND ORC.recruit_status=2 AND ORC.id = ?
        ";
        $query = $this->db->query($sql, array($owner_id));
        return $query->result_array();
    }
        /**
	 * @author  [IVS] Nguyen Minh Ngoc
	 * @name 	getTreatmentOwner
	 * @todo 	get list treatment of owner
	 * @param 	$owner_id
	 * @return
	*/
    public function getTreatmentOwner($owner_id) {
        $sql = "SELECT MTR.id, MTR.name
                FROM treatments_owners TRO INNER JOIN mst_treatments MTR ON TRO.treatment_id = MTR.id
                WHERE TRO.owner_recruit_id = ?
                AND MTR.display_flag = 1
            ";
        $query = $this->db->query($sql, array($owner_id));
        return $query->result_array();
    }
        /**
	 * @author  [IVS] Nguyen Minh Ngoc
	 * @name 	getAllTreatments
	 * @todo 	get all treatment of mst_treatments
	 * @param
	 * @return
	*/
    public function getAllTreatments() {
        $sql = "SELECT mst_treatments.name, mst_treatments.id, mst_treatments.alph_name
                FROM  mst_treatments
                WHERE mst_treatments.display_flag = 1 Order by mst_treatments.priority ASC
            ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    /**
     * @author  [IVS] Nguyen Minh Ngoc
     * @name 	getCity
     * @todo 	get City
     * @param 	null
     * @return data
     */
    public function getCity() {
        $sql = 'SELECT id, name FROM mst_cities WHERE display_flag =1 ORDER BY id';
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    /**
     * @author  [IVS] Nguyen Minh Ngoc
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
     * @author  [IVS] Nguyen Minh Ngoc
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
     * @author  [IVS] Nguyen Minh Ngoc
     * @name 	getHappyMoney
     * @todo 	get Happy Money
     * @param 	null
     * @return 	data
     */
    public function getHappyMoney() {
        $sql = 'SELECT id, joyspe_happy_money, user_happy_money, default_money
                FROM mst_happy_moneys
                WHERE display_flag = 1
                ORDER BY joyspe_happy_money ';
        $query = $this->db->query($sql);
        return $query->result_array();
    }
        /**
	 * @author  [IVS] Nguyen Minh Ngoc
	 * @name 	insertTreatmentOwner
	 * @todo 	insert treatment record
	 * @param 	$owid,$tid
	 * @return
	*/
   public function insertTreatmentOwner($owid,$tid) {
       $data=array(
           "owner_recruit_id"=>$owid,
           "treatment_id"=>$tid
       );
        $this->db->insert('treatments_owners', $data);
    }
        /**
	 * @author  [IVS] Nguyen Minh Ngoc
	 * @name 	deleteTreatmentOwner
	 * @todo 	delete treatment record
	 * @param 	$owid
	 * @return
	*/
    public function deleteTreatmentOwner($owid){
       $this->db->where('owner_recruit_id', $owid);
        $this->db->delete('treatments_owners');
    }
        /**
	 * @author  [IVS] Nguyen Minh Ngoc
	 * @name 	updateBothOwnerRecruit
	 * @todo 	update owner recruit
	 * @param 	$owid,$image1,$image2,$image3,$image4,$image5,$image6,$sltmainimg,$txtcyinfo,$sltcity,$txtstation,$slthsala,$sltmsala
            ,$sltworkinghf,$sltworkinght,$chk24,$slthappymoney,$sltconhap,$txtwknote
	 * @return
	*/
    public function updateBothOwnerRecruit($owid,$image1,$image2,$image3,$image4,$image5,$image6,$sltmainimg,$txtcyinfo,$sltcity,$txtstation,$slthsala,$sltmsala
            ,$sltworkinghf,$sltworkinght,$chk24,$slthappymoney,$sltconhap,$txtwknote){
           $sql ="UPDATE owner_recruits set image1='".$this->db->escape_str($image1)."',image2='".$this->db->escape_str($image2)."', image3='".$this->db->escape_str($image3)."', image4='".$this->db->escape_str($image4)."',
               image5='".$this->db->escape_str($image5)."',image6='".$this->db->escape_str($image6)."',
              nearest_station='".$this->db->escape_str($txtstation)."',working_style_note='".$this->db->escape_str($txtwknote)."', company_info ='".$this->db->escape_str($txtcyinfo)."',
                  main_image='".$this->db->escape_str($sltmainimg)."',happy_money_id='".$this->db->escape_str($slthappymoney)."' ,
                city_id='".$this->db->escape_str($sltcity)."', working_hour_from='".$this->db->escape_str($sltworkinghf)."',
                working_hour_to='".$this->db->escape_str($sltworkinght)."',working_hour_24h='".$this->db->escape_str($chk24)."',cond_happy_money='".$this->db->escape_str($sltconhap)."'
              WHERE owner_id='".$this->db->escape_str($owid)."'";
           $this->db->query($sql);
           //$this->db->query($sql1);
        }
            /**
	 * @author  [IVS] Nguyen Minh Ngoc
	 * @name 	getJobType
	 * @todo 	get job type list
	 * @param
	 * @return
	*/
    public function getJobType() {
        $sql = 'SELECT id, name ,alph_name FROM mst_job_types WHERE display_flag = 1 ORDER BY priority';
        $query = $this->db->query($sql);
        return $query->result_array();
    }
           /**
	 * @author  [IVS] Nguyen Minh Ngoc
	 * @name 	getJobTypeOwner
	 * @todo 	get job type list of owner
	 * @param 	$owner_id
	 * @return
	*/
    public function getJobTypeOwner($owner_id) {
        $sql = "SELECT MJ.id, MJ.name
                FROM job_type_owners JT INNER JOIN mst_job_types MJ
                ON JT.job_type_id = MJ.id
                WHERE JT.owner_recruit_id = ?
                AND MJ.display_flag = 1
            ";
        $query = $this->db->query($sql,array($owner_id));
        return $query->result_array();
    }
        /**
	 * @author  [IVS] Nguyen Minh Ngoc
	 * @name 	insertJobTypeOwner
	 * @todo 	insert jobtype of owner
	 * @param 	$owid,$tid
	 * @return
	*/
    public function insertJobTypeOwner($owid,$tid) {
       $data=array(
           "owner_recruit_id"=>$owid,
           "job_type_id"=>$tid
       );
        $this->db->insert('job_type_owners', $data);
        return $this->db->insert_id();
    }
        /**
	 * @author  [IVS] Nguyen Minh Ngoc
	 * @name 	deleteJobTypeOwner
	 * @todo 	delete record job type of owner
	 * @param 	$owid
	 * @return
	*/
    public function deleteJobTypeOwner($owid){
       $this->db->where('owner_recruit_id', $owid);
        $this->db->delete('job_type_owners');
    }
       /**
	 * @author  [IVS] Nguyen Minh Ngoc
	 * @name 	deleteoOwnerRe
	 * @todo 	delete owner recruit
	 * @param 	$id
	 * @return
	*/
    public function deleteoOwnerRe($id){
        $data=array(
            "display_flag"=>0
        );
        $this->db->where('id', $id);
        $this->db->update('owner_recruits',$data);

    }
    /**
	 * @author  [IVS] Nguyen Minh Ngoc
	 * @name 	insertNewOwnerRecruit
	 * @todo 	insert new owner recruit
	 * @param 	$owid, $image1, $image2, $image3, $image4, $image5, $image6, $city_group_id, $city_id,
              $town_id, $title, $work_place, $working_day, $working_time, $how_to_access, $salary, $con_to_apply, $company_info,
              $apply_time, $apply_emailaddress, $home_page_url, $line_id, $main_image, $happy_money_id, $cond_happy_money_id
	 * @return
	*/
    public function insertNewOwnerRecruit($owid, $image1, $image2, $image3, $image4, $image5, $image6, $city_group_id, $city_id,
      $town_id, $title, $work_place, $working_day, $working_time, $how_to_access, $salary, $con_to_apply, $company_info,
      $apply_time, $apply_tel, $apply_emailaddress, $home_page_url, $line_id, $main_image, $happy_money_id, $cond_happy_money_id, $time,$scout_pr_text, $new_msg_notify_email)
    {
      $sql =  "INSERT INTO owner_recruits (owner_id,image1,image2,image3,image4,image5,image6,city_group_id,city_id,town_id,title,
              work_place,working_day,working_time,how_to_access,salary,con_to_apply,company_info,apply_time,apply_tel,apply_emailaddress,home_page_url,line_id,main_image,happy_money_id,cond_happy_money,created_date,scout_pr_text, new_msg_notify_email, recruit_status) VALUES
              ('".$this->db->escape_str($owid)."','".$this->db->escape_str($image1)."', '".$this->db->escape_str($image2)."', '".$this->db->escape_str($image3)."', '".$this->db->escape_str($image4)."','".$this->db->escape_str($image5)."',
               '".$this->db->escape_str($image6)."','".$this->db->escape_str($city_group_id)."','".$this->db->escape_str($city_id)."',  '".$this->db->escape_str($town_id)."','".$this->db->escape_str($title)."','".$this->db->escape_str($work_place)."',
              '".$this->db->escape_str($working_day)."', '".$this->db->escape_str($working_time)."','".$this->db->escape_str($how_to_access)."','".$this->db->escape_str($salary)."',
              '".$this->db->escape_str($con_to_apply)."','".$this->db->escape_str($company_info)."','".$this->db->escape_str($apply_time)."','".$this->db->escape_str($apply_tel)."','".$this->db->escape_str($apply_emailaddress)."',
              '".$this->db->escape_str($home_page_url)."','".$this->db->escape_str($line_id)."','".$this->db->escape_str($main_image)."','".$this->db->escape_str($happy_money_id)."',
              '".$this->db->escape_str($cond_happy_money_id)."','".$this->db->escape_str($time)."','".$this->db->escape_str($scout_pr_text).
              "','".$this->db->escape_str($new_msg_notify_email)."', 2)";
      $this->db->query($sql);
    }
        /**
	 * @author  [IVS] Nguyen Minh Ngoc
	 * @name 	maxid
	 * @todo
	 * @param
	 * @return
	*/
        public function maxid(){
           $sql="select Max(id) from owner_recruits";
           return $this->db->query($sql)->row_array();
        }
          /**
	 * @author  [IVS] Nguyen Minh Ngoc
	 * @name 	showWeb
	 * @todo 	show mst_websites
	 * @param
	 * @return
	*/
        public function showWeb(){
           $sql="select * from mst_websites WHERE type=1";
           return $this->db->query($sql)->result_array();
        }
          /**
	 * @author  [IVS] Nguyen Minh Ngoc
	 * @name 	showStatus
	 * @todo 	show mst_websites
	 * @param
	 * @return
	*/
        public function showStatus($id){
           $sql="select user_status from users WHERE id=?";
           return $this->db->query($sql,array($id))->result_array();
        }

      public function getAreaPrefTownIds($name) {
        $sql = "select t.id as town_id, c.id as prefecture_id, c.city_group_id as area_id
                from mst_towns t
                left join mst_cities c
                on c.id = t.city_id
                where t.name=?";
        return $this->db->query($sql, $name)->result_array();
      }

      public function getAreaId($name) {
        $sql = "select id
                from mst_city_groups
                where name=?";
        return $this->db->query($sql, $name)->result_array();
      }

      public function getTownId($name) {
        $sql = "select id, city_id
                from mst_towns
                where name=?";
        return $this->db->query($sql, $name)->result_array();
      }

      public function getJobTypeId($name) {
        $sql = "select id
                from mst_job_types
                where name=?";
        return $this->db->query($sql, $name)->result_array();
      }

      public function getTreatmentId($name) {
        $sql = "select id
                from mst_treatments
                where name=?";
        return $this->db->query($sql, $name)->result_array();
      }

      function countUserFromSite1or2($where) {
        $sql='SELECT count(us.id) as total_number
              FROM users us
              WHERE us.display_flag = 1
              AND us.remote_scout_flag = 1';
        $sql.=$where;
        return $this->db->query($sql)->result_array();
      }

      function countMakiaUsers($where) {
        $sql = "SELECT us.id
                FROM users us
                WHERE us.user_from_site = 2
                AND us.display_flag = 1 and us.email_address not like 'makia_%'";
        $sql .= $where;
        $sql .= " ORDER BY us.id DESC";
        return $this->db->query($sql)->num_rows();
      }


      function searchMakiaUsers($where, $number, $offset) {
        $ret_user_info = array();
        $sql = "SELECT us.id, us.unique_id, us.`name`,
                CASE WHEN us.website_id = 44 THEN 'AMM' ELSE CASE WHEN us.website_id = 45 THEN 'ZIP' ELSE 'アマンテ' END END AS website_type,
                us.received_bonus_datetime, us.created_date, us.received_bonus_flag, us.id AS user_id, us.memo
                FROM users us
                WHERE us.user_from_site = 2 AND us.display_flag = 1 and us.email_address not like 'makia_%'";
        $sql .= $where;
        $sql .= " ORDER BY us.id DESC";
        $sql .= " LIMIT ".$number." OFFSET ".$offset."";

        $user_list = $this->db->query($sql)->result_array();

        if ($user_list && is_array($user_list)) {
          foreach ($user_list as $user_info) {
            $params = array();

            $sql = "SELECT COUNT(lum.id) AS inquiry_amount
                    FROM list_user_owner_messages lum
                    WHERE lum.user_id = ? AND lum.msg_from_flag = 0
                    AND lum.display_flag = 1
                    ";
            $params[] = $user_info['user_id'];
            $query = $this->db->query($sql, $params);
            if ($query) {
                $user_addition_infor = $query->result_array();
                if ($user_addition_infor && is_array($user_addition_infor)) {
                    $ret_user_info[] = array_merge($user_info, $user_addition_infor[0]);
                }
            }

          }
        }

        return $ret_user_info;
      }

      function searchUserFromSite1or2($where,$number,$offset) {
        $sql='SELECT * FROM users us
              WHERE us.display_flag = 1
              AND us.remote_scout_flag = 1';
        $sql.=$where;
        $sql.= " GROUP BY us.id ORDER BY us.accept_remote_scout_datetime DESC ";
        $sql = $sql." LIMIT ".$number." OFFSET ".$offset."";
        return $this->db->query($sql)->result_array();
      }

      function countUserBonusFromSite1or2($where) {
        $sql='SELECT count(smb.id) as total_number
              FROM scout_mail_bonus smb
              LEFT JOIN users us ON smb.user_id = us.id
              WHERE smb.bonus_requested_flag = 1
              AND smb.display_flag = 1';
        $sql.=$where;
        return $this->db->query($sql)->result_array();
      }

      function searchUserBonusFromSite1or2($where,$number,$offset) {
        $sql="
                SELECT 
                    user_id, SUM(bonus_money) as bonus_money, id, unique_id, old_id, name, user_from_site, bonus_requested_date, received_bonus_flag, received_bonus_date
                FROM (
                    SELECT us.id as user_id, smb.id, us.unique_id,us.old_id, us.name, us.user_from_site, smb.bonus_requested_date,
                    smb.bonus_money, smb.received_bonus_flag, smb.received_bonus_date
                    FROM scout_mail_bonus smb
                    LEFT JOIN users us ON smb.user_id = us.id
                    WHERE smb.bonus_requested_flag = 1
                    $where
                UNION
                    SELECT us.id as user_id, 0 as id, us.unique_id,us.old_id, us.name, us.user_from_site, abp.bonus_requested_date,
                    SUM(abp.point) as bonus_money, abp.received_bonus_flag, abp.received_bonus_date
                    FROM aruaru_bbs_points abp
                    LEFT JOIN users us ON abp.user_id = us.id
                    WHERE abp.bonus_requested_flag = 1
                    $where
                    GROUP BY abp.user_id, abp.bonus_requested_date
                UNION
                    SELECT us.id as user_id, 0 as id, us.unique_id,us.old_id, us.name, us.user_from_site, bp.bonus_requested_date,
                    SUM(bp.point) as bonus_money, bp.received_bonus_flag, bp.received_bonus_date
                    FROM bbs_points bp
                    LEFT JOIN users us ON bp.user_id = us.id
                    WHERE bp.bonus_requested_flag = 1
                    $where
                    GROUP BY bp.user_id, bp.bonus_requested_date
                ) a 
                GROUP BY user_id, bonus_requested_date
            ";
        $sql.= " ORDER BY bonus_requested_date DESC ";
        $sql = $sql." LIMIT ".$number." OFFSET ".$offset."";
        return $this->db->query($sql)->result_array();
      }

    public function getScoutMailsPerDay($owner_id){
      $ret = 0;
      if ( $owner_id ){
          $sql = 'SELECT default_scout_mails_per_day
                  FROM owners
                  WHERE display_flag = 1
                  AND id = ?';
          $query = $this->db->query($sql, $owner_id);
          if ( $query && $row = $query->row_array() ){
            $ret = $row['default_scout_mails_per_day'];
          }
      }
      return $ret;
    }
    }
?>

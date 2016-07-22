<?php
    class Msetting extends CI_Model{
        public function __construct() {
            parent::__construct();
        }
           /**
	 * @author  [IVS] Nguyen Minh Ngoc
	 * @name    showPointMaster
	 * @todo 	show record in mst_point_master
	 * @param
	 * @return
	*/
        public function showPointMaster(){
            $sql="SELECT * FROM mst_point_masters ms
                    WHERE ms.display_flag = 1
                    ORDER BY ms.payment_method_id DESC , ms.amount ASC, ms.`point` ASC ";
            return $this->db->query($sql)->result_array();
        }
           /**
	 * @author  [IVS] Nguyen Minh Ngoc
	 * @name 	showMethodTran()
	 * @todo 	show method in mst_payment_methods
	 * @param 	null
	 * @return 	null
	*/
        public function showMethodTran(){
            $this->db->select("*");
            return $this->db->get("mst_payment_methods")->result_array();
        }
           /**
	 * @author  [IVS] Nguyen Minh Ngoc
	 * @name 	insertPoint
	 * @todo 	insert record in mst_point_masters
	 * @param 	$method,$amount,$point,$time
	 * @return 	null
	*/
        public function insertPoint($method,$amount,$point,$time){
            $data=array(
                "payment_method_id"=>$method,
                "amount"=>$amount,
                "point"=>$point,
                "created_date"=>$time
            );
            $this->db->insert("mst_point_masters",$data);
        }
           /**
	 * @author  [IVS] Nguyen Minh Ngoc
	 * @name 	showPointScout
	 * @todo 	show record in mst_point_setting
	 * @param 	null
	 * @return 	null
	*/
        public function showPointScout(){
           $where=array(
               "point_setting_status"=>0,
               "display_flag"=>1
           );
           $this->db->select("*");
           $this->db->where($where);
            return $this->db->get("mst_point_setting")->result_array();
        }
           /**
	 * @author  [IVS] Nguyen Minh Ngoc
	 * @name 	updatePoint
	 * @todo 	update record in mst_point_master
	 * @param 	$id,$amount,$point,$method
	 * @return 	null
	*/
        public function updatePoint($id,$amount,$point,$method){
           $data=array(
               "amount"=>$amount,
               "point"=>$point,
               "payment_method_id"=>$method
           );
           $where=array(
               "id"=>$id
           );
           $this->db->where($where);
           $this->db->update("mst_point_masters",$data);
        }
              /**
	 * @author  [IVS] Nguyen Minh Ngoc
	 * @name 	deletePoint
	 * @todo 	delete record in mst_point_masters
	 * @param 	$id,$amount,$point,$method
	 * @return 	null
	*/
        public function deletePoint($id,$amount,$point,$method){
           $data=array(
               "display_flag"=>"0",
           );
           $where=array(
               "id"=>$id
           );
           $this->db->where($where);
           $this->db->update("mst_point_masters",$data);
        }
           /**
	 * @author  [IVS] Nguyen Minh Ngoc
	 * @name 	showPointView
	 * @todo 	show record in mst_point_setting
	 * @param 	null
	 * @return 	null
	*/
        public function showPointView(){
           $where=array(
               "point_setting_status"=>1,
               "display_flag"=>1
           );
           $this->db->select("*");
           $this->db->where($where);
            return $this->db->get("mst_point_setting")->result_array();
        }
           /**
	 * @author  [IVS] Nguyen Minh Ngoc
	 * @name 	updatePointScout
	 * @todo 	update record in mst_point_setting
	 * @param 	$id,$amount,$point,$time
	 * @return 	null
	*/
        public function updatePointScout($id,$amount,$point,$time){
           $data=array(
               "amount"=>$amount,
               "point"=>$point,
               "updated_date"=>$time
           );
           $where=array(
               "id"=>$id
           );
           $this->db->where($where);
           $this->db->update("mst_point_setting",$data);
        }
           /**
	 * @author  [IVS] Nguyen Minh Ngoc
	 * @name        updatePointView
	 * @todo 	update record in mst_point_setting
	 * @param 	$id,$amount,$point,$time
	 * @return 	null
	*/
        public function updatePointView($id,$amount,$point,$time){
           $data=array(
               "amount"=>$amount,
               "point"=>$point,
               "updated_date"=>$time
           );
           $where=array(
               "id"=>$id
           );
           $this->db->where($where);
           $this->db->update("mst_point_setting",$data);
        }
        /**
	 * @author  [IVS] Nguyen Minh Ngoc
	 * @name        showjobType
	 * @todo 	show information in table mst_job_types
	 * @param 	null
	 * @return 	null
	*/
        public function showJobType(){
            $this->db->select("*");
            $this->db->order_by("priority", "asc");
            return $this->db->get("mst_job_types")->result_array();
        }
        /**
	 * @author  [IVS] Nguyen Minh Ngoc
	 * @name        delteJobType
	 * @todo 	delete record in mst_job_types
	 * @param 	$id
	 * @return 	null
	*/
        public function deleteJobType($id){
           $data=array(
               "display_flag"=>0
           );
           $where=array(
               "id"=>$id
           );
           $this->db->where($where);
           $this->db->update("mst_job_types",$data);
        }

        /**
	 * @author  [IVS] Nguyen Minh Ngoc
	 * @name 	insertJobType
	 * @todo 	insert new job type in mst_job_types
	 * @param 	$name,$priority
	 * @return 	null
	*/
        public function insertJobType($name,$priority,$time){
            $data=array(
                "name"=>$name,
                "priority"=>$priority
            );
            $this->db->insert("mst_job_types",$data);
        }

        /**
	 * @author  [IVS] Nguyen Minh Ngoc
	 * @name 	showlastrecordJob
	 * @todo 	get last record in table
	 * @param 	$method,$amount,$point
	 * @return 	null
	*/
        public function showlastrecordJob(){
            $sql="select priority from mst_job_types order by priority desc limit 1";
            $query = $this->db->query($sql);
            return $query->result_array();
        }
         /**
	 * @author  [IVS] Nguyen Minh Ngoc
	 * @name 	showprerecord
	 * @todo 	get pre record in table
	 * @param 	$pri
	 * @return 	null
	*/
        public function showprerecord($pri){
            $sql="select id,priority from mst_job_types where priority < ? ORDER BY priority DESC LIMIT 0,1";
            $query = $this->db->query($sql, array($pri));
            return $query->result_array();
        }
         /**
	 * @author  [IVS] Nguyen Minh Ngoc
	 * @name 	shownextrecord
	 * @todo 	get next record in table
	 * @param 	$pri
	 * @return 	null
	*/
        public function shownextrecord($pri){
            $sql="select id,priority from mst_job_types where priority > ? ORDER BY priority ASC LIMIT 0,1";
            $query = $this->db->query($sql, array($pri));
            return $query->result_array();
        }
        /**
	 * @author  [IVS] Nguyen Minh Ngoc
	 * @name        updatePriority
	 * @todo 	update priority of job type
	 * @param 	$id,$pri
	 * @return 	null
	*/
        public function updatePriority($id,$pri){
           $data=array(
               "priority"=>$pri
           );
           $where=array(
               "id"=>$id
           );
           $this->db->where($where);
           $this->db->update("mst_job_types",$data);
        }
        /**
	 * @author  [IVS] Nguyen Minh Ngoc
	 * @name        showPriority
	 * @todo 	show list job type follow priority
	 * @param 	$id
	 * @return 	null
	*/
        public function showPriority($id){
           $this->db->select("*");
           $where=array(
               "id"=>$id
           );
           $this->db->where($where);
           return $this->db->get("mst_job_types")->result_array();
        }

        /*----------------------------------------------------------------------------------------------------------------------------------*/

        /**
	 * @author  [IVS] Nguyen Hoai Nam
	 * @name 	getHourSalary
	 * @todo
	 * @param
	 * @return
	*/
        public function getHourSalary(){
           $this->db->order_by("amount", "ASC");
           $query = $this->db->get("mst_hourly_salaries");
           if($query->num_rows() > 0) {
               return $query->result_array();
           }
           else {
               return array();
           }
        }
        /**
	 * @author  [IVS] Nguyen Hoai Nam
	 * @name 	updateHour
	 * @todo
	 * @param
	 * @return
	*/
        public function updateHour($item, $val){
            $sql = 'UPDATE mst_hourly_salaries SET display_flag = ? WHERE id = ?';
            $query = $this->db->query($sql,array($val, $item['id']));
        }
        /**
	 * @author  [IVS] Nguyen Hoai Nam
	 * @name 	insertHour
	 * @todo
	 * @param
	 * @return
	*/
        public function insertHour($price)
        {
            $args = array(
                'amount'=>$price
            );
            $this->db->insert('mst_hourly_salaries', $args);
            return $this->db->insert_id();
        }
        /**
	 * @author  [IVS] Nguyen Hoai Nam
	 * @name 	getMonthSalary
	 * @todo
	 * @param
	 * @return
	*/
        public function getMonthSalary(){
           $query = $this->db->get("mst_monthly_salaries");
           $this->db->where("display_flag",1);
           if($query->num_rows() > 0) {
               return $query->result_array();
           }
           else {
               return array();
           }
        }
        /**
	 * @author  [IVS] Nguyen Hoai Nam
	 * @name 	updateMonth
	 * @todo
	 * @param
	 * @return
	*/
        public function updateMonth($item, $val){
            $sql = 'UPDATE mst_monthly_salaries SET display_flag = ? WHERE id = ?';
            $query = $this->db->query($sql,array($val, $item['id']));
        }
        /**
	 * @author  [IVS] Nguyen Hoai Nam
	 * @name 	insertMonth
	 * @todo
	 * @param
	 * @return
	*/
        public function insertMonth($price)
        {
            $args = array(
                'amount'=>$price
            );
            $this->db->insert('mst_monthly_salaries', $args);
            return $this->db->insert_id();
        }
        /**
	 * @author  [IVS] Nguyen Hoai Nam
	 * @name 	getTreatment
	 * @todo
	 * @param
	 * @return
	*/
        public function getTreatment(){
           $sql = 'SELECT * FROM mst_treatments ORDER BY priority ASC';
           $query = $this->db->query($sql);
           if($query->num_rows() > 0) {
               return $query->result_array();
           }
           else {
               return array();
           }
        }
        /**
	 * @author  [IVS] Nguyen Hoai Nam
	 * @name    getTreatmentById
	 * @todo
	 * @param
	 * @return
	*/
        public function getTreatmentById($id){
           $this->db->select("*");
           $con = array(
               "id"=>$id,
           );
           $this->db->where($con);
           return $this->db->get("mst_treatments")->result_array();
        }
        /**
	 * @author  [IVS] Nguyen Hoai Nam
	 * @name    getPreviousTreatment
	 * @todo
	 * @param
	 * @return
	*/
        public function getPreviousTreatment($index){
            $sql = "SELECT id, priority FROM mst_treatments WHERE priority < ? ORDER BY priority DESC LIMIT 0,1";
            $query = $this->db->query($sql, array($index));
            return $query->result_array();
        }
         /**
	 * @author  [IVS] Nguyen Hoai Nam
	 * @name    getNextTreatment
	 * @todo
	 * @param
	 * @return
	*/
        public function getNextTreatment($index){
            $sql = "SELECT id, priority FROM mst_treatments WHERE priority > ? ORDER BY priority ASC LIMIT 0,1";
            $query = $this->db->query($sql, array($index));
            return $query->result_array();
        }
        /**
	 * @author  [IVS] Nguyen Hoai Nam
	 * @name    updateTreatment
	 * @todo
	 * @param
	 * @return
	*/
        public function updateTreatment($item, $val){
            $sql = 'UPDATE mst_treatments SET display_flag = ? WHERE id = ?';
            $query = $this->db->query($sql,array($val, $item['id']));
        }
        /**
	 * @author  [IVS] Nguyen Hoai Nam
	 * @name    updatePriorityTreatment
	 * @todo
	 * @param
	 * @return
	*/
        public function updatePriorityTreatment($id, $index){
           $data = array(
               "priority"=>$index
           );
           $where = array(
               "id"=>$id
           );
           $this->db->where($where);
           $this->db->update("mst_treatments", $data);
        }
        /**
	 * @author  [IVS] Nguyen Minh Ngoc
	 * @name    insertTreatment
	 * @todo    insert new record treatment
	 * @param   null
	 * @return  null
	*/
        public function insertTreatment($name,$pri)
        {
            $args = array(
                'name'=>$name,
                "priority"=>$pri
            );
            $this->db->insert('mst_treatments', $args);
            return $this->db->insert_id();
        }
        /**
	 * @author  [IVS] Nguyen Hoai Nam
	 * @name 	getOwnerCode
	 * @todo
	 * @param
	 * @return
	*/
        public function getOwnerCode(){
           $sql = 'SELECT * FROM mst_websites WHERE type = 0 AND display_flag = 1';
           $query = $this->db->query($sql);

           if($query->num_rows() > 0) {
               return $query->result_array();
           }
           else {
               return array();
           }
        }
        /**
	 * @author  [IVS] Nguyen Hoai Nam
	 * @name    deleteOwnerCode
	 * @todo
	 * @param
	 * @return
	*/
        public function deleteOwnerCode($item){
            $sql = 'UPDATE mst_websites SET display_flag = 0 WHERE id = ?';
            $query = $this->db->query($sql,array($item));
        }
        /**
	 * @author  [IVS] Nguyen Hoai Nam
	 * @name    insertOwnerCode
	 * @todo
	 * @param
	 * @return
	*/
        public function insertOwnerCode($name, $code)
        {
            $args = array(
                'name'=>$name,
                'code'=>$code,
                'type'=>0
            );
            $this->db->set('created_date', 'NOW()', FALSE);
            $this->db->insert('mst_websites', $args);
            return $this->db->insert_id();
        }
        /**
	 * @author  [IVS] Nguyen Hoai Nam
	 * @name    getUserCode
	 * @todo
	 * @param
	 * @return
	*/
        public function getUserCode(){
           $sql = 'SELECT * FROM mst_websites WHERE type = 1 AND display_flag = 1';
           $query = $this->db->query($sql);
           if($query->num_rows() > 0) {
               return $query->result_array();
           }
           else {
               return array();
           }
        }
        /**
	 * @author  [IVS] Nguyen Hoai Nam
	 * @name    deleteUserCode
	 * @todo
	 * @param
	 * @return
	*/
        public function deleteUserCode($item){
            $sql = 'UPDATE mst_websites SET display_flag = 0 WHERE id = ?';
            $query = $this->db->query($sql,array($item));
        }
        /**
	 * @author  [IVS] Nguyen Hoai Nam
	 * @name    insertUserCode
	 * @todo
	 * @param
	 * @return
	*/
        public function insertUserCode($name, $code)
        {
            $args = array(
                'name'=>$name,
                'code'=>$code,
                'type'=>1
            );
            $this->db->set('created_date', 'NOW()', FALSE);
            $this->db->insert('mst_websites', $args);
            return $this->db->insert_id();
        }
        /**
	 * @author  [IVS] Nguyen Hoai Nam
	 * @name    getAccount
	 * @todo
	 * @param
	 * @return
	*/
        public function getAccount(){
           $sql = 'SELECT * FROM admin WHERE display_flag = 1';
           $query = $this->db->query($sql);
           if($query->num_rows() > 0) {
               return $query->result_array();
           }
           else {
               return array();
           }
        }
        /**
	 * @author  [IVS] Nguyen Hoai Nam
	 * @name    getAccountById
	 * @todo
	 * @param
	 * @return
	*/
        public function getAccountById($id){
           $sql = "SELECT * FROM admin WHERE display_flag = 1 AND id = ?";
           $query = $this->db->query($sql, array($id));
           if($query->num_rows() > 0) {
               return $query->row_array();
           }
           else {
               return array();
           }
        }
        /**
	 * @author  [IVS] Nguyen Hoai Nam
	 * @name    insertAccount
	 * @todo
	 * @param
	 * @return
	*/
        public function insertAccount($username, $password)
        {
            $args = array(
                'login_id'=>$username,
                'password'=> base64_encode($password)
            );
            $this->db->set('created_date', 'NOW()', FALSE);
            $this->db->set('updated_date', 'NOW()', FALSE);
            $this->db->insert('admin', $args);
        }
        /**
	 * @author  [IVS] Nguyen Hoai Nam
	 * @name    updateAccount
	 * @todo
	 * @param
	 * @return
	*/
        public function updateAccount($id, $username, $password)
        {
            $args = array(
                'login_id'=>$username,
                'password'=>base64_encode($password)
            );
            $con = array(
               'id'=>$id
            );
            $this->db->set('updated_date', 'NOW()', FALSE);
            $this->db->where($con);
            $this->db->update('admin', $args);
        }
        /**
	 * @author  [IVS] Nguyen Hoai Nam
	 * @name    deleteAccount
	 * @todo
	 * @param
	 * @return
	*/
        public function deleteAccount($id)
        {
            $args = array(
                'display_flag'=>0
            );
            $con = array(
               'id'=>$id
            );
            $this->db->where($con);
            $this->db->update('admin', $args);
        }
        public function maxPriority(){
            $sql="SELECT MAX(priority) FROM mst_treatments";
            return $query = $this->db->query($sql)->result_array();

        }
        /**
	 * @author  [IVS] Nguyen Minh Ngoc
	 * @name        updateJobType
	 * @todo
	 * @param 	$id
	 * @return 	null
	*/
        public function updateJobType($id){
           $data=array(
               "display_flag"=>1
           );
           $where=array(
               "id"=>$id
           );
           $this->db->where($where);
           $this->db->update("mst_job_types",$data);
        }
        /**
	 * @author  [IVS] Nguyen Minh Ngoc
	 * @name 	getJob
	 * @todo
	 * @param
	 * @return
	*/
        public function getJob(){
           $sql = 'SELECT * FROM mst_job_types ORDER BY priority ASC';
           $query = $this->db->query($sql);
           if($query->num_rows() > 0) {
               return $query->result_array();
           }
           else {
               return array();
           }
        }
     /**
      * @author [VJS] チャンキムバック
      * @name  getOiwaiMoneyList()
      * @todo  お祝い金額と採用金額情報取得処理(テーブル名: mst_happy_moneys)
      * @param null
      * @return  お祝い金リスト
      */
      public function getOiwaiMoneyList(){
          $this->db->select("*");
          $this->db->order_by("display_flag","desc");
          $this->db->order_by("joyspe_happy_money","asc");
          return $this->db->get("mst_happy_moneys")->result_array();
      }

      /**
      * @author [VJS] チャンキムバック
      * @name  updateOiwaiMoney()
      * @todo  お祝い金額と採用金額情報を更新(テーブル名: mst_happy_moneys)
      * @param　mst_happy_moneysの一行の更新データ
      * @return TRUE 　成功
      *         FALSE 失敗
      */
      public function updateOiwaiMoney($happy_money_item){
        $ret = false;  //戻り値
        if ( $happy_money_item && is_array($happy_money_item) ){
          //$this->db->trans_start();
          //$this->db->trans_complete();
          $this->db->where('id', $happy_money_item['id']);
          $this->db->update("mst_happy_moneys", $happy_money_item);
          $ret = true;
        }
        return $ret;
      }
      /**
      * @author [VJS] チャンキムバック
      * @name  addOiwaiMoney()
      * @todo  お祝い金新規追加(テーブル名: mst_happy_moneys)
      * @param　mst_happy_moneysのデータ新規追加
      * @return TRUE 　成功
      *         FALSE 失敗
      */
      public function addOiwaiMoney($happy_money_item){
        $ret = false;  //戻り値
        if ( $happy_money_item && is_array($happy_money_item) ){
          $this->db->insert("mst_happy_moneys", $happy_money_item);
          $ret = true;
        }
        return $ret;
      }
      /**
      * @author [VJS] チャンキムバック
      * @name  addOiwaiMoneyAll()
      * @todo  すべてのお祝い金変更
      * @param　mst_happy_moneysの全データ
      * @return TRUE 　成功
      *         FALSE 失敗
      */
      public function updateOiwaiMoneyAll($happy_money_data){
        $ret = false;  //戻り値
        if ( $happy_money_data && is_array($happy_money_data) && count($happy_money_data) > 0){
            $this->db->update_batch("mst_happy_moneys", $happy_money_data, 'id');
            $ret = true;
        }
        return $ret;
      }

      function uniqueJoyspeUserHappyMoney($joypseHappyMoney, $userHappyMoney) {
        $this->db->select('id, joyspe_happy_money, user_happy_money');
        $this->db->from('mst_happy_moneys');
        $this->db->where('joyspe_happy_money', $joypseHappyMoney);
        $this->db->where('user_happy_money', $userHappyMoney);
        $this->db->limit(1);

        $query = $this->db->get();
        if($query->num_rows == 1) {
          return true;
        }
        else {
          return false;
        }
      }

      public function getNewsPoints() {
          $sql = 'SELECT point
                FROM mst_newsletter_point
                WHERE display_flag = 1';
          $query = $this->db->query($sql);
          return $query->row_array();
      }
      public function inactiveNewsPoint($data) {
        $this->db->where('display_flag', 1);
        $this->db->update('mst_newsletter_point', $data);
      }
      public function insertNewsPoint($data) {
        $this->db->insert('mst_newsletter_point', $data);
        return $this->db->insert_id();
      }
      
      public function getMakiaLoginBonus() {
          $sql = "SELECT condition_no, number_of_days, bonus_point, created_date 
                  FROM mst_point_login_bonus
                  WHERE display_flag = 1
                  ORDER BY condition_no ASC";
                  
          $query = $this->db->query($sql);
          return $query->result_array();
      }      
      
      public function getMonthlyCampaignResultAds() {
          $sql = "SELECT month, travel_expense_total_paid_money, trial_work_total_paid_money
                  FROM monthly_campaign_result_ads
                  WHERE display_flag = 1
                  ORDER BY month ASC";
                  
          $query = $this->db->query($sql);
          return $query->row_array();
      }  
          
      public function deleteMakiaLoginBonus() {
          $sql = "UPDATE mst_point_login_bonus 
                  SET display_flag = 0
                  WHERE display_flag = 1";              
          $this->db->query($sql);            
      }
      
      public function createNewMakiaLoginBonus($data) {
          $ret = false;
          if ( $data ) {
              $this->db->insert('mst_point_login_bonus', $data);
              $ret = $this->db->affected_rows() > 0 ? true : false;
          }
          return $ret;
      }
      
      public function deleteMonthlyCampaignResultAds() {
          $sql = "UPDATE monthly_campaign_result_ads 
                  SET display_flag = 0
                  WHERE display_flag = 1";              
          $this->db->query($sql);            
      }
      
      public function createMonthlyCampaignResultAds($data) {
          $ret = false;
          if ($data) {
              $this->db->insert('monthly_campaign_result_ads', $data);
              $ret = $this->db->affected_rows() > 0 ? true : false;
          }
          return $ret;
      }
      
    }
?>

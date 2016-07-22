<?php
    class Mauthentication extends CI_Model{
        public function __construct() {
            parent::__construct();
        }
        
        /**
         * @author     [IVS] Phan Van Thuyet
         * @name        listPaymentMethods
         * @todo        view list payment methods
         * @param 	 
         * @return 	
         */
        function countPaymentMethods(){
            $sql='SELECT ow.`unique_id`, ow.`storename`, owr.`created_date`
                  FROM `owner_recruits` owr
                  INNER JOIN owners ow ON owr.`owner_id` = ow.`id`
                  WHERE owr.`display_flag` = 1 AND ow.`display_flag` = 1 AND owr.recruit_status = 1';
            
            $result=$this->db->query($sql);
            return $result->num_rows();
        }
        
        /**
         * @author     [IVS] Phan Van Thuyet
         * @name        listPaymentMethods
         * @todo        view list payment methods
         * @param 	 
         * @return 	
         */
        function listPaymentMethods($limit, $offset){
            $sql='SELECT owr.id, ow.`unique_id`, ow.`storename`, DATE_FORMAT(owr.`created_date`,"%Y/%m/%d %H:%i") AS created_date
                  FROM `owner_recruits` owr
                  INNER JOIN owners ow ON owr.`owner_id` = ow.`id`
                  WHERE owr.`display_flag` = 1 AND ow.`display_flag` = 1 AND owr.recruit_status = 1';
            
            $sql = $sql." ORDER BY created_date DESC LIMIT ".$limit." OFFSET ".$offset."";
            $result=$this->db->query($sql);
            return $result->result_array();
        }
        /**
         * @author     [IVS] Phan Van Thuyet
         * @name        listPaymentMethods
         * @todo        view list payment methods
         * @param 	 
         * @return 	
         */
        function listProfile($id){
            $sql="SELECT ow.email_address,ow.storename,ow.pic, owr.image1,owr.image2,owr.image3,
                owr.image4,owr.image5,owr.image6,owr.company_info,owr.nearest_station,owr.working_style_note 
		FROM owners AS ow INNER JOIN owner_recruits AS owr
                ON ow.id = owr.owner_id
                WHERE owr.id= ? AND owr.display_flag=1";
            return $this->db->query($sql,array($id))->row_array();
        }
          /**
         * @author     [IVS] Nguyen Minh Ngoc
         * @name        showProfile
         * @todo        show information of owner
         * @param 	 $id
         * @return 	
         */
        public function showProfile($id){
            $sql="SELECT ow.set_send_mail as smail,owr.id as reid,ow.id as wid,owr.main_image,ow.pic,owr.error_recruit_content,owr.error_recruit_note,ow.email_address,ow.storename,owr.image1,owr.image2,owr.image3,owr.image4,owr.image5,owr.image6,owr.company_info,owr.nearest_station,owr.working_style_note 
		FROM owners AS ow INNER JOIN owner_recruits AS owr
                ON ow.id = owr.owner_id
                WHERE owr.id=? AND owr.display_flag=1";
            return $this->db->query($sql,array($id))->result_array();
        }
             /**
         * @author     [IVS] Nguyen Minh Ngoc
         * @name        showProfile
         * @todo        show information of owner
         * @param 	 
         * @return 	
         */
        public function showProfile03($id){
            $sql="SELECT owr.id as reid,ow.id as wid,owr.main_image,ow.pic,owr.error_recruit_content,owr.error_recruit_note,ow.email_address,ow.storename,owr.image1,owr.image2,owr.image3,owr.image4,owr.image5,owr.image6,owr.company_info,owr.nearest_station,owr.working_style_note 
		FROM owners AS ow INNER JOIN owner_recruits AS owr
                ON ow.id = owr.owner_id
                WHERE owr.id=? AND owr.display_flag=1";
            return $this->db->query($sql,array($id))->result_array();
        }
            /**
         * @author     [IVS] Nguyen Minh Ngoc
         * @name        showProfile2
         * @todo        show information of owner
         * @param 	 
         * @return 	
         */
        public function showProfile2($id){
            $sql="SELECT owr.id as reid,ow.id as wid,owr.main_image,ow.pic,owr.error_recruit_content,owr.error_recruit_note,ow.email_address,ow.storename,owr.image1,owr.image2,owr.image3,owr.image4,owr.image5,owr.image6,owr.company_info,owr.nearest_station,owr.working_style_note 
		FROM owners AS ow INNER JOIN owner_recruits AS owr
                ON ow.id = owr.owner_id
                WHERE owr.id=? AND owr.display_flag=1 AND recruit_status=2";
            return $this->db->query($sql,array($id))->result_array();
        }
             /**
         * @author     [IVS] Nguyen Minh Ngoc
         * @name        updateOW
         * @todo        update ok profile
         * @param 	 
         * @return 	
         */
        public function updateOW($id,$store,$pic,$info,$station,$stylework,$ernote,$image1,$image2,$image3,$image4,$image5,$image6,$main,$time,$rid){
           $sql="UPDATE owners set storename='".$this->db->escape_str($store)."', pic='".$this->db->escape_str($pic)."',updated_date='".$this->db->escape_str($time)."'  WHERE id='".$this->db->escape_str($id)."'";
           $sql1 ="UPDATE owner_recruits set image1='".$this->db->escape_str($image1)."',image2='".$this->db->escape_str($image2)."', image3='".$this->db->escape_str($image3)."', image4='".$this->db->escape_str($image4)."',image5='".$this->db->escape_str($image5)."',image6='".$this->db->escape_str($image6)."',
              error_recruit_note='".$this->db->escape_str($ernote)."',nearest_station='".$this->db->escape_str($station)."',working_style_note='".$this->db->escape_str($stylework)."', company_info ='".$this->db->escape_str($info)."',main_image='".$this->db->escape_str($main)."', recruit_status=2,recruit_approve_date='".$this->db->escape_str($time)."'
                  WHERE id='".$this->db->escape_str($rid)."'";
           $this->db->query($sql);
           $this->db->query($sql1);
        }
             /**
         * @author     [IVS] Nguyen Minh Ngoc
         * @name        updateOW2
         * @todo        update non profile
         * @param 	 
         * @return 	
         */
          public function updateOW2($id,$store,$pic,$info,$station,$stylework,$ernote,$ercenter,$image1,$image2,$image3,$image4,$image5,$image6,$main,$time,$rid){
            $sql="UPDATE owners set storename='".$this->db->escape_str($store)."', pic='".$this->db->escape_str($pic)."', updated_date='".$this->db->escape_str($time)."'  WHERE id='".$this->db->escape_str($id)."'";
           $sql1 ="UPDATE owner_recruits set image1='".$this->db->escape_str($image1)."',image2='".$this->db->escape_str($image2)."', image3='".$this->db->escape_str($image3)."', image4='".$this->db->escape_str($image4)."',image5='".$this->db->escape_str($image5)."',
               image6='".$this->db->escape_str($image6)."',error_recruit_note='".$this->db->escape_str($ernote)."',error_recruit_content='".$this->db->escape_str($ercenter)."',nearest_station='".$this->db->escape_str($station)."',working_style_note='".$this->db->escape_str($stylework)."', company_info ='".$this->db->escape_str($info)."',main_image='".$this->db->escape_str($main)."' 
                  ,recruit_deny_date='".$this->db->escape_str($time)."',recruit_status=3 WHERE id='".$this->db->escape_str($rid)."'";
           $this->db->query($sql);
           $this->db->query($sql1);
        }
        /**
	 * @name    updateOW01 	
	 * @todo 	Nguyen Minh Ngoc
	 * @param 	 
	 * @return 	
	*/
        public function updateOW01($id,$store,$pic,$info,$station,$stylework,$ernote,$image1,$image2,$image3,$image4,$image5,$image6,$main,$time,$rid){
           $sql="UPDATE owners set storename='".$this->db->escape_str($store)."', pic='".$this->db->escape_str($pic)."',updated_date='".$this->db->escape_str($time)."'  WHERE id='".$this->db->escape_str($id)."'";
           $sql1 ="UPDATE owner_recruits set image1='".$this->db->escape_str($image1)."',image2='".$this->db->escape_str($image2)."', image3='".$this->db->escape_str($image3)."', image4='".$this->db->escape_str($image4)."',image5='".$this->db->escape_str($image5)."',image6='".$this->db->escape_str($image6)."',
              error_recruit_note='".$this->db->escape_str($ernote)."',nearest_station='".$this->db->escape_str($station)."',working_style_note='".$this->db->escape_str($stylework)."', company_info ='".$this->db->escape_str($info)."',main_image='".$this->db->escape_str($main)."', recruit_status=2,recruit_approve_date='".$this->db->escape_str($time)."'
                  WHERE id='".$this->db->escape_str($rid)."'";
           $this->db->query($sql);
           $this->db->query($sql1);
        }
        /**
	 * @author  [IVS] Nguyen Hoai Nam
	 * @name    getSearchOwnerApprovedQuery 	
	 * @todo 	
	 * @param 	 
	 * @return 	
	*/
        public function getSearchOwnerApprovedQuery($email, $name, $dateFrom, $dateTo){
            $strQuery1 = "";
            $strQuery2 = "";
            $strQuery3 = "";
            $strQuery4 = "";
            if($email !=""){
                $strQuery1 = " AND o.email_address LIKE '%".$this->db->escape_like_str($email)."%' ";   
            }
            if($name !=""){
                $strQuery2 = " AND o.storename LIKE '%".$this->db->escape_like_str($name)."%' ";   
            }
            if($dateFrom !=""){
                $strQuery3 = " AND DATEDIFF('".$this->db->escape_like_str($dateFrom)."',r.recruit_approve_date ) <= 0 ";   
            }
            if($dateTo !=""){
                $strQuery4 = " AND DATEDIFF('".$this->db->escape_like_str($dateTo)."',r.recruit_approve_date) >= 0 ";   
            }
            return $sql = "SELECT r.id AS id, o.email_address AS email_address, o.storename AS storename, 
                                    r.created_date AS created_date, r.recruit_approve_date AS recruit_approve_date 
                           FROM owners o  
                           INNER JOIN owner_recruits r ON r.owner_id = o.id 
                           WHERE r.recruit_status = 2
                           AND r.display_flag = 1
                           AND o.display_flag = 1".$strQuery1." ".$strQuery2." ".$strQuery3." ".$strQuery4." 
                           ORDER BY created_date DESC, recruit_approve_date DESC ";
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
	 * @name    getResultSearchOwnerApproved 	
	 * @todo 	
	 * @param 	 
	 * @return 	
	*/
        public function getResultSearchOwnerApproved($sql,$limit,$offset){
            $sql = $sql."LIMIT ".$limit." OFFSET ".$offset."";
            return $this->db->query($sql)->result_array();
        }
        /**
	 * @author  [IVS] Nguyen Hoai Nam
	 * @name    getSearchOwnerUnapprovedQuery 	
	 * @todo 	
	 * @param 	 
	 * @return 	
	*/
        public function getSearchOwnerUnapprovedQuery($email, $name, $dateFrom, $dateTo){
            $strQuery1 = "";
            $strQuery2 = "";
            $strQuery3 = "";
            $strQuery4 = "";
            if($email !=""){
                $strQuery1 = " AND o.email_address LIKE '%".$this->db->escape_like_str($email)."%' ";   
            }
            if($name !=""){
                $strQuery2 = " AND o.storename LIKE '%".$this->db->escape_like_str($name)."%' ";   
            }
            if($dateFrom !=""){
                $strQuery3 = " AND DATEDIFF('".$this->db->escape_like_str($dateFrom)."',r.recruit_deny_date) <= 0 ";   
            }
            if($dateTo !=""){
                $strQuery4 = " AND DATEDIFF('".$this->db->escape_like_str($dateTo)."',r.recruit_deny_date) >= 0 ";   
            }
            return $sql = "SELECT o.id AS id, o.email_address AS email_address, o.storename AS storename, 
                                    r.created_date AS created_date, r.recruit_deny_date AS recruit_deny_date 
                           FROM owners o  
                           LEFT OUTER JOIN owner_recruits r ON r.owner_id = o.id 
                           WHERE r.recruit_status = 3
                           AND r.display_flag = 1
                           AND o.display_flag = 1".$strQuery1." ".$strQuery2." ".$strQuery3." ".$strQuery4." 
                           ORDER BY created_date DESC, recruit_deny_date DESC ";
        }
        /**
	 * @author  [IVS] Nguyen Hoai Nam
	 * @name    getResultSearchOwnerUnapproved 	
	 * @todo 	
	 * @param 	 
	 * @return 	
	*/
        public function getResultSearchOwnerUnapproved($sql,$limit,$offset){
            $sql = $sql."LIMIT ".$limit." OFFSET ".$offset."";
            return $this->db->query($sql)->result_array();
        }
        /**
	 * @author  [IVS] Nguyen Hoai Nam
	 * @name    getOwnerInfoById 	
	 * @todo 	
	 * @param 	 
	 * @return 	
	*/
        public function getOwnerInfoById($id){
            $sql = "SELECT o.id AS id, o.email_address AS email_address, 
                            o.storename AS storename, o.pic AS pic,
                            r.company_info AS company_info, r.main_image AS main_image, 
                            r.image1 AS image1, r.image2 AS image2, r.image3 AS image3,
                            r.image4 AS image4, r.image5 AS image5, r.image6 AS image6,
                            r.error_recruit_note AS error_recruit_note, 
                            r.error_recruit_content AS error_recruit_content,
                            r.nearest_station AS nearest_station,
                            r.working_style_note AS working_style_note
                    FROM owners o
                    INNER JOIN owner_recruits r ON r.owner_id = o.id
                    WHERE o.display_flag = 1
                    AND r.display_flag = 1
                    AND o.id = ?";
            return $this->db->query($sql,array($id))->row_array();
        }
            /**
         * author: [IVS] Nguyen Minh Ngoc
         * name : approveOwn
         * todo : update display flag when approve
         * @param null
         * @return null
         */
        public function approveOwn($id){
            $sql ="UPDATE `owner_recruits` SET `display_flag` = 0 WHERE id IN 
            (SELECT id FROM
            (SELECT id FROM `owner_recruits` WHERE `recruit_status` = 2 AND `display_flag` = 1 AND owner_id =?) AS arbitraryTableName)";
            $this->db->query($sql,array($id));
        }
     
    }

?>

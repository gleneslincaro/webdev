<?php

class Mhappymoney extends CI_Model{
    function __construct() {
        parent::__construct();
    }
    /*
    * @author: IVS_Nguyen_Ngoc_Phuong
    * get all owner in favorite list of user
    * @param:user id
    */
    public function getHappyMoneyList($id,$get,$limithpm,$day_happy_money){
        $condition_get='';
        //  value of dropdownlist 
        // get all owner that user apply and take happy money
        if($get==3)
        {
            $condition_get="AND UP.user_payment_status NOT IN (2)";
        }
        // get owners that were applied by user
        if($get==1)
        {
            $condition_get=" AND UP.user_payment_status NOT IN (2,5,6) ";
        }
        // get owners that user taked happy money
        if($get==2){
            $condition_get=" AND UP.`user_payment_status`IN (5,6)";
        }
        $sql="SELECT  
              UP.`user_id`,UP.`user_payment_status`,DATE_ADD(UP.interview_date, INTERVAL ? HOUR) as day,
              ORS.id AS ors_id,OW.storename, MHM.image,ORS.main_image,ORS.image1,ORS.`image2`,ORS.`image3`,ORS.`image4`,ORS.`image5`,ORS.`image6`,
              ORS.`company_info` ,MHM.`user_happy_money`,MC.`name`,
              MC.name AS city_name, MCG.name AS group_name, MT.name AS town_name, ORS.`title`,
              ORS.`apply_tel`, ORS.`apply_emailaddress`, ORS.`salary`, ORS.`owner_id`,
              OW.`public_info_flag`
              FROM 
              `owner_recruits` ORS
              INNER JOIN `user_payments` UP
              ON UP.`owner_recruit_id`= ORS.id
              INNER JOIN owners OW
              ON OW.`id`= ORS.`owner_id`
              INNER JOIN mst_happy_moneys MHM
              ON MHM.`id`= ORS.`happy_money_id`

              INNER JOIN mst_cities MC
              ON MC.`id`= ORS.`city_id`
              LEFT JOIN mst_city_groups MCG
              ON MCG.`id`= ORS.`city_group_id`    
              LEFT JOIN mst_towns MT
              ON MT.id = ORS.`town_id`              

              WHERE
		UP.`user_id`= ?
		".$condition_get.
                "AND OW.display_flag = 1
                 AND (OW.owner_status = 2 OR OW.owner_status = 1 OR OW.owner_status = 3)   
                AND MC.display_flag = 1
                AND ORS.recruit_status = 2
                ORDER BY ORS.created_date DESC limit ?";
                //echo $sql;
        $query= $this->db->query($sql ,array($day_happy_money,$id,$limithpm));
        return $query->result_array();
    }
    public function getAllHappyMoneyList($get,$id){
         $condition_get='';
        //  value of dropdownlist 
        // get all owner that user apply and take happy money
        if($get==3)
        {
            $condition_get="AND UP.user_payment_status NOT IN (2)";
        }
        // get owners that were applied by user
        if($get==1)
        {
            $condition_get=" AND UP.user_payment_status NOT IN (2,5,6) ";
        }
        // get owners that user taked happy money
        if($get==2){
            $condition_get=" AND UP.user_payment_status IN (5,6)";
        }
        $sql="SELECT  
              UP.`user_id`,UP.`user_payment_status`,
                ORS.id AS ors_id,OW.storename, MHM.image,ORS.main_image,ORS.image1,ORS.`image2`,ORS.`image3`,ORS.`image4`,ORS.`image5`,ORS.`image6`,
              ORS.`company_info` ,MHM.`user_happy_money`,MC.`name`, OW.`public_info_flag`
              FROM 
              `owner_recruits` ORS
              INNER JOIN `user_payments` UP
              ON UP.`owner_recruit_id`= ORS.id
              INNER JOIN owners OW
              ON OW.`id`= ORS.`owner_id`
              INNER JOIN mst_happy_moneys MHM
              ON MHM.`id`= ORS.`happy_money_id`


              INNER JOIN mst_cities MC
              ON MC.`id`= ORS.`city_id`
              
              WHERE
              UP.`user_id`= ?
              ".$condition_get.
              "AND  OW.display_flag = 1
              AND (OW.owner_status = 2 OR OW.owner_status = 1 OR OW.owner_status = 3)
              AND MC.display_flag = 1
              AND ORS.recruit_status = 2
              ORDER BY ORS.created_date";
        $query= $this->db->query($sql ,array($id));
        return $query->result_array();
    }
    /*
    * @author: IVS_Nguyen_Ngoc_Phuong
    * get user_payment_satus
    * @param: user_id and owner_recruit_id
    */
    public function getUserPaymentStt($user_id,$ors_id,$day_happy_money){
        $sql="SELECT `user_payment_status`,DATE_ADD(interview_date, INTERVAL ? HOUR )as day_inter
            FROM user_payments 
            WHERE user_id= ? AND `owner_recruit_id`= ?";
        $query=$this->db->query($sql ,array($day_happy_money,$user_id ,$ors_id));
        return $query->row_array();
    }
    /*
    * @author: IVS_Nguyen_Ngoc_Phuong
    * get user_payment_satus
    * @param: user_id and owner_recruit_id
    */
    public function getScoutSpam($user_id,$ors_id){
        $sql="SELECT SMS.`display_flag` as stt
            FROM `scout_message_spams` SMS 
            INNER JOIN `owner_recruits`ORS
            ON ORS.`owner_id`=SMS.`owner_id` 
            WHERE 
            user_id= ? AND ORS.id= ?";
        $query=$this->db->query($sql ,array($user_id ,$ors_id));
        return $query->row_array();
    }
    /*
    * @author: IVS_Nguyen_Ngoc_Phuong
    * update user_payment_satus
    * @param: user_id and owner_recruit_id
    */
    public function updatePaymentsSttt($user_id,$ors_id){
           $data=array(
               "user_payment_status"=>5,
               "request_money_date"=>date("y-m-d H:i:s")
           ); 
           $where=array(
               "user_id"=>$user_id,
               "owner_recruit_id"=>$ors_id
           );
           $this->db->where($where);
           $this->db->update("user_payments",$data);
           return ($this->db->affected_rows() != 1) ? false : true;
    }
    /*
    * @author: [IVS]Nguyen Ngoc Phuong
    * show information company 
    * $param: owner_recruits_id
    */
    public function getCompanyCelebration($ors_id){
         $sql=" SELECT  OW.`public_info_flag`as public_stt,
                ORS.id AS ors_id,OW.storename, MHM.image,ORS.`main_image`,ORS.`image1`,ORS.`image2`,ORS.`image3`,ORS.`image4`,ORS.`image5`,ORS.`image6`,
                ORS.`company_info` ,MHM.`user_happy_money`,MC.`name` AS citiname
                ,ORS.`cond_happy_money` ,ORS.`title`, OW.`address`, MC.name AS city_name, MCG.name AS group_name, MT.name AS town_name, ORS.apply_time,
                ORS.apply_tel, ORS.apply_emailaddress, ORS.line_id, ORS.con_to_apply, ORS.salary, ORS.work_place, ORS.working_day, ORS.working_time,
                ORS.how_to_access, ORS.home_page_url, OW.kuchikomi_url, OW.id AS owner_id
                
                FROM owners OW
                INNER JOIN `owner_recruits` ORS
                ON OW.`id`= ORS.`owner_id`
                INNER JOIN mst_happy_moneys MHM
                ON MHM.`id`= ORS.`happy_money_id`


                INNER JOIN mst_cities MC
                ON MC.`id`= ORS.`city_id`
                LEFT JOIN mst_city_groups MCG
                ON MCG.`id`= ORS.`city_group_id`    
                LEFT JOIN mst_towns MT
                ON MT.id = ORS.`town_id`                

                WHERE
                ORS.`id`= ?
                AND OW.display_flag = 1
                AND MC.display_flag = 1
                AND ORS.recruit_status = 2";
            $query = $this->db->query($sql,array($ors_id));
            return $query->result_array();
     } 
} 
?>

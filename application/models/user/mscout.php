<?php

class Mscout extends CI_Model{
    function __construct() {
        parent::__construct();
    }
    /**
     * @author: [IVS]Nguyen Ngoc Phuong
     * @param: user id and limit
     */
    public function getListScout($user_id, $limit){
        $sql="SELECT  DISTINCT
                ORS.id AS ors_id,OW.storename, MHM.image,ORS.main_image,ORS.image1,ORS.`image2`,ORS.`image3`,ORS.`image4`,ORS.`image5`,ORS.`image6`,
                ORS.`company_info`,MHM.`user_happy_money`,MC.`name`, MC.`name` AS city_name, MCG.name AS group_name, MT.name AS town_name,
                ORS.apply_tel, ORS.apply_emailaddress, ORS.salary, ORS.title
                FROM
                list_user_messages LUM
                INNER JOIN `owner_recruits` ORS
                ON LUM.`owner_recruit_id`=ORS.id
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
                LUM.user_id= ? AND
                LUM.display_flag = 1
                AND OW.display_flag = 1
                AND OW.owner_status = 2
                AND MC.display_flag = 1
                AND ORS.recruit_status = 2
                AND (LUM.`template_id`= 25 || LUM.`template_id`= 63)
                AND LUM.`payment_message_status` = 1
                ORDER BY LUM.`updated_date` DESC limit ?";
        $query= $this->db->query($sql,array($user_id, $limit));
        return $query->result_array();
    }
    public function countOwnerList($user_id){
        $sql="SELECT  DISTINCT
                ORS.id AS ors_id,OW.storename, MHM.image,ORS.main_image,ORS.image1,ORS.`image2`,ORS.`image3`,ORS.`image4`,ORS.`image5`,ORS.`image6`,
                ORS.`company_info` ,MHM.`user_happy_money`,MC.`name`
                FROM 
                list_user_messages LUM
                INNER JOIN
                `owner_recruits` ORS
                ON LUM.`owner_recruit_id`=ORS.id
                INNER JOIN owners OW
                ON OW.`id`= ORS.`owner_id`
                INNER JOIN mst_happy_moneys MHM
                ON MHM.`id`= ORS.`happy_money_id`
                INNER JOIN mst_cities MC
                ON MC.`id`= ORS.`city_id`                
                WHERE
                LUM.user_id= ? AND
                LUM.display_flag=1
                AND OW.display_flag=1
                AND OW.owner_status =2
                AND MC.display_flag = 1 
                AND ORS.recruit_status = 2
                AND (LUM.`template_id`= 25 || LUM.`template_id`= 63)
                AND LUM.`payment_message_status`=1
                ORDER BY LUM.`updated_date`";
        return $this->db->query($sql,array($user_id))->num_rows();
    }
     /*
     * @author: IVS_Nguyen_Ngoc_Phuong
     * get user_payment_status by user_id and owner_recruits_id
     * @param: user_id, owner_recruits_id
     */
    public function getUserPaySTT($ors_id,$user_id,$day_happy_money){
            $sql="SELECT `user_payment_status` as paymentstt,
                DATE_ADD(UP.interview_date, INTERVAL ? HOUR) as day
            FROM 
            `user_payments` UP   
            WHERE UP.`user_id`= ?
            AND UP.owner_recruit_id= ? ";
            //echo $sql;
            $query= $this->db->query($sql ,array($day_happy_money,$user_id ,$ors_id));
            $row= $query->row_array();
            $count=count($row);
            if($count==0){
                return -1;
            }  else {
                return $row;
            }
    } 
    /*
     * @author: IVS_NNPhuong
     * get KeepSTT
     * @param: owner_recruit_id, @user_id
     * @return: #0 or 0
     */
    public function getUserKeepSTT($ors_id,$user_id){
        $sql="SELECT *
            FROM `favorite_lists` FL
            WHERE FL.`user_id`= ?
            AND FL.owner_recruit_id= ?
            AND FL.`display_flag`=1";
         return $this->db->query($sql,array($user_id,$ors_id))->num_rows();   
    }
}
?>

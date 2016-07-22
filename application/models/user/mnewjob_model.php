<?php

class Mnewjob_model extends CI_Model {
    public function __construct() {
        parent::__construct();
    }
    /*
    * @author:IVS_VTAn
    * show Index Top
    * @param index
    */
    public function getAll($limit,$user_id){
        $ownerapply='';
        if( $user_id && $user_id != 0 ){
            $data_prepare_sql = "SELECT distinct ORS.owner_id, LSM.owner_recruit_id
                                 FROM owner_recruits ORS
                                 INNER JOIN list_user_messages LSM
                                 ON  LSM.owner_recruit_id = ORS.id
                                 AND LSM.user_id = ?
                                 AND LSM.template_id=25
                                 AND LSM.display_flag = 1
                                 AND LSM.payment_message_status = 1";
            $query = $this->db->query($data_prepare_sql,$user_id);
            $scout_owners_str = null;
            $scout_owner_recruits_str = null;
            //　スカウトメール送信オナーリストと求人リストID取得（スピード改善のため、sqlに使用される固定配列を先に取得）
            if ( $query ){
                $temp = $query->result_array();
                if ( $temp && is_array($temp) ){
                    $scout_owners_list = array();
                    $scout_owner_recruits_list = array();
                    foreach ($temp as $key => $value) {
                       $scout_owners_list[]  = $value['owner_id'];
                       $scout_owner_recruits_list[] = $value['owner_recruit_id'];
                    }
                    $scout_owners_str = join("','",$scout_owners_list);
                    $scout_owner_recruits_str = join("','",$scout_owner_recruits_list);
                }
            }
            //sql準備
            if ( $scout_owners_str && $scout_owner_recruits_str  ){
                $sql_and_cond = " AND ((ORS.`display_flag`=1 AND ORS.owner_id not in ( '$scout_owners_str' ))
                                  OR (ORS.id in ( '$scout_owner_recruits_str' ))) ";
            }else{
                $sql_and_cond = " AND ORS.`display_flag`=1 ";
            }
            $ownerapply =
            " AND OW.id NOT IN(
                SELECT ORS.owner_id FROM
                `user_payments` UP
                INNER JOIN `owner_recruits` ORS
                ON ORS.id= UP.`owner_recruit_id`
                WHERE
                UP.`user_id`= ?
                AND UP.`user_payment_status` NOT IN(2)
                )".$sql_and_cond;

        } else {
            $ownerapply = " AND ORS.`display_flag`=1 ";
        }

        $sql = "SELECT * FROM  (
                SELECT DISTINCT ORS.owner_id,ORS.id AS ors_id,
                OW.`storename`, MC.name AS city_name, MCG.name AS group_name, MT.name AS town_name, ORS.`title`,
                ORS.`apply_tel`, ORS.`apply_emailaddress`, ORS.`salary`,
                ORS.`main_image`, ORS.`image1`, ORS.`image2`, ORS.`image3`, ORS.`image4`, ORS.`image5`, ORS.`image6`,
                MHM.`user_happy_money`,MHM.image,
                ORS.`created_date`
                
                FROM `owner_recruits` ORS
                INNER JOIN owners OW
                ON OW.`id`= ORS.`owner_id`
                INNER JOIN mst_happy_moneys MHM
                ON ORS.`happy_money_id`= MHM.`id`                
                INNER JOIN mst_cities MC
                ON MC.`id`= ORS.`city_id`                
                LEFT JOIN mst_city_groups MCG
                ON MCG.`id`= ORS.`city_group_id`    
                LEFT JOIN mst_towns MT
                ON MT.id = ORS.`town_id`
                
                WHERE
                MC.display_flag =1 AND
                ORS.recruit_status = 2 AND
                OW.`display_flag`=1 AND
                OW.`owner_status`=2 AND
                OW.`public_info_flag` = 1"
                .$ownerapply.
                "
                UNION
                (
                SELECT DISTINCT
                ORS.owner_id,
                ORS.id AS ors_id,
                OW.`storename`,
                MC.name AS city_name, MCG.name AS group_name, MT.name AS town_name, ORS.`title`,
                ORS.`apply_tel`, ORS.`apply_emailaddress`, ORS.`salary`,
                ORS.`main_image`,
                ORS.`image1`,
                ORS.`image2`,
                ORS.`image3`,
                ORS.`image4`,
                ORS.`image5`,
                ORS.`image6`,
                MHM.`user_happy_money`,
                MHM.image,                
                ORS.`created_date`
                FROM
                `user_payments` UP
                INNER JOIN `owner_recruits` ORS
                ON UP.`owner_recruit_id`= ORS.`id`
                INNER JOIN `owners` OW
                ON ORS.`owner_id`= OW.id
                INNER JOIN mst_happy_moneys MHM
                ON MHM.`id`= ORS.`happy_money_id`                
                INNER JOIN mst_cities MC
                ON MC.`id`= ORS.`city_id`                
                LEFT JOIN mst_city_groups MCG
                ON MCG.`id`= ORS.`city_group_id`
                LEFT JOIN mst_towns MT
                ON MT.id = ORS.`town_id` 
                WHERE
                MC.display_flag =1 AND
                OW.display_flag =1
                AND OW.owner_status =2
                AND OW.`public_info_flag` = 1
                AND UP.user_id= ?
                AND UP.`user_payment_status` NOT IN(2)
                )) AS SearchResult
                ORDER BY SearchResult.`created_date` DESC LIMIT ?";
        if( $user_id && $user_id != 0){
            $query = $this->db->query($sql, array($user_id, $user_id, $limit));
        }else{
            $query = $this->db->query($sql, array($user_id, $limit));
        }
        return $query->result_array();
    }
    /*
    * @author:IVS_VTAn
    * count all record
    * @param paging index
    */
    public function countOwner(){
        $sql = "SELECT DISTINCT OW.`id`, ORS.`id`AS ors_id FROM
                owners OW
                INNER JOIN `owner_recruits` ORS
                ON OW.`id`= ORS.`owner_id`
                INNER JOIN `mst_cities` MC
                ON MC.`id`= ORS.`city_id`
                INNER JOIN `mst_happy_moneys` MHM
                ON MHM.`id`= ORS.`happy_money_id`
                INNER JOIN `treatments_owners` TWO
                ON TWO.`owner_recruit_id`= ORS.`id`
                INNER JOIN `mst_treatments` MT
                ON MT.`id`= TWO.`treatment_id`
                WHERE OW.`display_flag`=1
                AND OW.`owner_status`=2
                AND ORS.`display_flag`=1
                AND ORS.`recruit_status`=2
                AND MC.`display_flag`=1
                AND OW.public_info_flag = 1
            ";
        return $this->db->query($sql)->num_rows();
    }
    /*
     * @author:IVS_VTAn
     * show Company  from page Index
     * @param Detail
     */
     public function getAllCompany($id,$owner_status = 2){
        $sql = "SELECT  OW.`public_info_flag`as public_stt, OW.`happy_money_type`as happy_money_type, OW.`happy_money`as happy_money,
                ORS.id AS ors_id,OW.storename, MHM.image,ORS.`main_image`,ORS.`image1`,ORS.`image2`,ORS.`image3`,ORS.`image4`,ORS.`image5`,ORS.`image6`,
                ORS.`company_info` ,MHM.`user_happy_money`,MC.`name` AS citiname,ORS.`cond_happy_money`,
                ORS.`title`, OW.`address`, MC.id AS city_id, MCG.id AS group_id, MT.id AS town_id, MC.name AS city_name, MCG.name AS group_name, MT.name AS town_name, MC.alph_name AS city_alph_name, MCG.alph_name AS group_alph_name, MT.alph_name AS town_alph_name, ORS.apply_time,
                ORS.apply_tel, ORS.apply_emailaddress, ORS.line_id, ORS.con_to_apply, ORS.salary, ORS.work_place, ORS.working_day, ORS.working_time,
                ORS.how_to_access, ORS.home_page_url, OW.kuchikomi_url, ORS.display_flag, ORS.owner_id, ORS.other_service, ORS.visiting_benefits_title_1,
                ORS.visiting_benefits_title_2, ORS.visiting_benefits_title_3, visiting_benefits_content_1,
                MJT.name AS job_type_name, MJT.alph_name AS job_type_alph_name,
                visiting_benefits_content_2, visiting_benefits_content_3, line_url, OW.owner_status
                FROM owners OW
                INNER JOIN `owner_recruits` ORS
                ON OW.`id`= ORS.`owner_id`
                INNER JOIN mst_happy_moneys MHM
                ON MHM.`id`= ORS.`happy_money_id`


                INNER JOIN mst_cities MC
                ON MC.`id`= ORS.`city_id`                
                LEFT JOIN mst_city_groups MCG
                ON MCG.id = ORS.`city_group_id`
                LEFT JOIN mst_towns MT
                ON MT.id = ORS.`town_id`
                
                LEFT JOIN job_type_owners JTO
                ON JTO.owner_recruit_id =  ORS.id
                LEFT JOIN mst_job_types MJT
                ON MJT.id =  JTO.job_type_id

                WHERE
                 ORS.`id`= ?
                AND OW.display_flag = 1
                AND OW.owner_status IN (".$owner_status.")
                AND MC.display_flag = 1       
                AND ORS.recruit_status = 2
                ORDER BY ORS.`created_date` DESC                
            ";
       $query = $this->db->query($sql,array($id));
       return $query->result_array();
    }
     /*
     * @author:IVS_VTAn
     * show page Index
     * @param job_type_name
     */
    public function getJobType($id)
    {
        $sql="
                SELECT mjt.`priority`,mjt.`name`
                FROM job_type_owners jto
                INNER JOIN mst_job_types mjt
                ON jto.`job_type_id`=mjt.`id`
                WHERE mjt.`display_flag`=1
                AND jto.`owner_recruit_id`= ?
                ORDER BY  mjt.`priority` ASC LIMIT 2";
        $query= $this->db->query($sql, array($id));
        return $query->result_array();
    }
    /*
    * @author:IVS_VTAn
    * show page Index
    * @param treatment
    */
    public function getTreatment($id){
        $sql="SELECT treatments_owners.`owner_recruit_id`,mt.`id`,mt.`name` as name ,mt.`priority`
                FROM treatments_owners 
                INNER JOIN mst_treatments mt
                ON treatments_owners.`treatment_id`= mt.`id`
                WHERE
                mt.`display_flag`=1 AND
                treatments_owners.`owner_recruit_id`= ?
                ORDER BY mt.priority ASC LIMIT 5 ";
         $query= $this->db->query($sql,array($id));
         return $query->result_array();
    }
    /*
    * @author:IVS_VTAn
    * show company
    * @param job_type_name
    */
    public function getJobTypeCompany($id)
    {
        $sql="
                SELECT mjt.`priority`,mjt.`name`
                FROM job_type_owners jto
                INNER JOIN mst_job_types mjt
                ON jto.`job_type_id`=mjt.`id`
                WHERE mjt.`display_flag`=1
                AND jto.`owner_recruit_id`= ?
                ORDER BY  mjt.`priority` ASC ";
        $query= $this->db->query($sql, array($id));
        return $query->result_array();
    }
    /*
    * @author:IVS_VTAn
    * show page company
    * @param treatment
    */
    public function getTreatmentCompany($id){
       $sql="SELECT treatments_owners.`owner_recruit_id`,mt.`id`,mt.`name` as name ,mt.`priority`,mt.`group_id` 
               FROM treatments_owners 
               INNER JOIN mst_treatments mt
               ON treatments_owners.`treatment_id`= mt.`id`
               WHERE
               mt.`display_flag`=1 AND
               treatments_owners.`owner_recruit_id`= ?
               ORDER BY mt.priority ASC ";
        $query= $this->db->query($sql,array($id));
        return $query->result_array();
    }  
    
    public function getOwnerRecruitHappyMoney($id) {
      $sql = "select MHM.user_happy_money 
              from owner_recruits ORS
              INNER JOIN mst_happy_moneys MHM
              ON MHM.id = ORS.happy_money_id
              where ORS.id =?";
      $query = $this->db->query($sql, $id);
      return $query->result_array();
    }

    public function geActiveOwnerId($owner_id){
        $ret = 0;
        $sql = "SELECT id FROM owner_recruits WHERE display_flag = 1 AND owner_id = ?";
        $query = $this->db->query($sql, $owner_id);
        if ( $query && $row = $query->row_array() ){
            $ret = $row['id'];
        }
        return $ret;
    }
}
?>

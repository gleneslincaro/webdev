<?php

class Muserview extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    
    public function getAllCompany($id) {
        $sql = "SELECT  OW.`public_info_flag`as public_stt,
                OW.id ,ORS.id AS Ow_id,OW.storename, OW.address,MHM.image,ORS.`main_image`,ORS.`image1`,ORS.`image2`,ORS.`image3`,ORS.`image4`,ORS.`image5`,ORS.`image6`, ORS.`title`,
                ORS.con_to_apply, ORS.salary, ORS.work_place, ORS.working_day, ORS.working_time, MC.name AS city_name, MCG.name AS group_name, MT.name AS town_name,
                ORS.apply_time, ORS.apply_tel, ORS.apply_emailaddress, ORS.line_id, ORS.how_to_access, ORS.home_page_url, ORS.id AS ors_id,
                ORS.`company_info` ,MHM.`user_happy_money`,MC.`name` AS citiname,ORS.`cond_happy_money`

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

                WHERE
                OW.`id`= ? AND
                ORS.display_flag = 1 
                AND ORS.recruit_status=2
                AND  OW.display_flag = 1
                AND MC.display_flag = 1
                ORDER BY ORS.`created_date` DESC                
            ";
        $query = $this->db->query($sql,array($id));
        return $query->result_array();
    }

    public function getJobTypeCompany($id) {     
        $sql = "
                SELECT mjt.`priority`,mjt.`name`
                FROM job_type_owners jto
                INNER JOIN mst_job_types mjt
                ON jto.`job_type_id`=mjt.`id`
                WHERE mjt.`display_flag`=1
                AND jto.`owner_recruit_id`= ?
                ORDER BY  mjt.`priority` ";
        $query = $this->db->query($sql, array($id));
        return $query->result_array();
    }

    /*
     * @author:IVS_VTAn
     * show page company
     * @param treatment
     */

    public function getTreatmentCompany($id) {
        $sql = "SELECT treatments_owners.`owner_recruit_id`,mt.`id`,mt.`name` as name ,mt.`priority`
                FROM treatments_owners 
                INNER JOIN mst_treatments mt
                ON treatments_owners.`treatment_id`= mt.`id`
                WHERE
                mt.`display_flag`=1 AND
                treatments_owners.`owner_recruit_id`= ?
                ORDER BY mt.priority ";

        $query = $this->db->query($sql, array($id));
        return $query->result_array();
    }

}

?>

<?php

class Mcompany extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /* @author: [IVS] Nguyen Van Phong
     * @use in: company/company basic
     * @todo: show information in view_basic page
     */
    public function getCompanyInfo($owner_id) {
        $sql = "SELECT OW.id, OW.email_address, OW.password, OW.storename, OW.address,
                OW.set_send_mail, OW.bank_name, OW.branch_name,
                OW.account_type, OW.account_no, OW.account_name, OW.public_info_flag
                FROM owners OW 
                WHERE OW.`id` = ? AND OW.owner_status IN (1,2) AND OW.display_flag = 1 LIMIT 1";
        $query = $this->db->query($sql, array($owner_id));
        return $query->row_array();
    }

    /* @author: [IVS] Nguyen Van Phong
     * @use in: company/company
     * @todo: show part 1 information of the view page
     */
    public function getCompanyRecruitInfo1($owner_id) {
        $sql = "
            SELECT `email_address`, `password`, `storename`, `address`,
                    `set_send_mail`, `bank_name`, `branch_name`, `account_type`, `account_no`,
                    `account_name`, `happy_money_type`, `happy_money`,
                    public_info_flag                    
            FROM owners 
            WHERE id = ?
                AND display_flag = 1 AND owner_status IN (1,2)
                LIMIT 1
        ";
        $query = $this->db->query($sql, array($owner_id));
        return $query->row_array();
    }

    /* @author: [IVS] Nguyen Van Phong
     * @use in: company/company
     * @todo: show part 2 information of the view page
     */
    public function getCompanyRecruitInfo2($owner_id) {
        $sql = "
            SELECT
                    ORC2.image1, ORC2.image2, ORC2.image3, ORC2.image4, ORC2.image5, ORC2.image6,
                    ORC2.`company_info`, ORC2.public_info_flag,
                    MHM.`joyspe_happy_money`, MHM.`user_happy_money`,
                    ORC2.`cond_happy_money`, ORC2.`work_place`, ORC2.`working_day`, ORC2.`working_time`, ORC2.`how_to_access`,
                    ORC2.`salary`, ORC2.`con_to_apply`, ORC2.`apply_time`, ORC2.`apply_tel`, ORC2.`apply_emailaddress`,
                    ORC2.`home_page_url`, ORC2.`line_id`, MCI.`name` AS city_name, MT.`name` AS town_name,
                    MCG.`name` AS `city_group_name`, ORC2.`title`,ORC2.scout_pr_text, ORC2.new_msg_notify_email, 
                    ORC2.visiting_benefits_title_1, ORC2.visiting_benefits_title_2, ORC2.visiting_benefits_title_3, ORC2.other_service,
                    ORC2.visiting_benefits_content_1, ORC2.visiting_benefits_content_2, ORC2.visiting_benefits_content_3, ORC2.line_url                    
                 FROM
			(SELECT
			ORC.owner_id, ORC.recruit_status, ORC.image1, ORC.image2, ORC.image3, ORC.image4, ORC.image5, ORC.image6,
			ORC.`company_info`, OW.public_info_flag,ORC.city_group_id,
			ORC.`cond_happy_money`, ORC.`city_id`,ORC.happy_money_id,
			ORC.`work_place`, ORC.`working_day`, ORC.`working_time`, ORC.`how_to_access`, ORC.`salary`,
            ORC.`con_to_apply`, ORC.`apply_time`, ORC.`apply_tel`, ORC.`apply_emailaddress`, ORC.`home_page_url`, ORC.`line_id`,
            ORC.`town_id`, ORC.`title`, ORC.scout_pr_text, ORC.new_msg_notify_email, ORC.visiting_benefits_title_1,
            ORC.visiting_benefits_title_2, ORC.visiting_benefits_title_3, ORC.visiting_benefits_content_1, ORC.other_service,
            ORC.visiting_benefits_content_2, ORC.visiting_benefits_content_3, ORC.line_url 
            FROM owner_recruits ORC INNER JOIN owners OW ON ORC.owner_id = OW.id
            WHERE ORC.display_flag = 1
            ) ORC2
                    LEFT JOIN mst_cities MCI ON (ORC2.`city_id` = MCI.`id` AND MCI.`display_flag`=1)
                    LEFT JOIN mst_city_groups MCG ON (ORC2.`city_group_id` = MCG.`id`)
                    LEFT JOIN mst_towns MT ON ORC2.`town_id` = MT.`id`
                    LEFT JOIN mst_happy_moneys MHM ON ORC2.`happy_money_id` = MHM.`id`
                WHERE ORC2.owner_id = ?
                LIMIT 1

            ";
        $query = $this->db->query($sql, array($owner_id));
        return $query->row_array();
    }
    
    /* @author: [IVS] Nguyen Van Phong
     * @use in: company/company
     */
    public function getTreatmentOwner($owner_recruit_id = 0) {
        $sql = "SELECT MTR.id, MTR.name
                FROM treatments_owners TRO INNER JOIN mst_treatments MTR ON TRO.treatment_id = MTR.id
                WHERE TRO.owner_recruit_id = ?
                AND MTR.display_flag = 1";       
        $query = $this->db->query($sql, array($owner_recruit_id));
        return $query->result_array();
    }

    /* @author: [IVS] Nguyen Van Phong
     * @use in: company/company
     */
    public function getAllTreatments() {
        $sql = "SELECT mst_treatments.name, mst_treatments.id
                FROM  mst_treatments 
                WHERE mst_treatments.display_flag = 1
                ORDER BY priority
            ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    
    /* @author: [IVS] Nguyen Van Phong
     * @use in: ompany/do_edit, do_edit_company_store
     */
    public function updateOwner($data, $owid) {
        $this->db->where('id', $owid);
        $this->db->update('owners', $data);
    }

    /* @author: [IVS] Nguyen Van Phong
     * @use in: Company/company_store     
     */
    public function companyStoreEdit($owner_id) {
        $sql = "
            SELECT ORC.id AS orid, ORC.owner_id AS oid, ORC.image1, ORC.image2, ORC.image3, ORC.image4, ORC.image5, ORC.image6,
            ORC.company_info, ORC.city_id, ORC.cond_happy_money, ORC.happy_money_id, ORC.scout_pr_text, MHM.joyspe_happy_money,
            OW.happy_money_type, OW.happy_money
            FROM owner_recruits ORC INNER JOIN owners OW ON ORC.owner_id = OW.id
                INNER JOIN mst_happy_moneys MHM ON ORC.happy_money_id = MHM.id
            
            WHERE ORC.display_flag = 1 AND OW.display_flag = 1 AND OW.id = ?
            
            LIMIT 1
        ";
        $query = $this->db->query($sql, array($owner_id));
        //return $query->result_array();
        if ($query->num_rows()) {
            return $query->row_array();
        }
        return 0;
    }

     /**
     * @author  [IVS] Nguyen Van Phong
     * @name 	
     * @todo 	Insert new owner_recruit
     * @use in: Company/do_edit_company_store
     * @param 	
     * @return 	
     */
    public function insertOwnerRecruit($data) {
        $this->db->update('owner_recruits', $data);
    }
    /**
     * @author  [IVS] Nguyen Van Phong
     * @name 	
     * @todo 	get owner_recruit_id of current owner
     * @param 	
     * @return 	
     */
    public function getCurrentOwnerRecruitId($owner_id = 0) {
        $sql = "SELECT ORC.id
            FROM owners OW INNER JOIN owner_recruits ORC ON OW.id = ORC.owner_id
            WHERE OW.display_flag = 1 AND ORC.display_flag = 1 AND OW.id = ?
            ORDER BY ORC.id DESC
            LIMIT 1                
                ";
        $query = $this->db->query($sql, array($owner_id));
        $result = $query->row_array();
        if(!$result) {
            return 0;
        }
        return $result['id'];
    }
    /**
     * @author  [IVS] Nguyen Van Phong
     * @name 	
     * @todo 	get owner_recruit-status of current owner
     * @param 	
     * @return 	
     */
    public function getLastOwnerRecruitStatus($owner_id = 0){
        $sql = "SELECT ORC.recruit_status AS status
            FROM owners OW INNER JOIN owner_recruits ORC ON OW.id = ORC.owner_id
            WHERE OW.display_flag = 1 AND ORC.display_flag = 1 AND OW.id = ?
            ORDER BY ORC.id DESC
            LIMIT 1                
                ";
        $query = $this->db->query($sql, array($owner_id));
        $result = $query->row_array();
        if(!$result) {
            return 0;
        }
        return $result['status'];
    }
}

?>

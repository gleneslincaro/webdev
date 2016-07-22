<?php

class Mmessage extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /**
     * @author  [IVS] Nguyen Van Phong
     * @name 	getOwnerDetail
     * @todo 	get owner information, used in message/message_approval
     * @param 	int $id
     * @return 	result_array()
     */
    public function getOwnerDetail($id) {
        $sql = "SELECT 
  OW.storename,
  ORC2.created_date 
FROM
  owners OW 
  INNER JOIN 
    (SELECT 
      ORC.owner_id,
      ORC.recruit_status,
      OW.owner_status,
      ORC.`created_date` 
    FROM
      owner_recruits ORC 
      INNER JOIN owners OW 
        ON ORC.owner_id = OW.id 
    WHERE ORC.display_flag = 1) ORC2 
    ON OW.id = ORC2.owner_id 
WHERE OW.id = ?
  AND OW.display_flag = 1 
  AND ORC2.recruit_status IN (1, 3) 
  AND ORC2.owner_status IN (1, 2) ";
        $query = $this->db->query($sql, array($id));

        return $query->result_array();
    }

    /**
     * @author  [IVS] Nguyen Van Phong
     * @name 	getOwnerRecruitDetail
     * @todo 	get owner and owner recruit information
     * @use in  message/message_approval_profile/edit
     * @param 	int $owner_id
     * @return 	result_array()
     */
    public function getOwnerRecruitDetail($owner_id) {
        $sql = "SELECT ORC.error_recruit_content, ORC.id AS orid, OW.storename, OW.pic, OW.id,
                    ORC.image1, ORC.image2, ORC.image3, ORC.image4, ORC.image5, ORC.image6,
                    ORC.company_info, ORC.nearest_station,ORC.working_style_note,
                    ORC.`recruit_status`          
                FROM owner_recruits ORC INNER JOIN owners OW ON ORC.owner_id = OW.id          
                WHERE ORC.owner_id = ? AND ORC.display_flag = 1 AND ORC.recruit_status = 3";
        
        $query = $this->db->query($sql, array($owner_id));
        return $query->row_array();
    }

    /**
     * @author  [IVS] Nguyen Van Phong
     * @name 	deletePicture
     * @todo 	erase link picture of list pictures
     * @param 	int $id, array $data
     * @return 	
     */
    public function updateOwnerRecruit($data, $id) {
        $this->db->where('id', $id);
        $this->db->update('owner_recruits', $data);
    }

    /* @author: [IVS] Nguyen Van Phong
     * @use in: 
     * @todo: Update owner
     */

    public function updateOwner($data, $id) {
        $this->db->where('id', $id);
        $this->db->update('owners', $data);
    }

    /* @author: [IVS] Nguyen Van Phong
     * @use in: 
     * @todo: List images url of owner recruit
     */

    public function listImageUrl($orid) {

        $this->db->select('image1, image2, image3, image4, image5, image6');
        $this->db->from('owner_recruits');
        $param = array(
            'id' => $orid,
            'display_flag' => 1,
        );
        $this->db->where($param);
        $query = $this->db->get();
        if ($query->num_rows()) {
            return $query->row_array();
        }
        return 0;
    }

    /* @author: [IVS] Nguyen Van Phong
     * @use in: 
     * @todo: Insert new owner recruit
     */

    public function insertOwnerRecruit($data) {
        $this->db->insert('owner_recruits', $data);
    }

    /* @author: [IVS] Nguyen Van Phong
     * @use in: 
     * @todo: Insert treatments of owner recruits
     */

    public function insertTreatmentsOwners($data) {
        $this->db->insert('treatments_owners', $data);
    }

    /* @author: [IVS] Nguyen Van Phong
     * @use in: 
     * @todo: insert jobtype of owner_recruits
     */

    public function insertJobTypeOwners($data) {
        $this->db->insert('job_type_owners', $data);
    }
    
     public function updateOwnerRecruit2($data, $id) {
        $this->db->where('owner_id', $id);
        $this->db->update('owner_recruits', $data);
    }
    
    public function deleteTreatmentsOwners($owner_recruit_id) {
    	$sql = "DELETE FROM treatments_owners WHERE owner_recruit_id = '$owner_recruit_id'";
    	$this->db->query($sql);
    }
    
    public function deleteJobTypeOwners($owner_recruit_id) {
    	$sql = "DELETE FROM job_type_owners WHERE owner_recruit_id = '$owner_recruit_id'";
    	$this->db->query($sql);
    }

}

?>

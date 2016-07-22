<?php

class Mjobexplanation extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    /** 
     * Get owner owner job explanation 
     * @param string $owner_id
     * @return array $ret
     */
    public function get_owner_job_explanation($owner_id) {
        $ret = array();
        $sql = "SELECT * FROM owner_job_explanation WHERE display_flag = 1 AND owner_id = ?";
        $query = $this->db->query($sql, array($owner_id));
        if ($query) {
            $ret = $query->row_array();
        }
        
        return $ret;
    }

    /**
     * Insert owner job explanation 
     *
     * @param   array data
     * @return  boolean
     */
    public function insert_owner_job_explanation($data){
        $this->db->insert('owner_job_explanation', $data);
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    /**
     * Update owner job explanation 
     *
     * @param   string owner id, array data 
     * @return  boolean
     */
    public function update_owner_job_explanation($id, $data) {
        $this->db->where('owner_id',$id);
        $this->db->update('owner_job_explanation',$data);
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    /** 
     * Get owner working days
     * @param string $owner_id
     * @return array $ret
     */
    public function get_owner_working_days ($owner_id)   
    {
        $ret = null;
        $sql = "SELECT oje.content, oje.youtube_embed, wdi.* FROM owner_job_explanation oje
                LEFT JOIN owner_working_day_info wdi ON oje.owner_id = wdi.owner_id
                WHERE oje.display_flag = 1 AND oje.owner_id = ? AND wdi.display_flag = 1";
        $query = $this->db->query($sql, array($owner_id));
        if ($query) {
            $ret = $query->result_array();
        }
        
        return $ret;
    }

    /**
     * Get owners working days info
     *
     * @param   string owner id
     * @return  boolean
     */
    public function get_working_days($id){
        $sql = "SELECT * FROM `owner_working_day_info` WHERE owner_id = ? AND display_flag = 1";
        $query = $this->db->query($sql, array($id));
        $ret = $query->result_array();
        return $ret;
    }

    /**
     * Insert owners working days info
     *
     * @param   array data
     * @return  boolean
     */
    public function insert_working_days($data){
        $this->db->insert('owner_working_day_info', $data);
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    /**
     * Delete owners working days info
     *
     * @param   string owner id
     * @return  boolean
     */
    public function delete_working_days($id){
        $this->db->where('owner_id', $id);
        $this->db->delete('owner_working_day_info'); 
        return ($this->db->affected_rows() != 1) ? false : true;
    }
}

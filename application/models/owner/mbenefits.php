<?php

class Mbenefits extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    /**
     * Get owners flow hiring
     *
     * @param   string owner id
     * @return  data
     */
    public function get_owner_benefits($id) {
        $sql = "SELECT * FROM `owner_benefits` WHERE owner_id = ? AND display_flag = 1";
        $query = $this->db->query($sql, array($id));
        $ret = $query->result_array();
        return $ret;
    }

    /**
     * Insert owners flow hiring
     *
     * @param   array data
     * @return  data
     */
    public function insert_owner_benefits($data){
        $this->db->insert('owner_benefits', $data);
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    /**
     * Delete owners flow hiring
     *
     * @param   array data
     * @return  boolean
     */
    public function delete_owner_benefits($id){
        $this->db->where('owner_id', $id);
        $this->db->delete('owner_benefits'); 
        return ($this->db->affected_rows() != 1) ? false : true;
    }
}

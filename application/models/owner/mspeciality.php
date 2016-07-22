<?php

class Mspeciality extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    /** 
     * Get owner speciality 
     * @param string $owner_id
     * @return array $ret
     */
    public function get_owner_speciality($owner_id) {
        $ret = array();
        $sql = "SELECT * FROM owner_speciality WHERE display_flag = 1 AND owner_id = ?";
        $query = $this->db->query($sql, array($owner_id));
        if ($query) {
            $ret = $query->row_array();
        }
        
        return $ret;
    }

    /**
     * Insert owner speciality 
     *
     * @param   array data
     * @return  boolean
     */
    public function insert_owner_speciality($data){
        $this->db->insert('owner_speciality', $data);
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    /**
     * Update owner speciality 
     *
     * @param   string owner id, array data 
     * @return  boolean
     */
    public function update_owner_speciality($id, $data) {
        $this->db->where('owner_id',$id);
        $this->db->update('owner_speciality',$data);
        return ($this->db->affected_rows() != 1) ? false : true;
    }
}

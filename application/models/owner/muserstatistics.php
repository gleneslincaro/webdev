<?php

class Muserstatistics extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    /**
     * Get owners flow hiring
     *
     * @param   string owner id
     * @return  data
     */
    public function get_user_statistics($id) {
        $sql = "SELECT * FROM `owner_user_statistics` WHERE owner_id = ? AND display_flag = 1 ORDER BY id";
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
    public function insert_user_statistics($data){
        $this->db->insert('owner_user_statistics', $data);
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    /**
     * Delete owners flow hiring
     *
     * @param   array data
     * @return  boolean
     */
    public function delete_user_statistics($id){
        $this->db->where('owner_id', $id);
        $this->db->delete('owner_user_statistics'); 
        return ($this->db->affected_rows() != 1) ? false : true;
    }
}

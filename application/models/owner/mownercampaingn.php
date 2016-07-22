<?php

class Mownercampaingn extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public function createNewOwnerCampaingn($data){
        $this->db->insert('owner_display_campaign', $data);
        return $this->db->insert_id();
    }

    public function getNewOwnerCampaingn($limit = 0){
    	$ret = null;
        $sql = 'SELECT * FROM owner_display_campaign WHERE display_flag = 1 ORDER BY id DESC';
        if ($limit != 0) {
        	$sql .= " LIMIT " . $limit;
        }
		$query =  $this->db->query($sql);
		if ($query) {
		   $ret = $query->result_array();
		}

		return $ret;
    }

    public function getNewOwnerCampaingnId($id){
    	$ret = null;
        $sql = 'SELECT * FROM owner_display_campaign WHERE id = ? AND display_flag = 1 ORDER BY id DESC';
        $query =  $this->db->query($sql, array($id));
		if ($query) {
		   $ret = $query->result_array();
		}

		return $ret;
        
    }

    public function editNewOwnerCampaingn($id, $data){
    	$this->db->where('id', $id);
        $this->db->update('owner_display_campaign', $data);
        return ($this->db->affected_rows() != 1) ? false : true;
    }
}

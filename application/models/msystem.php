<?php

class Msystem extends CI_Model{
        public function __construct(){
            parent::__construct();
            $this->load->database();
        }
        public function showID(){
            $sql = "select * from user";
            return $this->db->query($sql)->result_array();
            
        }
        public function countSearch(){
            $this->db->count_all("user");
        }
        public function edit($id){
            $this->db->select("*");
            $this->db->where("user_id",$id);
            return $this->db->get("user")->result_array();
            
            
        }
    }
?>

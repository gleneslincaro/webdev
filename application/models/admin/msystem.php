<?php
    class Msystem extends CI_Model{
        public function __construct() {
            parent::__construct();
        }
        public function getByLoginId($login_id){
            $sql = 'SELECT * FROM admin WHERE login_id = ? AND display_flag=1';
            $query = $this->db->query($sql,array($login_id));
            return $query->row_array();                
        }
        
    }
?>

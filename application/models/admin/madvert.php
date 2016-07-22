<?php
    class Madvert extends CI_Model{
        public function __construct() {
            parent::__construct();
        }

        public function set_big_category_data($id, $ar)
        {
            if($id > 0){
                $this->db->where('id', $id);
                $this->db->update('aruaru_bbs_big_categorys', $ar);
            } else {
                $this->db->where('id', 1);
                $this->db->update('aruaru_bbs_is_top', $ar);
            }
        }


    }
?>

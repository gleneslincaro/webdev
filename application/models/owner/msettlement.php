<?php

class Msettlement extends CommonQuery {

    function __construct() {
        parent::__construct();
    }

    /**
     * @author  [IVS] Phan Ngoc Minh Luan
     * @name 	getCardPointMasters
     * @todo 	get amount, point from table mst_point_masters for card
     * @param 
     * @return 	int
     */
    public function getCardPointMasters() {
        $this->db->select('amount, point');
        $this->db->from('mst_point_masters');
        $this->db->where('display_flag',1);
        $this->db->where('payment_method_id',1);
        $this->db->order_by('amount','asc');
        $query = $this->db->get();
        if($query->num_rows()) {
            return $query->result_array();
        }
        return 0;
    }
    
    /**
     * @author  [IVS] Nguyen Bao Trieu
     * @name 	getBankPointMasters
     * @todo 	get amount, point from table mst_point_masters for bank
     * @param 
     * @return 	int
     */
    public function getBankPointMasters() {
        $this->db->select('amount, point');
        $this->db->from('mst_point_masters');
        $this->db->where('display_flag',1);
        $this->db->where('payment_method_id',2);
        $this->db->order_by('amount','asc');
        $query = $this->db->get();
        if($query->num_rows()) {
            return $query->result_array();
        }
        return 0;
    }

    
}

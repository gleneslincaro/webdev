<?php

class Mprofile extends CommonQuery {

    function __construct() {
        parent::__construct();
    }

    /**
     * @author  [IVS] Phan Ngoc Minh Luan
     * @name 	getUserProfiles
     * @todo 	get data user profiles
     * @param 	 $user_id
     * @return 	int
     */

    public function getUserProfiles($user_id) {
        $this->db->select( 'u.unique_id,ur.user_id,, ma.name1 as age_name1, ma.name2 as age_name2,
                            mh.name1 as height_name1, mh.name2 as height_name2, mc.name as city_name');
        $this->db->from('user_recruits ur');
        $this->db->join('users u','u.id = ur.user_id');
        $this->db->join('mst_ages ma','ma.id = ur.age_id', 'left');
        $this->db->join('mst_height mh', 'mh.id = ur.height_id', 'left');
        $this->db->join('mst_cities mc', 'mc.id = city_id', 'left');
        $param = array(
            'ur.user_id'=>$user_id,
            'ur.display_flag'=>1
        );
        $this->db->where($param);
        $this->db->group_by('ur.user_id');
        $query = $this->db->get();
        if($query->num_rows()>0) {
            return $query->row_array();
        }
        return 0;
    }

    /**
     * @author  [IVS] Phan Ngoc Minh Luan
     * @name 	getJobTypeUsers
     * @todo 	get JobType Users
     * @param 	 $user_id
     * @return 	int
     */

    public function getJobTypeUsers($user_id) {
        $this->db->select('name');
        $this->db->from('mst_job_types mjt');
        $this->db->join('job_type_users jtu', 'jtu.job_type_id = mjt.id');
        $this->db->where(array('user_id'=>$user_id));
        $this->db->order_by('priority','asc');
        $query = $this->db->get();
        if($this->db->affected_rows()) {
            return $query->result_array() ;
        }
        return 0;
    }
}

<?php
    class Mstatistics extends CI_Model{
        public function __construct() {
            parent::__construct();
        }
        /**
	 * @author  [IVS] Nguyen Hoai Nam
	 * @name    showOwnerJob
	 * @todo
	 * @param
	 * @return
	*/
        public function showOwnerJob(){
           $this->db->select('mst_job_types.name, COUNT(job_type_owners.job_type_id) AS numbers');
           $this->db->from('job_type_owners');
           $this->db->join('mst_job_types', 'job_type_owners.job_type_id = mst_job_types.id');
           $this->db->join('owner_recruits', 'owner_recruits.id = job_type_owners.owner_recruit_id');
           $this->db->where('owner_recruits.recruit_status = 2 AND `owner_recruits`.`display_flag` = 1');
           $this->db->group_by('job_type_id');
           $this->db->order_by("numbers","DESC");
           return $this->db->get()->result_array();
        }
        /**
	 * @author  [IVS] Nguyen Hoai Nam
	 * @name    getList
	 * @todo
	 * @param
	 * @return
	*/
        public function getList($tbl){
           $query = $this->db->get($tbl);
           if($query->num_rows() > 0) {
               return $query->result_array();
           }
           else {
               return array();
           }
        }
        /**
	 * @author  [IVS] Nguyen Hoai Nam
	 * @name    showOwnerArea
	 * @todo
	 * @param
	 * @return
	*/
        public function showOwnerArea($val){
           $strQuery = "";
           if($val !=""){
                $strQuery = " AND mst_cities.city_group_id = ".$this->db->escape($val)." ";
           }
           $sql = "SELECT mst_cities.district, mst_cities.name, COUNT(owner_recruits.city_id) AS numbers
                    FROM owner_recruits
                    LEFT OUTER JOIN mst_cities ON owner_recruits.city_id = mst_cities.id
                    WHERE owner_recruits.display_flag = 1 AND owner_recruits.recruit_status = 2 ".$strQuery."
                    GROUP BY owner_recruits.city_id
                    ORDER BY numbers DESC ";
           return $this->db->query($sql)->result_array();
        }
        /**
	 * @author  [IVS] Nguyen Hoai Nam
	 * @name    showOwnerArea1
	 * @todo
	 * @param
	 * @return
	*/
        public function showOwnerArea1(){
           $this->db->select('mst_city_groups.name, COUNT(owner_recruits.city_id) AS numbers');
           $this->db->from('owner_recruits');
           $this->db->join('mst_cities', 'owner_recruits.city_id = mst_cities.id');
           $this->db->join('mst_city_groups', 'mst_cities.city_group_id =  mst_city_groups.id');
           $this->db->where('owner_recruits.recruit_status = 2 AND `owner_recruits`.`display_flag` = 1');
           $this->db->group_by('mst_city_groups.name');
           $this->db->order_by("numbers","DESC");
           return $this->db->get()->result_array();
        }
        /**
	 * @author  [IVS] Nguyen Hoai Nam
	 * @name    showOwnerTreatment
	 * @todo
	 * @param
	 * @return
	*/
        public function showOwnerTreatment(){
           $this->db->select('mst_treatments.name, COUNT(treatments_owners.treatment_id) AS numbers');
           $this->db->from('treatments_owners');
           $this->db->join('mst_treatments', 'treatments_owners.treatment_id = mst_treatments.id');
           $this->db->join('owner_recruits', 'owner_recruits.id = treatments_owners.owner_recruit_id');
           $this->db->where('owner_recruits.recruit_status = 2 AND `owner_recruits`.`display_flag` = 1');
           $this->db->group_by('treatments_owners.treatment_id');
           $this->db->order_by("numbers","DESC");
           return $this->db->get()->result_array();
        }
        /**
	 * @author  [IVS] Nguyen Hoai Nam
	 * @name    showUserJob
	 * @todo
	 * @param
	 * @return
	*/
        public function showUserJob(){
           $this->db->select('mst_job_types.name, COUNT(job_type_users.job_type_id) AS numbers');
           $this->db->from('job_type_users');
           $this->db->join('mst_job_types', 'job_type_users.job_type_id = mst_job_types.id');
           $this->db->group_by('job_type_users.job_type_id');
           $this->db->order_by("numbers","DESC");
           return $this->db->get()->result_array();
        }
         /**
	 * @author  [IVS] Nguyen Hoai Nam
	 * @name    showUserAge
	 * @todo
	 * @param
	 * @return
	*/
        public function showUserAge(){
           $this->db->select('mst_ages.name1 AS name1, mst_ages.name2 AS name2, COUNT(user_recruits.age_id) AS numbers');
           $this->db->from('user_recruits');
           $this->db->join('mst_ages', 'user_recruits.age_id = mst_ages.id', 'left');
           $this->db->group_by('user_recruits.age_id');
           $this->db->order_by("numbers","DESC");
           return $this->db->get()->result_array();
        }
        /**
	 * @author  [IVS] Nguyen Hoai Nam
	 * @name    showUserArea
	 * @todo
	 * @param
	 * @return
	*/
        public function showUserArea($val){
           $strQuery = "";
           if($val !=""){
                $strQuery = " AND mst_cities.city_group_id = ".$this->db->escape($val)." ";
           }
           $sql = "SELECT mst_cities.district, mst_cities.name, COUNT(user_recruits.city_id) AS numbers
                    FROM user_recruits
                    LEFT OUTER JOIN mst_cities ON user_recruits.city_id = mst_cities.id
                    WHERE user_recruits.display_flag = 1".$strQuery."
                    GROUP BY user_recruits.city_id
                    ORDER BY numbers DESC ";
           return $this->db->query($sql)->result_array();
        }
        /**
	 * @author  [IVS] Nguyen Hoai Nam
	 * @name    showUserArea1
	 * @todo
	 * @param
	 * @return
	*/
        public function showUserArea1(){
           $this->db->select('mst_city_groups.name, COUNT(user_recruits.city_id) AS numbers');
           $this->db->from('user_recruits');
           $this->db->join('mst_cities', 'user_recruits.city_id = mst_cities.id');
           $this->db->join('mst_city_groups', 'mst_cities.city_group_id = mst_city_groups.id');
           $this->db->group_by('mst_city_groups.name');
           $this->db->order_by("numbers","DESC");
           return $this->db->get()->result_array();
        }
    }
?>

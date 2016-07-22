<?php
class Msearch_store extends CI_Model{
    public function __construct() {
        parent::__construct();
    }

    public function get_new_store($limit =20)
    {
        $sql =  "SELECT ow.storename, ow.new_store_date, owr.id, mjt.name FROM owners ow
                LEFT JOIN owner_recruits owr ON ow.id = owr.owner_id AND owr.display_flag = 1
                LEFT jOIN job_type_owners jto ON owr.id = jto.owner_recruit_id
                LEFT jOIN mst_job_types mjt ON jto.job_type_id = mjt.id
                WHERE ow.public_info_flag = 1 AND ow.new_store_date != 'null'
                ORDER BY ow.new_store_date DESC
                LIMIT $limit";

        $query = $this->db->query($sql);
//echo $this->db->last_query();
        return $query->result_array();
    }


}
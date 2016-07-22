<?php

class Muser_experiences extends CI_Model {

    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

    /**
     * Insert data in user_experiences table
     *
     * @param data array to be inserted
     * @return  id inserted
     */
    public function insert_experiences_msg($data) {
        $this->db->insert('user_experiences', $data);
        return $this->db->insert_id();
    }

    /**
     * Get all data in user_experiences table
     *
     * @param data limit, offset for stating index
     * @return detail array
     */
    public function get_experiences_msg_all($limit = 0, $offset = 0,$from_admin_flag=false) {
        $cond = '';
        $where = '';
        $ret = array();
        if ($limit != 0) {
            $cond = "LIMIT " . $limit . " OFFSET " . $offset;
        }

        if($from_admin_flag == false) {
            $where = ' AND ue.status = 1 ';
        }
        
        $sql = "SELECT ue.id as msg_id, ue.title, ue.age_id, ue.status,ma.name1 as age_name1, ma.name2 as age_name2,
                        mc.name as city_name, ue.created_date, u.unique_id as unique_id, u.id as user_id,ue.content,
                        (CASE WHEN DATE_SUB(NOW(), INTERVAL 7 DAY) <= ue.created_date THEN 1 ELSE 0 END) AS new_status
                        FROM user_experiences AS ue 
                        LEFT JOIN users AS u ON ue.user_id = u.id
                        LEFT JOIN user_recruits AS ur ON u.id = ur.user_id
                        LEFT JOIN mst_ages AS ma ON ue.age_id = ma.id
                        LEFT JOIN mst_cities AS mc ON ue.city_id = mc.id
                WHERE ue.display_flag = 1 $where ORDER BY ue.created_date DESC, ue.id DESC " . $cond;
        $query = $this->db->query($sql);
        $ret = $query->result_array();
        return $ret;
    }

    /**
     * Get all data in user_experiences table
     *
     * @param data limit, offset for stating index
     * @return detail array
     */
    public function get_experiences_msg_count($from_admin_flag=false) {
        $cond = '';
        if($from_admin_flag == false) {
            $cond = " AND ue.status = 1 ";
        }

        $sql = "SELECT count(ue.id) AS count FROM user_experiences AS ue WHERE ue.display_flag = 1 ".$cond ;
        $query = $this->db->query($sql);
        $ret = $query->row_array();
        return $ret['count'];
    }

    /**
     * Get user_experiences data by id
     *
     * @param table id
     * @return detail array
     */
    public function get_experiences_msg_id($msg_id) {
        $ret = array();
        // Get msg detail
        $sql = "SELECT ue.*, ma.id as age_id,ma.name1 as age_name1, ma.name2 as age_name2, mc.name as city_name,mc.id as city_id, ue.created_date,
                        (CASE WHEN DATE_SUB(NOW(), INTERVAL 7 DAY) <= ue.created_date THEN 1 ELSE 0 END) AS new_status
                        FROM user_experiences AS ue
                        LEFT JOIN users AS u ON ue.user_id = u.id
                        LEFT JOIN user_recruits AS ur ON u.id = ur.user_id
                        LEFT JOIN mst_ages AS ma ON ue.age_id = ma.id
                        LEFT JOIN mst_cities AS mc ON ue.city_id = mc.id
                WHERE ue.id = ? AND ue.status = 1 AND ue.display_flag = 1";
        $query = $this->db->query($sql, array($msg_id));
        $resp = $query->row_array();

        if($resp) {
            // Get pagination left id
            $sql = "SELECT ue.id AS left_id FROM user_experiences AS ue WHERE ue.id > ? AND ue.display_flag = 1 AND ue.status = 1 ORDER BY created_date ASC limit 1";
            $query = $this->db->query($sql, array($resp['id']));
            $left = $query->row_array();

            // Get pagination right id
            $sql = "SELECT ue.id AS right_id FROM user_experiences AS ue WHERE ue.id < ? AND ue.display_flag = 1 AND ue.status = 1 ORDER BY created_date DESC limit 1";
            $query = $this->db->query($sql, array($resp['id']));
            $right = $query->row_array();

            $ret = array_merge($resp, $left);
            $ret = array_merge($ret, $right);
        }
        
        return $ret;
    }

    /**
     * modify the user_experience
     *
     * @param int $id , array $data
     * @return detail array
     */

    public function modify_experience($id,$data) {
        $this->db->where('id',$id);
        $this->db->update('user_experiences',$data);
        if($this->db->affected_rows() > 0) {
            return true;
        }
        return false;
    }

    /**
     * update the show status of experience
     *
     * @param  array $data
     * @return detail array
     */
    public function update_show_status($data) {
        $this->db->where('id',$data['id']);
        $this->db->update('user_experiences',array('status'=>$data['status']));
        if($this->db->affected_rows() > 0) {
            return 1;
        }
        return 0;
    }

    public function delete_experience($id){
        $this->db->where('id',$id);
        $this->db->update('user_experiences',array('display_flag'=>0));
        if($this->db->affected_rows() > 0) {
            return 1;
        }
        return 0;
    }

}

?>

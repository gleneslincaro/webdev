<?php
class mcity extends CI_Model{
    function __construct() {
        parent::__construct();
    }
    /*
    * @author:IVS_Nguyen_Ngoc_Phuong
    * get all group city
    */
    public function getCityGroup(){
        $sql= "select * from mst_city_groups";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    /*
    * @author:IVS_Nguyen_Ngoc_Phuong
    * get city in group city
    * @param city_group_id
    */
    public function getCity($id){
        $sql="select * from mst_cities where city_group_id = ?";
        $query = $this->db->query($sql,array($id));
        return $query->result_array();
    }
    public function getTown($id){
        $sql="select * from mst_towns where city_id = ?";
        $query = $this->db->query($sql,array($id));
        return $query->result_array();
    }

    /**
     * Get all city group 
     * @param none
     * @return return data array
     */
    public function get_all_citygroup(){
        $sql= "select * from mst_city_groups";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    /**
     * Get all city 
     * @param none
     * @return return data array
     */
    public function get_all_city(){
        $sql="select * from mst_cities";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    /**
     * Get all city 
     * @param none
     * @return return data array
     */
    public function get_all_town(){
        $sql="select * from mst_towns";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    /*
    * @author:Kiyoshi Suzuki
    * get all group city select id, name, alph_name
    */
    public function getCityGroupIds()
    {
        $sql= "SELECT id, name, alph_name FROM mst_city_groups";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    /*
    * @author:Kiyoshi Suzuki
    * get city in group city select id, name, alph_name
    * @param city_group_id
    */
    public function getCityIds($id)
    {
        $sql="SELECT id, name, alph_name FROM mst_cities WHERE city_group_id = ?";
        $query = $this->db->query($sql, array($id));
        return $query->result_array();
    }
    /*
    * @author:Kiyoshi Suzuki
    * get town in city select id, name, alph_name
    * @param city_group_id
    */
    public function getTownIds($id){
        $sql="SELECT id, name, alph_name FROM mst_towns WHERE city_id = ?";
        $query = $this->db->query($sql,array($id));
        return $query->result_array();
    }

    public function getTownUserCount($id,$owner_status=2){
        $sql = "SELECT dttown.* ,COUNT(dttown.owner_id) AS ocount, GROUP_CONCAT(dttown.owner_id ORDER BY dttown.owner_id ASC) AS owner_id FROM
                (SELECT DISTINCT owr.owner_id, mt.id , mt.name, mt.alph_name, owr.display_flag, ow.display_flag AS owflag
                FROM `owner_recruits` AS owr
                LEFT JOIN `owner_category` AS owc ON owr.id = owc.owner_id
                LEFT JOIN `owners` AS ow ON owr.owner_id = ow.id
                INNER JOIN `mst_towns` AS mt ON mt.display_flag = 1 
                WHERE mt.city_id = ? AND mt.display_flag = 1 AND ow.public_info_flag = 1 AND ow.display_flag = 1 AND (mt.id = owc.category_id OR mt.id = owr.town_id)
                    AND ow.owner_status IN (".$owner_status.")
                ) AS dttown
                WHERE dttown.display_flag = 1 && dttown.owflag = 1
                GROUP BY dttown.id  ORDER BY dttown.id ASC";
        $query = $this->db->query($sql, array($id));
        return $query->result_array();
    }

    public function getTownUserCountIds($id,$owner_status=2){
        $sql = "SELECT dttown.* ,COUNT(dttown.owner_id) AS ocount";
        $sql .= " FROM (SELECT DISTINCT owr.owner_id, mt.id , mt.name, mt.alph_name, owr.display_flag, ow.display_flag AS owflag
                FROM `owner_recruits` AS owr
                LEFT JOIN `owner_category` AS owc ON owr.id = owc.owner_id
                LEFT JOIN `owners` AS ow ON owr.owner_id = ow.id
                INNER JOIN `mst_towns` AS mt ON mt.display_flag = 1 
                WHERE mt.city_id = ? AND mt.display_flag = 1 AND ow.public_info_flag = 1 AND ow.display_flag = 1 AND (mt.id = owc.category_id OR mt.id = owr.town_id)
                    AND ow.owner_status IN (".$owner_status.")
                ) AS dttown
                WHERE dttown.display_flag = 1 && dttown.owflag = 1
                GROUP BY dttown.id  ORDER BY dttown.id ASC";
        $query = $this->db->query($sql,array($id));
        return $query->result_array();
    }

    public function getCityOwnerCount($id){
        $this->db->select('id, name, alph_name, owners_count');
        $this->db->from('mst_cities');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function getTownOwnerCount($id){
        $this->db->select('id, name, alph_name, owners_count');
        $this->db->from('mst_towns');
        $this->db->where('city_id', $id);

        $query = $this->db->get();
        return $query->result_array();
    }

    public function updateCityOwnerCount($id, $count){

            $data = array(
                           'owners_count' => $count
                        );
            $this->db->where('id', $id);
            $this->db->update('mst_cities', $data);
    }

    public function updateTownOwnerCount($ar){

            $data = array(
                           'owners_count' => $ar['ocount']
                        );
            $this->db->where('id', $ar['id']);
            $this->db->update('mst_towns', $data);
    }


    public function getTownUserCheck($id,$owner_status=2){

        $this->db->select('*');
        $this->db->from('owner_recruits AS owr');
        $this->db->join('owner_category AS owc', 'owr.id = owc.owner_id', 'LEFT');
        $this->db->join('owners AS ow', 'owr.owner_id = ow.id', 'LEFT');
        $this->db->join('mst_towns AS mt', 'mt.id = owr.town_id', 'INNER');
//        $this->db->where('mt.city_id', $id);
        $this->db->where('owr.town_id', $id);
        $this->db->where('mt.display_flag', 1);
        $this->db->where('ow.public_info_flag', 1);
        $this->db->where('ow.display_flag', 1);
        $this->db->where('(mt.id = owc.category_id OR mt.id = owr.town_id)');

        $this->db->where('ow.owner_status IN ("'.$owner_status.'")');

        $query = $this->db->get();

//echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            return $query->num_rows();
        }

        return false;

/*
        $sql = "SELECT dttown.* ,COUNT(dttown.owner_id) AS ocount, GROUP_CONCAT(dttown.owner_id ORDER BY dttown.owner_id ASC) AS owner_id FROM
                (SELECT DISTINCT owr.owner_id, mt.id , mt.name, mt.alph_name, owr.display_flag, ow.display_flag AS owflag
                FROM `owner_recruits` AS owr
                LEFT JOIN `owner_category` AS owc ON owr.id = owc.owner_id
                LEFT JOIN `owners` AS ow ON owr.owner_id = ow.id
                INNER JOIN `mst_towns` AS mt ON mt.display_flag = 1 
                WHERE mt.city_id = ? AND mt.display_flag = 1 AND ow.public_info_flag = 1 AND ow.display_flag = 1 AND (mt.id = owc.category_id OR mt.id = owr.town_id)
                    AND ow.owner_status IN (".$owner_status.")
                ) AS dttown
                WHERE dttown.display_flag = 1 && dttown.owflag = 1
                GROUP BY dttown.id  ORDER BY dttown.id ASC";
        $query = $this->db->query($sql,array($id));
        return $query->result_array();*/
    }



    /*
    * @author: IVS_Nguyen_Ngoc_Phuong
    * get city_group_name by id
    * @param city_group_id
    */
    public function getCityGroupName($id){
        $sql="SELECT * FROM mst_city_groups WHERE id = ?";
        $query = $this->db->query($sql,array($id));
        return $query->row_array();
    }

    public function getCityByAlphaName($name){
        $sql="SELECT id, name, alph_name, district FROM mst_cities WHERE alph_name = ?";
        $query = $this->db->query($sql,array($name));
        return $query->row_array();
    }

    public function getGroupCityByAlphaName($name){
        $sql="SELECT id, name, alph_name FROM mst_city_groups WHERE alph_name = ?";
        $query = $this->db->query($sql,array($name));
        return $query->row_array();
    }

    public function getTownByCityId($id){
        $sql="SELECT city_id FROM mst_towns WHERE city_id = ?";
        $query = $this->db->query($sql,array($id));
        return $query->row_array();
    }

    public function getTownByAlphaName($name){
        $sql="SELECT id, name, alph_name, contents FROM mst_towns WHERE alph_name = ?";
        $query = $this->db->query($sql,array($name));
        return $query->row_array();
    }

    public function getTownByAlphaNameR($name){
        $sql="SELECT id, name, alph_name, city_id FROM mst_towns WHERE alph_name = ?";
        $query = $this->db->query($sql, array($name));
        return $query->row_array();
    }

    public function getCityGroupById($id){
        $sql="SELECT id, name, alph_name, contents FROM mst_city_groups WHERE id = ?";
        $query = $this->db->query($sql,array($id));
        return $query->row_array();
    }

    public function getCityById($id){
        $sql="SELECT id, name, alph_name, contents FROM mst_cities WHERE id = ?";
        $query = $this->db->query($sql,array($id));
        return $query->row_array();
    }

    public function getTownById($id){
        $sql="SELECT id, name, alph_name, contents FROM mst_towns WHERE id = ?";
        $query = $this->db->query($sql,array($id));
        return $query->row_array();
    }

    /** get all jobs belonging to a town
    *
    * @param $town_id
    * @return an array of jobs(job_id, job_name)
    */
    public function getAllJobInTown($town_id) {
        $ret = array();
        if (!$town_id) {
            return $ret;
        }
        $sql =  "SELECT DISTINCT  mjt.id AS job_id, mjt.name as job_name, mjt.alph_name as job_alp_name ";
        $sql .= "FROM job_type_owners jto ";
        $sql .= "INNER JOIN mst_job_types mjt ON (mjt.id = jto.job_type_id AND mjt.display_flag = 1 and mjt.alph_name is not null)";
        $sql .= "INNER JOIN owner_recruits owr ON (owr.id = jto.owner_recruit_id AND owr.display_flag = 1) ";
        $sql .= "WHERE owr.town_id = ?";

        $result = $this->db->query($sql, $town_id);
        if ($result && $data = $result->result_array()) {
            $ret = $data;
        }
        return $ret;
    }
}
?>

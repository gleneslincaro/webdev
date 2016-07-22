<?php
class Msearch_contents extends CI_Model
{
    public function __construct()
    {
        parent::__construct();

    }
    
    public function getJobtypeContents($mst_job_type_id)
    {
        $sql="SELECT id,name,contents,contents2,contents3,contents4,income FROM mst_job_types where id = ?";
        $query = $this->db->query($sql, array($mst_job_type_id));
        return $query->row_array();
    }

    public function updateJobtypeContents($Jobtype_id, $income, $text, $text2, $text3,$text4)
    {
        $data = array(
           'income' => $income,
           'contents' => $text,
           'contents2' => $text2,
           'contents3' => $text3,
           'contents4' => $text4
        );
        $this->db->where('id', $Jobtype_id);
        $this->db->update('mst_job_types', $data);
    }

    public function getTreatmentContents($treatment_id)
    {
        $sql="SELECT id,name,contents,contents2,contents3 FROM mst_treatments where id = ?";
        $query = $this->db->query($sql, array($treatment_id));
        return $query->row_array();
    }

    public function updateTreatmentContents($treatments_id, $text, $text2, $text3)
    {
        $data = array(
           'contents' => $text,
           'contents2' => $text2,
           'contents3' => $text3
        );
        $this->db->where('id', $treatments_id);
        $this->db->update('mst_treatments', $data);
    }

    public function updateCityGroupContents($id, $text)
    {
        $today = new DateTime();//本日
        $data = array(
           'contents' => $text,
           'updated_date' => ($today->format('Y-m-d H:i:s'))
        );
        $this->db->where('id', $id);
        $this->db->update('mst_city_groups', $data);
    }
    
    public function updateCityContents($id, $text)
    {
        $today = new DateTime();//本日
        $data = array(
           'contents' => $text,
           'updated_date' => ($today->format('Y-m-d H:i:s'))
        );
        $this->db->where('id', $id);
        $this->db->update('mst_cities', $data);
    }
    
    public function updateTownContents($town_id, $text)
    {
        $today = new DateTime();//本日
        $data = array(
           'contents' => $text,
           'updated_date' => ($today->format('Y-m-d H:i:s'))
        );
        $this->db->where('id', $town_id);
        $this->db->update('mst_towns', $data);
    }

    public function getCityGroupContents($id)
    {
        $sql="SELECT id,contents FROM mst_city_groups where id = ?";
        $query = $this->db->query($sql, array($id));
        return $query->row_array();
    }
    
    public function getCityContents($id)
    {
        $sql="SELECT id,contents FROM mst_cities where id = ?";
        $query = $this->db->query($sql, array($id));
        return $query->row_array();
    }

    public function getTownContents($town_id)
    {
        $sql="SELECT id,contents FROM mst_towns where id = ?";
        $query = $this->db->query($sql, array($town_id));
        return $query->row_array();
    }

    public function getCityGroup()
    {
        $sql= "select * from mst_city_groups";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function getCity($id)
    {
        $sql="select * from mst_cities where city_group_id = ?";
        $query = $this->db->query($sql, array($id));
        return $query->result_array();
    }

    public function getGroupCityByAlphaName($name)
    {
        $sql="SELECT id, name, alph_name FROM mst_city_groups WHERE alph_name = ?";
        $query = $this->db->query($sql, array($name));
        return $query->row_array();
    }

}
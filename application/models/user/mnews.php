<?php
class Mnews extends CI_Model{
      
    function __construct() {
        parent::__construct();
    }
    /*
     * @author: IVS_Nguyen_Ngoc_Phuong
     * get 5 record 
     * @param $limit
     */
    public function getNews($limit, $offset){
        $sql="SELECT `id`,`title`,`content`,DATE_FORMAT(created_date,'%Y/%m/%d %H:%i')AS created_date FROM mst_news WHERE display_flag=1 AND `member_type` = 0
            ORDER BY created_date DESC  LIMIT ? OFFSET ?";
        $query= $this->db->query($sql,array($limit, $offset));
        return $query->result_array();
    }
    /*
     * @author: IVS_Nguyen_Ngoc_Phuong
     * get 5 record 
     */
    public function getAllNews(){
        $sql="SELECT * FROM mst_news WHERE display_flag=1 AND `member_type` = 0
            ORDER BY created_date DESC";
        $query= $this->db->query($sql);
        return $query->result_array();
    }
    
    public function getSpecificNews($id) {
        $sql = "SELECT `title`,`content`,DATE_FORMAT(created_date,'%Y/%m/%d %H:%i')AS created_date FROM mst_news WHERE id = ? AND display_flag = 1";
        return $this->db->query($sql, array($id))->row_array();
    }
    
}
?>

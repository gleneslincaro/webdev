<?php
    class Mnews extends CI_Model{
        public function __construct() {
            parent::__construct();
        }
    
         /**
	 * @author  [IVS] Nguyen Minh Ngoc
	 * @name 	insertPoint
	 * @todo 	insert record in mst_point_masters
	 * @param 	$method,$amount,$point
	 * @return 	
	*/
        public function insertNew($content,$title,$newType,$date){
            $data=array(
                "title"=>$title,
                "content"=>$content,
                "member_type"=>$newType,
                "created_date"=>$date,
            );
            $this->db->insert("mst_news",$data);
        }
        
                /**
        * @author  [IVS] Ho Quoc Huy
        * @name 	getSearchShopNameQuery
        * @todo 	get Search_Shop_Name_Query
        * @param 	$emailAddress,$storeName,$note,$lastLoginFrom,$lastLoginTo,$styleShopClub
        * @return 	string sql
        */  
        public function getSearchNewsQueryForUser(){
            return $sql = "SELECT * FROM mst_news WHERE display_flag='1' AND member_type ='0'";
        }
                /**
        * @author  [IVS] Ho Quoc Huy
        * @name 	getSearchShopNameQuery
        * @todo 	get Search_Shop_Name_Query
        * @param 	$emailAddress,$storeName,$note,$lastLoginFrom,$lastLoginTo,$styleShopClub
        * @return 	string sql
        */  
        public function getSearchNewsQueryForOwner(){
            return $sql = "SELECT * FROM mst_news WHERE display_flag='1' AND member_type ='1'";
        }
        /**
        * @author  [IVS] Ho Quoc Huy
        * @name 	searchDataToShow
        * @todo 	search Data To Show (paging)
        * @param 	$sql,$limit,$offset
        * @return 	data_result
        */  
        public function searchDataToShow($sql,$limit,$offset){
            $sql = $sql."ORDER BY created_date DESC LIMIT ".$limit." OFFSET ".$offset."";
            return $this->db->query($sql)->result_array();
        }

        /**
        * @author  [IVS] Ho Quoc Huy
        * @name 	getDataByQuery
        * @todo 	get total data by query
        * @param 	$sql
        * @return 	data_result
        */  
        public function getDataByQuery($sql){
            return $this->db->query($sql)->result_array();
        }

        /**
        * @author  [IVS] Ho Quoc Huy
        * @name 	count Data By Query
        * @todo 	get total rows (paging)
        * @param 	$sql
        * @return 	data_result
        */  
        public function countDataByQuery($sql){
            return $this->db->query($sql)->num_rows();
        }
           /**
        * @author  [IVS] Ho Quoc Huy
        * @name 	getSearchShopNameQuery
        * @todo 	get Search_Shop_Name_Query
        * @param 	$emailAddress,$storeName,$note,$lastLoginFrom,$lastLoginTo,$styleShopClub
        * @return 	string sql
        */  
        public function getNewByID($id){
            $sql = "SELECT * FROM mst_news WHERE display_flag='1' AND id='".$this->db->escape_str($id)."'";
             return $this->db->query($sql)->row_array();
        }
        
         public function updateNew($content,$title,$txtId,$date){
          $data=array(
           "title"=>$title,
           "content"=>$content,
            "created_date"=>$date
        ); 
        $where=array(
           "id"=>$txtId
        );
           $this->db->where($where);
           $this->db->update("mst_news",$data);
        }
        
        public function deactiveNew($txtId){
          $data=array(
           "display_flag"=>0
        ); 
        $where=array(
           "id"=>$txtId
        );
           $this->db->where($where);
           $this->db->update("mst_news",$data);
        }
    }
?>

<?php
    class Mmaillan extends CI_Model{
        public function __construct() {
            parent::__construct();
        }
     
     /**
        * @author  [IVS] Ho Quoc Huy
        * @name 	getTemplateByType
        * @todo 	get Template By Type
        * @param 	$templateType
        * @return 	row_array
        */   
     public function getTemplateByType($templateType){
            
         $sql = "SELECT * FROM mst_templates WHERE display_flag='1' AND template_type ='".$this->db->escape_str($templateType)."'";
         return $this->db->query($sql)->row_array();
        }
        
     /**
        * @author  [IVS] Ho Quoc Huy
        * @name 	updateTemplateContent
        * @todo 	update Template by ID 
        * @param 	$templateID,$title,$context
        * @return 	
        */ 
        public function updateTemplateByType($templateType,$title,$content,$mail){
         
        $sql = "UPDATE mst_templates SET title='".$this->db->escape_str($title)."',content='".$this->db->escape_str($content)."',mail_from='".$this->db->escape_str($mail)."' WHERE template_type='".$this->db->escape_str($templateType)."' AND display_flag='1'";
        $this->db->query($sql);
        }
    
        
    }
?>

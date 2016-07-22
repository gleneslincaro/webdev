<?php
    class Statistics extends MX_Controller{
        protected $_data;
        public function __construct() {
            parent::__construct();
            AdminControl::CheckLogin();
            $this->_data["module"] = $this->router->fetch_module();
            $this->output->set_header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
            $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate");
            $this->output->set_header("Cache-Control: post-check=0, pre-check=0");
            $this->output->set_header("Pragma: no-cache");
        }
        /**
	 * @author  [IVS] Nguyen Hoai Nam
	 * @name 	showOwnerJob
	 * @todo 	load page
	 * @param 	 
	 * @return 	
	*/
        public function showOwnerJob(){
            $this->_data["loadPage"]="statistics/owner_job";
            $this->_data["titlePage"]="統計・職種";
            $this->load->view($this->_data["module"]."/layout/layout",$this->_data);
        }
        /**
	 * @author  [IVS] Nguyen Hoai Nam
	 * @name 	showOwnerJobAfter
	 * @todo 	show data
	 * @param 	 
	 * @return 	
	*/
        public function showOwnerJobAfter(){
            $this->load->Model("admin/Mstatistics");
            $data = $this->Mstatistics->showOwnerJob();
            $sum = 0;
            foreach ($data as $c) {
                $sum = $sum + $c['numbers'];          
            }
            $jobList = array();
            if($sum > 0){
                foreach ($data as $i=>$t) 
                {
                    $jobList[$i] = array (
                            'name'=> $t["name"],
                            'numbers'=> $t['numbers'],
                            'rate'=> sprintf('%0.1f',($t['numbers']/$sum)*100)
                    );
                }
            }
            $this->_data["jobList"]=$jobList;
            $this->_data["count"]=$sum;
            $this->_data["loadPage"]="statistics/owner_job_after";
            $this->_data["titlePage"]="統計・職種";
            $this->load->view($this->_data["module"]."/layout/layout",$this->_data);
        }
        /**
	 * @author  [IVS] Nguyen Hoai Nam
	 * @name 	showOwnerArea
	 * @todo 	load page
	 * @param 	 
	 * @return 	
	*/
        public function showOwnerArea(){
            $this->load->Model("admin/Mstatistics");
            $this->_data["cityGroupList"]=$this->Mstatistics->getList($tbl='mst_city_groups');
            $this->_data["loadPage"]="statistics/owner_area";
            $this->_data["titlePage"]="統計・地域47都道府県";
            $this->load->view($this->_data["module"]."/layout/layout",$this->_data);
        }
        /**
	 * @author  [IVS] Nguyen Hoai Nam
	 * @name 	showOwnerAreaAfter
	 * @todo 	show data
	 * @param 	
	 * @return 	
	*/
        public function showOwnerAreaAfter(){
            $val = null;
            if(isset($_POST["selectList"])){
                $val = $_POST["selectList"];
            }
            $this->load->Model("admin/Mstatistics");
            $data = $this->Mstatistics->showOwnerArea($val);
            $sum = 0;
            foreach ($data as $c) {
                $sum = $sum + $c['numbers'];       
                
            }
            $cityList = array();
            if($sum > 0){
                foreach ($data as $i=>$t) 
                {                    
                    $cityList[$i] = array (
                            'name'=> $t["name"].$t['district'],
                            'numbers'=> $t['numbers'],
                            'rate'=> sprintf('%0.1f',($t['numbers']/$sum)*100)
                    );
                }
            }
            $this->_data["cityGroupList"]=$this->Mstatistics->getList($tbl='mst_city_groups');
            $this->_data["cityList"]=$cityList;
            $this->_data["count"]=$sum;
            $this->_data["index"]=1;
            $this->_data["selectedItem"]=$val;
            $this->_data["loadPage"]="statistics/owner_area_after";
            $this->_data["titlePage"]="統計・地域47都道府県";
            $this->load->view($this->_data["module"]."/layout/layout",$this->_data);
        }
        /**
	 * @author  [IVS] Nguyen Hoai Nam
	 * @name 	showOwnerArea01
	 * @todo 	load page
	 * @param 	 
	 * @return 	
	*/
        public function showOwnerArea01(){
            $this->_data["loadPage"]="statistics/owner_area01";
            $this->_data["titlePage"]="統計・地域分布";
            $this->load->view($this->_data["module"]."/layout/layout",$this->_data);
        }
        /**
	 * @author  [IVS] Nguyen Hoai Nam
	 * @name 	showOwnerArea01After
	 * @todo 	show data
	 * @param 	 
	 * @return 	
	*/
        public function showOwnerArea01After(){
            $this->load->Model("admin/Mstatistics");
            $data = $this->Mstatistics->showOwnerArea1();
            $sum = 0;
            foreach ($data as $c) {
                $sum = $sum + $c['numbers'];          
            }
            $cityGroupList = array();
            if($sum > 0){
                foreach ($data as $i=>$t) 
                {
                    $cityGroupList[$i] = array (
                            'name'=> $t["name"],
                            'numbers'=> $t['numbers'],
                            'rate'=> sprintf('%0.1f',($t['numbers']/$sum)*100)
                    );
                }
            }   
            $this->_data["cityGroupList"]=$cityGroupList;
            $this->_data["count"]=$sum;
            $this->_data["index"]=1;
            $this->_data["loadPage"]="statistics/owner_area01_after";
            $this->_data["titlePage"]="統計・地域分布";
            $this->load->view($this->_data["module"]."/layout/layout",$this->_data);
        }
        /**
	 * @author  [IVS] Nguyen Hoai Nam
	 * @name 	showOwnerTreatment
	 * @todo 	laod page
	 * @param 	 
	 * @return 	
	*/
        public function showOwnerTreatment(){
            $this->_data["loadPage"]="statistics/owner_treatment";
            $this->_data["titlePage"]="統計・待遇";
            $this->load->view($this->_data["module"]."/layout/layout",$this->_data);
        }
        /**
	 * @author  [IVS] Nguyen Hoai Nam
	 * @name 	showOwnerTreatmentAfter
	 * @todo 	show data
	 * @param 	 
	 * @return 	
	*/
        public function showOwnerTreatmentAfter(){
            $this->load->Model("admin/Mstatistics");
            $data = $this->Mstatistics->showOwnerTreatment();
            $sum = 0;
            foreach ($data as $c) {
                $sum = $sum + $c['numbers'];          
            }
            $treatmentList = array();
            if($sum > 0){
                foreach ($data as $i=>$t) 
                {
                    $treatmentList[$i] = array (
                            'name'=> $t["name"],
                            'numbers'=> $t['numbers'],
                            'rate'=> sprintf('%0.1f',($t['numbers']/$sum)*100)
                    );
                }
            }
            $this->_data["treatmentList"]=$treatmentList;
            $this->_data["count"]=$sum;
            $this->_data["index"]=1;
            $this->_data["loadPage"]="statistics/owner_treatment_after";
            $this->_data["titlePage"]="統計・待遇";
            $this->load->view($this->_data["module"]."/layout/layout",$this->_data);
        }
        /**
	 * @author  [IVS] Nguyen Hoai Nam
	 * @name 	showUserJob
	 * @todo 	load page
	 * @param 	 
	 * @return 	
	*/
        public function showUserJob(){
            $this->_data["loadPage"]="statistics/user_job";
            $this->_data["titlePage"]="統計・職種";
            $this->load->view($this->_data["module"]."/layout/layout",$this->_data);
        }
        /**
	 * @author  [IVS] Nguyen Hoai Nam
	 * @name 	showUserJobAfter
	 * @todo 	show data
	 * @param 	 
	 * @return 	
	*/
        public function showUserJobAfter(){
            $this->load->Model("admin/Mstatistics");
            $data = $this->Mstatistics->showUserJob();
            $sum = 0;
            foreach ($data as $c) {
                $sum = $sum + $c['numbers'];          
            }
            $userJobList = array();
            if($sum > 0){
                foreach ($data as $i=>$t) 
                {
                    $userJobList[$i] = array (
                            'name'=> $t["name"],
                            'numbers'=> $t['numbers'],
                            'rate'=> sprintf('%0.1f',($t['numbers']/$sum)*100)
                    );
                }
            }   
            $this->_data["userJobList"]=$userJobList;
            $this->_data["count"]=$sum;
            $this->_data["loadPage"]="statistics/user_job_after";
            $this->_data["titlePage"]="統計・職種";
            $this->load->view($this->_data["module"]."/layout/layout",$this->_data);
        }
        /**
	 * @author  [IVS] Nguyen Hoai Nam
	 * @name 	showUserAge
	 * @todo 	load page
	 * @param 	 
	 * @return 	
	*/
        public function showUserAge(){
            $this->_data["loadPage"]="statistics/user_age";
            $this->_data["titlePage"]="統計・年齢";
            $this->load->view($this->_data["module"]."/layout/layout",$this->_data);
        }
        /**
	 * @author  [IVS] Nguyen Hoai Nam
	 * @name 	showUserAgeAfter
	 * @todo 	show data
	 * @param 	 
	 * @return 	
	*/
        public function showUserAgeAfter(){
            $this->load->Model("admin/Mstatistics");
            $data = $this->Mstatistics->showUserAge();
            $sum = 0;
            foreach ($data as $c) {
                $sum = $sum + $c['numbers'];          
            }
            $ageList = array();
            if($sum > 0){
                foreach ($data as $i=>$t) 
                {
                    $ageList[$i] = array (
                            'name1'=> $t["name1"],
                            'name2'=> $t["name2"],
                            'numbers'=> $t['numbers'],
                            'rate'=> sprintf('%0.1f',($t['numbers']/$sum)*100)
                    );
                }
            }
            $this->_data["ageList"]=$ageList;
            $this->_data["count"]=$sum;
            $this->_data["index"]=1;
            $this->_data["loadPage"]="statistics/user_age_after";
            $this->_data["titlePage"]="統計・年齢";
            $this->load->view($this->_data["module"]."/layout/layout",$this->_data);
        }
        /**
	 * @author  [IVS] Nguyen Hoai Nam
	 * @name 	showUserArea
	 * @todo 	load page
	 * @param 	 
	 * @return 	
	*/
        public function showUserArea(){
            $this->load->Model("admin/Mstatistics");
            $this->_data["cityGroupList"]=$this->Mstatistics->getList($tbl='mst_city_groups');
            $this->_data["loadPage"]="statistics/user_area";
            $this->_data["titlePage"]="統計・地域47都道府県";
            $this->load->view($this->_data["module"]."/layout/layout",$this->_data);
        }
        /**
	 * @author  [IVS] Nguyen Hoai Nam
	 * @name 	showUserAreaAfter
	 * @todo 	show data
	 * @param 	 
	 * @return 	
	*/
        public function showUserAreaAfter(){
            $val = null;
            if(isset($_POST["selectList"])){
                $val = $_POST["selectList"];
            }
            $this->load->Model("admin/Mstatistics");
            $data = $this->Mstatistics->showUserArea($val);
            $sum = 0;
            foreach ($data as $c) {
                $sum = $sum + $c['numbers'];          
            }
            $cityList = array();
            if($sum > 0){
                foreach ($data as $i=>$t) 
                {   
                    $cityList[$i] = array (
                            'name'=> $t["name"].$t['district'],
                            'numbers'=> $t['numbers'],
                            'rate'=> sprintf('%0.1f',($t['numbers']/$sum)*100)
                    );
                }
            }
            $this->_data["cityGroupList"]=$this->Mstatistics->getList($tbl='mst_city_groups');
            $this->_data["cityList"]=$cityList;
            $this->_data["count"]=$sum;
            $this->_data["index"]=1;
            $this->_data["selectedItem"]=$val;
            $this->_data["loadPage"]="statistics/user_area_after";
            $this->_data["titlePage"]="統計・地域47都道府県";
            $this->load->view($this->_data["module"]."/layout/layout",$this->_data);
        }
        /**
	 * @author  [IVS] Nguyen Hoai Nam
	 * @name 	showUserArea01
	 * @todo 	load page
	 * @param 	 
	 * @return 	
	*/
        public function showUserArea01(){
            $this->_data["loadPage"]="statistics/user_area01";
            $this->_data["titlePage"]="統計・地域分布";
            $this->load->view($this->_data["module"]."/layout/layout",$this->_data);
        }
        /**
	 * @author  [IVS] Nguyen Hoai Nam
	 * @name 	showUserArea01After
	 * @todo 	show data
	 * @param 	 
	 * @return 	
	*/
        public function showUserArea01After(){
            $this->load->Model("admin/Mstatistics");
            $data = $this->Mstatistics->showUserArea1();
            $sum = 0;
            foreach ($data as $c) {
                $sum = $sum + $c['numbers'];          
            }
            $cityGroupList = array();
            if($sum > 0){
                foreach ($data as $i=>$t) 
                {
                    $cityGroupList[$i] = array (
                            'name'=> $t["name"],
                            'numbers'=> $t['numbers'],
                            'rate'=> sprintf('%0.1f',($t['numbers']/$sum)*100)
                    );
                }
            }   
            $this->_data["cityGroupList"]=$cityGroupList;
            $this->_data["count"]=$sum;
            $this->_data["index"]=1;
            $this->_data["loadPage"]="statistics/user_area01_after";
            $this->_data["titlePage"]="統計・地域分布";
            $this->load->view($this->_data["module"]."/layout/layout",$this->_data);
        }
    }
?>

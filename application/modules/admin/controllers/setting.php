<?php
error_reporting(E_ALL);
ini_set('display_errors',1);
set_time_limit (2000);
define("CSV_DEBUG",1);
      class Setting extends MX_Controller{
        const OIWAI_PAY_ADD         = 1;
        const OIWAI_PAY_CHANGE_ONE  = 2;
        const OIWAI_PAY_CHANGE_ALL  = 3;
        const OIWAI_PAY_IMAGE       = "public/user/image/oiwai.jpg";
        const OWNER_CSV_CLUMN_NO    = 35; // number of csv owner columns
        const USER_CSV_CLUMN_NO     = 17; // number of csv user columns
        protected $_data;
        private $message = array('success' => true, 'error' => array());
        public function __construct() {
            parent::__construct();
            AdminControl::CheckLogin();
            $this->_data["module"] = $this->router->fetch_module();
            AdminControl::CheckLogin();
            $this->form_validation->CI =& $this;
            $this->lang->load('form_validation', 'english');
            $this->lang->load('list_message', 'english');
            $this->output->set_header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
            $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate");
            $this->output->set_header("Cache-Control: post-check=0, pre-check=0");
            $this->output->set_header("Pragma: no-cache");
        }
         /**
	 * @author  [IVS] Nguyen Minh Ngoc
	 * @name 	point
	 * @todo 	show table mst_point_masters
	 * @param
	 * @return
	*/
        public function point(){
            $this->load->Model("admin/Msetting");
            $this->_data["loadPage"]="setting/point";
            $this->_data["titlePage"]="管理者アカウント・金額・ポイント設定";
            $this->_data["info"]=$this->Msetting->showPointMaster();
            $this->_data["method"]=$this->Msetting->showMethodTran();
            $this->_data["scout"]=$this->Msetting->showPointScout();
            $this->_data["view"]=$this->Msetting->showPointView();
            if($this->input->post("btnaddpoint")){
                $this->form_validation->set_rules('txtamount','お金', 'required|numeric|max_length[11]');
                $this->form_validation->set_rules('txtpoint','ポイント', 'required|numeric|xss_clean|callback_checkPoint|max_length[11]');
                $form_validation = $this->form_validation->run();
                $this->message['success'] = !$form_validation && count($_POST) > 0 ? FALSE : TRUE;
                if ($form_validation==false) {
                     $this->_data['message']= $this->message;
                     $this->_data["cc"]="true";
                }else{
                    $amount=$_POST["txtamount"];
                    $point=$_POST["txtpoint"];
                    $method=$_POST["sltgd"];
                    //get current time
                    $time = date("Y-m-d-H-i-s");
                    $this->Msetting->insertPoint($method,$amount,$point,$time);
                    redirect($this->_data["module"]."/setting/comp",$this->_data);
                }
            }
            $this->load->view($this->_data["module"]."/layout/layout",$this->_data);

        }
          /**
	 * @author  [IVS] Nguyen Minh Ngoc
	 * @name 	checkPoint
	 * @todo 	callback check record exist
	 * @param
	 * @return
	*/
         public function checkPoint(){
             $point=$this->input->post('txtpoint');
             $amount=$this->input->post('txtamount');
             $method=$this->input->post('sltgd');
             $this->load->Model("admin/Msetting");
             $this->_data["info"] = $this->Msetting->showPointMaster();
             foreach($this->_data["info"] as $call){
                 $am= (string)$call["amount"];
                 $pt= (string)$call["point"];
                 $mt= (string)$call["payment_method_id"];
                 if(strcmp($amount,$am)==0 && strcmp($point,$pt)==0 && strcmp($method,$mt)==0){
                    return false;
                 }
             }
            return true;
         }
          /**
	 * @author  [IVS] Nguyen Minh Ngoc
	 * @name 	checkPointUP
	 * @todo 	callback check record exist
	 * @param
	 * @return
	*/
         public function checkPointUP(){
             $point=$this->input->post('txtupoint');
             $amount=$this->input->post('txtumoney');
             $method=$this->input->post('sltumethod');
             $this->load->Model("admin/Msetting");
             $this->_data["info"] = $this->Msetting->showPointMaster();
             foreach($this->_data["info"] as $call){
                 $am= (string)$call["amount"];
                 $pt= (string)$call["point"];
                 $mt= (string)$call["payment_method_id"];
                 if(strcmp($amount,$am)==0 && strcmp($point,$pt)==0 && strcmp($method,$mt)==0){
                    return false;
                 }
             }
            return true;
         }
          /**
	 * @author  [IVS] Nguyen Minh Ngoc
	 * @name    updatePoint
	 * @todo    update table mst_point_masters
	 * @param
	 * @return
	*/
         public function updatePoint(){
           $this->load->Model("admin/Msetting");
            $this->_data["loadPage"]="setting/point";
            $this->_data["titlePage"]="管理者アカウント・金額・ポイント設定";
            $this->_data["info"]=$this->Msetting->showPointMaster();
            $this->_data["method"]=$this->Msetting->showMethodTran();
            $this->_data["scout"]=$this->Msetting->showPointScout();
            $this->_data["view"]=$this->Msetting->showPointView();
             if($this->input->post("btnu_update")){
                 $this->form_validation->set_rules('txtumoney','お金', 'required|numeric|max_length[11]');
                 $this->form_validation->set_rules('txtupoint','ポイント', 'required|numeric|xss_clean|callback_checkPointUP|max_length[11]');
                 $form_validation = $this->form_validation->run();
                $this->message['success'] = !$form_validation && count($_POST) > 0 ? FALSE : TRUE;
                if ($form_validation==false) {
                     $this->_data['message']= $this->message;
                     $this->_data["cc"]="true";
                }else{
                    $id=$_POST["txtu_id"];
                    $amount=$_POST["txtumoney"];
                    $point=$_POST["txtupoint"];
                    $method=$_POST["sltumethod"];
                    $this->Msetting->updatePoint($id,$amount,$point,$method);
                    redirect($this->_data["module"]."/setting/comp",$this->_data);
                }
           }
           $this->load->view($this->_data["module"]."/layout/layout",$this->_data);
         }
         /**
	 * @author  [IVS] Nguyen Minh Ngoc
	 * @name    deletePoint
	 * @todo    delete record in table mst_point_masters
	 * @param
	 * @return
	*/
         public function deletePoint(){
           if(isset($_POST["id"])){
                 $id=$_POST["id"];
           }
           $this->load->Model("admin/Msetting");
           $this->Msetting->deletePoint($id);
         }
          /**
	 * @author  [IVS] Nguyen Minh Ngoc
	 * @name 	updatePointScout
	 * @todo 	update record in table mst_point_setting
	 * @param
	 * @return
	*/
         public function updatePointScout(){
            $id=$this->input->post("txtid");
            $a=$this->input->post("txts_amount");
            $p=$this->input->post("txts_point");
            $this->load->Model("admin/Msetting");
            $this->_data["loadPage"]="setting/point";
            $this->_data["titlePage"]="管理者アカウント・金額・ポイント設定";
            $this->load->library("form_validation");
            $this->form_validation->set_rules('txts_amount', 'お金', 'required|numeric|max_length[11]');
            $this->form_validation->set_rules('txts_point', 'ポイント', 'required|numeric|max_length[11]');
            $form_validation = $this->form_validation->run();
            $this->message['success'] = !$form_validation && count($_POST) > 0 ? FALSE : TRUE;
             if($this->form_validation->run()==false){
                $this->_data['message']= $this->message;
                $this->_data["info"]=$this->Msetting->showPointMaster();
                $this->_data["method"]=$this->Msetting->showMethodTran();
                $this->_data["scout"]=$this->Msetting->showPointScout();
                $this->_data["view"]=$this->Msetting->showPointView();
             }else{
                 //get current time
                    $time = date("Y-m-d-H-i-s");
                $this->Msetting->updatePointScout($id,$a,$p,$time);
                //$this->session->set_flashdata('note', 'update successful');
                redirect($this->_data["module"]."/setting/comp");
             }
            $this->load->view($this->_data["module"]."/layout/layout",$this->_data);
         }
          /**
	 * @author  [IVS] Nguyen Minh Ngoc
	 * @name 	updatePointView
	 * @todo 	update record in table mst_point_setting
	 * @param
	 * @return
	*/
          public function updatePointView(){
            $this->load->Model("admin/Msetting");
            $this->_data["loadPage"]="setting/point";
            $this->_data["titlePage"]="管理者アカウント・金額・ポイント設定";
            $this->load->library("form_validation");
            $this->form_validation->set_rules('txtv_amount', 'お金', 'required|numeric|max_length[11]');
            $this->form_validation->set_rules('txtv_point', 'ポイント', 'required|numeric|max_length[11]');
            $form_validation = $this->form_validation->run();
            $this->message['success'] = !$form_validation && count($_POST) > 0 ? FALSE : TRUE;
             if($this->form_validation->run()==false){
                $this->_data['message']= $this->message;
                $this->_data["info"]=$this->Msetting->showPointMaster();
                $this->_data["method"]=$this->Msetting->showMethodTran();
                $this->_data["scout"]=$this->Msetting->showPointScout();
                $this->_data["view"]=$this->Msetting->showPointView();
             }else{
                $id=$this->input->post("txtvid");
                $a=$this->input->post("txtv_amount");
                $p=$this->input->post("txtv_point");
                //get current time
                $time = date("Y-m-d-H-i-s");
                $this->Msetting->updatePointView($id,$a,$p,$time);
                redirect($this->_data["module"]."/setting/comp");
             }
            $this->load->view($this->_data["module"]."/layout/layout",$this->_data);
         }
          /**
	 * @author  [IVS] Nguyen Minh Ngoc
	 * @name 	category
	 * @todo 	show table category
	 * @param
	 * @return
	*/
        public function category(){

            $this->load->Model("admin/Msetting");
            $this->_data["loadPage"]="setting/category";
            $this->_data["titlePage"]="設定・業種";
            $this->_data["info"]=$this->Msetting->showJobType();
            $this->load->view($this->_data["module"]."/layout/layout",$this->_data);

        }
         /**
	 * @author  [IVS] Nguyen Minh Ngoc
	 * @name 	deleteJobType
	 * @todo 	delete job name
	 * @param
	 * @return
	*/
        public function deleteJobType(){
             $this->load->Model("admin/Msetting");
            $beforeSubmitList = $this->Msetting->getJob();
            $afterSubmitList = $this->input->post('chk_display');
            foreach($beforeSubmitList as $key=>$item){
                if(isset($afterSubmitList[$item['id']])){
                    $this->Msetting->updateJobType($item['id']);
                }
                else
                {
                    $this->Msetting->deleteJobType($item['id']);
                }
            }
            $this->_data["loadPage"] = "setting/comp";
            $this->_data["titlePage"] = "設定・待遇";
            $this->load->view($this->_data["module"]."/layout/layout",$this->_data);
        }


          /**
	 * @author  [IVS] Nguyen Minh Ngoc
	 * @name 	updatePriority
	 * @todo 	update priority when click up and down link
	 * @param
	 * @return
	*/
        public function updatePriority(){
            $this->load->Model("admin/Msetting");
            if(isset($_POST["id"])){
               $id = $_POST["id"];
            }
            $apri =$this->Msetting->showPriority($id);
            foreach($apri as $t){
                $pri=$t["priority"];
            }
            $pre =$this->Msetting->showprerecord($pri);
            if(!empty($pre)){
                foreach($pre as $a){
                    $ppri=$a["priority"];
                    $pid=$a["id"];
                }
                $this->Msetting->updatePriority($id,$ppri);
                $this->Msetting->updatePriority($pid,$pri);
            }
        }
         /**
	 * @author  [IVS] Nguyen Minh Ngoc
	 * @name 	updatePriority_Down
	 * @todo 	update priority when click down link
	 * @param
	 * @return
	*/
        public function updatePriority_Down(){
            $this->load->Model("admin/Msetting");
            if(isset($_POST["id"])){
               $id = $_POST["id"];
            }
            $apri =$this->Msetting->showPriority($id);
            foreach($apri as $t){
                $pri=$t["priority"];
            }

            $pre =$this->Msetting->shownextrecord($pri);
            if(!empty($pre)){
                foreach($pre as $a){
                    $ppri=$a["priority"];
                    $pid=$a["id"];
                }
                $this->Msetting->updatePriority($id,$ppri);
                $this->Msetting->updatePriority($pid,$pri);
            }
        }
        /*---------------------------------------------------------------------------------------------------------------------------------------------------------*/

        /**
	 * @author  [IVS] Nguyen Hoai Nam
	 * @name 	comp
	 * @todo 	return successful message
	 * @param
	 * @return
	*/
        public function comp(){
            $this->_data["loadPage"] = "setting/comp";
            $this->_data["titlePage"] = "会社検索";
            $this->load->view($this->_data["module"]."/layout/layout", $this->_data);
        }
        /**
	 * @author  [IVS] Nguyen Hoai Nam
	 * @name 	editHour
	 * @todo 	edit Hour
	 * @param
	 * @return
	*/
        public function editHour(){
            $this->load->Model("admin/Msetting");
            $this->_data["hourSalaryList"] = $this->Msetting->getHourSalary();
            $this->_data["loadPage"] = "setting/hour";
            $this->_data["index"] = 1;
            $this->_data["titlePage"] = "設定・時給目安";
            $this->load->view($this->_data["module"]."/layout/layout", $this->_data);
        }
        /**
	 * @author  [IVS] Nguyen Hoai Nam
	 * @name 	checkHour
	 * @todo 	check input
	 * @param
	 * @return
	*/
        public function checkHour() {
            $this->form_validation->set_rules('txtAmountHour', '時給目安', 'required|numeric|max_length[11]|is_natural_no_zero|xss_clean|callback_hour_exist_check');
            $form_validation = $this->form_validation->run();
            $this->message['success'] = !$form_validation && count($_POST) > 0 ? FALSE : TRUE;
            if (!$form_validation) {
                return false;
            }
            return true;
        }
        /**
	 * @author  [IVS] Nguyen Hoai Nam
	 * @name 	hour_exist_check
	 * @todo 	check record exist
	 * @param
	 * @return
	*/
        public function hour_exist_check($str)
	{
            $this->load->Model("admin/Msetting");
            $data = $this->Msetting->getHourSalary();
            foreach($data as $c){
                if(strcmp($str, $c["amount"]) == 0){
                   return false;
                }
            }
            return true;
	}
        /**
	 * @author  [IVS] Nguyen Hoai Nam
	 * @name 	addHour
	 * @todo 	load page
	 * @param
	 * @return
	*/
        public function addHour(){
            $this->_data["flag"] = 0;
            $this->_data["amount"] = null;
            $this->_data["loadPage"] = "setting/hour_set";
            $this->_data["titlePage"] = "設定・編集";
            $this->load->view($this->_data["module"]."/layout/layout",$this->_data);
        }
        /**
	 * @author  [IVS] Nguyen Hoai Nam
	 * @name 	checkBeforeInsertHour
	 * @todo 	check input before insert
	 * @param
	 * @return
	*/
        public function checkBeforeInsertHour(){
            if ($_POST) {
                if ($this->checkHour()) {
                    $this->_data["flag"] = 1;
                }
                else{
                    $this->_data["flag"] = 0;
                    $this->_data['message']= $this->message;
                }
            }
            else{
                $this->_data["flag"] = 0;
            }
            $this->_data["amount"] = trim($this->input->post('txtAmountHour'));
            $this->_data["loadPage"] = "setting/hour_set";
            $this->_data["titlePage"] = "設定・編集";
            $this->load->view($this->_data["module"]."/layout/layout",$this->_data);
        }
        /**
	 * @author  [IVS] Nguyen Hoai Nam
	 * @name 	doInsertHour
	 * @todo 	insert data
	 * @param
	 * @return
	*/
        public function doInsertHour(){
            if ($_POST) {
                $amount = $_POST['txtAmountHour'];
                $this->load->Model("admin/Msetting");
                $this->Msetting->insertHour($amount);
            }
        }
        /**
	 * @author  [IVS] Nguyen Hoai Nam
	 * @name 	doUpdateHour
	 * @todo 	update data
	 * @param
	 * @return
	*/
        public function doUpdateHour(){
            $this->load->Model("admin/Msetting");
            $beforeSubmitList = $this->Msetting->getHourSalary();
            $afterSubmitList = $this->input->post('chk');
            foreach($beforeSubmitList as $key=>$item){
                if(isset($afterSubmitList[$item['id']])){
                    $this->Msetting->updateHour($item, 1);
                }
                else
                {
                    $this->Msetting->updateHour($item, 0);
                }
            }
            $this->_data["loadPage"] = "setting/comp";
            $this->_data["titlePage"] = "設定・時給目安";
            $this->load->view($this->_data["module"]."/layout/layout",$this->_data);
        }
        /**
	 * @author  [IVS] Nguyen Hoai Nam
	 * @name 	editMonth
	 * @todo 	edit Month
	 * @param
	 * @return
	*/
        public function editMonth(){
            $this->load->Model("admin/Msetting");
            $this->_data["monthSalaryList"] = $this->Msetting->getMonthSalary();
            $this->_data["loadPage"] = "setting/month";
            $this->_data["index"] = 1;
            $this->_data["titlePage"] = "設定・月給目安";
            $this->load->view($this->_data["module"]."/layout/layout",$this->_data);
        }
        /**
	 * @author  [IVS] Nguyen Hoai Nam
	 * @name 	checkMonth
	 * @todo 	check input
	 * @param
	 * @return
	*/
        public function checkMonth() {
            $this->form_validation->set_rules('txtAmountMonth', '時給目安', 'required|numeric|is_natural_no_zero|xss_clean|callback_month_exist_check|max_length[11]');
            $form_validation = $this->form_validation->run();
            $this->message['success'] = !$form_validation && count($_POST) > 0 ? FALSE : TRUE;
            if (!$form_validation) {
                return false;
            }
            return true;
        }
        /**
	 * @author  [IVS] Nguyen Hoai Nam
	 * @name 	month_exist_check
	 * @todo 	check record exist
	 * @param
	 * @return
	*/
        public function month_exist_check($str)
	{
            $this->load->Model("admin/Msetting");
            $data = $this->Msetting->getMonthSalary();
            foreach($data as $c){
                if(strcmp($str, $c["amount"]) == 0){
                   return false;
                }
            }
            return true;
	}
        /**
	 * @author  [IVS] Nguyen Hoai Nam
	 * @name 	addMonth
	 * @todo 	load page
	 * @param
	 * @return
	*/
        public function addMonth(){
            $this->_data["flag"] = 0;
            $this->_data["amount"] = null;
            $this->_data["loadPage"] = "setting/month_set";
            $this->_data["titlePage"] = "設定・編集";
            $this->load->view($this->_data["module"]."/layout/layout",$this->_data);
        }
        /**
	 * @author  [IVS] Nguyen Hoai Nam
	 * @name 	checkBeforeInsertMonth
	 * @todo 	check input before insert
	 * @param
	 * @return
	*/
        public function checkBeforeInsertMonth(){
            if ($_POST) {
                if ($this->checkMonth()) {
                    $this->_data["flag"] = 1;
                }
                else{
                    $this->_data["flag"] = 0;
                    $this->_data['message']= $this->message;
                }
            }
            else{
                $this->_data["flag"] = 0;
            }
            $this->_data["amount"] = trim($this->input->post('txtAmountMonth'));
            $this->_data["loadPage"] = "setting/month_set";
            $this->_data["titlePage"] = "設定・編集";
            $this->load->view($this->_data["module"]."/layout/layout",$this->_data);
        }
        /**
	 * @author  [IVS] Nguyen Hoai Nam
	 * @name 	doInsertMonth
	 * @todo 	insert data
	 * @param
	 * @return
	*/
        public function doInsertMonth(){
            if ($_POST) {
                $amount = $_POST['txtAmountMonth'];
                $this->load->Model("admin/Msetting");
                $this->Msetting->insertMonth($amount);
            }
        }
        /**
	 * @author  [IVS] Nguyen Hoai Nam
	 * @name 	doUpdateMonth
	 * @todo 	update data
	 * @param
	 * @return
	*/
        public function doUpdateMonth(){
            $this->load->Model("admin/Msetting");
            $beforeSubmitList = $this->Msetting->getMonthSalary();
            $afterSubmitList = $this->input->post('chk');
            foreach($beforeSubmitList as $key=>$item){
                if(isset($afterSubmitList[$item['id']])){
                    $this->Msetting->updateMonth($item, 1);
                }
                else
                {
                    $this->Msetting->updateMonth($item, 0);
                }
            }
            $this->_data["loadPage"] = "setting/comp";
            $this->_data["titlePage"] = "設定・月給目安";
            $this->load->view($this->_data["module"]."/layout/layout",$this->_data);
        }
        /**
	 * @author  [IVS] Nguyen Hoai Nam
	 * @name 	editTreatment
	 * @todo 	load page
	 * @param
	 * @return
	*/
        public function editTreatment(){
            $this->load->Model("admin/Msetting");
            $this->_data["treatmentList"] = $this->Msetting->getTreatment();
            $this->_data["loadPage"] = "setting/treatment";
            $this->_data["index"] = 1;
            $this->_data["titlePage"] = "設定・待遇";
            $this->load->view($this->_data["module"]."/layout/layout",$this->_data);
        }
        /**
	 * @author  [IVS] Nguyen Hoai Nam
	 * @name 	checkTreatment
	 * @todo 	check input
	 * @param
	 * @return
	*/
        public function checkTreatment() {
            $this->form_validation->set_rules('txtNameTreatment', '待遇', 'required|xss_clean|callback_treatment_exist_check');
            $form_validation = $this->form_validation->run();
            $this->message['success'] = !$form_validation && count($_POST) > 0 ? FALSE : TRUE;
            if (!$form_validation) {
                return false;
            }
            return true;
        }
        /**
	 * @author  [IVS] Nguyen Hoai Nam
	 * @name 	treatment_exist_check
	 * @todo 	check record exist
	 * @param
	 * @return
	*/
        public function treatment_exist_check($str)
	{
            $this->load->Model("admin/Msetting");
            $data = $this->Msetting->getTreatment();
            foreach($data as $c){
                if(strcmp($str, $c["name"]) == 0){
                   return false;
                }
            }
            return true;
	}
        /**
	 * @author  [IVS] Nguyen Hoai Nam
	 * @name 	addTreatment
	 * @todo 	load page
	 * @param
	 * @return
	*/
        public function addTreatment(){
            $this->_data["flag"] = 0;
            $this->_data["treatment"] = null;
            $this->_data["loadPage"] = "setting/treatment_set";
            $this->_data["titlePage"] = "設定・待遇";
            $this->load->view($this->_data["module"]."/layout/layout",$this->_data);
        }
        /**
	 * @author  [IVS] Nguyen Hoai Nam
	 * @name 	checkBeforeInsertTreatment
	 * @todo 	check input before insert
	 * @param
	 * @return
	*/
        public function checkBeforeInsertTreatment(){
            if ($_POST) {
                if ($this->checkTreatment()) {
                    $this->_data["flag"] = 1;
                }
                else{
                    $this->_data["flag"] = 0;
                    $this->_data['message']= $this->message;
                }
            }
            else{
                $this->_data["flag"] = 0;
            }
            $this->_data["treatment"] = trim($this->input->post('txtNameTreatment'));
            $this->_data["loadPage"] = "setting/treatment_set";
            $this->_data["titlePage"] = "設定・待遇";
            $this->load->view($this->_data["module"]."/layout/layout",$this->_data);
        }
        /**
	 * @author  [IVS] Nguyen Hoai Nam
	 * @name 	doInsertTreatment
	 * @todo 	insert data
	 * @param
	 * @return
	*/
        public function doInsertTreatment(){
            if ($_POST) {
                $this->load->Model("admin/Msetting");
                $treatment = $_POST['txtNameTreatment'];
                $pri = $this->Msetting->maxPriority();
                foreach ($pri as $k=>$p){
                    $pri=(int)$p["MAX(priority)"] + 1;
                }
                $this->Msetting->insertTreatment($treatment,$pri);
            }
        }
        /**
	 * @author  [IVS] Nguyen Hoai Nam
	 * @name 	moveUpTreatment
	 * @todo 	move up record
	 * @param
	 * @return
	*/
        public function moveUpTreatment(){
            $this->load->Model("admin/Msetting");
            if(isset($_POST["id"])){
               $id = $_POST["id"];
            }
            $data1 = $this->Msetting->getTreatmentById($id);
            foreach($data1 as $c){
                $index1 = $c["priority"];
            }
            $data2 = $this->Msetting->getPreviousTreatment($index1);
            if(!empty($data2)){
                foreach($data2 as $c){
                    $index2 = $c["priority"];
                    $pid = $c["id"];
                }
                $this->Msetting->updatePriorityTreatment($id, $index2);
                $this->Msetting->updatePriorityTreatment($pid, $index1);
            }
        }
        /**
	 * @author  [IVS] Nguyen Hoai Nam
	 * @name 	moveDownTreatment
	 * @todo 	move down record
	 * @param
	 * @return
	*/
        public function moveDownTreatment(){
            $this->load->Model("admin/Msetting");
            if(isset($_POST["id"])){
               $id = $_POST["id"];
            }
            $data1 = $this->Msetting->getTreatmentById($id);
            foreach($data1 as $c){
                $index1 = $c["priority"];
            }
            $data2 = $this->Msetting->getNextTreatment($index1);
            if(!empty($data2)){
                foreach($data2 as $c){
                    $index2 = $c["priority"];
                    $pid = $c["id"];
                }
                $this->Msetting->updatePriorityTreatment($id, $index2);
                $this->Msetting->updatePriorityTreatment($pid, $index1);
            }
        }
        /**
	 * @author  [IVS] Nguyen Hoai Nam
	 * @name 	doUpdateTreatment
	 * @todo 	update data
	 * @param
	 * @return
	*/
        public function doUpdateTreatment(){
            $this->load->Model("admin/Msetting");
            $beforeSubmitList = $this->Msetting->getTreatment();
            $afterSubmitList = $this->input->post('chk');
            foreach($beforeSubmitList as $key=>$item){
                if(isset($afterSubmitList[$item['id']])){
                    $this->Msetting->updateTreatment($item, 1);
                }
                else
                {
                    $this->Msetting->updateTreatment($item, 0);
                }
            }
            $this->_data["loadPage"] = "setting/comp";
            $this->_data["titlePage"] = "設定・待遇";
            $this->load->view($this->_data["module"]."/layout/layout",$this->_data);
        }
        /**
	 * @author  [IVS] Nguyen Hoai Nam
	 * @name 	editOwnerCode
	 * @todo 	load page
	 * @param
	 * @return
	*/
        public function editOwnerCode(){
            $this->_data["flag"] = 0;
            $this->_data["error_message"] = null;
            $this->_data["array1"] = null;
            $this->load->Model("admin/Msetting");
            $this->_data["ownerCodeList"] = $this->Msetting->getOwnerCode();
            $this->_data["loadPage"] = "setting/ownercode";
            $this->_data["titlePage"] = "設定・オーナー・コード登録";
            $this->load->view($this->_data["module"]."/layout/layout",$this->_data);
        }
         /**
	 * @author  [IVS] Nguyen Hoai Nam
	 * @name 	checkOwnerCode
	 * @todo 	check input
	 * @param
	 * @return
	*/
        public function checkOwnerCode() {
            $this->form_validation->set_rules('txtNameOC', '広告サイト', 'required|checkStringByte');
            $this->form_validation->set_rules('txtCodeOC', 'コード', 'required|checkStringByte|xss_clean|callback_ownercode_exist_check['.$this->input->post('txtNameOC').']');
            $form_validation = $this->form_validation->run();
            $this->message['success'] = !$form_validation && count($_POST) > 0 ? FALSE : TRUE;
            if (!$form_validation) {
                return false;
            }
            return true;
        }
        /**
	 * @author  [IVS] Nguyen Hoai Nam
	 * @name 	ownercode_exist_check
	 * @todo 	check record exist
	 * @param
	 * @return
	*/
        public function ownercode_exist_check($str1, $str2)
	{
            $this->load->Model("admin/Msetting");
            $data = $this->Msetting->getOwnerCode();
            foreach($data as $c){
                if(strcmp($str1, $c["name"]) == 0 && strcmp($str2, $c["code"]) == 0){
                   return false;
                }
            }
            return true;
	}
        /**
	 * @author  [IVS] Nguyen Hoai Nam
	 * @name 	addOwnerCode
	 * @todo 	load page
	 * @param
	 * @return
	*/
        public function addOwnerCode(){
            $this->_data["flag"] = 0;
            $this->_data["name"] = null;
            $this->_data["code"] = null;
            $this->_data["loadPage"] = "setting/ownercode_set";
            $this->_data["titlePage"] = "設定・オーナー・コード登録編集";
            $this->load->view($this->_data["module"]."/layout/layout",$this->_data);
        }
        /**
	 * @author  [IVS] Nguyen Hoai Nam
	 * @name 	checkBeforeInsertOwnerCode
	 * @todo 	check input before insert
	 * @param
	 * @return
	*/
        public function checkBeforeInsertOwnerCode(){
            if ($_POST) {
                if ($this->checkOwnerCode()) {
                    $this->_data["flag"] = 1;
                }
                else{
                    $this->_data["flag"] = 0;
                    $this->_data['message']= $this->message;
                }
            }else{
                $this->_data["flag"] = 0;
            }
            $this->_data["name"] = trim($this->input->post('txtNameOC'));
            $this->_data["code"] = trim($this->input->post('txtCodeOC'));
            $this->_data["loadPage"] = "setting/ownercode_set";
            $this->_data["titlePage"] = "設定・オーナー・コード登録編集";
            $this->load->view($this->_data["module"]."/layout/layout",$this->_data);
        }
        /**
	 * @author  [IVS] Nguyen Hoai Nam
	 * @name 	doInsertOwnerCode
	 * @todo 	insert data
	 * @param
	 * @return
	*/
        public function doInsertOwnerCode(){
            if ($_POST) {
                $name = $_POST['txtNameOC'];
                $code = $_POST['txtCodeOC'];
                $this->load->Model("admin/Msetting");
                $this->Msetting->insertOwnerCode($name, $code);
            }
        }
        /**
	 * @author  [IVS] Nguyen Hoai Nam
	 * @name 	checkBeforeDeleteOwnerCode
	 * @todo 	check input before delete
	 * @param
	 * @return
	*/
        public function checkBeforeDeleteOwnerCode(){
            $afterSubmitList = $this->input->post('chk');
            if($afterSubmitList != null){
                $this->_data["flag"] = 2;
            }
            else{
                $this->_data["flag"] = 1;
                $msg =  $this->lang->line('check_checkbox');
                $this->_data["error_message"]= $msg;
            }
            $this->load->Model("admin/Msetting");
            $this->_data["ownerCodeList"] = $this->Msetting->getOwnerCode();
            $this->_data["array1"] = $afterSubmitList;
            $this->_data["loadPage"] = "setting/ownercode";
            $this->_data["titlePage"] = "設定・オーナー・コード登録";
            $this->load->view($this->_data["module"]."/layout/layout",$this->_data);
        }
        /**
	 * @author  [IVS] Nguyen Hoai Nam
	 * @name 	doDeleteOwnerCode
	 * @todo 	delete record
	 * @param
	 * @return
	*/
        public function doDeleteOwnerCode(){
            if ($_POST) {
                $array = $_POST['txtArrayOC'];
                $split = explode('_', $array);
                $this->load->Model("admin/Msetting");
                foreach ($split as $id){
                    $this->Msetting->deleteOwnerCode($id);
                }
            }
        }
        /**
	 * @author  [IVS] Nguyen Hoai Nam
	 * @name 	editUserCode
	 * @todo 	load page
	 * @param
	 * @return
	*/
        public function editUserCode(){
            $this->_data["flag"] = 0;
            $this->_data["error_message"] = null;
            $this->_data["array1"] = null;
            $this->load->Model("admin/Msetting");
            $this->_data["userCodeList"]=$this->Msetting->getUserCode();
            $this->_data["loadPage"]="setting/usercode";
            $this->_data["titlePage"]="設定・ユーザー・コード登録";
            $this->load->view($this->_data["module"]."/layout/layout",$this->_data);
        }
        /**
	 * @author  [IVS] Nguyen Hoai Nam
	 * @name 	checkUserCode
	 * @todo 	check input
	 * @param
	 * @return
	*/
        public function checkUserCode() {
            $this->form_validation->set_rules('txtNameUC', '広告サイト', 'required|checkStringByte');
            $this->form_validation->set_rules('txtCodeUC', 'コード', 'required|checkStringByte|xss_clean|callback_usercode_exist_check['.$this->input->post('txtNameUC').']');
            $form_validation = $this->form_validation->run();
            $this->message['success'] = !$form_validation && count($_POST) > 0 ? FALSE : TRUE;
            if (!$form_validation) {
                return false;
            }
            return true;
        }
	/**
	 * @author  [IVS] Nguyen Hoai Nam
	 * @name 	usercode_exist_check
	 * @todo 	check record exist
	 * @param
	 * @return
	*/
        public function usercode_exist_check($str1, $str2)
	{
            $this->load->Model("admin/Msetting");
            $data = $this->Msetting->getUserCode();
            foreach($data as $c){
                if(strcmp($str1, $c["name"]) == 0 && strcmp($str2, $c["code"]) == 0){
                   return false;
                }
            }
            return true;
	}
        /**
	 * @author  [IVS] Nguyen Hoai Nam
	 * @name 	addUserCode
	 * @todo 	load page
	 * @param
	 * @return
	*/
        public function addUserCode(){
            $this->_data["flag"] = 0;
            $this->_data["name"] = null;
            $this->_data["code"] = null;
            $this->_data["loadPage"]="setting/usercode_set";
            $this->_data["titlePage"]="設定・ユーザー・コード登録編集";
            $this->load->view($this->_data["module"]."/layout/layout",$this->_data);
        }
        /**
	 * @author  [IVS] Nguyen Hoai Nam
	 * @name 	checkBeforeInsertUserCode
	 * @todo 	check input before insert
	 * @param
	 * @return
	*/
        public function checkBeforeInsertUserCode(){
            if ($_POST) {
                if ($this->checkUserCode()) {
                    $this->_data["flag"] = 1;
                }
                else{
                    $this->_data["flag"] = 0;
                    $this->_data['message']= $this->message;
                }
            }
            else{
                $this->_data["flag"] = 0;
            }
            $this->_data["name"] = trim($this->input->post('txtNameUC'));
            $this->_data["code"] = trim($this->input->post('txtCodeUC'));
            $this->_data["loadPage"] = "setting/usercode_set";
            $this->_data["titlePage"] = "設定・ユーザー・コード登録編集";
            $this->load->view($this->_data["module"]."/layout/layout",$this->_data);
        }
         /**
	 * @author  [IVS] Nguyen Hoai Nam
	 * @name 	doInsertUserCode
	 * @todo 	insert data
	 * @param
	 * @return
	*/
        public function doInsertUserCode(){
            if ($_POST) {
                $name = $_POST['txtNameUC'];
                $code = $_POST['txtCodeUC'];
                $this->load->Model("admin/Msetting");
                $this->Msetting->insertUserCode($name, $code);
            }
        }
        /**
	 * @author  [IVS] Nguyen Hoai Nam
	 * @name 	checkBeforeDeleteUserCode
	 * @todo 	check before delete
	 * @param
	 * @return
	*/
        public function checkBeforeDeleteUserCode(){
            $afterSubmitList = $this->input->post('chk');
            if($afterSubmitList != null){
                $this->_data["flag"] = 2;
            }
            else{
                $this->_data["flag"] = 1;
                $msg =  $this->lang->line('check_checkbox');
                $this->_data["error_message"]= $msg;
            }
            $this->load->Model("admin/Msetting");
            $this->_data["userCodeList"] = $this->Msetting->getUserCode();
            $this->_data["array1"] = $afterSubmitList;
            $this->_data["loadPage"] = "setting/usercode";
            $this->_data["titlePage"] = "設定・ユーザー・コード登録";
            $this->load->view($this->_data["module"]."/layout/layout",$this->_data);
        }
        /**
	 * @author  [IVS] Nguyen Hoai Nam
	 * @name 	doDeleteUserCode
	 * @todo 	delete data
	 * @param
	 * @return
	*/
        public function doDeleteUserCode(){
            if ($_POST) {
                $array = $_POST['txtArrayUC'];
                $split = explode('_', $array);
                $this->load->Model("admin/Msetting");
                foreach ($split as $id){
                    $this->Msetting->deleteUserCode($id);
                }
            }
        }
        /**
	 * @author  [IVS] Nguyen Hoai Nam
	 * @name 	checkAccount
	 * @todo 	check input
	 * @param
	 * @return
	*/
        public function checkAccount() {
            $this->form_validation->set_rules('txtUsername', 'ログイン', 'required|max_length[10]');
            $this->form_validation->set_rules('txtPassword', 'パスワード', 'required|min_length[4]|max_length[20]|xss_clean|callback_account_exist_check['.$this->input->post('txtUsername').']');
            $form_validation = $this->form_validation->run();
            $this->message['success'] = !$form_validation && count($_POST) > 0 ? FALSE : TRUE;
            if (!$form_validation) {
                return false;
            }
            return true;
        }
	/**
	 * @author  [IVS] Nguyen Hoai Nam
	 * @name 	account_exist_check
	 * @todo 	check record exist
	 * @param
	 * @return
	*/
        public function account_exist_check($str1, $str2)
	{
            $this->load->Model("admin/Msetting");
            $data = $this->Msetting->getAccount();
            foreach($data as $c){
                 if(strcmp($str2, $c["login_id"]) == 0 && strcmp($str1, base64_decode($c["password"])) == 0){
                    return false;
                 }
            }
            return true;
	}
        /**
	 * @author  [IVS] Nguyen Hoai Nam
	 * @name 	manager
	 * @todo 	load page
	 * @param
	 * @return
	*/
        public function manager(){
            $this->_data["flag_insert"] = 0;
            $this->_data["username"] = null;
            $this->_data["password"] = null;
            $this->load->Model("admin/Msetting");
            $this->_data["accountList"]=$this->Msetting->getAccount();
            $this->_data["loadPage"]="setting/manager";
            $this->_data["titlePage"]="管理者アカウント・アカウント管理";
            $this->load->view($this->_data["module"]."/layout/layout",$this->_data);
        }
         /**
	 * @author  [IVS] Nguyen Hoai Nam
	 * @name 	checkBeforeInsertAccount
	 * @todo 	check input before insert
	 * @param
	 * @return
	*/
        public function checkBeforeInsertAccount(){
            if ($_POST) {
                if ($this->checkAccount()) {
                    $this->_data["flag_insert"] = 1;
                }
                else{
                    $this->_data["flag_insert"] = 0;
                    $this->_data['message']= $this->message;
                }
            }else{
                $this->_data["flag_insert"] = 0;
            }
            $this->_data["username"] = trim($this->input->post('txtUsername'));
            $this->_data["password"] = trim($this->input->post('txtPassword'));
            $this->load->Model("admin/Msetting");
            $this->_data["accountList"]=$this->Msetting->getAccount();
            $this->_data["loadPage"]="setting/manager";
            $this->_data["titlePage"]="管理者アカウント・アカウント管理";
            $this->load->view($this->_data["module"]."/layout/layout",$this->_data);
        }
         /**
	 * @author  [IVS] Nguyen Hoai Nam
	 * @name 	doInsertAccount
	 * @todo 	insert data
	 * @param
	 * @return
	*/
        public function doInsertAccount(){
            if ($_POST) {
                $username = $_POST['txtUsername'];
                $password = $_POST['txtPassword'];
                $this->load->Model("admin/Msetting");
                $this->Msetting->insertAccount($username, $password);
            }
        }
         /**
	 * @author  [IVS] Nguyen Hoai Nam
	 * @name    doUpdateAccount
	 * @todo    update table admin
	 * @param
	 * @return
	 */
         public function doUpdateAccount(){
           if(isset($_POST["username"]) && isset($_POST["password"]) && isset($_POST["id"])){
                 $id = $_POST["id"];
                 $username = $_POST["username"];
                 $password = $_POST["password"];
           }
           $this->load->Model("admin/Msetting");
           $this->Msetting->updateAccount($id, $username, $password);
           echo "true";
         }
         /**
	 * @author  [IVS] Nguyen Hoai Nam
	 * @name    doDeleteAccount
	 * @todo    delete record in table admin
	 * @param
	 * @return
	 */
         public function doDeleteAccount(){
           $flag = true;
           $this->load->Model("admin/Msetting");
           if(isset($_POST["id"]) && isset($_SESSION)){
                $id = $_POST["id"];
                $data = $this->Msetting->getAccountById($id);
                foreach ($_SESSION as $key=>$val){
                   if(strcmp($val, $data["login_id"]) == 0){
                       $flag = false;
                   }
                }
                if($flag == true){
                   $this->Msetting->deleteAccount($id);
                   echo "true";
                }
                else{
                   echo "false";
                }
           }
         }
         /**
	 * @author  [IVS] Nguyen Minh Ngoc
	 * @name 	category_set
	 * @todo 	create a new jobname
	 * @param
	 * @return
	*/
        public function category_Set(){
            $this->load->Model("admin/Msetting");
            $name=$this->input->post("txtjobname");
            $this->_data["loadPage"]="setting/category_set";
            $this->_data["titlePage"]="設定・業種";
            $this->form_validation->set_rules('txtjobname','業種内容', 'required|max_length[80]|is_unique[mst_job_types.name]');
            $this->_data["lstred"]=$this->Msetting->showlastrecordJob();
            $pri = 0;
            foreach($this->_data["lstred"] as $t){
                $pri=(int)$t["priority"]+1;
            }
                $form_validation = $this->form_validation->run();
                $this->message['success'] = !$form_validation && count($_POST) > 0 ? FALSE : TRUE;
                if ($form_validation==false) {
                     $this->_data['message']= $this->message;
                }else{
                    $this->_data["name"]=$name;
                    $this->_data["pri"]=$pri;
                    $this->_data["flag"]="true";
                    //redirect("admin/setting/do_insertjob",$this->_data);

            }
            $this->load->view($this->_data["module"]."/layout/layout",$this->_data);
        }
       /**
	 * @author  [IVS] Nguyen Minh Ngoc
	 * @name 	do_insertjob
	 * @todo 	to do insert new job name
	 * @param
	 * @return
	*/
         public function do_insertjob(){
             $this->load->Model("admin/Msetting");
             //get current time
             $name=$this->input->post("txtjobname");
             $pri=$this->input->post("pri");
             $this->Msetting->insertJobType($name,$pri);
         }
          /**
	 * @author  [IVS] Nguyen Minh Ngoc
	 * @name    updateAcc
	 * @todo    update account in admin table
	 * @param
	 * @return
	*/
         public function updateAcc(){
           $this->load->Model("admin/Msetting");
           $this->_data["flag_insert"] = 0;
            $this->_data["username"] = null;
            $this->_data["password"] = null;
            $this->_data["loadPage"]="setting/manager";
            $this->_data["titlePage"]="管理者アカウント・アカウント管理";
             $this->_data["accountList"]=$this->Msetting->getAccount();
             if($this->input->post("btnu_update")){
                 $this->form_validation->set_rules('txtUsername1','ログイン', 'required|max_length[10]');
                 $this->form_validation->set_rules('txtPass1','パスワード', 'required|xss_clean|callback_account_exist_check['.$this->input->post('txtUsername1').']|max_length[20]|min_length[4]');
                 $form_validation = $this->form_validation->run();
                $this->message['success'] = !$form_validation && count($_POST) > 0 ? FALSE : TRUE;
                if ($form_validation==false) {
                     $this->_data['message']= $this->message;
                }else{
                    $id=$_POST["txtu_id"];
                    $username=$_POST["txtUsername1"];
                    $password=$_POST["txtPass1"];
                    $this->Msetting->updateAccount($id, $username, $password);
                    redirect($this->_data["module"]."/setting/comp",$this->_data);
                }
           }
           $this->load->view($this->_data["module"]."/layout/layout",$this->_data);
         }
        /**
        * @author  [VJS] チャンキムバック
        * @name    createNewIowaiMoneyItem
        * @todo    お祝い金項目作成(mst_happy_moneysテーブル)
        * @param   $id          ID
        *          $joyspe_hm   採用金
        *          $user_hm     お祝い金
        *          $image       画像パス
        *          $default_money  デフォルト金額
        *          $display_flag   アクティブフラグ
        * @return  成功：　お祝い金項目（配列）
        *          失敗：　null
        */
        private function createNewIowaiMoneyItem($id, $joyspe_hm, $user_hm, $image, $default_money, $display_flag)
        {
            $ret = null; //戻り値
            //引数チェック
            if ( !is_numeric($joyspe_hm) || !is_numeric($user_hm) || !is_numeric($default_money) ){
                return $ret;
            }
            if ( $id != null && !is_numeric($id) ){
                return $ret;
            }
            if ( $display_flag != 0 && $display_flag != 1 ){
                return $ret;
            }
            if ( !$image ){
                return $ret;
            }

            $new_hp_item       = array();
            $new_hp_item['id'] = $id;
            $new_hp_item['joyspe_happy_money'] = $joyspe_hm;
            $new_hp_item['user_happy_money']   = $user_hm;
            $new_hp_item['image']              = $image;
            $new_hp_item['default_money']      = $default_money;
            $new_hp_item['display_flag']       = $display_flag;
            $ret = $new_hp_item;
            return $ret;
         }
        /**
        * @author  [VJS] チャンキムバック
        * @name    changeOiwaiPay
        * @todo    お祝い金変更
        * @param   $mode 変更モード
        *                1. お祝い金新規追加
        *                2. お祝い金新規変更
        *                3. お祝い金新規いっぺん変更
        *         　上記以外. お祝い金リスト表示
        * @return  なし
        */
        public function changeOiwaiPay($mode = null){
            $this->load->Model("admin/Msetting");
            if ( $mode ) {
                switch ( $mode ) {
                    case Setting::OIWAI_PAY_ADD:  //新規追加
                        $joyspe_happy_money = $this->input->post("joyspe_happy_money");
                        $user_happy_money   = $this->input->post("user_happy_money");
                        if ( isset($joyspe_happy_money) && isset($user_happy_money) ){
                                //入力データチェック
                                $this->form_validation->set_rules("joyspe_happy_money", "採用金","required|numeric|greater_than[-1]|less_than[1000001]|callback_unique_happy_moneys");
                                $this->form_validation->set_rules("user_happy_money", "お祝い金","required|numeric|greater_than[-1]|less_than[1000001]");
                                $form_validation = $this->form_validation->run();
                                $this->message['success'] = $form_validation;
                                if ( $form_validation === true ){
                                    $happy_money_item = $this->createNewIowaiMoneyItem(null, $joyspe_happy_money, $user_happy_money, Setting::OIWAI_PAY_IMAGE, 0, 1);
                                    $this->Msetting->addOiwaiMoney($happy_money_item);
                                    $this->_data["add_success_flag"] = 1;
                                }else{
                                    $this->_data['message'] = $this->message;
                                }
                        }
                        break;
                    case Setting::OIWAI_PAY_CHANGE_ONE: //ひとつの項目変更
                        $id = $this->input->post("money_no");
                        if ( isset($id) ){
                            $joyspe_happy_money = $this->input->post("joyspe_happy_money_".$id);
                            $user_happy_money   = $this->input->post("user_happy_money_".$id);
                            if ( isset($joyspe_happy_money) && isset($user_happy_money) ){
                                    //入力データチェック
                                    $this->form_validation->set_rules("joyspe_happy_money_".$id, "採用金","required|numeric|greater_than[-1]|less_than[1000001]");
                                    $this->form_validation->set_rules("user_happy_money_".$id, "お祝い金","required|numeric|greater_than[-1]|less_than[1000001]");
                                    $form_validation = $this->form_validation->run();
                                    $this->message['success'] = $form_validation;
                                    if ( $form_validation === true ){
                                        $active = $this->input->post("active_".$id);
                                        if ( $active ){
                                            $display_flag = 1;
                                        }else{
                                            $display_flag = 0;
                                        }
                                        $happy_money_item = $this->createNewIowaiMoneyItem($id, $joyspe_happy_money, $user_happy_money, Setting::OIWAI_PAY_IMAGE, 0, $display_flag);
                                        $this->Msetting->updateOiwaiMoney($happy_money_item);
                                    }else{
                                        $this->_data['message'] = $this->message;
                                    }
                            }
                        }
                        break;
                    case Setting::OIWAI_PAY_CHANGE_ALL: //すべて変更
                        $money_no_cnt = $this->input->post("money_no_cnt");
                        if ( isset($money_no_cnt) && is_numeric($money_no_cnt) ){
                            $happy_money_data = array();
                            $happy_money_data_cnt = 0;
                            $submit_data_err_flag = true;
                            for( $i=0; $i<$money_no_cnt; $i++ ){
                                $money_no_name = "money_no_".$i;
                                $id = $this->input->post($money_no_name);
                                if ( isset($id) ){
                                    $joyspe_happy_money = $this->input->post("joyspe_happy_money_".$id);
                                    $user_happy_money   = $this->input->post("user_happy_money_".$id);

                                    if ( isset($joyspe_happy_money) && isset($user_happy_money) ){
                                        //入力データチェック
                                        $this->form_validation->set_rules("joyspe_happy_money_".$id, "採用金","required|numeric|greater_than[-1]|less_than[1000001]");
                                        $this->form_validation->set_rules("user_happy_money_".$id, "お祝い金","required|numeric|greater_than[-1]|less_than[1000001]");

                                        $form_validation = $this->form_validation->run();
                                        $this->message['success'] = $form_validation;
                                        if ( $form_validation === true ){
                                            $active = $this->input->post("active_".$id);
                                            if ( $active ){
                                                $display_flag = 1;
                                            }else{
                                                $display_flag = 0;
                                            }
                                            $happy_money_item = $this->createNewIowaiMoneyItem($id, $joyspe_happy_money, $user_happy_money,Setting::OIWAI_PAY_IMAGE, 0, $display_flag);
                                            $happy_money_data[$happy_money_data_cnt] =  $happy_money_item;
                                            $happy_money_data_cnt++;
                                        }else{
                                            $this->_data['message'] = $this->message;
                                            $submit_data_err_flag = false;
                                            break;
                                        }
                                    }
                                }
                            }
                            //更新データ取得がOKの場合、DB更新
                            if ( $submit_data_err_flag && count($happy_money_data) > 0 ){
                                $this->Msetting->updateOiwaiMoneyAll($happy_money_data);
                            }
                        }
                        break;
                    default: //普通に表示する
                }
            }
            $this->_data["titlePage"]= "管理者アカウント・採用金・お祝い金設定";
            $this->_data["loadPage"] = "setting/oiwai_pay";
            $this->_data["happyMoneyList"] = $this->Msetting->getOiwaiMoneyList();
            $this->load->view($this->_data["module"]."/layout/layout",$this->_data);
        }
        //validate if both user and joyspe happy money exists.
        public function unique_happy_moneys($joyspeHappyMoney) {
          $this->load->Model("admin/Msetting");
          $userHappyMoney = $this->input->post('user_happy_money');
          $result = $this->Msetting->uniqueJoyspeUserHappyMoney($joyspeHappyMoney, $userHappyMoney);
          if($result) {
            $this->form_validation->set_message('unique_happy_moneys', '追加された採用金額は既に存在しています。');
            return false;
          }
          return true;
        }


         /**
        * @author  VJS
        * @name    registerUserFromCSV
        * @todo    import user data from csv
        * @param   none
        * @return  none
        */
        public function registerUserFromCSV(){
            $error_msg = ""; // Error message
            $this->load->Model("admin/Msearch");
            $this->load->Model("user/Musers");
            $last_reg_date = $this->Musers->getLastImportDate();
            if( $this->input->post("btnCsv") ) {
                $data_from_site = $this->input->post("import_from");
                $overwrite_flg = $this->input->post("update_flg");

                $fileName = $this->input->post('filename');
                $filePath = base_url().'/public/admin/uploads/csv/'.$fileName;
                $file = fopen($filePath,"r");

                if ( $file ){
                    $treatments = array();

                    // Start transaction
                    $this->db->trans_begin();
                    $cnt = 0;
                    $import_complete = true;
                    while(!feof($file)){
                        $data = fgetcsv($file);
                        if ( count($data) != SETTING::USER_CSV_CLUMN_NO ){
                            $error_msg = "CSVファイルのデータコラム数は間違っています。ご確認ください。". "データ番号".($cnt+1);
                            $import_complete = false;
                            break;
                        }
                        $cnt++;
                        if ( $cnt == 1 ){
                            continue; // skip the first line (title line)
                        }
                        // Check email address
                        $email_exist_flg = $this->Musers->checkRegisteredEmail($data[9]);
                        if ( !$data[9] || ($overwrite_flg == false && $email_exist_flg )){
                            $import_complete = false;
                            $error_msg = "メールアドレスは既に登録されています。"." データ番号:".$cnt;
                            break;
                        }
if ( CSV_DEBUG == 0 ){
                        // check if height, age, bust, waist, hip is numberic or not
                        if  ( !is_numeric($data[1]) ){
                            $import_complete  = false;
                            $error_msg = "身長は正しくありません。"." データ番号:".$cnt;
                            break;
                        }
                        // age
                        if  ( !is_numeric($data[2]) ){
                            $import_complete  = false;
                            $error_msg = "年齢は正しくありません。"." データ番号:".$cnt;
                            break;
                        }
                        // bust
                        if  ( !is_numeric($data[5]) ){
                            $import_complete  = false;
                            $error_msg = "バストは正しくありません。"." データ番号:".$cnt;
                            break;
                        }
                        // waist
                        if  ( !is_numeric($data[6]) ){
                            $import_complete  = false;
                            $error_msg = "ウェストは正しくありません。"." データ番号:".$cnt;
                            break;
                        }
                        // hip
                        if  ( !is_numeric($data[7]) ){
                            $import_complete  = false;
                            $error_msg = "ヒップは正しくありません。"." データ番号:".$cnt;
                            break;
                        }
}
                        if ( !$email_exist_flg ){
                            // 新ユーザー追加
                            $uniqueid = random_string('alnum', 8);
                            $user_data = array(
                            'unique_id' => $uniqueid,
                            'old_id' => $data[0],
                            'name' => $data[8],
                            'email_address' => $data[9],
                            'password' => base64_encode($data[10]),
                            'birthday'=> $data[11],
                            'profile_pic'=> $data[4],
                            'bust'=> $data[5],
                            'waist'=> $data[6],
                            'hip'=> $data[7],
                            'user_status' => 0,//仮登録に設定する
                            'bank_name' => $data[12],
                            'bank_agency_name' => $data[13],
                            'account_type' => $data[14],
                            'account_no' => $data[15],
                            'account_name' => $data[16],
                            'remote_scout_flag' => 0,
                            'user_from_site' => $data_from_site,
                            'display_flag'=> 1,
                            'set_send_mail' => 0,
                            'created_date' => date("y-m-d H:i:s"),
                            'updated_date'=> date("y-m-d H:i:s"),
                            'temp_reg_date'=> date("y-m-d H:i:s"),
                            );
                            $result = $this->Musers->insert_users($user_data);

                            $user_id = $this->Musers->getUserID($uniqueid);
                            if ( !$user_id ){
                                $import_complete  = false;
                                $error_msg = "User IDが取得できません。"." データ番号:".$cnt;
                                break;
                            }
                        }else{
                            // 既に存在しているデータを更新
                            // ID取得
                            $user_id = $this->Musers->getUserIDFromEmail($data[9]);
                            $user_data = array(
                            'name' => $data[8],
                            'birthday'=> $data[11],
                            'profile_pic'=> $data[4],
                            'bust'=> $data[5],
                            'waist'=> $data[6],
                            'hip'=> $data[7],
                            'password' => base64_encode($data[10]),
                            'bank_name' => $data[12],
                            'bank_agency_name' => $data[13],
                            'account_type' => $data[14],
                            'account_no' => $data[15],
                            'account_name' => $data[16],
                            'updated_date'=> date("y-m-d H:i:s"),
                            );
                            $result = $this->Musers->update_User($user_data, $user_id);
                        }

                        // insert into user_recruits
                        if ( !$result ){
                            $import_complete  = false;
                            $error_msg = "Usersテーブルにデータを書き込めません。"." データ番号:".$cnt;
                            break;
                        }
                        // get height id
                        $height_id = $this->Musers->getHeightID($data[1]);
                        if ( !$height_id ){
                            if ( CSV_DEBUG ){
                                $height_id = 3; //155~159
                            }else{
                                $import_complete  = false;
                                $error_msg = "身長の情報が間違っています。"." データ番号:".$cnt;
                                break;
                            }
                        }

                        // get age id
                        $age_id = $this->Musers->getAgeID($data[2]);
                        if ( !$age_id ){
                            if ( CSV_DEBUG ){
                                $age_id = 2; //20~24
                            }else{
                                $import_complete  = false;
                                $error_msg = "年齢の情報が間違っています。"." データ番号:".$cnt;
                                break;
                            }
                        }
                        // get city id
                        $city_id = $this->Musers->getCityID($data[3]);
                        if ( !$city_id ){
                             if ( CSV_DEBUG ){
                                $city_id = 8; //東京
                            }else{
                                $import_complete  = false;
                                $error_msg = "地域の情報が間違っています。"." データ番号:".$cnt;
                                break;
                            }
                        }

                        if ( !$email_exist_flg ){
                            // User_recruitsに新データ追加
                            $ur_data = array(
                                'user_id'   => $user_id,
                                'age_id'    => $age_id,
                                'height_id' => $height_id,
                                'city_id'   => $city_id,
                                'created_date' => date("y-m-d H:i:s"),
                                'display_flag' => 1,
                                );
                            $result = $this->Musers->insert_User_recruits($ur_data);
                        }else{
                            // User_recruits更新
                            $ur_data = array(
                            'age_id'    => $age_id,
                            'height_id' => $height_id,
                            'city_id'   => $city_id,
                            'updated_date' => date("y-m-d H:i:s"),
                            );
                            $result = $this->Musers->update_User_recruits($ur_data, $user_id);
                        }
                        if ( !$result ){
                            $import_complete  = false;
                            $error_msg = "User_recruitsテーブルにデータを書き込めません。"." データ番号:".$cnt;
                            break;
                        }
                    }

                    fclose($file);
                    // Finish transaction
                    if ($this->db->trans_status() === FALSE || $import_complete  == false){
                        $this->db->trans_rollback();
                    }else{
                        $this->db->trans_commit();
                    }
                    if ( $import_complete == true ){
                        redirect($this->_data["module"]."/setting/complete");
                    }else{
                        if ( !$error_msg ){
                            $error_msg =  "インポートエラーです。CSVファイルを再確認してください。";
                        }
                    }
                }
            }
            $data["titlePage"]="ユーザー情報をCSVインポート";
            $data["loadPage"]="setting/user_csv";
            $data["error_msg"] = $error_msg;
            $data["last_reg_date"] = $last_reg_date;
            $this->load->view($this->_data["module"]."/layout/layout", $data);
        }

        /**
        * @author  VJS
        * @name    registerOwnerInfoFromCSV
        * @todo    import owner data from csv
        * @param   none
        * @return  none
        */
        public function registerOwnerInfoFromCSV() {
          $error_msg = ""; // Error message
          $this->load->model('owner/Mowner');
          $this->load->Model("admin/Msearch");
          if($this->input->post("btnCsv")) {
            $fileName = $this->input->post('filename');
            $filePath = base_url().'/public/admin/uploads/csv/'.$fileName;
            $file = fopen($filePath,"r");

            if ( $file ){
                $flag = false;
                $treatments = array();

                // Start transaction
                $this->db->trans_begin();
                $cnt = 0;
                $import_complete = true;
                while(!feof($file)){
                  $data = fgetcsv($file);
                  if ( count($data) != SETTING::OWNER_CSV_CLUMN_NO ){
                    $error_msg = "CSVファイルのデータコラム数は間違っています。ご確認ください。";
                    $import_complete = false;
                    break;
                  }
                  if($flag == 1) {
                    $cnt++;
                    // Check email address
                    if ( !$data[33] ||  $this->Mowner->checkRegisteredEmail($data[33]) ){
                        $import_complete  = false;
                        $error_msg = "メールアドレスは既に登録されています。"." データ番号:".$cnt;
                        break;
                    }
                    //Get default scout mails number
                    $default_scout_no = $this->Mowner->getCommonEmailNoPerDay();
                    if ( !$default_scout_no ){
                        $default_scout_no = 0;
                    }

                    $dataOwner = array(
                      'unique_id' => $this->createUniqueId(),
                      'email_address' => $data[33],
                      'password' => base64_encode('admin'),
                      'storename' => $data[3],
                      'address' => $data[4],
                      'public_info_flag' => 0,
                      'set_send_mail' => 0,
                      'owner_status' => 2,
                      'default_scout_mails_per_day' => $default_scout_no,
                      'remaining_scout_mail' => $default_scout_no,
                      'admin_owner_flag' => 1,
                      'created_date' => date('Y-m-d H:i:s'),
                      'temp_reg_date' => date('Y-m-d H:i:s')
                    );
                    //insert new data to owners
                    $ownerId = $this->Mowner->insertOwner($dataOwner);

                    if ( !$ownerId ){
                        $import_complete  = false;
                        $error_msg = "オーナー情報をＤＢに書き込めません。"." データ番号:".$cnt;
                        break;
                    }
                    //$areaPrefTownIds = $this->Msearch->getAreaPrefTownIds($data[2]);
                    $areaId = $this->Msearch->getAreaId($data[0]);
                    if ( !$areaId ){
                        $import_complete  = false;
                        $error_msg = "エリア大を見つかりません。"." データ番号:".$cnt;
                        break;
                    }
                    $townId = $this->Msearch->getTownId($data[1]);
                    if ( !$townId ){
                        $townId = array(array('id'=>"", 'city_id' =>""));
                    }

                    // Get happy money ID for 0
                    $happy_money_id = $this->Mowner->getZeroHappyMoneyID();
                    if ( !$happy_money_id ){
                        $import_complete  = false;
                        $error_msg = "０円のお祝い金額の設定はありません。"." データ番号:".$cnt;
                        break;
                    }
                    $dataOwnerRecruit = array(
                      'owner_id' => $ownerId,
                      'company_info' => $data[30],
                      'city_group_id' => $areaId[0]['id'],
                      'city_id' => $townId[0]['city_id'],
                      'town_id' => $townId[0]['id'],
                      'title' => $data[2],
                      'happy_money_id' => $happy_money_id,
                      'work_place' => $data[6],
                      'working_day' => $data[7],
                      'working_time' => $data[8],
                      'how_to_access' => $data[9],
                      'salary' => $data[10],
                      'con_to_apply' => $data[11],
                      'apply_time' => $data[31],
                      'apply_tel' => $data[32],
                      'apply_emailaddress' => $data[33],
                      'home_page_url' => $data[34],
                      'recruit_status' => 2,
                      'created_date' => date('Y-m-d H:i:s')
                    );
                    $ownerRecruitId = $this->Mowner->insertOwnerRecruit($dataOwnerRecruit);
                    if ( !$ownerRecruitId ){
                        $error_msg = "オーナー求人情報をＢに書き込めません。"." データ番号:".$cnt;
                        break;
                    }
                    //insert jobtype owner
                    if($data[5] != '') {
                      $jobTypeId = $this->Msearch->getJobTypeId($data[5]);
                      if ( !$jobTypeId ){
                        $import_complete  = false;
                        $error_msg = "業種が見つかりません。"." データ番号:".$cnt;
                        // Error, stop
                        break;
                      }
                      $jobTypeData = array(
                        'owner_recruit_id' => $ownerRecruitId,
                        'job_type_id' => $jobTypeId[0]['id']
                      );
                      $jobTypeOwnerId = $this->Mowner->insertJopTypeOwner($jobTypeData);
                      if ( !$jobTypeOwnerId ){
                        $import_complete  = false;
                        $error_msg = "業種をDBに書き込めません。"." データ番号:".$cnt;
                        // Error, stop
                        break;
                      }
                    }

                    //Insert treatment owner
                    $insert_all_flg = true;
                    for($i=12; $i<=29;$i++) {
                      if($data[$i] == '○') {
                        $treatmentId = $this->Msearch->getTreatmentId($treatments[$i]);
                        if ( !$treatmentId ){
                            $error_msg = "待遇が見つかりません。"." データ番号:".$cnt;
                            //echo $i;
                            $insert_all_flg = false;
                            break;
                        }
                        $treatmentData = array(
                          'owner_recruit_id' => $ownerRecruitId,
                          'treatment_id' => $treatmentId[0]['id']
                        );
                        $treatmentOwnerID = $this->Mowner->insertTreatmentOwner($treatmentData);
                        if ( !$treatmentOwnerID ){
                            $error_msg = "待遇情報をDBに書き込めません。"." データ番号:".$cnt;
                            $insert_all_flg = false;
                            break;
                        }
                      }
                    }
                    // If not all treatment data are inserted succefully
                    if ( $insert_all_flg == false ){
                        $import_complete  = false;
                        break;
                    }
                  }
                  else {
                    for($i=12; $i<=29; $i++) {
                      $treatments[$i] = $data[$i];
                    }
                  }
                  $flag = true;
                }
                fclose($file);

                // Finish transaction
                if ($this->db->trans_status() === FALSE || $import_complete  == false){
                    $this->db->trans_rollback();
                }else{
                    $this->db->trans_commit();
                }
                if ( $import_complete == true ){
                    redirect($this->_data["module"]."/setting/complete");
                }else{
                    if ( !$error_msg ){
                        $error_msg =  "インポートエラーです。CSVファイルを再確認してください。";
                    }
                }
            }
          }
          $data["titlePage"]="オーナー情報をCSVインポート";
          $data["loadPage"]="setting/csv";
          $data["error_msg"] = $error_msg;
          $this->load->view($this->_data["module"]."/layout/layout", $data);
        }

        public function createUniqueId()
        {
          $this->load->model('owner/Mowner');
          $flag = true;
          $uniqueId = '';
          while($flag)
          {
            $uniqueId = Ultilities::random('alpha',8);
            $uniqueIdData = $this->Mowner->checkUniqueId($uniqueId);

            if($uniqueIdData['countId'] == 0)
            {
              $flag = false;
            }
          }
          return $uniqueId;
        }

        public function complete(){
          $this->_data["loadPage"]="setting/csv_complete";
          $this->_data["titlePage"]="joyspe管理画面";
          $this->load->view($this->_data["module"]."/layout/layout",$this->_data);
        }
        public function scoutMailQtySendPerDay() {
          $this->load->model('owner/Mowner');
          $value = $this->Mowner->getScoutMailQtySendPerDay();
          if(!isset($value['common_email_no_per_day'])) {
              $data['common_email_no_per_day'] = 1;
          } else {
            $data['common_email_no_per_day'] = $value['common_email_no_per_day'];
          }
          $message = '';
          if($_POST) {
            $this->load->library("form_validation");
            $this->form_validation->set_rules('commonEmailNoPerDay', '1日スカウト送信数', 'required');
            $form_validation = $this->form_validation->run();
            $data['common_email_no_per_day']  = $this->input->post('commonEmailNoPerDay');
            $this->message['success'] = !$form_validation && count($_POST) > 0 ? FALSE : TRUE;
            if($this->form_validation->run()==false){
              $data['message']= $this->message;
            }
            else {
              $scQty = $this->input->post('commonEmailNoPerDay');
              $commonEmailNoPerDay = $this->input->post('commonEmailNoPerDay');
              $this->Mowner->inactiveScoutMailQty(array('display_flag' => 0));
              $this->Mowner->insertScoutMailQty(array('common_email_no_per_day' => $commonEmailNoPerDay));
              $this->Mowner->setDefaultScoutMailQtyToOwners(array('default_scout_mails_per_day' => $scQty, 'remaining_scout_mail' => $scQty));
              $message = 'スカウト送信数設定が完了しました。';
            }
          }
          $data["loadPage"]="setting/scoutMailQtySendPerDay";
          $data['alert'] = $message;
          $data['message'] = $this->message;
          $data["titlePage"]="スカウト送信数";
          $this->load->view($this->_data["module"]."/layout/layout", $data);
        }

        public function scoutPoints() {
          $this->load->model('owner/Mowner');
          $value = $this->Mowner->getScoutPoint();
          if(!isset($value['point'])) {
              $data['point'] = 0;
          } else {
            $data['point'] = $value['point'];
          }
          $message = '';
          if($_POST) {
            $this->load->library("form_validation");
            $this->form_validation->set_rules('scoutPoint', 'スカウトポイント', 'required|greater_than[-1]|is_natural|numeric');
            $form_validation = $this->form_validation->run();
            $data['point']  = $this->input->post('scoutPoint');
            $this->message['success'] = !$form_validation && count($_POST) > 0 ? FALSE : TRUE;
            if($this->form_validation->run()==false){
              $data['message']= $this->message;
            }
            else {
              $spValue = $this->input->post('scoutPoint');
              $this->Mowner->inactiveCurrentScoutPoint(array('display_flag' => 0));
              $this->Mowner->insertScoutPoint(array('point' => $spValue, 'created_date' => date("Y-m-d-H-i-s")));
              $message = 'スカウトポイントの設定が完了です';
            }
          }
          $data["loadPage"]="setting/scoutPoint";
          $data['alert'] = $message;
          $data['message'] = $this->message;
          $data["titlePage"]="スカウトポイント設定";
          $this->load->view($this->_data["module"]."/layout/layout", $data);
        }
        // ＩＰアドレス制限
        public function limitIP(){
            $this->load->model('admin/Mipaddress');
            if ( $mode = $this->input->post("mode") ){
                $this->load->library('form_validation');
                if ( $mode == 'add' ){
                    $ip_address = $this->input->post('ip_address');
                    $this->form_validation->set_rules('ip_address',"IPアドレス","trim|required|callback_checkip");
                    $this->form_validation->set_rules('note',"メモ","trim|max_length[100]");
                    if ( $this->form_validation->run() == true ){
                        $note = $this->input->post('note');
                        $this->Mipaddress->addAccessableIP($ip_address,$note);
                        $this->_data["add_success_flag"] = true;
                    }
                }else if ( $mode == 'change'){
                    $ip_id = $this->input->post('ip_id');
                    $this->form_validation->set_rules('ip_address_'.$ip_id,"IPアドレス","trim|required|callback_checkip");
                    $this->form_validation->set_rules('note_'.$ip_id,"メモ","trim|max_length[100]");
                    //$this->form_validation->set_rules('active_flag_'.$ip_id,"アクティブフラグ","trim|required");
                    if ( $this->form_validation->run() == true ){
                        $ip_address = $this->input->post('ip_address_'.$ip_id);
                        $note = $this->input->post('note_'.$ip_id);
                        $active_flg = $this->input->post('active_flag_'.$ip_id);
                        $disable_flg = 1;
                        if ( $active_flg ){
                            $disable_flg = 0;
                        }
                        $this->Mipaddress->updateIP($ip_id, $ip_address,$note, $disable_flg);
                    }else{
                        $this->_data["error_ip_id"] = $ip_id;
                    }
                }
            }
            $allow_ip_list = $this->Mipaddress->getIPList();
            $this->_data["allow_ip_list"] = $allow_ip_list;
            $this->_data["titlePage"]= "管理画面アクセスＩＰ制限";
            $this->_data["loadPage"] = "setting/limitip";
            $this->load->view($this->_data["module"]."/layout/layout",$this->_data);
        }
        public function checkip($ip_address){
            $check_ip = FormValidator::is_ip($ip_address);
            if ( !$check_ip ){
                $this->form_validation->set_message('checkip', '入力された%sは無効なＩＰアドレスです。');
            }
            return $check_ip;
        }
        public function newsPoints(){
          $this->load->model('admin/msetting');
          $value = $this->msetting->getNewsPoints();
          if(!isset($value['point'])) {
              $data['point'] = 0;
          } else {
            $data['point'] = $value['point'];
          }
          $message = '';
          if($_POST) {
            $this->load->library("form_validation");
            $this->form_validation->set_rules('newsPoint', 'メルマガポイント', 'required|greater_than[-1]|is_natural|numeric');
            $form_validation = $this->form_validation->run();
            $data['point']  = $this->input->post('newsPoint');
            $this->message['success'] = !$form_validation && count($_POST) > 0 ? FALSE : TRUE;
            if($this->form_validation->run()==false){
              $data['message']= $this->message;
            }
            else {
              $npValue = $this->input->post('newsPoint');
              $this->msetting->inactiveNewsPoint(array('display_flag' => 0));
              $this->msetting->insertNewsPoint(array('point' => $npValue, 'created_date' => date("Y-m-d-H-i-s")));
              $message = 'メールマガポイントの設定が完了です。';
            }
          }
          $data["loadPage"]="setting/news_point";
          $data['alert'] = $message;
          $data['message'] = $this->message;
          $data["titlePage"]="メールマガポイント設定";
          $this->load->view($this->_data["module"]."/layout/layout", $data);

        }

        public function makia_login_bonus() {
            if ( $this->input->post() ) {
                redirect(base_url() . "admin/setting/create_new_makia_login_bonus");
            }
            $this->load->Model("admin/Msetting");
            $this->_data['makia_login_bonus'] = $makia_login_bonus = $this->Msetting->getMakiaLoginBonus();
            if ( count($makia_login_bonus) > 0 ) {
                $this->_data["created_date"]  = date_create($makia_login_bonus[0]['created_date']);
            }
            $this->_data["loadPage"]  = "setting/makia_login_bonus";
            $this->_data["titlePage"] = "累計ログインポイント設定";
            $this->load->view($this->_data["module"]."/layout/layout", $this->_data);
        }

        public function create_new_makia_login_bonus() {
            $this->load->Model("admin/Msetting");
            if ($this->input->post() ) {
                $no_of_days_arr = array();
                $bonus_point_arr = array();
                $add_error_messages = array();
                $no_input = true;
                for ( $i = 0; $i<10; $i++ ) {
                    $i_inc = $i + 1;
                    $no_of_days = "no_of_days".$i_inc;
                    $bonus_point = "bonus_point".$i_inc;
                    if ( $this->input->post($no_of_days) ) {
                        $no_of_days_arr[$i] = $this->input->post($no_of_days);
                    }
                    else {
                        $no_of_days_arr[$i] = "";
                    }
                    if ( $this->input->post($bonus_point) ) {
                        $bonus_point_arr[$i] = $this->input->post($bonus_point);
                    }
                    else {
                        $bonus_point_arr[$i] = "";
                    }
                    if ( $no_of_days_arr[$i] )  {
                        $no_input = false;
                        $this->form_validation->set_rules($no_of_days, '日数 '.$i_inc, 'trim|required|greater_than[0]');
                        $this->form_validation->set_rules($bonus_point, 'ボーナス '.$i_inc,'trim|required|greater_than[0]');
                        $validation = $this->form_validation->run();
                    }
                    if ( $this->input->post('no_of_days'.$i) ) {
                        $b_no_of_days = $this->input->post('no_of_days'.$i);
                        if( $i > 0 && $no_of_days_arr[$i] <= $b_no_of_days && $no_of_days_arr[$i] != '' ) {
                            $add_error_messages[] = "条件".$i_inc."の日数は条件".$i."日数より大きくなければならない。";
                        }
                    }
                }
                if ( $no_input ) {
                    $add_error_messages[] = "マキヤログインボーナスをご入力ください。";
                }
                $this->_data["no_of_days_arr"] = $no_of_days_arr;
                $this->_data["bonus_point_arr"] = $bonus_point_arr;
                if ( count($add_error_messages) > 0 ) {
                    $this->_data["add_error_messages"] = $add_error_messages;
                }
                if ( $this->form_validation->run() && count($add_error_messages) == 0 ) {
                    $this->Msetting->deleteMakiaLoginBonus();
                    for ( $i = 1; $i<11; $i++ ) {
                        if ($this->input->post('no_of_days'.$i) && $this->input->post('bonus_point'.$i)) {
                            $login_bonus_data = array(
                              'condition_no' => $i,
                              'number_of_days' => $this->input->post('no_of_days'.$i),
                              'bonus_point' => $this->input->post('bonus_point'.$i),
                              'created_date' => date('Y-m-d H:i:s')
                            );
                            $makia_login_bonus_flag = $this->Msetting->createNewMakiaLoginBonus($login_bonus_data);
                        }
                    }
                    redirect(base_url() . "admin/setting/makia_login_bonus");
                }

            }
            $this->_data["loadPage"]  = "setting/create_new_makia_login_bonus";
            $this->_data["titlePage"] = "累計ログインポイント設定";
            $this->load->view($this->_data["module"]."/layout/layout", $this->_data);
        }

        public function monthly_campaign_result_ads() {
            $this->load->Model("admin/Msetting");
            $this->_data["months"] = $this->getMonths();
            if ( $this->input->post() ) {
                $month = $this->input->post('mcra-month');
                $tetp_money = $this->input->post('tetp-money');
                $twtp_money = $this->input->post('twtp-money');
                $this->_data["month"] = $month;
                $this->_data["tetp_money"] = $tetp_money;
                $this->_data["twtp_money"] = $twtp_money;
                $this->form_validation->set_rules('mcra-month', '月度 ', 'required');
                $this->form_validation->set_rules('tetp-money', '面接交通費 ', 'trim|required|greater_than[0]');
                $this->form_validation->set_rules('twtp-money', '入店お祝い金 ', 'trim|required|greater_than[0]');
                if ($this->form_validation->run()) {
                    $this->Msetting->deleteMonthlyCampaignResultAds();
                    $data = array(
                        'month' => $month,
                        'travel_expense_total_paid_money' => $tetp_money,
                        'trial_work_total_paid_money' => $twtp_money
                    );
                    $mcra_flag = $this->Msetting->createMonthlyCampaignResultAds($data);
                    if ($mcra_flag) {
                        $this->_data["save_message"] = "月度キャンペーンの結果広告は正常に保存されました。";
                    }
                }
            } else {
                $data = $this->Msetting->getMonthlyCampaignResultAds();
                $this->_data["month"] = isset($data['month'])?$data['month']:'';
                $this->_data["tetp_money"] = isset($data['travel_expense_total_paid_money'])?$data['travel_expense_total_paid_money']:'';
                $this->_data["twtp_money"] = isset($data['trial_work_total_paid_money'])?$data['trial_work_total_paid_money']:'';
            }
            $this->_data["loadPage"]  = "setting/monthly_campaign_result_ads";
            $this->_data["titlePage"] = "月度キャンペーンの結果広告";
            $this->load->view($this->_data["module"]."/layout/layout", $this->_data);
        }

        public function getMonths() {
            $months = array();
            for ($i = 1 ; $i <= 12; $i++) {
                $months[$i] = $i . "月";
            }
            return $months;
        }
        
        public function disableCampaignAd() {
            $this->load->Model("admin/Msetting");
            $this->Msetting->deleteMonthlyCampaignResultAds();
        }
    }
?>

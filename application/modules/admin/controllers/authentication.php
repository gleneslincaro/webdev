<?php
  class Authentication extends MX_Controller{
        protected $_data;
        protected $_dataResult;
        private $common;
        private $message = array('success' => true, 'error' => array());
        public function __construct() {
            parent::__construct();
            AdminControl::CheckLogin();            
            $this->_data["module"] = $this->router->fetch_module();
            $this->common = new Common();
            $this->output->set_header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
            $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate");
            $this->output->set_header("Cache-Control: post-check=0, pre-check=0");
            $this->output->set_header("Pragma: no-cache");
        }
     /**
	 * @author  [IVS] Nguyen Minh Ngoc
	 * @name     fixname
	 * @todo     fix name when upload file
	 * @param    $str	
	 * @return 	
	*/
        public function fixname($str){
            $str=str_replace(array(" ","_","/","@","#","$","%","^","&","*",")","(","-"),"",$str);
            return $str;
           }
           /**
	 * @author  [IVS] Nguyen Minh Ngoc
	 * @name     lists
	 * @todo     list watting approve ownner
	 * @param    
	 * @return 	
	*/
         public function lists(){
            $start = 0;
            
            $this->load->Model("admin/Mauthentication");           
            //get totalRows
            $countRows = $this->Mauthentication->countPaymentMethods();
            
            //init config to paging
            $config['base_url'] = base_url().'admin/authentication/lists';
            $config['total_rows'] = $countRows;
            $config['constant_num_links'] = TRUE;
            $config['uri_segment']=4;
            $config["per_page"]=$this->config->item('per_page');
            $this->load->library("pagination",$config);
            $this->pagination->initialize($config);
            
            //start1 has value after clicking paging link 
            $start1 = $this->uri->segment(4);
            if($start1!=NULL) 
                $start=$start1;
            
            $this->_dataResult =$this->Mauthentication->listPaymentMethods($config['per_page'], $start);
            
            $this->_data["data_search"] = $this->_dataResult;
            $this->_data["countRows"] = $countRows;
            $this->_data["loadPage"]="authentication/list";
            $this->_data["titlePage"]="承認一覧";
            $this->load->view($this->_data["module"]."/layout/layout",$this->_data);
        }
        /**
         * author: [IVS] Phan Van Thuyet
         * name : listProfile
         * todo : list profile
         * @param null
         * @return null
         */
        public function listProfile(){
            $this->load->Model('admin/Mauthentication');            
            $this->_data["loadPage"]="authentication/list_profile";
            $this->_data["titlePage"]="承認・詳細";
            $id=$this->uri->segment(4);
            $this->_data["owner_id"] = $id;
            $this->_data["owinfo"]=$this->Mauthentication->listProfile($id);
            if($id=="" || empty( $this->_data["owinfo"])){
                 redirect(base_url()."admin/system/errorPage");
            }
            
            $this->load->view($this->_data["module"]."/layout/layout",$this->_data);
            
        }
        /**
         * author: [IVS] Nguyen Minh Ngoc
         * name : listProfile01
         * todo : list profile
         * @param null
         * @return null
         */
        public function listProfile01(){
            $this->load->Model('admin/Mauthentication');            
            $this->_data["loadPage"]="authentication/list_profile01";
            $this->_data["titlePage"]="承認・詳細";
            $id=$this->uri->segment(4);
            $this->_data["owner_id"] = $id;
            $this->_data["owinfo"]=$this->Mauthentication->listProfile($id);
            if($id=="" || empty( $this->_data["owinfo"])){
                 redirect(base_url()."admin/system/errorPage");
            }
            $this->load->view($this->_data["module"]."/layout/layout",$this->_data);
            
        }
        /**
         * author: [IVS] Nguyen Minh Ngoc
         * name : ok_Profile01
         * todo : ok profile
         * @param null
         * @return null
         */
        public function ok_Profile01(){
            $this->load->Model("admin/Mauthentication");
            $this->_data["loadPage"]="authentication/ok_profile01";
            $this->_data["titlePage"]="joyspe管理画面";
            $id=$this->uri->segment(4);
            $this->_data["owinfo"]=$this->Mauthentication->showProfile03($id);
            if($id=="" || empty( $this->_data["owinfo"])){
                 redirect(base_url()."admin/system/errorPage");
            }
            //
            //get current time
            $time = date("Y-m-d-H-i-s");
            //
            //
            if($this->input->post("btnupow")){
                $this->form_validation->set_rules('txtstorename', '店舗名', 'trim|required|max_length[100]');
                $this->form_validation->set_rules('txtpic', '求人担当', 'trim|required|max_length[100]');
                $this->form_validation->set_rules('txtcominfo', '会社情報', 'trim|required|max_length[400]');
                $this->form_validation->set_rules('txtstation', '最寄駅', 'trim|required|max_length[100]');
                $this->form_validation->set_rules('txtworkingstyle', '出勤スタイル', 'trim|required|max_length[140]');
                $this->form_validation->set_rules('txternote', 'スタッフ記入欄', 'trim|max_length[10000]');
                $form_validation = $this->form_validation->run();
                $this->message['success'] = !$form_validation && count($_POST) > 0 ? FALSE : TRUE;         
                if ($form_validation==false) {
                     $this->_data['message']= $this->message;
                      $this->_data["cc"]="true";
                }else{    
                    $this->_data["flag"]="true";
                    $this->_data["store"]=$this->input->post("txtstorename");
                    $this->_data["pic"]=$this->input->post("txtpic");
                    $this->_data["info"]=$this->input->post("txtcominfo");
                    $this->_data["station"]=$this->input->post("txtstation");
                    $this->_data["stylework"]=$this->input->post("txtworkingstyle");
                    $this->_data["ernote"]=$this->input->post("txternote");
                    $this->_data["image1"]=$_POST['hdImage1'];
                    $this->_data["image2"]=$_POST['hdImage2'];
                    $this->_data["image3"]=$_POST['hdImage3'];
                    $this->_data["image4"]=$_POST['hdImage4'];
                    $this->_data["image5"]=$_POST['hdImage5'];
                    $this->_data["image6"]=$_POST['hdImage6'];
                    $this->_data["main"]=$this->input->post("sltmainimg");
                }
            }  
            //
            $this->load->view($this->_data["module"]."/layout/layout",$this->_data);
        }
       /**
         * author: [IVS] Nguyen Minh Ngoc
         * name : updateOk_Profile01
         * todo : update owner profile
         * @param null
         * @return null
         */
       public function updateOk_Profile01(){
             $this->load->Model("admin/Mauthentication");
            //get current time
            $time = date("Y-m-d-H-i-s");
            $id=$this->input->post("txtowid");
            $rid=$this->input->post("id");
            $store=$this->input->post("txtstorename");
            $pic=$this->input->post("txtpic");
            $info=$this->input->post("txtcominfo");
            $station=$this->input->post("txtstation");
            $stylework=$this->input->post("txtworkingstyle");
            $ernote=$this->input->post("txternote");
            $image1=$_POST['hdImage1'];
            $image2=$_POST['hdImage2'];
            $image3=$_POST['hdImage3'];
            $image4=$_POST['hdImage4'];
            $image5=$_POST['hdImage5'];
            $image6=$_POST['hdImage6'];
            $main=$this->input->post("txtmainimg");
            $this->Mauthentication->updateOW01($id,$store,$pic,$info,$station,$stylework,$ernote,$image1,$image2,$image3,$image4,
                    $image5,$image6,$main,$time,$rid);
            
            //Upload file

            $set=$this->Mauthentication->showProfile($rid);
            $fname = $id;
            for ($i = 1; $i <= 6; $i++) {
                if (!empty($_POST['hdImage' . $i])) {
                    echo $_POST['hdImage'];
                    $this->fileUpload($_POST['hdImage' . $i],$fname);
                }
            }
            $this->deleteFolder2($fname);
       }
            /**
         * author: [IVS] Nguyen Minh Ngoc
         * name : ok_Profile
         * todo : approve owner profile
         * @param null
         * @return null
         */
       public function ok_Profile(){
            $this->load->Model("admin/Mauthentication");
            $this->_data["loadPage"]="authentication/ok_profile";
            $this->_data["titlePage"]="joyspe管理画面";
            $id=$this->uri->segment(4);
            $this->_data["owinfo"]=$this->Mauthentication->showProfile($id);
            if($id=="" || empty( $this->_data["owinfo"])){
                 redirect(base_url()."admin/system/errorPage");
            }
            //get current time
            $time = date("Y-m-d-H-i-s");
            //
            //
            if($this->input->post("btnupow")){
                $this->form_validation->set_rules('txtstorename', '店舗名', 'trim|required|max_length[100]');
                $this->form_validation->set_rules('txtpic', '求人担当', 'trim|required|max_length[100]');
                $this->form_validation->set_rules('txtcominfo', '会社情報', 'trim|required|max_length[400]');
                $this->form_validation->set_rules('txtstation', '最寄駅', 'trim|required|max_length[100]');
                $this->form_validation->set_rules('txtworkingstyle', '出勤スタイル', 'trim|required|max_length[140]');
                $this->form_validation->set_rules('txternote', 'スタッフ記入欄', 'trim|max_length[10000]');
                $form_validation = $this->form_validation->run();
                $this->message['success'] = !$form_validation && count($_POST) > 0 ? FALSE : TRUE;         
                if ($form_validation==false) {
                     $this->_data['message']= $this->message;
                     $this->_data["cc"]="true";
                }else{    
                    $this->_data["flag"]="true";
                    $this->_data["store"]=$this->input->post("txtstorename");
                    $this->_data["pic"]=$this->input->post("txtpic");
                    $this->_data["info"]=$this->input->post("txtcominfo");
                    $this->_data["station"]=$this->input->post("txtstation");
                    $this->_data["stylework"]=$this->input->post("txtworkingstyle");
                    $this->_data["ernote"]=$this->input->post("txternote");
                    $this->_data["image1"]=$_POST['hdImage1'];
                    $this->_data["image2"]=$_POST['hdImage2'];
                    $this->_data["image3"]=$_POST['hdImage3'];
                    $this->_data["image4"]=$_POST['hdImage4'];
                    $this->_data["image5"]=$_POST['hdImage5'];
                    $this->_data["image6"]=$_POST['hdImage6'];
                    $this->_data["main"]=$this->input->post("sltmainimg");
                }
            }   
            //
            $this->load->view($this->_data["module"]."/layout/layout",$this->_data);
        }
        /**
         * author: [IVS] Nguyen Minh NGoc
         * name : fileUploadAjx
         * todo : upload file into folder temp
         * @param null
         * @return null
         */
        public function fileUploadAjx() {
            $path = $this->config->item('upload_owner_dir') . '/tmp/';
            if (!is_dir($path)) {
                mkdir($path);
            }
            $id=$_POST["id"];
            $this->load->Model("admin/Mauthentication");
            $path = $this->config->item('upload_owner_dir') . '/tmp/';
            $this->_data["owinfo"]=$this->Mauthentication->showProfile($id);
            foreach ($this->_data["owinfo"] as $k=>$w){
                $fname =$w["wid"];
               
            }
            $this->folderName = $fname;
            if (!is_dir($path . $this->folderName)) {
                mkdir($path . $this->folderName);
            }
            $config["file_name"]=$this->fixname($_FILES['flUpload']['name']);
            $config['upload_path'] = $path . $this->folderName;
            $config['allowed_types'] = 'jpeg|jpg|png';
            $config['max_size'] = 4096;    
            //$config['overwrite'] = true;
            $this->load->library('upload', $config);
            if (!$this->upload->do_upload("flUpload")) {
                $array = array('error' => substr($this->upload->display_errors(), 3,  strlen($this->upload->display_errors() ) - 7)) ;
                echo json_encode($array);
                die;
            } else {
                $config['image_library'] = 'gd2';
                $config['source_image'] = $path.$this->folderName.'/'.$this->fixname($_FILES['flUpload']['name']);
                $config['maintain_ratio'] = FALSE;
                $config['height'] = "300";
                $config['width'] = "400";
                $this->load->library('image_lib', $config);
                $this->image_lib->resize();
                $array = array('url' => base_url() . $this->config->item('upload_owner_url') . 'tmp/' . $this->folderName . '/' . $this->fixname($_FILES['flUpload']["name"]), 'fileName' => $this->folderName . '/' .  $this->fixname($_FILES['flUpload']["name"]));
                echo json_encode($array);
                die;
            }
        }
        /**
         * author: [IVS] Nguyen Minh NGoc
         * name : fileUploadAjx2
         * todo : upload file into folder temp
         * @param null
         * @return null
         */
        public function fileUploadAjx2() {
            $path = $this->config->item('upload_owner_dir') . '/tmp/';
            if (!is_dir($path)) {
                mkdir($path);
            }
            $id=$_POST["id"];
            $this->load->Model("admin/Mauthentication");
            $path = $this->config->item('upload_owner_dir') . '/tmp/';
            $this->_data["owinfo"]=$this->Mauthentication->showProfile2($id);
            foreach ($this->_data["owinfo"] as $k=>$w){              
               $fname =$w["wid"];
            }
            $this->folderName = $fname;
            if (!is_dir($path . $this->folderName)) {
                mkdir($path . $this->folderName);
            }
            $config["file_name"]=$this->fixname($_FILES['flUpload']['name']);
            $config['upload_path'] = $path . $this->folderName;
            $config['allowed_types'] = 'jpeg|jpg|png';
            $config['max_size'] = 4096;    
            $config['overwrite'] = true;
            $this->load->library('upload', $config);
            if (!$this->upload->do_upload("flUpload")) {
                $array = array('error' => substr($this->upload->display_errors(), 3,  strlen($this->upload->display_errors() ) - 7)) ;
                echo json_encode($array);
                die;
            } else {
                $fn = $_FILES['flUpload']['tmp_name'];        
                $size = getimagesize($fn);
                $ratio = $size[0]/$size[1]; // width/height      
                $config['image_library'] = 'gd2';
                $config['source_image'] = $path.$this->folderName.'/'.$this->fixname($_FILES['flUpload']['name']);
                $config['maintain_ratio'] = FALSE;
                $config['width'] = 350;
                $config['height'] = 350/$ratio;
                $this->load->library('image_lib', $config);
                $this->image_lib->resize();

                $array = array('url' => base_url() . $this->config->item('upload_owner_url') . 'tmp/' . $this->folderName . '/' . $this->fixname($_FILES['flUpload']["name"]), 'fileName' => $this->folderName . '/' . $this->fixname($_FILES['flUpload']["name"]));
                echo json_encode($array);
                die;
            }
        }
        // Upload csv file
        public function fileUploadAjx3() {
          $path = $this->config->item('upload_dir') . 'csv/';
          if (!is_dir($path)) {
            mkdir($path, 0777, TRUE);
          }
          $date = date('YmdHis', time());
          $config["file_name"]  = $date."_".$this->fixname($_FILES['flUpload']['name']);
          $config['upload_path'] = $path;
          $config['allowed_types'] = 'csv';
          $config['overwrite'] = true;
          $this->load->library('upload', $config);
          if (!$this->upload->do_upload("flUpload")) {
            $array = array('error' => substr($this->upload->display_errors(), 3,  strlen($this->upload->display_errors() ) - 7)) ;
            echo json_encode($array);
            die;
          }
          else {
            $filePath = base_url().'/public/admin/uploads/csv/'.$config["file_name"];
            $file = fopen($filePath,"r");
            $cnt = 0;
            $error = null;
            while(!feof($file)){
              if(fgetcsv($file))
                $cnt++;
              if($cnt > 100000) {
                $error = 'CSVファイルが大きすぎです。';
                break;
              }
            }
            $array = array('error' => $error, 'fixName' => $config["file_name"]);
            echo json_encode($array);
            die;  
          }
        }
        
        
        
        
            /**
         * author: [IVS] Nguyen Minh Ngoc
         * name : fileUpload
         * todo : upload image into folder images
         * @param null
         * @return null
         */
        public function fileUpload($fileName,$fname) {

            $path = $this->config->item('upload_owner_dir') . '/images/';

            $this->folderName = $fname;

            if (!is_dir($path . $this->folderName)) {
                mkdir($path . $this->folderName);
            }
            $this->tmpPath = $this->config->item('upload_owner_dir') . '/tmp/';

            copy($this->tmpPath . '/' . $fileName, $path . '/' .$fileName);
        }

        /**
         * author: [IVS] Nguyen Minh Ngoc
         * name : deleteFolder
         * todo : delete folder in tmp folder
         * @param null
         * @return null
         */
      public function deleteFolder2($fname) {
        
        $this->load->helper("file");

        $this->tmpPath = $this->config->item('upload_owner_dir') . '/tmp/';

        $this->folderName = $fname;

        if (is_dir($this->tmpPath . $this->folderName)) {

            delete_files($this->tmpPath . $this->folderName, true);
            rmdir($this->tmpPath . $this->folderName);
        }
    } 
        /**
	 * @author  [IVS] Nguyen Hoai Nam
	 * @name 	history
	 * @todo 	load page
	 * @param 	
	 * @return 	
	*/
        public function history(){
            $this->_data["email"] = null;
            $this->_data["name"] = null;
            $this->_data["dateFrom"] = null;
            $this->_data["dateTo"] = null;
            $this->_data["info"] = null;
            $this->_data["sum"] = 0;
            $this->_data["flag"] = 0;
            $this->load->Model("admin/Mauthentication");
            $this->_data["loadPage"] = "authentication/history";
            $this->_data["titlePage"] = "承認履歴";
            $this->load->view($this->_data["module"]."/layout/layout",$this->_data);
        }
        /**
	 * @author  [IVS] Nguyen Hoai Nam
	 * @name 	searchOwnerApprovedAfter
	 * @todo 	search owner information approved
	 * @param 	
	 * @return 	
	*/
        public function searchOwnerApprovedAfter(){
            $email = null;
            $name = null;
            $dateFrom = null;
            $dateTo = null;
            if(isset($_POST["txtOwnerEmail"])){
                $email = trim($this->input->post('txtOwnerEmail'));
            }
            if(isset($_POST["txtOwnerName"])){
                $name = trim($this->input->post('txtOwnerName'));
            }
            if(isset($_POST["txtDateFrom"])){
                $dateFrom = trim($this->input->post('txtDateFrom'));
            }
            if(isset($_POST["txtDateTo"])){
                $dateTo = trim($this->input->post('txtDateTo'));
            }
            $this->_data["email"] = $email;
            $this->_data["name"] = $name;
            $this->_data["dateFrom"] = $dateFrom;
            $this->_data["dateTo"] = $dateTo;
            $this->_data["flag"] = 1;
            $start = 0;
            $this->load->Model("admin/Mauthentication");
            $sql = $this->Mauthentication->getSearchOwnerApprovedQuery($email, $name, $dateFrom, $dateTo);
            //get totalRows
            $countRows  = $this->Mauthentication->countDataByQuery($sql);
            //init config to paging
            $config['base_url'] = base_url().'admin/authentication/searchOwnerApprovedAfter';
            $config['total_rows'] = $countRows;
            $config['constant_num_links'] = TRUE;
            $config['uri_segment']=4;
            $config["per_page"]=$this->config->item('per_page');
            $this->load->library("pagination",$config);
            $this->pagination->initialize($config);
            //start1 has value after clicking paging link 
            $start1 = $this->uri->segment(4);
            if($start1 != ""){
                $start = $start1;
            }
            //data_info show data with paging
            $this->_data["info"] = $this->Mauthentication->getResultSearchOwnerApproved($sql, $config['per_page'], $start); 
            $this->pagination->create_links();
            
            $this->_data["sum"] = $countRows;
            $this->_data["loadPage"] = "authentication/history";
            $this->_data["titlePage"] = "承認履歴";
            //paging by ajax
            if($this->input->post('ajax')!=null){
               $this->load->view("authentication/history",$this->_data);    
            }else{
                $this->load->view($this->_data["module"]."/layout/layout",$this->_data);   
            }
        }
        /**
	 * @author  [IVS] Nguyen Hoai Nam
	 * @name 	unapproved
	 * @todo 	load page
	 * @param 	
	 * @return 	
	*/
        public function unapproved(){
            $this->_data["email"] = null;
            $this->_data["name"] = null;
            $this->_data["dateFrom"] = null;
            $this->_data["dateTo"] = null;
            $this->_data["info"] = null;
            $this->_data["sum"] = 0;
            $this->_data["flag"] = 0;
            $this->load->Model("admin/Mauthentication");
            $this->_data["loadPage"] = "authentication/unapproved";
            $this->_data["titlePage"] = "非認証一覧";
            $this->load->view($this->_data["module"]."/layout/layout",$this->_data);
        }
        /**
	 * @author  [IVS] Nguyen Hoai Nam
	 * @name 	searchOwnerUnapprovedAfter
	 * @todo 	search owner information unapproved
	 * @param 	
	 * @return 	
	*/
        public function searchOwnerUnapprovedAfter(){
            $email = null;
            $name = null;
            $dateFrom = null;
            $dateTo = null;
            if(isset($_POST["txtOwnerEmail"])){
                $email = $_POST["txtOwnerEmail"];
            }
            if(isset($_POST["txtOwnerName"])){
                $name = $_POST["txtOwnerName"];
            }
            if(isset($_POST["txtDateFrom"])){
                $dateFrom = $_POST["txtDateFrom"];
            }
            if(isset($_POST["txtDateTo"])){
                $dateTo = $_POST["txtDateTo"];   
            }
            $this->_data["email"] = $email;
            $this->_data["name"] = $name;
            $this->_data["dateFrom"] = $dateFrom;
            $this->_data["dateTo"] = $dateTo;
            $this->_data["flag"] = 1;
            $start = 0;
            $this->load->Model("admin/Mauthentication");
            $sql = $this->Mauthentication->getSearchOwnerUnapprovedQuery($email, $name, $dateFrom, $dateTo);
            //get totalRows
            $countRows  = $this->Mauthentication->countDataByQuery($sql);
            //init config to paging
            $config['base_url'] = base_url().'admin/authentication/searchOwnerUnapprovedAfter';
            $config['total_rows'] = $countRows;
            $config['constant_num_links'] = TRUE;
            $config['uri_segment']=4;
            $config["per_page"]=$this->config->item('per_page');
            $this->load->library("pagination",$config);
            $this->pagination->initialize($config);
            //start1 has value after clicking paging link 
            $start1 = $this->uri->segment(4);
            if($start1 != ""){
                $start = $start1;
            }
            //data_info show data with paging
            $this->_data["info"] = $this->Mauthentication->getResultSearchOwnerUnapproved($sql, $config['per_page'], $start); 
            $this->pagination->create_links();
            
            $this->_data["sum"] = $countRows;
            $this->_data["loadPage"] = "authentication/unapproved";
            $this->_data["titlePage"] = "非認証一覧";
            //paging by ajax
            if($this->input->post('ajax')!=null){
               $this->load->view("authentication/unapproved",$this->_data);    
            }else{
                $this->load->view($this->_data["module"]."/layout/layout",$this->_data);   
            }
        }
        /**
	 * @author  [IVS] Nguyen Hoai Nam
	 * @name 	nonProfileUnapproved
	 * @todo 	load page
	 * @param 	
	 * @return 	
	*/
        public function nonProfileUnapproved(){
            $ownerId = $this->uri->segment(4);
            $this->load->Model("admin/Mauthentication");
            $ownerInfo = $this->Mauthentication->getOwnerInfoById($ownerId);
            $this->_data["ownerInfo"] = $ownerInfo;
            $this->_data["loadPage"] = "authentication/non_profile_unapproved";
            $this->_data["titlePage"] = "認証一覧・プロフィール非認証";
            $this->load->view($this->_data["module"]."/layout/layout",$this->_data);
        }
       /**
         * author: [IVS] Nguyen Minh Ngoc
         * name : a_complete
         * todo : show note complete
         * @param null
         * @return null
         */
        public function a_complete(){
            $this->_data["loadPage"]="authentication/apro_com";
            $this->_data["titlePage"]="joyspe管理画面";
            $this->load->view($this->_data["module"]."/layout/layout",$this->_data);
        }
          /**
         * author: [IVS] Nguyen Minh Ngoc
         * name : non_Profile
         * todo : show owner profile which unapprove it
         * @param null
         * @return null
         */
        public function non_Profile(){
            $this->load->Model("admin/Mauthentication");
            $this->_data["loadPage"]="authentication/non_profile";
            $this->_data["titlePage"]="joyspe管理画面";
            $id=$this->uri->segment(4);
            $this->_data["owinfo"]=$this->Mauthentication->showProfile($id);
            if($id=="" || empty( $this->_data["owinfo"])){
                 redirect(base_url()."admin/system/errorPage");
            }
            //get current time
            $time = date("Y-m-d-H-i-s");
            //
            if($this->input->post("btnupow")){
                $this->form_validation->set_rules('txtstorename', '店舗名', 'trim|required|max_length[100]');
                $this->form_validation->set_rules('txtpic', '求人担当', 'trim|required|max_length[100]');
                $this->form_validation->set_rules('txtcominfo', '会社情報', 'trim|required|max_length[400]');
                $this->form_validation->set_rules('txtstation', '最寄駅', 'trim|required|max_length[100]');
                $this->form_validation->set_rules('txtworkingstyle', '出勤スタイル', 'trim|required|max_length[140]');
                $this->form_validation->set_rules('txternote', 'スタッフ記入欄', 'trim|max_length[10000]');
                $this->form_validation->set_rules('txtercenter', 'スタッフ記入欄', 'trim|max_length[10000]');
                $form_validation = $this->form_validation->run();
                $this->message['success'] = !$form_validation && count($_POST) > 0 ? FALSE : TRUE;         
                if ($form_validation==false) {
                     $this->_data['message']= $this->message;
                      $this->_data["cc"]="true";
                }else{
                     $this->_data["flag"]="true";
                    $this->_data["store"]=$this->input->post("txtstorename");
                    $this->_data["pic"]=$this->input->post("txtpic");
                    $this->_data["info"]=$this->input->post("txtcominfo");
                    $this->_data["station"]=$this->input->post("txtstation");
                    $this->_data["stylework"]=$this->input->post("txtworkingstyle");
                    $this->_data["ernote"]=$this->input->post("txternote");
                    $this->_data["ercenter"]=$this->input->post("txtercenter");
                    $this->_data["image1"]=$_POST['hdImage1'];
                    $this->_data["image2"]=$_POST['hdImage2'];
                    $this->_data["image3"]=$_POST['hdImage3'];
                    $this->_data["image4"]=$_POST['hdImage4'];
                    $this->_data["image5"]=$_POST['hdImage5'];
                    $this->_data["image6"]=$_POST['hdImage6'];
                    $this->_data["main"]=$this->input->post("sltmainimg");
                }
            }   
            //
            $this->load->view($this->_data["module"]."/layout/layout",$this->_data);
        }
        /**
         * author: [IVS] Nguyen Minh Ngoc
         * name : non_Profile
         * todo : do approve owner profile
         * @param null
         * @return null
         */
        public function updateOk_Profile(){
            $this->load->Model("admin/Mauthentication");
            //get current time
            $time = date("Y-m-d-H-i-s");
            $id=$this->input->post("txtowid");
            $rid=$this->input->post("id");
            $store=$this->input->post("txtstorename");
            $pic=$this->input->post("txtpic");
            $info=$this->input->post("txtcominfo");
            $station=$this->input->post("txtstation");
            $stylework=$this->input->post("txtworkingstyle");
            $ernote=$this->input->post("txternote");
            $image1=$_POST['hdImage1'];
            $image2=$_POST['hdImage2'];
            $image3=$_POST['hdImage3'];
            $image4=$_POST['hdImage4'];
            $image5=$_POST['hdImage5'];
            $image6=$_POST['hdImage6'];
            $main=$this->input->post("txtmainimg");
            $this->Mauthentication->approveOwn($id);
            $this->Mauthentication->updateOW($id,$store,$pic,$info,$station,$stylework,$ernote,$image1,$image2,$image3,$image4,
                    $image5,$image6,$main,$time,$rid);
            
            //Upload file

            $set=$this->Mauthentication->showProfile($rid);
            $fname = $id;
            for ($i = 1; $i <= 6; $i++) {
                if (!empty($_POST['hdImage' . $i])) {
                    echo $_POST['hdImage'];
                    $this->fileUpload($_POST['hdImage' . $i],$fname);
                }
            }
            $this->deleteFolder2($fname);
            //send mail
            foreach($set as $k=>$s){
                $setsendmail=$s["smail"];
            }
            if($setsendmail==1){
//                $this->common->sendMail('', '','',array('ow22'),'','',$id,'','','','','','');
            }
        }
            /**
         * author: [IVS] Nguyen Minh Ngoc
         * name : non_Profile
         * todo :  do unapprove owner profile
         * @param null
         * @return null
         */
       public function updateNon_Profile(){
           $this->load->Model("admin/Mauthentication");
            //get current time
            $time = date("Y-m-d-H-i-s");
            $id=$this->input->post("txtowid");
            $rid=$this->input->post("id");
            $store=$this->input->post("txtstorename");
            $pic=$this->input->post("txtpic");
            $info=$this->input->post("txtcominfo");
            $station=$this->input->post("txtstation");
            $stylework=$this->input->post("txtworkingstyle");
            $ernote=$this->input->post("txternote");
            $ercenter=$this->input->post("txtercenter");
            $image1=$_POST['hdImage1'];
            $image2=$_POST['hdImage2'];
            $image3=$_POST['hdImage3'];
            $image4=$_POST['hdImage4'];
            $image5=$_POST['hdImage5'];
            $image6=$_POST['hdImage6'];
            $main=$this->input->post("txtmainimg");
           $this->Mauthentication->updateOW2($id,$store,$pic,$info,$station,$stylework,$ercenter,$ernote,$image1,$image2,$image3,$image4,
                       $image5,$image6,$main,$time,$rid);
           //Upload file
           $this->_data["owinfo"]=$this->Mauthentication->showProfile($rid);
           foreach($this->_data["owinfo"] as $k=>$s){
               $setsendmail = $s["smail"];
           }
           if($setsendmail==1){
                $this->common->sendMail('', '','',array('ow03'),'','',$id,'','','','','','');
           }
           $fname =$id;
           for ($i = 1; $i <= 6; $i++) {
               if (!empty($_POST['hdImage' . $i])) {
                   $this->fileUpload($_POST['hdImage' . $i],$fname);
               }
           }
           $this->deleteFolder2($fname);
    }
    public function downloadOwnerCsv(){
        //Download CSV
        $txtDateFrom = trim($this->input->post('txtDateFrom'));
        $txtDateTo = trim($this->input->post('txtDateTo'));
        $this->load->Model("admin/Mlog");
        $limit = 1000;
        $result_array = $this->Mlog->searchOwnerStatistics($txtDateFrom,$txtDateTo,$limit);
        $data = array();
        $result = array( 'Unique ID', 'Owner店舗名 ', 'エリア地域' ,'最終ログイント', 'スカウト送信数', '開封数', 'お問合せ受信数');            
        array_push($data, $result);
        foreach ($result_array as $value) {              
            $result = array($value['unique_id'],$value['storename'],$value['area'],$value['last_visit_date'],$value['scout_mail_send'],$value['scout_mail_open'],$value['mails_receive']);
            array_push($data, $result);
        }
        $str=$this->_arrayToCsv($data);
        $this->load->helper('download');
        $nameFile="results_".date("Ymd").".csv";
        force_download($nameFile, $str);
    }
    public function downloadUserStatisticsCsv(){
        //download user statistics into csv
        $txtDateFrom = trim($this->input->post('txtDateFrom'));
        $txtDateTo = trim($this->input->post('txtDateTo'));
        $this->load->Model("admin/Mlog");
        $limit = 1000;
        $result_array = $this->Mlog->searchUserStatisticsLog($txtDateFrom,$txtDateTo,$limit);
        $data = array();
        $result = array( 'ユーザーユニークＩＤ', 'ユーザー名', 'メールクリック' ,'電話クリック', 'ＬＩＮＥクリック', '口コミクリック ', 'お問い合わせ','ＨＰクリック');            
        array_push($data, $result);
        foreach ($result_array as $value) {              
            $result = array($value['unique_id'],$value['name'],$value['count_mail'],$value['count_tel'],$value['count_line'],$value['count_kuchikomi'],$value['question_no'],$value['hp_click']);
            array_push($data, $result);
        }
        $str=$this->_arrayToCsv($data);
        $this->load->helper('download');
        $nameFile="results_".date("Ymd").".csv";
        force_download($nameFile, $str);
    }
    private function _arrayToCsv( array $fields, $delimiter = ',', $enclosure = '"', $encloseAll = false, $nullToMysqlNull = false ) {
        $delimiter_esc = preg_quote($delimiter, '/');
        $enclosure_esc = preg_quote($enclosure, '/');

        $outputString = "";
        foreach($fields as $tempFields) {
            $output = array();
            foreach ( $tempFields as $field ) {
                if ($field === null && $nullToMysqlNull) {
                    $output[] = 'NULL';
                    continue;
                }

                // Enclose fields containing $delimiter, $enclosure or whitespace
                if ( $encloseAll || preg_match( "/(?:${delimiter_esc}|${enclosure_esc}|\s)/", $field ) ) {
                    $field = $enclosure . str_replace($enclosure, $enclosure . $enclosure, $field) . $enclosure;
                }
                $output[] = $field." ";
            }
            $outputString .= implode( $delimiter, $output )."\r\n";
        }
        return mb_convert_encoding($outputString,'Shift-JIS','UTF-8');  
    }
  }

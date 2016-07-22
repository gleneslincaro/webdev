<?php
  class News extends MX_Controller{
        protected $_data;
        private $message = array('success' => true, 'error' => array());
        public function __construct() {
            parent::__construct();
            AdminControl::CheckLogin();
            $this->_data["module"] = $this->router->fetch_module();
            $this->load->Model("admin/Mnews");
            $this->form_validation->CI =& $this;
            $this->lang->load('list_message', 'english');
            $this->output->set_header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
            $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate");
            $this->output->set_header("Cache-Control: post-check=0, pre-check=0");
            $this->output->set_header("Pragma: no-cache");
        }
    /**
    * @author  [IVS] Ho Quoc Huy
    * @name 	ownerNews
    * @todo 	Go to news/owner_news page
    * @param 	
    * @return 	
    */
    public function ownerNews(){
        $this->_data["flag"]='00';
         
        $this->_data["send_date"] = date("Y-m-d-H-i-s");
        $this->_data["info"] = null;
        $this->_data["loadPage"]="news/owner_news";

          $start = 0;
        //init sql query to search shop
        $sql = $this->Mnews->getSearchNewsQueryForOwner();

        //get totalRows
        $countRows  = $this->Mnews->countDataByQuery($sql);

        //init config to paging
        $config['base_url'] = base_url().'admin/news/ownerNews';
        $config['total_rows'] = $countRows;
       
        $config['constant_num_links'] = TRUE;
        $config['uri_segment']=4;
        $config["per_page"]=$this->config->item('per_page');
        $this->load->library("pagination",$config);
        $this->pagination->initialize($config);

        //start1 has value after clicking paging link 
        $start1 = $this->uri->segment(4);
        if($start1!=NULL) $start=$start1;

        //data_info show data with paging
        $this->_data["info"] = $this->Mnews->searchDataToShow($sql,$this->config->item('per_page'),$start); 
        $this->pagination->create_links();
        $this->_data["totalRows"] = $countRows;
        $this->_data["titlePage"]="メルマガ・会社・店舗検索";
       
       $this->load->view($this->_data["module"]."/layout/layout",$this->_data);
    }  
    
      /**
    * @author  [IVS] Ho Quoc Huy
    * @name 	checkValidateFormOwner
    * @todo 	check validation in news/owner_news page
    * @param 	
    * @return 	
    */
    public function checkValidateFormOwner(){
        $year =$this->input->post('sltYear');
        $month =$this->input->post('sltMonth');
        $day =$this->input->post('sltDay');

        $post_send_date = $year."-".$month."-".$day;
        //convert string to datetime style
         
        $temp_send_date = strtotime($post_send_date);
        $time_now = date("Y-m-d");
        $this->_data["flag"]='00';
        $this->form_validation->set_rules('txtTitle', 'タイトル', 'trim|required|max_length[200]');
        $this->form_validation->set_rules('txtContent', 'ニュース ', 'trim|required|max_length[10000]');
        $form_validation = $this->form_validation->run();
        $this->message['success'] = !$form_validation && count($_POST) > 0 ? FALSE : TRUE;
        if ($form_validation==false) {
            $this->_data['message']= $this->message; 
        }else if($post_send_date<$time_now){
            $this->_data["flag"]='11';
            $msg =  $this->lang->line('checkAuto_sent_date');
            $this->_data["error_message"]= $msg;
        }else{
             $this->_data["flag"]='22';
          
        }
        $start = 0;
        //init sql query to search shop
        $sql = $this->Mnews->getSearchNewsQueryForOwner();

        //get totalRows
        $countRows  = $this->Mnews->countDataByQuery($sql);

        //init config to paging
        $config['base_url'] = base_url().'admin/news/ownerNews';
        $config['total_rows'] = $countRows;
       
        $config['constant_num_links'] = TRUE;
        $config['uri_segment']=4;
        $config["per_page"]=$this->config->item('per_page');
        $this->load->library("pagination",$config);
        $this->pagination->initialize($config);

        //start1 has value after clicking paging link 
        $start1 = $this->uri->segment(4);
        if($start1!=NULL) $start=$start1;

        //data_info show data with paging
        $this->_data["info"] = $this->Mnews->searchDataToShow($sql,$this->config->item('per_page'),$start); 
        $this->pagination->create_links();
        $this->_data["totalRows"] = $countRows;    
        $this->_data["send_date"] = $post_send_date;
        $this->_data["txtContent"] =$this->input->post('txtContent');
        $this->_data["txtTitle"] =$this->input->post('txtTitle');
        $this->_data["loadPage"]="news/owner_news";
        $this->_data["titlePage"]="メルマガ・会社・店舗検索";
        $this->load->view($this->_data["module"]."/layout/layout",$this->_data);  
        }
         
        /**
    * @author  [IVS] Ho Quoc Huy
    * @name 	insertToMst_News
    * @todo 	insert data to mst_news
    * @param 	$content,$title,$newType,$date
    * @return 	
    */
        public function insertToMst_News(){
        //get data from url
        $content =$this->input->post('txtContent');
        $title =$this->input->post('txtTitle');
        $newType =$this->input->post('newType');
        $date =$this->input->post('txtDate');
 

        
        $this->Mnews->insertNew($content,$title,$newType,$date);
      
        }
           /**
    * @author  [IVS] Ho Quoc Huy
    * @name 	newsComp
    * @todo 	Go to news/news_comp page
    * @param 	
    * @return 	
    */
    public function newsComp(){
        $this->_data["flag"]='00';
        $this->_data["info"] = null;
        $this->_data["listEmail"] = null;
        $this->_data["loadPage"]="news/news_comp";
        $this->_data["titlePage"]="メルマガ配信";
        $this->load->view($this->_data["module"]."/layout/layout",$this->_data);
    }
               /**
    * @author  [IVS] Ho Quoc Huy
    * @name 	showEditNewForOwner
    * @todo 	Go to news/owner_newsedit page
    * @param 	
    * @return 	
    */
    public function showEditNewForOwner(){
        $uid=trim($this->input->get('newId')); 
        $this->_data["detail"]=$this->Mnews->getNewByID($uid);
           if(empty($this->_data["detail"]) || $uid==""){
                redirect(base_url()."admin/system/errorPage");
            }
        if($_POST){
            $this->checkValidateFormOwnerToUpdate();
        }else {       
        $this->_data["flag"]='00';
        $this->_data["info"] = null;
        $this->_data["loadPage"]="news/owner_newsedit";
        $this->_data["titlePage"]="メルマガ・会社・店舗検索";
        $newID =$this->input->get('newId');
        $info = $this->Mnews->getNewByID($newID);
        $this->_data["send_date"] = strftime("%Y-%m-%d", strtotime($info["created_date"]));
        $this->_data["txtTitle"] = $info["title"];
        $this->_data["txtContent"] = $info["content"];
        $this->_data["txtID"] = $newID;
        $this->load->view($this->_data["module"]."/layout/layout",$this->_data);
        }
    }
    
                   /**
    * @author  [IVS] Ho Quoc Huy
    * @name 	checkValidateFormOwnerToUpdate
    * @todo 	check validation in news/owner_newsedit page
    * @param 	
    * @return 	
    */
    public function checkValidateFormOwnerToUpdate(){
        $year =$this->input->post('sltYear');
        $month =$this->input->post('sltMonth');
        $day =$this->input->post('sltDay');
  
        $post_send_date = $year."-".$month."-".$day;
        //convert string to datetime style
         
        $temp_send_date = strtotime($post_send_date);
        $time_now = date("Y-m-d");
        $this->_data["flag"]='00';
        $this->form_validation->set_rules('txtTitle', 'タイトル', 'trim|required|max_length[200]');
        $this->form_validation->set_rules('txtContent', 'ニュース ', 'trim|required|max_length[10000]');
        $form_validation = $this->form_validation->run();
        $this->message['success'] = !$form_validation && count($_POST) > 0 ? FALSE : TRUE;
        if ($form_validation==false) {
            $this->_data['message']= $this->message; 
        }else if($post_send_date<$time_now){
            $this->_data["flag"]='11';
            $msg =  $this->lang->line('checkAuto_sent_date');
            $this->_data["error_message"]= $msg;
        }else{
             $this->_data["flag"]='22';
          
        }
        $this->_data["send_date"] = $post_send_date;
        $this->_data["txtID"] =$this->input->post('txtID');
        $this->_data["txtContent"] =$this->input->post('txtContent');
        $this->_data["txtTitle"] =$this->input->post('txtTitle');
        $this->_data["loadPage"]="news/owner_newsedit";
        $this->_data["titlePage"]="メルマガ・会社・店舗検索";
        $this->load->view($this->_data["module"]."/layout/layout",$this->_data);  
        }
        
         /**
    * @author  [IVS] Ho Quoc Huy
    * @name 	updateNew
    * @todo 	update data in table mst_news 
    * @param 	$content,$title,$txtId,$date
    * @return 	
    */
        public function updateNew(){
        //get data from url
        $content =$this->input->post('txtContent');
        $title =$this->input->post('txtTitle');
        //$newType =$this->input->post('newType');
        $date =$this->input->post('txtDate');
        $txtId =$this->input->post('txtID');
        $this->Mnews->updateNew($content,$title,$txtId,$date);
      
        }
        
         /**
    * @author  [IVS] Ho Quoc Huy
    * @name 	deactiveNew
    * @todo 	deactive New in mst_news by ID
    * @param 	
    * @return 	
    */
        public function deactiveNew(){
        //get data from url
     
        $txtId =$this->input->get('newId');
        $this->Mnews->deactiveNew($txtId);
        $this->_data["loadPage"]="news/news_comp";
        $this->_data["titlePage"]="メルマガ配信";
        $this->load->view($this->_data["module"]."/layout/layout",$this->_data);
        }
        
        
        
        /**
    * @author  [IVS] Ho Quoc Huy
    * @name 	userNews
    * @todo 	Go to news/user_news page
    * @param 	
    * @return 	
    */
    public function userNews(){
        $this->_data["flag"]='00';
         
        $this->_data["send_date"] = date("Y-m-d-H-i-s");
        $this->_data["info"] = null;
        $this->_data["loadPage"]="news/user_news";
        $this->_data["titlePage"]="メルマガ・会社・店舗検索";
          $start = 0;
        //init sql query to search shop
        $sql = $this->Mnews->getSearchNewsQueryForUser();

        //get totalRows
        $countRows  = $this->Mnews->countDataByQuery($sql);

        //init config to paging
        $config['base_url'] = base_url().'admin/news/userNews';
        $config['total_rows'] = $countRows;
       
        $config['constant_num_links'] = TRUE;
        $config['uri_segment']=4;
        $config["per_page"]=$this->config->item('per_page');
        $this->load->library("pagination",$config);
        $this->pagination->initialize($config);

        //start1 has value after clicking paging link 
        $start1 = $this->uri->segment(4);
        if($start1!=NULL) $start=$start1;

        //data_info show data with paging
        $this->_data["info"] = $this->Mnews->searchDataToShow($sql,$this->config->item('per_page'),$start); 
        $this->pagination->create_links();
        $this->_data["totalRows"] = $countRows;
    
       
       $this->load->view($this->_data["module"]."/layout/layout",$this->_data);
    }  
    
      /**
    * @author  [IVS] Ho Quoc Huy
    * @name 	checkValidateFormUser
    * @todo 	check validation in news/user_news page
    * @param 	
    * @return 	
    */
    public function checkValidateFormUser(){
        $year =$this->input->post('sltYear');
        $month =$this->input->post('sltMonth');
        $day =$this->input->post('sltDay');
  
        $post_send_date = $year."-".$month."-".$day;
        //convert string to datetime style
         
        $temp_send_date = strtotime($post_send_date);
        $time_now = date("Y-m-d");
        $this->_data["flag"]='00';
        $this->form_validation->set_rules('txtTitle', 'タイトル ', 'trim|required|max_length[200]');
        $this->form_validation->set_rules('txtContent', 'ニュース ', 'trim|required|max_length[10000]');
        $form_validation = $this->form_validation->run();
        $this->message['success'] = !$form_validation && count($_POST) > 0 ? FALSE : TRUE;
        if ($form_validation==false) {
            $this->_data['message']= $this->message; 
        }else if($post_send_date<$time_now){
            $this->_data["flag"]='11';
            $msg =  $this->lang->line('checkAuto_sent_date');
            $this->_data["error_message"]= $msg;
        }else{
             $this->_data["flag"]='22';
          
        }
        $start = 0;
        //init sql query to search shop
        $sql = $this->Mnews->getSearchNewsQueryForUser();

        //get totalRows
        $countRows  = $this->Mnews->countDataByQuery($sql);

        //init config to paging
        $config['base_url'] = base_url().'admin/news/userNews';
        $config['total_rows'] = $countRows;
       
        $config['constant_num_links'] = TRUE;
        $config['uri_segment']=4;
        $config["per_page"]=$this->config->item('per_page');
        $this->load->library("pagination",$config);
        $this->pagination->initialize($config);

        //start1 has value after clicking paging link 
        $start1 = $this->uri->segment(4);
        if($start1!=NULL) $start=$start1;

        //data_info show data with paging
        $this->_data["info"] = $this->Mnews->searchDataToShow($sql,$this->config->item('per_page'),$start); 
        $this->pagination->create_links();
        $this->_data["send_date"] = $post_send_date;
        $this->_data["totalRows"] = $countRows;
        $this->_data["txtContent"] =$this->input->post('txtContent');
        $this->_data["txtTitle"] =$this->input->post('txtTitle');
        $this->_data["loadPage"]="news/user_news";
        $this->_data["titlePage"]="メルマガ・会社・店舗検索";
        $this->load->view($this->_data["module"]."/layout/layout",$this->_data);  
        }
         
     
       
               /**
    * @author  [IVS] Ho Quoc Huy
    * @name 	showEditNewForUser
    * @todo 	Go to news/user_newsedit page
    * @param 	
    * @return 	
    */
    public function showEditNewForUser(){
        $uid=trim($this->input->get('newId')); 
        $this->_data["detail"]=$this->Mnews->getNewByID($uid);
           if(empty($this->_data["detail"]) || $uid==""){
                redirect(base_url()."admin/system/errorPage");
            }
        if($_POST){
            $this->checkValidateFormUserToUpdate();
        }else {         
        $this->_data["flag"]='00';
        $this->_data["info"] = null;
        $this->_data["loadPage"]="news/user_newsedit";
        $this->_data["titlePage"]="メルマガ・会社・店舗検索";
        $newID =$this->input->get('newId');
        $info = $this->Mnews->getNewByID($newID);
        $this->_data["send_date"] = strftime("%Y-%m-%d", strtotime($info["created_date"]));
        $this->_data["txtTitle"] = $info["title"];
        $this->_data["txtContent"] = $info["content"];
        $this->_data["txtID"] = $newID;
        $this->load->view($this->_data["module"]."/layout/layout",$this->_data);
        }
    }
    
    /**
    * @author  [IVS] Ho Quoc Huy
    * @name 	checkValidateFormUserToUpdate
    * @todo 	check validation in news/owner_newsedit page
    * @param 	
    * @return 	
    */
    public function checkValidateFormUserToUpdate(){
        $year =$this->input->post('sltYear');
        $month =$this->input->post('sltMonth');
        $day =$this->input->post('sltDay');
  
        $post_send_date = $year."-".$month."-".$day;
        //convert string to datetime style
         
        $temp_send_date = strtotime($post_send_date);
        $time_now = date("Y-m-d");
        $this->_data["flag"]='00';
        $this->form_validation->set_rules('txtTitle', 'タイトル ', 'trim|required|max_length[200]');
        $this->form_validation->set_rules('txtContent', 'ニュース', 'trim|required|max_length[10000]');
        $form_validation = $this->form_validation->run();
        $this->message['success'] = !$form_validation && count($_POST) > 0 ? FALSE : TRUE;
        if ($form_validation==false) {
            $this->_data['message']= $this->message; 
        }else if($post_send_date<$time_now){
            $this->_data["flag"]='11';
            $msg =  $this->lang->line('checkAuto_sent_date');
            $this->_data["error_message"]= $msg;
        }else{
             $this->_data["flag"]='22';
          
        }
        $this->_data["send_date"] = $post_send_date;
        $this->_data["txtID"] =$this->input->post('txtID');
        $this->_data["txtContent"] =$this->input->post('txtContent');
        $this->_data["txtTitle"] =$this->input->post('txtTitle');
        $this->_data["loadPage"]="news/owner_newsedit";
        $this->_data["titlePage"]="メルマガ・会社・店舗検索";
        $this->load->view($this->_data["module"]."/layout/layout",$this->_data);  
        }
    }
?>

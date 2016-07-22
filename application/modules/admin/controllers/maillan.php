<?php
  class Maillan extends MX_Controller{
        protected $_data;
        private $message = array('success' => true, 'error' => array());
        public function __construct() {
            parent::__construct();
            AdminControl::CheckLogin();
            $this->_data["module"] = $this->router->fetch_module();
            $this->load->Model("admin/Mmaillan");
            $this->output->set_header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
            $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate");
            $this->output->set_header("Cache-Control: post-check=0, pre-check=0");
            $this->output->set_header("Pragma: no-cache");
        }
                 
    /**
    * @author  [IVS] Ho Quoc Huy
    * @name 	showOwnerMailForm
    * @todo 	Go to owner_mail_form.php
    * @param 	
    * @return 	
    */
    public function showOwnerMailForm(){
         $uid=trim($this->input->get('type')); 
        $this->_data["detail"]=$this->Mmaillan->getTemplateByType($uid); 
           if(empty($this->_data["detail"]) || $uid==""){
                redirect(base_url()."admin/system/errorPage");
            }
        if($_POST){
            $this->checkValidateFormOwner();
        }else {
        $this->_data["info"] = null;
      
        $templateStyle = trim($this->input->get('type')); 
      
         //search data to show
         $this->_data["info"] = $this->Mmaillan->getTemplateByType($templateStyle);
         $this->_data["flag"] = '00';
         $this->_data["type"] =trim($this->input->get('type'));
         $this->_data["loadPage"]="maillan/owner_mail_form";
         $this->_data["titlePage"]="joyspe管理画面";
         $this->load->view($this->_data["module"]."/layout/layout",$this->_data); 
        }
      }
         
    
    
    /**
    * @author  [IVS] Ho Quoc Huy
    * @name 	checkValidateFormUser
    * @todo 	check validation in maillan/user_mail_form page
    * @param 	
    * @return 	
    */
    public function checkValidateFormUser(){
        $this->_data["info"] = null;     
        $this->form_validation->set_rules('txtTitle', '見出し', 'trim|required|max_length[200]');
        $this->form_validation->set_rules('context', '内容', 'trim|required|max_length[50000]');
        $this->form_validation->set_rules('txtFromEmail', 'メールアドレス', 'trim|required|valid_email');
        $form_validation = $this->form_validation->run();
        $this->message['success'] = !$form_validation && count($_POST) > 0 ? FALSE : TRUE;
        if ($form_validation==false) {
             $this->_data["flag"]='00';
             $this->_data['message']= $this->message; 
        }else{
        $this->_data["flag"]='11';
        }
        
        $this->_data["type"] =trim($this->input->post('type')); 
        $this->_data["info"]["title"] = trim($this->input->post('txtTitle')); 
        $this->_data["info"]["content"] = trim($this->input->post('context'));
        $this->_data["info"]["mail_from"] = trim($this->input->post('txtFromEmail'));
                $this->_data["info"]["template_name"] = trim($this->input->post('template_name'));
        $data = $this->Mmaillan->getTemplateByType($this->input->post('type'));
        $this->_data["info"]["template_name"] = $data["template_name"];
        $this->_data["loadPage"]="maillan/user_mail_form";
        $this->_data["titlePage"]="joyspe管理画面";
        $this->load->view($this->_data["module"]."/layout/layout",$this->_data);  
    }
        /**
    * @author  [IVS] Ho Quoc Huy
    * @name 	checkValidateFormOwner
    * @todo 	check validation in maillan/owner_mail_form page
    * @param 	
    * @return 	
    */
    public function checkValidateFormOwner(){
        $this->_data["info"] = null;     
        $this->form_validation->set_rules('txtTitle', '見出し', 'trim|required|max_length[200]');
        $this->form_validation->set_rules('context', '内容', 'trim|required|max_length[50000]');
        $this->form_validation->set_rules('txtFromEmail', 'メールアドレス', 'trim|required|valid_email');
        $form_validation = $this->form_validation->run();
        $this->message['success'] = !$form_validation && count($_POST) > 0 ? FALSE : TRUE;
        if ($form_validation==false) {
             $this->_data["flag"]='00';
             $this->_data['message']= $this->message; 
        }else{
        $this->_data["flag"]='11';
        }
        
        $this->_data["type"] =trim($this->input->post('type')); 
        $this->_data["info"]["title"] = trim($this->input->post('txtTitle')); 
        $this->_data["info"]["content"] = trim($this->input->post('context'));
        $this->_data["info"]["mail_from"] = trim($this->input->post('txtFromEmail'));
                $this->_data["info"]["template_name"] = trim($this->input->post('template_name'));
        $data = $this->Mmaillan->getTemplateByType($this->input->post('type'));
        $this->_data["info"]["template_name"] = $data["template_name"];
        $this->_data["loadPage"]="maillan/owner_mail_form";
        $this->_data["titlePage"]="joyspe管理画面";
        $this->load->view($this->_data["module"]."/layout/layout",$this->_data);  
    }
        /**
    * @author  [IVS] Ho Quoc Huy
    * @name 	checkValidateFormAdmin
    * @todo 	check validation in maillan/admin_mail_form page
    * @param 	
    * @return 	
    */
    public function checkValidateFormAdmin(){
        
        $this->_data["info"] = null;     
        $this->form_validation->set_rules('txtTitle', '見出し', 'trim|required|max_length[200]');
        $this->form_validation->set_rules('context', '内容', 'trim|required|max_length[50000]');
        $this->form_validation->set_rules('txtFromEmail', 'メールアドレス', 'trim|required|valid_email');
        $form_validation = $this->form_validation->run();
        $this->message['success'] = !$form_validation && count($_POST) > 0 ? FALSE : TRUE;
        if ($form_validation==false) {
             $this->_data["flag"]='00';
             $this->_data['message']= $this->message; 
        }else{
        $this->_data["flag"]='11';
        }
        
        $this->_data["type"] =trim($this->input->post('type')); 
        $this->_data["info"]["title"] = trim($this->input->post('txtTitle')); 
        $this->_data["info"]["content"] = trim($this->input->post('context'));
        $this->_data["info"]["mail_from"] = trim($this->input->post('txtFromEmail'));
                $this->_data["info"]["template_name"] = trim($this->input->post('template_name'));
        $data = $this->Mmaillan->getTemplateByType($this->input->post('type'));
        $this->_data["info"]["template_name"] = $data["template_name"];
        $this->_data["loadPage"]="maillan/admin_mail_form";
        $this->_data["titlePage"]="joyspe管理画面";
        $this->load->view($this->_data["module"]."/layout/layout",$this->_data);  

    }
        /**
    * @author  [IVS] Ho Quoc Huy
    * @name 	checkValidateFormJoyspe
    * @todo 	check validation in maillan/joyspe_mail_form page
    * @param 	
    * @return 	
    */
    public function checkValidateFormJoyspe(){
        
        $this->_data["info"] = null;     
        $this->form_validation->set_rules('txtTitle', '見出し', 'trim|required|max_length[200]');
        $this->form_validation->set_rules('context', '内容', 'trim|required|max_length[50000]');
        $this->form_validation->set_rules('txtFromEmail', 'メールアドレス', 'trim|required|valid_email');
        $form_validation = $this->form_validation->run();
        $this->message['success'] = !$form_validation && count($_POST) > 0 ? FALSE : TRUE;
        if ($form_validation==false) {
             $this->_data["flag"]='00';
             $this->_data['message']= $this->message; 
        }else{
        $this->_data["flag"]='11';
        }
        
        $this->_data["type"] =trim($this->input->post('type')); 
        $this->_data["info"]["title"] = trim($this->input->post('txtTitle')); 
        $this->_data["info"]["content"] = trim($this->input->post('context'));
         $this->_data["info"]["mail_from"] = trim($this->input->post('txtFromEmail'));
        $this->_data["info"]["template_name"] = trim($this->input->post('template_name'));
        $data = $this->Mmaillan->getTemplateByType($this->input->post('type'));
        $this->_data["info"]["template_name"] = $data["template_name"];
        $this->_data["loadPage"]="maillan/joyspe_mail_form";
        $this->_data["titlePage"]="joyspe管理画面";
        $this->load->view($this->_data["module"]."/layout/layout",$this->_data);  

    }
    /**
    * @author  [IVS] Ho Quoc Huy
    * @name 	updateTemplatebyType
    * @todo 	Update mst_template by template_type
    * @param 	
    * @return 	
    */
    public function updateTemplatebyType(){
        $this->_data["info"] = null;
      
        $templateStyle = trim($this->input->post('type')); 
        $title = trim($this->input->post('txtTitle')); 
        $content = trim($this->input->post('context'));
         $email = trim($this->input->post('txtFromEmail'));
         //search data to show
        //echo "abc";
       $this->Mmaillan->updateTemplateByType($templateStyle,$title,$content,$email);
//         $this->_data["flag"] = '00';
         echo "update success"; 
    }
    
    
        /**
    * @author  [IVS] Ho Quoc Huy
    * @name 	showUserMailForm
    * @todo 	Go to maillan/user_mail_form
    * @param 	
    * @return 	
    */
    public function showUserMailForm(){
         $uid=trim($this->input->get('type')); 
        $this->_data["detail"]=$this->Mmaillan->getTemplateByType($uid); 
           if(empty($this->_data["detail"]) || $uid==""){
                redirect(base_url()."admin/system/errorPage");
            }
        if($_POST){
            $this->checkValidateFormUser();
        }else {
        $this->_data["info"] = null;
      
        $templateStyle = trim($this->input->get('type')); 
      
         //search data to show
         $this->_data["info"] = $this->Mmaillan->getTemplateByType($templateStyle);
         $this->_data["flag"] = '00';
         $this->_data["type"] =trim($this->input->get('type'));
         $this->_data["loadPage"]="maillan/user_mail_form";
         $this->_data["titlePage"]="joyspe管理画面";
         $this->load->view($this->_data["module"]."/layout/layout",$this->_data); 
        }
    }
    
        /**
    * @author  [IVS] Ho Quoc Huy
    * @name 	showJoyspeMailForm
    * @todo 	Go to maillan/joyspe_mail_form page
    * @param 	
    * @return 	
    */
    public function showJoyspeMailForm(){
         $uid=trim($this->input->get('type')); 
        $this->_data["detail"]=$this->Mmaillan->getTemplateByType($uid); 
           if(empty($this->_data["detail"]) || $uid==""){
                redirect(base_url()."admin/system/errorPage");
            }
        if($_POST){
            $this->checkValidateFormJoyspe();
        }else {
        $this->_data["info"] = null;
      
        $templateStyle = trim($this->input->get('type')); 
      
         //search data to show
         $this->_data["info"] = $this->Mmaillan->getTemplateByType($templateStyle);
         $this->_data["flag"] = '00';
         $this->_data["type"] =trim($this->input->get('type'));
         $this->_data["loadPage"]="maillan/joyspe_mail_form";
         $this->_data["titlePage"]="joyspe管理画面";
         $this->load->view($this->_data["module"]."/layout/layout",$this->_data);  
        }
    }
    
    
      /**
    * @author  [IVS] Ho Quoc Huy
    * @name 	maillanComp
    * @todo 	Go to maillan/maillan_comp page
    * @param 	
    * @return 	
    */
        public function maillanComp(){
        $this->_data["info"] = null;
      
         //search data to show
         $this->_data["loadPage"]="maillan/maillan_comp";
         $this->_data["titlePage"]="joyspe管理画面";
         $this->load->view($this->_data["module"]."/layout/layout",$this->_data);  
    }
            /**
    * @author  [IVS] Ho Quoc Huy
    * @name 	showAdminMailForm
    * @todo 	Go to maillan/admin_mail_form page
    * @param 	
    * @return 	
    */
    public function showAdminMailForm(){
         $uid=trim($this->input->get('type')); 
        $this->_data["detail"]=$this->Mmaillan->getTemplateByType($uid); 
           if(empty($this->_data["detail"]) || $uid==""){
                redirect(base_url()."admin/system/errorPage");
            }
        if($_POST){
            $this->checkValidateFormAdmin();
        }else {        
        $this->_data["info"] = null;
      
        $templateStyle = trim($this->input->get('type')); 
      
         //search data to show
         $this->_data["info"] = $this->Mmaillan->getTemplateByType($templateStyle);
         $this->_data["flag"] = '00';
         $this->_data["type"] =trim($this->input->get('type'));
         $this->_data["loadPage"]="maillan/admin_mail_form";
         $this->_data["titlePage"]="joyspe管理画面";
         $this->load->view($this->_data["module"]."/layout/layout",$this->_data); 
        }
    }
  }
?>

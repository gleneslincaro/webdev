<?php
class keep extends MY_Controller{
    private $viewData = array();
    private $common;
    private $validator;
    private $layout = 'user/layout/main';
    public function __construct() {
        parent::__construct();
		$this->redirect_pc_site();
        $this->load->library("session");
        if(HelperApp::get_session('url_search')!=null){
            $current_url=HelperApp::get_session('url_search');
             HelperGlobal::require_login($current_url);
             
        }else{
             HelperGlobal::require_login(current_url());
        }
        $this->common = new Common();
        $this->validator = new FormValidator();  
        $this->viewData['idheader'] = 1;
        $this->viewData['storename'] = '';
        $this->load->model("user/Mcommon");
        $this->viewData['class_ext'] = 'keep';
        $this->load->library('user_agent');
    }
    /**
    * @author [IVS] My Phuong Thi Le
    * @name   index
    * @todo   view keep
    * @param  
    * @return void
    */
    public function index($ors_id=0) {
        //make a sign of page: search_list
        if($ors_id==0)
        {
            redirect(base_url()."user/errorpage");
        }
        if(UserControl::getUserStt()==0){
                redirect(base_url()."user/certificate/certificate_after");
            }        
        $type_page=0;
        if(isset($_GET['id'])){
            $type_page=$_GET['id'];
        }

        /* sp */
        if ($this->agent->is_mobile()) {
            $this->viewData['load_page'] = 'user/keep';
        /* pc */
        } else {
            $this->viewData['total_users'] = HelperGlobal::getUserTotalNumber();
            $this->viewData['total_owners'] = HelperGlobal::gettotalHeader();
            $this->viewData["load_page"] = "user/pc/keep";
            $this->layout = "user/pc/layout/main";
            $breadscrumb_array = array(
                array("class" => "", "text" => "キープ", "link"=>"")
            );
            $this->viewData['breadscrumb_array'] = $breadscrumb_array;
        }

        $ownerid=$this->Musers->getOwnerId($ors_id);
        $owner=$this->Musers->get_owner($ownerid);
        $this->viewData['storename'] = $owner['storename'];
        $this->viewData['ors_id']= $ors_id;
        $this->viewData['type_page']=$type_page;
        $this->viewData['titlePage'] = 'joyspe｜キープ';
        $this->load->view($this->layout, $this->viewData);
    }
    /**
    * @author [IVS] My Phuong Thi Le
    * @name   keep_complete
    * @todo   update or insert and view keep complete
    * @param  
    * @return void
    */
    public function keep_complete(){
        $userid = UserControl::getId();
        $type_page=$this->input->post('type_page');
        $ors_id = $this->input->post('ors_id');
        //if exit to update
        if ($this->Musers->check_keep($userid,$ors_id)!=0)
        {            
            $display = $this->Musers->get_keep($userid,$ors_id);
            if($display == 0){
                $data = array(
                      'display_flag'=> 1,
                 );
            }
            else {
                $data = array(
                      'display_flag'=> 0,
                ); 
            }
            $this->Musers->update_favorite_lists($data,$userid,$ors_id);
        }
        //if not exit to insert
        if ($this->Musers->check_keep($userid,$ors_id)==0)
        {
            $this->Musers->insert_favorite_lists($userid,$ors_id);
        }

        /* sp */
        if ($this->agent->is_mobile()) {
            $this->viewData['load_page'] = 'user/keep_complete';
        /* pc */
        } else {
            $this->viewData['total_users'] = HelperGlobal::getUserTotalNumber();
            $this->viewData['total_owners'] = HelperGlobal::gettotalHeader();
            $this->viewData['load_page'] = 'user/pc/keep_complete';
            $this->layout = "user/pc/layout/main";
            $breadscrumb_array = array(
                array("class" => "", "text" => "キープ", "link"=>"")
            );
            $this->viewData['breadscrumb_array'] = $breadscrumb_array;
        }

        $ownerid=$this->Musers->getOwnerId($ors_id);
        $owner=$this->Musers->get_owner($ownerid);
        $this->viewData['type_page']=$type_page;
        $this->viewData['storename'] = $owner['storename'];
        $this->viewData['titlePage'] = 'joyspe｜キープ完了';
        $this->load->view($this->layout, $this->viewData);
    }
    /**
    * @author [IVS] My Phuong Thi Le
    * @name   keep_clear
    * @todo   view keep clear
    * @param  
    * @return void
    */
    public function keep_clear($ors_id=0){
        if($ors_id==0)
        {
            redirect(base_url()."user/errorpage");
        }

        /* sp */
        if ($this->agent->is_mobile()) {
            $this->viewData['load_page'] = 'user/keep_clear';
        /* pc */
        } else {
            $this->viewData['total_users'] = HelperGlobal::getUserTotalNumber();
            $this->viewData['total_owners'] = HelperGlobal::gettotalHeader();
            $this->viewData['load_page'] = 'user/pc/keep_clear';
            $this->layout = "user/pc/layout/main";
            $breadscrumb_array = array(
                array("class" => "", "text" => "キープ", "link"=>"")
            );
            $this->viewData['breadscrumb_array'] = $breadscrumb_array;
        }

        $ownerid=$this->Musers->getOwnerId($ors_id);
        $owner=$this->Musers->get_owner($ownerid);
        $this->viewData['storename'] = $owner['storename'];
        $this->viewData['ors_id']= $ors_id;
        $this->viewData['titlePage'] = 'joyspe｜キープ解除';
        $this->load->view($this->layout, $this->viewData);
    }
    /**
    * @author [IVS] My Phuong Thi Le
    * @name   keep_clear_complete
    * @todo   update or insert and view keep_clear complete
    * @param  
    * @return void
    */
    public function keep_clear_complete(){
        $userid = UserControl::getId();
        $ors_id = $this->input->post('ors_id');
        //update display_flag->0 of favorite_lists
        $display = $this->Musers->get_keep($userid,$ors_id);
        if($display == 0){
            $data = array(
                  'display_flag'=> 1,
             );
        }
        else {
            $data = array(
                  'display_flag'=> 0,
            ); 
        }

        /* sp */
        if ($this->agent->is_mobile()) {
            $this->viewData['load_page'] = 'user/keep_clear_complete';
        /* pc */
        } else {
            $this->viewData['total_users'] = HelperGlobal::getUserTotalNumber();
            $this->viewData['total_owners'] = HelperGlobal::gettotalHeader();
            $this->viewData['load_page'] = 'user/pc/keep_clear_complete';
            $this->layout = "user/pc/layout/main";
            $breadscrumb_array = array(
                array("class" => "", "text" => "キープ", "link"=>"")
            );
            $this->viewData['breadscrumb_array'] = $breadscrumb_array;
        }

        $this->Musers->update_favorite_lists($data,$userid,$ors_id);
        $ownerid=$this->Musers->getOwnerId($ors_id);
        $owner=$this->Musers->get_owner($ownerid);
        $this->viewData['storename'] = $owner['storename'];
        $this->viewData['titlePage'] = 'joyspe｜キープ解除完了';
        $this->load->view($this->layout, $this->viewData);
    }
    /**
    * @author [IVS] My Phuong Thi Le
    * @name   keep_application
    * @todo   view keep_application
    * @param  
    * @return void
    */
    public function keep_application($ors_id=0){
        if($ors_id==0)
        {
            redirect(base_url()."user/errorpage");
        }
        if(UserControl::getUserStt()==0){
                redirect(base_url()."user/certificate/certificate_after");
            }            
        $type_page=0;
        if(isset($_GET['id'])){
            $type_page=$_GET['id'];
        }
        $ownerid=$this->Musers->getOwnerId($ors_id);
        $owner=$this->Musers->get_owner($ownerid);
        $this->viewData['storename'] = $owner['storename'];
        $this->viewData['ors_id']= $ors_id; 
        $this->viewData['type_page']=$type_page;
        $this->viewData['titlePage'] = 'joyspe｜応募';
        $this->viewData['load_page'] = 'user/keep_application';
        $this->load->view($this->layout, $this->viewData);
    }
    /**
    * @author [IVS] My Phuong Thi Le
    * @name   keep_application_complete
    * @todo   update or insert and view keep_application_complete
    * @param  
    * @return void
    */
    public function keep_application_complete(){
        $this->load->model("user/Mnewjob_model");
        $userid = UserControl::getId();
        $type_page=$this->input->post('type_page');
        $ors_id = $this->input->post('ors_id');
        $ownerid=$this->Musers->getOwnerId($ors_id);
        // get all infomation of owner
        $company_data= $this->Mnewjob_model->getAllCompany($ors_id);
        $user_happy_money = $company_data[0]['user_happy_money'];
        $data = array( 'display_flag'=> 0, );
        $data1 = array('user_payment_status'=> 1,'apply_date'=>date("y-m-d H:i:s"));
        //check if 2 id exit in favorite_lists , to update display_flag=0(delete)
        if ($this->Musers->check_keep($userid,$ors_id)!=0)
        {
            $this->Musers->update_favorite_lists($data,$userid,$ors_id);
        }
        //check if 2 id exit in user_payments , to update display_flag=0(delete)
        if ($this->Musers->check_user_payments($userid,$ors_id)!=0)
        {
            $payment_status = $this->Musers->get_user_payments($userid,$ors_id);
            //echo $payment_status;
            if($payment_status ==2){
               $this->Musers->update_user_payments($data1,$userid,$ors_id);
            }
        }
        //check if 2 id not exit in user_payments insert to user_payments
        if ($this->Musers->check_user_payments($userid,$ors_id)==0)
        {
            $this->Musers->insert_user_payments($userid,$ors_id,date("y-m-d H:i:s"));
        }
        //get templates id
        if($user_happy_money > 0) {
          $vUs = 'us04';
          $vOw = 'ow07';
        }
        else {
          $vUs = 'us15';
          $vOw = 'ow24';
        }

        $mst_templates = $this->Musers->get_mst_templates($template_type = $vUs);
        $mst_templates1=$this->Musers->get_mst_templates($template_type = $vOw);

        //insert to list user messages
        $this->Musers->insert_list_user_messages($userid,$ors_id,date("y-m-d H:i:s"),$mst_templates);
        // insert to list_owner_messages
        $this->Musers->insert_list_owner_messages($ownerid,date("y-m-d H:i:s"),$mst_templates1);
        //get set send mail of user and owner
        $url= base_url().'user/celebration/company_celebration/'.$ors_id;
        if($this->Musers->setSendMail($userid)==1)
        {
           $this->common->sendMail( '', '', '', array($vUs),$ownerid,'', $userid,'getUserSelect','getJobUser','getJobOwner' ,'', $url,'');
        }
        if (($this->Musers->setSendMailOwner($ownerid) == 1)&& UserControl::getUserStt()==1) {
           $this->common->sendMail( '', '', '', array($vOw),$ownerid,'', $userid,'getUserSelect','getJobUser','getJobOwner' ,array($userid), $url,'');
        }

        echo true;
    }
}
?>

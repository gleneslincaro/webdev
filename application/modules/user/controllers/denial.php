<?php
class denial extends MY_Controller{
    private $viewData = array();
    private $common;
    private $validator;
    private $layout = 'user/layout/main';
    public function __construct() {
          parent::__construct();
		      $this->redirect_pc_site();
          $this->load->library("session");
          $this->load->library('user_agent');
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
    }
    /**
    * @author [IVS] My Phuong Thi Le
    * @name   index
    * @todo   view denial
    * @param
    * @return void
    */
    public function index($ors_id=0) {
        if($ors_id==0)
        {
            redirect(base_url()."user/errorpage");
        }

        if ($this->agent->is_mobile()) {
            $this->viewData['load_page'] = 'user/denial';
            $this->layout = "user/layout/main";
        /* pc */
        } else {
            $this->viewData['total_users'] = HelperGlobal::getUserTotalNumber();
            $this->viewData['total_owners'] = HelperGlobal::gettotalHeader();
            $this->viewData['load_page'] = 'user/pc/denial';
            $this->layout = "user/pc/layout/main";
            $breadscrumb_array = array(
                array("class" => "", "text" => "スカウトメール受信拒否設定", "link"=>"")
            );
            $this->viewData['breadscrumb_array'] = $breadscrumb_array;
        }

        $ownerid=$this->Musers->getOwnerId($ors_id);
        $owner=$this->Musers->get_owner($ownerid);
        $this->viewData['storename'] = $owner['storename'];
        $this->viewData['ors_id']= $ors_id;
        $this->viewData['titlePage'] = 'joyspe｜スカウトメール受信';
        $this->load->view($this->layout, $this->viewData);
    }
    /**
    * @author [IVS] My Phuong Thi Le
    * @name   denial_complete
    * @todo   update or insert and view denial complete
    * @param
    * @return void
    */
    public function denial_complete(){
        $userid = UserControl::getId();
        $ors_id = $this->input->post('ors_id');
        $ownerid=$this->Musers->getOwnerId($ors_id);
        //if exit to update scout_message_spams
        if ($this->Musers->check_denial($userid,$ownerid)!=0)
        {
            $display = $this->Musers->get_denial($userid,$ownerid);
            if($display == 0){
                $data = array(
                      'display_flag'=> 1,
                 );
                $this->Musers->update_scout_message_spams($data,$userid,$ownerid);
            }
        }

        if ($this->agent->is_mobile()) {
            $this->viewData['load_page'] = 'user/denial_complete';
            $this->layout = "user/layout/main";
        /* pc */
        } else {
            $this->viewData['total_users'] = HelperGlobal::getUserTotalNumber();
            $this->viewData['total_owners'] = HelperGlobal::gettotalHeader();
            $this->viewData['load_page'] = 'user/pc/denial_complete';
            $this->layout = "user/pc/layout/main";
            $breadscrumb_array = array(
                array("class" => "", "text" => "スカウトメール受信拒否設定", "link"=>"")
            );
            $this->viewData['breadscrumb_array'] = $breadscrumb_array;
        }

        //it not exit to insert scout_message_spams
        if ($this->Musers->check_denial($userid,$ownerid)==0)
        {
            $this->Musers->insert_scout_message_spams($userid,$ownerid);
        }
        $owner=$this->Musers->get_owner($ownerid);
        $this->viewData['storename'] = $owner['storename'];
        $this->viewData['titlePage'] = 'joyspe｜スカウトメール受信完了';
        $this->load->view($this->layout, $this->viewData);
    }
    /**
    * @author [IVS] My Phuong Thi Le
    * @name   not_denial
    * @todo   view not_denial
    * @param
    * @return void
    */
    public function not_denial($ors_id=0){
        if($ors_id==0)
        {
            redirect(base_url()."user/errorpage");
        }
        $ownerid=$this->Musers->getOwnerId($ors_id);
        $owner=$this->Musers->get_owner($ownerid);
        $this->viewData['storename'] = $owner['storename'];
        $this->viewData['ors_id']= $ors_id;
        /*sp*/
        if($this->agent->is_mobile()) {
          $this->viewData['load_page'] = 'user/not_denial';
          /*pc*/
        }else{
          $this->viewData['load_page'] = 'user/pc/not_denial';
          $this->layout = "user/pc/layout/main";
          $breadscrumb_array = array(
              array("class" => "", "text" => "スカウトメール受信", "link"=>"")
          );
          $this->viewData['breadscrumb_array'] = $breadscrumb_array;
        }

        $this->viewData['titlePage'] = 'joyspe｜スカウトメール受信';
        $this->load->view($this->layout, $this->viewData);
    }
    /**
    * @author [IVS] My Phuong Thi Le
    * @name   not_denial_complete
    * @todo   update or insert and view not denial complete
    * @param
    * @return void
    */
    public function not_denial_complete($ors_id=0){
        if($ors_id==0)
        {
            redirect(base_url()."user/errorpage");
        }
        $userid = UserControl::getId();
        //$ors_id = $this->input->post('ors_id');
        $ownerid=$this->Musers->getOwnerId($ors_id);
        // update scout_message_spams
        $display = $this->Musers->get_denial($userid,$ownerid);
        if($display == 1){
            $data = array(
                 'display_flag'=> 0,
             );
            $this->Musers->update_scout_message_spams($data,$userid,$ownerid);
        }
        //success
        $owner=$this->Musers->get_owner($ownerid);
        $this->viewData['storename'] = $owner['storename'];
        /*sp*/
        if($this->agent->is_mobile()) {
          $this->viewData['load_page'] = 'user/not_denial_complete';
        /*pc*/
        } else {
          $this->viewData['load_page'] = 'user/pc/not_denial_complete';
          $this->layout = "user/pc/layout/main";
          $breadscrumb_array = array(
              array("class" => "", "text" => "スカウトメール受信完了", "link"=>"")
          );
          $this->viewData['breadscrumb_array'] = $breadscrumb_array;
        }

        $this->viewData['titlePage'] = 'joyspe｜スカウトメール受信完了';
        $this->load->view($this->layout, $this->viewData);
    }
}
?>

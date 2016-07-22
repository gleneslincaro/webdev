<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Top extends MX_Controller {
    private $data;
    public function __construct() {
        parent::__construct();
        $this->data['module'] = $this->router->fetch_module();
    }

    /**
     * author: VJソリューションズ
     * name : index
     * todo : オンナーランディングページ表示
     * @param null
     * @return null
     */
    function index() {
        if (!OwnerControl::LoggedIn()){
            $this->load->view($this->data['module'] .'/layout/top');
        }else{
            $url = base_url().'owner/index';
            redirect($url);
        }
    }
    
    public function updateOwnerScoutMailQtyPerDay(){        
      if($_SERVER['REMOTE_ADDR'] == SERVER_ADDRESS) {
        $this->load->model('owner/Mowner');
        $this->Mowner->resetScoutMailQtyToOwners();
      } 
    }
    
    public function resetSiteRankRemainingUpdates() {        
      if ($_SERVER['REMOTE_ADDR'] == SERVER_ADDRESS) {
          $this->load->model('owner/Mowner');
          $this->Mowner->resetSiteRankRemainingUpdates();
      } 
    }
}


<?php

class errorpage extends MY_Controller{
    private $viewdata = array();
    private $common;
    private $validator;
    private $layout = 'user/layout/main_menu';
    public function __construct() {
        parent::__construct();
		$this->redirect_pc_site();
        $this->viewdata['idheader'] = 1;
      
    }
    public function index(){
        $this->viewdata['titlePage'] = 'joyspe｜error';
        $this->viewdata['load_page'] = 'user/error';
        $this->load->view($this->layout, $this->viewdata);
    }
    
}
?>

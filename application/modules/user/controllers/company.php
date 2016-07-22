<?php

class company extends MY_Controller {

    private $layout = "user/layout/main";
    private $viewData = array();

    public function __construct() {
        parent::__construct();
		$this->redirect_pc_site();
        $this->viewData['idheader'] = 10;
        $this->load->library('user_agent');
    }

    // 会社概要
    public function index() {
        if ($this->agent->is_mobile()) {
            $this->viewData['load_page'] = "user/view_company";
            $this->layout = "user/layout/main";
        /* pc */
        } else {
            $this->viewData['load_page'] = 'user/pc/footer/view_company';
            $this->layout = "user/pc/layout/main";
            $breadscrumb_array = array(array("class" => "", "text" => "会社概要", "link"=>""));
            $this->viewData['breadscrumb_array'] = $breadscrumb_array;
        }

        $this->viewData['titlePage'] = '運営会社｜風俗求人・高収入アルバイトのジョイスペ';
        $this->viewData['noCompanyInfo'] = true;        
        $this->load->view($this->layout, $this->viewData);
    }
}

?>

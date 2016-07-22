<?php

class my404 extends MX_Controller {
    public $data;
    public function __construct() {
        parent::__construct();
        $this->data['idheader'] = NULL;
        $this->load->library('user_agent');
    }
    public function index() {
        $this->output->set_status_header('404');
        $this->data['titlePage']= 'ページが見つかりませんでした｜風俗求人・高収入アルバイトのジョイスペ';
        if($this->agent->is_mobile()) {
            $this->data['load_page'] = 'user/view_my404';
            $this->load->view("user/layout/main", $this->data);
        } else {
            $this->data['load_page'] = 'user/pc/404_page';
            $this->data['from_404'] = 1;
            $breadscrumb_array = array(array("class" => "", "text" => "お探しのページは見つかりません。", "link"=>""));
            $this->data['breadscrumb_array'] = $breadscrumb_array;
            $this->load->view("user/pc/layout/main",$this->data);
        }
        
    }
}

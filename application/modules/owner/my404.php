<?php

class my404 extends MX_Controller {
    public $data;
    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->output->set_status_header('404');
        $this->data['loadPage'] = 'owner/my404/index';
        $this->load->view("owner/layout/layout_A", $this->data);
    }


}

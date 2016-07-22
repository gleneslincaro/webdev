<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class help extends Common {

    private $viewData=array();

    public function __construct() {
        parent::__construct();
        $this->output->set_header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate");
        $this->output->set_header("Cache-Control: post-check=0, pre-check=0");
        $this->output->set_header("Pragma: no-cache");
        if (!OwnerControl::LoggedIn()) {
            redirect(base_url() . "owner/login/");
        }
        $this->form_validation->CI = & $this;
    }

    public function index($page=1) {

        $title='joyspe｜ヘルプ';
        $owner_id = OwnerControl::getId();
        $owner_data = HelperGlobal::owner_info($owner_id);
        $this->viewData['title'] = $title;
        $this->viewData['owner_data'] = $owner_data;

        $this->viewData['loadPage'] = 'owner/help/help';
        $this->load->view("owner/layout/layout_A", $this->viewData);
    }

    public function scoutmail() {
        $title='joyspe｜ヘルプ';
        $owner_id = OwnerControl::getId();
        $owner_data = HelperGlobal::owner_info($owner_id);
        $this->viewData['title'] = $title;
        $this->viewData['owner_data'] = $owner_data;

        $this->viewData['loadPage'] = 'owner/help/scoutmail';
        $this->load->view("owner/layout/layout_A", $this->viewData);
    }

    public function scout_manual() {
        $title='joyspe｜自動送信機能マニュアル';
        $owner_id = OwnerControl::getId();
        $owner_data = HelperGlobal::owner_info($owner_id);
        $this->viewData['title'] = $title;
        $this->viewData['owner_data'] = $owner_data;

        $this->viewData['loadPage'] = 'owner/help/scout_manual';
        $this->load->view("owner/layout/layout_A", $this->viewData);
    }
}

?>

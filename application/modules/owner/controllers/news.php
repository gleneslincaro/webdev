<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class news extends Common {

    private $viewData=array();

    public function __construct() {
        parent::__construct();
        $this->load->model('owner/Mowner');
        $this->load->model('owner/Mcommon');
        $this->load->model('owner/Mnew');
        $this->common = new Common();
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

        $title='joyspe｜ユーザービュー';
        $owner_id = OwnerControl::getId();
        $owner_data = HelperGlobal::owner_info($owner_id);
        $page = $page > 1 ? $page : 1;
        $ppp = $this->config->item('per_page');

        $news = $this->Mnew->getNews( $page, $ppp);
        $total = $this->Mnew->countNews();
        $totalpage;
        if ($ppp != 0) {
            $totalpage = ceil($total / $ppp);
        }
        $this->viewData['totalpage'] = $totalpage;
        $this->viewData['total'] = $total;
        $this->viewData['title'] = $title;
        $this->viewData['owner_data'] = $owner_data;
        $this->viewData['news'] = $news;
        $this->viewData['paging'] = HelperApp::get_paging($ppp, base_url() . "owner/news/index", $total, $page);

        $this->viewData['loadPage'] = 'owner/new/news';
        $this->load->view("owner/layout/layout_A", $this->viewData);
      

    }

}

?>

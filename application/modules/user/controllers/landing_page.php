<?php
class landing_page extends MY_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->library('user_agent');
    }

    public function lp01()
    {
        $this->load->view("user/landing_page");
    }

    public function lp02()
    {
        $this->load->view("user/landing_page2");
    }

    public function lpstep()
    {
        $mid = $this->input->get("mid");
        $data = array();
        if ($mid) {
            $data["mid"] = $mid;
        }
        $this->load->view("user/landing_page_step", $data);
    }

    public function lp_hokkaido()
    {
        $this->load->view("user/lp_hokkaido");
    }

    public function lp_kanto()
    {
        $this->load->view("user/lp_kanto");
    }

    public function lp_kansai()
    {
        $this->load->view("user/lp_kansai");
    }

    public function lp_tokai()
    {
        $this->load->view("user/lp_tokai");
    }

}

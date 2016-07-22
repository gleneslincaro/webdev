<?php
class answer extends MY_Controller {
    private $page_line_max = 5;
    private $layout = "user/layout/main";
    private $layout_pc = "user/layout/pc_page";
    private $viewData = array();
    private $total_owners;
    private $keywords    = "風俗,求人,体育倉庫,/--TOWN--/,/--INDUSTRY--/";
    private $description = "風俗求人・高収入アルバイトは女性のためのハローワークと言えばジョイスペ。このページでは/--CITY--/・/--TOWN--/にある【/--STORENAME--/】の求人情報/--INDUSTRY--/をご案内します。採用でお祝い金をGET!";

    public function __construct()
    {
        parent::__construct();
        $this->load->library('user_agent');
        $this->load->library('cipher');
        $this->load->model("admin/Mmail");
        $this->load->model("user/Mnewjob_model");
        $this->load->model("user/Mscout");
        $this->load->model("user/Mstyleworking");
        $this->load->model("user/Mhappymoney");
        $this->load->model("user/Musers");
        $this->load->model("owner/Mbenefits");
        $this->load->model("owner/Mjobexplanation");
        $this->load->model("owner/Muserstatistics");
        $this->load->model("owner/Mspeciality");
        $this->load->model("user/mcampaign_bonus_request");
        $this->load->model("user/Mtravel_expense");
        $this->load->model("user/MCampaign");
        $this->load->model("user/Muser_statistics");
        $this->load->model("user/Muser_messege");
        $this->load->model("user/Mdialog_box");
        $this->common = new Common();
        $this->viewData['idheader'] = NULL;
        $this->viewData['total_users'] = HelperGlobal::getUserTotalNumber();
        $this->viewData['total_owners'] = $this->total_owners = HelperGlobal::gettotalHeader();
    }

    /*
    * @author: [VJS] Kiyoshi Suzuki
    * show page index
    */
    public function index()
    {

        $this->viewData['titlePage']= '風俗求人・高収入アルバイトがみつかる -ジョイスペ-';
        $this->viewData['description'] = '';


        if ($this->agent->is_mobile() or $this->agent->platform() == 'Android' or $this->agent->platform() == 'iOS') {
            $this->viewData['load_css'] = "user/layout/css_bbs";
            $this->viewData['load_page'] = "user/answer/index";
            $this->layout = "user/layout/main";
        /* pc */
        } else {
            $this->viewData['load_css'] = "user/pc/layout/css_bbs";
            $this->viewData['load_page'] = "user/pc/answer/index";
            $this->layout = "user/pc/layout/main";
        }

        $this->viewData['imagePath'] = base_url(). $this->config->item('upload_owner_url') . 'images/';
        $this->load->view($this->layout, $this->viewData);
    }

}
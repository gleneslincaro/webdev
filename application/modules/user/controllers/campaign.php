<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

 class Campaign extends MX_Controller {
  	private $layout = "user/layout/main";
    private $viewData = array();

    public function __construct() {
        parent::__construct();
        HelperGlobal::require_login(base_url() . uri_string());
        $this->load->model("user/Musers");
        $this->viewData['idheader'] = NULL;
        $this->viewData['class_ext'] = "campaign";
        $this->load->library('user_agent');
    }

    // リクエスト一覧表示
    public function index() {
		if (UserControl::LoggedIn()){
			$user_id= UserControl::getId();
		}
        $expense_pay_requests = null;
		// リクエストリスト取得
		$filter_status = $this->input->get('filter_status');
		// Pagination
		$total_number             = $this->Musers->getAllRequestNo( $filter_status, $user_id );
		$config['base_url']       = base_url('user/campaign/index');
		$config['total_rows']     = $total_number;
		$config['constant_num_links'] = TRUE;
		$config['uri_segment']    = 4;
		$config["per_page"]       = $req_per_page = $this->config->item('per_page');
		// GET データ保存
		if ($filter_status){
			$config['suffix'] = '?filter_status=' . (int)$filter_status;
			$config['first_url'] = $config['base_url'] . '?filter_status=' . (int)$filter_status;
		}
		$this->pagination->initialize($config);
		$start_offset = intval($this->uri->segment(4));
		if ($start_offset == NULL) {
			$start_offset = 0;
		}
		$expense_pay_requests = $this->Musers->getUserBonusCampaign($req_per_page, $start_offset, $filter_status, $user_id);

		/* sp */
		if ($this->agent->is_mobile()) {
			$this->viewData["load_page"] = "user/campaign/index";
		/* pc */
		} else {
			$this->viewData['total_users'] = HelperGlobal::getUserTotalNumber();
			$this->viewData['total_owners'] = HelperGlobal::gettotalHeader();
			$this->viewData["load_page"] = "user/pc/campaign/index";
			$this->layout = "user/pc/layout/main";
			$breadscrumb_array = array(
				array("class" => "", "text" => "面接交通費/入店お祝い金申請一覧", "link"=>"")
			);
			$this->viewData['breadscrumb_array'] = $breadscrumb_array;
		}

		$this->viewData["titlePage"] = "面接交通費/入店お祝い金申請一覧";
		$this->viewData['expense_pay_requests'] = $expense_pay_requests;
		$this->load->view($this->layout,$this->viewData);
    }
}
?>

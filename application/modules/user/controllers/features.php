<?php
class features extends MY_Controller {
	private $viewdata = array();
	private $layout = "";
	private $common = null;

	function __construct()
    {
        parent::__construct();
        $this->load->model("user/mcampaign_bonus_request");
        $this->common = new Common();
		$this->viewdata['total_users'] = HelperGlobal::getUserTotalNumber();
		$this->viewdata['total_owners'] = HelperGlobal::gettotalHeader();
    }

	public function index($name='hibarai') {
		$this->load->library('user_agent');
        /* sp */
        if ($this->agent->is_mobile()) {
            redirect('/'); // no mobile page for this link
		}
		/* pc */
		$city_group = $this->mcity->getCityGroup();
    	$this->viewdata['city_group'] = $city_group;
    	$this->layout = "user/pc/layout/main";
        $this->viewdata['titlePage'] = '風俗求人・高収入アルバイトがみつかる -ジョイスペ-';
		$this->viewdata['banner_bonus_req'] = $this->mcampaign_bonus_request->getLatestCampaignBonusBanner();
        $this->viewdata['banner_data'] = $this->common->getLatestBanner();
		$this->viewdata['searchRes'] = true;
        switch ($name) {
        	case 'trial':
        		$this->viewdata['load_page'] = 'pc/feature/feature_'.$name;
				$this->viewdata['titlePage'] = $this->viewdata['keyword'] = '特集・体験入店できるお店';
        		break;
        	case 'deriheru':
        		$this->viewdata['load_page'] = 'pc/feature/feature_'.$name;
				$this->viewdata['titlePage'] = $this->viewdata['keyword'] = '特集・デリヘリで安全で稼ぐ';
        		break;
        	default:
        		$this->viewdata['load_page'] = 'pc/feature/feature_hibarai';
				$this->viewdata['titlePage'] = $this->viewdata['keyword'] = '特集・日払いで貰えるお店';
        		break;
        }

        $this->load->view($this->layout, $this->viewdata);
	}
}

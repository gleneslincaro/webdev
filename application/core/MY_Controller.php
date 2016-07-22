<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/* load the MX_Router class */
require APPPATH."third_party/MX/Controller.php";

class MY_Controller extends MX_Controller {
	
	public function __construct() {
		parent::__construct();
	}

	/**
	 * PCかどうかの確認。(PCの場合はTOPに戻す)
	 */
	protected function redirect_pc_site(){
		/*$this->load->library('user_agent');
		if(!$this->agent->is_mobile()){
			redirect(base_url(), 'location', 302);
			exit;
		}*/
	}
	
}
<?php
class Menu extends MY_Controller{
	function __construct() {
		parent::__construct();
		$this->redirect_pc_site();
        $this->load->model('user/Muser_messege');
        $this->load->model('user/Mnewjob_model');
        $this->viewData['idheader'] = NULL;
    }
    private $layout = "user/layout/main_menu";
    private $viewData = array();
    public function index()
    {
        $user = UserControl::getUser();
        if ($user) {
            if ($user['user_from_site'] != 0) { // マキア&マシェモバユーザの場合
                $this->viewData['display_bonus_menu_flg'] = 1;
            } else {
                $this->viewData['display_travel_expense_flg'] = 1;
            }
        }
        $gettype =1;
        $this->viewData['user_from_site'] = $user['user_from_site'];
        $this->viewData['gettype'] = $gettype;
        $this->viewData['titlePage'] = 'joyspe｜TOPページ';
        $this->viewData['load_page'] = "user/menu/menu";
        $this->load->view($this->layout, $this->viewData);
    }
}
?>

<?php
class message_campaign extends MY_Controller
{
    private $viewdata= array();
    private $layout="user/layout/main";
    function __construct() {
        parent::__construct();
        $this->redirect_pc_site();
        $this->load->Model("user/Mcampaign");   
        $this->common = new Common();
        $this->viewdata['idheader'] = 1;
        $this->viewdata['class_ext'] = "contact_campaign";
        HelperGlobal::require_login(base_url() . uri_string());
    }

    public function index() {
        $userId = UserControl::getId();        
        $user_from_site = UserControl::getFromSiteStatus();
        if ($user_from_site == 0) {
            redirect(base_url());
        }
        $this->viewdata['message_campaign'] = $this->Mcampaign->getMessageCampaignOwnerList();
        $this->viewdata['load_page'] = "user/message_campaign";       
        $this->viewdata['titlePage'] = 'joyspe｜メッセージキャンペーン';
        $this->load->view($this->layout, $this->viewdata);
    } 
}
?>

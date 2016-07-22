<?php

class Profile extends MX_Controller {

    private $viewData;

    function __construct() {
        parent::__construct();
        $this->load->helper('breabcrumb_helper');
        $this->load->model('owner/Mprofile');
        $this->output->set_header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate");
        $this->output->set_header("Cache-Control: post-check=0, pre-check=0");
        $this->output->set_header("Pragma: no-cache");
    }

    /**
     * @author  [IVS] Phan Ngoc Minh Luan
     * @name 	user_profile
     * @todo 	show info's user
     * @param 	 $user_id
     * @return 	void
     */
    public function index($user_id = null) {
        if ($user_id != null) {
            $owner_id = OwnerControl::getId();
            if ($owner_id) {
                $email_address = OwnerControl::getEmail();
                $owners = $this->Mprofile->getTotal($email_address);
                $point_owner = $owners['total_point'];
                $user_profiles = $this->Mprofile->getUserProfiles($user_id);
                $job_types = $this->Mprofile->getJobTypeUsers($user_id);
                $owner_info = HelperGlobal::owner_info($owner_id);
                $this->viewData['owner_info'] = $owner_info;
                $this->viewData['job_types'] = $job_types;
                $this->viewData['up'] = $user_profiles;
                $this->viewData['total_point'] = $point_owner;
                $this->viewData['loadPage'] = "profile/profile";
                $this->viewData['title'] = 'joyspe｜ユーザープロフィール';
                $this->load->view('owner/layout/layout_B', $this->viewData);
            } else {
                redirect(base_url() . "owner/login");
            }
        } else {
            show_404();
        }
    }

}

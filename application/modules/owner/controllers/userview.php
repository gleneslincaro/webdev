<?php

class  userview extends MX_Controller
{   
     private $viewData = array();
     public function __construct() {
        parent::__construct();
        $this->load->model('owner/Muserview');
        $this->load->model("user/Mscout");
        if (!OwnerControl::LoggedIn()) {
            redirect(base_url() . "owner/login/");
        }
        $this->output->set_header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate");
        $this->output->set_header("Cache-Control: post-check=0, pre-check=0");
        $this->output->set_header("Pragma: no-cache");
    }
    public function index() {
   
        $title = 'joyspe｜ユーザービュー';
        $owner_id = OwnerControl::getId();
        $owner_data = HelperGlobal::owner_info($owner_id);
//        $path = $this->config->item('upload_owner_dir') . '/image/';
       
        // Get owner_id
        $id = OwnerControl::getId();
        $company_data = $this->Muserview->getAllCompany($id);
        $user_id=0;
        //var_dump($company_data); exit;
        foreach ($company_data as $key => $v) {
          $company_data[$key]['jobtypename'] = $this->Muserview->getJobTypeCompany($v['Ow_id']);
          $company_data[$key]['treatment'] = $this->Muserview->getTreatmentCompany($v['Ow_id']);
          $company_data[$key]['keepstt']=$this->Mscout->getUserKeepSTT($v['Ow_id'],$user_id);
        }

        $this->viewData['company_data'] = $company_data;       
        $this->viewData['cTitle'] = $company_data != null ? $company_data[0]['title']: "";
        $this->viewData['owner_data'] = $owner_data;
        $this->viewData['title'] = $title;
        $this->viewData['imagePath'] = base_url(). $this->config->item('upload_owner_url') . 'images/';
        $this->viewData['loadPage'] = 'owner/userview/userview';
        $this->load->view("owner/layout/layout_A", $this->viewData);
    }
}
 
?>

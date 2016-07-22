<?php

class Privacy extends MX_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('owner/Mowner');
    }

    public $viewData = array();

    /**
     * @author [IVS] Nguyen Hong Duc
     * @name   privacy
     * @todo   index
     * @param  null
     * @return null
     */
    public function index() {
        $title='joyspe｜プライバシーポリシー';
        $ownerId = OwnerControl::getId();
        $this->viewData['loadPage'] = 'owner/privacy/privacy';
        $owner = $this->Mowner->getOwner($ownerId);
        $owner_recruit = $this->Mowner->getOwnerRecruit($ownerId);

        if ($ownerId) {
            if ($owner['owner_status'] == 0) {
                $this->viewData['title'] = $title;
                $this->load->view("owner/layout/layout_C", $this->viewData);
            } else if ($owner['owner_status'] == 1 || $owner['owner_status'] == 2) {
                if (count($owner_recruit) == 0) { // hasn't got a recruit
                    $this->viewData['title'] = $title;
                    $this->load->view("owner/layout/layout_C", $this->viewData);
                } else if ($owner_recruit['recruit_status'] == 1) { // had recruit
                    $this->viewData['title'] = $title;
                    $this->load->view("owner/layout/layout_C", $this->viewData);
                } else if ($owner_recruit['recruit_status'] == 2) { // recruit was be approved
                    $this->viewData['title'] = $title;
                    $this->load->view("owner/layout/layout_E", $this->viewData);
                } else if ($owner_recruit['recruit_status'] == 3) { // recruit was be denied
                    $this->viewData['title'] = $title;
                    $this->load->view("owner/layout/layout_C", $this->viewData);
                }
            } elseif ($owner['owner_status'] == 3) {
                $this->viewData['title'] = $title;
                $this->load->view("owner/layout/layout_C", $this->viewData);
            }
        } else {
            $this->viewData['title'] = $title;
            $this->load->view("owner/layout/layout_C", $this->viewData);
        }
    }

}

?>

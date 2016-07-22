<?php

class Inquiry extends MX_Controller {

    private $message = array('success' => true, 'error' => array());

    public function __construct() {
        parent::__construct();
        $this->load->model('owner/Mowner');
        $this->load->library('session');
        $this->output->set_header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate");
        $this->output->set_header("Cache-Control: post-check=0, pre-check=0");
        $this->output->set_header("Pragma: no-cache");
        $this->form_validation->CI = & $this;
    }

    public $viewData = array();

    /**
     * @author [IVS] Nguyen Hong Duc
     * @name   inquiry
     * @todo   index
     * @param  null
     * @return null
     */
    public function index() {
        if ($_POST) {
            if ($this->validate()) {
                $senderName = $this->input->post('txtStoreName');
                $from = $this->input->post('txtEmail');
                $subject = $this->input->post('txtSubject');
                $body = $this->input->post('txaBody');

                Common::sendMailFeedBack($from, $this->config->item('smtp_user'), '', '', $subject, $body, $senderName);
                redirect(base_url() . "owner/inquiry/inquiry_after");
            }
        }
        $sSubject = $this->input->post('txtSubject');
        $sBody = $this->input->post('txaBody');
        $sStoreName = $this->input->post('txtStoreName');
        $sEmail = $this->input->post('txtEmail');
        HelperApp::add_session('sSubject', $sSubject);
        HelperApp::add_session('sBody', $sBody);
        HelperApp::add_session('sStoreName', $sStoreName);
        HelperApp::add_session('sEmail', $sEmail);
        $this->viewData['sSubject'] = HelperApp::get_session('sSubject');
        $this->viewData['sBody'] = HelperApp::get_session('sBody');
        $this->viewData['storename'] = HelperApp::get_session('sStoreName');
        $this->viewData['email'] = HelperApp::get_session('sEmail');
        $ownerId = OwnerControl::getId();
        if ($ownerId) {
            $email = OwnerControl::getEmail();
            $storename = OwnerControl::getStoreName();
            $this->viewData['email'] = $email;
            $this->viewData['storename'] = $storename;
        }
        $this->viewData['message'] = $this->message;
        $this->viewData['loadPage'] = 'owner/inquiry/inquiry';
        $this->viewData["title"]="joyspe｜問合せフォーム";
        $owner = $this->Mowner->getOwner($ownerId);
        $owner_recruit = $this->Mowner->getOwnerRecruit($ownerId);

        if ($ownerId) {
            if ($owner['owner_status'] == 0) {
                $this->load->view("owner/layout/layout_C", $this->viewData);
            } else if ($owner['owner_status'] == 1 || $owner['owner_status'] == 2) {
                if (count($owner_recruit) == 0) { // hasn't got a recruit
                    $this->load->view("owner/layout/layout_C", $this->viewData);
                } else if ($owner_recruit['recruit_status'] == 1) { // had recruit
                    $this->load->view("owner/layout/layout_C", $this->viewData);
                } else if ($owner_recruit['recruit_status'] == 2) { // recruit was be approved
                    $this->load->view("owner/layout/layout_E", $this->viewData);
                } else if ($owner_recruit['recruit_status'] == 3) { // recruit was be denied
                    $this->load->view("owner/layout/layout_C", $this->viewData);
                }
            } elseif ($owner['owner_status'] == 3) {
                $this->load->view("owner/layout/layout_C", $this->viewData);
            }
        } else {
            $this->load->view("owner/layout/layout_C", $this->viewData);
        }
    }

    /**
     * @author: [IVS] Nguyen Hong Duc
     * @name : checkMail
     * @todo : check storename, email, title, body
     * @param null
     * @return boolean
     */
    public function validate() {
        $email = trim($this->input->post('txtEmail'));
        $storeName = trim($this->input->post('txtStoreName'));
        $subject = trim($this->input->post('txtSubject'));
        $body = trim($this->input->post('txaBody'));

        $this->form_validation->set_rules('txtEmail', 'メールアドレス', 'trim|required|max_length[200]|checkStringByte|valid_email');
        $this->form_validation->set_rules('txtStoreName', '会社名・店舗名', 'trim|required|max_length[100]');
        $this->form_validation->set_rules('txtSubject', '件名', 'trim|required|max_length[100]');
        $this->form_validation->set_rules('txaBody', 'メッセージ', 'trim|required|max_length[10000]');

        $form_validation = $this->form_validation->run();
        $this->message['success'] = !$form_validation && count($_POST) > 0 ? FALSE : TRUE;

        if (!$form_validation) {
            return false;
        }

        return true;
    }

    /**
     * @author	[IVS]Trieu Nguyen Bao
     * @name	checkStringByte
     * @todo	Check string's byte    
     * @param	null
     * @return  boolen
     */
    function checkStringByte() {

        $str_ar = str_split($this->input->post('email'));
        for ($i = 0; $i < sizeof($str_ar); $i++) {
            $byte = strlen($str_ar[$i]);
            if ($byte > 1) {
                return false;
            }
        }
        return true;
    }

    /**
     * @author: [IVS] Nguyen Hong Duc
     * @name : inquiry_after
     * @todo : alert send mail
     * @param null
     * @return null
     */
    function inquiry_after() {
        $this->viewData['loadPage'] = 'owner/inquiry/inquiry_after';
        $this->viewData['title'] = 'joyspe｜問合せフォーム';
        $ownerId = OwnerControl::getId();
        $owner = $this->Mowner->getOwner($ownerId);
        $owner_recruit = $this->Mowner->getOwnerRecruit($ownerId);
        if ($ownerId) {
            if ($owner['owner_status'] == 0) {
                $this->load->view("owner/layout/layout_C", $this->viewData);
            } else if ($owner['owner_status'] == 1 || $owner['owner_status'] == 2) {
                if (count($owner_recruit) == 0) { // hasn't got a recruit
                    $this->load->view("owner/layout/layout_C", $this->viewData);
                } else if ($owner_recruit['recruit_status'] == 1) { // had recruit
                    $this->load->view("owner/layout/layout_C", $this->viewData);
                } else if ($owner_recruit['recruit_status'] == 2) { // recruit was be approved
                    $this->load->view("owner/layout/layout_E", $this->viewData);
                } else if ($owner_recruit['recruit_status'] == 3) { // recruit was be denied
                    $this->load->view("owner/layout/layout_C", $this->viewData);
                }
            } elseif ($owner['owner_status'] == 3) {
                $this->load->view("owner/layout/layout_C", $this->viewData);
            }
        } else {
            $this->load->view("owner/layout/layout_C", $this->viewData);
        }
    }

}

?>

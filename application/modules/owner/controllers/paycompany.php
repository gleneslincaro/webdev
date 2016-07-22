<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Paycompany extends MX_Controller {

    private $data;
    private $message = array('success' => true, 'error' => array());

    public function __construct() {
        parent::__construct();
        $this->common = new Common();
        $this->load->Model(array('owner/mowner','owner/mtemplate','owner/mcommon', 'user/Mcaptcha'));
        $this->data['module'] = $this->router->fetch_module();
        $this->form_validation->CI = & $this;
        HelperApp::start_session();
    }

    public function index() {
        $city_groups = $this->mowner->getGroups();
        $jobTypes = $this->mowner->getJobType();
        $this->data['city_groups'] = $city_groups;
        $this->data['jobTypes'] = $jobTypes;

        if ($_POST) {
            $data = array (
                    'city_group' => $this->input->post('city_group'),
                    'city' => $this->input->post('city'),
                    'town' => $this->input->post('town'),
                    'storename' => $this->input->post('storename'),
                    'job_type' => $this->input->post('jobtype'),
                    'tel' => $this->input->post('tel'),
                    'email' => $this->input->post('email'),
                    'person_in_charge' => $this->input->post('person_in_charge'),
                    'campaign_note' => $this->input->post('campaign_note') ? $this->input->post('campaign_note') : ''
                );
            $this->common->sendMailpayCompany($data, 'ss11');
            redirect(base_url() . "owner/paycompany/success");
        }

        $this->data['loadPage'] = 'paycompany/paycompany_registration';
        $this->data['message'] = $this->message;
        $this->data['title'] = 'joyspe｜ログイン - 新規会員登録フォーム';
        $this->load->view($this->data['module'] . '/layout/layout_C', $this->data);
    }

    public function checkinput() {
        $ret = '';
        $this->form_validation->set_rules('city_group_id', 'エリア地域', 'trim|required');
        $this->form_validation->set_rules('city_id', 'エリア都道府県', 'trim|required');
        $this->form_validation->set_rules('town_id', 'エリア都市', 'trim|required');
        $this->form_validation->set_rules('storename', '店舗名', 'trim|required');
        $this->form_validation->set_rules('job_type', '業種', 'trim|required');
        $this->form_validation->set_rules('tel', '電話番号', 'trim|required');
        $this->form_validation->set_rules('email', 'メールアドレス', 'trim|required|valid_email');
        $this->form_validation->set_rules('person_in_charge', 'ご担当者様氏名', 'trim|required');
        $this->form_validation->set_rules('campaign_note', 'campaign_note');

        $form_validation = $this->form_validation->run();
        if (!$form_validation) {
          $ret = validation_errors();
        }

        $arr = array('err' => $ret);

        echo json_encode($arr);
        
    }

    public function success() {
        $this->data['loadPage'] = 'paycompany/success_page';
        $this->data['title'] = 'joyspe｜ログイン - 新規会員登録フォーム';
        $this->load->view($this->data['module'] . '/layout/layout_C', $this->data);
    }
}

?>

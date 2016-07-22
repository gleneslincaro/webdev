<?php
class Inquiry extends MY_Controller{
    private $viewdata= array();
    private $common;
    private $layout="user/layout/main";
    private $message = array('success' => true, 'error' => array());
    private $breadscrumb_array = array();
    function __construct() {
        parent::__construct();
        $this->common = new Common();
        $this->viewdata['idheader'] = NULL;
        $this->load->model("owner/Mowner");
        $this->load->model("user/Musers");
        $this->viewdata['class_ext'] = 'before_contact';
        $this->load->library('user_agent');
    }

    public function index($owrId) {
        if (!$owrId) {
            redirect(base_url());
        }
        $this->load->library("form_validation");
        $ownerRecruitInfo = $this->Mowner->getOwnerRecruitByowrId($owrId);
        if (!$ownerRecruitInfo) {
            redirect(base_url() . 'user/');
        }

        if ($_POST) {
            $this->form_validation->set_rules('uname', 'お名前', 'trim|required');
            $this->form_validation->set_rules('age', '年齢', 'trim|required');
            $this->form_validation->set_rules('contact', 'メールアドレス', 'required|valid_email|checkStringByte');
            $this->form_validation->set_rules('mess', '聞きたいこと', 'trim|required');
            $this->form_validation->set_rules('storname', '店舗名', '');
            $this->form_validation->set_rules('user_title', '件名', '');
            $this->form_validation->set_error_delimiters('<div class="ui_msg ui_msg-error"><p>', '</p></div>');
            $form_validation = $this->form_validation->run();
            $this->message['success'] = !$form_validation ? FALSE : TRUE;
            if ($form_validation) {
                $storname = $this->input->post("storname");
                $title = $this->input->post("user_title");
                $uname = $this->input->post("uname");
                $age = $this->input->post("age");
                $email = $this->input->post("contact");
                $content = trim($this->input->post("mess"));
                $mailtype = $this->input->post("mailtype");
                $this->viewdata['confirm'] = true;
                $test = $this->input->post("send_mail");
                if ($this->input->post("send_mail")) {
                    //send mail
                    $noneMemberInfo = $this->Musers->getNoneMemberEmail($email);
                    if ($noneMemberInfo) {
                        $noneMemberId = $noneMemberInfo['id'];
                    } else {
                        $data = array(
                                'name'              => $uname,
                                'age'               => $age,
                                'email_address'     => $email,
                                'created_date'      => date("y-m-d H:i:s")
                            );
                        $noneMemberId = $this->Musers->insertNoneMember($data);
                    }

                    $data = array('none_member_id' => $noneMemberId,
                            'owner_id' => $ownerRecruitInfo['owner_id'],
                            'title' => $title,
                            'content' => $storname . "様へ\n\n" .$content,
                            'created_date' => date("y-m-d H:i:s"),
                            'updated_date' => date("y-m-d H:i:s"),
                            'msg_from_flag' => 0);
                    $id = $this->Musers->insert_user_owner_message($data);
                    $this->common->sendToAdminNonMember($owrId, $email, $uname, $age, $content, $title);
                    //send success
                    HelperApp::add_session('inquiry_msg', true);
                    redirect(base_url() . "user/inquiry/complete/");
                }
            }
        }

        $this->viewdata['ownerRecruitInfo'] = $ownerRecruitInfo;
        $this->viewdata['noCompanyInfo'] = true;
        $this->viewdata['message'] = $this->message;
        $this->viewdata['titlePage']= 'joyspe｜TOPページ';

        /*sp*/
        if($this->agent->is_mobile()) {
            $this->viewdata['load_page'] = "inquiry/inquiry_non_user";
        }
        /*pc*/
        else {
            $this->viewdata['total_users'] = HelperGlobal::getUserTotalNumber();
            $this->viewdata['total_owners'] = HelperGlobal::gettotalHeader();
            $this->viewdata['load_page'] = "pc/inquiry/inquiry_non_user";
            $this->breadscrumb_array[] = array("class" => "", "text" => "お問い合わせ", "link"=>"");
            $this->layout = "user/pc/layout/main";
        }
        $this->viewdata['breadscrumb_array'] = $this->breadscrumb_array;
        /*$this->viewdata['inquiry_msg'] = HelperApp::get_session('inquiry_msg');
        HelperApp::remove_session('inquiry_msg');*/
        $this->load->view($this->layout, $this->viewdata);
    }

    public function complete() {

        $this->viewdata['titlePage']= 'joyspe｜TOPページ';
         /*sp*/
        if($this->agent->is_mobile()) {
            $this->viewdata['load_page'] = "inquiry/complete";
        }
        /*pc*/
        else {
            $this->viewdata['total_users'] = HelperGlobal::getUserTotalNumber();
            $this->viewdata['total_owners'] = HelperGlobal::gettotalHeader();
            $this->viewdata['load_page'] = "pc/inquiry/complete";
            $this->breadscrumb_array[] = array("class" => "", "text" => "お問い合わせ", "link"=>"");
            $this->layout = "user/pc/layout/main";
        }
        $this->viewdata['breadscrumb_array'] = $this->breadscrumb_array;
        $this->load->view($this->layout, $this->viewdata);
    }
}
?>

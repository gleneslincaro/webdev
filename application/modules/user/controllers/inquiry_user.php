<?php
class Inquiry_user extends MY_Controller{
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
        $this->load->model("user/Muser_statistics");
        $this->viewdata['class_ext'] = 'before_contact';
        $this->load->library('user_agent');
    }

    public function index($owrId)
    {
        if (!$owrId) {
            redirect(base_url());
        }
        $this->load->library("form_validation");
        $ownerRecruitInfo = $this->Mowner->getOwnerRecruitByowrId($owrId);
        if (!$ownerRecruitInfo) {
            redirect(base_url() . 'user/');
        }

        $this->load->model("owner/Mowner");
        $user_id = UserControl::getId();
        if (!$user_id) { // only for login user
            return;
        }

        if ($_POST) {
            $this->form_validation->set_rules('storname', '店舗名', '');
            $this->form_validation->set_rules('user_title', '件名', '');
            $this->form_validation->set_rules('mess', '聞きたいこと', 'trim|required');
            $this->form_validation->set_error_delimiters('<div class="ui_msg ui_msg-error"><p>', '</p></div>');
            $form_validation = $this->form_validation->run();
            $this->message['success'] = !$form_validation ? FALSE : TRUE;
            if ($form_validation) {
                $storname = $this->input->post("storname");
                $title = $this->input->post("user_title");
                $content = trim($this->input->post("mess"));
                $this->viewdata['confirm'] = true;
                $test = $this->input->post("send_mail");
                if ($this->input->post("send_mail")) {
                    $owner_id = $ownerRecruitInfo['owner_id'];
                    //send mail
                    $data = array('user_id' => $user_id,
                            'owner_id' => $ownerRecruitInfo['owner_id'],
                            'title' => $title,
                            'content' => $storname . "様へ\n\n" .$content,
                            'created_date' => date("y-m-d H:i:s"),
                            'updated_date' => date("y-m-d H:i:s"),
                            'msg_from_flag' => 0);
                    $id = $this->Musers->insert_user_owner_message($data);

                    $this->Muser_statistics->updateClick($user_id, 'QUESTION');

                    $data = array(
                              'user_id' => $user_id,
                              'owner_id' => $ownerRecruitInfo['owner_id'],
                              'owner_recruit_id' => $owrId,
                              'action_type' => 4,
                              'created_date' => date('Y-m-d H:i:s')
                           );
                    $this->Muser_statistics->insertUserStatisticsLog($data);

                    if ($id) {
                        if ($this->Musers->checkIfUserFirstTimeMessageToOwner($user_id)) {
                            // give first point to makia/machemoba users only
                            if (UserControl::getFromSiteStatus() == 1 || UserControl::getFromSiteStatus() == 2) {
                                $this->Musers->updateBonusPoint($user_id, 100, BONUS_REASON_FIRST_MSG);
                            }
                            $data = array(
                                'first_message_flag' => 1,
                                'updated_date' => date("y-m-d H:i:s")
                            );
                            $this->Musers->updateUserFirstMessage($data, $id);
                        } else {
                            // grant 100 points for first message after joining a campaign
                            if (UserControl::getFromSiteStatus() == 1 || UserControl::getFromSiteStatus() == 2) {
                                if ($current_campaign = $this->Musers->getCurStepUpCampaign($user_id)) {
                                    $joined_date = $current_campaign['campaign_join_date'];
                                    if ($this->Musers->isFirstMessageSinceJoinedCampaign($user_id, $joined_date)) {
                                        $this->Musers->updateBonusPoint($user_id, 100, BONUS_REASON_FIRST_MSG);
                                    }
                                }
                            }
                        }
                        // update step up campaign progress(step 2)
                        $this->Musers->checkAndUpdateCampaignProgress($user_id, BONUS_REASON_FIRST_MSG);
                        $this->common->sendNotificationToOwner($owner_id, $user_id, $title);
                    }

                    //send success
                    HelperApp::add_session('inquiry_msg', true);
                    redirect(base_url() . "user/inquiry_user/complete/");
                }
            }
        }
        $this->viewdata['ownerRecruitInfo'] = $ownerRecruitInfo;
        $this->viewdata['noCompanyInfo'] = true;
        $this->viewdata['message'] = $this->message;
        $this->viewdata['titlePage']= 'joyspe｜TOPページ';

        $this->viewdata['total_users'] = HelperGlobal::getUserTotalNumber();
        $this->viewdata['total_owners'] = HelperGlobal::gettotalHeader();
        $this->viewdata['load_page'] = "pc/inquiry/inquiry_user";
        $this->breadscrumb_array[] = array("class" => "", "text" => "お問い合わせ", "link"=>"");
        $this->layout = "user/pc/layout/main";

        $this->viewdata['breadscrumb_array'] = $this->breadscrumb_array;
        $this->load->view($this->layout, $this->viewdata);
    }

    public function complete()
    {

        $this->viewdata['titlePage']= 'joyspe｜TOPページ';
         /*sp*/
        if ($this->agent->is_mobile()) {
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
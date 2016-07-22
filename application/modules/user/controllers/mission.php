<?php
class mission extends MY_Controller {
    private $viewdata= array();
    private $layout="user/layout/main";
    function __construct() {
        parent::__construct();
        $this->redirect_pc_site();
        $this->load->model("user/Musers");
        $this->viewdata["idheader"] = 1;
    }

    public function index() {
        $userId = UserControl::getId();
        $userFromSite = $this->Musers->getUserSite($userId);
        if ($userFromSite['user_from_site'] == 0) {
            redirect(base_url());
        }
        $canAvailStepUpCampaign = false;
        $userData = $this->Musers->get_users($userId);
        $available_campaign_id = $this->Musers->canJoinStepUpCampaign($userId);
        if ($available_campaign_id) {
            $this->Musers->startJoinACampaign($userId, $available_campaign_id);
        }

        $stepUpNewCampProg = $this->Musers->getNewStepUpCampaignProgress($userId, $available_campaign_id);
        if ($available_campaign_id) {
            if ($stepUpNewCampProg['step1_fin_flag'] == 1 && $stepUpNewCampProg['step2_fin_flag'] == 1 && $stepUpNewCampProg['step3_fin_flag'] == 1 && $stepUpNewCampProg['step4_fin_flag'] == 1 && $stepUpNewCampProg['step5_fin_flag'] == 1) {
                $this->viewdata["requestMagnificationBonus"] = true;
            }
            $stepUpNewCamp = $this->Musers->getNewStepUpCampaign($stepUpNewCampProg['step_up_campaign_id']);
            if ($stepUpNewCamp) {
                if ($stepUpNewCamp['new_campaign_flag'] == 1) {
                    $stepUpNewCamp["campaign1_end_date"] = date("y/m/d", strtotime($stepUpNewCampProg['offcial_reg_date']. " + ".$stepUpNewCamp['campaign1_valid_days']." days"));
                    $campaignEndDate = strtotime($stepUpNewCampProg['offcial_reg_date']. " + ".$stepUpNewCamp['campaign1_valid_days']." days");
                    if (date('Y-m-d',$campaignEndDate) <= date('Y-m-d')) {
                        $plusDate = $stepUpNewCamp['campaign1_valid_days'] + $stepUpNewCamp['campaign_retry_days'];
                        $stepUpNewCamp["campaign1_end_date"] = date("y/m/d", strtotime($stepUpNewCampProg['offcial_reg_date']. " + ".$plusDate." days"));
                        $campaignEndDate = strtotime($stepUpNewCampProg['offcial_reg_date']. " + ".$plusDate." days");
                    }
                }
                else {
                    $stepUpNewCamp["campaign2_end_date2"] = date("y/m/d", strtotime($stepUpNewCamp['campaign2_end_date']));
                    $campaignEndDate = strtotime($stepUpNewCamp['campaign2_end_date']);
                    if (date('Y-m-d',$campaignEndDate) <= date('Y-m-d')) {
                        $stepUpNewCamp["campaign2_end_date2"] = date("y/m/d", strtotime($stepUpNewCamp['campaign2_end_date']." + ".$stepUpNewCamp['campaign_retry_days']." days"));
                        $campaignEndDate = strtotime($stepUpNewCamp['campaign2_end_date']." + ".$stepUpNewCamp['campaign_retry_days']." days");
                    }
                }

                $scoutMailBonus = $this->Musers->getCampaignBonus($userId, BONUS_REASON_OPEN_SCOUT_MAIL, $stepUpNewCampProg['campaign_join_date']);
                $inquiryBonus = $this->Musers->getCampaignBonus($userId, BONUS_REASON_FIRST_MSG, $stepUpNewCampProg['campaign_join_date']);
                $loginBonus = $this->Musers->getCampaignBonus($userId, BONUS_REASON_LOGIN, $stepUpNewCampProg['campaign_join_date']);
                $pageAccessBonus = $this->Musers->getCampaignBonus($userId, BONUS_REASON_PAGE_ACCESS, $stepUpNewCampProg['campaign_join_date']);
                $interviewBonus = $this->Musers->getCampaignBonus($userId, BONUS_REASON_INTERVIEW, $stepUpNewCampProg['campaign_join_date']);
                $remainingSlot =  $this->Musers->getStepUpCampaignRemainingSlot($stepUpNewCampProg['step_up_campaign_id']);
                $remainingSteps = $stepUpNewCampProg['step1_fin_flag'] + $stepUpNewCampProg['step2_fin_flag'] + $stepUpNewCampProg['step3_fin_flag'] + $stepUpNewCampProg['step4_fin_flag'] + $stepUpNewCampProg['step5_fin_flag'];

                $this->viewdata["campaignStatus"] = array('未','達成');
                $this->viewdata["scoutMailBonus"]   = $scoutMailBonus;
                $this->viewdata["inquiryBonus"]     = $inquiryBonus;
                $this->viewdata["loginBonus"]       = $loginBonus;
                $this->viewdata["pageAccessBonus"]  = $pageAccessBonus;
                $this->viewdata["interviewBonus"]   = $interviewBonus;

                $totalPoint  = ($scoutMailBonus * $stepUpNewCamp['scout_bonus_mag_times']) + ($inquiryBonus * $stepUpNewCamp['msg_bonus_mag_times']);
                $totalPoint += ($loginBonus * $stepUpNewCamp['login_bonus_mag_times']) + ($pageAccessBonus * $stepUpNewCamp['page_access_bonus_mag_times']);
                $totalPoint += ($interviewBonus * $stepUpNewCamp['interview_bonus_mag_times']);
                $noOfInterview = ($stepUpNewCampProg['no_of_interviews'] > 0)?$stepUpNewCampProg['no_of_interviews']:1;
                $grandTotalPoint = $totalPoint * $noOfInterview;
                $this->viewdata["totalLoginBonusDays"] = $this->Musers->getUserTotalLoginDaysAchieved($available_campaign_id, $userId);
                $this->viewdata["totalPageAccessDays"] = $this->Musers->getUserPageAccessDaysAchieved($available_campaign_id, $userId);
                $this->viewdata["remainingSteps"] = 5 - $remainingSteps;
                $this->viewdata["remainingTime"] = strtotime(date('Y-m-d 23:59:59', $campaignEndDate)) - time();
                $this->viewdata["stepUpNewCamp"] = $stepUpNewCamp;
                $this->viewdata["stepUpNewCampProg"] = $stepUpNewCampProg;
                $this->viewdata["subTotalPoint"] = $totalPoint;
                $this->viewdata["grandTotalPoint"] = $grandTotalPoint;
                $this->viewdata["remainingSlot"] = $remainingSlot['max_user_no'] - $remainingSlot['c_finish_user'];
            }
        }

        $this->viewdata["titlePage"] = "joyspe｜ミッション確認";
        $this->viewdata["load_page"] = "mission/index";
        $this->viewdata['class_ext'] = 'mission_conf';

        $this->load->view($this->layout, $this->viewdata);
    }

    public function requestMagnificationBonus() {
        if ($this->input->post()) {
            $campaign_progress_id = $this->input->post('campaign_progress_id');
            $data = array(
                        'request_money_flag' => 1,
                        'request_money_date' => date('Y-m-d H:i:s')
                    );
            $update = $this->Musers->updateStepUpCampaignProgress($data, $campaign_progress_id);
        }
        exit;
    }
}
?>

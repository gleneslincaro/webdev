<?php
class joyspe_user extends MY_Controller {
    private $page_line_max = 5;
    private $layout = "user/layout/main";
    private $layout_pc = "user/layout/pc_page";
    private $viewData = array();
    private $total_owners;
    private $keywords    = "風俗,求人,/--TOWN--/,/--INDUSTRY--/";
//    private $description = "風俗求人・高収入アルバイトは女性のためのハローワークと言えばジョイスペ。このページでは/--CITY--/・/--TOWN--/にある【/--STORENAME--/】の求人情報/--INDUSTRY--/をご案内します。採用でお祝い金をGET!";
    private $description = "最近口コミで評判の/--CITY--/・/--TOWN--/【/--TOWN--/ /--STORENAME--/】（/--JOBTYPE--/）の求人情報・お問合せページをご案内します。安心してちゃんと稼げる高収入アルバイト・風俗求人情報だけをお届けいたします!ジョイスペでは誰でもカンタンに色々な条件で風俗のお仕事を検索することができます。";

    public function __construct() {
        parent::__construct();
        $this->load->library('user_agent');
        $this->load->library('cipher');
        $this->load->model("admin/Mmail");
        $this->load->model("user/Mnewjob_model");
        $this->load->model("user/Mscout");
        $this->load->model("user/Mstyleworking");
        $this->load->model("user/Mhappymoney");
        $this->load->model("user/Musers");
        $this->load->model("owner/Mbenefits");
        $this->load->model("owner/Mjobexplanation");
        $this->load->model("owner/Muserstatistics");
        $this->load->model("owner/Mspeciality");
        $this->load->model("user/mcampaign_bonus_request");
        $this->load->model("user/Mtravel_expense");
        $this->load->model("user/MCampaign");
        $this->load->model("user/Muser_statistics");
        $this->load->model("user/Muser_messege");
        $this->load->model("user/Mdialog_box");
        $this->common = new Common();
        $this->viewData['idheader'] = NULL;
        $this->viewData['total_users'] = HelperGlobal::getUserTotalNumber();
        $this->viewData['total_owners'] = $this->total_owners = HelperGlobal::gettotalHeader();
    }
    /*
    * @author: IVS_VoThanhAn
    * @param: paging
    */
    public function process() {
        $this->redirect_pc_site();
        $limit=5;
        $user_id=0;
        $day_happy_money=$this->config->item('day_happymoney');
        if(UserControl::LoggedIn())
        {
            $user_id=  UserControl::getId();
        }
        $more_top_owner_list=$this->input->post("more_top_owner_list");
        if($more_top_owner_list!=''){
            $limit= $this->input->post("limit");
            $limit= $limit+10;
        }
        $count_all=$this->input->post("count_all");
        $owners = $this->Mnewjob_model->getAll($limit,$user_id);
        $count=count($owners);
        foreach ($owners as $key => $v) {
            $owners[$key]['jobtypename'] = $this->Mnewjob_model->getJobType($v['ors_id']);
            $owners[$key]['treatment'] = $this->Mnewjob_model->getTreatment($v['ors_id']);
            $owners[$key]['user_paymentstt']=$this->Mscout->getUserPaySTT($v['ors_id'],$user_id,$day_happy_money);
            $owners[$key]['keepstt']=$this->Mscout->getUserKeepSTT($v['ors_id'],$user_id);
        }
        $this->viewData['owners'] = $owners;
        $this->viewData['limit']=$limit;
        $this->viewData['count']=$count;
        $this->viewData['count_all']=$count_all;
        $this->viewData['imagePath'] = base_url(). $this->config->item('upload_owner_url') . 'images/';
        $this->load->view("user/job/process",$this->viewData);
    }
    /*
    * @author: [IVS] Nguyen Ngoc Phuong
    * show page index
    */
    public function index()
    {
        HelperApp::remove_session('sSearchKeyword');

        $limit=5;
        $user_id=0;
        $day_happy_money=$this->config->item('day_happymoney');

        // check the opened news letter link if it's valid or not.
        $this->_check_news_letter();

        /*FROM NEWSLETTER LINK TO TOP PAGE GRANTS POINTS TO USER*/
        $this->_giveBonusPoint();

        if(UserControl::LoggedIn())
        {
            $user_id=  UserControl::getId();

            $time_diff = 0;
            $user_from_site = UserControl::getFromSiteStatus();
            if ($user_from_site == 1 || $user_from_site == 2) {
                $this->viewData['message_campaign'] = $this->MCampaign->getMessageCampaignOwnerList();
            }
            if ($this->session->userdata('time_to_display')) {
                $time_diff = (time()-$this->session->userdata('time_to_display'));
            }
            if($time_diff) {
                $this->viewData['time_to_display'] = (int)gmdate("i",$time_diff);
            }
            $user_data = $this->Mdialog_box->get_user_data($user_id);
            $show_dialog_box = $this->Mdialog_box->show_dialog_box($user_data);
            if(count($show_dialog_box) > 0) {
                $this->viewData['priority'] = $show_dialog_box;
            }


        }
        if(!UserControl::LoggedIn()){
            HelperApp::add_session("url_search", base_url()."user/joyspe_user");
        }

        $jobdata = $this->Mnewjob_model->getAll($limit, $user_id);
        $count=  count($jobdata);
        foreach ($jobdata as $key => $v) {
            $jobdata[$key]['jobtypename'] = $this->Mnewjob_model->getJobType($v['ors_id']);
            $jobdata[$key]['treatment'] = $this->Mnewjob_model->getTreatment($v['ors_id']);
            $jobdata[$key]['user_paymentstt']=$this->Mscout->getUserPaySTT($v['ors_id'], $user_id, $day_happy_money);
            $jobdata[$key]['keepstt']=$this->Mscout->getUserKeepSTT($v['ors_id'], $user_id);
        }
        $this->viewData['owners'] = $jobdata;


        $this->viewData['limit']=$limit;
        $this->viewData['count']=$count;

        /* 総店舗数 */
        $this->viewData['count_all']=$this->total_owners;

        $this->load->Model("owner/mowner");
        $this->viewData['monthly_campaign_result_ads'] = $this->mowner->getMonthlyCampaignResultAds();
        //check if user can join step up campaign
        $this->has_step_up_campaign($user_id);

        $this->viewData['banner_data'] = $this->common->getLatestBanner();
        $cnt = 0;

//        $city_groups = $this->mcity->getCityGroup();
        $city_groups = $this->mcity->getCityGroupIds();/* 都市 */
        $this->viewData['city_group'] = $city_groups;

        $this->load->model("user/Mbuffer");
        $this->load->library('user_agent');

        /*新着風俗求人情報 */
        $this->load->model('admin/Msearch_store');
        $new_store_ar = $this->Msearch_store->get_new_store(20);
        $this->viewData['new_store_ar'] = $new_store_ar;

        $this->load->model('owner/Mowner');

        $everyones_question_ar =$this->Mowner->getUserMessages_public_contents_new(20);
        $this->viewData['everyones_question_ar'] = $everyones_question_ar;

        /* 新着あるある */
/*        $this->load->model("user/Mpost_model");
        $latestPost = $this->Mpost_model->getLatestPosts();
        $this->viewData['latest_post'] = $latestPost;*/

        /* 注目のあるある */
/*        $popular = $this->Mpost_model->get3daysLogsHome();
        $this->viewData['popular'] = $popular;*/

        /* sp */
        if ($this->agent->is_mobile() or $this->agent->platform() == 'Android' or $this->agent->platform() == 'iOS') {
            $this->viewData['load_page'] = "user/job/index";
            $this->layout = "user/layout/main_top";

            /* 業種 */
            $this->load->Model("admin/Msearch");
            $jobtypes =  $this->Msearch->getJobType();

            $jobtypes_ar = array();
            $jobtypes_ar2 = array();
            $ar_cnt = 0;
            foreach ($jobtypes as $key => $val) {
                if ($val['alph_name'] != null) {
                    if ($ar_cnt < 6) {
                        $jobtypes_ar[] = array('name' => $val['name'],'alph_name' => $val['alph_name']);
                    } else {
                        $jobtypes_ar2[] = array('name' => $val['name'],'alph_name' => $val['alph_name']);
                    }
                    $ar_cnt++;
                }
            }
            $this->viewData['jobtypes_ar'] = $jobtypes_ar;
            $this->viewData['jobtypes_ar2'] = $jobtypes_ar2;

            /* 待遇 */
            $treatments = $this->Msearch->getAllTreatments();

            $treatments_ar = array();
            $treatments_ar2 = array();
            $ar_cnt = 0;
            foreach ($treatments as $key => $val) {
                if ($val['alph_name'] != null) {
                    if ($ar_cnt < 6) {
                        if ($val['alph_name'] == 'bakkin') {
                            $treatments_ar[] = array('name' => '罰金・ノルマ無' ,'alph_name' => $val['alph_name']);
                        } else {
                            $treatments_ar[] = array('name' => $val['name'],'alph_name' => $val['alph_name']);
                        }
                    } else {
                        if ($val['alph_name'] == 'bakkin') {
                            $treatments_ar2[] = array('name' => '罰金・ノルマ無' ,'alph_name' => $val['alph_name']);
                        } else {
                            $treatments_ar2[] = array('name' => $val['name'],'alph_name' => $val['alph_name']);
                        }
                    }
                    $ar_cnt++;
                }
            }
            $this->viewData['treatments_ar'] = $treatments_ar;
            $this->viewData['treatments_ar2'] = $treatments_ar2;

        /* pc */
        } else {
            /* 業種 */
            $this->load->Model("admin/Msearch");
            $jobtypes =  $this->Msearch->getJobType();
            $this->viewData['jobtypes_ar'] = $jobtypes;

            /* 待遇 */
            $treatments = $this->Msearch->getAllTreatments();
            $this->viewData['treatments_ar'] = $treatments;

            if (isset($user_id)) {
                $mail_data = HelperGlobal::checkscoutmail($user_id);
                if ($mail_data && isset($mail_data['quantity']) && $mail_data['quantity'] > 0) {
                    $this->viewData['new_mail_flag'] = true;
                }
            }
            $this->viewData['load_page'] = "user/pc/job/index";
            $this->layout = "user/pc/layout/main";
            $city_group_ar = array();
            $city_ar = array();

//            $city_groups = $this->mcity->getCityGroupIds();
            foreach ($city_groups as $key => $val) {
                $city_ar[$key] = $val;
                $city_group_id = $val['id'];
                $citys = $this->mcity->getCityIds($city_group_id);
                foreach ($citys as $key1 => $val1) {
                    $city_ar[$key][$city_group_id][] = $val1;
                }
            }
            $this->viewData['is_top'] = 'true';
            $this->viewData['getCityGroup'] = $city_group_ar;
            $this->viewData['getCity'] = $city_ar;
            $this->viewData['column_data'] = $this->Mbuffer->get_column_buffer();/* バッファからコラム取得 */
//            $this->viewData['column_data'] = $this->common->get_latest_column_posts(4, false); // get latest posts from wordpress
            $this->viewData['searchRes'] = true; //display scrumbread
        }


        $this->viewData['articles'] = $res = $this->Mbuffer->get_urgent_recruit_buffer();/* バッファから新着取得 */
//        $this->viewData['articles'] = $this->Mowner->getUrgentRecruitmentsLatestPost(0);/* 新着 */
        $this->viewData['class_ext'] = 'index';
        $this->viewData['banner_bonus_req'] = $this->mcampaign_bonus_request->getLatestCampaignBonusBanner();
        $this->viewData['titlePage']= '風俗求人・高収入アルバイトがみつかる -ジョイスペ-';
        $this->viewData['keywords'] = DEFAULT_KEYWORDS;
        $this->viewData['description'] =
            '風俗求人ジョイスペは全国の口コミや評判で有名な優良でオススメの風俗求人・アルバイト情報を探すことのできる大人のハローワークです。デリヘル・ホテヘル・ヘルス・エステ・ソープ・ピンサロなどの業種選択や体験入店、日払い、短期などの条件を未経験者でもカンタンにお仕事検索！☆面接交通費や採用お祝い金を保証する唯一の高収入求人情報サイトです。';
        $this->viewData['imagePath'] = base_url(). $this->config->item('upload_owner_url') . 'images/';
        $this->load->view($this->layout, $this->viewData);
    }

    /**
     * PCランディングページの表示
     * @return void
     */
    private function pc_view(){
        $this->load->view($this->layout_pc);
        return;
    }

    private function _giveBonusPoint($ors_id = null) {
        $redirect_url = base_url() . "user/joyspe_user/";
        if ($ors_id) {
            $redirect_url .= "company/" . $ors_id;
        }
        if (!$this->session->flashdata('flag')) {
            if($this->input->get('li') || $this->input->get('lk') || $this->input->get('hash')|| $this->input->get('np')) {
                $from_np = md5('np');
                $this->load->Model("user/Musers");
                $hash = ($this->input->get('hash')) ? $this->input->get('hash'): '';
                $data = $this->Musers->getUserLoginIdAndPassByOrIdAndHash($hash, $ors_id);
                $np = (($this->input->get('np') != NULL) && $this->input->get('np') == $from_np) ? true : false;
                if (count($data) > 0) {
                    $loginId = $this->input->get('li');
                    $pass = $this->input->get('lk');
                    // check login information
                    $login_auth_flag = false;
                    if (UserControl::LoggedIn() && UserControl::getFromSiteStatus() != 0) {
                        // machemoba user clicked link from scout mail inside joyspe mail box
                        $login_auth_flag = true;
                    } else if(md5($data['old_id']) == $loginId && md5(base64_decode($data['password'])) == $pass) {
                        // machemoba user clicked link from scout mail machemoba mail box
                        $login_auth_flag = true;
                        // check and update data for login bonus
                        $this->common->updateLoginBonus($data['user_id'], $data['user_from_site'], $data['last_visit_date']);
                    }
                    if( $login_auth_flag ) {
                        if (!UserControl::LoggedIn()) {
                            HelperApp::add_session('id', $data['user_id']);
                        }
                        $this->session->set_flashdata('flag', true);
                        $this->session->set_flashdata('np', $np);
                        $this->session->set_flashdata('userId', $data['user_id']);
                        $this->session->set_flashdata('lumId', $data['lum_id']);
                        $this->session->set_flashdata('activeFlag', $data['active_flag']);
                        redirect($redirect_url); //
                    }
                } else {
                    redirect($redirect_url);
                }
            }
        } else {
            $userId = $this->session->flashdata('userId');
            $lumId = $this->session->flashdata('lumId');
            $activeFlag = $this->session->flashdata('activeFlag');
            $np = $this->session->flashdata('np');
            $data = array(
                'last_visit_date' => date("y-m-d H:i:s"),
            );
            $this->Musers->update_User($data, $userId);
            // set is_read flag for scout mail if not yet set
            $this->Muser_messege->updateIsRead($lumId);
            //open_rate set
            $this->Muser_messege->insertListOpenRate($userId);

            $own_recruit_data = $this->Muser_messege->get_owner_recruit_data_from($lumId);
            if ($own_recruit_data) {
                $ownerId = $own_recruit_data['owner_id'];
                //opend_mail
                $this->Muser_messege->insertListReciveOpenMail($ownerId, $userId);
            }

            if($activeFlag == 1) {
                // disable hash value to avoid adding points many times
                $ret = $this->Musers->updateListUserMessagesActiveFlagTo0($lumId);
                if ($ret) {
                    // add points
                    if (!$np) { // give point for opening scout mail
                        $bonus_point = $this->Musers->getBonusPointForScout();
                        if ($bonus_point) {
                            // check if opened scout mail is not greater than the given expiration date.
                            $is_expired = $this->Muser_messege->check_mail_expiration($lumId);
                            if ($is_expired == false) {
                                $this->Musers->updateBonusPoint($userId, $bonus_point, BONUS_REASON_OPEN_SCOUT_MAIL);
                            }
                        }
                    } else { // get current news letter points.
                        $news_point = $this->Musers->getNewsPoint();
                        if ($news_point) {
                            // check if opened news mail is not greater than the given expiration date.
                            $is_expired = $this->Muser_messege->check_mail_expiration($lumId);
                            if ($is_expired == false) {
                                // give point for opening news letter
                                $this->Musers->updateBonusPoint($userId, $news_point, "メルマガ開封");
                            }
                        }
                    }
                }
            }
        }
    }
    /*
     * @author: [IVS]Nguyen Ngoc Phuong
     * show detail Company
     */
    public function company($ors_id = 0, $cateid = null, $msgid = null) {

        /* user/joyspe_user/company/6155/6/186/ これ以上の url は404 */
        if ($this->uri->total_segments() > 7) {
            show_404();
        }

        $owner_id = $this->Mowner->getCountOwnerIdRecruit($ors_id);
        if ( !$ors_id || count($owner_id) == 0) {
          show_404();
        }
        $user_from_site = null;
        $count = 0;

        // check the opened news letter link if it's valid or not.
        $this->_check_news_letter();
        
        // grant points to user for opening scout/newsleter mail
        $this->_giveBonusPoint($ors_id);
        $this->redirect_pc_site();
        $user_id=0;
        if (!UserControl::LoggedIn()) {
            HelperApp::add_session("url_search", base_url()."user/joyspe_user/company/".$ors_id);
        }
        $owner_status = "2,5";
        $company_data= $this->Mnewjob_model->getAllCompany($ors_id,$owner_status);
        if ($company_data) {
            $article = $this->Mowner->getOwnerUrgentRecruitment($company_data[0]['owner_id']);
            if (count($article) > 0) {
                $jap_days = array('日', '月', '火', '水', '木', '金', '土');
                $article['jap_day'] = $jap_days[date('w', strtotime($article['post_date']))];
            }
            $this->viewData['article'] = $article;
        }

//group_alph_name
//city_alph_name
//town_alph_name


        $this->viewData['area_info'] = $company_data[0];


        // get all towns
        $towns = $this->mcity->getTownUserCount($company_data[0]['city_id']);
        $this->viewData['towns'] = $towns;

        // get all jobs belonging to a town
        $jobs_in_town = $this->mcity->getAllJobInTown($company_data[0]['town_id']);
        $this->viewData['jobs_in_town'] = $jobs_in_town;

        //get faq between owner and users
        $faq = $this->Musers->get_faq($owner_id['owner_id']);
        if (count($faq) > 0) {
            $this->viewData['faq'] = $faq;
        }

        //get owner senior profile
        $owner_senior_profile = $this->Musers->get_senior_profile($owner_id['owner_id']);
        if (count($owner_senior_profile) > 0) {
            $this->viewData['owner_senior_profile'] = $owner_senior_profile;
        }

        //get user statistics
        $user_statistics = $this->Muserstatistics->get_user_statistics($owner_id['owner_id']);
        if (count($user_statistics) > 0) {
            $this->viewData['user_statistics'] = $user_statistics;
        }

        //get owner speciality
        $owner_speciality = $this->Mspeciality->get_owner_speciality($owner_id['owner_id']);
        if (count($owner_speciality) > 0) {
            $this->viewData['owner_speciality'] = $owner_speciality;
        }

        //get owner working days
        $owner_working_days = $this->Mjobexplanation->get_owner_working_days($owner_id['owner_id']);
        if (count($owner_working_days) > 0) {
            $this->viewData['owner_working_days'] = $owner_working_days;
        }

        //get owner benefits
        $owner_benefits = $this->Mbenefits->get_owner_benefits($owner_id['owner_id']);
        if (count($owner_benefits) > 0) {
            $this->viewData['owner_benefits'] = $owner_benefits;
        }

        //get user character
        $user_character = $this->Musers->get_user_character($ors_id);
        $new_user_character_array = array();
        if (count($user_character) > 0) {
            foreach ($user_character as $character) {
                $new_user_character_array[$character['id']] = $character; // set ID to array key
            }
        }
        $this->viewData['reg_user_character'] = $new_user_character_array;

        //get owner treatments
        $treatments = $this->Mowner->getOwnerTreatment();
        $this->viewData['treatments'] = $treatments;

        //get all user characters
        $this->viewData['user_characters'] = $this->Musers->get_all_user_characters();

        // check if old data or not
        if(UserControl::LoggedIn()){
            $user_id= UserControl::getId();
            $this->viewData['user_id'] = $user_id;
            $user_data = $this->Musers->get_users_by_id($user_id);
            $user_from_site = $user_data['user_from_site'];
            //count exhange of conversation between the user and the store
            $count = $this->Musers->countExchangeConversation($user_id,$ors_id);
            // add point bonus for each time visit
            $insert_flag = $this->Musers->insertUserCountOwnerlogCookie($owner_id['owner_id']);
            if ($user_from_site == 1 || $user_from_site == 2) { // only give point to machemoba/Makia user
                $accessPoint = $this->Mowner->getAccessPoint();
                if ($accessPoint && isset($accessPoint['page_point']) && $accessPoint['page_point']) {
                    $limitPoint = $this->Musers->getUserCountOwnerlog($user_id, $owner_id['owner_id'], $accessPoint, $user_from_site);
                    if ($limitPoint == false) {
                        if($insert_flag){
                            $this->Musers->insertUserCountOwnerlog($owner_id['owner_id'],$user_id, $accessPoint['page_point']);
                        }
                        $this->Musers->updateBonusPoint($user_id, $accessPoint['page_point'], BONUS_REASON_PAGE_ACCESS);
                    } else {
                        if($insert_flag){
                            $this->Musers->insertUserCountOwnerlog($owner_id['owner_id'],$user_id, 0);
                        }
                    }
                }
            } else {
                if($insert_flag){
                    $this->Musers->insertUserCountOwnerlog($owner_id['owner_id'],$user_id, 0);
                }
            }
        } else {
            if($this->Musers->insertUserCountOwnerlogCookie($company_data[0]['owner_id'])){
                $this->Musers->insertUserCountOwnerlog($company_data[0]['owner_id'],0,0);
            }
        }

        // get all infomation of owner
        if ( $company_data && is_array($company_data) && $company_data[0]['display_flag'] == 0){
            if ( !UserControl::LoggedIn() ) {
                // Login画面へ
                redirect(base_url()."user/login/");
            }else{
                // Check if once applied for the job
                $user_id= UserControl::getId();
                // if not applied
                if($this->Musers->check_user_apply($user_id,$ors_id) == 0) {
                    //get latest $ors_id
                    $latest_ors_id = $this->Mnewjob_model->geActiveOwnerId( $company_data[0]['owner_id'] );
                    if ( $latest_ors_id ) {
                       redirect(base_url()."user/joyspe_user/company/".$latest_ors_id);
                    }
                }
            }
        }

        $user_unique_id = "";
        if(isset($user_id) && $user_id ) {
            $this->viewData['user_data']  = $this->Musers->get_user($user_id);
            $user_unique_id = UserControl::getUnique_id();
        }
        $this->viewData['hide_apply_emailaddress'] = $this->hide_email($company_data[0]['apply_emailaddress'],$user_unique_id);
        $this->viewData['hide_apply_emailaddress1'] = $this->hide_email($company_data[0]['apply_emailaddress'],$user_unique_id);

        //status public information of owner
        $public_stt=0;

        //check if user can join step up campaign
        $this->has_step_up_campaign($user_id);

        foreach ($company_data as $key=>$v){
            $public_stt=$v['public_stt'];
            $company_data[$key]['jobtypename']=$this->Mnewjob_model->getJobTypeCompany($v['ors_id']);
            $company_data[$key]['treatment']=$this->Mnewjob_model->getTreatmentCompany($v['ors_id']);
            $company_data[$key]['keepstt']=$this->Mscout->getUserKeepSTT($v['ors_id'], $user_id);
        }

        //get stt spam message
        $status_scout_spam=$this->Mhappymoney->getScoutSpam($user_id, $ors_id);
        $count_scout=  count($status_scout_spam);
        $stt=0;
        if($count_scout>0){
            $stt=$status_scout_spam['stt'];
        }
        $this->viewData['company_data'] = $company_data;
        $this->viewData['stt']=$stt;
        //$this->viewdata['status_scout_spam']=$status_scout_spam;


        $owner_id = isset($company_data[0]['owner_id']) ? $company_data[0]['owner_id'] : null;

        $this->viewData['title'] = "";
        $this->viewData['titlePage'] = "風俗求人の高収入アルバイト -ジョイスペ-";
        $industries = "";
        $this->viewData['ors_id']   = $ors_id;
        $this->viewData['user_from_site'] = $user_from_site;
        $this->viewData['owner_id'] = $owner_id;
        $this->viewData['keywords'] = $this->keywords;
        if ($company_data) {
            $this->viewData['title'] = $company_data[0]['title'];
            $this->viewData['titlePage'] = $company_data[0]['storename'].'（'.$company_data[0]['town_name'].'）' . $this->viewData['titlePage'];
            $i=0;
            $no_of_jobtypes = count($company_data[0]['jobtypename']);
            foreach ($company_data[0]['jobtypename'] as $j) {
                $industries .= $j['name'] ;
                $i++;
                if( $i < $no_of_jobtypes){
                    $industries .= ",";
                }
            }
            $this->viewData['keywords'] = str_replace("/--TOWN--/", $company_data[0]['town_name'], $this->viewData['keywords']);
            $this->viewData['keywords'] = str_replace("/--INDUSTRY--/", $industries, $this->viewData['keywords']);

            $this->viewData['description'] = $this->description;
            $this->viewData['description'] = str_replace("/--STORENAME--/", $company_data[0]['storename'], $this->viewData['description']);
            $this->viewData['description'] = str_replace("/--INDUSTRY--/", $industries, $this->viewData['description']);
            $this->viewData['description'] = str_replace("/--CITY--/", $company_data[0]['city_name'], $this->viewData['description']);
            $this->viewData['description'] = str_replace("/--TOWN--/", $company_data[0]['town_name'], $this->viewData['description']);
            $this->viewData['description'] = str_replace("/--JOBTYPE--/", $company_data[0]["job_type_name"], $this->viewData['description']);

            $this->viewData['long_tail'] = 'store_detail';
            $this->viewData['town_name'] = $company_data[0]['town_name'];
            $this->viewData['jobtypename'] = $industries;
            $this->viewData['storename'] = $company_data[0]['storename'];
            $this->viewData['area_hi'] = $company_data[0]["job_type_name"].'の求人情報はコチラ';
        }
        //check if owner has its own travel expense point
        $travel_expense_bonus_point = $this->MCampaign->getOwnerTravelExpensePoint($ors_id);
        // キャンペーン情報表示
        $campaign_data  = $this->MCampaign->getLatestCampaign();
        if($campaign_data){
            $request_status = 0; // 交通費申請可能

            if ($travel_expense_bonus_point > 0) {
                $bonus_point   = $travel_expense_bonus_point;
                $this->viewData['owner_travel_expense'] = true;
            } else {
                $bonus_point  = $campaign_data['travel_expense'];
            }

            if ( $user_id ) { // ログイン中の場合
                $request_status  = $this->Mtravel_expense->canRequestTrvelExpense(
                                    $user_id,
                                    $owner_id,
                                    $campaign_data['id'],
                                    $bonus_point,
                                    $campaign_data['budget_money'],
                                    $campaign_data['max_request_times'],
                                    $campaign_data['multi_request_per_owner_flag']);

            }

            $this->viewData['request_status']   = $request_status;
            $this->viewData['travel_expense']   = $campaign_data['travel_expense'];
            $this->viewData['campaign_id']      = $campaign_data['id'];
            $this->viewData['travel_expense_bonus_point']   = $bonus_point;
        }

        $campaignBonusRequest  = $this->MCampaign->getLatestCampaignBonusRequest();

        $this->viewData['requestCampaignStatus'] = 0;
        if ( $campaignBonusRequest ) {
            $this->viewData['campaignBonusRequest'] = $campaignBonusRequest;
            //check if owner has trial work bonus point
            $owner_trial_work_point = $this->MCampaign->getOwnerTrialWorkPoint($ors_id);
            $masterRequestStatus = 0;
            if ( $user_id ) {
                $ckIfdecline  = $this->mcampaign_bonus_request->ckIfdecline($user_id, $owner_id ,$campaignBonusRequest['id']);
                if($ckIfdecline){
                    $this->viewData['ckdecline'] = true;
                }
                $requestCampaignStatus  = $this->mcampaign_bonus_request->canRequestCampaign($user_id, $owner_id ,$campaignBonusRequest);
                $this->viewData['requestCampaignStatus'] = $requestCampaignStatus;
            }
            if ($owner_trial_work_point > 0) {
                $this->viewData['bonus_money']   = $owner_trial_work_point;
            } else {
                $this->viewData['bonus_money']   = $campaignBonusRequest['bonus_money'];
            }

        }

        $this->load->library('user_agent');
        $device = '';
        if (isset($_GET['device'])) {
            $device = $_GET['device'];
        }

        $this->viewData['class_ext'] = "store";
        $this->viewData['imagePath'] = base_url(). $this->config->item('upload_owner_url') . 'images/';
        if ($public_stt ==0 || !$company_data) {
            $this->viewData['load_page'] ="user/company_not";
        } else {
            $this->load->library('user_agent');
            $device = '';
            if (isset($_GET['device'])) {
                $device = $_GET['device'];
            }

            if($company_data[0]['owner_status'] == 5) {
                $this->Musers->insert_owner_recruit_log($ors_id);
                $this->viewData['count_log']  = $this->Musers->get_owner_recruit_flag($ors_id);
            }

            if ($this->agent->is_mobile() OR $device == 'sp') {
                if($company_data[0]['owner_status'] == 2) {
                    $this->viewData['load_page'] = "user/company_detail";
                } else {
                    $this->viewData['load_page'] = "user/company_detail_request";
                }
                $this->layout = "user/layout/main";
            /* pc */
            } else {
                $this->viewData['hide_apply_emailaddress'] = $this->hide_email_pc($company_data[0]['apply_emailaddress'],$user_unique_id);
                $this->viewData['hide_apply_emailaddress1'] = $this->hide_email_pc($company_data[0]['apply_emailaddress'],$user_unique_id);
                if($company_data[0]['owner_status'] == 2) {
                    $this->viewData['load_page'] = "user/pc/store_detail";
                } else {
                    $this->viewData['load_page'] = "user/pc/store_detail_request";
                }

                $this->viewData['header_storeDetail'] = true; // for display header of store detail page
                $this->layout = "user/pc/layout/main";
            }
        }




            $this->load->Model("owner/Mowner");
            $this->Mowner->getUserMessages_owner_public($owner_id);
            $res = $this->Mowner->getUserMessages_owner_public($owner_id);
            $this->viewData['category_message_num'] = $res['cate_count'];

        if($cateid != null && $msgid != null){
            $this->load->Model("owner/Mqa");
            $res = $this->Mqa->get_faq_by_owner($owner_id, $msgid);
            if (!$res) {
                show_404();
            }
//            $this->viewData['owner_faq_ar'] = $res['cate_message_ar'];

            $ar = $res['cate_message_ar'];
            $this->viewData['page_line_max'] = $this->page_line_max;

            $this->viewData['current_cate'] = $res['current_cate'];

            /* 日時 */
            $datetime = $ar['created_date'];
            list($year, $month, $day, $hour, $minute, $second) = preg_split('/[-: ]/', $datetime);
            $jap_days = array('日', '月', '火', '水', '木', '金', '土');
            $jp_day  = $jap_days[date('w', strtotime($datetime))];
            $res['cate_message_ar']['created_date'] = $year.'-'.$month.'-'.$day.'('.$jp_day.')'.$hour.':'.$minute;

            $str = $ar['reply_content'];
            $str = preg_replace('/店舗名:.*/', '', $str);
            $str = preg_replace('/電話番号:.*/', '', $str);
            $str = preg_replace('/【匿名の返信はこちら】.*/', '', $str);
            $str = preg_replace('/メールアドレス:.*/', '', $str);
            $str = preg_replace('/URL:.*/', '', $str);
            $res['cate_message_ar']['reply_content'] = $str;
            $this->viewData['owner_faq_ar'] = $res['cate_message_ar'];

            $this->viewData['category_message_num'] = $res['cate_count'];
            $this->viewData['page_wrap_qa_list'] = 'page_wrap--store_everyone_qa_detail';

            $str = $ar['content'];
            $substr32 = mb_substr($str, 0, 32);
            $substr32 = trim($substr32, "\x00..\x1F");

            $this->viewData['title'] = "";
            $this->viewData['titlePage'] = $substr32."｜".$company_data[0]['storename']."-ジョイスペ-";

            if ($this->agent->is_mobile() OR $device == 'sp') {
                $substr25 = mb_substr($str, 0, 25);
                $substr25 = trim($substr25, "\x00..\x1F");
                $this->viewData['description'] = $substr25."｜".$company_data[0]['storename']."が質問解答します！";
                $this->viewData['load_page'] = "user/company_detail_qa";
                $this->layout = "user/layout/main";
            } else {
                $substr90 = mb_substr($str, 0, 25);
                $substr90 = trim($substr90, "\x00..\x1F");
                $this->viewData['description'] = $substr90."｜".$company_data[0]['storename']."が質問解答します！";
                $this->viewData['load_page'] = "user/pc/company_detail_qa";
                $this->layout = "user/pc/layout/main";
            }

            $this->load->view($this->layout, $this->viewData);
            return;
        } elseif ($cateid != null && $msgid == null) {
            if(preg_match("/^[0-9]+$/", $cateid)){
                $this->load->Model("owner/Mqa");
                $res = $this->Mqa->get_faqlist_by_owner($owner_id, $cateid, $offset = 0, $this->page_line_max);
                if (!$res) {
                    show_404();
                }

                $this->viewData['cate_all_count'] = $res['cate_all_count'];
                $cate_all_count = $res['cate_all_count'];
                $this->viewData['page_max'] = ceil($cate_all_count / $this->page_line_max);
                $this->viewData['page_line_max'] = $this->page_line_max;

                $this->viewData['current_cate'] = $res['current_cate'];
                $this->viewData['owner_faq_ar'] = $res['cate_message_ar'];
                $this->viewData['category_message_num'] = $res['cate_count'];
                $this->viewData['page_wrap_qa_list'] = 'page_wrap--store_everyone_qa_detail';

                $this->viewData['description'] = $company_data[0]['storename'].'に届いた'.$res['current_cate']['name'].'の質問一覧です。皆様の風俗に対する疑問・質問をバッチリ解決します！';
                $this->viewData['titlePage'] = $company_data[0]['storename'].' '.$company_data[0]['town_name'].'に集まった'.$res['current_cate']['name'].'の質問一覧 -風俗求人ならジョイスペ-';

                if ($this->agent->is_mobile() OR $device == 'sp') {
                    $this->viewData['load_page'] = "user/company_detail_qalist";
                    $this->layout = "user/layout/main";
                } else {
                    $this->viewData['load_page'] = "user/pc/company_detail_qalist";
                    $this->layout = "user/pc/layout/main";
                }
            } else {
                show_404();
            }
        }

        $interviewer = $this->Musers->getInterviewer($ors_id);
        if ($interviewer) {
          $this->viewData['interviewer_info'] = $interviewer;
        }

        $this->viewData['company_detail_page'] = true;

        $this->viewData['banner_data'] = $this->common->getLatestBanner();
        $this->viewData['banner_bonus_req'] = $this->mcampaign_bonus_request->getLatestCampaignBonusBanner();
        $this->viewData['count_exchange_conversation'] = $count;
        $this->viewData['login_flag'] = (UserControl::LoggedIn())?true:false;
        $this->load->view($this->layout, $this->viewData);
    }

    function company_faq_ajax()
    {
        $page = $this->input->post('page');
        $ors_id = $this->input->post('ors_id');
        $owner_id = $this->input->post('owner_id');
        $category_id = $this->input->post('category_id');

        $this->load->Model("owner/Mqa");

        $offset = 0;
        $offset = $page;
        $limit = $this->page_line_max;

        $offset = ($page > 0)? ($page - 1) * $this->page_line_max : 0;

        $res = $this->Mqa->get_faqlist_by_owner($owner_id, $category_id, $offset, $limit);
        $count = count($res['cate_message_ar']);
        $this->viewData['ors_id']   = $ors_id;
        $this->viewData['current_cate'] = $res['current_cate'];
        $this->viewData['owner_faq_ar'] = $res['cate_message_ar'];
        $this->viewData['category_message_num'] = $res['cate_count'];

        $this->layout = "user/company_detail_qalist_ajax";
/*
        if ($this->agent->is_mobile()) {
            $this->layout = "user/company_detail_qalist_ajax";
        } else {
            $this->layout = "user/pc/company_detail_qalist_ajax";
        }
*/
        $html = $this->load->view($this->layout, $this->viewData, true);

        $json_ar = array();
        $json_ar['flag'] = true;
        $json_ar['html'] = $html;
        $json_ar['count'] = $count;
        echo json_encode($json_ar);
    }

    /*
     * @author: [VJS] Kiyoshi Suzuki
     * email難読化
     */
    function hide_email($email,$user_unique_id) {
        $mail_txt = "?subject=".MAIL_TITLE;
        if ( isset($user_unique_id) && $user_unique_id ) {
            $mail_txt .= "&amp;body=ID:".$user_unique_id.MAIL_HEAD_SUFFIX;
        } else {
            $mail_txt .= "&amp;body=" . MAIL_HEAD_SUFFIX_NO_LOGIN;
        }
        $character_set  = '+-.0123456789@ABCDEFGHIJKLMNOPQRSTUVWXYZ_abcdefghijklmnopqrstuvwxyz';
        $key = str_shuffle($character_set); $cipher_text = '';  $id = 'e'.rand(1,999999999);
        for ($i=0; $i<strlen($email); $i+=1) $cipher_text.= $key[strpos($character_set,$email[$i])];
            $script = 'var a="'.$key.'";var b=a.split("").sort().join("");var c="'.$cipher_text.'";var d="";';
            $script.= 'for(var e=0;e<c.length;e++)d+=b.charAt(a.indexOf(c.charAt(e)));';
            $script.= 'd+="'.$mail_txt.'";';
            $script.= 'document.getElementById("'.$id.'").innerHTML="<a class=\\"contact_mail\\" href=\\"mailto:"+d+"\\">';
            $script.= '<span class=\\"icon_wrap\\"><span class=\\"icon--mail icons\\">';
            $script.= '<img src=\\"'.base_url().'public/user/image/icon_mail.png\\"></span class=\\"item\\">';
            $script.= 'メール</span></a>"';
            $script = "eval(\"".str_replace(array("\\",'"'),array("\\\\",'\"'), $script)."\")";
            $script = '<script type="text/javascript">/*<![CDATA[*/'.$script.'/*]]>*/</script>';
        return '<span id="'.$id.'">[javascript protected email address]</span>'.$script;
    }

    /*
     * @author: [VJS] Kiyoshi Suzuki
     * email難読化 pc
     */
    function hide_email_pc($email,$user_unique_id) {
        $mail_txt = "?subject=".MAIL_TITLE;
        if ( isset($user_unique_id) && $user_unique_id ) {
            $mail_txt .= "&amp;body=ID:" . $user_unique_id .MAIL_HEAD_SUFFIX;
            $mail_txt_sjis = $mail_txt . "&amp;body=ID:" . $user_unique_id . MAIL_HEAD_SUFFIX_SJIS;
        } else {
            $mail_txt_sjis = $mail_txt . "&amp;body=" . MAIL_HEAD_SUFFIX_NO_LOGIN_SJIS;
            $mail_txt .= "&amp;body=" . MAIL_HEAD_SUFFIX_NO_LOGIN;
        }
        $character_set  = '+-.0123456789@ABCDEFGHIJKLMNOPQRSTUVWXYZ_abcdefghijklmnopqrstuvwxyz';
        $key = str_shuffle($character_set); $cipher_text = '';  $id = 'e'.rand(1,999999999);
        for ($i=0; $i<strlen($email); $i+=1) $cipher_text.= $key[strpos($character_set,$email[$i])];
            $script = 'var a="'.$key.'";var b=a.split("").sort().join("");var c="'.$cipher_text.'";var d="";var dsjis="";';
            $script.= 'for(var e=0;e<c.length;e++)d+=b.charAt(a.indexOf(c.charAt(e)));';
            $script.= 'd+="'.$mail_txt.'";';
            $script.= 'for(var e=0;e<c.length;e++)dsjis+=b.charAt(a.indexOf(c.charAt(e)));';
            $script.= 'dsjis+="'.$mail_txt_sjis.'";';
            $script.= 'document.getElementById("'.$id.'").innerHTML="<div class=\\"col_item contact-email\\">';
            $script.= '<h3 class=\\"sub_ttl ic ic-email\\">メールで応募する</h3>';
            $script.= '<p><a href=\\"mailto:"+d+"\\" class=\\"contact_mail ui_btn ui_btn--bg_magenta ui_btn--middle\\">メールで応募する</a></p>';
            $script.= '<p class=\\"mojibake_email_link\\"><a href=\\"mailto:"+dsjis+"\\" class=\\"contact_mail \\">文字化けの方はコチラをクリック</a></p></div>"';
            $script = "eval(\"".str_replace(array("\\",'"'),array("\\\\",'\"'), $script)."\")";
            $script = '<script type="text/javascript">/*<![CDATA[*/'.$script.'/*]]>*/</script>';
        return '<span id="'.$id.'">[javascript protected email address]</span>'.$script;
    }

    public function if_login() {
        if (!UserControl::LoggedIn()) {
            echo json_encode(urlencode($this->input->get('url')));
        }
        else
            echo json_encode(1);
    }

    public function sendMessageToOwner() {
        $this->load->model("owner/Mowner");
        $user_id = UserControl::getId();
        if (!$user_id) { // only for login user
            return;
        }
        $owner_id = $this->input->post('owner_id');
        $ors_data = $this->Mowner->getOwnerRecruit($owner_id);
        $title = $this->input->post('title');

        $data = array('user_id' => $user_id,
                'owner_id' => $owner_id,
                'title' => $title,
                'content' => $this->input->post('content'),
                'created_date' => date("y-m-d H:i:s"),
                'updated_date' => date("y-m-d H:i:s"),
                'msg_from_flag' => 0);

        $id = $this->Musers->insert_user_owner_message($data);

        $this->Muser_statistics->updateClick($user_id, 'QUESTION');

        $data = array(
                  'user_id' => $user_id,
                  'owner_id' => $owner_id,
                  'owner_recruit_id' => $ors_data['id'],
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
            echo json_encode(true);
        }
        else
            echo json_encode(false);
        exit;
    }

    // 申請処理を行う
    public function insertUserTravelExpense() {
        // 共通関数を使用する
        $this->common->insertUserTravelExpense();
    }

    public function insertRequestCampaign() {
        $user_id= UserControl::getId();
        $owner_id = $this->input->post('owner_id');
        $flag = $this->_check_conditions($user_id, $owner_id);
        if ($flag) {
            $data = array(
                'user_id' => $user_id,
                'owner_id' => $owner_id,
                'campaign_id' => $this->input->post('campaignBonusRequestId'),
                'visit_owner_office_date' => $this->input->post('reqDate'),
                'status'        => 0,
                'requested_date' => date('y-m-d H:i:s'),
                'created_date' => date('y-m-d H:i:s')
            );
            $result = $this->mcampaign_bonus_request->insertRequestCampaign($data);
            echo json_encode($result);
        } else {
            echo json_encode(array("ret"=>false, "error_code" => 2));
        }


    }

    public function has_step_up_campaign($user_id = 0) {
        //for makia users
        $userData = $this->Musers->get_users($user_id);
        if (isset($userData['user_from_site']) && ($userData['user_from_site'] == 1 || $userData['user_from_site'] == 2)) {
            $available_campaign_id = $this->Musers->canJoinStepUpCampaign($user_id);
            if ($available_campaign_id) {
                $finish_five_steps = false;
                // add campaign data if not
                $this->Musers->startJoinACampaign($user_id, $available_campaign_id);
                $stepUpNewCampProg = $this->Musers->getNewStepUpCampaignProgress($user_id, $available_campaign_id);
                if($stepUpNewCampProg['step1_fin_flag'] == 1 && $stepUpNewCampProg['step2_fin_flag'] == 1 && $stepUpNewCampProg['step3_fin_flag'] == 1 && $stepUpNewCampProg['step4_fin_flag'] == 1 && $stepUpNewCampProg['step5_fin_flag'] == 1) {
                    $this->viewData["requestMagnificationBonus"] = true;
                    $finish_five_steps = true;
                }
                $stepUpNewCamp = $this->Musers->getNewStepUpCampaign($stepUpNewCampProg['step_up_campaign_id']);
                if ($stepUpNewCamp) {
                    if ($stepUpNewCamp['new_campaign_flag'] == 1) {
                        $campaignEndDate = strtotime($stepUpNewCampProg['offcial_reg_date']. " + ".$stepUpNewCamp['campaign1_valid_days']." days");
                        if (date('Y-m-d',$campaignEndDate) <= date('Y-m-d')) {
                            $plusDate = $stepUpNewCamp['campaign1_valid_days'] + $stepUpNewCamp['campaign_retry_days'];
                            $campaignEndDate = strtotime($stepUpNewCampProg['offcial_reg_date']. " + ".$plusDate." days");
                            $this->viewData["planDate2"] = true;
                        }
                    }
                    else {
                        $campaignEndDate = strtotime($stepUpNewCamp['campaign2_end_date']);
                        if (date('Y-m-d',$campaignEndDate) <= date('Y-m-d')) {
                            $campaignEndDate = strtotime($stepUpNewCamp['campaign2_end_date']." + ".$stepUpNewCamp['campaign_retry_days']." days");
                            $this->viewData["planDate2"] = true;
                        }
                    }

                    $scoutMailBonus = $this->Musers->getCampaignBonus($user_id, BONUS_REASON_OPEN_SCOUT_MAIL, $stepUpNewCampProg['campaign_join_date']);
                    $inquiryBonus = $this->Musers->getCampaignBonus($user_id, BONUS_REASON_FIRST_MSG, $stepUpNewCampProg['campaign_join_date']);
                    $loginBonus = $this->Musers->getCampaignBonus($user_id, BONUS_REASON_LOGIN, $stepUpNewCampProg['campaign_join_date']);
                    $pageAccessBonus = $this->Musers->getCampaignBonus($user_id, BONUS_REASON_PAGE_ACCESS, $stepUpNewCampProg['campaign_join_date']);
                    $interviewBonus = $this->Musers->getCampaignBonus($user_id, BONUS_REASON_INTERVIEW, $stepUpNewCampProg['campaign_join_date']);
                    $remainingSlot =  $this->Musers->getStepUpCampaignRemainingSlot($stepUpNewCampProg['step_up_campaign_id']);
                    $remainingSteps = $stepUpNewCampProg['step1_fin_flag'] + $stepUpNewCampProg['step2_fin_flag'] + $stepUpNewCampProg['step3_fin_flag'] + $stepUpNewCampProg['step4_fin_flag'] + $stepUpNewCampProg['step5_fin_flag'];

                    $fiveStepTotalPoint = ($scoutMailBonus * $stepUpNewCamp['scout_bonus_mag_times']) + ($inquiryBonus * $stepUpNewCamp['msg_bonus_mag_times']);
                    $fiveStepTotalPoint += ($loginBonus * $stepUpNewCamp['login_bonus_mag_times']) + ($pageAccessBonus * $stepUpNewCamp['page_access_bonus_mag_times']);
                    $fiveStepTotalPoint += ($interviewBonus * $stepUpNewCamp['interview_bonus_mag_times']);
                    $noOfInterview = $stepUpNewCampProg['no_of_interviews'];
                    if ($noOfInterview > 0 && $finish_five_steps) {
                        $totalPoint = $fiveStepTotalPoint * $noOfInterview;
                    } else {
                        $totalPoint = $fiveStepTotalPoint;
                    }
                    $oneMoreInterViewFlag = false;
                    if ($noOfInterview + 1 <= $stepUpNewCamp['max_interview_bonus_times']) {
                        $oneMoreInterViewFlag = true;
                    }
                    $oneMoreInterviePoint = $totalPoint + $fiveStepTotalPoint;

                    HelperApp::add_session("userOtherSite", $available_campaign_id ? true : false);
                    $this->viewData["canAvailStepUpCampaign"] = $available_campaign_id ? true : false;
                    $this->viewData["remainingSteps"] = 5 - $remainingSteps;
                    $this->viewData["remainingTime"] = strtotime(date('Y-m-d 23:59:59', $campaignEndDate)) - time();
                    $this->viewData["remainingDays"] = floor((strtotime(date('Y-m-d 23:59:59', $campaignEndDate)) - time())/ 86400);
                    $EndDateTime = strtotime(date('Y-m-d 23:59:59', $campaignEndDate));
                    if (time() < $EndDateTime) {
                        $this->viewData["stepUpNewCamp"] = $stepUpNewCamp;
                    }
                    $this->viewData["stepUpNewCampProg"] = $stepUpNewCampProg;
                    $this->viewData["totalPoint"] = $totalPoint;
                    $this->viewData["oneMoreInterViewFlag"] = $oneMoreInterViewFlag;
                    $this->viewData["oneMoreInterviePoint"] = $oneMoreInterviePoint;
                    $this->viewData["remainingSlot"] = $remainingSlot['max_user_no'] - $remainingSlot['c_finish_user'];
                }
            }
            $this->viewData['user_from_site'] = $userData['user_from_site'];
            return $this->viewData;
        }
    }
    public function history_inquiry($ors_id=null){
        if(!$ors_id){
            show_404();
        }
        $user_id= UserControl::getId();
        $count_conversation = $this->Musers->countConversation($user_id,$ors_id);
        // Pagination
        $total_number             = $count_conversation;
        $config['base_url']       = base_url('/user/joyspe_user/history_inquiry/'.$ors_id);
        $config['total_rows']     = $total_number;
        $config['constant_num_links'] = TRUE;
        $config['uri_segment']    = 5;
        $config["per_page"]       = $this->config->item('per_page');
        $this->pagination->initialize($config);
        $start_offset = intval($this->uri->segment(5));
        $per_page = $this->config->item('per_page');
        if ($start_offset == NULL) {
          $start_offset = 0;
        }
        $conversation = $this->Musers->exchangeConversation($user_id,$ors_id,$per_page,$start_offset);
        $this->viewData['conversation'] = $conversation;
        $this->viewData['titlePage'] = 'メッセージ履歴';
        $this->viewData['load_page'] = 'user/history/history_inquiry';
        $this->viewData['class_ext'] = 'history_inquiry';
        if($this->input->post('ajax')!=null){
            $this->load->view("history/history_inquiry",$this->viewData);
        }else{
            $this->load->view($this->layout,$this->viewData);
        }
    }

    /**
    * Check if an user can request for bonus
    *
    * @param $user_id user id of the requested person
    * @param $owner_id owner_id of the owner that user requested for bonus
    * @return TRUE: can request, FALSE: can not request
    */
    private function _check_conditions($user_id, $owner_id) {
        $ret = false;
        $campaignBonusRequest  = $this->MCampaign->getLatestCampaignBonusRequest();
        $ckIfdecline  = $this->mcampaign_bonus_request->ckIfdecline($user_id, $owner_id ,$campaignBonusRequest['id']);
        $requestCampaignStatus  = $this->mcampaign_bonus_request->canRequestCampaign($user_id, $owner_id ,$campaignBonusRequest);
        if ($ckIfdecline==false && $requestCampaignStatus==0) {
            $ret = true;
        }
        return $ret;
    }

    /**
    * Check check the opened news letter link if it's valid or not. 
    *
    * @param None
    * @return None
    */
    private function _check_news_letter(){
        // check login from URL in email address
        $login_url = $this->input->get('lparam');
        if ($login_url) {
            $data = urlencode($login_url);
            $decrypt = $this->cipher->decrypt($data);
            $arr = unserialize($decrypt);
            if (!$arr || !isset($arr['email']) || !isset($arr['password']) || !isset($arr['created_date'])) {
                redirect(base_url());
            }
            $email = $arr['email'];
            $pass  = $arr['password'];
            $user_info = $this->Musers->get_users_by_email($email);
            $ret = $this->mmail->get_mail_magazine_log($data, $arr['created_date']);
            if ($ret && $user_info && $this->Musers->check_emailpassexit($email, $pass)) {
                HelperApp::add_session('id', $user_info['id']);
                $data = array(
                    'last_visit_date' => date("y-m-d H:i:s"),
                );
                $this->Musers->update_User($data, $user_info['id']);

                // check if user can join campaign
                if ($user_info['user_from_site'] == 1 || $user_info['user_from_site'] == 2) {// just for makia/machemoba user
                    if ($stp_cpgn_id = $this->Musers->canJoinStepUpCampaign($user_info['id'])) {
                        // insert data for step up campaign data(if not created)
                        $this->Musers->startJoinACampaign($user_info['id'], $stp_cpgn_id);
                    }
                }

                //check if user has already login within this day
                $this->common->updateLoginBonus($user_info['id'], $user_info['user_from_site'], $user_info['last_visit_date']);
            }
        }
    }

    public function add_session_modal_box() {
        $this->session->set_userdata('modal', 1);
        $this->session->set_userdata('time_to_display',time());
    }
}
?>

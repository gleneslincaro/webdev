<?php

class History extends MX_Controller {

    private $viewData;
    private $common;
    const   DATA_PER_PAGE = 10;

    function __construct() {
        parent::__construct();
        $this->load->helper('breabcrumb_helper');
        $this->load->model('owner/Mscout');
        $this->load->model('owner/Mhistory');
        $this->load->model('owner/Muser');
        $this->load->model('owner/Mtemplate');
        $this->load->model('owner/Mowner');
        $this->load->model('owner/Mpoint');
        $this->load->model('owner/Mcommon');
        $this->load->model('owner/Musers');
        $this->common = new Common();
        $this->output->set_header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate");
        $this->output->set_header("Cache-Control: post-check=0, pre-check=0");
        $this->output->set_header("Pragma: no-cache");
        if (!OwnerControl::LoggedIn()) {
            redirect(base_url() . "owner/login/");
        }
        $this->form_validation->CI = & $this;
        HelperApp::start_session();
//        HelperGlobal::requireOwnerLogin();
    }

    /**
     * @author  [IVS] Phan Ngoc Minh Luan
     * @name 	history_app_work
     * @todo 	load view history_app_work
     * @param 	int $user_id, $owner_recruit_id
     * @return 	void
     */
    function history_app_work($user_id = null, $owner_recruit_id = null) {
        if ($user_id != null && $owner_recruit_id != null) {
            $owner_id = OwnerControl::getId();
            if ($owner_id != NULL) {
                $email_address = OwnerControl::getEmail();
                $recruit_money = $this->Mhistory->getJoyspeHappyMoney($user_id, $owner_recruit_id);
                $owners = $this->Mhistory->getTotal($email_address);
                $point_owner = $owners['total_point'];
                $money_owner = $owners['total_amount'];
                $owner_info = HelperGlobal::owner_info($owner_id);
                $this->viewData['owner_info'] = $owner_info;
                $this->viewData['total_point'] = $point_owner;
                $this->viewData['userProfiles'] = $this->Mhistory->getUserProfiles($user_id,$owner_recruit_id);
                $this->viewData['recruit_money'] = $recruit_money;
                $this->viewData['point_owner'] = $point_owner;
                $this->viewData['recruit_point'] = $recruit_money;
                $remainder_point = $point_owner - $recruit_money;
                $remainder_money = $money_owner - $recruit_money;
                $this->viewData['remainder_point'] = $remainder_point;
                $this->viewData['remainder_money'] = $remainder_money;
                $this->viewData['recruit_money'] = $recruit_money;
                $this->viewData['owner_recruit_id'] = $owner_recruit_id;
                $this->viewData['user_id'] = $user_id;
                if ($remainder_point < 0) {
                    HelperApp::add_session('owner_recruit_id', $owner_recruit_id);
                    HelperApp::add_session('user_list', $user_id);
                }
                $this->viewData['loadPage'] = "owner/history/history_app_work";
                $this->viewData['title'] = 'joyspe｜履歴一覧 - 採用金額';
                $this->load->view("owner/layout/layout_B", $this->viewData);
            } else {
                redirect(base_url() . "owner/login");
            }
        } else {
            show_404();
        }
    }

    /**
     * @author  [IVS] Phan Ngoc Minh Luan
     * @name 	history_app_work
     * @todo 	load view history_app_scout
     * @param
     * @return 	void
     */
    function history_app_scout($disp_pr_text = null) {
//        HelperGlobal::requireOwnerLogin();
//        HelperGlobal::checkScreen();
        if($this->input->post('_sendScout')) {
        	HelperApp::add_session('s_owner_index', true);;
        }
        $arrId = array();
        $this->load->model("user/Mnewjob_model");
        $email_address = OwnerControl::getEmail();
        if (isset($_SESSION['sCheckrs']) && (count($_SESSION['sCheckrs']) > 0)) {
            foreach (HelperApp::get_session('sCheckrs') as $key => $value) {
                foreach ($value as $vl) {
                  $arrId[] = $vl;
                }
            }
            $owner_id = OwnerControl::getId();
            $owner_recruit  = $this->Mowner->getOwnerRecruit($owner_id);
            $ownerData = $this->Mowner->getOwner($owner_id);
            $scout_pr_text = $owner_recruit['scout_pr_text'];

            $ownerRecruitId = $owner_recruit['id'];
            $company_data = $this->Mhistory->getOwnerRecruitHappyMoney($ownerRecruitId);
            $user_happy_money = $company_data[0]['user_happy_money'];
            $mst_template = $this->Mhistory->getMtemplatesTitle(($user_happy_money > 0) ? 'us03':'us14');
            $defaul_mail_title = str_replace('/--店舗名--/', $ownerData['storename'], $mst_template['title']);

            if ($_POST && $this->input->post('scout_pr_text_flag')) {
                $scout_mail_register = $this->input->post('scout_mail_register');
                $scout_title = $this->input->post('scout_title');
                $scout_pr_text = $this->input->post('scout_pr_text');
                $scout_pr_ttle = $this->input->post('scout_pr_ttle');
                $scout_pr_id = $this->input->post('scout_pr_id');
                if($scout_mail_register == 1) {
                    $scout_pr_id = $this->_insertOwnerScoutPrText($owner_id, $scout_title, $scout_pr_text, $scout_pr_ttle);
                    $scout_mail_message = '新しいスカウトメールを登録しました。';
                } else {
                    $this->Mowner->updateOwnerScoutMailPrText($scout_pr_id, array('active_flag' => 0));
                    $data = $this->Mowner->getOwnerScoutPrText(0, $owner_id, $scout_pr_id);
                    $scout_pr_id = $this->_insertOwnerScoutPrText($owner_id, $scout_title, $scout_pr_text, $scout_pr_ttle);
                    $scout_mail_message = 'スカウトメールを更新しました。';
                    $owner_recruit = $this->Mowner->getOwnerRecruit($owner_id);
                }
                unset($_POST);
                HelperApp::add_session('s_scout_pr_data', array('scout_pr_id' => $scout_pr_id, 'scout_mail_message' => $scout_mail_message, 'scout_title' => $scout_title, '$scout_pr_ttle' => $scout_pr_ttle));
                redirect(base_url() . "owner/history/history_app_scout");
            } else {
                $owner_scout_pr_text_data = $this->Mowner->getListOfOwnerScoutPrText($owner_id);
                $this->viewData['owner_scout_pr_text_data'] = $owner_scout_pr_text_data;
                $o_s_pr_text_total = count($owner_scout_pr_text_data);
                $this->viewData['o_s_pr_text_total'] = $o_s_pr_text_total;
                if ($o_s_pr_text_total == 0) {
                    $scout_pr_id = $this->_insertOwnerScoutPrText($owner_id, '名称未設定', $scout_pr_text, $defaul_mail_title);
                }
                if (isset($_SESSION['s_scout_pr_data'])) {
                    $s_scout_pr_data = HelperApp::get_session('s_scout_pr_data');
                    $scout_pr_id = $s_scout_pr_data['scout_pr_id'];
                    $scout_title = $s_scout_pr_data['scout_title'];
                    //$scout_pr_ttle = $s_scout_pr_data['scout_pr_ttle'];
                    $scout_mail_template_data = $this->Mowner->getOwnerScoutPrText(1, $owner_id, $scout_pr_id);
                    $this->viewData['scout_mail'] = $s_scout_pr_data['scout_mail_message'];
                    HelperApp::remove_session('s_scout_pr_data');
                } else {
                    if(isset($_SESSION['scout_mail_template_id'])) {
                        $scout_pr_id = HelperApp::get_session('scout_mail_template_id');
                        HelperApp::remove_session('scout_mail_template_id');
                        $scout_mail_template_data = $this->Mowner->getOwnerScoutPrText(1, $owner_id, $scout_pr_id);
                    } else {
                        $scout_mail_template_data = $this->Mowner->getOwnerFirstScoutMail($owner_id);
                    }
                }
                $scout_title = $scout_mail_template_data['title'];
                $scout_pr_text = $scout_mail_template_data['pr_text'];
                $scout_pr_ttle = $scout_mail_template_data['pr_title'];
                $scout_pr_id = $scout_mail_template_data['id'];
            }
            $this->viewData['scout_mail_template_id'] = $scout_pr_id;
            $this->viewData['scout_title'] = $scout_title;
            if (!$scout_pr_ttle) {
                $scout_pr_ttle = $defaul_mail_title;
            }
            $this->viewData['scout_pr_ttle'] = $scout_pr_ttle;
            $ownerRecruitId = $owner_recruit['id'];
            $this->viewData['scout_pr_text'] = $scout_pr_text;
            // get Charge scout message
            $scout = $this->Mhistory->getCharge('0');
            $user_profiles = $this->Mhistory->getArrUserProfiles($arrId);
            if ( $user_profiles && is_array($user_profiles) ){
                $newUserWithStat = array();
                foreach ($user_profiles as $a_new_user) {
                    $a_new_user["statistics"] = $this->Muser->getScoutMailStat($a_new_user["uid"]);
                    $newUserWithStat[] = $a_new_user;
                }
                $user_profiles = $newUserWithStat;
            }

            //$owner_recruit_id = $this->Mowner->getOwnerRecruitId($owner_id);
            $url = base_url()."user/joyspe_user/company/".$ownerRecruitId."/";
            $content = $this->common->setTemplateContentu03o01($owner_id, ($user_happy_money > 0)?array('us03'):array('us14'), 'getJobOwnerRecruito01', 1	, $url, 1, $scout_pr_text, $ownerRecruitId);

            if ($disp_pr_text) {
                $this->viewData['disp_pr_text'] = 1;
            }
            $content = str_replace(array("\r\n", "\n", "\r"), "<br/>", $content);
            $owners = $this->Mpoint->getTotal($email_address);
            $owner_info = HelperGlobal::owner_info($owner_id);
            $this->viewData['owner_info'] = $owner_info;
            $this->viewData['owner_scout_pr_text_data'] = $owner_scout_pr_text_data;
            $this->viewData['total_point'] = $owners['total_point'];
            $this->viewData['scout_money'] = $scout['amount'];
            $this->viewData['scout_point'] = $scout['point'];
            $this->viewData['user_profiles'] = $user_profiles;
            $this->viewData['content'] = $content;
            //$this->viewData['title_mail'] = $title_mail;
            $this->viewData['loadPage'] = "owner/history/history_app_scout";
            $this->viewData['title'] = 'joyspe｜履歴一覧 - スカウトメッセージ';
            $this->load->view("owner/layout/layout_B", $this->viewData);
        } else {
            redirect(base_url() . "owner/scout/scout_after");
        }
    }

    /**
     * @author  [IVS] Phan Ngoc Minh Luan
     * @name 	history_app_work
     * @todo 	check and return data for history_app_scout view
     * @param
     * @return 	void
     */
    public function history_app_scout_check() {
        $arr_user_id = $_POST['array_user_id'];
        HelperApp::add_session('scout_mail_template_id', $_POST['scout_pr_id']);
        $owner_id = OwnerControl::getId();
        $count = $count_unsent = $count_spams = 0;
        $str_unique_id = "";
        $remaining_scout_mail = $this->Mowner->getRemainingScoutEmail($owner_id);
        if ( $remaining_scout_mail >= count($arr_user_id) ){
    //        $user_profiles = $this->Mhistory->getArrUserProfiles($arr_user_id);
            foreach ($arr_user_id as $value) {
                $count++; // number checked box
                $flag_compare = $this->Mhistory->compareScoutMessageSpam($value, $owner_id);
                if ($flag_compare > 0) {
                    $count_spams++; // have spam
                    $unique_id = $this->Mscout->getUserUniqueId($value);
                    $str_unique_id = $unique_id . "," . $str_unique_id;
                } else { //don't have spam
                    $count_unsent++; // number of users are unsent scout message
                    $arr_user_id_unsent[] = $value;
                }
            }
            $result_str = substr($str_unique_id, 0, -1);
            if ($count_spams == $count) {
                $arr_param = array(
                    'str_unique_id' => $result_str,
                    'count_unsent' => $count_unsent,
                    'count' => $count,
                    'count_spams' => $count_spams,
                );
            }
            if (0 < $count_spams && $count_spams < $count) {
                $arr_param = array(
                    'str_unique_id' => $result_str,
                    'count_unsent' => $count_unsent,
                    'count' => $count,
                    'count_spams' => $count_spams,
                    'arr_user_id_unsent' => array('arr_user_id_unsent[]' => $arr_user_id_unsent),
                );
            }
            if ($count == $count_unsent) {
                $arr_param = array(
                    'count_unsent' => $count_unsent,
                    'count' => $count,
                    'count_spams' => $count_spams,
                );
                HelperApp::add_session('arr_user_id_unsent', $arr_user_id_unsent);
                HelperApp::add_session('count_unsent', $count_unsent);
            }
        }else{
            // over the number of send-able scout mails
            $arr_param = array(
                'error' => "送信可能スカウトメール数を超えましたため、スカウトできません。女性選択からやり直してください。"
            );
        }
        echo json_encode($arr_param);
        die;
    }

    /**
     * @author  [IVS] Phan Ngoc Minh Luan
     * @name 	history_app_work
     * @todo 	pay happy money for every user
     * @param 	int $user_id
     * @return 	void
     */
    function history_app_scout01($user_id = null) {

        if ($user_id != null) {
            $owner_id = OwnerControl::getId();
            $email_address = OwnerControl::getEmail();
            $owners = $this->Mhistory->getTotal($email_address);
            // get Charge scout message
            $scout = $this->Mhistory->getCharge('0');
            HelperApp::add_session('arr_user_id_unsent', array($user_id));
            $user_profile = $this->Mhistory->getSmallUserProfiles($user_id);
            // send mail us03 for user's mail
            $mst_template = $this->Mhistory->getMtemplates('us03');
            $content = $mst_template['content'];
            $content = str_replace(array("\r\n", "\n", "\r"), "<br/>", $content);
            $title_mail = $mst_template['title'];
            $owner_info = HelperGlobal::owner_info($owner_id);
            $this->viewData['owner_info'] = $owner_info;
            $this->viewData['total_point'] = $owners['total_point'];
            $this->viewData['scout_money'] = $scout['amount'];
            $this->viewData['scout_point'] = $scout['point'];
            $this->viewData['user_profile'] = $user_profile;
            $this->viewData['content'] = $content;
            $this->viewData['title_mail'] = $title_mail;
            $this->viewData['loadPage'] = "owner/history/history_app_scout01";
            $this->viewData['title'] = 'joyspe｜履歴一覧 - スカウトメッセージ';
            $this->load->view("owner/layout/layout_B", $this->viewData);
        } else {
            show_404();
        }
    }

    /**
     * @author [IVS] Lam Tu My Kieu
     * @name   get_owner_recruit_id
     * @todo   get owner recruit id
     * @param
     * @return int
     */
    public function get_owner_recruit_id() {
        $owner_id = OwnerControl::getId();
        $owner_recruit_id = $this->Mtemplate->getOwnerRecruit($owner_id);

        $id = $owner_recruit_id[0];
        return $id['id'];
    }

    /**
     * @author [IVS] Lam Tu My Kieu
     * @name   history_work
     * @todo   request happy money
     * @param  $page = 1
     * @return void
     */
    public function history_work($page = 1) {
        if (isset($_SESSION['sCheckrs'])) {
            HelperApp::remove_session('sCheckrs');
        }
        $title = 'joyspe｜申請一覧';
        $owner_id = OwnerControl::getId();
        $owner_data = HelperGlobal::owner_info($owner_id);
        $page = $page > 1 ? $page : 1;
        $ppp = $this->config->item('per_page');

        $users_data = $this->Muser->getAllUsersWork($owner_id, array(), $page, $ppp);
        $total = $this->Muser->countUsersWork($owner_id, array());
        $totalpage;
        if ($ppp != 0) {
            $totalpage = ceil($total / $ppp);
        }
        $this->viewData['totalpage'] = $totalpage;
        $this->viewData['title'] = $title;
        $this->viewData['owner_data'] = $owner_data;
        $this->viewData['user_data'] = $users_data;
        $this->viewData['paging'] = HelperApp::get_paging($ppp, base_url() . "owner/history/history_work", $total, $page);

        $this->viewData['loadPage'] = 'owner/history/history_work';
        $this->load->view("owner/layout/layout_A", $this->viewData);
    }

    /**
     * @author [IVS] Lam Tu My Kieu
     * @name   history_app
     * @todo   reply for user / hide user
     * @param  $page = 1
     * @return void
     */
    public function history_app($page = 1) {

        $title = 'joyspe｜履歴一覧 - 応募一覧';
        $owner_id = OwnerControl::getId();
        $owner_data = HelperGlobal::owner_info($owner_id);
        $page = $page > 1 ? $page : 1;
        $ppp = $this->config->item('per_page');

        $users_data = $this->Muser->getAllUsersWorkApp($owner_id, array(), $page, $ppp);

        $total = count($users_data);

        $totalpage;
        if ($ppp != 0) {
            $totalpage = ceil($total / $ppp);
        }
        $this->viewData['total'] = $total;
        $this->viewData['totalpage'] = $totalpage;
        $this->viewData['owner_data'] = $owner_data;
        $this->viewData['user_data'] = $users_data;
        $this->viewData['curpage'] = $page;
        $this->viewData['title'] = $title;
        $count = $this->Muser->countAllUsersApply($owner_id);
        $this->viewData['count'] = $count;
        $this->viewData['sCheckrs'] = HelperApp::get_session('sCheckrs');
        $this->viewData['paging'] = HelperApp::get_paging($ppp, base_url() . "owner/history/history_app", $total, $page);
        $this->viewData['loadPage'] = 'owner/history/history_app';
        $this->load->view("owner/layout/layout_A", $this->viewData);
    }

    /**
     * @author [IVS] Lam Tu My Kieu
     * @name   history_app_message_study
     * @todo   send message reply for user
     * @param $user_id
     * @return void
     */
    public function history_app_message_study($user_id = NULL) {

        $title = 'joyspe｜履歴一覧-応募一覧-メッセージ・検討メッセージ送信';
        $tem = $this->Mtemplate->getTemp('ow11');
        $this->viewData['tem'] = $tem;
        $owner_id = OwnerControl::getId();
        $owner_data = HelperGlobal::owner_info($owner_id);
        $owner_recruit_id = $this->Mowner->getOwnerRecruitIdOld($owner_id, $user_id);
        $this->viewData['owner_data'] = $owner_data;
        $users_data = $this->Muser->getUserWorkApp($owner_recruit_id, $user_id);
        if ($users_data != NULL) {
            $this->viewData['user_data'] = $users_data;
//            $body = $this->common->setTemplateContent($user_id, $owner_id, array('ow11'), 'getUserSelect', 'getJobTypeSelect', '', $user_id, '', '');
//            $title_mail = $this->common->setTemplateTitle($user_id, $owner_id, array('ow11'));

            $body =  $this->common->setTemplateContent('', '', array('us06'), '', '', 'getJobTypeOwner', '', '', '');
            $title_mail = $this->common->setTemplateTitle('', '', array('us06'));
            $this->viewData['body'] = $body;
            $this->viewData['title'] = $title;
            $this->viewData['title_mail'] = $title_mail;
            $this->viewData['loadPage'] = 'owner/history/history_app_message_study';
            $this->load->view("owner/layout/layout_B", $this->viewData);
        } else {
            show_404();
        }
    }

    /**
     * @author [IVS] Lam Tu My Kieu
     * @name   history_app_not
     * @todo   deny user / unhide user
     * @param $page = 1
     * @return void
     */
    public function history_app_not($page = 1) {

        $title = 'joyspe｜履歴一覧 - 応募非表示一覧';
        $owner_id = OwnerControl::getId();
        $owner_data = HelperGlobal::owner_info($owner_id);
        $page = $page > 1 ? $page : 1;
        $ppp = $this->config->item('per_page');

        $users_data = $this->Muser->getAllUsersHide($owner_id, array(), $page, $ppp);
        $total = $this->Muser->countUsersHide($owner_id, array());

        $totalpage;
        if ($ppp != 0) {
            $totalpage = ceil($total / $ppp);
        }
        $this->viewData['totalpage'] = $totalpage;
        $this->viewData['title'] = $title;
        $this->viewData['owner_data'] = $owner_data;
        $this->viewData['user_data'] = $users_data;

        $this->viewData['paging'] = HelperApp::get_paging($ppp, base_url() . "owner/history/history_app_not", $total, $page);
        $this->viewData['loadPage'] = 'owner/history/history_app_not';
        $this->load->view("owner/layout/layout_A", $this->viewData);
    }

    /**
     * @author [IVS] Lam Tu My Kieu
     * @name   history_app_message_farewell
     * @todo   send message farewell for user
     * @param $user_id
     * @return void
     */
    public function history_app_message_farewell($user_id = NULL) {

        $title = 'joyspe｜履歴一覧-応募一覧-メッセージ・採用見送りメッセージ';
        $tem = $this->Mtemplate->getTemp('ow10');

        $this->viewData['tem'] = $tem;

        $owner_id = OwnerControl::getId();
        $owner_data = HelperGlobal::owner_info($owner_id);
        $owner_recruit_id = $this->Mowner->getOwnerRecruitIdOld($owner_id, $user_id);
        $this->viewData['owner_data'] = $owner_data;
        $users_data = $this->Muser->getUserWorkAppNot($owner_recruit_id, $user_id);
        if ($users_data != NULL) {
            $this->viewData['user_data'] = $users_data;

//            $body = $this->common->setTemplateContent($user_id, $owner_id, array('ow10'), 'getUserSelect', 'getJobTypeSelect', '', $user_id, '', '');
//            $title_mail = $this->common->setTemplateTitle($user_id, $owner_id, array('ow10'));

            $body =  $this->common->setTemplateContent('', '', array('us05'), '', '', '', '', '', '');
            $title_mail = $this->common->setTemplateTitle('', '', array('us05'));

            $this->viewData['body'] = $body;
            $this->viewData['title'] = $title;
            $this->viewData['title_mail'] = $title_mail;
            $this->viewData['loadPage'] = 'owner/history/history_app_message_farewell';
            $this->load->view("owner/layout/layout_B", $this->viewData);
        } else {
            show_404();
        }
    }

    /**
     * @author [IVS] Lam Tu My Kieu
     * @name   history_adoption
     * @todo   history of user adoption
     * @param $page = 1
     * @return void
     */
    public function history_adoption($page = 1) {

        $title = 'joyspe｜履歴一覧 - スカウト履歴';
        $owner_id = OwnerControl::getId();
        $owner_data = HelperGlobal::owner_info($owner_id);

        $page = $page > 1 ? $page : 1;
        $ppp = $this->config->item('per_page');

        $users_data = $this->Muser->getAllUsersAdoption($owner_id, array(), $page, $ppp);
        $total = $this->Muser->countAllUsersAdoption($owner_id, array());

        $totalpage;
        if ($ppp != 0) {
            $totalpage = ceil($total / $ppp);
        }
        $this->viewData['totalpage'] = $totalpage;
        $this->viewData['title'] = $title;
        $this->viewData['user_data'] = $users_data;
        $this->viewData['owner_data'] = $owner_data;
        $this->viewData['paging'] = HelperApp::get_paging($ppp, base_url() . "owner/history/history_adoption", $total, $page);
        $this->viewData['loadPage'] = 'owner/history/history_adoption';
        $this->load->view("owner/layout/layout_A", $this->viewData);
    }

    /**
     * @author [IVS] Lam Tu My Kieu
     * @name   history_app_scout_again
     * @todo   send scout message again for user
     * @param $user_id
     * @return void
     */
    public function history_app_scout_again($user_id = NULL) {
        $title = 'joyspe｜履歴一覧 - スカウトメッセージ';
        $owner_id = OwnerControl::getId();
        $spam = $this->Mtemplate->checkScoutUser($user_id, $owner_id);
        $owner_data = HelperGlobal::owner_info($owner_id);
        $this->viewData['owner_data'] = $owner_data;
        $users_data = $this->Muser->getUserForScoutAgain($owner_id, $user_id);
        if ($users_data != NULL) {
            $this->viewData['user_data'] = $users_data;
            $mst_template = $this->Mhistory->getMtemplates('us03');
            $body = $mst_template['content'];
            $body = str_replace(array("\r\n", "\n", "\r"), "<br/>", $body);
            $title_mail = $mst_template['title'];
            $this->viewData['body'] = $body;
            $this->viewData['title_mail'] = $title_mail;
            $this->viewData['spam'] = $spam;
            $this->viewData['title'] = $title;
            $this->viewData['loadPage'] = 'owner/history/history_app_scout_again';
            $this->load->view("owner/layout/layout_B", $this->viewData);
        } else {
            show_404();
        }
    }

    /**
     * @author [IVS] Lam Tu My Kieu
     * @name   history_scout
     * @todo   history scout message
     * @param  $page = 1
     * @return void
     */
    public function history_scout($page = 1) {
      if(isset($_SESSION['sHistoryScoutSort'])) {
        $sort = HelperApp::get_session('sHistoryScoutSort');
        HelperApp::remove_session('sHistoryScoutSort');
      }
      else
        $sort = 'created_date';

      if(isset($_SESSION['resendUserScoutMail']))
        HelperApp::remove_session('resendUserScoutMail');
      if(isset($_SESSION['sCheckrs']))
        HelperApp::remove_session('sCheckrs');
        $title = 'joyspe｜スカウト履歴';
        $owner_id = OwnerControl::getId();
        $owner_data = HelperGlobal::owner_info($owner_id);

        $page = $page > 1 ? $page : 1;
        $ppp = $this->config->item('per_page');

        $scout_start_date = $this->input->get("scout_start_date");
        $scout_end_date = $this->input->get("scout_end_date");
        $unique_id = $this->input->get("u");
        if($scout_start_date || $scout_end_date)
          HelperApp::remove_session('sHistoryScoutSort');


        $users_data = $this->Muser->getAllUsersScout($owner_id, array(), $page, $ppp, $scout_start_date, $scout_end_date, $sort,$unique_id);

        if ( $users_data && is_array($users_data) ){
            $newUserWithStat = array();
            foreach ($users_data as $a_new_user) {
                $a_new_user["statistics"] = $this->Muser->getScoutMailStat($a_new_user["id"]);
                $newUserWithStat[] = $a_new_user;
            }
            $users_data = $newUserWithStat;
        }

        $total = $this->Muser->countAllUsersScout($owner_id, $scout_start_date, $scout_end_date,$unique_id);
        $opened_mail_number = $this->Muser->getNumberOfMailOpened($owner_id, $scout_start_date, $scout_end_date,$unique_id);
        $totalpage;
        if ($ppp != 0) {
            $totalpage = ceil($total / $ppp);
        }
        $this->viewData['page'] = $page;
        $this->viewData['ppp'] = $ppp;

        $this->viewData['sort'] = $sort;
        $this->viewData['totalpage'] = $totalpage;
        $this->viewData['title'] = $title;
        $this->viewData['owner_data'] = $owner_data;
        $this->viewData['user_data'] = $users_data;
        $this->viewData['scout_start_date'] = $scout_start_date;
        $this->viewData['unique_id']= $unique_id;
        $this->viewData['scout_end_date'] = $scout_end_date;
        $first_link = base_url() . 'owner/history/history_scout';
        $last_link  = base_url() . 'owner/history/history_scout/'.$totalpage;

        if (count($this->input->get()) > 0) {
            $first_link .= '?' . http_build_query($_GET, '', "&");
            $last_link  .= '?' . http_build_query($_GET, '', "&");
        }
        $this->viewData['first_link'] = $first_link;
        $this->viewData['last_link']  = $last_link;
        $mail_open_rate = "未定";
        if ( $total ){
            $mail_open_rate = number_format( ($opened_mail_number * 100) / $total, 1) . "% (".$opened_mail_number."/".$total.")";
        }
        $this->viewData['mail_open_rate'] = $mail_open_rate;

        $this->viewData['paging'] = HelperApp::get_paging($ppp, base_url() . "owner/history/history_scout", $total, $page);
        $this->viewData['loadPage'] = 'owner/history/history_scout';
        $this->load->view("owner/layout/layout_A", $this->viewData);
    }

    public function history_scout_sort() {
      if($_POST){
        $owner_id = OwnerControl::getId();
        $page = $this->input->post('page');
        $ppp = $this->input->post('ppp');
        $scout_start_date = $this->input->post('scout_start_date');
        $scout_end_date = $this->input->post('scout_end_date');
        $sort = $this->input->post('sort');
        $unique_id = $this->input->post('unique_id');
        HelperApp::remove_session('sHistoryScoutSort');
        $users_data = $this->Muser->getAllUsersScout($owner_id, array(), $page, $ppp, $scout_start_date, $scout_end_date, $sort,$unique_id);
        if($users_data && is_array($users_data) ){
            $newUserWithStat = array();
            foreach ($users_data as $a_new_user) {
                $a_new_user["statistics"] = $this->Muser->getScoutMailStat($a_new_user["id"]);
                $newUserWithStat[] = $a_new_user;
            }
            $users_data = $newUserWithStat;
        }

        $this->viewData['user_data'] = $users_data;
        $this->load->view("owner/history/history_scout_sort", $this->viewData);
      }
    }

    /**
     * @author [IVS] Nguyen Van Phong
     * @name   history_app_message_temp
     * @todo
     * @param
     * @return void
     */
    public function history_app_message_temp($disp_pr_text=false) {
        $title = 'joyspe｜メッセージ・テンプレート確認';
        $owner_id = OwnerControl::getId();
        $owner_data = HelperGlobal::owner_info($owner_id);
        $owner_recruit = $this->Mowner->getOwnerRecruit($owner_id);
        $ownerRecruitId = $owner_recruit['id'];
        $company_data = $this->Mhistory->getOwnerRecruitHappyMoney($ownerRecruitId);
        $user_happy_money = $company_data[0]['user_happy_money'];
        $mst_template = $this->Mhistory->getMtemplatesTitle(($user_happy_money > 0) ? 'us03':'us14');
        $defaul_mail_title = str_replace('/--店舗名--/', $owner_data['storename'], $mst_template['title']);
        $scout_pr_text = $owner_recruit['scout_pr_text'];

        if ($_POST) {
            $scout_mail_register = $this->input->post('scout_mail_register');
            $scout_title = $this->input->post('scout_title');
            $scout_pr_text = $this->input->post('scout_pr_text');
            $scout_pr_ttle = $this->input->post('scout_pr_ttle');
            $scout_pr_id = $this->input->post('scout_pr_id');

            if ($scout_mail_register == 1) {
                $scout_pr_id = $this->_insertOwnerScoutPrText($owner_id, $scout_title, $scout_pr_text, $scout_pr_ttle);
                $scout_mail_message = '新しいスカウトメールを登録しました。';
            } else {
                $this->Mowner->updateOwnerScoutMailPrText($scout_pr_id, array('active_flag' => 0));
                $data = $this->Mowner->getOwnerScoutPrText(0, $owner_id, $scout_pr_id);
                $scout_pr_id = $this->_insertOwnerScoutPrText($owner_id, $scout_title, $scout_pr_text, $scout_pr_ttle);
                $scout_mail_message = 'スカウトメールを更新しました。';
                $owner_recruit = $this->Mowner->getOwnerRecruit($owner_id);
            }
            unset($_POST);
            $pr_data_arr = array('scout_pr_id' => $scout_pr_id,
                                 'scout_mail_message' => $scout_mail_message,
                                 'scout_title' => $scout_title,
                                 'scout_pr_ttle' => $scout_pr_ttle);
            HelperApp::add_session('s_scout_pr_data', $pr_data_arr);
            redirect(base_url() . "owner/history/history_app_message_temp");
        } else {
            $owner_scout_pr_text_data = $this->Mowner->getListOfOwnerScoutPrText($owner_id);
            $this->viewData['owner_scout_pr_text_data'] = $owner_scout_pr_text_data;
            $o_s_pr_text_total = count($owner_scout_pr_text_data);
            $this->viewData['o_s_pr_text_total'] = $o_s_pr_text_total;
            if ($o_s_pr_text_total == 0) {
                $scout_pr_id = $this->_insertOwnerScoutPrText($owner_id, '名称未設定', $scout_pr_text, $defaul_mail_title);
            }

            if (isset($_SESSION['s_scout_pr_data'])) {
                $s_scout_pr_data = HelperApp::get_session('s_scout_pr_data');
                $scout_pr_id = $s_scout_pr_data['scout_pr_id'];
                //$scout_title = $s_scout_pr_data['scout_title'];
                $scout_mail_template_data = $this->Mowner->getOwnerScoutPrText(1, $owner_id, $scout_pr_id);
                $this->viewData['scout_mail'] = $s_scout_pr_data['scout_mail_message'];
                HelperApp::remove_session('s_scout_pr_data');
            } else {
                if (isset($_SESSION['scout_mail_template_id'])) {
                    $scout_pr_id = HelperApp::get_session('scout_mail_template_id');
                    HelperApp::remove_session('scout_mail_template_id');
                    $scout_mail_template_data = $this->Mowner->getOwnerScoutPrText(1, $owner_id, $scout_pr_id);
                } else {
                    $scout_mail_template_data = $this->Mowner->getOwnerFirstScoutMail($owner_id);
                }
            }
            $scout_title = $scout_mail_template_data['title'];
            $scout_pr_text = $scout_mail_template_data['pr_text'];
            $scout_pr_id = $scout_mail_template_data['id'];
            $scout_pr_ttle = $scout_mail_template_data['pr_title'];
        }
        $this->viewData['scout_title'] = $scout_title;
        $this->viewData['scout_mail_template_id'] = $scout_pr_id;

        $scoutMails = $this->Mhistory->getScoutMails();
        $listMail = array();
        $listScoutMails = array();
        $this->viewData['owner_data'] = $owner_data;
        $this->viewData['scout_pr_text'] = $scout_pr_text;
        if (!$scout_pr_ttle) {
            $scout_pr_ttle = $defaul_mail_title;
        }
        $this->viewData['scout_pr_ttle'] = $scout_pr_ttle;
        $this->viewData['content06'] = $this->common->setTemplateContent('', '', array('us06'), '', '', '', '', '', '');
        $this->viewData['title06'] = $this->common->setTemplateTitle('', '', array('us06'));
        $this->viewData['type06'] = 'us06';
        $url = base_url()."user/joyspe_user/company/".$ownerRecruitId;
        $this->viewData['content03'] = $this->common->setTemplateContentu03o01($owner_id,
                                        ($user_happy_money > 0) ? array('us03') : array('us14'),
                                        'getJobOwnerRecruito01', 1, $url, 1, $scout_pr_text, $ownerRecruitId);

        $this->viewData['title03'] = str_replace('/--店舗名--/', $owner_data['storename'], $mst_template['title']);
        $this->viewData['type03'] = ($user_happy_money > 0)?'us03':'us14';

        if ($disp_pr_text) {
            $ow_rec_data  = $this->Mowner->getOwnerRecruit($owner_id);
            if ($ow_rec_data) {
                $mapTemplate = $this->Mcommon->getMapTemplate(($user_happy_money > 0)?'us03':'us14');
                foreach ($mapTemplate as $variable) {
                    if ($variable['name'] == "スカウト自由文") {
                        $replace_data = nl2br($ow_rec_data[$variable["mapping_name"]]);
                        $this->viewData['content03'] = str_replace( "/--スカウト自由文--/",
                                                       $replace_data, $this->viewData['content03']);
                    }
                }
            }
            $this->viewData['disp_pr_text'] = 1;
        }

        $this->viewData['content07'] = $this->common->setTemplateContent('', '', array('us07'), '', '', '', '', '', '');
        $this->viewData['title07'] = $this->common->setTemplateTitle('', '', array('us07'));
        $this->viewData['type07'] = 'us07';

        $this->viewData['content05'] = $this->common->setTemplateContent('', '', array('us05'), '', '', '', '', '', '');
        $this->viewData['title05'] = $this->common->setTemplateTitle('', '', array('us05'));
        $this->viewData['type05'] = 'us05';

        $this->viewData['scoutMails'] = $listScoutMails;
        $this->viewData['listMail'] = $listMail;
        $this->viewData['title'] = $title;
        $this->viewData['loadPage'] = 'owner/history/history_app_message_temp';
        $this->load->view("owner/layout/layout_A", $this->viewData);
    }

    /**
     * @author [IVS] Nguyen Hong Duc
     * @name   history_app_action_conf
     * @todo   history app conf
     * @param  $userId
     * @return void
     */
    public function history_app_action_conf() {
        if ($_POST) {

            if (isset($_SESSION['sCheckrs'])) {
                foreach (HelperApp::get_session('sCheckrs') as $key => $value) {
                    foreach ($value as $vl) {
                        $userId[] = $vl;
                    }
                }
            }
            if ($this->input->post('ckUser')) {
                $userId = $this->input->post('ckUser');
            }
            $str = "";
            foreach ($userId as $usId) {
                $str .= $usId . ",";
            }
            $str = substr($str, 0, -1);
            $owner_id = OwnerControl::getId();
            $owner_data = HelperGlobal::owner_info($owner_id);
            $owner_recruit = $this->Mowner->getOwnerRecruit($owner_id);
            $url = base_url() . 'user/joyspe_user/company/' . $owner_recruit['id'];
//            $body = $this->common->setTemplateContent($userId, $owner_id, array('ow12'), 'getManyUserSelect', 'getJobUser', 'getJobOwnerRecruit', $userId, $url, '');
//            $title = $this->common->setTemplateTitle('', $owner_id, array('ow12'));
            $body =  $this->common->setTemplateContent('', '', array('us07'), '', '', '', '', '', '');
            $title = $this->common->setTemplateTitle('', '', array('us07'));

            $information = $this->Mhistory->getHistoryAppConf($userId, $owner_id);
            $this->viewData['body'] = $body;
            $this->viewData['titlemail'] = $title;
            $this->viewData['owner_data'] = $owner_data;
            $this->viewData['information'] = $information;
            $this->viewData['arrUserId'] = $userId;
            $this->viewData['loadPage'] = 'owner/history/history_app_action_conf';
            $this->viewData['title'] = "joyspe｜履歴一覧 - 会社・店舗情報　送信";
            $this->load->view("owner/layout/layout_E", $this->viewData);
        } else {
            redirect(base_url() . "owner/index");
        }
    }

    /**
     * @author [IVS] Nguyen Hong Duc
     * @name   history_app_action_conf_message
     * @todo   send_message
     * @param
     * @return void
     */
    public function history_app_action_conf_message() {
        if ($_POST) {
            $owner_id = OwnerControl::getId();
            $owner_status = OwnerControl::getOwnerStatus();
            $arrUserId = $this->input->post('arrUserId');
            $owner_recruit = $this->Mowner->getOwnerRecruit($owner_id);
            $url = base_url() . 'user/joyspe_user/company/' . $owner_recruit['id'];
            if (OwnerControl::getSetSendMail()) {
                $this->common->sendMail('', '', '', array('ow12'), $owner_id, '', '', 'getManyUserSelect', 'getJobUser', 'getJobOwnerRecruit', $arrUserId, $url, '');
            }

            $templOwner = $this->Mcommon->getTemplate('ow12');
            $dataOwner['owner_id'] = $owner_id;
            $dataOwner['template_id'] = $templOwner['id'];
            $dataOwner['created_date'] = date("y-m-d H:i:s");
            $this->Mtemplate->insertOwnerList($dataOwner);

            foreach ($arrUserId as $userId) {
                $owner_recruit_id= $this->Mowner->getOwnerRecruitIdOld($owner_id, $userId);
                $url = base_url() . 'user/joyspe_user/company/' . $owner_recruit_id;
                $flagsetsendmail = $this->Musers->get_users($userId);
                if (($flagsetsendmail['set_send_mail'] == 1) && ($owner_status != 1)) {
                    $this->common->sendMail('', '', '', array('us07'), $owner_id, '', $userId, 'getUserSelect', '', 'getJobOwner', '', $url, '');
                }
            }

            $templUser = $this->Mcommon->getTemplate('us07');
            $information = $this->Mhistory->getHistoryAppConf($arrUserId, $owner_id);

            foreach ($information as $listid) {
                //INSERT
                $dataUser['owner_recruit_id'] = $listid['owner_recruit_id'];
                $dataUser['user_id'] = $listid['usid'];
                $dataUser['user_message_status'] = 1;
                $dataUser['template_id'] = $templUser['id'];
                $dataUser['created_date'] = date("y-m-d H:i:s");
                $dataUser['updated_date'] = date("y-m-d H:i:s");
                $this->Mtemplate->insertUserList($dataUser);
                //UPDATE
                $updateUser['user_payment_status'] = 4;
                $updateUser['interview_date'] = date("y-m-d H:i:s");
                $this->Mtemplate->updateUserPaymentStatus($updateUser, $listid['usid'], $listid['owner_recruit_id']);
            }
            redirect(base_url() . "owner/dialog/dialog_transmission");
        } else {
            redirect(base_url() . "owner/index");
        }
    }

    /**
     * @author  [IVS] Lam Tu My Kieu
     * @name 	savecheck
     * @todo 	sace checkbox paging
     * @param 	null
     * @return 	void
     */
    public function saveCheck() {
        $checkrs = $this->input->post("ckUser");
        $curpage = $this->input->post("hdPage");

        $sessionArr[$curpage] = array();

        if (!isset($_SESSION['sCheckrs'])) {
            foreach ($checkrs as $value) {

                $sessionArr[$curpage][] = $value;
            }
            HelperApp::add_session('sCheckrs', $sessionArr);
        } else {
            unset($_SESSION['sCheckrs'][$curpage]);

            foreach ($checkrs as $value) {

                $_SESSION['sCheckrs'][$curpage][] = $value;
            }
        }
    }

    public function history_transmission($user_id = null, $type = 0, $nmu_id = null, $page = 1) {
      $page = $page > 1 ? $page : 1;
      $ppp = self::DATA_PER_PAGE;
      $owner_id = OwnerControl::getId();
      $owner_data = HelperGlobal::owner_info($owner_id);
      if ($type == 0) { // スカウト履歴
        $user_scout_mails_data = $this->Mowner->getUserScoutMails($owner_id, $user_id, $page, $ppp);
        $total = $this->Mowner->countUserScoutMails($owner_id, $user_id);
        $content = array();
        $title_mail = array();
        $sent_date = array();
        $scout_mail_open_date = array();
        foreach($user_scout_mails_data as $data) {
            $mstTemplate = $this->Mhistory->getMtemplatesTitle(($data['template_id'] == '25')?'us03':'us14');
            $url = base_url()."user/joyspe_user/company/".$data['owner_recruit_id'];
            $content[] = $this->common->setTemplateContentScoutMail($user_id, $owner_id, $data['owner_recruit_id'],
                                ($data['template_id'] == '25') ? 'us03' : 'us14', $url, $data['scout_mail_id']);
            if (isset($data['pr_title']) && $data['pr_title']) {
                $title_mail[] = $data['pr_title'];
            } else {
                // use the default
                $title_mail[] = str_replace('/--店舗名--/', $owner_data['storename'], $mstTemplate['title']);
            }
            $sent_date[] = $data['sent_date'];
            $scout_mail_open_date[]= $data['scout_mail_open_date'];
        }
        $content = str_replace(array("\r\n", "\n", "\r"), "<br/>", $content);
        $this->viewData['content'] = $content;
        $this->viewData['title_mail'] = $title_mail;
        $this->viewData['sent_date'] = $sent_date;
        $this->viewData['scout_mail_open_date'] = $scout_mail_open_date;
      } else { // 送受信履歴
        $msg_history = $this->Mowner->getUsrOwrMessageHistory($owner_id, $user_id, $nmu_id,$page, $ppp);
        $total = $this->Mowner->getUsrOwrMessageCnt($owner_id, $user_id, $nmu_id);
        $this->viewData['msg_history'] = $msg_history;
      }
      // paging
      $totalpage = 1;
      if ($ppp != 0) {
        $totalpage = ceil($total / $ppp);
      }

      $lastPage = $totalpage;
      $first_link = base_url() . 'owner/history/history_transmission/'.$user_id.'/'.$type;
      $last_link  = base_url() . 'owner/history/history_transmission/'.$user_id.'/'.$type.'/'.$lastPage;

      $this->viewData['first_link'] = $first_link;
      $this->viewData['last_link']  = $last_link;

      $this->viewData['paging'] = HelperApp::get_paging1($ppp, base_url() . "owner/history/history_transmission/".$user_id.'/'.$type.'/'.$nmu_id, $total, $page);
      $owners = $this->Mpoint->getTotal($owner_data['email_address']);
      $this->viewData['type'] = $type;
      $this->viewData['totalpage'] = $totalpage;
      $this->viewData['storename'] = $owner_data['storename'];
      $this->viewData['total_point'] = $owners['total_point'];
      $this->viewData['owner_id'] = $owner_id;
      $this->viewData['user_id'] = $user_id;
      $this->viewData['nmu_id'] = $nmu_id;
      $this->viewData['page_no'] = $page;
      $this->viewData['loadPage'] = "owner/history/history_transmission";
      $this->viewData['title'] = 'joyspe｜履歴一覧 - 送受信履歴';
      $this->load->view("owner/layout/layout_A", $this->viewData);
    }

    public function manualAssignsScheckrs($userId = null) {
      if (isset($_SESSION['sCheckrs']))
        HelperApp::remove_session('sCheckrs');
      if(isset($_SESSION['resendUserScoutMail']))
        HelperApp::remove_session('resendUserScoutMail');
      HelperApp::add_session('sCheckrs', array(array($userId)));
      HelperApp::add_session('resendUserScoutMail', 1);
      redirect(base_url() . "owner/history/history_app_scout");
    }

    private function _insertOwnerScoutPrText($owner_id, $title, $pr_text, $pr_title) {
      $data = array(
        'owner_id' => $owner_id,
        'title' => $title,
        'pr_text' => $pr_text,
        'pr_title' => $pr_title,
        'created_date' => date("y-m-d H:i:s")
      );
      $scout_pr_id = $this->Mowner->insertOwnerScoutPrText($data);
      return $scout_pr_id;
    }

    public function getOwnerScoutPrText() {
      $owner_id = OwnerControl::getId();
      $this->output->set_content_type('application/json');
      $id = $_GET['id'];
      $data = $this->Mowner->getOwnerScoutPrText(1, $owner_id, $id);
      HelperApp::add_session('scout_mail_template_id', $data['id']);
      echo json_encode($data);
    }

    public function setSortBlue() {
      if($_POST){
        $this->output->set_content_type('application/json');
        HelperApp::remove_session('sHistoryScoutSort');
        HelperApp::add_session('sHistoryScoutSort', $this->input->post('sort'));
        echo json_encode(array('result' => $this->input->post('sort')));
      }
    }

    public function removeSHistoryScoutSort() {
      HelperApp::remove_session('sHistoryScoutSort');
      exit;
    }

    // Get msg send/resend and scout history
    public function getSendHistory(){
      if ($this->input->post()) {
        $type = $this->input->post('type');
        $owner_id = $this->input->post('owner_id');
        $user_id = $this->input->post('user_id');
        $nmu_id = $this->input->post('nmu_id');
        $with_nmu_id = '';
        $ret_data = array();

        // pagination
        $page = 1;
        $ppp = self::DATA_PER_PAGE;
        if ($type == 0) { // for total of scout mails
          $total = $this->Mowner->countUserScoutMails($owner_id, $user_id);
        }else{ // get total of messages        
          $total = $this->Mowner->getUsrOwrMessageCnt($owner_id, $user_id, $nmu_id);
          $with_nmu_id = '/'.$nmu_id;
        }
        $totalpage = 0;
        if ($ppp != 0) {
          $totalpage = ceil($total / $ppp);
        }
        $lastPage = $totalpage;
        $first_link = base_url() . 'owner/history/history_transmission/'.$user_id.'/'.$type;
        $last_link  = base_url() . 'owner/history/history_transmission/'.$user_id.'/'.$type.'/'.$lastPage;
        $data['first_link'] = $first_link;
        $data['last_link']  = $last_link;
        $data['paging']     = HelperApp::get_paging1($ppp, base_url() . "owner/history/history_transmission/".$user_id.'/'.$type.$with_nmu_id, $total, $page);
        $data['totalpage']  = $totalpage;

        if ($type == 0) { // get cout message
          $title_mail = array();
          $content = array();
          $sent_date = array();
          $scout_mail_open_date = array();
          $owner_data = HelperGlobal::owner_info($owner_id);
          $user_scout_mails_data = $this->Mowner->getUserScoutMails($owner_id, $user_id, $page, $ppp);
          foreach($user_scout_mails_data as $scout_data) {
            $mstTemplate = $this->Mhistory->getMtemplatesTitle(($scout_data['template_id'] == '25')?'us03':'us14');
            $url = base_url()."user/joyspe_user/company/".$scout_data['owner_recruit_id'];
            $content[] = $this->common->setTemplateContentScoutMail($user_id, $owner_id, $scout_data['owner_recruit_id'],
                         ($scout_data['template_id'] == '25') ? 'us03' : 'us14', $url, $scout_data['scout_mail_id']);
            if (isset($scout_data['pr_title']) && $scout_data['pr_title']) {
                $title_mail[] = $scout_data['pr_title'];
            } else {
                // use the default
                $title_mail[] = str_replace('/--店舗名--/', $owner_data['storename'], $mstTemplate['title']);
            }
            $sent_date[] = $scout_data['sent_date'];
            $scout_mail_open_date[]= $scout_data['scout_mail_open_date'];
          }
          $content = str_replace(array("\r\n", "\n", "\r"), "<br/>", $content);
          $data['content'] = $content;
          $data['title_mail'] = $title_mail;
          $data['sent_date'] = $sent_date;
          $data['scout_mail_open_date'] = $scout_mail_open_date;
          $html = $this->load->view('owner/template/scout_history', $data, true);
          $ret_data = array($html);
        }else if ($type == 1) { // get send/receive message history
          $msg_history = $this->Mowner->getUsrOwrMessageHistory($owner_id, $user_id, $nmu_id, $page, $ppp);
          $html ="ユーザーからのお問い合わせはまだありません";
          $data['msg_history'] = $msg_history;
          $html = $this->load->view('owner/template/msg_history', $data, true);
          $ret_data = array($html);
        }
        echo json_encode($ret_data);
      }
    }

    /*public function access_log() {
        $this->load->model('owner/muser');
        $owner_id = OwnerControl::getId();
        $getLatestUserAccess = $this->muser->getLatestUserAccessLog($owner_id);
        $this->viewData['count_access_log'] = $this->muser->countAccessLog($owner_id);
        $this->viewData['latest_user_access_log'] = $getLatestUserAccess;
        $this->viewData['loadPage'] = 'scout/access_log';
        $this->viewData['title'] = 'joyspe｜アクセスログ';
        $this->load->view("owner/layout/layout_A", $this->viewData);
    }*/
}

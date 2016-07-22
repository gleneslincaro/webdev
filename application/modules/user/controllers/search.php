<?php

class Search extends MY_Controller
{
        protected $_data;
        private $viewdata = array();
        private $layout = "user/layout/main";
        // public $city_check= array();
        function __construct() {
                parent::__construct();
        $this->redirect_pc_site();
                $this->load->model("user/Mnewjob_model");
                $this->load->model("user/Mscout");
                $this->load->model("user/Mstyleworking");
                $this->load->model("user/Mhappymoney");
                $this->load->model("user/MCampaign");
                $this->load->model("user/mcampaign_bonus_request");
                $this->viewdata['idheader'] = NULL;
                $this->output->set_header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
                $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate");
                $this->output->set_header("Cache-Control: post-check=0, pre-check=0");
                $this->output->set_header("Pragma: no-cache");
                $common = new Common();
                $this->viewdata['banner_data'] = $common->getLatestBanner();
                $this->viewdata['banner_bonus_req'] = $this->mcampaign_bonus_request->getLatestCampaignBonusBanner();
                $this->load->library('user_agent');
        }
        /*
        * @author : IVS_Nguyen_Ngoc_Phuong
        * load all group city in search screen
        */
        public function loadCityGroup() {
                $city_group = $this->mcity->getCityGroup();
                $this->viewdata['city_group'] = $city_group;
                $this->viewdata['titlePage'] = 'joyspe｜スカウト一覧';
                $this->viewdata['load_page'] = "search/group_city";
                $this->load->view($this->layout, $this->viewdata);
        }
        /*
         * @author: VJS
         * @detail: redirect old area search pages to the new ones
         * @param:  old id value (1~8)
         */

        public function detail_search($id) {
                $base_url = base_url();
                switch ($id) {
                        case 1:
                                redirect($base_url . 'user/jobs/hokkaido/');
                                break;
                        case 2:
                                redirect($base_url . 'user/jobs/kanto/');
                                break;
                        case 3:
                                redirect($base_url . 'user/jobs/kitakanto/');
                                break;
                        case 4:
                                redirect($base_url . 'user/jobs/tohoku/');
                                break;
                        case 5:
                                redirect($base_url . 'user/jobs/tokai/');
                                break;
                        case 6:
                                redirect($base_url . 'user/jobs/kansai/');
                                break;
                        case 7:
                                redirect($base_url . 'user/jobs/shikoku/');
                                break;
                        case 8:
                                redirect($base_url . 'user/jobs/kyushu/');
                                break;
                        default:
                                show_404();
                }
        }
        /*
        * @author: IVS_Nguyen_Ngoc_Phuong
        * load main search
        */
        public function main_search() {
                $city_group = $this->mcity->getCityGroup();
                $this->viewdata['city_group'] = $city_group;
                $happymoney = $this->Mstyleworking->getHappyMoney();
                $hourly = $this->Mstyleworking->getHourlySalary();
                $monthly = $this->Mstyleworking->getMonthlySalary();
                $treatment = $this->Mstyleworking->getTreatments();
                $this->viewdata['hourly'] = $hourly;
                $this->viewdata['happymoney'] = $happymoney;
                $this->viewdata['monthly'] = $monthly;
                $this->viewdata['treatment'] = $treatment;
                $this->viewdata['titlePage'] = '高収入アルバイトのジョイスペ｜検索';
                $this->viewdata['load_page'] = "search/main_search";
                $this->load->view($this->layout, $this->viewdata);
        }
        /*
         * @author: IVS_Nguyen_Ngoc_Phuong
         * do search
         */
        public function search_list()
        {
            HelperApp::remove_session('sSearchKeyword');
            $owners = array();
            $user_id = 0;
            $day_happy_money=$this->config->item('day_happymoney');
            $city_group_id = 0;
            $idcity = '';
            $device = '';
            $keyword = '';

            //sort
            $sort=1;
            if(UserControl::LoggedIn()){
                $user_id = UserControl::getId();
            }
            if(isset($_GET['search_keyword'])){
                $this->viewdata['keyword'] = $keyword = $_GET['search_keyword'];
                HelperApp::add_session('sSearchKeyword', $keyword);


                $owner_status = "2,5";
                $offset = 0;
                /* pc */
                if (!$this->agent->is_mobile()) {
                    if (isset($_GET['page'])) {
                        $offset = $_GET['page'] ? $_GET['page'] : 0;
                    }
                }
                
                $all_owners=$this->Mstyleworking->search_keyword($sort, 0, $user_id, $keyword, 0, 0, $owner_status);
                if ($all_owners ) {
                    $owners = array_slice($all_owners, $offset, STORE_LIMIT);
                }
                
            }
            else {
                if(isset($_POST['check_city'])){
                    foreach ($_POST['check_city']as $t){
                        $idcity=$idcity.$t.",";
                    }
                    $idcity= substr($idcity,0, strlen($idcity) - 1);
                }
                if(isset($_POST['city_group_id'])){
                    $city_group_id=$this->input->post("city_group_id");
                }

                if($_POST){
                    HelperApp::add_session('idcity', $idcity);
                    HelperApp::add_session('city_group_id', $city_group_id);
                }
                if(!UserControl::LoggedIn()){
                    HelperApp::add_session("url_search", base_url()."user/search/search_list");
                }
                $idcity=HelperApp::get_session('idcity');
                $city_group_id=HelperApp::get_session('city_group_id');

                $owner_status = "2,5";
                //user login
                $owners = $this->Mstyleworking->search($idcity,$sort,STORE_LIMIT,$user_id,$city_group_id,$owner_status);
                //echo count($owners); die;
                

                $all_owners=$this->Mstyleworking->findAll($idcity,$sort,$user_id,$city_group_id,$owner_status);
            }

            if ($owners && is_array($owners) ){
                foreach ($owners as $key=>$v){
                    $jobtypename =$this->Mstyleworking->getJobtype($v['orid']);
                    $treatment =$this->Mstyleworking->getTreatment($v['orid']);
                    $owners[$key]['user_paymentstt']=$this->Mscout->getUserPaySTT($v['orid'],$user_id,$day_happy_money);
                    $owners[$key]['keepstt']=$this->Mscout->getUserKeepSTT($v['orid'],$user_id);
                    $treatmentID = array();
                    $treatmentsName = array();
                    foreach ($treatment as $t) {
                                $treatmentID[] = $t['id'];
                                $treatmentsName[] = $t['name'];
                        }
                    $owners[$key]['treatmentsID'] = implode(",", $treatmentID);
                    $owners[$key]['treatmentsName'] = implode(",", $treatmentsName);
                    $owners[$key]['jtname'] = isset($jobtypename[0]['name'])?$jobtypename[0]['name']:'';
                }
            }



            $device = '';
            if (isset($_GET['device'])) {
                $device = $_GET['device'];
            }
            /* sp */
            if ($this->agent->is_mobile() OR $device == 'sp') {
                $this->viewdata['load_page'] ="user/share/result_company";
            /* pc */
            } else {
                $this->layout = "user/pc/layout/main";
                $this->viewdata['load_page'] ="pc/search/do_search";
//                $this->viewdata['load_page_area'] = "user/pc/result_store";
                $this->viewdata['load_page_area'] = "pc/search/keysearch_result";
                $this->viewdata['searchRes'] = 'true';

                $this->load->library('pagination');
                /* ページネーション設定 */
                $count_all= ($all_owners)?count($all_owners):0;

                $config['page_query_string'] = TRUE;
                $config['base_url'] = base_url()."user/search/search_list/?search_keyword=$keyword";
                $config['total_rows'] = $count_all;
                $config['per_page'] = STORE_LIMIT;
                $config['first_link'] = FALSE;
                $config['last_link'] = FALSE;
                $config['num_links'] = 2;
                $config['prev_link'] = '&lt;';
                $config['prev_tag_open'] = '<li>';
                $config['prev_tag_close'] = '</li>';
                $config['next_link'] = '&gt;';
                $config['next_tag_open'] = '<li>';
                $config['next_tag_close'] = '</li>';
                $config['cur_tag_open'] = '<li><span class="current">';
                $config['cur_tag_close'] = '</span></li>';
                $config['num_tag_open'] = '<li>';
                $config['num_tag_close'] = '</li>';
                $config['query_string_segment'] = 'page';
                $config['prefix'] = '';
                $this->pagination->initialize($config);

                $this->viewdata['page_links'] = $this->pagination->create_links();
            }

            $count_all= ($all_owners)?count($all_owners):0;
            $count = count($owners);
            $getTreatments = $this->Mstyleworking->getTreatments();
            $this->viewdata['treatments'] = $getTreatments;
            $this->viewdata['count']=$count;
            $this->viewdata['ajax_load_more'] = "do_ajax_sort";
            $this->viewdata['count_title'] = "検索結果";
            $this->viewdata['count_all']=$count_all;
            $this->viewdata['storeOwner']=$owners;
            $this->viewdata['limit']=STORE_LIMIT;
            $this->viewdata['titlePage'] = '風俗求人 -ジョイスペ-｜検索一覧';
            $this->viewdata['imagePath'] = base_url(). $this->config->item('upload_owner_url') . 'images/';
            $this->load->view($this->layout, $this->viewdata);
        }
        /*
         * @author : IVS_Nguyen_Ngoc_Phuong
         * sort all result search
         */
        public function do_ajax_sort(){
                     $day_happy_money=$this->config->item('day_happymoney');
                        $idcity = '';
                        $sort = $this->input->post("id_select");
                        $more= $this->input->post("more");
                        $limit=$this->input->post("limit");
                        $offset=$this->input->post("offset");
                        if($more!='')
                        {
                            $limit=$limit+STORE_LIMIT;
                        }
                        $user_id=0;
                if(UserControl::LoggedIn()){
                        $user_id=  UserControl::getId();
                }
                        $happymoney1 = HelperApp::get_session('happymoney1');
                        $happymoney2 = HelperApp::get_session('happymoney2');
                        $hourly1 = HelperApp::get_session('hourly1');
                        $hourly2 = HelperApp::get_session('hourly2');
                        $monthly1 = HelperApp::get_session('monthly1');
                        $monthly2 = HelperApp::get_session('monthly2');
                        $treament1 = HelperApp::get_session('treatment1');
                        $treament2 = HelperApp::get_session('treatment2');
                        $treament3 = HelperApp::get_session('treatment3');
                        $idcity = HelperApp::get_session('idcity');
                        $city_group_id =HelperApp::get_session('city_group_id');
                //get value in db by id
                $happy_money_amount1=$this->Mstyleworking->getHappyMoneyAmount($happymoney1);
                $happy_money_amount2=0;
                if($happymoney2>0){
                        $happy_money_amount2=$this->Mstyleworking->getHappyMoneyAmount($happymoney2);
                }
                $hourly_amount1 = $this->Mstyleworking->getHourlySalaryAmount($hourly1);
                $hourly_amount2 = 0;
                if ($hourly2 != 0) {
                        $hourly_amount2 = $this->Mstyleworking->getHourlySalaryAmount($hourly2);
                }
                $monthly_amount1=$this->Mstyleworking->getMonthlySalaryAmount($monthly1);
                $monthly_amount2=0;
                if($monthly2>0)
                {
                        $monthly_amount2=$this->Mstyleworking->getMonthlySalaryAmount($monthly2);
                }

                $info_id = $_POST['info_id'];
                $info_id = $arrTown = join("','",  explode(",",$info_id));
                $keyword = HelperApp::get_session('sSearchKeyword');
                if($keyword) {
                    $owner_status = "2,5";
                    $owners = $this->Mstyleworking->search_keyword($sort, STORE_LIMIT, $user_id, $keyword, 0, $info_id,$owner_status);
                    $all_owners=$this->Mstyleworking->search_keyword($sort,  '', $user_id, $keyword, '', 0,$owner_status);
                }
                else {
                    $owners = $this->Mstyleworking->search($idcity,$sort,STORE_LIMIT,$user_id,$city_group_id, $info_id);
                    $all_owners=$this->Mstyleworking->findAll($idcity,$sort,$user_id,$city_group_id);
                }


                if ( $owners && is_array($owners) ){
                        foreach ($owners as $key=>$v){
                                $jobtypename =$this->Mstyleworking->getJobtype($v['orid']);
                                $treatment =$this->Mstyleworking->getTreatment($v['orid']);
                                $owners[$key]['jobtypename']=$this->Mstyleworking->getJobtype($v['orid']);
                                $owners[$key]['treatment']=$this->Mstyleworking->getTreatment($v['orid']);
                                $owners[$key]['keepstt']=$this->Mscout->getUserKeepSTT($v['orid'],$user_id);
                                $treatmentID = array();
                                $treatmentsName = array();
                                foreach ($treatment as $t) {
                                            $treatmentID[] = $t['id'];
                                            $treatmentsName[] = $t['name'];
                                    }
                                $owners[$key]['treatmentsID'] = implode(",", $treatmentID);
                                $owners[$key]['treatmentsName'] = implode(",", $treatmentsName);
                                $owners[$key]['jtname'] = isset($jobtypename[0]['name'])?$jobtypename[0]['name']:'';
                        }
                }
                $count_all = ($all_owners)?count($all_owners):0;;
                $count=  count($owners);
                $getTreatments = $this->Mstyleworking->getTreatments();
                $this->viewdata['treatments'] = $getTreatments;
                $this->viewdata['count']=$count;
                $this->viewdata['count_all']=$count_all;
                $this->viewdata['storeOwner']=$owners;
                $this->viewdata['happymoney1']=$happymoney1;
                $this->viewdata['happymoney2']=$happymoney2;
                $this->viewdata['hourly1']=$hourly1;
                $this->viewdata['hourly2']=$hourly2;
                $this->viewdata['monthly1']=$monthly1;
                $this->viewdata['monthly2']=$monthly2;
                $this->viewdata['treament1']=$treament1;
                $this->viewdata['treament2']=$treament2;
                $this->viewdata['treament3']=$treament3;
                $this->viewdata['limit']=$limit;
                $this->viewdata['imagePath'] = base_url(). $this->config->item('upload_owner_url') . 'images/';
                $this->load->view("user/share/company_list", $this->viewdata);
        }
}
?>

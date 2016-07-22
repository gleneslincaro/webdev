<?php
class Keep_list extends MY_Controller{
    private $viewdata= array();
    private $layout="user/layout/main";
    function __construct() {
        parent::__construct();
        $this->load->library('user_agent');
        $this->redirect_pc_site();
        $this->load->model("user/Mkeep");
        $this->load->model("user/Mscout");
        $this->load->model("user/Mstyleworking");
        $this->load->model("user/Mnewjob_model");
        $this->load->model("user/Mhappymoney");
        $this->load->model("user/mcampaign_bonus_request");
        HelperGlobal::require_login(base_url() . uri_string());
        $this->viewdata['idheader'] = NULL;
        $this->viewdata['class_ext'] = 'keep_list';
        $this->common = new Common();
    }
    /*
    * @author: IVS_Nguyen_Ngoc_Phuong
    * load favorite owners list of user
    */
    public function index(){
        $user_id= UserControl::getId();
        $offset = (int)$this->input->get('page');
        $owners= $this->Mkeep->getKeepList($user_id,STORE_LIMIT, $offset);
        foreach ($owners as $key=>$v){
            $jobtypename =$this->Mstyleworking->getJobtype($v['orid']);
            $treatment = $this->Mstyleworking->getTreatment($v['orid']);
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
        $count= count($owners);
        $count_all = $this->Mkeep->countOwnerList($user_id);

        if ($this->agent->is_mobile()) {
            $this->viewdata['load_page']="user/share/result_company";
            $this->layout = "user/layout/main";
        /* pc */
        } else {
            $this->load->library('pagination');
            /* ページネーション設定 */
            $config['page_query_string'] = TRUE;
            $config['base_url'] = base_url()."user/keep_list/?";
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
            foreach ($owners as $key => $value) {
                $owners[$key]['keepstt']=$this->Mscout->getUserKeepSTT($value['orid'], $user_id);
            }

            $this->viewdata['total_users'] = HelperGlobal::getUserTotalNumber();
            $this->viewdata['total_owners'] = HelperGlobal::gettotalHeader();

            $this->viewdata['load_page']="user/pc/share/result_company";
            $this->viewdata['load_page_area'] = "user/pc/store_list";
            $this->layout = "user/pc/layout/main";
            $breadscrumb_array = array(
                array("class" => "", "text" => "キープ一覧", 'link'=> "")
            );
            $this->viewdata['breadscrumb_array'] = $breadscrumb_array;
            $this->viewdata['imagePath'] = base_url(). $this->config->item('upload_owner_url') . 'images/';
            $this->viewdata['banner_bonus_req'] = $this->mcampaign_bonus_request->getLatestCampaignBonusBanner();
            $this->viewdata['banner_data'] = $this->common->getLatestBanner();
        }

        $getTreatments = $this->Mstyleworking->getTreatments();
        $this->viewdata['treatments'] = $getTreatments;
        $this->viewdata['count']=$count;
        $this->viewdata['ajax_load_more'] = 'load_ajax_keeplist';
        $this->viewdata['count_title'] = 'キープ件数';
        $this->viewdata['count_all']=$count_all;
        $this->viewdata['limit'] = STORE_LIMIT;
        $this->viewdata['storeOwner']=$owners;
        $this->viewdata['titlePage'] = 'joyspe｜キープ一覧';
        $this->viewdata['imagePath'] = base_url(). $this->config->item('upload_owner_url') . 'images/';
        $this->load->view($this->layout,$this->viewdata);

    }
    /*
    * @author: IVS_Nguyen_Ngoc_Phuong
    * show more 10 owners in favorite list of user
    */
    public function load_ajax_keeplist(){
        $user_id= UserControl::getId();
        $get_more_owner=$this->input->post("more");
        $limit = STORE_LIMIT;
        $offset = 0;
        if (isset($_POST['offset'])) {
            $offset = (int)$_POST['offset'];
        }
        $count_all=$this->input->post("count_all");
        $owners= $this->Mkeep->getKeepList($user_id, $limit, $offset);
        foreach ($owners as $key=>$v){
            $jobtypename =$this->Mstyleworking->getJobtype($v['orid']);
            $treatment = $this->Mstyleworking->getTreatment($v['orid']);
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
        $count= count($owners);
        $getTreatments = $this->Mstyleworking->getTreatments();
        $this->viewdata['treatments'] = $getTreatments;
        $this->viewdata['count']= $count;
        $this->viewdata['count_all']= $this->Mkeep->countOwnerList($user_id);
        $this->viewdata['limit']= STORE_LIMIT;
        $this->viewdata['storeOwner']= $owners;
        $this->viewdata['imagePath'] = base_url(). $this->config->item('upload_owner_url') . 'images/';
        $this->load->view("user/share/company_list",$this->viewdata);
    }
    /*
    * @author: IVS_Nguyen_Ngoc_Phuong
    * show Detai Owner
    */
    public function company_keep($ors_id=0){
        $user_id= UserControl::getId();
        // get all infomation of owner
        $company_data= $this->Mnewjob_model->getAllCompany($ors_id);
        //status public information of owner
        $public_stt=0;
        foreach ($company_data as $key=>$v){
            $public_stt=$v['public_stt'];
            $company_data[$key]['jobtypename']=$this->Mnewjob_model->getJobTypeCompany($v['ors_id']);
            $company_data[$key]['treatment']=$this->Mnewjob_model->getTreatmentCompany($v['ors_id']);
            $company_data[$key]['keepstt']=$this->Mscout->getUserKeepSTT($v['ors_id'],$user_id);
            }
        //get stt spam message
        $status_scout_spam=$this->Mhappymoney->getScoutSpam($user_id,$ors_id);
        $count_scout=  count($status_scout_spam);
        $stt=0;
        if($count_scout>0){
            $stt=$status_scout_spam['stt'];
        }
        $this->viewdata['company_data']=$company_data;
        $this->viewdata['owner_id'] = $company_data[0]['owner_id'];
        $this->viewdata['ors_id'] = $company_data[0]['ors_id'];
        $this->viewdata['user_from_site'] = UserControl::getFromSiteStatus();
        $this->viewdata['title']=$company_data[0]['title'];
        $this->viewdata['user_id'] = $user_id;
        $this->viewdata['stt']=$stt;
        //$this->viewdata['status_scout_spam']=$status_scout_spam;
        $this->viewdata['titlePage'] = 'joyspe｜会社情報詳細';
        if ($public_stt == 0) {
            $this->viewdata['load_page'] = "user/company_not";
        }else {
            $this->viewdata['load_page'] = "user/company_detail";
        }
        $this->viewdata['imagePath'] = base_url(). $this->config->item('upload_owner_url') . 'images/';
        $this->load->view($this->layout,$this->viewdata);
    }
}
?>

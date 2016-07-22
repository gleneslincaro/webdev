<?php
class Scout extends MY_Controller {
    private $viewdata= array();
    private $layout="user/layout/main";
    function __construct() {
        parent::__construct();
		$this->redirect_pc_site();
        $this->load->model("user/Mnewjob_model");
        $this->load->model("user/Mscout");
        $this->load->model("user/Mstyleworking");
        $this->load->model("user/Mhappymoney");
        $this->load->model("user/Musers");
        $this->load->model("user/MCampaign");
        $this->load->model("user/Mtravel_expense");
        $this->viewdata['idheader'] = 1;
        $this->common = new Common();
        HelperGlobal::require_login(current_url());
        $this->viewdata['class_ext'] = 'keep_list';
    }
    /*
    * @author: IVS_Nguyen_Ngoc_Phuong
    * load scout list of user
    */
    public function scout_list(){
       $user_id= UserControl::getId();
       $day_happy_money=$this->config->item('day_happymoney');
       $owners= $this->Mscout->getListScout($user_id,STORE_LIMIT);
       foreach ($owners as $key=>$v){
          $jobtypename=$this->Mstyleworking->getJobtype($v['ors_id']);
          $treatment=$this->Mstyleworking->getTreatment($v['ors_id']);
          $treatmentID = array();
          $treatmentsName = array();
          foreach ($treatment as $t) {
              $treatmentID[] = $t['id'];
              $treatmentsName[] = $t['name'];
          }
          $owners[$key]['treatmentsID'] = implode(",", $treatmentID);
          $owners[$key]['treatmentsName'] = implode(",", $treatmentsName);
          $owners[$key]['jtname'] = isset($jobtypename[0]['name'])?$jobtypename[0]['name']:'';
          $owners[$key]['keepstt']=$this->Mscout->getUserKeepSTT($v['ors_id'],$user_id);
          $owners[$key]['orid'] = $owners[$key]['ors_id'];
       }
       $count= count($owners);
       $count_all = $this->Mscout->countOwnerList($user_id);
       $this->viewdata['count']=$count;
       $this->viewdata['ajax_load_more'] = "ajax_load_ScoutList";
       $this->viewdata['count_title'] = "スカウト件数";
       $this->viewdata['count_all']=$count_all;
       $this->viewdata['limit']=STORE_LIMIT;
       $this->viewdata['storeOwner']=$owners;
       $this->viewdata['titlePage'] = 'joyspe｜スカウト一覧';
       $this->viewdata['load_page']="user/share/result_company";
       $this->viewdata['imagePath'] = base_url(). $this->config->item('upload_owner_url') . 'images/';
       $this->load->view($this->layout,$this->viewdata);
    }
    /*
    * @author: IVS_Nguyen_Ngoc_Phuong
    * load more owner in ScoutList
    */
    public function ajax_load_ScoutList()
    {
        $day_happy_money=$this->config->item('day_happymoney');
        $user_id= UserControl::getId();
        $get_more_owner=$this->input->post("more");
         if($get_more_owner!=''){
            $limit=$this->input->post("limit");
            $limit=$limit+STORE_LIMIT;
        }
        $count_all=$this->input->post("count_all");

        $owners= $this->Mscout->getListScout($user_id,$limit);
        //$public_stt=0;
        foreach ($owners as $key=>$v){
            $jobtypename=$this->Mstyleworking->getJobtype($v['ors_id']);
            $treatment=$this->Mstyleworking->getTreatment($v['ors_id']);
            $treatmentID = array();
            $treatmentsName = array();
            foreach ($treatment as $t) {
                $treatmentID[] = $t['id'];
                $treatmentsName[] = $t['name'];
            }
            $owners[$key]['treatmentsID'] = implode(",", $treatmentID);
            $owners[$key]['treatmentsName'] = implode(",", $treatmentsName);
            $owners[$key]['jobtypename']=$this->Mstyleworking->getJobtype($v['ors_id']);
            $owners[$key]['treatment']=$this->Mstyleworking->getTreatment($v['ors_id']);            
            $owners[$key]['keepstt']=$this->Mscout->getUserKeepSTT($v['ors_id'],$user_id);
            $owners[$key]['orid'] = $owners[$key]['ors_id'];
        }
        $count= count($owners);
        $count_all = $this->Mscout->countOwnerList($user_id);
        $this->viewdata['count']=$count;
        $this->viewdata['count_all']=$count_all;
        $this->viewdata['limit']=$limit;
        $this->viewdata['storeOwner']=$owners;
        $this->viewdata['imagePath'] = base_url(). $this->config->item('upload_owner_url') . 'images/';
        $this->load->view("user/share/company_list",$this->viewdata);
    }    
    /*
    * @author: IVS_Nguyen_Ngoc_Phuong
    * show Detai Owner for user has user_payment_status=0,1,3
    */
    public function company_scout($ors_id=0){
        $user_id= UserControl::getId();
        $user_data = $this->Musers->get_users_by_id($user_id);
        $user_from_site = $user_data['user_from_site'];
        //get all infomation of owner
        $company_data= $this->Mnewjob_model->getAllCompany($ors_id);

        // キャンペーン情報表示
        $campaign_data  = $this->MCampaign->getLatestCampaign();
        $owner_id       =  isset($company_data[0]['owner_id']) ? $company_data[0]['owner_id'] : null;
        if ( $campaign_data ) {
            $request_status = 0; // 交通費申請可能
            if ( $user_id ) { // ログイン中の場合
                $request_status  = $this->Mtravel_expense->canRequestTrvelExpense(
                $user_id,
                $owner_id,
                $campaign_data['id'],
                $campaign_data['travel_expense'],
                $campaign_data['budget_money'],
                $campaign_data['max_request_times'],
                $campaign_data['multi_request_per_owner_flag']);
            }
            $this->viewdata['request_status']   = $request_status;
            $this->viewdata['travel_expense']   = $campaign_data['travel_expense'];
            $this->viewdata['campaign_id']      = $campaign_data['id'];
        }

        //status public
        $public_stt=0;
        foreach ($company_data as $key=>$v){
            $public_stt=$v['public_stt'];
            $company_data[$key]['jobtypename']=$this->Mnewjob_model->getJobTypeCompany($v['ors_id']);
            $company_data[$key]['treatment']=$this->Mnewjob_model->getTreatmentCompany($v['ors_id']);
        }
        //get stt spam message
        $status_scout_spam=$this->Mhappymoney->getScoutSpam($user_id,$ors_id);
        $count_scout=  count($status_scout_spam);
        $stt=0;
        //check owner spam mail user
        if($count_scout>0){
            $stt=$status_scout_spam['stt'];
        }
        $this->viewdata['user_id'] = $user_id;
        $this->viewdata['user_from_site'] = $user_from_site;
        $this->viewdata['company_data']=$company_data;
        $this->viewdata['ors_id']=$company_data[0]['ors_id'];
        $this->viewdata['owner_id']=$company_data[0]['owner_id'];
        $this->viewdata['title']=$company_data[0]['title'];
        $this->viewdata['stt']=$stt;
        //$this->viewdata['status_scout_spam']=$status_scout_spam;
        $this->viewdata['titlePage'] = 'joyspe｜スカウト一覧';

        $user_unique_id = "";
        if ( isset($user_id) && $user_id ){
          $user_unique_id = UserControl::getUnique_id();
        }
        $this->viewdata['user_unique_id'] = $user_unique_id;

        if($public_stt==0){
            $this->viewdata['load_page'] = "user/company_not";
        }else
             $this->viewdata['load_page'] = "user/scout/scout_owner_detail";
        $this->viewdata['imagePath'] = base_url(). $this->config->item('upload_owner_url') . 'images/';
        $this->viewdata['banner_data'] = $this->common->getLatestBanner();
        $this->load->view($this->layout,$this->viewdata);
    }
}

?>

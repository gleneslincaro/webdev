<?php
class Celebration extends MY_Controller
{
    private $viewdata= array();
    private $layout="user/layout/main";
    private $layout1="user/layout/main_menu";
    private $keywords    = "風俗,求人,/--TOWN--/,/--INDUSTRY--/";
    private $description = "風俗求人・高収入アルバイトは女性のためのハローワークと言えばジョイスペ。このページでは/--CITY--/・/--TOWN--/にある【/--STORENAME--/】の求人情報/--INDUSTRY--/をご案内します。採用でお祝い金をGET!";
    function __construct() {
        parent::__construct();
		$this->redirect_pc_site();
        $this->load->model("user/Mhappymoney");
        $this->load->model("user/Mstyleworking");
        $this->load->model("user/Mnewjob_model");
        $this->load->model("user/Musers");
        $this->load->model("user/MCampaign");
        $this->load->model("user/Mtravel_expense");
        HelperGlobal::require_login(current_url());
        $this->common = new Common();
        $this->viewdata['idheader'] = 1;
    }
    /*
    * @author: IVS_Nguyen Ngoc Phuong
    * load list owner happy money
    */
    public function celebration_list(){
        $user_id= UserControl::getId();
        $day_happy_money=$this->config->item('day_happymoney');
        $get_condition=1;
        $limithpm=5;
        $listHappyMoney=$this->Mhappymoney->getHappyMoneyList($user_id,$get_condition,$limithpm,$day_happy_money);
        foreach ($listHappyMoney as $key=>$v){
            $listHappyMoney[$key]['jobtypename']=$this->Mstyleworking->getJobtype($v['ors_id']);
            $listHappyMoney[$key]['treatment']=$this->Mstyleworking->getTreatment($v['ors_id']);
        }
        $count=count($listHappyMoney);
        $list_all=$this->Mhappymoney->getAllHappyMoneyList($get_condition,$user_id);
        $count_all= count($list_all);
        $this->viewdata['count_all']=$count_all;
        $this->viewdata['listHappyMoney']=$listHappyMoney;
        $this->viewdata['count']=$count;
        $this->viewdata['limithpm']=$limithpm;
        $this->viewdata['imagePath'] = base_url(). $this->config->item('upload_owner_url') . 'images/';
        $this->viewdata['load_page']="happy_money/result_happy_money";
        $this->viewdata['titlePage'] = 'joyspe｜お祝い金リスト';
        $this->load->view($this->layout1,$this->viewdata);
    }
    /*
    * @author: IVS_Nguyen Ngoc Phuong
    * load more record
    */
    public function load_ajax_HappyMoney(){
        $user_id= UserControl::getId();
        $day_happy_money=$this->config->item('day_happymoney');
        $limithpm=5;
        $get_condition=$this->input->post("get_condition");
        $get_more_owner=$this->input->post("more_hpm_id");
        if($get_more_owner!=''){
            $limithpm=$this->input->post("limithpm");
            $limithpm=$limithpm+10;
        }
        $listHappyMoney=$this->Mhappymoney->getHappyMoneyList($user_id,$get_condition,$limithpm,$day_happy_money);
        foreach ($listHappyMoney as $key=>$v){
            $listHappyMoney[$key]['jobtypename']=$this->Mstyleworking->getJobtype($v['ors_id']);
            $listHappyMoney[$key]['treatment']=$this->Mstyleworking->getTreatment($v['ors_id']);
        }
        $count=count($listHappyMoney);
        $count_all=count($this->Mhappymoney->getAllHappyMoneyList($get_condition,$user_id));
        $this->viewdata['count_all']=$count_all;
        $this->viewdata['count']=$count;
        $this->viewdata['listHappyMoney']=$listHappyMoney;
        $this->viewdata['limithpm']=$limithpm;
        $this->viewdata['imagePath'] = base_url(). $this->config->item('upload_owner_url') . 'images/';
        $this->load->view("happy_money/list_happy_money",$this->viewdata);
    }
    /*
    * @author:IVS_Nguyen_Ngoc_Phuong
    * show detail of owner
    */
    public function company_celebration($ors_id=0)
    {
      $day_happy_money=$this->config->item('day_happymoney');
      $user_id= UserControl::getId();
      $user_data = $this->Musers->get_users_by_id($user_id);
      $user_from_site = $user_data['user_from_site'];
      $detail_owners= $this->Mhappymoney->getCompanyCelebration($ors_id);

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
          $this->viewdata['request_status'] = $request_status;
          $this->viewdata['travel_expense'] = $campaign_data['travel_expense'];
          $this->viewdata['campaign_id']    = $campaign_data['id'];
      }

      $public_stt=0;
      foreach ($detail_owners as $key=>$v){
        $public_stt=$v['public_stt'];
        $detail_owners[$key]['jobtypename']=$this->Mnewjob_model->getJobTypeCompany($v['ors_id']);
        $detail_owners[$key]['treatment']=$this->Mnewjob_model->getTreatmentCompany($v['ors_id']);
      }
      $status_hpm= $this->Mhappymoney->getUserPaymentStt($user_id,$ors_id,$day_happy_money);
      if(empty($status_hpm)){
        redirect(base_url() . 'user/celebration/celebration_list');
      }

      $status_scout_spam=$this->Mhappymoney->getScoutSpam($user_id,$ors_id);
      // check owner spam mail user
      $count_scout=  count($status_scout_spam);
      $stt=0;
      if($count_scout>0){
          $stt=$status_scout_spam['stt'];
      }
      $this->viewdata['user_id'] = $user_id;
      $this->viewdata['user_from_site'] = $user_from_site;
      $this->viewdata['ors_id'] = $detail_owners[0]['ors_id'];
      $this->viewdata['owner_id'] = $detail_owners[0]['owner_id'];
      $this->viewdata['imagePath'] = base_url(). $this->config->item('upload_owner_url') . 'images/';
      $this->viewdata['count_scout']=$count_scout;
      $this->viewdata['detail_owners']=$detail_owners;
      $this->viewdata['status_hpm']=$status_hpm;
      $this->viewdata['stt']=$stt;
      $this->viewdata['title']=$detail_owners[0]['title'];

      $this->viewdata['titlePage'] = $detail_owners[0]['storename'].'（'.$detail_owners[0]['town_name'].'）｜風俗求人の高収入アルバイト -ジョイスペ-';
      $i=0;
      $no_of_jobtypes =count($detail_owners[0]['jobtypename']);
      $industries = "";
      foreach ($detail_owners[0]['jobtypename'] as $j) {
          $industries .= $j['name'] ;
          $i++;
          if( $i < $no_of_jobtypes){
             $industries .= ",";
          }
      }
      $this->viewdata['keywords'] = $this->keywords;
      $this->viewdata['keywords'] = str_replace("/--TOWN--/", $detail_owners[0]['town_name'], $this->viewdata['keywords']);
      $this->viewdata['keywords'] = str_replace("/--INDUSTRY--/", $industries, $this->viewdata['keywords']);

      $this->viewdata['description'] = $this->description;
      $this->viewdata['description'] = str_replace("/--STORENAME--/", $detail_owners[0]['storename'], $this->viewdata['description']);
      $this->viewdata['description'] = str_replace("/--INDUSTRY--/", $industries, $this->viewdata['description']);
      $this->viewdata['description'] = str_replace("/--CITY--/", $detail_owners[0]['city_name'], $this->viewdata['description']);
      $this->viewdata['description'] = str_replace("/--TOWN--/", $detail_owners[0]['town_name'], $this->viewdata['description']);
      $user_unique_id = "";
      if ( isset($user_id) && $user_id ){
        $user_unique_id = UserControl::getUnique_id();
      }
      $this->viewdata['user_unique_id'] = $user_unique_id;

      $this->viewdata['status_scout_spam']=$status_scout_spam;
      if($public_stt==0){
        $this->viewdata['load_page'] = "user/company_not";
      } else {
        if ($status_hpm['user_payment_status'] == 5 || $status_hpm['user_payment_status'] == 6){
          $this->viewdata['load_page'] = "happy_money/detail_owner_hpm";
        } else {
          $this->viewdata['load_page'] = "happy_money/detail_owner_hpm1";
        }
      }
      $this->viewdata['banner_data'] = $this->common->getLatestBanner();
      $this->load->view($this->layout,$this->viewdata);
    }
    /*
    * @author: IVS_Nguyen_Ngoc_Phuong
    * action: take happy money
    */
    public function celebration_app($ors_id=0){
        if($ors_id==0)
        {
            redirect(base_url()."user/errorpage");
        }
        $user_id= UserControl::getId();
        $ownerid=$this->Musers->getOwnerId($ors_id);
        $owner=$this->Musers->get_owner($ownerid);
        $this->viewdata['storename'] = $owner['storename'];
        $this->viewdata['ors_id']=$ors_id;
        $this->viewdata['load_page']="user/happy_money/do_take_happy_money";
        $this->viewdata['titlePage'] = 'joyspe｜お祝い申請';
        $this->load->view($this->layout,$this->viewdata);
    }
    /*
    * @author: IVS_Nguyen_Ngoc_Phuong
    * complete event take happy money
    */
    public function celebration_complete($ors_id=0){
        if($ors_id==0)
        {
            redirect(base_url()."user/errorpage");
        }
        $user_id= UserControl::getId();
        $url= base_url().'user/celebration/company_celebration/'.$ors_id;
        $this->Mhappymoney->updatePaymentsSttt($user_id,$ors_id);
        $ownerid=$this->Musers->getOwnerId($ors_id);
        // insert to list_user_messages
        $mst_templates = $this->Musers->get_mst_templates($template_type ='us08');
        $this->Musers->insert_list_user_messages($user_id,$ors_id,date("y-m-d H:i:s"),$mst_templates);
         // insert to list_owner_messages
        $mst_templates1=$this->Musers->get_mst_templates($template_type ='ow13');
        $this->Musers->insert_list_owner_messages($ownerid,date("y-m-d H:i:s"),$mst_templates1);
        //get set send mail of user and owner
        if($this->Musers->setSendMail($user_id)==1)
        {
           $this->common->sendMail( '', '', '', array('us08'),$ownerid,'', $user_id,'getUserSelect','getJobUser','getJobOwner' ,'', $url,'');
        }
        if (($this->Musers->setSendMailOwner($ownerid) == 1)&& UserControl::getUserStt()==1) {
            $this->common->sendMail( '', '', '', array('ow13'),$ownerid,'', $user_id,'getUserSelect','getJobUser','getJobOwner' ,array($user_id), $url,'');
        }
        $this->viewdata['load_page']="user/happy_money/take_happy_money_complete";
        $this->viewdata['titlePage'] = 'joyspe｜お祝い金申請・完了';
        $this->load->view($this->layout,$this->viewdata);
    }
}
?>

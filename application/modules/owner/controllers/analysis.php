<?php
class  analysis extends MX_Controller
{   
     private $viewData = array();
     public function __construct() {
        parent::__construct();
        $this->load->model("owner/Manalysis");
        if (!OwnerControl::LoggedIn()) {
            redirect(base_url() . "owner/login/");
        }
    }
    public function index() {
        $this->load->model('owner/muser');
        $title = 'joyspe｜アクセス解析';
        $owner_id = OwnerControl::getId();
        $date_st = $this->Manalysis->getOwnerRegistDate($owner_id);
        $date_from = strtotime($date_st);
        $month1 = date('Y')*12 + date('m');
        $month2 = date('Y', $date_from)*12 + date('m',$date_from);
        $result = ($month1 - $month2)+1;
        list($year, $month) = explode("-", date('Y-m',strtotime($date_st)), 2);
        for($i=0; $i < ($result); $i++){ 
            $select_date_from[$i] = date('Y-m', mktime(0, 0, 0, $month + $i, 1, $year));
        }
        for($i=0; $i < $result; $i++){ 
            $select_date_to[$i] = date('Y-m', mktime(0, 0, 0, $month + $i, 1, $year));
        }
        $this->viewData['select_date_from'] = $select_date_from;
        $this->viewData['select_date_to'] = $select_date_to;
        $date = date('Y-m');
        list($year, $month) = explode("-", $date, 2);
        $nowMonth = date('Y-m-d', mktime(0, 0, 0, $month, 1, $year));
        $analysis_data[0] = $this->Manalysis->doUserAnalysis($owner_id,$nowMonth,date("Y-m-t",strtotime($nowMonth)));
        $analysis_data[0]['nowmonth'] = date('Y-m',strtotime($nowMonth));
        $this->viewData['analysis_data'] = $analysis_data;
        
        $getLatestUserAccess = $this->muser->getLatestUserAccessLog($owner_id);
        $this->viewData['count_access_log'] = $this->muser->countAccessLog($owner_id);
        $this->viewData['latest_user_access_log'] = $getLatestUserAccess;
        $this->viewData['title'] = $title;
        $this->viewData['loadPage'] = 'owner/analysis/analysis';
        $this->load->view("owner/layout/layout_A", $this->viewData);
    }
    //--------アクセス解析処理----------
    public function result_of_analysis() {
        $owner_id = OwnerControl::getId();
        $from_date = $this->input->post('from_date');
        $to_date = $this->input->post('to_date');
        $data1 = $this->Manalysis->doUserAnalysis($owner_id,$from_date,$to_date);
        $data11[0] = $data1;
        $this->viewData['analysis_data_ar'] = $this->Manalysis->doUserAnalysisMonth($owner_id,$from_date,$to_date);
        $this->viewData['analysis_data'] = $data11;
        $this->load->view("owner/analysis/result_of_analysis", $this->viewData);
    }
}
 
?>
<?php
//管理画面での店舗集計
class  analysis extends MX_Controller
{   
     private $viewData = array();
    public function __construct() {
        parent::__construct();
//        $this->load->model("owner/Manalysis");
    }

    public function index() {
    }

    //--------アクセス解析処理----------
    public function result_of_analysis() {
        $this->load->model("owner/Manalysis");

        $owner_id = $this->input->post('owner_id');
        $from_date = $this->input->post('from_date');
        $to_date = $this->input->post('to_date');

        $this->viewData['analysis_data_ar'] = $this->Manalysis->doUserAnalysisMonth($owner_id,$from_date,$to_date);
        $this->load->view("admin/search/result_of_analysis", $this->viewData);
    }

}
 
?>

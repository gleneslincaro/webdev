<?php
  class Log extends MX_Controller{
        protected $_data;
        protected $_dataResult;
        public function __construct() {
            parent::__construct();
            AdminControl::CheckLogin();
            $this->_data["module"] = $this->router->fetch_module();
            $this->output->set_header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
            $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate");
            $this->output->set_header("Cache-Control: post-check=0, pre-check=0");
            $this->output->set_header("Pragma: no-cache");
        }
         /**
	 * @author     [IVS] Nguyen Van Vui
	 * @name 	settlement
	 * @todo 	view info settlement
	 * @param 	 
	 * @return 	
	 */
        public function settlement(){
            $this->_data['data_search'] = null;
            $this->_data["selectYear"]=date("Y");
            $this->_data["selectMonth"]=1;
            $this->_data['titlePage']='joyspe管理画面';
            $this->_data["loadPage"]="log/settlement";
            $this->load->view($this->_data["module"]."/layout/layout",$this->_data);
        }
         /**
	 * @author     [IVS] Nguyen Hoai Nam
	 * @name 	searchSettlement
	 * @todo 	view search info settlement
	 * @param 	 
	 * @return 	
	 */
        public function searchSettlement(){
            
            $year=trim($this->input->post("cbYear"));            
            $month=trim($this->input->post("cbMonth"));            
            $where="";
            $_totalPoint=0;
            $_totalRowCount=0;
            
            if($year != ""){
                $where.=" AND YEAR(approved_date) = ".$this->db->escape($year);
            }
            if($month != ""){
                $where.=" AND MONTH(approved_date) = ".$this->db->escape($month);
            }
           
            $this->load->Model("admin/Mlog");
            $this->_dataResult =$this->Mlog->searchBySettlement($where);
            
            foreach ($this->_dataResult as $key => $items) {
                $_totalPoint = $_totalPoint + (int)$items['amount'];
                $_totalRowCount = $_totalRowCount + (int)$items['rowcount'];
            }
            
            if(!empty($this->_dataResult)){
                
                $key = (int)end(array_keys($this->_dataResult)) + 1;
                $this->_dataResult[$key]['updated_date']= "合計";
                $this->_dataResult[$key]['amount'] = $_totalPoint;
                $this->_dataResult[$key]['rowcount'] = $_totalRowCount;

                $_averagePoint = $_totalPoint / $key;
                $_averageRowCount = $_totalRowCount / $key;
                $this->_dataResult[$key+1]['updated_date']= "平均";
                $this->_dataResult[$key+1]['amount'] = $_averagePoint;
                $this->_dataResult[$key+1]['rowcount'] = number_format($_averageRowCount, 1, '.', ',');
                                  
            }
            $this->_data["data_search"] = $this->_dataResult;
            $this->_data["selectYear"]=$year;
            $this->_data["selectMonth"]=$month;
            
            $this->_data["loadPage"]="log/settlement";
            $this->_data['titlePage']='joyspe管理画面';
            $this->load->view($this->_data["module"]."/layout/layout",$this->_data);
        }
        
        /**
	 * @author     [IVS] Nguyen Van Vui
	 * @name 	settlementlog
	 * @todo 	view serach settlement log
	 * @param 	 
	 * @return 	
	 */
        
        function settlementlog() {
            $this->load->Model('admin/Mlog');
            $this->_data['paymentcases']=$this->Mlog->listPaymentCases();
            $this->_data['paymentmethods']=$this->Mlog->listPaymentMethods();
            $this->_data['loadPage']='log/settlementlog';
            $this->_data['titlePage']='joyspe管理画面';
            $this->load->view($this->_data['module'].'/layout/layout',$this->_data);
        }
        
        /**
	 * @author     [IVS] Nguyen Van Vui
	 * @name 	view_settlementlog
	 * @todo 	view info settlement log
	 * @param 	 
	 * @return 	
	 */
        
        function view_settlementlog() {
            $start = 0;
            
            $where='';
            
            $txtEmail=trim($this->input->post('txtEmail'));
            $cbPaymentCases=$this->input->post('cbPaymentCases');
            $cbPaymentMethods=$this->input->post('cbPaymentMethods');
            $cbCreditResult=$this->input->post('cbCreditResult');
            $txtTranferDateFrom=$this->input->post('txtTranferDateFrom');
            $txtTranferDateTo=$this->input->post('txtTranferDateTo');
            $this->load->Model('admin/Mlog');
            $this->_data['paymentcases']=$this->Mlog->listPaymentCases();
            $this->_data['paymentmethods']=$this->Mlog->listPaymentMethods();
            $this->_data['email']=$txtEmail;
            $this->_data['cbPaymentCases']=$cbPaymentCases;
            $this->_data['cbPaymentMethods']=$cbPaymentMethods;
            $this->_data['cbCreditResult']=$cbCreditResult;
            $this->_data['txtTranferDateFrom']=$txtTranferDateFrom;
            $this->_data['txtTranferDateTo']=$txtTranferDateTo;
            
            if($txtEmail!=""){
                $where.=" AND o.`email_address` LIKE '%".$this->db->escape_like_str($txtEmail)."%' ";
            }
            if($cbPaymentCases!=0){
                $where.=" AND p.`payment_case_id` = ".$this->db->escape_str($cbPaymentCases);
            }
            if($cbCreditResult!=""){
                if($cbCreditResult==2){
                    $where.=" AND p.`payment_status` = 2 ";
                }elseif ($cbCreditResult==3) {
                    $where.=" AND p.`payment_status` <> 2 ";
                }
            }
            if($cbPaymentMethods!=0){
                $where.=" AND p.`payment_method_id` = ".$this->db->escape_str($cbPaymentMethods);
            }
            if($txtTranferDateFrom !=""){
                $where.=" AND DATE_FORMAT(p.`approved_date`,'%Y/%m/%d') >= '".$this->db->escape_str($txtTranferDateFrom)."' ";
            }
            if($txtTranferDateTo!=""){
                $where.=" AND DATE_FORMAT(p.`approved_date`,'%Y/%m/%d') <= '".$this->db->escape_str($txtTranferDateTo)."' ";
            }

            //Start Page
            $config['base_url'] = base_url('index.php/admin/log/view_settlementlog');
            $config['total_rows'] = $this->Mlog->countSettlementLog($where);
            $config['constant_num_links'] = TRUE;
            $config['uri_segment']=4;
            $config["per_page"]=$this->config->item('per_page');
            $this->pagination->initialize($config); 
            $start1 = $this->uri->segment(4);
            
            if($start1!=NULL) $start=$start1;
            $this->_data["records"]=$this->Mlog->listSettlementLog($where,$config['per_page'],$start);
            //End page
            
            $this->_data["sumAmount"]=$this->Mlog->sumAmount($where);
            $this->_data["countAll"]=$this->Mlog->countSettlementLog($where);
            $this->_data['loadPage']='log/settlementlog_after';
            $this->_data['titlePage']='joyspe管理画面';
            //paging by ajax
            if($this->input->post('ajax')!=null){
               $this->load->view("log/settlementlog_after",$this->_data);    
            }else{
                $this->load->view($this->_data["module"]."/layout/layout",$this->_data);   
            }
        }
        
        /**
	 * @author     [IVS] Nguyen Van Vui
	 * @name 	pointlog
	 * @todo 	view serach point log
	 * @param 	 
	 * @return 	
	 */
        
        function pointlog() {
            $this->load->Model('admin/Mlog');
            $this->_data['paymentcases']=$this->Mlog->listPaymentCasesPontLog();
            $this->_data['loadPage']='log/pointlog';
            $this->_data['titlePage']='joyspe管理画面';
            $this->load->view($this->_data['module'].'/layout/layout',$this->_data);
        }
        
        /**
	 * @author     [IVS] Nguyen Van Vui
	 * @name 	view_pointlog
	 * @todo 	view info point log
	 * @param 	 
	 * @return 	
	 */
        
        function view_pointlog() {
            $start = 0;
            $where='';
            $txtEmail=trim($this->input->post('txtEmail'));
            $cbPaymentCases=$this->input->post('cbPaymentCases');
            $txtCreatedDateFrom=$this->input->post('txtCreatedDateFrom');
            $txtCreatedDateTo=$this->input->post('txtCreatedDateTo');
            $this->_data['email']=$txtEmail;
            $this->_data['cbPaymentCases']=$cbPaymentCases;
            $this->_data['txtCreatedDateFrom']=$txtCreatedDateFrom;
            $this->_data['txtCreatedDateTo']=$txtCreatedDateTo;
            
            if($txtEmail!=""){
                $where.=" AND ow.`email_address` LIKE '%".$this->db->escape_like_str($txtEmail)."%' ";
            }
            if($cbPaymentCases!=0){
                $where.=" AND tr.`payment_case_id` = ".$this->db->escape_str($cbPaymentCases);
            }
            if($txtCreatedDateFrom !=""){
                $where.=" AND DATE_FORMAT(tr.`created_date`,'%Y/%m/%d') >= '".$this->db->escape_str($txtCreatedDateFrom)."' ";
            }
            if($txtCreatedDateTo!=""){
                $where.=" AND DATE_FORMAT(tr.`created_date`,'%Y/%m/%d') <= '".$this->db->escape_str($txtCreatedDateTo)."' ";
            }
            
            
            $this->load->Model('admin/Mlog');
            
            //Start Page
            $config['base_url'] = base_url('index.php/admin/log/view_pointlog');
            $config['total_rows'] = $this->Mlog->countPoint($where);
            $config['constant_num_links'] = TRUE;
            $config['uri_segment']=4;
            $config["per_page"]=$this->config->item('per_page');
            $this->pagination->initialize($config); 
            $start1 = $this->uri->segment(4);
            
            if($start1!=NULL) $start=$start1;
            $this->_data["records"]=$this->Mlog->listPointLog($where,$config['per_page'],$start);
            //End page
            $this->_data["countAll"]=$this->Mlog->countPoint($where);
            $this->_data["sumPoint"]=$this->Mlog->sumPoint($where);
            $this->_data['paymentcases']=$this->Mlog->listPaymentCasesPontLog();
            $this->_data['loadPage']='log/pointlog_after';
            $this->_data['titlePage']='joyspe管理画面';
            //paging by ajax
            if($this->input->post('ajax')!=null){
               $this->load->view("log/pointlog_after",$this->_data);    
            }else{
                $this->load->view($this->_data["module"]."/layout/layout",$this->_data);   
            }
        }
        /**
	 * @author  [IVS] Nguyen Hoai Nam
	 * @name 	app
	 * @todo 	load page
	 * @param 	
	 * @return 	
	*/
        public function app(){
            $this->_data["dateFrom"]=null;
            $this->_data["dateTo"]=null;
            $this->_data["info"] = null;
            $this->_data["sum"] = 0;
            $this->_data["flag"] = 0;
            //$this->_data["listApp"] = null;
            $this->_data["loadPage"]="log/app";
            $this->_data["titlePage"]="joyspe管理画面";
            $this->load->view($this->_data["module"]."/layout/layout",$this->_data);
        }
        /**
	 * @author  [IVS] Nguyen Hoai Nam
	 * @name 	searchAppAfter
	 * @todo 	show data 
	 * @param 	
	 * @return 	
	*/
        public function searchAppAfter(){
            $dateFrom = null;
            $dateTo = null;     
            if(isset($_POST["txtDateFrom"])){
                $dateFrom = $_POST["txtDateFrom"];
            }
            if(isset($_POST["txtDateTo"])){
                $dateTo = $_POST["txtDateTo"];   
            }
            $this->_data["dateFrom"] = $dateFrom;
            $this->_data["dateTo"] = $dateTo;
            $this->_data["flag"] = 1;
            $start = 0;
            $this->load->Model("admin/Mlog");
            $sql = $this->Mlog->getSearchAppQuery($dateFrom, $dateTo);
            //get totalRows
            $countRows  = $this->Mlog->countDataByQuery($sql);
            //get totalRecords
            //$this->_data["listApp"] = $this->Mlog->getDataByQuery($sql);
            //init config to paging
            $config['base_url'] = base_url().'admin/log/searchCelebrationAfter';
            $config['total_rows'] = $countRows;
            $config['constant_num_links'] = TRUE;
            $config['uri_segment']=4;
            $config["per_page"]=$this->config->item('per_page');
            $this->load->library("pagination",$config);
            $this->pagination->initialize($config);
            //start1 has value after clicking paging link 
            $start1 = $this->uri->segment(4);
            if($start1 != ""){
                $start = $start1;
            }
            //data_info show data with paging
            $this->_data["info"] = $this->Mlog->getResultSearchApp($sql, $config['per_page'], $start); 
            $this->pagination->create_links();
            
            $this->_data["sum"] = $countRows;
            $this->_data["loadPage"]="log/app";
            $this->_data["titlePage"]="joyspe管理画面";
            //paging by ajax
            if($this->input->post('ajax')!=null){
               $this->load->view("log/app",$this->_data);    
            }else{
                $this->load->view($this->_data["module"]."/layout/layout",$this->_data);   
            }
        }
        /**
	 * @author  [IVS] Nguyen Hoai Nam
	 * @name 	sends
	 * @todo 	load page
	 * @param 	 
	 * @return 	
	*/
        public function sends(){
            $this->_data["dateFrom"]=null;
            $this->_data["dateTo"]=null;
            $this->_data["info"] = null;
            $this->_data["sum"] = 0;
            $this->_data["flag"] = 0;
            $this->_data["loadPage"]="log/sends";
            $this->_data["titlePage"]="joyspe管理画面";
            $this->load->view($this->_data["module"]."/layout/layout",$this->_data);
        }
        /**
	 * @author  [IVS] Nguyen Hoai Nam
	 * @name 	searchSendsAfter
	 * @todo 	show data
	 * @param 	
	 * @return 	
	*/
        public function searchSendsAfter(){
            $dateFrom = $this->input->get("txtDateFrom");
            $dateTo = $this->input->get("txtDateTo");
            $this->_data["dateFrom"] = $dateFrom;
            $this->_data["dateTo"] = $dateTo;
            $this->_data["flag"] = 1;
            $start = 0;
            $this->load->Model("admin/Mlog");
            $sql = $this->Mlog->getSearchSendsQuery($dateFrom, $dateTo);
            //get totalRows
            $countRows  = $this->Mlog->countDataByQuery($sql);
            //get totalRecords
            //$this->_data["listApp"] = $this->Mlog->getDataByQuery($sql);
            //init config to paging
            $config['base_url'] = base_url().'admin/log/searchSendsAfter';
            $config['total_rows'] = $countRows;
            $config['constant_num_links'] = TRUE;
            $config['uri_segment']=4;
            $config["per_page"]=$this->config->item('per_page');
            if (count($this->input->get()) > 0){
              $config['suffix'] = '?' . http_build_query($_GET, '', "&");
              $config['first_url'] = $config['base_url'].'?'.http_build_query($_GET,'', "&");
            }
            $this->load->library("pagination",$config);
            $this->pagination->initialize($config);
            //start1 has value after clicking paging link 
            $start1 = $this->uri->segment(4);
            if($start1 != ""){
                $start = $start1;
            }
            //data_info show data with paging
            $this->_data["info"] = $this->Mlog->getResultSearchSends($sql, $config['per_page'], $start);
            $this->_data["opened_rate"] = $this->Mlog->getOpenedRate($dateFrom, $dateTo);
            $this->pagination->create_links();
            
            $this->_data["sum"] = $countRows;
            $this->_data["loadPage"]="log/sends";
            $this->_data["titlePage"]="joyspe管理画面";
            //paging by ajax
            if($this->input->post('ajax')!=null){
               $this->load->view("log/sends",$this->_data);    
            }else{
                $this->load->view($this->_data["module"]."/layout/layout",$this->_data);   
            }
        }
        /**
	 * @author  [IVS] Nguyen Hoai Nam
	 * @name 	celebration
	 * @todo 	load page 
	 * @param 	 
	 * @return 	
	*/
        public function celebration(){
            $this->_data["dateFrom"]=null;
            $this->_data["dateTo"]=null;
            $this->_data["info"] = null;
            $this->_data["val"] = null;
            $this->_data["sum"] = 0;
            $this->_data["flag"] = 0;
            $this->_data["loadPage"]="log/celebration";
            $this->_data["titlePage"]="お祝い金申請履歴";
            $this->load->view($this->_data["module"]."/layout/layout",$this->_data);
        }
        /**
	 * @author  [IVS] Nguyen Hoai Nam
	 * @name 	searchCelebrationAfter
	 * @todo 	show data
	 * @param 	 
	 * @return 	
	*/
        public function searchCelebrationAfter(){
            $dateFrom = null;
            $dateTo = null;
            $val = null;
            if(isset($_POST["txtDateFrom"])){
                $dateFrom = $_POST["txtDateFrom"];
            }
            if(isset($_POST["txtDateTo"])){
                $dateTo = $_POST["txtDateTo"];   
            }
            if(isset($_POST["selectList"])){
                $val = $_POST["selectList"];
            }
            $this->_data["dateFrom"] = $dateFrom;
            $this->_data["dateTo"] = $dateTo;
            $this->_data["val"] = $val;
            $this->_data["flag"] = 1;
            $start = 0;
            $this->load->Model("admin/Mlog");
            $sql = $this->Mlog->getSearchCelebrationQuery($dateFrom, $dateTo, $val);
            //get totalRows
            $countRows  = $this->Mlog->countDataByQuery($sql);
            //get totalRecords
            //$this->_data["listApp"] = $this->Mlog->getDataByQuery($sql);
            //init config to paging
            $config['base_url'] = base_url().'admin/log/searchCelebrationAfter';
            $config['total_rows'] = $countRows;
            $config['constant_num_links'] = TRUE;
            $config['uri_segment']=4;
            $config["per_page"]=$this->config->item('per_page');
            $this->load->library("pagination",$config);
            $this->pagination->initialize($config);
            //start1 has value after clicking paging link 
            $start1 = $this->uri->segment(4);
            if($start1 != ""){
                $start = $start1;
            }
            //data_info show data with paging
            $this->_data["info"] = $this->Mlog->getResultSearchCelebration($sql, $config['per_page'], $start); 
            $this->pagination->create_links();
            
            $this->_data["sum"] = $countRows;
            $this->_data["loadPage"]="log/celebration";
            $this->_data["titlePage"]="お祝い金申請履歴";
            //paging by ajax
            if($this->input->post('ajax')!=null){
               $this->load->view("log/celebration",$this->_data);    
            }else{
                $this->load->view($this->_data["module"]."/layout/layout",$this->_data);   
            }
        }
        /**
        *author  : FDC
        *name : owner
        *todo: search statistic of page owner
        **/
        public function owner(){
            $this->_data['txtDateFrom'] = null;
            $this->_data['txtDateTo'] = null;
            $this->_data["loadPage"]="log/owner";
            $this->_data["titlePage"]="オーナー統計";
            $this->load->view($this->_data["module"]."/layout/layout",$this->_data);
        }
        public function searchOwner(){
            //get value input
            $this->load->Model("admin/Mlog");
            $this->load->library("pagination");
            $txtDateFrom = trim($this->input->post('txtDateFrom'));
            $txtDateTo = trim($this->input->post('txtDateTo'));
            $totalNumber = count($this->Mlog->searchOwnerStatisticsAnalysis($txtDateFrom,$txtDateTo));
            //Start Page
            $config['base_url'] = base_url('admin/log/searchOwner');
            $config['total_rows'] = $totalNumber;
            $config['constant_num_links'] = TRUE;
            $config['uri_segment']=4;
            $config["per_page"]=$this->config->item('per_page');
            $this->pagination->initialize($config);
            $offset = ($this->uri->segment(4))?$this->uri->segment(4):0;
            $this->_data["ownerResult"]=$this->Mlog->searchOwnerStatisticsAnalysis($txtDateFrom,$txtDateTo,$config["per_page"],$offset);
            //End page
            $this->_data["totalNumber"]=$totalNumber;
            $this->_data['txtDateFrom'] = $txtDateFrom;
            $this->_data['txtDateTo'] = $txtDateTo;
            $this->_data["loadPage"]="log/owner";
            $this->_data["titlePage"]="オーナー統計";
            //paging by ajax
            if($this->input->post('ajax')!=null){
                $this->load->view('log/owner',$this->_data);
            }else{
                $this->load->view($this->_data["module"]."/layout/layout",$this->_data);
            }
        }
        public function userstatistic(){
            $this->_data["dateFrom"] = null;
            $this->_data["dateTo"] = null;
            $this->_data["loadPage"] = "log/user_statistics";
            $this->_data["titlePage"]="ユーザ統計";
            $this->load->view($this->_data["module"]."/layout/layout",$this->_data);
        }
        public function userStatistics(){
            $offset = ($this->uri->segment(4))?$this->uri->segment(4):0;
            $per_page = $this->config->item('per_page');
            $this->load->Model("admin/Mlog");
            $dateFrom = trim($this->input->post('txtDateFrom'));
            $dateTo = trim($this->input->post('txtDateTo'));
            $getTotalRow = count($this->Mlog->searchUserStatisticsLog($dateFrom,$dateTo));
            //start pagination
            $config['base_url'] = base_url('admin/log/userStatistics');
            $config['total_rows'] = $getTotalRow;
            $config['constant_num_links'] = TRUE;
            $config['uri_segment']=4;
            $config["per_page"]=$per_page;
            $this->pagination->initialize($config);
            $this->_data["userStats"] = $this->Mlog->searchUserStatisticsLog($dateFrom,$dateTo,$per_page,$offset);
            //end pagination
            $this->_data["dateFrom"] = $dateFrom;
            $this->_data["dateTo"] = $dateTo;
            $this->_data["loadPage"] = "log/user_statistics";
            $this->_data["titlePage"]="ユーザ統計";
            //if ajax pagination
            if($this->input->post('ajax')!=null){
                $this->load->view('log/user_statistics',$this->_data);
            }else{
                $this->load->view($this->_data["module"]."/layout/layout",$this->_data);
            }
        }
    }
?>

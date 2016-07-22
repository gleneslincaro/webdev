<?php
      class Oneyenbonus extends MX_Controller{
        protected $_data;
        private $message = array('success' => true, 'error' => array());
        public function __construct() {
            parent::__construct();
            AdminControl::CheckLogin();
            $this->_data["module"] = $this->router->fetch_module();
            $this->form_validation->CI =& $this;
        }
        public function setpoint(){
          $this->load->model('owner/Mowner');
          $message = '';
          if($_POST) {
            $this->load->library("form_validation");
            $this->form_validation->set_rules('page_limit', 'スカウトポイント', 'required|greater_than[-1]|is_natural|numeric');
            $this->form_validation->set_rules('page_point', 'スカウトポイント', 'required|greater_than[-1]|is_natural|numeric');
            $form_validation = $this->form_validation->run();
            $data['page_limit']  = $this->input->post('page_limit');
            $data['page_point']  = $this->input->post('page_point');
            $this->message['success'] = !$form_validation && count($_POST) > 0 ? FALSE : TRUE;
            if($this->form_validation->run()==false){
              $data['message']= $this->message;
            }
            else {
              $page_limit = $this->input->post('page_limit');                                       
              $page_point = $this->input->post('page_point');
              $this->Mowner->inactiveCurrentAccessPoint(array('display_flag' => 0));
              $this->Mowner->insertAccessPoint(array('page_limit' => $page_limit,'page_point' => $page_point,'created_date' => date("Y-m-d-H-i-s")));
              $message = 'スカウトポイントの設定が完了です';
            }
          }
          $value = $this->Mowner->getAccessPoint();
          if(count($value) == 0) {
            $data = array('page_limit' => 0,
                          'page_point' => 0);
          } else {
            $data = array('page_limit' => $value['page_limit'],
                          'page_point' => $value['page_point']);
          }
          $data["loadPage"]="oneyenbonus/setpoint";
          $data['alert'] = $message;
          $data['message'] = $this->message;
          $data["titlePage"]="１ボーナス関連";
          $this->load->view($this->_data["module"]."/layout/layout", $data);
        }

        public function search(){
          $this->_data["dateFrom"]=null;
          $this->_data["dateTo"]=null;
          $this->_data["info"] = null;
          $this->_data["sum"] = 0;
          $this->_data["flag"] = 0;
          $this->_data["loadPage"]="oneyenbonus/search";
          $this->_data["titlePage"]="joyspe管理画面";
          $this->load->view($this->_data["module"]."/layout/layout",$this->_data);
        }

        public function searchAfter(){
            $this->load->model('user/musers');
            $dateFrom = $this->input->get("txtDateFrom");
            $dateTo = $this->input->get("txtDateTo");
            $this->_data["dateFrom"] = $dateFrom;
            $this->_data["dateTo"] = $dateTo;
            $this->_data["flag"] = 1;
            $start = 0;
            $this->load->Model("admin/Mlog");
            $sql = $this->Musers->getPeriodScoutOwnerlogQuery($dateFrom, $dateTo);
            $dataTable = $this->Musers->getPeriodScoutOwnerlog($dateFrom, $dateTo, $sql);
            $config['total_rows'] = count($dataTable);
            $config['constant_num_links'] = TRUE;
            $config['uri_segment']=4;
            $config["per_page"]=$this->config->item('per_page');
            $config['base_url'] = base_url().'admin/oneyenbonus/searchAfter';
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
            $this->_data["info"] = $this->Mlog->getResultSearchSends($sql, $config['per_page'], $start);
            $total = $this->Musers->getSumPeriodScoutOwnerlog($dateFrom, $dateTo);
            $dispTotal = 0;
            if(isset($total['access_point']) && count($total['access_point']) != 0 && $total['access_point']){
                $dispTotal = $total['access_point'];
            }
            $this->_data["total"] = $dispTotal;
            $this->_data["loadPage"]="oneyenbonus/search";
            $this->_data["titlePage"]="joyspe管理画面";
            //paging by ajax
            if($this->input->post('ajax')!=null){
               $this->load->view("oneyenbonus/search",$this->_data);
            }else{
               $this->load->view($this->_data["module"]."/layout/layout",$this->_data);
            }
        }
    }
?>

<?php
class Utility extends MX_Controller{
    protected $_data;
    private $message = array('success' => true, 'error' => array());
    public function __construct() {
        parent::__construct();
        AdminControl::CheckLogin();
        $this->form_validation->CI =& $this;
        $this->_data["module"] = $this->router->fetch_module();
        $this->load->model('admin/mutility');
        $this->output->set_header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate");
        $this->output->set_header("Cache-Control: post-check=0, pre-check=0");
        $this->output->set_header('Content-Type: text/html; charset=UTF-8');
        $this->output->set_header("Pragma: no-cache");
    }
    public function index(){
        $this->_data["loadPage"]="utility/addpoints";
        $this->_data["titlePage"]="ボーナスポイント追加";
        $this->_data["unique_id"]=null;
        $this->_data["email"]=null;
        $this->load->view($this->_data["module"]."/layout/layout",$this->_data);
    }
    public function search(){
        $unique_id = trim($this->input->post('unique_id'));
        $email =  trim($this->input->post('email'));
        if ($unique_id==null&&$email==null) {
            $this->form_validation->set_rules('unique_id','ユニークＩＤかメール','required|xss_clean');
        } else {
            $users = $this->mutility->searchUserToAddPoints($unique_id,$email);
            $this->_data["users"] = $users;
        }
        $form_validation = $this->form_validation->run();
        $this->message['success'] = !$form_validation ? FALSE : TRUE;
        $this->_data['message']= $this->message;
        $this->_data["unique_id"] = $unique_id;
        $this->_data["email"] = $email;
        $this->_data["loadPage"]="utility/addpoints";
        $this->_data["titlePage"]="ボーナスポイント追加";
        $this->load->view($this->_data["module"]."/layout/layout",$this->_data);
    }
    public function addpoints(){
        $this->load->model('user/musers');
        $array_user_id =$this->input->post('user_id');
        $points = $this->input->post('points');
        $reason = $this->input->post('reason');
        $this->form_validation->set_rules('user_id','ユーザーＩＤ', 'required');
        $this->form_validation->set_rules('points','ポイント', 'required|trim|numeric|is_natural|greater_than[0]');
        $this->form_validation->set_rules('reason','理由', 'required|trim');
        $form_validation = $this->form_validation->run();
        $this->message['success'] = !$form_validation ? FALSE : TRUE;
        if ($this->form_validation->run()==false) {
            $json = Helper::print_error($this->message);
            echo $json;
        } else {
            foreach($array_user_id as $user_id){
                $this->musers->updateBonusPoint($user_id,$points,$reason);
            }
            echo 'true';
        }
    }
    public function history_page(){
        $reason = trim($this->input->post('reason'));
        $email = trim($this->input->post('email'));
        $unique_id = trim($this->input->post('unique_id'));
        $dateFrom = trim($this->input->post('txtDateFrom'));
        $dateTo = trim($this->input->post('txtDateTo'));
        $offset = $this->uri->segment(4);
        $offset = !empty($offset) ? $offset : 0;
        $per_page = $this->config->item('per_page');
        $params = array('reason'=>$reason,'email'=>$email,'unique_id'=>$unique_id);
        $count_log = $this->mutility->historyLog($params,$dateFrom,$dateTo);
        if ($reason != null) {
            $history_log = $this->mutility->historyLog($params,$dateFrom,$dateTo,$per_page,$offset);
            $this->_data["history_log"]= $history_log;
        }
        $this->form_validation->set_rules('reason','追加理由','required|xss_clean|trim');
        $form_validation = $this->form_validation->run();
        $this->message['success'] = !$form_validation ? FALSE : TRUE;
        $config['base_url'] = base_url().'admin/utility/history_page';
        $config['total_rows'] = count($count_log);
        $config['constant_num_links'] = TRUE;
        $config['uri_segment']=4;
        $config["per_page"]=$this->config->item('per_page');
        $this->pagination->initialize($config);
        $this->_data['message']= $this->message;
        $this->_data["reason"] = $reason;
        $this->_data["email"] = $email;
        $this->_data["unique_id"] = $unique_id;
        $this->_data["dateFrom"] = $dateFrom;
        $this->_data["dateTo"] = $dateTo;
        $this->_data["titlePage"]="追加履歴を確認する";
        $this->_data["loadPage"]  = "utility/history_page";
        //paging by ajax
        if(isset($_POST["ajax"]) && $_POST["ajax"]!=null){
            $this->load->view("utility/history_page",$this->_data);
        }else{
            $this->load->view($this->_data["module"]."/layout/layout",$this->_data);
        }
    }
}

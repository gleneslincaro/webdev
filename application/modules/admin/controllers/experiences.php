<?php
    class Experiences extends MX_Controller{
    protected $_data;
    private $message = array('success' => true, 'error' => array());

    public function __construct() {
        parent::__construct();
        AdminControl::CheckLogin();
        $this->_data["module"] = $this->router->fetch_module();
        $this->load->Model("admin/mmail");
        $this->load->Model("user/Mcity");
        $this->load->Model("user/Musers");
        $this->load->Model("user/Muser_experiences");
		$this->load->library('common');
        $this->load->library('cipher');
        $this->form_validation->CI =& $this;
        $this->lang->load('list_message', 'english');
        $this->output->set_header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate");
        $this->output->set_header("Cache-Control: post-check=0, pre-check=0");
        $this->output->set_header("Pragma: no-cache");

        HelperApp::start_session();
    }

    public function index() {
        $post = $this->input->post();
        if ($post) {
            $city = $post['city'];
            $age = $post['age'];
            $title = $post['title'];
            $content = $post['content'];
            $data = array(
                        'user_id' => 'サクラ',
                        'title' => $title,
                        'content' => $content,
                        'age_id' => $age,
                        'city_id' => $city,
                        'status' => 1,
                        'created_date' => date('Y-m-d H:i:s')
                );
            $this->form_validation->set_rules('city','シティ','required|trim|numeric|xss_clean');
            $this->form_validation->set_rules('age','年齢','required|trim|numeric|xss_clean');
            $this->form_validation->set_rules('title','タイトル','required|trim|xss_clean');
            $this->form_validation->set_rules('content','コンテンツ','required|trim|xss_clean');
            if($this->form_validation->run()) {
                $this->Muser_experiences->insert_experiences_msg($data);
                $this->session->set_flashdata('success','保存しました');
                redirect(current_url());
            }
            
        }

        $this->_data["info"] = null;
        $this->_data["listEmail"] = null;
        $this->_data["loadPage"] = "experiences/modify";
        $this->_data["titlePage"] = "サクラ体験談";
        $cities = $this->Mcity->get_all_city();
        $this->_data["cities"] = $cities;
        $agelist = $this->Musers->list_combobox('mst_ages');
        $this->_data['agelist'] = $agelist;
        $this->load->view($this->_data["module"]."/layout/layout", $this->_data);
    }

    public function all(){
        //init config to paging
        $this->load->library("pagination");
        $config['base_url'] = base_url().'admin/experiences/all';
        $config['total_rows'] = $this->Muser_experiences->get_experiences_msg_count(true);
        $config['constant_num_links'] = TRUE;
        $config['uri_segment']=4;
        $config["per_page"]=$this->config->item('per_page');
        $this->pagination->initialize($config);
        $start_offset = intval($this->uri->segment(4));
        if ($start_offset == NULL) {
          $start_offset = 0;
        }
        $this->_data["loadPage"] = "experiences/all";
        $this->_data["titlePage"] = "投稿の体験談　編集・有効・無効・削除";
        $this->_data["list_experiences"] = $this->Muser_experiences->get_experiences_msg_all($config['per_page'],$start_offset,true);
        //paging by ajax
        if($this->input->post('ajax')!=null){
           $this->load->view("experiences/all",$this->_data);    
        }else{
            $this->load->view($this->_data["module"]."/layout/layout",$this->_data);   
        }
    }

    public function modify($user_id=null){

        if($this->input->post()) {
            $post = $this->input->post();
            $data = array(
                'title' => $post['title'],
                'content' => $post['content'],
                'update_date' => date('Y-m-d H:i:s'),
                'age_id'    => $post['age'],
                'city_id'   => $post['city'],
            );
            $this->form_validation->set_rules('city','シティ','required|trim|numeric|xss_clean');
            $this->form_validation->set_rules('age','年齢','required|trim|numeric|xss_clean');
            $this->form_validation->set_rules('title','タイトル','required|trim|xss_clean');
            $this->form_validation->set_rules('content','コンテンツ','required|trim|xss_clean');
            if($this->form_validation->run()) {
                $modify = $this->Muser_experiences->modify_experience($post['exp_id'],$data);
                if ($modify) {
                    $this->session->set_flashdata('success','保存しました');
                    redirect(current_url());
                }
                
            }
            
        }
        $this->_data["exp_data"] = $this->Muser_experiences->get_experiences_msg_id($user_id);
        $this->_data["loadPage"] = "experiences/modify";
        $this->_data["titlePage"] = "投稿の体験談　編集・有効・無効・削除";
        $this->_data["modify_flag"] = 1;
        $cities = $this->Mcity->get_all_city();
        $this->_data["cities"] = $cities;
        $agelist = $this->Musers->list_combobox('mst_ages');
        $this->_data['agelist'] = $agelist;
        $this->load->view($this->_data["module"]."/layout/layout", $this->_data);
    }

    public function update_show_status() {
        $post = $this->input->post();
        $show_experience = $this->Muser_experiences->update_show_status($post);
        echo $show_experience;
    }

    public function delete_experience() {
        $id = $this->input->post('id');
        $delete_experience = $this->Muser_experiences->delete_experience($id);
        if($delete_experience == 1) {
            $this->session->set_flashdata('success','正常に削除');

        }
        echo $delete_experience;
    }

}
?>

<?php

class Experiences extends MY_Controller {

    private $layout = "user/layout/main";
    private $viewData = array();
    private $breadscrumb_array;

    private $user_info;
    public function __construct() {
        parent::__construct();
        $this->viewData['idheader'] = null;
        $this->viewData['noCompanyInfo'] = true;
        $this->viewData['class_ext'] = 'dictionary';
        $this->load->model("owner/Musers");
        $this->load->model("user/Muser_experiences");
        $this->load->model("user/mcity");
        $this->load->model("owner/Mprofile");
        $this->load->library('user_agent');
        $user_id = UserControl::getId();
        $user_info = $this->Musers->get_user($user_id);
        $this->user_info = $user_info;
        if (!$user_info && $user_info['user_from_site'] == 0) {
            redirect(base_url() . 'user/');
        }
    }

    public function index() {
        /* sp */
        if ($this->agent->is_mobile()) {
            $this->viewData['load_page'] = 'user/experiences/index';
        /* pc */
        } else {
            $this->viewData['load_page'] = 'user/pc/experiences/index';
            $this->layout = "user/pc/layout/main";
            $this->breadscrumb_array[] = array("class" => "", "text" => "体験談トップページ", "link"=>"");
        }
        $limit = LIMIT_EXPERIENCE_LIST;
        $data = $this->Muser_experiences->get_experiences_msg_all($limit);
        $count = $this->Muser_experiences->get_experiences_msg_count();
        $pagination = array('count' => $count, 'limit' => $limit);
        $this->viewData['pagination'] = $pagination;
        $this->viewData['data'] = $data;
        $this->viewData['breadscrumb_array'] = $this->breadscrumb_array;
        $this->viewData['titlePage'] = '風俗求人・高収入アルバイトがみつかる -ジョイスペ-';
        $this->load->view($this->layout, $this->viewData);
    }

    public function experiences_load_more(){
        $post = $this->input->post();
        if ($post) {
            $page = $post['page'];
            $offset = $page * LIMIT_EXPERIENCE_LIST;
            $limit = LIMIT_EXPERIENCE_LIST;
            $info = $this->Muser_experiences->get_experiences_msg_all($limit, $offset);
            $count = $this->Muser_experiences->get_experiences_msg_count();
            $count = ceil($count / LIMIT_EXPERIENCE_LIST);
            $data = array('info' => $info, 'offset' => $page + 1, 'count' => $count);
            echo json_encode($data);
        }
    }

    public function experiences_form() {
        /* sp */
        if ($this->agent->is_mobile()) {
            $this->viewData['load_page'] = 'user/experiences/experiences_form';
        /* pc */
        } else {
            $this->viewData['load_page'] = 'user/pc/experiences/experiences_form';
            $this->layout = "user/pc/layout/main";
            $this->breadscrumb_array[] = array("class" => "", "text" => "体験談トップページ", "link"=>"");
        }


        $this->viewData['breadscrumb_array'] = $this->breadscrumb_array;
        $this->viewData['titlePage'] = '風俗求人・高収入アルバイトがみつかる -ジョイスペ-';
        $this->load->view($this->layout, $this->viewData);
    }

    public function experiences_send() {
        $post = $this->input->post();
        if ($post) {
            $info = $this->user_info;
            $data = array(
                        'user_id' => $info['user_id'],
                        'title' => $post['title'],
                        'content' => $post['content'],
                        'age_id' => $info['age_id'],
                        'city_id' => $info['city_id'],
                        'created_date' => date('Y-m-d H:i:s')
                );
            $id = $this->Muser_experiences->insert_experiences_msg($data);
        }
    }

    public function experiences_detail($msg_id) {
        $user_id = $this->user_info['user_id'];
        $get_msg = $this->Muser_experiences->get_experiences_msg_id($msg_id);

        if (!$get_msg) {
            redirect(base_url() . 'user/');
        }
        /* sp */
        if ($this->agent->is_mobile()) {
            $this->viewData['load_page'] = 'user/experiences/experiences_detail';
        /* pc */
        } else {
            $this->viewData['load_page'] = 'user/pc/experiences/experiences_detail';
            $this->layout = "user/pc/layout/main";
            $this->breadscrumb_array[] = array("class" => "", "text" => "体験談トップページ", "link"=>"");
        }

        $this->viewData['get_msg'] = $get_msg;
        $this->viewData['user_info'] = $this->user_info;
        $this->viewData['breadscrumb_array'] = $this->breadscrumb_array;
        $this->viewData['titlePage'] = '風俗求人・高収入アルバイトがみつかる -ジョイスペ-';
        $this->load->view($this->layout, $this->viewData);
    }

}

?>

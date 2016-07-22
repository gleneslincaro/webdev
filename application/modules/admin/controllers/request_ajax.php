<?php
class Request_ajax extends MX_Controller{
    private $viewData = array();
    private $messages = array();
    public function __construct() {
      parent::__construct();

    }

    public function index() {
    }

    public function first_bonus_list(){
        $this->load->Model('owner/Mowner');

        $msg_per_page = intval($this->input->post('page_max'));
        $start = intval($this->input->post('start'));
        $sort = $this->input->post('sort');
        $messages = $this->Mowner->getUserFirstMessages_sort($msg_per_page,$start,$sort);
        $this->viewData['messages'] = $messages;
        $this->load->view("admin/request/first_bonus_list",$this->viewData);
    }

    public function cate_select() {
        $this->load->Model('owner/Mowner');

        $id = $this->input->post('id');
        $msgid = $this->input->post('msgid');
        $category_id = $this->input->post('category_id');

        $arr = array(
            'category_id' => $category_id,
        );

        $res = true;
        $res = $this->Mowner->update_list_user_owner_messages($id, $msgid, $arr);
        $ar = array(
            'flag' => $res,
            'id' => $id,
            'category_id' => $category_id,
        );
        //$dataをJSONにして返す
        $this->output
             ->set_content_type('application/json')
             ->set_output(json_encode($ar));
    }

    public function public_select() {
        $this->load->Model('owner/Mowner');

        $id = $this->input->post('id');
        $msgid = $this->input->post('msgid');
        $public_flag = $this->input->post('public_flag');

        $arr = array(
            'public_flag' => $public_flag,
        );

        $res = true;
        $res = $this->Mowner->update_list_user_owner_messages($id, $msgid, $arr);
        $ar = array(
            'flag' => $res,
            'id' => $id,
            'public_flag' => $public_flag,
        );
        //$dataをJSONにして返す
        $this->output
             ->set_content_type('application/json')
             ->set_output(json_encode($ar));
    }

}
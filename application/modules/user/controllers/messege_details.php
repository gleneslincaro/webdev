<?php
class Messege_details extends MY_Controller {
    private $common;
    function __construct() {
        parent::__construct();
		$this->redirect_pc_site();
        $this->load->model('owner/Mcommon');
        $this->common = new Common();
        $this->load->model('user/Musers');
        $this->load->model('user/Muser_messege');
        $this->viewData['idheader'] = 1;
        HelperGlobal::require_login(current_url());
    }
    private $layout = "user/layout/main";
    private $viewData = array();
    /*
    * @author:IVS_VTAN
    * show user_message
    */
    public function messege_dustbox($gettype = 0) {
        $user_id = UserControl::getId();
        $limit = 5;
        $data = $this->Muser_messege->getMessege_dustbox($user_id, $limit, $gettype);
        $count = count($data);
        $count_all = $this->Muser_messege->countallMessege_dustbox($user_id, $gettype);
       // $listUserMessages = $this->Musers->getListUserMessages($user_id);
        $title='0';
        foreach ($data as $value) {
            if($value['template_type'] == 'us03' || $value['template_type'] == 'us14'){
                 if ($title == '0') {
                    $title = $this->common->setTemplateTitleUs03($user_id, $value['ors_id'], array($value['template_type']));
                } else {
                    $title = $title . ' , ' . $this->common->setTemplateTitleUs03($user_id, $value['ors_id'], array($value['template_type']));
                }
            } else if($value['template_type'] == 'ss09') {
                if($title == '0'){
                    $title = $this->common->setTemplateTitleSs09($user_id,$value['id']);
                } else {
                    $title =  $title . ' , ' . $this->common->setTemplateTitleSs09($user_id,$value['id']);
                }
              
            } else {
                    if ($title == '0') {
                    $title = $this->common->setTemplateTitle($user_id, $value['owner_id'], array($value['template_type']));
                } else {
                    $title = $title . ' , ' . $this->common->setTemplateTitle($user_id, $value['owner_id'], array($value['template_type']));
                }
            }
        }
        $chuoi=  explode(" , ", $title);
        $this->viewData['gettype'] = $gettype;
        $this->viewData['chuoi'] = $chuoi;
        $this->viewData['count'] = $count;
        $this->viewData['count_all'] = $count_all;
        $this->viewData['data'] = $data;
        //$this->viewData['listUserMessages'] = $listUserMessages;
        $this->viewData['limit'] = $limit;
        $this->viewData['titlePage'] = 'joyspe｜ゴミ箱';
        $this->viewData['load_page'] = "user/user_messege/messege_dustbox";
        $this->load->view($this->layout, $this->viewData);
    }
    /*
    * @author:IVS_NGuyen_Ngoc_Phuong
    * show more deleted user_message
    */
    public function ajax_messege_dustbox() {
        $user_id = UserControl::getId();
        $gettype = $this->input->post("gettype");
        $count_all = $this->input->post("count_all");
        $limit = 5;
        $getmore = $this->input->post("getmore");
        if ($getmore != '') {
            $limit = $this->input->post("limit");
            $limit = $limit + 10;
        }
        $data = $this->Muser_messege->getMessege_dustbox($user_id, $limit, $gettype);
        $count = count($data);
        $title='0';
       foreach ($data as $value) {
            if($value['template_type'] == 'us03' || $value['template_type'] == 'us14'){
                 if ($title == '0') {
                    $title = $this->common->setTemplateTitleUs03($user_id, $value['ors_id'], array($value['template_type']));
                } else {
                    $title = $title . ' , ' . $this->common->setTemplateTitleUs03($user_id, $value['ors_id'], array($value['template_type']));
                }
            } else if($value['template_type'] == 'ss09') {
                if($title == '0'){
                    $title = $this->common->setTemplateTitleSs09($user_id,$value['id']);
                } else {
                    $title =  $title . ' , ' . $this->common->setTemplateTitleSs09($user_id,$value['id']);
                }
              
            } else {
                if ($title == '0') {
                    $title = $this->common->setTemplateTitle($user_id, $value['owner_id'], array($value['template_type']));
                } else {
                    $title = $title . ' , ' . $this->common->setTemplateTitle($user_id, $value['owner_id'], array($value['template_type']));
                }
            }
        }
        $chuoi=  explode(" , ", $title);
        $this->viewData['chuoi'] = $chuoi;
        $this->viewData['gettype'] = $gettype;
        $this->viewData['count'] = $count;
        $this->viewData['count_all'] = $count_all;   
        $this->viewData['data'] = $data;
        $this->viewData['titlePage'] = 'joyspe｜ゴミ箱';
        $this->viewData['limit'] = $limit;
        $this->load->view("user/user_messege/list_user_message2", $this->viewData);
    }
    /*
    * @author:IVS_VTAN
    * show delete user_message
    */
    public function messege_delete($id, $send_type = 1) {
        if ($id==0) {
            redirect(base_url()."user/errorpage");
        }
        $data = '';
        $this->viewData['id'] = $id;
        if ($send_type == 1)
            $data = $this->Muser_messege->messege_delete($id);
        else
            $this->Muser_messege->messege_delete1($id);
        $this->viewData['data'] = $data;        
        redirect(base_url()."user/user_messege/message_list/0");
    }
    /*
    * @author:IVS_VTAN
    * show delete user_message
    */
    public function messege_delete_in() {
        $listId = $this->input->post('cbkdel');
        $listId1 = array();
        $listId2 = '';
        foreach($listId as $value) {        	
        	$s_value = explode(':', $value);
        	if($s_value[1] == 1)
        		 $listId1[] = $s_value[0];
        	else {
        		if($listId2 == '')
        			$listId2 = $listId2.$s_value[0];
        		else
        			$listId2 = $listId2.','.$s_value[0];
        	}             
        }
        if(count($listId1) > 0)        
        	$this->Muser_messege->checkbox_messege($listId1);
        if(count($listId2) > 0)
        	$this->Muser_messege->checkbox_messege1($listId2);
        redirect(base_url()."user/user_messege/messege");
        //$this->viewData['titlePage'] = 'joyspe｜メッセージ削除';
        //$this->viewData['load_page'] = "user/user_messege/messege_delete";
        //$this->load->view($this->layout, $this->viewData);
    }
}
?>

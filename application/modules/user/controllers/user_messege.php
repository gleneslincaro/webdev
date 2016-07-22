<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class User_messege extends MY_Controller {
    function __construct() {
      parent::__construct();
      $this->redirect_pc_site();
      $this->load->model('owner/Mcommon');
      $this->common = new Common();
      $this->load->model('user/Muser_messege');
      $this->load->model('user/Musers');
      $this->viewData['idheader'] = NULL;
      $this->viewData['class_ext'] = 'message_list';
      HelperGlobal::require_login(base_url() . uri_string());
      $this->load->library('user_agent');
    }
    private $layout = "user/layout/main";
    private $viewData = array();
    private $breadscrumb_array = array();
    /*
     *  @author:IVS_VTAN
     * get user message
     */
    /*public function messege($gettype = 0) {
        $user_id = UserControl::getId();
        $data = $this->Muser_messege->getCount($user_id, $gettype);
        $count = count($data);
        $this->viewData['count'] = $count;
        $this->viewData['data'] = $data;
        $this->viewData['gettype'] = $gettype;
        $this->viewData['titlePage'] = 'joyspe｜メッセージ';
        $this->viewData['load_page'] = "user/user_messege/messege";
        $this->load->view($this->layout, $this->viewData);
    }*/
    /*
     * @author:IVS_VTAN
     * restore user message
     */
    public function messege_return($id=0) {
        if($id==0)
        {
            redirect(base_url()."user/errorpage");
        }
        $data = $this->Muser_messege->restore_reception_messege($id);
        redirect(base_url()."user/user_messege/message_list_garbage/0");
    }

     public function delete_messages() {
        $this->changeMessagesStatus(1);
    }

    public function return_messages() {
        $this->changeMessagesStatus(0);
    }

    private function changeMessagesStatus($delete = 0) {
        $listId = $this->input->post('cbkdel');
        $listId1 = array();
        $listId2 = '';

        foreach ($listId as $value) {
            $s_value = explode(':', $value);
            if ($s_value[1] == 1)
                $listId1[] = $s_value[0];
            else {
              if ($listId2 == '')
                  $listId2 = $listId2.$s_value[0];
              else
                  $listId2 = $listId2.','.$s_value[0];
            }
        }
        if (count($listId1) > 0) {
            if ($delete == 1) {
                $display_flag = 0;
            } else {
                $display_flag = 1;
            }
            $this->Muser_messege->checkbox_messege($listId1, $display_flag);
        }
        if (count($listId2) > 0) {
            if ($delete == 1) {
                $this->Muser_messege->checkbox_messege1($listId2);
            }
        }
        if ($delete == 1) {
            redirect(base_url()."user/user_messege/message_list/0");
        } else {
            redirect(base_url()."user/user_messege/message_list_garbage/0");
        }
    }


    /*
     *  @author:IVS_VTAN
     *  get user message
     */
    public function message($gettype = 0) {
        $user_id = UserControl::getId();
        $limit = 5;
        $this->viewData['gettype'] = $gettype;
        $data = $this->Muser_messege->getMessege_reception($user_id, $limit, $gettype, 0);
        //count all record in user message
        $count_all = $this->Muser_messege->coutMessage($user_id, $gettype);
        $count = count($data);
        $title = '0';
        foreach ($data as $value) {
          if (($value['template_type'] == 'us03' || $value['template_type'] == 'us14') && $value['send_type'] == 1) {
              if ($title == '0') {
                  $title = $this->common->setTemplateTitleUs03($user_id, $value['ors_id'], array($value['template_type']), $value['id']);
              } else {
                  $title = $title . ' , ' . $this->common->setTemplateTitleUs03($user_id, $value['ors_id'], array($value['template_type']), $value['id']);
              }
          }else if ($value['template_type'] == 'ss09') {
              if ($title == '0') {
                  $title = $this->common->setTemplateTitleSs09($user_id,$value['id']);
              } else {
                  $title =  $title . ' , ' . $this->common->setTemplateTitleSs09($user_id,$value['id']);
              }
          } else {
              if ($value['send_type'] == 1) {
                  if ($title == '0') {
                      $title = $this->common->setTemplateTitle($user_id, $value['owner_id'], array($value['template_type']));
                  } else {
                      $title = $title . ' , ' . $this->common->setTemplateTitle($user_id, $value['owner_id'], array($value['template_type']));
                  }
              }
              else {
                  if ($title == '0')
                      $title = $value['title'];
                  else
                      $title = $title.' , '.$value['title'];
              }
          }
        }
        $chuoi = explode(" , ", $title);
        $this->viewData['new_data'] = $this->Muser_messege->getCount($user_id, $gettype);
        $this->viewData['chuoi'] = $chuoi;
        $this->viewData['count_all'] = $count_all;
        $this->viewData['limit'] = $limit;
        $this->viewData['count'] = $count;
        $this->viewData['data'] = $data;
        $this->viewData['titlePage'] = 'joyspe｜受信箱';
        $this->viewData['load_page'] = "user/user_messege/messege";
        $this->load->view($this->layout, $this->viewData);
    }

    public function message_list($gettype = 0) {
        $this->getMessageInformation($gettype, 'message_list');
    }

    public function message_list_garbage($gettype = 0) {
        $this->getMessageInformation($gettype, 'message_list_garbage');
    }

    private function getMessageInformation($gettype = 0, $message_type) {
        $message_list = 0;
        $user_id = UserControl::getId();
        
        if($this->agent->is_mobile()) {
          $limit = 5;
        } else {
          $limit = LIMIT_MESSAGE_LIST_PC;
        }
        
        
        if ($message_type == 'message_list') {
            $message_list = 1;
            $data = $this->Muser_messege->getMessege_reception($user_id, $limit, $gettype, 0);
            $count_all = $this->Muser_messege->coutMessage($user_id, $gettype);
            $this->viewData['titlePage'] = 'joyspe｜受信箱';
            $this->viewData['actionButtonText'] = '選択メールを削除';
        } else if ($message_type == 'message_list_garbage') {
            $data = $this->Muser_messege->getMessege_dustbox($user_id, $limit, $gettype, 0);
            $count_all = $this->Muser_messege->countallMessege_dustbox($user_id, $gettype);
            $this->viewData['titlePage'] = 'joyspe｜ゴミ箱';
            $this->viewData['actionButtonText'] = '選択メールを受信箱に戻す';
        } else {
            redirect(base_url()."user/errorpage");
        }
        $count = count($data);
        $title = '0';
        $title = $this->set_title_message($title,$data,$user_id);
        $chuoi = explode(" , ", $title);
        $this->viewData['message_list'] = $message_list;
        $this->viewData['new_data'] = $this->Muser_messege->getCount($user_id, $gettype);
        $this->viewData['gettype'] = $gettype;
        $this->viewData['chuoi'] = $chuoi;
        $this->viewData['count'] = $count;
        $this->viewData['count_all'] = $count_all;
        $this->viewData['limit'] = $limit;
        $this->viewData['data'] = $data;
        $this->viewData['noCompanyInfo'] = true;
        if($this->agent->is_mobile()){
          $this->viewData['load_page'] = "user/user_messege/message";
        } else {
          $base_url = ($message_list == 1) ? base_url()."user/message_list/$gettype/?":base_url()."user/message_list_garbage/$gettype/?";
          $this->load->library('pagination');
          $config['page_query_string'] = TRUE;
          $config['base_url'] = $base_url;
          $config['total_rows'] = $count_all;
          $config['per_page'] = LIMIT_MESSAGE_LIST_PC;
          $config['first_link'] = FALSE;
          $config['last_link'] = FALSE;
          $config['use_page_numbers'] = TRUE;
          $config['num_links'] = 2;
          $config['prev_link'] = '&lt;';
          $config['prev_tag_open'] = '<li>';
          $config['prev_tag_close'] = '</li>';
          $config['next_link'] = '&gt;';
          $config['next_tag_open'] = '<li>';
          $config['next_tag_close'] = '</li>';
          $config['cur_tag_open'] = '<li><span class="current">';
          $config['cur_tag_close'] = '</span></li>';
          $config['num_tag_open'] = '<li>';
          $config['num_tag_close'] = '</li>';
          $config['query_string_segment'] = 'page';
          $config['prefix'] = '';
          $this->pagination->initialize($config);
          $this->viewData['page_links'] = $this->pagination->create_links();
          $this->viewData['total_users'] = HelperGlobal::getUserTotalNumber();
          $this->viewData['total_owners'] = HelperGlobal::gettotalHeader();
          if($this->input->get('page')) {
            $offset = (($this->input->get('page') -1) * LIMIT_MESSAGE_LIST_PC);
            $last_page = ceil($count_all/LIMIT_MESSAGE_LIST_PC);
            if($offset < 0) {
              $offset = 0;
            }
            if($this->input->get('page') > $last_page) {
              $offset = ($last_page - 1) * LIMIT_MESSAGE_LIST_PC;
            }

            if ($message_list == 1) {
              $data = $this->Muser_messege->getMessege_reception($user_id, $limit, $gettype, $offset);
            } else {
              $data = $this->Muser_messege->getMessege_dustbox($user_id, $limit, $gettype, $offset);
            }
            $title = '0';
            $title = $this->set_title_message($title,$data,$user_id);
            $chuoi = explode(" , ", $title);
            $this->viewData['chuoi'] = $chuoi;
            $this->viewData['data'] = $data;
            $this->viewData['message_type'] = $message_type;
            
          }
          $this->breadscrumb_array[] = array("class" => "", "text" => "オファーメール", "link"=>"");
          $this->viewData['load_page'] = "user/pc/message/message";
          $this->layout = "user/pc/layout/main";
          $this->viewData['breadscrumb_array'] = $this->breadscrumb_array;
        }
        $this->load->view($this->layout, $this->viewData);
        
    }



    /*
     * @author: IVS_Nguyen_Ngoc_Phuong
     * load more user message by ajax
     */
    public function ajax_messege_reception() {
        $limit = 10;
        $user_id = UserControl::getId();
        $gettype = $this->input->post("gettype");
        $count_all = $this->input->post("count_all");
        $offset = $this->input->post("offset");
        $message_list = $this->input->post("message_list");
        $this->viewData['gettype'] = $gettype;
        if ($message_list == 1) {
            $data = $this->Muser_messege->getMessege_reception($user_id, $limit, $gettype, $offset);
        }
        else {
            $data = $this->Muser_messege->getMessege_dustbox($user_id, $limit, $gettype, $offset);
        }
       // $listUserMessages = $this->Musers->getListUserMessagesDetail($user_id, $gettype);
        $title = '0';
        $title = $this->set_title_message($title,$data,$user_id);
        $chuoi = explode(" , ", $title);
        $this->viewData['message_list'] = $message_list;
        $this->viewData['chuoi'] = $chuoi;
        $this->viewData['limit'] = $limit;
        $this->viewData['data'] = $data;
        $this->viewData['offset'] = $offset;
      //  $this->viewData['listUserMessages'] = $listUserMessages;
        $this->viewData['titlePage'] = 'joyspe｜受信箱';
        $this->load->view("user/user_messege/messege_reception", $this->viewData);
    }

    public function countMessages() {
        $user_id = UserControl::getId();
        $gettype = $this->input->get("gettype");
        $count_all = $this->Muser_messege->coutMessage($user_id, $gettype);
        echo json_encode($count_all);
        exit;
    }

    /*
     *  @author:IVS_VTAN
     * get user message detail
     */
    public function messege_reception_in($id, $send_type, $message_list = 0) {
        if($id==0)
        {
            redirect(base_url()."user/errorpage");
        }
        $user_id = UserControl::getId();
        $gettype = 0;
        if ($send_type != 2) {
            $this->viewData['id'] = $id;
            $this->Muser_messege->updateIsRead($id);
            $this->Muser_messege->insertListOpenRate($user_id);
            $data = $this->Muser_messege->getMessege_reception_in($user_id, $id, $gettype);

            if(empty($data)){
              redirect(base_url() . 'user/user_messege/messege_reception/');
            }
            $ListID = $this->Musers->getOwnerIDByUserID($id);
            $ownerId = 0;
            if (count($ListID) > 0) {
                $ownerId = $ListID[0]["owner_id"];
            }
            $this->Muser_messege->insertListReciveOpenMail($ownerId,$user_id);
            $ors_id = $this->Musers->_getOwnerRecruitId($id);
            if ($data['template_type'] == 'ss09') { // read newsletter sent from admin
                $title = "";
                $body = "";
                $user_email = UserControl::getEmail();
                $sent_newsletter_data = $this->common->getNewsLetterMailData($id, $user_id, $user_email, $ors_id);
                if ($sent_newsletter_data) {
                    $title = $sent_newsletter_data['title'];
                    $body  = nl2br($sent_newsletter_data['body']);
                }
            } else {
                $company_data = $this->Mcommon->getOwnerRecruitHappyMoney($ors_id);
                $user_happy_money = $company_data[0]['user_happy_money'];

                if($data['template_type'] == 'us03' && $user_happy_money > 0) {
                    $template_type = 'us03';
                } else {
                    $template_type = 'us14';
                }

                $url  = base_url().'user/joyspe_user/company/'.$ors_id."/";
                $bonus_hash = $data['u_hash'];
                if ($bonus_hash && UserControl::getFromSiteStatus() != 0) { // for machemoba/makia only
                    $url .= '?hash=' . $bonus_hash;
                    $url .= PHP_EOL . PHP_EOL . 'URLをクリックでポイントをGET!!<br>※クリックすることでボーナスが付与されます。' ;
                    $url .= '<br>ボーナスポイントGETの有効期限は本メールを受信してから' . SCOUT_MAIL_LIMIT_HOURS. '時間になります。';
                }
                if ($data['template_type'] != 'us03' && $data['template_type'] != 'us14') {
                    $title = $this->common->setTemplateTitle($user_id, $ownerId, array($data['template_type']));
                    $body = $this->common->setTemplateContent($user_id, $ownerId, array($data['template_type']),'getUserSelect','getJobUser','getJobOwner',array($user_id),$url,'');
                }
                if ($data['template_type'] == 'us03' || $data['template_type'] == 'us14') {
                    $title = $this->common->setTemplateTitleUs03($user_id, $ors_id, array($template_type), $id);
                    $body =  $this->common->setBodyUs03($user_id, $ors_id, $template_type, $id, $url);
                }
            }
            //URLにリンクを付ける
            $pattern = "/(?i)\b((?:https?:\/\/|www\d{0,3}[.]|[a-z0-9.\-]+[.][a-z]{2,4}\/)(?:[^\s()<>]+|\(([^\s()<>]+|(\([^\s()<>]+\)))*\))+(?:\(([^\s()<>]+|(\([^\s()<>]+\)))*\)|[^\s`!()\[\]{};:'\".,<>?«»“”‘’]))/";
            $body = preg_replace($pattern, "<a href=\"$1\">$1</a>", $body);

            //メールアドレスにリンクを付ける
            $pattern = "/([a-zA-Z0-9_\-\.]*@[a-zA-Z0-9\.]+\.\w+)/";
            $replace = '<a href="mailto:$1">$1</a>';
            $body = preg_replace($pattern, $replace, $body);

            //携帯電話番号にリンクを付ける
            //$pattern ='/^[0-9]{2,4}-[0-9]{2,4}-[0-9]{3,4}$/';
            $pattern = '!(\b\+?[0-9()\[\]./ -]{7,17}\b|\b\+?[0-9()\[\]./ -]{7,17}\s+(extension|x|#|-|code|ext)\s+[0-9]{4,6})!i';
            $replace = '<a href="tel:$1">$1</a>';
            $body = preg_replace($pattern, $replace, $body);

            $this->viewData['body'] = $body;
            $this->viewData['title'] = $title;
            //$this->viewData['listUserMessagesDetail'] = $listUserMessagesDetail;
        }
        else {
            if($send_type == 2) {
                $this->Muser_messege->updateIsReadFromOwner($id);
                $this->Muser_messege->insertListOpenRate($user_id);
                $data = $this->Muser_messege->getMessege_reception_in1($user_id, $id);
                if(empty($data)){
                     redirect(base_url() . 'user/user_messege/messege_reception/');
                }
            }
        }
        $this->viewData['message_list'] = $message_list;
        $this->viewData['send_type'] = $send_type;
        $this->viewData['data'] = $data;
        $this->viewData['titlePage'] = 'joyspe｜受信メッセージ';
        /*sp*/
        if($this->agent->is_mobile()) {
          $this->viewData['load_page'] = "user/user_messege/messege_reception_in";
        }
        /*pc*/
        else{
          $this->viewData['total_users'] = HelperGlobal::getUserTotalNumber();
          $this->viewData['total_owners'] = HelperGlobal::gettotalHeader();
          $this->viewData['load_page'] = "user/pc/message/message_detail";
          $this->breadscrumb_array[] = array("class" => "", "text" => "オファーメール", "link"=>"");
          $this->viewData['breadscrumb_array'] = $this->breadscrumb_array;
          $this->layout = "user/pc/layout/main";
        }
        

        $this->load->view($this->layout, $this->viewData);
    }
    private function set_title_message($title='0', $data,$user_id) {
      foreach ($data as $value) {
          if (($value['template_type'] == 'us03' || $value['template_type'] == 'us14') && $value['send_type'] == 1) {
              if ($title == '0') {
                  $title = $this->common->setTemplateTitleUs03($user_id, $value['ors_id'], array($value['template_type']), $value['id']);
              } else {
                  $title = $title . ' , ' . $this->common->setTemplateTitleUs03($user_id, $value['ors_id'], array($value['template_type']), $value['id']);
              }
          }else if ($value['template_type'] == 'ss09') {
              if ($title == '0') {
                  $title = $this->common->setTemplateTitleSs09($user_id,$value['id']);
              } else {
                  $title =  $title . ' , ' . $this->common->setTemplateTitleSs09($user_id,$value['id']);
              }
          } else {
              if ($value['send_type'] == 1) {
                  if ($title == '0') {
                      $title = $this->common->setTemplateTitle($user_id, $value['owner_id'], array($value['template_type']));
                  } else {
                      $title = $title . ' , ' . $this->common->setTemplateTitle($user_id, $value['owner_id'], array($value['template_type']));
                  }
              }
              else {
                  if ($title == '0')
                      $title = $value['title'];
                  else
                      $title = $title.' , '.$value['title'];
              }
          }
      }
      return $title;
    }
}

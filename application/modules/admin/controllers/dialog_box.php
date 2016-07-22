<?php

class Dialog_box extends MX_Controller {
  protected $_data;
  public function __construct() {
      parent::__construct();
      AdminControl::CheckLogin();
      $this->_data["module"] = $this->router->fetch_module();
      $this->form_validation->CI =& $this;
      $this->load->model('user/Mdialog_box');
  }
  public function index() {
    $data["loadPage"]="dialog_box/set_up_dialog";
    $data["titlePage"]="モーダルセットアップ";
    if($this->input->post()) {
      $cond = array(
        'start_date_last_visit'=> $this->input->post('txtStartDateLastVisit'),
        'end_date_last_visit'  => $this->input->post('txtEndDateLastVisit'),
        'start_date_auth'      => $this->input->post('txtStartDateAuth'),
        'end_date_auth'        => $this->input->post('txtStartDateAuth'),
        'min'                  => $this->input->post('minimum_bonus_money'),
        'max'                  => $this->input->post('maximum_bonus_money')

      );
      $users = array(
        'joyspe'    => $this->input->post('user_from_site'),
        'machemoba' => $this->input->post('user_from_machemoba'),
        'makia'     => $this->input->post('user_from_makia')
      );
      $modal_conditions = $this->modal_conditions($cond);
      $user_site = $this->user_site_flag($users);
      $cnt = count($_FILES['dialog_pic']['name']);
      $cntr = 0;
      for($j=0;$j<$cnt;$j++) {
        if(!empty($_FILES['dialog_pic']['name'][$j])) {
          $cntr++;
        }
      }
      $data['condition_empty'] = ($modal_conditions) ? 'あなたが入力しなければならないのいずれかの最後の訪問日、認証の日付やボーナスお金' :'';
      $data['no_upload'] = ($cntr<1) ? '少なくとも1写真をアップロードする必要があります' :'';
      $data['user_site_empty'] = ($user_site) ? 'マチェモバか、マキアか、どちらのサイトからか選択して下さい。' : '';
      if($this->post_data($modal_conditions,$user_site)) {
        $this->session->set_flashdata('success',正常に保存されました。);
        redirect(current_url());
      }
    }
    $count_all = $this->Mdialog_box->count_all_dialog();
    $data['dialog_box'] = $this->Mdialog_box->get_all_dialog();
    $this->load->view($this->_data["module"]."/layout/layout", $data);
    
  }

  public function update_dialog($id=null) {
    if($this->input->post()) {
      $cond = array(
        'start_date_last_visit'=> $this->input->post('txtStartDateLastVisit'),
        'end_date_last_visit'  => $this->input->post('txtEndDateLastVisit'),
        'start_date_auth'      => $this->input->post('txtStartDateAuth'),
        'end_date_auth'        => $this->input->post('txtStartDateAuth'),
        'min'                  => $this->input->post('minimum_bonus_money'),
        'max'                  => $this->input->post('maximum_bonus_money')

      );
      $users = array(
        'joyspe'    => $this->input->post('user_from_site'),
        'machemoba' => $this->input->post('user_from_machemoba'),
        'makia'     => $this->input->post('user_from_makia')
      );
      $user_site = $this->user_site_flag($users);
      $modal_conditions = $this->modal_conditions($cond);
      $has_image = $this->Mdialog_box->check_images($id);
      $cnt = count($_FILES['dialog_pic']['name']);
      $cntr = 0;
      for($j=0;$j<$cnt;$j++) {
        if(!empty($_FILES['dialog_pic']['name'][$j]) || $has_image < 1) {
          $cntr++;
        }
      }
      $data['condition_empty'] = ($modal_conditions) ? '入力しなければならないのいずれかの最後の訪問日、認証の日付やボーナスお金' :'';
      $data['no_upload'] = ($cntr<1) ? '少なくとも1写真をアップロードする必要があります' :'';
      $data['user_site_empty'] = ($user_site) ? 'マチェモバか、マキアか、どちらのサイトからか選択して下さい。' : '';
      if($this->post_data($modal_conditions,$user_site,$has_image)) {
        $data['success'] = '正常に保存されました。';
      } else {
        $data['reappear_time_modal'] = $reappear_time_modal = trim($this->input->post('reappear_time_modal'));
        $data['text_button'] = $this->input->post('text_button');
        $data['link'] = trim($this->input->post('link'));
        $data['txtStartDateLastVisit'] = trim($this->input->post('txtStartDateLastVisit'));
        $data['txtEndDateLastVisit'] = trim($this->input->post('txtEndDateLastVisit'));
        $data['txtStartDateAuth'] = trim($this->input->post('txtStartDateAuth'));
        $data['txtEndDateAuth'] = trim($this->input->post('txtEndDateAuth'));
        $data['minimum_bonus_money'] = trim($this->input->post('minimum_bonus_money'));
        $data['maximum_bonus_money'] = trim($this->input->post('maximum_bonus_money'));
        $data['bonus_grant'] = trim($this->input->post('bonus_grant'));
        $data['status_registration'] = trim($this->input->post('status_registration'));
        $data['user_from_site'] = ($this->input->post('user_from_site')) ? 1: 0;
        $data['user_from_machemoba'] = ($this->input->post('user_from_machemoba')) ? 1 : 0;
        $data['user_from_makia'] = ($this->input->post('user_from_makia')) ?1:0;
        $data['priority'] = trim($this->input->post('priority'));
        $data['edit_flag'] = trim($this->input->post('edit_flag'));
        $data['first_time_login'] = ($this->input->post('first_time_login')) ? 1 : 0;
        
      }
    }
    $data["loadPage"]="dialog_box/update_dialog";
    $data["titlePage"]="モーダルセットアップ";
    $dialog_detail = $this->Mdialog_box->get_dialog_detail($id);
    if($dialog_detail) {
      $data["dialog_detail"] = $dialog_detail;  
    }
    $this->load->view($this->_data["module"]."/layout/layout", $data);
  }

  public function delete_dialog() {
    $id = $this->input->post('id');
    $delete_dialog = $this->Mdialog_box->delete_dialog($id);
    echo ($delete_dialog) ? 'true' : 'false';
  }

  public function post_data($modal_condition_empty=false,$user_site=false,$no_image=1) {
    $path = $this->config->item('upload_userdir').'dialog_box/';
      if (!is_dir($path)) {
        mkdir($path, 0777, true);
      }

      $id = $this->input->post('id');
      $reappear_time_modal = $this->input->post('reappear_time_modal');
      $link = $this->input->post('link');
      $start_date_last_visit = ($this->input->post('txtStartDateLastVisit'))? $this->input->post('txtStartDateLastVisit') : NULL;
      $end_date_last_visit = ($this->input->post('txtEndDateLastVisit'))  ? $this->input->post('txtEndDateLastVisit'):NULL;
      $start_date_auth = $this->input->post('txtStartDateAuth') ? $this->input->post('txtStartDateAuth'):NULL;
      $end_date_auth = ($this->input->post('txtEndDateAuth')) ? $this->input->post('txtEndDateAuth'):NULL;
      $minimum_bonus_money = $this->input->post('minimum_bonus_money');
      $maximum_bonus_money = $this->input->post('maximum_bonus_money');
      $bonus_grant = $this->input->post('bonus_grant');
      $status_registration = $this->input->post('status_registration');
      $user_from_site = ($this->input->post('user_from_site'))?1:0;
      $user_from_machemoba = ($this->input->post('user_from_machemoba'))?1:0;
      $user_from_makia = ($this->input->post('user_from_makia'))?1:0;
      $priority = $this->input->post('priority');
      $edit_flag = $this->input->post('edit_flag');
      $first_time_login = ($this->input->post('first_time_login'))?1:0;
      $text_button = $this->input->post('text_button');
      $cnt = count($_FILES['dialog_pic']['name']);
      $files = $_FILES;
      $images = array();

      $this->form_validation->set_rules('reappear_time_modal','時間のモーダル表示','required|trim|numeric|xss_clean');
      $this->form_validation->set_rules('link','リンク','required|trim');
      $this->form_validation->set_rules('minimum_bonus_money','最低限','trim|numeric|callback_check_min_money');
      $this->form_validation->set_rules('maximum_bonus_money','最大限','trim|numeric|callback_check_max_money');
      $this->form_validation->set_rules('bonus_grant','付与されたボーナス','required|trim|xss_clean');
      $this->form_validation->set_rules('status_registration','ステータス登録','required|trim|numeric');
      $this->form_validation->set_rules('priority','優先順位','required|trim|numeric|callback_check_priority|greater_than[0]');
      $this->form_validation->set_rules('user_from_site','','trim|numeric|xss_clean');
      $this->form_validation->set_rules('user_from_machemoba','','trim|numeric|xss_clean');
      $this->form_validation->set_rules('user_from_makia','','trim|numeric|xss_clean');
      $this->form_validation->set_rules('text_button','ボタンにテキスト','trim|required');

      for($i=0;$i<$cnt;$i++) {
        $x = 0;
        $possible_keys = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $keys_length = strlen($possible_keys);
        $flname = "";
        while($x < 10) {
            $rand = mt_rand(1,$keys_length-1);
            $flname .= $possible_keys[$rand];
            $x++;
        }

        $_FILES['dialog_pic']['name'] = $files['dialog_pic']['name'][$i];
        $_FILES['dialog_pic']['type'] = $files['dialog_pic']['type'][$i];
        $_FILES['dialog_pic']['tmp_name'] = $files['dialog_pic']['tmp_name'][$i];
        $_FILES['dialog_pic']['error'] = $files['dialog_pic']['error'][$i];
        $_FILES['dialog_pic']['size'] = $files['dialog_pic']['size'][$i];
        if(!empty($_FILES['dialog_pic']['name'])) {
          $fltype = (!empty($_FILES['dialog_pic']['name']))?$_FILES['dialog_pic']['name'] :'';
          $ext = pathinfo($fltype, PATHINFO_EXTENSION);
          $upload = $this->_upload_image($flname,$ext,$path,$_FILES['dialog_pic']['name'],'dialog_pic');
          $images[$i] = $path.$flname . '.' . $ext;  
        }
      }

      $data_to_insert = array(
          'priority'            => $priority,
          'first_login_flag'    => $first_time_login,
          'minimum_bonus_money' => $minimum_bonus_money,
          'maximum_bonus_money' => $maximum_bonus_money,
          'start_date_last_visit'=> $start_date_last_visit,
          'end_date_last_visit'  => $end_date_last_visit,
          'start_date_auth'     => $start_date_auth,
          'end_date_auth'       => $end_date_auth,
          'text_button'         => $text_button,
          'link'                => $link,
          'time_to_display'     => $reappear_time_modal,
          'bonus_grant'         => $bonus_grant,
          'status_registration' => $status_registration,
          'user_from_site'      => $user_from_site,
          'user_from_machemoba' => $user_from_machemoba,
          'user_from_makia'     => $user_from_makia

      );
      if(count($images)>0) {
        foreach($images as $key=>$val){
          $data_to_insert['image_'.++$key] = $val;
        }
      }
      if($edit_flag == 0) {
        if($this->form_validation->run() && ( count($images) > 0 ) && $modal_condition_empty == false && $user_site == false) {
          $this->Mdialog_box->save_dialog($data_to_insert);
          return true;
        }
      } else {
        if($this->form_validation->run() && ( count($images) > 0 || $no_image < 1 ) && $modal_condition_empty == false && $user_site == false) {
          $this->Mdialog_box->update_dialog($data_to_insert,$id);
          return true;
        }
      }
      
  }

  public function delete_image() {
    $id = $this->input->post('id');
    $image_id = $this->input->post('image_id');
    return $this->Mdialog_box->delete_image($id,$image_id);
  }

  private function _upload_image($flname,$ext,$path,$full_name,$data_type) {
    $config = array();
    $config['file_name'] = $flname;
    $config['upload_path'] = $path;
    $config['allowed_types'] = 'jpeg|jpg|png|bmp|gif';
    $config['max_size'] = 4096;
    $config['overwrite'] = true;
    $this->load->library('upload', $config);
    $this->upload->initialize($config);
    if (!$this->upload->do_upload_user($data_type)) {
        $array = array('error' => substr($this->upload->display_errors(), 3,  strlen($this->upload->display_errors() ) - 7)) ;
        return $array;
    } elseif($this->upload->do_upload_user($data_type)) {
        $this->load->library('image_lib');
        $configThumb = array();
        $configThumb['image_library'] = 'gd2';
        $configThumb['source_image'] = $path.$flname . '.' . $ext;
        $configThumb['maintain_ratio'] = FALSE;
        $configThumb['width'] = 640;
        $configThumb['height'] = 700;
        $this->image_lib->initialize($configThumb);
        $this->image_lib->resize();
    }
    

  }

  public function check_priority($priority) {
    $dialog_id = (($this->input->post('id'))) ? $this->input->post('id') : NULL ;
    $result = $this->Mdialog_box->check_priority($priority,$dialog_id);
    if($result) {
      $this->form_validation->set_message('check_priority','優先度が他の設定と重複しています。再度設定してください。');
      return false;
    }
    return true;
  }

  public function check_min_money($min) {
    $max = $this->input->post('maximum_bonus_money');
    if($min > $max) {
      $this->form_validation->set_message('check_min_money','最小お金は最大お金よりも大きくなけれはなりません');
      return false;
    }
    return true;
  }
  
  public function check_max_money($max) {
    $min = $this->input->post('minimum_bonus_money');
    if($max < $min) {
      $this->form_validation->set_message('check_max_money','最大お金が最小ボーナスお金よりも大きくなければなりません');
      return false;
    }
    return true;
  }

  public function modal_conditions($cond) {
    if ((($cond['start_date_last_visit']=='') && ($cond['end_date_last_visit'] =='')) &&
        ((($cond['start_date_auth'] =='')) && ($cond['end_date_auth']=='')) && 
        ( $cond['min'] == '' && $cond['max'] == '')) {
      
      return true;
    } 
    return false;
  }

  public function user_site_flag($users) {
    if($users['joyspe']==''&&$users['machemoba']==''&&$users['makia']=='') {
      return true;
    }
    return false;
  }
  
}
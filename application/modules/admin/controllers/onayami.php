<?php
class Onayami extends MX_Controller{
    protected $_data;
    private $message = array('success' => true, 'error' => array());
    private $common;
    public $limit = 10;
    public function __construct() {
        parent::__construct();
        AdminControl::CheckLogin();
        $this->_data["module"] = $this->router->fetch_module();
        $this->form_validation->CI =& $this;
        $this->common = new Common();
        $this->output->set_header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate");
        $this->output->set_header("Cache-Control: post-check=0, pre-check=0");
        $this->output->set_header("Pragma: no-cache");
        $this->load->Model('admin/Mbbs');
    }

    public function bonus() {
        $this->_data["bonusData"] = $this->Mbbs->getBonusSettings(0);
        $this->_data["loadPage"]  = "onayami/bonus";
        $this->_data["titlePage"] = "スレッド検索";
        $this->load->view($this->_data["module"]."/layout/layout", $this->_data);
    }

    public function bonusEdit () {
        $data = array();
        extract($this->input->post());
        if (isset($questionBonus) && $questionBonus !='') {
            $post_data  = array(
                    'name' => 'question_bonus',
                    'value' => intval($questionBonus)
                );
            array_push($data, $post_data);
        }
        if (isset($answerBonus) && $answerBonus != '') {
            $post_data  = array(
                    'name' => 'answer_bonus',
                    'value' => intval($answerBonus)
                );
            array_push($data, $post_data);
        }
        if (isset($likePointsMultiplyBy) && $likePointsMultiplyBy != '') {
            $post_data  = array(
                    'name' => 'like_points_multiply_by',
                    'value' => intval($likePointsMultiplyBy)
                );
            array_push($data, $post_data);
        }
        if (isset($evaluateBonus) && $evaluateBonus != '') {
            $post_data  = array(
                    'name' => 'evaluate_bonus',
                    'value' => intval($evaluateBonus)
                );
            array_push($data, $post_data);
        }
        if (isset($maxAnswerHasBonus) && $maxAnswerHasBonus != '') {
            $post_data  = array(
                    'name' => 'max_answer_has_bonus',
                    'value' => intval($maxAnswerHasBonus)
                );
            array_push($data, $post_data);
        }
        $this->load->library("form_validation");
        $this->form_validation->set_rules('questionBonus', 'スレッド立てボーナス', 'numeric');
        $this->form_validation->set_rules('answerBonus', '書き込みボーナス', 'numeric');
        $this->form_validation->set_rules('likePointsMultiplyBy', 'あるある累計ボーナス', 'numeric');
        $this->form_validation->set_rules('evaluateBonus', 'あるある獲得ボーナス', 'numeric');
        $this->form_validation->set_rules('maxAnswerHasBonus', 'ボーナス対象コメント数', 'numeric');
        $ret = array();
        if($this->form_validation->run() == false){
            $ret['status'] = 'error';
        }
        else {
            $this->Mbbs->bbsSetting($data, 0);
            $ret['status'] = 'success';
        }
        
        echo json_encode($ret);
        exit;
    }

    public function thread_point($page = null) {
        $error = '';
        $result = '';
        $where = '';
        $data = array();
        $this->_data["subject"] = '';
        $this->_data["start_date"] = '';
        $this->_data["end_date"] = '';
        if ($page == null) {
          $current_page = 0;
          $offset = 0;
        } else {
          $current_page = $page;
          $offset = ($page-1) * $this->limit;
        }
        $this->form_validation->set_rules('start_date','DOB','callback_checkDateFormat'); 
        $this->form_validation->set_rules('end_date','DOB','callback_checkDateFormat'); 
      
        if (isset($_POST['buttonSearch'])) {
            if (!empty($_POST['subject'])) {
                $where = " AND bt.title LIKE '%".$_POST['subject']."%'";
            }
            if (!empty($_POST['start_date']) && !empty($_POST['start_date'])) {
               $where .= "AND  DATE_FORMAT(bt.create_date, '%Y/%m/%d') >= ? AND  DATE_FORMAT(bt.create_date, '%Y/%m/%d') <= ?";
               $data[] = $_POST['start_date'];
               $data[] = $_POST['end_date'];
            }
            $this->_data["subject"] = $_POST['subject'];
            $this->_data["start_date"] = $_POST['start_date'];
            $this->_data["end_date"] = $_POST['end_date'];

            if ($this->form_validation->run() == FALSE) {
              $error = '日付が正しくありません。再入力してください。';
            } else {
              $start_date = $_POST['start_date'];
              $end_date = $_POST['end_date'];
              if ($start_date == '' || $end_date  == '') {
                 $error = '日付が正しくありません。再入力してください。';
              } 
              if ($start_date == '' && $end_date == '') {
                $error = '';
              }
            }
            $this->_data["error"] = $error;
        }
        if ($error == '') {
           $result = $this->Mbbs->getConsultList($where, $data, $offset);
           $total_row = $this->Mbbs->getTotalRows();
        }
        $this->_data["threadList"] = $result;
        $this->_data["pagination"] = HelperApp::get_paging($this->limit, base_url().'admin/onayami/thread_point/', $total_row, $current_page, 'bootstrap');
        $this->_data["loadPage"]  = "onayami/thread_point";
        $this->_data["titlePage"] = "スレッド管理";
        $this->load->view($this->_data["module"]."/layout/layout", $this->_data);
   }

   public function thread_detail($id = null) {
     
      $request = $this->input->post();
      $is_ajax = (empty($request['is_ajax'])) ? false : true;
      $status = array(1 => '公開', 2 => '非公開');
      if (isset($request['page'])) {
        $offset = ($request['page']) * $this->limit;
        $curr_page = $request['page'] + 1;
      } else {
        $offset = 0;
        $curr_page = 1;
      }

      if (isset($_POST['id']) && !empty($_POST['id'])) {
          $reason = '';
          $arrdata = explode(':', $_POST['id']);
          if (isset($arrdata[1]) && ($arrdata[1] == 2 || $arrdata[1] == 3)) { // target bonus type 2 for comment bonus, 3 for weekly bonus
            $where = "`thread_id` = ".$arrdata[0]." and `target` = ".$arrdata[1];
            $reason = '回答ボーナスを引く管理者';
          } else {
            if (isset($_POST['bonus_type']) && $_POST['bonus_type'] == 1) { // check bonus type if first thread
                $where = "id  = ".$arrdata[0]." and `target` = 1";
                $reason = '投稿ボーナスを引く管理者'; 
            } elseif (isset($arrdata[1]) && ($arrdata[1] == 4)) {
                 $where = "`thread_id` = ".$arrdata[0]." and `target` = ".$arrdata[1]." and comment_id is null";
                 $reason = '私もそう思うを引く（質問者）管理者';
            } else {
                $where = "comment_id  = ".$arrdata[0]." and `target` = 4";
                $reason = '私もそう思うを引く（質問者）管理者'; 
            } 
          }
          
          // get and check comment to cancel
          $row = $this->Mbbs->getPointOnayami($where);
          if (!empty($row)) {
            if ($this->Mbbs->cancelOnyamiPoints($where)) { //check successfully update and add to log
              foreach ($row as $key => $value) {
                $this->Mbbs->updateOnayamiBonus($value['user_id'], $value['point'] , $reason, 1);
              }
            }            
          }
      }

       $row = $this->Mbbs->getConsultDetail($id);
       $where ='AND target IN (1, 2, 3, 4) AND comment_id is null';
       $data = $this->Mbbs->getOnayamiPoints($where, array($id));
       foreach ($data as $key => $value) {
         $row['points'][] = array(
           'id' => $value['id'],
           'thread_id' => $value['thread_id'],
           'comment_id' => $value['comment_id'],
           'target' =>  $value['target']
         );
       }

       $this->_data["threadDetail"] = $row;      

       $comments = $this->Mbbs->getConsultArray($id, $offset, $this->limit);
       $comments_list = $comments['comments_list'];       

       $where ='AND target IN (4) AND comment_id = ?';
       foreach ($comments_list as $key => $value) {
          $data = $this->Mbbs->getOnayamiPoints($where, array($value['post_id'], $value['id']));
          foreach ($data as $key1 => $value1) {
              $comments_list[$key]['points']= array(
                'id' => $value1['id'],
                'comment_id' => $value1['comment_id'],
                'target' =>  $value1['target']
              );
          }
       }

       if ($comments['tota_list'] == count($comments_list)) {
           $curr_page = 0;
       }

       $this->_data['status'] = $status;
       $this->_data['more_page'] = $curr_page;
       $this->_data['comments'] = $comments_list;
       $this->_data['total_row'] = $comments['tota_list'];
       $this->_data['current_page'] = $id;
       $this->_data["titlePage"] = "スレッド管理";
       if ($is_ajax) {
          $this->load->view("onayami/thread_detail_ajax", $this->_data); 
       } else {
          $this->_data["loadPage"]  = "onayami/thread_detail";
          $this->load->view($this->_data["module"]."/layout/layout", $this->_data);
       }

   }

   public function checkDateFormat($date) {
      if (!empty($date)) {
         if (preg_match("/^[0-9]{4}\/(0[1-9]|1[0-2])\/(0[1-9]|[1-2][0-9]|3[0-1])$/", $date)) {
          return true;
        } else {
          return false;
        }
      }
      return true;
   }

   public function update_status() {
      $request = $this->input->post();
      $result = $this->Mbbs->updateConsult($request['select'], $request['id'], $request['type']);
      if ($result) {
        $ret['status'] = 'success';
      } else {
        $ret['status'] = 'error';
      }
      echo json_encode($ret);
      exit;
   }
}

?>
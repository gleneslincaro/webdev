<?php
class Bbs extends MX_Controller{
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

    public function category_setting() {

      /*$array = array();
      $array[0] = array('index' => 1,'big_category_name' => 'あああああ');
      $array[1] = array('index' => 2,'big_category_name' => 'いいいいい');
      $array[2] = array('index' => 3,'big_category_name' => 'ううううう');
      $array[3] = array('index' => 4,'big_category_name' => 'えええええ');
      $array[4] = array('index' => 5,'big_category_name' => 'おおおおお');*/

      $new_cate = $this->input->post('new_cate');
      $big_cate_ar = $this->Mbbs->get_big_category();
      $this->_data["big_category_ar"]  = $big_cate_ar;

      $array = array();
      foreach ($big_cate_ar as $key => $val) {
          $ar = array();
          $categorys = $this->Mbbs->get_category($val['id']);
          foreach ($categorys as $key2 => $val2) {
              $ar[$val2['id']] = $val2['name'];
          }
          $array[$val['id']] = $ar;
      }
      $this->_data['category_ar'] = $array;

      $this->_data["loadPage"]  = "bbs/index";
      $this->_data["titlePage"] = "カテゴリー設定";
      $this->load->view($this->_data["module"]."/layout/layout", $this->_data);
    }

    public function category_ajax() {
      $array = array();
      $array = array('index' => 1,'big_category_name' => 'あああああ');
//      $array[2] = array('big_category_name' => 'いいいいい');
//      $array[3] = array('big_category_name' => 'ううううう');
//      $array[4] = array('big_category_name' => 'えええええ');
      $this->_data["info"]  = $array;
      $this->load->view('bbs/add_big_category', $this->_data);
    }

   public function add_big_category_ajax() {
        $new_cate = $this->input->post('new_cate');
        $this->Mbbs->insert_big_category($new_cate);

       //postデータをもとに$arrayからデータを抽出
        $data = array('flag' => true);

        //$dataをJSONにして返す
        $this->output
             ->set_content_type('application/json')
             ->set_output(json_encode($data));
   }

   public function add_category_ajax() {
        $p_cate_id = $this->input->post('p_cate_id');
        $new_cate = $this->input->post('new_cate');
        $this->Mbbs->insert_category($p_cate_id, $new_cate);

       //postデータをもとに$arrayからデータを抽出
        $data = array('flag' => true);

        //$dataをJSONにして返す
        $this->output
             ->set_content_type('application/json')
             ->set_output(json_encode($data));
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
                $where = " AND abt.title LIKE '%".$_POST['subject']."%'";
            }
            if (!empty($_POST['start_date']) && !empty($_POST['start_date'])) {
               $where .= "AND  DATE_FORMAT(abt.create_date, '%Y/%m/%d') >= ? AND  DATE_FORMAT(abt.create_date, '%Y/%m/%d') <= ?";
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
           $result = $this->Mbbs->getThreadList($where, $data, $offset);
           $total_row = $this->Mbbs->getTotalRows();
        }
        $this->_data["threadList"] = $result;
        $this->_data["pagination"] = HelperApp::get_paging($this->limit, base_url().'admin/bbs/thread_point/', $total_row, $current_page, 'bootstrap');
        $this->_data["loadPage"]  = "bbs/thread_point";
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
          $row = $this->Mbbs->getAruaruPoints($where); 
          if (!empty($row)) {
            if ($this->Mbbs->cancelPoints($where)) { //check successfully update and add to log
              foreach ($row as $key => $value) {
                $this->Mbbs->updateScoutBonus($value['user_id'], $value['point'] , $reason, 1);
              }
            }            
          }
      }

       $row = $this->Mbbs->getThreadCommentDetail($id);
       $where ='AND target IN (1, 2, 3, 4) AND comment_id is null';
       $data = $this->Mbbs->getValidPoints($where, array($id));
       foreach ($data as $key => $value) {
         $row['points'][] = array(
           'id' => $value['id'],
           'thread_id' => $value['thread_id'],
           'comment_id' => $value['comment_id'],
           'target' =>  $value['target']
         );
       }
       $this->_data["threadDetail"] = $row;      

       $comments = $this->Mbbs->getLatestsArray($id, $offset, $this->limit);
       $comments_list = $comments['comments_list'];       

       $where ='AND target IN (4) AND comment_id = ?';
       foreach ($comments_list as $key => $value) {
          $data = $this->Mbbs->getValidPoints($where, array($value['post_id'], $value['id']));
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
          $this->load->view("bbs/thread_detail_ajax", $this->_data); 
       } else {
          $this->_data["loadPage"]  = "bbs/thread_detail";
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
      $result = $this->Mbbs->updateStatus($request['select'], $request['id'], $request['type']);
      if ($result) {
        $ret['status'] = 'success';
      } else {
        $ret['status'] = 'error';
      }
      echo json_encode($ret);
      exit;
   } 

   public function bonus() {
        $this->_data["bonusData"] = $this->Mbbs->getBonusSettings();
        $this->_data["loadPage"]  = "bbs/bonus";
        $this->_data["titlePage"] = "スレッド検索";
        $this->load->view($this->_data["module"]."/layout/layout", $this->_data);
    }

    public function bonusEdit () {
        $data = array();
        extract($this->input->post());
        if (isset($threadBonus) && $threadBonus !='') {
            $post_data  = array(
                    'name' => 'thread_bonus',
                    'value' => intval($threadBonus)
                );
            array_push($data, $post_data);
        }
        if (isset($commentBonus) && $commentBonus != '') {
            $post_data  = array(
                    'name' => 'comment_bonus',
                    'value' => intval($commentBonus)
                );
            array_push($data, $post_data);
        }
        if (isset($likeMultiplyBy) && $likeMultiplyBy != '') {
            $post_data  = array(
                    'name' => 'like_points_multiply_by',
                    'value' => intval($likeMultiplyBy)
                );
            array_push($data, $post_data);
        }
        if (isset($commentLikeBonus) && $commentLikeBonus != '') {
            $post_data  = array(
                    'name' => 'comment_like_bonus',
                    'value' => intval($commentLikeBonus)
                );
            array_push($data, $post_data);
        }
        if (isset($maxCommentHasBonus) && $maxCommentHasBonus != '') {
            $post_data  = array(
                    'name' => 'max_comment_has_bonus',
                    'value' => intval($maxCommentHasBonus)
                );
            array_push($data, $post_data);
        }
        $this->load->library("form_validation");
        $this->form_validation->set_rules('threadBonus', 'スレッド立てボーナス', 'numeric');
        $this->form_validation->set_rules('commentBonus', '書き込みボーナス', 'numeric');
        $this->form_validation->set_rules('likeMultiplyBy', 'あるある累計ボーナス', 'numeric');
        $this->form_validation->set_rules('commentLikeBonus', 'あるある獲得ボーナス', 'numeric');
        $this->form_validation->set_rules('maxCommentHasBonus', 'ボーナス対象コメント数', 'numeric');
        $ret = array();
        if($this->form_validation->run() == false){
            $ret['status'] = 'error';
        }
        else {
            $this->Mbbs->bbsSetting($data);
            $ret['status'] = 'success';
        }
        
        echo json_encode($ret);
        exit;
    }



}
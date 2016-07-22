<?php
class statistics extends MY_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model("user/Muser_statistics");
    }
    /*
    * @author: VJS
    * update HP click
    */
    public function updateClick(){
        if ( $type = $this->input->post('type') ){
            $user_id = UserControl::getId();
            // ログインユーザーしかクリック更新させない
            if ( $user_id ){
               $this->Muser_statistics->updateClick($user_id, $type);
            }
        }
   }
   
   public function insertUserStatisticsLog() {
      $user_id = $this->input->post('user_id');
      $owner_id = $this->input->post('owner_id');
      $ors_id = $this->input->post('ors_id');
      $action_type = $this->input->post('action_type');      
      $data = array(
                  'user_id' => $user_id,
                  'owner_id' => $owner_id,
                  'owner_recruit_id' => $ors_id,
                  'action_type' => $action_type,
                  'created_date' => date('Y-m-d H:i:s')
              );              
      echo json_encode($this->Muser_statistics->insertUserStatisticsLog($data));     
   }
}

?>

<?php
class MCampaign extends CI_Model {

    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

    // 現在、キャンペーン中か取得
    public function hasCampaign() {
        $ret = false;
        $latest_campaign = $this->getLatestCampaign();

        if ( $latest_campaign && count($latest_campaign) > 0 ) {
            $ret = true;
        }
    }
    // 最新キャンペーンの情報取得
    public function getLatestCampaign() {
        $ret = null;
        $sql  = "SELECT id, travel_expense, multi_request_per_owner_flag, ";
        $sql .= "       budget_money, banner_path, max_request_times, start_date ";
        $sql .= "FROM campaign_list WHERE display_flag = 1 AND end_date >= CURDATE() ORDER BY id DESC LIMIT 1";
        $result = $this->db->query($sql);

        if ( $result ) {
            $ret = $result->row_array();
        }
        return $ret;
    }

    // 特定のキャンペーン情報を取得する
    public function getCampaign( $campagin_id ) {
      $campaign_data = null;

      if ( $campagin_id ) {
        $this->db->where( 'id', $campagin_id );
        $campaign_data = $this->db->get('campaign_list');
      }

      return $campaign_data;
    }

    // 特定のキャンペーン金額を取得する
    public function getCampaignMoney($campagin_id, $owner_id = null) {
        $campaign_money = 0;

        if ($owner_id) {
            $this->db->select('travel_expense_bonus_point');
            $this->db->where( 'id', $owner_id );
            $query = $this->db->get('owners');
            if ( $query && $data = $query->row_array() ) {
                $campaign_money = $data['travel_expense_bonus_point'];
            }
        }

        if ($campaign_money == 0 && $campagin_id) {
            $this->db->select('travel_expense');
            $this->db->where( 'id', $campagin_id );
            $query = $this->db->get('campaign_list');
            if ( $query && $data = $query->row_array() ) {
                $campaign_money = $data['travel_expense'];
            }
        }

      return $campaign_money;
    }

    public function getMstCampaignMoney( $campagin_id ) {
      $campaign_money = 0;

      if ( $campagin_id ) {
        $this->db->select('bonus_money');
        $this->db->where( 'id', $campagin_id );
        $query = $this->db->get('mst_campaign');
        if ( $query && $data = $query->row_array() ) {
          $campaign_money = $data['bonus_money'];
        }
      }

      return $campaign_money;
    }

    // キャンペーン数取得
    public function getAllCampaign( $data_per_page, $offset ) {
      $ret = null;
      $this->db->order_by('id', "DESC");
      $query = $this->db->get("campaign_list", $data_per_page, $offset );
      if ( $query ) {
        $ret = $query->result_array();
      }

      return $ret;
    }

    // キャンペーン数取得
    public function getAllCampaignNo() {
      return $this->db->count_all_results('campaign_list');
    }

    public function getAllMstCampaignNo() {
      return $this->db->count_all_results('mst_campaign');
    }

    // キャンペーンデータ更新
    public function updateCampaignData( $id, $data ) {
      $id = (int)$id;
      if ( $id && $data ){
        $this->db->where('id', $id);
        $this->db->update('campaign_list', $data);
      }

      return $this->db->affected_rows() > 0 ? true : false;
    }

    // 新キャンペーンを登録する
    public function createNewCampaign( $data ) {
      $ret = false;
      if ( $data ) {
        $this->db->insert('campaign_list', $data);
        $ret = $this->db->affected_rows() > 0 ? true : false;
      }
      return $ret;
    }


    public function getmakiaUserCampaign($campaign_id, $step, $inOut){
      $flag = $this->getMakiaCampaignid($campaign_id);
      if ($inOut == 'in') {
        if( $flag[0]['new_campaign_flag'] == 1){
          $sqlext = 'NOW() >= u.offcial_reg_date AND NOW() <= DATE_FORMAT(DATE_ADD(DATE_FORMAT(DATE_ADD(u.offcial_reg_date, INTERVAL msuc.campaign1_valid_days DAY), "%Y-%m-%d %H:%m:%s"), INTERVAL msuc.campaign_retry_days DAY), "%Y-%m-%d %H:%m:%s") AND sucp.step' . $step .'_fin_flag = 1 AND msuc.new_campaign_flag = 1';
        }else{
          $sqlext = 'NOW() >= msuc.campaign2_start_date AND NOW() <= msuc.campaign2_end_date AND sucp.step' . $step .'_fin_flag = 1 AND msuc.new_campaign_flag = 0';
        }
      }
      if ($inOut == 'out') {
        if( $flag[0]['new_campaign_flag'] == 1){
          $sqlext = 'NOW() >= DATE_FORMAT(DATE_ADD(DATE_FORMAT(DATE_ADD(u.offcial_reg_date, INTERVAL msuc.campaign1_valid_days DAY), "%Y-%m-%d %H:%m:%s"), INTERVAL msuc.campaign_retry_days DAY), "%Y-%m-%d %H:%m:%s") AND sucp.step' . $step .'_fin_flag = 1 AND msuc.new_campaign_flag = 1';
        }else{
          $sqlext = 'NOW() >= msuc.campaign2_start_date AND NOW() >= msuc.campaign2_end_date AND sucp.step' . $step .'_fin_flag = 1 AND msuc.new_campaign_flag = 0';
        }
      }
      $sql = "SELECT u.unique_id, u.name, u.website_id, u.last_visit_date, u.offcial_reg_date
              FROM `step_up_campaign_progress` AS sucp
              LEFT JOIN `mst_step_up_campaign` AS msuc ON sucp.step_up_campaign_id = msuc.id
              LEFT JOIN `users` AS u ON sucp.user_id = u.id
              WHERE sucp.step_up_campaign_id = ? AND " . $sqlext;
      $result = $this->db->query($sql, array($campaign_id));
      $ret = $result->result_array();
      return $ret;
    }

    public function getmakiaCampaignProgress($campaign_id) {
      $sql = "SELECT SUM(CASE
                          WHEN NOW() >= u.offcial_reg_date AND NOW() <= DATE_FORMAT(DATE_ADD(DATE_FORMAT(DATE_ADD(u.offcial_reg_date, INTERVAL msuc.campaign1_valid_days DAY), '%Y-%m-%d %H:%m:%s'), INTERVAL msuc.campaign_retry_days DAY), '%Y-%m-%d %H:%m:%s') AND sucp.step1_fin_flag = 1 AND msuc.new_campaign_flag = 1 THEN 1
                          WHEN NOW() >= msuc.campaign2_start_date AND NOW() <= msuc.campaign2_end_date AND sucp.step1_fin_flag = 1 AND msuc.new_campaign_flag = 0 THEN 1
                          ELSE 0 END) AS step1in,
                     SUM(CASE
                          WHEN NOW() >= u.offcial_reg_date AND NOW() <= DATE_FORMAT(DATE_ADD(DATE_FORMAT(DATE_ADD(u.offcial_reg_date, INTERVAL msuc.campaign1_valid_days DAY), '%Y-%m-%d %H:%m:%s'), INTERVAL msuc.campaign_retry_days DAY), '%Y-%m-%d %H:%m:%s') AND sucp.step2_fin_flag = 1 AND msuc.new_campaign_flag = 1 THEN 1
                          WHEN NOW() >= msuc.campaign2_start_date AND NOW() <= msuc.campaign2_end_date AND sucp.step2_fin_flag = 1 AND msuc.new_campaign_flag = 0 THEN 1
                          ELSE 0 END) AS step2in,
                     SUM(CASE
                          WHEN NOW() >= u.offcial_reg_date AND NOW() <= DATE_FORMAT(DATE_ADD(DATE_FORMAT(DATE_ADD(u.offcial_reg_date, INTERVAL msuc.campaign1_valid_days DAY), '%Y-%m-%d %H:%m:%s'), INTERVAL msuc.campaign_retry_days DAY), '%Y-%m-%d %H:%m:%s') AND sucp.step3_fin_flag = 1 AND msuc.new_campaign_flag = 1 THEN 1
                          WHEN NOW() >= msuc.campaign2_start_date AND NOW() <= msuc.campaign2_end_date AND sucp.step3_fin_flag = 1 AND msuc.new_campaign_flag = 0 THEN 1
                          ELSE 0 END) AS step3in,
                     SUM(CASE
                          WHEN NOW() >= u.offcial_reg_date AND NOW() <= DATE_FORMAT(DATE_ADD(DATE_FORMAT(DATE_ADD(u.offcial_reg_date, INTERVAL msuc.campaign1_valid_days DAY), '%Y-%m-%d %H:%m:%s'), INTERVAL msuc.campaign_retry_days DAY), '%Y-%m-%d %H:%m:%s') AND sucp.step4_fin_flag = 1 AND msuc.new_campaign_flag = 1 THEN 1
                          WHEN NOW() >= msuc.campaign2_start_date AND NOW() <= msuc.campaign2_end_date AND sucp.step4_fin_flag = 1 AND msuc.new_campaign_flag = 0 THEN 1
                          ELSE 0 END) AS step4in,
                     SUM(CASE
                          WHEN NOW() >= u.offcial_reg_date AND NOW() <= DATE_FORMAT(DATE_ADD(DATE_FORMAT(DATE_ADD(u.offcial_reg_date, INTERVAL msuc.campaign1_valid_days DAY), '%Y-%m-%d %H:%m:%s'), INTERVAL msuc.campaign_retry_days DAY), '%Y-%m-%d %H:%m:%s') AND sucp.step5_fin_flag = 1 AND msuc.new_campaign_flag = 1 THEN 1
                          WHEN NOW() >= msuc.campaign2_start_date AND NOW() <= msuc.campaign2_end_date AND sucp.step5_fin_flag = 1 AND msuc.new_campaign_flag = 0 THEN 1
                          ELSE 0 END) AS step5in,
                     SUM(CASE
                          WHEN NOW() >= DATE_FORMAT(DATE_ADD(DATE_FORMAT(DATE_ADD(u.offcial_reg_date, INTERVAL msuc.campaign1_valid_days DAY), '%Y-%m-%d %H:%m:%s'), INTERVAL msuc.campaign_retry_days DAY), '%Y-%m-%d %H:%m:%s') AND sucp.step1_fin_flag = 1 AND msuc.new_campaign_flag = 1 THEN 1
                          WHEN NOW() >= msuc.campaign2_start_date AND NOW() >= msuc.campaign2_end_date AND sucp.step1_fin_flag = 1 AND msuc.new_campaign_flag = 0 THEN 1
                          ELSE 0 END) AS step1out,
                     SUM(CASE
                          WHEN NOW() >= DATE_FORMAT(DATE_ADD(DATE_FORMAT(DATE_ADD(u.offcial_reg_date, INTERVAL msuc.campaign1_valid_days DAY), '%Y-%m-%d %H:%m:%s'), INTERVAL msuc.campaign_retry_days DAY), '%Y-%m-%d %H:%m:%s') AND sucp.step2_fin_flag = 1 AND msuc.new_campaign_flag = 1 THEN 1
                          WHEN NOW() >= msuc.campaign2_start_date AND NOW() >= msuc.campaign2_end_date AND sucp.step2_fin_flag = 1 AND msuc.new_campaign_flag = 0 THEN 1
                          ELSE 0 END) AS step2out,
                     SUM(CASE
                          WHEN NOW() >= DATE_FORMAT(DATE_ADD(DATE_FORMAT(DATE_ADD(u.offcial_reg_date, INTERVAL msuc.campaign1_valid_days DAY), '%Y-%m-%d %H:%m:%s'), INTERVAL msuc.campaign_retry_days DAY), '%Y-%m-%d %H:%m:%s') AND sucp.step3_fin_flag = 1 AND msuc.new_campaign_flag = 1 THEN 1
                          WHEN NOW() >= msuc.campaign2_start_date AND NOW() >= msuc.campaign2_end_date AND sucp.step3_fin_flag = 1 AND msuc.new_campaign_flag = 0 THEN 1
                          ELSE 0 END) AS step3out,
                     SUM(CASE
                          WHEN NOW() >= DATE_FORMAT(DATE_ADD(DATE_FORMAT(DATE_ADD(u.offcial_reg_date, INTERVAL msuc.campaign1_valid_days DAY), '%Y-%m-%d %H:%m:%s'), INTERVAL msuc.campaign_retry_days DAY), '%Y-%m-%d %H:%m:%s') AND sucp.step4_fin_flag = 1 AND msuc.new_campaign_flag = 1 THEN 1
                          WHEN NOW() >= msuc.campaign2_start_date AND NOW() >= msuc.campaign2_end_date AND sucp.step4_fin_flag = 1 AND msuc.new_campaign_flag = 0 THEN 1
                          ELSE 0 END) AS step4out,
                     SUM(CASE
                          WHEN NOW() >= DATE_FORMAT(DATE_ADD(DATE_FORMAT(DATE_ADD(u.offcial_reg_date, INTERVAL msuc.campaign1_valid_days DAY), '%Y-%m-%d %H:%m:%s'), INTERVAL msuc.campaign_retry_days DAY), '%Y-%m-%d %H:%m:%s') AND sucp.step5_fin_flag = 1 AND msuc.new_campaign_flag = 1 THEN 1
                          WHEN NOW() >= msuc.campaign2_start_date AND NOW() >= msuc.campaign2_end_date AND sucp.step5_fin_flag = 1 AND msuc.new_campaign_flag = 0 THEN 1
                          ELSE 0 END) AS step5out
                      FROM `step_up_campaign_progress` AS sucp
                      LEFT JOIN `mst_step_up_campaign` AS msuc ON sucp.step_up_campaign_id = msuc.id
                      LEFT JOIN `users` AS u ON sucp.user_id = u.id
                      WHERE sucp.step_up_campaign_id = ?";
      $result = $this->db->query($sql, array($campaign_id));
      $ret = $result->row_array();
      return $ret;
    }

    public function getMakiaCampaignid($id = false) {
      $ret = null;
      $this->db->order_by('id', "DESC");
      if ($id != false) {
        $this->db->where('id', $id);
      }
      $query = $this->db->get("mst_step_up_campaign");
      if ( $query ) {
        $ret = $query->result_array();
      }
      return $ret;
    }

    public function getMakiaCampaignfl($flag = false) {
      $ret = null;
      $this->db->order_by('id', "DESC");
      if ($flag == 1 || $flag == 0 && $flag != null){
        $this->db->where('new_campaign_flag', $flag);
      }
      $query = $this->db->get("mst_step_up_campaign");
      if ( $query ) {
        $ret = $query->result_array();
      }
      return $ret;
    }

    public function getStepUpCampaignProgressFinish(){
      $ret = null;
      $sql = "SELECT sucp.user_id, u.unique_id, sucp.step_up_campaign_id, sucp.no_of_interviews, sucp.request_money_date, sucp.request_money_flag, msuc.budget_money, msuc.max_user_no
              FROM `step_up_campaign_progress` AS sucp
              INNER JOIN `users` AS u ON sucp.user_id = u.id
              INNER JOIN `mst_step_up_campaign` AS msuc ON sucp.step_up_campaign_id = msuc.id
              WHERE sucp.request_money_flag != 0  ORDER BY sucp.request_money_date DESC";
      $result = $this->db->query($sql);
      if ( $result ) {
        $ret = $result->result_array();
      }
      return $ret;
    }

    public function makiacampaigncreate($data){
      $ret = false;
      if ( $data ) {
        $this->db->insert('mst_step_up_campaign', $data);
        $ret = $this->db->affected_rows() > 0 ? true : false;
      }
      return $ret;
    }

    public function updateMakiaCampaignData( $id, $data ) {
      $id = (int)$id;
      if ( $id && $data ){
        $this->db->where('id', $id);
        $this->db->update('mst_step_up_campaign', $data);
      }

      return $this->db->affected_rows() > 0 ? true : false;
    }

    public function updateCampaignProgress( $data, $id, $user_id  ) {
      $this->db->where('step_up_campaign_id', $id);
      $this->db->where('user_id', $user_id);
      $this->db->update('step_up_campaign_progress', $data);
      return $this->db->affected_rows() > 0 ? true : false;
    }

    public function updateFlagCampaignProgress($id, $data){
        $this->db->where('step_up_campaign_id', $id);
        $this->db->update('step_up_campaign_progress', $data);
        return $this->db->affected_rows() > 0 ? true : false;
    }

    public function getAllMstCampaign( $data_per_page, $offset ) {
        $ret = null;
        $this->db->order_by('id', "DESC");
        $query = $this->db->get("mst_campaign", $data_per_page, $offset );
        if ( $query ) {
          $ret = $query->result_array();
        }
        return $ret;
    }

    public function getLatestCampaignBonusRequest() {
        $ret = null;
        $sql  = "SELECT * ";
        $sql .= "FROM mst_campaign WHERE display_flag = 1 AND end_date >= CURDATE() ORDER BY id DESC LIMIT 1";
        $result = $this->db->query($sql);
        if ( $result ) {
            $ret = $result->row_array();
        }
        return $ret;
    }

    public function createMstCampaign( $data ) {
        $ret = false;
        if ( $data ) {
            $this->db->insert('mst_campaign', $data);
            $ret = $this->db->affected_rows() > 0 ? true : false;
        }
        return $ret;
    }

    public function updateCampaignBonusRequest( $id, $data ) {
        $id = (int)$id;
        if ( $id && $data ){
          $this->db->where('id', $id);
          $this->db->update('mst_campaign', $data);
        }
        return $this->db->affected_rows() > 0 ? true : false;
    }
    //check if the owner has own trial work bonus point
    public function getOwnerTrialWorkPoint($owner_recruit_id) {
        $points = 0;
        $sql = "SELECT ow.trial_work_bonus_point FROM owner_recruits owr INNER JOIN owners ow ON ow.id = owr.owner_id WHERE owr.id = ? ORDER BY ow.id DESC LIMIT 1";
        $query = $this->db->query($sql,array($owner_recruit_id));
        if ($query && $ret = $query->row_array()) {
            $points = $ret['trial_work_bonus_point'];
        }
        return $points;
    }

    //check if the owner has its own travel expense bonus point
    public function getOwnerTravelExpensePoint($owner_recruit_id) {
        $points = 0;
        $sql = "SELECT ow.travel_expense_bonus_point FROM owner_recruits owr INNER JOIN owners ow ON ow.id = owr.owner_id WHERE owr.id = ? ORDER BY ow.id DESC LIMIT 1";
        $query = $this->db->query($sql,array($owner_recruit_id));
        if ($query && $ret = $query->row_array()) {
            $points = $ret['travel_expense_bonus_point'];
        }
        return $points;
    }
    #check if the owner has own trial work bonus point by its campaign request id
    public function getOwnerTrialWorkPointById($campaign_request_id) {
        $points = 0;
        $sql = "SELECT ow.trial_work_bonus_point FROM campaign_bonus_request_list cbrl INNER JOIN owners  ow ON ow.id = cbrl.owner_id  WHERE cbrl.id = ?";
        $query = $this->db->query($sql,array($campaign_request_id));
        if ($query && $ret = $query->row_array()) {
            $points = $ret['trial_work_bonus_point'];
        }
        return $points;
    }
    public function getMessageCampaignOwnerList() {
        $sql = "SELECT id, area, storename, url FROM admin_message_campaign WHERE display_flag = 1 ORDER BY id DESC";
        return $this->db->query($sql)->result_array();
    }

    public function messageCampaignAddOwner($data) {
        $ret = false;
        if ($data) {
            $this->db->insert('admin_message_campaign', $data);
            $ret = $this->db->affected_rows() > 0 ? true : false;
        }
        return $ret;
    }

    public function getMessageCampaignOwner($id) {
        $sql = "SELECT id, area, storename, url FROM admin_message_campaign WHERE display_flag = 1 AND id = ?";
        return $this->db->query($sql, array($id))->row_array();
    }

    public function messageCampaignUpdateOwner($data, $id) {
        $id = (int)$id;
        if ($id && $data) {
          $this->db->where('id', $id);
          $this->db->update('admin_message_campaign', $data);
        }
        return $this->db->affected_rows() > 0 ? true : false;
    }

    public function insertInterviewReport($interview_date,$unique_id) {
        $data = array (
                'interview_date'  => date('Y-m-d',strtotime($interview_date)),
                'user_unique_id'  => $unique_id
                );
        $this->db->insert('admin_interview_report',$data);
        return $this->db->affected_rows() > 0 ? true : false ;
    }

    public function getInterviewReport($from_owner = null) {
        $sql = "SELECT id,user_unique_id,interview_date,display_flag
                FROM admin_interview_report";
        if ($from_owner != null) {
            $sql .= " WHERE display_flag = 1 ";
        }
        $sql .= " ORDER BY id DESC
                LIMIT 10 ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function changeStatusReport($id, $display_flag) {
        $this->db->where('id', $id);
        $this->db->update('admin_interview_report', array('display_flag'=>$display_flag));
        return $this->db->affected_rows() > 0 ? true : false;
    }

    public function messageCampaignDeleteOwner($id) {
        $id = (int)$id;
        if ($id){
          $this->db->where('id', $id);
          $this->db->update('admin_message_campaign', array('display_flag' => 0));
        }
        return $this->db->affected_rows() > 0 ? true : false;
    }
}

?>

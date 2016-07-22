<?php
class Mcampaign_bonus_request extends CI_Model {

    function __construct() {
        // Call the Model constructor
        parent::__construct();
        $this->load->model('user/mcampaign');
        $this->common = new Common();
    }


    public function getRequestMasterCampaign($owner_id) {
        $ret = null;
        $sql  = "SELECT
            mc.visit_owner_office_date, mc.id, mc.status, mc.requested_date, us.unique_id, us.user_from_site, us.profile_pic,
            ifnull(us.bust, 0) bust, ifnull(us.waist, 0) waist, ifnull(us.hip, 0) hip,
            ma.name1 AS ageName1, ma.name2 AS ageName2,
            mth.name1 AS height_l, mth.name2 AS height_h
            FROM campaign_bonus_request_list mc
            LEFT JOIN users us ON mc.user_id = us.id
            LEFT JOIN user_recruits usr ON us.id = usr.user_id
            LEFT JOIN mst_ages ma ON usr.age_id = ma.id
            LEFT JOIN mst_height mth ON usr.height_id = mth.id
            LEFT JOIN owners ow ON mc.owner_id = ow.id
            WHERE mc.display_flag = 1 AND us.display_flag = 1
            AND ow.id = ? AND ow.display_flag = 1 AND mc.status = 0
            ORDER BY mc.id DESC";

        $data = array($owner_id);
        $result = $this->db->query($sql, $data);
        if ( $result ) {
            $ret = $result->result_array();
        }
        return $ret;
    }
    public function getMasterCampaignAll() {
        $ret = null;
        $sql = "SELECT * FROM campaign_bonus_request_list";
        $result = $this->db->query($sql);
        if ( $result ) {
            $ret = $result->result_array();
        }
        return $ret;
    }

    public function checkRequestTimes( $user_id, $campaign_id, $max_req_times ) {
        $ret = false;

        if ( !$user_id || !$campaign_id || !$max_req_times ) {
            return $ret;
        }

        $sql  = "SELECT IF(count(id) < ?, 1, 0) as valid_req_time_flg ";
        $sql .= "FROM campaign_bonus_request_list ";
        $sql .= "WHERE user_id = ? AND campaign_id = ? ";
        $sql .= "AND status not in (2, 4) AND display_flag = 1 ";

        $params = array($max_req_times, $user_id, $campaign_id);
        $query = $this->db->query( $sql, $params );
        if ( $query && $row = $query->row_array() ) {
            if ( $row['valid_req_time_flg'] == 1 ) {
                $ret = true;
            }
        }

        return $ret;
    }

    public function iSRequestingExpense( $user_id, $owner_id, $campaign_id = null ) {
        $ret = false;

        if ( !$user_id || !$owner_id ) {
            return $ret;
        }

        $params = array($user_id, $owner_id);

        $sql  = "SELECT id FROM campaign_bonus_request_list ";
        $sql .= "WHERE display_flag = 1 AND user_id = ? AND owner_id = ? ";
        if ( $campaign_id ) { // キャンペーン毎のチェックの場合
            $sql .= "AND campaign_id = ? ";
            $params[] = $campaign_id;
        }
        $sql .= "AND status not in (2, 4) ORDER BY id DESC ";
        $sql .= "LIMIT 1";

        $query = $this->db->query($sql, $params);
        if ( $query && $query->num_rows() > 0 ) {
            $ret = true;
        }

        return $ret;
    }

    public function isInBudget( $campaign_id, $travel_expense, $budget, $request_flg = false, $owner_id = null ) {
        $ret = false;

        if ( !$campaign_id || !$travel_expense | !$budget ) {
            return $ret;
        }

        if ($owner_id) {
            $sql = "SELECT id, trial_work_bonus_point FROM owners WHERE id = ? AND trial_work_bonus_point != 0";
            $query = $this->db->query( $sql, array($owner_id));
            if ($owner_travel_expense = $query->row_array()) {
                $travel_expense = $owner_travel_expense['trial_work_bonus_point'];
            }

        }

        if ( $request_flg ) {
            $sql  = "SELECT IF(((count(id) + 1) * ? ) <= ?, 1, 0) as in_budget_flg ";
        } else {
            $sql  = "SELECT IF((count(id) * ?) <= ?, 1, 0) as in_budget_flg ";
        }
        $sql .= "FROM campaign_bonus_request_list ";
        $sql .= "WHERE campaign_id = ? AND status not in (2, 4) AND display_flag = 1";

        $params = array( $travel_expense, $budget, $campaign_id );
        $result = $this->db->query( $sql, $params );

        if ( $result && $row = $result->row_array() ) {
            if ( $row['in_budget_flg'] == 1 ) {
                $ret = true;
            }
        }

        return $ret;
    }

    public function insertRequestCampaign($data) {
        $ret_array = array();
        if ($data) {
            $this->db->insert('campaign_bonus_request_list', $data);
            $insert = $this->db->affected_rows() > 0 ? true : false;

            if ( $insert ) {
                $ret_array = array("ret"=>true, "error_code" => 0); // 成功
                $this->common->sendTravelExpRequestNotifToOwner($data['owner_id']);
            } else {
                $ret_array = array("ret"=>false, "error_code" => 2); // データ挿入失敗
            }
        }
        return $ret_array;
    }

    public function canRequestCampaign($user_id, $owner_id , $campaignBonusRequest) {
        $ret = 0;
        if ( $campaignBonusRequest['multi_request_per_owner_flag'] ) {
            $flag = $this->iSRequestingExpense( $user_id, $owner_id, $campaignBonusRequest['id'] );
        } else {
            $flag = $this->iSRequestingExpense( $user_id, $owner_id );
        }
        if ( $flag ) {
            $ret = 3;
        } else {
            $flag = $this->isInBudget( $campaignBonusRequest['id'], $campaignBonusRequest['bonus_money'], $campaignBonusRequest['budget_money'], true, $owner_id );
            if ( $flag === false ) {
                $ret = 1;
            } else {
                $flag = $this->checkRequestTimes( $user_id, $campaignBonusRequest['id'], $campaignBonusRequest['max_request_times'] );
                if ( $flag == false ) {
                    $ret = 2;
                }
            }
        }

        return $ret;
    }

    public function updateBonusRequest($data, $id) {
        $this->db->where('id', $id);
        $this->db->update('campaign_bonus_request_list', $data);
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    public function getAllRequest( $req_per_page = 1, $start_offset = 0, $filter_status = "" ) {
        $all_request_data = null;
        if ( $req_per_page < 0 || $start_offset < 0 ) {
            return $all_request_data;
        }

        $sql  = "SELECT ";
        $sql .= "  tel.id as req_id, ";
        $sql .= "  tel.user_id as user_id, ";
        $sql .= "  us.user_from_site as u_from_site, ";
        $sql .= "  us.unique_id as u_unique_id, ";
        $sql .= "  us.name as u_name, ";
        $sql .= "  ow.unique_id as o_unique_id, ";
        $sql .= "  ow.storename as o_shop_name, ";
        $sql .= "  tel.requested_date as req_date, ";
        $sql .= "  tel.status as req_status ";
        $sql .= "FROM campaign_bonus_request_list tel ";
        $sql .= "INNER JOIN users us ON us.id = tel.user_id ";
        $sql .= "INNER JOIN owners ow ON ow.id = tel.owner_id ";
        $sql .= "WHERE tel.display_flag = 1 ";
        if ( $filter_status ) {
            if ( $filter_status == 1 /* 承認待ち */) {
                $sql .= "AND (tel.status = 0 OR tel.status = 1) ";
            } else {
                $sql .= "AND tel.status = ? ";
                $params[] = (int)$filter_status;
            }
        }
        $sql .= "ORDER BY tel.id DESC, tel.user_id ";
        $sql .= "LIMIT ? OFFSET ? ";
        $params[] = $req_per_page;
        $params[] = $start_offset;

        $query = $this->db->query( $sql, $params );
        if ( $query && $all_data = $query->result_array() ) {
            $all_request_data = $all_data;
        }

        return $all_request_data;
    }
    public function getAllRequestNo( $filter_status = "" ) {
        if ( $filter_status ) {
            if ( $filter_status == 1 /* 承認待ち */) {
                $add_where = "(status = 0 OR status = 1)";
                $this->db->where($add_where);
            } else {
                $this->db->where('status', (int)$filter_status);
            }
        }
        $this->db->where('display_flag', '1');
        return $this->db->count_all_results('campaign_bonus_request_list');
    }

     public function getCampaignIdFrmReqId( $req_id ) {
      $campaign_id = 0;

      if ( $req_id ) {
        $this->db->select('campaign_id');
        $this->db->where( 'id', $req_id );
        $query = $this->db->get('campaign_bonus_request_list');
        if ( $query && $data = $query->row_array() ) {
          $campaign_id = $data['campaign_id'];
        }
      }

      return $campaign_id;
    }

    public function getLatestCampaignBonusBanner() {
        $ret = null;

        $latest_campaign = $this->MCampaign->getLatestCampaignBonusRequest();
        if ( $latest_campaign ) {
            // キャンペーンの予算チェック
            $is_in_budget = $this->isInBudget(
                                $latest_campaign['id'],
                                $latest_campaign['bonus_money'],
                                $latest_campaign['budget_money']);
            if ( $is_in_budget ) {
                $ret = $latest_campaign;
            }
        }
        return $ret;
    }

    public function ckIfdecline($user_id, $owner_id , $campaign_id){
        $ret = false;
        $sql = "SELECT status FROM campaign_bonus_request_list
                WHERE display_flag = 1 AND user_id = ? AND owner_id = ? AND status = 4 LIMIT 1";
        $query = $this->db->query( $sql,array($user_id, $owner_id , $campaign_id));
        if ($result = $query->row_array()){
            $ret = true;
        }

        return $ret;
    }
}

?>

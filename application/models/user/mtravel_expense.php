<?php
class Mtravel_expense extends CI_Model {

    function __construct() {
        // Call the Model constructor
        parent::__construct();
        $this->load->model('user/mcampaign');
    }

    // 制限日数をチェックする（現在不要）
    // 引数：ユーザーID, 制限日数、キャンペーンID
    // 戻り値: TRUE: 申請可能、FALSE: 申請不可能
    public function checkAllowRequestSpan( $user_id, $ards, $campaign_id = null ) {
        $ret = false;

        if ( !$user_id || !$ards ) {
            return $ret;
        }

        $sql  = "SELECT IF(count(requested_date) > 0, ";
        $sql .= "          IF(DATE_ADD(requested_date, INTERVAL ? DAY) > NOW(), 0, 1), ";
        $sql .= "          1) as span_flag ";
        $sql .= "FROM travel_expense_list ";
        $sql .= "WHERE display_flag = 1 AND user_id = ? AND status NOT IN (2, 4) ";
        $params = array($ards, $user_id);
        if ( !$campaign_id ) {
            $sql .= "AND campaign_id = ? ";
            $params[] = $campaign_id;
        }
        $sql .= "ORDER BY id DESC LIMIT 1";

        $query = $this->db->query($sql, $params);
        if( $query  && $row = $query->row_array() ) {
            if ( $row['span_flag'] == 1 ) {
                $ret = true;
            }
        }

        return $ret;
    }

    // キャンペーン中の申請回数上限をチェックする
    public function checkRequestTimes( $user_id, $campaign_id, $max_req_times ) {
        $ret = false;

        if ( !$user_id || !$campaign_id || !$max_req_times ) {
            return $ret;
        }

        $sql  = "SELECT IF(count(id) < ?, 1, 0) as valid_req_time_flg ";
        $sql .= "FROM travel_expense_list ";
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

    // 交通費申請中かチェックする
    public function iSRequestingExpense( $user_id, $owner_id, $campaign_id = null ) {
        $ret = false;

        if ( !$user_id || !$owner_id ) {
            return $ret;
        }

        $params = array($user_id, $owner_id);

        $sql  = "SELECT id FROM travel_expense_list ";
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

    // キャンペーン予算を超えるかチェックする
    // request_flag: 今回の申請の金額を含めるフラグ（1: 含める, 0: 含めない)
    public function isInBudget( $campaign_id, $travel_expense, $budget, $request_flg = false ) {
        $ret = false;

        // パラメータチェック
        if ( !$campaign_id || !$travel_expense | !$budget ) {
            return $ret;
        }

        if ( $request_flg ) { // 今回の申請も含めて、予算を超えるかチェックする
            $sql  = "SELECT IF(((count(id) + 1) * ? ) <= ?, 1, 0) as in_budget_flg ";
        } else {
            $sql  = "SELECT IF((count(id) * ?) <= ?, 1, 0) as in_budget_flg ";
        }
        $sql .= "FROM travel_expense_list ";
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

    // 申請時、申請データを作る
    public function insertUserTravelExpense( $data ) {
        $this->db->insert('travel_expense_list', $data);
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    // ユーザーが交通費を申請する可能かどうかチェック
    // 戻り値: 0 申請可能
    //        1 予算オーバー
    //        2 上限回数オーバー
    //        3  申請済み
    public function canRequestTrvelExpense($user_id, $owner_id, $campaign_id,
                                           $travel_expense, $budget, $max_req_times,
                                           $multi_requests_flag) {
        $ret = 0; // 申請可能をデフォルトにする

        if ( $multi_requests_flag ) {
            $flag = $this->iSRequestingExpense( $user_id, $owner_id, $campaign_id );
        } else {
            $flag = $this->iSRequestingExpense( $user_id, $owner_id );
        }

        if ( $flag ) {
            $ret = 3; //申請済み
        } else {
            // 予算チェック
            $flag = $this->isInBudget( $campaign_id, $travel_expense, $budget, true );
            if ( $flag === false ) {
                $ret = 1; // 予算オーバー
            } else {
                // 制限回数をチェックする
                $flag = $this->checkRequestTimes( $user_id, $campaign_id, $max_req_times );
                if ( $flag == false ) {
                    $ret = 2; // 上限回数オーバー
                }
            }
        }

        return $ret;
    }

    // 交通費申請のデータを更新する
    public function updateTravelExpense($data, $id) {
        $this->db->where('id', $id);
        $this->db->update('travel_expense_list', $data);
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    // ページの交通費リクエスト取得
    public function getAllRequest( $req_per_page = 1, $start_offset = 0, $filter_status = "", $user_id = "") {
        $all_request_data = null;
        if ( $req_per_page < 0 || $start_offset < 0 ) {
            return $all_request_data;
        }
        $sql  = "SELECT ";
        $sql .= "  tel.id as req_id, ";
        $sql .= "  tel.user_id as user_id, ";
        $sql .= "  tel.owner_id as owner_id, ";
        $sql .= "  us.user_from_site as u_from_site, ";
        $sql .= "  us.unique_id as u_unique_id, ";
        $sql .= "  us.name as u_name, ";
        $sql .= "  ow.unique_id as o_unique_id, ";
        $sql .= "  ow.storename as o_shop_name, ";
        $sql .= "  tel.requested_date as req_date, ";
        $sql .= "  tel.status as req_status ";
        $sql .= "FROM travel_expense_list tel ";
        $sql .= "INNER JOIN users us ON us.id = tel.user_id ";
        $sql .= "INNER JOIN owners ow ON ow.id = tel.owner_id ";
        $sql .= "WHERE tel.display_flag = 1 ";
        if ($user_id) {
            $sql .= " AND us.id = ?";
            $params[] = $user_id;
        }
        if ($filter_status) {
            if ($filter_status == 1 /* 承認待ち */) {
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

    // すべての交通費リクエスト数を取得する
    // パラメータ
    // 0: 絞込みなし
    // 1: 店舗・管理者承認待ち
    // 2: 店舗不承認
    // 3: 承認済み
    // 4: 不承認
    public function getAllRequestNo($filter_status = "" , $user_id = "") {
    	if ($user_id) {
    		$this->db->where('user_id',$user_id);
    	}

        if ($filter_status) {
            if ($filter_status == 1 /* 承認待ち */) {
                $add_where = "(status = 0 OR status = 1)";
                $this->db->where($add_where);
            } else {
                $this->db->where('status', (int)$filter_status);
            }
        }
        $this->db->where('display_flag', '1');
        return $this->db->count_all_results('travel_expense_list');
    }

    // ある申請からキャンペーンＩＤを取得する
    public function getCampaignIdFrmReqId( $req_id ) {
      $campaign_id = 0;

      if ( $req_id ) {
        $this->db->select('campaign_id');
        $this->db->where( 'id', $req_id );
        $query = $this->db->get('travel_expense_list');
        if ( $query && $data = $query->row_array() ) {
          $campaign_id = $data['campaign_id'];
        }
      }

      return $campaign_id;
    }
}

?>

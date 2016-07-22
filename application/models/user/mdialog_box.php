<?php

class Mdialog_box extends CI_Model {
  public function __construct() {
      parent::__construct();
  }
  
  public function save_dialog($data) {
    return $this->db->insert('dialog_box',$data);
  }

  public function get_all_dialog() {
    $sql = "SELECT *
          FROM dialog_box
          WHERE display_flag = 1
          ORDER BY priority ASC";
    $query = $this->db->query($sql);
    return $query->result_array();
  }

  public function count_all_dialog() {
    $sql = "SELECT COUNT(1) as count
          FROM dialog_box
          WHERE display_flag = 1";
    $query = $this->db->query($sql);
    return $query->row_array();
  }

  public function check_priority($priority_number,$dialog_id = null) {
    $params = array($priority_number);
    $sql = "SELECT dlb.priority
        FROM dialog_box dlb
        WHERE dlb.priority = ? AND dlb.display_flag = 1 ";
    if($dialog_id != null) {
      $sql .= "AND dlb.id <> ? ";
      array_push($params, $dialog_id);
    }

    $query = $this->db->query($sql,$params);
    return $query->row_array();
  }

  public function delete_dialog($id) {
    $this->db->where('id',$id);
    $this->db->update('dialog_box',array('display_flag'=>0));
    if($this->db->affected_rows() > 0) {
      return true;
    }
    return false;
  }

  public function update_dialog($data,$id) {
    $this->db->where('id',$id);
    $this->db->update('dialog_box',$data);
    if($this->db->affected_rows() > 0) {
      return true;
    }
    return false;
  }

  public function get_dialog_detail($id) {
    $sql = "SELECT *
          FROM dialog_box
          WHERE display_flag = 1 AND id = ?";
    $query = $this->db->query($sql,$id);
    return $query->row_array();
  }



  public function get_user_data($user_id) {
    $sql ="SELECT u.received_bonus_datetime,u.last_visit_date,u.user_from_site,u.received_bonus_flag,u.user_status,
          CASE WHEN smb.bonus_money IS NULL THEN 0 ELSE smb.bonus_money END as bonus_money
          FROM users u
          LEFT JOIN scout_mail_bonus smb ON u.id = smb.user_id
          WHERE u.id = ?";
    $query = $this->db->query($sql,$user_id);
    return $query->row_array();
  }

  public function show_dialog_box($user_data) {
    $bonus_money = $user_data['bonus_money'];
    $last_visit_date = date('Y-m-d' ,strtotime($user_data['last_visit_date']));
    $auth_date = ($user_data['received_bonus_datetime'] != NULL) ?date('Y-m-d',strtotime($user_data['received_bonus_datetime'])) : NULL;
    $bonus_grant = $user_data['received_bonus_flag'];
    $status_registration = $user_data['user_status'];
    $first_login_flag = ($user_data['last_visit_date'] == NULL) ? 1 : 0;
    $params = array(
          $bonus_money , $bonus_money,
          $bonus_grant, $status_registration , $first_login_flag
    );
    $sql = "SELECT *
          FROM dialog_box
          WHERE ( ? >= minimum_bonus_money AND ? <= maximum_bonus_money) 
          AND bonus_grant = ? AND status_registration = ? AND first_login_flag = ? AND display_flag = 1 ";
   
    if($auth_date != NULL) {
      $sql .= " AND (start_date_auth IS NULL OR ? >= start_date_auth ) AND (end_date_auth IS NULL OR ? <= end_date_auth )  ";
      array_push($params, $auth_date,$auth_date);
      
    } 
    if ($last_visit_date != NULL) {
      $sql .= " AND (start_date_last_visit IS NULL OR ? >= start_date_last_visit ) AND (end_date_last_visit IS NULL OR ? <= end_date_last_visit ) ";
      array_push($params,$last_visit_date , $last_visit_date);
    }
    
    switch ($user_data['user_from_site']) {
      case 1:
        $sql .= " AND user_from_machemoba = 1 ";
        break;
      case 2:
        $sql .= " AND user_from_makia = 1 ";
        break;
      default:
        $sql .= " AND user_from_site = 1 ";
        break;
    }
    $sql .= " ORDER BY priority ASC";
    
    $query = $this->db->query($sql,$params);
    return $query->row_array();
  }

  public function delete_image($id,$image_id) {
    $this->db->where('id',$id);
    $this->db->update('dialog_box',array('image_'.$image_id=>NULL));
    if($this->db->affected_rows() > 0) {
      return true;
    }
    return false;
  }

  public function check_images($id) {
    $sql = "SELECT COUNT(1) as count FROM dialog_box WHERE (image_1 && image_2 && image_3 && image_4 && image_5) IS NULL AND id = ?";
    $query = $this->db->query($sql,$id);
    $row = $query->row_array();
    return $row['count'];
  }

  
}
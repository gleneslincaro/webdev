<?php
class Mutility extends CI_Model{
    public function __construct() {
        parent::__construct();
    }
    public function searchUserToAddPoints($unique_id,$email){
        $condition='';
        $param = array();
        if ($unique_id!=null&&$email==null) {
            $condition = " unique_id LIKE ? ";
            $param = array("%$unique_id%");
        } elseif($unique_id==null&&$email!=null) {
            $condition = " email_address LIKE ? ";
            $param = array("%$email%");
        } else {
            $condition = " unique_id LIKE ? AND email_address LIKE ?";
            $param = array("%$unique_id%","%$email%");
        }
        $sql = "SELECT id,unique_id,email_address FROM users WHERE $condition";
        $query = $this->db->query($sql,$param);
        $ret = $query->result_array();
        return $ret;
    }
    public function historyLog($params,$dateFrom=null,$dateTo=null,$limit=0,$offset=0){
        if (!$params || !$params['reason']) {
            return null;
        }
        $param = array('%'.$params['reason'].'%');
        $sql = 'SELECT u.unique_id, smbl.id,smbl.user_id,smbl.bonus_money as new_bonus_money,smbl.reason,smbl.created_date
                FROM scout_mail_bonus_log smbl
                INNER JOIN users u ON smbl.user_id = u.id
                WHERE smbl.reason LIKE ? ';
        if ($params['email']!=null&&$params['unique_id']!=null) {
            $sql .= ' AND u.email_address LIKE ? AND u.unique_id LIKE ?';
            $param[] = '%'.$params['email'].'%';
            $param[] = '%'.$params['unique_id'].'%';
        } elseif($params['email']!=null) {
            $sql .= ' AND u.email_address LIKE ?';
            $param[] = '%'.$params['email'].'%';
        } elseif($params['unique_id']!=null) {
            $sql .= ' AND u.unique_id LIKE ? ';
            $param[] = '%'.$params['unique_id'].'%';
        }
        if ($dateFrom!=null&&$dateTo!=null) {
            $sql  .= ' AND DATE(smbl.created_date) BETWEEN ? AND ? ';
            $param[] = $dateFrom;
            $param[] = $dateTo;
        } elseif($dateFrom!=null && $dateTo==null) {
            $sql .= ' AND DATE(smbl.created_date) >= ? ';
            $param[] = $dateFrom;
        } elseif($dateFrom==null && $dateTo!=null) {
            $sql .= ' AND DATE(smbl.created_date) <= ? ';
            $param[] = $dateTo;
        }
        if($offset > 0 || $limit > 0){
            $sql .= ' LIMIT '.$limit.' OFFSET '.$offset;
        }
        $query = $this->db->query($sql,$param);
        $ret = $query->result_array();
        return $ret;
    }
}

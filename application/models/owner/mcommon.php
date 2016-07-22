<?php

class Mcommon extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    /**
     * author: [IVS] Nguyen Bao Trieu
     * name : getMapTemplate
     * todo : get Map Template
     * @param string $group_type
     * @return data
     */
    public function getMapTemplate($group_type = null) {
        if($group_type == 'us15')
          $group_type = 'us04';
        elseif($group_type == 'ow24')
          $group_type = 'ow07';
        elseif($group_type == 'ow23')
          $group_type = 'ow04';
        elseif($group_type == 'us14')
          $group_type = 'us03';
		$sql = "SELECT * FROM `mst_variable_list` WHERE `display_flag` = 1 AND  group_type = ? ";
        $query = $this->db->query($sql, array($group_type));
        return $query->result_array();
    }

    /**
     * author: [IVS] Nguyen Bao Trieu
     * name : getTemplate
     * todo : get template
     * @param int $ownerId
     * @return data
     */
    public function getTemplate($template_type = null) {
        $sql = 'SELECT * FROM mst_templates WHERE display_flag = 1 and template_type  = ? ';
        $query = $this->db->query($sql, array($template_type));
        return $query->row_array();
    }

    /**
     * author: [IVS] Nguyen Bao Trieu
     * name : ow01
     * todo : get owner
     * @param int $loginId
     * @return null
     */
    public function ow01($userId = null, $loginId = null) {
        $sql = "SELECT ow.id, ow.storename, ow.email_address, ow.password, ow.address,
                ors.apply_tel AS tel, ow.bank_name, ow.branch_name, ow.account_type, ow.account_no,
                ow.account_name, pm.amount, pm.point, pm.created_date as date_payment,
                mpm.name AS payment_case, ow.total_point as total_point_ap, pm.amount_payment, pm.point_payment,
                ow.total_point + SUM(t.point) AS total_point_bp, pm.amount AS amount1, ors.scout_pr_text,
                pm.payment_name, pm.tranfer_date as transfer_date, mhm.user_happy_money, mhm.joyspe_happy_money,
                up.`request_money_date`, u.unique_id, mcu.name AS user_city, COUNT(t.id) AS scout_number,
                ors.home_page_url, mcg.`name` AS `owner_city_group`, mc.name AS owner_city,
                mt.`name` AS owner_town, ors.how_to_access, ors.salary, concat(ma.name1, ' ~ ', ma.name2) AS age,
                concat(mh.name1, ' ~ ', mh.name2) AS height, u.bust, u.waist, u.hip

                FROM owners ow
                LEFT JOIN owner_recruits ors ON ow.id = ors.owner_id
                LEFT JOIN payments pm ON ow.id = pm.owner_id
                LEFT JOIN transactions t ON ow.id = t.owner_id
                LEFT JOIN mst_payment_methods mpm ON pm.payment_method_id = mpm.id
                LEFT JOIN mst_happy_moneys mhm ON ors.happy_money_id = mhm.id
                LEFT JOIN list_user_messages l ON ors.id = l.owner_recruit_id
                LEFT JOIN users u ON l.user_id = u.id
                LEFT JOIN user_recruits urs ON u.id = urs.user_id
                LEFT JOIN `user_payments` up ON ors.id = up.owner_recruit_id
                LEFT JOIN mst_ages ma ON urs.age_id = ma.id
                LEFT JOIN mst_height mh ON urs.height_id = mh.id
                LEFT JOIN mst_cities mcu ON urs.city_id = mcu.id
                LEFT JOIN mst_cities mc ON ors.city_id = mc.id
                LEFT JOIN mst_city_groups mcg ON mc.city_group_id = mcg.id
                LEFT JOIN mst_towns mt ON ors.town_id = mt.id
                WHERE ow.display_flag = 1 AND ow.id = ?";
        $query = $this->db->query($sql, array($loginId));
        return $query->row_array();


    }

		public function ow0101($userId = null, $loginId = null) {
        $sql = "SELECT ow.id, ow.storename, ow.email_address, ow.password, ow.address,
                ors.apply_tel AS tel, ow.bank_name, ow.branch_name, ow.account_type, ow.account_no,
                ow.account_name, pm.amount, pm.point, pm.created_date as date_payment,
                mpm.name AS payment_case, ow.total_point as total_point_ap, pm.amount_payment, pm.point_payment,
                ow.total_point + SUM(t.point) AS total_point_bp, pm.amount AS amount1, ors.scout_pr_text,
                pm.payment_name, pm.tranfer_date as transfer_date, mhm.user_happy_money, mhm.joyspe_happy_money,
                up.`request_money_date`, u.unique_id, mcu.name AS user_city, COUNT(t.id) AS scout_number,
                ors.home_page_url, mcg.`name` AS `owner_city_group`, mc.name AS owner_city,
                mt.`name` AS owner_town, ors.how_to_access, ors.salary, concat(ma.name1, ' ~ ', ma.name2) AS age,
                concat(mh.name1, ' ~ ', mh.name2) AS height, u.bust, u.waist, u.hip

                FROM owners ow
                LEFT JOIN owner_recruits ors ON ow.id = ors.owner_id
                LEFT JOIN payments pm ON ow.id = pm.owner_id
                LEFT JOIN transactions t ON ow.id = t.owner_id
                LEFT JOIN mst_payment_methods mpm ON pm.payment_method_id = mpm.id
                LEFT JOIN mst_happy_moneys mhm ON ors.happy_money_id = mhm.id
                LEFT JOIN list_user_messages l ON ors.id = l.owner_recruit_id
                LEFT JOIN users u ON l.user_id = u.id
                LEFT JOIN user_recruits urs ON u.id = urs.user_id
                LEFT JOIN `user_payments` up ON ors.id = up.owner_recruit_id
                LEFT JOIN mst_ages ma ON urs.age_id = ma.id
                LEFT JOIN mst_height mh ON urs.height_id = mh.id
                LEFT JOIN mst_cities mcu ON urs.city_id = mcu.id
                LEFT JOIN mst_cities mc ON ors.city_id = mc.id
                LEFT JOIN mst_city_groups mcg ON mc.city_group_id = mcg.id
                LEFT JOIN mst_towns mt ON ors.town_id = mt.id
                WHERE ow.display_flag = 1 AND ow.id = ? AND ors.display_flag = 1";
        $query = $this->db->query($sql, array($loginId));
        return $query->row_array();


    }

    /**
     * author: [IVS] Lam Tu My Kieu
     * name : us06
     * todo : get user
     * @param int $loginId
     * @return null
     */
    public function us06($userId = null, $ownerId = null) {
        $sql = 'SELECT u.name as username,
              u.email_address,
              o.storename,
             `user_happy_money`,
              mc.name AS owner_city
            FROM users u
            INNER JOIN user_recruits ur ON u.id = ur.user_id
            INNER JOIN user_payments up ON up.user_id = u.id
            INNER JOIN owner_recruits orr ON up.owner_recruit_id = orr.id
            INNER JOIN owners o ON o.id = orr.owner_id
            INNER JOIN mst_happy_moneys h ON h.`id` = orr.happy_money_id
            INNER JOIN mst_cities mc ON mc.`id`=orr.`city_id`
            WHERE o.display_flag = 1 AND u.display_flag = 1  AND o.id = ? AND u.id = ?
            ';

        $query = $this->db->query($sql, array($ownerId, $userId));
        return $query->row_array();
    }

    /**
     * author: [IVS] Lam Tu My Kieu
     * name : us05
     * todo : get user
     * @param int $loginId
     * @return null
     */
    public function us05($userId = null, $ownerId = null) {
        $sql = '';
        $sql = 'SELECT u.name as username,
              u.email_address,
              o.storename
            FROM users u
            INNER JOIN user_recruits ur ON u.id = ur.user_id
            INNER JOIN user_payments up ON up.user_id = u.id
            INNER JOIN owner_recruits orr ON up.owner_recruit_id = orr.id
            INNER JOIN owners o ON o.id = orr.owner_id


            WHERE o.display_flag = 1 AND u.display_flag = 1 AND o.id = ? AND u.id = ?';
        $query = $this->db->query($sql, array($ownerId, $userId));

        return $query->row_array();
    }

    /**
     * author: [IVS] Lam Tu My Kieu
     * name : us03
     * todo : get user
     * @param int $userId, $ownerId
     * @return null
     */
    public function us03($userId = null, $ownerId = null) {
          $sql = "SELECT	u.email_address AS email_address, u.password, o.storename, o.address, orr.apply_tel AS tel,
                  h.user_happy_money, up.request_money_date, u.unique_id, u.name AS username, orr.home_page_url,
                  o.email_address AS owner_email_address, mcg.name AS owner_city_group, o.unique_id AS owner_unique_id,
                  mc.name AS owner_city, mt.`name` AS owner_town, orr.how_to_access, orr.salary, u.old_id AS login_id,
                  orr.id AS owner_recrt_id,
                  IFNULL(IFNULL(ospt.pr_text, orr.scout_pr_text), '') as scout_pr_text

                  FROM users u
                  LEFT JOIN list_user_messages l ON u.id = l.user_id
                  LEFT JOIN owner_scout_pr_text ospt ON ospt.id = l.owner_scout_mail_pr_id
                  LEFT JOIN owner_recruits orr ON l.owner_recruit_id = orr.id
                  LEFT JOIN owners o ON orr.owner_id = o.id
                  LEFT JOIN mst_happy_moneys h ON orr.happy_money_id = h.id
                  LEFT JOIN mst_cities mc ON orr.city_id = mc.id
                  LEFT JOIN mst_city_groups mcg ON mc.city_group_id = mcg.id
                  LEFT JOIN mst_towns mt ON orr.town_id = mt.id
                  LEFT JOIN user_payments up ON orr.id = up.owner_recruit_id
                  WHERE o.display_flag = 1 AND u.display_flag = 1 AND orr.display_flag = 1 AND orr.recruit_status = 2 AND o.id = ?
                  AND u.id = ? AND l.template_id = 25";
          $query = $this->db->query($sql, array($ownerId, $userId));

        return $query->row_array();
    }

    public function us0301($userId, $ownerId, $ownerRecruitId, $scout_mail_id = null) {
      if ( !$userId || !$ownerId || !$ownerRecruitId) {
        return null;
      }
      $sql = "SELECT	u.email_address AS email_address, u.password, o.storename, o.address, orr.apply_tel AS tel,
              h.user_happy_money, up.request_money_date, u.unique_id, u.name AS username, orr.home_page_url,
              o.email_address AS owner_email_address, mcg.name AS owner_city_group, o.unique_id AS owner_unique_id,
              mc.name AS owner_city, mt.`name` AS owner_town, orr.how_to_access, orr.salary, u.old_id AS login_id,
              orr.id AS owner_recrt_id,
              IFNULL(IFNULL(ospt.pr_text, orr.scout_pr_text), '') as scout_pr_text

              FROM users u
              LEFT JOIN list_user_messages l ON u.id = l.user_id
              LEFT JOIN owner_recruits orr ON l.owner_recruit_id = orr.id
              LEFT JOIN owners o ON orr.owner_id = o.id
              LEFT JOIN mst_happy_moneys h ON orr.happy_money_id = h.id
              LEFT JOIN mst_cities mc ON orr.city_id = mc.id
              LEFT JOIN mst_city_groups mcg ON mc.city_group_id = mcg.id
              LEFT JOIN mst_towns mt ON orr.town_id = mt.id
              LEFT JOIN user_payments up ON orr.id = up.owner_recruit_id
              LEFT JOIN owner_scout_pr_text ospt on (l.owner_scout_mail_pr_id = ospt.id and ospt.owner_id = o.id)
              WHERE o.display_flag = 1 AND u.display_flag = 1 AND o.id = ?
              AND u.id = ? AND l.template_id = 25 and orr.id = ? ";
      $params = array($ownerId, $userId, $ownerRecruitId);
      if ( $scout_mail_id ) {
        $sql .= " and l.id = ? ";
        $params[] = $scout_mail_id;
      }
      $sql .= " LIMIT 1";
      $query = $this->db->query( $sql, $params );

      return $query->row_array();
    }

    /**
     * author: [IVS] Lam Tu My Kieu
     * name : ow04
     * todo : scout again
     * @param int $userId, $ownerId
     * @return null
     */
    public function ow04($userId = null, $ownerId = null) {
        if ($userId != NULL) {

            $sql = "SELECT ow.id, ow.storename, ow.email_address, ow.password, ow.address,
                    ors.apply_tel AS tel, ow.bank_name, ow.branch_name, ow.account_type, ow.account_no,
                    ow.account_name, pm.amount, pm.point, pm.created_date AS date_payment,
                    mpm.name AS payment_case, ow.total_point AS total_point_ap, pm.amount_payment, pm.point_payment,
                    ow.total_point + SUM(t.point) AS total_point_bp, pm.amount AS amount1,
                    pm.payment_name, pm.tranfer_date AS transfer_date, mhm.user_happy_money, mhm.joyspe_happy_money,
                    up.`request_money_date`, COUNT(t.id) AS scout_number,
                    ors.home_page_url, mcg.`name` AS `owner_city_group`, mc.name AS owner_city,
                    mt.`name` AS owner_town, ors.how_to_access, ors.salary

                    FROM users  u
                    LEFT JOIN user_recruits ur ON u.id = ur.user_id
                    LEFT JOIN mst_ages ma ON ur.age_id = ma.id
                    LEFT JOIN mst_height mh ON ur.height_id = mh.id
                    LEFT JOIN list_user_messages l ON u.id = l.user_id
                    LEFT JOIN owner_recruits ors ON l.owner_recruit_id = ors.id
                    LEFT JOIN owners ow ON ors.owner_id = ow.id
                    LEFT JOIN `user_payments` up ON ors.id = up.owner_recruit_id
                    LEFT JOIN payments pm ON ow.id = pm.owner_id
                    LEFT JOIN transactions t ON ow.id = t.owner_id
                    LEFT JOIN mst_payment_methods mpm ON pm.payment_method_id = mpm.id
                    LEFT JOIN mst_happy_moneys mhm ON ors.happy_money_id = mhm.id
                    LEFT JOIN mst_cities mc ON ors.city_id = mc.id
                    LEFT JOIN mst_cities mcu ON ur.city_id = mcu.id
                    LEFT JOIN mst_city_groups mcg ON mc.city_group_id = mcg.id
                    LEFT JOIN mst_towns mt ON ors.town_id = mt.id
                    WHERE ow.display_flag = 1 AND u.display_flag = 1 AND ors.`display_flag`=1 AND ow.id = ? AND u.id = ?";
            $query = $this->db->query($sql, array($ownerId, $userId));
            return $query->row_array();
        } else {
            $sql = "SELECT ow.id, ow.storename, ow.email_address, ow.password, ow.address,
                ors.apply_tel AS tel, ow.bank_name, ow.branch_name, ow.account_type, ow.account_no,
                ow.account_name, pm.amount, pm.point, pm.created_date AS date_payment,
                mpm.name AS payment_case, ow.total_point AS total_point_ap, pm.amount_payment, pm.point_payment,
                ow.total_point + SUM(t.point) AS total_point_bp, pm.amount AS amount1,
                pm.payment_name, pm.tranfer_date AS transfer_date, mhm.user_happy_money, mhm.joyspe_happy_money,
                up.`request_money_date`, COUNT(t.id) AS scout_number,
                ors.home_page_url, mcg.`name` AS `owner_city_group`, mc.name AS owner_city,
                mt.`name` AS owner_town, ors.how_to_access, ors.salary

                FROM owners ow
                LEFT JOIN owner_recruits ors ON ow.id = ors.owner_id
                LEFT JOIN payments pm ON ow.id = pm.owner_id
                LEFT JOIN transactions t ON ow.id = t.owner_id
                LEFT JOIN mst_payment_methods mpm ON pm.payment_method_id = mpm.id
                LEFT JOIN mst_happy_moneys mhm ON ors.happy_money_id = mhm.id
                LEFT JOIN list_user_messages l ON ors.id = l.owner_recruit_id
                LEFT JOIN users u ON l.user_id = u.id
                LEFT JOIN user_recruits urs ON u.id = urs.user_id
                LEFT JOIN `user_payments` up ON ors.id = up.owner_recruit_id
                LEFT JOIN mst_ages ma ON urs.age_id = ma.id
                LEFT JOIN mst_height mh ON urs.height_id = mh.id
                LEFT JOIN mst_cities mcu ON urs.city_id = mcu.id
                LEFT JOIN mst_cities mc ON ors.city_id = mc.id
                LEFT JOIN mst_city_groups mcg ON mc.city_group_id = mcg.id
                LEFT JOIN mst_towns mt ON ors.town_id = mt.id
                WHERE ow.`id` = ? AND ors.`display_flag`=1
                GROUP BY ow.`id` ";
            $query = $this->db->query($sql, array($ownerId));
            return $query->row_array();
        }
    }

    /**
     * author: [IVS] Phan Ngoc Minh Luan
     * name : ow05
     * todo : payment scout point
     * @param int $userId, $ownerId
     * @return null
     */
    public function ow05($userId = null, $ownerId = null) {
//        $sql = "SELECT
//  owners.storename,
//  owners.email_address,
//  SUM(`transactions`.`amount`) AS amount_payment,
//  SUM(`transactions`.`point`) AS point_payment,
//  `transactions`.`created_date` AS date_payment,
//  CASE
//    1
//    WHEN 1
//    THEN 'ポイント'
//  END AS payment_case,
//  owners.`total_point`,
//  owners.`total_point` + SUM(`transactions`.`point`) AS before_point
//
//FROM
//  users
//  INNER JOIN user_recruits
//    ON users.id = user_recruits.user_id
//  INNER JOIN `list_user_messages`
//    ON list_user_messages.`user_id` = users.id
//  INNER JOIN `transactions`
//    ON `transactions`.`reference_id` = `list_user_messages`.`id`
//  INNER JOIN owner_recruits
//    ON list_user_messages.owner_recruit_id = owner_recruits.id
//  INNER JOIN owners
//    ON owners.id = owner_recruits.owner_id
//  INNER JOIN mst_happy_moneys
//    ON mst_happy_moneys.`id` = owner_recruits.`happy_money_id`
//WHERE owners.display_flag = 1
//  AND users.display_flag = 1
//  AND `transactions`.`payment_case_id`=1
//  AND list_user_messages.display_flag = 1
//  AND owners.id = ?
//   GROUP BY owners.`id` ";
        $sql = "SELECT DISTINCT
   owners.`storename`,
   owners.storename,
   owners.email_address,
   transactions.`created_date` AS date_payment,
   owners.`total_point`,


 ( SELECT SUM(transactions.`amount`) FROM transactions WHERE

transactions.`created_date` = (SELECT MAX(`created_date`) phuong FROM transactions WHERE
 transactions.`payment_case_id` = 1 AND
`display_flag` = 1 AND owner_id = ? )) AS point_payment,

( SELECT SUM(transactions.`point`) FROM transactions WHERE

transactions.`created_date` = (SELECT MAX(`created_date`) phuong FROM transactions WHERE
transactions.`payment_case_id` = 1 AND
`display_flag` = 1 AND owner_id = ? )) AS  amount_payment,
(( SELECT SUM(transactions.`amount`) FROM transactions WHERE

transactions.`created_date` = (SELECT MAX(`created_date`) phuong FROM transactions WHERE
 transactions.`payment_case_id` = 1 AND
`display_flag` = 1 AND owner_id = ? )) +  owners.`total_point`) AS before_point

FROM
 `transactions`
 INNER JOIN owners ON owners.id = transactions.`owner_id`
 INNER JOIN `owner_recruits` ON `owner_recruits` . `owner_id` = `owners`.`id`
 INNER JOIN `mst_happy_moneys` ON `mst_happy_moneys`.id = `owner_recruits`.`happy_money_id`

WHERE
  `transactions`.`payment_case_id`=1
  AND transactions.owner_id = ?
  AND transactions.`created_date` = (SELECT MAX(`created_date`) phuong FROM transactions WHERE
   transactions.`payment_case_id` = 1 AND
`display_flag` = 1 AND owner_id = ? )";
        $query = $this->db->query($sql, array($ownerId, $ownerId, $ownerId, $ownerId, $ownerId ));
        return $query->row_array();
    }

    /**
     * author: [IVS] Phan Ngoc Minh Luan
     * name : ow08
     * todo : payment app_conf point
     * @param int $userId, $ownerId
     * @return null
     */
    public function ow08($userId = null, $ownerId = null) {
        $sql = "SELECT
  owners.storename,
  owners.email_address,
  SUM(`transactions`.`amount`) AS amount_payment,
  SUM(`transactions`.`point`) AS point_payment,
  `transactions`.`created_date` AS date_payment,
  COUNT(`transactions`.`id`) AS number_info_user,
  CASE
    1
    WHEN 1
    THEN 'ポイント'
  END AS payment_case,
  owners.`total_point`,
  owners.`total_point` + SUM(`transactions`.`point`) AS before_point
FROM
  users
  INNER JOIN user_recruits
    ON users.id = user_recruits.user_id
  INNER JOIN `user_payments`
    ON user_payments.`user_id` = users.id
  INNER JOIN `transactions`
    ON `transactions`.`reference_id` = `user_payments`.`id`
  INNER JOIN owner_recruits
    ON user_payments.owner_recruit_id = owner_recruits.id
  INNER JOIN owners
    ON owners.id = owner_recruits.owner_id
  INNER JOIN mst_happy_moneys
    ON mst_happy_moneys.`id` = owner_recruits.`happy_money_id`
WHERE owners.display_flag = 1
  AND users.display_flag = 1
  AND `user_payment_status` = 0
  AND user_payments.display_flag = 1
  AND `transactions`.`payment_case_id`=2
  AND transactions.owner_id = ?
GROUP BY owners.`id` ";
        $query = $this->db->query($sql, array($ownerId));
        return $query->row_array();
    }

    /**
     * author: [IVS] Lam Tu My Kieu
     * name : ow10 (Tu choi tuyen dung)
     * todo : deny for apply
     * @param int $userId = null, $ownerId = null
     * @return data
     */
    public function ow10($userId = null, $ownerId = null) {
        $sql = 'SELECT o.`storename`, o.email_address
            FROM users u
            INNER JOIN user_recruits ur ON u.id = ur.user_id
            INNER JOIN user_payments up ON up.`user_id` = u.id
            INNER JOIN owner_recruits orr ON up.owner_recruit_id = orr.id
            INNER JOIN owners o ON o.id = orr.owner_id

            WHERE o.display_flag = 1 AND u.id = ?
             AND o.id = ?';
        $query = $this->db->query($sql, array($userId, $ownerId));
        return $query->row_array();
    }

    /**
     * author: [IVS] Lam Tu My Kieu
     * name : ow11
     * todo : reply for apply
     * @param int $userId = null, $ownerId = null
     * @return data
     */
    public function ow11($userId = null, $ownerId = null) {
        $sql = 'SELECT  o.`storename`, o.email_address
            FROM users u
            INNER JOIN user_recruits ur ON u.id = ur.user_id
            INNER JOIN user_payments up ON up.`user_id` = u.id
            INNER JOIN owner_recruits orr ON up.owner_recruit_id = orr.id
            INNER JOIN owners o ON o.id = orr.owner_id

            WHERE o.display_flag = 1 AND u.display_flag = 1 AND u.id = ?
             AND o.id = ?';
        $query = $this->db->query($sql, array($userId, $ownerId));
        return $query->row_array();
    }

    /**
     * author: [IVS] Phan Ngoc Minh Luan
     * name : ow15
     * todo : refuse recruit money
     * @param int $userId, $ownerId
     * @return null
     */
    public function ow15($userId = null, $ownerId = null) {
        $sql = "SELECT ow.id, ow.storename, ow.email_address, ow.password, ow.address,
                ors.apply_tel AS tel, ow.bank_name, ow.branch_name, ow.account_type, ow.account_no,
                ow.account_name, pm.amount, pm.point, pm.created_date AS date_payment,
                mpm.name AS payment_case, ow.total_point AS total_point_ap, pm.amount_payment, pm.point_payment,
                ow.total_point + SUM(t.point) AS total_point_bp, pm.amount AS amount1,
                pm.payment_name, pm.tranfer_date AS transfer_date, mhm.user_happy_money, mhm.joyspe_happy_money,
                up.`request_money_date`, u.unique_id, mcu.name AS user_city, COUNT(t.id) AS scout_number,
                ors.home_page_url, mcg.`name` AS `owner_city_group`, mc.name AS owner_city,
                mt.`name` AS owner_town, ors.how_to_access, ors.salary, CONCAT(ma.name1, ' ~ ', ma.name2) AS age,
                CONCAT(mh.name1, ' ~ ', mh.name2) AS height, u.bust, u.waist, u.  hip

                FROM owners ow
                LEFT JOIN owner_recruits ors ON ow.id = ors.owner_id
                LEFT JOIN payments pm ON ow.id = pm.owner_id
                LEFT JOIN transactions t ON ow.id = t.owner_id
                LEFT JOIN mst_payment_methods mpm ON pm.payment_method_id = mpm.id
                LEFT JOIN mst_happy_moneys mhm ON ors.happy_money_id = mhm.id
                LEFT JOIN list_user_messages l ON ors.id = l.owner_recruit_id
                LEFT JOIN users u ON l.user_id = u.id
                LEFT JOIN user_recruits urs ON u.id = urs.user_id
                LEFT JOIN `user_payments` up ON ors.id = up.owner_recruit_id
                LEFT JOIN mst_ages ma ON urs.age_id = ma.id
                LEFT JOIN mst_height mh ON urs.height_id = mh.id
                LEFT JOIN mst_cities mcu ON urs.city_id = mcu.id
                LEFT JOIN mst_cities mc ON ors.city_id = mc.id
                LEFT JOIN mst_city_groups mcg ON mc.city_group_id = mcg.id
                LEFT JOIN mst_towns mt ON ors.town_id = mt.id

                WHERE ow.`id` = ?
                AND up.`user_payment_status` = 7
                GROUP BY ow.`id` ";
        $query = $this->db->query($sql, array($ownerId));
        return $query->row_array();
    }

    /**
     * author: [IVS] Phan Ngoc Minh Luan
     * name : ow17
     * todo : inform ending tranfer payment
     * @param int $userId, $ownerId
     * @return null
     */
    public function ow17($userId = null, $ownerId = null) {
        $sql = "SELECT ow.id, ow.storename, ow.email_address, ow.password, ow.address,
                ors.apply_tel AS tel, ow.bank_name, ow.branch_name, ow.account_type, ow.account_no,
                ow.account_name, pm.amount, pm.point, pm.created_date AS date_payment,
                mpm.name AS payment_case, ow.total_point AS total_point_ap, pm.amount_payment, pm.point_payment,
                ow.total_point + SUM(t.point) AS total_point_bp, pm.amount AS amount1,
                pm.payment_name, pm.tranfer_date AS transfer_date, mhm.user_happy_money, mhm.joyspe_happy_money,
                up.`request_money_date`, u.unique_id, mcu.name AS user_city, COUNT(t.id) AS scout_number,
                ors.home_page_url, mcg.`name` AS `owner_city_group`, mc.name AS owner_city,
                mt.`name` AS owner_town, ors.how_to_access, ors.salary, CONCAT(ma.name1, ' ~ ', ma.name2) AS age,
                CONCAT(mh.name1, ' ~ ', mh.name2) AS height, u.bust, u.waist, u.  hip


                FROM payments pm
                LEFT JOIN owners ow ON pm.owner_id = ow.id
                LEFT JOIN owner_recruits ors ON ow.id = ors.owner_id
                LEFT JOIN transactions t ON ow.id = t.owner_id
                LEFT JOIN mst_payment_methods mpm ON pm.payment_method_id = mpm.id
                LEFT JOIN mst_happy_moneys mhm ON ors.happy_money_id = mhm.id
                LEFT JOIN list_user_messages l ON ors.id = l.owner_recruit_id
                LEFT JOIN users u ON l.user_id = u.id
                LEFT JOIN user_recruits urs ON u.id = urs.user_id
                LEFT JOIN `user_payments` up ON ors.id = up.owner_recruit_id
                LEFT JOIN mst_ages ma ON urs.age_id = ma.id
                LEFT JOIN mst_height mh ON urs.height_id = mh.id
                LEFT JOIN mst_cities mcu ON urs.city_id = mcu.id
                LEFT JOIN mst_cities mc ON ors.city_id = mc.id
                LEFT JOIN mst_city_groups mcg ON mc.city_group_id = mcg.id
                LEFT JOIN mst_towns mt ON ors.town_id = mt.id
                WHERE
                pm.`payment_status` = 1
                AND pm.`id` = ?";
        $query = $this->db->query($sql, array($ownerId));
        return $query->row_array();
    }

    /**
     * author: [IVS] Phan Ngoc Minh Luan
     * name : ow18
     * todo : payment recruit point
     * @param int $userId, $ownerId
     * @return null
     */
    public function ow18($userId = null, $ownerId = null) {
        $sql = "SELECT ow.id, ow.storename, ow.email_address, ow.password, ow.address,
                ors.apply_tel AS tel, ow.bank_name, ow.branch_name, ow.account_type, ow.account_no,
                ow.account_name, pm.amount, pm.point, t.created_date AS date_payment,
                CASE
                1
                WHEN 1
                THEN 'ポイント'
                END AS payment_case,
                ow.total_point AS total_point_ap, t.amount AS amount_payment, t.point AS point_payment,
                ow.total_point + t.point AS total_point_bp, pm.amount AS amount1,
                pm.payment_name, pm.tranfer_date AS transfer_date, mhm.user_happy_money, mhm.joyspe_happy_money,
                up.`request_money_date`, u.unique_id, mcu.name AS user_city, COUNT(t.id) AS scout_number,
                ors.home_page_url, mcg.`name` AS `owner_city_group`, mc.name AS owner_city,
                mt.`name` AS owner_town, ors.how_to_access, ors.salary, CONCAT(ma.name1, ' ~ ', ma.name2) AS age,
                CONCAT(mh.name1, ' ~ ', mh.name2) AS height, u.bust, u.waist, u.hip

                FROM users u
                LEFT JOIN user_recruits ur ON u.id = ur.user_id
                LEFT JOIN mst_ages ma ON ur.age_id = ma.id
                LEFT JOIN mst_height mh ON ur.height_id = mh.id
                LEFT JOIN user_payments up ON u.id = up.user_id
                LEFT JOIN transactions t ON up.id = t.reference_id
                LEFT JOIN owner_recruits ors ON up.owner_recruit_id = ors.id
                LEFT JOIN owners ow ON ors.owner_id = ow.id
                LEFT JOIN mst_happy_moneys mhm ON ors.happy_money_id = mhm.id
                LEFT JOIN payments pm ON ow.id = pm.owner_id
                LEFT JOIN mst_payment_methods mpm ON pm.payment_method_id = mpm.id
                LEFT JOIN mst_cities mc ON ors.city_id = mc.id
                LEFT JOIN mst_cities mcu ON ur.city_id = mcu.id
                LEFT JOIN mst_city_groups mcg ON mc.city_group_id = mcg.id
                LEFT JOIN mst_towns mt ON ors.town_id = mt.id
                WHERE ow.display_flag = 1
                AND u.display_flag = 1
                AND up.user_payment_status = 6
                AND up.display_flag = 1
                AND t.owner_id = ?
                AND t.payment_case_id = 3
                AND u.`id` = ?
                GROUP BY ow.id";
        $query = $this->db->query($sql, array($ownerId, $userId));
        return $query->row_array();
    }

    /**
     * author: [IVS] Nguyen Bao Trieu
     * name : sp01
     * todo : send inform payment for joyspe
     * @param int $loginId
     * @return null
     */
    public function sp01($userId = null, $ownerId = null) {
        $sql = "SELECT
  o.`storename`,
  p.`payment_name`,
  p.`tranfer_date`,
  CASE
    p.`payment_method_id`
    WHEN 1
    THEN 'クレジット'
    WHEN 2
    THEN '銀行'
  END AS case_name,
  p.`amount`,
  p.`point_payment`,
  p.`amount_payment`
FROM
  payments p,
  owners o
WHERE p.`owner_id` = o.`id`
  AND p.`payment_status` = 1
  AND p.`id` = ?";
        $query = $this->db->query($sql, array($ownerId));
        return $query->row_array();
    }

    /**
     * author: [IVS] Nguyen Bao Trieu
     * name : ss01
     * todo : get owner
     * @param int $loginId
     * @return null
     */
    public function ss01($user_id = null, $loginId = null) {
        $sql = "SELECT ow.*, owr.apply_tel, mjt.name AS business, CONCAT(CONCAT(mcg.name, ',' , mc.name), ',', mt.name) AS post_area, owr.campaign_note 
                FROM owners AS ow 
                LEFT JOIN owner_recruits AS owr ON ow.id = owr.owner_id
                LEFT JOIN job_type_owners AS jto ON owr.id = jto.owner_recruit_id
                LEFT JOIN mst_job_types AS mjt ON jto.job_type_id = mjt.id
                LEFT JOIN mst_city_groups AS mcg ON owr.city_group_id = mcg.id
                LEFT JOIN mst_cities AS mc ON owr.city_id = mc.id
                LEFT JOIN mst_towns AS mt ON owr.town_id = mt.id
                WHERE ow.display_flag = 1 AND ow.id = ?";
        $query = $this->db->query($sql, array($loginId));
        return $query->row_array();
    }

    /**
     * @author: [IVS] Nguyen Hong Duc
     * @name : ss07
     * @todo : get owner
     * @param int $loginId
     * @return null
     */
    public function ss07($user_id = null, $loginId = null) {
        $sql = 'SELECT * FROM owners WHERE display_flag = 1 AND id = ?';
        $query = $this->db->query($sql, array($loginId));
        return $query->row_array();
    }

    /**
     * @author: [IVS] Nguyen Hong Duc
     * @name : ss08
     * @todo : get owner
     * @param int $loginId
     * @return null
     */
    public function ss08($user_id = null, $loginId = null) {
        $sql = 'SELECT * FROM owners WHERE display_flag = 1 AND id = ?';
        $query = $this->db->query($sql, array($loginId));
        return $query->row_array();
    }
    public function ss09($user_id = null, $loginId = null) {
       $sql = "SELECT u.unique_id,u.name,u.email_address,u.password,ow.storename
	   			FROM users u
				INNER JOIN list_user_messages lum ON u.id= lum.user_id
				INNER JOIN owner_recruits owr ON lum.owner_recruit_id = owr.id
				INNER JOIN owners ow ON owr.owner_id = ow.id
				WHERE u.id = ? AND owr.id= ?";
		$query = $this->db->query($sql, array($user_id,$loginId));
		return $query->row_array();
    }

    /**
     * @author: [IVS] Nguyen Hong Duc
     * @name : us07
     * @todo : get
     * @param int
     * @return null
     */
    public function us07($userId = null, $ownerId = null) {
      $sql = 'SELECT o.storename,o.address,
              mh.`user_happy_money`,mc.name AS city_of_owner, u.`unique_id`,
              u.name AS user_name,u.`email_address`,o.email_address as owner_email
              FROM users u
              INNER JOIN user_recruits ur ON u.id = ur.user_id
              INNER JOIN user_payments up ON up.user_id = u.id
              INNER JOIN owner_recruits orc ON up.owner_recruit_id = orc.id
              INNER JOIN owners o ON o.id = orc.owner_id
              INNER JOIN mst_happy_moneys mh ON mh.`id` = orc.happy_money_id
              INNER JOIN mst_cities mc ON orc.city_id = mc.id
              WHERE o.display_flag = 1 AND u.display_flag = 1
              AND o.id = ?
              AND u.id = ?
              AND mc.display_flag = 1
              GROUP BY u.`id` ';

      $query = $this->db->query($sql, array($ownerId, $userId));
      return $query->row_array();
    }

    /**
     * author: [IVS] Phan Ngoc Minh Luan
     * name : us09
     * todo : get
     * @param int
     * @return null
     */
    public function us09($userId = null, $ownerId = null) {
        $sql = "SELECT 	u.email_address AS email_address, u.password, o.storename, o.address, orr.apply_tel AS tel,
                h.user_happy_money, up.request_money_date, u.unique_id, u.name AS user_name, orr.home_page_url,
                o.email_address AS owner_email_address, mcg.name AS owner_city_group,
                mc.name AS city_of_owner, mt.`name` AS owner_town, orr.how_to_access, orr.salary

                FROM users u
                LEFT JOIN user_recruits urs ON u.id = urs.user_id
                LEFT JOIN user_payments up ON up.user_id = u.id
                LEFT JOIN owner_recruits orr ON up.owner_recruit_id = orr.id
                LEFT JOIN owners o ON orr.owner_id = o.id
                LEFT JOIN mst_happy_moneys h ON orr.happy_money_id = h.id
                LEFT JOIN mst_cities mc ON orr.city_id = mc.id
                LEFT JOIN mst_city_groups mcg ON mc.city_group_id = mcg.id
                LEFT JOIN mst_towns mt ON orr.town_id = mt.id
                LEFT JOIN job_type_owners jto ON orr.id = jto.owner_recruit_id
                LEFT JOIN mst_job_types mjt ON jto.job_type_id = mjt.id
                WHERE o.display_flag = 1
                AND u.display_flag = 1
                AND mc.display_flag = 1
                AND mjt.display_flag = 1
                AND o.id = ?
                AND u.id = ?
                GROUP BY u.id";
        $query = $this->db->query($sql, array($ownerId, $userId));
        return $query->row_array();
    }

    /**
     * author: [IVS] Phan Ngoc Minh Luan
     * name : us11
     * todo : inform tranfer happy money
     * @param int
     * @return null
     */
    public function us11($userId = null, $ownerId = null) {
        $sql = "SELECT 	u.email_address AS email_address, u.password, o.storename, o.address, orr.apply_tel AS tel,
                h.user_happy_money, up.request_money_date, u.unique_id, u.name AS user_name, orr.home_page_url,
                o.email_address AS owner_email_address, mcg.name AS owner_city_group,
                mc.name AS city_of_owner, mt.`name` AS owner_town, orr.how_to_access, orr.salary

                FROM users u
                LEFT JOIN user_recruits urs ON u.id = urs.user_id
                LEFT JOIN user_payments up ON up.user_id = u.id
                LEFT JOIN owner_recruits orr ON up.owner_recruit_id = orr.id
                LEFT JOIN owners o ON orr.owner_id = o.id
                LEFT JOIN mst_happy_moneys h ON orr.happy_money_id = h.id
                LEFT JOIN mst_cities mc ON orr.city_id = mc.id
                LEFT JOIN mst_city_groups mcg ON mc.city_group_id = mcg.id
                LEFT JOIN mst_towns mt ON orr.town_id = mt.id
                WHERE o.display_flag = 1
                AND u.display_flag = 1
                AND mc.display_flag = 1
                AND o.id = ?
                AND u.id = ?
                GROUP BY u.id";
        $query = $this->db->query($sql, array($ownerId, $userId));
        return $query->row_array();
    }

    /**
     * @author: [IVS] Nguyen Hong Duc
     * @name :
     * @todo : get owner
     * @param int $loginId
     * @return null
     */
    public function ow12($userId = null, $ownerId = null) {
        $sql = 'SELECT
          ow.`storename`,
          ow.`address`,
          ow.`email_address`,
          mc.name,
          ow.email_address as owner_email
        FROM
          `owners` ow
          INNER JOIN `owner_recruits` owr
            ON ow.`id` = owr.`owner_id`
          INNER JOIN `mst_happy_moneys` mhm
            ON owr.`happy_money_id` = mhm.`id`
          INNER JOIN `job_type_owners` jto
            ON owr.`id` = jto.`owner_recruit_id`
          INNER JOIN `mst_cities` mc
            ON owr.`city_id` = mc.`id`
        WHERE ow.`id` = ?
        GROUP BY ow.`id`  ';
        $query = $this->db->query($sql, array($ownerId));
        return $query->row_array();
    }

    /**
     * @author  [IVS] Nguyen Minh Ngoc
     * @name 	us02
     * @todo 	send mail us02
     * @param 	$userid
     * @return
     */
    public function us02($userid) {
        $sql = "SELECT 	u.email_address AS email_address, u.password, o.storename, o.address, orr.apply_tel AS tel,
                h.user_happy_money, up.request_money_date, u.unique_id, u.name,  orr.home_page_url,
                o.email_address AS owner_email_address, mcg.name AS owner_city_group,
                mc.name AS owner_city, mt.`name` AS owner_town, orr.how_to_access, orr.salary

                FROM users u
                LEFT JOIN user_recruits urs ON u.id = urs.user_id AND urs.display_flag = 1
                LEFT JOIN list_user_messages l ON u.id = l.user_id
                LEFT JOIN owner_recruits orr ON l.owner_recruit_id = orr.id
                LEFT JOIN owners o ON orr.owner_id = o.id
                LEFT JOIN mst_happy_moneys h ON orr.happy_money_id = h.id
                LEFT JOIN mst_cities mc ON orr.city_id = mc.id
                LEFT JOIN mst_cities mcu ON urs.city_id = mcu.id AND mcu.display_flag = 1
                LEFT JOIN mst_city_groups mcg ON mc.city_group_id = mcg.id
                LEFT JOIN mst_towns mt ON orr.town_id = mt.id
                LEFT JOIN user_payments up ON orr.id = up.owner_recruit_id
                LEFT JOIN job_type_users jtu ON urs.user_id = jtu.user_id
                LEFT JOIN mst_job_types mjt ON jtu.job_type_id = mjt.id AND mjt.display_flag = 1
                WHERE u.display_flag = 1 AND u.id = ?
                GROUP BY urs.id";
        $query = $this->db->query($sql, array($userid));
        return $query->row_array();
    }

    /**
     * @author  [IVS] Nguyen Minh Ngoc
     * @name 	ow03
     * @todo 	sendmail ow03
     * @param 	$id
     * @return
     */
    public function ow03($id) {
        $sql = "SELECT *,email_address,owners.password,storename,address,bank_name,branch_name,
                account_type,account_no,account_name,mst_cities.`name` AS city_name,
                GROUP_CONCAT(mst_job_types.name,'') AS job_type,joyspe_happy_money,0.4*joyspe_happy_money AS happy_money
                FROM owners
                LEFT JOIN owner_recruits ON owners.id = owner_recruits.owner_id AND owner_recruits.`display_flag` = '1'
                LEFT JOIN mst_cities ON owner_recruits.city_id = mst_cities.id AND mst_cities.`display_flag` = '1'
                LEFT JOIN job_type_owners ON owner_recruits.id = job_type_owners.owner_recruit_id
                LEFT JOIN mst_job_types ON job_type_owners.job_type_id = mst_job_types.id AND mst_job_types.`display_flag` = '1'
                LEFT JOIN mst_happy_moneys ON mst_happy_moneys.id = owner_recruits.happy_money_id AND mst_happy_moneys.`display_flag` = '1'
                WHERE owners.display_flag = 1 AND owners.id = ?
                GROUP BY owner_recruits.id";
        return $this->db->query($sql, array($id))->row_array();
    }

    /**
     * @author     [IVS] Nguyen Van Vui
     * @name 	ow02
     * @todo 	view company details
     * @param 	$id
     * @return
     */
    public function ow02($id) {
        $sql = "SELECT ow.id, ow.storename, ow.email_address, ow.password, ow.address,
                ors.apply_tel AS tel, ow.bank_name, ow.branch_name, ow.account_type, ow.account_no,
                ow.account_name, pm.amount, pm.point, pm.created_date as date_payment,
                mpm.name AS payment_case, ow.total_point as total_point_ap, pm.amount_payment, pm.point_payment,
                ow.total_point + SUM(t.point) AS total_point_bp, pm.amount AS amount1,
                pm.payment_name, pm.tranfer_date as transfer_date, mhm.user_happy_money, mhm.joyspe_happy_money,
                up.`request_money_date`, u.unique_id, mcu.name AS user_city, COUNT(t.id) AS scout_number,
                ors.home_page_url, mcg.`name` AS `owner_city_group`, mc.name AS owner_city,
                mt.`name` AS owner_town, ors.how_to_access, ors.salary, concat(ma.name1, ' ~ ', ma.name2) AS age,
                concat(mh.name1, ' ~ ', mh.name2) AS height, u.bust, u.waist, u.hip

                FROM owners ow
                LEFT JOIN owner_recruits ors ON ow.id = ors.owner_id
                LEFT JOIN payments pm ON ow.id = pm.owner_id
                LEFT JOIN transactions t ON ow.id = t.owner_id
                LEFT JOIN mst_payment_methods mpm ON pm.payment_method_id = mpm.id
                LEFT JOIN mst_happy_moneys mhm ON ors.happy_money_id = mhm.id
                LEFT JOIN list_user_messages l ON ors.id = l.owner_recruit_id
                LEFT JOIN users u ON l.user_id = u.id
                LEFT JOIN user_recruits urs ON u.id = urs.user_id
                LEFT JOIN `user_payments` up ON ors.id = up.owner_recruit_id
                LEFT JOIN mst_ages ma ON urs.age_id = ma.id
                LEFT JOIN mst_height mh ON urs.height_id = mh.id
                LEFT JOIN mst_cities mcu ON urs.city_id = mcu.id
                LEFT JOIN mst_cities mc ON ors.city_id = mc.id
                LEFT JOIN mst_city_groups mcg ON mc.city_group_id = mcg.id
                LEFT JOIN mst_towns mt ON ors.town_id = mt.id
                WHERE ow.display_flag = 1 AND ow.id = ?";
        return $this->db->query($sql, array($id))->row_array();
    }

    /**
     * @author     [IVS] Nguyen Minh Ngoc
     * @name 	ow06
     * @todo 	send mail bank details to owner
     * @param 	$id
     * @return
     */
    public function ow06($userId = null, $ownerId = null) {
        $sql = " SELECT
            owners.storename,owners.email_address,
             (payments.`point_payment` - payments.`amount`) AS total_point,
            payments.`amount_payment`,
            payments.`point_payment` ,
            payments.`created_date` AS date_payment,
            mst_payment_methods.`name` AS payment_case,
            payments.`amount` ,
            payments.`point`
          FROM
            payments
            INNER JOIN owners
              ON owners.id = payments.owner_id
            INNER JOIN `mst_payment_methods`
              ON payments.`payment_method_id` = `mst_payment_methods`.`id`
          WHERE payments.display_flag = 1
            AND payments.id = ?
             GROUP BY owners.`id` ";
        return $this->db->query($sql, array($ownerId))->row_array();
    }

    /**
     * @author     [IVS] Nguyen Minh Ngoc + [IVS] Nguyen Van Vui
     * @name 	ow09
     * @todo 	send mail bank details to owner
     * @param 	$id
     * @return
     */
    public function ow09($userId = null, $ownerId = null) {
        $sql = "SELECT DISTINCT
                    OW.`email_address`,
                    PM.`amount`,
                    MPM.`name` AS payment_case,
                    PM.`point`,
                    PM.`amount_payment`,
                    PM.`point_payment`,
                    PM.`created_date`,
                    OW.`storename`,
                    OW.`total_amount`
                  FROM
                    `payments` PM
                    INNER JOIN `mst_payment_methods` MPM
                      ON MPM.`id` = PM.`payment_method_id`
                    INNER JOIN owners OW
                      ON PM.`owner_id` = OW.`id`
                  WHERE PM.`display_flag` = 1
                    AND PM.`id` = ?";
        $query = $this->db->query($sql, array($ownerId));
        return $query->row_array();
    }

//    public function ow09($id) {
//        $sql = 'SELECT pm.`id`, ow.`email_address`, ow.`unique_id`, ow.`storename`, pm.`payment_name`,
//                         pm.`tranfer_date`, pm.`amount`
//                     FROM payments pm
//                     INNER JOIN owners ow ON pm.`owner_id` = ow.`id`
//                     WHERE pm.`display_flag` = 1 AND pm.`id` = ?';
//        return $this->db->query($sql, array($id))->row_array();
//    }

    /**
     * @author    [IVS] Phan Van Thuyet + [IVS] Nguyen Van Vui
     * @name 	ow19
     * @todo 	send mail bank details to owner
     * @param 	$id
     * @return
     */
    public function ow19($userId = null, $ownerId = null) {
        $sql = "SELECT DISTINCT ow.id, ow.storename, ow.email_address, ow.password, ow.address,
                ors.apply_tel AS tel, ow.bank_name, ow.branch_name, ow.account_type, ow.account_no,
                ow.account_name, pm.amount, pm.point, pm.created_date AS date_payment,
                mpm.name AS payment_case, ow.total_point AS total_point_ap, pm.amount_payment, pm.point_payment,
                ow.total_point + SUM(t.point) AS total_point_bp, pm.amount AS amount1,
                pm.payment_name, pm.tranfer_date AS transfer_date, mhm.user_happy_money, mhm.joyspe_happy_money,
                up.`request_money_date`, u.unique_id, mcu.name AS user_city, COUNT(t.id) AS scout_number,
                ors.home_page_url, mcg.`name` AS `owner_city_group`, mc.name AS owner_city,
                mt.`name` AS owner_town, ors.how_to_access, ors.salary, CONCAT(ma.name1, ' ~ ', ma.name2) AS age,
                CONCAT(mh.name1, ' ~ ', mh.name2) AS height, u.bust, u.waist, u.  hip

                FROM payments pm
                LEFT JOIN mst_payment_methods mpm ON pm.payment_method_id = mpm.id
                LEFT JOIN owners ow ON pm.owner_id = ow.id
                LEFT JOIN transactions t ON pm.id = t.payment_id
                LEFT JOIN `user_payments` up ON t.reference_id = up.id
                LEFT JOIN users u ON up.user_id = u.id
                LEFT JOIN user_recruits urs ON u.id = urs.user_id
                LEFT JOIN mst_ages ma ON urs.age_id = ma.id
                LEFT JOIN mst_height mh ON urs.height_id = mh.id
                LEFT JOIN owner_recruits ors ON up.owner_recruit_id = ors.id
                LEFT JOIN mst_happy_moneys mhm ON ors.happy_money_id = mhm.id
                LEFT JOIN mst_cities mcu ON urs.city_id = mcu.id
                LEFT JOIN mst_cities mc ON ors.city_id = mc.id
                LEFT JOIN mst_city_groups mcg ON mc.city_group_id = mcg.id
                LEFT JOIN mst_towns mt ON ors.town_id = mt.id
                WHERE pm.`display_flag` = 1
                AND pm.`id`= ?
                AND pm.`payment_case_id` = 3
                AND t.`display_flag` = 1
                AND up.`user_payment_status`=6
                AND up.`display_flag`= 1";
        $query = $this->db->query($sql, array($ownerId));
        return $query->row_array();
    }

    /**
     * @author     [IVS] Phan Van Thuyet + [IVS] Nguyen Van Vui
     * @name 	ow21
     * @todo 	send mail bank details to owner
     * @param 	$id
     * @return
     */
    public function ow21($userId = null, $id = null) {
        $sql = "SELECT DISTINCT ow.id, ow.storename, ow.email_address, ow.password, ow.address,
                ors.apply_tel AS tel, ow.bank_name, ow.branch_name, ow.account_type, ow.account_no,
                ow.account_name, pm.amount, pm.point, pm.created_date AS date_payment,
                mpm.name AS payment_case, ow.total_point AS total_point_ap, pm.amount_payment, pm.point_payment,
                ow.total_point + pm.point AS total_point_bp, pm.amount AS amount1,
                pm.payment_name, pm.tranfer_date AS transfer_date, mhm.user_happy_money, mhm.joyspe_happy_money,
                up.`request_money_date`, u.unique_id, mcu.name AS user_city, COUNT(t.id) AS scout_number,
                ors.home_page_url, mcg.`name` AS `owner_city_group`, mc.name AS owner_city,
                mt.`name` AS owner_town, ors.how_to_access, ors.salary, CONCAT(ma.name1, ' ~ ', ma.name2) AS age,
                CONCAT(mh.name1, ' ~ ', mh.name2) AS height, u.bust, u.waist, u.  hip

                FROM payments pm
                LEFT JOIN mst_payment_methods mpm ON pm.payment_method_id = mpm.id
                LEFT JOIN owners ow ON pm.owner_id = ow.id
                LEFT JOIN transactions t ON pm.id = t.payment_id
                LEFT JOIN `user_payments` up ON t.reference_id = up.id
                LEFT JOIN users u ON up.user_id = u.id
                LEFT JOIN user_recruits urs ON u.id = urs.user_id
                LEFT JOIN mst_ages ma ON urs.age_id = ma.id
                LEFT JOIN mst_height mh ON urs.height_id = mh.id
                LEFT JOIN owner_recruits ors ON up.owner_recruit_id = ors.id
                LEFT JOIN mst_happy_moneys mhm ON ors.happy_money_id = mhm.id
                LEFT JOIN mst_cities mcu ON urs.city_id = mcu.id
                LEFT JOIN mst_cities mc ON ors.city_id = mc.id
                LEFT JOIN mst_city_groups mcg ON mc.city_group_id = mcg.id
                LEFT JOIN mst_towns mt ON ors.town_id = mt.id
                WHERE pm.`display_flag` = 1
                AND pm.id = ?";
        return $this->db->query($sql, array($id))->row_array();
    }

    /**
     * @author  [IVS] Nguyen Minh Ngoc
     * @name 	ow22
     * @todo 	approve owner recruit
     * @param 	$id
     * @return
     */
    public function ow22($id) {
        $sql = "SELECT email_address,owners.password,storename,address,bank_name,branch_name,
                account_type,account_no,account_name,mst_cities.`name` AS city_name,
                GROUP_CONCAT(mst_job_types.name,'') AS job_type,joyspe_happy_money,0.4*joyspe_happy_money AS happy_money
                FROM owners
                LEFT JOIN owner_recruits ON owners.id = owner_recruits.owner_id AND owner_recruits.`display_flag` = '1'
                LEFT JOIN mst_cities ON owner_recruits.city_id = mst_cities.id AND mst_cities.`display_flag` = '1'
                LEFT JOIN job_type_owners ON owner_recruits.id = job_type_owners.owner_recruit_id
                LEFT JOIN mst_job_types ON job_type_owners.job_type_id = mst_job_types.id AND mst_job_types.`display_flag` = '1'
                LEFT JOIN mst_happy_moneys ON mst_happy_moneys.id = owner_recruits.happy_money_id AND mst_happy_moneys.`display_flag` = '1'
                WHERE owners.display_flag = 1 AND owners.id = ?
                GROUP BY owner_recruits.id";
        return $this->db->query($sql, array($id))->row_array();
    }

    /**
     * author: [IVS] Nguyen Ngoc Phuong
     * name : us04
     * todo : get user
     * @param int $userId, $ownerId
     * @return null
     */
    public function us04($userId = null, $ownerId = null) {
        $sql = "SELECT 	u.email_address AS email_address, u.password, o.storename, o.address, orr.apply_tel,
                h.user_happy_money, up.request_money_date, u.unique_id, u.name AS username, orr.home_page_url,
                o.email_address AS owner_email_address, mcg.name AS owner_city_group,
                mc.name AS owner_city, mt.`name` AS owner_town, orr.how_to_access, orr.salary

                FROM owners o
                LEFT JOIN owner_recruits orr ON o.id = orr.owner_id
                LEFT JOIN mst_happy_moneys h ON orr.happy_money_id = h.id
                LEFT JOIN user_payments up ON orr.id = up.owner_recruit_id
                LEFT JOIN users u ON up.user_id = u.id
                LEFT JOIN mst_cities mc ON orr.city_id = mc.id
                LEFT JOIN mst_city_groups mcg ON mc.city_group_id = mcg.id
                LEFT JOIN mst_towns mt ON orr.town_id = mt.id
                WHERE o.id = $ownerId
                AND o.display_flag = 1
                AND orr.display_flag = 1
                AND orr.recruit_status = 2
                AND h.display_flag = 1
                AND up.user_id = $userId";
        $query = $this->db->query($sql, array($ownerId, $userId));
        return $query->row_array();
    }

    /**
     * author: [IVS] Jeffrey Sabellon
     * name : us15
     * todo : get user
     * @param int $userId, $ownerId
     * @return null
     */
    public function us15($userId = null, $ownerId = null) {
        $sql = "SELECT 	u.email_address AS email_address, u.password, o.storename, o.address, orr.apply_tel,
                h.user_happy_money, up.request_money_date, u.unique_id, u.name AS username, orr.home_page_url,
                o.email_address AS owner_email_address, mcg.name AS owner_city_group,
                mc.name AS owner_city, mt.`name` AS owner_town, orr.how_to_access, orr.salary

                FROM owners o
                LEFT JOIN owner_recruits orr ON o.id = orr.owner_id
                LEFT JOIN mst_happy_moneys h ON orr.happy_money_id = h.id
                LEFT JOIN user_payments up ON orr.id = up.owner_recruit_id
                LEFT JOIN users u ON up.user_id = u.id
                LEFT JOIN mst_cities mc ON orr.city_id = mc.id
                LEFT JOIN mst_city_groups mcg ON mc.city_group_id = mcg.id
                LEFT JOIN mst_towns mt ON orr.town_id = mt.id
                WHERE o.id = $ownerId
                AND o.display_flag = 1
                AND orr.display_flag = 1
                AND orr.recruit_status = 2
                AND h.display_flag = 1
                AND up.user_id = $userId";
        $query = $this->db->query($sql, array($ownerId, $userId));
        return $query->row_array();
    }



    /**
     * author: [IVS] Nguyen Ngoc Phuong
     * name : us08
     * todo : get user
     * @param int $userId, $ownerId
     * @return null
     */
    public function us08($userId = null, $ownerId = null) {
        $sql = "SELECT 	u.email_address AS email_address, u.password, o.storename, o.address, orr.apply_tel AS tel,
                h.user_happy_money, up.request_money_date, u.unique_id AS userid, u.name AS username, orr.home_page_url,
                o.email_address AS owner_email_address, mcg.name AS owner_city_group,
                mc.name AS owner_city, mt.`name` AS owner_town, orr.how_to_access, orr.salary

                FROM owners o
                LEFT JOIN owner_recruits orr ON o.id = orr.owner_id
                LEFT JOIN mst_happy_moneys h ON orr.happy_money_id = h.id
                LEFT JOIN user_payments up ON orr.id = up.owner_recruit_id
                LEFT JOIN users u ON up.user_id = u.id
                LEFT JOIN mst_cities mc ON orr.city_id = mc.id
                LEFT JOIN mst_city_groups mcg ON mc.city_group_id = mcg.id
                LEFT JOIN mst_towns mt ON orr.town_id = mt.id
                WHERE o.id = ?
                AND o.display_flag = 1
                AND h.display_flag = 1
                AND up.user_id = ?";
        $query = $this->db->query($sql, array($ownerId, $userId));
        return $query->row_array();
    }

    /**
     * @author     [IVS] Nguyen Van Vui
     * @name 0
     * @todo 	send mail reward deleted owners
     * @param 	$id
     * @return
     */
    public function ow20($ownerId = null,$id = null) {
        $sql = "SELECT ow.id, ow.storename, ow.email_address, ow.password, ow.address,
                ors.apply_tel AS tel, ow.bank_name, ow.branch_name, ow.account_type, ow.account_no,
                ow.account_name, pm.amount, pm.point, pm.created_date AS date_payment,
                mpm.name AS payment_case, ow.total_point AS total_point_ap, pm.amount_payment, pm.point_payment,
                ow.total_point + SUM(t.point) AS total_point_bp, pm.amount AS amount1,
                pm.payment_name, pm.tranfer_date AS transfer_date, mhm.user_happy_money, mhm.joyspe_happy_money,
                up.`request_money_date`, u.unique_id, mcu.name AS user_city, COUNT(t.id) AS scout_number,
                ors.home_page_url, mcg.`name` AS `owner_city_group`, mc.name AS owner_city,
                mt.`name` AS owner_town, ors.how_to_access, ors.salary, CONCAT(ma.name1, ' ~ ', ma.name2) AS age,
                CONCAT(mh.name1, ' ~ ', mh.name2) AS height, u.bust, u.waist, u.  hip

                FROM users u
                LEFT JOIN user_payments up ON u.id= up.user_id
                LEFT JOIN user_recruits urs ON u.id= urs.user_id
                LEFT JOIN mst_ages ma ON urs.age_id = ma.id
                LEFT JOIN mst_height mh ON urs.height_id = mh.id
                LEFT JOIN owner_recruits ors ON up.owner_recruit_id = ors.id
                LEFT JOIN owners ow ON ors.owner_id = ow.id
                LEFT JOIN mst_happy_moneys mhm ON ors.happy_money_id = mhm.id
                LEFT JOIN mst_cities mcu ON urs.city_id = mcu.id
                LEFT JOIN mst_cities mc ON ors.city_id = mc.id
                LEFT JOIN mst_city_groups mcg ON mc.city_group_id = mcg.id
                LEFT JOIN mst_towns mt ON ors.town_id = mt.id
                LEFT JOIN payments pm ON ow.id = pm.owner_id
                LEFT JOIN transactions t ON ow.id = t.owner_id
                LEFT JOIN mst_payment_methods mpm ON pm.payment_method_id = mpm.id
                WHERE up.user_payment_status=6
                AND up.payment_date IS NULL
                AND up.`display_flag` = 1
                AND ow.`id` = ?";
        return $this->db->query($sql, array($id))->row_array();
    }

    /**
     * @author     [IVS] Nguyen Van Vui
     * @name 	us12
     * @todo 	send mail reward deleted user
     * @param 	$id
     * @return
     */
    public function us12($userId = null, $ownerId = null) {
        $sql = "SELECT 	u.email_address AS email_address, u.password, o.storename, o.address, orr.apply_tel AS tel,
                h.user_happy_money, up.request_money_date, u.unique_id, u.name AS user_name, orr.home_page_url,
                o.email_address AS owner_email, mcg.name AS owner_city_group,
                mc.name AS city_of_owner, mt.`name` AS owner_town, orr.how_to_access, orr.salary

                FROM users u
                LEFT JOIN user_recruits urs ON u.id = urs.user_id
                LEFT JOIN user_payments up ON u.id = up.user_id
                LEFT JOIN owner_recruits orr ON up.owner_recruit_id = orr.id
                LEFT JOIN owners o ON orr.owner_id = o.id
                LEFT JOIN mst_happy_moneys h ON orr.happy_money_id = h.id
                LEFT JOIN mst_cities mc ON orr.city_id = mc.id
                LEFT JOIN mst_city_groups mcg ON mc.city_group_id = mcg.id
                LEFT JOIN mst_towns mt ON orr.town_id = mt.id
                WHERE o.display_flag = 1
                AND u.display_flag = 1
                AND mc.display_flag = 1
                AND o.id = ?
                AND u.id = ?
                GROUP BY u.id";
        return $this->db->query($sql, array($ownerId, $userId))->row_array();
    }

    /**
     * @author     [IVS] Nguyen Van Vui
     * @name 	ss03
     * @todo 	send mail bank details to Joyspe
     * @param 	$id
     * @return
     */
    public function ss03($ownerId = null, $payment_id = null) {
        if ($ownerId == NULL) {
            $sql = 'SELECT
        owners.storename,
        owners.email_address,
        payments.`created_date` AS date_payment,
        mst_payment_methods.`name` AS payment_case,
        payments.`amount`,
        payments.`point`

      FROM
        payments
        INNER JOIN owners
          ON owners.id = payments.owner_id
        INNER JOIN `mst_payment_methods`
          ON payments.`payment_method_id` = `mst_payment_methods`.`id`
      WHERE payments.display_flag = 1
        AND payments.id = ?
         GROUP BY owners.`id`';
            return $this->db->query($sql, array($payment_id))->row_array();
        } else {
            $sql = "SELECT
  owners.storename,
  owners.email_address,
  SUM(`transactions`.`amount`) AS amount,
  SUM(`transactions`.`point`) AS 'point',
  `transactions`.`created_date` AS date_payment,
  CASE
    1
    WHEN 1
    THEN 'ポイント'
  END AS payment_case

FROM
  users
  INNER JOIN user_recruits
    ON users.id = user_recruits.user_id
  INNER JOIN `list_user_messages`
    ON list_user_messages.`user_id` = users.id
  INNER JOIN `transactions`
    ON `transactions`.`reference_id` = `list_user_messages`.`id`
  INNER JOIN owner_recruits
    ON list_user_messages.owner_recruit_id = owner_recruits.id
  INNER JOIN owners
    ON owners.id = owner_recruits.owner_id
  INNER JOIN mst_happy_moneys
    ON mst_happy_moneys.`id` = owner_recruits.`happy_money_id`
WHERE owners.display_flag = 1
  AND users.display_flag = 1
  AND list_user_messages.display_flag = 1
  AND `transactions`.`payment_case_id` = 1
  AND owners.id = ?
   GROUP BY owners.`id` ";
        }
        $query = $this->db->query($sql, array($ownerId));
        return $query->row_array();
    }

    /**
     * @author     [IVS] Nguyen Van Vui
     * @name 	ss04
     * @todo 	send mail bank details to Joyspe
     * @param 	$id
     * @return
     */
    public function ss04($userId = null, $id = null) {
        $sql = 'SELECT DISTINCT
                    owners.`email_address`,
                    payments.`created_date`,
                    mst_payment_methods.`name` AS payment_case,
                    payments.`amount`,
                    payments.`point`,
                    owners.`storename`
                 FROM
        payments
        INNER JOIN owners
          ON owners.id = payments.owner_id
        INNER JOIN `mst_payment_methods`
          ON payments.`payment_method_id` = `mst_payment_methods`.`id`
      WHERE payments.display_flag = 1
        AND payments.id = ?
         GROUP BY owners.`id`';
        return $this->db->query($sql, array($id))->row_array();
    }

    /**
     * @author     [IVS] Nguyen Van Vui
     * @name 	ss05
     * @todo 	send mail bank details to Joyspe
     * @param 	$id
     * @return
     */
    public function ss05($ownerId = null, $id = null) {
        if ($ownerId == NULL) {
            $sql = 'SELECT
        owners.storename,
        owners.email_address,
        payments.`created_date` AS date_payment,
        mst_payment_methods.`name` AS payment_case,
        payments.`amount`,
        payments.`point`

      FROM
        payments
        INNER JOIN owners
          ON owners.id = payments.owner_id
        INNER JOIN `mst_payment_methods`
          ON payments.`payment_method_id` = `mst_payment_methods`.`id`
      WHERE payments.display_flag = 1
        AND payments.id = ?
         GROUP BY owners.`id`';
            $query = $this->db->query($sql, array($id));
        } else {
            $sql = "SELECT
  owners.storename,
  owners.email_address,
  SUM(`transactions`.`amount`) AS amount,
  SUM(`transactions`.`point`) AS `point`,
  `transactions`.`created_date` AS date_payment,
  COUNT(`transactions`.`id`) AS scout_number,
  CASE
    1
    WHEN 1
    THEN 'ポイント'
  END AS payment_case
FROM
  users
  INNER JOIN user_recruits
    ON users.id = user_recruits.user_id
  INNER JOIN `user_payments`
    ON user_payments.`user_id` = users.id
  INNER JOIN `transactions`
    ON `transactions`.`reference_id` = `user_payments`.`id`
  INNER JOIN owner_recruits
    ON user_payments.owner_recruit_id = owner_recruits.id
  INNER JOIN owners
    ON owners.id = owner_recruits.owner_id
  INNER JOIN mst_happy_moneys
    ON mst_happy_moneys.`id` = owner_recruits.`happy_money_id`
WHERE owners.display_flag = 1
  AND users.display_flag = 1
  AND `user_payment_status` = 0
  AND user_payments.display_flag = 1
  AND `transactions`.`payment_case_id` = 2
  AND transactions.owner_id = ?
GROUP BY owners.`id` ";
            $query = $this->db->query($sql, array($ownerId));
        }
        return $query->row_array();
    }

    /**
     * @author     [IVS] Nguyen Van Vui
     * @name 	ss06
     * @todo 	send mail bank details to Joyspe
     * @param 	$id
     * @return
     */
    public function ss06($userId = null, $id = null) {
        if ($userId == NULL) {
            $sql = 'SELECT
        owners.storename,
        owners.email_address,
        payments.`created_date` AS date_payment,
        mst_payment_methods.`name` AS payment_case,
        payments.`amount`,
        payments.`point`

      FROM
        payments
        INNER JOIN owners
          ON owners.id = payments.owner_id
        INNER JOIN `mst_payment_methods`
          ON payments.`payment_method_id` = `mst_payment_methods`.`id`
      WHERE payments.display_flag = 1
        AND payments.id = ?
         GROUP BY owners.`id`';
            return $this->db->query($sql, array($id))->row_array();
        } else {
            $sql = "SELECT
  owners.storename,
  owners.`email_address`,
  `transactions`.`amount`,
  `transactions`.`point`,
  `transactions`.`created_date` AS date_payment,
  CASE
    1
    WHEN 1
    THEN 'ポイント'
  END AS payment_case
FROM
  users
  INNER JOIN user_recruits
    ON users.id = user_recruits.user_id
  INNER JOIN `user_payments`
    ON user_payments.`user_id` = users.id
  INNER JOIN `transactions`
    ON `transactions`.`reference_id` = `user_payments`.`id`
  INNER JOIN owner_recruits
    ON user_payments.owner_recruit_id = owner_recruits.id
  INNER JOIN owners
    ON owners.id = owner_recruits.owner_id
  INNER JOIN mst_happy_moneys
    ON mst_happy_moneys.`id` = owner_recruits.`happy_money_id`
WHERE owners.display_flag = 1
  AND users.display_flag = 1
  AND `user_payment_status` = 6
  AND user_payments.display_flag = 1
  AND users.`id` = ?
  AND transactions.owner_id = ?
  AND `transactions`.`payment_case_id` = 3
GROUP BY owners.`id` ";
            $query = $this->db->query($sql, array($userId, $id));
            return $query->row_array();
        }
    }

    /**
     * @author : [IVS] Nguyen Ngoc  Phuong
     * @name : ow07
     * @param: user id and owner id
     */
    public function ow07($userId = null, $ownerId = null) {
        $sql = "SELECT DISTINCT
                ow.id, ow.storename, ow.email_address, ow.password, ow.address,
                ors.apply_tel AS tel, ow.bank_name, ow.branch_name, ow.account_type, ow.account_no,
                ow.account_name, pm.amount, pm.point, pm.created_date AS date_payment,
                mpm.name AS payment_case, ow.total_point AS total_point_ap, pm.amount_payment, pm.point_payment,
                ow.total_point + SUM(t.point) AS total_point_bp, pm.amount AS amount1,
                pm.payment_name, pm.tranfer_date AS transfer_date, mhm.user_happy_money, mhm.joyspe_happy_money,
                up.`request_money_date`, u.unique_id, mcu.name AS user_city, COUNT(t.id) AS scout_number,
                ors.home_page_url, mcg.`name` AS `owner_city_group`, mc.name AS owner_city,
                mt.`name` AS owner_town, ors.how_to_access, ors.salary, CONCAT(ma.name1, ' ~ ', ma.name2) AS age,
                CONCAT(mh.name1, ' ~ ', mh.name2) AS height, u.bust, u.waist, u.  hip

                FROM owner_recruits ors
                LEFT JOIN owners ow ON ors.owner_id = ow.id
                LEFT JOIN payments pm ON ow.id = pm.owner_id
                LEFT JOIN transactions t ON ow.id = t.owner_id
                LEFT JOIN mst_payment_methods mpm ON pm.payment_method_id = mpm.id
                LEFT JOIN mst_happy_moneys mhm ON ors.happy_money_id = mhm.id
                LEFT JOIN list_user_messages l ON ors.id = l.owner_recruit_id
                LEFT JOIN users u ON l.user_id = u.id
                LEFT JOIN user_recruits urs ON u.id = urs.user_id
                LEFT JOIN `user_payments` up ON ors.id = up.owner_recruit_id
                LEFT JOIN mst_ages ma ON urs.age_id = ma.id
                LEFT JOIN mst_height mh ON urs.height_id = mh.id
                LEFT JOIN mst_cities mcu ON urs.city_id = mcu.id
                LEFT JOIN mst_cities mc ON ors.city_id = mc.id
                LEFT JOIN mst_city_groups mcg ON mc.city_group_id = mcg.id
                LEFT JOIN mst_towns mt ON ors.town_id = mt.id

                WHERE
                mc.`display_flag`=1 AND
                u.`display_flag`=1 AND
                ow.`display_flag`=1 AND
                ors.`display_flag`=1 AND
                ors.`recruit_status`=2 AND
                u.`id`=? AND
                ow.`id`= ?";
        $query = $this->db->query($sql, array($userId, $ownerId));
        return $query->row_array();
    }

    /**
     * Get store information
     * @name : ow25
     * @param: owner id
     */
    public function ow25($userId = null, $ownerId = null) {
        $get_date = date('Y-m-d H:i:s', strtotime('-3 day', strtotime(date('Y-m-d'))));
        $get_date_hr = date('Y-m-d H:i:s', strtotime('+18 hour', strtotime($get_date)));
        $sql = "SELECT SUM(CASE WHEN msg_from_flag = 0 THEN 1 ELSE 0 END) as count, ow.`id`, ow.`storename`, ow.`email_address`
                FROM list_user_owner_messages AS luom
                INNER JOIN owners AS ow ON luom.`owner_id` = ow.`id`
                INNER JOIN owner_recruits AS ors ON ow.`id` = ors.`owner_id`
                WHERE ow.`id` = ? AND
                      ow.`set_send_mail` = 1 AND
                      luom.`is_read_flag` = 1 AND 
                      luom.`msg_from_flag` = 0 AND
                      luom.`display_flag` = 1 AND
                      ow.`display_flag` = 1 AND
                      ors.`display_flag` = 1 AND
                      ors.`recruit_status` = 2 AND
                      luom.`created_date` >= ?
                GROUP BY ow.`id`";
        $query = $this->db->query($sql, array($ownerId, $get_date_hr));
        return $query->row_array();
    }

    /**
     * @author : [IVS] Jeffrey Sabellon
     * @name : ow24
     * @param: user id and owner id
     */
    public function ow24($userId = null, $ownerId = null) {
        $sql = "SELECT DISTINCT
                ow.id, ow.storename, ow.email_address, ow.password, ow.address,
                ors.apply_tel AS tel, ow.bank_name, ow.branch_name, ow.account_type, ow.account_no,
                ow.account_name, pm.amount, pm.point, pm.created_date AS date_payment,
                mpm.name AS payment_case, ow.total_point AS total_point_ap, pm.amount_payment, pm.point_payment,
                ow.total_point + SUM(t.point) AS total_point_bp, pm.amount AS amount1,
                pm.payment_name, pm.tranfer_date AS transfer_date, mhm.user_happy_money, mhm.joyspe_happy_money,
                up.`request_money_date`, u.unique_id, mcu.name AS user_city, COUNT(t.id) AS scout_number,
                ors.home_page_url, mcg.`name` AS `owner_city_group`, mc.name AS owner_city,
                mt.`name` AS owner_town, ors.how_to_access, ors.salary, CONCAT(ma.name1, ' ~ ', ma.name2) AS age,
                CONCAT(mh.name1, ' ~ ', mh.name2) AS height, u.bust, u.waist, u.  hip

                FROM owner_recruits ors
                LEFT JOIN owners ow ON ors.owner_id = ow.id
                LEFT JOIN payments pm ON ow.id = pm.owner_id
                LEFT JOIN transactions t ON ow.id = t.owner_id
                LEFT JOIN mst_payment_methods mpm ON pm.payment_method_id = mpm.id
                LEFT JOIN mst_happy_moneys mhm ON ors.happy_money_id = mhm.id
                LEFT JOIN list_user_messages l ON ors.id = l.owner_recruit_id
                LEFT JOIN users u ON l.user_id = u.id
                LEFT JOIN user_recruits urs ON u.id = urs.user_id
                LEFT JOIN `user_payments` up ON ors.id = up.owner_recruit_id
                LEFT JOIN mst_ages ma ON urs.age_id = ma.id
                LEFT JOIN mst_height mh ON urs.height_id = mh.id
                LEFT JOIN mst_cities mcu ON urs.city_id = mcu.id
                LEFT JOIN mst_cities mc ON ors.city_id = mc.id
                LEFT JOIN mst_city_groups mcg ON mc.city_group_id = mcg.id
                LEFT JOIN mst_towns mt ON ors.town_id = mt.id

                WHERE
                mc.`display_flag`=1 AND
                u.`display_flag`=1 AND
                ow.`display_flag`=1 AND
                ors.`display_flag`=1 AND
                ors.`recruit_status`=2 AND
                u.`id`=? AND
                ow.`id`= ?";
        $query = $this->db->query($sql, array($userId, $ownerId));
        return $query->row_array();
    }

    /**
     * @author : [IVS]Nguyen Ngoc Phuong
     * @name : ow13
     * @param: user id and owner id
     */
    public function ow13($userId = null, $ownerId = null) {
        $sql = "SELECT DISTINCT
                ow.id, ow.storename, ow.email_address, ow.password, ow.address,
                ors.apply_tel AS tel, ow.bank_name, ow.branch_name, ow.account_type, ow.account_no,
                ow.account_name, pm.amount, pm.point, pm.created_date AS date_payment,
                mpm.name AS payment_case, ow.total_point AS total_point_ap, pm.amount_payment, pm.point_payment,
                ow.total_point + SUM(t.point) AS total_point_bp, pm.amount AS amount1,
                pm.payment_name, pm.tranfer_date AS transfer_date, mhm.user_happy_money, mhm.joyspe_happy_money,
                up.`request_money_date`, u.unique_id, mcu.name AS user_city, COUNT(t.id) AS scout_number,
                ors.home_page_url, mcg.`name` AS `owner_city_group`, mc.name AS owner_city,
                mt.`name` AS owner_town, ors.how_to_access, ors.salary, CONCAT(ma.name1, ' ~ ', ma.name2) AS age,
                CONCAT(mh.name1, ' ~ ', mh.name2) AS height, u.bust, u.waist, u.  hip

                FROM owner_recruits ors
                LEFT JOIN owners ow ON ors.owner_id = ow.id
                LEFT JOIN payments pm ON ow.id = pm.owner_id
                LEFT JOIN transactions t ON ow.id = t.owner_id
                LEFT JOIN mst_payment_methods mpm ON pm.payment_method_id = mpm.id
                LEFT JOIN mst_happy_moneys mhm ON ors.happy_money_id = mhm.id
                LEFT JOIN list_user_messages l ON ors.id = l.owner_recruit_id
                LEFT JOIN users u ON l.user_id = u.id
                LEFT JOIN user_recruits urs ON u.id = urs.user_id
                LEFT JOIN `user_payments` up ON ors.id = up.owner_recruit_id
                LEFT JOIN mst_ages ma ON urs.age_id = ma.id
                LEFT JOIN mst_height mh ON urs.height_id = mh.id
                LEFT JOIN mst_cities mcu ON urs.city_id = mcu.id
                LEFT JOIN mst_cities mc ON ors.city_id = mc.id
                LEFT JOIN mst_city_groups mcg ON mc.city_group_id = mcg.id
                LEFT JOIN mst_towns mt ON ors.town_id = mt.id
                WHERE
                u.`display_flag`=1 AND
                ow.`display_flag`=1 AND
                u.`id`=? AND
                ow.`id`= ?";
        $query = $this->db->query($sql, array($userId, $ownerId));
        return $query->row_array();
    }

    /**
     * @author : [IVS]Nguyen Ngoc Phuong
     * @name : us01
     * @param: user id and owner id
     */
    public function us01($userId = null, $ownerId = null) {
        $sql = "SELECT 	u.email_address AS email_address, u.password, o.storename, o.address, orr.apply_tel AS tel,
                h.user_happy_money, up.request_money_date, u.unique_id AS userid, u.name,  orr.home_page_url,
                o.email_address AS owner_email_address, mcg.name AS owner_city_group,
                mc.name AS owner_city, mt.`name` AS owner_town, orr.how_to_access, orr.salary

                FROM users u
                LEFT JOIN list_user_messages l ON u.id = l.user_id
                LEFT JOIN owner_recruits orr ON l.owner_recruit_id = orr.id
                LEFT JOIN owners o ON orr.owner_id = o.id
                LEFT JOIN mst_happy_moneys h ON orr.happy_money_id = h.id
                LEFT JOIN mst_cities mc ON orr.city_id = mc.id
                LEFT JOIN mst_city_groups mcg ON mc.city_group_id = mcg.id
                LEFT JOIN mst_towns mt ON orr.town_id = mt.id
                LEFT JOIN user_payments up ON orr.id = up.owner_recruit_id
                WHERE u.display_flag = 1 AND
                u.user_status = 0 AND
                u.id = ?";
        $query = $this->db->query($sql, array($userId));
        return $query->row_array();
    }

    /**
     * @author : [IVS]Nguyen Ngoc Phuong
     * @name : ow13
     * @param: user id and owner id
     */
    public function ss02($userId = null, $ownerId = null) {
        $sql = "SELECT US.`email_address` AS email_address, US.`name`, US.`unique_id` userid
                        FROM users US
                        WHERE US.`display_flag`=1 AND
                        US.`user_status`= 1 AND
                        US.id= ?
                        ";
        $query = $this->db->query($sql, array($userId));
        return $query->row_array();
    }

    /**
     * author: [IVS] Jeffrey G. Sabellon
     * name : ow23
     * todo : scout again
     * @param int $userId, $ownerId
     * @return null
     */
    public function ow23($userId = null, $ownerId = null) {
        if ($userId != NULL) {

            $sql = "SELECT ow.id, ow.storename, ow.email_address, ow.password, ow.address,
                    ors.apply_tel AS tel, ow.bank_name, ow.branch_name, ow.account_type, ow.account_no,
                    ow.account_name, pm.amount, pm.point, pm.created_date AS date_payment,
                    mpm.name AS payment_case, ow.total_point AS total_point_ap, pm.amount_payment, pm.point_payment,
                    ow.total_point + SUM(t.point) AS total_point_bp, pm.amount AS amount1,
                    pm.payment_name, pm.tranfer_date AS transfer_date, mhm.user_happy_money, mhm.joyspe_happy_money,
                    up.`request_money_date`, COUNT(t.id) AS scout_number,
                    ors.home_page_url, mcg.`name` AS `owner_city_group`, mc.name AS owner_city,
                    mt.`name` AS owner_town, ors.how_to_access, ors.salary

                    FROM users  u
                    LEFT JOIN user_recruits ur ON u.id = ur.user_id
                    LEFT JOIN mst_ages ma ON ur.age_id = ma.id
                    LEFT JOIN mst_height mh ON ur.height_id = mh.id
                    LEFT JOIN list_user_messages l ON u.id = l.user_id
                    LEFT JOIN owner_recruits ors ON l.owner_recruit_id = ors.id
                    LEFT JOIN owners ow ON ors.owner_id = ow.id
                    LEFT JOIN `user_payments` up ON ors.id = up.owner_recruit_id
                    LEFT JOIN payments pm ON ow.id = pm.owner_id
                    LEFT JOIN transactions t ON ow.id = t.owner_id
                    LEFT JOIN mst_payment_methods mpm ON pm.payment_method_id = mpm.id
                    LEFT JOIN mst_happy_moneys mhm ON ors.happy_money_id = mhm.id
                    LEFT JOIN mst_cities mc ON ors.city_id = mc.id
                    LEFT JOIN mst_cities mcu ON ur.city_id = mcu.id
                    LEFT JOIN mst_city_groups mcg ON mc.city_group_id = mcg.id
                    LEFT JOIN mst_towns mt ON ors.town_id = mt.id
                    WHERE ow.display_flag = 1 AND u.display_flag = 1 AND ors.`display_flag`=1 AND ow.id = ? AND u.id = ?";

            $query = $this->db->query($sql, array($ownerId, $userId));
            return $query->row_array();
        } else {
            $sql = "SELECT ow.id, ow.storename, ow.email_address, ow.password, ow.address,
                ors.apply_tel AS tel, ow.bank_name, ow.branch_name, ow.account_type, ow.account_no,
                ow.account_name, pm.amount, pm.point, pm.created_date AS date_payment,
                mpm.name AS payment_case, ow.total_point AS total_point_ap, pm.amount_payment, pm.point_payment,
                ow.total_point + SUM(t.point) AS total_point_bp, pm.amount AS amount1,
                pm.payment_name, pm.tranfer_date AS transfer_date, mhm.user_happy_money, mhm.joyspe_happy_money,
                up.`request_money_date`, COUNT(t.id) AS scout_number,
                ors.home_page_url, mcg.`name` AS `owner_city_group`, mc.name AS owner_city,
                mt.`name` AS owner_town, ors.how_to_access, ors.salary

                FROM owners ow
                LEFT JOIN owner_recruits ors ON ow.id = ors.owner_id
                LEFT JOIN payments pm ON ow.id = pm.owner_id
                LEFT JOIN transactions t ON ow.id = t.owner_id
                LEFT JOIN mst_payment_methods mpm ON pm.payment_method_id = mpm.id
                LEFT JOIN mst_happy_moneys mhm ON ors.happy_money_id = mhm.id
                LEFT JOIN list_user_messages l ON ors.id = l.owner_recruit_id
                LEFT JOIN users u ON l.user_id = u.id
                LEFT JOIN user_recruits urs ON u.id = urs.user_id
                LEFT JOIN `user_payments` up ON ors.id = up.owner_recruit_id
                LEFT JOIN mst_ages ma ON urs.age_id = ma.id
                LEFT JOIN mst_height mh ON urs.height_id = mh.id
                LEFT JOIN mst_cities mcu ON urs.city_id = mcu.id
                LEFT JOIN mst_cities mc ON ors.city_id = mc.id
                LEFT JOIN mst_city_groups mcg ON mc.city_group_id = mcg.id
                LEFT JOIN mst_towns mt ON ors.town_id = mt.id
                WHERE ow.`id` = ? AND ors.`display_flag`=1
                GROUP BY ow.`id` ";
            $query = $this->db->query($sql, array($ownerId));
            return $query->row_array();
        }
    }




    /**
     * author: [IVS] Nguyen Bao Trieu
     * name : getUserSelect
     * todo : get User Select
     * @param array $userIds
     * @return data
     */
    public function getUserSelect($ownerId = null, $userIds = null) {
        $this->db->select("users.id as user_id, old_id AS login_id, password, unique_id, users.name as username, mst_cities.name as user_city,CONCAT(ma.name1, ' ~ ', ma.name2) AS age, CONCAT(mh.name1, ' ~ ', mh.name2) AS height, users.bust, users.waist, users.hip",false);
        $this->db->from('users');
        $this->db->join('user_recruits ur','ur.user_id = users.id');
        $this->db->join('mst_height mh','ur.height_id = mh.id');
        $this->db->join('mst_ages ma','ur.age_id = ma.id');
        $this->db->join('user_recruits', 'users.id = user_recruits.user_id');
        $this->db->join('mst_cities', 'user_recruits.city_id = mst_cities.id');
        $this->db->where('user_recruits.display_flag', 1);
        $this->db->where_in('users.id', $userIds);
        return $this->db->get()->result_array();
    }

    public function getUserSelect1($ownerId = null, $userId = null) {
      $sql = "SELECT us.id AS user_id, us.unique_id, us.name AS username, mc.name AS user_city,
        mc.name AS owner_city, mcg.name AS owner_city_group, mt.name AS owner_town,
        owr.how_to_access, ow.address, owr.apply_tel AS tel,
        ow.email_address AS owner_email_address, owr.salary

        FROM users us
        LEFT JOIN user_recruits usr ON us.id = usr.user_id
        LEFT JOIN list_user_messages l ON us.id = l.user_id
        LEFT JOIN owner_recruits owr ON l.owner_recruit_id = owr.id
        LEFT JOIN owners ow ON owr.owner_id = ow.id
        LEFT JOIN mst_cities mc ON usr.city_id = mc.id
        LEFT JOIN mst_city_groups mcg ON mcg.id = mc.`city_group_id`
        LEFT JOIN mst_towns mt ON mt.id = owr.`town_id`
        WHERE usr.display_flag = 1
        AND owr.recruit_status = 2
#        AND owr.display_flag = 1
        AND ow.display_flag = 1
        AND us.id = ?
        AND owr.id = ?";

      $query = $this->db->query($sql, array($userId, $ownerId));
      return $query->result_array();
    }


    /**
     * author: [IVS]
     * name : getUserSelect
     * todo : get User Select
     * @param array $userIds
     * @return data
     */
    public function getManyUserSelect($ownerId = null, $userIdArr = null) {
        $this->db->select('users.id as user_id,users.unique_id, users.name as username, mst_cities.name as user_city,owners.email_address,
          owners.address,
          mst_cities.name as owner_city,
          mst_happy_moneys.user_happy_money,
          mst_happy_moneys.joyspe_happy_money,
          user_payments.owner_recruit_id');
        $this->db->from('users');
        $this->db->join('user_recruits', 'users.id = user_recruits.user_id');
        $this->db->join('mst_cities', 'user_recruits.city_id = mst_cities.id');
        $this->db->join('user_payments', 'users.id = user_payments.user_id');
        $this->db->join('owner_recruits', 'user_payments.owner_recruit_id = owner_recruits.id ');
        $this->db->join('mst_happy_moneys', 'owner_recruits.happy_money_id = mst_happy_moneys.id ');
        $this->db->join('owners', 'owners.id = owner_recruits.owner_id ');
        $this->db->where('owner_recruits.owner_id', $ownerId);
        $this->db->where('user_payments.user_payment_status', 1);
        $this->db->where('user_recruits.display_flag', 1);
        $this->db->where_in('users.id', $userIdArr);


        return $this->db->get()->result_array();
    }

    /**
     * author: [IVS] Lam Tu My Kieu
     * name : getJobTypeSelect
     * todo : getJobTypeSelect
     * @param array $userIds
     * @return data
     */
    public function getJobTypeSelect($userId = null) {
        $sql = "SELECT j.`name` as jobtype_user
                        FROM users u
                        INNER JOIN job_type_users ju ON ju.`user_id` = u.`id`
                        INNER JOIN mst_job_types j ON j.`id` = ju.`job_type_id`
                        WHERE u.`display_flag`=1 AND
                        u.`user_status` = 1 AND
                        u.id =  ?";
        $query = $this->db->query($sql, $userId);
        return $query->result_array();
    }

    /**
     * author: [IVS] Lam Tu My Kieu
     * name : getJobTypeOwner
     * todo : getJobTypeOwner
     * @param array $ownerId
     * @return data
     */
    public function getJobTypeOwner($ownerId, $userId) {
        $sql = "SELECT j.`name` AS jobtype_owner
                        FROM owners o
                        INNER JOIN owner_recruits owr ON owr.`owner_id` = o.`id`
                        INNER JOIN user_payments up ON up.`owner_recruit_id`=owr.`id`
                        INNER JOIN job_type_owners jo ON jo.`owner_recruit_id` = owr.`id`
                        INNER JOIN mst_job_types j ON j.`id` = jo.`job_type_id`
                        WHERE o.`display_flag` = 1 AND
                        o.`id`=?
                        AND up.`user_id`=?";
        $query = $this->db->query($sql, array($ownerId, $userId));
        return $query->result_array();
    }

    /**
     * author: [IVS] Phan Ngoc Minh Luan
     * name : getJobTypeOwner
     * todo : getJobTypeOwner
     * @param array $ownerId
     * @return data
     */
    public function getJobOwnerForScout($ownerId = null, $userId = null) {
        $sql = "SELECT DISTINCT j.`name` AS jobtype_owner
                        FROM owners o
                        INNER JOIN owner_recruits owr ON owr.`owner_id` = o.`id`
                        INNER JOIN job_type_owners jo ON jo.`owner_recruit_id` = owr.`id`
                        INNER JOIN mst_job_types j ON j.`id` = jo.`job_type_id`
                        WHERE o.`display_flag` = 1 AND owr.`display_flag` = 1 AND owr.`recruit_status`=2 AND
                        o.`id`= ?";
        $query = $this->db->query($sql, array($ownerId));
        return $query->result_array();
    }

    /**
     * author: [IVS] Lam Tu My Kieu
     * name : getJobTypeOwnerForScout
     * todo : getJobTypeOwnerForScout
     * @param array $ownerId
     * @return data
     */
    public function getJobTypeOwnerForScout($ownerId, $userId) {
        $sql = "SELECT j.`name` AS jobtype_owner, owr.id
                        FROM owners o
                        INNER JOIN owner_recruits owr ON owr.`owner_id` = o.`id`
                        INNER JOIN list_user_messages l ON l.`owner_recruit_id`=owr.`id`
                        INNER JOIN mst_templates mt ON mt.`id`=l.`template_id`
                        INNER JOIN job_type_owners jo ON jo.`owner_recruit_id` = owr.`id`
                        INNER JOIN mst_job_types j ON j.`id` = jo.`job_type_id`
                        WHERE o.`display_flag` = 1 AND
                        o.`id`=?
                        AND (mt.`template_type`='us03' || mt.`template_type`='us14')
                        AND owr.`display_flag`=1
                        AND l.`user_id`=?";
        $query = $this->db->query($sql, array($ownerId, $userId));
        return $query->result_array();
    }

    /**
     * @author: [IVS] Nguyen Hong Duc
     * @name : getJobUser
     * @todo : get Job User
     * @param $userId
     * @return data
     */
    public function getJobUser($userId = null) {
        $this->db->distinct();
        $this->db->select('mst_job_types.name as jobtype_user');
        $this->db->from('users');
        $this->db->join('job_type_users', 'users.id = job_type_users.user_id');
        $this->db->join('mst_job_types', 'job_type_users.job_type_id = mst_job_types.id');
        $this->db->where('mst_job_types.display_flag', 1);
        $this->db->where('users.display_flag', 1);
        $this->db->where('users.id', $userId);
        return $this->db->get()->result_array();
    }

    /**
     * @author: [IVS] Nguyen Minh Ngoc
     * @name : getJobOwner
     * @todo : get Job Owner
     * @param $ownerId
     * @return data
     */
    public function getJobOwner($ownerId = null, $userId = null) {
        $sql = "SELECT DISTINCT `mst_job_types`.`name` AS jobtype_owner
            FROM (`owner_recruits`)
            INNER JOIN `job_type_owners` ON `job_type_owners`.`owner_recruit_id` = `owner_recruits`.`id`
            INNER JOIN `mst_job_types` ON `job_type_owners`.`job_type_id` = `mst_job_types`.`id`
            LEFT JOIN user_payments ON `user_payments`.`owner_recruit_id` = `job_type_owners`.`owner_recruit_id`
            WHERE `mst_job_types`.`display_flag` = 1 AND `owner_recruits`.`display_flag` = 1
            AND `owner_recruits`.`owner_id` = ?";
        if ($userId != null) {
            $sql .= " AND  user_payments.`user_id`=?";
        }
        $query = $this->db->query($sql, array($ownerId, $userId));
        return $query->result_array();

//        $this->db->distinct();
//        $this->db->select('mst_job_types.name as jobtype_owner');
//        $this->db->from('owner_recruits');
//        $this->db->join('job_type_owners', 'job_type_owners.owner_recruit_id = owner_recruits.id ');
//        $this->db->join('mst_job_types', 'job_type_owners.job_type_id = mst_job_types.id');
//        $this->db->join('user_payments', 'user_payments.owner_recruit_id = job_type_owners.owner_recruit_id');
//        $this->db->where('mst_job_types.display_flag', 1);
//        $this->db->where_in('user_payments.user_id', $userId);
//        $this->db->where('owner_recruits.owner_id', $ownerId);
//        return $this->db->get()->result_array();
    }

    /**
     * @author: [IVS] Nguyen Minh Ngoc
     * @name : getJobOwner
     * @todo : get Job Owner
     * @param $ownerId
     * @return data
     */
    public function getJobOwnerNoDisplay($ownerId = null, $userId = null) {
        $sql = "SELECT DISTINCT `mst_job_types`.`name` AS jobtype_owner
            FROM (`owner_recruits`)
            INNER JOIN `job_type_owners` ON `job_type_owners`.`owner_recruit_id` = `owner_recruits`.`id`
            INNER JOIN `mst_job_types` ON `job_type_owners`.`job_type_id` = `mst_job_types`.`id`
            INNER JOIN user_payments ON `user_payments`.`owner_recruit_id` = `job_type_owners`.`owner_recruit_id`
            WHERE `mst_job_types`.`display_flag` = 1
            AND `owner_recruits`.`owner_id` = ?";
        if ($userId != null) {
            $sql .= " AND  user_payments.`user_id`=?";
        }
        $query = $this->db->query($sql, array($ownerId, $userId));
        return $query->result_array();

    }

    /**
     * @author: [IVS] Phan Ngoc Minh Luan
     * @name : getJobOwnerRecruit
     * @todo : get Job OwnerRecruit for old and new
     * @param $ownerId, userId
     * @return data
     */
    public function getJobOwnerRecruit($ownerRecruitId = null, $userId = null) {
        $this->db->distinct();
        $this->db->select('mst_job_types.name as jobtype_owner');
        $this->db->from('owner_recruits');
        $this->db->join('job_type_owners', 'job_type_owners.owner_recruit_id = owner_recruits.id ');
        $this->db->join('mst_job_types', 'job_type_owners.job_type_id = mst_job_types.id');
        $this->db->join('user_payments', 'user_payments.owner_recruit_id = job_type_owners.owner_recruit_id');
        $this->db->where('mst_job_types.display_flag', 1);
        $this->db->where('user_payments.user_id', $userId);
        $this->db->where('owner_recruits.id', $ownerRecruitId);
        return $this->db->get()->result_array();
    }

		public function getJobOwnerRecruito01($ownerRecruitId = null) {
        $this->db->distinct();
        $this->db->select('mst_job_types.name as jobtype_owner');
        $this->db->from('owner_recruits');
        $this->db->join('job_type_owners', 'job_type_owners.owner_recruit_id = owner_recruits.id ');
        $this->db->join('mst_job_types', 'job_type_owners.job_type_id = mst_job_types.id');
        $this->db->where('mst_job_types.display_flag', 1);
        $this->db->where('owner_recruits.id', $ownerRecruitId);
        return $this->db->get()->result_array();
    }

    /**
     * @author:[IVS] Nguyen Ngoc Phuong
     * @name: us13
     * @param: $user_id
     * @return: data
     */
    public function us13($user_id) {
        $sql = "SELECT unique_id, password, email_address FROM users  WHERE users.id = ?";
        $query = $this->db->query($sql, array($user_id));
        return $query->row_array();
    }
    /**
     * @author:[IVS] Nguyen Ngoc Phuong
     * @name: us032
     * @param: $user_id,$owner_recruitsid
     * @return: data
     * @todo : get information of owner by $owner_recruitsid
     */
     public function us032( $userId, $owner_recruitsid, $scout_mail_id = null) {
       if ( !$userId || !$owner_recruitsid ) {
         return null;
       }
      $sql = 'SELECT  `user_happy_money`,u.email_address,
              o.storename, u.name AS username, u.unique_id, mc.name AS owner_city,
              IFNULL(IFNULL(ospt.pr_text, orr.scout_pr_text), "") as scout_pr_text,
              IFNULL(ospt.pr_title, "") as scout_pr_title
			  FROM users u
			  INNER JOIN list_user_messages l ON l.user_id = u.id
			  LEFT JOIN owner_scout_pr_text ospt ON ospt.id = l.owner_scout_mail_pr_id
			  INNER JOIN owner_recruits orr ON l.owner_recruit_id = orr.id
			  INNER JOIN owners o ON o.id = orr.owner_id
			  INNER JOIN mst_happy_moneys h ON h.`id` = orr.`happy_money_id`
			  INNER JOIN mst_cities mc ON mc.`id`=orr.`city_id`
			  WHERE o.display_flag = 1 AND u.display_flag = 1  AND orr.id = ? AND u.id = ?';// AND l.`template_id`=25';
      $params = array($owner_recruitsid, $userId);
	  if ( $scout_mail_id ) {
		$sql .= " AND l.id = ? ";
		$params[] = $scout_mail_id;
	  }
	 $query = $this->db->query($sql, $params);
	 return $query->row_array();
    }

    /**
     * @author: [IVS] Nguyen Ngoc Phuong
     * @name : getJobOwnerByOwnerRecruits
     * @todo : get Job Owner when show us03
     * @param $ownerId
     * @return data
     */
    public function getJobOwnerByOwnerRecruits($ownerId = null, $userId = null) {
        $sql = " SELECT  `mst_job_types`.`name` AS jobtype_owner
            FROM `owner_recruits` orr
            INNER JOIN owners ON orr.owner_id = owners.`id`
            INNER JOIN job_type_owners jto ON jto.`owner_recruit_id` = orr.id
            INNER JOIN mst_job_types ON jto.`job_type_id` = mst_job_types.`id`
            WHERE owners.`display_flag` = 1 AND mst_job_types.`display_flag` =1
            AND orr.id = ? " ;
        $query = $this->db->query($sql, array($ownerId));
        return $query->result_array();

    }

    /**
     * author: [IVS] Jeffrey G. Sabellon
     * name : us14
     * todo : get user
     * @param int $userId, $ownerId
     * @return null
     */
    public function us14($userId = null, $ownerId = null, $scout_mail_id = null) {
      $sql = "SELECT	u.email_address AS email_address, u.password, o.storename, o.address, orr.apply_tel AS tel,
                  h.user_happy_money, up.request_money_date, u.unique_id, u.name AS username, orr.home_page_url,
                  o.email_address AS owner_email_address, mcg.name AS owner_city_group, o.unique_id AS owner_unique_id,
                  mc.name AS owner_city, mt.`name` AS owner_town, orr.how_to_access, orr.salary, u.old_id AS login_id,
                  orr.id AS owner_recrt_id,
                  IFNULL(IFNULL(ospt.pr_text, orr.scout_pr_text), '') as scout_pr_text,
                  IFNULL(ospt.pr_title, '') as scout_pr_title

                  FROM users u
                  LEFT JOIN list_user_messages l ON u.id = l.user_id
                  LEFT JOIN owner_scout_pr_text ospt ON ospt.id = l.owner_scout_mail_pr_id
                  LEFT JOIN owner_recruits orr ON l.owner_recruit_id = orr.id
                  LEFT JOIN owners o ON orr.owner_id = o.id
                  LEFT JOIN mst_happy_moneys h ON orr.happy_money_id = h.id
                  LEFT JOIN mst_cities mc ON orr.city_id = mc.id
                  LEFT JOIN mst_city_groups mcg ON mc.city_group_id = mcg.id
                  LEFT JOIN mst_towns mt ON orr.town_id = mt.id
                  LEFT JOIN user_payments up ON orr.id = up.owner_recruit_id
                  WHERE o.display_flag = 1 AND u.display_flag = 1 AND orr.display_flag = 1 AND orr.recruit_status = 2 AND o.id = ?
            AND u.id = ? AND l.template_id = 63";
            $params = array($ownerId, $userId);
            if ($scout_mail_id) {
                $sql .= " AND l.id = ? ";
                $params[] = $scout_mail_id;
            }
            $query = $this->db->query($sql, $params);
      return $query->row_array();
    }

    public function us1401($userId, $ownerId, $ownerRecruitId, $scout_mail_id = null) {
      if ( !$userId || !$ownerId || !$ownerRecruitId) {
        return null;
      }

      $sql = "SELECT u.email_address AS email_address, u.password, o.storename, o.address, orr.apply_tel AS tel,
              h.user_happy_money, up.request_money_date, u.unique_id, u.name AS username, orr.home_page_url,
              o.email_address AS owner_email_address, mcg.name AS owner_city_group, o.unique_id AS owner_unique_id,
              mc.name AS owner_city, mt.`name` AS owner_town, orr.how_to_access, orr.salary, u.old_id AS login_id,
              orr.id AS owner_recrt_id,
              IFNULL(IFNULL(ospt.pr_text, orr.scout_pr_text), '') as scout_pr_text

              FROM users u
              LEFT JOIN list_user_messages l ON u.id = l.user_id
              LEFT JOIN owner_recruits orr ON l.owner_recruit_id = orr.id
              LEFT JOIN owners o ON orr.owner_id = o.id
              LEFT JOIN mst_happy_moneys h ON orr.happy_money_id = h.id
              LEFT JOIN mst_cities mc ON orr.city_id = mc.id
              LEFT JOIN mst_city_groups mcg ON mc.city_group_id = mcg.id
              LEFT JOIN mst_towns mt ON orr.town_id = mt.id
              LEFT JOIN user_payments up ON orr.id = up.owner_recruit_id
              LEFT JOIN owner_scout_pr_text ospt on (l.owner_scout_mail_pr_id = ospt.id and ospt.owner_id = o.id)
              WHERE o.display_flag = 1 AND u.display_flag = 1 AND o.id = ?
              AND u.id = ? AND l.template_id = 63 and orr.id = ?";
      $params = array($ownerId, $userId, $ownerRecruitId);
      if ( $scout_mail_id ) {
        $sql     .= " AND l.id = ? ";
        $params[] = $scout_mail_id;
      }
      $sql .= " LIMIT 1";
      $query = $this->db->query( $sql, $params );
      return $query->row_array();
    }

    public function getOwnerRecruitHappyMoney($id) {
      $sql = "select MHM.user_happy_money
              from owner_recruits ORS
              INNER JOIN mst_happy_moneys MHM
              ON MHM.id = ORS.happy_money_id
              where ORS.id =?";
      $query = $this->db->query($sql, $id);
      return $query->result_array();

    }
    public function getSentNewsletterDataSs09($id,$user_id) {
        $ret = null;
        $sql = "SELECT lm.id,lm.owner_recruit_id,lm.user_id,sl.list_user_message_id,sl.mail_content,sl.mail_title
              FROM list_user_messages AS lm
              INNER JOIN admin_scout_mail_log AS sl ON lm.id=sl.list_user_message_id
              WHERE lm.id = ?
              AND lm.user_id = ?";
        $query = $this->db->query($sql,array($id,$user_id));
        if ($query) {
            $ret = $query->row_array();
        }
        return $ret;
    }
	public function newTemplateTitle($user_id,$id) {
		$sql = "SELECT lum.id,lum.user_id,lum.owner_scout_mail_pr_id,prtxt.pr_title
				FROM list_user_messages lum
				INNER JOIN owner_scout_pr_text AS prtxt ON lum.owner_scout_mail_pr_id = prtxt.id
				WHERE lum.user_id = ? AND lum.id = ?
				";
		$query = $this->db->query($sql,array($user_id,$id));
		return $query->row_array();
	}
	public function convertTitle($user_id) {
		$sql = "SELECT lum.id,lum.user_id, lum.owner_scout_mail_pr_id,ospt.title
				FROM list_user_messages lum
				INNER JOIN owner_scout_pr_text ospt ON lum.owner_scout_mail_pr_id = ospt.id
				WHERE lum.user_id = ?
				ORDER BY lum.id DESC
				LIMIT 5";
		$query  = $this->db->query($sql,array($user_id));
		return $query->result_array();
	}

}

?>

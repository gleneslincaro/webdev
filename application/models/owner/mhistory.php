<?php

class Mhistory extends CommonQuery {

    function __construct() {
        parent::__construct();
    }

    /**
     * @author  [IVS] Phan Ngoc Minh Luan
     * @name 	getUserProfiles
     * @todo 	get User Profiles
     * @param 	int $user_id
     * @return 	array
     */
    public function getUserProfiles($user_id,$owner_recruit_id=null) {
        $this->db->select('user_recruits.user_id as uid,unique_id, users.user_from_site, users.profile_pic, users.name as user_name, mst_cities.name as city_name, mst_ages.name1 as age_name1, mst_ages.name2 as age_name2, user_payments.apply_date, user_payments.request_money_date');
        $this->db->from('user_recruits');
        $this->db->join('users', 'users.id = user_recruits.user_id');
        $this->db->join('mst_ages', 'mst_ages.id = user_recruits.age_id', 'left');
        $this->db->join('mst_cities', 'mst_cities.id = user_recruits.city_id', 'left');
        $this->db->join('user_payments', 'user_payments.user_id = user_recruits.user_id');
        $this->db->where('user_recruits.user_id', $user_id);
        if ( $owner_recruit_id ){
            $this->db->where('user_payments.owner_recruit_id', $owner_recruit_id);
        }
        $this->db->group_by('user_recruits.user_id');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return 0;
    }

    /**
     * @author  [IVS] Phan Ngoc Minh Luan
     * @name 	getSmallUserProfiles
     * @todo 	get a few User Profiles
     * @param 	int $user_id
     * @return 	array
     */
    public function getSmallUserProfiles($user_id) {
        $this->db->select('user_recruits.user_id uid, unique_id, mst_cities.name as city_name, mst_ages.name1 as age_name1, mst_ages.name2 as age_name2, scout_message_spams.user_id = user_recruits.user_id as protect_spam');
        $this->db->from('user_recruits');
        $this->db->join('users', 'users.id = user_recruits.user_id');
        $this->db->join('mst_ages', 'mst_ages.id = user_recruits.age_id', 'left');
        $this->db->join('mst_cities', 'mst_cities.id = user_recruits.city_id', 'left');
        $this->db->join('scout_message_spams', 'scout_message_spams.user_id = user_recruits.user_id', 'left');
        $param = array(
            'user_recruits.user_id' => $user_id,
            'user_recruits.display_flag' => 1
        );
        $this->db->where($param);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return 0;
    }

    /**
     * @author  [IVS] Phan Ngoc Minh Luan
     * @name 	getArrUserProfiles
     * @todo 	get array User Profiles
     * @param 	int $user_id
     * @return 	array
     */
    public function getArrUserProfiles($arr_user_id) {
        $this->db->select('user_recruits.user_id uid,user_recruits.hope_salary_id,user_recruits.working_exp, users.name, users.user_from_site, users.profile_pic,
                           users.bust,users.waist,users.hip, unique_id, mst_cities.name as cityname,
                           mst_ages.name1 as age_name1, mst_ages.name2 as age_name2,
                           mst_height.name1 AS height_l, mst_height.name2 AS height_h,
                           mst_salary_range.range1 AS salary_l, mst_salary_range.range2 AS salary_h,
                           IF(DATE_ADD(IFNULL(users.accept_remote_scout_datetime, users.offcial_reg_date), INTERVAL 2 DAY) >= NOW(), 1, 0) as new_flg',
                           false);
        $this->db->from('user_recruits');
        $this->db->join('users', 'users.id = user_recruits.user_id');
        $this->db->join('mst_ages', 'mst_ages.id = user_recruits.age_id', 'left');
        $this->db->join('mst_cities', 'mst_cities.id = user_recruits.city_id', 'left');
        $this->db->join('mst_height', 'mst_height.id = user_recruits.height_id', 'left');
        $this->db->join('mst_salary_range', 'mst_salary_range.id = user_recruits.hope_salary_id', 'left');
        $param = array(
            'user_recruits.display_flag' => 1
        );
        $this->db->where($param);
        $this->db->where_in('user_recruits.user_id', $arr_user_id);
        $this->db->group_by('user_recruits.user_id');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return 0;
    }

    /**
     * @author  [IVS] Phan Ngoc Minh Luan
     * @name 	getUserJoyspeMoney
     * @todo 	get Happy Money of Joyspe
     * @param 	int $user_id, $owner_recruit_id
     * @return 	int
     */
    public function getJoyspeHappyMoney($user_id, $owner_recruit_id) {
        $this->db->select('joyspe_happy_money');
        $this->db->from('user_payments up');
        $this->db->join('owner_recruits ore', 'ore.id = up.owner_recruit_id');
        $this->db->join('mst_happy_moneys hp', 'hp.id = ore.happy_money_id');
        $cond = array(
            'user_id' => $user_id,
            'owner_recruit_id' => $owner_recruit_id,
            'up.display_flag'=>1,
        );
        $this->db->where($cond);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $row = $query->row_array();
            return $row['joyspe_happy_money'];
        }
        return 0;
    }

    /**
     * @author  [IVS] Nguyen Van Phong
     * @name 	getScoutMails
     * @todo 	get scout mails which owner sent to users
     * @param
     * @return 	array result
     */
    public function getScoutMails() {
        $sql = "
            SELECT title, content, template_type
            FROM mst_templates
            WHERE template_type IN ('us03','us14','us06', 'us05', 'us07')
        ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    /**
     * @author: [IVS] Nguyen Hong Duc
     * @name : getHistoryAppConf
     * @todo : get history app conf
     * @param $userId
     * @return data
     */
    public function getHistoryAppConf($userId, $owner_id) {
        $this->db->select('us.id AS usid,us.unique_id AS id,mct.name AS mst_cities_name,mhm.joyspe_happy_money AS mst_happy_moneys_joyspe,usp.apply_date AS user_payments_apply_date,us.email_address AS email_users,owr.id AS owner_recruit_id');
        $this->db->from('user_recruits usr');
        $this->db->join('users us', 'usr.user_id = us.id ');
        $this->db->join('user_payments usp', 'us.id = usp.user_id');
        $this->db->join('owner_recruits owr', 'usp.owner_recruit_id = owr.id');
        $this->db->join('mst_happy_moneys mhm', 'owr.happy_money_id = mhm.id');
        $this->db->join('mst_cities mct', 'usr.city_id = mct.id', 'left');
        $this->db->where('owr.owner_id', $owner_id);
        $this->db->where_in('us.id', $userId);
        $this->db->group_by('us.id');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return 0;
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

}

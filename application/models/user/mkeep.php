<?php
class Mkeep extends CI_Model{
    function __construct() {
        parent::__construct();
    }
    /*
     * @author IVS_Nguyen_Ngoc_Phuong:
     * get favorite list by user_id
     * @param: user_id, limit
     */
    function getKeepList($user_id, $limit = STORE_LIMIT, $offset = 0){
        if( $user_id && $user_id != 0){
            $data_prepare_sql = "   select distinct owner_id, lsm.owner_recruit_id
                                    from owner_recruits ors
                                    inner join list_user_messages lsm
                                    ON lsm.owner_recruit_id = ors.id and  lsm.user_id = ?
                                    AND lsm.template_id=25 AND lsm.display_flag = 1 AND lsm.payment_message_status = 1";
            $query = $this->db->query($data_prepare_sql,$user_id);
            $scout_owners_str = null;
            $scout_owner_recruits_str = null;
            //　スカウトメール送信オナーリストと求人リストID取得（スピード改善のため、sqlに使用される固定配列を先に取得）
            if ( $query ){
                $temp = $query->result_array();
                if ( $temp && is_array($temp) ){
                    $scout_owners_list = array();
                    $scout_owner_recruits_list = array();
                    foreach ($temp as $key => $value) {
                       $scout_owners_list[]  = $value['owner_id'];
                       $scout_owner_recruits_list[] = $value['owner_recruit_id'];
                    }
                    $scout_owners_str = join("','",$scout_owners_list);
                    $scout_owner_recruits_str = join("','",$scout_owner_recruits_list);
                }
            }
            //sql準備
            if ( $scout_owners_str && $scout_owner_recruits_str  ){
                $sql_and_cond = " AND ((ORS.`display_flag`=1 AND ORS.owner_id not in ( '$scout_owners_str' ))
                                  OR (ORS.id in ( '$scout_owner_recruits_str' ))) ";
            }else{
                $sql_and_cond = " AND ORS.`display_flag`=1 ";
            }
        }else{
            $sql_and_cond = " AND ORS.`display_flag`=1 ";
        }

        $sql= "SELECT ORS.id AS orid,OW.storename,
                MHM.image,ORS.main_image,ORS.image1,
                ORS.`image2`,ORS.`image3`,ORS.`image4`,
                ORS.`image5`,ORS.`image6`, ORS.`company_info`,
                MHM.`user_happy_money`,MC.`name` AS city_name, MCG.name AS group_name, MT.name AS town_name,
                ORS.apply_tel, ORS.apply_emailaddress, ORS.salary, ORS.title,
                OW.`public_info_flag`, OW.`happy_money_type`, OW.`happy_money`, ORS.`apply_tel` AS telephone
                FROM favorite_lists FL
                INNER JOIN `owner_recruits` ORS ON FL.`owner_recruit_id`=ORS.`id` AND FL.`user_id`
                INNER JOIN owners OW ON OW.`id`= ORS.`owner_id`
                INNER JOIN mst_happy_moneys MHM ON MHM.`id`= ORS.`happy_money_id`
                INNER JOIN mst_cities MC ON MC.`id`= ORS.`city_id`
                LEFT JOIN mst_city_groups MCG
                ON MCG.`id`= ORS.`city_group_id`
                LEFT JOIN mst_towns MT
                ON MT.id = ORS.`town_id`
                WHERE FL.`display_flag`=1
                AND FL.user_id= ?"
                .$sql_and_cond.
                "AND OW.owner_status=2
                AND OW.display_flag = 1
                AND MC.display_flag = 1
                AND ORS.recruit_status = 2
                ORDER BY ORS.created_date DESC limit ? OFFSET ?";
        $query = $this->db->query($sql ,array($user_id, $limit, $offset));
        return $query->result_array();
    }
     /*
     * @author IVS_Nguyen_Ngoc_Phuong:
     * get favorite list by user_id
     * @param: user_id, limit
     */
    public function countOwnerList($user_id){
        $sql="SELECT
                ORS.id AS ors_id,OW.storename, MHM.image,ORS.main_image,ORS.image1,ORS.`image2`,ORS.`image3`,ORS.`image4`,ORS.`image5`,ORS.`image6`,
                ORS.`company_info` ,MHM.`user_happy_money`,MC.`name` AS citiname, OW.`public_info_flag`
                FROM
                favorite_lists FL
                INNER JOIN `owner_recruits` ORS
                ON FL.`owner_recruit_id`=ORS.`id` AND FL.`user_id`
                INNER JOIN owners OW
                ON OW.`id`= ORS.`owner_id`
                INNER JOIN mst_happy_moneys MHM
                ON MHM.`id`= ORS.`happy_money_id`


                INNER JOIN mst_cities MC
                ON MC.`id`= ORS.`city_id`

                WHERE
                FL.`display_flag`=1
                AND FL.`user_id`=?
                AND ORS.display_flag = 1
                AND OW.display_flag = 1
                AND OW.owner_status=2
                AND MC.display_flag = 1
                AND ORS.recruit_status = 2
                ORDER BY ORS.created_date";
        return $this->db->query($sql,array($user_id))->num_rows();
    }
}
?>

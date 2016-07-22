<?php

class Mstyleworking extends CI_Model{

    function __construct() {
        parent::__construct();
    }
    /*
     * @author: IVS_Nguyen Ngoc Phuong
     * get happy money
     */
    public function getHappyMoney(){
        $sql="SELECT * FROM mst_happy_moneys WHERE display_flag=1 ORDER BY `user_happy_money`";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
     /*
     * @author: IVS_Nguyen Ngoc Phuong
     * get all hourly salary
     */
    public function getHourlySalary(){
        $sql="SELECT * FROM mst_hourly_salaries WHERE display_flag=1 ORDER BY amount";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    /*
     * @author: IVS_Nguyen Ngoc Phuong
     * get monthly salary
     */
    public function getMonthlySalary(){
        $sql="select * from mst_monthly_salaries where display_flag=1 ORDER BY amount";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function getJobTypes(){
        $sql="SELECT * FROM mst_job_types WHERE display_flag = 1 AND alph_name IS NOT NULL ORDER BY priority ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    /*
     * @author: IVS_Nguyen Ngoc Phuong
     * get treatment
     */
    public function getTreatments(){
        $sql="SELECT * FROM mst_treatments WHERE display_flag = 1 AND alph_name IS NOT NULL ORDER BY priority ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    /*
     * @author: IVS_Nguyen Ngoc Phuong
     * get  hourly salary by id
     * @param: id
     */
    public function getHourlySalaryAmount($id){
        //引数チェック
        if ( !$id ){
            return null;
        }
        $sql="select * from mst_hourly_salaries where display_flag=1 and id= ? ";
        $query = $this->db->query($sql,array($id));
        $row= $query->row_array();
        return $row['amount'];
    }
    /*
     * @author: IVS_Nguyen Ngoc Phuong
     * get  monthly salary by id
     * @param: id
     */
    public function getMonthlySalaryAmount($id){
        //引数チェック
        if ( !$id ){
            return null;
        }
        $sql="select * from mst_monthly_salaries where display_flag=1 and id=  ? ";
        $query = $this->db->query($sql,array($id));
        $row= $query->row_array();
        return $row['amount'];
    }
    /*
     * @author: IVS_Nguyen Ngoc Phuong
     * get  happy money by id
     * @param: id
     */
    public function getHappyMoneyAmount($id){
        //引数チェック
        if ( !$id ){
            return null;
        }
        $sql="select * from mst_happy_moneys where display_flag=1 and id= ? ";
        $query = $this->db->query($sql,array($id));
        $row= $query->row_array();
        return $row['user_happy_money'];
    }
    /*
     *@author: IVS_Nguyen_Ngoc_Phuong
     * search and limit
     *@param: happymoney, hourly salary,monthly salary,treatment
     */
    public function search($idcity, $sort=1, $limit=5, $user_id, $city_group_id, $info_id = 0,$owner_status=2){
        $listcity='';
        //$sort_data= ' DESC';
        $ownerapply='';
        $city_group='';
        if($user_id!=0){
             $data_prepare_sql = "  select distinct owner_id, lsm.owner_recruit_id
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
           $ownerapply =
            " AND OW.id NOT IN(
                SELECT ORS.owner_id FROM
                `user_payments` UP
                INNER JOIN `owner_recruits` ORS
                ON ORS.id= UP.`owner_recruit_id`
                WHERE
                UP.`user_id`= $user_id
                AND UP.`user_payment_status` NOT IN(2)
                )".$sql_and_cond;
        }else {
            $ownerapply = " AND ORS.`display_flag`=1 ";
        }

        if($city_group_id!=0){
            $city_group=' AND MC.`city_group_id`= '.$city_group_id;
        }
        if($idcity != ''){
            $listcity= " AND MC.id in(".$idcity.")";
        }
        if($sort!=1)
        {
           //$sort_data= " ASC";
        }
        $sql="SELECT *  FROM (SELECT  DISTINCT ORS.owner_id,ORS.id AS orid,
              OW.`storename`,MC.name, ORS.`main_image`, ORS.`image1`, ORS.`image2`, ORS.`image3`, ORS.`image4`, ORS.`image5`, ORS.`image6`, ORS.`company_info` ,
              MHM.`user_happy_money`,MHM.image, MC.name AS city_name,  MCG.name AS group_name, MSTT.name AS town_name, ORS.`title`,
              ORS.`apply_tel`, ORS.`apply_emailaddress`, ORS.`salary`, OW.`happy_money_type`, OW.`happy_money`,OW.`owner_status`

              FROM
              `owners` OW
              INNER JOIN owner_recruits ORS
              ON OW.`id`= ORS.`owner_id`
              INNER JOIN mst_happy_moneys MHM
              ON ORS.`happy_money_id`= MHM.`id`
              INNER JOIN treatments_owners
              ON ORS.`id`= treatments_owners.`owner_recruit_id`
              INNER JOIN mst_treatments MT
              ON MT.id= treatments_owners.`treatment_id`
              INNER JOIN mst_cities MC
              ON MC.`id`= ORS.`city_id`
              INNER JOIN mst_city_groups MCG
              ON MCG.`id`= ORS.`city_group_id`
              INNER JOIN mst_towns MSTT
              ON MSTT.id = ORS.`town_id`
              WHERE
              OW.public_info_flag = 1 AND
              MC.display_flag =1 AND
              ORS.recruit_status = 2 AND
              MHM.`display_flag`=1 AND
              MT.`display_flag`=1 AND
              OW.`display_flag`=1 AND
              OW.`owner_status` IN (".$owner_status.")
              AND ORS.id NOT IN ('" . $info_id . "') "
              .$listcity."  ".$city_group
              .$ownerapply.
              "
              UNION
              (
              SELECT DISTINCT
              ORS.owner_id,
              ORS.id AS orid,
              OW.`storename`,
              OW.`happy_money_type`,
              OW.`happy_money`,
              MC.name,
              ORS.`main_image`,
              ORS.`image1`,
              ORS.`image2`,
              ORS.`image3`,
              ORS.`image4`,
              ORS.`image5`,
              ORS.`image6`,
              ORS.`company_info`,
              MHM.`user_happy_money`,
              MHM.image,
              MC.name AS city_name,
              MCG.name AS group_name,
              MSTT.name AS town_name, ORS.`title`,
              ORS.`apply_tel`, ORS.`apply_emailaddress`, ORS.`salary`,
              OW.`owner_status`

              FROM
              `user_payments` UP
              INNER JOIN `owner_recruits` ORS
              ON UP.`owner_recruit_id`= ORS.`id`
              INNER JOIN `owners` OW
              ON ORS.`owner_id`= OW.id
              INNER JOIN mst_happy_moneys MHM
              ON MHM.`id`= ORS.`happy_money_id`
              INNER JOIN `treatments_owners` TWO
              ON TWO.`owner_recruit_id`= ORS.`id`
              INNER JOIN `mst_treatments` MT
              ON MT.`id`= TWO.`treatment_id`
              INNER JOIN mst_cities MC
              ON MC.`id`= ORS.`city_id`
              INNER JOIN mst_city_groups MCG
              ON MCG.`id`= ORS.`city_group_id`
              INNER JOIN mst_towns MSTT
              ON MSTT.id = ORS.`town_id`

              WHERE
              OW.public_info_flag = 1 AND
              MC.display_flag =1
              AND OW.display_flag =1
              AND MT.`display_flag`=1
              AND MHM.`display_flag`=1
              AND OW.owner_status IN (".$owner_status.")
              AND UP.user_id=$user_id
              AND UP.`user_payment_status` NOT IN(2)
              AND ORS.id NOT IN ('" . $info_id . "') "
              .$listcity." ".$city_group.
              "
              )) AS Phuong ORDER BY RAND()
              LIMIT ".$limit;
         $query = $this->db->query($sql);
         return $query->result_array();
    }

    public function search_keyword($sort=1, $limit=5, $user_id, $keyword, $offset=0, $info_id=0, $owner_status = 2){
        if($keyword != null && $keyword != '') {
          $keyword =  $this->db->escape_like_str($keyword);
          //$sort_data= ' DESC';
          $ownerapply='';
          if($user_id!=0){
               $data_prepare_sql = "  select distinct owner_id, lsm.owner_recruit_id
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
             $ownerapply =
              " AND OW.id NOT IN(
                  SELECT ORS.owner_id FROM
                  `user_payments` UP
                  INNER JOIN `owner_recruits` ORS
                  ON ORS.id= UP.`owner_recruit_id`
                  WHERE
                  UP.`user_id`= $user_id
                  AND UP.`user_payment_status` NOT IN(2)
                  )".$sql_and_cond;
          }else {
              $ownerapply = " AND ORS.`display_flag`=1 ";
          }
          /*
          if($sort!=1)
            $sort_data= " ASC";
          */
          $keyword_cond = "AND (ORS.company_info like '%$keyword%' OR OW.storename like '%$keyword%' OR ORS.title like '%$keyword%' OR jt.priority_name LIKE '%$keyword%' ";
          $keyword_cond = $keyword_cond."OR ORS.work_place like '%$keyword%' OR ORS.how_to_access LIKE '%$keyword%' OR ORS.salary LIKE '%$keyword%' OR ORS.con_to_apply LIKE '%$keyword%' ";
          $keyword_cond = $keyword_cond."OR MC.name like '%$keyword%' OR MCG.name LIKE '%$keyword%' OR MSTT.name LIKE '%$keyword%')";
          $sql="SELECT *  FROM (SELECT  DISTINCT ORS.owner_id,ORS.id AS orid,
                OW.`storename`,MC.name, ORS.`main_image`, ORS.`image1`, ORS.`image2`, ORS.`image3`, ORS.`image4`, ORS.`image5`, ORS.`image6`, ORS.`company_info`,
                MC.name AS city_name,  MCG.name AS group_name, MSTT.name AS town_name, ORS.`title`,
                ORS.`apply_tel`, ORS.`apply_emailaddress`, ORS.`salary`, OW.`happy_money_type`, OW.`happy_money`,OW.`owner_status`

                FROM
                `owners` OW
                INNER JOIN owner_recruits ORS
                ON OW.`id`= ORS.`owner_id`
                LEFT JOIN (
                SELECT mjt.`priority`,mjt.`name` AS priority_name, jto.owner_recruit_id
                  FROM job_type_owners jto
                  INNER JOIN mst_job_types mjt
                  ON jto.`job_type_id`=mjt.`id`
                  WHERE mjt.`display_flag`=1
                  ORDER BY  mjt.`priority` ASC LIMIT 2
                ) AS jt ON jt.owner_recruit_id = ORS.id
                INNER JOIN treatments_owners
                ON ORS.`id`= treatments_owners.`owner_recruit_id`
                INNER JOIN mst_treatments MT
                ON MT.id= treatments_owners.`treatment_id`
                INNER JOIN mst_cities MC
                ON MC.`id`= ORS.`city_id`
                INNER JOIN mst_city_groups MCG
                ON MCG.`id`= ORS.`city_group_id`
                INNER JOIN mst_towns MSTT
                ON MSTT.id = ORS.`town_id`
                WHERE
                OW.public_info_flag = 1 AND
                MC.display_flag =1 AND
                ORS.recruit_status = 2 AND
                MT.`display_flag`=1 AND
                OW.`display_flag`=1 AND
                OW.`owner_status` IN (" . $owner_status . ")
                AND ORS.id NOT IN ('" . $info_id . "') "
                .$ownerapply.$keyword_cond.
                "
                UNION
                (
                SELECT DISTINCT
                ORS.owner_id,
                ORS.id AS orid,
                OW.`storename`,
                MC.name,
                ORS.`main_image`,
                ORS.`image1`,
                ORS.`image2`,
                ORS.`image3`,
                ORS.`image4`,
                ORS.`image5`,
                ORS.`image6`,
                ORS.`company_info`,
                MC.name AS city_name,
                MCG.name AS group_name,
                MSTT.name AS town_name, ORS.`title`,
                ORS.`apply_tel`, ORS.`apply_emailaddress`, ORS.`salary`
                , OW.`happy_money_type`, OW.`happy_money`,
                OW.`owner_status`

                FROM
                `user_payments` UP
                INNER JOIN `owner_recruits` ORS
                ON UP.`owner_recruit_id`= ORS.`id`
                LEFT JOIN (
                SELECT mjt.`priority`,mjt.`name` AS priority_name, jto.owner_recruit_id
                  FROM job_type_owners jto
                  INNER JOIN mst_job_types mjt
                  ON jto.`job_type_id`=mjt.`id`
                  WHERE mjt.`display_flag`=1
                  ORDER BY  mjt.`priority` ASC LIMIT 2
                ) AS jt ON jt.owner_recruit_id = ORS.id
                INNER JOIN `owners` OW
                ON ORS.`owner_id`= OW.id
                INNER JOIN `treatments_owners` TWO
                ON TWO.`owner_recruit_id`= ORS.`id`
                INNER JOIN `mst_treatments` MT
                ON MT.`id`= TWO.`treatment_id`
                INNER JOIN mst_cities MC
                ON MC.`id`= ORS.`city_id`
                INNER JOIN mst_city_groups MCG
                ON MCG.`id`= ORS.`city_group_id`
                INNER JOIN mst_towns MSTT
                ON MSTT.id = ORS.`town_id`

                WHERE
                OW.public_info_flag = 1 AND
                MC.display_flag =1
                AND OW.display_flag =1
                AND MT.`display_flag`=1
                AND OW.owner_status IN (" . $owner_status . ")
                AND UP.user_id=$user_id
                AND UP.`user_payment_status` NOT IN(2)
                AND ORS.id NOT IN ('" . $info_id . "') "
                .$keyword_cond.
                "
                )) AS Phuong ORDER BY Phuong.owner_status ASC, RAND()";

          if ($limit != '') {
            $sql = $sql." LIMIT ".$limit;
          }
          if ($offset > 0) {
            $sql = $sql." OFFSET ".$offset;
          }
          $query = $this->db->query($sql);
          return $query->result_array();
        }
        else
          return false;

    }


    /*
    *@author: IVS_Nguyen_Ngoc_Phuong
    * get all owner has searched
    *@param: happymoney, hourly salary,monthly salary,treatment
    */
    public function findAll($idcity,$sort=1,$user_id,$city_group_id,$owner_status=2){
        $listcity='';
        //$sort_data= ' DESC';
        $ownerapply='';
        $city_group='';
        if($user_id!=0){
            $data_prepare_sql = "  select distinct owner_id, lsm.owner_recruit_id
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
            $ownerapply= " AND OW.id NOT IN(
                            SELECT ORS.owner_id FROM
                            `user_payments` UP
                            INNER JOIN `owner_recruits` ORS
                            ON ORS.id= UP.`owner_recruit_id`
                            WHERE
                            UP.`user_id`=$user_id
                        AND UP.`user_payment_status` NOT IN(2)
                )".$sql_and_cond;
        }else {
            $ownerapply = " AND ORS.`display_flag`=1 ";
        }

        if($city_group_id!=0){
            $city_group='AND MC.`city_group_id`= '.$city_group_id;
        }
        if($idcity != ''){
            $listcity= " AND MC.id in(".$idcity.")";
        }
        /*
        if($sort!=1)
        {
           $sort_data= " ASC                                                                                ";
        }*/
        $sql="SELECT *  FROM (SELECT  DISTINCT ORS.owner_id,ORS.id AS orid,
                OW.`storename`, MC.name,
                ORS.`main_image`, ORS.`image1`, ORS.`image2`, ORS.`image3`, ORS.`image4`, ORS.`image5`, ORS.`image6`, ORS.`company_info`,
                MHM.`user_happy_money`,MHM.image, MC.name AS city_name,  MCG.name AS group_name, MSTT.name AS town_name, ORS.`title`,
                ORS.`apply_tel`, ORS.`apply_emailaddress`, ORS.`salary`

                FROM
                `owners` OW
                INNER JOIN owner_recruits ORS
                ON OW.`id`= ORS.`owner_id`
                INNER JOIN mst_happy_moneys MHM
                ON ORS.`happy_money_id`= MHM.`id`
                INNER JOIN treatments_owners
                ON ORS.`id`= treatments_owners.`owner_recruit_id`
                INNER JOIN mst_treatments MT
                ON MT.id= treatments_owners.`treatment_id`
                INNER JOIN mst_cities MC
                ON MC.`id`= ORS.`city_id`
                INNER JOIN mst_city_groups MCG
                ON MCG.`id`= ORS.`city_group_id`
                INNER JOIN mst_towns MSTT
                ON MSTT.id = ORS.`town_id`
                WHERE
                OW.public_info_flag = 1 AND
                MC.display_flag =1 AND
                ORS.recruit_status = 2 AND
                MHM.`display_flag`=1 AND
                MT.`display_flag`=1 AND
                OW.`display_flag`=1 AND
                OW.`owner_status` IN (".$owner_status.")".$listcity." ".$city_group
                .$ownerapply.
                "
                UNION
                (
                SELECT DISTINCT
                ORS.owner_id,
                ORS.id AS orid,
                OW.`storename`,
                MC.name,
                ORS.`main_image`,
                ORS.`image1`,
                ORS.`image2`,
                ORS.`image3`,
                ORS.`image4`,
                ORS.`image5`,
                ORS.`image6`,
                ORS.`company_info`,
                MHM.`user_happy_money`,
                MHM.image,
                MC.name AS city_name,
                MCG.name AS group_name, MSTT.name AS town_name, ORS.`title`,
                ORS.`apply_tel`, ORS.`apply_emailaddress`, ORS.`salary`

                FROM
                `user_payments` UP
                INNER JOIN `owner_recruits` ORS
                ON UP.`owner_recruit_id`= ORS.`id`
                INNER JOIN `owners` OW
                ON ORS.`owner_id`= OW.id
                INNER JOIN mst_happy_moneys MHM
                ON MHM.`id`= ORS.`happy_money_id`
                INNER JOIN `treatments_owners` TWO
                ON TWO.`owner_recruit_id`= ORS.`id`
                INNER JOIN `mst_treatments` MT
                ON MT.`id`= TWO.`treatment_id`
                INNER JOIN mst_cities MC
                ON MC.`id`= ORS.`city_id`
                INNER JOIN mst_city_groups MCG
                ON MCG.`id`= ORS.`city_group_id`
                INNER JOIN mst_towns MSTT
                ON MSTT.id = ORS.`town_id`

                WHERE
                OW.public_info_flag = 1 AND
                MC.display_flag =1
                AND OW.display_flag =1
                AND MT.`display_flag`=1
                AND MHM.`display_flag`=1
                AND OW.owner_status IN (".$owner_status.")
                AND UP.user_id=$user_id
                AND UP.`user_payment_status` NOT IN(2)".$listcity." ".$city_group.
                "
                )) AS Phuong ";
         $query = $this->db->query($sql);
         return $query->result_array();
    }
    /*
    * @author:IVS_Nguyen_Ngoc_Phuong
    * get all job type by id of owner_recruits
    *@param: id
    */
    public function getJobType($id)
    {
        $sql="
                SELECT mjt.`priority`,mjt.`name` as name
                FROM job_type_owners jto
                INNER JOIN mst_job_types mjt
                ON jto.`job_type_id`=mjt.`id`
                WHERE mjt.`display_flag`=1
                AND jto.`owner_recruit_id`= ?
                ORDER BY  mjt.`priority` ASC LIMIT 2";
        $query= $this->db->query($sql,array($id));
        return $query->result_array();
    }
    /*
     * @author:IVS_Nguyen_Ngoc_Phuong
     * get all treatment by id of owner_recruits
     *@param: id
     */
    public function getTreatment($id){
        $sql="SELECT treatments_owners.`owner_recruit_id`,mt.`id`,mt.`name` as name ,mt.`priority`
                FROM treatments_owners
                INNER JOIN mst_treatments mt
                ON treatments_owners.`treatment_id`= mt.`id`
                WHERE
                mt.`display_flag`=1 AND
                treatments_owners.`owner_recruit_id`= ?
                ORDER BY mt.priority";
        $query= $this->db->query($sql,array($id));
        return $query->result_array();
    }

    //Note: The value of $withRankSetting parameter is either string of owner id's or BOOLEAN TRUE;
    public function getSearchStore($cityGroup, $city, $arrTown, $arrTreatment, $arrCate, $limit = STORE_LIMIT, $withRankSetting, $offset = 0, $info_id= 0,$is_mobile=false,$owner_status=2) {
        $ret = array();
        $free_flag = "";

        $sql = "";
        if ($withRankSetting && is_bool($withRankSetting) === true) {
            $owner_status = "2";
        }

        if ($arrTreatment || $arrCate) {
            $sql .= " SELECT owr.id AS owner_recruit_id ";
            $sql .= " FROM owner_recruits owr ";
            $sql .= " INNER JOIN owners ow ON ow.display_flag = 1 AND ow.public_info_flag = 1 ";
            $sql .= "            AND owr.owner_id = ow.id AND ow.owner_status IN (".$owner_status.") ";
            if ($arrTreatment) {
                $sql .= " INNER JOIN treatments_owners tro ON owr.id = tro.owner_recruit_id ";
                $sql .= "            AND tro.treatment_id in ('" . $arrTreatment . "') ";
            }

            if ($arrCate) {
                $sql .= " INNER JOIN job_type_owners jto ON owr.id = jto.owner_recruit_id ";
                $sql .= "            AND jto.job_type_id in ('" . $arrCate . "') ";
            }
            $sql .= " WHERE owr.display_flag = 1";
            $sql .= " GROUP BY owner_recruit_id ";
        }

        $filter_in_str = "";
        if ($sql) {
            $query = $this->db->query($sql);
            if ($query) {
                $filter_owner_list = $query->result_array();
                if (count($filter_owner_list) <= 0) {
                    return $ret;  // null array
                }
                foreach ($filter_owner_list as $owner) {
                    $filter_in_str .= $owner["owner_recruit_id"] . ",";
                }
                if ($filter_in_str) {
                    $filter_in_str = rtrim($filter_in_str, ",");
                }
            }
        }

        $sql = "SELECT  ow.owner_status,ow.id AS id,owr.id AS orid, owr.main_image, owr.image1, owr.image2,
                        owr.image3, owr.image4, owr.image5, owr.image6, ow.id AS owID, ow.storename,
                        owr.title,
                        owr.apply_tel AS telephone,
                        owr.company_info,
                        ow.trial_work_bonus_point, ow.travel_expense_bonus_point,
                        mcg.name AS group_name, mc.name AS city_name, mt.name AS town_name, owr.salary, ow.happy_money_type AS happy_money_type, ow.happy_money AS happy_money";

        if ($withRankSetting && is_bool($withRankSetting) === true) {
            $sql .= ", sr.rank_time ";
        }

        $sql .= " FROM `owners` AS ow
                INNER JOIN `owner_recruits` AS owr ON ow.id = owr.owner_id
                LEFT JOIN `owner_category` AS owc ON owr.id = owc.owner_id
                INNER JOIN `mst_city_groups` AS mcg ON owr.city_group_id = mcg.id
                INNER JOIN `mst_cities` AS mc ON owr.city_id = mc.id
                INNER JOIN `mst_towns` AS mt ON owr.town_id = mt.id OR owc.category_id = mt.id ";

        if ($withRankSetting && is_bool($withRankSetting) === true) {
            $sql .= " INNER JOIN (SELECT LEAST(
                                  CASE WHEN (TIMEDIFF(DATE_FORMAT(NOW(), '%H:%i:%s'), time_1) >= 0 && DATE_FORMAT(created_date, '%Y-%m-%d') = DATE_FORMAT(NOW(), '%Y-%m-%d') && time_1 >= DATE_FORMAT(created_date, '%H:%i:%s')) THEN TIMEDIFF(DATE_FORMAT(NOW(), '%H:%i:%s'), time_1)
                                  ELSE
                                      CASE WHEN (TIMEDIFF(DATE_FORMAT(NOW(), '%H:%i:%s'), time_1) >= 0 && DATE_FORMAT(created_date, '%Y-%m-%d') < DATE_FORMAT(NOW(), '%Y-%m-%d')) THEN TIMEDIFF(DATE_FORMAT(NOW(), '%H:%i:%s'), time_1)
                                      ELSE
                                          CASE WHEN DATE_FORMAT(created_date, '%Y-%m-%d') < DATE_FORMAT(NOW(), '%Y-%m-%d') THEN TIMEDIFF(ADDTIME('24:00:00', DATE_FORMAT(NOW(), '%H:%i:%s')), GREATEST(IFNULL(time_1, '00:00:00'), IFNULL(time_2, '00:00:00'), IFNULL(time_3, '00:00:00'), IFNULL(time_4, '00:00:00'), IFNULL(time_5, '00:00:00')))
                                          ELSE '24:00:00:00' END
                                      END
                                  END,
                                  CASE WHEN (TIMEDIFF(DATE_FORMAT(NOW(), '%H:%i:%s'), time_2) >= 0 && DATE_FORMAT(created_date, '%Y-%m-%d') = DATE_FORMAT(NOW(), '%Y-%m-%d') && time_2 >= DATE_FORMAT(created_date, '%H:%i:%s')) THEN TIMEDIFF(DATE_FORMAT(NOW(), '%H:%i:%s'), time_2)
                                  ELSE
                                      CASE WHEN (TIMEDIFF(DATE_FORMAT(NOW(), '%H:%i:%s'), time_2) >= 0 && DATE_FORMAT(created_date, '%Y-%m-%d') < DATE_FORMAT(NOW(), '%Y-%m-%d')) THEN TIMEDIFF(DATE_FORMAT(NOW(), '%H:%i:%s'), time_2)
                                      ELSE
                                          CASE WHEN DATE_FORMAT(created_date, '%Y-%m-%d') < DATE_FORMAT(NOW(), '%Y-%m-%d') THEN TIMEDIFF(ADDTIME('24:00:00', DATE_FORMAT(NOW(), '%H:%i:%s')), GREATEST(IFNULL(time_1, '00:00:00'), IFNULL(time_2, '00:00:00'), IFNULL(time_3, '00:00:00'), IFNULL(time_4, '00:00:00'), IFNULL(time_5, '00:00:00')))
                                          ELSE '24:00:00:00' END
                                      END
                                  END,
                                  CASE WHEN (TIMEDIFF(DATE_FORMAT(NOW(), '%H:%i:%s'), time_3) >= 0 && DATE_FORMAT(created_date, '%Y-%m-%d') = DATE_FORMAT(NOW(), '%Y-%m-%d') && time_3 >= DATE_FORMAT(created_date, '%H:%i:%s')) THEN TIMEDIFF(DATE_FORMAT(NOW(), '%H:%i:%s'), time_3)
                                  ELSE
                                      CASE WHEN (TIMEDIFF(DATE_FORMAT(NOW(), '%H:%i:%s'), time_3) >= 0 && DATE_FORMAT(created_date, '%Y-%m-%d') < DATE_FORMAT(NOW(), '%Y-%m-%d')) THEN TIMEDIFF(DATE_FORMAT(NOW(), '%H:%i:%s'), time_3)
                                      ELSE
                                          CASE WHEN DATE_FORMAT(created_date, '%Y-%m-%d') < DATE_FORMAT(NOW(), '%Y-%m-%d') THEN TIMEDIFF(ADDTIME('24:00:00', DATE_FORMAT(NOW(), '%H:%i:%s')), GREATEST(IFNULL(time_1, '00:00:00'), IFNULL(time_2, '00:00:00'), IFNULL(time_3, '00:00:00'), IFNULL(time_4, '00:00:00'), IFNULL(time_5, '00:00:00')))
                                          ELSE '24:00:00:00' END
                                      END
                                  END,
                                  CASE WHEN (TIMEDIFF(DATE_FORMAT(NOW(), '%H:%i:%s'), time_4) >= 0 && DATE_FORMAT(created_date, '%Y-%m-%d') = DATE_FORMAT(NOW(), '%Y-%m-%d') && time_4 >= DATE_FORMAT(created_date, '%H:%i:%s')) THEN TIMEDIFF(DATE_FORMAT(NOW(), '%H:%i:%s'), time_4)
                                  ELSE
                                      CASE WHEN (TIMEDIFF(DATE_FORMAT(NOW(), '%H:%i:%s'), time_4) >= 0 && DATE_FORMAT(created_date, '%Y-%m-%d') < DATE_FORMAT(NOW(), '%Y-%m-%d')) THEN TIMEDIFF(DATE_FORMAT(NOW(), '%H:%i:%s'), time_4)
                                      ELSE
                                          CASE WHEN DATE_FORMAT(created_date, '%Y-%m-%d') < DATE_FORMAT(NOW(), '%Y-%m-%d') THEN TIMEDIFF(ADDTIME('24:00:00', DATE_FORMAT(NOW(), '%H:%i:%s')), GREATEST(IFNULL(time_1, '00:00:00'), IFNULL(time_2, '00:00:00'), IFNULL(time_3, '00:00:00'), IFNULL(time_4, '00:00:00'), IFNULL(time_5, '00:00:00')))
                                          ELSE '24:00:00:00' END
                                      END
                                  END,
                                  CASE WHEN (TIMEDIFF(DATE_FORMAT(NOW(), '%H:%i:%s'), time_5) >= 0 && DATE_FORMAT(created_date, '%Y-%m-%d') = DATE_FORMAT(NOW(), '%Y-%m-%d') && time_5 >= DATE_FORMAT(created_date, '%H:%i:%s')) THEN TIMEDIFF(DATE_FORMAT(NOW(), '%H:%i:%s'), time_5)
                                  ELSE
                                      CASE WHEN (TIMEDIFF(DATE_FORMAT(NOW(), '%H:%i:%s'), time_5) >= 0 && DATE_FORMAT(created_date, '%Y-%m-%d') < DATE_FORMAT(NOW(), '%Y-%m-%d')) THEN TIMEDIFF(DATE_FORMAT(NOW(), '%H:%i:%s'), time_5)
                                      ELSE
                                          CASE WHEN DATE_FORMAT(created_date, '%Y-%m-%d') < DATE_FORMAT(NOW(), '%Y-%m-%d') THEN TIMEDIFF(ADDTIME('24:00:00', DATE_FORMAT(NOW(), '%H:%i:%s')), GREATEST(IFNULL(time_1, '00:00:00'), IFNULL(time_2, '00:00:00'), IFNULL(time_3, '00:00:00'), IFNULL(time_4, '00:00:00'), IFNULL(time_5, '00:00:00')))
                                          ELSE '24:00:00:00' END
                                      END
                                  END)
                                      AS rank_time, owner_id
                                  FROM site_rank WHERE display_flag = 1) AS sr ON ow.id = sr.owner_id AND sr.rank_time != '24:00:00' AND sr.rank_time != '00:00:00'";
            $free_flag = " AND ow.free_owner_flag = 0";
        }

        $sql .=" WHERE ow.display_flag = 1 AND ow.public_info_flag = 1 AND owr.display_flag = 1 ";
        $sql .=" AND ow.owner_status IN (".$owner_status.") AND  mt.id IN ('" . $arrTown . "') AND owr.id NOT IN ('" . $info_id . "')" . $free_flag ;
        if ($filter_in_str) {
            $sql .= " AND owr.id in (" . $filter_in_str . ") ";
        }
        if ($withRankSetting && is_bool($withRankSetting) === false) {
            $sql .=" AND owr.owner_id NOT IN (". $withRankSetting . ")";
        }
        $sql .= " GROUP BY owr.owner_id ORDER BY";
        if ($withRankSetting && is_bool($withRankSetting) === true) {
            $sql .= " sr.rank_time, ";
        }
        $sql .= " ow.owner_status ASC, ";
        $sql .= " RAND()";
        $sql .= " LIMIT ? ";
        $params[] = intval($limit);
        if($is_mobile == false) {
          $sql .= " OFFSET ? ";
          $params[] = intval($offset);
        }

        $query = $this->db->query($sql, $params);
        if ($query->result_array()){
            $ret = $query->result_array();
            $ret_data = array();
            if ($ret) {
                foreach ($ret as $owner_data) {
                    $flag = false;
                    $owner_recruit_id = $owner_data['orid'];
                    $ret_temp = $owner_data;

                    // get treatmentsID, treatmentsName
                    $sql  = " SELECT GROUP_CONCAT(mtr.id ORDER BY mtr.priority ASC) AS treatmentsID, GROUP_CONCAT(mtr.name) AS treatmentsName";
                    $sql .= " FROM  treatments_owners AS tro ";
                    $sql .= "       INNER JOIN mst_treatments AS mtr ON (tro.treatment_id = mtr.id) AND (mtr.display_flag = 1)";
                    $sql .= " WHERE tro.owner_recruit_id = ?";
                    $query = $this->db->query($sql, $owner_recruit_id);
                    if ($query) {
                        $owner_addtition_data = $query->result_array();
                        if ($owner_addtition_data && is_array($owner_addtition_data)) {
                            $ret_temp = array_merge($ret_temp,$owner_addtition_data[0]);
                            $flag = true;
                        }
                    }
                    // get jtname
                    $sql  = "SELECT mjt.`name` as jtname ";
                    $sql .= "FROM job_type_owners jto ";
                    $sql .= "INNER JOIN mst_job_types mjt ON jto.`job_type_id`= mjt.`id` ";
                    $sql .= "WHERE mjt.`display_flag`=1 AND jto.`owner_recruit_id`= ?";
                    $query = $this->db->query($sql, $owner_recruit_id);
                    if ($query) {
                        $owner_addtition_data = $query->result_array();
                        if ($owner_addtition_data && is_array($owner_addtition_data)) {
                            $ret_temp = array_merge($ret_temp,$owner_addtition_data[0]);
                            $flag = true;
                        }
                    }

                    if($flag){
                      $ret_data[] = $ret_temp;
                    }

                }
                $ret = $ret_data;
            }
        }

        return $ret;
    }
    public function countSearchStore($cityGroup, $city, $arrTown, $arrTreatment_info, $arrCate_info,$owner_status=2){
        $ret = 0;
        $sql = "";
        if ($arrTreatment_info || $arrCate_info) {
            $sql .= " SELECT owr.id AS owner_recruit_id ";
            $sql .= " FROM owner_recruits owr ";
            $sql .= " INNER JOIN owners ow ON ow.display_flag = 1 AND ow.public_info_flag = 1 ";
            $sql .= "            AND owr.owner_id = ow.id AND ow.owner_status IN (".$owner_status.") ";
            if ($arrTreatment_info) {
                $sql .= " INNER JOIN treatments_owners tro ON owr.id = tro.owner_recruit_id ";
                $sql .= "            AND tro.treatment_id in ('" . $arrTreatment_info . "') ";
            }

            if ($arrCate_info) {
                $sql .= " INNER JOIN job_type_owners jto ON owr.id = jto.owner_recruit_id ";
                $sql .= "            AND jto.job_type_id in ('" . $arrCate_info . "') ";
            }
            $sql .= " WHERE owr.display_flag = 1";
            $sql .= " GROUP BY owner_recruit_id ";
        }

        $filter_in_str = "";
        if ($sql) {
            $query = $this->db->query($sql);
            if ($query) {
                $filter_owner_list = $query->result_array();
                if (count($filter_owner_list) <= 0) {
                    return $ret;  // 0
                }
                foreach ($filter_owner_list as $owner) {
                    $filter_in_str .= $owner["owner_recruit_id"] . ",";
                }
                if ($filter_in_str) {
                    $filter_in_str = rtrim($filter_in_str, ",");
                }
            }
        }

        $sql = "SELECT DISTINCT owr.id
        FROM `owners` AS ow
        INNER JOIN `owner_recruits` AS owr ON ow.id = owr.owner_id
        LEFT JOIN `owner_category` AS owc ON owr.id = owc.owner_id
        INNER JOIN `mst_city_groups` AS mcg ON owr.city_group_id = mcg.id
        INNER JOIN `mst_cities` AS mc ON owr.city_id = mc.id
        INNER JOIN `mst_towns` AS mt ON owr.town_id = mt.id OR owc.category_id = mt.id ";

        $sql .=" WHERE ow.display_flag = 1 AND ow.public_info_flag = 1 AND owr.display_flag = 1 ";
        $sql .=" AND ow.owner_status IN (".$owner_status.") AND mt.id IN ('" . $arrTown . "')";

        if ($filter_in_str) {
            $sql .= " AND owr.id in (" . $filter_in_str . ") ";
        }

        $params = array($cityGroup, $city);
        $query = $this->db->query($sql, $params);
        $result = $query->result_array();
        $ret = count($result);

        return $ret;
    }

    public function countSearchStore2($cityGroup, $city, $arrTown){
        $filter_in_str = "";

        $sql = "SELECT DISTINCT owr.id AS owr_id, ow.id
        FROM `owners` AS ow
        INNER JOIN `owner_recruits` AS owr ON ow.id = owr.owner_id
        LEFT JOIN `owner_category` AS owc ON owr.id = owc.owner_id
        INNER JOIN `mst_city_groups` AS mcg ON owr.city_group_id = mcg.id
        INNER JOIN `mst_cities` AS mc ON owr.city_id = mc.id
        INNER JOIN `mst_towns` AS mt ON owr.town_id = mt.id OR owc.category_id = mt.id ";

        $sql .=" WHERE ow.display_flag = 1 AND ow.public_info_flag = 1 AND owr.display_flag = 1 ";
        $sql .=" AND ow.owner_status IN (2) AND mt.id IN ('" . $arrTown . "')";

        if ($filter_in_str) {
            $sql .= " AND owr.id in (" . $filter_in_str . ") ";
        }

        $params = array($cityGroup, $city);
        $query = $this->db->query($sql, $params);
        $result = $query->result_array();

        $ret['count'] = count($result);
        $ret['owners']= $result;

        return $ret;
    }


    public function getSelectTownName($city, $arrTown){
        $ret = array();
        $sql = "SELECT GROUP_CONCAT(mt.id) AS id, GROUP_CONCAT(mt.name) AS name, GROUP_CONCAT(mt.alph_name) AS alph_name  FROM `mst_cities` AS mc
                INNER JOIN `mst_towns` AS mt ON mc.id = mt.city_id
                WHERE mc.id = ? AND mt.alph_name IN ('" . $arrTown ."')";

        $query = $this->db->query($sql, array($city));
        if ($query->row_array()){
            $ret = $query->row_array();
        }
        return $ret;
    }

    public function getAllJobType(){
        $sql="SELECT * FROM mst_job_types WHERE display_flag =1 AND alph_name IS NOT NULL";
        $query= $this->db->query($sql);
        return $query->result_array();
    }

    public function getAllTreatment(){
        $sql="SELECT * FROM mst_treatments WHERE display_flag =1 AND alph_name IS NOT NULL";
        $query= $this->db->query($sql);
        return $query->result_array();
    }

    public function getTreatmentInfo($treatmentAlphName){
        $sql="SELECT GROUP_CONCAT(id) AS id, GROUP_CONCAT(name) AS name, GROUP_CONCAT(alph_name) AS alph_name FROM mst_treatments WHERE display_flag =1 AND alph_name IN ('" . $treatmentAlphName . "')";
        $query= $this->db->query($sql);
        return $query->row_array();
    }

    public function getTreatmentInfoContents($treatmentAlphName){
        $sql ="SELECT GROUP_CONCAT(id) AS id, GROUP_CONCAT(name) AS name, GROUP_CONCAT(alph_name) AS alph_name, top_description, contents, contents2, contents3 ";
        $sql.="FROM mst_treatments WHERE display_flag =1 AND alph_name IN ('" . $treatmentAlphName . "')";
        $query= $this->db->query($sql);
        return $query->row_array();
    }

    public function getJobTypeInfo($catetAlphName){
        $sql = "SELECT GROUP_CONCAT(id) AS id, GROUP_CONCAT(name) AS name, GROUP_CONCAT(alph_name) AS alph_name ,contents";
        $sql.= " FROM mst_job_types WHERE display_flag =1 AND alph_name IN ('" . $catetAlphName . "')";
        $query= $this->db->query($sql);
        return $query->row_array();
    }

    public function getJobTypeInfoContents($catetAlphName){
        $sql = "SELECT GROUP_CONCAT(id) AS id, GROUP_CONCAT(name) AS name, GROUP_CONCAT(alph_name) AS alph_name, top_description, income, contents, contents2, contents3, contents4";
        $sql.= " FROM mst_job_types WHERE display_flag =1 AND alph_name IN ('" . $catetAlphName . "')";
        $query= $this->db->query($sql);
        return $query->row_array();
    }

}
?>

<?php

class Manalysis extends CommonQuery {

    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

    //(スカウト送受信数、開封率)
    function doUserScoutAnalysis($owner_id,$DateFrom,$DateTo){
        $sql   = "SELECT ";
        $sql  .= "COALESCE(COUNT(owr.owner_id),0) AS scout_mail_send,";
        $sql  .= "COALESCE(SUM(lum.is_read),0) AS scout_mail_open,";
        $sql  .= "COALESCE(SUM(lum.is_read) / COUNT(owr.owner_id),0) AS scout_open_rate ";
        $sql  .= "FROM list_user_messages lum ";
        $sql  .= "INNER JOIN owner_recruits owr ON lum.owner_recruit_id = owr.id WHERE lum.created_date >= ? AND lum.created_date <= ? AND owr.owner_id = ?";
        return $this->db->query($sql,array($DateFrom,$DateTo,$owner_id))->row_array();
    }
    //(email,tel,line,匿名,HP,クチコミ)
    function doUserClickAnalysis($owner_id,$DateFrom,$DateTo){
        $sql = "SELECT ";
        $sql .= "COUNT(if(action_type = 1, 1, null)) AS mail_click_num,
            COUNT(if(action_type = 2, 1, null)) AS tel_click_num,
            COUNT(if(action_type = 3, 1, null)) AS line_click_num,
            COUNT(if(action_type = 4, 1, null)) AS question_num, 
            COUNT(if(action_type = 5, 1, null)) AS hp_click_num, 
            COUNT(if(action_type = 6, 1, null)) AS kuchikomi_click_num ";
        $sql .= "FROM user_statistics_log ";
        $sql .= "WHERE created_date >= ? AND created_date <= ? AND owner_id = ?";
        return $this->db->query($sql,array($DateFrom,$DateTo,$owner_id))->row_array();
    }
    //(面接交通費)
    function doUserTravelAnalysis($owner_id,$DateFrom,$DateTo){
        $sql  = "SELECT COUNT(owner_id) AS travel_num FROM travel_expense_list WHERE created_date >= ? AND created_date <= ? AND owner_id = ?";
        return $this->db->query($sql,array($DateFrom,$DateTo,$owner_id))->row_array();
    }    
    //(体験入店)
    function doUserCampaignBonusAnalysis($owner_id,$DateFrom,$DateTo){
        $sql = "SELECT COUNT(owner_id) AS campaign_bonus_num FROM campaign_bonus_request_list WHERE created_date >= ? AND created_date <= ? AND owner_id = ?";
        return $this->db->query($sql,array($DateFrom,$DateTo,$owner_id))->row_array();
    }    
    //(アクセス)
    function doUserShopAccessAnalysis($owner_id,$DateFrom,$DateTo){
        $sql = "SELECT COUNT(owner_id) AS shop_access_num FROM scout_owner_log WHERE visited_date >= ? AND visited_date <= ? AND owner_id = ?";
        return $this->db->query($sql,array($DateFrom,$DateTo,$owner_id))->row_array();
    }
    //アクセス解析期間指定
    function doUserAnalysis($owner_id,$From,$To) {
        $DateFrom = $From;
        $DateTo = $To;
        if(strtotime($From) > strtotime($To)){
            $DateFrom = $To;
            $DateTo = $From;
        }
        $array1 = $this->doUserScoutAnalysis($owner_id,$DateFrom,$DateTo);
        $array2 = $this->doUserClickAnalysis($owner_id,$DateFrom,$DateTo);
        $array3 = $this->doUserTravelAnalysis($owner_id,$DateFrom,$DateTo);
        $array4 = $this->doUserCampaignBonusAnalysis($owner_id,$DateFrom,$DateTo);
        $array5 = $this->doUserShopAccessAnalysis($owner_id,$DateFrom,$DateTo);
        return array_merge($array1,$array2,$array3,$array4,$array5);
    }    
    //アクセス解析月毎
    function doUserAnalysisMonth($owner_id,$From,$To) {
        $DateFrom = $From;
        $DateTo = $To;
        if(strtotime($From) > strtotime($To)){
            $DateFrom = $To;
            $DateTo = $From;
        }
        $date_from = strtotime($DateFrom);
        $date_to = strtotime($DateTo);
        $month1 = date('Y',$date_to)*12 + date('m',$date_to);
        $month2 = date('Y', $date_from)*12 + date('m',$date_from);
        $result = ($month1 - $month2)+1;

        $date = $DateFrom;
        list($year, $month) = explode("-", $date, 2);
        for ($i=0; $i < $result; $i++){
            $nextMonth = date('Y-m-d', mktime(0, 0, 0, $month + $i, 1, $year));
            $array0['month'] = date('Y-m',strtotime($nextMonth));
            $array1 = $this->doUserAnalysis($owner_id,$nextMonth,date("Y-m-t",strtotime($nextMonth)));//月末は date("Y-m-t",strtotime($nextMonth);
            $array2 = $this->doUserClickAnalysisMax($nextMonth,date("Y-m-t",strtotime($nextMonth)));
            $array3 = $this->doUserShopAccessAnalysisMax($nextMonth,date("Y-m-t",strtotime($nextMonth)));
            $array4 = $this->doUserTravelAnalysisMax($nextMonth,date("Y-m-t",strtotime($nextMonth)));
            $array5 = $this->doUserCampaignBonusAnalysisMax($nextMonth,date("Y-m-t",strtotime($nextMonth)));
            $array6 = $this->doUserScoutAnalysisMax($nextMonth,date("Y-m-t",strtotime($nextMonth)));
            $data[$i] = array_merge($array0,$array1,$array2,$array3,$array4,$array5,$array6);
        }
        return $data;
    }
    //送信数最大、開封数最大、開封率最大取得
    function doUserScoutAnalysisMax($DateFrom,$DateTo){
        $sql  = "SELECT ";
        $sql .= "COALESCE(MAX(c.scout_mail_send),0) AS scout_mail_send_max,";
        $sql .= "COALESCE(MAX(c.scout_mail_open),0) AS scout_mail_open_max,";
        $sql .= "COALESCE(MAX(c.scout_open_rate),0) AS open_rate_max ";
        $sql .= "FROM (SELECT ";
        $sql .= "COUNT(owr.owner_id) AS scout_mail_send,";
        $sql .= "SUM(lum.is_read) AS scout_mail_open,";
        $sql .= "SUM(is_read) / COUNT(owner_id) AS scout_open_rate ";
        $sql .= "FROM list_user_messages lum ";
        $sql .= "INNER JOIN owner_recruits owr ON lum.owner_recruit_id = owr.id ";
        $sql .= "WHERE lum.created_date >= ? AND lum.created_date <= ? ";
        $sql .= "GROUP BY owner_id) AS c";
        return $this->db->query($sql,array($DateFrom,$DateTo))->row_array();
    }
    //email,tel,line,匿名,HP,クチコミ最大数取得
    function doUserClickAnalysisMax($DateFrom,$DateTo){
        $sql  = "SELECT ";
        $sql .= "COALESCE(MAX(mail_click_num),0) AS mail_click_max,
                 COALESCE(MAX(tel_click_num),0) AS tel_click_max,
                 COALESCE(MAX(line_click_num),0) AS line_click_max,
                 COALESCE(MAX(question_num),0) AS question_max,
                 COALESCE(MAX(hp_click_num),0) AS hp_click_max,
                 COALESCE(MAX(kuchikomi_click_num),0) AS kuchikomi_click_max ";
        $sql .= "FROM owners ow
                LEFT JOIN (SELECT owner_id,
                COUNT(if(action_type = 1, 1, null)) AS mail_click_num,
                COUNT(if(action_type = 2, 1, null)) AS tel_click_num,
                COUNT(if(action_type = 3, 1, null)) AS line_click_num,
                COUNT(if(action_type = 4, 1, null)) AS question_num, 
                COUNT(if(action_type = 5, 1, null)) AS hp_click_num, 
                COUNT(if(action_type = 6, 1, null)) AS kuchikomi_click_num
                FROM user_statistics_log WHERE created_date >= ? AND created_date <= ? GROUP BY owner_id) AS usl ON usl.owner_id = ow.id ";
        return $this->db->query($sql,array($DateFrom,$DateTo))->row_array();
    }    
    //アクセス最大数取得
    function doUserShopAccessAnalysisMax($DateFrom,$DateTo){
        $sql  = "SELECT COALESCE(MAX(c.co),0) AS shop_access_max ";
        $sql .= "FROM(SELECT COUNT(owner_id) AS co FROM scout_owner_log ";
        $sql .= "WHERE visited_date >= ? AND visited_date <= ? GROUP BY owner_id) AS c";
        return $this->db->query($sql,array($DateFrom,$DateTo))->row_array();
    }
    //面接交通費最大数取得
    function doUserTravelAnalysisMax($DateFrom,$DateTo){
        $sql  = "SELECT COALESCE(MAX(c.co),0) AS travel_max ";
        $sql .= "FROM(SELECT COUNT(owner_id) AS co FROM travel_expense_list ";
        $sql .= "WHERE created_date >= ? AND created_date <= ? GROUP BY owner_id) AS c";
        return $this->db->query($sql,array($DateFrom,$DateTo))->row_array();
    }    
    //体験入店最大数取得
    function doUserCampaignBonusAnalysisMax($DateFrom,$DateTo){
        $sql  = "SELECT COALESCE(MAX(c.co),0) AS campaign_bonus_max ";
        $sql .= "FROM(SELECT COUNT(owner_id) AS co FROM campaign_bonus_request_list ";
        $sql .= "WHERE created_date >= ? AND created_date <= ? GROUP BY owner_id) AS c";
        return $this->db->query($sql,array($DateFrom,$DateTo))->row_array();
    }
    //店舗登録日取得
    function getOwnerRegistDate($owner_id) {
        $param = array($owner_id);
        $sql  = "";
        $sql .= "SELECT id,offcial_reg_date ";
        $sql .= "FROM owners ";
        $sql .= "WHERE `id` = ? ";
        $ar = $this->db->query($sql,$param)->row_array();;
        return $ar['offcial_reg_date'];
    }
}

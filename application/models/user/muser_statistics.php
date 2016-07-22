<?php

class Muser_statistics extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    /**
     * @author  [VJS]
     * @name 	updateHPClick
     * @todo 	count up hp click for a user
     * @param 	user id
     */
    public function updateClick($user_id, $type){
        if ( !$user_id || !$type ){
            return;
        }
        switch ($type) {
            case 'MAIL':
                $sql = "INSERT INTO user_statistics (user_id, mail_click, created_date)
                        VALUES (?, mail_click + 1, NOW())
                        ON DUPLICATE KEY UPDATE mail_click = mail_click + 1, updated_date = NOW()";
                break;
            case 'TEL':
                $sql = "INSERT INTO user_statistics (user_id, tel_click, created_date)
                        VALUES (?, tel_click + 1, NOW())
                        ON DUPLICATE KEY UPDATE tel_click = tel_click + 1, updated_date = NOW()";
                break;
            case 'LINE':
                $sql = "INSERT INTO user_statistics (user_id, line_click, created_date)
                        VALUES (?, line_click + 1, NOW())
                        ON DUPLICATE KEY UPDATE line_click = line_click + 1, updated_date = NOW()";
                break;
            case 'HP':
                $sql = "INSERT INTO user_statistics (user_id, HP_click, created_date)
                        VALUES (?, HP_click + 1, NOW())
                        ON DUPLICATE KEY UPDATE HP_click = HP_click + 1, updated_date = NOW()";
                break;
            case 'KUCHIKOMI':
                $sql = "INSERT INTO user_statistics (user_id, kuchikomi_click, created_date)
                        VALUES (?, kuchikomi_click + 1, NOW())
                        ON DUPLICATE KEY UPDATE kuchikomi_click = kuchikomi_click + 1, updated_date = NOW()";
                break;
			case 'QUESTION':
                $sql = "INSERT INTO user_statistics (user_id, question_no, created_date)
                        VALUES (?, question_no + 1, NOW())
                        ON DUPLICATE KEY UPDATE question_no = question_no + 1, updated_date = NOW()";
                break;
            default:
                $sql = "";
                break;
        }
        if ( $sql ){
            $query = $this->db->query($sql, array($user_id));
        }
    }
    
    public function insertUserStatisticsLog($data) {
        $this->db->insert('user_statistics_log', $data);
        return ($this->db->affected_rows() != 1) ? false : true;
    }
}

?>

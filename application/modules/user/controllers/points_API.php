<?php
class points_API extends MY_Controller
{
    private $viewdata= array();
    function __construct() {
        parent::__construct();
        $this->load->model("user/Musers");
    }

    public function getAllSiteTotalPoints() {
        extract($this->input->post());
        if (!isset($user_id) || ($from_site != 'onayami' && $from_site != 'aruaru')) {
            return false;
        } 
        $bonus = $this->Musers->getUserScoutMailBonus0($user_id);
        if (!empty($bonus)) {
            $money = $bonus['bonus_money'];
            if ($money != '') {
                echo json_encode($money);
                exit;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

}
?>


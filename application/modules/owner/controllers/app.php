<?php

class App extends Common {

    private $viewData;

    function __construct() {
        parent::__construct();
        $this->load->model('owner/Mapp');
        $this->load->helper('breabcrumb_helper');
        $this->output->set_header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate");
        $this->output->set_header("Cache-Control: post-check=0, pre-check=0");
        $this->output->set_header("Pragma: no-cache");
    }

    /**
     * @author  [IVS] Phan Ngoc Minh Luan
     * @name 	app_settlement
     * @todo 	pay money to see info's user
     * @param 	int $count_unview
     * @return 	void
     */
    function app_settlement($count_unview = null) {
        if ($count_unview != null) {
            $owner_id = OwnerControl::getId();
            if ($owner_id != NULL) {
                $email_address = OwnerControl::getEmail();
                // get info money purchase
                $info = $this->Mapp->getCharge('1');
                $total_info_money = $info['amount'] * $count_unview;
                $total_info_point = $info['point'] * $count_unview;
                // get total point and amount of owner
                $owners = $this->Mapp->getTotal($email_address);
                $point_owner = $owners['total_point'];
                $money_owner = $owners['total_amount'];
                $paramPoint = $info['point'] / $info['amount'];
                $owner_info = HelperGlobal::owner_info($owner_id);
                $this->viewData['owner_info'] = $owner_info;
                $this->viewData['count_unview'] = $count_unview;
                $this->viewData['total_info_money'] = $total_info_money;
                $this->viewData['point_owner'] = $point_owner;
                $this->viewData['total_info_point'] = $total_info_point;
                $this->viewData['remainder_point'] = $point_owner - $total_info_point;
                $this->viewData['remainder_money'] = $money_owner - $total_info_money;
                $this->viewData['info_money'] = $info['amount'];
                $this->viewData['info_point'] = $info['point'];
                $this->viewData['loadPage'] = "app/app_settlement";
                $this->viewData['title'] = "joyspe｜応募者確認決済";
                $this->load->view("owner/layout/layout_B", $this->viewData);
            } else {
                redirect(base_url() . "owner/login");
            }
        } else {
            show_404();
        }
    }

    /**
     * author: [IVS] Phan Ngoc Minh Luan
     * name : check_app_settle
     * todo : check app settlement
     * @param null
     * @return void
     */
    public function check_app_settle() {
        $email_address = OwnerControl::getEmail();
        $owner_id = OwnerControl::getId();
        $count_unview = $_POST['count_unview'];
        $arr_owner_recruit = $this->Mapp->getArrOwnerRecruitId($owner_id);
        $count_apply = 0;
        foreach ($arr_owner_recruit as $owner_recruit) {
            $count_apply += $this->Mapp->countUserPaymentStatusApply($owner_recruit['id']);
        }
        $param = array(
            'count_unview' => $count_unview,
            'count_apply' => $count_apply,
        );
        HelperApp::add_session('count_unview', $count_unview);
        echo json_encode($param);
        die;
    }

}

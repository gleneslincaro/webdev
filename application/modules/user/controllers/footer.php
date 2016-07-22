<?php
class footer extends MY_Controller {
    public $viewData = array();
    public $layout = 'user/layout/main';

    public function __construct() {
        parent::__construct();
        $this->viewData['idheader'] = 4;
        $this->viewData['div'] = '';
        $this->load->library('user_agent');
    }
     /**
     * @author [IVS] My Phuong Le Thi
     * @name   agreement
     * @todo
     * @param  null
     * @return null
     */
    public function agreement() {
        if ($this->agent->is_mobile()) {
            $this->viewData['load_page'] = 'user/footer/agreement';
            $this->layout = "user/layout/main";
        /* pc */
        } else {
            $this->viewData['load_page'] = 'user/pc/footer/agreement';
            $this->layout = "user/pc/layout/main";
            $breadscrumb_array = array(
                array("class" => "", "text" => "利用規約", 'link'=> "")
            );
            $this->viewData['breadscrumb_array'] = $breadscrumb_array;
        }

        $this->viewData['titlePage'] = '利用規約｜風俗求人・高収入アルバイトのジョイスペ';
        $this->viewData['class_ext'] = 'tos';
        $this->load->view($this->layout, $this->viewData);
    }
     /**
     * @author [IVS] My Phuong Le Thi
     * @name   privacy
     * @todo
     * @param  null
     * @return null
     */
    public function privacy() {
        if ($this->agent->is_mobile()) {
            $this->viewData['load_page'] = 'user/footer/privacy';
            $this->layout = "user/layout/main";
        /* pc */
        } else {
            $this->viewData['load_page'] = 'user/pc/footer/privacy';
            $this->layout = "user/pc/layout/main";
            $breadscrumb_array = array(
                array("class" => "", "text" => "個人情報保護方針", "link"=>"")
            );
            $this->viewData['breadscrumb_array'] = $breadscrumb_array;
        }

        $this->viewData['titlePage'] = '個人情報保護法｜風俗求人・高収入アルバイトのジョイスペ';
        $this->viewData['noCompanyInfo'] = true;
        $this->load->view($this->layout, $this->viewData);
    }
     /**
     * @author [IVS] My Phuong Le Thi
     * @name   managementcompany
     * @todo
     * @param  null
     * @return null
     */
    public function managementcompany() {
        $this->viewData['load_page'] = 'user/footer/managementcompany';
        $this->viewData['titlePage'] = '高収入アルバイトのジョイスペ｜運営会社';
        $this->load->view($this->layout, $this->viewData);
    }
}
?>

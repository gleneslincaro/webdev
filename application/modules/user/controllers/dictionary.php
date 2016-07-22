<?php

class Dictionary extends MY_Controller {

    private $layout = "user/layout/main";
    private $viewData = array();
    private $breadscrumb_array;
    public function __construct() {
        parent::__construct();
        $this->viewData['idheader'] = null;
        $this->viewData['noCompanyInfo'] = true;
        $this->viewData['class_ext'] = 'dictionary';
        $this->breadscrumb_array = array(
            array("class" => "", "text" => "用語辞典", "link"=>"/user/dictionary/")
        );
        $this->load->library('user_agent');
    }

    public function index() {
        /* sp */
        if ($this->agent->is_mobile()) {
            $this->viewData['load_page'] = 'user/dictionary/mb/dictionary_a';
        /* pc */
        } else {
            $this->viewData['load_page'] = 'user/pc/dictionary/dictionary_a';
            $this->layout = "user/pc/layout/main";
            $this->breadscrumb_array[] = array("class" => "", "text" => "あ行", "link"=>"");
        }
        $this->viewData['breadscrumb_array'] = $this->breadscrumb_array;
        $this->viewData['titlePage'] = 'あ行の用語辞典｜風俗求人・高収入アルバイトのジョイスペ';
        $this->load->view($this->layout, $this->viewData);
    }

    public function ka() {
        /* sp */
        if ($this->agent->is_mobile()) {
            $this->viewData['load_page'] = 'user/dictionary/mb/dictionary_ka';
        /* pc */
        } else {
            $this->viewData['load_page'] = 'user/pc/dictionary/dictionary_ka';
            $this->layout = "user/pc/layout/main";
            $this->breadscrumb_array[] = array("class" => "", "text" => "か行", "link"=>"");
        }

        $this->viewData['breadscrumb_array'] = $this->breadscrumb_array;
        $this->viewData['titlePage'] = 'か行の用語辞典｜風俗求人・高収入アルバイトのジョイスペ';
        $this->load->view($this->layout, $this->viewData);
    }

    public function sa() {
        /* sp */
        if ($this->agent->is_mobile()) {
            $this->viewData['load_page'] = 'user/dictionary/mb/dictionary_sa';
        /* pc */
        } else {
            $this->viewData['load_page'] = 'user/pc/dictionary/dictionary_sa';
            $this->layout = "user/pc/layout/main";
            $this->breadscrumb_array[] = array("class" => "", "text" => "さ行", "link"=>"");
        }

        $this->viewData['breadscrumb_array'] = $this->breadscrumb_array;
        $this->viewData['titlePage'] = 'さ行の用語辞典｜風俗求人・高収入アルバイトのジョイスペ';
        $this->load->view($this->layout, $this->viewData);
    }

    public function ta() {
        /* sp */
        if ($this->agent->is_mobile()) {
            $this->viewData['load_page'] = 'user/dictionary/mb/dictionary_ta';
        /* pc */
        } else {
            $this->viewData['load_page'] = 'user/pc/dictionary/dictionary_ta';
            $this->layout = "user/pc/layout/main";
            $this->breadscrumb_array[] = array("class" => "", "text" => "た行", "link"=>"");
        }

        $this->viewData['breadscrumb_array'] = $this->breadscrumb_array;
        $this->viewData['titlePage'] = 'た行の用語辞典｜風俗求人・高収入アルバイトのジョイスペ';
        $this->load->view($this->layout, $this->viewData);
    }

    public function na() {
        /* sp */
        if ($this->agent->is_mobile()) {
            $this->viewData['load_page'] = 'user/dictionary/mb/dictionary_na';
        /* pc */
        } else {
            $this->viewData['load_page'] = 'user/pc/dictionary/dictionary_na';
            $this->layout = "user/pc/layout/main";
            $this->breadscrumb_array[] = array("class" => "", "text" => "な行", "link"=>"");
        }

        $this->viewData['breadscrumb_array'] = $this->breadscrumb_array;
        $this->viewData['titlePage'] = 'な行の用語辞典｜風俗求人・高収入アルバイトのジョイスペ';
        $this->load->view($this->layout, $this->viewData);
    }

    public function ha() {
        /* sp */
        if ($this->agent->is_mobile()) {
            $this->viewData['load_page'] = 'user/dictionary/mb/dictionary_ha';
        /* pc */
        } else {
            $this->viewData['load_page'] = 'user/pc/dictionary/dictionary_ha';
            $this->layout = "user/pc/layout/main";
            $this->breadscrumb_array[] = array("class" => "", "text" => "は行", "link"=>"");
        }

        $this->viewData['breadscrumb_array'] = $this->breadscrumb_array;
        $this->viewData['titlePage'] = 'は行の用語辞典｜風俗求人・高収入アルバイトのジョイスペ';
        $this->load->view($this->layout, $this->viewData);
    }

    public function ma() {
        /* sp */
        if ($this->agent->is_mobile()) {
            $this->viewData['load_page'] = 'user/dictionary/mb/dictionary_ma';
        /* pc */
        } else {
            $this->viewData['load_page'] = 'user/pc/dictionary/dictionary_ma';
            $this->layout = "user/pc/layout/main";
            $this->breadscrumb_array[] = array("class" => "", "text" => "ま行", "link"=>"");
        }

        $this->viewData['breadscrumb_array'] = $this->breadscrumb_array;
        $this->viewData['titlePage'] = 'ま行の用語辞典｜風俗求人・高収入アルバイトのジョイスペ';
        $this->load->view($this->layout, $this->viewData);
    }

    public function ya() {
        /* sp */
        if ($this->agent->is_mobile()) {
            $this->viewData['load_page'] = 'user/dictionary/mb/dictionary_ya';
        /* pc */
        } else {
            $this->viewData['load_page'] = 'user/pc/dictionary/dictionary_ya';
            $this->layout = "user/pc/layout/main";
            $this->breadscrumb_array[] = array("class" => "", "text" => "や行", "link"=>"");
        }

        $this->viewData['breadscrumb_array'] = $this->breadscrumb_array;
        $this->viewData['titlePage'] = 'や行の用語辞典｜風俗求人・高収入アルバイトのジョイスペ';
        $this->load->view($this->layout, $this->viewData);
    }

    public function ra() {
        /* sp */
        if ($this->agent->is_mobile()) {
            $this->viewData['load_page'] = 'user/dictionary/mb/dictionary_ra';
        /* pc */
        } else {
            $this->viewData['load_page'] = 'user/pc/dictionary/dictionary_ra';
            $this->layout = "user/pc/layout/main";
            $this->breadscrumb_array[] = array("class" => "", "text" => "ら行", "link"=>"");
        }

        $this->viewData['breadscrumb_array'] = $this->breadscrumb_array;
        $this->viewData['titlePage'] = 'ら行の用語辞典｜風俗求人・高収入アルバイトのジョイスペ';
        $this->load->view($this->layout, $this->viewData);
    }

    public function wa() {
        /* sp */
        if ($this->agent->is_mobile()) {
            $this->viewData['load_page'] = 'user/dictionary/mb/dictionary_wa';
        /* pc */
        } else {
            $this->viewData['load_page'] = 'user/pc/dictionary/dictionary_wa';
            $this->layout = "user/pc/layout/main";
            $this->breadscrumb_array[] = array("class" => "", "text" => "わ行", "link"=>"");
        }

        $this->viewData['breadscrumb_array'] = $this->breadscrumb_array;
        $this->viewData['titlePage'] = 'わ行の用語辞典｜風俗求人・高収入アルバイトのジョイスペ';
        $this->load->view($this->layout, $this->viewData);
    }

}

?>

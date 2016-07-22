<?php
class Misc extends MY_Controller {
    private $layout = "user/layout/main";
    private $layout_pc = "user/layout/pc_page";
    private $viewData = array();
    public function __construct() {
        parent::__construct();
        $this->load->library('user_agent');
    }
    public function index() {
        $this->viewData['titlePage'] = '交通費キャンペーン15000円｜風俗求人・高収入アルバイトのジョイスペ';
        $this->viewData['load_page'] = 'user/misc/koutsuhi01';
        $this->load->view($this->layout,$this->viewData);
    }
    public function koutsuhi01() {
        $this->viewData['titlePage'] = '交通費キャンペーン15000円｜風俗求人・高収入アルバイトのジョイスペ';
        $this->viewData['load_page'] = 'user/misc/koutsuhi01';
        $this->load->view($this->layout,$this->viewData);
    }
    public function more_point1() {
        $this->viewData['titlePage'] = '風俗・高収入アルバイトのjoyspe｜報酬期待度';
        $this->viewData['load_page'] = 'user/misc/more_point1';
        $this->viewData['class_ext'] = 'more_point1';
        $this->load->view($this->layout,$this->viewData);
    }
    public function more_point2() {
        $this->viewData['titlePage'] = '風俗・高収入アルバイトのjoyspe｜報酬期待度';
        $this->viewData['load_page'] = 'user/misc/more_point2';
        $this->viewData['class_ext'] = 'more_point2';
        $this->load->view($this->layout,$this->viewData);
    }
    public function stepUpDescription(){
        $this->viewData['titlePage'] = '風俗・高収入アルバイトのjoyspe｜報酬期待度';
        $this->viewData['load_page'] = 'user/misc/stepUpDescription';
        $this->viewData['class_ext'] = 'stepUpDescription';
        $this->load->view($this->layout,$this->viewData);
    }
    public function maintenance(){
        $this->load->view('user/misc/maintenance');
    }
    public function tokyohibarai(){
        $this->viewData['titlePage'] = '風俗・高収入アルバイトのjoyspe｜報酬期待度';
        $this->viewData['load_page'] = 'user/misc/tokyohibarai';
        $this->load->view($this->layout,$this->viewData);
    }


    /*
    * Display 鶴岡 manual page name
    *
    * @param string name of page
    */
    public function tsuruoka($page_name) {
        $tsuruoka_pages = array(
            'fuuzokudekasegi' => array(
                'bread_text' => 'スタイル',
                'title' => '一度ハマルと長居してしまう鶴岡の出稼ぎ|高収入求人ジョイスペ',
                'description' => '山形県鶴岡市で高収入求人である風俗アルバイトを考えている人必見！居心地が良く長期間出稼ぎをしてしまう鶴岡の魅力を公開'),
            'fuuzokuokanetamaru' => array(
                'bread_text' => 'スタイル',
                'title' => '鶴岡市の出稼ぎはお金が溜まりやすい|高収入求人ジョイスペ',
                'description' => '鶴岡市は風俗アルバイトはとにかくお金が溜まりやすい！高収入求人のジョイスペがその理由を徹底公開！'),
            'fuuzokukasegeru' => array(
                'bread_text' => 'スタイル',
                'title' => '鶴岡の風俗は儲かりやすい|高収入求人ジョイスペ',
                'description' => '鶴岡市のデリヘルは都心部よりも儲かるって本当？高収入求人ジョイスペ編集部がその真相を解明！'),
            'dekasegishousai' => array(
                'bread_text' => '生活スタイル',
                'title' => '鶴岡の出稼ぎ向け情報|高収入求人ジョイスペ',
                'description' => '.山形県鶴岡市へ風俗（デリヘル）の出稼ぎをする前に知っておきたい情報を徹底調査！家賃、物価、アクセスなど実際の生活スタイルの情報を公開！'),
            'ibent201508'     => array(
                'bread_text' => '>鶴岡8月イベント情報',
                'title' => '2015年8月鶴岡市のイベント情報|高収入求人ジョイスペ',
                'description' => '鶴岡市で風俗アルバイトしてる人必見！2015年8月近隣エリアのイベント情報を徹底調査！お祭り情報などを事前にチェックしてシフトを調整しよう！'),
            'ibent201506'     => array(
                'bread_text' => '>鶴岡6月イベント情報',
                'title' => '2015年6月鶴岡市のイベント情報|高収入求人ジョイスペ',
                'description' => '鶴岡市で風俗アルバイトしてる人必見！2015年6月近隣エリアのイベント情報を徹底調査！お祭り情報などを事前にチェックしてシフトを調整しよう！'),
            'fuuzokutakujisho'=> array(
                'bread_text' => '>鶴岡市の託児所',
                'title' => '鶴岡市で風俗アルバイトするなら託児所事情をチェック｜高収入求人ジョイスペ',
                'description' => '鶴岡市内の託児所事情を調査。風俗求人を探すまえに事前にチェックすることができます。託児所、保育園、一時保育の料金や施設を公開'));

        if (isset($tsuruoka_pages[$page_name])) {
            $this->viewData['bread_text']  = $tsuruoka_pages[$page_name]['bread_text'];;
            $this->viewData['titlePage']   = $tsuruoka_pages[$page_name]['title'];
            $this->viewData['description'] = $tsuruoka_pages[$page_name]['description'];
            $this->viewData['load_page']   = 'user/tsuruoka/' . $page_name;
            $this->viewData['tsuruoka_top_link'] = "/user/jobs/hokkaido/yamagata/tsuruoka/";
            $this->load->view($this->layout, $this->viewData);
        } else {
            $this->load->helper('url');
            redirect(base_url());
        }

    }

    /* バナー設置 */
    public function campaign($campaign_name = null)
    {

        /* sp */
        if ($this->agent->is_mobile()) {
            switch ($campaign_name) {
                case 'travel_expense':
                    $this->layout = "user/layout/main";
                    $this->viewData['titlePage'] = '風俗・高収入アルバイトのjoyspe｜バナー';
                    $this->viewData['load_page'] = 'user/misc/campaign_experience';
                    break;
                case 'trial_work':
                    $this->layout = "user/layout/main";
                    $this->viewData['titlePage'] = '風俗・高収入アルバイトのjoyspe｜バナー';
                    $this->viewData['load_page'] = 'user/misc/campaign_traffic';
                    break;
                default:
                    break;
            }
        /* pc */
        } else {
            switch ($campaign_name) {
                case 'travel_expense':
                    $this->layout = "user/pc/layout/main";
                    $this->viewData['titlePage'] = '風俗・高収入アルバイトのjoyspe｜バナー';
                    $this->viewData['load_page'] = 'user/pc/misc/campaign_experience';
                    break;
                case 'trial_work':
                    $this->layout = "user/pc/layout/main";
                    $this->viewData['titlePage'] = '風俗・高収入アルバイトのjoyspe｜バナー';
                    $this->viewData['load_page'] = 'user/pc/misc/campaign_traffic';
                    break;
                default:
                    break;
            }
        }

        $this->load->view($this->layout, $this->viewData);
    }


}

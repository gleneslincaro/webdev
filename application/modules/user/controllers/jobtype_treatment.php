<?php

class jobtype_treatment extends MY_Controller {
    protected $_data;
    private $viewdata = array();
    private $layout = "user/layout/main";
    private $device = "sp";
    // public $city_check= array();
    function __construct()
    {
        parent::__construct();
        $this->redirect_pc_site();
        $this->load->helper('url');
        $this->load->model("user/Mstyleworking");
        $this->load->model("user/Mscout");
        $this->load->model("user/Musers");
        $this->load->Model("user/MCampaign");
        $this->load->model("user/mcampaign_bonus_request");
        $this->load->Model("admin/Msearch_contents");
        $this->common = new Common();
        $device = $this->input->get('device');
        $this->load->library('user_agent');
        $this->load->library('cipher');
        if ($this->agent->is_mobile() OR $device == 'sp') {
            $this->device = 'sp';
        /* pc */
        } else {
            $this->device = 'pc';
        }
    }

    public function index($group_city, $city = null, $town = null)
    {

    }

    public function jobtype($jobtype, $group_city = null, $city = null, $town = null)
    {
        $this->viewdata['search_type'] = 'jobtype_';
        $this->viewdata['search_que'] = '?cate=';

        $user_id=0;
        if (UserControl::LoggedIn()) {
            $user_id = UserControl::getId();
        }

        if ($this->agent->is_mobile()) {
            $this->viewdata['load_page'] = "user/jobtype/index";
            $this->layout = "user/layout/main";
        } else {
            $this->viewdata['load_page'] = "user/pc/jobtype/index";
            $this->layout = "user/pc/layout/main";
        }

        switch (true) {
            case ($group_city != null && $city == null && $town == null):
            /* 大エリア */
                $this->viewdata['jobtype'] = $jobtype;
                $jobtype_info = $this->Mstyleworking->getJobTypeInfoContents($jobtype);
                $this->viewdata['jobtype_info'] = $jobtype_info;
                $this->viewdata['info_name'] = $jobtype_info['name'];

                if($jobtype_info['id'] == null) {
                    show_404();
                }

                $city_group = $this->mcity->getCityGroup();
                $this->viewdata['city_group'] = $city_group;

                $groupCity_info = $this->mcity->getGroupCityByAlphaName($group_city);
                $this->viewdata['groupCity_info'] = $groupCity_info;

                $area_ar = array();
                $area_ar = $this->mcity->getCity($groupCity_info['id']);
                $this->viewdata['get_city_ar'] = $area_ar;
                foreach ($area_ar as $key => $val) {
                    $arr_town = $this->mcity->getTownIds($val['id']);
                    $area_ar[$key]['towns'] = $arr_town;
                }
                $this->viewdata['city_towns_ar'] = $area_ar;


                $breadscrumb_array = array(
                    array("class" => "", "text" => $jobtype_info['name'], "link"=>base_url().'jobtype_'.$jobtype_info['alph_name'].'/'),
                    array("class" => "", "text" => $groupCity_info['name'], "link"=>"")
                );
                $this->viewdata['breadscrumb_array'] = $breadscrumb_array;


                $this->viewdata['titlePage'] = $groupCity_info['name'].'の'.$jobtype_info['name'].'求人｜高収入アルバイトのジョイスペ';

                $this->viewdata['getCity'] = true;
                $city_group_contents = $this->mcity->getCityGroupById($groupCity_info['id']);
                if ($city_group_contents['contents'] != '' || $city_group_contents['contents'] != null) {
                    $this->viewdata['city_group_contents'] = $city_group_contents['contents'];
                }

                $this->load->model("user/Mbuffer");
                $this->viewdata['column_data'] = $this->Mbuffer->get_column_buffer();/* バッファからコラム取得 */

                $groupCity_str = '';
                foreach ($area_ar as $key => $val) {
                    $groupCity_str .= ($key > 0)? '・'.$val['name'] : $val['name'];
                }

                $description = $jobtype_info['top_description'];
                $description = str_replace("/--AREA_DE--/", $groupCity_info['name'].'で', $description);
                $description = str_replace("/--AREA_NO--/", $groupCity_info['name'].'の', $description);
                $description = str_replace("/--AREA2_DE--/", $groupCity_str.'で', $description);
                $description = str_replace("/--AREA2_NO--/", $groupCity_str.'の', $description);
                if ($description != null) {
                    $this->viewdata['description'] = $description;
                }
                else {
                    $description =
    "/--GROUPCITY--/の風俗求人・高収入アルバイト情報をご紹介。/--CITYS--/の/--JOBTYPE--/の風俗求人アルバイト情報を未経験の人でも安心してお仕事検索ができます！《最大1万5千円の面接交通費をジョイスペが保証！》";
                    $description = str_replace("/--GROUPCITY--/", $groupCity_info['name'], $description);
                    $description = str_replace("/--CITYS--/", $groupCity_str, $description);
                    $description = str_replace("/--JOBTYPE--/", $jobtype_info['name'], $description);
                    $this->viewdata['description'] = $description;
                }

                $this->viewdata['keywords']  = '風俗,求人,高収入アルバイト';
                if ($this->agent->is_mobile()) {
                    $this->viewdata['load_page'] = "user/jobtype/group_city";
                } else {
                    $this->viewdata['load_page'] = "user/pc/jobtype/group_city";
                }
                break;

            case ($group_city != null && $city != null && $town == null):
            /* 中エリア */
                $this->viewdata['group_city'] = $group_city;
                $this->viewdata['city'] = $city;

                $city_group = $this->mcity->getCityGroup();
                $this->viewdata['city_group'] = $city_group;

                $this->viewdata['jobtype'] = $jobtype;
                $jobtype_info = $this->Mstyleworking->getJobTypeInfoContents($jobtype);
                $this->viewdata['jobtype_info'] = $jobtype_info;
                $this->viewdata['info_name'] = $jobtype_info['name'];
                if($jobtype_info['id'] == null) {
                    show_404();
                }

                $groupCity_info = $this->mcity->getCityGroupIds();
                $this->viewdata['getCityGroup'] = $groupCity_info;

                $groupCity_info = $this->mcity->getGroupCityByAlphaName($group_city);
                $this->viewdata['groupCity_info'] = $groupCity_info;


                $City_info = $this->mcity->getCityByAlphaName($city);
                $this->viewdata['City_info'] = $City_info;
                $this->viewdata['city_info'] = $City_info;

                $getCity = $this->mcity->getCity($groupCity_info['id']);

                $getTown = $this->mcity->getTown($City_info['id']);
                $this->viewdata['towns'] = $getTown;

                $area_ar = array();
                $city_cont = 0;
                foreach ($getCity as $key => $value) {
                    $area_ar[$key] = $value;
                    $arr_town = $this->mcity->getTownOwnerCount($value['id']);
                    ksort($arr_town);
                    $area_ar[$key]['towns'] = $arr_town;
                }
                $this->viewdata['city_towns'] = $area_ar;

                $breadscrumb_array = array(
                    array("class" => "", "text" => $jobtype_info['name'], "link"=>base_url().'jobtype_'.$jobtype_info['alph_name'].'/'),
                    array("class" => "", "text" => $groupCity_info['name'], "link"=>base_url().'jobtype_'.$jobtype_info['alph_name'].'/'.$groupCity_info['alph_name'].'/'),
                    array("class" => "", "text" => $City_info['name'], "link"=>"")
                );
                $this->viewdata['breadscrumb_array'] = $breadscrumb_array;

                $this->viewdata['titlePage'] = $City_info['name'].'の'.$jobtype_info['name'].'求人｜高収入アルバイトのジョイスペ';

                $this->viewdata['getTowns'] = true;
                $city_contents = $this->mcity->getCityById($City_info['id']);
                if ($city_contents['contents'] != '' || $city_contents['contents'] != null) {
                    $this->viewdata['city_contents'] = $city_contents['contents'];
                }

                $description = $jobtype_info['top_description'];
                $description = str_replace("/--AREA_DE--/", $City_info['name'].'で', $description);
                $description = str_replace("/--AREA_NO--/", $City_info['name'].'の', $description);
                $description = str_replace("/--AREA2_DE--/", $City_info['name'].'で', $description);
                $description = str_replace("/--AREA2_NO--/", $City_info['name'].'の', $description);
                if ($description != null) {
                    $this->viewdata['description'] = $description;
                }
                else {
                    $description = 
    "/--CITY--/の風俗求人・高収入アルバイト情報をご紹介。/--CITY--/の/--JOBTYPE--/の風俗求人アルバイト情報を未経験の人でも安心してお仕事検索ができます！《最大1万5千円の面接交通費をジョイスペが保証！》";
                    $description = str_replace("/--CITY--/", $City_info['name'], $description);
                    $description = str_replace("/--JOBTYPE--/", $jobtype_info['name'], $description);
                    $this->viewdata['description'] = $description;
                }

                $this->viewdata['keywords']  = '風俗,求人,高収入アルバイト';
                if ($this->agent->is_mobile()) {
                    $this->viewdata['load_page'] = "user/jobtype/town";
                } else {
                    $this->viewdata['load_page'] = "user/pc/jobtype/town";
                }
                break;

            default:
                $this->viewdata['jobtype'] = $jobtype;
                $jobtype_info = $this->Mstyleworking->getJobTypeInfoContents($jobtype);
                $this->viewdata['jobtype_info'] = $jobtype_info;
                $this->viewdata['info_name'] = $jobtype_info['name'];
                if($jobtype_info['id'] == null) {
                    show_404();
                }

                $city_group = $this->mcity->getCityGroup();
                $this->viewdata['city_group'] = $city_group;

                $breadscrumb_array = array(
                    array("class" => "", "text" => $jobtype_info['name'], "link"=>"")
                );
                $this->viewdata['breadscrumb_array'] = $breadscrumb_array;
                $this->viewdata['titlePage'] = $jobtype_info['name'].'求人｜高収入アルバイトのジョイスペ';
                $this->viewdata['area_hi'] = '職種で探す'.$jobtype_info['name'].'の高収入アルバイト求人';


                $city_groups = $this->mcity->getCityGroupIds();/* 都市 */
                $city_group_ar = array();
                $city_ar = array();

                foreach ($city_groups as $key => $val) {
                    $city_ar[$key] = $val;
                    $city_group_id = $val['id'];
                    $citys = $this->mcity->getCityIds($city_group_id);
                    foreach ($citys as $key1 => $val1) {
                        $city_ar[$key][$city_group_id][] = $val1;
                    }
                }
                $this->viewdata['getCity'] = $city_ar;

                $description = $jobtype_info['top_description'];
                $description = str_replace("/--AREA_DE--/", '', $description);
                $description = str_replace("/--AREA_NO--/", '', $description);
                $description = str_replace("/--AREA2_DE--/", '', $description);
                $description = str_replace("/--AREA2_NO--/", '', $description);
                if ($description != null) {
                    $this->viewdata['description'] = $description;
                }
                $this->viewdata['keywords']  = '風俗,求人,高収入アルバイト';
                if ($this->agent->is_mobile()) {
                    $this->viewdata['load_page'] = "user/jobtype/index";
                    $this->viewdata['image_area_path'] = '/public/user/image/jobtype/main_bg_top.jpg';
                } else {
                    $this->viewdata['load_page'] = "user/pc/jobtype/index";
                    $this->viewdata['image_area_path'] = '/public/user/pc/image/jobtype/main_bg_top.jpg';
                }
                break;
        }

        $this->viewdata['idheader'] = NULL;
        $this->viewdata['banner_data'] = $this->common->getLatestBanner();
        $this->load->view($this->layout, $this->viewdata);
    }

    public function treatment($treatment, $group_city = null, $city = null, $town = null)
    {
        $this->viewdata['search_type'] = 'treatment_';
        $this->viewdata['search_que'] = '?treatment=';

        if ($this->agent->is_mobile()) {
            $this->layout = "user/layout/main";
        } else {
            $this->layout = "user/pc/layout/main";
        }

        switch (true) {
            case ($group_city != null && $city == null && $town == null):
            /* 大エリア */
                $this->viewdata['jobtype'] = $treatment;
                $treatment_info = $this->Mstyleworking->getTreatmentInfoContents($treatment);
                $this->viewdata['jobtype_info'] = $treatment_info;
                if($treatment_info['id'] == null) {
                    show_404();
                }

                $city_group = $this->mcity->getCityGroup();
                $this->viewdata['city_group'] = $city_group;

                $groupCity_info = $this->mcity->getGroupCityByAlphaName($group_city);
                $this->viewdata['groupCity_info'] = $groupCity_info;

                $area_ar = array();
                $area_ar = $this->mcity->getCity($groupCity_info['id']);
                $this->viewdata['get_city_ar'] = $area_ar;
                foreach ($area_ar as $key => $val) {
                    $arr_town = $this->mcity->getTownIds($val['id']);
                    $area_ar[$key]['towns'] = $arr_town;
                }
                $this->viewdata['city_towns_ar'] = $area_ar;

                $treatment_top_h3 = ($this->_treatment_top_h3($treatment))? $this->_treatment_top_h3($treatment) : $treatment_info['name'];
                $this->viewdata['info_name'] = $treatment_top_h3;

                $breadscrumb_array = array(
                    array("class" => "", "text" => $treatment_top_h3, "link"=>base_url().'treatment_'.$treatment_info['alph_name'].'/'),
                    array("class" => "", "text" => $groupCity_info['name'], "link"=>"")
                );
                $this->viewdata['breadscrumb_array'] = $breadscrumb_array;

                $titlePage = $treatment_info['name'];
                $titlePage .= $this->_title_cat($treatment);
                $this->viewdata['titlePage'] = $groupCity_info['name'].'で'.$titlePage.'風俗求人｜ジョイスペ';

                $this->viewdata['getCity'] = true;
                $city_group_contents = $this->mcity->getCityGroupById($groupCity_info['id']);
                if ($city_group_contents['contents'] != '' || $city_group_contents['contents'] != null) {
                    $this->viewdata['city_group_contents'] = $city_group_contents['contents'];
                }

                $this->load->model("user/Mbuffer");
                $this->viewdata['column_data'] = $this->Mbuffer->get_column_buffer();/* バッファからコラム取得 */


                $groupCity_str = '';
                foreach ($area_ar as $key => $val) {
                    $groupCity_str .= ($key > 0)? '・'.$val['name'] : $val['name'];
                }

                /* description */
                $description = $treatment_info['top_description'];
                $description = str_replace("/--AREA_DE--/", $groupCity_info['name'].'で', $description);
                $description = str_replace("/--AREA_NO--/", $groupCity_info['name'].'の', $description);
                $description = str_replace("/--AREA_DENO--/", $groupCity_info['name'].'での', $description);
                $this->viewdata['description'] = $description;

                $this->viewdata['keywords']  = '風俗,求人,高収入アルバイト';
                if ($this->agent->is_mobile()) {
                    $this->viewdata['load_page'] = "user/jobtype/group_city";
                } else {
                    $this->viewdata['load_page'] = "user/pc/jobtype/group_city";
                }
                break;

            case ($group_city != null && $city != null && $town == null):
            /* 中エリア */
                $this->viewdata['group_city'] = $group_city;
                $this->viewdata['city'] = $city;

                $city_group = $this->mcity->getCityGroup();
                $this->viewdata['city_group'] = $city_group;

                $this->viewdata['jobtype'] = $treatment;
                $treatment_info = $this->Mstyleworking->getTreatmentInfoContents($treatment);
                $this->viewdata['jobtype_info'] = $treatment_info;
                if($treatment_info['id'] == null) {
                    show_404();
                }

                $groupCity_info = $this->mcity->getCityGroupIds();
                $this->viewdata['getCityGroup'] = $groupCity_info;

                $groupCity_info = $this->mcity->getGroupCityByAlphaName($group_city);
                $this->viewdata['groupCity_info'] = $groupCity_info;

                $City_info = $this->mcity->getCityByAlphaName($city);
                $this->viewdata['City_info'] = $City_info;
                $this->viewdata['city_info'] = $City_info;

                $getCity = $this->mcity->getCity($groupCity_info['id']);

                $getTown = $this->mcity->getTown($City_info['id']);
                $this->viewdata['towns'] = $getTown;

                $area_ar = array();
                $city_cont = 0;
                foreach ($getCity as $key => $value) {
                    $area_ar[$key] = $value;
                    $arr_town = $this->mcity->getTownOwnerCount($value['id']);
                    ksort($arr_town);
                    $area_ar[$key]['towns'] = $arr_town;
                }
                $this->viewdata['city_towns'] = $area_ar;

                $treatment_top_h3 = ($this->_treatment_top_h3($treatment))? $this->_treatment_top_h3($treatment) : $treatment_info['name'];
                $this->viewdata['info_name'] = $treatment_top_h3;

                $breadscrumb_array = array(
                    array("class" => "", "text" => $treatment_top_h3, "link"=>base_url().'treatment_'.$treatment_info['alph_name'].'/'),
                    array("class" => "", "text" => $groupCity_info['name'], "link"=>base_url().'treatment_'.$treatment_info['alph_name'].'/'.$groupCity_info['alph_name'].'/'),
                    array("class" => "", "text" => $City_info['name'], "link"=>"")
                );
                $this->viewdata['breadscrumb_array'] = $breadscrumb_array;

                $titlePage = $treatment_info['name'];
                $titlePage .= $this->_title_cat($treatment);
                $this->viewdata['titlePage'] = $City_info['name'].'で'.$titlePage.'風俗求人｜ジョイスペ';

                $this->viewdata['getTowns'] = true;
                $city_contents = $this->mcity->getCityById($City_info['id']);
                if ($city_contents['contents'] != '' || $city_contents['contents'] != null) {
                    $this->viewdata['city_contents'] = $city_contents['contents'];
                }

                /* description */
                $description = $treatment_info['top_description'];
                $description = str_replace("/--AREA_DE--/", $City_info['name'].'で', $description);
                $description = str_replace("/--AREA_NO--/", $City_info['name'].'の', $description);
                $description = str_replace("/--AREA_DENO--/", $City_info['name'].'での', $description);
                $this->viewdata['description'] = $description;

                $this->viewdata['keywords']  = '風俗,求人,高収入アルバイト';
                if ($this->agent->is_mobile()) {
                    $this->viewdata['load_page'] = "user/jobtype/town";
                } else {
                    $this->viewdata['load_page'] = "user/pc/jobtype/town";
                }
                break;

            default:
                $this->viewdata['treatment'] = $treatment;
                $treatment_info = $this->Mstyleworking->getTreatmentInfoContents($treatment);
                if($treatment_info['id'] == null) {
                    show_404();
                }

                $temp = $treatment_info['contents3'];
                $temp = str_replace("/--BASE_JOB--/", base_url().'jobtype_', $temp);
                $temp = str_replace("/--BASE_URL--/", base_url(), $temp);
                $treatment_info['contents3'] = $temp;

                $this->viewdata['treatment_info'] = $treatment_info;

                $city_group = $this->mcity->getCityGroup();
                $this->viewdata['city_group'] = $city_group;

                $city_groups = $this->mcity->getCityGroupIds();
                $city_group_ar = array();
                $city_ar = array();

                foreach ($city_groups as $key => $val) {
                    $city_ar[$key] = $val;
                    $city_group_id = $val['id'];
                    $citys = $this->mcity->getCityIds($city_group_id);
                    foreach ($citys as $key1 => $val1) {
                        $city_ar[$key][$city_group_id][] = $val1;
                    }
                }
                $this->viewdata['getCity'] = $city_ar;


                $titlePage = $treatment_info['name'];
                $titlePage .= $this->_title_cat($treatment);

                $this->viewdata['titlePage'] = $titlePage.'風俗求人｜ジョイスペ';
                $this->viewdata['area_hi'] = '待遇で探す'.$treatment_info['name'].'の高収入アルバイト求人';

                $description = $treatment_info['top_description'];
                $description = str_replace("/--AREA_DE--/", '', $description);
                $description = str_replace("/--AREA_NO--/", '', $description);
                $description = str_replace("/--AREA_DENO--/", '', $description);
                $this->viewdata['description'] = $description;

                $treatment_top_h3 = ($this->_treatment_top_h3($treatment))? $this->_treatment_top_h3($treatment) : $treatment_info['name'];
                $this->viewdata['info_name'] = $treatment_top_h3;

                $breadscrumb_array = array(
                    array("class" => "", "text" => $treatment_top_h3, "link"=>"")
                );
                $this->viewdata['breadscrumb_array'] = $breadscrumb_array;

                $this->viewdata['keywords']  = '風俗,求人,高収入アルバイト';
                if ($this->agent->is_mobile()) {
                    $this->viewdata['load_page'] = "user/treatment/index";
                    $this->viewdata['image_area_path'] = '/public/user/image/jobtype/main_bg_top.jpg';
                } else {
                    $this->viewdata['load_page'] = "user/pc/treatment/index";
                    $this->viewdata['image_area_path'] = '/public/user/pc/image/jobtype/main_bg_top.jpg';
                }
                break;
        }

        $this->viewdata['idheader'] = NULL;
        $this->viewdata['banner_data'] = $this->common->getLatestBanner();
        $this->load->view($this->layout, $this->viewdata);

    }

    public function _title_cat($treatment)
    {
        switch ($treatment) {
            case 'taiken':
            case 'tanjikan':
            case 'seifuku_bihin':
                $title = '可能な';
                break;

            case 'hibarai':
            case 'choukikyuuka':
                $title = 'な';
                break;

            case 'ryouari':
                $title = 'を完備している';
                break;

            case 'kyuuyohosyou':
                $title = 'がある';
                break;

            case 'syucchoumensetu':
            case 'koshitsutaiki':
            case 'housyoukinn':
            case 'eiseitaisaku':
            case 'seirikyuuka':
                $title = 'ありの';
                break;

            case 'alibi':
                $title = 'のある';
                break;

            case 'mennsetsukoutsuuhi':
            case 'bakkin':
            case 'takujijoari':
            case 'mikeiken':
            default:
                $title = 'の';
                break;
        }
        return $title;
    }

    public function _treatment_top_h3($treatment)
    {
        switch ($treatment) {
            case 'ryouari':
                $text = '寮完備';
                break;
            case 'housyoukinn':
                $text = '報奨金完備';
                break;
            case 'sougeiari':
                $text = '送迎可能';
                break;
            case 'syucchoumensetu':
                $text = '出張面接可能';
                break;
            case 'koshitsutaiki':
                $text = '個室待機完備';
                break;
            case 'eiseitaisaku':
                $text = '衛生対策完備';
                break;
            case 'seirikyuuka':
                $text = '生理休暇可能';
                break;
            default:
                $text = false;
                break;
        }
        return $text;
    }

}
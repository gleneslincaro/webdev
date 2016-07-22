<?php

class faq extends MY_Controller {
    protected $_data;
    private $viewdata = array();
    private $layout = "user/layout/main";
    private $device = "sp";
    private $page_line_max = 5;
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

    public function index($group_city = null, $city = null, $town = null)
    {
        if ($group_city == null) {
            show_404();
        }

        $user_id=0;
        if (UserControl::LoggedIn()) {
            $user_id = UserControl::getId();
            $getuser = $this->Musers->get_users($user_id);
            $this->viewdata['getuserInfo'] = $getuser;

            $this->load->module('user/joyspe_user');
            $data = $this->joyspe_user->has_step_up_campaign($user_id);
            if ($data) {
                foreach ($data as $key => $value) {
                    $this->viewdata["$key"] = $value;
                }
            }
        }
        $groupCity_info = $this->mcity->getGroupCityByAlphaName($group_city);
        $this->viewdata['group_city'] = $group_city;
        $this->viewdata['city'] = $city;
        $this->viewdata['town'] = $town;
        if (!$group_city || !$groupCity_info) {
            redirect(base_url());
        }
        $city_alphaname = $city;
        $town_alphaname = $town;

        $treatment = '';
        $cate = '';
        $this->viewdata['treatment']  = '';
        $this->viewdata['cate']  = '';
        $arrTreatment = null;
        $arrCate = null;
        $countTreatment =0;
        $countCategory = 0;
        $countTown = 0;
        $cate_flag = false;
        $treament_flag = false;

        $treatment = $this->input->get('treatment');
        if ($treatment) {
            $arrTreatment = join("','", explode(",", $treatment));
            $arrTreatment_info = $this->Mstyleworking->getTreatmentInfo($arrTreatment);
            if ($arrTreatment_info['id'] != null) {
                $arrTreatment = join("','", explode(",", $arrTreatment_info['id']));
                $countTreatment = ($treatment=='')? 0:count(explode(',', $treatment));
                $this->viewdata['treatment'] = $arrTreatment_info['name'];
                $this->viewdata['treatment_name'] = explode(',', $arrTreatment_info['name']);
                $this->viewdata['treatment_alph_name'] = explode(',', $arrTreatment_info['alph_name']);
                $treament_flag = true;
            }
        }
        $cate_id = $this->input->get('c');
        if ($cate_id) {
//            echo "cate_id=".$cate_id;
        }


        $this->viewdata['arrTreatment'] = $arrTreatment;
        $this->viewdata['arrCate'] = $arrCate;
        $this->viewdata['groupCity_info'] = $groupCity_info;
        if ($city) {
            $city_info = $this->mcity->getCityByAlphaName($city);
            $this->viewdata['city_info'] = $city_info;
        }

        if ($city != null && $town == null) {
            show_404();
            return;
        } elseif ($city != null && $town != null) {
            $town_explode = join("','", explode("-", $town));
            $countTown = count(explode('-', $town));
            $town_info = $this->Mstyleworking->getSelectTownName($city_info['id'], $town_explode);
            $arrTown = join("','", explode(",", $town_info['id']));
            $this->viewdata['town_info'] = $town_info;
            $this->viewdata['arrTown'] = $town;
            $this->viewdata['arrTownId'] = $arrTown;

            $this->viewdata['town_name'] = $town_info['name'];

            $cityGroup = $groupCity_info['id'];
            $city = $city_info['id'];
            $town = $arrTown;
            $treatment = $arrTreatment;
            $cate = $arrCate;

            $getTreatments = $this->Mstyleworking->getTreatments();
            $getAllJobType = $this->Mstyleworking->getAllJobType();
            $getAllUserChar = $this->Musers->get_all_user_characters();
//            $count_all = $this->Mstyleworking->countSearchStore($cityGroup, $city, $town, $treatment, $cate);

            $this->viewdata['ajax_load_more'] = 'ajax_area_list';
//            $this->viewdata['count'] = $count_all;
//            $this->viewdata['count_all'] = $count_all;
            $this->viewdata['limit'] = STORE_LIMIT;
            $this->viewdata['allJobType'] = $getAllJobType;
            $this->viewdata['treatments'] = $getTreatments;
            $this->viewdata['AllUserChar'] = $getAllUserChar;

            $ar = array();
            foreach ($getTreatments as $key => $value) {
                $group_id = $value['group_id'];
                $ar[$group_id][] = $value;
            }
            $this->viewdata['treatments_group'] = $ar;

            $treatment = false;
            $cate  = false;
            $owner_status = 2;


            $res = $this->Mstyleworking->countSearchStore2($cityGroup, $city, $town);
            if ( $res['count'] == 0){
                show_404();
            }
            $ar = $res['owners'];
/*
            if ($this->device == 'sp') {
                $ar = $this->_getSearchStore($user_id, $cityGroup, $city, $town, $treatment, $cate, STORE_LIMIT, true, 0);
            } else {
                $offset = ($this->input->get('page')) ? $this->input->get('page'): 0;
                $ar = $this->_getSearchStore($user_id, $cityGroup, $city, $town, $treatment, $cate, STORE_LIMIT, true, $offset);
            }*/

            $this->load->model("owner/Mowner");

            $cate_id = 0;
            $cate_id = $this->input->get('c');
            if ($cate_id) {

            }

            $this->viewdata['default_category_id'] = $cate_id;

            $res = $this->Mowner->getUserMessages_public_contents($ar, $cate_id, 0, $this->page_line_max);

            $owners_id = array();
            foreach ($ar as $key => $val) {
                $owners_id[] = $val['id'];
            }
            $this->viewdata['owners_json'] = json_encode($owners_id);

            $this->viewdata['cate_all_count'] = $res['cate_all_count'];
            $cate_all_count = $res['cate_all_count'];

            $this->viewdata['page_max'] = ceil($cate_all_count / $this->page_line_max);
            $this->viewdata['page_line_max'] = $this->page_line_max;
            $this->viewdata['category_message_ar'] = $res['cate_message_ar'];
            $this->viewdata['category_message_num'] = $res['cate_count'];
            $this->viewdata['current_category'] = $res['current_cate'];
            $current_cate = $res['current_cate'];
//            $this->viewdata['storeOwner'] = $ar;
        } else {
            show_404();
            return;
        }

//        $this->viewdata['storeOwner'] = true;
        $this->viewdata['storeTown'] = true;

        if ($this->device == 'sp') {
            $this->viewdata['load_page'] = "search/do_search_faq";
            $this->layout = "user/layout/main";
        } else {
            $this->viewdata['load_page'] = "pc/search/do_search_faq";
            $this->layout = "user/pc/layout/main";
        }

        //description
        //パンくず、タイトル
        $cates_str = "";
        $treaments_str = "";
        $preTitle = "";
        $breadText = "";
        switch ($this->uri->total_segments()) {
            case 3:
                $location = $groupCity_info['name'].'で検索';
                $preTitle = $groupCity_info['name'].'で検索';
                break;
            case 4:
                $location = $city_info['name'].'で検索';
                $preTitle = $city_info['name'].'で検索';
                break;
            default:
                $location = ($countTown > 1) ?$city_info['name'].'の複数エリアの検索結果': $town_info['name'].'の検索結果';
                $preTitle = ($countTown > 1) ? $city_info['name'].'の複数地域の求人': $town_info['name'].'の求人';
                $breadText = ($countTown > 1) ? '検索結果': $town_info['name'];
                break;
        }
        if ($cate_flag) {
            $cates_str = str_replace(",", "", $arrCate_info['name']); // remove comma (,)
        }
        if ($treament_flag) {
            $treaments_str = str_replace(",", "", $arrTreatment_info['name']); // remove comma (,)
        }

        if ($cate_flag && $treament_flag) {
            if ($countTown < 2) {
                $preTitle = $town_info['name'];
                if (($countTreatment < 2) && ($countCategory < 2)) {
                    $preTitle .= '・'.$cates_str.'・'.$treaments_str.'求人';
                    $breadText .= '('.$cates_str.'・'.$treaments_str.')';
                } elseif ($countCategory < 2) {
                    $preTitle .= '・'.$cates_str.'・複数特徴求人';
                    $breadText .= '('.$cates_str.'・複数特徴)';
                } elseif ($countTreatment < 2) {
                    $preTitle .= '・複数業種・'.$treaments_str.'求人';
                    $breadText .= '(複数業種・'.$treaments_str.')';
                } else {
                    $preTitle .= '・複数業種・特徴求人';
                    $breadText .= '(複数業種・特徴)';
                }
            } else {
                $preTitle = $city_info['name'].'の複数地域';
                if (($countTreatment < 2) && ($countCategory < 2)) {
                    $preTitle .= '・'.$cates_str.'・'.$treaments_str.'求人';
                    $breadText .= '('.$cates_str.'・'.$treaments_str.')';
                } elseif ($countCategory < 2) {
                    $preTitle .= '・'.$cates_str.'・複数特徴求人';
                    $breadText .= '('.$cates_str.'・複数特徴)';
                } elseif ($countTreatment < 2) {
                    $preTitle .= '・業種・'.$treaments_str.'求人';
                    $breadText .= '(複数業種・'.$treaments_str.')';
                } else {
                    $preTitle .= '・業種・特徴求人';
                }
            }

        } elseif ($cate_flag) {
            if ($countTown < 2) {
                $preTitle = $town_info['name'];
                if ($countCategory < 2) {
                    $preTitle .= '・'.$cates_str.'求人';
                    $breadText .= '('.$cates_str.')';
                } else {
                    $preTitle .= '・複数業種求人';
                    $breadText .= '(複数業種)';
                }
            } else {
                $preTitle = $city_info['name'].'の複数地域';
                if ($countCategory < 2) {
                    $preTitle .= '・'.$cates_str.'求人';
                    $breadText .= '('.$cates_str.')';
                } else {
                    $preTitle .= '・業種求人';
                }
            }

        } elseif ($treament_flag) {
            if ($countTown < 2) {
                $preTitle = $town_info['name'];
                if ($countTreatment < 2) {
                    $preTitle .= '・'.$treaments_str.'求人';
                    $breadText .= '('.$treaments_str.')';
                } else {
                    $preTitle .= '・複数特徴求人';
                    $breadText .= '(複数特徴)';
                }
            } else {
                $preTitle = $city_info['name'].'の複数地域';
                if ($countTreatment < 2) {
                    $preTitle .= '・'.$treaments_str.'求人';
                    $breadText .= '('.$treaments_str.')';
                } else {
                    $preTitle .= '・特徴求人';
                }
            }
        }
        $preTitle = ($countTown > 1) ?$city_info['name'].'の複数地域': $town_info['name'];

        if ($cate_id > 0) {
            $this->viewdata['titlePage'] = $preTitle.'風俗求人へ届いた'.$current_cate['name'].'に関する解決済み質問一覧 -ジョイスペ-';
//            $this->viewdata['titlePage'] = $preTitle.'の'.$current_cate['name'].'の解決済みの質問 -ジョイスペ-';
            $this->viewdata['description'] = $preTitle.'の'.$current_cate['name'].'に関する質問が一覧で確認できます。掲載店舗様が風俗の様々な疑問・質問にお答えしています。参考にしてください。';
        } else {
            $this->viewdata['titlePage'] = $preTitle.'風俗求人へ届いた解決済み質問一覧 -ジョイスペ-';
//            $this->viewdata['titlePage'] = 'みんなの質問スッキリ解決　' . $preTitle . 'で働きたい子の質問一覧 ｜ 風俗求人の高収入アルバイトと言えば-ジョイスペ-で決まり！';
            $this->viewdata['description'] = 'ジョイスペの'.$preTitle.'で掲載されている店舗で働きたい子の質問が一覧で確認できます。風俗の様々な疑問・質問にお答えしています。参考にしてください。';
        }
        $this->viewdata['breadText'] = $breadText;

        $this->viewdata['page_wrap_qa_list'] = 'page_wrap--store_everyone_qa_list';

        $this->viewdata['idheader'] = NULL;
        $this->viewdata['keywords']  = '風俗,求人,高収入アルバイト';
        $this->viewdata['imagePath'] = base_url(). $this->config->item('upload_owner_url') . 'images/';
        $this->viewdata['banner_bonus_req'] = $this->mcampaign_bonus_request->getLatestCampaignBonusBanner();
        $this->viewdata['banner_data'] = $this->common->getLatestBanner();
        $this->load->view($this->layout, $this->viewdata);
    }


    public function faq_ajax()
    {
        $owners_json = $this->input->post('owners_json');
        $array = json_decode($owners_json, true) ;

        $ar = array();
        foreach ($array as $key => $val) {
            $ar[] = array('id' => $val);
        }

        $user_id=0;
        if (UserControl::LoggedIn()) {
            $user_id = UserControl::getId();
        }

        $this->load->model("owner/Mowner");

        $category_id = $this->input->post('category_id');

        $next_page = $this->input->post('next_page');
        $offset = ($next_page > 0)? ($next_page - 1) * $this->page_line_max: 0;

        $res = $this->Mowner->getUserMessages_public_contents($ar, $category_id, $offset, $this->page_line_max);

        $this->viewdata['cate_all_count'] = $res['cate_all_count'];
        $count = count($res['cate_message_ar']);
        $this->viewdata['category_message_ar'] = $res['cate_message_ar'];
        $this->viewdata['category_message_num'] = $res['cate_count'];
        $this->viewdata['current_category'] = $res['current_cate'];

//        $this->viewdata['load_page'] = "search/do_search_faq_ajax";
        $this->layout = "user/search/do_search_faq_ajax";
        $html = $this->load->view($this->layout, $this->viewdata, true);

        $json_ar = array();
        $json_ar['flag'] = true;
//        $json_ar['owners'] = $ar;
        $json_ar['count'] = $count;
        $json_ar['html'] = $html;
        echo json_encode($json_ar);
    }

    /* ページネーション設定 */
    public function _pagination_set($config)
    {
        $this->load->library('pagination');
        $config['page_query_string'] = TRUE;
        $config['per_page'] = STORE_LIMIT;
        $config['use_page_numbers'] = TRUE;
        $config['first_link'] = FALSE;
        $config['last_link'] = FALSE;
        $config['num_links'] = 2;
        $config['prev_link'] = '&lt;';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = '&gt;';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li><span class="current">';
        $config['cur_tag_close'] = '</span></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['query_string_segment'] = 'page';
        $config['prefix'] = '';
        $this->pagination->initialize($config);
    }

    public function ajax_cityname_list()
    {
        $q = $this->input->post('q');
        switch ($q) {
            case 'getCitys':
                $id = $this->input->post('city_groups_id');
                $this->viewdata['cityGroup_info'] = $this->mcity->getCityGroupName($id);
                $this->viewdata['city_list'] = $this->mcity->getCity($id);
                $this->load->view("user/pc/search_detail_city", $this->viewdata);
                break;
            case 'getTowns':
                $city_groups_id = $this->input->post('city_groups_id');
                $cityGroup_alphaname = $this->mcity->getCityGroupName($city_groups_id);
                $city_id = $this->input->post('city_id');
                $city_alphaname = $this->mcity->getCityById($city_id);
                $ar = $this->mcity->getTownIds($city_id);
                $query = '';
                foreach ($ar as $key => $value) {
                    if ($key > 0) {
                        if ($value['alph_name'] != '') {
                            $query .= '-'.$value['alph_name'];
                        }
                    } else {
                        if ($value['alph_name'] != '') {
                            $query .= $value['alph_name'];
                        }
                    }
                }
                $json_ar = array();
                $json_ar['cityGroup'] = $cityGroup_alphaname['alph_name'];
                $json_ar['city'] = $city_alphaname['alph_name'];
                $json_ar['towns'] = $query;
                echo json_encode($json_ar);
                break;
            default:
                break;
        }
    }

    public function ajax_area_list()
    {

        $user_id=0;
        if (UserControl::LoggedIn()) {
            $user_id = UserControl::getId();
        }
        $treatment = '';
        $cate = '';
        $offset = 0;

        if (isset($_POST['treatment'])) {
            $treatment = $_POST['treatment'];
        }

        if (isset($_POST['cate'])) {
            $cate = $_POST['cate'];
        }

        if (isset($_POST['offset'])) {
            $offset = $_POST['offset'];
        }

        $info_id_count = 0;
        $info_id = $_POST['info_id'];
        $info_id_ar = explode(",",$info_id);
        $info_id_count = count($info_id_ar);
        $info_id = $arrTown = join("','", $info_id_ar);
//        $info_id = $arrTown = join("','",  explode(",",$info_id));
        $cityGroup = $this->input->post('cityGroup');
        $city = $this->input->post('city');
        $town = $this->input->post('town');

        $count_all = $this->Mstyleworking->countSearchStore($cityGroup, $city, $town, $treatment, $cate);
        $getTreatments = $this->Mstyleworking->getTreatments();
        $this->viewdata['treatments'] = $getTreatments;
        $this->viewdata['count']= $count_all;
        $this->viewdata['count_all']= $count_all;
        $this->viewdata['limit'] = STORE_LIMIT;
        
        $ar = $this->_getSearchStore($user_id, $cityGroup, $city, $town, $treatment, $cate, STORE_LIMIT, true, $offset, $info_id,$is_mobile=true);
        /* 交通費キャンペーン と 体験入店キャンペーン */
        $campaign_data  = $this->MCampaign->getLatestCampaign();
        if ($campaign_data) {
            $this->viewdata['travel_expense'] = true;//$campaign_data['travel_expense'];
            foreach ($ar as $key => $value) {
                $travel_expense_bonus_point = $value['travel_expense_bonus_point'];
                if ($travel_expense_bonus_point > 0) {
                    $ar[$key]['travel_expense_bonus'] = $travel_expense_bonus_point;
                } else {
                    $ar[$key]['travel_expense_bonus'] = $campaign_data['travel_expense'];
                }
            }
        }
        $campaignBonusRequest  = $this->MCampaign->getLatestCampaignBonusRequest();
        if ($campaignBonusRequest) {
            $this->viewdata['campaignBonusRequest'] = true;//$campaignBonusRequest;
            foreach ($ar as $key => $value) {
                //check if owner has trial work bonus point
                $owner_trial_work_point = $value['trial_work_bonus_point'];
                if ($owner_trial_work_point > 0) {
                    $ar[$key]['bonus_money'] = $owner_trial_work_point;
                } else {
                    $ar[$key]['bonus_money'] = $campaignBonusRequest['bonus_money'];
                }
            }
        }
        $this->viewdata['storeOwner'] = $ar;
        $this->viewdata['imagePath'] = base_url(). $this->config->item('upload_owner_url') . 'images/';
        $this->load->view("user/share/company_list", $this->viewdata);
    }

    private function _getSearchStore($user_id, $cityGroup, $city, $town, $treatment, $cate, $limit, $withRankSetting, $offset, $info_id= 0, $is_mobile=false) {
        if (!$offset) {
            $offset = 0;
            $page = 1;
        } else {
            $page = $offset;
            if (!$this->agent->is_mobile()) {
                $offset = ($offset - 1) * STORE_LIMIT;
            } else {
                $page = ($page / STORE_LIMIT) + 1;
            }
        }

        $array_keys = array('group_city'=>$cityGroup,'city'=>$city,'town'=>$town);
        if ($treatment != null) {
            $array_keys['treatment'] = $treatment;
        } elseif ($cate != null) {
            $array_keys['cate'] = $cate;
        }
        
        $encrypt_keys  = $this->cipher->encrypt(serialize($array_keys));
         /*check if the user it is time already and reshuffle again the store by EXPIRATION_SHUFFLE_TIME*/
        if ($this->agent->is_mobile()) {
            if ($page == 1) {
                $check_expiration = $this->check_expiration();
            } else{
                $check_expiration = false;
            }

        } else {
            $check_expiration = $this->check_expiration();
        }

        if ($check_expiration == true) {
            unset($_COOKIE['sec_enc']);
            $this->check_expiration(true);
        }

        $temp_id = array();
        $temp_arr = array();
        $search_ids = array();
        $store_display = array();
        $searchStore = array();
        $exist_page = false;
        $not_in_cookie = false;
        if (isset($_COOKIE['sec_enc'])) {
            $decrypt = $this->cipher->decrypt($_COOKIE['sec_enc']);
            $arr = unserialize($decrypt);
            foreach ($arr as $key => $value) {
                if ($key == $encrypt_keys) {
                    $count = 1;
                    if (is_array($value)) {
                        foreach ($value as $index => $ids) {
                            $temp_arr = array();
                            foreach ($ids as $val) {
                                $arr_store = $this->Mowner->get_owner_info($val);
                                if ($index == $page) {
                                    $store_display[] = $arr_store;
                                }
                                
                                $count++;
                                $temp_arr[] = $val;
                                $search_ids[] = $val;
                                
                            }

                            if ($index == $page) {
                                $exist_page = true;
                            }

                            $temp_id[$index] = $temp_arr;
                        }

                        if ($exist_page) {
                            $searchStore = $store_display;
                            $not_in_cookie = true;
                        } else {
                            $count = 0;
                            for ($x=1; $x <= $page; $x++) {
                                if (!array_key_exists($x, $value)) {
                                    $offset = $count * STORE_LIMIT;
                                    $count++;
                                }
                            }
                        }

                        break;
                    }
                }
            }
            $info_id = implode("','",$search_ids);
        }

        /*check if data is already in a cookie if not generate a random store and save to cookie*/
        if ($not_in_cookie == false) {
            if ($this->agent->is_mobile()) {
                $offset = 0;
            }
            $searchStoreWithRankSetting = $this->Mstyleworking->getSearchStore($cityGroup, $city, $town, $treatment, $cate, $limit, $withRankSetting, $offset, $info_id,$is_mobile);
            $countSearchStoreWithRankSetting = count($searchStoreWithRankSetting);

            // owners that have no rank site setting.
            $withRankSetting = false;
            if ($countSearchStoreWithRankSetting > 0) {

                foreach ($searchStoreWithRankSetting as $data) {
                    $arWithRankSetting[strval($data['id'])] =  $data["id"];
                }
                $withRankSetting = '';
                foreach ($arWithRankSetting as $data) {
                    $withRankSetting .= $data.",";
                }

                if ($withRankSetting) {
                    $withRankSetting = rtrim($withRankSetting, ",");
                }
            }

            if ($countSearchStoreWithRankSetting > 0) {
                if ($countSearchStoreWithRankSetting < $limit) {
                    $storeLimit = $limit - $countSearchStoreWithRankSetting;
                    $searchStore = $this->Mstyleworking->getSearchStore($cityGroup, $city, $town, $treatment, $cate, $storeLimit, $withRankSetting, $offset, $info_id,$is_mobile);
                }
            } else {
                $searchStore = $this->Mstyleworking->getSearchStore($cityGroup, $city, $town, $treatment, $cate, $limit, $withRankSetting, $offset, $info_id,$is_mobile);
            }

            // merge owners that have rank site setting and no rank site setting.
            if (isset($searchStoreWithRankSetting)) {
                $searchStore = array_merge($searchStoreWithRankSetting, $searchStore);
            }
        }

        $temp_arr = array();
        foreach ($searchStore as $key => $value) {
            $searchStore[$key]['keepstt']=$this->Mscout->getUserKeepSTT($value['orid'], $user_id);
            if ($not_in_cookie == false ) {
                $temp_arr[] = $value['orid'];
            }
        }

        if ($not_in_cookie == false) {
            $temp_id[$page] = $temp_arr;
        }
        
        ksort($temp_id);
        $arr[$encrypt_keys] = $temp_id;
        $data = $this->cipher->encrypt(serialize($arr));
        setcookie('sec_enc',$data,time()+3600,'/');
        return $searchStore;
    }

    public function check_expiration($reset_time = false) {
        $shuffle_store = false;
        if (!isset($_COOKIE['shuffle_time']) || $reset_time == true) {
            setcookie('shuffle_time',strtotime(date('Y-m-d H:i:s')),time()+3600,'/');
        }
        if(isset($_COOKIE['shuffle_time'])) {
            $datetime1 = $_COOKIE['shuffle_time'];
            $datetime2 = strtotime(date('Y-m-d H:i:s'));
            $interval  = abs($datetime2 - $datetime1);
            $minutes   = round($interval / 60);
            if($minutes > STORE_TIME_SHUFFLE) {
                $shuffle_store = true;
            }
        }
        return $shuffle_store;
    }

}
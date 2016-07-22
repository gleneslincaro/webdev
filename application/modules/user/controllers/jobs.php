<?php

class jobs extends MY_Controller {
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

        $owner_status = "2,5";
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

        $area_h1 = null;


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
        $cate = $this->input->get('cate');
        if ($cate) {
            $arrCate = join("','", explode(",", $cate));
            $arrCate_info = $this->Mstyleworking->getJobTypeInfo($arrCate);
            if ($arrCate_info['id'] != null) {
                $arrCate = join("','", explode(",", $arrCate_info['id']));
                $countCategory = ($cate=='')? 0:count(explode(',', $cate));
                $this->viewdata['cate'] = $arrCate_info['name'];
                $this->viewdata['cate_name'] = explode(',', $arrCate_info['name']);
                $this->viewdata['cate_alph_name'] = explode(',', $arrCate_info['alph_name']);
                $cate_flag = true;
            }
        }

        if (isset($_GET['treatment']) && isset($_GET['cate'])) {
            if ($cate == '' && $treatment == '') {
                redirect(base_url().'user/jobs/'.$group_city.'/'.$city.'/'.$town.'/', "location", 301);
            } elseif ($cate == '') {
                redirect(base_url().'user/jobs/'.$group_city.'/'.$city.'/'.$town.'/?treatment='.$treatment, "location", 301);
            } elseif ($treatment == '') {
                redirect(base_url().'user/jobs/'.$group_city.'/'.$city.'/'.$town.'/?cate='.$cate, "location", 301);
            }
        } elseif (isset($_GET['cate']) && $cate == '') {
            redirect(base_url().'user/jobs/'.$group_city.'/'.$city.'/'.$town.'/', "location", 301);
        } elseif (isset($_GET['treatment']) && $treatment == '') {
            redirect(base_url().'user/jobs/'.$group_city.'/'.$city.'/'.$town.'/', "location", 301);
        }

        $this->viewdata['arrTreatment'] = $arrTreatment;
        $this->viewdata['arrCate'] = $arrCate;
        $this->viewdata['groupCity_info'] = $groupCity_info;
        if ($city) {
            $city_info = $this->mcity->getCityByAlphaName($city);
            $this->viewdata['city_info'] = $city_info;
        }

        switch (true) {
            // echo "中エリア";
            case ($city != null && $town == null):
            $this->viewdata['no_scroll'] = true;
            $getTowns = $this->mcity->getTownUserCount($city_info['id'],$owner_status);
            $owCount = $this->mcity->getCityOwnerCount($city_info['id']);
            $this->viewdata['owCount'] = $owCount['owners_count'];

            $this->viewdata['getTowns'] = $getTowns;

            $city_contents = $this->mcity->getCityById($city_info['id']);
            if ($city_contents['contents'] != '' || $city_contents['contents'] != null) {
                $this->viewdata['city_contents'] = $city_contents['contents'];
            }

            $getAllJobType = $this->Mstyleworking->getAllJobType();
            $this->viewdata['allJobType'] = $getAllJobType;

            // sp
            if ($this->device == 'sp') {
            // pc
            } else {
            }
                break;
            // echo "小エリア";
            case ($city != null && $town != null):
            $town_explode = join("','", explode("-", $town));
            $countTown = count(explode('-', $town));
            $town_info = $this->Mstyleworking->getSelectTownName($city_info['id'], $town_explode);
            $arrTown = join("','", explode(",", $town_info['id']));

            if (($countTown < 2) && ($countTreatment < 2) && ($countCategory < 2)) {
                $town_contents = $this->mcity->getTownById($town_info['id']);
                // マニュアルで「鶴岡」の対応
                if ($town_contents['alph_name'] == "tsuruoka") {
                    $town_curr_event_info = $this->common->get_curr_town_event_info($town_contents['alph_name']);
                    $this->viewdata['town_curr_event_info'] = $town_curr_event_info;
                    $this->viewdata['tsuruoka_top_link'] = '/user/jobs/hokkaido/yamagata/tsuruoka/';
                }

                if ($town_contents['contents'] != '' || $town_contents['contents'] != null) {
                    $this->viewdata['town_contents'] = $town_contents['contents'];
                }

                if ($countTreatment == 1 && $countTreatment > 0) {
                    $treatment_info = $this->Msearch_contents->getTreatmentContents($arrTreatment_info['id']);
                    if ($treatment_info['contents'] != '' || $treatment_info['contents'] != null) {
                        $this->viewdata['treatment_info'] = $treatment_info;
                    }
                }
                if ($countCategory == 1 && $countCategory > 0) {
                    $category_info = $this->Msearch_contents->getJobtypeContents($arrCate_info['id']);
                    if ($category_info['contents'] != '' || $category_info['contents'] != null) {
                        $this->viewdata['category_info'] = $category_info;
                    }
                }
            }
            $this->viewdata['town_info'] = $town_info;
            $this->viewdata['arrTown'] = $town;
            $this->viewdata['arrTownId'] = $arrTown;

            $cityGroup = $groupCity_info['id'];
            $city = $city_info['id'];
            $town = $arrTown;
            $treatment = $arrTreatment;
            $cate = $arrCate;

            $getTreatments = $this->Mstyleworking->getTreatments();
            $getAllJobType = $this->Mstyleworking->getAllJobType();
            $getAllUserChar = $this->Musers->get_all_user_characters();
            $count_all = $this->Mstyleworking->countSearchStore($cityGroup, $city, $town, $treatment, $cate,$owner_status);

            $count_all_ar = $this->Mstyleworking->countSearchStore2($cityGroup, $city, $town, $treatment, $cate,$owner_status);

            $this->viewdata['ajax_load_more'] = 'ajax_area_list';
            $this->viewdata['count'] = $count_all;
            $this->viewdata['count_all'] = $count_all;
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

            /* sp */
            if ($this->device == 'sp') {
                $ar = $this->_getSearchStore($user_id, $cityGroup, $city, $town, $treatment, $cate, STORE_LIMIT, true, 0);
            /* pc */
            } else {
                $offset = ($this->input->get('page')) ? $this->input->get('page'): 0;
                $ar = $this->_getSearchStore($user_id, $cityGroup, $city, $town, $treatment, $cate, STORE_LIMIT, true, $offset);
            }
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
            $count_all_ar = $this->Mstyleworking->countSearchStore2($cityGroup, $city, $town);

            if ($countTown < 2) {
                $this->load->model("owner/Mowner");
                $res = $this->Mowner->getUserMessages_public($count_all_ar['owners']);
                $this->viewdata['category_message_ar'] = $res['new_cate_message'];
                if ($res['cate_count']) {
                    $this->viewdata['category_message_num'] = $res['cate_count'];
                }
            }

            $this->viewdata['storeOwner'] = $ar;

            // sp
            if ($this->device == 'sp') {
            // pc
            } else {
            }
                break;
            // echo "大エリア";
            default:
/*            if ($cate_flag) {
                echo "業種string";
            }
            if ($treament_flag) {
                echo "待遇string";
            }*/

            $this->viewdata['no_scroll'] = true;
            $getCity = $this->mcity->getCity($groupCity_info['id']);
            $this->viewdata['getCity'] = $getCity;
            $get_city_ar = $getCity;
            $city_group_contents = $this->mcity->getCityGroupById($groupCity_info['id']);
            if ($city_group_contents['contents'] != '' || $city_group_contents['contents'] != null) {
                $this->viewdata['city_group_contents'] = $city_group_contents['contents'];
            }

            $getTreatments = $this->Mstyleworking->getTreatments();
            $getAllJobType = $this->Mstyleworking->getAllJobType();
            $getAllUserChar = $this->Musers->get_all_user_characters();
            $this->viewdata['treatments'] = $getTreatments;
            $this->viewdata['allJobType'] = $getAllJobType;
            $this->viewdata['AllUserChar'] = $getAllUserChar;

            $ar = array();
            foreach ($getTreatments as $key => $value) {
                $group_id = $value['group_id'];
                $ar[$group_id][] = $value;
            }
            $this->viewdata['treatments_group'] = $ar;

            // sp
            if ($this->device == 'sp') {
            // pc
            } else {
            }
                break;
        }

        /* sp */
        if ($this->device == 'sp') {
            $this->viewdata['load_page'] = "search/do_search";
            $this->layout = "user/layout/main";
        /* pc */
        } else {
            $this->viewdata['articles'] = null; //$this->Mowner->getUrgentRecruitmentsLatestPost();
            $this->layout = "user/pc/layout/main";
//            $this->viewdata['total_users'] = HelperGlobal::getUserTotalNumber();
//            $this->viewdata['total_owners'] = HelperGlobal::gettotalHeader();
            /* CityGroup/City/ */
            if ($city != null && $town == null) {
                $groupCity_info = $this->mcity->getCityGroupIds();
                $this->viewdata['getCityGroup'] = $groupCity_info;
                $this->viewdata['towns'] = $this->mcity->getTownUserCount($city_info['id'],$owner_status);
                $this->viewdata['load_page'] = "pc/search/do_search";
                $this->viewdata['load_page_area'] = "pc/search/search_town";
            /* CityGroup/City/Town/ */
            } elseif ($city != null && $town != null) {
                $subpage = $this->input->get('subpage');
                if ($subpage) {
                    if ($subpage == 'feature') {
                        $this->viewdata['feature_canonical'] = base_url()."user/jobs/$group_city/$city_alphaname/$town_alphaname/";
                        $this->viewdata['subpage'] = true;
                        $this->viewdata['getFeature'] = true;
                        $this->viewdata['back_url'] = base_url()."user/jobs/$group_city/$city_alphaname/$town_alphaname/";
                        $this->viewdata['load_page'] = "pc/search/feature";
                        $this->viewdata['load_page_area'] = "pc/search/feature/town_contents";
                    } else {
                        redirect(base_url()."user/jobs/$group_city/$city_alphaname/$town_alphaname/");
                    }
                } else {
                    $this->load->library('pagination');
                    /* ページネーション設定 */
                    $config['base_url'] = base_url()."user/jobs/$group_city/$city_alphaname/$town_alphaname/?";
                    $config['total_rows'] = $count_all;
                    $this->_pagination_set($config);
                    $this->viewdata['page_links'] = $this->pagination->create_links();

                    $groupCity_info = $this->mcity->getCityGroupIds();
                    $towns = explode(",", $town_info['name']);
                    $towns_alph_name = explode(",", $town_info['alph_name']);
                    $towns_id = explode(",", $town_info['id']);

                    // get all jobs belonging to a town
                    $jobs_in_town = array();
                    foreach ($towns_id as $value) {
                        $arr_jobs = $this->mcity->getAllJobInTown($value);
                        foreach ($arr_jobs as $jobs) {
                            $jobs_in_town[$jobs['job_id']] = array('job_alp_name' => $jobs['job_alp_name'], 'job_name' => $jobs['job_name']);
                        }
                    }

                    $this->viewdata['getCityGroup'] = $groupCity_info;
                    $this->viewdata['towns'] = $towns;
                    $this->viewdata['towns_alph_name'] = $towns_alph_name;
                    $this->viewdata['all_towns'] = $this->mcity->getTownUserCount($city,$owner_status);
                    $this->viewdata['towns_id'] = $towns_id;
                    $this->viewdata['jobs_in_town'] = $jobs_in_town;

                    /* Next feature contents page url */
                    $feature_ar = array('shibuya',
                                        'yoshiwara',
                                       );
                    foreach ($feature_ar as $value) {
                        if ($town_alphaname == $value) {
                            $this->viewdata['feature_url'] = base_url()."user/jobs/$group_city/$city_alphaname/$town_alphaname/?subpage=feature";
                            break;
                        }
                    }
                    $this->viewdata['load_page'] = "pc/search/do_search";
                    $this->viewdata['load_page_area'] = "pc/search/search_result";

                }
            /* CityGroup */
            } else {
                $getCityGroup = $this->mcity->getCityGroupIds();//CityGroup取得
                $this->viewdata['getCityGroup'] = $getCityGroup;

                $area_ar = array();
                $temp_towns = '';
                $temp_town_alph = '';
                $city_cont = 0;
                foreach ($getCity as $key => $value) {
                    $area_ar[$key] = $value;
//                    $arr_town = $this->mcity->getTownIds($value['id']);
                    $arr_town = $this->mcity->getTownOwnerCount($value['id']);
                    ksort($arr_town);
                    $area_ar[$key]['towns'] = $arr_town;
//                    $area_ar[$ar_index]['count_all_owners'] = $city_cont;
                    $area_ar[$key]['count_all_owners'] = count($arr_town);

                }

                $this->load->model("user/Mbuffer");

                $this->viewdata['city_towns'] = $area_ar;
                $this->viewdata['column_data'] = $this->Mbuffer->get_column_buffer();/* バッファからコラム取得 */
                //$this->viewdata['column_data'] = $this->common->get_latest_column_posts(); // get latest posts from wordpress
                $this->viewdata['load_page'] = "pc/search/do_search";
                $this->viewdata['load_page_area'] = "pc/search/search_city2";
            }
        }

        //description
        //パンくず、タイトル
        $cates_str = "";
        $treaments_str = "";
        $preTitle = "";
        $breadText = "";

        switch ($this->uri->total_segments()) {
            case 3:
                $preTitle = $groupCity_info['name'].'のおすすめ風俗求人';
                break;
            case 4:
                $preTitle = $city_info['name'].'のおすすめ風俗求人';
                break;
            default:
                $preTitle = ($countTown > 1) ? $city_info['name'].'の複数地域の求人': $town_info['name'].'のおすすめ風俗求人';
                $breadText = ($countTown > 1) ? '検索結果': $town_info['name'];
                break;
        }

        if ($cate_flag) {
            $cates_str = str_replace(",", "", $arrCate_info['name']); // remove comma (,)
        }
        if ($treament_flag) {
            $treaments_str = str_replace(",", "", $arrTreatment_info['name']); // remove comma (,)
        }

        switch ($this->uri->total_segments()) {
            case 3:
                $groupCity_str = '';
                foreach ($get_city_ar as $key => $val) {
                    $groupCity_str .= ($key > 0)? '・'.$val['name'] : $val['name'];
                }
                $description = 
"/--GROUPCITY--/の風俗求人・高収入アルバイト情報をご紹介。/--CITYS--/のデリヘル・ヘルス・ピンサロ・ソープ・チャットなどの風俗求人アルバイト情報を未経験の人でも安心してお仕事検索ができます！《最大1万5千円の面接交通費をジョイスペが保証！》";
                $description = str_replace("/--GROUPCITY--/", $groupCity_info['name'], $description);
                $description = str_replace("/--CITYS--/", $groupCity_str, $description);
//                $this->viewdata['area_hi'] = $groupCity_str.'<br>'.$groupCity_info['name'].'の風俗求人の高収入アルバイト情報はコチラ';
                $this->viewdata['area_hi'] = $groupCity_info['name'].'エリアの高収入風俗求人情報満載';
                break;
            case 4:
                $description = 
"/--CITY--/の風俗求人・高収入アルバイト情報をご紹介。/--CITY--/のデリヘル・ヘルス・ピンサロ・ソープ・チャットなどの風俗求人アルバイト情報を未経験の人でも安心してお仕事検索ができます！《最大1万5千円の面接交通費をジョイスペが保証！》";
                $description = str_replace("/--CITY--/", $city_info['name'], $description);
                //$this->viewdata['area_hi'] = $city_info['name'].'で高収入アルバイトをお探しの方はコチラ';
                $this->viewdata['area_hi'] = $city_info['name'].'の風俗求人おすすめ一覧';
                break;
            default:
                $area_str = ($countTown > 1) ? $town_info['name']: '【'.$town_info['name'].'】';
                $area_h1_str = ($countTown > 1) ? $town_info['name']: '【'.$town_info['name'].'】';
                $description = 
$area_str."のオススメ風俗求人・高収入のアルバイト情報。口コミや評判で有名な".$area_str."のデリヘル・ホテヘル・ピンサロ・ソープ・チャットなどの求人情報を厳選！1日～短期、日払い、日給35000円+α、体験入店、未経験歓迎、在宅など希望条件もカンタン検索！《最大1万5千円の面接交通費支給をジョイスペが保証》";


                $rep_join1 = '';
                if($countTown > 1){
                    $rep_area = $city_info['name'];
                    if (($countCategory == 1) && ($countTreatment == 0)) {
                        $rep_join1 = 'での';
                    }elseif (($countCategory == 1) && ($countTreatment == 0)) {
                        $rep_join1 = 'での';
                    }elseif (($countCategory == 0) && ($countTreatment == 1)) {
                        $rep_join1 = 'での';
                    }elseif (($countCategory == 1) && ($countTreatment == 1)) {
                        $rep_join1 = 'での';
                    }else {
                        $rep_join1 = 'の';
                    }
                } else {
                    $rep_area = $town_info['name'];
                    $rep_join1 = 'の';
                }

                /* 業種 */
                if ($countCategory == 0) {
                    $rep_job = '';
                } elseif ($countCategory ==1) {
                    $rep_job = $cates_str;
                } else {
                    $rep_job = '複数業種';
                }

                /* /--JOIN2--/ */
                if($countTown > 1){
                    if (($countCategory == 0) && ($countTreatment == 0)) {
                        $rep_join2 = '';
                    }elseif (($countCategory == 1) && ($countTreatment == 0)) {
                        $rep_join2 = '';
                    }elseif (($countCategory == 0) && ($countTreatment == 1)) {
                        $rep_join2 = '';
                    }elseif (($countCategory > 1) && ($countTreatment == 0)) {
                        $rep_join2 = '';
                    }elseif (($countCategory == 0) && ($countTreatment > 1)) {
                        $rep_join2 = '';
                    }else {
                        $rep_join2 = '・';
                    }
                } else {
                    if (($countCategory == 0) && ($countTreatment == 0)) {
                        $rep_join2 = '';
                    } elseif (($countCategory == 1) && ($countTreatment == 0)) {
                        $rep_join2 = '';
                    } elseif (($countCategory == 0) && ($countTreatment == 1)) {
                        $rep_join2 = '';
                    } elseif (($countCategory == 1) && ($countTreatment == 1)) {
                        $rep_join2 = 'で';
                    } elseif (($countCategory > 1) && ($countTreatment == 0)) {
                        $rep_join2 = '';
                    } elseif (($countCategory == 0) && ($countTreatment > 1)) {
                        $rep_join2 = '';
                    } elseif (($countCategory > 1) && ($countTreatment == 1)) {
                        $rep_join2 = 'で';
                    } elseif (($countCategory > 1) && ($countTreatment > 1)) {
                        $rep_join2 = '・';
                    } elseif (($countCategory = 1) && ($countTreatment > 1)) {
                        $rep_join2 = 'で';
                    } else {
                        $rep_join2 = 'の';
                    }
                }

                /* 待遇 */
                if ($countTreatment == 0) {
                    $rep_treatment = '';
                } elseif ($countTreatment == 1) {
                    $rep_treatment = $treaments_str;
                } else {
                    if ($countCategory > 1) {
                        $rep_treatment = '待遇';
                    } else{
                        $rep_treatment = '複数待遇';
                    }
                }

                /* /--JOIN3--/ */
                if($countTown > 1){
                    if (($countCategory == 0) && ($countTreatment == 0)) {
                        $rep_join3 = '';
                    }elseif (($countCategory > 1) && ($countTreatment > 1)) {
                        $rep_join3 = 'での';
                    }elseif (($countCategory == 1) && ($countTreatment > 1)) {
                        $rep_join3 = 'での';
                    }else {
                        $rep_join3 = 'の';
                    }

                } else {
                    if (($countCategory == 0) && ($countTreatment == 0)) {
                        $rep_join3 = '';
                    } else {
                        $rep_join3 = 'の';
                    }
                }

                $h1_str = '/--AREA--//--JOIN1--//--JOB--//--JOIN2--//--TREAT--//--JOIN3--/';
                $h1_str = str_replace("/--AREA--/", $rep_area, $h1_str);
                $h1_str = str_replace("/--JOIN1--/", $rep_join1, $h1_str);
                $h1_str = str_replace("/--JOB--/", $rep_job, $h1_str);
                $h1_str = str_replace("/--JOIN2--/", $rep_join2, $h1_str);
                $h1_str = str_replace("/--TREAT--/", $rep_treatment, $h1_str);
                $h1_str = str_replace("/--JOIN3--/", $rep_join3, $h1_str);

                $this->viewdata['area_hi'] = $h1_str.'お仕事がここでみつかる'.(($count_all > 0)? ' 現在、'.$count_all.'件掲載中':'');


/*
                if (isset($_GET['treatment']) || isset($_GET['cate'])) {

                    if($countTown > 1){
                        $this->viewdata['area_hi'] = $city_info['name'].'の複数地域の求人はコチラから'.(($count_all > 0)? ' 現在、'.$count_all.'件掲載中':'');
                    } else {
                        $this->viewdata['area_hi'] = $town_info['name'].'の'.$cates_str .'のお仕事がここでみつかる'.(($count_all > 0)? ' 現在、'.$count_all.'件掲載中':'');
                    }

                } else {
                    if($countTown > 1){
                        $this->viewdata['area_hi'] = $city_info['name'].'の複数地域の求人はコチラから'.(($count_all > 0)? ' 現在、'.$count_all.'件掲載中':'');
                    } else {
                        $this->viewdata['area_hi'] = $town_info['name'].'でのお仕事がここでみつかる'.(($count_all > 0)? ' 現在、'.$count_all.'件掲載中':'');
                    }
                }
*/
                break;
        }

        if (isset($_GET['treatment']) || isset($_GET['cate'])) {
            $preTitle = $cates_str . $treaments_str;
            $description =
"/--TOWN--/の/--JOBTYPE--//--TREAMENTS--/のオススメ求人情報一覧。/--CITY--/の/--TOWN--/で風俗求人・高収入のバイト・アルバイト情報を探すならジョイスペで決まり！1日～OKの短期、日払い、日給35000円+α、体験入店、未経験歓迎、在宅など希望条件でカンタンにお仕事検索できます。《最大1万5千円の面接交通費支給》";
            $description = str_replace("/--CITY--/", $city_info['name'], $description);
            $description = str_replace("/--TOWN--/", $town_info['name'], $description);
            $description = str_replace("/--JOBTYPE--/", $cates_str, $description);
            $description = str_replace("/--TREAMENTS--/", $treaments_str, $description);
        }
        $this->viewdata['description'] = $description;


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

        $this->viewdata['titlePage'] = $preTitle . '｜高収入アルバイトのジョイスペ';
        $this->viewdata['breadText'] = $breadText;

/*
        $this->load->module('user/joyspe_user');
        $data = $this->joyspe_user->has_step_up_campaign($user_id);
        if ($data) {
            foreach ($data as $key => $value) {
                $this->viewdata["$key"] = $value;
            }
        }
*/
        $this->viewdata['idheader'] = NULL;
        $this->viewdata['keywords']  = '風俗,求人,高収入アルバイト';
        $this->viewdata['imagePath'] = base_url(). $this->config->item('upload_owner_url') . 'images/';
        $this->viewdata['banner_bonus_req'] = $this->mcampaign_bonus_request->getLatestCampaignBonusBanner();
        $this->viewdata['banner_data'] = $this->common->getLatestBanner();
        $this->load->view($this->layout, $this->viewdata);
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

        $owner_status = "2,5";
        $count_all = $this->Mstyleworking->countSearchStore($cityGroup, $city, $town, $treatment, $cate,$owner_status);
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
        $owner_status = "2,5";
        if ($not_in_cookie == false) {
            if ($this->agent->is_mobile()) {
                $offset = 0;
            }
            $searchStoreWithRankSetting = $this->Mstyleworking->getSearchStore($cityGroup, $city, $town, $treatment, $cate, $limit, $withRankSetting, $offset, $info_id,$is_mobile, 2);
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
                    $searchStore = $this->Mstyleworking->getSearchStore($cityGroup, $city, $town, $treatment, $cate, $storeLimit, $withRankSetting, $offset, $info_id,$is_mobile,$owner_status);
                }
            } else {
                $searchStore = $this->Mstyleworking->getSearchStore($cityGroup, $city, $town, $treatment, $cate, $limit, $withRankSetting, $offset, $info_id,$is_mobile,$owner_status);
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
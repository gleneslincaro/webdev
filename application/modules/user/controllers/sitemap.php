<?php

class sitemap extends MY_Controller {
    private $viewData = array();

    public function __construct() {
        parent::__construct();
        $this->common = new Common();
    }

    public function index() {
        header("Content-Type: text/xml;charset=UTF8");
        $this->load->view("user/sitemap/sitemap", $this->viewData);
    }


    public function sitemap_index() {
        header("Content-Type: text/xml;charset=UTF8");
        $this->load->view("user/sitemap/sitemap_index", $this->viewData);
    }


    public function sitemap_01() {
        $this->load->model("user/mcampaign_bonus_request");
        $this->viewData['banner_bonus_req'] = $this->mcampaign_bonus_request->getLatestCampaignBonusBanner();
        $this->viewData['banner_data'] = $this->common->getLatestBanner();
        header("Content-Type: text/xml;charset=UTF8");
        $this->load->view("user/sitemap/sitemap_01", $this->viewData);
    }

    public function sitemap_jobtype_treatment() {
        header("Content-Type: text/xml;charset=UTF8");
        $this->load->view("user/sitemap/sitemap_jobtype_treatment", $this->viewData);
    }

    public function sitemap_area() {
        $cityGroup = $this->mcity->getCityGroup();
        $this->viewData['cityGroup_ar'] = $cityGroup;

        $this->load->model("user/Mstyleworking");

$job_ar =     $this->Mstyleworking->getAllJobType();
$treatment_ar =     $this->Mstyleworking->getAllTreatment();
        $i = 0;
        $ii = 0;
        $ar = array();
        $ar2 = array();
        $ar3 = array();
        $ar4 = array();
        $ar5 = array();
        $ar6 = array();
        foreach ($cityGroup as $key => $val) {
            $citys = $this->mcity->getCity($val['id']);
            foreach ($citys as $key2 => $val2) {
                $ar[$i]['alph_name'] = $val['alph_name'].'/'.$val2['alph_name'];
                foreach ($job_ar as $key6 => $val6) {
                    $ar5[$i]['alph_name'] = 'jobtype_'.$val6['alph_name'].'/'.$val['alph_name'].'/'.$val2['alph_name'].'/';
                }
                foreach ($treatment_ar as $key7 => $val7) {
                    $ar6[$i]['alph_name'] = 'treatment_'.$val7['alph_name'].'/'.$val['alph_name'].'/'.$val2['alph_name'].'/';
                }
                $i++;

                $towns = $this->mcity->getTown($val2['id']);
                foreach ($towns as $key3 => $val3) {
                    $ar2[$ii]['alph_name'] = $val['alph_name'].'/'.$val2['alph_name'].'/'.$val3['alph_name'];
                    foreach ($job_ar as $key4 => $val4) {
                        $ar3[$ii]['alph_name'] = $val['alph_name'].'/'.$val2['alph_name'].'/'.$val3['alph_name'].'/?cate='.$val4['alph_name'];
                    }
                    foreach ($treatment_ar as $key5 => $val5) {
                        $ar4[$ii]['alph_name'] = $val['alph_name'].'/'.$val2['alph_name'].'/'.$val3['alph_name'].'/?treatment='.$val5['alph_name'];
                    }
                    $ii++;
                }

            }
        }
        $this->viewData['city_ar'] = $ar;
        $this->viewData['town_ar'] = $ar2;
        $this->viewData['town_cate_ar'] = $ar3;
        $this->viewData['town_treatment_ar'] = $ar4;
        $this->viewData['city_cate_ar'] = $ar5;
        $this->viewData['city_treatment_ar'] = $ar6;

        header("Content-Type: text/xml;charset=UTF8");
        $this->load->view("user/sitemap/sitemap_area", $this->viewData);
    }

    public function sitemap_shop() {
        $this->load->Model("owner/Mqa");

        $owners = $this->Mowner->get_all_owners();
        $ar = array();
        $qa_ar = array();
        foreach ($owners as $key => $val) {
            $ar[$key]['url'] = base_url() . 'user/joyspe_user/company/' . $val['owner_recruit_id'];
            if ($this->Mqa->check_faqlist_by_owner($val['owner_id'], 0)){
                $qa_ar[$key]['url'] = base_url() . 'user/joyspe_user/company/' . $val['owner_recruit_id']. '/0';
            }
        }
        $this->viewData['shop_ar'] = $ar;
        $this->viewData['shop_qa_ar'] = $qa_ar;
        header("Content-Type: text/xml;charset=UTF8");
        $this->load->view("user/sitemap/sitemap_shop", $this->viewData);
    }

}

?>

<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Siterank extends MX_Controller {

    private $data;

    public function __construct() {
        parent::__construct();
        $this->load->Model(array('owner/mowner','owner/muser','user/mcampaign_bonus_request'));
        $this->common = new Common();
        $this->data['module'] = $this->router->fetch_module();
        $this->form_validation->CI = & $this;
        HelperApp::start_session();
    }

    /**
     * @author  [IVS] Nguyen Bao Trieu
     * @name 	index
     * @todo 	show index for owner
     * @param 	null
     * @return 	null
    */
    public function index() {        
        if ( !OwnerControl::LoggedIn() ){
            //ランディングページへ遷移
            $url = base_url() .'owner/top';
            redirect($url);
        }       
        $owner = OwnerControl::getOwner();
        HelperApp::add_session('free_owner', $owner['free_owner_flag']);
        if ($owner['free_owner_flag'] == 1) {
            $url = base_url() .'owner/top';
            redirect($url);
        }

        $owner_id = OwnerControl::getId(); 
        $this->data['data'] = $data = $this->Mowner->getOwnerRankSetting($owner_id);         
        if ($this->input->post()) {
            $rank_setting[] = '';
            $rank_setting[] = $this->input->post('time1');
            $rank_setting[] = $this->input->post('time2');
            $rank_setting[] = $this->input->post('time3');
            $rank_setting[] = $this->input->post('time4');
            $rank_setting[] = $this->input->post('time5');             
            $this->data['rank_setting'] = $rank_setting;
            if ($rank_setting[1] == '' && $rank_setting[2] == '' && $rank_setting[3] == '' && $rank_setting[4] == '' && $rank_setting[5] == '') {
                $this->data['error_message'] = '最低1つのサイト上位設定をご記入ください。';
            } else {
                if ($data) {
                    $update_data = array(
                        'time_1' => ($rank_setting[1] != '')?$rank_setting[1]:NULL,
                        'time_2' => ($rank_setting[2] != '')?$rank_setting[2]:NULL,
                        'time_3' => ($rank_setting[3] != '')?$rank_setting[3]:NULL,
                        'time_4' => ($rank_setting[4] != '')?$rank_setting[4]:NULL,
                        'time_5' => ($rank_setting[5] != '')?$rank_setting[5]:NULL,
                        'remaining_update' => ($data['remaining_update'] > 0)?intval($data['remaining_update'])-1:0,
                        'updated_date' => date('Y-m-d H:i:s')
                    );
                    $this->Mowner->updateSiteRankSettings($update_data, $data['id']);
                }
                else {
                    $insert_data = array(
                        'owner_id' => $owner_id,
                        'time_1' => ($rank_setting[1] != '')?$rank_setting[1]:NULL,
                        'time_2' => ($rank_setting[2] != '')?$rank_setting[2]:NULL,
                        'time_3' => ($rank_setting[3] != '')?$rank_setting[3]:NULL,
                        'time_4' => ($rank_setting[4] != '')?$rank_setting[4]:NULL,
                        'time_5' => ($rank_setting[5] != '')?$rank_setting[5]:NULL,
                        'remaining_update' => 4,
                        'created_date' => date('Y-m-d H:i:s')
                    );                    
                    $this->Mowner->insertSiteRankSettings($insert_data);
                }
              $this->data['success_message'] = 'サイト上位が更新されました。';  
            }
        }                             
        $this->data['title'] = 'joyspe｜サイト上位表示';
        $this->data['loadPage'] = 'siterankdisplay/index';
        $this->load->view($this->data['module'].'/layout/layout_A', $this->data);
    }
}

?>

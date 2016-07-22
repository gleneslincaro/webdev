<?php

/*
 * Openページ
 */

class Open extends MX_Controller {
    private $data;

    public function __construct() {
        parent::__construct();
        $this->load->Model(array('owner/mowner','owner/mtemplate','owner/mcommon'));
        $this->data['module'] = $this->router->fetch_module();
    }
    /**
     * author: VJソリューションズ
     * name : index
     * todo : オープンページ表示
     * @param null
     * @return null
     */
    function index() {
        $owner_id = OwnerControl::getId();
        $Mowner = new Mowner();
        if ($owner_id != NULL) {
            $owner = $Mowner->getOwner(HelperApp::get_session('ownerId'));
            //現在日付取得
            $date_array = getdate();
            //オープン日付取得
            $open_date_stamp = strtotime(OPEN_DATE);
            $open_date_day = date('d', $open_date_stamp);
            $open_date_mon = date('m', $open_date_stamp);
            $open_date_year = date('Y', $open_date_stamp);
            $is_open_flg =  ( ($date_array['mday'] == $open_date_day) &&
                            ($date_array['mon'] == $open_date_mon) &&
                            ($date_array['year'] == $open_date_year) )
                            ?
                            TRUE : FALSE;
            //管理者のオンナーか、OPEN_FLAGかオープンデートになった場合、通常ページ表示
            if (($owner && $owner['admin_owner_flag'] == 1) || OPEN_FLAG  == 1 || $is_open_flg == TRUE){
                redirect(base_url() . "owner/");
            }else{
                $this->data['loadPage'] = 'openpage/open_page';
                $this->data['title'] = 'joyspe｜オープンのお知らせ';
                $this->load->view($this->data['module'] . '/layout/layout_B', $this->data);
            }
        }else{
            redirect(base_url() . "owner/login");
        }
    }
}


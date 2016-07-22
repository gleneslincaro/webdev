<?php
class News extends MY_Controller{
    private $viewdata= array();
    private $layout="user/layout/main";
    function __construct() {
        parent::__construct();
		$this->redirect_pc_site();
        $this->load->model("user/Mnews");
        $this->viewdata['idheader'] = NULL;
        $this->viewdata['class_ext'] = 'info_list';
        $this->viewdata['total_users'] = HelperGlobal::getUserTotalNumber();
        $this->viewdata['total_owners'] = HelperGlobal::gettotalHeader();
    }
    /*
    *@author: IVS Nguyen Ngoc Phuong
    * load news  
    */
    public function index()
    {
        $limit = 5;
        $offset = 0;
        $page = $this->input->get('page');
        if ($page) {
            $offset = intval($page);
        }
        $news = $this->Mnews->getNews($limit, $offset);
        $count= count($news);
        $all_news=$this->Mnews->getAllNews();
        $count_all=  count($all_news);
        $this->viewdata['noCompanyInfo']= true;
        $this->viewdata['count']=$count;
        $this->viewdata['count_all']=$count_all;
        $this->viewdata['listnews'] = $news;
        $this->viewdata['limit'] = $limit;

        $this->load->library('user_agent');
        $device = $this->input->get('device');
        /* sp */
        if ($this->agent->is_mobile() OR $device == 'sp') {
            $this->viewdata['titlePage']= 'joyspe｜TOPページ';
            $this->viewdata['load_page'] = "news/hotnews";
        /* pc */
        } else {
            $this->load->library('pagination');
            /* ページネーション設定 */
            $config['page_query_string'] = TRUE;
            $config['base_url'] = base_url()."user/info_list/?";
            $config['total_rows'] = $count_all;
            $config['per_page'] = $limit;
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
            $this->viewdata['page_links'] = $this->pagination->create_links();

            $this->viewdata['breadscrumb_array'] = array(
                array("class" => "", "text" => "お知らせ一覧", "link"=>""),
            );
            $this->layout="user/pc/layout/main";
            $this->viewdata['titlePage']= 'joyspe｜お知らせ一覧';
            $this->viewdata['load_page'] = "pc/news/hotnews";
        }
        $this->load->view($this->layout, $this->viewdata);
    }
    /*
    * @author: IVS_Nguyen_Ngoc_Phuong
    * show more News
    */
    public function ajax_GetNews()
    {
        $offset = $this->input->post("offset");
        $limit = 10;
        $news = $this->Mnews->getNews($limit, $offset);
        $count= count($news);
        $all_news=$this->Mnews->getAllNews();
        $count_all=  count($all_news);
        $this->viewdata['count']=$count;
        $this->viewdata['count_all']=$count_all;
        $this->viewdata['listnews'] = $news;
        $this->viewdata['limit'] = $limit;
        $this->load->view("news/list_hot_news", $this->viewdata);
    }

    public function news_details($id = null)
    {
        $this->viewdata['noCompanyInfo'] = true;
        $this->viewdata['specific_news'] = $this->Mnews->getSpecificNews($id);

        $this->load->library('user_agent');
        $device = $this->input->get('device');
        /* sp */
        if ($this->agent->is_mobile() OR $device == 'sp') {
            $this->viewdata['titlePage']= 'joyspe｜TOPページ';
            $this->viewdata['load_page'] = "news/specific_news";
        /* pc */
        } else {
            $this->layout="user/pc/layout/main";
            $this->viewdata['titlePage']= 'joyspe｜お知らせ';
            $this->viewdata['load_page'] = "pc/news/specific_news";
            $this->viewdata['breadscrumb_array'] = array(
                array("class" => "", "text" => "お知らせ", "link"=>""),
            );
        }
        $this->load->view($this->layout, $this->viewdata);
    }
}
?>

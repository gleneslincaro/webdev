<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class MY_Exceptions extends CI_Exceptions {
  public function show_404(){
    $CI =& get_instance();
    $CI->output->set_status_header('404');
    $data['idheader'] = NULL;
    $data['titlePage']= 'ページが見つかりませんでした｜風俗求人・高収入アルバイトのジョイスペ';
    $data['load_page'] = 'user/view_my404';

    $CI->load->library('user_agent');
    if($CI->agent->is_mobile()) {
        $data['load_page'] = 'user/view_my404';
        $CI->load->view("user/layout/main", $data);
    } else {
        $data['load_page'] = 'user/pc/404_page';
        $data['from_404'] = 1;
        $breadscrumb_array = array(array("class" => "", "text" => "お探しのページは見つかりません。", "link"=>""));
        $data['breadscrumb_array'] = $breadscrumb_array;
        $CI->load->view("user/pc/layout/main", $data);
    }
//    $CI->load->view("user/layout/main", $data);
    echo $CI->output->get_output();
    exit;
  }
}

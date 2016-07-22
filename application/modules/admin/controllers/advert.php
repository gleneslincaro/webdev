<?php
//管理画面での店舗集計
class  advert extends MX_Controller
{   
    protected $_data;
    public function __construct() {
        parent::__construct();
		$this->_data["module"] = $this->router->fetch_module();
//        $this->load->model("owner/Manalysis");
      // モデルロード
      $this->load->Model("admin/mbbs");
      $this->load->Model("admin/madvert");

    }

    public function index() {
    }

    public function advert_setting() {

        $this->load->helper('file');


        $path = $this->config->item('upload_dir') . 'images/';

        $this->folderName = 'advert';



        $filenames = get_filenames($path.$this->folderName);
//        print_r($filenames);

    $is_top_ar = $this->mbbs->get_is_top();
    $this->_data["is_top_info"]  = $is_top_ar;


    $big_category_ar = $this->mbbs->get_big_category();
//    var_dump($big_category_ar);

        $advert_image_ar = array();
        $i = 1;
        foreach ($filenames as $key => $val) {
            $filenames[$key] = '/'.$path.$this->folderName.'/'.$val;
            $advert_image_ar[$i]['index'] = $i;
            $advert_image_ar[$i]['image_path'] = '/'.$path.$this->folderName.'/'.$val;
            $i++;
        }
        $this->_data["advert_image_ar"]  = $advert_image_ar;

//var_dump($filenames);

		$this->_data["big_category_ar"]  = $big_category_ar;

		$this->_data["loadPage"]  = "advert/advert";
		$this->_data["titlePage"] = "広告設定";
		$this->load->view($this->_data["module"]."/layout/layout", $this->_data);
    }



    public function advert_setting_test() {

        $data = array();

//               $data['ad_url'] = $post['ad_url'];

               $data['ad_url'] = 'えええええええ';
               $id = 1;
                $this->madvert->set_big_category_data($id, $data);


    }


    public function advert_setting_ajax() {
        $post = $this->input->post();

        $q = $post['q'];
        $id = $post['id'];

        $data = array();

        $array = array('flag'=> true);
//               $data['ad_url'] = $post['ad_url'];
        switch ($q) {
            case 'ad_flag':
                $data['ad_flag'] = $post['ad_flag'];
                $this->madvert->set_big_category_data($id, $data);
                break;

            case 'ad_interval':
                $data['ad_interval'] = $post['ad_interval'];
                $this->madvert->set_big_category_data($id, $data);
                break;

            case 'ad_url':
                $data['ad_url'] = $post['ad_url'];
                $this->madvert->set_big_category_data($id, $data);
                break;

            case 'ad_type':
                $data['ad_type'] = $post['ad_type'];
                $this->madvert->set_big_category_data($id, $data);
                break;

            case 'ad_text':
                $data['ad_text'] = $post['ad_text'];
                $this->madvert->set_big_category_data($id, $data);
                break;

            case 'ad_image':
                $data['ad_image'] = $post['ad_image'];
                $this->madvert->set_big_category_data($id, $data);
                $array = array('id'=>$id,'ad_image'=> $post['ad_image']);
                break;
            default:
                break;
        }

 //$dataをJSONにして返す
        $this->output
             ->set_content_type('application/json')
             ->set_output(json_encode($array));

    }

    public function advert_upload_ajax() {
        $path = $this->config->item('upload_dir') . 'images/advert/';
        if (!is_dir($path)) {
          mkdir($path, 0777, true);
        }

        // 一時アップロード先ファイルパス
        $file_tmp  = $_FILES["file_1"]["tmp_name"];

        // 正式保存先ファイルパス
        $file_save = $path . $_FILES["file_1"]["name"];

        // ファイル移動
        $result = @move_uploaded_file($file_tmp, $file_save);
        if ($result === true ) {
            echo "アップロードされました。";
        } else {
            echo "UPLOAD NG";
        }
    }

    public function fileUploadAjaxPic() {

        $path = $this->config->item('upload_userdir') . 'tmp/';
        if (!is_dir($path)) {
          mkdir($path, 0777, true);
        }

        $this->folderName = 'advert';

        if (!is_dir($path . $this->folderName)) {
            mkdir($path . $this->folderName);
        }

        $config['upload_path'] = $path . $this->folderName;
        $config['allowed_types'] = 'gif|jpeg|jpg|png';
        $config['max_size'] = 4096;
        $config['overwrite'] = true;
        $this->load->library('upload', $config);


		$nRet   = $this->upload->do_upload("userfile");
        $aryRet = $this->upload->data();
        if ($nRet) {
            // 正常
           /* $strOldFname = $aryRet['full_path'];
            $strNewGazou = md5(uniqid(rand(), TRUE)) . $aryRet['file_ext'];
            $strNewFname = $aryRet['file_path'] . $strNewGazou;
            @rename($strOldFname, $strNewFname);
            @chmod($strNewFname, 0666);
            $outHtml =  "<img src='" . $aryConfig['upload_path']  . $strNewGazou . "'  width='400' />";*/
            $outHtml = "アップロードされました。";
        }
        else {
            // NG
            $outHtml = "正しい画像を選択してください。";
        }

        $array = array('flag'=> $outHtml);
//        $array = array('url' => $url, 'fileName' => $fileName);
        echo json_encode($array);
    }

}
 
?>

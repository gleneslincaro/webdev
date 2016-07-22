<?php
class certificate extends MY_Controller{
    private $viewData = array();
    private $validator;
    private $layout = 'user/layout/main';
    private $message = array('success' => true, 'error' => array());    
    public function __construct() {
        parent::__construct();
		$this->redirect_pc_site();
        HelperGlobal::require_login(current_url());
        $this->validator = new FormValidator();  
        $this->common = new Common();
        $this->viewData['module'] = $this->router->fetch_module();
        $this->form_validation->CI = & $this;
        $this->viewData['idheader'] = 4;
        $this->viewData['divsuccess'] = '';
        $this->viewData['linkid']= '';   
    }
    public function index() {  
    }
     /**
     * @author [IVS] My Phuong Thi Le
     * @name   certificate_after
     * @todo   view after certificate success
     * @param  
     * @return void
     */
    public function certificate_after($id=0) {
        if ($_POST) 
            $this->do_certificate();
        $this->viewData['linkid']= $id;       
        $this->viewData['load_page'] = 'user/certificate_after';
        $this->viewData['titlePage'] = 'joyspe｜新規会員登録';
        $this->viewData['message'] = $this->message;
        $this->load->view($this->layout, $this->viewData);    
    }
    public function certificate_after_compltete() {
        $div = '身分証明書のアップロードが完了しました。<br >確認メールをお待ち下さいませ。<br >年齢確認は10分程度お時間頂きます。<br ><br ><a href="http://www.joyspe.com/user/joyspe_user/index/">　>>　TOPページへ　<<　</a>';
        $this->viewData['divsuccess'] = $div;
        $this->viewData['load_page'] = 'user/certificate_after';
        $this->viewData['titlePage'] = 'joyspe｜新規会員登録';
        $this->load->view($this->layout, $this->viewData);
    }
     /**
     * @author [IVS] My Phuong Thi Le
     * @name   do_certificate
     * @todo   update image for user
     * @param  
     * @return void
     */
    public function do_certificate() {
       // get id of user
       $id = UserControl::getId();
       $file=$_FILES['img']['name'];
       // set values
       $this->form_validation->set_rules('img', 'image', 'callback_checkimgnull');
       $form_validation = $this->form_validation->run();
        $this->message['success'] = !$form_validation ? FALSE : TRUE;
        if (!$form_validation){                  
            return false;
        }        
        else {      
            $path = $this->config->item('upload_userdir') . '/images/';
            $this->folderName = $id;
            if (!is_dir($path.$this->folderName )) {
               mkdir($path.$this->folderName);
            }
            $config['upload_path'] = $path . $this->folderName;
            $config['allowed_types'] = 'jpeg|jpg|png';
            $config['max_size'] = 4096;
            $config['overwrite'] = true;
           // echo filesize($_FILES['img']['tmp_name']);die;
            $this->load->library('upload', $config);
            if (!$this->upload->do_upload("img")) {
                 $this->form_validation->set_rules('img', 'image', 'callback_check_jpg_jpeg_png');
                 $this->form_validation->set_rules('img', 'image', 'callback_checkimg2MB');
                 $form_validation = $this->form_validation->run();
                 $this->message['success'] = !$form_validation ? FALSE : TRUE;
                if (!$form_validation){                  
                    return false;    
                } 
             }else {
                    $config['image_library'] = 'gd2';
                    $config['source_image'] = $path . $this->folderName . '/' . $_FILES['img']['name'];
                    $config['maintain_ratio'] = FALSE;
                    $config['width'] = 400;
                    $config['height'] = 300;
                    $this->load->library('image_lib', $config);
                    $this->image_lib->resize();
                    $data = array(
                        'image1' => $this->folderName . '/' .$_FILES['img']["name"],
                     );
                    $this->Musers->update_User($data, $id);
                    $this->common->sendMail( '', '', '', array('ss02'),'' , 'joyspe',$id);
                // update success;
                     redirect(base_url() . "user/certificate/certificate_after_compltete");
                }
            }
    }
     /**
     * author: [IVS] My Phuong Thi Le
     * name : checkimgnull
     * todo : check image null
     * @return boolean
     */
    public function checkimgnull() {
       $file=$_FILES['img']['name'];
       if($file==null||$file='')
           return false;
        return true;
    }
     /**
     * author: [IVS] My Phuong Thi Le
     * name : checkimg2M
     * todo : check image >2MB
     * @return boolean
     */
    public function checkimg2MB() {
        $size=filesize($_FILES['img']['tmp_name']);
        if ($size > 2097152)
           return false;
        return true;
    }
     /**
     * author: [IVS] My Phuong Thi Le
     * name : check_jpg_jpeg_png
     * todo : check image jpg_jpeg_png
     * @return boolean
     */
    public function check_jpg_jpeg_png() {
       if($_FILES['img']['type'] != "image/jpeg" && $_FILES['img']['type'] != "image/jpg" && $_FILES['img']['type'] != "image/png" )
           return false;
        return true;
    }
}

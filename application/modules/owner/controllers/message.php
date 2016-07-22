<?php

class Message extends MX_Controller {

    private $viewData;
    private $common;
    public $owner_id = 0;
    private $status = 0;
    private $message = array('success' => true, 'error' => array());

    public function __construct() {
        parent::__construct();
        $this->load->model('owner/Mmessage');
        $this->load->model('owner/Mcompany');
        $this->load->model('owner/Mowner');
        $this->common = new Common();
        $this->output->set_header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate");
        $this->output->set_header("Cache-Control: post-check=0, pre-check=0");
        $this->output->set_header("Pragma: no-cache");
        if (!OwnerControl::LoggedIn()) {
            redirect(base_url() . "owner/login/");
        }
        // Kiem tra recruit_status
        $this->status = $this->Mcompany->getLastOwnerRecruitStatus(OwnerControl::getId());
    }

    /**
     * @author  [IVS] Nguyen Van Phong
     * @name 	
     * @todo 	show owner_recruit has error
     * @param 	
     * @return 	
     */
    public function message_approval() {
        redirect(base_url()."owner/history/history_app_message_temp");
        /*
        $title = 'joyspe｜メッセージ - 承認中一覧';
        $owner_id = OwnerControl::getId();
        $owner_data = HelperGlobal::owner_info($owner_id);
        $recruitErr = $this->Mowner->getOwnerRecruitErr($owner_id);
        $ownerprofile_data = $this->Mmessage->getOwnerDetail($owner_id);
        $this->viewData['ownerprofile_data'] = $ownerprofile_data;
        $this->viewData['recruitErr'] = $recruitErr;
        $this->viewData['owner_data'] = $owner_data;
        $this->viewData['title'] = $title;
        $this->viewData['loadPage'] = 'owner/message/message_approval';
        $this->load->view("owner/layout/layout_A", $this->viewData);
        */
    }

    /**
     * @author  [IVS] Nguyen Van Phong
     * @name 	message_approval_profile
     * @todo 	get owner profile/recruit information
     * @param 	
     * @return 	
     */
    public function message_approval_profile() {
        //Cheeck owner status
        $title = 'joyspe｜メッセージ - 承認中一覧 - プロフィール';
        $this->checkOwnerRecruitStatus();
        $owner_id = OwnerControl::getId();
        $owner_data = HelperGlobal::owner_info($owner_id);
        $this->viewData['owner_data'] = $owner_data;
        $ownerrecruit_data = $this->Mmessage->getOwnerRecruitDetail($owner_id);
        $owner_recruit = $this->Mowner->getOwnerRecruit($owner_id);
        $this->viewData['data'] = $ownerrecruit_data;
        $this->viewData['recruit_status'] = $owner_recruit['recruit_status'];
        $this->viewData['title'] = $title;
        $this->viewData['imagePath'] = base_url() . "/public/owner/";
        $this->viewData['loadPage'] = 'owner/message/message_approval_profile';
        $this->load->view("owner/layout/layout_B", $this->viewData);
    }

    /**
     * @author  [IVS] Nguyen Van Phong
     * @name 	message_approval_profileedit
     * @todo 	edit owner profile/recruit information
     * @param 	
     * @return 	
     */
    public function message_approval_profileedit() {
        //Check owner status
        $this->checkOwnerRecruitStatus();
        $owner_id = OwnerControl::getId();
        $count_profiles = $this->Mowner->countOwnerRecruit($owner_id);
        $owner_main = $this->Mowner->getOwnerRecruit($owner_id);        
        $owner_data = HelperGlobal::owner_info($owner_id);
        $owner_recruit = $this->Mmessage->getOwnerRecruitDetail($owner_id);
       
        $this->viewData['hdflag'] = 0;
        $this->viewData['hdError'] = 0;
        $this->viewData['hdmain_image'] = $owner_main['main_image'];
        $this->viewData['image1'] = empty($owner_recruit['image1'])? base_url().'public/owner/images/no_image.jpg': base_url().'public/owner/uploads/images/'.$owner_recruit['image1'];
        $this->viewData['image2'] = empty($owner_recruit['image2'])? base_url().'public/owner/images/no_image.jpg': base_url().'public/owner/uploads/images/'.$owner_recruit['image2'];
        $this->viewData['image3'] = empty($owner_recruit['image3'])? base_url().'public/owner/images/no_image.jpg': base_url().'public/owner/uploads/images/'.$owner_recruit['image3'];
        $this->viewData['image4'] = empty($owner_recruit['image4'])? base_url().'public/owner/images/no_image.jpg': base_url().'public/owner/uploads/images/'.$owner_recruit['image4'];
        $this->viewData['image5'] = empty($owner_recruit['image5'])? base_url().'public/owner/images/no_image.jpg': base_url().'public/owner/uploads/images/'.$owner_recruit['image5'];
        $this->viewData['image6'] = empty($owner_recruit['image6'])? base_url().'public/owner/images/no_image.jpg': base_url().'public/owner/uploads/images/'.$owner_recruit['image6'];
        if ($_POST) {
            $this->viewData['image1'] = $_POST['hdImage1'];
            $this->viewData['image2'] = $_POST['hdImage2'];
            $this->viewData['image3'] = $_POST['hdImage3'];
            $this->viewData['image4'] = $_POST['hdImage4'];
            $this->viewData['image5'] = $_POST['hdImage5'];
            $this->viewData['image6'] = $_POST['hdImage6'];
            $this->viewData['hdmain_image'] = $_POST['sltImageDefault'];
            if ($this->checkValidateInput()) {
                $this->viewData['hdflag'] = 1; // Check show 登録しますか？
                $this->viewData['hdError'] = 0; // check validate
            }
        }        
      
        $this->viewData['message'] = $this->message;
        $this->viewData['imagePath'] = base_url() . "/public/owner/";
        $this->viewData['data'] = $owner_recruit;
        $this->viewData['owner_recruit'] = $owner_main;
        $this->viewData['owner_data'] = $owner_data;
        $this->viewData['owner_id'] = $owner_id;
        $this->viewData['count_profiles'] = $count_profiles;
        $this->viewData['title'] = 'joyspe｜メッセージ - 承認中一覧 - プロフィール';
        $this->viewData['loadPage'] = 'owner/message/message_approval_profileedit';
        $this->load->view("owner/layout/layout_B", $this->viewData);
    }

    /**
     * @author  [IVS] Nguyen Van Phong    
     * @todo 	edit owner_recruit owner_profileedit
     * @use in  
     * @param 	
     * @return 	
     */
    public function do_edit($owner_id) {
        $storename = $this->input->post('storename');        
        $sltImageDefault = $this->input->post('sltImageDefault');
        $company_info = $this->input->post('company_info');        
        $orid = $this->input->post('orid');
        $listImageUrl = $this->Mmessage->listImageUrl($orid);
        $l = $listImageUrl;
        $l_to_save = $listImageUrl;
        for ($i = 1; $i <= 6; $i++) {
            $url = $_POST['hdImage' . $i];
            // Nếu URL ko rỗng & có chứa 'images/' & không chứa no_image.jpg => Hình cũ
            if (!empty($url) && strpos($url, 'images/')) {
                $url = substr(strstr($url, 'images/'), 7);
                // Neu url co chua 'no_image.jpg' => Ko chon hinh anh
                if ($url == 'no_image.jpg') {
                    $url = '';
                }
            }
            // Nếu URL khác với đường dẫn cũ => Bị thay đổi hoặc bị xóa thành no_image
            else if ((strcmp($url, $l['image' . $i]) != 0)) {
                if (empty($url)) {
                    $url = '';
                } else {
                    // Nếu url có đuôi (sau images/) nằm trong image[i], 
                    // Tức lấy hình sau đè lên hình trước, thì url = image[i]
                    $url = substr(strstr($url, 'tmp/'), 4);  
                    $this->common->fileUpload($url);
                } // End else
            } // End else if            
            $l_to_save['image' . $i] = $url;
        } //End for
        // Delete folder upload image  
        $this->common->deleteFolder();
        // Update owner
        $dataOwner = array(
            'storename' => $storename,           
        );
        $this->Mmessage->updateOwner($dataOwner, $owner_id);
        // Update owner_recruit
        $dataOwnerRecruit = array(
            'main_image' => $sltImageDefault,
            'company_info' => $company_info,            
            'recruit_status' => 1,
            'image1' => $l_to_save['image1'],
            'image2' => $l_to_save['image2'],
            'image3' => $l_to_save['image3'],
            'image4' => $l_to_save['image4'],
            'image5' => $l_to_save['image5'],
            'image6' => $l_to_save['image6']
        );
        $this->Mmessage->updateOwnerRecruit($dataOwnerRecruit, $orid);
        // Send email     
        $this->common->sendMail('', '', '', array('ss08'), $owner_id, '', '', '', '', '', '', '', '');
        redirect(base_url() . 'owner/dialog/dialog_request/0');
    }

    /**
     * @author  [IVS] Nguyen Van Phong    
     * @todo 	Validate input in views
     * @use in  
     * @param 	
     * @return 	
     */
    public function checkValidateInput() {
        $this->form_validation->set_rules('hdImage1', 'hdImage1');
        $this->form_validation->set_rules('hdImage2', 'hdImage2');
        $this->form_validation->set_rules('hdImage3', 'hdImage3');
        $this->form_validation->set_rules('hdImage4', 'hdImage4');
        $this->form_validation->set_rules('hdImage5', 'hdImage5');
        $this->form_validation->set_rules('hdImage6', 'hdImage6');
         $this->form_validation->set_rules('ckImage[]', '写真');
        $this->form_validation->set_rules('company_info', '会社情報', 'trim|required|max_length[400]');        
        $this->form_validation->set_rules('storename', '求人会社名 or 求人店舗名', 'trim|required|max_length[100]');        
        $form_validation = $this->form_validation->run();
        $this->message['success'] = !$form_validation && count($_POST) > 0 ? FALSE : TRUE;
        if (!$form_validation) {
            return false;
        }
        return true;
    }
 
    /**
     * @author  [IVS] Nguyen Van Phong    
     * @todo 	Check owner_status
     * @use in  
     * @param 	
     * @return 	
     */
    public function checkOwnerRecruitStatus() {
        // = 1, dang cho approve thi qua dialog_request
        if ($this->status == 1) {
            $owner_id = OwnerControl::getId();
            $total = $this->Mowner->countOwnerRecruit($owner_id);
            if ($total == 1) {
                redirect(base_url() . 'owner/dialog/dialog_request/0');
            } else {
                redirect(base_url() . 'owner/dialog/dialog_request/1');
            }
        }
        // = 0, chua nhap recruit, thi qua login_store de nhap
        if ($this->status == 0) {
            redirect(base_url() . 'owner/login/login_store');
        }
        // = 2 da duoc approved, thi qua company_store de tao owner recruit moi
        if ($this->status == 2) {
            redirect(base_url() . 'owner/Company/company_store');
        }
    }

}

?>

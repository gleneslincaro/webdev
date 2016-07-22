<?php

class Search extends MX_Controller{
    protected $_data;
    private $message = array('success' => true, 'error' => array());
    private $common;
    public function __construct() {
        parent::__construct();
        AdminControl::CheckLogin();
        $this->_data["module"] = $this->router->fetch_module();
        $this->form_validation->CI =& $this;
        $this->common = new Common();
        $this->output->set_header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate");
        $this->output->set_header("Cache-Control: post-check=0, pre-check=0");
        $this->output->set_header("Pragma: no-cache");
    }
    /**
    * @author  [IVS] Nguyen Minh Ngoc
    * @name     fixname
    * @todo     fix name when upload file
    * @param 	$str
    * @return
    */
    public function fixname($str){
        $str=str_replace(array(" ","_","/","@","#","$","%","^","&","*",")","(","-"),"",$str);
        return $str;
    }
    /**
	 * @author  [IVS] Nguyen Minh Ngoc
	 * @name     user
	 * @todo     load page user information
	 * @param
	 * @return
	*/
    public function user(){
        $this->load->Model("admin/Msearch");
        $this->_data["loadPage"]="search/user";
        $this->_data["titlePage"]="ユーザー検索";
        $this->_data["webs"]=$this->Msearch->showWebsite();
        $this->load->view($this->_data["module"]."/layout/layout",$this->_data);
    }
    /**
	 * @author  [IVS] Nguyen Minh Ngoc
	 * @name     searchUser
	 * @todo     search user information
	 * @param
	 * @return
	*/
    public function searchUser(){
        //load model
        $this->load->Model("admin/Msearch");
        $this->_data["loadPage"]="search/user";
        $this->_data["titlePage"]="ユーザー検索";
        $this->_data["webs"]=$this->Msearch->showWebsite();
        $start = 0;
        //create variable
        $email_address = trim($this->input->post('txtEmailAddress'));
        $unique_id = trim($this->input->post('txtunique_id'));
        $name = trim($this->input->post('txtname'));
        $web_id= trim($this->input->post('sltwebs'));
        $account_name = trim($this->input->post('txtaccountname'));
        $datef_dktam = trim($this->input->post('txtf_dktam'));
        $datet_dktam = trim($this->input->post('txtt_dktam'));
        $datef_dk = trim($this->input->post('txtf_dk'));
        $datet_dk = trim($this->input->post('txtt_dk'));
        $m_status = trim($this->input->post('sltmail'));
        $status = trim($this->input->post('sltstatus'));
        $memo = trim($this->input->post('txtmemo'));
        $telephone_number = trim($this->input->post('txttelephone'));
        $telephone_record = trim($this->input->post('txttelrecord'));

        $param = array(
            'email_address' => $email_address,
            'unique_id'     => $unique_id,
            'name'          => $name,
            'account_name'  => $account_name,
            'web_id'        => $web_id,
            'datef_dktam'   => $datef_dktam,
            'datet_dktam'   => $datet_dktam,
            'datef_dk'      => $datef_dk,
            'datet_dk'      => $datet_dk,
            'm_status'      => $m_status,
            'status'        => $status,
            'memo'          => $memo,
            'telephone_number'=> $telephone_number,
            'telephone_record'=> $telephone_record
        );

        //init sql query to search user
        $sql = $this->Msearch->getSearchUser($param);
        //get totalRows
        $this->_data["count"]  = $this->Msearch->countSearch($sql);

        //init config to paging
        $this->load->library("pagination");
        $config['base_url'] = base_url().'admin/search/searchUser';
        $config['total_rows'] = $this->_data["count"];
        $config['constant_num_links'] = TRUE;
        $config['uri_segment']=4;
        $config["per_page"]=$this->config->item('per_page');
        $this->pagination->initialize($config);
        //start1 has value after clicking paging link
        $start1 = $this->uri->segment(4);
        if($start1!=NULL){
           $start=$start1;
        }
        //get data
        $this->_data["userinfo"] = $this->Msearch->listUser($sql,$this->config->item('per_page'),$start);
        //paging by ajax
        if(isset($_POST["ajax"]) && $_POST["ajax"]!=null){
          $this->load->view("search/user",$this->_data);
        }else{
           $this->load->view($this->_data["module"]."/layout/layout",$this->_data);
        }
    }
        /**
	 * @author  [IVS] Nguyen Minh Ngoc
	 * @name 	userDetail
	 * @todo 	view user information and update information
	 * @param
	 * @return
	*/
    public function userDetail(){
        $this->load->Model("admin/Msearch");
        $uid=$_GET["uid"];
        $this->_data["detail"]=$this->Msearch->showDetailUS($uid);
        if(empty($this->_data["detail"]) || $uid==""){
            redirect(base_url()."admin/system/errorPage");
        }
        $this->_data["recruit"]= $this->Musers->get_user_recruits($uid);
        $this->_data["loadPage"]="search/user_detail";
        $this->_data["titlePage"]="ユーザー検索";
        //$this->_data["detail"]=$this->Msearch->showDetailUS($uid);
        $this->_data["cscout"]=$this->Msearch->countUS("us03",$uid) + $this->Msearch->countUS("us14",$uid);
        $this->_data["capply"]=$this->Msearch->countApply($uid);
        $this->_data["cview"]=$this->Msearch->countUS("us07",$uid);
        $this->_data["apscout"]=$this->Msearch->showApplyScout($uid);
        $this->_data["website"]=$this->Msearch->showWeb();
        if($this->input->post("btnupdateus")){
            $this->form_validation->set_rules('txtpass', 'パスワード', 'trim|required|min_length[4]|max_length[20]|checkStringByte');
            $this->form_validation->set_rules('txtemail', 'アドレス', 'trim|required|max_length[200]|valid_email|checkStringByte');
            $this->form_validation->set_rules('txtOldID', '元のID', 'trim|max_length[200]');
            $this->form_validation->set_rules('txtUname', '氏名', 'trim|required|max_length[200]');
            $this->form_validation->set_rules('txtbirthday', '生年月日', 'trim|required|max_length[200]');
            $this->form_validation->set_rules('txtbankname', '銀行名', 'trim|max_length[100]||double');
            $this->form_validation->set_rules('txtbankkana', '支店名（通帳記号）', 'trim|max_length[100]|double');
            $this->form_validation->set_rules('txtacountno', '口座番号（通帳番号）', 'trim|max_length[20]|numeric');
            $this->form_validation->set_rules('txtaccountname', '名義', 'trim|max_length[100]|double');
            $this->form_validation->set_rules('txtmemo', 'メモ', 'trim|max_length[10000]');
            $this->form_validation->set_rules('txttelephone','電話番号','trim|max_length[25]');
            $this->form_validation->set_rules('txttelrecord','電話対応記録','trim|max_length[10000]');
            $form_validation = $this->form_validation->run();
            $this->message['success'] = !$form_validation && count($_POST) > 0 ? FALSE : TRUE;
            if ($form_validation==false) {
                 $this->_data['message']= $this->message;
                 $this->_data["cc"]="true";
            }else{
               $this->_data["flag"]="true";
               $this->_data["pass"]=base64_encode($this->input->post("txtpass"));
               $this->_data["old_id"]=$this->input->post("txtOldID");
               $this->_data["uname"]=$this->input->post("txtUname");
               $this->_data["status"]=$this->input->post("sltstatus");
               $this->_data["email"]=$this->input->post("txtemail");
               $this->_data["birthday"]=$this->input->post("txtbirthday");
               $this->_data["tel_number"] = $this->input->post("txttelephone");
               $this->_data["charge"]=$this->input->post("sltcharge");
               $this->_data["bank"]=$this->input->post("txtbankname");
               $this->_data["bankkana"]=$this->input->post("txtbankkana");
               $this->_data["ac_type"]=$this->input->post("sltac_type");
               $this->_data["ac_no"]=$this->input->post("txtacountno");
               $this->_data["ac_name"]=$this->input->post("txtaccountname");
               $this->_data["getmail"]=$this->input->post("txtgetmail");
               $this->_data["memo"]=$this->input->post("txtmemo");
               $this->_data["telephone_record"]=$this->input->post("txttelrecord");
               $this->_data["image1"]=$_POST['img1'];
               $this->_data["image2"]=$_POST['img2'];

            }
        }
        $this->load->view($this->_data["module"]."/layout/layout",$this->_data);
    }
    /**
	 * @author  [IVS] Nguyen Minh Ngoc
	 * @name 	fileUpload
	 * @todo 	copy image to images forder
	 * @param
	 * @return
	*/
    public function fileUpload($fileName,$fileName1,$fileName2)
    {
        $this->path = $this->config->item('upload_userdir');
        copy($this->path.'/tmp/'.$fileName, $this->path ."/images/".$fileName1."/".$fileName2);
    }

    /**
	 * @author  [IVS] Nguyen Minh Ngoc
	 * @name 	deleteFolder
	 * @todo 	delete image
	 * @param
	 * @return
	*/
    public function deleteFolder($fname)
    {
        $this->load->helper("file");

        $this->tmpPath = $this->config->item('upload_userdir') . '/tmp/' ;

        $this->folderName = $fname;

         if (is_dir($this->tmpPath . $fname)) {
             delete_files($this->tmpPath.$fname,true);
             rmdir($this->tmpPath.$fname);
         }
    }

    /**
	 * @author  [IVS] Nguyen Minh Ngoc
	 * @name 	approveUS
	 * @todo 	aprove user
	 * @param
	 * @return
	*/
    public function approveUS(){
        $uid=$_POST["uid"];
        $time = date("Y-m-d-H-i-s");
        $this->load->Model("admin/Msearch");
        $this->load->Model("admin/Msearch");$this->Msearch->approveUS($uid,$time);
        $url=base_url()."user/joyspe_user/company/sign_up";
         //send email
        $this->common->sendMail('', '','',array('us02'),'','',$uid,'','','','',$url,'');
    }

    /**
	 * @author  [IVS] Nguyen Minh Ngoc
	 * @name 	fileUploadAjx
	 * @todo 	upload images
	 * @param
	 * @return
	*/
    public function fileUploadAjx(){
        $path = $this->config->item('upload_userdir') . '/tmp/';
        if (!is_dir($path)) {
            mkdir($path);
        }
        $id=$_POST["id"];
        $this->load->Model("admin/Msearch");
        $this->_data["usinfo"]=$this->Msearch->showDetailUS($id);
        foreach($this->_data["usinfo"] as $k=>$item){
            $name=$item["uid"];
        }
        $path= $this->config->item('upload_userdir')."/tmp/".$name;
        if(isset($_FILES["txtimg"]) && !isset($_FILES["txtimg1"])){
                if (!file_exists($path)) {
                        mkdir($path);
                }
                $config["file_name"]=$this->fixname($_FILES['txtimg']['name']);
                $config['upload_path'] = $this->config->item('upload_userdir')."/tmp/".$name;
                $config['allowed_types'] = 'jpeg|jpg|png';
                $config['max_size']	= 4096;
                $config['overwrite']  = true;
                $this->load->library('upload', $config);
                if ( ! $this->upload->do_upload("txtimg"))
                {
                     $array = array('error' => substr($this->upload->display_errors(), 3,  strlen($this->upload->display_errors() ) - 7)) ;
                     echo json_encode($array);
                     die;
                }
                else
                {
                    $this->_data["data"] = array($this->upload->data());
                    $array = array('url'=>base_url(). $this->config->item('upload_userdir')."/tmp/".$name."/".$this->fixname($_FILES['txtimg']["name"]),'fileName'=>$name."/".$this->fixname($_FILES['txtimg']["name"]));
                     echo json_encode($array);
                     die;
                }
        }else{
                if (!file_exists($path)) {
                        mkdir($path);
                }
                 $config["file_name"]=$this->fixname($_FILES['txtimg1']['name']);
                $config['upload_path'] = $this->config->item('upload_userdir')."/tmp/".$name;
                $config['allowed_types'] = 'jpeg|jpg|png';
                $config['max_size']	= 4096;
                $config['overwrite']  = true;
                $this->load->library('upload', $config);
                if ( ! $this->upload->do_upload("txtimg1"))
                {
                     $array = array('error' => substr($this->upload->display_errors(), 3,  strlen($this->upload->display_errors() ) - 7)) ;
                     //$array = array('error'=>$this->upload->display_errors());
                     echo json_encode($array);
                     die;
                }
                else
                {
                    $this->_data["data"] = array($this->upload->data());
                    $array = array('url'=>base_url(). $this->config->item('upload_userdir')."/tmp/".$name."/".$this->fixname($_FILES['txtimg1']["name"]),'fileName'=>$name."/".$this->fixname($_FILES['txtimg1']["name"]));
                    echo json_encode($array);
                    die;
                }
        }
    }

    /**
	 * @author     [IVS] Nguyen Van Vui
	 * @name 	user_profile
	 * @todo 	view user profile
	 * @param
	 * @return
	 */

    function user_profile($id = 1) {
        $this->load->Model("user/Musers");
        $this->load->Model("admin/Msearch");
        $get_user_recruits = $this->Musers->get_user_recruits($id);
        $get_user = $this->Musers->get_users($id);
        if(count($get_user_recruits) > 0 && count($get_user) > 0){
            $row_data = $get_user;
            $this->_data['userData']=$row_data;
            $this->_data['unique_id']=$row_data['unique_id'];
            $get_user_recruits['bust'] = $row_data['bust'];
            $get_user_recruits['waist'] = $row_data['waist'];
            $get_user_recruits['hip'] = $row_data['hip'];
            $this->_data['uprofile'] = $get_user_recruits;
            $this->_data['agelist']=$this->Musers->list_combobox($tbl='mst_ages');
            $this->_data['heightlist']=$this->Musers->list_combobox($tbl='mst_height');
            $this->_data['citylist']=$this->Musers->list_combobox($tbl='mst_cities');
            $this->_data['bustlist']=$this->Musers->list_combobox($tbl='mst_busts');
            $this->_data['waistlist']=$this->Musers->list_combobox($tbl='mst_waists');
            $this->_data['hiplist']=$this->Musers->list_combobox($tbl='mst_hips');
            $this->_data['listJobTypename']=$this->Msearch->listJobTypename();
            $this->_data['listJobTypenameById']=$this->Msearch->listJobTypenameById($id);
            $this->_data['salary_range_list'] = $this->Musers->list_combobox($tbl='mst_salary_range');
            $this->_data['loadPage']='search/user_profile';
            $this->_data['titlePage']='ユーザー・プロフィール';
            $this->load->view($this->_data['module'].'/layout/layout',$this->_data);
        }else{
            redirect(base_url()."admin/system/errorPage");
        }
    }

    /**
	 * @author     [IVS] Nguyen Van Vui
	 * @name 	comp
	 * @todo 	view compple change user profile
	 * @param
	 * @return
	 */
    function update_user_profile(){
        // get values
        $user_id = $this->input->post('user_id');
        $age_id = $this->input->post('age_id');
        $height_id = $this->input->post('height_id');
        $city_id = $this->input->post('city_id');

        $bust_size = $this->input->post('bust_size');
        $waist_size = $this->input->post('waist_size');
        $hip_size = $this->input->post('hip_size');

        $working_exp = $this->input->post('working_exp');
        $hope_salary = $this->input->post('hope_salary_id');
        $pr_message = $this->input->post('pr_message');

        $data = array(
        'age_id' => $age_id,
        'height_id' => $height_id,
        'city_id' => $city_id,
        'working_exp' => $working_exp,
        'hope_salary_id' => $hope_salary,
        'pr_message' => $pr_message,
        'updated_date' => date("y-m-d H:i:s")
        );
        // update user_recruits
        $this->Musers->update_User_recruits($data, $user_id);

        // update users
        $udata = array(
            'bust' => $bust_size,
            'waist' => $waist_size,
            'hip' => $hip_size,
            'updated_date' => date("y-m-d H:i:s"),
        );
        $this->Musers->update_User($udata, $user_id);

        $this->_data['loadPage']='search/comp';
        $this->_data['titlePage']='会社検索';
        $this->load->view($this->_data['module'].'/layout/layout',$this->_data);
    }

    /**
	 * @author     [IVS] Nguyen Van Vui
	 * @name 	file_upload_com_detail
	 * @todo 	upload file image
	 * @param
	 * @return
	 */
    public function file_upload_com_detail(){
        $id=$_POST["id"];
        $name=$id;
        $path= $this->config->item('upload_dir')."/tmp/".$name;
        if (!file_exists($path)) {
            mkdir($path);
        }
        $file_name=$this->fixname($_FILES['txtImgComDetail']['name']);

        $config["file_name"]=$file_name;
        $config['upload_path'] = $path;
        $config['allowed_types'] = 'jpeg|jpg|png';
        $config['max_size']	= 4096;
//            $config['max_width']  = '400';
//            $config['max_height']  = '300';
        $config['overwrite']  = true;
//            $config['file_name'] = $filename;

        $this->load->library('upload', $config);
        if ( ! $this->upload->do_upload("txtImgComDetail"))
        {
            //$array = array('error'=>$this->upload->display_errors());
            $array = array('error' => substr($this->upload->display_errors(), 3,  strlen($this->upload->display_errors() ) - 7)) ;
            echo json_encode($array);
            die;
        }
        else
        {
            $config['image_library'] = 'gd2';
            $config['source_image'] = $path.'/'.$file_name;
            $config['create_thumb'] = FALSE;
            $config['maintain_ratio'] = FALSE;
            $config['max_size']	= 4096;
            $config['width'] = 400;
            $config['height'] = 300;

            $this->load->library('image_lib', $config);

            $this->image_lib->resize();

            $this->_data["data"] = array($this->upload->data());
//                $array = array('url'=>base_url()."public/admin/". $this->config->item('upload_url')."/tmp/".$name."/".$filename,'fileName'=>$name."/".$filename);
            $array = array('url'=>base_url().$this->config->item('upload_url')."tmp/".$name."/".$file_name,'fileName'=>$name."/".$file_name);
            echo json_encode($array);
            die;
        }
    }

    /**
	 * @author     [IVS] Nguyen Van Vui
	 * @name 	company_detail
	 * @todo 	view company details
	 * @param
	 * @return
	 */

    function company_detail($id) {
        $this->load->Model("owner/Manalysis");
        $this->load->Model('admin/Msearch');
        $records = $this->Msearch->companyDetail($id);
        if(count($records) > 0){
            $this->_data['records'] = $records;
            $this->_data['countApplicants']=$this->Msearch->countApplicants($id);
            $this->_data['countPublicInfo']=$this->Msearch->countPublicInfo($id);
            $this->_data['countScoutSent']=$this->Msearch->countScoutSent($id);
            $this->_data['countWorkingApprove']=$this->Msearch->countWorkingApprove($id);
            $this->_data['countSendNumber']=$this->Msearch->countSendNumber($id);
            $this->_data['listPaymentMethod']=$this->Msearch->listPaymentMethod();
            $where = 'AND scout_auto_send_flag = 1';
            $this->_data['autoSendFlag']=$this->Mowner->getAutoSend($id, $where);
            $ckOwner = $this->Mowner->getAutoSend($id);
            if(count($ckOwner) == 0){
                $slectFlag = false;
                for($x=1;$x<=6;$x++){
                    if($x == 6){
                        $x=1;
                        $slectFlag = true;
                    }
                    if($slectFlag == true && $x <= 4){
                        if($x == 4){
                            break;
                        }
                        $data = array('owner_id' => $id, 'pick_num_order' => $x, 'selected_flag' => 1);
                    }else{
                        $data = array('owner_id' => $id, 'pick_num_order' => $x, 'selected_flag' => 0);
                    }
                    $this->Mowner->insertAutoSend($data);
                }
            }
        }else{
            redirect(base_url()."admin/system/errorPage");
        }

        $day = date('d');
        if($day > 20){
          $from_date =  date('Y-m')."-21 00:00:00";
          $to_date = date('Y-m-').$day." 23:59:59";
        }else{
          $from_date =  date('Y-m', strtotime(date('Y-m-1') . '-1 month'))."-21 00:00:00";
          $to_date = date('Y-m-').$day." 23:59:59";
        }
        $date_from = strtotime($this->Manalysis->getOwnerRegistDate($id));
        $month1 = date('Y')*12 + date('m');
        $month2 = date('Y', $date_from)*12 + date('m',$date_from);
        $result = ($month1 - $month2)+1;
        list($year, $month) = explode("-", date('Y-m',$date_from), 2);
        for($i=0; $i < ($result); $i++){
            $select_date_from[$i] = date('Y-m', mktime(0, 0, 0, $month + $i, 1, $year));
        }
        for($i=0; $i < $result; $i++){
            $select_date_to[$i] = date('Y-m', mktime(0, 0, 0, $month + $i, 1, $year));
        }
        $this->_data['select_date_from'] = $select_date_from;
        $this->_data['select_date_to'] = $select_date_to;

        $date = date('Y-m');
        list($year, $month) = explode("-", $date, 2);
        $nowMonth = date('Y-m-d', mktime(0, 0, 0, $month, 1, $year));
        $analysis_data = $this->Manalysis->doUserAnalysis($id,$nowMonth,date("Y-m-t",strtotime($nowMonth)));
        $analysis_data['nowmonth'] = date('Y-m',strtotime($nowMonth));
        $this->_data['analysis_data'] = $analysis_data;

        $this->_data['loadPage']='search/company_detail';
        $this->_data['titlePage']='会社検索';
        $this->load->view($this->_data['module'].'/layout/layout',$this->_data);
    }

    //--------アクセス解析処理----------
    public function result_of_analysis($id) {
        $this->load->Model("owner/Manalysis");
        $owner_id = $id;

        $from_date = $this->input->post('from_date');
        $to_date = $this->input->post('to_date');

        $data1 = $this->Manalysis->doUserAnalysis($owner_id,$from_date,$to_date);
        $data11[0] = $data1;

        $this->viewData['analysis_data_ar'] = $this->Manalysis->doUserAnalysisMonth($owner_id,$from_date,$to_date);
        $this->viewData['analysis_data'] = $data11;
        $this->load->view("admin/search/result_of_analysis", $this->viewData);
    }

    /**
	 * @author     [IVS] Nguyen Van Vui
	 * @name 	update_owner_register
	 * @todo 	update status owner
	 * @param
	 * @return
	 */

    function update_owner_register() {
        $id=$this->input->post('hrId');
        $this->load->Model('admin/Msearch');
        $this->Msearch->updateOwnerRegister($id);
        $this->common->sendMail('', '', 'Joyspe', array('ow02'),'','', $id,'','','','','','');
        redirect(base_url().'admin/search/update_owner_completed');
    }

    /**
	 * @author     [IVS] Nguyen Van Vui
	 * @name 	validate_update_owner
	 * @todo 	validate update owner
	 * @param
	 * @return
	 */

    function validate_update_owner() {
        $this->form_validation->set_rules('txtEmail', 'アドレス', 'required|valid_email');
        $this->form_validation->set_rules('txtPassword', 'パスワード', 'required|min_length[4]|checkStringByte');
        $this->form_validation->set_rules('txtKuchikomiUrl', '口コミリンク', 'trim|max_length[200]');
        $this->form_validation->set_rules('txtDefaultScoutMailsPerDay', '1日スカウト送信数', 'required|numeric|');
        $form_validation = $this->form_validation->run();
        $this->message['success'] = !$form_validation && count($_POST) > 0 ? FALSE : TRUE;
        if ($form_validation == FALSE) {
            $json['success'] = false;
            $json['message'] = validation_errors();
        }else {
            $json['success'] = true;
        }

        echo json_encode($json);
    }

    /**
     *
	 * @author     [IVS] Nguyen Van Vui
	 * @name 	update_owner
	 * @todo 	update owner
	 * @param
	 * @return
	 */

    function update_owner() {
        $id=trim($this->input->post('hrId'));
        $hrOwnerStatus=trim($this->input->post('hrOwnerStatus'));
        $txtEmail=trim($this->input->post('txtEmail'));
        $txtAgEmail=trim($this->input->post('txtAgEmail'));
        $uMonthSendFlag=trim($this->input->post('uMonthSendFlag'));
        $uAgMonthSendFlag=trim($this->input->post('uAgMonthSendFlag'));
        $txtDefaultScoutMailsPerDay=trim($this->input->post('txtDefaultScoutMailsPerDay'));
        $txtPassword=trim($this->input->post('txtPassword'));
        $cbOwnerStatus=trim($this->input->post('cbOwnerStatus'));
        //$txtStoreName=trim($this->input->post('txtStoreName'));
        //$txtNotifier=trim($this->input->post('txtNotifier'));
        $new_store_date=preg_replace('/\//', '-', $this->input->post('NewStoreDate').' '.date("H-i-s"));

//$str = str_replace("ll", "", "good golly miss molly!", $count);

        $txtPersonnelPic=trim($this->input->post('txtPersonnelPic'));
        $txtAddress=trim($this->input->post('txtAddress'));
        $txtPhone=trim($this->input->post('txtPhone'));
        $txtStoreNotificationType=trim($this->input->post('txtStoreNotificationType'));
        $txtPublicCommission=trim($this->input->post('txtPublicCommission'));
        $txtNotifyNo=trim($this->input->post('txtNotifyNo'));
        $cbMagazineStatus=trim($this->input->post('cbMagazineStatus'));
        $txtMemo=trim($this->input->post('txtMemo'));
        $txtKuchikomiUrl=trim($this->input->post('txtKuchikomiUrl'));
        $rdPublicFlag=$this->input->post('rdPublicFlag');
        $autoSendFlag=$this->input->post('autoSendFlag');
        $uRecruitmentFlag=$this->input->post('uRecruitmentFlag');
        $email_error_flag=$this->input->post('email_error_flag');
        $free_owner_flag=$this->input->post('free_owner_flag');
        $hrImgComDetail=$this->input->post('hrImgComDetail');
        $txtNewTrialWorkBonus = $this->input->post('txtNewTrialWorkBonus');
        $travel_expense_bonus_point = $this->input->post('travel_expense_bonus_point');
        $kameLoginId = $this->input->post('kameLoginId');
        $kamePassword = $this->input->post('kamePassword');

        $this->load->Model("admin/Msearch");
        $records=$this->Msearch->companyDetail($id);
        $imageOnwer=$records['kanri_image'];
        $diffImage=FALSE;
        if($imageOnwer!=$hrImgComDetail){
           $diffImage=TRUE;
        }

        $time = date("Y-m-d-H-i-s");
        $values=Array(
            'new_store_date'=> $new_store_date,
//            'new_store_date'=> '2016-5-24 11:11:11',
            'email_address'=>trim($txtEmail),
            'ag_email_address'=>trim($txtAgEmail),
            'month_send_flag'=>trim($uMonthSendFlag),
            'ag_month_send_flag'=>trim($uAgMonthSendFlag),
            'password'=>base64_encode(trim($txtPassword)),
            'owner_status'=>$cbOwnerStatus,
            'pic'=>trim($txtPersonnelPic),
            'store_notification_type'=>trim($txtStoreNotificationType),
            'public_commission'=>trim($txtPublicCommission),
            'notify_no'=>trim($txtNotifyNo),
            'magazine_status'=>$cbMagazineStatus,
            'memo'=>trim($txtMemo),
            'kuchikomi_url'=>trim($txtKuchikomiUrl),
            'public_info_flag'=>$rdPublicFlag,
            'urgent_recruitment_flag'=>$uRecruitmentFlag,
            'email_error_flag'=>$email_error_flag,
            'free_owner_flag'=>$free_owner_flag,
            'admin_owner_flag'=>1,
            'kanri_image'=>$hrImgComDetail,
            'trial_work_bonus_point' =>$txtNewTrialWorkBonus,
            'travel_expense_bonus_point' =>$travel_expense_bonus_point,
            'kame_login_id'=>$kameLoginId,
            'kame_password' => base64_encode(trim($kamePassword))
        );

        $current_scout_mails_per_day = $this->Msearch->getScoutMailsPerDay($id);
        if ( $current_scout_mails_per_day != $txtDefaultScoutMailsPerDay ){
           $values['default_scout_mails_per_day'] = $txtDefaultScoutMailsPerDay;
           $values['remaining_scout_mail'] = $txtDefaultScoutMailsPerDay;
        }

        $values2 = $values;
        $values2['offcial_reg_date'] = $time;

        $this->load->Model('admin/Msearch');
        $this->Msearch->updateOwner($id,$values);
        $this->Mowner->updateAutoSendFlag($id, trim($autoSendFlag));
        //send mail
        if($hrOwnerStatus==0 && $cbOwnerStatus==2){
            $this->common->sendMail('', '', 'Joyspe', array('ow02'),'','', $id,'','');
            $this->Msearch->updateOwner($id,$values2);
        }else{
            $this->Msearch->updateOwner($id,$values);
        }
        //update penalty_date khi owner bi penalty
        if($cbOwnerStatus==3){
            $this->Msearch->updatePenaltyOnwer($id);
        }
        if($diffImage)
        {
            $temp = explode("/",$hrImgComDetail);
            if($temp[0]!=null || $temp[0]!=""){
                $path= $this->config->item('upload_dir')."/images/".$temp[0];
                $path_del= $this->config->item('upload_dir')."/tmp/".$temp[0];
                if (!file_exists($path)) {
                    mkdir($path);
                }
                $this->coppy_file_for_owner($hrImgComDetail);
                if(is_dir($path_del)){
                    $this->delete_folder_for_owner($temp[0]);
                }
            }
        }
    }

    /**
	 * @author     [IVS] Nguyen Van Vui
	 * @name 	coppy_file_for_owner
	 * @todo 	coppy file
	 * @param
	 * @return
	 */

    public function coppy_file_for_owner($fileName)
    {
        $this->path = $this->config->item('upload_dir');
        copy($this->path.'/tmp/'.$fileName, $this->path ."/images/".$fileName);
    }

    /**
	 * @author     [IVS] Nguyen Van Vui
	 * @name 	delete_folder_for_owner
	 * @todo 	delete folder
	 * @param
	 * @return
	 */

    public function delete_folder_for_owner($fname)
    {
        $this->load->helper("file");
        $this->tmpPath = $this->config->item('upload_dir') . '/tmp/' ;
        $this->folderName = $fname;
         if (is_dir($this->tmpPath . $fname)) {
             delete_files($this->tmpPath.$fname,true);
             rmdir($this->tmpPath.$fname);
         }
    }

    /**
	 * @author     [IVS] Nguyen Van Vui
	 * @name 	update_owner_completed
	 * @todo 	update owner completed
	 * @param
	 * @return
	 */

    function update_owner_completed() {
        $this->_data['loadPage']='search/comp';
        $this->_data['titlePage']='会社検索';
        $this->load->view($this->_data['module'].'/layout/layout',$this->_data);
    }


    /**
	 * @author  [IVS] Nguyen Minh Ngoc
	 * @name     penalty
	 * @todo     load page owner penalty
	 * @param
	 * @return
	*/
    public function penalty(){
        $this->load->Model("admin/Msearch");
        $this->_data["loadPage"]="search/penalty";
        $this->_data["titlePage"]="会社・ペナルティ検索";
        $this->load->view($this->_data["module"]."/layout/layout",$this->_data);
    }

   /**
	 * @author  [IVS] Nguyen Minh Ngoc
	 * @name     searchPen
	 * @todo     show list owner pennalty
	 * @param
	 * @return
	*/
    public function searchPen(){
        $this->load->Model("admin/Msearch");
        $this->_data["loadPage"]="search/penalty";
        $this->_data["titlePage"]="会社・ペナルティ検索";
        $start = 0;
        $email = trim($this->input->post('txtpemail'));
        $storename = trim($this->input->post('txtpstore'));
        $this->_data["count"]=$this->Msearch->countPen($email,$storename) ;
        //init config to paging
        $this->load->library("pagination");
        $config['base_url'] = base_url().'admin/search/searchPen';
        $config['total_rows'] = $this->_data["count"];
        $config['constant_num_links'] = TRUE;
        $config['uri_segment']=4;
        $config["per_page"]=$this->config->item('per_page');
        $this->pagination->initialize($config);
         //start1 has value after clicking paging link
        $start1 = $this->uri->segment(4);
        if($start1!=NULL){
            $start=$start1;
        }
        //get data
       $this->_data["listpe"]=$this->Msearch->searchPenalty($email,$storename,$config['per_page'],$start);
        //paging by ajax
        if(isset($_POST["ajax"]) && $_POST["ajax"]!=null){
           $this->load->view("search/penalty",$this->_data);
        }else{
            $this->load->view($this->_data["module"]."/layout/layout",$this->_data);
        }
    }

    /**
	 * @author  [IVS] Nguyen Minh Ngoc
	 * @name     company_Profile
	 * @todo     show information of owner recruit
	 * @param
	 * @return
	*/
    public function company_Profile(){
        $this->load->model('owner/Mowner');
        $this->load->Model("admin/Msearch");
        $this->load->Model("user/mcity");
        $this->_data["loadPage"]="search/company_profile";
        $this->_data["titlePage"]="認証・プロフィール詳細";
        $this->_data['city_groups'] = $this->Mowner->getGroups();
        $id=$this->uri->segment(4);
        $owner_info = $this->Msearch->companyStoreEdit($id);
        $this->_data["cominfo"] = $owner_info;
        if($id=="" || empty( $this->_data["cominfo"])){
             redirect(base_url()."admin/system/errorPage");
        }
        //get current time
        $time = date("Y-m-d-H-i-s");
        //

        $ckjobTypeOwnerRecruit = $this->Mowner->getJobTypeOfOwnerRecruit($id);
        $this->_data["ckjobTypeOwnerRecruit"] = $ckjobTypeOwnerRecruit[0]['id'];
        $this->_data["cominfo"]=$this->Msearch->companyStoreEdit($id);
        $this->_data["tre"]=$this->Msearch->getTreatmentOwner($id);
        $this->_data["alltre"]=$this->Msearch->getAllTreatments();
        $this->_data["job"]=$this->Msearch->getJobType();
        $this->_data["jobOW"]=$this->Msearch->getJobTypeOwner($id);
        $this->_data['cities'] = $this->Msearch->getCity();
        $this->_data['happyMoneys'] = $this->Msearch->getHappyMoney();
        $this->_data['city_group_id'] = $this->_data["cominfo"][0]['city_group_id'];
        $this->_data['city_id'] = $this->_data["cominfo"][0]['city_id'];
        $this->_data['town_id'] = $this->_data["cominfo"][0]['town_id'];
        $this->_data["owner_category"] = $this->Mowner->get_owner_category($id);
        $this->_data["all_citygroup"] = $this->mcity->get_all_citygroup();
        $this->_data["all_city"] = $this->mcity->get_all_city();
        $this->_data["all_towns"] = $this->mcity->get_all_town();

        if($this->input->post("btnupown")){
            $this->_data["txtDatePickerCreatedDate"] = $this->input->post('txtDatePickerCreatedDate');
            $this->_data["ckjobTypeOwnerRecruit"] = $this->input->post('ckJobType');
            $this->_data['city_group_id'] = $this->input->post('city_group_id');
            $this->_data['city_id'] = $this->input->post('city_id');
            $this->_data['town_id'] = $this->input->post('town_id');
            $this->_data["cominfo"][0]['work_place'] = $this->input->post('txtWorkPlace');
            $this->_data["cominfo"][0]['working_day'] = $this->input->post('txtWorkingDay');
            //$this->_data["cominfo"][0]['happy_money_id'] = $this->input->post('happy_money');
            //$this->_data["cominfo"][0]['cond_happy_money'] = $this->input->post('cond_happy_money');
            $this->_data["orid"]= $this->input->post('txtorid');
            $this->_data["image1"] = $this->input->post('hdImage1');
            $this->_data["image2"] = $this->input->post('hdImage2');
            $this->_data["image3"] = $this->input->post('hdImage3');
            $this->_data["image4"] = $this->input->post('hdImage4');
            $this->_data["image5"] = $this->input->post('hdImage5');
            $this->_data["image6"] = $this->input->post('hdImage6');
            $this->_data["cominfo"][0]['set_send_mail'] = $this->input->post('set_send_mail');
            $this->_data["cominfo"][0]['public_info_flag'] = $this->input->post('public_info_flag');
            $this->_data["sltmainimg"] = $this->input->post('sltmainimg');
            $job=$this->input->post("job");
            $treat=$this->input->post("cbkalltre");
            $this->_data["jobtype"]=null;
            $this->_data["treat"]=null;
            if(isset($job) && $job!=""){
                foreach ($job as $k=>$value){
                  $this->_data["jobtype"] =$this->_data["jobtype"].",".$value;
                }
            }
            $this->_data["jobarray"]=explode(",",$this->_data["jobtype"]);
            if(isset($treat)&& $treat!=""){
                foreach($treat as $k=>$value2){
                  $this->_data["treat"]=$this->_data["treat"].",".$value2;
                }
            }
            $this->_data["treatarray"]=explode(",",$this->_data["treat"]);
            $this->form_validation->set_rules('txtDatePickerCreatedDate', '作成日', 'required');
            $this->form_validation->set_rules('cbkalltre', '待遇', 'required');
            $this->form_validation->set_rules('sltworkinghf', '出勤スタイル', 'callback_checkHour');
            $this->form_validation->set_rules('city_group_id', 'エリア地域', 'required');
            $this->form_validation->set_rules('city_id', 'エリア都道府県', 'required');
            $this->form_validation->set_rules('town_id', 'エリア都市', 'required');
            $this->form_validation->set_rules('txtTitle', 'タイトル', 'trim|required|min_length[4]|max_length[100]');
            $this->form_validation->set_rules('txtStoreName', '店舗名', 'trim|required|max_length[100]');
            $this->form_validation->set_rules('txtAddress', '住所', 'trim|required|max_length[200]');
            $this->form_validation->set_rules('ckJobType', '業種', 'required');
            $this->form_validation->set_rules('txtWorkPlace', '勤務地', 'trim|required|max_length[200]');
            $this->form_validation->set_rules('txtWorkingDay', '勤務日', 'trim|required|max_length[200]');
            $this->form_validation->set_rules('txtHowToAccess', '交通', 'trim|required|max_length[200]');
            $this->form_validation->set_rules('txtSalary', '給与', 'trim|required|max_length[200]');
            $this->form_validation->set_rules('txtConToApply', '応募資格', 'trim|required|max_length[200]');
            $this->form_validation->set_rules('cbkalltre[]', '待遇', 'required');
            $this->form_validation->set_rules('txtShopInfo', 'お店からのメッセージ', 'trim|required');
            $this->form_validation->set_rules('txtTimeOfApply', '応募時間', 'trim|required|max_length[20]');
            $this->form_validation->set_rules('txtTelForApp', '応募用電話番号', 'trim|required|max_length[24]|checkStringByte|validNumber');
            $this->form_validation->set_rules('txtMailForApp', '応募用メールアドレス', 'trim|required|max_length[200]|checkStringByte|valid_email');
            $this->form_validation->set_rules('txtMailForReply', 'お問い合わせ通知用のメールアドレス', 'trim|max_length[200]|checkStringByte|valid_email');
            $this->form_validation->set_rules('txtHomePageUrl', 'オフィシャルHP', 'trim|required|max_length[100]');
            $this->form_validation->set_rules('txtScoutPrText', 'スカウトメール自己PR文', 'trim');
            $this->form_validation->set_rules('txtLineId', 'LINEID');
            $this->form_validation->set_rules('hdImage1', 'hdImage1');
            $this->form_validation->set_rules('hdImage2', 'hdImage2');
            $this->form_validation->set_rules('hdImage3', 'hdImage3');
            $this->form_validation->set_rules('hdImage4', 'hdImage4');
            $this->form_validation->set_rules('hdImage5', 'hdImage5');
            $this->form_validation->set_rules('hdImage6', 'hdImage6');
            $form_validation = $this->form_validation->run();
            $this->message['success'] = !$form_validation && count($_POST) > 0 ? FALSE : TRUE;
            if ($form_validation==false) {
                $this->_data['message']= $this->message;
                $this->_data["cc"]="true";
            }else {
                $this->_data["flag"]="true";
            }
        }
        $this->load->view($this->_data["module"]."/layout/layout",$this->_data);
    }

    public function checkHour(){
        $hf=$this->input->post("sltworkinghf");
        $ht=$this->input->post("sltworkinght");
        if($hf<=$ht){
            return true;
        }else{
            return false;
        }
    }

    /**
	 * @author     [IVS] Nguyen Van Vui
	 * @name 	company
	 * @todo 	search company
	 * @param
	 * @return
	 */

    function company() {
        $this->load->Model("admin/Msearch");
        $this->_data["listWebsite"]=$this->Msearch->listWebsite();
        $this->_data["loadPage"]="search/company";
        $this->_data["titlePage"]="店舗検索";
        $this->load->view($this->_data["module"]."/layout/layout",$this->_data);
    }

    /**
	 * @author     [IVS] Nguyen Van Vui
	 * @name 	company_after
	 * @todo 	search company results
	 * @param
	 * @return
	 */

    function company_after() {
        $start = 0;
        $where='';
        //get value input
        $txtEmail=trim($this->input->post('txtEmail'));
        $txtStoreName=trim($this->input->post('txtStoreName'));
        $txtPic=trim($this->input->post('txtPic'));
        $txtIP=trim($this->input->post('txtIP'));
        $txtTel=trim($this->input->post('txtTel'));
        $txtTempRegDateFrom=trim($this->input->post('txtTempRegDateFrom'));
        $txtTempRegDateTo=trim($this->input->post('txtTempRegDateTo'));
        $txtCreatedDateFrom=trim($this->input->post('txtCreatedDateFrom'));
        $txtCreatedDateTo=trim($this->input->post('txtCreatedDateTo'));
        $txtAddress=trim($this->input->post('txtAddress'));
        $txtMemo=trim($this->input->post('txtMemo'));
        $cbOwnerStatus=trim($this->input->post('cbOwnerStatus'));
        $cbCreditResult=trim($this->input->post('cbCreditResult'));
        $rdPublicFlag=trim($this->input->post('rdPublicFlag'));
        $cbWebsite=trim($this->input->post('cbWebsite'));

        //set conditions
        if($txtEmail!=""){
            $where.=" AND ow.`email_address` LIKE '%".$this->db->escape_like_str($txtEmail)."%' ";
        }
        if($txtStoreName!=""){
            $where.=" AND ow.`storename` LIKE '%".$this->db->escape_like_str($txtStoreName)."%' ";
        }
        if($txtPic!=""){
            $where.=" AND ow.`pic` LIKE '%".$this->db->escape_like_str($txtPic)."%' ";
        }
        if($txtTel!=""){
            $where.=" AND ow.`tel` LIKE '%".$this->db->escape_like_str($txtTel)."%' ";
        }
        if($txtIP!=""){
            $where.=" AND ow.`ip_address` LIKE '%".$this->db->escape_like_str($txtIP)."%' ";
        }
        if($txtTempRegDateFrom !=""){
            $where.=" AND DATE_FORMAT(ow.`temp_reg_date`,'%Y/%m/%d') >= '".$this->db->escape_str($txtTempRegDateFrom)."' ";
        }
        if($txtTempRegDateTo!=""){
            $where.=" AND DATE_FORMAT(ow.`temp_reg_date`,'%Y/%m/%d') <= '".$this->db->escape_str($txtTempRegDateTo)."' ";
        }
        if($txtCreatedDateFrom !=""){
            $where.=" AND DATE_FORMAT(ow.`offcial_reg_date`,'%Y/%m/%d') >= '".$this->db->escape_str($txtCreatedDateFrom)."' ";
        }
        if($txtCreatedDateTo!=""){
            $where.=" AND DATE_FORMAT(ow.`offcial_reg_date`,'%Y/%m/%d') <= '".$this->db->escape_str($txtCreatedDateTo)."' ";
        }
        if($txtAddress!=""){
            $where.=" AND ow.`address` LIKE '%".$this->db->escape_like_str($txtAddress)."%' ";
        }
        if($txtMemo!=""){
            $where.=" AND ow.`memo` LIKE '%".$this->db->escape_like_str($txtMemo)."%' ";
        }
        if($cbOwnerStatus!=""){
            if($cbOwnerStatus!=-1){
                $where.=" AND ow.`owner_status` = ".$this->db->escape_str($cbOwnerStatus);
            }
        }
        if($cbCreditResult!=""){
            if($cbCreditResult==2){
                $where.=" AND ow.`magazine_status` = 1 ";
            }elseif ($cbCreditResult==3) {
                $where.=" AND ow.`magazine_status` = 0 ";
            }
        }

        if($rdPublicFlag != ""){
            if($rdPublicFlag == 1){
                $where.=" AND ow.`public_info_flag` = 1 ";
            }elseif ($rdPublicFlag == 0) {
                $where.=" AND ow.`public_info_flag` = 0 ";
            }
        }

        if($cbWebsite!=""){
            if($cbWebsite!=0 && $cbWebsite!=-1){
                $where.=" AND ow.`website_id` = ".$this->db->escape_str($cbWebsite);
            }
        }
        $this->load->Model("admin/Msearch");
        $this->_data["listWebsite"]=$this->Msearch->listWebsite();
        $totalNumber = $this->Msearch->search_company($where);
        $totalNumber = count($totalNumber);
        //Start Page
        $config['base_url'] = base_url('index.php/admin/search/company_after');
        $config['total_rows'] = $totalNumber;
        $config['constant_num_links'] = TRUE;
        $config['uri_segment']=4;
        $config["per_page"]=$this->config->item('per_page');
        $this->pagination->initialize($config);
        $start1 = $this->uri->segment(4);
        if($start1!=NULL) $start=$start1;
        $this->_data["records"]=$this->Msearch->search_company($where,$config['per_page'],$start);
        //End page
        $this->_data["totalNumber"]=$totalNumber;
        $this->_data["loadPage"]="search/company";
        $this->_data["titlePage"]="店舗検索";
        //paging by ajax
        if($this->input->post('ajax')!=null){
           $this->load->view("search/company",$this->_data);
        }else{
            $this->load->view($this->_data["module"]."/layout/layout",$this->_data);
        }
    }

    /**
	 * @author     [IVS] Nguyen Van Vui
	 * @name 	work
	 * @todo 	search work
	 * @param
	 * @return
	 */

    function work() {
        $this->_data["loadPage"]="search/work";
        $this->_data["titlePage"]="勤務申請一覧";
        $this->load->view($this->_data["module"]."/layout/layout",$this->_data);
    }

        /**
	 * @author     [IVS] Nguyen Van Vui
	 * @name 	work_after
	 * @todo 	search work results
	 * @param
	 * @return
	 */

    function work_after() {
        $start = 0;
        $where='';

        //get values
        $txtEmail=trim($this->input->post('txtEmail'));
        $txtStoreName=trim($this->input->post('txtStoreName'));
        $txtUserId=trim($this->input->post('txtUserId'));
        $txtUserName=trim($this->input->post('txtUserName'));
        $txtApplicationDateFrom=$this->input->post('txtApplicationDateFrom');
        $txtApplicationDateTo=$this->input->post('txtApplicationDateTo');
        $cbSelect=$this->input->post('cbSelect');
        $ckCheck=$this->input->post('ckCheck');
        //start set conditions
        if($txtEmail!=""){
            $where.=" AND ow.`email_address` LIKE '%".$this->db->escape_like_str($txtEmail)."%' ";
        }
        if($txtStoreName!=""){
            $where.=" AND ow.`storename` LIKE '%".$this->db->escape_like_str($txtStoreName)."%' ";
        }
        if($txtUserId!=""){
            $where.=" AND us.`unique_id` LIKE '%".$this->db->escape_like_str($txtUserId)."%' ";
        }
        if($txtUserName!=""){
            $where.=" AND us.`name` LIKE '%".$this->db->escape_like_str($txtUserName)."%' ";
        }
        if($txtApplicationDateFrom !=""){
            $where.=" AND DATE_FORMAT(up.`request_money_date`,'%Y/%m/%d') >= '".$this->db->escape_str($txtApplicationDateFrom)."' ";
        }
        if($txtApplicationDateTo!=""){
            $where.=" AND DATE_FORMAT(up.`request_money_date`,'%Y/%m/%d') <= '".$this->db->escape_str($txtApplicationDateTo)."' ";
        }
        if($cbSelect!=0){
            $where.=" AND up.`user_payment_status` = ".$this->db->escape_str($cbSelect);
        }
        if($ckCheck==1){
            $where.=" AND up.`user_payment_status` = 5 AND CURRENT_TIMESTAMP > DATE_ADD(up.`request_money_date`,INTERVAL 7 DAY) ";
        }
        //end set conditions

        $this->load->Model("admin/Msearch");
        $totalNumber=$this->Msearch->countWork($where);
        //Start Page
        $config['base_url'] = base_url('index.php/admin/search/work_after');
        $config['total_rows'] = $totalNumber;
        $config['constant_num_links'] = TRUE;
        $config['uri_segment']=4;
        $config["per_page"]=$this->config->item('per_page');
        $this->pagination->initialize($config);
        $start1 = $this->uri->segment(4);
        if($start1!=NULL) $start=$start1;
        $this->_data["records"]=$this->Msearch->search_work($where,$config['per_page'],$start);
        //End page
        $this->_data["totalNumber"]=$totalNumber;
        $this->_data["loadPage"]="search/work";
        $this->_data["titlePage"]="勤務申請一覧";
        //paging by ajax
        if($this->input->post('ajax')!=null){
           $this->load->view("search/work",$this->_data);
        }else{
            $this->load->view($this->_data["module"]."/layout/layout",$this->_data);
        }
    }

    /**
	 * @author  [IVS] Nguyen Hoai Nam
	 * @name 	application
	 * @todo 	load page
	 * @param
	 * @return
	*/
    public function application(){
        $this->_data["email"]=null;
        $this->_data["name"]=null;
        $this->_data["user_id"]=null;
        $this->_data["user_name"]=null;
        $this->_data["dateFrom"]=null;
        $this->_data["dateTo"]=null;
        $this->_data["info"] = null;
        $this->_data["val"] = 10;
        $this->_data["sum"] = 0;
        $this->_data["flag"] = 0;
        $this->_data["loadPage"]="search/application";
        $this->_data["titlePage"]="応募一覧";
        $this->load->view($this->_data["module"]."/layout/layout",$this->_data);
    }

    /**
	 * @author  [IVS] Nguyen Hoai Nam
	 * @name 	searchApplicationAfter
	 * @todo 	show data
	 * @param
	 * @return
	*/
    public function searchApplicationAfter(){
        $email = null;
        $name = null;
        $user_id = null;
        $user_name = null;
        $dateFrom = null;
        $dateTo = null;
        $val = 10;
        if(isset($_POST["txtOwnerEmail"])){
            $email = $_POST["txtOwnerEmail"];
        }
        if(isset($_POST["txtOwnerName"])){
            $name = $_POST["txtOwnerName"];
        }
        if(isset($_POST["txtUserId"])){
            $user_id = $_POST["txtUserId"];
        }
        if(isset($_POST["txtUserName"])){
            $user_name = $_POST["txtUserName"];
        }
        if(isset($_POST["txtDateFrom"])){
            $dateFrom = $_POST["txtDateFrom"];
        }
        if(isset($_POST["txtDateTo"])){
            $dateTo = $_POST["txtDateTo"];
        }
        if(isset($_POST["selectList"])){
            $val = $_POST["selectList"];
        }
        $this->_data["email"] = $email;
        $this->_data["name"] = $name;
        $this->_data["user_id"] = $user_id;
        $this->_data["user_name"] = $user_name;
        $this->_data["dateFrom"] = $dateFrom;
        $this->_data["dateTo"] = $dateTo;
        $this->_data["val"] = $val;
        $this->_data["flag"] = 1;
        $start = 0;
        $this->load->Model("admin/Msearch");
        $sql = $this->Msearch->getSearchApplicationQuery($email, $name, $user_id, $user_name, $dateFrom, $dateTo, $val);
        //get totalRows
        $countRows  = $this->Msearch->countDataByQuery($sql);
        //init config to paging
        $config['base_url'] = base_url().'admin/search/searchApplicationAfter';
        $config['total_rows'] = $countRows;
        $config['constant_num_links'] = TRUE;
        $config['uri_segment']=4;
        $config["per_page"]=$this->config->item('per_page');
        $this->load->library("pagination",$config);
        $this->pagination->initialize($config);
        //start1 has value after clicking paging link
        $start1 = $this->uri->segment(4);
        if($start1 != ""){
            $start = $start1;
        }
        //data_info show data with paging
        $this->_data["info"] = $this->Msearch->getResultSearchApplication($sql, $config['per_page'], $start);
        $this->pagination->create_links();

        $this->_data["sum"] = $countRows;
        $this->_data["loadPage"]="search/application";
        $this->_data["titlePage"]="応募一覧";
        //paging by ajax
        if($this->input->post('ajax')!=null){
           $this->load->view("search/application",$this->_data);
        }else{
            $this->load->view($this->_data["module"]."/layout/layout",$this->_data);
        }
    }
     /**
	 * @author  [IVS] Nguyen Minh Ngoc
	 * @name 	complete
	 * @todo 	note successful
	 * @param
	 * @return
	*/
    public function complete(){
        $this->_data["loadPage"]="search/note_complete";
        $this->_data["titlePage"]="joyspe管理画面";
        $this->load->view($this->_data["module"]."/layout/layout",$this->_data);
    }

    /**
	 * @author  [IVS] Nguyen Minh Ngoc
	 * @name 	do_updateUser
	 * @todo 	to do upade user when validate successful
	 * @param
	 * @return
	*/
    public function do_updateUser(){
        $uid=$_POST["id"];
        //$this->load->Model("admin/Msearch");
        $pass=  base64_encode($this->input->post("txtpass"));
        $status=$this->input->post("txtstatus");
        $old_id=$this->input->post("txtOldID");
        $uname=$this->input->post("txtUname");
        $email=$this->input->post("txtemail");
        $birthday=$this->input->post("txtbirthday");
        $charge=$this->input->post("txtcharge");
        $bank=$this->input->post("txtbankname");
        $bankkana=$this->input->post("txtbankkana");
        $ac_type=$this->input->post("txtac_type");
        $ac_no=$this->input->post("txtacountno");
        $ac_name=$this->input->post("txtaccountname");
        $getmail=$this->input->post("txtgetmail");
        $memo=$this->input->post("txtmemo");
        $telephone_number = $this->input->post('txttelephone');
        $phone_document = ($this->input->post('txttelrecord')== '') ? NULL : $this->input->post('txttelrecord');
        $image1=$_POST['img1'];
        $image2=$_POST['img2'];
        //get current time
        $time = date("Y-m-d-H-i-s");
        $this->load->Model("admin/Msearch");
        $st=$this->Msearch->showStatus($uid);
        foreach ($st as $stt){
            $statustable =$stt["user_status"];
        }
        if($status==1 && $statustable == 0){
            $url=base_url()."user/joyspe_user/company/sign_up";
            //send email
           $this->common->sendMail('', '','',array('us02'),'','',$uid,'','','','',$url,'');
           //update user
           $this->Msearch->updateUS($uid,$pass,$status,$email,$birthday,$charge,$bank,$bankkana,$ac_type,$ac_no,$ac_name,$getmail,$memo,$image1,$image2,$time,$time,$uname,$old_id,$telephone_number,$phone_document);
        }else{
           $this->Msearch->updateUSSub($uid,$pass,$status,$email,$birthday,$charge,$bank,$bankkana,$ac_type,$ac_no,$ac_name,$getmail,$memo,$image1,$image2,$time,$uname,$old_id,$telephone_number,$phone_document);
        }
        if(isset($_POST["img1"]) && $_POST["img2"]=="")
        {
            $temp = explode("/",$_POST["img1"]);
            $path= $this->config->item('upload_userdir')."/images/".$temp[0];
            $path_del= $this->config->item('upload_userdir')."/tmp/";
            if($temp[0]!=null || $temp[0]!=""){
                $path_del= $this->config->item('upload_userdir')."/tmp/".$temp[0];
            }else{
                $path_del= $this->config->item('upload_userdir')."/tmp/temp";
            }
            if (!file_exists($path)) {
                mkdir($path);
            }
            $this->fileUpload($_POST["img1"],$temp[0],$temp[1]);
            if(is_dir($path_del)){
                $this->deleteFolder($temp[0]);
            }

        }
          if(isset($_POST["img1"]) && isset($_POST["img2"]))
        {
            $temp = explode("/",$_POST["img1"]);
            $path= $this->config->item('upload_userdir')."/images/".$temp[0];
            $path_del= $this->config->item('upload_userdir')."/tmp/";
            if($temp[0]!=null || $temp[0]!=""){
                $path_del= $this->config->item('upload_userdir')."/tmp/".$temp[0];
            }else{
                $path_del= $this->config->item('upload_userdir')."/tmp/temp";
            }
            if (!file_exists($path)) {
                mkdir($path);
            }
            $this->fileUpload($_POST["img1"],$temp[0],$temp[1]);
            //if(is_dir($path_del)){
               // $this->deleteFolder($temp[0]);
            //}

        }
        if(isset($_POST["img2"])){
            $temp = explode("/",$_POST["img2"]);
            $path= $this->config->item('upload_userdir')."/images/".$temp[0];
            $path_del= $this->config->item('upload_userdir')."/tmp/";
            if($temp[0]!=null || $temp[0]!=""){
                $path_del= $this->config->item('upload_userdir')."/tmp/".$temp[0];
            }else{
                $path_del= $this->config->item('upload_userdir')."/tmp/temp";
            }
            if (!file_exists($path)) {
                mkdir($path);
            }
            $this->fileUpload($_POST["img2"],$temp[0],$temp[1]);
            if(is_dir($path_del)){
                $this->deleteFolder($temp[0]);
            }
        }
    }
      /**
     * author: [IVS] Nguyen Minh Ngoc
     * name : fileUpload2
     * todo : upload image into folder images
     * @param null
     * @return null
     */
    public function fileUpload2($fileName,$fname) {

        $path = $this->config->item('upload_owner_dir') . '/images/';

        $this->folderName = $fname;

        if (!is_dir($path . $this->folderName)) {
            mkdir($path . $this->folderName);
        }
        $this->tmpPath = $this->config->item('upload_owner_dir') . '/tmp/';

        copy($this->tmpPath . '/' . $fileName, $path . '/' . $fileName);
    }
    /**
    * author: [IVS] Nguyen Minh Ngoc
    * name : fileUpload2
    * todo : upload image into folder images
    * @param null
    * @return null
    */
    public function deleteFolder2($fname) {

        $this->load->helper("file");

        $this->tmpPath = $this->config->item('upload_owner_dir') . '/tmp/';

        $this->folderName = $fname;

        if (is_dir($this->tmpPath . $this->folderName)) {

            delete_files($this->tmpPath . $this->folderName, true);
            rmdir($this->tmpPath . $this->folderName);
        }
    }
   /**
     * author: [IVS] Nguyen Minh Ngoc
     * name : updateComPro
     * todo : update profile of owner
     * @param null
     * @return null
     */
    public function updateComPro(){
        $this->load->model('owner/Mowner');
        $this->load->model('owner/Mmessage');
        $this->load->Model("admin/Msearch");
        $this->load->Model("admin/Mauthentication");
        $owid = $this->input->post('txtowid');
        //get current time
        $time = date("Y-m-d-H-i-s");
        $created_date = $this->input->post('created_date')." ".date('H:i:s');

        $dataOwnerRecruit = array(
            'owner_id' => $this->input->post('txtowid'),
            'main_image' => $this->input->post('txtmainimg'),
            'image1' => $this->input->post('hdImage1'),
            'image2' => $this->input->post('hdImage2'),
            'image3' => $this->input->post('hdImage3'),
            'image4' => $this->input->post('hdImage4'),
            'image5' => $this->input->post('hdImage5'),
            'image6' => $this->input->post('hdImage6'),
            'company_info' => trim($this->input->post('company_info')),
            'city_group_id' => $this->input->post('city_group_id'),
            'city_id' => $this->input->post('city_id'),
            'town_id' => $this->input->post('town_id'),
            'title' => $this->input->post('title'),
            'work_place' => $this->input->post('work_place'),
            'working_day' => $this->input->post('working_day'),
            'working_time' => $this->input->post('working_time'),
            'how_to_access' => trim($this->input->post('how_to_access')),
            'salary' => trim($this->input->post('salary')),
            'con_to_apply' => trim($this->input->post('con_to_apply')),
            'apply_time' => $this->input->post('apply_time'),
            'apply_tel' => $this->input->post('apply_tel'),
            'apply_emailaddress' => $this->input->post('apply_emailaddress'),
            'home_page_url' => $this->input->post('home_page_url'),
            'line_id' => $this->input->post('line_id'),
            'new_msg_notify_email' => $this->input->post('new_msg_notify_email'),
            'happy_money_id' => $this->Mowner->getZeroHappyMoneyID(), // default set to no happy money
            'scout_pr_text' => $this->input->post('scout_pr_text'),
            'display_flag' => 1,
            'created_date' => $created_date
        );

        $orid = $this->input->post('txtorid');
        $dataOwner = array(
            'storename' => $this->input->post('storename'),
            'address' => $this->input->post('address'),
            'set_send_mail' => $this->input->post('set_send_mail'),
            'public_info_flag' => $this->input->post('public_info_flag'),
            'updated_date' => date("Y-m-d H:i:s")
        );

        //Update owner
        $this->Mowner->updateOwner($dataOwner, $owid);

        //Update owner recruits
        $this->Mowner->updateOwnerRecruits($dataOwnerRecruit, $orid);

        $all_category = $this->input->post('all_category');print_r($all_category);
        $all_category = rtrim($all_category, ",");
        if ($all_category) {
            $all_category = explode(',', $all_category);
        } else {
            $all_category = array();
        }
        
        $this->Mowner->insert_owner_category($all_category, $orid);

        if (isset($_POST['txttreat'])) {
            // Delete owner treatments
            $this->Mmessage->deleteTreatmentsOwners($orid);
            $treat = explode(",", $_POST["txttreat"]);
            foreach ($treat as $key => $value) {
                if($value != '')
                    $this->Msearch->insertTreatmentOwner($orid, $value, $time);
            }
        }
        if (isset($_POST['txtjobtype'])) {
            // Delete owner jobtype
            $this->Mmessage->deleteJobTypeOwners($orid);
            $job = $_POST['txtjobtype'];
            $this->Msearch->insertJobTypeOwner($orid, $job);
        }

        $this->_data["owinfo"] = $this->Mauthentication->showProfile2($orid);

        for ($i = 1; $i <= 6; $i++) {
            if (!empty($_POST['hdImage' . $i])) {
              $this->fileUpload2($_POST['hdImage' . $i], $owid);
            }
        }

        $this->deleteFolder2($orid);

        //send mail
        $set = $this->Msearch->companyStoreEdit($owid);
        foreach ($set as $k=>$item){
            $setsendmail=$item["set_send_mail"];
        }
        if($setsendmail=1){
            // $this->common->sendMail('', '','',array('ow22'),'','',$owid,'','','','','','');
        }
    }

    public function getDataList() {
      $this->load->model('owner/Mowner');
      $this->output->set_content_type('application/json');
      if($_POST['type'] == 'city_group')
        $data = $this->Mowner->getGroupCities($_POST['id']);
      elseif($_POST['type'] == 'city')
        $data = $this->Mowner->getCityTowns($_POST['id']);
      echo json_encode($data);
    }


    /**
    * author: VJS
    * name : fileUploadAjxPic
    * todo : upload profile pic to tmp
    * @return boolean
    */
    public function fileUploadAjxPic($user_id) {
        if( !$user_id ){
            $array = array('error' => "ユーザＩＤが取得できません。") ;
            echo json_encode($array);
            exit;
        }

        $path = $this->config->item('upload_userdir') . 'tmp/';
        if (!is_dir($path)) {
          mkdir($path, 0777, true);
        }

        $this->folderName = $user_id;

        if (!is_dir($path . $this->folderName)) {
            mkdir($path . $this->folderName);
        }

        $config['upload_path'] = $path . $this->folderName;
        $config['allowed_types'] = 'jpeg|jpg|png';
        $config['max_size'] = 4096;
        $config['overwrite'] = true;
        $this->load->library('upload', $config);

        $num = $this->input->post('profile_pic_num');
        switch ($num) {
            case 1:
            if (!$this->upload->do_upload_user("profile_pic_file")) {
                $array = array('error' => substr($this->upload->display_errors(), 3,  strlen($this->upload->display_errors() ) - 7)) ;
                echo json_encode($array);
                die;
            } else {
                $source_image = $path.$this->folderName.'/'.$_FILES['profile_pic_file']['name'] ;
                $fn = $path.$this->folderName.'/'.$_FILES['profile_pic_file']['name'] ;
                $url = base_url() . $this->config->item('upload_userdir') . 'tmp/' . $this->folderName . '/' . $_FILES['profile_pic_file']["name"];
                $fileName = $this->folderName . '/' . $_FILES['profile_pic_file']["name"];
            }
            break;
            case 2:
            if (!$this->upload->do_upload_user("profile_pic_file2")) {
                $array = array('error' => substr($this->upload->display_errors(), 3,  strlen($this->upload->display_errors() ) - 7)) ;
                echo json_encode($array);
                die;
            } else {
                $source_image = $path.$this->folderName.'/'.$_FILES['profile_pic_file2']['name'] ;
                $fn = $path.$this->folderName.'/'.$_FILES['profile_pic_file2']['name'] ;
                $url = base_url() . $this->config->item('upload_userdir') . 'tmp/' . $this->folderName . '/' . $_FILES['profile_pic_file2']["name"];
                $fileName = $this->folderName . '/' . $_FILES['profile_pic_file2']["name"];
            }
            break;
            case 3:
            if (!$this->upload->do_upload_user("profile_pic_file3")) {
                $array = array('error' => substr($this->upload->display_errors(), 3,  strlen($this->upload->display_errors() ) - 7)) ;
                echo json_encode($array);
                die;
            } else {
                $source_image = $path.$this->folderName.'/'.$_FILES['profile_pic_file3']['name'] ;
                $fn = $path.$this->folderName.'/'.$_FILES['profile_pic_file3']['name'] ;
                $url = base_url() . $this->config->item('upload_userdir') . 'tmp/' . $this->folderName . '/' . $_FILES['profile_pic_file3']["name"];
                $fileName = $this->folderName . '/' . $_FILES['profile_pic_file3']["name"];
            }
            break;
        }

        $config['image_library'] = 'gd2';
        $config['source_image'] = $source_image;
        $config['maintain_ratio'] = FALSE;
        $size = getimagesize($fn);
        $ratio = $size[0]/$size[1];// width/height
//        $config['height'] = 90;
//        $config['width'] = 90*$ratio;
        $config['height'] = 270;
        $config['width'] = 270*$ratio;
        $this->load->library('image_lib', $config);
        $this->image_lib->resize();

        $array = array('url' => $url, 'fileName' => $fileName);
        echo json_encode($array);
    }
    /**
    * author: VJS
    * name : updateProfilePic
    * todo : upload profile pic
    * @return null
    */
    public function updateProfilePic($userid){
        $udata = array();
        $array = array();
        $json = array();
        $ret = false;
        $profile_path = $this->input->post('profile_pic_file_path');

        $num = $this->input->post('profile_pic_num');
        switch($num){
            case 1:
                $profile_path = $this->input->post('profile_pic_file_path');
                $dataname = 'profile_pic';
                $name = 'profile_pic_file';
                $profile_pic_file_path = 'profile_pic_file_path';
                break;
            case 2:
                $profile_path = $this->input->post('profile_pic_file_path2');
                $dataname = 'profile_pic2';
                $name = 'profile_pic_file2';
                $profile_pic_file_path = 'profile_pic_file_path2';
                break;
            case 3:
                $profile_path = $this->input->post('profile_pic_file_path3');
                $dataname = 'profile_pic3';
                $name = 'profile_pic_file3';
                $profile_pic_file_path = 'profile_pic_file_path3';
                break;
        }

        $file_name = "";
        if($profile_path){
            $file_name = substr(strstr($profile_path, 'tmp/'), 4);
            $this->common->fileUpload($file_name,false,$userid); //copy file from /tmp to /images
            // delete files from /tmp folder
            $this->common->deleteFolder(false,$userid);

            // update profile path in DB
            if($file_name){
                if ( !$userid ){
                    $userid = UserControl::getId();
                }

                $udata[$dataname] = $file_name;
                $ret = $this->Musers->update_User($udata, $userid);
            }

            if ( $ret == false ){
                break;
            }elseif($profile_path != ""){
                $array[$dataname] = base_url() . $this->config->item('upload_userdir').'images/'.$file_name;
                $src = base_url() . $this->config->item('upload_userdir').'images/'.$file_name;
            }
        }

        if($ret == false){
            $array = array('error'=>"プロフィル写真の更新が失敗しました。");
        }else{
            $array["img_id"] = $dataname;
            $array["src"] = $src;
            $array["name"] = $name;
            $array["path"] = $profile_pic_file_path;
        }
        echo json_encode($array);
    }
    /**
    * author: VJS
    * name : deleteProfilePic
    * todo : delete profile pic
    * @return null
    */
    public function deleteProfilePic($userid){
        $ret = false;
        if ( !$userid ){
            $array = array('error'=>"プロフィル写真の削除が失敗しました。ユーザＩＤが取得できません");
            echo json_encode($array);
            exit;
        }
        //　Get the current profile file path
        $user_data = $this->Musers->get_users($userid);
        $old_profile_path = "";
        if ( $user_data ){
            //$old_profile_path = $user_data['profile_pic'];
            //$old_profile_path = FCPATH . $this->config->item('upload_userdir').'images/'. $old_profile_path;
            $num = $this->input->post('profile_pic_num');
            switch($num){
            case 1:
                $dataname = 'profile_pic';
                $profile_pic_file_path = 'profile_pic_file_path';
                $old_profile_path = $user_data['profile_pic'];
                $old_profile_path = FCPATH . $this->config->item('upload_userdir').'images/'. $old_profile_path;
                break;
            case 2:
                $dataname = 'profile_pic2';
                $profile_pic_file_path = 'profile_pic_file_path2';
                $old_profile_path = $user_data['profile_pic2'];
                $old_profile_path = FCPATH . $this->config->item('upload_userdir').'images/'. $old_profile_path;
                break;
            case 3:
                $dataname = 'profile_pic3';
                $profile_pic_file_path = 'profile_pic_file_path3';
                $old_profile_path = $user_data['profile_pic3'];
                $old_profile_path = FCPATH . $this->config->item('upload_userdir').'images/'. $old_profile_path;
                break;
            }
        }
        // Update DB
        $udata = array(
            $dataname => "",
        );
        $ret = $this->Musers->update_User($udata, $userid);
        if ( $ret ){
            // Delete file from disk
            if ( $old_profile_path ){
                if ( file_exists($old_profile_path) ){
                    unlink($old_profile_path);
                }
            }
        }

        if ( $ret == false ){
            $array = array('error'=>"プロフィル写真の削除が失敗しました。");
        }else{
            $array = array('url'=> base_url() . "public/user/image/no_image.jpg");
        }
        echo json_encode($array);
    }
    /**
     * author: [IVS] Nguyen Bao Trieu
     * name : happyMoneyPayUser
     * todo : happy Money Pay User
     * @param null
     * @return null
     */
    public function happyMoneyPayUser() {
        $happymoney_id = $_POST['id'];
        $this->load->model('owner/Mowner');
        $this->data = $this->Mowner->getHappyMoneyPayUser($happymoney_id);
        if ( $this->data ){
            echo json_encode(array('user_happy_money'=>number_format($this->data['user_happy_money'])));
        }
        die;
    }

    /**
     * author: [IVS] Nguyen Bao Trieu
     * name : happyMoneyPayUser
     * todo : happy Money Pay User
     * @param null
     * @return null
     */
    public function get_owner_town_category() {
      $this->load->model('owner/Mowner');



      echo json_encode($data);
    }

    public function downloadSearchCsv(){
        //Download CSV
        $txtDateFrom = trim($this->input->post('txtDateFrom'));
        $txtDateTo = trim($this->input->post('txtDateTo'));
        $this->load->Model("admin/Mlog");
        $result_array = unserialize(urldecode($_GET['result_array']));
        $where = '';


            $txtEmail=trim($result_array['txtEmail']);
            $txtStoreName=trim($result_array['txtStoreName']);
            $txtPic=trim($result_array['txtPic']);
            $txtIP=trim($result_array['txtIP']);
            $txtTel=trim($result_array['txtTel']);
            $txtTempRegDateFrom=trim($result_array['txtTempRegDateFrom']);
            $txtTempRegDateTo=trim($result_array['txtTempRegDateTo']);
            $txtCreatedDateFrom=trim($result_array['txtCreatedDateFrom']);
            $txtCreatedDateTo=trim($result_array['txtCreatedDateTo']);
            $txtAddress=trim($result_array['txtAddress']);
            $txtMemo=trim($result_array['txtMemo']);
            $cbOwnerStatus=trim($result_array['cbOwnerStatus']);
            $cbCreditResult=trim($result_array['cbCreditResult']);
            $rdPublicFlag=trim($result_array['rdPublicFlag']);
            $cbWebsite=trim($result_array['cbWebsite']);

            //set conditions
            if($txtEmail!=""){
                $where.=" AND ow.`email_address` LIKE '%".$this->db->escape_like_str($txtEmail)."%' ";
            }
            if($txtStoreName!=""){
                $where.=" AND ow.`storename` LIKE '%".$this->db->escape_like_str($txtStoreName)."%' ";
            }
            if($txtPic!=""){
                $where.=" AND ow.`pic` LIKE '%".$this->db->escape_like_str($txtPic)."%' ";
            }
            if($txtTel!=""){
                $where.=" AND ow.`tel` LIKE '%".$this->db->escape_like_str($txtTel)."%' ";
            }
            if($txtIP!=""){
                $where.=" AND ow.`ip_address` LIKE '%".$this->db->escape_like_str($txtIP)."%' ";
            }
            if($txtTempRegDateFrom !=""){
                $where.=" AND DATE_FORMAT(ow.`temp_reg_date`,'%Y/%m/%d') >= '".$this->db->escape_str($txtTempRegDateFrom)."' ";
            }
            if($txtTempRegDateTo!=""){
                $where.=" AND DATE_FORMAT(ow.`temp_reg_date`,'%Y/%m/%d') <= '".$this->db->escape_str($txtTempRegDateTo)."' ";
            }
            if($txtCreatedDateFrom !=""){
                $where.=" AND DATE_FORMAT(ow.`offcial_reg_date`,'%Y/%m/%d') >= '".$this->db->escape_str($txtCreatedDateFrom)."' ";
            }
            if($txtCreatedDateTo!=""){
                $where.=" AND DATE_FORMAT(ow.`offcial_reg_date`,'%Y/%m/%d') <= '".$this->db->escape_str($txtCreatedDateTo)."' ";
            }
            if($txtAddress!=""){
                $where.=" AND ow.`address` LIKE '%".$this->db->escape_like_str($txtAddress)."%' ";
            }
            if($txtMemo!=""){
                $where.=" AND ow.`memo` LIKE '%".$this->db->escape_like_str($txtMemo)."%' ";
            }
            if($cbOwnerStatus!=""){
                if($cbOwnerStatus!=-1){
                    $where.=" AND ow.`owner_status` = ".$this->db->escape_str($cbOwnerStatus);
                }
            }
            if($cbCreditResult!=""){
                if($cbCreditResult==2){
                    $where.=" AND ow.`magazine_status` = 1 ";
                }elseif ($cbCreditResult==3) {
                    $where.=" AND ow.`magazine_status` = 0 ";
                }
            }

            if($rdPublicFlag != ""){
                if($rdPublicFlag == 1){
                    $where.=" AND ow.`public_info_flag` = 1 ";
                }elseif ($rdPublicFlag == 0) {
                    $where.=" AND ow.`public_info_flag` = 0 ";
                }
            }

            if($cbWebsite!=""){
                if($cbWebsite!=0 && $cbWebsite!=-1){
                    $where.=" AND ow.`website_id` = ".$this->db->escape_str($cbWebsite);
                }
            }
            $this->load->Model("admin/Msearch");
            $this->_data["listWebsite"]=$this->Msearch->listWebsite();

            $totalNumber = 0;
            $getOwners = $this->Msearch->search_company($where);

        $data = array();
        $result = array( ' 店舗ID', '店舗名 ', 'アドレス');            
        array_push($data, $result);
        foreach ($getOwners as $value) {              
            $result = array($value['unique_id'], $value['storename'], $value['email_address']);
            array_push($data, $result);
        }
        $str=$this->_arrayToCsv($data);
        $this->load->helper('download');
        $nameFile="results_".date("Ymd").".csv";
        force_download($nameFile, $str);
    }

    private function _arrayToCsv( array $fields, $delimiter = ',', $enclosure = '"', $encloseAll = false, $nullToMysqlNull = false ) {
        $delimiter_esc = preg_quote($delimiter, '/');
        $enclosure_esc = preg_quote($enclosure, '/');

        $outputString = "";
        foreach($fields as $tempFields) {
            $output = array();
            foreach ( $tempFields as $field ) {
                if ($field === null && $nullToMysqlNull) {
                    $output[] = 'NULL';
                    continue;
                }

                // Enclose fields containing $delimiter, $enclosure or whitespace
                if ( $encloseAll || preg_match( "/(?:${delimiter_esc}|${enclosure_esc}|\s)/", $field ) ) {
                    $field = $enclosure . str_replace($enclosure, $enclosure . $enclosure, $field) . $enclosure;
                }
                $output[] = $field." ";
            }
            $outputString .= implode( $delimiter, $output )."\r\n";
        }
        return mb_convert_encoding($outputString,'Shift-JIS','UTF-8');  
    }
}
?>

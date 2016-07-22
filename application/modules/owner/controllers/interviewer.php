<?php

class Interviewer extends MX_Controller {
    private $data;
    public function __construct() {
        parent::__construct();
        $this->load->Model('owner/mowner');
        $this->load->model('owner/Musers');
        $this->load->model('owner/muser');
        $this->load->model('owner/mspeciality');
        $this->load->model('owner/mbenefits');
        $this->load->model('owner/mjobexplanation');
        $this->load->model('owner/muserstatistics');
        $this->common = new Common();
        $this->data['module'] = $this->router->fetch_module();
        $this->form_validation->CI = & $this;
        $this->output->set_header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate");
        $this->output->set_header("Cache-Control: post-check=0, pre-check=0");
        $this->output->set_header("Pragma: no-cache");
        if (!OwnerControl::LoggedIn()) {
            redirect(base_url() . "owner/login/");
        }
    }

    public function index() {
        $this->data['title'] = 'joyspe | 未経験者向け登録';
        $this->data['error_upload']=0;
        $this->data['success'] = 0;
        $config = array();
        $owner_id = OwnerControl::getId();
        $interviewer = $this->Musers->hasInterviewer($owner_id);
        $speciality = $this->mspeciality->get_owner_speciality($owner_id);
        $job_explanation = $this->mjobexplanation->get_owner_job_explanation($owner_id);
        $working_days_info = $this->mjobexplanation->get_working_days($owner_id);
        $statistics = $this->muserstatistics->get_user_statistics($owner_id);
        $existingInterviewer = $this->Musers->getExistingInterviewer($owner_id);
        $senior_profile_info = $this->Musers->get_senior_profile($owner_id);
        $benefits = $this->mbenefits->get_owner_benefits($owner_id);
        $owner_recruit = $this->mowner->getOwnerRecruit($owner_id);
        $user_character = $this->Musers->get_user_character($owner_recruit['id']);
        $save_all_data = $this->input->post('save_all_data');
        $new_user_character_array = array();
        if (count($user_character) > 0) {
            foreach ($user_character as $character) {
                $new_user_character_array[$character['id']] = $character; // set ID to array key
            }
        }

        $all_user_characters = $this->Musers->get_all_user_characters();

        if ($this->input->post()) {
            if (isset($_POST['senior_profile'])) {
                $this->_senior_profile($owner_id, $senior_profile_info, $interviewer);
            }

            if (isset($_POST['statistics'])) {
                 $this->_statistics($owner_id);
            }

            if (isset($_POST['jobexplanation'])) {
                $this->_jobexplanation($owner_id, $job_explanation, $working_days_info, $interviewer);
            }

            if (isset($_POST['speciality'])) {
                $this->_speciality($owner_id, $speciality, $interviewer);
            }

            if (isset($_POST['benefits'])) {
                $this->_benefits($owner_id);
            }

            if (isset($_POST['interviewer'])) {
                $this->_interviewer($owner_id, $interviewer, $existingInterviewer);
            }

            if (isset($_POST['treatment'])) {
                $this->_treatment($owner_recruit['id']);
            }

            HelperApp::add_session('interviewer_success', true);
            if ($save_all_data == false) {
                redirect(base_url() . 'owner/interviewer');
            }
        }
        if ($save_all_data == false) {
            $faq_messages = $this->Musers->faq_messages_by_owner($owner_id);
            $this->data['total_senior_profile'] = TOTAL_SENIOR_PROFILE;
            $this->data['interviewer_success'] = HelperApp::get_session('interviewer_success') ? HelperApp::get_session('interviewer_success'): false;
            $this->data['user_character'] = $new_user_character_array;
            $this->data['all_user_characters'] = $all_user_characters;
            $this->data['faq_messages'] = $faq_messages;
            $this->data['job_explanation'] = $job_explanation;
            $this->data['statistics'] = $statistics;
            $this->data['speciality'] = $speciality;
            $this->data['interviewer'] = $existingInterviewer;
            $this->data['senior_profile_info'] = $senior_profile_info;
            $this->data['working_days_info'] = $working_days_info;
            $this->data['benefits'] = $benefits;
            $this->data['loadPage'] = 'interviewer/interviewer';
            $this->load->view($this->data['module'].'/layout/layout_A',$this->data);
            HelperApp::remove_session('interviewer_success');
        }
    }

    private function _treatment($id){
        $treatments = $this->input->post('treatments');
        $this->Musers->delete_user_characters($id);
        for($x=0; $x < count($treatments); $x++) {
            if ($treatments[$x]){
                $data = array(
                    'owner_recruit_id' => $id,
                    'character_id' => $treatments[$x]
                );
                $this->Musers->insert_user_characters($data);
            }

        }
    }

    private function _senior_profile($owner_id, $senior_profile_info, $interviewer){
        $path_senior_photo = $this->config->item('upload_owner_dir').'senior_photos/';
        $files = $_FILES;
        $count_senior_photo = count($_FILES['senior_photo']['name']);
        $monthly_income = $this->input->post('monthly_income');
        $service_length = $this->input->post('service_length');
        $senior_age = $this->input->post('senior_age');
        $monthly_work_days = $this->input->post('monthly_work_days');
        $work_experience = $this->input->post('work_experience');
        $senior_comment = $this->input->post('senior_comment');

        if (!is_dir($path_senior_photo)) {
          mkdir($path_senior_photo, 0777, true);
        }
        $this->Musers->delete_senior_profile($owner_id);
        for($x = 0; $x < TOTAL_SENIOR_PROFILE; $x++) {
            if($files['senior_photo']['name'][$x] == null && $monthly_income[$x] == null && $service_length[$x] == null && $senior_age[$x] == null && $monthly_work_days[$x] == null && $work_experience[$x] == null && $senior_comment[$x] == null){
                continue;
            }

            $i = 0;
            $possible_keys = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
            $keys_length = strlen($possible_keys);
            $flname_senior_photo = '';
            while($i < 10) {
                $rand_senior_photo = mt_rand(1,$keys_length-1);
                $flname_senior_photo .= $possible_keys[$rand_senior_photo];
                $i++;
            }

            $_FILES['senior_photo']['name'] = $files['senior_photo']['name'][$x];
            $_FILES['senior_photo']['type'] = $files['senior_photo']['type'][$x];
            $_FILES['senior_photo']['tmp_name'] = $files['senior_photo']['tmp_name'][$x];
            $_FILES['senior_photo']['error'] = $files['senior_photo']['error'][$x];
            $_FILES['senior_photo']['size'] = $files['senior_photo']['size'][$x];
            if (($_FILES['senior_photo']['name'])) {
                $existing_pic = ($interviewer['counts']< 1) ? '' : str_replace('public/owner/uploads/senior_photos/','',(isset($senior_profile_info[$x]['senior_photo'])? $senior_profile_info[$x]['senior_photo']: ''));
                $fltype = (!empty($_FILES['senior_photo']['name']))? $_FILES['senior_photo']['name'] : $existing_pic;
                $ext_senior_photo = pathinfo($fltype, PATHINFO_EXTENSION);
                $this->_upload_file($flname_senior_photo, $ext_senior_photo, $path_senior_photo, $_FILES['senior_photo']['name'], 'senior_photo', $interviewer['counts'], (isset($senior_profile_info[$x]['senior_photo'])? $senior_profile_info[$x]['senior_photo']: ''));
            }

            $data = array(
                'owner_id' => $owner_id,
                'senior_photo' => (!empty($_FILES['senior_photo']['name'])) ? $path_senior_photo . $flname_senior_photo . '.' . $ext_senior_photo : (isset($senior_profile_info[$x]['senior_photo'])? $senior_profile_info[$x]['senior_photo']: ''),
                'monthly_income' => $monthly_income[$x],
                'service_length' => $service_length[$x],
                'senior_age' => $senior_age[$x],
                'monthly_work_days' => $monthly_work_days[$x],
                'work_experience' => $work_experience[$x],
                'comment' => $senior_comment[$x],
                'created_date' => date("Y-m-d H:i:s")
            );
            $this->Musers->insert_senior_profile($data);

        }

    }

    private function _statistics($owner_id){
        $this->muserstatistics->delete_user_statistics($owner_id);
        $user_percent = $this->input->post('user_percent');
        $data_content = $this->input->post('data_content');
        for($x = 0; $x < count($user_percent); $x++) {
                $data = array(
                    'owner_id' => $owner_id,
                    'user_percent' => $user_percent[$x],
                    'created_date' => date("Y-m-d H:i:s")
                );
                $this->muserstatistics->insert_user_statistics($data);

        }
        $data = array(
            'owner_id' => $owner_id,
            'content' => $data_content,
            'created_date' => date("Y-m-d H:i:s")
        );
        $this->muserstatistics->insert_user_statistics($data);
    }

    private function _jobexplanation($owner_id, $job_explanation, $working_days_info, $interviewer){
        $path = $this->config->item('upload_owner_dir').'working_day_info_photos/';
        $working_day_description = $this->input->post('working_day_description');
        if (!is_dir($path)) {
          mkdir($path, 0777, true);
        }
        $files = $_FILES;
        $count_working_day_pic = count($_FILES['working_day_pic']['name']);
        $this->mjobexplanation->delete_working_days($owner_id);
        for($x = 0; $x<$count_working_day_pic; $x++) {
            $i = 0;
            $possible_keys = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
            $keys_length = strlen($possible_keys);
            $flname = "";
            while($i < 10) {
                $rand = mt_rand(1,$keys_length-1);
                $flname .= $possible_keys[$rand];
                $i++;
            }

            $_FILES['working_day_pic']['name'] = $files['working_day_pic']['name'][$x];
            $_FILES['working_day_pic']['type'] = $files['working_day_pic']['type'][$x];
            $_FILES['working_day_pic']['tmp_name'] = $files['working_day_pic']['tmp_name'][$x];
            $_FILES['working_day_pic']['error'] = $files['working_day_pic']['error'][$x];
            $_FILES['working_day_pic']['size'] = $files['working_day_pic']['size'][$x];
            if (($working_day_description[$x]) || (isset($working_days_info[$x]['working_day_pic']) && $working_day_description[$x])) {
                $existing_pic = ($interviewer['counts']< 1) ? '' : str_replace('public/owner/uploads/working_day_info_photos/','', (isset($working_days_info[$x]['working_day_pic'])? $working_days_info[$x]['working_day_pic']: ''));
                $fltype = (!empty($_FILES['working_day_pic']['name']))? $_FILES['working_day_pic']['name'] : $existing_pic;
                $ext = pathinfo($fltype, PATHINFO_EXTENSION);

                if ($working_day_description[$x]) {
                    if(!$count_working_day_pic == 0) {
                        $this->_upload_file($flname, $ext, $path, $_FILES['working_day_pic']['name'], 'working_day_pic', $interviewer['counts'], (isset($working_days_info[$x]['working_day_pic'])? $working_days_info[$x]['working_day_pic']: ''));
                    }
                    $data = array(
                        'owner_id' => $owner_id,
                        'working_day_pic' => (!empty($_FILES['working_day_pic']['name']))?$path.$flname. '.' . $ext : $working_days_info[$x]['working_day_pic'],
                        'working_day_description' => $working_day_description[$x],
                        'created_date' => date("Y-m-d H:i:s")
                    );

                    $this->mjobexplanation->insert_working_days($data);
                }
            }

        }
        $job_description = $this->input->post('job_description');
        $youtube_embed = $this->input->post('youtube_embed');
        $data = array(
            'owner_id' => $owner_id,
            'content' => $job_description,
            'youtube_embed' => $youtube_embed
        );

        if (count($job_explanation)) {
            $this->mjobexplanation->update_owner_job_explanation($owner_id, $data);
        } else {
            $this->mjobexplanation->insert_owner_job_explanation($data);
        }
    }

    private function _speciality($owner_id, $speciality, $interviewer){
        $path = $this->config->item('upload_owner_dir').'speciality_photos/';
        $speciality_content = $this->input->post('speciality_content');
        $prev_pic = $this->input->post('prev_pic');

        if ($prev_pic && !$prev_pic[0]) { // picture is deleted
            $data = array(
                'owner_id' => $owner_id,
                'content' => $speciality_content,
                'photo' => "",
            );
        } else {
            if (!is_dir($path)) {
              mkdir($path, 0777, true);
            }

            $i = 0;
            $possible_keys = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
            $keys_length = strlen($possible_keys);
            $flname = "";
            while($i < 10) {
                $rand = mt_rand(1,$keys_length-1);
                $flname .= $possible_keys[$rand];
                $i++;
            }
            $existing_pic = ($interviewer['counts']< 1) ? '' : str_replace('public/owner/uploads/speciality_photos/','',isset($speciality['photo']) ? $speciality['photo']:'');
            $fltype = (!empty($_FILES['speciality_photo']['name']))? $_FILES['speciality_photo']['name'] : $existing_pic;
            $ext = pathinfo($fltype, PATHINFO_EXTENSION);

            $this->_upload_file($flname, $ext, $path, $_FILES['speciality_photo']['name'], 'speciality_photo', $interviewer['counts'], isset($speciality['photo']) ? $speciality['photo']:'');
            $data = array(
                'owner_id' => $owner_id,
                'content' => $speciality_content,
                'photo' => (!empty($_FILES['speciality_photo']['name']))?$path.$flname . '.' . $ext : $speciality['photo'],
            );
        }

        if (count($speciality)) {
             $this->mspeciality->update_owner_speciality($owner_id, $data);
        } else {
             $this->mspeciality->insert_owner_speciality($data);
        }
    }

    private function _benefits($owner_id){
        $this->mbenefits->delete_owner_benefits($owner_id);
        $benefits_title = $this->input->post('benefits_title');
        $benefits_content = $this->input->post('benefits_content');
        if ($benefits_title && $benefits_content) {
            for($x = 0; $x < count($benefits_title); $x++) {
                if ($benefits_content[$x] && $benefits_title[$x]){
                    $data = array(
                        'owner_id' => $owner_id,
                        'title' => $benefits_title[$x],
                        'content' => $benefits_content[$x],
                        'created_date' => date("Y-m-d H:i:s")
                    );
                    $this->mbenefits->insert_owner_benefits($data);
                }
            }
        }
    }

    private function _interviewer($owner_id, $interviewer, $existingInterviewer){
        $path = $this->config->item('upload_owner_dir').'interviewer_photos/';
        $name = $this->input->post('name');
        $description = $this->input->post('description');
        $age = $this->input->post('age');
        $gender = $this->input->post('gender');
        $hobby = $this->input->post('hobby');

        if (!is_dir($path)) {
          mkdir($path, 0777, true);
        }

        $i = 0;
        $possible_keys = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $keys_length = strlen($possible_keys);
        $flname = "";
        while($i < 10) {
            $rand = mt_rand(1,$keys_length-1);
            $flname .= $possible_keys[$rand];
            $i++;
        }

        $existing_pic = ($interviewer['counts']< 1) ? '' : str_replace('public/owner/uploads/interviewer_photos/','',isset($existingInterviewer['interviewer_photo']) ? $existingInterviewer['interviewer_photo']:'');
        $fltype = (!empty($_FILES['interviewer_pic']['name']))? $_FILES['interviewer_pic']['name'] : $existing_pic;
        $ext = pathinfo($fltype, PATHINFO_EXTENSION);

        $this->_upload_file($flname, $ext, $path, $_FILES['interviewer_pic']['name'], 'interviewer_pic', $interviewer['counts'], isset($existingInterviewer['interviewer_photo']) ? $existingInterviewer['interviewer_photo']:'');
        $data = array(
              'owner_id'          => $owner_id,
              'interviewer_name'  => $name,
              'interviewer_photo' => (!empty($_FILES['interviewer_pic']['name']))?$path.$flname . '.' . $ext:$existingInterviewer['interviewer_photo'],
              'description'       => $description,
              'age'               => $age,
              'gender'            => $gender[0],
              'hobby'             => $hobby
            );

        if ($interviewer['counts'] > 0) {
            $this->mowner->updateInterviewer($data,$owner_id);
        } elseif($interviewer['counts'] < 1) {
            $this->mowner->interviewer($data);
        }
    }

    public function validation_interview() {
        $err = array();
        $prev_pic = $this->input->post('prev_pic');
        $notinputed = true;
        $noimage = '画像を選択してください';
        if (isset($_POST['senior_profile'])) {
            $monthly_income = $this->input->post('monthly_income');
            $service_length = $this->input->post('service_length');
            $senior_age = $this->input->post('senior_age');
            $monthly_work_days = $this->input->post('monthly_work_days');
            $work_experience = $this->input->post('work_experience');
            $senior_comment = $this->input->post('senior_comment');
            for ($i=0; $i < TOTAL_SENIOR_PROFILE; $i++) {
                if ($prev_pic[$i] == null && $monthly_income[$i] == null && $service_length[$i] == null && $senior_age[$i] == null && $monthly_work_days[$i] == null && $work_experience[$i] == null && $senior_comment[$i] == null) {
                    continue;
                }

                $notinputed = false;
                if (!$prev_pic[$i]) {
                    $err[] = $noimage;
                }

                if ($monthly_income[$i] == null) {
                    $this->form_validation->set_rules('monthly_income['. $i.']', '月収', 'trim|checkSelect');
                }

                if ($service_length[$i] == null) {
                    $this->form_validation->set_rules('service_length['. $i.']', '勤続期間', 'trim|checkSelect');
                }

                if ($senior_age[$i] == null) {
                    $this->form_validation->set_rules('senior_age['. $i.']', '年齢', 'trim|checkSelect');
                }

                if ($monthly_work_days[$i] == null) {
                    $this->form_validation->set_rules('monthly_work_days['. $i.']', '月間勤務日数', 'trim|checkSelect');
                }

                if ($work_experience[$i] == null) {
                    $this->form_validation->set_rules('work_experience['. $i.']', '風俗勤務経験', 'trim|checkSelect');
                }

                if ($senior_comment[$i] == null || mb_strlen($senior_comment[$i]) > 150) {
                    $this->form_validation->set_rules('senior_comment['. $i.']', 'コメント', 'trim|required|max_length[150]');
                }

            }

        }

        if (isset($_POST['statistics'])) {
            $this->form_validation->set_rules('data_content', '補足文章', 'trim|required|max_length[50]');
            $notinputed = false;
        }

        if (isset($_POST['jobexplanation'])) {
            
            $this->form_validation->set_rules('job_description', 'お仕事説明', 'trim|required|max_length[200]');
            $this->form_validation->set_rules('youtube_embed', 'お仕事動画', 'trim');
            $prev_pic = $this->input->post('prev_pic');
            $working_day_description = $this->input->post('working_day_description');
            $notinputed = false;
            for ($i=0; $i < count($prev_pic); $i++) {
                $step_no = $i+1;
                if (!$prev_pic[$i] && !$working_day_description[$i]) {
                    continue;
                }
               /* if (!$prev_pic[$i]) {
                    $err[] = "ステップ" . $step_no . "の" . $noimage;
                }*/
                $this->form_validation->set_rules('working_day_description['. $i . ']' , "ステップ" . $step_no . "の文章", 'trim|required|max_length[50]');
                if (!$this->form_validation->run() || !$prev_pic[$i]) {
                    break;
                }
            }
        }

        if (isset($_POST['speciality'])) {
            $this->form_validation->set_rules('speciality_content', '当店はここが違う', 'trim|required|max_length[150]');
            $notinputed = false;
        }

        if (isset($_POST['benefits'])) {
            $benefits_title = $this->input->post('benefits_title');
            $benefits_content = $this->input->post('benefits_content');
            for ($i=0; $i < count($benefits_title) ; $i++) {
                if (!$benefits_title[$i] && !$benefits_content[$i]) {
                    continue;
                }

                $this->form_validation->set_rules('benefits_title['. $i.']', 'タイトル', 'trim|required|max_length[10]');
                $this->form_validation->set_rules('benefits_content['. $i.']', '文章', 'trim|required|max_length[50]');
                $notinputed = false;
                if (!$this->form_validation->run() && !$prev_pic[$i]) {
                    break;
                }

            }
        }

        if (isset($_POST['interviewer'])) {
            if (!$prev_pic[0]) {
                $err[] = $noimage;
            }
            $this->form_validation->set_rules('name', '名前', 'trim|required');
            $this->form_validation->set_rules('description', '簡単な説明/コメント ', 'trim|required');
            $this->form_validation->set_rules('age', '年齢', 'trim|required');
            $this->form_validation->set_rules('gender[0]', '性別', 'trim|required|checkSelect');
            $this->form_validation->set_rules('hobby', '趣味', 'trim|required|max_length[200]');
            $notinputed = false;
        }

        if ($notinputed) {
            $err[] = "必須の項目をご記入ください。";
        }
        if (!$this->form_validation->run()) {
            $err[] = validation_errors();
        }

        $err = array_filter($err);
        echo json_encode($err);
    }

    /**
     * Upload image in certain folder
     *
     * @param   string file name, string file extention, string folder path, string image name,
     *          string upload name, int data count, string old image path
     * @return  null
     */
    private function _upload_file($flname, $ext, $path, $pic_name, $data_type, $count, $image_path){
        $this->load->library('image_lib');
        $config = array();
        $config['file_name'] = $flname;
        $config['upload_path'] = $path;
        $config['allowed_types'] = 'jpeg|jpg|png|bmp';
        $config['max_size'] = 4096;
        $config['overwrite'] = true;
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        if (!empty($pic_name)) {
            if (!$this->upload->do_upload_owner($data_type)) {
                $array = array('error' => substr($this->upload->display_errors(), 3,  strlen($this->upload->display_errors() ) - 7)) ;
                $this->data['upload_error']  = $array;
                $this->data['error_upload'] = 1;
            } elseif ($this->upload->do_upload_owner($data_type) && $count > 0) {
                if(file_exists($image_path)) {
                    unlink($image_path);
                }
            }
        }

        $data = $this->upload->data();
        $configThumb = array();
        $configThumb['image_library'] = 'gd2';
        $configThumb['source_image'] = $path.$flname . '.' . $ext;
        $configThumb['maintain_ratio'] = FALSE;
        $configThumb['width'] = 100;
        $configThumb['height'] = 100;

        if($data['is_image'] == 1) {
          $configThumb['source_image'] = $data['full_path'];
          $this->image_lib->initialize($configThumb);
          $this->image_lib->resize();
        }

    }

    public function faq_user_owner_update() {
        $owner_id = OwnerControl::getId();
        $ret = false;
        $msg_id = $this->input->post('msg_id');
        $q_content = $this->input->post('q_content');
        $ans_content = $this->input->post('ans_content');

        $data = array( 'owner_id'           => $owner_id,
                       'question'           => $q_content,
                       'answer'             => $ans_content,
                       'updated_date'       => date('Y-m-d H:i:s')
                );

        if ($msg_id) {
            $ret = $this->Musers->update_faq_messages($msg_id, $data);
        } else {
            $ret = $this->muser->inser_faq_messages($msg_id, false, $data);
        }
        echo json_encode($ret);
    }

    public function faq_user_owner_delete() {
        $ret = false;
        $msg_id = $this->input->post('msg_id');
        $ret = $this->Musers->delete_faq_messages($msg_id);
        echo json_encode($ret);
    }

    public function question_answer(){
        header('Content-Type: text/html; charset=utf-8');
        $owner_id = OwnerControl::getId();
        $count = $this->input->post('page_id');
        if (!$count) {
            $count = 0;
        }

        $all_question_answer = $this->Musers->all_question_answer_limit($owner_id, $count);
        $numrows = $this->Musers->all_question_answer($owner_id);
        $totalpages = ceil($numrows / TOTAL_DISPLAY_FAQ);
        $this->data['totalpages'] = $totalpages;
        $this->data['page'] = $count / TOTAL_DISPLAY_FAQ + 1;
        $this->data['all_question_answer'] = $all_question_answer;
        $this->load->view("owner/interviewer/question_answer", $this->data);
    }

    public function owner_faq_update() {
        $ret = false;
        $msg_id = $this->input->post('msg_id');
        $ret = $this->muser->inser_faq_messages($msg_id, true);
        echo json_encode($ret);
    }

}

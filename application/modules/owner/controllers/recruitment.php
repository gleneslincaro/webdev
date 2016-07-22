<?php

class Recruitment extends MX_Controller {

    private $viewData;
    private $common;

    function __construct() {
        parent::__construct();
        $this->load->helper('breabcrumb_helper');
        $this->load->model('owner/Mowner');
        $this->load->model('owner/Mcommon');
        $this->common = new Common();
        $this->output->set_header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate");
        $this->output->set_header("Cache-Control: post-check=0, pre-check=0");
        $this->output->set_header("Pragma: no-cache");
        if (!OwnerControl::LoggedIn()) {
            redirect(base_url() . "owner/login/");
        }
        $this->form_validation->CI = & $this;
        HelperApp::start_session();
        if (!HelperApp::get_session('urgentRecruitment')) {
            redirect(base_url() . "owner/top");
        }
    }

    public function index($page = 1) {
        $increment_flag = true;
        $owner_id = OwnerControl::getId();
        $this->viewData['occasional_data'] = $this->Mowner->getOwnerUrgentRecruitments($owner_id, 1);
        $this->viewData['weekly_data'] = $this->Mowner->getOwnerUrgentRecruitments($owner_id, 2);
        $latest_posted_date = $this->Mowner->getUrgentRecruitmentLogLatestDate($owner_id);
        if (!$latest_posted_date) {
            $latest_posted_date = $this->Mowner->getFirstOwnerUrgentRecruitmentDate($owner_id);
            $increment_flag = false;
        }
        if ($latest_posted_date) {
            if ($increment_flag) {
                $start_date = strtotime(date('Y-m-d H:i:s',strtotime($latest_posted_date . "+1 days")));
            } else {
                $start_date = strtotime($latest_posted_date);
                $increment_flag = true;
                            }
            $end_date = strtotime(date('Y-m-d H:i:s'));
            while (intval($start_date) <= intval($end_date)) {
              $data = $this->Mowner->getUrgentRecruitmentPostHistory(date('Y-m-d H:i:s', $start_date), $owner_id);
              if (isset($data) && $data) {
                  if ($data['posted_date'] == '') {
                      $post_hour = (intval($data['post_hour']) > 10)?$data['post_hour'].":00":'0'.$data['post_hour'].":00";
                      $data['posted_date'] = date('Y-m-d ', $start_date).$post_hour;
                        }                       
                        unset($data['post_hour']);
                        $is_inserted = $this->Mowner->insertUrgentRecruitmentPostHistory($data);
                    }
              $sdate = date('Y-m-d H:i:s', $start_date);
              $start_date = strtotime(date('Y-m-d H:i:s',strtotime($sdate . "+1 days")));
                }
            }

        $total = $this->Mowner->countOwnerUrgentRecruitmentPostHistory($owner_id);
        $page = $page > 1 ? $page : 1;
        $ppp = $this->config->item('per_page');

        $totalpage;
        if ($ppp != 0) {
            $totalpage = ceil($total / $ppp);
        }

        $this->viewData['first_link'] = base_url() . 'owner/recruitment/index/';
        $this->viewData['last_link']  = base_url() . 'owner/recruitment/index/'.$totalpage;

        $this->viewData['post_history'] = $this->Mowner->getOwnerUrgentRecruitmentPostHistory($page, $ppp, $owner_id, false);
        $this->viewData['ph_paging'] = HelperApp::get_paging($ppp, base_url() . "owner/recruitment/index/", $total, $page);
        $this->viewData['totalpage'] = $totalpage;
        $this->viewData['days'] = $this->getDays();
        $this->viewData['loadPage'] = 'owner/recruitment/index';
        $this->viewData['title'] = 'joyspe｜急募';
        $this->load->view("owner/layout/layout_A", $this->viewData);
    }

    public function create() {
        $this->viewData['days'] = $this->getDays();
        $owner_id = OwnerControl::getId();
        if ($this->input->post()) {
            $this->viewData['recruitment_type'] = $recruitment_type = $this->input->post('recruitment_type');
            if ($recruitment_type == 'weekly') {
                $this->viewData['post_day'] = $post_day = $this->input->post('post_day');
                $this->viewData['post_hour'] = $post_hour = $this->input->post('post_hour');
                $this->form_validation->set_rules('post_day', '曜日', 'required');
                $this->form_validation->set_rules('post_hour', '時', 'required');
            } else {
                $post_date = $this->input->post('post_date');
//                $this->form_validation->set_rules('post_date', '投稿日時', 'required');
            }
            $this->form_validation->set_rules('message', 'メッセージ', 'trim|required');
            if ($this->form_validation->run()) {
                $errors = array();
                if (isset($post_day)) {
                    if ($this->Mowner->checkDayHasScheduleWeekly($owner_id, $post_day, false)) {
                        $errors[] = '当日には既に投稿予約があります。１日一回投稿可能。';
                    }
                }
                if (isset($post_date)) {
                    if ($this->Mowner->checkOwnerHasPostedToday($owner_id, $post_date)) {
                        $errors[] = '本日既に記事を投稿しました。１日一回投稿可能。';
                    } else {
                        if ($this->Mowner->checkDayHasScheduleOccasional($owner_id, date('Y-m-d', strtotime($post_date)))) {
                            $errors[] = '当日には既に投稿予約があります。１日一回投稿可能。';
                        }
                    }
                }

                if (count($errors) < 1) {
                    $data = array(
                        'owner_id' => $owner_id,
                        'message' => $this->input->post('message'),
                        'recruitment_type' => ($recruitment_type == 'weekly')?2:1,
                        'post_day' => isset($post_day)?$post_day:NULL,
                        'post_hour' => isset($post_hour)?$post_hour:date('H', strtotime($post_date)),
                        'post_date' => isset($post_date)?date('Y-m-d', strtotime($post_date)):NULL,
                        'created_date' => date('Y-m-d H:i:s')
                    );
                    $is_inserted = $this->Mowner->insertUrgentRecruitment($data);
                    if ((isset($is_inserted) && $is_inserted)) {
                        $this->viewData['success_message'] = 'add';
                    }
                }
                else {
                    $this->viewData['errors'] = $errors;
                }
            }
        }
        $this->viewData['title_header'] = '記事を作成';
        $this->viewData['loadPage'] = 'owner/recruitment/create';
        $this->viewData['title'] = 'joyspe｜記事を作成';
        $this->load->view("owner/layout/layout_A", $this->viewData);
    }

    public function edit($ur_id = 0) {
        $owner_id = OwnerControl::getId();
        if ($ur_id == 0) {
            show_404();
        }
        $this->viewData['days'] = $this->getDays();
        if ($this->input->post()) {
            $this->viewData['recruitment_type'] = $recruitment_type = $this->input->post('recruitment_type');
            if ($recruitment_type == 'weekly') {
                $this->viewData['post_day'] = $post_day = $this->input->post('post_day');
                $this->viewData['post_hour'] = $post_hour = $this->input->post('post_hour');
                $this->form_validation->set_rules('post_day', '曜日', 'required');
                $this->form_validation->set_rules('post_hour', '時', 'required');
            } else {
                $post_date = $this->input->post('post_date');
                $this->form_validation->set_rules('post_date', '投稿日時', 'required');
            }
            $this->form_validation->set_rules('message', 'メッセージ', 'trim|required');
            $errors = array();
            if ($this->form_validation->run()) {
                if (isset($post_day)) {
                    $post_date_data = $this->Mowner->getOwnerUrgentRecruitmentPostDate($ur_id);
                    if ($this->Mowner->checkDayHasScheduleWeekly($owner_id, $post_day, $post_date_data['post_day'])) {
                        $errors[] = '当日には既に投稿予約があります。１日一回投稿可能。';
                    }
                }
                if (isset($post_date)) {
                    $post_date_data = $this->Mowner->getOwnerUrgentRecruitmentPostDate($ur_id);
                    if ($this->Mowner->checkOwnerHasPostedToday($owner_id, $post_date)) {
                        $errors[] = '本日既に記事を投稿しました。１日一回投稿可能。';
                    } else {
                        if(date('Y-m-d', strtotime($post_date)) != date('Y-m-d', strtotime($post_date_data['post_date']))) {
                            if ($this->Mowner->checkDayHasScheduleOccasional($owner_id, date('Y-m-d', strtotime($post_date)))) {
                                $errors[] = '当日には既に投稿予約があります。１日一回投稿可能。';
                            }
                        }
                    }
                }

                if (count($errors) < 1) {
                    $data = array(
                        'owner_id' => $owner_id,
                        'message' => $this->input->post('message'),
                        'post_date' => isset($post_date)?$post_date:NULL,
                        'post_day' => isset($post_day)?$post_day:NULL,
                        'post_hour' => isset($post_hour)?$post_hour:date('H', strtotime($post_date)),
                        'updated_date' => date('Y-m-d H:i:s'),
                        'recruitment_type' => ($recruitment_type == 'weekly')?2:1
                    );
                    $updated = $this->Mowner->updateUrgentRecruitment($data, $ur_id);
                    if (isset($updated) && $updated) {
                        $this->viewData['success_message'] = 'edit';
                    }
                } else {
                    $this->viewData['errors'] = $errors;
                }

            }
        } else {
            $data = $this->Mowner->getUrgentRecruitment($ur_id);
            $this->viewData['recruitment_type'] = ($data['recruitment_type'] == 1)?'occasional':'weekly';
            $this->viewData['post_day'] = $data['post_day'];
            $this->viewData['post_hour'] = $data['post_hour'];
            $post_hour = (intval($data['post_hour']) > 10)?$data['post_hour']:'0'.$data['post_hour'];
            $this->viewData['post_date'] = date('Y/m/d', strtotime($data['post_date']))." ".$post_hour.":00";
            $this->viewData['message'] = $data['message'];
        }
        $this->viewData['title_header'] = '記事を編集';
        $this->viewData['loadPage'] = 'owner/recruitment/create';
        $this->viewData['title'] = 'joyspe｜記事を編集';
        $this->load->view("owner/layout/layout_A", $this->viewData);
    }

    public function view($ph_id = 0) {
        if ($ph_id == 0) {
            show_404();
        }
        $this->viewData['data'] = $this->Mowner->getOwnerUrgentRecruitmentPostHistory(false, false, false, $ph_id);
        $this->viewData['loadPage'] = 'owner/recruitment/view';
        $this->viewData['title'] = 'joyspe｜記事を見る';
        $this->load->view("owner/layout/layout_A", $this->viewData);
    }

    public function delete() {
        $id = $this->input->post('id');
        $recruitment_type = $this->input->post('recruitment_type');
        $deleted = false;
        if ($id != 0) {
            $deleted = $this->Mowner->updateUrgentRecruitment(array('display_flag' => 0), $id);
        }
        echo json_encode($deleted);
    }

    public function getDays() {
        return array('日曜日', '月曜日', '火曜日', '水曜日', '木曜日', '金曜日', '土曜日');
    }
}

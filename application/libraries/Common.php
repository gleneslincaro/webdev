<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Common extends MX_Controller {

    function __construct() {
        $this->load->library('email');
        $this->load->model('user/Musers');
        $this->load->model('user/Mtravel_expense');
        $this->load->model('owner/Mowner');
        $this->load->model('owner/Mcommon');
        $this->load->model('user/MCampaign');
        $this->load->Model("admin/mmail");
        $this->load->Model("owner/Mtemplate");
    }

    /**
     * author: [IVS] Nguyen Bao Trieu + Phan Ngoc Minh Luan + Nguyen Hong Duc
     * name : sendMail
     * todo : send mail to object
     * @param $from , $to, $cc, $bc, $subject, $template, $loginId, $senderName, $user_id , $functionName, $functionJobTypeUser, $functionJobTypeOwner, $param, $url
     * @param string $senderName
     */
    function sendMail($cc = null, $bcc = null, $subject = null, $template = null, $loginId = null, $senderName = null, $user_id = null, $functionName = null, $functionJobTypeUser = null, $functionJobTypeOwner = null, $param = null, $url = null, $countUser = null, $scout_mail_id = null) {
        $body = "";
        $strJob = "";
        $strJobOwner = "";
        $dataRepeat = array();
        $from = "";
        $to = "";

        foreach ($template as $value) {
            $name_template = $value;
            $templateMail = $this->Mcommon->getTemplate($value);
            $mapTemplate = $this->Mcommon->getMapTemplate($value);
            $custom_title_flg = false;
            $title = $templateMail['title'];
            if ($scout_mail_id) {
                $dataTemplate = $this->Mcommon->$value($user_id, $loginId, $scout_mail_id);
                if (isset($dataTemplate['scout_pr_title']) && $pr_title = $dataTemplate['scout_pr_title']) {
                    $title = $pr_title;
                    $custom_title_flg = true;
                }
            } else {
                $dataTemplate = $this->Mcommon->$value($user_id, $loginId);
            }

            $body = $templateMail['content'];
            //Set template title for mail us ---- Lam Tu My Kieu
            foreach ($mapTemplate as $key => $value) {
                if ($custom_title_flg == false) {
                    if (isset($dataTemplate[$value['mapping_name']]) && $dataTemplate[$value['mapping_name']] != '') {
                      $title = str_replace('/--' . $value['name'] . '--/', ($value['mapping_name'] == 'password') ? base64_decode($dataTemplate[$value['mapping_name']]) :$dataTemplate[$value['mapping_name']], $title);
                    }
                }
                if(isset($dataTemplate[$value['mapping_name']])) {
                    if(($dataTemplate[$value['mapping_name']] == 0 || $dataTemplate[$value['mapping_name']] == '0') && $value['mapping_name'] == 'scout_pr_text'){
                        $body = str_replace('/--スカウト自由文--/',  $dataTemplate[$value['mapping_name']] , $body);
                    }
                }
             }

            // string job type owner
            if (!empty($functionJobTypeOwner) && $name_template != 'ow12') {
                $jobOwner = $this->Mcommon->$functionJobTypeOwner($loginId, $user_id);
                foreach ($jobOwner as $ownerJob) {
                    $strJob .= ($strJob != '' ? '、' : '') . $ownerJob['jobtype_owner'];
                }
                $dataTemplate['jobtype_owner'] = $strJob;
                if (!empty($countUser)) {
                    $dataTemplate['scout_number'] = $countUser;
                }
            }
            foreach ($mapTemplate as $key => $value) {
                if (isset($dataTemplate[$value['mapping_name']]) && $dataTemplate[$value['mapping_name']] != '') {
                    $body = str_replace('/--' . $value['name'] . '--/', ($value['mapping_name'] == 'password') ? base64_decode($dataTemplate[$value['mapping_name']]) : $dataTemplate[$value['mapping_name']], $body);
                    $body = str_replace('/--店舗URL--/',$url,$body);
                }
            }
            if (!empty($functionName)) {
                $bodyArr = mb_split('//////////////////////////////', $body);
                if (count($bodyArr) > 1) {
                    //------- Replace many users -----------
                    $content_template = $bodyArr[1];

                    $content_replace = '';

                    $dataRebeat = $this->Mcommon->$functionName($loginId, $param);

                    $addContent = '';
                    if (!empty($functionJobTypeUser)) {
                        foreach ($dataRebeat as $key => $data) {
                            // string job type user
                            $jobUser = $this->Mcommon->$functionJobTypeUser($data['user_id']);
                            $strJob = '';
                            foreach ($jobUser as $userJob) {
                                $strJob .= ($strJob != '' ? '、' : '') . $userJob['jobtype_user'];
                            }
                            $data['jobtype_user'] = $strJob;
                            // string job type owner
                            if (!empty($functionJobTypeOwner) && $name_template == 'ow12') {
                                $jobOwner = $this->Mcommon->$functionJobTypeOwner($data['owner_recruit_id'], $data['user_id']);
                                $strJob = '';
                                foreach ($jobOwner as $ownerJob) {
                                    $strJob .= ($strJob != '' ? '、' : '') . $ownerJob['jobtype_owner'];
                                }

                                $data['jobtype_owner'] = $strJob;
                            }
                            $dataRepeat[] = $data;
                        }
                    } else {
                        $dataRepeat = $dataRebeat;
                    }
                    foreach ($dataRepeat as $key => $data) {
                        $content_replace = $content_template;
                        foreach ($mapTemplate as $key => $value) {
                          if (isset($data[$value['mapping_name']])) {
                            if (strpos($content_template, '/--' . $value['name'] . '--/')) {
                              $content_replace = str_replace('/--' . $value['name'] . '--/', $data[$value['mapping_name']], $content_replace);
                            }
                          }
                        }
                        $addContent .= $content_replace;
                    }

                    $body = str_replace($content_template, $addContent, $body);
                } else {
                    //------- Replace 1 users -----------
                    $dataRebeat = $this->Mcommon->$functionName($loginId, $param);

                    $addContent = '';
                    if (!empty($functionJobTypeUser)) {
                        foreach ($dataRebeat as $key => $data) {
                            // string job type user
                            $jobUser = $this->Mcommon->$functionJobTypeUser($data['user_id']);
                            $strJob = '';
                            foreach ($jobUser as $userJob) {
                                $strJob .= ($strJob != '' ? '、' : '') . $userJob['jobtype_user'];
                            }
                            $data['jobtype_user'] = $strJob;
                            $dataRepeat[] = $data;
                        }
                    } else {
                        $dataRepeat = $dataRebeat;
                    }
                    foreach ($dataRepeat as $key => $data) {
                      foreach ($mapTemplate as $key => $value) {
                        if (isset($data[$value['mapping_name']])) {
                          if (strpos($body, '/--' . $value['name'] . '--/')) {
                            $body = str_replace('/--' . $value['name'] . '--/', $data[$value['mapping_name']], $body);
                          }
                        }
                      }
                    }
                }
            }
            //--------------------------------------------------------
            $storename = '';
            if (isset($dataTemplate['storename'])) {
                $storename = $dataTemplate['storename'];
            }

            //-------------------------Get email address start-------------------------------
            $type = substr($templateMail['template_type'], 0, 2);

            $from = ( $templateMail['mail_from'] == null || $templateMail['mail_from'] == '') ? $this->config->item('smtp_user') : $templateMail['mail_from'];

            if (trim($type) == "ss" || trim($type) == "sp") {
                $to = ( $templateMail['mail_from'] == null || $templateMail['mail_from'] == '') ? $this->config->item('smtp_user') : $templateMail['mail_from'];
            } else {
                if (isset($dataTemplate['email_address'])) {
                    $to = $dataTemplate['email_address'];
                }
            }

            //-------------------------Get email address end---------------------------------

            //---Check items don't replace when will replace empty  start ---
             foreach ($mapTemplate as $key => $value) {
                  $body = str_replace('/--' . $value['name'] . '--/',"", $body);
            }
            //---------------------------end---------------------------------

            //---------------------------campaign_note-----------------------
            $body = str_replace('/--ご紹介店舗名--/',$dataTemplate['campaign_note'], $body);
            //---------------------------end---------------------------------

            try {
                $crlf = "\r\n";
                $header = "From: Joyspe<" . $from . ">" . $crlf;
                if ( $bcc ) {
                    $header .= "Bcc:<" . $bcc . ">" . $crlf;
                }
                if ( $cc ) {
                    $header .= "Cc:<". $cc . ">" . $crlf;
                }
                $new_header = $this->_add_attachment_to_mail_header($header, $type, $body);
                if ($new_header) {
                    $header = $new_header;
                }
                $result = mb_send_mail($to, $title, $body , $header);
            } catch (phpmailerException $e) {
                //throw $e;
            } catch (Exception $e){
                //throw $e;
            }
        }
    }

    private function _add_attachment_to_mail_header($header, $type, $body) {
        if (trim($type) == "ss" && isset($_FILES['file_attachment']['name']) && $_FILES['file_attachment']['name']) {
            $random_hash = md5(date('r', time()));
            $crlf = "\r\n";
            // Main header
            $header .= "Content-Type: multipart/mixed; boundary=\"" . $random_hash . "\"" . $crlf . $crlf;
            $header .= "Content-Transfer-Encoding: 7bit" . $crlf;
            $header .= "This is a MIME encoded message." . $crlf . $crlf;
            // Message
            $header .= "--" . $random_hash . $crlf;
            $header .= "Content-Type: text/plain; charset=\"utf-8\"" . $crlf;
            $header .= "Content-Transfer-Encoding: 8bit" . $crlf . $crlf;
            $header .= $body . $crlf . $crlf;

            $filename = $_FILES['file_attachment']['name'];
            $size = $_FILES['file_attachment']['size'];
            $mime = $_FILES['file_attachment']['type'];
            $tmp = $_FILES['file_attachment']['tmp_name'];
            $file = fopen($tmp,'rb');
            // Read the file content into a variable
            $data = fread($file,filesize($tmp));
            // Close the file
            fclose($file);
            // Encode it and split it into acceptable length lines
            $attachment = chunk_split(base64_encode($data));
            // Attachment
            $header .= "--" . $random_hash . $crlf;
            $header .= "Content-Type: " . $mime . "; name=\"" . $filename . "\"" . $crlf;
            $header .= "Content-Transfer-Encoding: base64" . $crlf;
            $header .= "Content-Disposition: attachment" . $crlf . $crlf;
            $header .= $attachment . $crlf . $crlf;
            $header .= "--" . $random_hash . "--";
        }

        return $header;
    }

    /**
    * Send information that a new pay owner inputted to admin email addres
    *
    * @param $data all user inputed data in array
    * @param $type type of mail template to send
    * @return none
    */
    public function sendMailpayCompany($data, $type) {
        if (!$data || !$type) {
            return;
        }
        $template = $this->Mcommon->getTemplate($type);
        if (!$template) {
            return;
        }
        $to = $template['mail_from'];
        $from = $template['mail_from'];
        $title = $template['title'];
        $body = $template['content'];
        $body = str_replace('/--掲載エリア--/', $data['city_group'] . '-' . $data['city'] . '-' . $data['town'] , $body);
        $body = str_replace('/--店舗名--/', $data['storename'] , $body);
        $body = str_replace('/--業種--/', $data['job_type'] , $body);
        $body = str_replace('/--電話番号--/', $data['tel'] , $body);
        $body = str_replace('/--店舗メールアドレス--/', $data['email'] , $body);
        $body = str_replace('/--ご担当者様氏名--/', $data['person_in_charge'] , $body);
        $body = str_replace('/--ご紹介店舗名--/',$data['campaign_note'], $body);

        try {
            $header  = "From: Joyspe<" . $from . ">" . PHP_EOL;
            mb_send_mail($to, $title, $body , $header);
        } catch (phpmailerException $e) {
        //throw $e;
        } catch (Exception $e){
        //throw $e;
        }
    }

    public function sendMailUsingMbSendMail($title, $body, $from, $to, $cc = null, $bcc = null) {
        try {
            $header  = "From: Joyspe<" . $from . ">" . PHP_EOL;
            if ($bcc) {
                $header .= "Bcc:<" . $bcc . ">" . PHP_EOL;
            }
            if ($cc) {
                $header .= "Cc:<". $cc . ">";
            }
            $result = mb_send_mail($to, $title, $body , $header);
        } catch (phpmailerException $e) {
        } catch (Exception $e){
        }
    }
    // get newsletter mail data to send(title, body)
    // content_type: 0 send to user's address content
    // content_type: 1 send to machemoba's mailbox
    // content_type: 2 display inside joyspe's mailbox
    public function getMailDataFromTemplate($title_template, $body_template, $user_email, $owner_recruit_id, $content_type = 0,
                                            $scout_mail_id = null,$curr_bonus_money='',$encoded_login_str=null) {
        $ret = null;
        $result_variable = $this->mmail->variableList();
        if (!$result_variable || !$title_template || !$body_template || !$owner_recruit_id || !$user_email) {
            return null;
        }
        $dataTemplate = $this->mmail->emailQuery($user_email);
        if (!$dataTemplate) {
            return null;
        }

        $owner_url = base_url() . "user/joyspe_user/company/" . $owner_recruit_id;

        // string job type owner
        $job_owner = $this->Mcommon->getJobOwnerRecruito01($owner_recruit_id);
        $str_owner_job = "";
        foreach ($job_owner as $job) {
            $str_owner_job .= ($str_owner_job != '' ? '、' : '') . $job['jobtype_owner'];
        }
        if ($str_owner_job) {
            $dataTemplate['jobtype_owner'] = $str_owner_job;
        }

        foreach ($result_variable as $value) {
            $mapping_name     = $value['mapping_name'];
            $mapping_variable = $value['name'];
            if (isset($dataTemplate[$mapping_name])) {
                if (strpos($body_template, '/--' . $mapping_variable . '--/', 0 ) !== false) {
                    if ($mapping_name == 'password') {
                        $body_template = str_replace('/--'.$mapping_variable.'--/', base64_decode($dataTemplate[$mapping_name]), $body_template);
                    } else {
                        $body_template = str_replace('/--'.$mapping_variable.'--/', $dataTemplate[$mapping_name], $body_template);
                    }
                }
                if (strpos($title_template, '/--' . $mapping_variable . '--/', 0) !== false) {
                    if ($mapping_name == 'password') {
                        $title_template = str_replace('/--'.$mapping_variable.'--/', base64_decode($dataTemplate[$mapping_name]), $title_template);
                    } else {
                        $title_template = str_replace('/--'.$mapping_variable.'--/', $dataTemplate[$mapping_name], $title_template);
                    }
                }
            }
        }
        $top_page = base_url() . 'user/joyspe_user/index/';
        $user_inbox = base_url() . 'user/message_detail/' . $scout_mail_id . '/1/1/';
        $user_from_site = $dataTemplate['user_from_site'];
        if ($content_type) {
            $phrase = PHP_EOL . "本リンクによる自動ログインは送信された時間から" . LOGIN_EXPIRE_HOURS . "時間内になります。";
            $np = md5('np');
            $user_id = $dataTemplate['userId'];
            // change store URL based on type of users
            switch($user_from_site) {
                case 0: // User inside joyspe(currently, thre is not)
                    break;
                case 1: // Machemoba
                case 2: //Makia
                    if ($content_type == 1 || $content_type == 3) { // Send mail to email address
                        $hash = md5(date("Y-m-d H:i:s") . $user_id);
                        $this->Musers->updateListUserMessage(array('u_hash' => $hash), $owner_recruit_id, $user_id, $scout_mail_id);
                        if ($encoded_login_str) {
                            $top_page .= '?lparam='. $encoded_login_str.'&hash='.$hash . '&np=' . $np . $phrase;
                            $owner_url .= '?lparam='. $encoded_login_str.'&hash='.$hash . '&np=' . $np . $phrase;
                            $user_inbox .= '?lparam='. $encoded_login_str.'&hash='.$hash . '&np=' . $np . $phrase;
                        }
                    } else  if ($content_type == 2) { // display inside joyspe's mailbox
                        $hash = $this->Musers->getHashByListUrMsgID($scout_mail_id);
                        if ($hash) {
                            $owner_url .= '?hash=' . $hash . '&np=' . $np . $phrase;
                            $top_page  .= '?hash=' . $hash . '&np=' . $np . $phrase;
                            $user_inbox .= '?hash='.$hash . '&np=' . $np . $phrase;
                        }
                    }
                break;
            }
        }

        if (strpos($body_template,'/--現在の報酬額--/', 0) !== false) {
            $body_template = str_replace('/--現在の報酬額--/', $curr_bonus_money, $body_template);
        }

        if (strpos($body_template,'/--店舗URL(メルマガポイント付き)--/', 0) !== false) {
            $body_template = str_replace('/--店舗URL(メルマガポイント付き)--/', $owner_url, $body_template);
        }

        if (strpos($body_template,'/--トップページURL(メルマガポイント付き)--/', 0) !== false) {
            $body_template = str_replace('/--トップページURL(メルマガポイント付き)--/', $top_page, $body_template);
        }

        // for old newsletter to display ok inside joyspe message box
        //<--
        if (strpos($body_template,'/--店舗URL--/', 0) !== false) {
            $body_template = str_replace('/--店舗URL--/', $owner_url, $body_template);
        }

        if (strpos($body_template,'/--トップページURL--/', 0) !== false) {
            $body_template = str_replace('/--トップページURL--/', $top_page, $body_template);
        }
        //-->

        $ret['title'] = $title_template;
        $ret['body'] = $body_template;
        return $ret;
    }
    /**
     * author: [IVS] My Phuong Le Thi
     * name : sendMail
     * todo : send mail to object
     * @param string $from
     * @param string $to
     * @param string $cc
     * @param string $bcc
     * @param string $subject
     * @param string $body
     * @param string $senderName
     */
    public function sendMailObject($from = null, $to = null, $cc = null, $bcc = null, $subject = null, $body = null, $senderName = null) {

        if ($from == null)
            $from = $this->config->item('smtp_user');
        $from = ($from == null || $from == '') ? $this->config->item('smtp_user') : $from;

        try {
                  $result =$this->email
                            ->from($from,"joyspe")
                            ->to($to)
                            ->cc($cc)
                            ->bcc($bcc)
                            ->subject($subject)
                            ->message($body)
                            ->send();

            } catch (phpmailerException $e) {
                throw $e;
            } catch (Exception $e){
                throw $e;
            }

    }

    /**
     * author: [IVS] Lam Tu My Kieu
     * name : sendMailForOneUser
     * todo : send mail for one user
     * @param $from , $to, $cc, $bc, $subject, $template, $loginId, $senderName, $user_id , $functionJobTypeUser, $functionJobTypeOwner, $param, $url
     * @param string $senderName
     */
    function sendMailForOneUser($from = null, $to = null, $cc = null, $bcc = null, $subject = null, $template = null, $loginId = null, $senderName = null, $user_id = null, $functionJobTypeUser = null, $functionJobTypeOwner = null, $param = null, $url = null, $countUser = null) {
        $body = "";
        $strJob = "";
        $strJobOwner = "";
        $strJobUser = '';
        $from = ($from == null || $from == '') ? $this->config->item('smtp_user') : $from;

        foreach ($template as $value) {
            $templateMail = $this->Mcommon->getTemplate($value);
            $mapTemplate = $this->Mcommon->getMapTemplate($value);
            $dataTemplate = $this->Mcommon->$value($user_id, $loginId);
            $title = $templateMail['title'];

            //Set template title for mail us ---- Lam Tu My Kieu
            foreach ($mapTemplate as $key => $value) {

                if (!empty($dataTemplate[$value['mapping_name']])) {

                    $title = str_replace('/--' . $value['name'] . '--/', ($value['mapping_name'] == 'password') ? base64_decode($dataTemplate[$value['mapping_name']]) : $dataTemplate[$value['mapping_name']], $title);
                }
            }
            $body = $templateMail['content'];

            // string job type owner
            if (!empty($functionJobTypeOwner)) {
                $jobOwner = $this->Mcommon->$functionJobTypeOwner($loginId);
                foreach ($jobOwner as $ownerJob) {
                    $strJob .= ($strJob != '' ? '、' : '') . $ownerJob['jobtype_owner'];
                }
                $dataTemplate['jobtype_owner'] = $strJob;
                if (!empty($countUser)) {
                    $dataTemplate['scout_number'] = $countUser;
                }
            }
            foreach ($mapTemplate as $key => $value) {
                if (!empty($dataTemplate[$value['mapping_name']])) {
                    $body = str_replace('/--' . $value['name'] . '--/', ($value['mapping_name'] == 'password') ? base64_decode($dataTemplate[$value['mapping_name']]) : $dataTemplate[$value['mapping_name']], $body);
                    $body = str_replace('/--店舗URL--/', $url, $body);
                }
            }
            //------- Replace many jobtype user -----------

            if (!empty($functionJobTypeUser)) {
                $jobUser = $this->Mcommon->$functionJobTypeUser($user_id);
                foreach ($jobUser as $userJob) {
                    $strJobUser.= ($strJobUser != '' ? '、' : '') . $userJob['jobtype_user'];
                }
                $strJobUser = substr($strJobUser, 0, -1);

                $dataTemplate['jobtype_user'] = $strJobUser;
            }
            foreach ($mapTemplate as $key => $value) {
                if (!empty($dataTemplate[$value['mapping_name']])) {

                    $body = str_replace('/--' . $value['name'] . '--/', ($value['mapping_name'] == 'password') ? base64_decode($dataTemplate[$value['mapping_name']]) : $dataTemplate[$value['mapping_name']], $body);
                }
            }
            //--------------------------------------------------------

           if($to == null)
           {
               $to = $dataTemplate['email_address'];
           }

           try {
                  $result =$this->email
                            ->from($from,"joyspe")
                            ->to($to)
                            ->cc($cc)
                            ->bcc($bcc)
                            ->subject($title)
                            ->message($body)
                            ->send();

            } catch (phpmailerException $e) {
                throw $e;
            } catch (Exception $e){
                throw $e;
            }
        }
    }

    /**
     * author: [IVS] Phan Ngoc Minh Luan + Nguyen Hong Duc
     * name : setTemplateContent
     * todo : set template mail content
     * @param int $user_id, $owner_id, $template, $functionName, $param
     * @param string $template
     */
    function setTemplateContent($user_id = null, $owner_id = null, $template = null, $functionName = null, $functionJobTypeUser = null, $functionJobTypeOwner = null, $param, $url = null, $countUser = null) {
        $body = "";
        $strJob = "";
        $strJobOwner = "";
        $dataRepeat = array();
        foreach ($template as $value) {
            $name_template = $value;
            $templateMail = $this->Mcommon->getTemplate($value);
            $mapTemplate = $this->Mcommon->getMapTemplate($value);
            $dataTemplate = $this->Mcommon->$value($user_id, $owner_id);
            $body = $templateMail['content'];
            // string job type owner
            if (!empty($functionJobTypeOwner) && $name_template != 'ow12') {
                $jobOwner = $this->Mcommon->$functionJobTypeOwner($owner_id, $user_id);
                foreach ($jobOwner as $ownerJob) {
                    $strJob .= ($strJob != '' ? '、' : '') . $ownerJob['jobtype_owner'];
                }

                $dataTemplate['jobtype_owner'] = $strJob;
                if (!empty($countUser)) {
                    $dataTemplate['scout_number'] = $countUser;
                }
            }
            foreach ($mapTemplate as $key => $value) {

                if (!empty($dataTemplate[$value['mapping_name']])) {
                    $body = str_replace('/--' . $value['name'] . '--/', ($value['mapping_name'] == 'password') ? base64_decode($dataTemplate[$value['mapping_name']]) : $dataTemplate[$value['mapping_name']], $body);
                    $body = str_replace('/--店舗URL--/',  $url , $body);
                }
            }


            if (!empty($functionName)) {
                if (count($param) > 1) {
                    //------- Replace many users -----------
                    $bodyArr = mb_split('//////////////////////////////', $body);
                    if (count($bodyArr) > 1) {

                        $content_template = $bodyArr[1];

                        $content_replace = '';
                        $dataRebeat = $this->Mcommon->$functionName($owner_id, $param);
                        $addContent = '';
                        if (!empty($functionJobTypeUser)) {
                            foreach ($dataRebeat as $key => $data) {
                                // string job type user
                                $jobUser = $this->Mcommon->$functionJobTypeUser($data['user_id']);
                                $strJob = '';
                                foreach ($jobUser as $userJob) {
                                    $strJob .= ($strJob != '' ? '、' : '') . $userJob['jobtype_user'];
                                }
                                $data['jobtype_user'] = $strJob;
                                // string job type owner
                                if (!empty($functionJobTypeOwner) && $name_template == 'ow12') {
                                    $jobOwner = $this->Mcommon->$functionJobTypeOwner($data['owner_recruit_id'], $data['user_id']);
                                    $strJob = '';
                                    foreach ($jobOwner as $ownerJob) {
                                        $strJob .= ($strJob != '' ? '、' : '') . $ownerJob['jobtype_owner'];
                                    }

                                    $data['jobtype_owner'] = $strJob;
                                }
                                $dataRepeat[] = $data;
                            }
                        } else {
                            $dataRepeat = $dataRebeat;
                        }
                        foreach ($dataRepeat as $key => $data) {
                            $content_replace = $content_template;

                            foreach ($mapTemplate as $key => $value) {
                                if (strpos($content_template, '/--' . $value['name'] . '--/')) {
                                    $replaseData = isset($data[$value['mapping_name']]) ? $data[$value['mapping_name']] : '';
                                    $content_replace = str_replace('/--' . $value['name'] . '--/', $replaseData, $content_replace);
                                    //$content_replace = str_replace('/--' . $value['name'] . '--/', $data[$value['mapping_name']], $content_replace);
                                }
                            }
                            $addContent .= $content_replace;
                        }

                        $body = str_replace($content_template, $addContent, $body); //------------------
                    }
                } else {
                    //------- Replace 1 users -----------
                    $dataRebeat = $this->Mcommon->$functionName($owner_id, $param);

                    $addContent = '';
                    if (!empty($functionJobTypeUser)) {
                        foreach ($dataRebeat as $key => $data) {
                            // string job type user
                            $jobUser = $this->Mcommon->$functionJobTypeUser($data['user_id']);
                            $strJob = '';
                            foreach ($jobUser as $userJob) {
                                $strJob .= ($strJob != '' ? '、' : '') . $userJob['jobtype_user'];
                            }
                            $data['jobtype_user'] = $strJob;
                            // string job type owner
                            if (!empty($functionJobTypeOwner) && $name_template == 'ow12') {
                                $jobOwner = $this->Mcommon->$functionJobTypeOwner($data['owner_recruit_id'], $data['user_id']);
                                $strJob = '';
                                foreach ($jobOwner as $ownerJob) {
                                    $strJob .= ($strJob != '' ? '、' : '') . $ownerJob['jobtype_owner'];
                                }

                                $data['jobtype_owner'] = $strJob;
                            }
                            $dataRepeat[] = $data;
                        }
                    } else {
                        $dataRepeat = $dataRebeat;
                    }
                    foreach ($dataRepeat as $key => $data) {

                        foreach ($mapTemplate as $key => $value) {
                            if (strpos($body, '/--' . $value['name'] . '--/')){
                                $replaseData = isset($data[$value['mapping_name']]) ? $data[$value['mapping_name']] : '';
                                $body = str_replace('/--' . $value['name'] . '--/', $replaseData, $body);
                                //$body = str_replace('/--' . $value['name'] . '--/', $data[$value['mapping_name']], $body);
                            }
                        }
                    }
                }
            }

            //--------------------------------------------------------
            $body = str_replace(array("\r\n", "\n", "\r"), "<br/>", $body);
        }
        return $body;
    }

    function setTemplateContentu03o01($owner_id = null, $template = null, $functionJobTypeOwner = null, $param, $url = null, $countUser = null, $scout_pr_text = null, $ownerRecruitId = null) {
        $body = "";
        $strJob = "";
        $strJobOwner = "";
        $dataRepeat = array();
                $flag = true;
        foreach ($template as $value) {
            $name_template = $value;
            $templateMail = $this->Mcommon->getTemplate($value);
            $mapTemplate = $this->Mcommon->getMapTemplate('ow01');
            $dataTemplate = $this->Mcommon->ow0101('', $owner_id);
                        if($flag == true) {
                            $mTQty =count($mapTemplate);
                            $mapTemplate[$mTQty]['id'] = '';
                            $mapTemplate[$mTQty]['group_type'] = 'ow01';
                            $mapTemplate[$mTQty]['name'] = 'スカウト自由文';
                            $mapTemplate[$mTQty]['mapping_name'] = 'scout_pr_text';
                            $mapTemplate[$mTQty]['display_flag'] = '1';
                            $flag = false;
                        }
            $body = $templateMail['content'];
            // string job type owner
            if (!empty($functionJobTypeOwner) && $name_template != 'ow12') {
                $jobOwner = $this->Mcommon->$functionJobTypeOwner($ownerRecruitId);
                foreach ($jobOwner as $ownerJob) {
                    $strJob .= ($strJob != '' ? '、' : '') . $ownerJob['jobtype_owner'];
                }

                $dataTemplate['jobtype_owner'] = $strJob;
                if (!empty($countUser)) {
                    $dataTemplate['scout_number'] = $countUser;
                }
            }
            foreach ($mapTemplate as $key => $value) {
                if (!empty($dataTemplate[$value['mapping_name']]) && $value['mapping_name'] != 'unique_id') {
                                    $body = str_replace('/--' . $value['name'] . '--/', ($value['mapping_name'] == 'password') ? base64_decode($dataTemplate[$value['mapping_name']]) : $dataTemplate[$value['mapping_name']], $body);
                                    $body = str_replace('/--店舗URL--/',  $url , $body);
                }

                                $body = str_replace('/--' . $mapTemplate[$mTQty]['name'] . '--/',  '<textarea style="border: none; resize: none; background: none" cols="80" id="scout_pr_text" name="scout_pr_text" readonly="readonly" type="text">'.$scout_pr_text.'</textarea>', $body);
            }
            //--------------------------------------------------------
            $body = str_replace(array("\r\n", "\n", "\r"), "<br/>", $body);
        }
        return $body;
    }

    // fill owner, user data to template
    function setTemplateContentScoutMail($user_id, $owner_id, $owner_recruit_id,
                                         $template, $url, $scout_mail_id) {
      $body= "";
      $strJob   = "";
      $strJobOwner = "";
      $dataRepeat = array();
      $name_template  = $template;
      $templateMail   = $this->Mcommon->getTemplate($template);
      $mapTemplate    = $this->Mcommon->getMapTemplate($template);
      $cTemplate      = ($template == 'us03') ? 'us0301' : 'us1401';

      $dataTemplate = $this->Mcommon->$cTemplate($user_id, $owner_id, $owner_recruit_id, $scout_mail_id);
      $body = $templateMail['content'];

      // string job type owner
      if ($name_template != 'ow12') {
        $jobOwner = $this->Mcommon->getJobOwnerRecruito01($owner_recruit_id, $user_id);
        foreach ($jobOwner as $ownerJob) {
          $strJob .= ($strJob != '' ? '、' : '') . $ownerJob['jobtype_owner'];
        }
        $dataTemplate['jobtype_owner'] = $strJob;
        $dataTemplate['scout_number'] = 1;
      }

      foreach ($mapTemplate as $key => $value) {
        if ( $value['mapping_name'] && isset($dataTemplate[$value['mapping_name']]) ) {
        //if ( !empty($dataTemplate[$value['mapping_name']]) ) {
          $body = str_replace('/--' . $value['name'] . '--/', $dataTemplate[$value['mapping_name']], $body);
          $body = str_replace('/--店舗URL--/',  $url , $body);
        }
      }
      //--------------------------------------------------------
      $body = str_replace(array("\r\n", "\n", "\r"), "<br/>", $body);
      return $body;
    }


    /**
     * author: [IVS] Lam Tu My Kieu
     * name : setTemplateContentForOneUser
     * todo : set template mail content for 1 user
     * @param int $user_id, $owner_id, $template, $functionName, $param
     * @param string $template
     */
    function setTemplateContentForOneUser($user_id = null, $owner_id = null, $template = null, $functionJobTypeUser = null, $functionJobTypeOwner = null, $param = null, $url = null, $countUser = NULL) {
        $body = "";
        $strJob = "";
        $strJobOwner = "";
        $strJobUser = "";
        foreach ($template as $value) {
            $templateMail = $this->Mcommon->getTemplate($value);
            $mapTemplate = $this->Mcommon->getMapTemplate($value);
            $dataTemplate = $this->Mcommon->$value($user_id, $owner_id);

            $body = $templateMail['content'];

            // string job type owner
            if (!empty($functionJobTypeOwner)) {
                $jobOwner = $this->Mcommon->$functionJobTypeOwner($owner_id);
                foreach ($jobOwner as $ownerJob) {
                    $strJob .= ($strJob != '' ? '、' : '') . $ownerJob['jobtype_owner'];
                }
                $dataTemplate['jobtype_owner'] = $strJob;
                if (!empty($countUser)) {
                    $dataTemplate['scout_number'] = $countUser;
                }
            }
            foreach ($mapTemplate as $key => $value) {
                if (!empty($dataTemplate[$value['mapping_name']])) {
                    $body = str_replace('/--' . $value['name'] . '--/', ($value['mapping_name'] == 'password') ? base64_decode($dataTemplate[$value['mapping_name']]) : $dataTemplate[$value['mapping_name']], $body);
                    $body = str_replace('/--店舗URL--/', $url , $body);
                }
            }
            // string job type user
            if (!empty($functionJobTypeUser)) {
                $jobUser = $this->Mcommon->$functionJobTypeUser($user_id);
                foreach ($jobUser as $userJob) {
                    $strJobUser.= ($strJobUser != '' ? '、' : '') . $userJob['jobtype_user'];
                }
                $strJobUser = substr($strJobUser, 0, -1);

                $dataTemplate['jobtype_user'] = $strJobUser;
            }
            foreach ($mapTemplate as $key => $value) {
                if (!empty($dataTemplate[$value['mapping_name']])) {

                    $body = str_replace('/--' . $value['name'] . '--/', ($value['mapping_name'] == 'password') ? base64_decode($dataTemplate[$value['mapping_name']]) : $dataTemplate[$value['mapping_name']], $body);
                }
            }


            //--------------------------------------------------------
            $body = str_replace(array("\r\n", "\n", "\r"), "<br/>", $body);
        }
        return $body;
    }

    /**
     * author: [IVS] Lam Tu My Kieu
     * name : setTemplateTitle
     * todo : set template mail title
     * @param int $user_id, $owner_id
     * @param string $template
     */
    function setTemplateTitle($user_id = null, $owner_id = null, $template = null) {

        $title = "";
        foreach ($template as $value) {

            $templateMail = $this->Mcommon->getTemplate($value);
            $mapTemplate = $this->Mcommon->getMapTemplate($value);
            $dataTemplate = $this->Mcommon->$value($user_id, $owner_id);
            $title = $templateMail['title'];
            foreach ($mapTemplate as $key => $value) {
                if (!empty($dataTemplate[$value['mapping_name']])) {
                    $title = str_replace('/--' . $value['name'] . '--/', ($value['mapping_name'] == 'password') ? base64_decode($dataTemplate[$value['mapping_name']]) : $dataTemplate[$value['mapping_name']], $title);
                }
            }

            $title = str_replace(array("\r\n", "\n", "\r"), "<br/>", $title);
        }
        return $title;
    }

    /**
     * author: [IVS] Nguyen Hong Duc
     * name : sendMailFeddBack
     * todo : send mail feed back
     * @param string $from
     * @param string $to
     * @param string $cc
     * @param string $bcc
     * @param string $subject
     * @param array  $template
     * @param int  $loginId
     * @param string $senderName
     */
    function sendMailFeedBack($from = null, $to = null, $cc = null, $bcc = null, $subject = null, $body = null, $senderName = null) {

        $from = ($from == null || $from == '') ? $this->config->item('smtp_user') : $from;

        try {
                $result =$this->email
                            ->from($from,"joyspe")
                            ->to($to)
                            ->cc($cc)
                            ->bcc($bcc)
                            ->subject($subject)
                            ->message($body)
                            ->send();

            } catch (phpmailerException $e) {
                throw $e;
            } catch (Exception $e){
                throw $e;
            }
    }

    /**
     * author: [IVS] Nguyen Bao Trieu
     * name : fileUpload
     * todo : upload image into folder images
     * @param null
     * @return null
     */
    public function fileUpload($fileName,$isOwner=true,$user_id=null) {
        if ( $isOwner ){
            $path = $this->config->item('upload_owner_dir') . '/images/';
             $this->folderName = OwnerControl::getId();
        }else{
            $path = $this->config->item('upload_userdir') . '/images/';
            if ( $user_id ){
                $this->folderName = $user_id;
            }else{
                $this->folderName = UserControl::getId();
            }
        }

        if (!is_dir($path . $this->folderName)) {
            mkdir($path . $this->folderName);
        }
        if ( $isOwner ){
            $this->tmpPath = $this->config->item('upload_owner_dir') . '/tmp/';
        }else{
            $this->tmpPath = $this->config->item('upload_userdir') . '/tmp/';
        }

        copy($this->tmpPath . '/' . $fileName, $path . '/' . $fileName);
    }

    /**
     * author: [IVS] Nguyen Bao Trieu
     * name : deleteFolder
     * todo : delete folder in tmp folder
     * @param null
     * @return null
     */
    public function deleteFolder($isOwner=true,$user_id=null) {

        $this->load->helper("file");
        if ( $isOwner ){
            $this->tmpPath = $this->config->item('upload_owner_dir') . '/tmp/';
            $this->folderName = OwnerControl::getId();
        }else{
             $this->tmpPath = $this->config->item('upload_userdir') . '/tmp/';
             if( $user_id ){
                $this->folderName = $user_id;
            }else{
                $this->folderName = UserControl::getId();
            }
        }

        if (is_dir($this->tmpPath . $this->folderName)) {

            delete_files($this->tmpPath . $this->folderName, true);
            rmdir($this->tmpPath . $this->folderName);
        }
    }
    /**
     * @author:[IVS]Nguyen Ngoc Phuong
     * @name: setBodyUs03
     * @return:$body
     */
    public function setBodyUs03( $user_id, $owner_recruit_id, $template, $scout_mail_id, $url = null){
      // check parameters
      if ( !$user_id || !$owner_recruit_id || !$template || !$scout_mail_id ) {
        return null;
      }

      $body   = "";
      $strJob = "";
      $strJobOwner = "";
      $dataRepeat  = array();

      $name_template = $template;
      $templateMail  = $this->Mcommon->getTemplate($template);
      $mapTemplate   = $this->Mcommon->getMapTemplate($template);
      $dataTemplate  = $this->Mcommon->us032($user_id, $owner_recruit_id, $scout_mail_id);
      $body          = $templateMail['content'];

      // string job type owner
      if ( $name_template != 'ow12') {
        $jobOwner = $this->Mcommon->getJobOwnerByOwnerRecruits($owner_recruit_id, $user_id);
        foreach ($jobOwner as $ownerJob) {
            $strJob .= ($strJob != '' ? '、' : '') . $ownerJob['jobtype_owner'];
        }
        $dataTemplate['jobtype_owner'] = $strJob;
      }
      foreach ($mapTemplate as $key => $value) {
        if ( $value['mapping_name'] && isset($dataTemplate[$value['mapping_name']]) ) {
          $replace_value = $dataTemplate[$value['mapping_name']];
          if ( $value['mapping_name'] == 'password' ) {
            $replace_value = base64_decode($dataTemplate[$value['mapping_name']]);
          }
          $body = str_replace('/--' . $value['name'] . '--/', $replace_value, $body);
          $body = str_replace('/--店舗URL--/',  $url, $body);
        }
      }

      $dataRebeat = $this->Mcommon->getUserSelect1( $owner_recruit_id, $user_id );
      $addContent = '';
      foreach ($dataRebeat as $key => $data) {
        // string job type user
        $jobUser = $this->Mcommon->getJobUser($data['user_id']);
        $strJob = '';
        foreach ($jobUser as $userJob) {
            $strJob .= ($strJob != '' ? '、' : '') . $userJob['jobtype_user'];
        }
        $data['jobtype_user'] = $strJob;
        // string job type owner

        $dataRepeat[] = $data;
      }
      foreach ($dataRepeat as $key => $data) {
        foreach ($mapTemplate as $key => $value) {
          if ( $value['mapping_name'] && isset($data[$value['mapping_name']]) )
            if (strpos($body, '/--' . $value['name'] . '--/')) {
              $body = str_replace('/--' . $value['name'] . '--/', $data[$value['mapping_name']], $body);
            }
        }
      }
      //--------------------------------------------------------
      $body = str_replace(array("\r\n", "\n", "\r"), "<br/>", $body);

      return $body;
    }
     /**
     * author: [IVS] Nguyen Ngoc Phuong
     * name : setTemplateTitleUs03
     * todo : set template mail title
     * @param int $user_id, $owner_recruits_id
     * @param string $template
     */
    function setTemplateTitleUs03($user_id = null, $owner_recruits_id = null, $template = null, $id = null) {
        $title = "";
        foreach ($template as $value) {
            $templateMail = $this->Mcommon->getTemplate($value);
            $mapTemplate = $this->Mcommon->getMapTemplate($value);
            $dataTemplate = $this->Mcommon->us032($user_id, $owner_recruits_id, $id);
            if (isset($dataTemplate['scout_pr_title']) && $pr_title = $dataTemplate['scout_pr_title']) {
                $title = $pr_title;
            } else {
                $title = $templateMail['title'];
                foreach ($mapTemplate as $key => $value) {
                    if ( $value['mapping_name'] && isset($dataTemplate[$value['mapping_name']]) ) {
                        $title = str_replace('/--' . $value['name'] . '--/', ($value['mapping_name'] == 'password') ? base64_decode($dataTemplate[$value['mapping_name']]) : $dataTemplate[$value['mapping_name']], $title);
                    }
                }
            }
            $title = str_replace(array("\r\n", "\n", "\r"), "<br/>", $title);
        }
        return $title;
    }
    public function getNewsLetterMailData($lst_usr_msg_id, $user_id, $user_email, $owner_recruit_id) {
        $ret_data = null;
        $data = $this->Mcommon->getSentNewsletterDataSs09($lst_usr_msg_id, $user_id);
        $mail_data = $this->mmail->get_unread_message($user_email);
        $curr_bonus_money = '0円';
        if ($mail_data && isset($mail_data['bonus_money']) && $mail_data['bonus_money'] > 0) {
            $curr_bonus_money = $mail_data['bonus_money'] . '円';
        }
        if ($data && isset($data['mail_title']) && isset($data['mail_content'])) {
            $ret_data = $this->getMailDataFromTemplate($data['mail_title'],
                                                       $data['mail_content'],
                                                       $user_email,
                                                       $owner_recruit_id,
                                                       $content_type = 2,
                                                       $lst_usr_msg_id,
                                                       $curr_bonus_money);
        }
        return $ret_data;
    }
    // get scout mail content
    function getUserEmailContent($owner_id, $user_id, $url, $scout_mail_id, $user_from_site = null) {
        $dataRepeat = array();
        $strJob = "";
        $strJobOwner = "";
        $phrase = '';
        if (!$owner_id || !$user_id || !$url || !$scout_mail_id) {
            return null;
        }
        // foreach ($template as $value) {
        $mail_temppate = 'us14';
        $templateMail = $this->Mcommon->getTemplate($mail_temppate);
        $mapTemplate = $this->Mcommon->getMapTemplate($mail_temppate);
        $dataTemplate = $this->Mcommon->us14($user_id, $owner_id, $scout_mail_id);
        $custom_title_flg = false;
        if (isset($dataTemplate['scout_pr_title']) && $pr_title = $dataTemplate['scout_pr_title']) {
            $title = $pr_title;
            $custom_title_flg = true;
        } else {
            $title = $templateMail['title'];
        }
        $body = $templateMail['content'];
        // string job type owner
        $jobOwner = $this->Mcommon->getJobTypeOwnerForScout($owner_id, $user_id);
        foreach ($jobOwner as $ownerJob) {
            $strJob .= ($strJob != '' ? '、' : '') . $ownerJob['jobtype_owner'];
        }
        $dataTemplate['jobtype_owner'] = $strJob;
        // change title, body (owner data)
        foreach ($mapTemplate as $key => $value) {
            $mapping_name = $value['mapping_name'];
            $variable_name = $value['name'];
            $mapping_data = null;
            if (isset($dataTemplate[$mapping_name])) {
                $mapping_data = $dataTemplate[$mapping_name];
            }
            if ($mapping_data) {
                // title
                if ($custom_title_flg == false) {
                    if ($mapping_name == 'password') {
                        $title = str_replace('/--' . $variable_name . '--/', base64_decode($mapping_data), $title);
                    } else {
                        $title = str_replace('/--' . $variable_name . '--/', $mapping_data, $title);
                    }
                }
                // body
                if ($variable_name == '店舗URL') { // skip to get URL with login info later
                    continue;
                } else {
                    // body
                    if ($mapping_name == 'password') {
                        $body = str_replace('/--' . $variable_name . '--/', base64_decode($mapping_data), $body);
                    } else {
                        $body = str_replace('/--' . $variable_name . '--/', $mapping_data, $body);
                    }
                }
            }
        }
        // Change user data
        $dataRepeat = $this->Mcommon->getUserSelect($owner_id, $user_id);
        foreach ($dataRepeat as $key => $data) {
            foreach ($mapTemplate as $key => $value) {
                if (isset($data[$value['mapping_name']])) {
                    if (strpos($body, '/--' . $value['name'] . '--/')) {
                        $body = str_replace('/--' . $value['name'] . '--/', $data[$value['mapping_name']], $body);
                    }
                }
            }
            // change store URL based on type of users
            switch($user_from_site) {
                case 0: // User inside joyspe
                break;
                case 1: // Machemoba
                $phrase = ' <br /><br />URLをクリックでポイントをGET!!<br>※クリックすることでボーナスが付与されます。<br /> ';
                $phrase .= 'ボーナスポイントGETの有効期限は本メールを受信してから' . SCOUT_MAIL_LIMIT_HOURS. '時間になります。<br>';
                $login_id = md5($data['login_id']);
                $pass = md5(base64_decode($data['password']));
                $hash = md5(date("Y-m-d H:i:s").$user_id);
                $this->Musers->updateListUserMessage(array('u_hash' => $hash), $dataTemplate['owner_recrt_id'], $user_id, $scout_mail_id);
                $url .= '?li=' . $login_id.'&lk=' . $pass . '&hash=' . $hash . $phrase;
                break;
                case 2: // Makia
                $phrase = ' <br /><br />URLをクリックでポイントをGET!!<br>※クリックすることでボーナスが付与されます。<br /> ';
                $phrase .= 'ボーナスポイントGETの有効期限は本メールを受信してから' . SCOUT_MAIL_LIMIT_HOURS. '時間になります。<br>';
                $login_id = md5($data['login_id']);
                $pass = md5(base64_decode($data['password']));
                $hash = md5(date("Y-m-d H:i:s").$user_id);
                $this->Musers->updateListUserMessage(array('u_hash' => $hash), $dataTemplate['owner_recrt_id'], $user_id, $scout_mail_id);
                $url .= '?li=' . $login_id.'&lk=' . $pass . '&hash=' . $hash . $phrase;
                break;
            }
            $body = str_replace('/--店舗URL--/', $url, $body);
        }
        //---Check items don't replace when will replace empty start ---
        foreach ($mapTemplate as $key => $value) {
            $body = str_replace('/--' . $value['name'] . '--/', "", $body);
        }
        $userEmaildata['title'] = $title;
        $userEmaildata['body'] = $body;
        return $userEmaildata;
    }

    function sendNotificationToOwner($owner_id, $user_id, $title) {
        $owner_recruit_data = $this->Mowner->getOwnerRecruit($owner_id);
      $to = isset($owner_recruit_data['new_msg_notify_email']) ? $owner_recruit_data['new_msg_notify_email'] : "";
      if ( $to) {
        $user_data = $this->Musers->get_user($user_id);
        $owner_data = $this->Mowner->getOwner($owner_id);
        $new_line = "\r\n";
        $body  = "店舗名: ".$owner_data['storename'] . $new_line . $new_line;
        $body .= "以下のユーザー様からお問い合わせがございました。" . $new_line . $new_line;
        $body .= "ユーザーＩＤ: ".$user_data['unique_id'] . $new_line;
        $body .= "地域: " . $user_data['cityName'] . $new_line;
        $body .= "身長: " . $user_data['name1']."~".$user_data['name2'] . $new_line;
        $body .= "スリーサイズ: B".$user_data['bust']." W";
        $body .= $user_data['waist']." H".$user_data['hip'] . $new_line . $new_line;
        $body .= "返信はこちらから" . $new_line;
        $body .= base_url()."owner/inbox" . $new_line . $new_line . $new_line;
        $body .= "ジョイスペ事務局" . $new_line;
        $body .= "www.joyspe.com";
        try {
            mb_send_mail($to, $title, $body , 'From: Joyspe<' . $this->config->item('smtp_user') . '>', '-f info@joyspe.com');
        } catch (phpmailerException $e) {
            //throw $e;
        } catch (Exception $e){
            //throw $e;
        }
      }
    }

    // send notification mail to owner
    // after receiving travel expense request from user
    function sendTravelExpRequestNotifToOwner($owner_id) {
        $owner_data = $this->Mowner->getOwner($owner_id);
        $title = '【ジョイスペ】面接交通費の承認依頼';

        $body = $owner_data['storename'] . " 様" . PHP_EOL . PHP_EOL;
        $body .= "お世話になっております。" . PHP_EOL;
        $body .= "ジョイスペ事務局でございます。" . PHP_EOL . PHP_EOL;
        $body .= "会員さまより面接交通費の申請がございました。" . PHP_EOL;
        $body .= "承認を頂くことでサイトより交通費が支給されますので" . PHP_EOL;
        $body .= "お手数ではございますがご確認をお願いいたします。" . PHP_EOL . PHP_EOL;
        $body .= "承認の確認はこちらから" . PHP_EOL;
        $body .= base_url() . "owner/index" . PHP_EOL . PHP_EOL . PHP_EOL;
        $body .= "ジョイスペ事務局" . PHP_EOL;
        $body .= "info@joyspe.com" . PHP_EOL;
        $body .= "営業時間　月～金11:00～19:00(土日祝日を除く）" . PHP_EOL;

        $this->email->set_newline(PHP_EOL);
        try {
            $to = $owner_data['email_address'];
            $header = "From: Joyspe<" . $this->config->item('smtp_user') . ">" . PHP_EOL;
            $result = mb_send_mail($to, $title, $body , $header);
            /*
            $result =$this->email
            ->from($this->config->item('smtp_user'),"joyspe")
            ->to($owner_data['email_address'])
            ->subject($title)
            ->message($body)
            ->send();
            */
        } catch (phpmailerException $e) {
        //throw $e;
        } catch (Exception $e){
        //throw $e;
        }
    }

    // 交通費申請処理を行う(AJAX)
    // 戻り値：JSON形式
    //   "ret":true,  "error_code" : 0 //申請成功
    //   "ret":false, "error_code" : 1 //未ログインエラー
    //   "ret":false, "error_code" : 2 //データ挿入失敗
    //   "ret":false, "error_code" : 3 //受付終了
    function insertUserTravelExpense() {
        $ret_array = array();

        $owner_id = $this->input->post('owner_id');
        $user_id = UserControl::getId();
        if ( !$user_id ) {
            $ret_array = array("ret"=>false, "error_code" => 1); //未ログインエラー
        } else {
            $campaign_data  = $this->MCampaign->getLatestCampaign();
            if ( $campaign_data ) {
                $request_status = $this->Mtravel_expense->canRequestTrvelExpense(
                        $user_id,
                        $owner_id,
                        $campaign_data['id'],
                        $campaign_data['travel_expense'],
                        $campaign_data['budget_money'],
                        $campaign_data['max_request_times'],
                        $campaign_data['multi_request_per_owner_flag']);
                if ( $request_status != 0 ) {
                    $ret_array = array("ret"=>false, "error_code" => 3); //受付終了
                } else {
                    $data = array(
                        'user_id'       => $user_id,
                        'owner_id'      => $owner_id,
                        'interview_date' => $this->input->post('reqDate'),
                        'campaign_id'   => $this->input->post('campaign_id'),
                        'status'        => 0,
                        'requested_date' => date('y-m-d H:i:s'),
                        'created_date'  => date('y-m-d H:i:s'),
                    );

                    $insert = $this->Mtravel_expense->insertUserTravelExpense($data);

                    if ( $insert ) {
                        $ret_array = array("ret"=>true, "error_code" => 0); // 成功
                        $this->sendTravelExpRequestNotifToOwner($owner_id);
                    } else {
                        $ret_array = array("ret"=>false, "error_code" => 2); // データ挿入失敗
                    }
                }
            }
        }

        echo json_encode( $ret_array );
        exit;
    }

    // キャンペーン中の場合、バナー情報取得
    function getLatestBanner() {
        $ret = null;

        $latest_campaign = $this->MCampaign->getLatestCampaign();
        if ( $latest_campaign ) {
            // キャンペーンの予算チェック
            $is_in_budget = $this->Mtravel_expense->isInBudget(
                                $latest_campaign['id'],
                                $latest_campaign['travel_expense'],
                                $latest_campaign['budget_money']);
            if ( $is_in_budget ) {
                $ret = $latest_campaign;
            }
        }
        return $ret;
    }

    // 管理画面より、交通費申請の承認後に、会員たちにメールを通知する
    function sendNotifToUserExpenseApproval( $user_id ) {
        $user_data = $this->Musers->get_users_by_id($user_id);
        if ( $user_data ) {
            $title = '【ジョイスペ】面接交通費が支給されました。';

            $body = $user_data['unique_id'] . " 様" . PHP_EOL . PHP_EOL;
            $body .= "こんにちは。" . PHP_EOL;
            $body .= "ジョイスペ事務局です。" . PHP_EOL ;
            $body .= "面接交通費が支給されました。" . PHP_EOL;
            $body .= "お手数ではございますがご確認をお願いいたします。" . PHP_EOL;
            $body .= base_url() . "user/bonus/bonus_list" . PHP_EOL . PHP_EOL ;
            $body .= "※尚、支給時には年齢のわかる身分証明書のご提示が必要となります。身分証明書はメニュー内のプロフィール確認よりアップロードできます。". PHP_EOL . PHP_EOL;
            $body .= "ジョイスペ事務局" . PHP_EOL;
            $body .= "info@joyspe.com" . PHP_EOL;
            $body .= "営業時間　月～金11:00～19:00(土日祝日を除く）" . PHP_EOL;

            $this->email->set_newline(PHP_EOL);
            try {
                $to = $user_data['email_address'];
                $header = "From: Joyspe<" . $this->config->item('smtp_user') . ">" . PHP_EOL;
                $result = mb_send_mail($to, $title, $body , $header);
            } catch (phpmailerException $e) {
            } catch (Exception $e){
            }
        }
    }

    function sendCampaignRequestNotifToOwner($owner_id) {
        $owner_data = $this->Mowner->getOwner($owner_id);
        $title = '【ジョイスペ】体験入店申請をご確認願います。';

        $body = $owner_data['storename'] . " 様" . PHP_EOL . PHP_EOL;
        $body .= "いつもご利用頂き誠にありがとうございます。" . PHP_EOL;
        $body .= "ジョイスペでございます。" . PHP_EOL . PHP_EOL;
        $body .= "会員より体験入店の申請がございました。" . PHP_EOL . PHP_EOL;
        $body .= "お手数ではございますが申請内容をご確認お願いいたします。" . PHP_EOL . PHP_EOL;
        $body .= "ログインはこちら" . PHP_EOL;
        $body .= base_url() . "owner/login" . PHP_EOL . PHP_EOL . PHP_EOL;
        $body .= "-------------------------------------" . PHP_EOL;
        $body .= "■ジョイスペサポートセンター" . PHP_EOL;
        $body .= "info@joyspe.com" . PHP_EOL;
        $body .= "■サポート対応時間：平日10:00〜18:00" . PHP_EOL;
        $body .= "土日・祝日を除く" . PHP_EOL;
        $body .= "-------------------------------------" . PHP_EOL;

        $this->email->set_newline(PHP_EOL);
        try {
            $to = $owner_data['email_address'];
            $header = "From: Joyspe<" . $this->config->item('smtp_user') . ">" . PHP_EOL;
            $result = mb_send_mail($to, $title, $body , $header);
            /*
            $result =$this->email
            ->from($this->config->item('smtp_user'),"joyspe")
            ->to($owner_data['email_address'])
            ->subject($title)
            ->message($body)
            ->send();
            */
        } catch (phpmailerException $e) {
        //throw $e;
        } catch (Exception $e){
        //throw $e;
        }
    }

    function sendNotifToUserCampaignApproval( $user_id ) {
        $user_data = $this->Musers->get_users_by_id($user_id);
        if ( $user_data ) {
            $title = '【ジョイスペ】体験入店の申請が受理されました。';

            $body = $user_data['unique_id'] . " 様" . PHP_EOL . PHP_EOL;
            $body .= "いつもご利用頂き誠にありがとうございます。" . PHP_EOL;
            $body .= "ジョイスペでございます。" . PHP_EOL . PHP_EOL ;
            $body .= "店舗より体験入店の申請が承認されました。" . PHP_EOL . PHP_EOL;
            $body .= "ジョイスペにログインして頂き内容をご確認ください。" . PHP_EOL . PHP_EOL;
            $body .= "ログインはこちら" . PHP_EOL;
            $body .= base_url() . "user/login/" . PHP_EOL . PHP_EOL . PHP_EOL;
            $body .= "-------------------------------------" . PHP_EOL;
            $body .= "■ジョイスペサポートセンター" . PHP_EOL;
            $body .= "info@joyspe.com" . PHP_EOL . PHP_EOL;
            $body .= "■サポート対応時間：平日10:00〜18:00" . PHP_EOL;
            $body .= "土日・祝日を除く" . PHP_EOL;
            $body .= "-------------------------------------" . PHP_EOL;

            $this->email->set_newline(PHP_EOL);
            try {
                $to = $user_data['email_address'];
                $header = "From: Joyspe<" . $this->config->item('smtp_user') . ">" . PHP_EOL;
                $result = mb_send_mail($to, $title, $body , $header);
            } catch (phpmailerException $e) {
            } catch (Exception $e){
            }
        }
    }

    function sendNotifToUserCampaignDisapproval( $user_id ) {
        $user_data = $this->Musers->get_users_by_id($user_id);
        if ( $user_data ) {
            $title = '【ジョイスペ】体験入店の申請内容をご確認ください';

            $body = $user_data['unique_id'] . " 様" . PHP_EOL . PHP_EOL;
            $body .= "いつもご利用頂き誠にありがとうございます。" . PHP_EOL;
            $body .= "ジョイスペでございます。" . PHP_EOL . PHP_EOL ;
            $body .= "先日申請頂きました体験入店の申請でございますが" . PHP_EOL;
            $body .= "該当店舗より承認を得ることができませんでした。" . PHP_EOL . PHP_EOL;
            $body .= "お手数ではございますが申請内容をご確認お願いいたします。" . PHP_EOL . PHP_EOL;
            $body .= "ログインはこちら" . PHP_EOL;
            $body .= base_url() . "user/login/" . PHP_EOL . PHP_EOL . PHP_EOL;
            $body .= "-------------------------------------" . PHP_EOL;
            $body .= "■ジョイスペサポートセンター" . PHP_EOL;
            $body .= "info@joyspe.com" . PHP_EOL . PHP_EOL;
            $body .= "■サポート対応時間：平日10:00〜18:00" . PHP_EOL;
            $body .= "土日・祝日を除く" . PHP_EOL;
            $body .= "-------------------------------------" . PHP_EOL;

            $this->email->set_newline(PHP_EOL);
            try {
                $to = $user_data['email_address'];
                $header = "From: Joyspe<" . $this->config->item('smtp_user') . ">" . PHP_EOL;
                $result = mb_send_mail($to, $title, $body , $header);
            } catch (phpmailerException $e) {
            } catch (Exception $e){
            }
        }
    }

    function setTemplateTitleNew($user_id,$id) {
        $new_title = $this->Mcommon->newTemplateTitle($user_id,$id);
        return $new_title['pr_title'];
    }
    function setTemplateTitleSs09($user_id,$lum_id){
        $mailTitle = $this->Musers->setMailTitleSs09($user_id,$lum_id);
        if ($mailTitle) {
            return $mailTitle['mail_title'];
        } else {
            return "";
        }
	}

    // update login bonus when login
    function updateLoginBonus($user_id, $user_from_site, $last_visit_date) {
        if (!$user_id || !$user_from_site || !$last_visit_date) {
            return false;
        }
        //check if user has already login within this day
        if ($user_from_site && DATE('Y-m-d') > DATE('Y-m-d', strtotime($last_visit_date))) {
            $noOfDaysLogin = $this->Musers->updateUserLoginNoOfDays($user_id);
            //for makia users
            if ($user_from_site == 1 || $user_from_site == 2) {
                // check if user is joining a campaign to grant bonus points
                if ($this->Musers->isUserInCampaign($user_id)) {
                    //check and grant user total login bonus
                    $loginBonusData = $this->Musers->getLoginBonusPoint($noOfDaysLogin);
                    if (count($loginBonusData) > 0) {
                        $add_point_flag = $this->Musers->updateBonusPoint($user_id,
                                            $loginBonusData['bonus_point'],
                                            BONUS_REASON_LOGIN);
                    }
                }
            }
        }
        $this->Musers->insertUserLoginLog($user_id);
        // update result each time login
        $this->Musers->checkAndUpdateCampaignProgress($user_id);
    }

    function sendToAdminNonMember($owrId, $email, $uname, $age, $content, $title) {
        $ret = false;
        $owner_recruit_data = $this->Mowner->getOwnerRecruitByowrId($owrId);
        $to = isset($owner_recruit_data['new_msg_notify_email']) ? $owner_recruit_data['new_msg_notify_email'] : "";
        if ($to) {
            $new_line = "\r\n";
            $body = "店舗名: " . $owner_recruit_data['storename'] . "様". $new_line . $new_line;
            $body .= "以下のユーザー様からお問い合わせがございました。" . $new_line . $new_line;
            $body .= "ユーザー名前: " . $uname . $new_line;
            $body .= "年齢： " . $age . $new_line;
            $body .= "返信はこちらから" . $new_line;
            $body .= base_url() . "owner/inbox" . $new_line . $new_line . $new_line;
            $body .= "ジョイスペ事務局" . $new_line;
            $body .= "www.joyspe.com";

            try {
                $ret =mb_send_mail($to, $title, $body , 'From: ' . $email . PHP_EOL );
            } catch (phpmailerException $e) {
            } catch (Exception $e){
            }
        }
        return $ret;
    }

    function sendToNonMemberAdmin($owner_recruit_data, $noneMemberInfo, $owner_data, $title, $content){
        $ret = false;
        $content_none_member = $noneMemberInfo['name'] . " 様" . PHP_EOL . PHP_EOL;
        $content_none_member .= "いつもご利用頂き誠にありがとうございます。" . PHP_EOL;
        $content_none_member .= "お問い合わせ頂いた店舗様から返信がありました。" . PHP_EOL . PHP_EOL;
        $content_none_member .= "========" . PHP_EOL;
        $content_none_member .= $content . PHP_EOL . PHP_EOL;
        $content_none_member .= "店舗名: " . $owner_data['storename'] . PHP_EOL;
        $content_none_member .= "電話番号: " . $owner_recruit_data['apply_tel'] . PHP_EOL;
        $content_none_member .= "メールアドレス: " . $owner_recruit_data['apply_emailaddress'] . PHP_EOL . PHP_EOL;
        $content_none_member .= "【匿名の返信はこちら】" . PHP_EOL;
        $content_none_member .= base_url() . "user/joyspe_user/company/" . $owner_recruit_data["id"] . PHP_EOL;
        $content_none_member .= "========" . PHP_EOL . PHP_EOL;
        $content_none_member .= "ジョイスペ事務局" . PHP_EOL;
        $content_none_member .= "www.joyspe.com";
        try {
            $ret = mb_send_mail($noneMemberInfo['email_address'], "Re: " .$title, $content_none_member , 'From: Joyspe<' . $this->config->item('smtp_user') . '>', '-f info@joyspe.com' );
        } catch (phpmailerException $e) {
        } catch (Exception $e){
        }
        return $ret;
    }

    /**
     * Generate captcha image.
     *
     * @param string $module
     * @return  captcha data in an array format.
     */
    public function generate_captcha($module)
    {
        $this->load->helper('captcha');
        $original_string = array_merge(range(0,9), range('a','z'), range('A', 'Z'));
        $original_string = implode("", $original_string);
        $random_number_and_words = substr(str_shuffle($original_string), 0, 6);
        $path = "./public/".$module."/captcha/";
        //create the folder if it's not already exists
        if (!is_dir($path)) {
            mkdir($path,0755,TRUE);
        }
        $captcha = array (
            'word'	=> $random_number_and_words,
            'img_path'	=> $path,
            'img_url'	=> base_url().$path,
            'font_path'	=> './fonts/texb.ttf',
            'img_width'	=> '300',
            'img_height' => '60',
            'expiration' => '7200'
        );

        return create_captcha($captcha);
    }

    /**
     * Check if the captcha inputted value is correct/match.
     *
     * @param   string  $str an inputted captcha value.
     * @return  true or false
     */
    public function check_captcha($str)
    {
        //delete old captchas
        $this->Mcaptcha->delete_old_captchas();
        //check if captcha exist
        $is_captcha_exist = $this->Mcaptcha->check_captcha_exist($str);
        if (!$is_captcha_exist) {
            $this->form_validation->set_message('check_captcha', '画像に表示される字を入力してください。');
            return false;
        } else {
            return true;
        }
    }

    /**
     * Display captcha if fail login times >= LOGIN_FAILS_LIMIT.
     * @param   string  $module and string unique_id.
     * @return  false or array $img
     */
    public function display_captcha($module, $unique_id, $email_address)
    {
        //Reset fail login times if last login time(updated_date) is passed 10 mins.
        $is_reset = $this->Mcaptcha->reset_fail_login_times($module, $unique_id, $_SERVER["REMOTE_ADDR"], true, $email_address);
        if ($is_reset == false) {
            // Get the fail_login_times.
            $fail_login_times = $this->Mcaptcha->get_fail_login_times($module, $unique_id, $_SERVER["REMOTE_ADDR"]);
            if (!$fail_login_times) {
                //insert login_fail data
                $this->Mcaptcha->insert_login_fail_data($module, $unique_id, $_SERVER["REMOTE_ADDR"], $email_address);
            } else {
                // Update login fail times.
                $is_update = $this->Mcaptcha->update_fail_login_times($module, $unique_id, $_SERVER["REMOTE_ADDR"], $fail_login_times['fail_login_times'], $email_address);
                if ($is_update) {
                    $fail_login_times = $fail_login_times['fail_login_times'] + 1;
                    if ($fail_login_times >= LOGIN_FAILS_LIMIT) {
                        //generate captcha
                        $img = $this->generate_captcha($this ->router->fetch_module());
                        $captcha_data = array(
                        'captcha_time'	=> $img['time'],
                        'ip_address'	=> $this->input->ip_address(),
                        'word'	=> $img['word']
                        );
                        //insert captcha data in captcha table.
                        $this->Mcaptcha->insert_captcha($captcha_data);
                        return $img;
                    }
                }
            }
        }
        return false;
    }

    /**
    * Create a new user with existing ID from the current sites(makia, machemoba)
    *
    * @param $old_id the current ID in the the sites
    * @param $from_site 1: from machemoba, 2: from makia
    * @return true: success, false: failed
    */
    function create_user_with_waiting_state($old_id, $from_site){
        $ret = false;
        // マシェリのAPIでログインID取得
        if ($old_id){
            $data = array(
                'unique_id' => random_string('alnum', 8),
                'old_id' => $old_id,
                'password' => base64_encode('admin'),
                'user_status' => 4, //waiting state
                'user_from_site' => $from_site,
                'remote_scout_flag' => 1,
                'accept_remote_scout_datetime' => date("y-m-d H:i:s"),
                'set_send_mail' => 0,
                'display_flag'=> 1,
                'email_address'=> random_string('unique'),
                'created_date' => date("y-m-d H:i:s"),
                'temp_reg_date'=> date("y-m-d H:i:s"),
                'offcial_reg_date'=> date("y-m-d H:i:s")
                /*,'last_visit_date'=> date("y-m-d H:i:s")*/
            );

            $result = $this->Musers->insert_users($data);
            if ($result) {
                $user_id = $this->Musers->getUserIDFromOldID($old_id);
                if ($user_id){
                    // User_recruitsに新データ追加
                    $ur_data = array(
                        'user_id'   => $user_id,
                        'age_id'    => 2, //20~24
                        'height_id' => 3, //155~159
                        'city_id'   => 8, //東京
                        'created_date' => date("y-m-d H:i:s"),
                        'display_flag' => 1
                    );
                    $this->Musers->insert_User_recruits($ur_data);
                    // 報酬用のデータ作成
                    $this->Musers->addNewScoutMailBonus($user_id);
                    $ret = true;
                }
            }
        }
        return $ret;
    }

    /*
    * Get mail content for daily mail
    *
    * @param all params to match template variable with real content
    */
    function getDailyMailContent($base_url, $title_template, $body_template, $user_email, $owner_recruit_id = null,
                                 $encoded_login_str = "", $curr_bonus_money="", $unread_no_str = "") {

        $ret = null;
        $result_variable = $this->mmail->variableList();
        if (!$base_url || !$result_variable || !$title_template || !$body_template || !$owner_recruit_id || !$user_email) {
            return null;
        }
        $dataTemplate = $this->mmail->emailQuery($user_email);
        if (!$dataTemplate) {
            return null;
        }

        $owner_url = $base_url . "/user/joyspe_user/company/" . $owner_recruit_id;
        $top_page  = $base_url . '/user/joyspe_user/index/';
        if ($encoded_login_str) {
            $top_page .= '?lparam=' . $encoded_login_str;
            $owner_url .= '?lparam=' . $encoded_login_str;
        }

        // string job type owner
        $job_owner = $this->Mcommon->getJobOwnerRecruito01($owner_recruit_id);
        $str_owner_job = "";
        foreach ($job_owner as $job) {
            $str_owner_job .= ($str_owner_job != '' ? '、' : '') . $job['jobtype_owner'];
        }
        if ($str_owner_job) {
            $dataTemplate['jobtype_owner'] = $str_owner_job;
        }

        foreach ($result_variable as $value) {
            $mapping_name     = $value['mapping_name'];
            $mapping_variable = $value['name'];
            if (isset($dataTemplate[$mapping_name])) {
                if (strpos($body_template, '/--' . $mapping_variable . '--/', 0 ) !== false) {
                    if ($mapping_name == 'password') {
                        $body_template = str_replace('/--'.$mapping_variable.'--/', base64_decode($dataTemplate[$mapping_name]), $body_template);
                    } else {
                        $body_template = str_replace('/--'.$mapping_variable.'--/', $dataTemplate[$mapping_name], $body_template);
                    }
                }
                if (strpos($title_template, '/--' . $mapping_variable . '--/', 0) !== false) {
                    if ($mapping_name == 'password') {
                        $title_template = str_replace('/--'.$mapping_variable.'--/', base64_decode($dataTemplate[$mapping_name]), $title_template);
                    } else {
                        $title_template = str_replace('/--'.$mapping_variable.'--/', $dataTemplate[$mapping_name], $title_template);
                    }
                }
            }
        }

        if (strpos($body_template,'/--店舗URL--/', 0) !== false) {
            $owner_url .= PHP_EOL . "本リンクによる自動ログインは送信された時間から" . LOGIN_EXPIRE_HOURS . "時間内になります。";
            $body_template = str_replace('/--店舗URL--/', $owner_url, $body_template);
        }

        if (strpos($body_template,'/--トップページURL--/', 0) !== false) {
            $top_page .= PHP_EOL . "本リンクによる自動ログインは送信された時間から" . LOGIN_EXPIRE_HOURS . "時間内になります。";
            $body_template = str_replace('/--トップページURL--/', $top_page, $body_template);
        }

        if (strpos($body_template,'/--未読のスカウトメール--/', 0) !== false) {
            $body_template = str_replace('/--未読のスカウトメール--/', $unread_no_str , $body_template);
        }

        if (strpos($body_template,'/--現在の報酬額--/', 0) !== false) {
            $body_template = str_replace('/--現在の報酬額--/', $curr_bonus_money , $body_template);
        }

        $ret['title'] = $title_template;
        $ret['body'] = $body_template;

        return $ret;
    }

    /**
    * Get fixed current event information in a town from its alpha name
    *
    * @param    string $town_alph_name the alpha name(town name in English) of a town(from vjsolutions.mst_towns)
    * @return   the current event information in a town
    */
    public function get_curr_town_event_info($town_alph_name) {
        $ret = "";
        if ($town_alph_name == "tsuruoka") {
            $ret = '<b>2015年7月鶴岡市のイベント情報</b>

            ■温海トライアスロン大会（7月19日）
            ■鮎釣りマル得企画
            ■あんべみ処
            ■月山山開き（7月1日）
            ■国指定重要無形民俗文化財黒川能　野外能楽　第３２回「水焔の能」
            ■鈴カラ竹まつり（7月上旬）
            ■清正公祭（7月24日前後）
            ■鼠ヶ関漁船クルージング（7月中旬～8月下旬）
            ■鼠ヶ関天然岩ガキフェスティバル（７月下旬）
            ■花まつり（7月15日）
            ■【山形DC開催記念】摩耶山（越沢口）夏の登山会
            ■湯田川温泉ほたるまつり（6月中旬～7月中旬）
            ■湯田川神楽（温泉清浄祭）（7月下旬）
            ■湯ノ沢岳山開き（７月下旬）
            ■由良イワガキまつりと漁船パレード乗船会（7月下旬）


            鶴岡で風俗バイトをしている人必見！鶴岡市で７月に行われるイベントで売上に影響がありそうなイベントはトライアスロン？筋肉ムキムキのお兄様方がたくさん来るので集客につなげたいところです。山開きも行われる山が多いので夏本番が始まりますね！

            ※イベント名の横に☆の印があるイベントは集客の期待があるイベントに表示されています。


            <a href="./ibent201508">2015年8月鶴岡市のイベント情報</a><a href="./ibent201506">2015年6月鶴岡市のイベント情報</a>';
        }

        return $ret;
    }

    /**
    * get latest post from Column data(wordpress)
    *
    * @param  int $post_cnt number of posts we will get
    * @return array of post data with the following structure
    *========================
    * 1. pubdate (YYYY-MM-DD)
    * 2. category
    * 3. title
    * 4. picture
    * 5. description
    * 6. link
    *========================
    */
    public function get_latest_column_posts($post_cnt = 4, $image_flag = true) {
        $ret_array = array();
        if (ENVIRONMENT != 'production') { // for testing
            $ret_array[0]['pubdate'] = "2015-07-29 15:44:05";
            $ret_array[0]['title'] = "悲しい合コン敗者の女たちの特徴";
            $ret_array[0]['link'] = "http://www.joyspe.com/column/?p=218";
            $ret_array[0]['category'] = "恋愛, ジョイスペコンシェルジュのつぶやき";
            if ($image_flag) {
                $ret_array[0]['picture'] = "http://joyspe.com/column/wp-content/uploads/悲しい合コン敗者の女たちの特徴-300x200.jpg";
            }
            $ret_array[0]['description'] = "何度合コンを重ねても、いい男と出会えない女たちも多 ...";
            return $ret_array;
        }
        $post_cnt = (int)$post_cnt;
        if ($post_cnt <= 0) {
            $post_cnt = 4; // default value;
        }

        $db_wordpress = $this->load->database('wordpress', TRUE, TRUE);
        if (!$db_wordpress) {
            return $ret_array;
        }
        $query = "SELECT DISTINCT p.post_date as pubdate, p.post_title as title, p.post_content, p.guid as link, GROUP_CONCAT(t.name SEPARATOR ', ') as category
                FROM wp_joyspeposts p
                LEFT JOIN wp_joyspeterm_relationships rel ON rel.object_id = p.ID
                LEFT JOIN wp_joyspeterm_taxonomy tax ON tax.term_taxonomy_id = rel.term_taxonomy_id
                LEFT JOIN wp_joyspeterms t ON t.term_id = tax.term_id
                where p.post_status = 'publish' and p.post_type = 'post'
                group by p.id
                order by p.post_date desc limit ?";
        $result = $db_wordpress->query($query, $post_cnt);
        if ($result && $data_array = $result->result_array()) {
            foreach($data_array as $data) {
                if ($image_flag) {
                    // get featured picture
                    $flag = preg_match( '/<img.+?src=[\'"]([^\'"]+?)[\'"].*?>/msi', $data['post_content'], $matches );
                    $data['picture'] = "";
                    if ($flag && $matches) {
                        $data['picture'] = $matches[1];
                    }
                }
                // get first post_content text
                $find_close_a_tag = strpos($data['post_content'], '</a>');
                if ($find_close_a_tag) {
                    $truncated_string = substr($data['post_content'], $find_close_a_tag + 4);
                } else {
                    $truncated_string = $data['post_content'];
                }
                $truncated_string = trim($truncated_string);
                $truncated_string = $this->_japanese_character_limiter($truncated_string, 25);
                // get description from post_content
                $data['description'] = $truncated_string;
                unset($data['post_content']); // remove post_content
                $ret_array[] = $data;
            }
        }

        return $ret_array;
    }
    /**
    * get n Japanese characters from a string
    *
    * @param  string $str string to get characters from
    * @param int $n number of characters
    * @param string $end_char strign to be put at the end of a truncated string
    * @return truncated string
    */
    public function _japanese_character_limiter($str, $n = 500, $end_char = ' ...' ) {
        $CI =& get_instance();
        $charset = $CI->config->item('charset');
        if ( mb_strlen( $str , $charset) < $n ) {
            return $str ;
        }
        $str = preg_replace( "/\s+/iu", ' ', str_replace( array( "\r\n", "\r", "\n" ), ' ', $str ) );
        if ( mb_strlen( $str , $charset) <= $n ) {
            return $str;
        }
        return mb_substr(trim($str), 0, $n ,$charset) . $end_char ;
    }
}

?>

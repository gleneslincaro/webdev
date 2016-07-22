<?php

class HelperApp {

    private static $CI;

    public function HelperApp() {

        self::$CI = & get_instance();
    }

    public static function get_avatar_sizes() {
        $array = array(
            'thumbnail' => array('w' => 200, 'h' => 200, 'crop' => true),
            'small' => array('w' => 100, 'h' => 100, 'crop' => true),
            'mini' => array('w' => 50, 'h' => 50, 'crop' => true)
        );
        return $array;
    }

    public static function add_cookie($params = array()) {
        self::$CI->session->set_userdata($params);
    }

    public static function get_cookie($name) {
        //    return self::$CI->session->userdata($name);
    }

    public static function get_all_cookie_data() {
        return self::$CI->session->all_userdata();
    }

    public static function remove_cookie($name) {
        //can be an item or an array
        self::$CI->session->unset_userdata($name);
    }

    public static function clear_cookie() {
        self::$CI->session->sess_destroy();
    }

    public static function start_session() {
        // $state = session_status();
        //if ($state < 2)
       if (!isset($_SESSION)) {
            $host_array = explode('.', $_SERVER['HTTP_HOST']); 
            $last_key = count($host_array) - 1; 
            $domain = '.' .$host_array[$last_key - 1] . "." . $host_array[$last_key];
            session_set_cookie_params(0, '/', $domain);
            session_start();
        }
    }

    public static function add_session($key, $value) {
        self::start_session();
        $_SESSION[$key] = $value;
    }

    public static function get_session($key) {
        self::start_session();
        return isset($_SESSION[$key]) ? $_SESSION[$key] : null;
    }

    public static function remove_session($key) {
        self::start_session();
        unset($_SESSION[$key]);
    }

    public static function clear_session() {
        self::start_session();
        session_destroy();
    }

    public static function session_to_array() {
        self::start_session();
        return $_SESSION;
    }

    /* public static function get_paging($ppp, $base_url, $total_rows, $current_page) {
      $config['base_url'] = $base_url;
      $config['total_rows'] = $total_rows;
      $config['per_page'] = $ppp;
      $config['use_page_numbers'] = TRUE;
      $config['cur_page'] = $current_page;
      $config['uri_segment'] = 4;
      $config['full_tag_open'] = '<div class="pagination pagination-right"><ul>';
      $config['full_tag_close'] = '</ul></div>';
      $config['first_link'] = 'First';
      $config['first_tag_open'] = '<li>';
      $config['first_tag_close'] = '</li>';
      $config['next_link'] = '&gt;';
      $config['next_tag_open'] = '<li>';
      $config['next_tag_close'] = '</li>';
      $config['prev_link'] = '&lt;';
      $config['prev_tag_open'] = '<li>';
      $config['prev_tag_close'] = '</li>';
      $config['cur_tag_open'] = '<li class="active"><a href="#">';
      $config['cur_tag_close'] = '</a></li>';
      $config['num_tag_open'] = '<li>';
      $config['num_tag_close'] = '</li>';
      $config['last_link'] = 'Last';
      $config['last_tag_open'] = '<li>';
      $config['last_tag_close'] = '</li>';
      self::$CI->pagination->initialize($config);
      return self::$CI->pagination->create_links();
      } */

    /**
     * @author [IVS] Nguyen Van Phong - Lam Tu My Kieu
     * @name   get_paging
     * @todo   get paging
     * @param  
     * @return void
     */
    public static function get_paging($ppp, $base_url, $total_rows, $current_page, $style = 'default') {
        $config['base_url'] = $base_url;
        $config['total_rows'] = $total_rows;
        $config['per_page'] = $ppp;
        $config['use_page_numbers'] = TRUE;
        $config['cur_page'] = $current_page;
        $config['uri_segment'] = 4;
        
        if ($style == 'default') {
            $config['full_tag_open'] = '<span> &nbsp;';
            $config['full_tag_close'] = '&nbsp; </span>';
            $config['first_link'] = '';
            $config['first_tag_open'] = '<span>';
            $config['first_tag_close'] = '</span>';
            $config['next_link'] = '&gt;';
            $config['next_tag_open'] = '<span>&nbsp    ';
            $config['next_tag_close'] = '</span>';
            $config['prev_link'] = '&lt;';
            $config['prev_tag_open'] = '<span>&nbsp    ';
            $config['prev_tag_close'] = '</span>';
            $config['cur_tag_open'] = '<span>&nbsp';
            $config['cur_tag_close'] = '</span>';
            $config['num_tag_open'] = '<span>&nbsp    ';
            $config['num_tag_close'] = '</span>';
            $config['last_link'] = '';
            $config['last_tag_open'] = '<span>&nbsp    ';
            $config['last_tag_close'] = '</span>';
        } else if ($style == 'bootstrap') {
            $config['full_tag_open'] = '<ul class="pagination">';
            $config['full_tag_close'] = '</ul>';
            $config['first_link'] = '&lsaquo;';
            $config['last_link'] = '&rsaquo;';
            $config['first_tag_open'] = '<li>';
            $config['first_tag_close'] = '</li>';
            $config['prev_link'] = '&laquo';
            $config['prev_tag_open'] = '<li class="prev">';
            $config['prev_tag_close'] = '</li>';
            $config['next_link'] = '&raquo';
            $config['next_tag_open'] = '<li>';
            $config['next_tag_close'] = '</li>';
            $config['last_tag_open'] = '<li>';
            $config['last_tag_close'] = '</li>';
            $config['cur_tag_open'] = '<li class="active"><a href="#">';
            $config['cur_tag_close'] = '</a></li>';
            $config['num_tag_open'] = '<li>';
            $config['num_tag_close'] = '</li>';
        }

        if (count($_GET) > 0){
          $config['suffix'] = '?' . http_build_query($_GET, '', "&");
          $config['first_url'] = $config['base_url'].'?'.http_build_query($_GET,'', "&");
        }

        self::$CI->pagination->initialize($config);
        return self::$CI->pagination->create_links();
    }
		
    public static function get_paging1($ppp, $base_url, $total_rows, $current_page) {
      $config['base_url'] = $base_url;
      $config['total_rows'] = $total_rows;
      $config['per_page'] = $ppp;
      $config['use_page_numbers'] = TRUE;
      $config['cur_page'] = $current_page;
      $config['uri_segment'] = 7;
      $config['full_tag_open'] = '<span> &nbsp;';
      $config['full_tag_close'] = '&nbsp; </span>';
      $config['first_link'] = '';
      $config['first_tag_open'] = '<span>';
      $config['first_tag_close'] = '</span>';
      $config['next_link'] = '&gt;';
      $config['next_tag_open'] = '<span>&nbsp    ';
      $config['next_tag_close'] = '</span>';
      $config['prev_link'] = '&lt;';
      $config['prev_tag_open'] = '<span>&nbsp    ';
      $config['prev_tag_close'] = '</span>';
      $config['cur_tag_open'] = '<span>&nbsp';
      $config['cur_tag_close'] = '</span>';
      $config['num_tag_open'] = '<span>&nbsp    ';
      $config['num_tag_close'] = '</span>';
      $config['last_link'] = '';
      $config['last_tag_open'] = '<span>&nbsp    ';
      $config['last_tag_close'] = '</span>';


      if (count($_GET) > 0){
        $config['suffix'] = '?' . http_build_query($_GET, '', "&");
        $config['first_url'] = $config['base_url'].'?'.http_build_query($_GET,'', "&");
      }

      self::$CI->pagination->initialize($config);
      return self::$CI->pagination->create_links();
    }
    
    public static function do_resize($remote_url, $sizes, $filename, $upload_dir, $old_filename = '') {

        $data = array();
        $img = new SimpleImage();
        $img->load($remote_url);
        self::make_folder($upload_dir);
        if ($old_filename)
            @unlink($upload_dir . $old_filename);
        $filepath = $upload_dir . $filename;
        $width = $img->getWidth();
        $height = $img->getHeight();
        $img->resizeToThumb($width, $height);
        $img->save_with_default_imagetype($filepath);

        foreach ($sizes as $size_name => $size) {
            $img->load($filepath);

            if ($size['w'] == 0) {
                $new_filename = $size['h'] . 'h-' . $filename;
                if ($old_filename)
                    $new_oldfilename = $size['h'] . 'h-' . $old_filename;
            }
            elseif ($size['h'] == 0) {
                $new_filename = $size['w'] . 'w-' . $filename;
                if ($old_filename)
                    $new_oldfilename = $size['w'] . 'w-' . $old_filename;
            }
            else {
                $new_filename = $size['w'] . 'x' . $size['h'] . '-' . $filename;
                if ($old_filename)
                    $new_oldfilename = $size['w'] . 'x' . $size['h'] . '-' . $old_filename;
            }
            $folder = str_replace(Helper::upload_dir() . "media/", '', $upload_dir);

            $new_size = '';
            if ($size['w'] == 0) {
                if ($height > $size['h'])
                    $new_size = $img->resizeToHeight($size['h']);
            }
            elseif ($size['h'] == 0) {
                if ($width > $size['w'])
                    $new_size = $img->resizeToWidth($size['w']);
            }
            else {
                if ($height >= $size['h'] && $width >= $size['w'])
                    $new_size = $img->resizeToThumb($size['w'], $size['h']);
            }

            if ($new_size) {
                if ($old_filename)
                    @unlink($upload_dir . $new_oldfilename);
                $img->save_with_default_imagetype($upload_dir . '/' . $new_filename);
                $data[$size_name] = array(
                    'folder' => $folder,
                    'filename' => $new_filename,
                    'width' => $new_size['w'],
                    'height' => $new_size['h']
                );
            }
        }

        $data['full'] = array(
            'folder' => $folder,
            'filename' => $filename,
            'width' => $width,
            'height' => $height
        );
        return $data;
    }

    public static function make_folder($folderpath) {
        @mkdir($folderpath, 0777, true);
        @chmod($folderpath, 0777);
        // chmod parent folder
        $folder = pathinfo($folderpath);
        @chmod($folder['dirname'], 0777);
    }

    public static function get_thumbnail($sizes, $size = 'thumbnail') {
        $sizes = unserialize($sizes);
        if (isset($sizes[$size]['filename']))
            return Helper::upload_url() . "media/" . $sizes[$size]['folder'] . $sizes[$size]['filename'];
        return base_url() . "public/img/default.png";
    }

    public static function resize_images($file, $sizes, $old_name = '') {
        $image_info = getimagesize($file['tmp_name']);

        $img = Ultilities::base32UUID() . "." . Helper::image_types($image_info['mime']);
        $upload_dir = Helper::upload_dir() . "media/" . date('Y') . '/' . date('m') . '/';
        $thumbnail = serialize(self::do_resize($file['tmp_name'], $sizes, $img, $upload_dir, $old_name));
        return array('img' => $img, 'thumbnail' => $thumbnail);
    }
    
    /**
    * @name: get_external_referrer
    * @desc: get external site back url
    * @parameters: $unset (true) if you want to unset session right away
                          (false) if you want to unset session later
    * @return: url
    */
    public function get_external_referrer($unset = true) {
        //setting backurl for external site
        $referrer = HelperApp::external_referrer_session_set($unset);
        if ($referrer !== false) {
            return $referrer;
        } 
    }
    
    /**
    * @name: external_referrer_session_set
    * @desc: check if external sit referrer session is set
    * @parameters: $unset (true) if you want to unset session right away
                          (false) if you want to unset session later
    * @return: return url if external site referral else false
    */
    public function external_referrer_session_set($unset = true) {
        $referrer = HelperApp::get_session('external_site_referrer');
        if (isset($referrer)) {
            if (HelperApp::aruaru_or_onayami($referrer) !== false) {
                if ($unset) HelperApp::remove_session('external_site_referrer');
                return $referrer;
            } else {
                if ($unset) HelperApp::remove_session('external_site_referrer');
                return false;
            }
        } else {
            return false;
        }
    }
    
    /**
    * @name: from_external_site
    * @desc: check if referral from external site
    * @parameters: none
    * @return: boolean
    */
    public function from_external_site() {
        $this->load->library('user_agent');
        if ($this->agent->is_referral()) {
            $aruaru_or_onayami = HelperApp::aruaru_or_onayami($this->agent->referrer());
            if ($aruaru_or_onayami !== false) { 
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
    * @name: aruaru_or_onayami
    * @desc: check if referral from external site
    * @parameters: referrer
    * @return: aruaru or onayami else false
    */
    public function aruaru_or_onayami($referrer = '') {
        if ($referrer == '') return;

        if (strpos($referrer, ARUARU_URL) !== false || strpos($referrer, ONAYAMI_URL) !== false) { 
            if (strpos($referrer, ARUARU_URL) !== false) {
                return 'aruaru';
            } else {
                return 'onayami';
            }
        } else {
            return false;
        }
    }

}

<?php

class Mcaptcha extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    /**
     * Delete old captchas
     * @param
     * @return
     */
    public function delete_old_captchas()
    {
        $expiration = time()-7200; // Two hour limit
        $this->db->query("DELETE FROM captcha WHERE captcha_time < ".$expiration);
    }

    /**
     * Check if a captcha exists.
     * @param $str
     * @return true or false
     */
    public function check_captcha_exist($str)
    {
        $expiration = time()-7200; // Two hour limit
        $ret = false;
        $sql = "SELECT 1 FROM captcha WHERE word = ? AND ip_address = ? AND captcha_time > ?";
        $binds = array($str, $this->input->ip_address(), $expiration);
        $query = $this->db->query($sql, $binds);
        if ($query && $query->num_rows() > 0) {
            $ret = true;
        }
        return $ret;
    }

    /**
     * Insert captcha data.
     * @param $data
     * @return
     */
    public function insert_captcha($data)
    {
        $query = $this->db->insert_string('captcha', $data);
        $this->db->query($query);
    }

    /**
     * Reset user login fail times if last login time(updated_date) is passed 10 mins or user login without errors.
     * @param string $module, string $unique_id, string $ip_address, boolean $login_errors and string $email_address
     * @return true or false
     */
    public function reset_fail_login_times($module, $unique_id = null, $ip_address = null, $login_errors = false, $email_address)
    {
        $type = 1;
        if ($module == 'owner') {
            $type = 2;
        }

        $sql = "UPDATE fail_login_list SET fail_login_times = 0, updated_date = ?";
        $params[] = date('Y-m-d H:i:s');
        if (!$unique_id) {
            $sql .= ", email_address = ?";
            $params[] = $email_address;
        }               

        $sql .= " WHERE type = ? AND display_flag = 1 AND ip_address = ?";
        $params[] = $type;        
        $params[] = $ip_address;

        if ($login_errors) {
            $sql .= " AND IFNULL(DATE_ADD(updated_date, INTERVAL 10 MINUTE), DATE_ADD(created_date, INTERVAL " . CAPTCHA_DISPLAY_EXPIRATION . " MINUTE)) <= ?" ;
            $params[] = date('Y-m-d H:i:s');
        }

        if ($unique_id) {
            $sql .= " AND unique_id = ?";
            $params[] = $unique_id;
        } else {
            $sql .= " AND unique_id IS NULL";           
        }

        $this->db->query($sql, $params);
        return ($this->db->affected_rows() < 1) ? false : true;
    }

    /**
     * Get the fail_login_times.
     * @param string $module, string $unique_id and string $ip_address
     * @return $ret
     */
    public function get_fail_login_times($module, $unique_id = null, $ip_address = null)
    {
        $ret = null;
        $type = 1;
        if ($module == 'owner') {
            $type = 2;
        }
        $sql = "SELECT fail_login_times FROM fail_login_list
                WHERE type = ? AND display_flag = 1 AND ip_address = ?";
        $params[] = $type;       
        $params[] = $ip_address;
        if ($unique_id) {
            $sql .= " AND unique_id = ?";
            $params[] = $unique_id;
        } 
        
        $query = $this->db->query($sql, $params);
        if ($query && $row = $query->row_array()) {
            $ret = $row;
        }
        return $ret;
    }

    /**
     * Update the fail_login_times.
     * @param string $module, string $unique_id, string $ip_address, int $fail_login_times and string $email_address
     * @return true or false
     */
    public function update_fail_login_times($module, $unique_id = null, $ip_address = null, $fail_login_times = 0, $email_address)
    {
        $type = 1;
        if ($module == 'owner') {
            $type = 2;
        }
        $sql = "UPDATE fail_login_list SET fail_login_times = ?, updated_date = ?";
        $params[] = $fail_login_times + 1;
        $params[] = date('Y-m-d H:i:s');  
        if (!$unique_id) {
            $sql .= ", email_address = ?";
            $params[] = $email_address;
        }
        $sql .= " WHERE type = ? AND display_flag = 1 AND ip_address = ?";              
        $params[] = $type;        
        $params[] = $ip_address;
        if ($unique_id) {
            $sql .= " AND unique_id = ?";
            $params[] = $unique_id;
        } else {
            $sql .= " AND unique_id IS NULL";           
        }
        $this->db->query($sql, $params);
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    /**
     * Insert login fail data
     * @param string $module, string $unique_id, $ip_address, int $fail_login_times and string $email_address
     * @return
     */
    public function insert_login_fail_data($module, $unique_id = null, $ip_address = null, $email_address)
    {
        $params = array();
        if ($module == 'owner') {
            $params['type'] = 2;
        } else {
            $params['type'] = 1;
        }
        if ($unique_id) {
            $params['unique_id'] = $unique_id;
        } 
        $params['ip_address'] = $ip_address;
        $params['fail_login_times'] = 1;
        $params['email_address'] = $email_address;
        $params['created_date'] = date('Y-m-d H:i:s');
        $this->db->insert('fail_login_list', $params);
    }
}

?>

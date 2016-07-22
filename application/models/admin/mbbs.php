<?php
    class Mbbs extends CI_Model{
        public function __construct() {
            parent::__construct();
        }


        public function insert_big_category($name)
        {
            $data=array(
                "name"=>$name,
                "update_date"=>(date("Y-m-d H:i:s")),
                "create_date"=>(date("Y-m-d H:i:s")),
            );
            $query = $this->db->insert("aruaru_bbs_big_categorys", $data);
        }

        public function insert_category($big_id, $name)
        {
            $data=array(
                "big_category_id"=>$big_id,
                "name"=>$name,
                "update_date"=>(date("Y-m-d H:i:s")),
                "create_date"=>(date("Y-m-d H:i:s")),
            );
            $query = $this->db->insert("aruaru_bbs_categorys", $data);
        }

        public function get_is_top()
        {
//            $this->db->select();
            $this->db->from('aruaru_bbs_is_top');
            $this->db->where('id', 1);
            $query = $this->db->get();
            $arr = $query->row_array();
            return $arr;
        }

        public function get_big_category()
        {
//            $this->db->select();
            $this->db->from('aruaru_bbs_big_categorys');
            $this->db->order_by("create_date", "ASC");
            $query = $this->db->get();
            $arr = $query->result_array();
            return $arr;
        }

        public function get_category($id)
        {
//            $this->db->select();
            $this->db->from('aruaru_bbs_categorys');
            $this->db->where('big_category_id', $id);
            $query = $this->db->get();
            $arr = $query->result_array();
            return $arr;
        }

        public function bbsSetting($data, $aruaru = 1) {
            if (empty($data)) return;

            if ($aruaru == 1) {
                $table = 'aruaru_bbs_settings';
            } else {
                $table = 'bbs_settings';
            }
            $date = date('Y-m-d H:i:s');
            foreach ($data as $data_row) {
                $name_exists = $this->bbsSettingExist($data_row['name'], $table);

                if ($name_exists) {
                    //update data
                    $update_date = array('update_date' => $date);
                    $data_merge = array_merge($data_row, $update_date);
                    $this->db->where('name', $data_row['name']);
                    $this->db->update($table, $data_merge);
                } else {
                    //insert data
                    $create_date = array('create_date' => $date, 'update_date' => $date);
                    $data_merge = array_merge($data_row, $create_date);
                    $this->db->insert($table, $data_merge);
                }
            }
           
        }

        public function bbsSettingExist($name = '', $table = 'aruaru_bbs_settings') {
            if ($name == '') return false;
            $this->db->from($table);
            $this->db->where('name', $name);
            $query = $this->db->get();
           if ( $query->num_rows() > 0) {
                return true;
            } else {
                return false;
            }
        }

        public function getBBSSetting($name = '', $table = 'aruaru_bbs_settings') {
            if ($name == '') return false;

            $this->db->from($table);
            $this->db->where('name', $name);
            $query = $this->db->get();
           if ( $query->num_rows() > 0) {
                $arr = $query->row();
                //print_r($arr); die;
                return $arr->value;
            } else {
                return 0;
            }
        }

        public function getBonusSettings($aruaru = 1) {

            if ($aruaru == 1) {
                $table = 'aruaru_bbs_settings';
                $bonus_settings = array('thread_bonus', 
                                      'comment_bonus', 
                                      'like_points_multiply_by', 
                                      'comment_like_bonus', 
                                      'max_comment_has_bonus'
                                    );
            } else {
                $table = 'bbs_settings';
                $bonus_settings = array('question_bonus', 
                                      'answer_bonus', 
                                      'like_points_multiply_by', 
                                      'evaluate_bonus', 
                                      'max_answer_has_bonus'
                                    );
            }
            $ret = array();
            foreach ($bonus_settings as $setting_name) {
                $value = $this->getBBSSetting($setting_name, $table);
                $ret[$setting_name] = $value;
            }
            return $ret;
        }

        /**
         * Get list points by
         * 1 = owner post
         * 3 = owner weekly post
         * 4 = owner commenter post
         * @param string $where :filter by columns
         * @param unknown $data : value
         */
        public function getThreadList($where = null, $data = array(), $offset = 0, $limit = 10) {
            $sql="
                SELECT
                    sql_calc_found_rows
                    abt.id,
                    abt.title,
                    (CASE
                        WHEN (abt.publish = 1) THEN '公開'
                        ELSE '非公開'
                    END) AS publish,
                    DATE_FORMAT(abt.create_date, '%Y/%m/%d') AS create_date,
                    COUNT(abm.id) AS comment_count,
                     (IFNULL(sum(abm.like_count),0) + IFNULL(abt.like_count,0)) as comment_like_count
                FROM
                    aruaru_bbs_threads AS abt
                        LEFT JOIN
                    aruaru_bbs_messages AS abm ON abm.thread_id = abt.id
                        AND abm.parent_id IS NULL
                WHERE
                    abt.publish <> 3
                    $where  
                GROUP BY abt.id
                ORDER BY abt.create_date DESC
                LIMIT ".$limit."
                OFFSET ".$offset;

            $query = $this->db->query($sql, $data);
            return $query->result_array();
        }

        /**
         * Get list points by
         * 1 = owner post
         * 3 = owner weekly post
         * 4 = owner commenter post
         * @param string $where :filter by columns
         * @param unknown $data : value
         */
        public function getConsultList($where = null, $data = array(), $offset = 0, $limit = 10) {
            $sql="
                SELECT
                    sql_calc_found_rows
                    bt.id,
                    bt.title,
                    (CASE
                        WHEN (bt.display_flag = 1) THEN '公開'
                        ELSE '非公開'
                    END) AS publish,
                    DATE_FORMAT(bt.create_date, '%Y/%m/%d') AS create_date,
                    COUNT(bm.id) AS comment_count,
                     (IFNULL(sum(bm.evaluate),0) + IFNULL(bt.like_count,0)) as comment_like_count
                FROM
                    bbs_threads AS bt
                        LEFT JOIN
                    bbs_messages AS bm ON bm.thread_id = bt.id
                        AND bm.reply_id IS NULL
                WHERE
                    bt.display_flag <> 3
                    $where  
                GROUP BY bt.id
                ORDER BY bt.create_date DESC
                LIMIT ".$limit."
                OFFSET ".$offset;

            $query = $this->db->query($sql, $data);
            return $query->result_array();
        }

        /**
         * Return detail of post thread
         * @param integer $id thread id
         */
        public function getThreadCommentDetail($id = null) {
            $sql="
                SELECT 
                    abt.id, 
                    abt.title, 
                    abt.message, 
                    abt.create_date, 
                    abt.big_cate_id, 
                    abt.cate_id, 
                    abt.like_count,
                    abt.dislike_count,
                    abt.user_id as owner_id, 
                    abt.create_date,
                    abt.create_ip,
                    abbc.jp_name as big_cate_name, 
                    abc.jp_name as cate_name, 
                    users.unique_id,
                    (CASE
                        WHEN (users.user_from_site = 1) THEN 'マシェモバ'
                        ELSE 'マキア'
                    END) AS user_from_site,
                    users.offcial_reg_date,
                    abt.publish,
                    count(abm.id) as comment_count,
                    (IFNULL(sum(abm.like_count),0) + IFNULL(abt.like_count,0)) as comment_like_count
                FROM aruaru_bbs_threads AS abt
                LEFT JOIN aruaru_bbs_big_categorys AS abbc ON abt.big_cate_id = abbc.id 
                LEFT JOIN aruaru_bbs_categorys AS abc ON abt.big_cate_id = abc.id
                LEFT JOIN aruaru_bbs_messages AS abm ON abt.id = abm.thread_id AND abm.parent_id IS NULL
                LEFT JOIN users on users.id = abt.user_id
                WHERE abt.id = ? AND abt.publish <> 3
                LIMIT 1
            ";
            $query = $this->db->query($sql, $id);
            return $query->row_array();
      
        }

        /**
         * Return detail of post thread
         * @param integer $id thread id
         */
        public function getConsultDetail($id = null) {
            $sql="
                SELECT 
                    bt.id, 
                    bt.title, 
                    bt.message, 
                    bt.create_date, 
                    bt.big_cate_id, 
                    bt.cate_id, 
                    bt.like_count,
                    bt.user_id as owner_id, 
                    bt.create_date,
                    bbc.name as big_cate_name, 
                    bc.name as cate_name, 
                    users.unique_id,
                    (CASE
                        WHEN (users.user_from_site = 1) THEN 'マシェモバ'
                        ELSE 'マキア'
                    END) AS user_from_site,
                    users.offcial_reg_date,
                    bt.display_flag,
                    count(bm.id) as comment_count,
                    (IFNULL(sum(bm.evaluate),0) + IFNULL(bt.like_count,0)) as comment_like_count
                FROM bbs_threads AS bt
                LEFT JOIN bbs_big_categorys AS bbc ON bt.big_cate_id = bbc.id 
                LEFT JOIN bbs_categorys AS bc ON bt.big_cate_id = bc.id
                LEFT JOIN bbs_messages AS bm ON bt.id = bm.thread_id AND bm.reply_id IS NULL
                LEFT JOIN users on users.id = bt.user_id
                WHERE bt.id = ? AND bt.display_flag <> 3
                LIMIT 1
            ";
            $query = $this->db->query($sql, $id);
            return $query->row_array();
      
        }

        /**
         * Get message by parent
         * @param string $id
         */
        function getCommentByParent($id = null) {
            $sql = "
            SELECT 
                abm.id,
                abm.thread_id as post_id,
                abm.message,
                abm.user_id as owner_id,
                abm.parent_id,
                abm.like_count,
                abm.create_ip,
                abm.dislike_count,
                abm.publish,
                (CASE
                    WHEN (u.user_from_site = 1) THEN 'マシェモバ'
                    ELSE 'マキア'
                END) AS user_from_site,
                u.offcial_reg_date,
                COALESCE(u.unique_id, 'とくめい') as unique_id
            FROM aruaru_bbs_messages AS abm
            LEFT JOIN users AS u ON abm.user_id = u.id
            WHERE abm.parent_id = ? AND abm.publish <> 3
            ";
            $query = $this->db->query($sql, $id);
            return $query->row_array();
        }

        /**
         * Get message by parent
         * @param string $id
         */
        function getConsultByParent($id = null) {
            $sql = "
            SELECT 
                bm.id,
                bm.thread_id as post_id,
                bm.message,
                bm.user_id as owner_id,
                bm.reply_id,
                bm.evaluate,
                bm.create_ip,
                bm.display_flag,
                (CASE
                    WHEN (u.user_from_site = 1) THEN 'マシェモバ'
                    ELSE 'マキア'
                END) AS user_from_site,
                u.offcial_reg_date,
                COALESCE(u.unique_id, 'とくめい') as unique_id
            FROM bbs_messages AS bm
            LEFT JOIN users AS u ON bm.user_id = u.id
            WHERE bm.reply_id = ? AND bm.display_flag <> 3
            ";
            $query = $this->db->query($sql, $id);
            return $query->row_array();
        }

        /**
         * Retrieve latest message
         * @param string $id : thread id of the message
         * @param number $offset
         * @param number $limit
         * @return multitype:
         */
        function getLatestComments($id = null, $offset = 0, $limit = 10) {
            if (is_null($id)) return array();
            $sql = "
            SELECT
                sql_calc_found_rows 
                abm.id,
                abm.thread_id as post_id,
                abm.message,
                abm.user_id as owner_id,
                abm.parent_id,
                abm.like_count,
                abm.dislike_count,
                abm.create_ip,
                abm.publish,
                DATE_FORMAT(abm.create_date,'%Y/%m/%d %H:%i:%s') as posted_date,
                COALESCE(u.unique_id, 'とくめい') as unique_id
            FROM aruaru_bbs_messages AS abm
            LEFT JOIN users AS u ON abm.user_id = u.id
            WHERE abm.thread_id = ? 
                AND abm.parent_id IS NULL AND abm.publish <> 3
            ORDER BY abm.create_date DESC
            LIMIT ".$limit."
            OFFSET ".$offset;

            $query = $this->db->query($sql, $id);
            return $query->result_array();
        }

        /**
         * Retrieve latest message
         * @param string $id : thread id of the message
         * @param number $offset
         * @param number $limit
         * @return multitype:
         */
        function getLatestConsultComments($id = null, $offset = 0, $limit = 10) {
            if (is_null($id)) return array();
            $sql = "
            SELECT
                sql_calc_found_rows 
                bm.id,
                bm.thread_id as post_id,
                bm.message,
                bm.user_id as owner_id,
                bm.reply_id,
                bm.evaluate,
                bm.display_flag,
                DATE_FORMAT(bm.create_date,'%Y/%m/%d %H:%i:%s') as posted_date,
                COALESCE(u.unique_id, 'とくめい') as unique_id
            FROM bbs_messages AS bm
            LEFT JOIN users AS u ON bm.user_id = u.id
            WHERE bm.thread_id = ? 
                AND bm.reply_id IS NULL AND bm.display_flag <> 3
            ORDER BY bm.create_date DESC
            LIMIT ".$limit."
            OFFSET ".$offset;

            $query = $this->db->query($sql, $id);
            return $query->result_array();
        }

        /**
         * Serialize all the comments into array by
         * call the functions getCommentByParent
         * @param string $id : id of the latest comments
         * @param number $offset
         * @param number $limit
         * @return multitype: array of comments
         */
        function getLatestsArray($id = null, $offset = 0, $limit = 10) {
            $arr_comments = array();
            $comments = $this->getLatestComments($id, $offset, $limit);
            $total_rows = $this->getTotalRows();
            foreach ($comments as $comment) {
                if ($child = $this->getCommentByParent($comment['id'])) {
                    $comment['reply'] = $child;
                }
                $arr_comments[$comment['id']] = $comment;
            }

            return array(
                'tota_list' => $total_rows, 
                'comments_list' => $arr_comments
                );
        }

        /**
         * Serialize all the comments into array by
         * call the functions getCommentByParent
         * @param string $id : id of the latest comments
         * @param number $offset
         * @param number $limit
         * @return multitype: array of comments
         */
        function getConsultArray($id = null, $offset = 0, $limit = 10) {
            $arr_comments = array();
            $comments = $this->getLatestConsultComments($id, $offset, $limit);
            $total_rows = $this->getTotalRows();
            foreach ($comments as $comment) {
                if ($child = $this->getConsultByParent($comment['id'])) {
                    $comment['reply'] = $child;
                }
                $arr_comments[$comment['id']] = $comment;
            }

            return array(
                'tota_list' => $total_rows, 
                'comments_list' => $arr_comments
                );
        }

        /**
         * Retrieve validity by its target
         * @param string $where
         * @param unknown $data
         */
        function getValidPoints($where = null, $data = array()) {
            $sql = "
                SELECT 
                    *
                FROM
                    aruaru_bbs_points
                WHERE
                    thread_id = ? 
                    AND validity <> 0 and bonus_requested_flag = 0
                    $where
                GROUP BY target      
             ";
            $query = $this->db->query($sql, $data);
            return $query->result_array();
        }

        /**
         * Onayami
         * Retrieve validity by its target
         * @param string $where
         * @param unknown $data
         */
        function getOnayamiPoints($where = null, $data = array()) {
            $sql = "
                SELECT 
                    *
                FROM
                    bbs_points
                WHERE
                    thread_id = ? 
                    AND validity <> 0 and bonus_requested_flag = 0
                    $where
                GROUP BY target      
             ";
            $query = $this->db->query($sql, $data);
            return $query->result_array();
        }

        /**
         * Cancel Points set to 0
         * @param integer $id = id of the points
         */
        function cancelPoints($where = null) {
          $this->db->where($where);
          $this->db->update('aruaru_bbs_points', array('validity' => 0, 'bonus_requested_flag' => 1 ,'update_date' => date('Y-m-d H:i:s'))); 
          return $this->db->affected_rows();
        }

        /**
         * Cancel Points set to 0
         * @param integer $id = id of the points
         */
        function cancelOnyamiPoints($where = null) {
          $this->db->where($where);
          $this->db->update('bbs_points', array('validity' => 0, 'bonus_requested_flag' => 1 ,'update_date' => date('Y-m-d H:i:s'))); 
          return $this->db->affected_rows();
        }

        //get rows of the query
        function getTotalRows() {
             $sql = "
                SELECT FOUND_ROWS() as total;
             ";
            $query = $this->db->query($sql);
            $row = $query->row_array();
            return $row['total'];
        }

        function updateStatus($value = null, $id = null, $type = null) {
            $columns = 'id';
            if ($type == 'thread') {
                $this->db->set('publish', $value);
                $this->db->where('id', $id);
                $this->db->update('aruaru_bbs_threads');
                $columns = 'parent_id';
            }
            $this->db->set('publish', $value);
            $this->db->where($columns, $id);
            return $this->db->update('aruaru_bbs_messages');
        }

        function updateConsult($value = null, $id = null, $type = null) {
            $columns = 'id';
            if ($type == 'thread') {
                $this->db->set('display_flag', $value);
                $this->db->where('id', $id);
                $this->db->update('bbs_threads');
                $columns = 'reply_id';
            }
            $this->db->set('display_flag', $value);
            $this->db->where($columns, $id);
            return $this->db->update('bbs_messages');
        }

        /**
         * @author: VJS
         * @name : updateScoutBonus
         * @todo : add a new record for bonus data
         * @param  user id
         * @return TRUE: success, FALSE: failed
         */
        public function updateScoutBonus($user_id = null, $addPoint = null, $reason = 'no reason', $mode = 0){

            $this->load->model('Musers');
            $row = $this->Musers->getUserScoutMailBonus0($user_id);

            $old_bonus_money = $row['bonus_money'];               
            if (!$mode) {
                $new_bonus_money = $row['bonus_money'] + $addPoint;
            } else {
                $new_bonus_money = $row['bonus_money'] - $addPoint;
                $addPoint = '-'.$addPoint;
            }

            $sql  = "INSERT INTO  aruaru_bbs_points_log SET ";
            $sql .= "user_id = ?, bonus_money = ?, old_bonus_money = ?, ";
            $sql .= "new_bonus_money = ?, reason = ?, created_date = NOW()";
            $params = array($user_id, $addPoint, $old_bonus_money, $new_bonus_money, $reason);
            $this->db->query( $sql, $params );
        }

        /**
         * @author: VJS
         * @name : updateScoutBonus
         * @todo : add a new record for bonus data
         * @param  user id
         * @return TRUE: success, FALSE: failed
         */
        public function updateOnayamiBonus($user_id = null, $addPoint = null, $reason = 'no reason', $mode = 0){          

            $this->load->model('Musers');
            $row = $this->Musers->getUserScoutMailBonus0($user_id);

            $old_bonus_money = $row['bonus_money'];
            if (!$mode) {
                $new_bonus_money = $row['bonus_money'] + $addPoint;
            } else {
                $new_bonus_money = $row['bonus_money'] - $addPoint;
                $addPoint = '-'.$addPoint;
            }

            $sql  = "INSERT INTO  bbs_point_logs SET ";
            $sql .= "user_id = ?, bonus_money = ?, old_bonus_money = ?, ";
            $sql .= "new_bonus_money = ?, reason = ?, created_date = NOW()";
            $params = array($user_id, $addPoint, $old_bonus_money, $new_bonus_money, $reason);
            $this->db->query( $sql, $params );
        }

        public function getAruaruPoints($where = null) {
            $this->db->where($where);
            $this->db->where('bonus_requested_flag', 0);
            $this->db->where('validity', 1);
            $this->db->from('aruaru_bbs_points');
            $query =  $this->db->get();
            return $query->result_array();
        }

         public function getPointOnayami($where = null) {
            $this->db->where($where);
            $this->db->where('bonus_requested_flag', 0);
            $this->db->where('validity', 1);
            $this->db->from('bbs_points');
            $query =  $this->db->get();
            return $query->result_array();
        }

    }
?>

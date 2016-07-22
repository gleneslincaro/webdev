<?php
    class Mpost_model extends CI_Model
    {
        function __construct() {
            parent::__construct();
        }

        public function get_big_category_ar() {
                $query = $this->db->get('aruaru_bbs_big_categorys');
                return $query->result_array();
        }

        /**
         * Get the latest message/post
         * @param number $offset
         * @param number $limit
         */
        function getLatestPosts($offset = 0, $limit = 10) {
            $sql = "
                SELECT 
                    abt.id, 
                    abt.title, 
                    abt.create_date, 
                    abt.big_cate_id, 
                    abt.cate_id, 
                    abt.user_id as owner_id
                 ".
                "FROM aruaru_bbs_threads AS abt ".
                "WHERE abt.publish = 1
                GROUP BY abt.id
                ORDER BY abt.create_date DESC
                LIMIT ".$limit."
                OFFSET ".$offset
            ;
            $query = $this->db->query($sql);
            return $query->result_array();
        }

        function get3daysLogsHome($params = array(), $offset = 0, $limit = 10)
        {
            $cond = (empty($params)) ? '':$params['row']." = ". $params['value']." AND";

            $sql = "
                SELECT 
                    avbl.thread_id as id,
                    abt.title,
                    abt.category_like_count as like_count,
                    count(avbl.thread_id) as log_count, 
                    avbl.create_date,
                    abt.last_comment_time AS last_comment_time,
                    (   CASE 
                            WHEN (TIMESTAMPDIFF(HOUR, abt.last_comment_time, NOW()) >= 24) THEN DATE_FORMAT(abt.last_comment_time,'%Y/%m/%d %H:%i')
                            WHEN (TIMESTAMPDIFF(MINUTE, abt.last_comment_time, NOW()) >= 60 ) THEN CONCAT(TIMESTAMPDIFF(HOUR, abt.last_comment_time, NOW()),' 時間前')
                            WHEN (TIMESTAMPDIFF(SECOND, abt.last_comment_time, NOW()) >= 60 ) THEN CONCAT(TIMESTAMPDIFF(MINUTE, abt.last_comment_time, NOW()),' 分前')
                            ELSE 'ちょうど今'
                        END
                    ) as comment_time_ago,
                    abbc.jp_name as big_cate_name, 
                    abc.jp_name as cate_name, 
                    REPLACE(LOWER(abbc.name),' ','_') as big_cate_slug
                FROM aruaru_bbs_view_logs AS avbl 
                INNER JOIN aruaru_bbs_threads AS abt ON avbl.thread_id = abt.id AND abt.publish = 1
                LEFT JOIN aruaru_bbs_big_categorys AS abbc ON abt.big_cate_id = abbc.id 
                LEFT JOIN aruaru_bbs_categorys AS abc ON abt.cate_id = abc.id
                WHERE ".$cond."
                avbl.create_date BETWEEN CURDATE() - INTERVAL 2 DAY AND CURDATE() + INTERVAL 1 DAY
                GROUP BY avbl.thread_id
                ORDER BY log_count DESC, avbl.create_date DESC
                LIMIT ".$limit."
                OFFSET ".$offset
            ;
            $query = $this->db->query($sql);
            return $query->result_array();
        }

    }

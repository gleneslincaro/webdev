<?php

class Mnew extends CI_Model {

    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

/**
     * @author  [IVS] Lam Tu My Kieu
     * @name 	getNews
     * @todo 	get all news
     * @param 	int $owner_id, $args, $page = 1, $posts_per_page = 10
     * @return 	data
     */
    function getNews($page = 1, $posts_per_page = 10) {
        $params = array();
        $custom = "";
        $page = ($page - 1) * $posts_per_page;

        $sql = "SELECT id, title, content,created_date
                FROM mst_news
                WHERE member_type = 1 AND display_flag =1
                ORDER BY id DESC
            LIMIT ?,?";

        $params[] = $page;
        $params[] = $posts_per_page;
        $query = $this->db->query($sql, $params);
        return $query->result_array();
    }
    
    /**
     * @author  [IVS] Lam Tu My Kieu
     * @name 	countNew
     * @todo 	count the number of News rows
     * @param 	int $owner_id, $args
     * @return 	int
     */
    public function countNews() {
        $sql = "SELECT COUNT(*) AS total

                FROM mst_news
     
                WHERE member_type = 1 AND display_flag =1
                ";
        $query = $this->db->query($sql);
        $row = $query->row_array();
        return $row['total'];
    }
}
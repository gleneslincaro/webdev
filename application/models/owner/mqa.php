<?php

class Mqa extends CI_Model {

    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

    function get_faq_by_owner($owner_id, $message_id) {
        $this->db->select('alias2.id, alias2.reply_id, alias2.content, alias1.content AS reply_content,
         alias2.title AS reply_title, alias1.category_id AS reply_category_id,alias1.created_date, ow.storename');
        $this->db->from('list_user_owner_messages AS alias1');
        $this->db->join('list_user_owner_messages AS alias2', 'alias1.id = alias2.reply_id', 'INNER');
        $this->db->join('owners AS ow', 'ow.id = alias2.owner_id');
        $this->db->where('alias1.msg_from_flag', 1);
        $this->db->where('alias1.public_flag', 1);
        $this->db->where('alias2.owner_id', $owner_id);
        $this->db->where('alias2.id', $message_id);
        $result = $this->db->get();
        $res = $result->row_array();

        if ($result->num_rows() == 0) {
            return false;
        }

        $storename = $res['storename'];
        $content = $res['content'];
        $str = preg_replace('/'.$storename.'様へ/', '', $content);
        $res['content'] = $str;

        $this->db->select('id, title, content, reply_id, category_id');
        $this->db->from('list_user_owner_messages');
        $this->db->where('owner_id', $owner_id);
        $this->db->where('msg_from_flag', 0);
        $this->db->where('reply_id !=', 'NULL');
        $this->db->where('public_flag', 1);
        $result = $this->db->get();
        $arr = $result->result_array();

        $count_ar = array();
        $category_name_ar= array();
        $category_name_ar[0] = array('id'=>0, 'name'=>'全て','count'=>count($arr));
        $category_name_ar[6] = array('id'=>6, 'name'=>'仕事内容','count'=>0);
        $category_name_ar[1] = array('id'=>1, 'name'=>'報酬','count'=>0);
        $category_name_ar[2] = array('id'=>2, 'name'=>'待遇','count'=>0);
        $category_name_ar[3] = array('id'=>3, 'name'=>'面接・体験入店','count'=>0);
        $category_name_ar[4] = array('id'=>4, 'name'=>'休暇','count'=>0);
        $category_name_ar[5] = array('id'=>5, 'name'=>'未経験','count'=>0);
        $category_name_ar[100] = array('id'=>100, 'name'=>'その他','count'=>0);

        $res['reply_category_name'] = $category_name_ar[$res['reply_category_id']]['name'];
        $ret_ar['cate_message_ar'] = $res;

        foreach ($arr as $key => $val) {
            $category_name_ar[$val['category_id']]['count']++;
        }
        foreach ($category_name_ar as $key => $val) {
            if ($val['count'] < 1) {
                unset($category_name_ar[$val['id']]);
            }
        }
        $ret_ar['current_cate'] = $category_name_ar[$res['reply_category_id']];
        unset($category_name_ar[$res['reply_category_id']]);

        $ret_ar['cate_count'] = $category_name_ar;

        return $ret_ar;
    }

    function get_faqlist_by_owner($owner_id, $category_id, $offset = 0, $limit = 0) {
        $this->db->select('alias2.id, alias2.reply_id, alias2.content, alias1.content AS reply_content,
         alias2.title AS reply_title, alias1.category_id AS reply_category_id,alias1.created_date, ow.storename');
        $this->db->from('list_user_owner_messages AS alias1');
        $this->db->join('list_user_owner_messages AS alias2', 'alias1.id = alias2.reply_id', 'INNER');
        $this->db->join('owners AS ow', 'ow.id = alias2.owner_id');
        $this->db->where('alias1.msg_from_flag', 1);
        $this->db->where('alias1.public_flag', 1);
        $this->db->where('alias2.owner_id', $owner_id);
//        $this->db->where('alias2.id', $message_id);
        if ($category_id > 0) {
            $this->db->where('alias2.category_id', $category_id);
        }

        if ($limit > 0) {
            $this->db->limit($limit);
        }
        if ($offset > 0) {
            $this->db->offset($offset);
        }

        $result = $this->db->get();
        $res = $result->result_array();

        if ($result->num_rows() == 0) {
            return false;
        }

        foreach ($res as $key => $val) {
            $storename = $val['storename'];
            $content = $val['content'];
            $str = preg_replace('/'.$storename.'様へ/', '', $content);
            $res[$key]['content'] = $str;
        }

        $this->db->select('id, title, content, reply_id, category_id');
        $this->db->from('list_user_owner_messages');
        $this->db->where('owner_id', $owner_id);
        $this->db->where('msg_from_flag', 0);
        $this->db->where('reply_id !=', 'NULL');
        $this->db->where('public_flag', 1);
        $result = $this->db->get();
        $arr = $result->result_array();

        $cate_all_count = count($arr);
        $ret_ar['cate_all_count'] = $cate_all_count;

        $count_ar = array();
        $category_name_ar= array();
        $category_name_ar[0] = array('id'=>0, 'name'=>'全て','count'=>count($arr));
        $category_name_ar[6] = array('id'=>6, 'name'=>'仕事内容','count'=>0);
        $category_name_ar[1] = array('id'=>1, 'name'=>'報酬','count'=>0);
        $category_name_ar[2] = array('id'=>2, 'name'=>'待遇','count'=>0);
        $category_name_ar[3] = array('id'=>3, 'name'=>'面接・体験入店','count'=>0);
        $category_name_ar[4] = array('id'=>4, 'name'=>'休暇','count'=>0);
        $category_name_ar[5] = array('id'=>5, 'name'=>'未経験','count'=>0);
        $category_name_ar[100] = array('id'=>100, 'name'=>'その他','count'=>0);

        $ret_ar['cate_message_ar'] = $res;

        foreach ($arr as $key => $val) {
            $category_name_ar[$val['category_id']]['count']++;
        }
        foreach ($category_name_ar as $key => $val) {
            if ($val['count'] < 1) {
                unset($category_name_ar[$val['id']]);
            }
        }
        $ret_ar['current_cate'] = $category_name_ar[$category_id];

        if ($category_id > 0) {
            $ret_ar['cate_all_count'] = $category_name_ar[$category_id]['count'];
        }
        unset($category_name_ar[$category_id]);

        $ret_ar['cate_count'] = $category_name_ar;

        return $ret_ar;
    }

    function check_faqlist_by_owner($owner_id, $category_id, $offset = 0, $limit = 0) {
        $this->db->select('alias2.id, alias2.reply_id, alias2.content, alias1.content AS reply_content,
         alias2.title AS reply_title, alias1.category_id AS reply_category_id,alias1.created_date, ow.storename');
        $this->db->from('list_user_owner_messages AS alias1');
        $this->db->join('list_user_owner_messages AS alias2', 'alias1.id = alias2.reply_id', 'INNER');
        $this->db->join('owners AS ow', 'ow.id = alias2.owner_id');
        $this->db->where('alias1.msg_from_flag', 1);
        $this->db->where('alias1.public_flag', 1);
        $this->db->where('alias2.owner_id', $owner_id);
//        $this->db->where('alias2.id', $message_id);
        if ($category_id > 0) {
            $this->db->where('alias2.category_id', $category_id);
        }

        if ($limit > 0) {
            $this->db->limit($limit);
        }
        if ($offset > 0) {
            $this->db->offset($offset);
        }

        $result = $this->db->get();
        $res = $result->result_array();

        if ($result->num_rows() == 0) {
            return false;
        }
        return true;
    }

}
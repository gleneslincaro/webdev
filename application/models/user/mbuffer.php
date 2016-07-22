<?php
class Mbuffer extends CI_Model {
    function __construct() {
        parent::__construct();
    }

    public function get_urgent_recruit($ar)
    {
        $count = $this->db->count_all('urgent_recruit_buffer');
        if ($count < 10) {
            for ($i=0; $i < 10; $i++) {
                $sql="INSERT INTO urgent_recruit_buffer (owner_id) VALUES (0)";
                $query= $this->db->query($sql);
            }
        }

        $id = 1;
        $line_num = 0;
        foreach ($ar as $key => $val) {
            $i = 0;
            $sql1 = '';
            foreach ($val as $key2 => $val2) {
                $sql1 .= ($i > 0)? ",".$key2."='".$val2."'":" ".$key2."='".$val2."'";
                $i++;
            }
            $sql='UPDATE urgent_recruit_buffer SET '.$sql1.' WHERE id = ?';
            $query= $this->db->query($sql, array($id));
            $id++;
            $line_num++;
        }
        for ($i=$line_num; $i < 10; $i++) {
            $sql='UPDATE urgent_recruit_buffer SET owner_id = ? WHERE id = ?';
            $query= $this->db->query($sql, array(0, $id));
            $id++;
        }
        return true;

    }

    public function get_urgent_recruit_buffer()
    {
        $sql = "SELECT * FROM `urgent_recruit_buffer` WHERE owner_id != 0 ORDER BY `id` ASC";
        $query= $this->db->query($sql);
        return $query->result_array();
    }

    public function set_column_buffer($ar)
    {
        $count = $this->db->count_all('column_buffer');
        if ($count < 4) {
            for ($i=0; $i < 4; $i++) {
                $sql="INSERT INTO column_buffer (title) VALUES ('NULL')";
                $query= $this->db->query($sql);
            }
        }

        $id = 1;
        $line_num = 0;
        foreach ($ar as $key => $val) {
            $i = 0;
            $sql1 = '';
            foreach ($val as $key2 => $val2) {
                $sql1 .= ($i > 0)? ",".$key2."='".$val2."'":" ".$key2."='".$val2."'";
                $i++;
            }
            $sql='UPDATE column_buffer SET '.$sql1.' WHERE id = '.$id;
//            $query= $this->db->query($sql, array($id));
            $query= $this->db->query($sql);
            $id++;
            $line_num++;
        }
        for ($i=$line_num; $i < 4; $i++) {
            $sql='UPDATE column_buffer SET title = ? WHERE id = ?';
            $query= $this->db->query($sql, array('NULL', $id));
            $id++;
        }
        return true;
    }

    public function get_column_buffer()
    {
        $sql = "SELECT * FROM `column_buffer` WHERE title != 'NULL' ORDER BY `id` ASC";
        $query= $this->db->query($sql);
        return $query->result_array();
    }

}
?>

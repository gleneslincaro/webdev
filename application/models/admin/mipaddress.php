<?php
	/*
	* 管理画面のIPアドレス制限
	*/
	class mipaddress extends CI_Model{
		public function __construct() {
            parent::__construct();
        }
		/*
		 * @author  VJソリューションズ
         * @name    getAccessableIP
         * @todo    管理画面のアクセス可能IP取得
         * @param　　　なし
         * @return　　成功：アクセス可能IPの配列
         *			失敗：NULL
		*/
		public function getAccessableIP(){
			$ret = null;
			$sql = "select ip_address from admin_ip where disable_flag=0";
			$query = $this->db->query($sql);
			if ( $query && $query->result_array() ){
				$ip_array = $query->result_array();
				$ret = array();
				foreach($ip_array as $row){
					$ret[] = $row['ip_address'];
				}
			}
			return $ret;
		}
		/*
		 * @author  VJS
         * @name    getIPList
         * @todo    設定IPリスト取得
         * @param　　　なし
         * @return　　成功：設定IP情報リスト
         *			失敗：NULL
		*/
		public function getIPList(){
			$ret = null;
			$sql = "select * from admin_ip
					ORDER BY disable_flag";
			$query = $this->db->query($sql);
			if ( $query && $query->result_array() ){
				$ret = $query->result_array();
			}
			return $ret;
		}
		/*
		 * @author  VJソリューションズ
         * @name    addAccessableIP
         * @todo    管理画面のアクセス可能IP追加
         * @param　　　$ip: IPアドレス
         * @param　　　$note: IPについてのメモ
         * @return　　成功：TRUE
         *			失敗：FALSE
		*/
		public function addAccessableIP($ip, $note=""){
			$ret = false;
			if ( $ip ){
				$last_update = date('Y-m-d H:i:s');
				$data =	array(
                	"ip_address"=>$ip,
                	"note"=>$note,
                	"last_update"=>$last_update,
                	"disable_flag"=>0
	            );
	            $this->db->insert("admin_ip",$data);
	            if($this->db->affected_rows() > 0){
	            	$ret = true;
	            }
			}
			return $ret;
		}
		/*
		 * @author  VJS
         * @name    updateIP
         * @todo    制限IP更新
         * @param　　　$ip: IPアドレス
         * @param　　　$note: IPについてのメモ
         * @param　　　$disable_flag:無効フラグ
         * @return　　成功：TRUE
         *			失敗：FALSE
		*/
		public function updateIP($id, $ip, $note="", $disable_flag=0){
			$ret = false;
			if ( $id && $ip ){
				$last_update = date('Y-m-d H:i:s');
				$data =	array(
                	"ip_address"	=>$ip,
                	"note"			=>$note,
                	"last_update"	=>$last_update,
                	"disable_flag"	=>$disable_flag
	            );
	            $this->db->where('idip',$id);
	            $this->db->update("admin_ip",$data);
	            if($this->db->affected_rows() > 0){
	            	$ret = true;
	            }
			}
			return $ret;
		}
		/*
		 * @author  VJソリューションズ
         * @name    delAccessableIP
         * @todo    管理画面のアクセス可能IP削除
         * @param　　　$ip: IPアドレス
         * @return　　成功：TRUE
         *			失敗：FALSE
		*/
		public function delAccessableIP($ip){
			$ret = false;
			if ( $ip ){
				$sql = "update admin_ip set disable_flag = 1 where ip_address = ?";
	            $this->db->query("admin_ip",$ip);
	            if($this->db->affected_rows() > 0){
	            	$ret = true;
	            }
			}
			return $ret;
		}
	}
?>

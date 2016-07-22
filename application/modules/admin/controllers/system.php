<?php
    class System extends MX_Controller{
        protected $_data;
        private $message = array('success' => true, 'error' => array());
        public function __construct() {
            parent::__construct();            
            $this->_data["module"] = $this->router->fetch_module();
            $this->lang->load('list_message', 'english');
            $this->form_validation->CI =& $this;
            $this->output->set_header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
            $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate");
            $this->output->set_header("Cache-Control: post-check=0, pre-check=0");
            $this->output->set_header("Pragma: no-cache");
        }
         /**
        * @author     [IVS] Phan Van Thuyet
        * @name 	index
        * @todo 	index page
        * @param 	 
        * @return 	
        */
        public function index(){
            AdminControl::CheckLogin();
            $this->_data["loadPage"]="search/company";
            $this->_data["titlePage"]="店舗検索";
            $this->load->view($this->_data["module"]."/layout/layout",$this->_data);
        }
         /**
        * @author     [IVS] Phan Van Thuyet
        * @name 	login
        * @todo 	login
        * @param 	 
        * @return 	
        */
        public function login() {
            AdminControl::CheckIP();
            if ($_POST)
                $this->do_login();

            $this->_data['loadPage'] = 'admin/main';
            $this->_data['message'] = $this->message;
            $this->load->view($this->_data["module"]."/layout/login",$this->_data);
        }
         /**
        * @author     [IVS] Phan Van Thuyet
        * @name 	logout
        * @todo 	logout
        * @param 	 
        * @return 	
        */
        public function logout(){        
            HelperApp::clear_session();
            $this->_data['loadPage'] = 'admin/logout';
            $this->_data["titlePage"]="joyspe管理画面";
            $this->load->view($this->_data["module"]."/layout/layout",$this->_data);
        }
         /**
        * @author       [IVS] Phan Van Thuyet
        * @name         do_login
        * @todo 	do login
        * @param 	 
        * @return 	
        */
        public function do_login() {

            $login_id = trim($this->input->post('loginId'));           
                 
            if(trim($this->input->post('password'))!=null){
                $this->form_validation->set_rules('loginId', 'ログインID', 'required|checkStringByte');
                $this->form_validation->set_rules('password', 'パスワード', 'required|checkStringByte|min_length[4]|max_length[20]|callback_check_login');
            }else{
                $this->form_validation->set_rules('loginId', 'ログインID', 'required');
                $this->form_validation->set_rules('password', 'パスワード', 'required');
            }
                     
            
            $form_validation = $this->form_validation->run();
            $this->message['success'] = !$form_validation ? FALSE : TRUE;
       
            if (!$form_validation){                  
                return false;
            }  else {
                $set_login = HelperApp::add_session('loginId', $login_id);
                $return_url = isset($_GET['return_url']) && trim($_GET['return_url']) != "" ? urldecode(trim($_GET['return_url'])) : base_url() . "admin/system/index";
                redirect($return_url);
            }
            
            
        }
         /**
        * @author       [IVS] Phan Van Thuyet
        * @name 	check_login
        * @todo 	check login
        * @param 	 
        * @return 	
        */
        public function check_login() {
            $login_id = trim($this->input->post('loginId'));
            $admin = $this->Msystem->getByLoginId($login_id);  
            $password = trim($this->input->post('password'));            
            if (!$admin)
                return false;
            
            if (base64_decode($admin['password']) != $password)
                return false;
            return true;
        }
        
     /**
        * @author       [IVS] Nguyen Minh Ngoc
        * @name 	errorPage
        * @todo 	redirect to errorpage
        * @param 	 
        * @return 	
        */
        public function errorPage(){
            $this->_data["loadPage"]="error_page";
            $this->_data["titlePage"]="joyspe管理画面";
            $this->load->view($this->_data["module"]."/layout/layout",$this->_data);
        }
        /**
        * @author  　VJソリューションズ
        * @name     denyAccess
        * @todo     管理画面アクセス不可画面表示
        * @param　　　　なし
        * @return　　　なし
        */
        public function denyAcess(){
            echo "エラー";
            exit;
        }
    }

?>

<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Home extends MX_Controller {

    private $viewData;
            
    function __construct() {
        parent::__construct();
        $this->load->helper('breabcrumb_helper');
    }
    
    function index(){

        $this->viewData['loadPage'] = 'owner/index';
        
        $this->load->view("owner/layout/layout_A",  $this->viewData);
        
        
        
    }
    

}




?>

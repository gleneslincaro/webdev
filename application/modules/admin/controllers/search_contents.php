<?php
class search_contents extends MX_Controller
{
    protected $_data;
    protected $_dataResult;
    public function __construct()
    {
        parent::__construct();
        AdminControl::CheckLogin();
        $this->_data["module"] = $this->router->fetch_module();
        $this->output->set_header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate");
        $this->output->set_header("Cache-Control: post-check=0, pre-check=0");
        $this->output->set_header("Pragma: no-cache");
    }

    public function area($group_city = null, $city = null, $town = null)
    {
        $this->load->Model("user/mcity");
        if ($group_city == null && $city == null && $town == null) {
            $step = 0;
            $this->_data['city_groups']=$this->mcity->getCityGroup();
        } elseif ($city == null && $town == null) {
            $step = 1;
            $city_group=$this->mcity->getGroupCityByAlphaName($group_city);
            $this->_data['city_group_alphaname']=$group_city.'/';
            $this->_data['city_group_name']=$city_group['name'];
            $this->_data['citys']=$this->mcity->getCity($city_group['id']);
        } elseif ($town == null) {
            $step = 2;
            $citys=$this->mcity->getCityByAlphaName($city);
            $city_group=$this->mcity->getGroupCityByAlphaName($group_city);
            $this->_data['city_group_alphaname']=$group_city.'/';
            $this->_data['city_group_name']=$city_group['name'];
            $this->_data['city_name']=$citys['name'];
            $this->_data['city_alphaname']=$city.'/';
            $this->_data['towns']=$this->mcity->getTown($citys['id']);
        }
        $this->load->Model("admin/Msearch_contents");
        $this->_data["loadPage"]="search_contents/area";
        $this->_data["titlePage"]="エリア文言";
        $this->_data["step"]=$step;
        $this->load->view($this->_data["module"] . "/layout/layout", $this->_data);
    }
    
    public function area_ajax()
    {
        $group_city = null;
        $city = null;
        $town = null;

        $area_str = $this->input->post('area');
        $ar_str = explode("/", $area_str);
        foreach ($ar_str as $key => $val) {
            if ($key == 1) {
                $city = ($val != '')? $val:null;
            } elseif ($key == 2) {
                $town = ($val != '')? $val:null;
            } else {
                $group_city = ($val != '')? $val:null;
            }
        }

        $this->load->Model("user/mcity");
        if ($group_city == null && $city == null && $town == null) {
            $step = 0;
            $this->_data['city_groups']=$this->mcity->getCityGroup();
        } elseif ($city == null && $town == null) {
            $step = 1;
            $city_group=$this->mcity->getGroupCityByAlphaName($group_city);
            $this->_data['city_group_alphaname']=$group_city.'/';
            $this->_data['city_group_name']=$city_group['name'];
            $this->_data['citys']=$this->mcity->getCity($city_group['id']);
        } elseif ($town == null) {
            $step = 2;
            $citys=$this->mcity->getCityByAlphaName($city);
            $city_group=$this->mcity->getGroupCityByAlphaName($group_city);
            $this->_data['city_group_alphaname']=$group_city.'/';
            $this->_data['city_group_name']=$city_group['name'];
            $this->_data['city_name']=$citys['name'];
            $this->_data['city_alphaname']=$city.'/';
            $this->_data['towns']=$this->mcity->getTown($citys['id']);
        }
        $this->_data["step"]=$step;
        $this->load->view('search_contents/area_table_list', $this->_data);
    }

    public function areaselact()
    {
        $this->load->Model("admin/Msearch_contents");
        $this->_data['city_groups']=$this->Msearch_contents->getCityGroup();
        $this->_data["loadPage"]="search_contents/area";
        $this->_data["titlePage"]="エリア文言";
        $this->load->view($this->_data["module"]."/layout/layout", $this->_data);
    }
        
    public function updateAreaContents()
    {
        $this->load->Model("admin/Msearch_contents");
        $step = $this->input->post('step');
        $id = $this->input->post('id');
        $text = $this->input->post('text');
        switch ($step) {
            case 0:
                $this->Msearch_contents->updateCityGroupContents($id, $text);
                $data = $text;
                break;
            case 1:
                $this->Msearch_contents->updateCityContents($id, $text);
                $data = $text;
                break;
            case 2:
                $this->Msearch_contents->updateTownContents($id, $text);
                $data = $text;
                break;
            default:
                break;
        }
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function getAreaContents()
    {
        $this->load->Model("admin/Msearch_contents");
        $id = $this->input->post('id');
        $step = $this->input->post('step');
        switch ($step) {
            case 0:
                $ar = $this->Msearch_contents->getCityGroupContents($id);
                $data = $ar["contents"];
                break;
            case 1:
                $ar = $this->Msearch_contents->getCityContents($id);
                $data = $ar["contents"];
                break;
            case 2:
                $ar = $this->Msearch_contents->getTownContents($id);
                $data = $ar["contents"];
                break;
            default:
                break;
        }
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }
    
    public function jobtype()
    {
        $this->load->Model("user/Mstyleworking");
        $this->_data['jobtype_ar']=$this->Mstyleworking->getJobTypes();
        $this->_data["loadPage"]="search_contents/jobtype";
        $this->_data["titlePage"]="業種文言";
        $this->load->view($this->_data["module"]."/layout/layout", $this->_data);
    }

    public function jobtypeContents()
    {
        $this->load->Model("admin/Msearch_contents");
        $jobtype_id = $this->input->post('jobtype_id');

        $jobtype_data = $this->Msearch_contents->getJobtypeContents($jobtype_id);
        $data = $jobtype_data;
//        $data = $jobtype_data["contents"];
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }
    
    public function updateJobtypeContents()
    {
        $this->load->Model("admin/Msearch_contents");
        $id = $this->input->post('id');
        $income = $this->input->post('income');
        $text = $this->input->post('text');
        $text2 = $this->input->post('text2');
        $text3 = $this->input->post('text3');
        $text4 = $this->input->post('text4');
        $this->Msearch_contents->updateJobtypeContents($id, $income, $text, $text2, $text3, $text4);
        $data = $text;
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }
    
    public function treatment()
    {
        $this->load->Model("user/Mstyleworking");
        $this->_data['treatments_ar']=$this->Mstyleworking->getTreatments();
        $this->_data["loadPage"]="search_contents/treatment";
        $this->_data["titlePage"]="待遇文言";
        $this->load->view($this->_data["module"]."/layout/layout", $this->_data);
    }

    public function treatmentContents()
    {
        $this->load->Model("admin/Msearch_contents");
        $treatment_id = $this->input->post('treatment_id');

        $treatment_data = $this->Msearch_contents->getTreatmentContents($treatment_id);
        $data = $treatment_data;
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function updateTreatmentContents()
    {
        $this->load->Model("admin/Msearch_contents");
        $id = $this->input->post('id');
        $text = $this->input->post('text');
        $text2 = $this->input->post('text2');
        $text3 = $this->input->post('text3');
        $this->Msearch_contents->updateTreatmentContents($id, $text, $text2, $text3);
        $data = $text;
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

}
/* joyspe/application/modules/admin/controllers/search_contents.php  */
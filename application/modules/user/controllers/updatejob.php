<?php
class updatejob extends MY_Controller{
    private $viewData = array();
    private $common;
    private $validator;
    private $layout = 'user/layout/main';
    private $message = array('success' => true, 'error' => array());
    private $device;
    public function __construct() {
        parent::__construct();
        $this->redirect_pc_site();
        $this->common = new Common();
        $this->validator = new FormValidator();  
        $this->viewData['idheader'] = NULL;
        $this->viewData['email'] = '';
    }

    public function index($group_city = null)
    {

        if ($group_city == null) {
            echo "urlにエリアを入力して下さい";
            exit();
        }


        echo "エリア求人データ更新!";
                    echo "<br>";

        $groupCity = $this->mcity->getCityGroup();

        $owner_status = "2,5";

        $towns_ar = array();
        $area_ar = array();

        $city_index = 0;
        $index = 0;

        $GroupCity = $this->mcity->getGroupCityByAlphaName($group_city);

        $city_group_id = $GroupCity['id'];
        $getCity = $this->mcity->getCity($city_group_id);
        foreach ($getCity as $key2 => $val2) {
            $arr_town = $this->mcity->getTownIds($val2['id']);
            //echo "city_id".$val2['id'];
            //echo "<br>";
            $area_ar[$val2['id']]['city'] = $val2['id'];
            $temp_towns = $this->mcity->getTownUserCountIds($val2['id'], $owner_status);
            $area_ar[$val2['id']]['town'] = $temp_towns;

            $towns_ar[$index] = $temp_towns;
            $index++;
        }

        foreach ($area_ar as $key => $val) {
            $city_id = $val['city'];
            if (count($area_ar[$city_id]['town']) > 0) {
                echo "num=".count($area_ar[$city_id]['town']);
                echo "<br>";
                foreach ($area_ar[$city_id]['town'] as $key2 => $val2) {
                    echo "id=".$val2['id'].' '."name=".$val2['name'].' '."alph_name=".$val2['alph_name'].' '."ocount=".$val2['ocount'];
                    echo "<br>";
                }
            }
        }

        foreach ($area_ar as $key => $val) {
            $city_id = $val['city'];
            if (count($area_ar[$city_id]['town']) > 0) {
                foreach ($area_ar[$city_id]['town'] as $key2 => $val2) {
                    $this->mcity->updateTownOwnerCount($val2);
                }
            }
        }

    }

    public function update_town($town_name = null)
    {

        $towns_ar = array();
        $area_ar = array();

        $city_index = 0;
        $index = 0;

        $owner_status = "2,5";

            $town_info = $this->mcity->getTownByAlphaNameR($town_name);
            $city_id = $town_info['city_id'];

            $area_ar[$city_id]['city'] = $city_id;
            $temp_towns = $this->mcity->getTownUserCountIds($city_id, $owner_status);
            $area_ar[$city_id]['town'] = $temp_towns;

            $towns_ar[$index] = $temp_towns;

            foreach ($area_ar as $key => $val) {
                $city_id = $val['city'];
                if (count($area_ar[$city_id]['town']) > 0) {
                    echo "num=".count($area_ar[$city_id]['town']);
                    echo "<br>";
                    foreach ($area_ar[$city_id]['town'] as $key2 => $val2) {
                        echo "id=".$val2['id'].' '."name=".$val2['name'].' '."alph_name=".$val2['alph_name'].' '."ocount=".$val2['ocount'];
                        echo "<br>";
                    }
                }
            }

            foreach ($area_ar as $key => $val) {
                $city_id = $val['city'];
                if (count($area_ar[$city_id]['town']) > 0) {
                    foreach ($area_ar[$city_id]['town'] as $key2 => $val2) {
                        $this->mcity->updateTownOwnerCount($val2);
                    }
                }
            }

    }

}
?>

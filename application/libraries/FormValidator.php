<?php

/**
 * Class Formvalidator
 * Validate form input elements such as input, option, radio, checkbox or even button value
 * Simply by passing thru element names
 * 
 * @author 0512146 Ziony Phan Thanh Ha & Le Hoang Thanh
 */
class FormValidator {

    private $element_array = array();
    private $method = "post";
    private $invalid_elements = array();
    private $allowed_image_type = array('image/png', 'image/jpeg', 'image/gif');
    private $blacklist_extensions = array('php','php3','php4','phtml','pl','py','jsp','asp','aspx','htm','shtml','sh','cgi');
    /**
     * Constructor
     * method must be "get" or "post". Default value is "post"
     * @var string $_method
     * 
     */
    public function __construct($_method = "post") {
        if ($_method != "post")
            $this->method = "get";
    }

    /*     * *
     * Add single element or array of element
     * If just want to check the Element is exsits: $notnull = false
     * Otherwise you may wanna check the Element is not null: $notnull = true 
     * 
     */

    public function addElement($element, $notEmpty = true) {
        if (is_array($element)) {
            foreach ($element as $ele) {
                $this->addSingleElement($ele, $notEmpty);
            }
        } else {
            $this->addSingleElement($element, $notEmpty);
        }
    }

    /*     * *
     * Private calling form internal class
     */

    private function addSingleElement($singleElement, $notnull = false) {
        if ($notnull == true) {
            $tmp_array = array();
            $tmp_array['NOTNULL'] = true;
            $tmp_array['element'] = $singleElement;

            $this->element_array[] = $tmp_array;
        }
        else
            $this->element_array[] = $singleElement;
    }

    /*     * *
     * Change the current method
     * Method must be "get" or "post"
     * @var String $newMethod 
     */

    public function setMethod($newMethod) {
        if ($newMethod == "get" || $newMethod == "post")
            $this->method = $newMethod;
    }

    /*     * *
     * The most important function you need
     * Wanna know the form is valid or not? :-)
     * @return boolean
     * 
     */

    public function validate() {
        $result = true;
        foreach ($this->element_array as $object) {
            if (is_array($object)) {
                if ($this->ValidateSingleArray($object) == false) {
                    $result = false;
                    $this->invalid_elements[] = $object['element'];
                }
            } else {
                if ($this->ValidateSingleElement($object) == false) {
                    //DebugVariable($object);
                    $result = false;
                    $this->invalid_elements[] = $object;
                }
            }
        }
        return $result;
    }

    public function getInvalidElements() {
        return $this->invalid_elements;
    }

    private function ValidateSingleArray($object) {
        if ($this->method == "post") {
            $res1 = @isset($_POST[$object['element']]);
            $res2 = (trim($_POST[$object['element']]) != "");
            if ($res1 == false || $res2 == false)
                return false;
            else
                return true;
        }
        else {
            $res1 = @isset($_GET[$object['element']]);
            $res2 = (trim($_GET[$object['element']]) != "");
            if ($res1 == false || $res2 == false)
                return false;
            else
                return true;
        }
        //can not be here!! :-)
        return false;
    }

    private function ValidateSingleElement($object) {
        if ($this->method == "post") {
            $res1 = @isset($_POST[$object]);
            if ($res1 == false)
                return false;
            else
                return true;
        }
        else {
            $res1 = @isset($_GET[$object]);
            if ($res1 == false)
                return false;
            else
                return true;
        }
        //can not be here!! :-)
        return false;
    }

    private function validateType($type) {
        if (array_search($type, $this->allowed_image_type) === false)
            return false;
        return true;
    }

    private function validateImage($image) {
        $size = @getimagesize($image);
        if (!is_array($size))
            return false;
        return true;
    }

    private function validateSize($filesize, $allow_size) {
        if ((float) $filesize > (float) $allow_size)
            return false;
        return true;
    }
    
    public function is_blacklist_extension($extension){
        if(array_search(strtolower($extension), $this->blacklist_extensions) === false)
            return false;
        return true;
    }

    public function is_valid_image($file, $allow_size = 3145728) {
        $information = pathinfo($file['name']);
        if ($this->is_no_upload_file($file) || !$this->validateImage($file['tmp_name']) || !$this->validateType($file['type']) || !$this->validateSize($file['size'], $allow_size) || $this->is_blacklist_extension($information['extension']))
            return false;
        return true;
    }

    public function is_no_upload_file($file) {
        if ($file['error'] != UPLOAD_ERR_NO_FILE)
            return false;
        return true;
    }

    public function is_exceed_file_ini_size($file) {
        if ($file['error'] != UPLOAD_ERR_INI_SIZE)
            return false;
        return true;
    }

    public function is_exceed_file_form_size($file) {
        if ($file['error'] != UPLOAD_ERR_FORM_SIZE)
            return false;
        return true;
    }

    public function is_valid_file($file, $allow_size = 3145728) {
        $information = pathinfo($file['name']);
        if ($this->is_no_upload_file($file))
            return false;
        if ($this->is_exceed_file_ini_size($file) || $this->is_exceed_file_form_size($file))
            return false;
        //if $allow_size == 0 mean don't check size
        if ($allow_size  > 0 && !$this->validateSize($file['size'], $allow_size))
            return false;
        if($this->is_blacklist_extension($information['extension']))
            return false;
        return true;
    }

    public function is_normal_character($str) {
        //this method use for validate Username, normal characters with no space but can contain "_"
        $pattern = '/^[A-Za-z0-9]+(?:[_][A-Za-z0-9]+)*$/';
        return FormValidator::is_valid($pattern, $str);
    }

    public function has_speacial_character($str) {
        $pattern = '/[\'\/~`\!@#\$%\^&\*\(\)_\-\+=\{\}\[\]\|;:"\<\>,\.\?\\\]/';
        return !FormValidator::is_valid($pattern, $str);
    }

    public function is_credit_card($str) {
        $pattern = '/^(?:4[0-9]{12}(?:[0-9]{3})?|5[1-5][0-9]{14}|6(?:011|5[0-9][0-9])[0-9]{12}|3[47][0-9]{13}|3(?:0[0-5]|[68][0-9])[0-9]{11}|(?:2131|1800|35\d{3})\d{11})$/';
        return FormValidator::is_valid($pattern, $str);
    }
    
    public function is_positive_number($str){
        $pattern = '/^\d+$/';
        return FormValidator::is_valid($pattern, $str);
    }

    public function resetValidator() {
        $this->element_array = array();
        $this->invalid_elements = array();
        $this->method = "post";
    }

    public static function check_max_image_size($w, $h, $img) {
        $info = @getimagesize($img);
        if(!$info)
            return false;
        return (int) $info[0] <= $w && (int) $info[1] <= $h;
    }

    public static function check_min_image_size($w, $h, $img) {
        $info = @getimagesize($img);
        if(!$info)
            return false;
        return (int) $info[0] >= $w && (int) $info[1] >= $h;
    }

    public static function check_fixed_image_size($w, $h, $img) {
        $info = @getimagesize($img);
        if(!$info)
            return false;

        return (int) $info[0] == $w && (int) $info[1] == $h;
    }

    public static function is_email($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    public static function is_URL($url) {
        return filter_var($url, FILTER_VALIDATE_URL);
    }

    public static function is_boolean($element) {
        return filter_var($element, FILTER_VALIDATE_BOOLEAN);
    }

    public static function is_integer($element) {
        return filter_var($element, FILTER_VALIDATE_INT);
    }

    public static function is_ip($element) {
        return filter_var($element, FILTER_VALIDATE_IP);
    }

    public static function is_float($element) {
        return filter_var($element, FILTER_VALIDATE_FLOAT);
    }

    public static function is_valid($pattern, $subject) {
        return preg_match($pattern, $subject);
    }

    public static function is_match($str, $array) {
        return array_search($str, $array) !== FALSE;
    }

    public static function is_valid_date($day, $month, $year) {
        return checkdate($month, $day, $year);
    }

    public static function is_empty_string($name) {
        return trim($name) == '';
    }

}

?>
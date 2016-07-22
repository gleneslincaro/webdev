<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cipher extends MX_Controller {
    private $securekey, $iv;
    function __construct() {
            $textkey = "random text";
            $this->securekey = hash('sha256',$textkey,TRUE);
            $this->iv = str_repeat("\0", 8);
    }
    /**
     * Get encrypted data
     * @param $input serialize value for username, password and created date
     * @return string
     */
    function encrypt($input) {
        return urlencode(base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $this->securekey, $input, MCRYPT_MODE_ECB, $this->iv)));
    }
    /**
     * Get encrypted data
     * @param $input encrypt vaule
     * @return string serialize
     */
    function decrypt($input) {
        return trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $this->securekey, base64_decode(urldecode($input)), MCRYPT_MODE_ECB, $this->iv));
    }
}

?>

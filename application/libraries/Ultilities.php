<?php

class Ultilities {

    public static function random($type = 'sha1', $len = 20) {
        if (phpversion() >= 4.2)
            mt_srand();
        else
            mt_srand(hexdec(substr(md5(microtime()), - $len)) & 0x7fffffff);

        switch ($type) {
            case 'basic':
                return mt_rand();
                break;
            case 'alpha':
            case 'numeric':
            case 'nozero':
                switch ($type) {
                    case 'alpha':
                        $param = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                        break;
                    case 'numeric':
                        $param = '0123456789';
                        break;
                    case 'nozero':
                        $param = '123456789';
                        break;
                }
                $str = '';
                for ($i = 0; $i < $len; $i++) {
                    $str .= substr($param, mt_rand(0, strlen($param) - 1), 1);
                }
                return $str;
                break;
            case 'md5':
                return md5(uniqid(mt_rand(), TRUE));
                break;
            case 'sha1':
                return sha1(uniqid(mt_rand(), TRUE));
                break;
        }
    }
    
    public static function base32UUID(){
        $result = self::_custombase_convert(strrev(uniqid()),'0123456789abcdef','0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ');
        while(strlen($result) != 9){
            $result = self::_custombase_convert(strrev(uniqid()),'0123456789abcdef','0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ');
        }
        return $result;
    }
    
    private static function _custombase_convert($numstring, $baseFrom = "0123456789", $baseTo = "0123456789") {
        $numstring = (string) $numstring;
        $baseFromLen = strlen($baseFrom);
        $baseToLen = strlen($baseTo);
        if ($baseFrom == "0123456789") { // No analyzing needed, because $numstring is already decimal 
            $decVal = (int) $numstring;
        } else {
            $decVal = 0;
            for ($len = (strlen($numstring) - 1); $len >= 0; $len--) {
                $char = substr($numstring, 0, 1);
                $pos = strpos($baseFrom, $char);
                if ($pos !== FALSE) {
                    $decVal += $pos * ($len > 0 ? pow($baseFromLen, $len) : 1);
                }
                $numstring = substr($numstring, 1);
            }
        }
        if ($baseTo == "0123456789") { // No converting needed, because $numstring needs to be converted to decimal 
            $numstring = (string) $decVal;
        } else {
            $numstring = FALSE;
            $nslen = 0;
            $pos = 1;
            while ($decVal > 0) {
                $valPerChar = pow($baseToLen, $pos);
                $curChar = floor($decVal / $valPerChar);
                
                if ($curChar >= $baseToLen) {
                    $pos++;
                } else {
                    $decVal -= ($curChar * $valPerChar);
                    if ($numstring === FALSE) {
                        $numstring = str_repeat($baseTo{1}, $pos);
                        $nslen = $pos;
                    }
                    
                    $numstring = substr($numstring, 0, ($nslen - $pos)) . $baseTo{(int)$curChar} . substr($numstring, (($nslen - $pos) + 1));
                    $pos--;
                }
            }
            if ($numstring === FALSE)
                $numstring = $baseTo{1};
        }
        return $numstring;
    }

}
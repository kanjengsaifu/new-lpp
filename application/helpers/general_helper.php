<?php
if(!defined('BASEPATH')) exit('No direct access script allowed!');

if(!function_exists('dbTodayDate')) {
    function dbTodayDate() {
        return date('Y-m-d');
    }
}

if(!function_exists('left')) {
    function left($str, $length) {
         return substr($str, 0, $length);
    }
}

if(!function_exists('right')) {
    function right($str, $length) {
         return substr($str, -$length);
    }
}

if(!function_exists('dbTodayDatetime')) {
    function dbTodayDatetime() {
        return date('Y-m-d H:i:s');
    }
}

if(!function_exists('todayDate')) {
    function todayDate() {
        return date('d-m-Y');
    }
}

if(!function_exists('formatNumber')) {
    function formatNumber($number, $decimal = 0) {
        return number_format($number, $decimal);
    }
}

if(!function_exists('dbFormatNumber')) {
    function dbFormatNumber($number) {
        return str_replace(',', '', $number);
    }
}

if(!function_exists('generateSalt')) {
    function generateSalt($sha) {
        return hash($sha, uniqid(mt_rand(1, mt_getrandmax()), true));
    }
}

if(!function_exists('generateRandomString')) {
    function generateRandomString($len = 8) {
        return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $len);
    }
}

if(!function_exists('convertDateFormat')) {
    function convertDateFormat($date, $format) {
        if($date == '' || $date == null) {
            return '';
        } else {
            return date($format, strtotime($date));
        }
    }
}

if(!function_exists('convertDateFormatToDatepickerFormat')) {
    function convertDateFormatToDatepickerFormat($format) {
        $return = '';

        switch($format) {
            case 'd-m-Y':
                $return = 'DD-MM-YYYY';
                break;
            case 'd/m/Y':
                $return = 'DD/MM/YYYY';
                break;
        }

        return $return;
    }
}

if(!function_exists('sanitize')) {
    function sanitize($str)
    {
        $bad='/[\/:*?"<>|]/';
        return preg_replace($bad, '', $str);
    }
}

if(!function_exists('leftPad')) {
    function leftPad($str, $len = 4, $pad = 0) {
        return str_pad($str, $len, $pad, STR_PAD_LEFT);
    }
}

if(!function_exists('rightPad')) {
    function rightPad($str, $len = 4, $pad = 0) {
        return str_pad($str, $len, $pad, STR_PAD_RIGHT);
    }
}

if(!function_exists('middlePad')) {
    function middlePad($str, $len, $pad) {
        return str_pad($str, $len, $pad, STR_PAD_BOTH);
    }
}

if(!function_exists('hex2str')) {
    function hex2str($hex) {
        return pack('H*', $hex);
    }
}

if(!function_exists('str2hex')) {
    function str2hex($str) {
        $unpack = unpack('H*', $str);
        return array_shift($unpack);
    }
}

if(!function_exists('generateTransactionNo')) {
    function generateTransactionNo($prefix, $transactionDate, $tableName) {
        $ci =& get_instance();

        $month = date('m', strtotime($transactionDate));
        $year = date('Y', strtotime($transactionDate));
        $shortYear = date('y', strtotime($transactionDate));

        $query = $ci->db->query("SELECT MAX(RIGHT(ref_no, 4)) AS seq FROM ".$tableName." WHERE MONTH(date) = '".$month."' AND YEAR(date) = '".$year."'");
        $seq = (int)$query->row()->seq;
        $seq++;

        /*$result = $ci->config->item('transactionNumberFormat');
        $result = str_replace('{prefix}', $prefix, $result);
        $result = str_replace('{MM}', $month, $result);
        $result = str_replace('{YY}', $shortYear, $result);
        $result = str_replace('{seq}', leftPad($seq, 4), $result);*/

        $result = $prefix.'/'.$month.'/'.$shortYear.'/'.leftPad($seq, 4);
        return $result;
    }
}

if(!function_exists('replaceMobileNo')) {
    function replaceMobileNo($mobileNo) {
        $ci =& get_instance();

        if(left($mobileNo, 1) == '0') {
            $len = strlen($mobileNo);
            return $ci->config->item('phoneCountryCode').right($mobileNo, ($len - 1));
        } else {
            return $mobileNo;
        }
    }
}

if(!function_exists('showHours')) {
    function showHours() {
        $result = array();

        for($i = 0; $i <= 23; $i++) {
            $result[] = array('label' => leftPad($i, 2), 'value' => $i);
        }

        return $result;
    }
}

if(!function_exists('showMinutes')) {
    function showMinutes() {
        $result = array();

        for($i = 0; $i <= 59; $i++) {
            $result[] = array('label' => leftPad($i, 2), 'value' => $i);
        }

        return $result;
    }
}

if(!function_exists('joinHourMinute')) {
    function joinHourMinute($h, $m) {
        return $h.':'.$m;
    }
}

if(!function_exists('splitHourMinute')) {
    function splitHourMinute($time) {
        return explode(':', $time);
    }
}

if(!function_exists('generateImageName')) {
    function generateImageName($prefix, $tableName, $fieldName, $len = 20) {
        $ci =& get_instance();

        $filename = $prefix.generateRandomString($len);

        $query = $ci->db->query("SELECT COUNT(0) AS jum FROM ".DB_PREFIX.$tableName." WHERE ".$fieldName." = '".$filename."'");
        $row = $query->row_array();

        if($row['jum'] > 0) {
            generateImageName($prefix, $tableName, $fieldName);
        } else {
            return $filename;
        }
    }
}

if(!function_exists('generateImageNameOnly')) {
    function generateImageNameOnly($prefix, $len = 20) {
        $filename = $prefix.generateRandomString($len);

        return $filename;
    }
}

if(!function_exists('getMonthName')) {
    function getMonthName($i) {
        $result = '';

        switch($i) {
            case 1:
                $result = 'Januari';
                break;

            case 2:
                $result = 'Februari';
                break;

            case 3:
                $result = 'Maret';
                break;

            case 4:
                $result = 'April';
                break;

            case 5:
                $result = 'Mei';
                break;

            case 6:
                $result = 'Juni';
                break;

            case 7:
                $result = 'Juli';
                break;

            case 8:
                $result = 'Agustus';
                break;

            case 9:
                $result = 'September';
                break;

            case 10:
                $result = 'Oktober';
                break;

            case 11:
                $result = 'November';
                break;

            case 12:
                $result = 'Desember';
                break;

            default:
                $result = '';
        }

        return $result;
    }
}

if(!function_exists('showMonths')) {
    function showMonths() {
        $result = array();

        for($i = 1; $i <= 12; $i++) {
            $result[] = array('id' => leftPad($i, 2), 'label' => getMonthName($i));
        }

        return $result;
    }
}

if(!function_exists('generateRandomStringNumber')) {
    function generateRandomStringNumber($len = 6) {
        $char = '0123456789';
        $charLen = strlen($char);
        $result = '';

        for($i = 0; $i < $len; $i++) {
            $result .= $char[rand(0, $charLen - 1)];
        }

        return $result;
    }
}

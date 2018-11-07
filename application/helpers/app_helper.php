<?php
if(!defined('BASEPATH')) exit('No direct access script allowed!');

if (!function_exists('get_status_int'))
{
    function get_status_int($status)
    {
        if ($status == null) {
			$statusInt = 0; //un-checked
		} else {
			$statusInt = 1; //checked
        }

        return $statusInt;
    }
}

if (!function_exists('get_status_spk_int'))
{
    function get_status_spk_int($spk_status)
    {
        if ( strtolower($spk_status) == "mulai" ) {
			$statusSpkInt = 0;
		} else if ( strtolower($spk_status) == "dalam proses" ) {
			$statusSpkInt = 1;
		} else {
			$statusSpkInt = 2;
        }

        return $statusSpkInt;
    }
}

if (!function_exists('get_status_spk_word'))
{
    function get_status_spk_word($spk_status_int)
    {
        if ( (int) $spk_status_int == 0 ) {
            $statusSpkWord = "Mulai";
		} else if ( (int) $spk_status_int == 1 ) {
            $statusSpkWord = "Dalam Proses";
		} else {
			$statusSpkWord = "Selesai";
        }

        return $statusSpkWord;
    }
}
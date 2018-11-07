<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//$route['url yang di tulis] = "nama controller/nama function di controller";
// $route['transaction/spks/showAllSpk/(:any)'] = "spks/showAllSpk/$1";

$route['default_controller'] = 'pages/view';
$route['pages/(:any)'] = 'pages/view/$1';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
  | -------------------------------------------------------------------------
  | THEMES CONFIG
  | -------------------------------------------------------------------------
  | This config will be used in : ./application/libraries/template.php
  | Each template will be used different value for config variable : '_assets, _assets_css, _assets_js'
 */

$CI = & get_instance();

//Common assets
$config['_sufiks_min_assets'] = ''; //set to ".min" : to load minimize version of 'js|css', example : jquery.min.js
$config['_general_assets'] = "{$CI->config->item("base_url")}assets/";
$config['_general_assets_css'] = "{$config['_general_assets']}css/";
$config['_general_assets_js'] = "{$config['_general_assets']}js/";

unset($CI);

/* End of file template.php */
/* Location: ./application/config/template.php */
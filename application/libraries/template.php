<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Template {

    private $CI;

    public function __construct() {
        $this->CI = & get_instance();
    }

    public function __destruct() {
        unset($this->CI);
    }

    public function set_template($template = '') {
        //load library view
        $this->CI->load->library('view');

            //set assets data to view-library
        $this->CI->view->set(array(
            '_path' => "{$template}/",
            '_general_assets' => $this->CI->config->item("_general_assets"),
            '_general_assets_css' => $this->CI->config->item("_general_assets_css"),
            '_general_assets_js' => $this->CI->config->item("_general_assets_js"),
            '_assets' => "{$this->CI->config->item("_general_assets")}{$template}/",
            '_assets_css' => "{$this->CI->config->item("_general_assets")}{$template}/css/",
            '_assets_js' => "{$this->CI->config->item("_general_assets")}{$template}/js/",
            '_sufiks_min_assets' => $this->CI->config->item("_sufiks_min_assets")
        )); 
    }

}

/* End of file template.php */
/* Location: ./application/libraries/template.php */
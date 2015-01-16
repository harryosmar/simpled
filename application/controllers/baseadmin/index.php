<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

include_once APPPATH . 'core/controllers/baseadmin.php';

class Index extends Baseadmin {
    public function __construct() {
        parent::__construct();
    }

    public function index(){
    	$this->page_css[] = $this->_assets_css."pages/index.css";
    	$this->page_js[] = $this->_assets_js."pages/index.js";
    	parent::index();
    }
}

/* End of file index.php */
/* Location: ./application/controllers/baseadmin/index.php */
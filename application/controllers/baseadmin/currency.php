<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

include_once APPPATH . 'core/controllers/crud.php';

class Currency extends Crud {
    public function __construct() {
        parent::__construct();
    }

    public function index(){
    	$this->page_css[] = $this->_assets_css."pages/currency.css";
    	$this->page_js[] = $this->_assets_js."pages/currency.js";
    	parent::index();
    }
}

/* End of file currency.php */
/* Location: ./application/controllers/baseadmin/currency.php */
<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

include_once APPPATH . 'core/controllers/crud.php';

class Coa_type extends Crud {
    public function __construct() {
        parent::__construct();
    }

    public function index(){
    	$this->page_css[] = $this->_assets_css."pages/coa_type.css";
    	$this->page_js[] = $this->_assets_js."pages/coa_type.js";
    	parent::index();
    }
}

/* End of file coa_type.php */
/* Location: ./application/controllers/baseadmin/coa_type.php */
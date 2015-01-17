<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

include_once APPPATH . 'core/models/core_model.php';

class Coa_model extends Core_model {

    //Datatables Attribute
    public $primary_key = "coa_id";
    public $_table = "coa";
    public $_view = "coa";

}

/* End of file coa_model.php */
/* Location: ./application/models/coa_model.php */
<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

include_once APPPATH . 'core/models/core_model.php';

class Coa_type_model extends Core_model {

    //Datatables Attribute
    public $primary_key = "coa_type_id";
    public $_table = "coa_type";
    public $_view = "coa_type";

}

/* End of file coa_type_model.php */
/* Location: ./application/models/coa_type_model.php */
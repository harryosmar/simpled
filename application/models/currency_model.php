<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

include_once APPPATH . 'core/models/core_model.php';

class Currency_model extends Core_model {

    //Datatables Attribute
    public $primary_key = "currency_id";
    public $_table = "currency";
    public $_view = "currency";

}

/* End of file currency_model.php */
/* Location: ./application/models/currency_model.php */
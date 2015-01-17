<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

include_once APPPATH . 'core/models/core_model.php';

class Jurnal_entry_model extends Core_model {

    //Datatables Attribute
    public $primary_key = "transaction_id";
    public $_table = "jurnal";
    public $_view = "jurnal";

}

/* End of file jurnal_entry_model.php */
/* Location: ./application/models/jurnal_entry_model.php */
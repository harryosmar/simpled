<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

include_once APPPATH . 'core/models/core_model.php';

class Jurnal_entry_model extends Core_model {

    //Datatables Attribute
    public $primary_key = "transaction_id";
    public $_table = "jurnal";
    public $_view = "jurnal";

    public function get_jurnal_detail_by_primary_key($primary_key){
    	$this->db->select("*");
        $this->db->from("jurnal_detail");
        $this->db->where(array("transaction_id" => $primary_key));
        return $this->db->get();
    }
}

/* End of file jurnal_entry_model.php */
/* Location: ./application/models/jurnal_entry_model.php */
<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

include_once APPPATH . 'core/models/core_model.php';

class Ledger_model extends Core_model {

    //Datatables Attribute
    public $primary_key = "transaction_id";
    public $_table = "jurnal";
    public $_view = "jurnal";

    public function get_list_ledger($post){
    	$this->db->select('j.ref_number, j.remarks, j.transaction_date, jd.*', FALSE);
    	$this->db->from("{$this->_table} j");
    	$this->db->join("jurnal_detail jd", "jd.transaction_id = j.transaction_id");
        //$this->db->join("coa c", "c.coa_id = jd.coa_id");

        $this->db->where('j.posted', 'YES');

    	if($post['coa_id'] != 0){
    		$this->db->where('jd.coa_id', $post['coa_id']);
    	}

    	if($post['from']){
    		$this->db->where('j.transaction_date >= ', $post['from']);
    	}

    	if($post['to']){
    		$this->db->where('j.transaction_date <= ', $post['to']);
    	}

        // if($post['action']){
        //     $posted = $post['action'] == 'posting' ? 'NO' : 'YES';
        //     $this->db->where('jd.posted', $posted);
        // }

        $this->db->group_by("jd.coa_id, jd.transaction_detail_id");
        $this->db->order_by("jd.coa_id ASC, j.transaction_date ASC, j.input_date ASC");
    	return $this->db->get();
    }
}

/* End of file ledger_model.php */
/* Location: ./application/models/ledger_model.php */
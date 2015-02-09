<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

include_once APPPATH . 'core/models/core_model.php';

class Posting_model extends Core_model {

    //Datatables Attribute
    public $primary_key = "transaction_id";
    public $_table = "jurnal";
    public $_view = "jurnal";

    public function get_list_jurnal($post){
        $this->db->select('j.*', FALSE);
        $this->db->from("{$this->_table} j");
        $this->db->where('transaction_status', 'VALID');

        if($post['from']){
            $this->db->where('j.transaction_date >= ', $post['from']);
        }

        if($post['to']){
            $this->db->where('j.transaction_date <= ', $post['to']);
        }

        if($post['action']){
            $posted = $post['action'] == 'posting' ? 'NO' : 'YES';
            $this->db->where('j.posted', $posted);
        }

        return $this->db->get();
    }

    /*public function get_list_jurnal($post){
    	$this->db->select('CONCAT(c.description, \'<br/>\', j.ref_number, \'<br/>\', j.remarks) AS `desc`, jd.*', FALSE);
    	$this->db->from("{$this->_table} j");
    	$this->db->join("jurnal_detail jd", "jd.transaction_id = j.transaction_id");
        $this->db->join("coa c", "c.coa_id = jd.coa_id");

    	if($post['coa_id'] != 0){
    		$this->db->where('jd.coa_id', $post['coa_id']);
    	}

    	if($post['from']){
    		$this->db->where('j.transaction_date >= ', $post['from']);
    	}

    	if($post['to']){
    		$this->db->where('j.transaction_date <= ', $post['to']);
    	}

        if($post['action']){
            $posted = $post['action'] == 'posting' ? 'NO' : 'YES';
            $this->db->where('jd.posted', $posted);
        }

    	return $this->db->get();
    }*/
}

/* End of file posting_model.php */
/* Location: ./application/models/posting_model.php */
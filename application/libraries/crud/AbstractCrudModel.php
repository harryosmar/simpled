<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

include_once APPPATH . 'libraries/crud/InterfaceCrudModel.php';

abstract class AbstractCrudModel implements InterfaceCrudModel {

	protected $CI, $table, $primary_key;

    public function get_table_name(){
    	return $this->table;
    }

    public function get_primary_key(){
    	return $this->primary_key;
    }

    public function delete($CI, $id){
    	$this->CI->db->delete($this->table, [
            $this->primary_key => $id
        ]);
    }

}

/* End of file AbstractCrudModel.php */
/* Location: ./application/libraries/crud/AbstractCrudModel.php */
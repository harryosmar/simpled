<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

include_once APPPATH . 'libraries/crud/InterfaceSchema.php';

abstract class AbstractSchema implements InterfaceSchema {

	protected $CI, $table_name, $primary_key_name, $fields = [];

    public function get_table_name(){
    	return $this->table_name;
    }

    public function get_primary_key_name(){
    	return $this->primary_key_name;
    }

    public function get_fields(){
        return $this->fields;
    }
}

/* End of file AbstractSchema.php */
/* Location: ./application/libraries/crud/AbstractSchema.php */
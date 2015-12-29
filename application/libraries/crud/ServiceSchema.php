<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

include_once APPPATH . 'libraries/crud/AbstractSchema.php';
include_once APPPATH . 'libraries/crud/ServiceField.php';


class ServiceSchema extends AbstractSchema {

	public function __construct($config = array(), CI_Controller $CI = NULL){
		if($CI === NULL){
            $this->CI = &get_instance();
        }else{
            $this->CI = $CI;
        }

        if (count($config) > 0){
			$config['fields'] = isset($config['fields']) ? $config['fields'] : NULL;	// if param fields is not exist then set it value to NULL
			$this->initialize($config);
		}else{
			$this->initialize(['fields' => NULL]); // if param is empty, at leaset set fields value to NULL
		}
	}

	public function initialize($config = array())
	{
		foreach ($config as $key => $val)
		{
			if (property_exists($this, $key))
			{
				$method = 'set_'.$key;

				if (method_exists($this, $method))
				{
					$this->$method($val);
				}
				else
				{
					$this->$key = $val;
				}
			}
		}

		return $this;
	}


	protected function set_fields($fields = NULL){
		if($fields){
			$this->fields = $fields;
			return $this->fields;
		}

		$fields = $this->CI->db->field_data($this->table_name);
		foreach ($fields as $index_field => $field) {
			$field = (array)$field;
			$field['table_name'] = $this->table_name;
            $field['label'] = ucwords(preg_replace("/_/", " ", $field->name));
            $field['targets'] = $index_field;

			$this->fields[$field->name] = new ServiceField($field, $this->CI);

			return $this->fields;
		}
	}

    public function get_CI_instance(){
    	return $this->CI;
    }

    public function __destruct() {
       unset($this->CI);
    }
}

/* End of file ServiceSchema.php */
/* Location: ./application/libraries/crud/ServiceSchema.php */
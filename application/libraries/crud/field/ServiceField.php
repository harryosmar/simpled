<?php
namespace crud\field;

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class ServiceField {
    // Codeigniter field data property
    private $table_name, $name, $type, $default, $max_lenght, $primary_key;

    // Custom addtional property for datatable
    private $label, $targets;
    private $visible = true;
    private $searchable = true;
    private $orderable = true;
    private $singlecolumn_search_type = 'like';
    private $enums = NULL;


    public function __construct($config = array(), \CI_Controller $CI = NULL){
        if($CI === NULL){
            $this->CI = &get_instance();
        }else{
            $this->CI = $CI;
        }

        if (count($config) > 0){
            $this->initialize($config);
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

        //if type is enum, then get enum values
        if($this->type == 'enum'){
            $this->enums = array_merge(["Select..." => ""], $this->get_enum_values());
        }

        return $this;
    }

    public function getAttribute($attribute_name){
        return property_exists($this, $attribute_name) ? $this->{$attribute_name} : NULL;
    }

    /**
    * @singlecolumn_search_type : equal|like, if type in(datetime|enum|currency) automatically use equal
    * @orderable 'true|false', default : 'true'
    * @searchable 'true|false', default : 'true'
    * @type 'text|enum|currency|datetime', default : 'text'
    */
    public function set_type($type){
        if (preg_match("/^(enum)$/i", $type)) {
            $this->type = "enum";
        } else if (preg_match("/^(date)$/i", $type)) {
            $this->type = "date";
        } else if (preg_match("/^(datetime|timestamp)$/i", $type)) {
            $this->type = "datetime";
        } else {
            $this->type = "text";
        }
    }

    /**
     * @desc this function used to generate 'array' contains enumeration data from a field(field-name using as parameter)
     * @param $field field-name that have type 'enum'
     * @return enumeration value list from a field
     */
    public function get_enum_values() {
        $type = $this->CI->db->query("SHOW COLUMNS FROM `{$this->table_name}` WHERE Field = '{$this->name}'")->row()->Type;
        preg_match('/^enum\((.*)\)$/', $type, $matches);
        
        //preg_match('/\'(.*)\'/', $matches[1], $matches2); print_r($matches2); die;
        foreach (explode('\',\'', $matches[1]) as $value) {
            $enum[preg_replace('/[\']/', '', $value)] = preg_replace('/[\']/', '', $value);
        }
        return $enum;
    }

    public function __destruct() {
       unset($this->CI);
    }
}

/* End of file ServiceField.php */
/* Location: ./application/libraries/crud/ServiceField.php */
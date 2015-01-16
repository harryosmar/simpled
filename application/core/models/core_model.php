<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @desc this is a 'core model'
 * @author harry
 * @date : 2012 Nov 12
 */
class Core_model extends CI_Model {

    protected $session_user;

    public function __construct() {
        parent::__construct();
        $this->session_user = $this->session->userdata('user');
    }

    /**
     * @desc get row by primary key value
     * @param primary_key
     */
    public function get_row_by_primary_key($primary_key) {
        $this->db->select("*");
        $this->db->from("{$this->_table}");
        $this->db->where(array("{$this->primary_key}" => $primary_key));
        return $this->db->get();
    }

    /**
     * @desc get by field parameter and value
     * @param primary_key
     */
    public function get_by_field($field, $value = '') {
        $this->db->select("*");
        $this->db->from("{$this->_table}");
        if (is_array($field)) {
            $this->db->where($field);
        } else {
            $this->db->where(array("{$field}" => $value));
        }
        return $this->db->get();
    }

    /**
     * @desc get result by primary key value
     */
    public function get_result($field_where = '', $val_where = '') {
        $this->db->select("*");
        $this->db->from("{$this->_table}");
        if (is_array($field_where)) {
            $this->db->where($field_where);
        } else if (!empty($field_where) && !empty($val_where)) {
            $this->db->where($field_where, $val_where);
        }
        return $this->db->get();
    }
    
     /**
     * @desc get result by primary key value
     */
    public function get_result_detail($field_where = '', $val_where = '') {
        $this->db->select("*");
        $this->db->from("{$this->_view}");
        if (is_array($field_where)) {
            $this->db->where($field_where);
        } else if (!empty($field_where) && !empty($val_where)) {
            $this->db->where($field_where, $val_where);
        }
        return $this->db->get();
    }
    
     /**
     * @desc get result by primary key value
     */
    public function get_count($field_where = '', $val_where = '') {
        $this->db->select("COUNT(1) AS `count`");
        $this->db->from("{$this->_table}");
        if (is_array($field_where)) {
            $this->db->where($field_where);
        } else if (!empty($field_where) && !empty($val_where)) {
            $this->db->where($field_where, $val_where);
        }
        return $this->db->get()->row()->count;
    }

    /**
     * @desc this function used to generate 'array' contains enumeration data from a field(field-name using as parameter)
     * @param $field field-name that have type 'enum'
     * @return enumeration value list from a field
     */
    public function get_enum_values($field, $_view = '') {
        $_view = ($_view == '') ? $this->_view : $_view;
        $type = $this->db->query("SHOW COLUMNS FROM `{$_view}` WHERE Field = '{$field}'")->row()->Type;
        preg_match('/^enum\((.*)\)$/', $type, $matches);
        
        //preg_match('/\'(.*)\'/', $matches[1], $matches2); print_r($matches2); die;
        foreach (explode('\',\'', $matches[1]) as $value) {
            $enum[preg_replace('/[\']/', '', $value)] = preg_replace('/[\']/', '', $value);
        }
        return $enum;
    }

    public function get_options($field, $val) {
        $this->db->select("*");
        $this->db->from($this->_table);
        $result = $this->db->get()->result();
        $return = array("Select..." => "");
        foreach ($result as $row) {
            $return[$row->{$field}] = $row->{$val};
        }
        return $return;
    }

    public function get_result_pk_as_index(){
        $this->db->select("*");
        $this->db->from($this->_table);
        $result = $this->db->get()->result_array();
        foreach ($result as $field) {
            $arr[$field[$this->primary_key]] = $field;
        }
        return $arr;
    }

}

/* End of file core_model.php */
/* Location: ./application/core/models/core_model.php */
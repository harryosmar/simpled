<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

include_once APPPATH . 'core/controllers/crud.php';

class Coa extends Crud {
    public function __construct() {
        parent::__construct();
    }

    protected function init(){
        $this->load->model('Coa_type_model');
        $this->load->model('Currency_model');
        parent::init();
    }

    public function index(){
    	$this->page_css[] = $this->_assets_css."pages/coa.css";
    	$this->page_js[] = $this->_assets_js."pages/coa.js";
    	parent::index();
    }

    protected function datatable_customize_columns() {
        $this->Coa_type_model;

        $this->columns[0]["visible"] = FALSE;
        $this->columns[2]["label"] = 'COA Type';
        $this->columns[2]["type"] = 'enum';
        $this->columns[2]["enums"] = $this->Coa_type_model->get_options('coa_type_name', 'coa_type_id');
        $this->columns[3]["label"] = 'Currency';
        $this->columns[3]["type"] = 'enum';
        $this->columns[3]["enums"] = $this->Currency_model->get_options('currency_label', 'currency_id');
        $this->columns[5]["label"] = 'CR/DR';
        $this->columns[6]["label"] = 'Status';
        //echo "<pre>"; print_r($this->columns); die;
        return $this->columns;
    }

    protected function datatable_field_record_formatter($field, $val, $column_index) {
        if ($field == 'coa_type_id') {
            return $this->db->query("SELECT coa_type_name FROM coa_type WHERE coa_type_id = ?", array($val))->row()->coa_type_name;
        } elseif($field == 'currency_id'){
            return $this->db->query("SELECT currency_label FROM currency WHERE currency_id = ?", array($val))->row()->currency_label;
        }else {
            return parent::datatable_field_record_formatter($field, $val, $column_index);
        }
    }

    protected function datatable_customize_actions($row) {
        return $this->view->load("pages/coa_action", array('primary_key' => $this->primary_key, 'row' => $row), TRUE);
    }


    protected function set_form_validation($field, $action) {
        if($field['db'] == 'coa_type_id'){
            return "xss_clean|required|integer|callback_check_coa_type_id";
        }elseif($field['db'] == 'coa_number' && $action == 'add'){
            return "xss_clean|required|max_length[{$field["field_data"]["max_length"]}]|is_unique[coa.coa_number]";
        }elseif($field['db'] == 'coa_number' && $action == 'edit'){
            return "xss_clean|required|max_length[{$field["field_data"]["max_length"]}]|callback_coa_number_for_edit";
        }else{
            return parent::set_form_validation($field, $action);
        }
    }

    protected function set_input_form($row, $field) {
        //echo "<pre>"; print_r($field); die;
        if (!$row) {
            $row = new stdClass();
            $row->coa_type_id = isset($row->coa_type_id) ? $row->coa_type_id : "";
            $row->currency_id = isset($row->currency_id) ? $row->currency_id : "";
        }

        if (preg_match("/^coa_type_id$/", $field["db"])) {
            return form_dropdown($field['db'], create_form_dropdown_options($this->db->query("SELECT * FROM coa_type")->result_array(), 'coa_type_id', 'coa_type_name'), $row->{$field['db']}, 'id="' . $field['db'] . '" class="form-control" placeholder="' . ucwords(preg_replace("/_/", " ", $field['db'])) . '"');
        } elseif (preg_match("/^currency_id$/", $field["db"])) {
            return form_dropdown($field['db'], create_form_dropdown_options($this->db->query("SELECT * FROM currency")->result_array(), 'currency_id', 'currency_label'), $row->{$field['db']}, 'id="' . $field['db'] . '" class="form-control" placeholder="' . ucwords(preg_replace("/_/", " ", $field['db'])) . '"');
        } else {
            return parent::set_input_form($row, $field);
        }
    }

    public function check_coa_type_id($coa_type_id) {
        if ($coa_type_id == 0) {
            $this->form_validation->set_message('check_coa_type_id', 'Please Select %s field');
            return FALSE;
        }

        $this->load->model('Coa_type_model');
        $coa_type = $this->Coa_type_model->get_row_by_primary_key($coa_type_id)->row();
        if (empty($coa_type)) {
            $this->form_validation->set_message('check_coa_type_id', 'The %s field is not valid');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function coa_number_for_edit($coa_number){
        $this->load->model('Coa_model');
        $coa = $this->Coa_model->get_by_field(array(
            'coa_number' => $coa_number,
            'coa_id <> ' => $this->input->post('coa_id')
        ))->row();

        if (!empty($coa)) {
            $this->form_validation->set_message('coa_number_for_edit', 'The %s field is already used');
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
}

/* End of file coa.php */
/* Location: ./application/controllers/baseadmin/coa.php */
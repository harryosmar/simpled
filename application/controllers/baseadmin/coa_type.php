<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

include_once APPPATH . 'core/controllers/crud.php';

class Coa_type extends Crud {
    public function __construct() {
        parent::__construct();
    }

    public function index(){
    	$this->page_css[] = $this->_assets_css."pages/coa_type.css";
    	$this->page_js[] = $this->_assets_js."pages/coa_type.js";
    	parent::index();
    }

    protected function datatable_customize_columns() {
        $this->load->model("User_group_model");

        $this->columns[0]["visible"] = FALSE;
        $this->columns[1]["label"] = 'COA Type';
        //echo "<pre>"; print_r($this->columns); die;
        return $this->columns;
    }

    protected function datatable_customize_actions($row) {
        return $this->view->load("pages/coa_type_action", array('primary_key' => $this->primary_key, 'row' => $row), TRUE);
    }

    protected function set_form_validation($field, $action) {
    	if($field['db'] == 'coa_type_name' && $action == 'add'){
            return "xss_clean|required|max_length[{$field["field_data"]["max_length"]}]|is_unique[coa_type.coa_type_name]";
        }elseif($field['db'] == 'coa_type_name' && $action == 'edit'){
            return "xss_clean|required|max_length[{$field["field_data"]["max_length"]}]|callback_coa_type_name_for_edit";
        }else{
        	return parent::set_form_validation($field, $action);
        }
    }

    public function coa_type_name_for_edit($coa_type_name){
        $coa_type = $this->Coa_type_model->get_by_field(array(
            'coa_type_name' => $coa_type_name,
            'coa_type_id <> ' => $this->input->post('coa_type_id')
        ))->row();

        if (!empty($coa_type)) {
            $this->form_validation->set_message('coa_type_name_for_edit', 'The %s field is already used');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function delete($primary_key = 0) {
        if ($this->input->is_ajax_request()){
            header('Content-Type: application/json');
            $this->load->library('form_validation');
            $_POST[$this->primary_key] = $primary_key;
            $this->form_validation->set_rules($this->primary_key, ucwords(preg_replace("/_/", " ", $this->primary_key)), 'required|callback_primary_id_check['.$this->primary_key.']|callback_is_already_used');
            if ($this->form_validation->run() == FALSE) {
                echo json_encode(array(
                    'status' => 'error',
                    'msg' => validation_errors(),
                    'action' => 'show_delete_msg'
                ));
            } else {
                $this->db->delete($this->_table, array(
                    $this->primary_key => $primary_key
                ));
                $this->log->addInfo('delete '.$this->_table, array('session' => $this->session->userdata('user'), 'query' => $this->db->last_query())); //record query in log data
                echo json_encode(array(
                    'status' => 'success',
                    'msg' => 'Successfully delete record',
                    'action' => 'show_delete_msg'
                ));
            }
            unset($_POST[$this->primary_key]);
        }
    }

    public function is_already_used($str){
    	$this->load->model('Coa_model');
    	$coa_type = $this->Coa_model->get_by_field(array(
            'coa_type_id' => $str
        ))->row();

        if (!empty($coa_type)) {
            $this->form_validation->set_message('is_already_used', 'Cannot delete %s field, because already used');
            return FALSE;
        } else {
            return TRUE;
        }
    }
}

/* End of file coa_type.php */
/* Location: ./application/controllers/baseadmin/coa_type.php */
<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

include_once APPPATH . 'core/controllers/crud.php';

/**
 * @author Harry <if07087@gmail.com>
 * @since 10 Oct 2014 
 * @todo Menu management : CRUD Menu
 */
class Menu extends Crud {

    public function __construct() {
        parent::__construct();
    }

    public function remove($primary_key = 0) {
        $this->load->library('form_validation');
        $_POST["{$this->primary_key}"] = $primary_key;
        $this->form_validation->set_rules($this->primary_key, ucwords(preg_replace("/_/", " ", $this->primary_key)), 'required|callback_primary_id_check');
        if ($this->form_validation->run() == FALSE) {
            $this->view->set(array('err_title' => '<span class="text-danger">Invalid Data</span>', 'err_msg' => validation_errors('<p class="text-danger">', '</p>')));
            $this->view->content("error");
        } else {
            //START FIX menu Tree
            $row = $this->{$this->model_name}->get_row_by_primary_key($primary_key)->row();
            $this->db->update($this->_table, array('menu_parent_id' => $row->menu_parent_id), array('menu_parent_id' => $primary_key));
            //END FIX menu Tree

            $this->db->delete($this->_table, array(
                $this->primary_key => $this->input->post("{$this->primary_key}")
            ));
            $this->session->set_flashdata("msg", '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button> <span class="glyphicon glyphicon-remove-sign"></span>&nbsp;Successfully Delete Your Data</div>');
            redirect("{$this->class_url}");
        }
    }

    protected function set_crud_asset() {
        parent::set_crud_asset();

        //set asset css & js
        $this->page_js[] = "{$this->_general_assets}plugins/jquery-tags-input/jquery.tagsinput.min.js";
        $this->page_css[] = "{$this->_general_assets}plugins/jquery-tags-input/jquery.tagsinput.css";
        $this->view->set("page_css", $this->page_css);
        $this->view->set("page_js", $this->page_js);
    }

    protected function set_form_validation($field, $action) {
        if (preg_match("/^menu_segment$/i", $field["db"]) && preg_match("/^NO$/i", $this->input->post('menu_link'))) {
            return "xss_clean";
        } else if (preg_match("/^menu_action$/i", $field["db"])) {
            return "xss_clean";
        } else {
            return parent::set_form_validation($field, $action);
        }
    }

    protected function set_input_form($row, $field) {
        if (!$row) { //for add action
            $row = new stdClass();
            $row->menu_action = 'view,edit,add,remove';
            $row->menu_id = '';
        }

        if (preg_match("/^menu_parent_id$/", $field["db"])) {
            return '<select class="form-control" name="menu_parent_id" id="menu_parent_id">' . '<option value="0">New Parent</option>' . $this->{$this->model_name}->generate_menu_option_dropdown(0, $row ? $row->menu_id : '') . '<select>';
        } else if (preg_match("/^menu_action$/", $field["db"])) {
            return sprintf('<input id="menu_action" name="menu_action" type="text" class="form-control tags" value="%s"/>', $row->menu_action);
        } else {
            return parent::set_input_form($row, $field);
        }
    }

    protected function datatable_customize_columns() {
        $this->columns[0]["visible"] = FALSE;
        $this->columns[1]["visible"] = FALSE;
        return $this->columns;
    }

    protected function datatable_field_record_formatter($field, $val, $column_index) {
        if ($field == 'menu_segment') {
            return sprintf('<a href="%s">%s</a>', "{$this->template_url}{$val}", $val);
        } else {
            return parent::datatable_field_record_formatter($field, $val, $column_index);
        }
    }

    /**
     * @since 10 Oct 2014 
     * @todo this function call by ajax, to provide new menu data after INSERT operation
     */
    public function reload_menu_parent_id() {
        echo json_encode(array(
            'status' => 'success',
            'data' => '<select class="form-control" name="menu_parent_id" id="menu_parent_id">' . '<option value="0">New Parent</option>' . $this->{$this->model_name}->generate_menu_option_dropdown() . '<select>'
        ));
    }

}

/* End of file menu.php */
/* Location: ./application/controllers/baseadmin/menu.php */